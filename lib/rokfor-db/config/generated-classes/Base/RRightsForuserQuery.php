<?php

namespace Base;

use \RRightsForuser as ChildRRightsForuser;
use \RRightsForuserQuery as ChildRRightsForuserQuery;
use \Exception;
use \PDO;
use Map\RRightsForuserTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'R_rights_foruser' table.
 *
 *
 *
 * @method     ChildRRightsForuserQuery orderByRightid($order = Criteria::ASC) Order by the _rightid column
 * @method     ChildRRightsForuserQuery orderByUserid($order = Criteria::ASC) Order by the _userid column
 *
 * @method     ChildRRightsForuserQuery groupByRightid() Group by the _rightid column
 * @method     ChildRRightsForuserQuery groupByUserid() Group by the _userid column
 *
 * @method     ChildRRightsForuserQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRRightsForuserQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRRightsForuserQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRRightsForuserQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildRRightsForuserQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildRRightsForuserQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildRRightsForuserQuery leftJoinRights($relationAlias = null) Adds a LEFT JOIN clause to the query using the Rights relation
 * @method     ChildRRightsForuserQuery rightJoinRights($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Rights relation
 * @method     ChildRRightsForuserQuery innerJoinRights($relationAlias = null) Adds a INNER JOIN clause to the query using the Rights relation
 *
 * @method     ChildRRightsForuserQuery joinWithRights($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Rights relation
 *
 * @method     ChildRRightsForuserQuery leftJoinWithRights() Adds a LEFT JOIN clause and with to the query using the Rights relation
 * @method     ChildRRightsForuserQuery rightJoinWithRights() Adds a RIGHT JOIN clause and with to the query using the Rights relation
 * @method     ChildRRightsForuserQuery innerJoinWithRights() Adds a INNER JOIN clause and with to the query using the Rights relation
 *
 * @method     ChildRRightsForuserQuery leftJoinUsers($relationAlias = null) Adds a LEFT JOIN clause to the query using the Users relation
 * @method     ChildRRightsForuserQuery rightJoinUsers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Users relation
 * @method     ChildRRightsForuserQuery innerJoinUsers($relationAlias = null) Adds a INNER JOIN clause to the query using the Users relation
 *
 * @method     ChildRRightsForuserQuery joinWithUsers($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Users relation
 *
 * @method     ChildRRightsForuserQuery leftJoinWithUsers() Adds a LEFT JOIN clause and with to the query using the Users relation
 * @method     ChildRRightsForuserQuery rightJoinWithUsers() Adds a RIGHT JOIN clause and with to the query using the Users relation
 * @method     ChildRRightsForuserQuery innerJoinWithUsers() Adds a INNER JOIN clause and with to the query using the Users relation
 *
 * @method     \RightsQuery|\UsersQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRRightsForuser findOne(ConnectionInterface $con = null) Return the first ChildRRightsForuser matching the query
 * @method     ChildRRightsForuser findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRRightsForuser matching the query, or a new ChildRRightsForuser object populated from the query conditions when no match is found
 *
 * @method     ChildRRightsForuser findOneByRightid(int $_rightid) Return the first ChildRRightsForuser filtered by the _rightid column
 * @method     ChildRRightsForuser findOneByUserid(int $_userid) Return the first ChildRRightsForuser filtered by the _userid column *

 * @method     ChildRRightsForuser requirePk($key, ConnectionInterface $con = null) Return the ChildRRightsForuser by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRRightsForuser requireOne(ConnectionInterface $con = null) Return the first ChildRRightsForuser matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRRightsForuser requireOneByRightid(int $_rightid) Return the first ChildRRightsForuser filtered by the _rightid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRRightsForuser requireOneByUserid(int $_userid) Return the first ChildRRightsForuser filtered by the _userid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRRightsForuser[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRRightsForuser objects based on current ModelCriteria
 * @method     ChildRRightsForuser[]|ObjectCollection findByRightid(int $_rightid) Return ChildRRightsForuser objects filtered by the _rightid column
 * @method     ChildRRightsForuser[]|ObjectCollection findByUserid(int $_userid) Return ChildRRightsForuser objects filtered by the _userid column
 * @method     ChildRRightsForuser[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RRightsForuserQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\RRightsForuserQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\RRightsForuser', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRRightsForuserQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRRightsForuserQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRRightsForuserQuery) {
            return $criteria;
        }
        $query = new ChildRRightsForuserQuery();
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
     * @param array[$_rightid, $_userid] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildRRightsForuser|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RRightsForuserTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = RRightsForuserTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildRRightsForuser A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT _rightid, _userid FROM R_rights_foruser WHERE _rightid = :p0 AND _userid = :p1';
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
            /** @var ChildRRightsForuser $obj */
            $obj = new ChildRRightsForuser();
            $obj->hydrate($row);
            RRightsForuserTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildRRightsForuser|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRRightsForuserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(RRightsForuserTableMap::COL__RIGHTID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(RRightsForuserTableMap::COL__USERID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRRightsForuserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(RRightsForuserTableMap::COL__RIGHTID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(RRightsForuserTableMap::COL__USERID, $key[1], Criteria::EQUAL);
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
     * @return $this|ChildRRightsForuserQuery The current query, for fluid interface
     */
    public function filterByRightid($rightid = null, $comparison = null)
    {
        if (is_array($rightid)) {
            $useMinMax = false;
            if (isset($rightid['min'])) {
                $this->addUsingAlias(RRightsForuserTableMap::COL__RIGHTID, $rightid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rightid['max'])) {
                $this->addUsingAlias(RRightsForuserTableMap::COL__RIGHTID, $rightid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RRightsForuserTableMap::COL__RIGHTID, $rightid, $comparison);
    }

    /**
     * Filter the query on the _userid column
     *
     * Example usage:
     * <code>
     * $query->filterByUserid(1234); // WHERE _userid = 1234
     * $query->filterByUserid(array(12, 34)); // WHERE _userid IN (12, 34)
     * $query->filterByUserid(array('min' => 12)); // WHERE _userid > 12
     * </code>
     *
     * @see       filterByUsers()
     *
     * @param     mixed $userid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRRightsForuserQuery The current query, for fluid interface
     */
    public function filterByUserid($userid = null, $comparison = null)
    {
        if (is_array($userid)) {
            $useMinMax = false;
            if (isset($userid['min'])) {
                $this->addUsingAlias(RRightsForuserTableMap::COL__USERID, $userid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userid['max'])) {
                $this->addUsingAlias(RRightsForuserTableMap::COL__USERID, $userid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RRightsForuserTableMap::COL__USERID, $userid, $comparison);
    }

    /**
     * Filter the query by a related \Rights object
     *
     * @param \Rights|ObjectCollection $rights The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRRightsForuserQuery The current query, for fluid interface
     */
    public function filterByRights($rights, $comparison = null)
    {
        if ($rights instanceof \Rights) {
            return $this
                ->addUsingAlias(RRightsForuserTableMap::COL__RIGHTID, $rights->getId(), $comparison);
        } elseif ($rights instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RRightsForuserTableMap::COL__RIGHTID, $rights->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildRRightsForuserQuery The current query, for fluid interface
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
     * Filter the query by a related \Users object
     *
     * @param \Users|ObjectCollection $users The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRRightsForuserQuery The current query, for fluid interface
     */
    public function filterByUsers($users, $comparison = null)
    {
        if ($users instanceof \Users) {
            return $this
                ->addUsingAlias(RRightsForuserTableMap::COL__USERID, $users->getId(), $comparison);
        } elseif ($users instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RRightsForuserTableMap::COL__USERID, $users->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUsers() only accepts arguments of type \Users or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Users relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRRightsForuserQuery The current query, for fluid interface
     */
    public function joinUsers($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Users');

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
            $this->addJoinObject($join, 'Users');
        }

        return $this;
    }

    /**
     * Use the Users relation Users object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UsersQuery A secondary query class using the current class as primary query
     */
    public function useUsersQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUsers($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Users', '\UsersQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRRightsForuser $rRightsForuser Object to remove from the list of results
     *
     * @return $this|ChildRRightsForuserQuery The current query, for fluid interface
     */
    public function prune($rRightsForuser = null)
    {
        if ($rRightsForuser) {
            $this->addCond('pruneCond0', $this->getAliasedColName(RRightsForuserTableMap::COL__RIGHTID), $rRightsForuser->getRightid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(RRightsForuserTableMap::COL__USERID), $rRightsForuser->getUserid(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the R_rights_foruser table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RRightsForuserTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RRightsForuserTableMap::clearInstancePool();
            RRightsForuserTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RRightsForuserTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RRightsForuserTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RRightsForuserTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RRightsForuserTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RRightsForuserQuery
