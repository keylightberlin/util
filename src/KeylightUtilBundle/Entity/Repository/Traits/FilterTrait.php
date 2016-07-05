<?php
namespace KeylightUtilBundle\Entity\Repository\Traits;

use Doctrine\ORM\QueryBuilder;

trait FilterTrait
{
    static $PLACEHOLDER_PREFIX = "param_";

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $name
     * @param string $value
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
     * @param string $name1
     * @param string $name2
     * @param string $value
     *
     * @return QueryBuilder
     */
    protected function addLikeOrFilter(QueryBuilder $queryBuilder, $name1, $name2, $value)
    {
        if ($value != null) {
            $randomPlaceholder = static::$PLACEHOLDER_PREFIX . uniqid();

            $queryBuilder
                ->andWhere(
                    $name1 . " LIKE :" . $randomPlaceholder
                    . " OR " . $name2 . " LIKE :" . $randomPlaceholder
                )
                ->setParameter($randomPlaceholder, "%" . $value . "%");
        }

        return $queryBuilder;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $name
     * @param string $value
     *
     * @return QueryBuilder
     */
    protected function addSuffixLikeFilter(QueryBuilder $queryBuilder, $name, $value)
    {
        if ($value != null) {
            $randomPlaceholder = static::$PLACEHOLDER_PREFIX . uniqid();

            $queryBuilder
                ->andWhere(
                    $name . " LIKE :" . $randomPlaceholder
                )
                ->setParameter($randomPlaceholder, "%" . $value);
        }

        return $queryBuilder;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $name
     * @param string $value
     *
     * @return QueryBuilder
     */
    protected function addPrefixLikeFilter(QueryBuilder $queryBuilder, $name, $value)
    {
        if ($value != null) {
            $randomPlaceholder = static::$PLACEHOLDER_PREFIX . uniqid();

            $queryBuilder
                ->andWhere(
                    $name . " LIKE :" . $randomPlaceholder
                )
                ->setParameter($randomPlaceholder, $value . "%");
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
