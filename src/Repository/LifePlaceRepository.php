<?php

namespace App\Repository;

use App\Entity\LifePlace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LifePlace>
 *
 * @method LifePlace|null find($id, $lockMode = null, $lockVersion = null)
 * @method LifePlace|null findOneBy(array $criteria, array $orderBy = null)
 * @method LifePlace[]    findAll()
 * @method LifePlace[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LifePlaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LifePlace::class);
    }

    public function save(LifePlace $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LifePlace $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return LifePlace[] Returns an array of LifePlace objects
     */
    public function findByExampleField($value): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.id = :val')
            ->andWhere('l.pieces = :val')
            ->andWhere('l.bathroom = :val')
            ->andWhere('l.livingRoom = :val')
            ->andWhere('l.wc = :val')
            ->andWhere('l.rooms = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    //    public function findOneBySomeField($value): ?LifePlace
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
