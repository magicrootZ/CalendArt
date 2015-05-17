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

use Doctrine\Common\Collections\Collection,
    Doctrine\Common\Collections\ArrayCollection;

/**
 * Represents a User
 *
 * This class should be extended by the different adapters to specify their
 * needs ; it should hydrate its descendants
 *
 * @author Baptiste Clavié <baptiste@wisembly.com>
 */
class User
{
    /** 
     * User's name
     *
     * @var string
     */
    protected $name;

    /**
     * User's email 
     * 
     * @var string
     */
    protected $email;

    /**
     * Collection of events the user is involved in
     *
     * @var Collection<AbstractEvent> 
     */
    protected $events;

    /**
     * @brief constructor
     *
     * @param string $name
     * @param string $email
     */
    public function __construct($name, $email)
    {
        $this->name  = $name;
        $this->email = $email;

        $this->events = new ArrayCollection();
    }

    /**
     * @brief getter
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @brief getter
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @brief getter
     *
     * @return Collection<AbstractEvent>
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @brief setter
     *
     * @param AbstractEvent $event
     * @return $this
     */
    public function addEvent(AbstractEvent $event)
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
        }
        return $this;
    }

    /**
     * @brief remover
     * 
     * @param AbstractEvent $event
     * @return $this
     */
    public function removeEvent(AbstractEvent $event)
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
        }
        return $this;
    }
}

