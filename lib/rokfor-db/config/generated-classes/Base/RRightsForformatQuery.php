<?php

namespace Base;

use \RRightsForformat as ChildRRightsForformat;
use \RRightsForformatQuery as ChildRRightsForformatQuery;
use \Exception;
use \PDO;
use Map\RRightsForformatTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'R_rights_forformat' table.
 *
 *
 *
 * @method     ChildRRightsForformatQuery orderByRightid($order = Criteria::ASC) Order by the _rightid column
 * @method     ChildRRightsForformatQuery orderByFormatid($order = Criteria::ASC) Order by the _formatid column
 *
 * @method     ChildRRightsForformatQuery groupByRightid() Group by the _rightid column
 * @method     ChildRRightsForformatQuery groupByFormatid() Group by the _formatid column
 *
 * @method     ChildRRightsForformatQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRRightsForformatQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRRightsForformatQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRRightsForformatQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildRRightsForformatQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildRRightsForformatQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildRRightsForformatQuery leftJoinRights($relationAlias = null) Adds a LEFT JOIN clause to the query using the Rights relation
 * @method     ChildRRightsForformatQuery rightJoinRights($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Rights relation
 * @method     ChildRRightsForformatQuery innerJoinRights($relationAlias = null) Adds a INNER JOIN clause to the query using the Rights relation
 *
 * @method     ChildRRightsForformatQuery joinWithRights($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Rights relation
 *
 * @method     ChildRRightsForformatQuery leftJoinWithRights() Adds a LEFT JOIN clause and with to the query using the Rights relation
 * @method     ChildRRightsForformatQuery rightJoinWithRights() Adds a RIGHT JOIN clause and with to the query using the Rights relation
 * @method     ChildRRightsForformatQuery innerJoinWithRights() Adds a INNER JOIN clause and with to the query using the Rights relation
 *
 * @method     ChildRRightsForformatQuery leftJoinFormats($relationAlias = null) Adds a LEFT JOIN clause to the query using the Formats relation
 * @method     ChildRRightsForformatQuery rightJoinFormats($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Formats relation
 * @method     ChildRRightsForformatQuery innerJoinFormats($relationAlias = null) Adds a INNER JOIN clause to the query using the Formats relation
 *
 * @method     ChildRRightsForformatQuery joinWithFormats($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Formats relation
 *
 * @method     ChildRRightsForformatQuery leftJoinWithFormats() Adds a LEFT JOIN clause and with to the query using the Formats relation
 * @method     ChildRRightsForformatQuery rightJoinWithFormats() Adds a RIGHT JOIN clause and with to the query using the Formats relation
 * @method     ChildRRightsForformatQuery innerJoinWithFormats() Adds a INNER JOIN clause and with to the query using the Formats relation
 *
 * @method     \RightsQuery|\FormatsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRRightsForformat findOne(ConnectionInterface $con = null) Return the first ChildRRightsForformat matching the query
 * @method     ChildRRightsForformat findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRRightsForformat matching the query, or a new ChildRRightsForformat object populated from the query conditions when no match is found
 *
 * @method     ChildRRightsForformat findOneByRightid(int $_rightid) Return the first ChildRRightsForformat filtered by the _rightid column
 * @method     ChildRRightsForformat findOneByFormatid(int $_formatid) Return the first ChildRRightsForformat filtered by the _formatid column *

 * @method     ChildRRightsForformat requirePk($key, ConnectionInterface $con = null) Return the ChildRRightsForformat by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRRightsForformat requireOne(ConnectionInterface $con = null) Return the first ChildRRightsForformat matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRRightsForformat requireOneByRightid(int $_rightid) Return the first ChildRRightsForformat filtered by the _rightid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRRightsForformat requireOneByFormatid(int $_formatid) Return the first ChildRRightsForformat filtered by the _formatid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRRightsForformat[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRRightsForformat objects based on current ModelCriteria
 * @method     ChildRRightsForformat[]|ObjectCollection findByRightid(int $_rightid) Return ChildRRightsForformat objects filtered by the _rightid column
 * @method     ChildRRightsForformat[]|ObjectCollection findByFormatid(int $_formatid) Return ChildRRightsForformat objects filtered by the _formatid column
 * @method     ChildRRightsForformat[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RRightsForformatQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\RRightsForformatQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\RRightsForformat', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRRightsForformatQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRRightsForformatQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRRightsForformatQuery) {
            return $criteria;
        }
        $query = new ChildRRightsForformatQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$_rightid, $_formatid] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildRRightsForformat|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RRightsForformatTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = RRightsForformatTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRRightsForformat A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT _rightid, _formatid FROM R_rights_forformat WHERE _rightid = :p0 AND _formatid = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildRRightsForformat $obj */
            $obj = new ChildRRightsForformat();
            $obj->hydrate($row);
            RRightsForformatTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildRRightsForformat|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildRRightsForformatQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(RRightsForformatTableMap::COL__RIGHTID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(RRightsForformatTableMap::COL__FORMATID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRRightsForformatQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(RRightsForformatTableMap::COL__RIGHTID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(RRightsForformatTableMap::COL__FORMATID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the _rightid column
     *
     * Example usage:
     * <code>
     * $query->filterByRightid(1234); // WHERE _rightid = 1234
     * $query->filterByRightid(array(12, 34)); // WHERE _rightid IN (12, 34)
     * $query->filterByRightid(array('min' => 12)); // WHERE _rightid > 12
     * </code>
     *
     * @see       filterByRights()
     *
     * @param     mixed $rightid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRRightsForformatQuery The current query, for fluid interface
     */
    public function filterByRightid($rightid = null, $comparison = null)
    {
        if (is_array($rightid)) {
            $useMinMax = false;
            if (isset($rightid['min'])) {
                $this->addUsingAlias(RRightsForformatTableMap::COL__RIGHTID, $rightid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rightid['max'])) {
                $this->addUsingAlias(RRightsForformatTableMap::COL__RIGHTID, $rightid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RRightsForformatTableMap::COL__RIGHTID, $rightid, $comparison);
    }

    /**
     * Filter the query on the _formatid column
     *
     * Example usage:
     * <code>
     * $query->filterByFormatid(1234); // WHERE _formatid = 1234
     * $query->filterByFormatid(array(12, 34)); // WHERE _formatid IN (12, 34)
     * $query->filterByFormatid(array('min' => 12)); // WHERE _formatid > 12
     * </code>
     *
     * @see       filterByFormats()
     *
     * @param     mixed $formatid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRRightsForformatQuery The current query, for fluid interface
     */
    public function filterByFormatid($formatid = null, $comparison = null)
    {
        if (is_array($formatid)) {
            $useMinMax = false;
            if (isset($formatid['min'])) {
                $this->addUsingAlias(RRightsForformatTableMap::COL__FORMATID, $formatid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($formatid['max'])) {
                $this->addUsingAlias(RRightsForformatTableMap::COL__FORMATID, $formatid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RRightsForformatTableMap::COL__FORMATID, $formatid, $comparison);
    }

    /**
     * Filter the query by a related \Rights object
     *
     * @param \Rights|ObjectCollection $rights The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRRightsForformatQuery The current query, for fluid interface
     */
    public function filterByRights($rights, $comparison = null)
    {
        if ($rights instanceof \Rights) {
            return $this
                ->addUsingAlias(RRightsForformatTableMap::COL__RIGHTID, $rights->getId(), $comparison);
        } elseif ($rights instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RRightsForformatTableMap::COL__RIGHTID, $rights->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRights() only accepts arguments of type \Rights or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Rights relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRRightsForformatQuery The current query, for fluid interface
     */
    public function joinRights($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Rights');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Rights');
        }

        return $this;
    }

    /**
     * Use the Rights relation Rights object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RightsQuery A secondary query class using the current class as primary query
     */
    public function useRightsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRights($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Rights', '\RightsQuery');
    }

    /**
     * Filter the query by a related \Formats object
     *
     * @param \Formats|ObjectCollection $formats The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRRightsForformatQuery The current query, for fluid interface
     */
    public function filterByFormats($formats, $comparison = null)
    {
        if ($formats instanceof \Formats) {
            return $this
                ->addUsingAlias(RRightsForformatTableMap::COL__FORMATID, $formats->getId(), $comparison);
        } elseif ($formats instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RRightsForformatTableMap::COL__FORMATID, $formats->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByFormats() only accepts arguments of type \Formats or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Formats relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRRightsForformatQuery The current query, for fluid interface
     */
    public function joinFormats($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Formats');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Formats');
        }

        return $this;
    }

    /**
     * Use the Formats relation Formats object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \FormatsQuery A secondary query class using the current class as primary query
     */
    public function useFormatsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFormats($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Formats', '\FormatsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRRightsForformat $rRightsForformat Object to remove from the list of results
     *
     * @return $this|ChildRRightsForformatQuery The current query, for fluid interface
     */
    public function prune($rRightsForformat = null)
    {
        if ($rRightsForformat) {
            $this->addCond('pruneCond0', $this->getAliasedColName(RRightsForformatTableMap::COL__RIGHTID), $rRightsForformat->getRightid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(RRightsForformatTableMap::COL__FORMATID), $rRightsForformat->getFormatid(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the R_rights_forformat table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RRightsForformatTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RRightsForformatTableMap::clearInstancePool();
            RRightsForformatTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RRightsForformatTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RRightsForformatTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RRightsForformatTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RRightsForformatTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RRightsForformatQuery
