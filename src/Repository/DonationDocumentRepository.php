<?php

namespace App\Repository;

use App\Entity\DonationDocument;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DonationDocument|null find($id, $lockMode = null, $lockVersion = null)
 * @method DonationDocument|null findOneBy(array $criteria, array $orderBy = null)
 * @method DonationDocument[]    findAll()
 * @method DonationDocument[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DonationDocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DonationDocument::class);
    }
}
