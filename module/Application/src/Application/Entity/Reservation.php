<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="fk_reservation_restaurant_idx", columns={"restaurant_id"})})
 * @ORM\Entity
 */
class Reservation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="no_people", type="integer", nullable=false)
     */
    private $noPeople;

    /**
     * @var \Application\Entity\Restaurant
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Restaurant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="restaurant_id", referencedColumnName="id")
     * })
     */
    private $restaurant;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Reservation
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getNoPeople()
    {
        return $this->noPeople;
    }

    /**
     * @param int $no_people
     */
    public function setNoPeople($no_people)
    {
        $this->noPeople = $no_people;
        return $this;
    }

    /**
     * Set restaurant
     *
     * @param \Application\Entity\Restaurant $restaurant
     *
     * @return Reservation
     */
    public function setRestaurant(\Application\Entity\Restaurant $restaurant = null)
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    /**
     * Get restaurant
     *
     * @return \Application\Entity\Restaurant
     */
    public function getRestaurant()
    {
        return $this->restaurant;
    }
}
