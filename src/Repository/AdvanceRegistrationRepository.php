<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AdvanceRegistration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AdvanceRegistration>
 *
 * @method AdvanceRegistration|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdvanceRegistration|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdvanceRegistration[]    findAll()
 * @method AdvanceRegistration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdvanceRegistrationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdvanceRegistration::class);
    }

    public function save(AdvanceRegistration $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AdvanceRegistration $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AdvanceRegistration[] Returns an array of AdvanceRegistration objects
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

//    public function findOneBySomeField($value): ?AdvanceRegistration
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
