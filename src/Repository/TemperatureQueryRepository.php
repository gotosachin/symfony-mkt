<?php

namespace App\Repository;

use App\Entity\TemperatureQuery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TemperatureQuery>
 *
 * @method TemperatureQuery|null find($id, $lockMode = null, $lockVersion = null)
 * @method TemperatureQuery|null findOneBy(array $criteria, array $orderBy = null)
 * @method TemperatureQuery[]    findAll()
 * @method TemperatureQuery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TemperatureQueryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TemperatureQuery::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(TemperatureQuery $entity, bool $flush = true): void
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
    public function remove(TemperatureQuery $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return TemperatureQuery[] Returns an array of TemperatureQuery objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TemperatureQuery
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
