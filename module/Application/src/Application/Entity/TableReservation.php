<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TableReservation
 *
 * @ORM\Table(name="table_reservation",
 * indexes={@ORM\Index(name="fk_table_reservation_Table1_idx",
 * columns={"table_id"}),
 * @ORM\Index(name="fk_table_reservation_restaurant1_idx",
 * columns={"restaurant_id"})})
 * @ORM\Entity
 */
class TableReservation
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
     * @var boolean
     *
     * @ORM\Column(name="taken", type="boolean", nullable=false)
     */
    private $taken;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var \Application\Entity\Table
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Table")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="table_id", referencedColumnName="id")
     * })
     */
    private $table;

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
     * Set taken
     *
     * @param boolean $taken
     *
     * @return TableReservation
     */
    public function setTaken($taken)
    {
        $this->taken = $taken;

        return $this;
    }

    /**
     * Get taken
     *
     * @return boolean
     */
    public function getTaken()
    {
        return $this->taken;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return TableReservation
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
     * Set table
     *
     * @param \Application\Entity\Table $table
     *
     * @return TableReservation
     */
    public function setTable(\Application\Entity\Table $table = null)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Get table
     *
     * @return \Application\Entity\Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Set restaurant
     *
     * @param \Application\Entity\Restaurant $restaurant
     *
     * @return TableReservation
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
