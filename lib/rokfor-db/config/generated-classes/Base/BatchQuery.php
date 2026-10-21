<?php

namespace Base;

use \Batch as ChildBatch;
use \BatchQuery as ChildBatchQuery;
use \Exception;
use \PDO;
use Map\BatchTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the '_batch' table.
 *
 *
 *
 * @method     ChildBatchQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildBatchQuery orderByName($order = Criteria::ASC) Order by the _name column
 * @method     ChildBatchQuery orderByDescription($order = Criteria::ASC) Order by the _description column
 * @method     ChildBatchQuery orderByPrecode($order = Criteria::ASC) Order by the _precode column
 * @method     ChildBatchQuery orderByPostcode($order = Criteria::ASC) Order by the _postcode column
 * @method     ChildBatchQuery orderByConfigSys($order = Criteria::ASC) Order by the __config__ column
 * @method     ChildBatchQuery orderBySplit($order = Criteria::ASC) Order by the __split__ column
 * @method     ChildBatchQuery orderByParentnode($order = Criteria::ASC) Order by the __parentnode__ column
 * @method     ChildBatchQuery orderBySort($order = Criteria::ASC) Order by the __sort__ column
 *
 * @method     ChildBatchQuery groupById() Group by the id column
 * @method     ChildBatchQuery groupByName() Group by the _name column
 * @method     ChildBatchQuery groupByDescription() Group by the _description column
 * @method     ChildBatchQuery groupByPrecode() Group by the _precode column
 * @method     ChildBatchQuery groupByPostcode() Group by the _postcode column
 * @method     ChildBatchQuery groupByConfigSys() Group by the __config__ column
 * @method     ChildBatchQuery groupBySplit() Group by the __split__ column
 * @method     ChildBatchQuery groupByParentnode() Group by the __parentnode__ column
 * @method     ChildBatchQuery groupBySort() Group by the __sort__ column
 *
 * @method     ChildBatchQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildBatchQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildBatchQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildBatchQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildBatchQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildBatchQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildBatchQuery leftJoinRBatchForbook($relationAlias = null) Adds a LEFT JOIN clause to the query using the RBatchForbook relation
 * @method     ChildBatchQuery rightJoinRBatchForbook($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RBatchForbook relation
 * @method     ChildBatchQuery innerJoinRBatchForbook($relationAlias = null) Adds a INNER JOIN clause to the query using the RBatchForbook relation
 *
 * @method     ChildBatchQuery joinWithRBatchForbook($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RBatchForbook relation
 *
 * @method     ChildBatchQuery leftJoinWithRBatchForbook() Adds a LEFT JOIN clause and with to the query using the RBatchForbook relation
 * @method     ChildBatchQuery rightJoinWithRBatchForbook() Adds a RIGHT JOIN clause and with to the query using the RBatchForbook relation
 * @method     ChildBatchQuery innerJoinWithRBatchForbook() Adds a INNER JOIN clause and with to the query using the RBatchForbook relation
 *
 * @method     \RBatchForbookQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildBatch findOne(ConnectionInterface $con = null) Return the first ChildBatch matching the query
 * @method     ChildBatch findOneOrCreate(ConnectionInterface $con = null) Return the first ChildBatch matching the query, or a new ChildBatch object populated from the query conditions when no match is found
 *
 * @method     ChildBatch findOneById(int $id) Return the first ChildBatch filtered by the id column
 * @method     ChildBatch findOneByName(string $_name) Return the first ChildBatch filtered by the _name column
 * @method     ChildBatch findOneByDescription(string $_description) Return the first ChildBatch filtered by the _description column
 * @method     ChildBatch findOneByPrecode(string $_precode) Return the first ChildBatch filtered by the _precode column
 * @method     ChildBatch findOneByPostcode(string $_postcode) Return the first ChildBatch filtered by the _postcode column
 * @method     ChildBatch findOneByConfigSys(string $__config__) Return the first ChildBatch filtered by the __config__ column
 * @method     ChildBatch findOneBySplit(string $__split__) Return the first ChildBatch filtered by the __split__ column
 * @method     ChildBatch findOneByParentnode(int $__parentnode__) Return the first ChildBatch filtered by the __parentnode__ column
 * @method     ChildBatch findOneBySort(int $__sort__) Return the first ChildBatch filtered by the __sort__ column *

 * @method     ChildBatch requirePk($key, ConnectionInterface $con = null) Return the ChildBatch by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBatch requireOne(ConnectionInterface $con = null) Return the first ChildBatch matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBatch requireOneById(int $id) Return the first ChildBatch filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBatch requireOneByName(string $_name) Return the first ChildBatch filtered by the _name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBatch requireOneByDescription(string $_description) Return the first ChildBatch filtered by the _description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBatch requireOneByPrecode(string $_precode) Return the first ChildBatch filtered by the _precode column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBatch requireOneByPostcode(string $_postcode) Return the first ChildBatch filtered by the _postcode column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBatch requireOneByConfigSys(string $__config__) Return the first ChildBatch filtered by the __config__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBatch requireOneBySplit(string $__split__) Return the first ChildBatch filtered by the __split__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBatch requireOneByParentnode(int $__parentnode__) Return the first ChildBatch filtered by the __parentnode__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildBatch requireOneBySort(int $__sort__) Return the first ChildBatch filtered by the __sort__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildBatch[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildBatch objects based on current ModelCriteria
 * @method     ChildBatch[]|ObjectCollection findById(int $id) Return ChildBatch objects filtered by the id column
 * @method     ChildBatch[]|ObjectCollection findByName(string $_name) Return ChildBatch objects filtered by the _name column
 * @method     ChildBatch[]|ObjectCollection findByDescription(string $_description) Return ChildBatch objects filtered by the _description column
 * @method     ChildBatch[]|ObjectCollection findByPrecode(string $_precode) Return ChildBatch objects filtered by the _precode column
 * @method     ChildBatch[]|ObjectCollection findByPostcode(string $_postcode) Return ChildBatch objects filtered by the _postcode column
 * @method     ChildBatch[]|ObjectCollection findByConfigSys(string $__config__) Return ChildBatch objects filtered by the __config__ column
 * @method     ChildBatch[]|ObjectCollection findBySplit(string $__split__) Return ChildBatch objects filtered by the __split__ column
 * @method     ChildBatch[]|ObjectCollection findByParentnode(int $__parentnode__) Return ChildBatch objects filtered by the __parentnode__ column
 * @method     ChildBatch[]|ObjectCollection findBySort(int $__sort__) Return ChildBatch objects filtered by the __sort__ column
 * @method     ChildBatch[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class BatchQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\BatchQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\Batch', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildBatchQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildBatchQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildBatchQuery) {
            return $criteria;
        }
        $query = new ChildBatchQuery();
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
     * @return ChildBatch|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(BatchTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = BatchTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildBatch A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, _name, _description, _precode, _postcode, __config__, __split__, __parentnode__, __sort__ FROM _batch WHERE id = :p0';
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
            /** @var ChildBatch $obj */
            $obj = new ChildBatch();
            $obj->hydrate($row);
            BatchTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildBatch|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildBatchQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BatchTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildBatchQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BatchTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildBatchQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(BatchTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(BatchTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BatchTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildBatchQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BatchTableMap::COL__NAME, $name, $comparison);
    }

    /**
     * Filter the query on the _description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE _description = 'fooValue'
     * $query->filterByDescription('%fooValue%', Criteria::LIKE); // WHERE _description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBatchQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BatchTableMap::COL__DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the _precode column
     *
     * Example usage:
     * <code>
     * $query->filterByPrecode('fooValue');   // WHERE _precode = 'fooValue'
     * $query->filterByPrecode('%fooValue%', Criteria::LIKE); // WHERE _precode LIKE '%fooValue%'
     * </code>
     *
     * @param     string $precode The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBatchQuery The current query, for fluid interface
     */
    public function filterByPrecode($precode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($precode)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BatchTableMap::COL__PRECODE, $precode, $comparison);
    }

    /**
     * Filter the query on the _postcode column
     *
     * Example usage:
     * <code>
     * $query->filterByPostcode('fooValue');   // WHERE _postcode = 'fooValue'
     * $query->filterByPostcode('%fooValue%', Criteria::LIKE); // WHERE _postcode LIKE '%fooValue%'
     * </code>
     *
     * @param     string $postcode The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildBatchQuery The current query, for fluid interface
     */
    public function filterByPostcode($postcode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($postcode)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BatchTableMap::COL__POSTCODE, $postcode, $comparison);
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
     * @return $this|ChildBatchQuery The current query, for fluid interface
     */
    public function filterByConfigSys($configSys = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($configSys)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BatchTableMap::COL___CONFIG__, $configSys, $comparison);
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
     * @return $this|ChildBatchQuery The current query, for fluid interface
     */
    public function filterBySplit($split = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($split)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BatchTableMap::COL___SPLIT__, $split, $comparison);
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
     * @return $this|ChildBatchQuery The current query, for fluid interface
     */
    public function filterByParentnode($parentnode = null, $comparison = null)
    {
        if (is_array($parentnode)) {
            $useMinMax = false;
            if (isset($parentnode['min'])) {
                $this->addUsingAlias(BatchTableMap::COL___PARENTNODE__, $parentnode['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentnode['max'])) {
                $this->addUsingAlias(BatchTableMap::COL___PARENTNODE__, $parentnode['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BatchTableMap::COL___PARENTNODE__, $parentnode, $comparison);
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
     * @return $this|ChildBatchQuery The current query, for fluid interface
     */
    public function filterBySort($sort = null, $comparison = null)
    {
        if (is_array($sort)) {
            $useMinMax = false;
            if (isset($sort['min'])) {
                $this->addUsingAlias(BatchTableMap::COL___SORT__, $sort['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sort['max'])) {
                $this->addUsingAlias(BatchTableMap::COL___SORT__, $sort['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BatchTableMap::COL___SORT__, $sort, $comparison);
    }

    /**
     * Filter the query by a related \RBatchForbook object
     *
     * @param \RBatchForbook|ObjectCollection $rBatchForbook the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBatchQuery The current query, for fluid interface
     */
    public function filterByRBatchForbook($rBatchForbook, $comparison = null)
    {
        if ($rBatchForbook instanceof \RBatchForbook) {
            return $this
                ->addUsingAlias(BatchTableMap::COL_ID, $rBatchForbook->getBatchid(), $comparison);
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
     * @return $this|ChildBatchQuery The current query, for fluid interface
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
     * Filter the query by a related Books object
     * using the R_batch_forbook table as cross reference
     *
     * @param Books $books the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildBatchQuery The current query, for fluid interface
     */
    public function filterByBooks($books, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRBatchForbookQuery()
            ->filterByBooks($books, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildBatch $batch Object to remove from the list of results
     *
     * @return $this|ChildBatchQuery The current query, for fluid interface
     */
    public function prune($batch = null)
    {
        if ($batch) {
            $this->addUsingAlias(BatchTableMap::COL_ID, $batch->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the _batch table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BatchTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BatchTableMap::clearInstancePool();
            BatchTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(BatchTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(BatchTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            BatchTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            BatchTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // BatchQuery
