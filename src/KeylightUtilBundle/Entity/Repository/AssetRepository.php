<?php
namespace KeylightUtilBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class AssetRepository extends EntityRepository
{
    /**
     * @param int $fromId
     * @param int $toId
     * @return array
     */
    public function findBaseAssetsForIdsFromTo($fromId, $toId)
    {
        return $this->createQueryBuilder("asset")
            ->where("asset.id > :from")
            ->andWhere("asset.id <= :to")
            ->andWhere("asset.parentAsset IS NULL")
            ->setParameters(
                [
                    'from' => $fromId,
                    'to' => $toId,
                ]
            )
            ->getQuery()
            ->getResult();
    }
}
