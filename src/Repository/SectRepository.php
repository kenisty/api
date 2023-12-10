<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Sect;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sect>
 *
 * @method Sect|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sect|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sect[]    findAll()
 * @method Sect[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sect::class);
    }

//    /**
//     * @return Sect[] Returns an array of Sect objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sect
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
