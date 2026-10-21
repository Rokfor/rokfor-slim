<?php

namespace Base;

use \RDataContribution as ChildRDataContribution;
use \RDataContributionQuery as ChildRDataContributionQuery;
use \Exception;
use \PDO;
use Map\RDataContributionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'R_data_contribution' table.
 *
 *
 *
 * @method     ChildRDataContributionQuery orderByDataid($order = Criteria::ASC) Order by the _dataid column
 * @method     ChildRDataContributionQuery orderByContributionid($order = Criteria::ASC) Order by the _contributionid column
 *
 * @method     ChildRDataContributionQuery groupByDataid() Group by the _dataid column
 * @method     ChildRDataContributionQuery groupByContributionid() Group by the _contributionid column
 *
 * @method     ChildRDataContributionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRDataContributionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRDataContributionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRDataContributionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildRDataContributionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildRDataContributionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildRDataContributionQuery leftJoinRData($relationAlias = null) Adds a LEFT JOIN clause to the query using the RData relation
 * @method     ChildRDataContributionQuery rightJoinRData($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RData relation
 * @method     ChildRDataContributionQuery innerJoinRData($relationAlias = null) Adds a INNER JOIN clause to the query using the RData relation
 *
 * @method     ChildRDataContributionQuery joinWithRData($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RData relation
 *
 * @method     ChildRDataContributionQuery leftJoinWithRData() Adds a LEFT JOIN clause and with to the query using the RData relation
 * @method     ChildRDataContributionQuery rightJoinWithRData() Adds a RIGHT JOIN clause and with to the query using the RData relation
 * @method     ChildRDataContributionQuery innerJoinWithRData() Adds a INNER JOIN clause and with to the query using the RData relation
 *
 * @method     ChildRDataContributionQuery leftJoinRContribution($relationAlias = null) Adds a LEFT JOIN clause to the query using the RContribution relation
 * @method     ChildRDataContributionQuery rightJoinRContribution($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RContribution relation
 * @method     ChildRDataContributionQuery innerJoinRContribution($relationAlias = null) Adds a INNER JOIN clause to the query using the RContribution relation
 *
 * @method     ChildRDataContributionQuery joinWithRContribution($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RContribution relation
 *
 * @method     ChildRDataContributionQuery leftJoinWithRContribution() Adds a LEFT JOIN clause and with to the query using the RContribution relation
 * @method     ChildRDataContributionQuery rightJoinWithRContribution() Adds a RIGHT JOIN clause and with to the query using the RContribution relation
 * @method     ChildRDataContributionQuery innerJoinWithRContribution() Adds a INNER JOIN clause and with to the query using the RContribution relation
 *
 * @method     \DataQuery|\ContributionsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRDataContribution findOne(ConnectionInterface $con = null) Return the first ChildRDataContribution matching the query
 * @method     ChildRDataContribution findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRDataContribution matching the query, or a new ChildRDataContribution object populated from the query conditions when no match is found
 *
 * @method     ChildRDataContribution findOneByDataid(int $_dataid) Return the first ChildRDataContribution filtered by the _dataid column
 * @method     ChildRDataContribution findOneByContributionid(int $_contributionid) Return the first ChildRDataContribution filtered by the _contributionid column *

 * @method     ChildRDataContribution requirePk($key, ConnectionInterface $con = null) Return the ChildRDataContribution by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRDataContribution requireOne(ConnectionInterface $con = null) Return the first ChildRDataContribution matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRDataContribution requireOneByDataid(int $_dataid) Return the first ChildRDataContribution filtered by the _dataid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRDataContribution requireOneByContributionid(int $_contributionid) Return the first ChildRDataContribution filtered by the _contributionid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRDataContribution[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRDataContribution objects based on current ModelCriteria
 * @method     ChildRDataContribution[]|ObjectCollection findByDataid(int $_dataid) Return ChildRDataContribution objects filtered by the _dataid column
 * @method     ChildRDataContribution[]|ObjectCollection findByContributionid(int $_contributionid) Return ChildRDataContribution objects filtered by the _contributionid column
 * @method     ChildRDataContribution[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RDataContributionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\RDataContributionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\RDataContribution', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRDataContributionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRDataContributionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRDataContributionQuery) {
            return $criteria;
        }
        $query = new ChildRDataContributionQuery();
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
     * @param array[$_dataid, $_contributionid] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildRDataContribution|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RDataContributionTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = RDataContributionTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildRDataContribution A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT _dataid, _contributionid FROM R_data_contribution WHERE _dataid = :p0 AND _contributionid = :p1';
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
            /** @var ChildRDataContribution $obj */
            $obj = new ChildRDataContribution();
            $obj->hydrate($row);
            RDataContributionTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildRDataContribution|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRDataContributionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(RDataContributionTableMap::COL__DATAID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(RDataContributionTableMap::COL__CONTRIBUTIONID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRDataContributionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(RDataContributionTableMap::COL__DATAID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(RDataContributionTableMap::COL__CONTRIBUTIONID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the _dataid column
     *
     * Example usage:
     * <code>
     * $query->filterByDataid(1234); // WHERE _dataid = 1234
     * $query->filterByDataid(array(12, 34)); // WHERE _dataid IN (12, 34)
     * $query->filterByDataid(array('min' => 12)); // WHERE _dataid > 12
     * </code>
     *
     * @see       filterByRData()
     *
     * @param     mixed $dataid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRDataContributionQuery The current query, for fluid interface
     */
    public function filterByDataid($dataid = null, $comparison = null)
    {
        if (is_array($dataid)) {
            $useMinMax = false;
            if (isset($dataid['min'])) {
                $this->addUsingAlias(RDataContributionTableMap::COL__DATAID, $dataid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dataid['max'])) {
                $this->addUsingAlias(RDataContributionTableMap::COL__DATAID, $dataid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RDataContributionTableMap::COL__DATAID, $dataid, $comparison);
    }

    /**
     * Filter the query on the _contributionid column
     *
     * Example usage:
     * <code>
     * $query->filterByContributionid(1234); // WHERE _contributionid = 1234
     * $query->filterByContributionid(array(12, 34)); // WHERE _contributionid IN (12, 34)
     * $query->filterByContributionid(array('min' => 12)); // WHERE _contributionid > 12
     * </code>
     *
     * @see       filterByRContribution()
     *
     * @param     mixed $contributionid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRDataContributionQuery The current query, for fluid interface
     */
    public function filterByContributionid($contributionid = null, $comparison = null)
    {
        if (is_array($contributionid)) {
            $useMinMax = false;
            if (isset($contributionid['min'])) {
                $this->addUsingAlias(RDataContributionTableMap::COL__CONTRIBUTIONID, $contributionid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($contributionid['max'])) {
                $this->addUsingAlias(RDataContributionTableMap::COL__CONTRIBUTIONID, $contributionid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RDataContributionTableMap::COL__CONTRIBUTIONID, $contributionid, $comparison);
    }

    /**
     * Filter the query by a related \Data object
     *
     * @param \Data|ObjectCollection $data The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRDataContributionQuery The current query, for fluid interface
     */
    public function filterByRData($data, $comparison = null)
    {
        if ($data instanceof \Data) {
            return $this
                ->addUsingAlias(RDataContributionTableMap::COL__DATAID, $data->getId(), $comparison);
        } elseif ($data instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RDataContributionTableMap::COL__DATAID, $data->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRData() only accepts arguments of type \Data or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RData relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRDataContributionQuery The current query, for fluid interface
     */
    public function joinRData($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RData');

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
            $this->addJoinObject($join, 'RData');
        }

        return $this;
    }

    /**
     * Use the RData relation Data object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DataQuery A secondary query class using the current class as primary query
     */
    public function useRDataQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRData($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RData', '\DataQuery');
    }

    /**
     * Filter the query by a related \Contributions object
     *
     * @param \Contributions|ObjectCollection $contributions The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRDataContributionQuery The current query, for fluid interface
     */
    public function filterByRContribution($contributions, $comparison = null)
    {
        if ($contributions instanceof \Contributions) {
            return $this
                ->addUsingAlias(RDataContributionTableMap::COL__CONTRIBUTIONID, $contributions->getId(), $comparison);
        } elseif ($contributions instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RDataContributionTableMap::COL__CONTRIBUTIONID, $contributions->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRContribution() only accepts arguments of type \Contributions or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RContribution relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRDataContributionQuery The current query, for fluid interface
     */
    public function joinRContribution($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RContribution');

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
            $this->addJoinObject($join, 'RContribution');
        }

        return $this;
    }

    /**
     * Use the RContribution relation Contributions object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ContributionsQuery A secondary query class using the current class as primary query
     */
    public function useRContributionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRContribution($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RContribution', '\ContributionsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRDataContribution $rDataContribution Object to remove from the list of results
     *
     * @return $this|ChildRDataContributionQuery The current query, for fluid interface
     */
    public function prune($rDataContribution = null)
    {
        if ($rDataContribution) {
            $this->addCond('pruneCond0', $this->getAliasedColName(RDataContributionTableMap::COL__DATAID), $rDataContribution->getDataid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(RDataContributionTableMap::COL__CONTRIBUTIONID), $rDataContribution->getContributionid(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the R_data_contribution table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RDataContributionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RDataContributionTableMap::clearInstancePool();
            RDataContributionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RDataContributionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RDataContributionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RDataContributionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RDataContributionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RDataContributionQuery
