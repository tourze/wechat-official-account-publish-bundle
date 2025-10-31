<?php

namespace WechatOfficialAccountPublishBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Tourze\PHPUnitSymfonyKernelTest\Attribute\AsRepository;
use WechatOfficialAccountPublishBundle\Entity\Publish;

/**
 * @extends ServiceEntityRepository<Publish>
 */
#[Autoconfigure(public: true)]
#[AsRepository(entityClass: Publish::class)]
class PublishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Publish::class);
    }

    public function save(Publish $entity, bool $flush = true): void
    {
        if (!$this->getEntityManager()->contains($entity)) {
            $this->getEntityManager()->persist($entity);
        }

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Publish $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
