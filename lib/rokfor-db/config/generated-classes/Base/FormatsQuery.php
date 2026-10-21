<?php

namespace Base;

use \Formats as ChildFormats;
use \FormatsQuery as ChildFormatsQuery;
use \Exception;
use \PDO;
use Map\FormatsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the '_formats' table.
 *
 *
 *
 * @method     ChildFormatsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildFormatsQuery orderByName($order = Criteria::ASC) Order by the _name column
 * @method     ChildFormatsQuery orderByForbook($order = Criteria::ASC) Order by the _forbook column
 * @method     ChildFormatsQuery orderByUserSys($order = Criteria::ASC) Order by the __user__ column
 * @method     ChildFormatsQuery orderByConfigSys($order = Criteria::ASC) Order by the __config__ column
 * @method     ChildFormatsQuery orderBySplit($order = Criteria::ASC) Order by the __split__ column
 * @method     ChildFormatsQuery orderBySort($order = Criteria::ASC) Order by the __sort__ column
 * @method     ChildFormatsQuery orderByParentnode($order = Criteria::ASC) Order by the __parentnode__ column
 *
 * @method     ChildFormatsQuery groupById() Group by the id column
 * @method     ChildFormatsQuery groupByName() Group by the _name column
 * @method     ChildFormatsQuery groupByForbook() Group by the _forbook column
 * @method     ChildFormatsQuery groupByUserSys() Group by the __user__ column
 * @method     ChildFormatsQuery groupByConfigSys() Group by the __config__ column
 * @method     ChildFormatsQuery groupBySplit() Group by the __split__ column
 * @method     ChildFormatsQuery groupBySort() Group by the __sort__ column
 * @method     ChildFormatsQuery groupByParentnode() Group by the __parentnode__ column
 *
 * @method     ChildFormatsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildFormatsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildFormatsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildFormatsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildFormatsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildFormatsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildFormatsQuery leftJoinuserSysRef($relationAlias = null) Adds a LEFT JOIN clause to the query using the userSysRef relation
 * @method     ChildFormatsQuery rightJoinuserSysRef($relationAlias = null) Adds a RIGHT JOIN clause to the query using the userSysRef relation
 * @method     ChildFormatsQuery innerJoinuserSysRef($relationAlias = null) Adds a INNER JOIN clause to the query using the userSysRef relation
 *
 * @method     ChildFormatsQuery joinWithuserSysRef($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the userSysRef relation
 *
 * @method     ChildFormatsQuery leftJoinWithuserSysRef() Adds a LEFT JOIN clause and with to the query using the userSysRef relation
 * @method     ChildFormatsQuery rightJoinWithuserSysRef() Adds a RIGHT JOIN clause and with to the query using the userSysRef relation
 * @method     ChildFormatsQuery innerJoinWithuserSysRef() Adds a INNER JOIN clause and with to the query using the userSysRef relation
 *
 * @method     ChildFormatsQuery leftJoinBooks($relationAlias = null) Adds a LEFT JOIN clause to the query using the Books relation
 * @method     ChildFormatsQuery rightJoinBooks($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Books relation
 * @method     ChildFormatsQuery innerJoinBooks($relationAlias = null) Adds a INNER JOIN clause to the query using the Books relation
 *
 * @method     ChildFormatsQuery joinWithBooks($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Books relation
 *
 * @method     ChildFormatsQuery leftJoinWithBooks() Adds a LEFT JOIN clause and with to the query using the Books relation
 * @method     ChildFormatsQuery rightJoinWithBooks() Adds a RIGHT JOIN clause and with to the query using the Books relation
 * @method     ChildFormatsQuery innerJoinWithBooks() Adds a INNER JOIN clause and with to the query using the Books relation
 *
 * @method     ChildFormatsQuery leftJoinRRightsForformat($relationAlias = null) Adds a LEFT JOIN clause to the query using the RRightsForformat relation
 * @method     ChildFormatsQuery rightJoinRRightsForformat($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RRightsForformat relation
 * @method     ChildFormatsQuery innerJoinRRightsForformat($relationAlias = null) Adds a INNER JOIN clause to the query using the RRightsForformat relation
 *
 * @method     ChildFormatsQuery joinWithRRightsForformat($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RRightsForformat relation
 *
 * @method     ChildFormatsQuery leftJoinWithRRightsForformat() Adds a LEFT JOIN clause and with to the query using the RRightsForformat relation
 * @method     ChildFormatsQuery rightJoinWithRRightsForformat() Adds a RIGHT JOIN clause and with to the query using the RRightsForformat relation
 * @method     ChildFormatsQuery innerJoinWithRRightsForformat() Adds a INNER JOIN clause and with to the query using the RRightsForformat relation
 *
 * @method     ChildFormatsQuery leftJoinRTemplatenamesInchapter($relationAlias = null) Adds a LEFT JOIN clause to the query using the RTemplatenamesInchapter relation
 * @method     ChildFormatsQuery rightJoinRTemplatenamesInchapter($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RTemplatenamesInchapter relation
 * @method     ChildFormatsQuery innerJoinRTemplatenamesInchapter($relationAlias = null) Adds a INNER JOIN clause to the query using the RTemplatenamesInchapter relation
 *
 * @method     ChildFormatsQuery joinWithRTemplatenamesInchapter($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RTemplatenamesInchapter relation
 *
 * @method     ChildFormatsQuery leftJoinWithRTemplatenamesInchapter() Adds a LEFT JOIN clause and with to the query using the RTemplatenamesInchapter relation
 * @method     ChildFormatsQuery rightJoinWithRTemplatenamesInchapter() Adds a RIGHT JOIN clause and with to the query using the RTemplatenamesInchapter relation
 * @method     ChildFormatsQuery innerJoinWithRTemplatenamesInchapter() Adds a INNER JOIN clause and with to the query using the RTemplatenamesInchapter relation
 *
 * @method     ChildFormatsQuery leftJoinContributions($relationAlias = null) Adds a LEFT JOIN clause to the query using the Contributions relation
 * @method     ChildFormatsQuery rightJoinContributions($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Contributions relation
 * @method     ChildFormatsQuery innerJoinContributions($relationAlias = null) Adds a INNER JOIN clause to the query using the Contributions relation
 *
 * @method     ChildFormatsQuery joinWithContributions($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Contributions relation
 *
 * @method     ChildFormatsQuery leftJoinWithContributions() Adds a LEFT JOIN clause and with to the query using the Contributions relation
 * @method     ChildFormatsQuery rightJoinWithContributions() Adds a RIGHT JOIN clause and with to the query using the Contributions relation
 * @method     ChildFormatsQuery innerJoinWithContributions() Adds a INNER JOIN clause and with to the query using the Contributions relation
 *
 * @method     ChildFormatsQuery leftJoinRDataFormat($relationAlias = null) Adds a LEFT JOIN clause to the query using the RDataFormat relation
 * @method     ChildFormatsQuery rightJoinRDataFormat($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RDataFormat relation
 * @method     ChildFormatsQuery innerJoinRDataFormat($relationAlias = null) Adds a INNER JOIN clause to the query using the RDataFormat relation
 *
 * @method     ChildFormatsQuery joinWithRDataFormat($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RDataFormat relation
 *
 * @method     ChildFormatsQuery leftJoinWithRDataFormat() Adds a LEFT JOIN clause and with to the query using the RDataFormat relation
 * @method     ChildFormatsQuery rightJoinWithRDataFormat() Adds a RIGHT JOIN clause and with to the query using the RDataFormat relation
 * @method     ChildFormatsQuery innerJoinWithRDataFormat() Adds a INNER JOIN clause and with to the query using the RDataFormat relation
 *
 * @method     ChildFormatsQuery leftJoinRPluginFormat($relationAlias = null) Adds a LEFT JOIN clause to the query using the RPluginFormat relation
 * @method     ChildFormatsQuery rightJoinRPluginFormat($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RPluginFormat relation
 * @method     ChildFormatsQuery innerJoinRPluginFormat($relationAlias = null) Adds a INNER JOIN clause to the query using the RPluginFormat relation
 *
 * @method     ChildFormatsQuery joinWithRPluginFormat($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RPluginFormat relation
 *
 * @method     ChildFormatsQuery leftJoinWithRPluginFormat() Adds a LEFT JOIN clause and with to the query using the RPluginFormat relation
 * @method     ChildFormatsQuery rightJoinWithRPluginFormat() Adds a RIGHT JOIN clause and with to the query using the RPluginFormat relation
 * @method     ChildFormatsQuery innerJoinWithRPluginFormat() Adds a INNER JOIN clause and with to the query using the RPluginFormat relation
 *
 * @method     \UsersQuery|\BooksQuery|\RRightsForformatQuery|\RTemplatenamesInchapterQuery|\ContributionsQuery|\RDataFormatQuery|\RPluginFormatQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildFormats findOne(ConnectionInterface $con = null) Return the first ChildFormats matching the query
 * @method     ChildFormats findOneOrCreate(ConnectionInterface $con = null) Return the first ChildFormats matching the query, or a new ChildFormats object populated from the query conditions when no match is found
 *
 * @method     ChildFormats findOneById(int $id) Return the first ChildFormats filtered by the id column
 * @method     ChildFormats findOneByName(string $_name) Return the first ChildFormats filtered by the _name column
 * @method     ChildFormats findOneByForbook(int $_forbook) Return the first ChildFormats filtered by the _forbook column
 * @method     ChildFormats findOneByUserSys(int $__user__) Return the first ChildFormats filtered by the __user__ column
 * @method     ChildFormats findOneByConfigSys(string $__config__) Return the first ChildFormats filtered by the __config__ column
 * @method     ChildFormats findOneBySplit(string $__split__) Return the first ChildFormats filtered by the __split__ column
 * @method     ChildFormats findOneBySort(int $__sort__) Return the first ChildFormats filtered by the __sort__ column
 * @method     ChildFormats findOneByParentnode(int $__parentnode__) Return the first ChildFormats filtered by the __parentnode__ column *

 * @method     ChildFormats requirePk($key, ConnectionInterface $con = null) Return the ChildFormats by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFormats requireOne(ConnectionInterface $con = null) Return the first ChildFormats matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFormats requireOneById(int $id) Return the first ChildFormats filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFormats requireOneByName(string $_name) Return the first ChildFormats filtered by the _name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFormats requireOneByForbook(int $_forbook) Return the first ChildFormats filtered by the _forbook column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFormats requireOneByUserSys(int $__user__) Return the first ChildFormats filtered by the __user__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFormats requireOneByConfigSys(string $__config__) Return the first ChildFormats filtered by the __config__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFormats requireOneBySplit(string $__split__) Return the first ChildFormats filtered by the __split__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFormats requireOneBySort(int $__sort__) Return the first ChildFormats filtered by the __sort__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFormats requireOneByParentnode(int $__parentnode__) Return the first ChildFormats filtered by the __parentnode__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFormats[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildFormats objects based on current ModelCriteria
 * @method     ChildFormats[]|ObjectCollection findById(int $id) Return ChildFormats objects filtered by the id column
 * @method     ChildFormats[]|ObjectCollection findByName(string $_name) Return ChildFormats objects filtered by the _name column
 * @method     ChildFormats[]|ObjectCollection findByForbook(int $_forbook) Return ChildFormats objects filtered by the _forbook column
 * @method     ChildFormats[]|ObjectCollection findByUserSys(int $__user__) Return ChildFormats objects filtered by the __user__ column
 * @method     ChildFormats[]|ObjectCollection findByConfigSys(string $__config__) Return ChildFormats objects filtered by the __config__ column
 * @method     ChildFormats[]|ObjectCollection findBySplit(string $__split__) Return ChildFormats objects filtered by the __split__ column
 * @method     ChildFormats[]|ObjectCollection findBySort(int $__sort__) Return ChildFormats objects filtered by the __sort__ column
 * @method     ChildFormats[]|ObjectCollection findByParentnode(int $__parentnode__) Return ChildFormats objects filtered by the __parentnode__ column
 * @method     ChildFormats[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class FormatsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\FormatsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\Formats', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildFormatsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildFormatsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildFormatsQuery) {
            return $criteria;
        }
        $query = new ChildFormatsQuery();
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
     * @return ChildFormats|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FormatsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = FormatsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildFormats A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, _name, _forbook, __user__, __config__, __split__, __sort__, __parentnode__ FROM _formats WHERE id = :p0';
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
            /** @var ChildFormats $obj */
            $obj = new ChildFormats();
            $obj->hydrate($row);
            FormatsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildFormats|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildFormatsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FormatsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildFormatsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FormatsTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildFormatsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(FormatsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(FormatsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FormatsTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildFormatsQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FormatsTableMap::COL__NAME, $name, $comparison);
    }

    /**
     * Filter the query on the _forbook column
     *
     * Example usage:
     * <code>
     * $query->filterByForbook(1234); // WHERE _forbook = 1234
     * $query->filterByForbook(array(12, 34)); // WHERE _forbook IN (12, 34)
     * $query->filterByForbook(array('min' => 12)); // WHERE _forbook > 12
     * </code>
     *
     * @see       filterByBooks()
     *
     * @param     mixed $forbook The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFormatsQuery The current query, for fluid interface
     */
    public function filterByForbook($forbook = null, $comparison = null)
    {
        if (is_array($forbook)) {
            $useMinMax = false;
            if (isset($forbook['min'])) {
                $this->addUsingAlias(FormatsTableMap::COL__FORBOOK, $forbook['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($forbook['max'])) {
                $this->addUsingAlias(FormatsTableMap::COL__FORBOOK, $forbook['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FormatsTableMap::COL__FORBOOK, $forbook, $comparison);
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
     * @return $this|ChildFormatsQuery The current query, for fluid interface
     */
    public function filterByUserSys($userSys = null, $comparison = null)
    {
        if (is_array($userSys)) {
            $useMinMax = false;
            if (isset($userSys['min'])) {
                $this->addUsingAlias(FormatsTableMap::COL___USER__, $userSys['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userSys['max'])) {
                $this->addUsingAlias(FormatsTableMap::COL___USER__, $userSys['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FormatsTableMap::COL___USER__, $userSys, $comparison);
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
     * @return $this|ChildFormatsQuery The current query, for fluid interface
     */
    public function filterByConfigSys($configSys = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($configSys)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FormatsTableMap::COL___CONFIG__, $configSys, $comparison);
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
     * @return $this|ChildFormatsQuery The current query, for fluid interface
     */
    public function filterBySplit($split = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($split)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FormatsTableMap::COL___SPLIT__, $split, $comparison);
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
     * @return $this|ChildFormatsQuery The current query, for fluid interface
     */
    public function filterBySort($sort = null, $comparison = null)
    {
        if (is_array($sort)) {
            $useMinMax = false;
            if (isset($sort['min'])) {
                $this->addUsingAlias(FormatsTableMap::COL___SORT__, $sort['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sort['max'])) {
                $this->addUsingAlias(FormatsTableMap::COL___SORT__, $sort['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FormatsTableMap::COL___SORT__, $sort, $comparison);
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
     * @return $this|ChildFormatsQuery The current query, for fluid interface
     */
    public function filterByParentnode($parentnode = null, $comparison = null)
    {
        if (is_array($parentnode)) {
            $useMinMax = false;
            if (isset($parentnode['min'])) {
                $this->addUsingAlias(FormatsTableMap::COL___PARENTNODE__, $parentnode['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentnode['max'])) {
                $this->addUsingAlias(FormatsTableMap::COL___PARENTNODE__, $parentnode['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FormatsTableMap::COL___PARENTNODE__, $parentnode, $comparison);
    }

    /**
     * Filter the query by a related \Users object
     *
     * @param \Users|ObjectCollection $users The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildFormatsQuery The current query, for fluid interface
     */
    public function filterByuserSysRef($users, $comparison = null)
    {
        if ($users instanceof \Users) {
            return $this
                ->addUsingAlias(FormatsTableMap::COL___USER__, $users->getId(), $comparison);
        } elseif ($users instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FormatsTableMap::COL___USER__, $users->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildFormatsQuery The current query, for fluid interface
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
     * Filter the query by a related \Books object
     *
     * @param \Books|ObjectCollection $books The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildFormatsQuery The current query, for fluid interface
     */
    public function filterByBooks($books, $comparison = null)
    {
        if ($books instanceof \Books) {
            return $this
                ->addUsingAlias(FormatsTableMap::COL__FORBOOK, $books->getId(), $comparison);
        } elseif ($books instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FormatsTableMap::COL__FORBOOK, $books->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByBooks() only accepts arguments of type \Books or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Books relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildFormatsQuery The current query, for fluid interface
     */
    public function joinBooks($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Books');

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
            $this->addJoinObject($join, 'Books');
        }

        return $this;
    }

    /**
     * Use the Books relation Books object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BooksQuery A secondary query class using the current class as primary query
     */
    public function useBooksQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinBooks($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Books', '\BooksQuery');
    }

    /**
     * Filter the query by a related \RRightsForformat object
     *
     * @param \RRightsForformat|ObjectCollection $rRightsForformat the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFormatsQuery The current query, for fluid interface
     */
    public function filterByRRightsForformat($rRightsForformat, $comparison = null)
    {
        if ($rRightsForformat instanceof \RRightsForformat) {
            return $this
                ->addUsingAlias(FormatsTableMap::COL_ID, $rRightsForformat->getFormatid(), $comparison);
        } elseif ($rRightsForformat instanceof ObjectCollection) {
            return $this
                ->useRRightsForformatQuery()
                ->filterByPrimaryKeys($rRightsForformat->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRRightsForformat() only accepts arguments of type \RRightsForformat or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RRightsForformat relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildFormatsQuery The current query, for fluid interface
     */
    public function joinRRightsForformat($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RRightsForformat');

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
            $this->addJoinObject($join, 'RRightsForformat');
        }

        return $this;
    }

    /**
     * Use the RRightsForformat relation RRightsForformat object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RRightsForformatQuery A secondary query class using the current class as primary query
     */
    public function useRRightsForformatQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRRightsForformat($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RRightsForformat', '\RRightsForformatQuery');
    }

    /**
     * Filter the query by a related \RTemplatenamesInchapter object
     *
     * @param \RTemplatenamesInchapter|ObjectCollection $rTemplatenamesInchapter the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFormatsQuery The current query, for fluid interface
     */
    public function filterByRTemplatenamesInchapter($rTemplatenamesInchapter, $comparison = null)
    {
        if ($rTemplatenamesInchapter instanceof \RTemplatenamesInchapter) {
            return $this
                ->addUsingAlias(FormatsTableMap::COL_ID, $rTemplatenamesInchapter->getChapterid(), $comparison);
        } elseif ($rTemplatenamesInchapter instanceof ObjectCollection) {
            return $this
                ->useRTemplatenamesInchapterQuery()
                ->filterByPrimaryKeys($rTemplatenamesInchapter->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRTemplatenamesInchapter() only accepts arguments of type \RTemplatenamesInchapter or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RTemplatenamesInchapter relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildFormatsQuery The current query, for fluid interface
     */
    public function joinRTemplatenamesInchapter($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RTemplatenamesInchapter');

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
            $this->addJoinObject($join, 'RTemplatenamesInchapter');
        }

        return $this;
    }

    /**
     * Use the RTemplatenamesInchapter relation RTemplatenamesInchapter object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RTemplatenamesInchapterQuery A secondary query class using the current class as primary query
     */
    public function useRTemplatenamesInchapterQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRTemplatenamesInchapter($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RTemplatenamesInchapter', '\RTemplatenamesInchapterQuery');
    }

    /**
     * Filter the query by a related \Contributions object
     *
     * @param \Contributions|ObjectCollection $contributions the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFormatsQuery The current query, for fluid interface
     */
    public function filterByContributions($contributions, $comparison = null)
    {
        if ($contributions instanceof \Contributions) {
            return $this
                ->addUsingAlias(FormatsTableMap::COL_ID, $contributions->getForchapter(), $comparison);
        } elseif ($contributions instanceof ObjectCollection) {
            return $this
                ->useContributionsQuery()
                ->filterByPrimaryKeys($contributions->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByContributions() only accepts arguments of type \Contributions or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Contributions relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildFormatsQuery The current query, for fluid interface
     */
    public function joinContributions($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Contributions');

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
            $this->addJoinObject($join, 'Contributions');
        }

        return $this;
    }

    /**
     * Use the Contributions relation Contributions object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ContributionsQuery A secondary query class using the current class as primary query
     */
    public function useContributionsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinContributions($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Contributions', '\ContributionsQuery');
    }

    /**
     * Filter the query by a related \RDataFormat object
     *
     * @param \RDataFormat|ObjectCollection $rDataFormat the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFormatsQuery The current query, for fluid interface
     */
    public function filterByRDataFormat($rDataFormat, $comparison = null)
    {
        if ($rDataFormat instanceof \RDataFormat) {
            return $this
                ->addUsingAlias(FormatsTableMap::COL_ID, $rDataFormat->getFormatid(), $comparison);
        } elseif ($rDataFormat instanceof ObjectCollection) {
            return $this
                ->useRDataFormatQuery()
                ->filterByPrimaryKeys($rDataFormat->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRDataFormat() only accepts arguments of type \RDataFormat or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RDataFormat relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildFormatsQuery The current query, for fluid interface
     */
    public function joinRDataFormat($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RDataFormat');

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
            $this->addJoinObject($join, 'RDataFormat');
        }

        return $this;
    }

    /**
     * Use the RDataFormat relation RDataFormat object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RDataFormatQuery A secondary query class using the current class as primary query
     */
    public function useRDataFormatQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRDataFormat($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RDataFormat', '\RDataFormatQuery');
    }

    /**
     * Filter the query by a related \RPluginFormat object
     *
     * @param \RPluginFormat|ObjectCollection $rPluginFormat the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFormatsQuery The current query, for fluid interface
     */
    public function filterByRPluginFormat($rPluginFormat, $comparison = null)
    {
        if ($rPluginFormat instanceof \RPluginFormat) {
            return $this
                ->addUsingAlias(FormatsTableMap::COL_ID, $rPluginFormat->getFormatid(), $comparison);
        } elseif ($rPluginFormat instanceof ObjectCollection) {
            return $this
                ->useRPluginFormatQuery()
                ->filterByPrimaryKeys($rPluginFormat->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRPluginFormat() only accepts arguments of type \RPluginFormat or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RPluginFormat relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildFormatsQuery The current query, for fluid interface
     */
    public function joinRPluginFormat($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RPluginFormat');

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
            $this->addJoinObject($join, 'RPluginFormat');
        }

        return $this;
    }

    /**
     * Use the RPluginFormat relation RPluginFormat object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RPluginFormatQuery A secondary query class using the current class as primary query
     */
    public function useRPluginFormatQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRPluginFormat($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RPluginFormat', '\RPluginFormatQuery');
    }

    /**
     * Filter the query by a related Rights object
     * using the R_rights_forformat table as cross reference
     *
     * @param Rights $rights the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFormatsQuery The current query, for fluid interface
     */
    public function filterByRights($rights, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRRightsForformatQuery()
            ->filterByRights($rights, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Templatenames object
     * using the R_templatenames_inchapter table as cross reference
     *
     * @param Templatenames $templatenames the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFormatsQuery The current query, for fluid interface
     */
    public function filterByTemplatenames($templatenames, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRTemplatenamesInchapterQuery()
            ->filterByTemplatenames($templatenames, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Data object
     * using the R_data_format table as cross reference
     *
     * @param Data $data the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFormatsQuery The current query, for fluid interface
     */
    public function filterByRData($data, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRDataFormatQuery()
            ->filterByRData($data, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Plugins object
     * using the R_plugin_format table as cross reference
     *
     * @param Plugins $plugins the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFormatsQuery The current query, for fluid interface
     */
    public function filterByRPlugin($plugins, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRPluginFormatQuery()
            ->filterByRPlugin($plugins, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildFormats $formats Object to remove from the list of results
     *
     * @return $this|ChildFormatsQuery The current query, for fluid interface
     */
    public function prune($formats = null)
    {
        if ($formats) {
            $this->addUsingAlias(FormatsTableMap::COL_ID, $formats->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the _formats table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FormatsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            FormatsTableMap::clearInstancePool();
            FormatsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(FormatsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(FormatsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            FormatsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            FormatsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // FormatsQuery
