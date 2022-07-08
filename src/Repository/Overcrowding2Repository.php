<?php

namespace App\Repository;

use App\Entity\Overcrowding2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Overcrowding2|null find($id, $lockMode = null, $lockVersion = null)
 * @method Overcrowding2|null findOneBy(array $criteria, array $orderBy = null)
 * @method Overcrowding2[]    findAll()
 * @method Overcrowding2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Overcrowding2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Overcrowding2::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Overcrowding2 $entity, bool $flush = true): void
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
    public function remove(Overcrowding2 $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Overcrowding2[] Returns an array of Overcrowding2 objects
     */
    public function findByType($value, $norm)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.type = :val', 'o.norm = :val2')
            //->setParameter('val', $value, 'val2', $norm)
            ->setParameters(['val' => $value, 'val2' => $norm])
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult()
        ;
    }




    /*
    public function findOneBySomeField($value): ?Overcrowding2
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
