<?php

namespace App\Repository;

use App\Entity\Donation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Donation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Donation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Donation[]    findAll()
 * @method Donation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DonationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Donation::class);
    }

    public function getCollection(int $lastID, int $size)
    {
        $query = $this->createQueryBuilder('donation')
            ->where('donation.id > :indexMin')
            ->setParameter('indexMin', $lastID)
            ->orderBy('donation.id', 'ASC');

        $query->setMaxResults($size + 1);

        return $query->getQuery()->execute();
    }
}
