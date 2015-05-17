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

/**
 * Represents a permission of a User towards a Calendar
 *
 * Like all generic objects, this object should be extended by the adapter
 *
 * @author Baptiste Clavié <baptiste@wisembly.com>
 */
class UserPermission
{
    const NOPE  = 0b00; // No rights. At all.
    const READ  = 0b01; // flag allowing to view this calendar
    const WRITE = 0b10; // flag allowing to edit this calendar

    /**
     * @var User 
     */
    private $user;

    /**
     * @var AbstractCalendar
     */
    private $calendar;

    /**
     * Mask of permissions allocated for the User on the Calendar
     *
     * @var int  
     */
    private $mask = 0b0000;

    public function __construct(AbstractCalendar $calendar, User $user, $mask = 0b0000)
    {
        $this->mask     = $mask;
        $this->user     = $user;
        $this->calendar = $calendar;
    }

    /**
     * @brief getter
     * @details Get current mask associated to this user
     *
     * @return int 
     */
    public function getMask()
    {
        return $this->mask;
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
     * @brief getter
     *
     * @return AbstractCalendar
     */
    public function getCalendar()
    {
        return $this->calendar;
    }

    /**
     * Grant a permission on this calendar
     *
     * @param integer $flag Flag to activate
     * @return $this
     */
    public function grant($flag)
    {
        if (is_string($flag) && defined('static::' . strtoupper($flag))) {
            $flag = constant('static::' . strtoupper($flag));
        }

        $this->mask |= $flag;

        return $this;
    }

    /**
     * Revoke a permission on this calendar
     *
     * @param integer $flag Flag to deactivate
     * @return $this
     */
    public function revoke($flag)
    {
        if (is_string($flag) && defined('static::' . strtoupper($flag))) {
            $flag = constant('static::' . strtoupper($flag));
        }

        $this->mask &= ~$flag;

        return $this;
    }

    /**
     * Checks if the user has the `$flag` right
     *
     * @param integer $flag Flag to test
     * @return boolean
     */
    public function isGranted($flag)
    {
        if (is_string($flag) && defined('static::' . strtoupper($flag))) {
            $flag = constant('static::' . strtoupper($flag));
        }

        return $this->mask & $flag;
    }
}

