<?php

namespace Base;

use \RDataBook as ChildRDataBook;
use \RDataBookQuery as ChildRDataBookQuery;
use \Exception;
use \PDO;
use Map\RDataBookTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'R_data_book' table.
 *
 *
 *
 * @method     ChildRDataBookQuery orderByDataid($order = Criteria::ASC) Order by the _dataid column
 * @method     ChildRDataBookQuery orderByBookid($order = Criteria::ASC) Order by the _bookid column
 *
 * @method     ChildRDataBookQuery groupByDataid() Group by the _dataid column
 * @method     ChildRDataBookQuery groupByBookid() Group by the _bookid column
 *
 * @method     ChildRDataBookQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRDataBookQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRDataBookQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRDataBookQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildRDataBookQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildRDataBookQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildRDataBookQuery leftJoinRData($relationAlias = null) Adds a LEFT JOIN clause to the query using the RData relation
 * @method     ChildRDataBookQuery rightJoinRData($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RData relation
 * @method     ChildRDataBookQuery innerJoinRData($relationAlias = null) Adds a INNER JOIN clause to the query using the RData relation
 *
 * @method     ChildRDataBookQuery joinWithRData($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RData relation
 *
 * @method     ChildRDataBookQuery leftJoinWithRData() Adds a LEFT JOIN clause and with to the query using the RData relation
 * @method     ChildRDataBookQuery rightJoinWithRData() Adds a RIGHT JOIN clause and with to the query using the RData relation
 * @method     ChildRDataBookQuery innerJoinWithRData() Adds a INNER JOIN clause and with to the query using the RData relation
 *
 * @method     ChildRDataBookQuery leftJoinRBook($relationAlias = null) Adds a LEFT JOIN clause to the query using the RBook relation
 * @method     ChildRDataBookQuery rightJoinRBook($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RBook relation
 * @method     ChildRDataBookQuery innerJoinRBook($relationAlias = null) Adds a INNER JOIN clause to the query using the RBook relation
 *
 * @method     ChildRDataBookQuery joinWithRBook($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RBook relation
 *
 * @method     ChildRDataBookQuery leftJoinWithRBook() Adds a LEFT JOIN clause and with to the query using the RBook relation
 * @method     ChildRDataBookQuery rightJoinWithRBook() Adds a RIGHT JOIN clause and with to the query using the RBook relation
 * @method     ChildRDataBookQuery innerJoinWithRBook() Adds a INNER JOIN clause and with to the query using the RBook relation
 *
 * @method     \DataQuery|\BooksQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRDataBook findOne(ConnectionInterface $con = null) Return the first ChildRDataBook matching the query
 * @method     ChildRDataBook findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRDataBook matching the query, or a new ChildRDataBook object populated from the query conditions when no match is found
 *
 * @method     ChildRDataBook findOneByDataid(int $_dataid) Return the first ChildRDataBook filtered by the _dataid column
 * @method     ChildRDataBook findOneByBookid(int $_bookid) Return the first ChildRDataBook filtered by the _bookid column *

 * @method     ChildRDataBook requirePk($key, ConnectionInterface $con = null) Return the ChildRDataBook by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRDataBook requireOne(ConnectionInterface $con = null) Return the first ChildRDataBook matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRDataBook requireOneByDataid(int $_dataid) Return the first ChildRDataBook filtered by the _dataid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRDataBook requireOneByBookid(int $_bookid) Return the first ChildRDataBook filtered by the _bookid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRDataBook[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRDataBook objects based on current ModelCriteria
 * @method     ChildRDataBook[]|ObjectCollection findByDataid(int $_dataid) Return ChildRDataBook objects filtered by the _dataid column
 * @method     ChildRDataBook[]|ObjectCollection findByBookid(int $_bookid) Return ChildRDataBook objects filtered by the _bookid column
 * @method     ChildRDataBook[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RDataBookQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\RDataBookQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\RDataBook', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRDataBookQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRDataBookQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRDataBookQuery) {
            return $criteria;
        }
        $query = new ChildRDataBookQuery();
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
     * @param array[$_dataid, $_bookid] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildRDataBook|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RDataBookTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = RDataBookTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildRDataBook A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT _dataid, _bookid FROM R_data_book WHERE _dataid = :p0 AND _bookid = :p1';
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
            /** @var ChildRDataBook $obj */
            $obj = new ChildRDataBook();
            $obj->hydrate($row);
            RDataBookTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildRDataBook|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRDataBookQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(RDataBookTableMap::COL__DATAID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(RDataBookTableMap::COL__BOOKID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRDataBookQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(RDataBookTableMap::COL__DATAID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(RDataBookTableMap::COL__BOOKID, $key[1], Criteria::EQUAL);
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
     * @return $this|ChildRDataBookQuery The current query, for fluid interface
     */
    public function filterByDataid($dataid = null, $comparison = null)
    {
        if (is_array($dataid)) {
            $useMinMax = false;
            if (isset($dataid['min'])) {
                $this->addUsingAlias(RDataBookTableMap::COL__DATAID, $dataid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dataid['max'])) {
                $this->addUsingAlias(RDataBookTableMap::COL__DATAID, $dataid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RDataBookTableMap::COL__DATAID, $dataid, $comparison);
    }

    /**
     * Filter the query on the _bookid column
     *
     * Example usage:
     * <code>
     * $query->filterByBookid(1234); // WHERE _bookid = 1234
     * $query->filterByBookid(array(12, 34)); // WHERE _bookid IN (12, 34)
     * $query->filterByBookid(array('min' => 12)); // WHERE _bookid > 12
     * </code>
     *
     * @see       filterByRBook()
     *
     * @param     mixed $bookid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRDataBookQuery The current query, for fluid interface
     */
    public function filterByBookid($bookid = null, $comparison = null)
    {
        if (is_array($bookid)) {
            $useMinMax = false;
            if (isset($bookid['min'])) {
                $this->addUsingAlias(RDataBookTableMap::COL__BOOKID, $bookid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bookid['max'])) {
                $this->addUsingAlias(RDataBookTableMap::COL__BOOKID, $bookid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RDataBookTableMap::COL__BOOKID, $bookid, $comparison);
    }

    /**
     * Filter the query by a related \Data object
     *
     * @param \Data|ObjectCollection $data The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRDataBookQuery The current query, for fluid interface
     */
    public function filterByRData($data, $comparison = null)
    {
        if ($data instanceof \Data) {
            return $this
                ->addUsingAlias(RDataBookTableMap::COL__DATAID, $data->getId(), $comparison);
        } elseif ($data instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RDataBookTableMap::COL__DATAID, $data->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildRDataBookQuery The current query, for fluid interface
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
     * Filter the query by a related \Books object
     *
     * @param \Books|ObjectCollection $books The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRDataBookQuery The current query, for fluid interface
     */
    public function filterByRBook($books, $comparison = null)
    {
        if ($books instanceof \Books) {
            return $this
                ->addUsingAlias(RDataBookTableMap::COL__BOOKID, $books->getId(), $comparison);
        } elseif ($books instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RDataBookTableMap::COL__BOOKID, $books->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRBook() only accepts arguments of type \Books or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RBook relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRDataBookQuery The current query, for fluid interface
     */
    public function joinRBook($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RBook');

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
            $this->addJoinObject($join, 'RBook');
        }

        return $this;
    }

    /**
     * Use the RBook relation Books object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BooksQuery A secondary query class using the current class as primary query
     */
    public function useRBookQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRBook($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RBook', '\BooksQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRDataBook $rDataBook Object to remove from the list of results
     *
     * @return $this|ChildRDataBookQuery The current query, for fluid interface
     */
    public function prune($rDataBook = null)
    {
        if ($rDataBook) {
            $this->addCond('pruneCond0', $this->getAliasedColName(RDataBookTableMap::COL__DATAID), $rDataBook->getDataid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(RDataBookTableMap::COL__BOOKID), $rDataBook->getBookid(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the R_data_book table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RDataBookTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RDataBookTableMap::clearInstancePool();
            RDataBookTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RDataBookTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RDataBookTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RDataBookTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RDataBookTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RDataBookQuery
