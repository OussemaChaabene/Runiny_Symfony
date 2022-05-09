<?php

namespace App\Repository;

use App\Entity\Payement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Payement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Payement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Payement[]    findAll()
 * @method Payement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PayementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Payement::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Payement $entity, bool $flush = true): void
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
    public function remove(Payement $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    // /**
    //  * @return Payement[] Returns an array of Payement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    /**
     * Returns sum of "Payement" per mounth
     * @return void
     */
    public function sommeByDate(){
        return $this->createQueryBuilder('c')
            ->addSelect('SUM(c.montant) AS sum')
            ->addSelect('SUBSTRING(c.datePay,7,10) AS date')
            ->groupBy('date')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * Returns sum of "Payement" per year per id
     * @return void
     */
    public function sommeByDateId($id){
        return $this->createQueryBuilder('c')
            ->setParameter('idc',$id)
            ->addSelect('SUM(c.montant) AS sum')
            ->addSelect('SUBSTRING(c.datePay,7,10) AS date')
            ->where('c.idUser=:idc')
            ->groupBy('date')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * Returns sum of "Payement"
     * @return void
     */
    public function somme(){
        return $this->createQueryBuilder('c')
            ->Select('SUM(c.montant) AS sums')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * Returns number of "Payement"
     * @return void
     */
    public function nbp(){
        return $this->createQueryBuilder('c')
            ->Select('COUNT(c.montant) AS nbp')
            ->getQuery()
            ->getResult()
            ;
    }

}
