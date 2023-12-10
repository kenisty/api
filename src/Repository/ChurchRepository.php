<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Church;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Church>
 *
 * @method Church|null find($id, $lockMode = null, $lockVersion = null)
 * @method Church|null findOneBy(array $criteria, array $orderBy = null)
 * @method Church[]    findAll()
 * @method Church[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChurchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Church::class);
    }

//    /**
//     * @return Church[] Returns an array of Church objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Church
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
