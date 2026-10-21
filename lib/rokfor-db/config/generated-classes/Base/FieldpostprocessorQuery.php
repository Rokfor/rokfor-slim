<?php

namespace Base;

use \Fieldpostprocessor as ChildFieldpostprocessor;
use \FieldpostprocessorQuery as ChildFieldpostprocessorQuery;
use \Exception;
use \PDO;
use Map\FieldpostprocessorTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the '_fieldpostprocessor' table.
 *
 *
 *
 * @method     ChildFieldpostprocessorQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildFieldpostprocessorQuery orderByName($order = Criteria::ASC) Order by the _name column
 * @method     ChildFieldpostprocessorQuery orderByCode($order = Criteria::ASC) Order by the _code column
 * @method     ChildFieldpostprocessorQuery orderByConfigSys($order = Criteria::ASC) Order by the __config__ column
 * @method     ChildFieldpostprocessorQuery orderBySplit($order = Criteria::ASC) Order by the __split__ column
 * @method     ChildFieldpostprocessorQuery orderByParentnode($order = Criteria::ASC) Order by the __parentnode__ column
 * @method     ChildFieldpostprocessorQuery orderBySort($order = Criteria::ASC) Order by the __sort__ column
 *
 * @method     ChildFieldpostprocessorQuery groupById() Group by the id column
 * @method     ChildFieldpostprocessorQuery groupByName() Group by the _name column
 * @method     ChildFieldpostprocessorQuery groupByCode() Group by the _code column
 * @method     ChildFieldpostprocessorQuery groupByConfigSys() Group by the __config__ column
 * @method     ChildFieldpostprocessorQuery groupBySplit() Group by the __split__ column
 * @method     ChildFieldpostprocessorQuery groupByParentnode() Group by the __parentnode__ column
 * @method     ChildFieldpostprocessorQuery groupBySort() Group by the __sort__ column
 *
 * @method     ChildFieldpostprocessorQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildFieldpostprocessorQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildFieldpostprocessorQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildFieldpostprocessorQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildFieldpostprocessorQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildFieldpostprocessorQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildFieldpostprocessorQuery leftJoinRFieldpostprocessorForfield($relationAlias = null) Adds a LEFT JOIN clause to the query using the RFieldpostprocessorForfield relation
 * @method     ChildFieldpostprocessorQuery rightJoinRFieldpostprocessorForfield($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RFieldpostprocessorForfield relation
 * @method     ChildFieldpostprocessorQuery innerJoinRFieldpostprocessorForfield($relationAlias = null) Adds a INNER JOIN clause to the query using the RFieldpostprocessorForfield relation
 *
 * @method     ChildFieldpostprocessorQuery joinWithRFieldpostprocessorForfield($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RFieldpostprocessorForfield relation
 *
 * @method     ChildFieldpostprocessorQuery leftJoinWithRFieldpostprocessorForfield() Adds a LEFT JOIN clause and with to the query using the RFieldpostprocessorForfield relation
 * @method     ChildFieldpostprocessorQuery rightJoinWithRFieldpostprocessorForfield() Adds a RIGHT JOIN clause and with to the query using the RFieldpostprocessorForfield relation
 * @method     ChildFieldpostprocessorQuery innerJoinWithRFieldpostprocessorForfield() Adds a INNER JOIN clause and with to the query using the RFieldpostprocessorForfield relation
 *
 * @method     \RFieldpostprocessorForfieldQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildFieldpostprocessor findOne(ConnectionInterface $con = null) Return the first ChildFieldpostprocessor matching the query
 * @method     ChildFieldpostprocessor findOneOrCreate(ConnectionInterface $con = null) Return the first ChildFieldpostprocessor matching the query, or a new ChildFieldpostprocessor object populated from the query conditions when no match is found
 *
 * @method     ChildFieldpostprocessor findOneById(int $id) Return the first ChildFieldpostprocessor filtered by the id column
 * @method     ChildFieldpostprocessor findOneByName(string $_name) Return the first ChildFieldpostprocessor filtered by the _name column
 * @method     ChildFieldpostprocessor findOneByCode(string $_code) Return the first ChildFieldpostprocessor filtered by the _code column
 * @method     ChildFieldpostprocessor findOneByConfigSys(string $__config__) Return the first ChildFieldpostprocessor filtered by the __config__ column
 * @method     ChildFieldpostprocessor findOneBySplit(string $__split__) Return the first ChildFieldpostprocessor filtered by the __split__ column
 * @method     ChildFieldpostprocessor findOneByParentnode(int $__parentnode__) Return the first ChildFieldpostprocessor filtered by the __parentnode__ column
 * @method     ChildFieldpostprocessor findOneBySort(int $__sort__) Return the first ChildFieldpostprocessor filtered by the __sort__ column *

 * @method     ChildFieldpostprocessor requirePk($key, ConnectionInterface $con = null) Return the ChildFieldpostprocessor by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFieldpostprocessor requireOne(ConnectionInterface $con = null) Return the first ChildFieldpostprocessor matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFieldpostprocessor requireOneById(int $id) Return the first ChildFieldpostprocessor filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFieldpostprocessor requireOneByName(string $_name) Return the first ChildFieldpostprocessor filtered by the _name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFieldpostprocessor requireOneByCode(string $_code) Return the first ChildFieldpostprocessor filtered by the _code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFieldpostprocessor requireOneByConfigSys(string $__config__) Return the first ChildFieldpostprocessor filtered by the __config__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFieldpostprocessor requireOneBySplit(string $__split__) Return the first ChildFieldpostprocessor filtered by the __split__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFieldpostprocessor requireOneByParentnode(int $__parentnode__) Return the first ChildFieldpostprocessor filtered by the __parentnode__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildFieldpostprocessor requireOneBySort(int $__sort__) Return the first ChildFieldpostprocessor filtered by the __sort__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildFieldpostprocessor[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildFieldpostprocessor objects based on current ModelCriteria
 * @method     ChildFieldpostprocessor[]|ObjectCollection findById(int $id) Return ChildFieldpostprocessor objects filtered by the id column
 * @method     ChildFieldpostprocessor[]|ObjectCollection findByName(string $_name) Return ChildFieldpostprocessor objects filtered by the _name column
 * @method     ChildFieldpostprocessor[]|ObjectCollection findByCode(string $_code) Return ChildFieldpostprocessor objects filtered by the _code column
 * @method     ChildFieldpostprocessor[]|ObjectCollection findByConfigSys(string $__config__) Return ChildFieldpostprocessor objects filtered by the __config__ column
 * @method     ChildFieldpostprocessor[]|ObjectCollection findBySplit(string $__split__) Return ChildFieldpostprocessor objects filtered by the __split__ column
 * @method     ChildFieldpostprocessor[]|ObjectCollection findByParentnode(int $__parentnode__) Return ChildFieldpostprocessor objects filtered by the __parentnode__ column
 * @method     ChildFieldpostprocessor[]|ObjectCollection findBySort(int $__sort__) Return ChildFieldpostprocessor objects filtered by the __sort__ column
 * @method     ChildFieldpostprocessor[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class FieldpostprocessorQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\FieldpostprocessorQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\Fieldpostprocessor', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildFieldpostprocessorQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildFieldpostprocessorQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildFieldpostprocessorQuery) {
            return $criteria;
        }
        $query = new ChildFieldpostprocessorQuery();
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
     * @return ChildFieldpostprocessor|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FieldpostprocessorTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = FieldpostprocessorTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildFieldpostprocessor A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, _name, _code, __config__, __split__, __parentnode__, __sort__ FROM _fieldpostprocessor WHERE id = :p0';
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
            /** @var ChildFieldpostprocessor $obj */
            $obj = new ChildFieldpostprocessor();
            $obj->hydrate($row);
            FieldpostprocessorTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildFieldpostprocessor|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildFieldpostprocessorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FieldpostprocessorTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildFieldpostprocessorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FieldpostprocessorTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildFieldpostprocessorQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(FieldpostprocessorTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(FieldpostprocessorTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FieldpostprocessorTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildFieldpostprocessorQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FieldpostprocessorTableMap::COL__NAME, $name, $comparison);
    }

    /**
     * Filter the query on the _code column
     *
     * Example usage:
     * <code>
     * $query->filterByCode('fooValue');   // WHERE _code = 'fooValue'
     * $query->filterByCode('%fooValue%', Criteria::LIKE); // WHERE _code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $code The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildFieldpostprocessorQuery The current query, for fluid interface
     */
    public function filterByCode($code = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($code)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FieldpostprocessorTableMap::COL__CODE, $code, $comparison);
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
     * @return $this|ChildFieldpostprocessorQuery The current query, for fluid interface
     */
    public function filterByConfigSys($configSys = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($configSys)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FieldpostprocessorTableMap::COL___CONFIG__, $configSys, $comparison);
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
     * @return $this|ChildFieldpostprocessorQuery The current query, for fluid interface
     */
    public function filterBySplit($split = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($split)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FieldpostprocessorTableMap::COL___SPLIT__, $split, $comparison);
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
     * @return $this|ChildFieldpostprocessorQuery The current query, for fluid interface
     */
    public function filterByParentnode($parentnode = null, $comparison = null)
    {
        if (is_array($parentnode)) {
            $useMinMax = false;
            if (isset($parentnode['min'])) {
                $this->addUsingAlias(FieldpostprocessorTableMap::COL___PARENTNODE__, $parentnode['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentnode['max'])) {
                $this->addUsingAlias(FieldpostprocessorTableMap::COL___PARENTNODE__, $parentnode['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FieldpostprocessorTableMap::COL___PARENTNODE__, $parentnode, $comparison);
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
     * @return $this|ChildFieldpostprocessorQuery The current query, for fluid interface
     */
    public function filterBySort($sort = null, $comparison = null)
    {
        if (is_array($sort)) {
            $useMinMax = false;
            if (isset($sort['min'])) {
                $this->addUsingAlias(FieldpostprocessorTableMap::COL___SORT__, $sort['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sort['max'])) {
                $this->addUsingAlias(FieldpostprocessorTableMap::COL___SORT__, $sort['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FieldpostprocessorTableMap::COL___SORT__, $sort, $comparison);
    }

    /**
     * Filter the query by a related \RFieldpostprocessorForfield object
     *
     * @param \RFieldpostprocessorForfield|ObjectCollection $rFieldpostprocessorForfield the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFieldpostprocessorQuery The current query, for fluid interface
     */
    public function filterByRFieldpostprocessorForfield($rFieldpostprocessorForfield, $comparison = null)
    {
        if ($rFieldpostprocessorForfield instanceof \RFieldpostprocessorForfield) {
            return $this
                ->addUsingAlias(FieldpostprocessorTableMap::COL_ID, $rFieldpostprocessorForfield->getPostprocessorid(), $comparison);
        } elseif ($rFieldpostprocessorForfield instanceof ObjectCollection) {
            return $this
                ->useRFieldpostprocessorForfieldQuery()
                ->filterByPrimaryKeys($rFieldpostprocessorForfield->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRFieldpostprocessorForfield() only accepts arguments of type \RFieldpostprocessorForfield or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RFieldpostprocessorForfield relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildFieldpostprocessorQuery The current query, for fluid interface
     */
    public function joinRFieldpostprocessorForfield($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RFieldpostprocessorForfield');

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
            $this->addJoinObject($join, 'RFieldpostprocessorForfield');
        }

        return $this;
    }

    /**
     * Use the RFieldpostprocessorForfield relation RFieldpostprocessorForfield object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RFieldpostprocessorForfieldQuery A secondary query class using the current class as primary query
     */
    public function useRFieldpostprocessorForfieldQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRFieldpostprocessorForfield($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RFieldpostprocessorForfield', '\RFieldpostprocessorForfieldQuery');
    }

    /**
     * Filter the query by a related Templates object
     * using the R_fieldpostprocessor_forfield table as cross reference
     *
     * @param Templates $templates the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFieldpostprocessorQuery The current query, for fluid interface
     */
    public function filterByTemplates($templates, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRFieldpostprocessorForfieldQuery()
            ->filterByTemplates($templates, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildFieldpostprocessor $fieldpostprocessor Object to remove from the list of results
     *
     * @return $this|ChildFieldpostprocessorQuery The current query, for fluid interface
     */
    public function prune($fieldpostprocessor = null)
    {
        if ($fieldpostprocessor) {
            $this->addUsingAlias(FieldpostprocessorTableMap::COL_ID, $fieldpostprocessor->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the _fieldpostprocessor table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FieldpostprocessorTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            FieldpostprocessorTableMap::clearInstancePool();
            FieldpostprocessorTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(FieldpostprocessorTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(FieldpostprocessorTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            FieldpostprocessorTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            FieldpostprocessorTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // FieldpostprocessorQuery
