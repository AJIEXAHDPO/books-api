<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    //    /**
    //     * @return Author[] Returns an array of Author objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Author
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }


    /**
     * @return Author[] Returns an array of Author objects
     */
    public function findAllExtra(): array
    {
        // автоматически знает, что надо выбирать Продукты
        // "p" - это псевдоним, который вы будете использовать до конца запроса
        $qb = $this->createQueryBuilder('a');
        $ids = $qb
            ->select('a.id')
            ->join('a.books', 'ab')
            ->distinct()
            ->getDQL();

        return $this->createQueryBuilder("a1")
            ->where($qb->expr()->notIn('a1.id', $ids))
            ->getQuery()
            ->execute();
    }
}
