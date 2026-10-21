<?php

namespace Base;

use \Books as ChildBooks;
use \BooksQuery as ChildBooksQuery;
use \Exception;
use \PDO;
use Map\BooksTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the '_books' table.
 *
 *
 *
 * @method     ChildBooksQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildBooksQuery orderByName($order = Criteria::ASC) Order by the _name column
 * @method     ChildBooksQuery orderByUserSys($order = Criteria::ASC) Order by the __user__ column
 * @method     ChildBooksQuery orderByConfigSys($order = Criteria::ASC) Order by the __config__ column
 * @method     ChildBooksQuery orderBySplit($order = Criteria::ASC) Order by the __split__ column
 * @method     ChildBooksQuery orderByParentnode($order = Criteria::ASC) Order by the __parentnode__ column
 * @method     ChildBooksQuery orderBySort($order = Criteria::ASC) Order by the __sort__ column
 *
 * @method     ChildBooksQuery groupById() Group by the id column
 * @method     ChildBooksQuery groupByName() Group by the _name column
 * @method     ChildBooksQuery groupByUserSys() Group by the __user__ column
 * @method     ChildBooksQuery groupByConfigSys() Group by the __config__ column
 * @method     ChildBooksQuery groupBySplit() Group by the __split__ column
 * @method     ChildBooksQuery groupByParentnode() Group by the __parentnode__ column
 * @method     ChildBooksQuery groupBySort() Group by the __sort__ column
 *
 * @method     ChildBooksQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBooksQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBooksQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBooksQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildBooksQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildBooksQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildBooksQuery leftJoinuserSysRef($relationAlias = null) Adds a LEFT JOIN clause to the query using the userSysRef relation
 * @method     ChildBooksQuery rightJoinuserSysRef($relationAlias = null) Adds a RIGHT JOIN clause to the query using the userSysRef relation
 * @method     ChildBooksQuery innerJoinuserSysRef($relationAlias = null) Adds a INNER JOIN clause to the query using the userSysRef relation
 *
 * @method     ChildBooksQuery joinWithuserSysRef($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the userSysRef relation
 *
 * @method     ChildBooksQuery leftJoinWithuserSysRef() Adds a LEFT JOIN clause and with to the query using the userSysRef relation
 * @method     ChildBooksQuery rightJoinWithuserSysRef() Adds a RIGHT JOIN clause and with to the query using the userSysRef relation
 * @method     ChildBooksQuery innerJoinWithuserSysRef() Adds a INNER JOIN clause and with to the query using the userSysRef relation
 *
 * @method     ChildBooksQuery leftJoinRBatchForbook($relationAlias = null) Adds a LEFT JOIN clause to the query using the RBatchForbook relation
 * @method     ChildBooksQuery rightJoinRBatchForbook($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RBatchForbook relation
 * @method     ChildBooksQuery innerJoinRBatchForbook($relationAlias = null) Adds a INNER JOIN clause to the query using the RBatchForbook relation
 *
 * @method     ChildBooksQuery joinWithRBatchForbook($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RBatchForbook relation
 *
 * @method     ChildBooksQuery leftJoinWithRBatchForbook() Adds a LEFT JOIN clause and with to the query using the RBatchForbook relation
 * @method     ChildBooksQuery rightJoinWithRBatchForbook() Adds a RIGHT JOIN clause and with to the query using the RBatchForbook relation
 * @method     ChildBooksQuery innerJoinWithRBatchForbook() Adds a INNER JOIN clause and with to the query using the RBatchForbook relation
 *
 * @method     ChildBooksQuery leftJoinRRightsForbook($relationAlias = null) Adds a LEFT JOIN clause to the query using the RRightsForbook relation
 * @method     ChildBooksQuery rightJoinRRightsForbook($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RRightsForbook relation
 * @method     ChildBooksQuery innerJoinRRightsForbook($relationAlias = null) Adds a INNER JOIN clause to the query using the RRightsForbook relation
 *
 * @method     ChildBooksQuery joinWithRRightsForbook($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RRightsForbook relation
 *
 * @method     ChildBooksQuery leftJoinWithRRightsForbook() Adds a LEFT JOIN clause and with to the query using the RRightsForbook relation
 * @method     ChildBooksQuery rightJoinWithRRightsForbook() Adds a RIGHT JOIN clause and with to the query using the RRightsForbook relation
 * @method     ChildBooksQuery innerJoinWithRRightsForbook() Adds a INNER JOIN clause and with to the query using the RRightsForbook relation
 *
 * @method     ChildBooksQuery leftJoinRTemplatenamesForbook($relationAlias = null) Adds a LEFT JOIN clause to the query using the RTemplatenamesForbook relation
 * @method     ChildBooksQuery rightJoinRTemplatenamesForbook($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RTemplatenamesForbook relation
 * @method     ChildBooksQuery innerJoinRTemplatenamesForbook($relationAlias = null) Adds a INNER JOIN clause to the query using the RTemplatenamesForbook relation
 *
 * @method     ChildBooksQuery joinWithRTemplatenamesForbook($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RTemplatenamesForbook relation
 *
 * @method     ChildBooksQuery leftJoinWithRTemplatenamesForbook() Adds a LEFT JOIN clause and with to the query using the RTemplatenamesForbook relation
 * @method     ChildBooksQuery rightJoinWithRTemplatenamesForbook() Adds a RIGHT JOIN clause and with to the query using the RTemplatenamesForbook relation
 * @method     ChildBooksQuery innerJoinWithRTemplatenamesForbook() Adds a INNER JOIN clause and with to the query using the RTemplatenamesForbook relation
 *
 * @method     ChildBooksQuery leftJoinRDataBook($relationAlias = null) Adds a LEFT JOIN clause to the query using the RDataBook relation
 * @method     ChildBooksQuery rightJoinRDataBook($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RDataBook relation
 * @method     ChildBooksQuery innerJoinRDataBook($relationAlias = null) Adds a INNER JOIN clause to the query using the RDataBook relation
 *
 * @method     ChildBooksQuery joinWithRDataBook($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RDataBook relation
 *
 * @method     ChildBooksQuery leftJoinWithRDataBook() Adds a LEFT JOIN clause and with to the query using the RDataBook relation
 * @method     ChildBooksQuery rightJoinWithRDataBook() Adds a RIGHT JOIN clause and with to the query using the RDataBook relation
 * @method     ChildBooksQuery innerJoinWithRDataBook() Adds a INNER JOIN clause and with to the query using the RDataBook relation
 *
 * @method     ChildBooksQuery leftJoinRPluginBook($relationAlias = null) Adds a LEFT JOIN clause to the query using the RPluginBook relation
 * @method     ChildBooksQuery rightJoinRPluginBook($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RPluginBook relation
 * @method     ChildBooksQuery innerJoinRPluginBook($relationAlias = null) Adds a INNER JOIN clause to the query using the RPluginBook relation
 *
 * @method     ChildBooksQuery joinWithRPluginBook($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RPluginBook relation
 *
 * @method     ChildBooksQuery leftJoinWithRPluginBook() Adds a LEFT JOIN clause and with to the query using the RPluginBook relation
 * @method     ChildBooksQuery rightJoinWithRPluginBook() Adds a RIGHT JOIN clause and with to the query using the RPluginBook relation
 * @method     ChildBooksQuery innerJoinWithRPluginBook() Adds a INNER JOIN clause and with to the query using the RPluginBook relation
 *
 * @method     ChildBooksQuery leftJoinFormats($relationAlias = null) Adds a LEFT JOIN clause to the query using the Formats relation
 * @method     ChildBooksQuery rightJoinFormats($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Formats relation
 * @method     ChildBooksQuery innerJoinFormats($relationAlias = null) Adds a INNER JOIN clause to the query using the Formats relation
 *
 * @method     ChildBooksQuery joinWithFormats($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Formats relation
 *
 * @method     ChildBooksQuery leftJoinWithFormats() Adds a LEFT JOIN clause and with to the query using the Formats relation
 * @method     ChildBooksQuery rightJoinWithFormats() Adds a RIGHT JOIN clause and with to the query using the Formats relation
 * @method     ChildBooksQuery innerJoinWithFormats() Adds a INNER JOIN clause and with to the query using the Formats relation
 *
 * @method     ChildBooksQuery leftJoinIssues($relationAlias = null) Adds a LEFT JOIN clause to the query using the Issues relation
 * @method     ChildBooksQuery rightJoinIssues($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Issues relation
 * @method     ChildBooksQuery innerJoinIssues($relationAlias = null) Adds a INNER JOIN clause to the query using the Issues relation
 *
 * @method     ChildBooksQuery joinWithIssues($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Issues relation
 *
 * @method     ChildBooksQuery leftJoinWithIssues() Adds a LEFT JOIN clause and with to the query using the Issues relation
 * @method     ChildBooksQuery rightJoinWithIssues() Adds a RIGHT JOIN clause and with to the query using the Issues relation
 * @method     ChildBooksQuery innerJoinWithIssues() Adds a INNER JOIN clause and with to the query using the Issues relation
 *
 * @method     \UsersQuery|\RBatchForbookQuery|\RRightsForbookQuery|\RTemplatenamesForbookQuery|\RDataBookQuery|\RPluginBookQuery|\FormatsQuery|\IssuesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildBooks findOne(ConnectionInterface $con = null) Return the first ChildBooks matching the query
 * @method     ChildBooks findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBooks matching the query, or a new ChildBooks object populated from the query conditions when no match is found
 *
 * @method     ChildBooks findOneById(int $id) Return the first ChildBooks filtered by the id column
 * @method     ChildBooks findOneByName(string $_name) Return the first ChildBooks filtered by the _name column
 * @method     ChildBooks findOneByUserSys(int $__user__) Return the first ChildBooks filtered by the __user__ column
 * @method     ChildBooks findOneByConfigSys(string $__config__) Return the first ChildBooks filtered by the __config__ column
 * @method     ChildBooks findOneBySplit(string $__split__) Return the first ChildBooks filtered by the __split__ column
 * @method     ChildBooks findOneByParentnode(int $__parentnode__) Return the first ChildBooks filtered by the __parentnode__ column
 * @method     ChildBooks findOneBySort(int $__sort__) Return the first ChildBooks filtered by the __sort__ column *

 * @method     ChildBooks requirePk($key, ConnectionInterface $con = null) Return the ChildBooks by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBooks requireOne(ConnectionInterface $con = null) Return the first ChildBooks matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBooks requireOneById(int $id) Return the first ChildBooks filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBooks requireOneByName(string $_name) Return the first ChildBooks filtered by the _name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBooks requireOneByUserSys(int $__user__) Return the first ChildBooks filtered by the __user__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBooks requireOneByConfigSys(string $__config__) Return the first ChildBooks filtered by the __config__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBooks requireOneBySplit(string $__split__) Return the first ChildBooks filtered by the __split__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBooks requireOneByParentnode(int $__parentnode__) Return the first ChildBooks filtered by the __parentnode__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBooks requireOneBySort(int $__sort__) Return the first ChildBooks filtered by the __sort__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBooks[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildBooks objects based on current ModelCriteria
 * @method     ChildBooks[]|ObjectCollection findById(int $id) Return ChildBooks objects filtered by the id column
 * @method     ChildBooks[]|ObjectCollection findByName(string $_name) Return ChildBooks objects filtered by the _name column
 * @method     ChildBooks[]|ObjectCollection findByUserSys(int $__user__) Return ChildBooks objects filtered by the __user__ column
 * @method     ChildBooks[]|ObjectCollection findByConfigSys(string $__config__) Return ChildBooks objects filtered by the __config__ column
 * @method     ChildBooks[]|ObjectCollection findBySplit(string $__split__) Return ChildBooks objects filtered by the __split__ column
 * @method     ChildBooks[]|ObjectCollection findByParentnode(int $__parentnode__) Return ChildBooks objects filtered by the __parentnode__ column
 * @method     ChildBooks[]|ObjectCollection findBySort(int $__sort__) Return ChildBooks objects filtered by the __sort__ column
 * @method     ChildBooks[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class BooksQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\BooksQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\Books', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBooksQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBooksQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildBooksQuery) {
            return $criteria;
        }
        $query = new ChildBooksQuery();
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
     * @return ChildBooks|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BooksTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = BooksTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildBooks A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, _name, __user__, __config__, __split__, __parentnode__, __sort__ FROM _books WHERE id = :p0';
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
            /** @var ChildBooks $obj */
            $obj = new ChildBooks();
            $obj->hydrate($row);
            BooksTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildBooks|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildBooksQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BooksTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildBooksQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BooksTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildBooksQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(BooksTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(BooksTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BooksTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the _name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE _name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE _name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBooksQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BooksTableMap::COL__NAME, $name, $comparison);
    }

    /**
     * Filter the query on the __user__ column
     *
     * Example usage:
     * <code>
     * $query->filterByUserSys(1234); // WHERE __user__ = 1234
     * $query->filterByUserSys(array(12, 34)); // WHERE __user__ IN (12, 34)
     * $query->filterByUserSys(array('min' => 12)); // WHERE __user__ > 12
     * </code>
     *
     * @see       filterByuserSysRef()
     *
     * @param     mixed $userSys The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBooksQuery The current query, for fluid interface
     */
    public function filterByUserSys($userSys = null, $comparison = null)
    {
        if (is_array($userSys)) {
            $useMinMax = false;
            if (isset($userSys['min'])) {
                $this->addUsingAlias(BooksTableMap::COL___USER__, $userSys['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userSys['max'])) {
                $this->addUsingAlias(BooksTableMap::COL___USER__, $userSys['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BooksTableMap::COL___USER__, $userSys, $comparison);
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
     * @return $this|ChildBooksQuery The current query, for fluid interface
     */
    public function filterByConfigSys($configSys = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($configSys)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BooksTableMap::COL___CONFIG__, $configSys, $comparison);
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
     * @return $this|ChildBooksQuery The current query, for fluid interface
     */
    public function filterBySplit($split = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($split)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BooksTableMap::COL___SPLIT__, $split, $comparison);
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
     * @return $this|ChildBooksQuery The current query, for fluid interface
     */
    public function filterByParentnode($parentnode = null, $comparison = null)
    {
        if (is_array($parentnode)) {
            $useMinMax = false;
            if (isset($parentnode['min'])) {
                $this->addUsingAlias(BooksTableMap::COL___PARENTNODE__, $parentnode['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentnode['max'])) {
                $this->addUsingAlias(BooksTableMap::COL___PARENTNODE__, $parentnode['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BooksTableMap::COL___PARENTNODE__, $parentnode, $comparison);
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
     * @return $this|ChildBooksQuery The current query, for fluid interface
     */
    public function filterBySort($sort = null, $comparison = null)
    {
        if (is_array($sort)) {
            $useMinMax = false;
            if (isset($sort['min'])) {
                $this->addUsingAlias(BooksTableMap::COL___SORT__, $sort['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sort['max'])) {
                $this->addUsingAlias(BooksTableMap::COL___SORT__, $sort['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BooksTableMap::COL___SORT__, $sort, $comparison);
    }

    /**
     * Filter the query by a related \Users object
     *
     * @param \Users|ObjectCollection $users The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildBooksQuery The current query, for fluid interface
     */
    public function filterByuserSysRef($users, $comparison = null)
    {
        if ($users instanceof \Users) {
            return $this
                ->addUsingAlias(BooksTableMap::COL___USER__, $users->getId(), $comparison);
        } elseif ($users instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BooksTableMap::COL___USER__, $users->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByuserSysRef() only accepts arguments of type \Users or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the userSysRef relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBooksQuery The current query, for fluid interface
     */
    public function joinuserSysRef($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('userSysRef');

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
            $this->addJoinObject($join, 'userSysRef');
        }

        return $this;
    }

    /**
     * Use the userSysRef relation Users object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UsersQuery A secondary query class using the current class as primary query
     */
    public function useuserSysRefQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinuserSysRef($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'userSysRef', '\UsersQuery');
    }

    /**
     * Filter the query by a related \RBatchForbook object
     *
     * @param \RBatchForbook|ObjectCollection $rBatchForbook the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBooksQuery The current query, for fluid interface
     */
    public function filterByRBatchForbook($rBatchForbook, $comparison = null)
    {
        if ($rBatchForbook instanceof \RBatchForbook) {
            return $this
                ->addUsingAlias(BooksTableMap::COL_ID, $rBatchForbook->getBookid(), $comparison);
        } elseif ($rBatchForbook instanceof ObjectCollection) {
            return $this
                ->useRBatchForbookQuery()
                ->filterByPrimaryKeys($rBatchForbook->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRBatchForbook() only accepts arguments of type \RBatchForbook or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RBatchForbook relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBooksQuery The current query, for fluid interface
     */
    public function joinRBatchForbook($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RBatchForbook');

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
            $this->addJoinObject($join, 'RBatchForbook');
        }

        return $this;
    }

    /**
     * Use the RBatchForbook relation RBatchForbook object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RBatchForbookQuery A secondary query class using the current class as primary query
     */
    public function useRBatchForbookQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRBatchForbook($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RBatchForbook', '\RBatchForbookQuery');
    }

    /**
     * Filter the query by a related \RRightsForbook object
     *
     * @param \RRightsForbook|ObjectCollection $rRightsForbook the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBooksQuery The current query, for fluid interface
     */
    public function filterByRRightsForbook($rRightsForbook, $comparison = null)
    {
        if ($rRightsForbook instanceof \RRightsForbook) {
            return $this
                ->addUsingAlias(BooksTableMap::COL_ID, $rRightsForbook->getBookid(), $comparison);
        } elseif ($rRightsForbook instanceof ObjectCollection) {
            return $this
                ->useRRightsForbookQuery()
                ->filterByPrimaryKeys($rRightsForbook->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRRightsForbook() only accepts arguments of type \RRightsForbook or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RRightsForbook relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBooksQuery The current query, for fluid interface
     */
    public function joinRRightsForbook($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RRightsForbook');

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
            $this->addJoinObject($join, 'RRightsForbook');
        }

        return $this;
    }

    /**
     * Use the RRightsForbook relation RRightsForbook object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RRightsForbookQuery A secondary query class using the current class as primary query
     */
    public function useRRightsForbookQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRRightsForbook($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RRightsForbook', '\RRightsForbookQuery');
    }

    /**
     * Filter the query by a related \RTemplatenamesForbook object
     *
     * @param \RTemplatenamesForbook|ObjectCollection $rTemplatenamesForbook the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBooksQuery The current query, for fluid interface
     */
    public function filterByRTemplatenamesForbook($rTemplatenamesForbook, $comparison = null)
    {
        if ($rTemplatenamesForbook instanceof \RTemplatenamesForbook) {
            return $this
                ->addUsingAlias(BooksTableMap::COL_ID, $rTemplatenamesForbook->getBookid(), $comparison);
        } elseif ($rTemplatenamesForbook instanceof ObjectCollection) {
            return $this
                ->useRTemplatenamesForbookQuery()
                ->filterByPrimaryKeys($rTemplatenamesForbook->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRTemplatenamesForbook() only accepts arguments of type \RTemplatenamesForbook or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RTemplatenamesForbook relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBooksQuery The current query, for fluid interface
     */
    public function joinRTemplatenamesForbook($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RTemplatenamesForbook');

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
            $this->addJoinObject($join, 'RTemplatenamesForbook');
        }

        return $this;
    }

    /**
     * Use the RTemplatenamesForbook relation RTemplatenamesForbook object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RTemplatenamesForbookQuery A secondary query class using the current class as primary query
     */
    public function useRTemplatenamesForbookQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRTemplatenamesForbook($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RTemplatenamesForbook', '\RTemplatenamesForbookQuery');
    }

    /**
     * Filter the query by a related \RDataBook object
     *
     * @param \RDataBook|ObjectCollection $rDataBook the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBooksQuery The current query, for fluid interface
     */
    public function filterByRDataBook($rDataBook, $comparison = null)
    {
        if ($rDataBook instanceof \RDataBook) {
            return $this
                ->addUsingAlias(BooksTableMap::COL_ID, $rDataBook->getBookid(), $comparison);
        } elseif ($rDataBook instanceof ObjectCollection) {
            return $this
                ->useRDataBookQuery()
                ->filterByPrimaryKeys($rDataBook->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRDataBook() only accepts arguments of type \RDataBook or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RDataBook relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBooksQuery The current query, for fluid interface
     */
    public function joinRDataBook($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RDataBook');

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
            $this->addJoinObject($join, 'RDataBook');
        }

        return $this;
    }

    /**
     * Use the RDataBook relation RDataBook object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RDataBookQuery A secondary query class using the current class as primary query
     */
    public function useRDataBookQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRDataBook($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RDataBook', '\RDataBookQuery');
    }

    /**
     * Filter the query by a related \RPluginBook object
     *
     * @param \RPluginBook|ObjectCollection $rPluginBook the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBooksQuery The current query, for fluid interface
     */
    public function filterByRPluginBook($rPluginBook, $comparison = null)
    {
        if ($rPluginBook instanceof \RPluginBook) {
            return $this
                ->addUsingAlias(BooksTableMap::COL_ID, $rPluginBook->getBookid(), $comparison);
        } elseif ($rPluginBook instanceof ObjectCollection) {
            return $this
                ->useRPluginBookQuery()
                ->filterByPrimaryKeys($rPluginBook->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRPluginBook() only accepts arguments of type \RPluginBook or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RPluginBook relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBooksQuery The current query, for fluid interface
     */
    public function joinRPluginBook($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RPluginBook');

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
            $this->addJoinObject($join, 'RPluginBook');
        }

        return $this;
    }

    /**
     * Use the RPluginBook relation RPluginBook object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RPluginBookQuery A secondary query class using the current class as primary query
     */
    public function useRPluginBookQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRPluginBook($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RPluginBook', '\RPluginBookQuery');
    }

    /**
     * Filter the query by a related \Formats object
     *
     * @param \Formats|ObjectCollection $formats the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBooksQuery The current query, for fluid interface
     */
    public function filterByFormats($formats, $comparison = null)
    {
        if ($formats instanceof \Formats) {
            return $this
                ->addUsingAlias(BooksTableMap::COL_ID, $formats->getForbook(), $comparison);
        } elseif ($formats instanceof ObjectCollection) {
            return $this
                ->useFormatsQuery()
                ->filterByPrimaryKeys($formats->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildBooksQuery The current query, for fluid interface
     */
    public function joinFormats($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useFormatsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinFormats($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Formats', '\FormatsQuery');
    }

    /**
     * Filter the query by a related \Issues object
     *
     * @param \Issues|ObjectCollection $issues the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBooksQuery The current query, for fluid interface
     */
    public function filterByIssues($issues, $comparison = null)
    {
        if ($issues instanceof \Issues) {
            return $this
                ->addUsingAlias(BooksTableMap::COL_ID, $issues->getForbook(), $comparison);
        } elseif ($issues instanceof ObjectCollection) {
            return $this
                ->useIssuesQuery()
                ->filterByPrimaryKeys($issues->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByIssues() only accepts arguments of type \Issues or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Issues relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildBooksQuery The current query, for fluid interface
     */
    public function joinIssues($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Issues');

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
            $this->addJoinObject($join, 'Issues');
        }

        return $this;
    }

    /**
     * Use the Issues relation Issues object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \IssuesQuery A secondary query class using the current class as primary query
     */
    public function useIssuesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinIssues($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Issues', '\IssuesQuery');
    }

    /**
     * Filter the query by a related Batch object
     * using the R_batch_forbook table as cross reference
     *
     * @param Batch $batch the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBooksQuery The current query, for fluid interface
     */
    public function filterByBatch($batch, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRBatchForbookQuery()
            ->filterByBatch($batch, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Rights object
     * using the R_rights_forbook table as cross reference
     *
     * @param Rights $rights the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBooksQuery The current query, for fluid interface
     */
    public function filterByRights($rights, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRRightsForbookQuery()
            ->filterByRights($rights, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Templatenames object
     * using the R_templatenames_forbook table as cross reference
     *
     * @param Templatenames $templatenames the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBooksQuery The current query, for fluid interface
     */
    public function filterByTemplatenames($templatenames, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRTemplatenamesForbookQuery()
            ->filterByTemplatenames($templatenames, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Data object
     * using the R_data_book table as cross reference
     *
     * @param Data $data the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBooksQuery The current query, for fluid interface
     */
    public function filterByRData($data, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRDataBookQuery()
            ->filterByRData($data, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Plugins object
     * using the R_plugin_book table as cross reference
     *
     * @param Plugins $plugins the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBooksQuery The current query, for fluid interface
     */
    public function filterByRPlugin($plugins, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRPluginBookQuery()
            ->filterByRPlugin($plugins, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildBooks $books Object to remove from the list of results
     *
     * @return $this|ChildBooksQuery The current query, for fluid interface
     */
    public function prune($books = null)
    {
        if ($books) {
            $this->addUsingAlias(BooksTableMap::COL_ID, $books->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the _books table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BooksTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BooksTableMap::clearInstancePool();
            BooksTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(BooksTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BooksTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            BooksTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            BooksTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // BooksQuery
