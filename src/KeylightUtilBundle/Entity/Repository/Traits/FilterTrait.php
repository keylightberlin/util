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
        return $this->addComparisonFilter($queryBuilder, $name, "%" . $value . "%", "LIKE");
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
        return $this->addComparisonFilter($queryBuilder, $name, "%" . $value, "LIKE");
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
        return $this->addComparisonFilter($queryBuilder, $name, $value . "%", "LIKE");
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
        return $this->addComparisonFilter($queryBuilder, $name, $value, "=");
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $name
     * @param mixed $value
     *
     * @return QueryBuilder
     */
    protected function addLessFilter(QueryBuilder $queryBuilder, $name, $value)
    {
        return $this->addComparisonFilter($queryBuilder, $name, $value, "<");
    }


    /**
     * @param QueryBuilder $queryBuilder
     * @param string $name
     * @param mixed $value
     *
     * @return QueryBuilder
     */
    protected function addLessOrEqualFilter(QueryBuilder $queryBuilder, $name, $value)
    {
        return $this->addComparisonFilter($queryBuilder, $name, $value, "<=");
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $name
     * @param mixed $value
     *
     * @return QueryBuilder
     */
    protected function addMoreFilter(QueryBuilder $queryBuilder, $name, $value)
    {
        return $this->addComparisonFilter($queryBuilder, $name, $value, ">");
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $name
     * @param mixed $value
     *
     * @return QueryBuilder
     */
    protected function addMoreOrEqualFilter(QueryBuilder $queryBuilder, $name, $value)
    {
        return $this->addComparisonFilter($queryBuilder, $name, $value, ">=");
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $name
     * @param mixed $value
     * @param string $comparison
     *
     * @return QueryBuilder
     */
    protected function addComparisonFilter(QueryBuilder $queryBuilder, $name, $value, $comparison)
    {
        if ($value !== null) {
            $randomPlaceholder = static::$PLACEHOLDER_PREFIX . uniqid();

            $queryBuilder
                ->andWhere(
                    $name . " " . $comparison . " :" . $randomPlaceholder
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
        return $this->addCollectionFilter($queryBuilder, $name, $value, "IN");
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $name
     * @param mixed $value
     *
     * @return QueryBuilder
     */
    protected function addNotContainmentFilter(QueryBuilder $queryBuilder, $name, $value)
    {
        return $this->addCollectionFilter($queryBuilder, $name, $value, "NOT IN");
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $name
     * @param mixed $value
     * @param string $comparison
     *
     * @return QueryBuilder
     */
    protected function addCollectionFilter(QueryBuilder $queryBuilder, $name, $value, $comparison)
    {
        if ($value != null) {
            $randomPlaceholder = static::$PLACEHOLDER_PREFIX . uniqid();

            $queryBuilder
                ->andWhere(
                    $name . " " . $comparison . " (:" . $randomPlaceholder . ")"
                )
                ->setParameter($randomPlaceholder, $value )
            ;
        }

        return $queryBuilder;
    }
}
