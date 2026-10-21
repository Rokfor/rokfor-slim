<?php

namespace Base;

use \RDataIssue as ChildRDataIssue;
use \RDataIssueQuery as ChildRDataIssueQuery;
use \Exception;
use \PDO;
use Map\RDataIssueTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'R_data_issue' table.
 *
 *
 *
 * @method     ChildRDataIssueQuery orderByDataid($order = Criteria::ASC) Order by the _dataid column
 * @method     ChildRDataIssueQuery orderByIssueid($order = Criteria::ASC) Order by the _issueid column
 *
 * @method     ChildRDataIssueQuery groupByDataid() Group by the _dataid column
 * @method     ChildRDataIssueQuery groupByIssueid() Group by the _issueid column
 *
 * @method     ChildRDataIssueQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRDataIssueQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRDataIssueQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRDataIssueQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildRDataIssueQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildRDataIssueQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildRDataIssueQuery leftJoinRData($relationAlias = null) Adds a LEFT JOIN clause to the query using the RData relation
 * @method     ChildRDataIssueQuery rightJoinRData($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RData relation
 * @method     ChildRDataIssueQuery innerJoinRData($relationAlias = null) Adds a INNER JOIN clause to the query using the RData relation
 *
 * @method     ChildRDataIssueQuery joinWithRData($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RData relation
 *
 * @method     ChildRDataIssueQuery leftJoinWithRData() Adds a LEFT JOIN clause and with to the query using the RData relation
 * @method     ChildRDataIssueQuery rightJoinWithRData() Adds a RIGHT JOIN clause and with to the query using the RData relation
 * @method     ChildRDataIssueQuery innerJoinWithRData() Adds a INNER JOIN clause and with to the query using the RData relation
 *
 * @method     ChildRDataIssueQuery leftJoinRIssue($relationAlias = null) Adds a LEFT JOIN clause to the query using the RIssue relation
 * @method     ChildRDataIssueQuery rightJoinRIssue($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RIssue relation
 * @method     ChildRDataIssueQuery innerJoinRIssue($relationAlias = null) Adds a INNER JOIN clause to the query using the RIssue relation
 *
 * @method     ChildRDataIssueQuery joinWithRIssue($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RIssue relation
 *
 * @method     ChildRDataIssueQuery leftJoinWithRIssue() Adds a LEFT JOIN clause and with to the query using the RIssue relation
 * @method     ChildRDataIssueQuery rightJoinWithRIssue() Adds a RIGHT JOIN clause and with to the query using the RIssue relation
 * @method     ChildRDataIssueQuery innerJoinWithRIssue() Adds a INNER JOIN clause and with to the query using the RIssue relation
 *
 * @method     \DataQuery|\IssuesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRDataIssue findOne(ConnectionInterface $con = null) Return the first ChildRDataIssue matching the query
 * @method     ChildRDataIssue findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRDataIssue matching the query, or a new ChildRDataIssue object populated from the query conditions when no match is found
 *
 * @method     ChildRDataIssue findOneByDataid(int $_dataid) Return the first ChildRDataIssue filtered by the _dataid column
 * @method     ChildRDataIssue findOneByIssueid(int $_issueid) Return the first ChildRDataIssue filtered by the _issueid column *

 * @method     ChildRDataIssue requirePk($key, ConnectionInterface $con = null) Return the ChildRDataIssue by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRDataIssue requireOne(ConnectionInterface $con = null) Return the first ChildRDataIssue matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRDataIssue requireOneByDataid(int $_dataid) Return the first ChildRDataIssue filtered by the _dataid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRDataIssue requireOneByIssueid(int $_issueid) Return the first ChildRDataIssue filtered by the _issueid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRDataIssue[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRDataIssue objects based on current ModelCriteria
 * @method     ChildRDataIssue[]|ObjectCollection findByDataid(int $_dataid) Return ChildRDataIssue objects filtered by the _dataid column
 * @method     ChildRDataIssue[]|ObjectCollection findByIssueid(int $_issueid) Return ChildRDataIssue objects filtered by the _issueid column
 * @method     ChildRDataIssue[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RDataIssueQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\RDataIssueQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\RDataIssue', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRDataIssueQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRDataIssueQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRDataIssueQuery) {
            return $criteria;
        }
        $query = new ChildRDataIssueQuery();
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
     * @param array[$_dataid, $_issueid] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildRDataIssue|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RDataIssueTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = RDataIssueTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildRDataIssue A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT _dataid, _issueid FROM R_data_issue WHERE _dataid = :p0 AND _issueid = :p1';
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
            /** @var ChildRDataIssue $obj */
            $obj = new ChildRDataIssue();
            $obj->hydrate($row);
            RDataIssueTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildRDataIssue|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRDataIssueQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(RDataIssueTableMap::COL__DATAID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(RDataIssueTableMap::COL__ISSUEID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRDataIssueQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(RDataIssueTableMap::COL__DATAID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(RDataIssueTableMap::COL__ISSUEID, $key[1], Criteria::EQUAL);
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
     * @return $this|ChildRDataIssueQuery The current query, for fluid interface
     */
    public function filterByDataid($dataid = null, $comparison = null)
    {
        if (is_array($dataid)) {
            $useMinMax = false;
            if (isset($dataid['min'])) {
                $this->addUsingAlias(RDataIssueTableMap::COL__DATAID, $dataid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dataid['max'])) {
                $this->addUsingAlias(RDataIssueTableMap::COL__DATAID, $dataid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RDataIssueTableMap::COL__DATAID, $dataid, $comparison);
    }

    /**
     * Filter the query on the _issueid column
     *
     * Example usage:
     * <code>
     * $query->filterByIssueid(1234); // WHERE _issueid = 1234
     * $query->filterByIssueid(array(12, 34)); // WHERE _issueid IN (12, 34)
     * $query->filterByIssueid(array('min' => 12)); // WHERE _issueid > 12
     * </code>
     *
     * @see       filterByRIssue()
     *
     * @param     mixed $issueid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRDataIssueQuery The current query, for fluid interface
     */
    public function filterByIssueid($issueid = null, $comparison = null)
    {
        if (is_array($issueid)) {
            $useMinMax = false;
            if (isset($issueid['min'])) {
                $this->addUsingAlias(RDataIssueTableMap::COL__ISSUEID, $issueid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($issueid['max'])) {
                $this->addUsingAlias(RDataIssueTableMap::COL__ISSUEID, $issueid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RDataIssueTableMap::COL__ISSUEID, $issueid, $comparison);
    }

    /**
     * Filter the query by a related \Data object
     *
     * @param \Data|ObjectCollection $data The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRDataIssueQuery The current query, for fluid interface
     */
    public function filterByRData($data, $comparison = null)
    {
        if ($data instanceof \Data) {
            return $this
                ->addUsingAlias(RDataIssueTableMap::COL__DATAID, $data->getId(), $comparison);
        } elseif ($data instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RDataIssueTableMap::COL__DATAID, $data->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildRDataIssueQuery The current query, for fluid interface
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
     * Filter the query by a related \Issues object
     *
     * @param \Issues|ObjectCollection $issues The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRDataIssueQuery The current query, for fluid interface
     */
    public function filterByRIssue($issues, $comparison = null)
    {
        if ($issues instanceof \Issues) {
            return $this
                ->addUsingAlias(RDataIssueTableMap::COL__ISSUEID, $issues->getId(), $comparison);
        } elseif ($issues instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RDataIssueTableMap::COL__ISSUEID, $issues->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRIssue() only accepts arguments of type \Issues or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RIssue relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRDataIssueQuery The current query, for fluid interface
     */
    public function joinRIssue($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RIssue');

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
            $this->addJoinObject($join, 'RIssue');
        }

        return $this;
    }

    /**
     * Use the RIssue relation Issues object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \IssuesQuery A secondary query class using the current class as primary query
     */
    public function useRIssueQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRIssue($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RIssue', '\IssuesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRDataIssue $rDataIssue Object to remove from the list of results
     *
     * @return $this|ChildRDataIssueQuery The current query, for fluid interface
     */
    public function prune($rDataIssue = null)
    {
        if ($rDataIssue) {
            $this->addCond('pruneCond0', $this->getAliasedColName(RDataIssueTableMap::COL__DATAID), $rDataIssue->getDataid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(RDataIssueTableMap::COL__ISSUEID), $rDataIssue->getIssueid(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the R_data_issue table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RDataIssueTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RDataIssueTableMap::clearInstancePool();
            RDataIssueTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RDataIssueTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RDataIssueTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RDataIssueTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RDataIssueTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RDataIssueQuery
