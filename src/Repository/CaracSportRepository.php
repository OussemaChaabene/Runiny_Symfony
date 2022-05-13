<?php

namespace App\Repository;

use App\Entity\CaracSport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CaracSport|null find($id, $lockMode = null, $lockVersion = null)
 * @method CaracSport|null findOneBy(array $criteria, array $orderBy = null)
 * @method CaracSport[]    findAll()
 * @method CaracSport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaracSportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CaracSport::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(CaracSport $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(CaracSport $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    public function findById($id){
        $query=$this->getEntityManager()
            ->createQuery('SELECT c FROM App\Entity\CaracSport c WHERE
             c.id = :idc')
            ->setParameter('idc','%'.$id.'%');
        return $query->getResult();
    }

    /**
     * Returns numbrer of "CaracSport"
     * @return void
     */
    public function nombreUsers(){
        return $this->createQueryBuilder('c')
            ->Select('COUNT(c.taille) AS nb')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return CaracSport[] Returns an array of CaracSport objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CaracSport
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
