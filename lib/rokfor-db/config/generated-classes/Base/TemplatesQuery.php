<?php

namespace Base;

use \Templates as ChildTemplates;
use \TemplatesQuery as ChildTemplatesQuery;
use \Exception;
use \PDO;
use Map\TemplatesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the '_templates' table.
 *
 *
 *
 * @method     ChildTemplatesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTemplatesQuery orderByFortemplate($order = Criteria::ASC) Order by the _fortemplate column
 * @method     ChildTemplatesQuery orderByFieldname($order = Criteria::ASC) Order by the _fieldname column
 * @method     ChildTemplatesQuery orderByHelpdescription($order = Criteria::ASC) Order by the _helpdescription column
 * @method     ChildTemplatesQuery orderByHelpimage($order = Criteria::ASC) Order by the _helpimage column
 * @method     ChildTemplatesQuery orderByFieldtype($order = Criteria::ASC) Order by the _fieldtype column
 * @method     ChildTemplatesQuery orderByConfigSys($order = Criteria::ASC) Order by the __config__ column
 * @method     ChildTemplatesQuery orderBySplit($order = Criteria::ASC) Order by the __split__ column
 * @method     ChildTemplatesQuery orderByParentnode($order = Criteria::ASC) Order by the __parentnode__ column
 * @method     ChildTemplatesQuery orderBySort($order = Criteria::ASC) Order by the __sort__ column
 *
 * @method     ChildTemplatesQuery groupById() Group by the id column
 * @method     ChildTemplatesQuery groupByFortemplate() Group by the _fortemplate column
 * @method     ChildTemplatesQuery groupByFieldname() Group by the _fieldname column
 * @method     ChildTemplatesQuery groupByHelpdescription() Group by the _helpdescription column
 * @method     ChildTemplatesQuery groupByHelpimage() Group by the _helpimage column
 * @method     ChildTemplatesQuery groupByFieldtype() Group by the _fieldtype column
 * @method     ChildTemplatesQuery groupByConfigSys() Group by the __config__ column
 * @method     ChildTemplatesQuery groupBySplit() Group by the __split__ column
 * @method     ChildTemplatesQuery groupByParentnode() Group by the __parentnode__ column
 * @method     ChildTemplatesQuery groupBySort() Group by the __sort__ column
 *
 * @method     ChildTemplatesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTemplatesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTemplatesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTemplatesQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTemplatesQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTemplatesQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTemplatesQuery leftJoinTemplatenames($relationAlias = null) Adds a LEFT JOIN clause to the query using the Templatenames relation
 * @method     ChildTemplatesQuery rightJoinTemplatenames($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Templatenames relation
 * @method     ChildTemplatesQuery innerJoinTemplatenames($relationAlias = null) Adds a INNER JOIN clause to the query using the Templatenames relation
 *
 * @method     ChildTemplatesQuery joinWithTemplatenames($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Templatenames relation
 *
 * @method     ChildTemplatesQuery leftJoinWithTemplatenames() Adds a LEFT JOIN clause and with to the query using the Templatenames relation
 * @method     ChildTemplatesQuery rightJoinWithTemplatenames() Adds a RIGHT JOIN clause and with to the query using the Templatenames relation
 * @method     ChildTemplatesQuery innerJoinWithTemplatenames() Adds a INNER JOIN clause and with to the query using the Templatenames relation
 *
 * @method     ChildTemplatesQuery leftJoinRFieldpostprocessorForfield($relationAlias = null) Adds a LEFT JOIN clause to the query using the RFieldpostprocessorForfield relation
 * @method     ChildTemplatesQuery rightJoinRFieldpostprocessorForfield($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RFieldpostprocessorForfield relation
 * @method     ChildTemplatesQuery innerJoinRFieldpostprocessorForfield($relationAlias = null) Adds a INNER JOIN clause to the query using the RFieldpostprocessorForfield relation
 *
 * @method     ChildTemplatesQuery joinWithRFieldpostprocessorForfield($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RFieldpostprocessorForfield relation
 *
 * @method     ChildTemplatesQuery leftJoinWithRFieldpostprocessorForfield() Adds a LEFT JOIN clause and with to the query using the RFieldpostprocessorForfield relation
 * @method     ChildTemplatesQuery rightJoinWithRFieldpostprocessorForfield() Adds a RIGHT JOIN clause and with to the query using the RFieldpostprocessorForfield relation
 * @method     ChildTemplatesQuery innerJoinWithRFieldpostprocessorForfield() Adds a INNER JOIN clause and with to the query using the RFieldpostprocessorForfield relation
 *
 * @method     ChildTemplatesQuery leftJoinData($relationAlias = null) Adds a LEFT JOIN clause to the query using the Data relation
 * @method     ChildTemplatesQuery rightJoinData($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Data relation
 * @method     ChildTemplatesQuery innerJoinData($relationAlias = null) Adds a INNER JOIN clause to the query using the Data relation
 *
 * @method     ChildTemplatesQuery joinWithData($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Data relation
 *
 * @method     ChildTemplatesQuery leftJoinWithData() Adds a LEFT JOIN clause and with to the query using the Data relation
 * @method     ChildTemplatesQuery rightJoinWithData() Adds a RIGHT JOIN clause and with to the query using the Data relation
 * @method     ChildTemplatesQuery innerJoinWithData() Adds a INNER JOIN clause and with to the query using the Data relation
 *
 * @method     ChildTemplatesQuery leftJoinRDataTemplate($relationAlias = null) Adds a LEFT JOIN clause to the query using the RDataTemplate relation
 * @method     ChildTemplatesQuery rightJoinRDataTemplate($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RDataTemplate relation
 * @method     ChildTemplatesQuery innerJoinRDataTemplate($relationAlias = null) Adds a INNER JOIN clause to the query using the RDataTemplate relation
 *
 * @method     ChildTemplatesQuery joinWithRDataTemplate($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RDataTemplate relation
 *
 * @method     ChildTemplatesQuery leftJoinWithRDataTemplate() Adds a LEFT JOIN clause and with to the query using the RDataTemplate relation
 * @method     ChildTemplatesQuery rightJoinWithRDataTemplate() Adds a RIGHT JOIN clause and with to the query using the RDataTemplate relation
 * @method     ChildTemplatesQuery innerJoinWithRDataTemplate() Adds a INNER JOIN clause and with to the query using the RDataTemplate relation
 *
 * @method     \TemplatenamesQuery|\RFieldpostprocessorForfieldQuery|\DataQuery|\RDataTemplateQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTemplates findOne(ConnectionInterface $con = null) Return the first ChildTemplates matching the query
 * @method     ChildTemplates findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTemplates matching the query, or a new ChildTemplates object populated from the query conditions when no match is found
 *
 * @method     ChildTemplates findOneById(int $id) Return the first ChildTemplates filtered by the id column
 * @method     ChildTemplates findOneByFortemplate(int $_fortemplate) Return the first ChildTemplates filtered by the _fortemplate column
 * @method     ChildTemplates findOneByFieldname(string $_fieldname) Return the first ChildTemplates filtered by the _fieldname column
 * @method     ChildTemplates findOneByHelpdescription(string $_helpdescription) Return the first ChildTemplates filtered by the _helpdescription column
 * @method     ChildTemplates findOneByHelpimage(string $_helpimage) Return the first ChildTemplates filtered by the _helpimage column
 * @method     ChildTemplates findOneByFieldtype(string $_fieldtype) Return the first ChildTemplates filtered by the _fieldtype column
 * @method     ChildTemplates findOneByConfigSys(string $__config__) Return the first ChildTemplates filtered by the __config__ column
 * @method     ChildTemplates findOneBySplit(string $__split__) Return the first ChildTemplates filtered by the __split__ column
 * @method     ChildTemplates findOneByParentnode(int $__parentnode__) Return the first ChildTemplates filtered by the __parentnode__ column
 * @method     ChildTemplates findOneBySort(int $__sort__) Return the first ChildTemplates filtered by the __sort__ column *

 * @method     ChildTemplates requirePk($key, ConnectionInterface $con = null) Return the ChildTemplates by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTemplates requireOne(ConnectionInterface $con = null) Return the first ChildTemplates matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTemplates requireOneById(int $id) Return the first ChildTemplates filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTemplates requireOneByFortemplate(int $_fortemplate) Return the first ChildTemplates filtered by the _fortemplate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTemplates requireOneByFieldname(string $_fieldname) Return the first ChildTemplates filtered by the _fieldname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTemplates requireOneByHelpdescription(string $_helpdescription) Return the first ChildTemplates filtered by the _helpdescription column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTemplates requireOneByHelpimage(string $_helpimage) Return the first ChildTemplates filtered by the _helpimage column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTemplates requireOneByFieldtype(string $_fieldtype) Return the first ChildTemplates filtered by the _fieldtype column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTemplates requireOneByConfigSys(string $__config__) Return the first ChildTemplates filtered by the __config__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTemplates requireOneBySplit(string $__split__) Return the first ChildTemplates filtered by the __split__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTemplates requireOneByParentnode(int $__parentnode__) Return the first ChildTemplates filtered by the __parentnode__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTemplates requireOneBySort(int $__sort__) Return the first ChildTemplates filtered by the __sort__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTemplates[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTemplates objects based on current ModelCriteria
 * @method     ChildTemplates[]|ObjectCollection findById(int $id) Return ChildTemplates objects filtered by the id column
 * @method     ChildTemplates[]|ObjectCollection findByFortemplate(int $_fortemplate) Return ChildTemplates objects filtered by the _fortemplate column
 * @method     ChildTemplates[]|ObjectCollection findByFieldname(string $_fieldname) Return ChildTemplates objects filtered by the _fieldname column
 * @method     ChildTemplates[]|ObjectCollection findByHelpdescription(string $_helpdescription) Return ChildTemplates objects filtered by the _helpdescription column
 * @method     ChildTemplates[]|ObjectCollection findByHelpimage(string $_helpimage) Return ChildTemplates objects filtered by the _helpimage column
 * @method     ChildTemplates[]|ObjectCollection findByFieldtype(string $_fieldtype) Return ChildTemplates objects filtered by the _fieldtype column
 * @method     ChildTemplates[]|ObjectCollection findByConfigSys(string $__config__) Return ChildTemplates objects filtered by the __config__ column
 * @method     ChildTemplates[]|ObjectCollection findBySplit(string $__split__) Return ChildTemplates objects filtered by the __split__ column
 * @method     ChildTemplates[]|ObjectCollection findByParentnode(int $__parentnode__) Return ChildTemplates objects filtered by the __parentnode__ column
 * @method     ChildTemplates[]|ObjectCollection findBySort(int $__sort__) Return ChildTemplates objects filtered by the __sort__ column
 * @method     ChildTemplates[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TemplatesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\TemplatesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\Templates', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTemplatesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTemplatesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTemplatesQuery) {
            return $criteria;
        }
        $query = new ChildTemplatesQuery();
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
     * @return ChildTemplates|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TemplatesTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = TemplatesTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildTemplates A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, _fortemplate, _fieldname, _helpdescription, _helpimage, _fieldtype, __config__, __split__, __parentnode__, __sort__ FROM _templates WHERE id = :p0';
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
            /** @var ChildTemplates $obj */
            $obj = new ChildTemplates();
            $obj->hydrate($row);
            TemplatesTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildTemplates|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTemplatesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TemplatesTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTemplatesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TemplatesTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildTemplatesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TemplatesTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TemplatesTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TemplatesTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the _fortemplate column
     *
     * Example usage:
     * <code>
     * $query->filterByFortemplate(1234); // WHERE _fortemplate = 1234
     * $query->filterByFortemplate(array(12, 34)); // WHERE _fortemplate IN (12, 34)
     * $query->filterByFortemplate(array('min' => 12)); // WHERE _fortemplate > 12
     * </code>
     *
     * @see       filterByTemplatenames()
     *
     * @param     mixed $fortemplate The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTemplatesQuery The current query, for fluid interface
     */
    public function filterByFortemplate($fortemplate = null, $comparison = null)
    {
        if (is_array($fortemplate)) {
            $useMinMax = false;
            if (isset($fortemplate['min'])) {
                $this->addUsingAlias(TemplatesTableMap::COL__FORTEMPLATE, $fortemplate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fortemplate['max'])) {
                $this->addUsingAlias(TemplatesTableMap::COL__FORTEMPLATE, $fortemplate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TemplatesTableMap::COL__FORTEMPLATE, $fortemplate, $comparison);
    }

    /**
     * Filter the query on the _fieldname column
     *
     * Example usage:
     * <code>
     * $query->filterByFieldname('fooValue');   // WHERE _fieldname = 'fooValue'
     * $query->filterByFieldname('%fooValue%', Criteria::LIKE); // WHERE _fieldname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fieldname The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTemplatesQuery The current query, for fluid interface
     */
    public function filterByFieldname($fieldname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fieldname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TemplatesTableMap::COL__FIELDNAME, $fieldname, $comparison);
    }

    /**
     * Filter the query on the _helpdescription column
     *
     * Example usage:
     * <code>
     * $query->filterByHelpdescription('fooValue');   // WHERE _helpdescription = 'fooValue'
     * $query->filterByHelpdescription('%fooValue%', Criteria::LIKE); // WHERE _helpdescription LIKE '%fooValue%'
     * </code>
     *
     * @param     string $helpdescription The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTemplatesQuery The current query, for fluid interface
     */
    public function filterByHelpdescription($helpdescription = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($helpdescription)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TemplatesTableMap::COL__HELPDESCRIPTION, $helpdescription, $comparison);
    }

    /**
     * Filter the query on the _helpimage column
     *
     * Example usage:
     * <code>
     * $query->filterByHelpimage('fooValue');   // WHERE _helpimage = 'fooValue'
     * $query->filterByHelpimage('%fooValue%', Criteria::LIKE); // WHERE _helpimage LIKE '%fooValue%'
     * </code>
     *
     * @param     string $helpimage The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTemplatesQuery The current query, for fluid interface
     */
    public function filterByHelpimage($helpimage = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($helpimage)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TemplatesTableMap::COL__HELPIMAGE, $helpimage, $comparison);
    }

    /**
     * Filter the query on the _fieldtype column
     *
     * Example usage:
     * <code>
     * $query->filterByFieldtype('fooValue');   // WHERE _fieldtype = 'fooValue'
     * $query->filterByFieldtype('%fooValue%', Criteria::LIKE); // WHERE _fieldtype LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fieldtype The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTemplatesQuery The current query, for fluid interface
     */
    public function filterByFieldtype($fieldtype = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fieldtype)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TemplatesTableMap::COL__FIELDTYPE, $fieldtype, $comparison);
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
     * @return $this|ChildTemplatesQuery The current query, for fluid interface
     */
    public function filterByConfigSys($configSys = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($configSys)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TemplatesTableMap::COL___CONFIG__, $configSys, $comparison);
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
     * @return $this|ChildTemplatesQuery The current query, for fluid interface
     */
    public function filterBySplit($split = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($split)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TemplatesTableMap::COL___SPLIT__, $split, $comparison);
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
     * @return $this|ChildTemplatesQuery The current query, for fluid interface
     */
    public function filterByParentnode($parentnode = null, $comparison = null)
    {
        if (is_array($parentnode)) {
            $useMinMax = false;
            if (isset($parentnode['min'])) {
                $this->addUsingAlias(TemplatesTableMap::COL___PARENTNODE__, $parentnode['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentnode['max'])) {
                $this->addUsingAlias(TemplatesTableMap::COL___PARENTNODE__, $parentnode['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TemplatesTableMap::COL___PARENTNODE__, $parentnode, $comparison);
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
     * @return $this|ChildTemplatesQuery The current query, for fluid interface
     */
    public function filterBySort($sort = null, $comparison = null)
    {
        if (is_array($sort)) {
            $useMinMax = false;
            if (isset($sort['min'])) {
                $this->addUsingAlias(TemplatesTableMap::COL___SORT__, $sort['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sort['max'])) {
                $this->addUsingAlias(TemplatesTableMap::COL___SORT__, $sort['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TemplatesTableMap::COL___SORT__, $sort, $comparison);
    }

    /**
     * Filter the query by a related \Templatenames object
     *
     * @param \Templatenames|ObjectCollection $templatenames The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTemplatesQuery The current query, for fluid interface
     */
    public function filterByTemplatenames($templatenames, $comparison = null)
    {
        if ($templatenames instanceof \Templatenames) {
            return $this
                ->addUsingAlias(TemplatesTableMap::COL__FORTEMPLATE, $templatenames->getId(), $comparison);
        } elseif ($templatenames instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TemplatesTableMap::COL__FORTEMPLATE, $templatenames->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByTemplatenames() only accepts arguments of type \Templatenames or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Templatenames relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTemplatesQuery The current query, for fluid interface
     */
    public function joinTemplatenames($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Templatenames');

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
            $this->addJoinObject($join, 'Templatenames');
        }

        return $this;
    }

    /**
     * Use the Templatenames relation Templatenames object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TemplatenamesQuery A secondary query class using the current class as primary query
     */
    public function useTemplatenamesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTemplatenames($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Templatenames', '\TemplatenamesQuery');
    }

    /**
     * Filter the query by a related \RFieldpostprocessorForfield object
     *
     * @param \RFieldpostprocessorForfield|ObjectCollection $rFieldpostprocessorForfield the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTemplatesQuery The current query, for fluid interface
     */
    public function filterByRFieldpostprocessorForfield($rFieldpostprocessorForfield, $comparison = null)
    {
        if ($rFieldpostprocessorForfield instanceof \RFieldpostprocessorForfield) {
            return $this
                ->addUsingAlias(TemplatesTableMap::COL_ID, $rFieldpostprocessorForfield->getTemplateid(), $comparison);
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
     * @return $this|ChildTemplatesQuery The current query, for fluid interface
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
     * Filter the query by a related \Data object
     *
     * @param \Data|ObjectCollection $data the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTemplatesQuery The current query, for fluid interface
     */
    public function filterByData($data, $comparison = null)
    {
        if ($data instanceof \Data) {
            return $this
                ->addUsingAlias(TemplatesTableMap::COL_ID, $data->getFortemplatefield(), $comparison);
        } elseif ($data instanceof ObjectCollection) {
            return $this
                ->useDataQuery()
                ->filterByPrimaryKeys($data->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByData() only accepts arguments of type \Data or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Data relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTemplatesQuery The current query, for fluid interface
     */
    public function joinData($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Data');

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
            $this->addJoinObject($join, 'Data');
        }

        return $this;
    }

    /**
     * Use the Data relation Data object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DataQuery A secondary query class using the current class as primary query
     */
    public function useDataQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinData($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Data', '\DataQuery');
    }

    /**
     * Filter the query by a related \RDataTemplate object
     *
     * @param \RDataTemplate|ObjectCollection $rDataTemplate the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTemplatesQuery The current query, for fluid interface
     */
    public function filterByRDataTemplate($rDataTemplate, $comparison = null)
    {
        if ($rDataTemplate instanceof \RDataTemplate) {
            return $this
                ->addUsingAlias(TemplatesTableMap::COL_ID, $rDataTemplate->getTemplateid(), $comparison);
        } elseif ($rDataTemplate instanceof ObjectCollection) {
            return $this
                ->useRDataTemplateQuery()
                ->filterByPrimaryKeys($rDataTemplate->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRDataTemplate() only accepts arguments of type \RDataTemplate or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RDataTemplate relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTemplatesQuery The current query, for fluid interface
     */
    public function joinRDataTemplate($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RDataTemplate');

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
            $this->addJoinObject($join, 'RDataTemplate');
        }

        return $this;
    }

    /**
     * Use the RDataTemplate relation RDataTemplate object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RDataTemplateQuery A secondary query class using the current class as primary query
     */
    public function useRDataTemplateQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRDataTemplate($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RDataTemplate', '\RDataTemplateQuery');
    }

    /**
     * Filter the query by a related Fieldpostprocessor object
     * using the R_fieldpostprocessor_forfield table as cross reference
     *
     * @param Fieldpostprocessor $fieldpostprocessor the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTemplatesQuery The current query, for fluid interface
     */
    public function filterByFieldpostprocessor($fieldpostprocessor, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRFieldpostprocessorForfieldQuery()
            ->filterByFieldpostprocessor($fieldpostprocessor, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Data object
     * using the R_data_template table as cross reference
     *
     * @param Data $data the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTemplatesQuery The current query, for fluid interface
     */
    public function filterByRData($data, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRDataTemplateQuery()
            ->filterByRData($data, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTemplates $templates Object to remove from the list of results
     *
     * @return $this|ChildTemplatesQuery The current query, for fluid interface
     */
    public function prune($templates = null)
    {
        if ($templates) {
            $this->addUsingAlias(TemplatesTableMap::COL_ID, $templates->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the _templates table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TemplatesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TemplatesTableMap::clearInstancePool();
            TemplatesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TemplatesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TemplatesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TemplatesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TemplatesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TemplatesQuery
