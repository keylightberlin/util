<?php
namespace KeylightUtilBundle\Entity\Repository\Traits;

use Doctrine\ORM\QueryBuilder;

trait FilterTrait
{
    static $PLACEHOLDER_PREFIX = "param_";

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $name
     * @param mixed $value
     *
     * @return QueryBuilder
     */
    protected function addLikeFilter(QueryBuilder $queryBuilder, $name, $value)
    {
        if ($value != null) {
            $randomPlaceholder = static::$PLACEHOLDER_PREFIX . uniqid();

            $queryBuilder
                ->andWhere(
                    $name . " LIKE :" . $randomPlaceholder
                )
                ->setParameter($randomPlaceholder, "%" . $value . "%");
        }

        return $queryBuilder;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $name
     * @param mixed $value
     *
     * @return QueryBuilder
     */
    protected function addIdentityFilter(QueryBuilder $queryBuilder, $name, $value)
    {
        if ($value !== null) {
            $randomPlaceholder = static::$PLACEHOLDER_PREFIX . uniqid();

            $queryBuilder
                ->andWhere(
                    $name . " = :" . $randomPlaceholder
                )
                ->setParameter($randomPlaceholder, $value)
            ;
        }

        return $queryBuilder;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $name
     * @param mixed $value
     *
     * @return QueryBuilder
     */
    protected function addContainmentFilter(QueryBuilder $queryBuilder, $name, $value)
    {
        if ($value != null) {
            $randomPlaceholder = static::$PLACEHOLDER_PREFIX . uniqid();

            $queryBuilder
                ->andWhere(
                    $name . " IN (:" . $randomPlaceholder . ")"
                )
                ->setParameter($randomPlaceholder, $value )
            ;
        }

        return $queryBuilder;
    }
}
