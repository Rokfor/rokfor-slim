<?php

namespace Base;

use \Log as ChildLog;
use \LogQuery as ChildLogQuery;
use \Exception;
use \PDO;
use Map\LogTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the '_log' table.
 *
 *
 *
 * @method     ChildLogQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildLogQuery orderByIp($order = Criteria::ASC) Order by the _ip column
 * @method     ChildLogQuery orderByAgent($order = Criteria::ASC) Order by the _agent column
 * @method     ChildLogQuery orderByUser($order = Criteria::ASC) Order by the _user column
 * @method     ChildLogQuery orderByDate($order = Criteria::ASC) Order by the _date column
 * @method     ChildLogQuery orderByConfigSys($order = Criteria::ASC) Order by the __config__ column
 * @method     ChildLogQuery orderBySplit($order = Criteria::ASC) Order by the __split__ column
 * @method     ChildLogQuery orderByParentnode($order = Criteria::ASC) Order by the __parentnode__ column
 * @method     ChildLogQuery orderBySort($order = Criteria::ASC) Order by the __sort__ column
 *
 * @method     ChildLogQuery groupById() Group by the id column
 * @method     ChildLogQuery groupByIp() Group by the _ip column
 * @method     ChildLogQuery groupByAgent() Group by the _agent column
 * @method     ChildLogQuery groupByUser() Group by the _user column
 * @method     ChildLogQuery groupByDate() Group by the _date column
 * @method     ChildLogQuery groupByConfigSys() Group by the __config__ column
 * @method     ChildLogQuery groupBySplit() Group by the __split__ column
 * @method     ChildLogQuery groupByParentnode() Group by the __parentnode__ column
 * @method     ChildLogQuery groupBySort() Group by the __sort__ column
 *
 * @method     ChildLogQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildLogQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildLogQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildLogQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildLogQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildLogQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildLog findOne(ConnectionInterface $con = null) Return the first ChildLog matching the query
 * @method     ChildLog findOneOrCreate(ConnectionInterface $con = null) Return the first ChildLog matching the query, or a new ChildLog object populated from the query conditions when no match is found
 *
 * @method     ChildLog findOneById(int $id) Return the first ChildLog filtered by the id column
 * @method     ChildLog findOneByIp(string $_ip) Return the first ChildLog filtered by the _ip column
 * @method     ChildLog findOneByAgent(string $_agent) Return the first ChildLog filtered by the _agent column
 * @method     ChildLog findOneByUser(string $_user) Return the first ChildLog filtered by the _user column
 * @method     ChildLog findOneByDate(int $_date) Return the first ChildLog filtered by the _date column
 * @method     ChildLog findOneByConfigSys(string $__config__) Return the first ChildLog filtered by the __config__ column
 * @method     ChildLog findOneBySplit(string $__split__) Return the first ChildLog filtered by the __split__ column
 * @method     ChildLog findOneByParentnode(int $__parentnode__) Return the first ChildLog filtered by the __parentnode__ column
 * @method     ChildLog findOneBySort(int $__sort__) Return the first ChildLog filtered by the __sort__ column *

 * @method     ChildLog requirePk($key, ConnectionInterface $con = null) Return the ChildLog by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLog requireOne(ConnectionInterface $con = null) Return the first ChildLog matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildLog requireOneById(int $id) Return the first ChildLog filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLog requireOneByIp(string $_ip) Return the first ChildLog filtered by the _ip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLog requireOneByAgent(string $_agent) Return the first ChildLog filtered by the _agent column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLog requireOneByUser(string $_user) Return the first ChildLog filtered by the _user column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLog requireOneByDate(int $_date) Return the first ChildLog filtered by the _date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLog requireOneByConfigSys(string $__config__) Return the first ChildLog filtered by the __config__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLog requireOneBySplit(string $__split__) Return the first ChildLog filtered by the __split__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLog requireOneByParentnode(int $__parentnode__) Return the first ChildLog filtered by the __parentnode__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildLog requireOneBySort(int $__sort__) Return the first ChildLog filtered by the __sort__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildLog[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildLog objects based on current ModelCriteria
 * @method     ChildLog[]|ObjectCollection findById(int $id) Return ChildLog objects filtered by the id column
 * @method     ChildLog[]|ObjectCollection findByIp(string $_ip) Return ChildLog objects filtered by the _ip column
 * @method     ChildLog[]|ObjectCollection findByAgent(string $_agent) Return ChildLog objects filtered by the _agent column
 * @method     ChildLog[]|ObjectCollection findByUser(string $_user) Return ChildLog objects filtered by the _user column
 * @method     ChildLog[]|ObjectCollection findByDate(int $_date) Return ChildLog objects filtered by the _date column
 * @method     ChildLog[]|ObjectCollection findByConfigSys(string $__config__) Return ChildLog objects filtered by the __config__ column
 * @method     ChildLog[]|ObjectCollection findBySplit(string $__split__) Return ChildLog objects filtered by the __split__ column
 * @method     ChildLog[]|ObjectCollection findByParentnode(int $__parentnode__) Return ChildLog objects filtered by the __parentnode__ column
 * @method     ChildLog[]|ObjectCollection findBySort(int $__sort__) Return ChildLog objects filtered by the __sort__ column
 * @method     ChildLog[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class LogQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\LogQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\Log', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildLogQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildLogQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildLogQuery) {
            return $criteria;
        }
        $query = new ChildLogQuery();
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
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildLog|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(LogTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = LogTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildLog A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, _ip, _agent, _user, _date, __config__, __split__, __parentnode__, __sort__ FROM _log WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildLog $obj */
            $obj = new ChildLog();
            $obj->hydrate($row);
            LogTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildLog|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(12, 56, 832), $con);
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
     * @return $this|ChildLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(LogTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(LogTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLogQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(LogTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(LogTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LogTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the _ip column
     *
     * Example usage:
     * <code>
     * $query->filterByIp('fooValue');   // WHERE _ip = 'fooValue'
     * $query->filterByIp('%fooValue%', Criteria::LIKE); // WHERE _ip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ip The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLogQuery The current query, for fluid interface
     */
    public function filterByIp($ip = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ip)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LogTableMap::COL__IP, $ip, $comparison);
    }

    /**
     * Filter the query on the _agent column
     *
     * Example usage:
     * <code>
     * $query->filterByAgent('fooValue');   // WHERE _agent = 'fooValue'
     * $query->filterByAgent('%fooValue%', Criteria::LIKE); // WHERE _agent LIKE '%fooValue%'
     * </code>
     *
     * @param     string $agent The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLogQuery The current query, for fluid interface
     */
    public function filterByAgent($agent = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($agent)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LogTableMap::COL__AGENT, $agent, $comparison);
    }

    /**
     * Filter the query on the _user column
     *
     * Example usage:
     * <code>
     * $query->filterByUser('fooValue');   // WHERE _user = 'fooValue'
     * $query->filterByUser('%fooValue%', Criteria::LIKE); // WHERE _user LIKE '%fooValue%'
     * </code>
     *
     * @param     string $user The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLogQuery The current query, for fluid interface
     */
    public function filterByUser($user = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($user)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LogTableMap::COL__USER, $user, $comparison);
    }

    /**
     * Filter the query on the _date column
     *
     * Example usage:
     * <code>
     * $query->filterByDate(1234); // WHERE _date = 1234
     * $query->filterByDate(array(12, 34)); // WHERE _date IN (12, 34)
     * $query->filterByDate(array('min' => 12)); // WHERE _date > 12
     * </code>
     *
     * @param     mixed $date The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLogQuery The current query, for fluid interface
     */
    public function filterByDate($date = null, $comparison = null)
    {
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingAlias(LogTableMap::COL__DATE, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingAlias(LogTableMap::COL__DATE, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LogTableMap::COL__DATE, $date, $comparison);
    }

    /**
     * Filter the query on the __config__ column
     *
     * Example usage:
     * <code>
     * $query->filterByConfigSys('fooValue');   // WHERE __config__ = 'fooValue'
     * $query->filterByConfigSys('%fooValue%', Criteria::LIKE); // WHERE __config__ LIKE '%fooValue%'
     * </code>
     *
     * @param     string $configSys The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLogQuery The current query, for fluid interface
     */
    public function filterByConfigSys($configSys = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($configSys)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LogTableMap::COL___CONFIG__, $configSys, $comparison);
    }

    /**
     * Filter the query on the __split__ column
     *
     * Example usage:
     * <code>
     * $query->filterBySplit('fooValue');   // WHERE __split__ = 'fooValue'
     * $query->filterBySplit('%fooValue%', Criteria::LIKE); // WHERE __split__ LIKE '%fooValue%'
     * </code>
     *
     * @param     string $split The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLogQuery The current query, for fluid interface
     */
    public function filterBySplit($split = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($split)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LogTableMap::COL___SPLIT__, $split, $comparison);
    }

    /**
     * Filter the query on the __parentnode__ column
     *
     * Example usage:
     * <code>
     * $query->filterByParentnode(1234); // WHERE __parentnode__ = 1234
     * $query->filterByParentnode(array(12, 34)); // WHERE __parentnode__ IN (12, 34)
     * $query->filterByParentnode(array('min' => 12)); // WHERE __parentnode__ > 12
     * </code>
     *
     * @param     mixed $parentnode The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLogQuery The current query, for fluid interface
     */
    public function filterByParentnode($parentnode = null, $comparison = null)
    {
        if (is_array($parentnode)) {
            $useMinMax = false;
            if (isset($parentnode['min'])) {
                $this->addUsingAlias(LogTableMap::COL___PARENTNODE__, $parentnode['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentnode['max'])) {
                $this->addUsingAlias(LogTableMap::COL___PARENTNODE__, $parentnode['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LogTableMap::COL___PARENTNODE__, $parentnode, $comparison);
    }

    /**
     * Filter the query on the __sort__ column
     *
     * Example usage:
     * <code>
     * $query->filterBySort(1234); // WHERE __sort__ = 1234
     * $query->filterBySort(array(12, 34)); // WHERE __sort__ IN (12, 34)
     * $query->filterBySort(array('min' => 12)); // WHERE __sort__ > 12
     * </code>
     *
     * @param     mixed $sort The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildLogQuery The current query, for fluid interface
     */
    public function filterBySort($sort = null, $comparison = null)
    {
        if (is_array($sort)) {
            $useMinMax = false;
            if (isset($sort['min'])) {
                $this->addUsingAlias(LogTableMap::COL___SORT__, $sort['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sort['max'])) {
                $this->addUsingAlias(LogTableMap::COL___SORT__, $sort['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(LogTableMap::COL___SORT__, $sort, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildLog $log Object to remove from the list of results
     *
     * @return $this|ChildLogQuery The current query, for fluid interface
     */
    public function prune($log = null)
    {
        if ($log) {
            $this->addUsingAlias(LogTableMap::COL_ID, $log->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the _log table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(LogTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            LogTableMap::clearInstancePool();
            LogTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(LogTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(LogTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            LogTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            LogTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // LogQuery
