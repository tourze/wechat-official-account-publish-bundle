<?php

namespace WechatOfficialAccountPublishBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use WechatOfficialAccountPublishBundle\Entity\Publish;

/**
 * @method Publish|null find($id, $lockMode = null, $lockVersion = null)
 * @method Publish|null findOneBy(array<string, mixed> $criteria, array<string, string>|null $orderBy = null)
 * @method Publish[]    findAll()
 * @method Publish[]    findBy(array<string, mixed> $criteria, array<string, string>|null $orderBy = null, $limit = null, $offset = null)
 * @extends ServiceEntityRepository<Publish>
 */
class PublishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Publish::class);
    }
}
