<?php

namespace App\Repository;

use App\Entity\Trade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trade>
 *
 * @method Trade|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trade|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trade[]    findAll()
 * @method Trade[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TradeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trade::class);
    }

    public function add(Trade $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Trade $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return Trade[] Returns an array of Trade objects
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

    //    public function findOneBySomeField($value): ?Trade
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    //   calcul Total Sell 
    // public function getTotalSell($token)
    // {
    //     $qb = $this->createQueryBuilder('t');
    //     $qb->select('SUM(t.amount)')
    //         ->where('t.action = :action')
    //         ->andWhere('t.token = :token')
    //         ->andWhere('t.exchange = :exchange')
    //         ->setParameter('action', 'sell')
    //         ->setParameter('token', $token);
    //     return $qb->getQuery()->getSingleScalarResult();
    // }

    /**
     * @return SumOfSelltrade Returns an float of SumOfSelltrade 
     */
    public function getSumSell($token): float
    {
        dump($token);
        $sumOfSelltrade = $this->createQueryBuilder('t')
            ->select('SUM(t.order_mount)')
            ->where('t.action = :action')
            ->andWhere('t.token = :token')
            ->setParameter('action', 'sell')
            ->setParameter('token', $token)
            ->getQuery()
            ->getSingleScalarResult();
        dd($sumOfSelltrade);
        return $sumOfSelltrade;
    }
}
