<?php

namespace Base;

use \Rights as ChildRights;
use \RightsQuery as ChildRightsQuery;
use \Exception;
use \PDO;
use Map\RightsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the '_rights' table.
 *
 *
 *
 * @method     ChildRightsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildRightsQuery orderByGroup($order = Criteria::ASC) Order by the _group column
 * @method     ChildRightsQuery orderByConfigSys($order = Criteria::ASC) Order by the __config__ column
 * @method     ChildRightsQuery orderBySplit($order = Criteria::ASC) Order by the __split__ column
 * @method     ChildRightsQuery orderByParentnode($order = Criteria::ASC) Order by the __parentnode__ column
 * @method     ChildRightsQuery orderBySort($order = Criteria::ASC) Order by the __sort__ column
 *
 * @method     ChildRightsQuery groupById() Group by the id column
 * @method     ChildRightsQuery groupByGroup() Group by the _group column
 * @method     ChildRightsQuery groupByConfigSys() Group by the __config__ column
 * @method     ChildRightsQuery groupBySplit() Group by the __split__ column
 * @method     ChildRightsQuery groupByParentnode() Group by the __parentnode__ column
 * @method     ChildRightsQuery groupBySort() Group by the __sort__ column
 *
 * @method     ChildRightsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRightsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRightsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRightsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildRightsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildRightsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildRightsQuery leftJoinRRightsForbook($relationAlias = null) Adds a LEFT JOIN clause to the query using the RRightsForbook relation
 * @method     ChildRightsQuery rightJoinRRightsForbook($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RRightsForbook relation
 * @method     ChildRightsQuery innerJoinRRightsForbook($relationAlias = null) Adds a INNER JOIN clause to the query using the RRightsForbook relation
 *
 * @method     ChildRightsQuery joinWithRRightsForbook($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RRightsForbook relation
 *
 * @method     ChildRightsQuery leftJoinWithRRightsForbook() Adds a LEFT JOIN clause and with to the query using the RRightsForbook relation
 * @method     ChildRightsQuery rightJoinWithRRightsForbook() Adds a RIGHT JOIN clause and with to the query using the RRightsForbook relation
 * @method     ChildRightsQuery innerJoinWithRRightsForbook() Adds a INNER JOIN clause and with to the query using the RRightsForbook relation
 *
 * @method     ChildRightsQuery leftJoinRRightsForissue($relationAlias = null) Adds a LEFT JOIN clause to the query using the RRightsForissue relation
 * @method     ChildRightsQuery rightJoinRRightsForissue($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RRightsForissue relation
 * @method     ChildRightsQuery innerJoinRRightsForissue($relationAlias = null) Adds a INNER JOIN clause to the query using the RRightsForissue relation
 *
 * @method     ChildRightsQuery joinWithRRightsForissue($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RRightsForissue relation
 *
 * @method     ChildRightsQuery leftJoinWithRRightsForissue() Adds a LEFT JOIN clause and with to the query using the RRightsForissue relation
 * @method     ChildRightsQuery rightJoinWithRRightsForissue() Adds a RIGHT JOIN clause and with to the query using the RRightsForissue relation
 * @method     ChildRightsQuery innerJoinWithRRightsForissue() Adds a INNER JOIN clause and with to the query using the RRightsForissue relation
 *
 * @method     ChildRightsQuery leftJoinRRightsFortemplate($relationAlias = null) Adds a LEFT JOIN clause to the query using the RRightsFortemplate relation
 * @method     ChildRightsQuery rightJoinRRightsFortemplate($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RRightsFortemplate relation
 * @method     ChildRightsQuery innerJoinRRightsFortemplate($relationAlias = null) Adds a INNER JOIN clause to the query using the RRightsFortemplate relation
 *
 * @method     ChildRightsQuery joinWithRRightsFortemplate($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RRightsFortemplate relation
 *
 * @method     ChildRightsQuery leftJoinWithRRightsFortemplate() Adds a LEFT JOIN clause and with to the query using the RRightsFortemplate relation
 * @method     ChildRightsQuery rightJoinWithRRightsFortemplate() Adds a RIGHT JOIN clause and with to the query using the RRightsFortemplate relation
 * @method     ChildRightsQuery innerJoinWithRRightsFortemplate() Adds a INNER JOIN clause and with to the query using the RRightsFortemplate relation
 *
 * @method     ChildRightsQuery leftJoinRRightsForformat($relationAlias = null) Adds a LEFT JOIN clause to the query using the RRightsForformat relation
 * @method     ChildRightsQuery rightJoinRRightsForformat($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RRightsForformat relation
 * @method     ChildRightsQuery innerJoinRRightsForformat($relationAlias = null) Adds a INNER JOIN clause to the query using the RRightsForformat relation
 *
 * @method     ChildRightsQuery joinWithRRightsForformat($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RRightsForformat relation
 *
 * @method     ChildRightsQuery leftJoinWithRRightsForformat() Adds a LEFT JOIN clause and with to the query using the RRightsForformat relation
 * @method     ChildRightsQuery rightJoinWithRRightsForformat() Adds a RIGHT JOIN clause and with to the query using the RRightsForformat relation
 * @method     ChildRightsQuery innerJoinWithRRightsForformat() Adds a INNER JOIN clause and with to the query using the RRightsForformat relation
 *
 * @method     ChildRightsQuery leftJoinRRightsForuser($relationAlias = null) Adds a LEFT JOIN clause to the query using the RRightsForuser relation
 * @method     ChildRightsQuery rightJoinRRightsForuser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RRightsForuser relation
 * @method     ChildRightsQuery innerJoinRRightsForuser($relationAlias = null) Adds a INNER JOIN clause to the query using the RRightsForuser relation
 *
 * @method     ChildRightsQuery joinWithRRightsForuser($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RRightsForuser relation
 *
 * @method     ChildRightsQuery leftJoinWithRRightsForuser() Adds a LEFT JOIN clause and with to the query using the RRightsForuser relation
 * @method     ChildRightsQuery rightJoinWithRRightsForuser() Adds a RIGHT JOIN clause and with to the query using the RRightsForuser relation
 * @method     ChildRightsQuery innerJoinWithRRightsForuser() Adds a INNER JOIN clause and with to the query using the RRightsForuser relation
 *
 * @method     \RRightsForbookQuery|\RRightsForissueQuery|\RRightsFortemplateQuery|\RRightsForformatQuery|\RRightsForuserQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRights findOne(ConnectionInterface $con = null) Return the first ChildRights matching the query
 * @method     ChildRights findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRights matching the query, or a new ChildRights object populated from the query conditions when no match is found
 *
 * @method     ChildRights findOneById(int $id) Return the first ChildRights filtered by the id column
 * @method     ChildRights findOneByGroup(string $_group) Return the first ChildRights filtered by the _group column
 * @method     ChildRights findOneByConfigSys(string $__config__) Return the first ChildRights filtered by the __config__ column
 * @method     ChildRights findOneBySplit(string $__split__) Return the first ChildRights filtered by the __split__ column
 * @method     ChildRights findOneByParentnode(int $__parentnode__) Return the first ChildRights filtered by the __parentnode__ column
 * @method     ChildRights findOneBySort(int $__sort__) Return the first ChildRights filtered by the __sort__ column *

 * @method     ChildRights requirePk($key, ConnectionInterface $con = null) Return the ChildRights by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRights requireOne(ConnectionInterface $con = null) Return the first ChildRights matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRights requireOneById(int $id) Return the first ChildRights filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRights requireOneByGroup(string $_group) Return the first ChildRights filtered by the _group column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRights requireOneByConfigSys(string $__config__) Return the first ChildRights filtered by the __config__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRights requireOneBySplit(string $__split__) Return the first ChildRights filtered by the __split__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRights requireOneByParentnode(int $__parentnode__) Return the first ChildRights filtered by the __parentnode__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRights requireOneBySort(int $__sort__) Return the first ChildRights filtered by the __sort__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRights[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRights objects based on current ModelCriteria
 * @method     ChildRights[]|ObjectCollection findById(int $id) Return ChildRights objects filtered by the id column
 * @method     ChildRights[]|ObjectCollection findByGroup(string $_group) Return ChildRights objects filtered by the _group column
 * @method     ChildRights[]|ObjectCollection findByConfigSys(string $__config__) Return ChildRights objects filtered by the __config__ column
 * @method     ChildRights[]|ObjectCollection findBySplit(string $__split__) Return ChildRights objects filtered by the __split__ column
 * @method     ChildRights[]|ObjectCollection findByParentnode(int $__parentnode__) Return ChildRights objects filtered by the __parentnode__ column
 * @method     ChildRights[]|ObjectCollection findBySort(int $__sort__) Return ChildRights objects filtered by the __sort__ column
 * @method     ChildRights[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RightsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\RightsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\Rights', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRightsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRightsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRightsQuery) {
            return $criteria;
        }
        $query = new ChildRightsQuery();
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
     * @return ChildRights|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RightsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = RightsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildRights A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, _group, __config__, __split__, __parentnode__, __sort__ FROM _rights WHERE id = :p0';
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
            /** @var ChildRights $obj */
            $obj = new ChildRights();
            $obj->hydrate($row);
            RightsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildRights|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRightsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RightsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRightsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RightsTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildRightsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(RightsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(RightsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RightsTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the _group column
     *
     * Example usage:
     * <code>
     * $query->filterByGroup('fooValue');   // WHERE _group = 'fooValue'
     * $query->filterByGroup('%fooValue%', Criteria::LIKE); // WHERE _group LIKE '%fooValue%'
     * </code>
     *
     * @param     string $group The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRightsQuery The current query, for fluid interface
     */
    public function filterByGroup($group = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($group)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RightsTableMap::COL__GROUP, $group, $comparison);
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
     * @return $this|ChildRightsQuery The current query, for fluid interface
     */
    public function filterByConfigSys($configSys = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($configSys)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RightsTableMap::COL___CONFIG__, $configSys, $comparison);
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
     * @return $this|ChildRightsQuery The current query, for fluid interface
     */
    public function filterBySplit($split = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($split)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RightsTableMap::COL___SPLIT__, $split, $comparison);
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
     * @return $this|ChildRightsQuery The current query, for fluid interface
     */
    public function filterByParentnode($parentnode = null, $comparison = null)
    {
        if (is_array($parentnode)) {
            $useMinMax = false;
            if (isset($parentnode['min'])) {
                $this->addUsingAlias(RightsTableMap::COL___PARENTNODE__, $parentnode['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentnode['max'])) {
                $this->addUsingAlias(RightsTableMap::COL___PARENTNODE__, $parentnode['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RightsTableMap::COL___PARENTNODE__, $parentnode, $comparison);
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
     * @return $this|ChildRightsQuery The current query, for fluid interface
     */
    public function filterBySort($sort = null, $comparison = null)
    {
        if (is_array($sort)) {
            $useMinMax = false;
            if (isset($sort['min'])) {
                $this->addUsingAlias(RightsTableMap::COL___SORT__, $sort['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sort['max'])) {
                $this->addUsingAlias(RightsTableMap::COL___SORT__, $sort['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RightsTableMap::COL___SORT__, $sort, $comparison);
    }

    /**
     * Filter the query by a related \RRightsForbook object
     *
     * @param \RRightsForbook|ObjectCollection $rRightsForbook the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRightsQuery The current query, for fluid interface
     */
    public function filterByRRightsForbook($rRightsForbook, $comparison = null)
    {
        if ($rRightsForbook instanceof \RRightsForbook) {
            return $this
                ->addUsingAlias(RightsTableMap::COL_ID, $rRightsForbook->getRightid(), $comparison);
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
     * @return $this|ChildRightsQuery The current query, for fluid interface
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
     * Filter the query by a related \RRightsForissue object
     *
     * @param \RRightsForissue|ObjectCollection $rRightsForissue the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRightsQuery The current query, for fluid interface
     */
    public function filterByRRightsForissue($rRightsForissue, $comparison = null)
    {
        if ($rRightsForissue instanceof \RRightsForissue) {
            return $this
                ->addUsingAlias(RightsTableMap::COL_ID, $rRightsForissue->getRightid(), $comparison);
        } elseif ($rRightsForissue instanceof ObjectCollection) {
            return $this
                ->useRRightsForissueQuery()
                ->filterByPrimaryKeys($rRightsForissue->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRRightsForissue() only accepts arguments of type \RRightsForissue or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RRightsForissue relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRightsQuery The current query, for fluid interface
     */
    public function joinRRightsForissue($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RRightsForissue');

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
            $this->addJoinObject($join, 'RRightsForissue');
        }

        return $this;
    }

    /**
     * Use the RRightsForissue relation RRightsForissue object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RRightsForissueQuery A secondary query class using the current class as primary query
     */
    public function useRRightsForissueQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRRightsForissue($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RRightsForissue', '\RRightsForissueQuery');
    }

    /**
     * Filter the query by a related \RRightsFortemplate object
     *
     * @param \RRightsFortemplate|ObjectCollection $rRightsFortemplate the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRightsQuery The current query, for fluid interface
     */
    public function filterByRRightsFortemplate($rRightsFortemplate, $comparison = null)
    {
        if ($rRightsFortemplate instanceof \RRightsFortemplate) {
            return $this
                ->addUsingAlias(RightsTableMap::COL_ID, $rRightsFortemplate->getRightid(), $comparison);
        } elseif ($rRightsFortemplate instanceof ObjectCollection) {
            return $this
                ->useRRightsFortemplateQuery()
                ->filterByPrimaryKeys($rRightsFortemplate->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRRightsFortemplate() only accepts arguments of type \RRightsFortemplate or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RRightsFortemplate relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRightsQuery The current query, for fluid interface
     */
    public function joinRRightsFortemplate($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RRightsFortemplate');

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
            $this->addJoinObject($join, 'RRightsFortemplate');
        }

        return $this;
    }

    /**
     * Use the RRightsFortemplate relation RRightsFortemplate object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RRightsFortemplateQuery A secondary query class using the current class as primary query
     */
    public function useRRightsFortemplateQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRRightsFortemplate($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RRightsFortemplate', '\RRightsFortemplateQuery');
    }

    /**
     * Filter the query by a related \RRightsForformat object
     *
     * @param \RRightsForformat|ObjectCollection $rRightsForformat the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRightsQuery The current query, for fluid interface
     */
    public function filterByRRightsForformat($rRightsForformat, $comparison = null)
    {
        if ($rRightsForformat instanceof \RRightsForformat) {
            return $this
                ->addUsingAlias(RightsTableMap::COL_ID, $rRightsForformat->getRightid(), $comparison);
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
     * @return $this|ChildRightsQuery The current query, for fluid interface
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
     * Filter the query by a related \RRightsForuser object
     *
     * @param \RRightsForuser|ObjectCollection $rRightsForuser the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRightsQuery The current query, for fluid interface
     */
    public function filterByRRightsForuser($rRightsForuser, $comparison = null)
    {
        if ($rRightsForuser instanceof \RRightsForuser) {
            return $this
                ->addUsingAlias(RightsTableMap::COL_ID, $rRightsForuser->getRightid(), $comparison);
        } elseif ($rRightsForuser instanceof ObjectCollection) {
            return $this
                ->useRRightsForuserQuery()
                ->filterByPrimaryKeys($rRightsForuser->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRRightsForuser() only accepts arguments of type \RRightsForuser or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RRightsForuser relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRightsQuery The current query, for fluid interface
     */
    public function joinRRightsForuser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RRightsForuser');

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
            $this->addJoinObject($join, 'RRightsForuser');
        }

        return $this;
    }

    /**
     * Use the RRightsForuser relation RRightsForuser object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RRightsForuserQuery A secondary query class using the current class as primary query
     */
    public function useRRightsForuserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRRightsForuser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RRightsForuser', '\RRightsForuserQuery');
    }

    /**
     * Filter the query by a related Books object
     * using the R_rights_forbook table as cross reference
     *
     * @param Books $books the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRightsQuery The current query, for fluid interface
     */
    public function filterByBooks($books, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRRightsForbookQuery()
            ->filterByBooks($books, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Issues object
     * using the R_rights_forissue table as cross reference
     *
     * @param Issues $issues the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRightsQuery The current query, for fluid interface
     */
    public function filterByIssues($issues, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRRightsForissueQuery()
            ->filterByIssues($issues, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Templatenames object
     * using the R_rights_fortemplate table as cross reference
     *
     * @param Templatenames $templatenames the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRightsQuery The current query, for fluid interface
     */
    public function filterByTemplatenames($templatenames, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRRightsFortemplateQuery()
            ->filterByTemplatenames($templatenames, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Formats object
     * using the R_rights_forformat table as cross reference
     *
     * @param Formats $formats the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRightsQuery The current query, for fluid interface
     */
    public function filterByFormats($formats, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRRightsForformatQuery()
            ->filterByFormats($formats, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Users object
     * using the R_rights_foruser table as cross reference
     *
     * @param Users $users the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildRightsQuery The current query, for fluid interface
     */
    public function filterByUsers($users, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRRightsForuserQuery()
            ->filterByUsers($users, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRights $rights Object to remove from the list of results
     *
     * @return $this|ChildRightsQuery The current query, for fluid interface
     */
    public function prune($rights = null)
    {
        if ($rights) {
            $this->addUsingAlias(RightsTableMap::COL_ID, $rights->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the _rights table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RightsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RightsTableMap::clearInstancePool();
            RightsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RightsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RightsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RightsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RightsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RightsQuery
