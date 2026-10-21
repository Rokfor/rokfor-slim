<?php

namespace Base;

use \Plugins as ChildPlugins;
use \PluginsQuery as ChildPluginsQuery;
use \Exception;
use \PDO;
use Map\PluginsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the '_plugins' table.
 *
 *
 *
 * @method     ChildPluginsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPluginsQuery orderByName($order = Criteria::ASC) Order by the _name column
 * @method     ChildPluginsQuery orderByApi($order = Criteria::ASC) Order by the _api column
 *
 * @method     ChildPluginsQuery groupById() Group by the id column
 * @method     ChildPluginsQuery groupByName() Group by the _name column
 * @method     ChildPluginsQuery groupByApi() Group by the _api column
 *
 * @method     ChildPluginsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPluginsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPluginsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPluginsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPluginsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPluginsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPluginsQuery leftJoinRPluginBook($relationAlias = null) Adds a LEFT JOIN clause to the query using the RPluginBook relation
 * @method     ChildPluginsQuery rightJoinRPluginBook($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RPluginBook relation
 * @method     ChildPluginsQuery innerJoinRPluginBook($relationAlias = null) Adds a INNER JOIN clause to the query using the RPluginBook relation
 *
 * @method     ChildPluginsQuery joinWithRPluginBook($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RPluginBook relation
 *
 * @method     ChildPluginsQuery leftJoinWithRPluginBook() Adds a LEFT JOIN clause and with to the query using the RPluginBook relation
 * @method     ChildPluginsQuery rightJoinWithRPluginBook() Adds a RIGHT JOIN clause and with to the query using the RPluginBook relation
 * @method     ChildPluginsQuery innerJoinWithRPluginBook() Adds a INNER JOIN clause and with to the query using the RPluginBook relation
 *
 * @method     ChildPluginsQuery leftJoinRPluginFormat($relationAlias = null) Adds a LEFT JOIN clause to the query using the RPluginFormat relation
 * @method     ChildPluginsQuery rightJoinRPluginFormat($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RPluginFormat relation
 * @method     ChildPluginsQuery innerJoinRPluginFormat($relationAlias = null) Adds a INNER JOIN clause to the query using the RPluginFormat relation
 *
 * @method     ChildPluginsQuery joinWithRPluginFormat($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RPluginFormat relation
 *
 * @method     ChildPluginsQuery leftJoinWithRPluginFormat() Adds a LEFT JOIN clause and with to the query using the RPluginFormat relation
 * @method     ChildPluginsQuery rightJoinWithRPluginFormat() Adds a RIGHT JOIN clause and with to the query using the RPluginFormat relation
 * @method     ChildPluginsQuery innerJoinWithRPluginFormat() Adds a INNER JOIN clause and with to the query using the RPluginFormat relation
 *
 * @method     ChildPluginsQuery leftJoinRPluginIssue($relationAlias = null) Adds a LEFT JOIN clause to the query using the RPluginIssue relation
 * @method     ChildPluginsQuery rightJoinRPluginIssue($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RPluginIssue relation
 * @method     ChildPluginsQuery innerJoinRPluginIssue($relationAlias = null) Adds a INNER JOIN clause to the query using the RPluginIssue relation
 *
 * @method     ChildPluginsQuery joinWithRPluginIssue($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RPluginIssue relation
 *
 * @method     ChildPluginsQuery leftJoinWithRPluginIssue() Adds a LEFT JOIN clause and with to the query using the RPluginIssue relation
 * @method     ChildPluginsQuery rightJoinWithRPluginIssue() Adds a RIGHT JOIN clause and with to the query using the RPluginIssue relation
 * @method     ChildPluginsQuery innerJoinWithRPluginIssue() Adds a INNER JOIN clause and with to the query using the RPluginIssue relation
 *
 * @method     ChildPluginsQuery leftJoinRPluginTemplate($relationAlias = null) Adds a LEFT JOIN clause to the query using the RPluginTemplate relation
 * @method     ChildPluginsQuery rightJoinRPluginTemplate($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RPluginTemplate relation
 * @method     ChildPluginsQuery innerJoinRPluginTemplate($relationAlias = null) Adds a INNER JOIN clause to the query using the RPluginTemplate relation
 *
 * @method     ChildPluginsQuery joinWithRPluginTemplate($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RPluginTemplate relation
 *
 * @method     ChildPluginsQuery leftJoinWithRPluginTemplate() Adds a LEFT JOIN clause and with to the query using the RPluginTemplate relation
 * @method     ChildPluginsQuery rightJoinWithRPluginTemplate() Adds a RIGHT JOIN clause and with to the query using the RPluginTemplate relation
 * @method     ChildPluginsQuery innerJoinWithRPluginTemplate() Adds a INNER JOIN clause and with to the query using the RPluginTemplate relation
 *
 * @method     ChildPluginsQuery leftJoinPdf($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pdf relation
 * @method     ChildPluginsQuery rightJoinPdf($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pdf relation
 * @method     ChildPluginsQuery innerJoinPdf($relationAlias = null) Adds a INNER JOIN clause to the query using the Pdf relation
 *
 * @method     ChildPluginsQuery joinWithPdf($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Pdf relation
 *
 * @method     ChildPluginsQuery leftJoinWithPdf() Adds a LEFT JOIN clause and with to the query using the Pdf relation
 * @method     ChildPluginsQuery rightJoinWithPdf() Adds a RIGHT JOIN clause and with to the query using the Pdf relation
 * @method     ChildPluginsQuery innerJoinWithPdf() Adds a INNER JOIN clause and with to the query using the Pdf relation
 *
 * @method     \RPluginBookQuery|\RPluginFormatQuery|\RPluginIssueQuery|\RPluginTemplateQuery|\PdfQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPlugins findOne(ConnectionInterface $con = null) Return the first ChildPlugins matching the query
 * @method     ChildPlugins findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPlugins matching the query, or a new ChildPlugins object populated from the query conditions when no match is found
 *
 * @method     ChildPlugins findOneById(int $id) Return the first ChildPlugins filtered by the id column
 * @method     ChildPlugins findOneByName(string $_name) Return the first ChildPlugins filtered by the _name column
 * @method     ChildPlugins findOneByApi(string $_api) Return the first ChildPlugins filtered by the _api column *

 * @method     ChildPlugins requirePk($key, ConnectionInterface $con = null) Return the ChildPlugins by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlugins requireOne(ConnectionInterface $con = null) Return the first ChildPlugins matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPlugins requireOneById(int $id) Return the first ChildPlugins filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlugins requireOneByName(string $_name) Return the first ChildPlugins filtered by the _name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlugins requireOneByApi(string $_api) Return the first ChildPlugins filtered by the _api column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPlugins[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPlugins objects based on current ModelCriteria
 * @method     ChildPlugins[]|ObjectCollection findById(int $id) Return ChildPlugins objects filtered by the id column
 * @method     ChildPlugins[]|ObjectCollection findByName(string $_name) Return ChildPlugins objects filtered by the _name column
 * @method     ChildPlugins[]|ObjectCollection findByApi(string $_api) Return ChildPlugins objects filtered by the _api column
 * @method     ChildPlugins[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PluginsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PluginsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\Plugins', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPluginsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPluginsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPluginsQuery) {
            return $criteria;
        }
        $query = new ChildPluginsQuery();
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
     * @return ChildPlugins|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PluginsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PluginsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPlugins A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, _name, _api FROM _plugins WHERE id = :p0';
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
            /** @var ChildPlugins $obj */
            $obj = new ChildPlugins();
            $obj->hydrate($row);
            PluginsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPlugins|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PluginsTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PluginsTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPluginsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PluginsTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PluginsTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginsTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginsTableMap::COL__NAME, $name, $comparison);
    }

    /**
     * Filter the query on the _api column
     *
     * Example usage:
     * <code>
     * $query->filterByApi('fooValue');   // WHERE _api = 'fooValue'
     * $query->filterByApi('%fooValue%', Criteria::LIKE); // WHERE _api LIKE '%fooValue%'
     * </code>
     *
     * @param     string $api The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByApi($api = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($api)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PluginsTableMap::COL__API, $api, $comparison);
    }

    /**
     * Filter the query by a related \RPluginBook object
     *
     * @param \RPluginBook|ObjectCollection $rPluginBook the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByRPluginBook($rPluginBook, $comparison = null)
    {
        if ($rPluginBook instanceof \RPluginBook) {
            return $this
                ->addUsingAlias(PluginsTableMap::COL_ID, $rPluginBook->getPluginid(), $comparison);
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
     * @return $this|ChildPluginsQuery The current query, for fluid interface
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
     * Filter the query by a related \RPluginFormat object
     *
     * @param \RPluginFormat|ObjectCollection $rPluginFormat the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByRPluginFormat($rPluginFormat, $comparison = null)
    {
        if ($rPluginFormat instanceof \RPluginFormat) {
            return $this
                ->addUsingAlias(PluginsTableMap::COL_ID, $rPluginFormat->getPluginid(), $comparison);
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
     * @return $this|ChildPluginsQuery The current query, for fluid interface
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
     * Filter the query by a related \RPluginIssue object
     *
     * @param \RPluginIssue|ObjectCollection $rPluginIssue the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByRPluginIssue($rPluginIssue, $comparison = null)
    {
        if ($rPluginIssue instanceof \RPluginIssue) {
            return $this
                ->addUsingAlias(PluginsTableMap::COL_ID, $rPluginIssue->getPluginid(), $comparison);
        } elseif ($rPluginIssue instanceof ObjectCollection) {
            return $this
                ->useRPluginIssueQuery()
                ->filterByPrimaryKeys($rPluginIssue->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRPluginIssue() only accepts arguments of type \RPluginIssue or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RPluginIssue relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPluginsQuery The current query, for fluid interface
     */
    public function joinRPluginIssue($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RPluginIssue');

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
            $this->addJoinObject($join, 'RPluginIssue');
        }

        return $this;
    }

    /**
     * Use the RPluginIssue relation RPluginIssue object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RPluginIssueQuery A secondary query class using the current class as primary query
     */
    public function useRPluginIssueQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRPluginIssue($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RPluginIssue', '\RPluginIssueQuery');
    }

    /**
     * Filter the query by a related \RPluginTemplate object
     *
     * @param \RPluginTemplate|ObjectCollection $rPluginTemplate the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByRPluginTemplate($rPluginTemplate, $comparison = null)
    {
        if ($rPluginTemplate instanceof \RPluginTemplate) {
            return $this
                ->addUsingAlias(PluginsTableMap::COL_ID, $rPluginTemplate->getPluginid(), $comparison);
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
     * @return $this|ChildPluginsQuery The current query, for fluid interface
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
     * Filter the query by a related \Pdf object
     *
     * @param \Pdf|ObjectCollection $pdf the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByPdf($pdf, $comparison = null)
    {
        if ($pdf instanceof \Pdf) {
            return $this
                ->addUsingAlias(PluginsTableMap::COL_ID, $pdf->getPlugin(), $comparison);
        } elseif ($pdf instanceof ObjectCollection) {
            return $this
                ->usePdfQuery()
                ->filterByPrimaryKeys($pdf->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPdf() only accepts arguments of type \Pdf or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Pdf relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPluginsQuery The current query, for fluid interface
     */
    public function joinPdf($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Pdf');

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
            $this->addJoinObject($join, 'Pdf');
        }

        return $this;
    }

    /**
     * Use the Pdf relation Pdf object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PdfQuery A secondary query class using the current class as primary query
     */
    public function usePdfQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPdf($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Pdf', '\PdfQuery');
    }

    /**
     * Filter the query by a related Books object
     * using the R_plugin_book table as cross reference
     *
     * @param Books $books the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByRBook($books, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRPluginBookQuery()
            ->filterByRBook($books, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Formats object
     * using the R_plugin_format table as cross reference
     *
     * @param Formats $formats the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByRFormat($formats, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRPluginFormatQuery()
            ->filterByRFormat($formats, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Issues object
     * using the R_plugin_issue table as cross reference
     *
     * @param Issues $issues the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByRIssue($issues, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRPluginIssueQuery()
            ->filterByRIssue($issues, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Templatenames object
     * using the R_plugin_template table as cross reference
     *
     * @param Templatenames $templatenames the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPluginsQuery The current query, for fluid interface
     */
    public function filterByTemplatenames($templatenames, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRPluginTemplateQuery()
            ->filterByTemplatenames($templatenames, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPlugins $plugins Object to remove from the list of results
     *
     * @return $this|ChildPluginsQuery The current query, for fluid interface
     */
    public function prune($plugins = null)
    {
        if ($plugins) {
            $this->addUsingAlias(PluginsTableMap::COL_ID, $plugins->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the _plugins table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PluginsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PluginsTableMap::clearInstancePool();
            PluginsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PluginsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PluginsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PluginsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PluginsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PluginsQuery
