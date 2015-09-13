<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Application\Entity\Reservation;
use Zend\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;

class ReservationController extends AbstractRestfulController
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * Get Doctrine Entity Manager
     * @return array|EntityManager|object
     */
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }
    /**
     * Get all Reservations
     * @return JsonModel
     */
    public function getList()
    {
        $reservations = $this->getEntityManager()->getRepository('Application\Entity\Reservation')->findAll();
        $result = array();
        foreach($reservations as $res) {
            $result['reservations'] [] = array(
                'date' => $res->getDate(),
                'restaurant' => $res->getRestaurant()->getName()
            );
        }

        return new JsonModel($result);
    }

    /**
     * Retrieve a Reservation
     * @param mixed $id
     * @return JsonModel
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function get($id)
    {
        $reservation = $this->getEntityManager()->find('Application\Entity\Reservation', $id);

        if ($reservation) {
            return new JsonModel(array(
                'reservation' => [
                    'date' => $reservation->getDate(),
                    'restaurant' => $reservation->getRestaurant()->getName()
                ]
            ));
        } else {
           return new JsonModel(parent::get($id));
        }
    }

    /**
     * Create a new Reservation
     * @param mixed $data
     * @return JsonModel
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function create($data)
    {
        if (!$this->request->isPost()) {
            return new JsonModel(parent::create($data));
        }

        $reservation = new Reservation();
        //More validation before saving the reservation here
        //ex: Check if has available tables for the date specified and the
        //    number of person for the reservation
        $reservation = $this->saveReservation($reservation, $data);

        return new JsonModel(array(
            'data' => $reservation->getId()
        ));
    }

    /**
     * To save the Reservation
     * @param Reservation $reservation
     * @param array $data
     * @return Reservation
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function saveReservation(Reservation $reservation, array $data)
    {
        $restaurantId = (int) $data['restaurantId'];
        $reservationDate = $data['reservationDate'];
        $numberOfPeople = (int) $data['numberOfPeople'];

        $restaurant = $this->getEntityManager()->find('Application\Entity\Restaurant', $restaurantId);

        $reservation->setDate($reservationDate);
        $reservation->setNoPeople($numberOfPeople);
        $reservation->setRestaurant($restaurant);

        $this->getEntityManager()->persist($reservation);
        $this->getEntityManager()->flush();

        return $reservation;
    }

    /**
     * Update an existing Reservation
     * @param mixed $id
     * @param mixed $data
     * @return JsonModel
     */
    public function update($id, $data)
    {
        $reservation = $this->getEntityManager()->find('Application\Entity\Reservation', $id);

        $reservationUpdated = $this->saveReservation($reservation, $data);

        return new JsonModel(array(
            'data' => $reservationUpdated->getId(),
        ));
    }

    /**
     * Delete a Reservation
     * @param mixed $id
     * @return JsonModel
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function delete($id)
    {
        $reservation = $this->getEntityManager()->find('Application\Entity\Reservation', $id);
        if ($reservation) {
            $this->getEntityManager()->remove($reservation);
            $this->getEntityManager()->flush();
            return new JsonModel(array(
                'data' => $id,
            ));
        } else {
            return new JsonModel([]);
        }
    }
}
