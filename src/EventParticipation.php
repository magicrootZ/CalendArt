<?php
/**
 * This file is part of the CalendArt package
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 *
 * @copyright Wisembly
 * @license   http://www.opensource.org/licenses/MIT-License MIT License
 */

namespace CalendArt;

use Datetime,
    InvalidArgumentException;

/**
 * Represents a participation of a user to an event
 *
 * Like all generic class, this class should be extended to the adapter's need
 *
 * @author Baptiste Clavié <baptiste@wisembly.com>
 */
class EventParticipation
{
    // status of the participation
    const STATUS_DECLINED  = -1;
    const STATUS_TENTATIVE = 0;
    const STATUS_ACCEPTED  = 1;

    // available roles
    const ROLE_PARTICIPANT = 0b01;
    const ROLE_MANAGER     = 0b10;

    /**
     * @var AbstractEvent
     */
    protected $event;

    /** 
     * @var User
     */
    protected $user;

    /**
     * @var int
     */
    protected $role = self::ROLE_PARTICIPANT;

    /**
     * @var Datetime
     */
    protected $invitedAt;

    /**
     * @var Datetime
     */
    protected $answeredAt = null;

    /**
     * @var int
     */
    protected $status = self::STATUS_TENTATIVE;

    /**
     * @brief constructor
     *
     * @param AbstractEvent $event
     * @param User $user
     * @param $role int
     * @param $status int
     */
    public function __construct(AbstractEvent $event, User $user, $role = self::ROLE_PARTICIPANT, $status = self::STATUS_TENTATIVE)
    {
        $this->user  = $user;
        $this->event = $event;

        $this->invitedAt = new Datetime;

        $this->setRole($role);
        $this->setStatus($status);

        $user->addEvent($event);
    }

    /**
     * @brief getter
     * @details return null if the user has not answered yet to the invitation
     *
     * @return Datetime|null 
     */
    public function getAnsweredAt()
    {
        return $this->answeredAt;
    }

    /**
     * @details returns true if the user has answered this invitation
     *
     * @return boolean
     */
    public function hasAnswered()
    {
        return null !== $this->answeredAt;
    }

    /** 
     * @return $this
     */
    public function setAnsweredAt(Datetime $date = null)
    {
        $this->answeredAt = $date ?: new Datetime();

        return $this;
    }

    /**
     * @brief getter
     *
     * @return Datetime
     */
    public function getInvitedAt()
    {
        return $this->invitedAt;
    }

    /**
     * @brief getter
     *
     * @return AbstractEvent
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @brief getter
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @brief Get the current role of the user in this event
     * @details return mask that puts the rights of the user
     *
     * @return int 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @brief setter
     *
     * @param int $role
     * @return $this
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @brief getter
     * @details Get the current status of this participation
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @brief setter
     *
     * @param int $status
     * @return $this
     */
    public function setStatus($status)
    {
        if (!in_array($status, static::getAvailableStatuses())) {
            throw new InvalidArgumentException(
                sprintf(
                    'Status not recognized ; Had "%s", expected one of "%s"',
                    $status,
                    implode('", "', static::getAvailableStatuses())
                )
            );
        }

        $this->status = $status;

        return $this;
    }

    /**
     * @brief Fetch the available statuses
     *
     * @return int[]
     */
    public static function getAvailableStatuses()
    {
        return [
            self::STATUS_DECLINED,
            self::STATUS_TENTATIVE,
            self::STATUS_ACCEPTED
        ];
    }
}

