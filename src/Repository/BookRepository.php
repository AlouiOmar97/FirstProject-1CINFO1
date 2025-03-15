<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    //    /**
    //     * @return Book[] Returns an array of Book objects
    //     */
        public function findBooksByAuthor()
        {
            return $this->createQueryBuilder('b')
                ->join('b.author','a')
                ->addSelect('a')
                ->where('a.username = :val')
                ->setParameter('val','abc')
                ->getQuery()
                ->getResult()
            ;
        }

        public function CountBooksByAuthor($username)
        {
            return $this->createQueryBuilder('b')
                ->select('COUNT(b.id)')
                ->join('b.author','a')
                //->addSelect('a')
                ->where('a.username = :val')
                ->setParameter('val',$username)
                ->getQuery()
                ->getSingleScalarResult()
            ;
        }

        public function countBooksByEachAuthor()
        {
            return $this->createQueryBuilder('b')
                ->select('a.username, COUNT(b.id)')
                ->join('b.author','a')
                ->groupBy('a.username')
                ->getQuery()
                ->getDQL()
            ;
        }

        public function countBooksByEachAuthorDQL(){
            $em= $this->getEntityManager();
            $query= $em->createQuery("SELECT a.username, COUNT(b.id) FROM App\Entity\Book b INNER JOIN b.author a GROUP BY a.username");
            $result= $query->getResult();
            return $result;
        }

        public function findBooksByAuthorDQL($username)
        {
            return $this->getEntityManager()
                        ->createQuery("SELECT a, b FROM App\Entity\Book b INNER JOIN b.author a WHERE a.username LIKE :username")
                        ->setParameter('username', '%'.$username.'%')
                        ->getResult()
            ;
        }


    //    public function findOneBySomeField($value): ?Book
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
