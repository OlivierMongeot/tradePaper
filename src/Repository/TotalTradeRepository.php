<?php

namespace App\Repository;

use App\Entity\TotalTrade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TotalTrade>
 *
 * @method TotalTrade|null find($id, $lockMode = null, $lockVersion = null)
 * @method TotalTrade|null findOneBy(array $criteria, array $orderBy = null)
 * @method TotalTrade[]    findAll()
 * @method TotalTrade[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TotalTradeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TotalTrade::class);
    }

    public function add(TotalTrade $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TotalTrade $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TotalTrade[] Returns an array of TotalTrade objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TotalTrade
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

//    /**
//     * @return SumOfSelltrade Returns an float of SumOfSelltrade 
//     */
//     public function getSumSell($token): float
//     {
//         $sumOfSelltrade = $this->createQueryBuilder('t')
//             ->select('SUM(t.orderMount)')
//             ->where('t.action = :action')
//             ->andWhere('t.token = :token')
//             ->setParameter('action', 'sell')
//             ->setParameter('token', $token)
//             ->getQuery()
//             ->getSingleScalarResult();
//         return $sumOfSelltrade;
//     }
}
