<?php

namespace Base;

use \RDataData as ChildRDataData;
use \RDataDataQuery as ChildRDataDataQuery;
use \Exception;
use \PDO;
use Map\RDataDataTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'R_data_data' table.
 *
 *
 *
 * @method     ChildRDataDataQuery orderBySource($order = Criteria::ASC) Order by the _src column
 * @method     ChildRDataDataQuery orderByTarget($order = Criteria::ASC) Order by the _ref column
 *
 * @method     ChildRDataDataQuery groupBySource() Group by the _src column
 * @method     ChildRDataDataQuery groupByTarget() Group by the _ref column
 *
 * @method     ChildRDataDataQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRDataDataQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRDataDataQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRDataDataQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildRDataDataQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildRDataDataQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildRDataDataQuery leftJoinRDataSrc($relationAlias = null) Adds a LEFT JOIN clause to the query using the RDataSrc relation
 * @method     ChildRDataDataQuery rightJoinRDataSrc($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RDataSrc relation
 * @method     ChildRDataDataQuery innerJoinRDataSrc($relationAlias = null) Adds a INNER JOIN clause to the query using the RDataSrc relation
 *
 * @method     ChildRDataDataQuery joinWithRDataSrc($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RDataSrc relation
 *
 * @method     ChildRDataDataQuery leftJoinWithRDataSrc() Adds a LEFT JOIN clause and with to the query using the RDataSrc relation
 * @method     ChildRDataDataQuery rightJoinWithRDataSrc() Adds a RIGHT JOIN clause and with to the query using the RDataSrc relation
 * @method     ChildRDataDataQuery innerJoinWithRDataSrc() Adds a INNER JOIN clause and with to the query using the RDataSrc relation
 *
 * @method     ChildRDataDataQuery leftJoinRDataRef($relationAlias = null) Adds a LEFT JOIN clause to the query using the RDataRef relation
 * @method     ChildRDataDataQuery rightJoinRDataRef($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RDataRef relation
 * @method     ChildRDataDataQuery innerJoinRDataRef($relationAlias = null) Adds a INNER JOIN clause to the query using the RDataRef relation
 *
 * @method     ChildRDataDataQuery joinWithRDataRef($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RDataRef relation
 *
 * @method     ChildRDataDataQuery leftJoinWithRDataRef() Adds a LEFT JOIN clause and with to the query using the RDataRef relation
 * @method     ChildRDataDataQuery rightJoinWithRDataRef() Adds a RIGHT JOIN clause and with to the query using the RDataRef relation
 * @method     ChildRDataDataQuery innerJoinWithRDataRef() Adds a INNER JOIN clause and with to the query using the RDataRef relation
 *
 * @method     \DataQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRDataData findOne(ConnectionInterface $con = null) Return the first ChildRDataData matching the query
 * @method     ChildRDataData findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRDataData matching the query, or a new ChildRDataData object populated from the query conditions when no match is found
 *
 * @method     ChildRDataData findOneBySource(int $_src) Return the first ChildRDataData filtered by the _src column
 * @method     ChildRDataData findOneByTarget(int $_ref) Return the first ChildRDataData filtered by the _ref column *

 * @method     ChildRDataData requirePk($key, ConnectionInterface $con = null) Return the ChildRDataData by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRDataData requireOne(ConnectionInterface $con = null) Return the first ChildRDataData matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRDataData requireOneBySource(int $_src) Return the first ChildRDataData filtered by the _src column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRDataData requireOneByTarget(int $_ref) Return the first ChildRDataData filtered by the _ref column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRDataData[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRDataData objects based on current ModelCriteria
 * @method     ChildRDataData[]|ObjectCollection findBySource(int $_src) Return ChildRDataData objects filtered by the _src column
 * @method     ChildRDataData[]|ObjectCollection findByTarget(int $_ref) Return ChildRDataData objects filtered by the _ref column
 * @method     ChildRDataData[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RDataDataQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\RDataDataQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\RDataData', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRDataDataQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRDataDataQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRDataDataQuery) {
            return $criteria;
        }
        $query = new ChildRDataDataQuery();
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
     * @param array[$_src, $_ref] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildRDataData|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RDataDataTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = RDataDataTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildRDataData A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT _src, _ref FROM R_data_data WHERE _src = :p0 AND _ref = :p1';
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
            /** @var ChildRDataData $obj */
            $obj = new ChildRDataData();
            $obj->hydrate($row);
            RDataDataTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildRDataData|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRDataDataQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(RDataDataTableMap::COL__SRC, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(RDataDataTableMap::COL__REF, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRDataDataQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(RDataDataTableMap::COL__SRC, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(RDataDataTableMap::COL__REF, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the _src column
     *
     * Example usage:
     * <code>
     * $query->filterBySource(1234); // WHERE _src = 1234
     * $query->filterBySource(array(12, 34)); // WHERE _src IN (12, 34)
     * $query->filterBySource(array('min' => 12)); // WHERE _src > 12
     * </code>
     *
     * @see       filterByRDataSrc()
     *
     * @param     mixed $source The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRDataDataQuery The current query, for fluid interface
     */
    public function filterBySource($source = null, $comparison = null)
    {
        if (is_array($source)) {
            $useMinMax = false;
            if (isset($source['min'])) {
                $this->addUsingAlias(RDataDataTableMap::COL__SRC, $source['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($source['max'])) {
                $this->addUsingAlias(RDataDataTableMap::COL__SRC, $source['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RDataDataTableMap::COL__SRC, $source, $comparison);
    }

    /**
     * Filter the query on the _ref column
     *
     * Example usage:
     * <code>
     * $query->filterByTarget(1234); // WHERE _ref = 1234
     * $query->filterByTarget(array(12, 34)); // WHERE _ref IN (12, 34)
     * $query->filterByTarget(array('min' => 12)); // WHERE _ref > 12
     * </code>
     *
     * @see       filterByRDataRef()
     *
     * @param     mixed $target The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRDataDataQuery The current query, for fluid interface
     */
    public function filterByTarget($target = null, $comparison = null)
    {
        if (is_array($target)) {
            $useMinMax = false;
            if (isset($target['min'])) {
                $this->addUsingAlias(RDataDataTableMap::COL__REF, $target['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($target['max'])) {
                $this->addUsingAlias(RDataDataTableMap::COL__REF, $target['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RDataDataTableMap::COL__REF, $target, $comparison);
    }

    /**
     * Filter the query by a related \Data object
     *
     * @param \Data|ObjectCollection $data The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRDataDataQuery The current query, for fluid interface
     */
    public function filterByRDataSrc($data, $comparison = null)
    {
        if ($data instanceof \Data) {
            return $this
                ->addUsingAlias(RDataDataTableMap::COL__SRC, $data->getId(), $comparison);
        } elseif ($data instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RDataDataTableMap::COL__SRC, $data->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRDataSrc() only accepts arguments of type \Data or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RDataSrc relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRDataDataQuery The current query, for fluid interface
     */
    public function joinRDataSrc($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RDataSrc');

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
            $this->addJoinObject($join, 'RDataSrc');
        }

        return $this;
    }

    /**
     * Use the RDataSrc relation Data object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DataQuery A secondary query class using the current class as primary query
     */
    public function useRDataSrcQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRDataSrc($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RDataSrc', '\DataQuery');
    }

    /**
     * Filter the query by a related \Data object
     *
     * @param \Data|ObjectCollection $data The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRDataDataQuery The current query, for fluid interface
     */
    public function filterByRDataRef($data, $comparison = null)
    {
        if ($data instanceof \Data) {
            return $this
                ->addUsingAlias(RDataDataTableMap::COL__REF, $data->getId(), $comparison);
        } elseif ($data instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RDataDataTableMap::COL__REF, $data->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRDataRef() only accepts arguments of type \Data or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RDataRef relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRDataDataQuery The current query, for fluid interface
     */
    public function joinRDataRef($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RDataRef');

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
            $this->addJoinObject($join, 'RDataRef');
        }

        return $this;
    }

    /**
     * Use the RDataRef relation Data object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DataQuery A secondary query class using the current class as primary query
     */
    public function useRDataRefQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRDataRef($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RDataRef', '\DataQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRDataData $rDataData Object to remove from the list of results
     *
     * @return $this|ChildRDataDataQuery The current query, for fluid interface
     */
    public function prune($rDataData = null)
    {
        if ($rDataData) {
            $this->addCond('pruneCond0', $this->getAliasedColName(RDataDataTableMap::COL__SRC), $rDataData->getSource(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(RDataDataTableMap::COL__REF), $rDataData->getTarget(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the R_data_data table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RDataDataTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RDataDataTableMap::clearInstancePool();
            RDataDataTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RDataDataTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RDataDataTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RDataDataTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RDataDataTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RDataDataQuery
