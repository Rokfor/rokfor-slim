<?php

namespace Base;

use \Templatenames as ChildTemplatenames;
use \TemplatenamesQuery as ChildTemplatenamesQuery;
use \Exception;
use \PDO;
use Map\TemplatenamesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the '_templatenames' table.
 *
 *
 *
 * @method     ChildTemplatenamesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTemplatenamesQuery orderByName($order = Criteria::ASC) Order by the _name column
 * @method     ChildTemplatenamesQuery orderByHelptext($order = Criteria::ASC) Order by the _helptext column
 * @method     ChildTemplatenamesQuery orderByHelpimage($order = Criteria::ASC) Order by the _helpimage column
 * @method     ChildTemplatenamesQuery orderByCategory($order = Criteria::ASC) Order by the _category column
 * @method     ChildTemplatenamesQuery orderByPublic($order = Criteria::ASC) Order by the _public column
 * @method     ChildTemplatenamesQuery orderByConfigSys($order = Criteria::ASC) Order by the __config__ column
 * @method     ChildTemplatenamesQuery orderBySplit($order = Criteria::ASC) Order by the __split__ column
 * @method     ChildTemplatenamesQuery orderBySort($order = Criteria::ASC) Order by the __sort__ column
 * @method     ChildTemplatenamesQuery orderByParentnode($order = Criteria::ASC) Order by the __parentnode__ column
 *
 * @method     ChildTemplatenamesQuery groupById() Group by the id column
 * @method     ChildTemplatenamesQuery groupByName() Group by the _name column
 * @method     ChildTemplatenamesQuery groupByHelptext() Group by the _helptext column
 * @method     ChildTemplatenamesQuery groupByHelpimage() Group by the _helpimage column
 * @method     ChildTemplatenamesQuery groupByCategory() Group by the _category column
 * @method     ChildTemplatenamesQuery groupByPublic() Group by the _public column
 * @method     ChildTemplatenamesQuery groupByConfigSys() Group by the __config__ column
 * @method     ChildTemplatenamesQuery groupBySplit() Group by the __split__ column
 * @method     ChildTemplatenamesQuery groupBySort() Group by the __sort__ column
 * @method     ChildTemplatenamesQuery groupByParentnode() Group by the __parentnode__ column
 *
 * @method     ChildTemplatenamesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTemplatenamesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTemplatenamesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTemplatenamesQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTemplatenamesQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTemplatenamesQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTemplatenamesQuery leftJoinRRightsFortemplate($relationAlias = null) Adds a LEFT JOIN clause to the query using the RRightsFortemplate relation
 * @method     ChildTemplatenamesQuery rightJoinRRightsFortemplate($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RRightsFortemplate relation
 * @method     ChildTemplatenamesQuery innerJoinRRightsFortemplate($relationAlias = null) Adds a INNER JOIN clause to the query using the RRightsFortemplate relation
 *
 * @method     ChildTemplatenamesQuery joinWithRRightsFortemplate($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RRightsFortemplate relation
 *
 * @method     ChildTemplatenamesQuery leftJoinWithRRightsFortemplate() Adds a LEFT JOIN clause and with to the query using the RRightsFortemplate relation
 * @method     ChildTemplatenamesQuery rightJoinWithRRightsFortemplate() Adds a RIGHT JOIN clause and with to the query using the RRightsFortemplate relation
 * @method     ChildTemplatenamesQuery innerJoinWithRRightsFortemplate() Adds a INNER JOIN clause and with to the query using the RRightsFortemplate relation
 *
 * @method     ChildTemplatenamesQuery leftJoinRTemplatenamesForbook($relationAlias = null) Adds a LEFT JOIN clause to the query using the RTemplatenamesForbook relation
 * @method     ChildTemplatenamesQuery rightJoinRTemplatenamesForbook($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RTemplatenamesForbook relation
 * @method     ChildTemplatenamesQuery innerJoinRTemplatenamesForbook($relationAlias = null) Adds a INNER JOIN clause to the query using the RTemplatenamesForbook relation
 *
 * @method     ChildTemplatenamesQuery joinWithRTemplatenamesForbook($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RTemplatenamesForbook relation
 *
 * @method     ChildTemplatenamesQuery leftJoinWithRTemplatenamesForbook() Adds a LEFT JOIN clause and with to the query using the RTemplatenamesForbook relation
 * @method     ChildTemplatenamesQuery rightJoinWithRTemplatenamesForbook() Adds a RIGHT JOIN clause and with to the query using the RTemplatenamesForbook relation
 * @method     ChildTemplatenamesQuery innerJoinWithRTemplatenamesForbook() Adds a INNER JOIN clause and with to the query using the RTemplatenamesForbook relation
 *
 * @method     ChildTemplatenamesQuery leftJoinRTemplatenamesInchapter($relationAlias = null) Adds a LEFT JOIN clause to the query using the RTemplatenamesInchapter relation
 * @method     ChildTemplatenamesQuery rightJoinRTemplatenamesInchapter($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RTemplatenamesInchapter relation
 * @method     ChildTemplatenamesQuery innerJoinRTemplatenamesInchapter($relationAlias = null) Adds a INNER JOIN clause to the query using the RTemplatenamesInchapter relation
 *
 * @method     ChildTemplatenamesQuery joinWithRTemplatenamesInchapter($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RTemplatenamesInchapter relation
 *
 * @method     ChildTemplatenamesQuery leftJoinWithRTemplatenamesInchapter() Adds a LEFT JOIN clause and with to the query using the RTemplatenamesInchapter relation
 * @method     ChildTemplatenamesQuery rightJoinWithRTemplatenamesInchapter() Adds a RIGHT JOIN clause and with to the query using the RTemplatenamesInchapter relation
 * @method     ChildTemplatenamesQuery innerJoinWithRTemplatenamesInchapter() Adds a INNER JOIN clause and with to the query using the RTemplatenamesInchapter relation
 *
 * @method     ChildTemplatenamesQuery leftJoinContributions($relationAlias = null) Adds a LEFT JOIN clause to the query using the Contributions relation
 * @method     ChildTemplatenamesQuery rightJoinContributions($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Contributions relation
 * @method     ChildTemplatenamesQuery innerJoinContributions($relationAlias = null) Adds a INNER JOIN clause to the query using the Contributions relation
 *
 * @method     ChildTemplatenamesQuery joinWithContributions($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Contributions relation
 *
 * @method     ChildTemplatenamesQuery leftJoinWithContributions() Adds a LEFT JOIN clause and with to the query using the Contributions relation
 * @method     ChildTemplatenamesQuery rightJoinWithContributions() Adds a RIGHT JOIN clause and with to the query using the Contributions relation
 * @method     ChildTemplatenamesQuery innerJoinWithContributions() Adds a INNER JOIN clause and with to the query using the Contributions relation
 *
 * @method     ChildTemplatenamesQuery leftJoinRPluginTemplate($relationAlias = null) Adds a LEFT JOIN clause to the query using the RPluginTemplate relation
 * @method     ChildTemplatenamesQuery rightJoinRPluginTemplate($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RPluginTemplate relation
 * @method     ChildTemplatenamesQuery innerJoinRPluginTemplate($relationAlias = null) Adds a INNER JOIN clause to the query using the RPluginTemplate relation
 *
 * @method     ChildTemplatenamesQuery joinWithRPluginTemplate($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RPluginTemplate relation
 *
 * @method     ChildTemplatenamesQuery leftJoinWithRPluginTemplate() Adds a LEFT JOIN clause and with to the query using the RPluginTemplate relation
 * @method     ChildTemplatenamesQuery rightJoinWithRPluginTemplate() Adds a RIGHT JOIN clause and with to the query using the RPluginTemplate relation
 * @method     ChildTemplatenamesQuery innerJoinWithRPluginTemplate() Adds a INNER JOIN clause and with to the query using the RPluginTemplate relation
 *
 * @method     ChildTemplatenamesQuery leftJoinTemplates($relationAlias = null) Adds a LEFT JOIN clause to the query using the Templates relation
 * @method     ChildTemplatenamesQuery rightJoinTemplates($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Templates relation
 * @method     ChildTemplatenamesQuery innerJoinTemplates($relationAlias = null) Adds a INNER JOIN clause to the query using the Templates relation
 *
 * @method     ChildTemplatenamesQuery joinWithTemplates($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Templates relation
 *
 * @method     ChildTemplatenamesQuery leftJoinWithTemplates() Adds a LEFT JOIN clause and with to the query using the Templates relation
 * @method     ChildTemplatenamesQuery rightJoinWithTemplates() Adds a RIGHT JOIN clause and with to the query using the Templates relation
 * @method     ChildTemplatenamesQuery innerJoinWithTemplates() Adds a INNER JOIN clause and with to the query using the Templates relation
 *
 * @method     \RRightsFortemplateQuery|\RTemplatenamesForbookQuery|\RTemplatenamesInchapterQuery|\ContributionsQuery|\RPluginTemplateQuery|\TemplatesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTemplatenames findOne(ConnectionInterface $con = null) Return the first ChildTemplatenames matching the query
 * @method     ChildTemplatenames findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTemplatenames matching the query, or a new ChildTemplatenames object populated from the query conditions when no match is found
 *
 * @method     ChildTemplatenames findOneById(int $id) Return the first ChildTemplatenames filtered by the id column
 * @method     ChildTemplatenames findOneByName(string $_name) Return the first ChildTemplatenames filtered by the _name column
 * @method     ChildTemplatenames findOneByHelptext(string $_helptext) Return the first ChildTemplatenames filtered by the _helptext column
 * @method     ChildTemplatenames findOneByHelpimage(string $_helpimage) Return the first ChildTemplatenames filtered by the _helpimage column
 * @method     ChildTemplatenames findOneByCategory(string $_category) Return the first ChildTemplatenames filtered by the _category column
 * @method     ChildTemplatenames findOneByPublic(string $_public) Return the first ChildTemplatenames filtered by the _public column
 * @method     ChildTemplatenames findOneByConfigSys(string $__config__) Return the first ChildTemplatenames filtered by the __config__ column
 * @method     ChildTemplatenames findOneBySplit(string $__split__) Return the first ChildTemplatenames filtered by the __split__ column
 * @method     ChildTemplatenames findOneBySort(int $__sort__) Return the first ChildTemplatenames filtered by the __sort__ column
 * @method     ChildTemplatenames findOneByParentnode(int $__parentnode__) Return the first ChildTemplatenames filtered by the __parentnode__ column *

 * @method     ChildTemplatenames requirePk($key, ConnectionInterface $con = null) Return the ChildTemplatenames by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTemplatenames requireOne(ConnectionInterface $con = null) Return the first ChildTemplatenames matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTemplatenames requireOneById(int $id) Return the first ChildTemplatenames filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTemplatenames requireOneByName(string $_name) Return the first ChildTemplatenames filtered by the _name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTemplatenames requireOneByHelptext(string $_helptext) Return the first ChildTemplatenames filtered by the _helptext column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTemplatenames requireOneByHelpimage(string $_helpimage) Return the first ChildTemplatenames filtered by the _helpimage column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTemplatenames requireOneByCategory(string $_category) Return the first ChildTemplatenames filtered by the _category column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTemplatenames requireOneByPublic(string $_public) Return the first ChildTemplatenames filtered by the _public column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTemplatenames requireOneByConfigSys(string $__config__) Return the first ChildTemplatenames filtered by the __config__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTemplatenames requireOneBySplit(string $__split__) Return the first ChildTemplatenames filtered by the __split__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTemplatenames requireOneBySort(int $__sort__) Return the first ChildTemplatenames filtered by the __sort__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTemplatenames requireOneByParentnode(int $__parentnode__) Return the first ChildTemplatenames filtered by the __parentnode__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTemplatenames[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTemplatenames objects based on current ModelCriteria
 * @method     ChildTemplatenames[]|ObjectCollection findById(int $id) Return ChildTemplatenames objects filtered by the id column
 * @method     ChildTemplatenames[]|ObjectCollection findByName(string $_name) Return ChildTemplatenames objects filtered by the _name column
 * @method     ChildTemplatenames[]|ObjectCollection findByHelptext(string $_helptext) Return ChildTemplatenames objects filtered by the _helptext column
 * @method     ChildTemplatenames[]|ObjectCollection findByHelpimage(string $_helpimage) Return ChildTemplatenames objects filtered by the _helpimage column
 * @method     ChildTemplatenames[]|ObjectCollection findByCategory(string $_category) Return ChildTemplatenames objects filtered by the _category column
 * @method     ChildTemplatenames[]|ObjectCollection findByPublic(string $_public) Return ChildTemplatenames objects filtered by the _public column
 * @method     ChildTemplatenames[]|ObjectCollection findByConfigSys(string $__config__) Return ChildTemplatenames objects filtered by the __config__ column
 * @method     ChildTemplatenames[]|ObjectCollection findBySplit(string $__split__) Return ChildTemplatenames objects filtered by the __split__ column
 * @method     ChildTemplatenames[]|ObjectCollection findBySort(int $__sort__) Return ChildTemplatenames objects filtered by the __sort__ column
 * @method     ChildTemplatenames[]|ObjectCollection findByParentnode(int $__parentnode__) Return ChildTemplatenames objects filtered by the __parentnode__ column
 * @method     ChildTemplatenames[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TemplatenamesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\TemplatenamesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\Templatenames', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTemplatenamesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTemplatenamesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTemplatenamesQuery) {
            return $criteria;
        }
        $query = new ChildTemplatenamesQuery();
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
     * @return ChildTemplatenames|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TemplatenamesTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = TemplatenamesTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildTemplatenames A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, _name, _helptext, _helpimage, _category, _public, __config__, __split__, __sort__, __parentnode__ FROM _templatenames WHERE id = :p0';
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
            /** @var ChildTemplatenames $obj */
            $obj = new ChildTemplatenames();
            $obj->hydrate($row);
            TemplatenamesTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildTemplatenames|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTemplatenamesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TemplatenamesTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTemplatenamesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TemplatenamesTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildTemplatenamesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TemplatenamesTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TemplatenamesTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TemplatenamesTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildTemplatenamesQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TemplatenamesTableMap::COL__NAME, $name, $comparison);
    }

    /**
     * Filter the query on the _helptext column
     *
     * Example usage:
     * <code>
     * $query->filterByHelptext('fooValue');   // WHERE _helptext = 'fooValue'
     * $query->filterByHelptext('%fooValue%', Criteria::LIKE); // WHERE _helptext LIKE '%fooValue%'
     * </code>
     *
     * @param     string $helptext The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTemplatenamesQuery The current query, for fluid interface
     */
    public function filterByHelptext($helptext = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($helptext)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TemplatenamesTableMap::COL__HELPTEXT, $helptext, $comparison);
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
     * @return $this|ChildTemplatenamesQuery The current query, for fluid interface
     */
    public function filterByHelpimage($helpimage = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($helpimage)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TemplatenamesTableMap::COL__HELPIMAGE, $helpimage, $comparison);
    }

    /**
     * Filter the query on the _category column
     *
     * Example usage:
     * <code>
     * $query->filterByCategory('fooValue');   // WHERE _category = 'fooValue'
     * $query->filterByCategory('%fooValue%', Criteria::LIKE); // WHERE _category LIKE '%fooValue%'
     * </code>
     *
     * @param     string $category The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTemplatenamesQuery The current query, for fluid interface
     */
    public function filterByCategory($category = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($category)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TemplatenamesTableMap::COL__CATEGORY, $category, $comparison);
    }

    /**
     * Filter the query on the _public column
     *
     * Example usage:
     * <code>
     * $query->filterByPublic('fooValue');   // WHERE _public = 'fooValue'
     * $query->filterByPublic('%fooValue%', Criteria::LIKE); // WHERE _public LIKE '%fooValue%'
     * </code>
     *
     * @param     string $public The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTemplatenamesQuery The current query, for fluid interface
     */
    public function filterByPublic($public = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($public)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TemplatenamesTableMap::COL__PUBLIC, $public, $comparison);
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
     * @return $this|ChildTemplatenamesQuery The current query, for fluid interface
     */
    public function filterByConfigSys($configSys = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($configSys)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TemplatenamesTableMap::COL___CONFIG__, $configSys, $comparison);
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
     * @return $this|ChildTemplatenamesQuery The current query, for fluid interface
     */
    public function filterBySplit($split = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($split)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TemplatenamesTableMap::COL___SPLIT__, $split, $comparison);
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
     * @return $this|ChildTemplatenamesQuery The current query, for fluid interface
     */
    public function filterBySort($sort = null, $comparison = null)
    {
        if (is_array($sort)) {
            $useMinMax = false;
            if (isset($sort['min'])) {
                $this->addUsingAlias(TemplatenamesTableMap::COL___SORT__, $sort['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sort['max'])) {
                $this->addUsingAlias(TemplatenamesTableMap::COL___SORT__, $sort['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TemplatenamesTableMap::COL___SORT__, $sort, $comparison);
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
     * @return $this|ChildTemplatenamesQuery The current query, for fluid interface
     */
    public function filterByParentnode($parentnode = null, $comparison = null)
    {
        if (is_array($parentnode)) {
            $useMinMax = false;
            if (isset($parentnode['min'])) {
                $this->addUsingAlias(TemplatenamesTableMap::COL___PARENTNODE__, $parentnode['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentnode['max'])) {
                $this->addUsingAlias(TemplatenamesTableMap::COL___PARENTNODE__, $parentnode['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TemplatenamesTableMap::COL___PARENTNODE__, $parentnode, $comparison);
    }

    /**
     * Filter the query by a related \RRightsFortemplate object
     *
     * @param \RRightsFortemplate|ObjectCollection $rRightsFortemplate the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTemplatenamesQuery The current query, for fluid interface
     */
    public function filterByRRightsFortemplate($rRightsFortemplate, $comparison = null)
    {
        if ($rRightsFortemplate instanceof \RRightsFortemplate) {
            return $this
                ->addUsingAlias(TemplatenamesTableMap::COL_ID, $rRightsFortemplate->getTemplateid(), $comparison);
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
     * @return $this|ChildTemplatenamesQuery The current query, for fluid interface
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
     * Filter the query by a related \RTemplatenamesForbook object
     *
     * @param \RTemplatenamesForbook|ObjectCollection $rTemplatenamesForbook the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTemplatenamesQuery The current query, for fluid interface
     */
    public function filterByRTemplatenamesForbook($rTemplatenamesForbook, $comparison = null)
    {
        if ($rTemplatenamesForbook instanceof \RTemplatenamesForbook) {
            return $this
                ->addUsingAlias(TemplatenamesTableMap::COL_ID, $rTemplatenamesForbook->getTemplateid(), $comparison);
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
     * @return $this|ChildTemplatenamesQuery The current query, for fluid interface
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
     * Filter the query by a related \RTemplatenamesInchapter object
     *
     * @param \RTemplatenamesInchapter|ObjectCollection $rTemplatenamesInchapter the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTemplatenamesQuery The current query, for fluid interface
     */
    public function filterByRTemplatenamesInchapter($rTemplatenamesInchapter, $comparison = null)
    {
        if ($rTemplatenamesInchapter instanceof \RTemplatenamesInchapter) {
            return $this
                ->addUsingAlias(TemplatenamesTableMap::COL_ID, $rTemplatenamesInchapter->getTemplateid(), $comparison);
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
     * @return $this|ChildTemplatenamesQuery The current query, for fluid interface
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
     * @return ChildTemplatenamesQuery The current query, for fluid interface
     */
    public function filterByContributions($contributions, $comparison = null)
    {
        if ($contributions instanceof \Contributions) {
            return $this
                ->addUsingAlias(TemplatenamesTableMap::COL_ID, $contributions->getFortemplate(), $comparison);
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
     * @return $this|ChildTemplatenamesQuery The current query, for fluid interface
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
     * Filter the query by a related \RPluginTemplate object
     *
     * @param \RPluginTemplate|ObjectCollection $rPluginTemplate the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTemplatenamesQuery The current query, for fluid interface
     */
    public function filterByRPluginTemplate($rPluginTemplate, $comparison = null)
    {
        if ($rPluginTemplate instanceof \RPluginTemplate) {
            return $this
                ->addUsingAlias(TemplatenamesTableMap::COL_ID, $rPluginTemplate->getTemplateid(), $comparison);
        } elseif ($rPluginTemplate instanceof ObjectCollection) {
            return $this
                ->useRPluginTemplateQuery()
                ->filterByPrimaryKeys($rPluginTemplate->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRPluginTemplate() only accepts arguments of type \RPluginTemplate or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RPluginTemplate relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTemplatenamesQuery The current query, for fluid interface
     */
    public function joinRPluginTemplate($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RPluginTemplate');

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
            $this->addJoinObject($join, 'RPluginTemplate');
        }

        return $this;
    }

    /**
     * Use the RPluginTemplate relation RPluginTemplate object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RPluginTemplateQuery A secondary query class using the current class as primary query
     */
    public function useRPluginTemplateQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRPluginTemplate($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RPluginTemplate', '\RPluginTemplateQuery');
    }

    /**
     * Filter the query by a related \Templates object
     *
     * @param \Templates|ObjectCollection $templates the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTemplatenamesQuery The current query, for fluid interface
     */
    public function filterByTemplates($templates, $comparison = null)
    {
        if ($templates instanceof \Templates) {
            return $this
                ->addUsingAlias(TemplatenamesTableMap::COL_ID, $templates->getFortemplate(), $comparison);
        } elseif ($templates instanceof ObjectCollection) {
            return $this
                ->useTemplatesQuery()
                ->filterByPrimaryKeys($templates->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTemplates() only accepts arguments of type \Templates or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Templates relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTemplatenamesQuery The current query, for fluid interface
     */
    public function joinTemplates($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Templates');

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
            $this->addJoinObject($join, 'Templates');
        }

        return $this;
    }

    /**
     * Use the Templates relation Templates object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TemplatesQuery A secondary query class using the current class as primary query
     */
    public function useTemplatesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTemplates($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Templates', '\TemplatesQuery');
    }

    /**
     * Filter the query by a related Rights object
     * using the R_rights_fortemplate table as cross reference
     *
     * @param Rights $rights the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTemplatenamesQuery The current query, for fluid interface
     */
    public function filterByRights($rights, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRRightsFortemplateQuery()
            ->filterByRights($rights, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Books object
     * using the R_templatenames_forbook table as cross reference
     *
     * @param Books $books the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTemplatenamesQuery The current query, for fluid interface
     */
    public function filterByBooks($books, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRTemplatenamesForbookQuery()
            ->filterByBooks($books, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Formats object
     * using the R_templatenames_inchapter table as cross reference
     *
     * @param Formats $formats the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTemplatenamesQuery The current query, for fluid interface
     */
    public function filterByFormats($formats, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRTemplatenamesInchapterQuery()
            ->filterByFormats($formats, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Plugins object
     * using the R_plugin_template table as cross reference
     *
     * @param Plugins $plugins the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTemplatenamesQuery The current query, for fluid interface
     */
    public function filterByRPlugin($plugins, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRPluginTemplateQuery()
            ->filterByRPlugin($plugins, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTemplatenames $templatenames Object to remove from the list of results
     *
     * @return $this|ChildTemplatenamesQuery The current query, for fluid interface
     */
    public function prune($templatenames = null)
    {
        if ($templatenames) {
            $this->addUsingAlias(TemplatenamesTableMap::COL_ID, $templatenames->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the _templatenames table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TemplatenamesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TemplatenamesTableMap::clearInstancePool();
            TemplatenamesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TemplatenamesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TemplatenamesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TemplatenamesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TemplatenamesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TemplatenamesQuery
