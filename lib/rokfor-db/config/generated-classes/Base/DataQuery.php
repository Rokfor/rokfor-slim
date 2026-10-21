<?php

namespace Base;

use \Data as ChildData;
use \DataQuery as ChildDataQuery;
use \Exception;
use \PDO;
use Map\DataTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the '_data' table.
 *
 *
 *
 * @method     ChildDataQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildDataQuery orderByForcontribution($order = Criteria::ASC) Order by the _forcontribution column
 * @method     ChildDataQuery orderByFortemplatefield($order = Criteria::ASC) Order by the _fortemplatefield column
 * @method     ChildDataQuery orderByContent($order = Criteria::ASC) Order by the _content column
 * @method     ChildDataQuery orderByIsjson($order = Criteria::ASC) Order by the _isjson column
 * @method     ChildDataQuery orderByUserSys($order = Criteria::ASC) Order by the __user__ column
 * @method     ChildDataQuery orderByConfigSys($order = Criteria::ASC) Order by the __config__ column
 * @method     ChildDataQuery orderBySplit($order = Criteria::ASC) Order by the __split__ column
 * @method     ChildDataQuery orderByParentnode($order = Criteria::ASC) Order by the __parentnode__ column
 * @method     ChildDataQuery orderBySort($order = Criteria::ASC) Order by the __sort__ column
 * @method     ChildDataQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildDataQuery orderByVersionCreatedAt($order = Criteria::ASC) Order by the version_created_at column
 * @method     ChildDataQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 * @method     ChildDataQuery orderByVersionComment($order = Criteria::ASC) Order by the version_comment column
 *
 * @method     ChildDataQuery groupById() Group by the id column
 * @method     ChildDataQuery groupByForcontribution() Group by the _forcontribution column
 * @method     ChildDataQuery groupByFortemplatefield() Group by the _fortemplatefield column
 * @method     ChildDataQuery groupByContent() Group by the _content column
 * @method     ChildDataQuery groupByIsjson() Group by the _isjson column
 * @method     ChildDataQuery groupByUserSys() Group by the __user__ column
 * @method     ChildDataQuery groupByConfigSys() Group by the __config__ column
 * @method     ChildDataQuery groupBySplit() Group by the __split__ column
 * @method     ChildDataQuery groupByParentnode() Group by the __parentnode__ column
 * @method     ChildDataQuery groupBySort() Group by the __sort__ column
 * @method     ChildDataQuery groupByVersion() Group by the version column
 * @method     ChildDataQuery groupByVersionCreatedAt() Group by the version_created_at column
 * @method     ChildDataQuery groupByVersionCreatedBy() Group by the version_created_by column
 * @method     ChildDataQuery groupByVersionComment() Group by the version_comment column
 *
 * @method     ChildDataQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDataQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDataQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDataQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDataQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDataQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDataQuery leftJoinuserSysRef($relationAlias = null) Adds a LEFT JOIN clause to the query using the userSysRef relation
 * @method     ChildDataQuery rightJoinuserSysRef($relationAlias = null) Adds a RIGHT JOIN clause to the query using the userSysRef relation
 * @method     ChildDataQuery innerJoinuserSysRef($relationAlias = null) Adds a INNER JOIN clause to the query using the userSysRef relation
 *
 * @method     ChildDataQuery joinWithuserSysRef($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the userSysRef relation
 *
 * @method     ChildDataQuery leftJoinWithuserSysRef() Adds a LEFT JOIN clause and with to the query using the userSysRef relation
 * @method     ChildDataQuery rightJoinWithuserSysRef() Adds a RIGHT JOIN clause and with to the query using the userSysRef relation
 * @method     ChildDataQuery innerJoinWithuserSysRef() Adds a INNER JOIN clause and with to the query using the userSysRef relation
 *
 * @method     ChildDataQuery leftJoinContributions($relationAlias = null) Adds a LEFT JOIN clause to the query using the Contributions relation
 * @method     ChildDataQuery rightJoinContributions($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Contributions relation
 * @method     ChildDataQuery innerJoinContributions($relationAlias = null) Adds a INNER JOIN clause to the query using the Contributions relation
 *
 * @method     ChildDataQuery joinWithContributions($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Contributions relation
 *
 * @method     ChildDataQuery leftJoinWithContributions() Adds a LEFT JOIN clause and with to the query using the Contributions relation
 * @method     ChildDataQuery rightJoinWithContributions() Adds a RIGHT JOIN clause and with to the query using the Contributions relation
 * @method     ChildDataQuery innerJoinWithContributions() Adds a INNER JOIN clause and with to the query using the Contributions relation
 *
 * @method     ChildDataQuery leftJoinTemplates($relationAlias = null) Adds a LEFT JOIN clause to the query using the Templates relation
 * @method     ChildDataQuery rightJoinTemplates($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Templates relation
 * @method     ChildDataQuery innerJoinTemplates($relationAlias = null) Adds a INNER JOIN clause to the query using the Templates relation
 *
 * @method     ChildDataQuery joinWithTemplates($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Templates relation
 *
 * @method     ChildDataQuery leftJoinWithTemplates() Adds a LEFT JOIN clause and with to the query using the Templates relation
 * @method     ChildDataQuery rightJoinWithTemplates() Adds a RIGHT JOIN clause and with to the query using the Templates relation
 * @method     ChildDataQuery innerJoinWithTemplates() Adds a INNER JOIN clause and with to the query using the Templates relation
 *
 * @method     ChildDataQuery leftJoinRDataDataRelatedBySource($relationAlias = null) Adds a LEFT JOIN clause to the query using the RDataDataRelatedBySource relation
 * @method     ChildDataQuery rightJoinRDataDataRelatedBySource($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RDataDataRelatedBySource relation
 * @method     ChildDataQuery innerJoinRDataDataRelatedBySource($relationAlias = null) Adds a INNER JOIN clause to the query using the RDataDataRelatedBySource relation
 *
 * @method     ChildDataQuery joinWithRDataDataRelatedBySource($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RDataDataRelatedBySource relation
 *
 * @method     ChildDataQuery leftJoinWithRDataDataRelatedBySource() Adds a LEFT JOIN clause and with to the query using the RDataDataRelatedBySource relation
 * @method     ChildDataQuery rightJoinWithRDataDataRelatedBySource() Adds a RIGHT JOIN clause and with to the query using the RDataDataRelatedBySource relation
 * @method     ChildDataQuery innerJoinWithRDataDataRelatedBySource() Adds a INNER JOIN clause and with to the query using the RDataDataRelatedBySource relation
 *
 * @method     ChildDataQuery leftJoinRDataDataRelatedByTarget($relationAlias = null) Adds a LEFT JOIN clause to the query using the RDataDataRelatedByTarget relation
 * @method     ChildDataQuery rightJoinRDataDataRelatedByTarget($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RDataDataRelatedByTarget relation
 * @method     ChildDataQuery innerJoinRDataDataRelatedByTarget($relationAlias = null) Adds a INNER JOIN clause to the query using the RDataDataRelatedByTarget relation
 *
 * @method     ChildDataQuery joinWithRDataDataRelatedByTarget($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RDataDataRelatedByTarget relation
 *
 * @method     ChildDataQuery leftJoinWithRDataDataRelatedByTarget() Adds a LEFT JOIN clause and with to the query using the RDataDataRelatedByTarget relation
 * @method     ChildDataQuery rightJoinWithRDataDataRelatedByTarget() Adds a RIGHT JOIN clause and with to the query using the RDataDataRelatedByTarget relation
 * @method     ChildDataQuery innerJoinWithRDataDataRelatedByTarget() Adds a INNER JOIN clause and with to the query using the RDataDataRelatedByTarget relation
 *
 * @method     ChildDataQuery leftJoinRDataContribution($relationAlias = null) Adds a LEFT JOIN clause to the query using the RDataContribution relation
 * @method     ChildDataQuery rightJoinRDataContribution($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RDataContribution relation
 * @method     ChildDataQuery innerJoinRDataContribution($relationAlias = null) Adds a INNER JOIN clause to the query using the RDataContribution relation
 *
 * @method     ChildDataQuery joinWithRDataContribution($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RDataContribution relation
 *
 * @method     ChildDataQuery leftJoinWithRDataContribution() Adds a LEFT JOIN clause and with to the query using the RDataContribution relation
 * @method     ChildDataQuery rightJoinWithRDataContribution() Adds a RIGHT JOIN clause and with to the query using the RDataContribution relation
 * @method     ChildDataQuery innerJoinWithRDataContribution() Adds a INNER JOIN clause and with to the query using the RDataContribution relation
 *
 * @method     ChildDataQuery leftJoinRDataBook($relationAlias = null) Adds a LEFT JOIN clause to the query using the RDataBook relation
 * @method     ChildDataQuery rightJoinRDataBook($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RDataBook relation
 * @method     ChildDataQuery innerJoinRDataBook($relationAlias = null) Adds a INNER JOIN clause to the query using the RDataBook relation
 *
 * @method     ChildDataQuery joinWithRDataBook($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RDataBook relation
 *
 * @method     ChildDataQuery leftJoinWithRDataBook() Adds a LEFT JOIN clause and with to the query using the RDataBook relation
 * @method     ChildDataQuery rightJoinWithRDataBook() Adds a RIGHT JOIN clause and with to the query using the RDataBook relation
 * @method     ChildDataQuery innerJoinWithRDataBook() Adds a INNER JOIN clause and with to the query using the RDataBook relation
 *
 * @method     ChildDataQuery leftJoinRDataFormat($relationAlias = null) Adds a LEFT JOIN clause to the query using the RDataFormat relation
 * @method     ChildDataQuery rightJoinRDataFormat($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RDataFormat relation
 * @method     ChildDataQuery innerJoinRDataFormat($relationAlias = null) Adds a INNER JOIN clause to the query using the RDataFormat relation
 *
 * @method     ChildDataQuery joinWithRDataFormat($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RDataFormat relation
 *
 * @method     ChildDataQuery leftJoinWithRDataFormat() Adds a LEFT JOIN clause and with to the query using the RDataFormat relation
 * @method     ChildDataQuery rightJoinWithRDataFormat() Adds a RIGHT JOIN clause and with to the query using the RDataFormat relation
 * @method     ChildDataQuery innerJoinWithRDataFormat() Adds a INNER JOIN clause and with to the query using the RDataFormat relation
 *
 * @method     ChildDataQuery leftJoinRDataIssue($relationAlias = null) Adds a LEFT JOIN clause to the query using the RDataIssue relation
 * @method     ChildDataQuery rightJoinRDataIssue($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RDataIssue relation
 * @method     ChildDataQuery innerJoinRDataIssue($relationAlias = null) Adds a INNER JOIN clause to the query using the RDataIssue relation
 *
 * @method     ChildDataQuery joinWithRDataIssue($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RDataIssue relation
 *
 * @method     ChildDataQuery leftJoinWithRDataIssue() Adds a LEFT JOIN clause and with to the query using the RDataIssue relation
 * @method     ChildDataQuery rightJoinWithRDataIssue() Adds a RIGHT JOIN clause and with to the query using the RDataIssue relation
 * @method     ChildDataQuery innerJoinWithRDataIssue() Adds a INNER JOIN clause and with to the query using the RDataIssue relation
 *
 * @method     ChildDataQuery leftJoinRDataTemplate($relationAlias = null) Adds a LEFT JOIN clause to the query using the RDataTemplate relation
 * @method     ChildDataQuery rightJoinRDataTemplate($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RDataTemplate relation
 * @method     ChildDataQuery innerJoinRDataTemplate($relationAlias = null) Adds a INNER JOIN clause to the query using the RDataTemplate relation
 *
 * @method     ChildDataQuery joinWithRDataTemplate($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RDataTemplate relation
 *
 * @method     ChildDataQuery leftJoinWithRDataTemplate() Adds a LEFT JOIN clause and with to the query using the RDataTemplate relation
 * @method     ChildDataQuery rightJoinWithRDataTemplate() Adds a RIGHT JOIN clause and with to the query using the RDataTemplate relation
 * @method     ChildDataQuery innerJoinWithRDataTemplate() Adds a INNER JOIN clause and with to the query using the RDataTemplate relation
 *
 * @method     ChildDataQuery leftJoinDataVersion($relationAlias = null) Adds a LEFT JOIN clause to the query using the DataVersion relation
 * @method     ChildDataQuery rightJoinDataVersion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DataVersion relation
 * @method     ChildDataQuery innerJoinDataVersion($relationAlias = null) Adds a INNER JOIN clause to the query using the DataVersion relation
 *
 * @method     ChildDataQuery joinWithDataVersion($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DataVersion relation
 *
 * @method     ChildDataQuery leftJoinWithDataVersion() Adds a LEFT JOIN clause and with to the query using the DataVersion relation
 * @method     ChildDataQuery rightJoinWithDataVersion() Adds a RIGHT JOIN clause and with to the query using the DataVersion relation
 * @method     ChildDataQuery innerJoinWithDataVersion() Adds a INNER JOIN clause and with to the query using the DataVersion relation
 *
 * @method     \UsersQuery|\ContributionsQuery|\TemplatesQuery|\RDataDataQuery|\RDataContributionQuery|\RDataBookQuery|\RDataFormatQuery|\RDataIssueQuery|\RDataTemplateQuery|\DataVersionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildData findOne(ConnectionInterface $con = null) Return the first ChildData matching the query
 * @method     ChildData findOneOrCreate(ConnectionInterface $con = null) Return the first ChildData matching the query, or a new ChildData object populated from the query conditions when no match is found
 *
 * @method     ChildData findOneById(int $id) Return the first ChildData filtered by the id column
 * @method     ChildData findOneByForcontribution(int $_forcontribution) Return the first ChildData filtered by the _forcontribution column
 * @method     ChildData findOneByFortemplatefield(int $_fortemplatefield) Return the first ChildData filtered by the _fortemplatefield column
 * @method     ChildData findOneByContent(string $_content) Return the first ChildData filtered by the _content column
 * @method     ChildData findOneByIsjson(boolean $_isjson) Return the first ChildData filtered by the _isjson column
 * @method     ChildData findOneByUserSys(int $__user__) Return the first ChildData filtered by the __user__ column
 * @method     ChildData findOneByConfigSys(string $__config__) Return the first ChildData filtered by the __config__ column
 * @method     ChildData findOneBySplit(string $__split__) Return the first ChildData filtered by the __split__ column
 * @method     ChildData findOneByParentnode(int $__parentnode__) Return the first ChildData filtered by the __parentnode__ column
 * @method     ChildData findOneBySort(int $__sort__) Return the first ChildData filtered by the __sort__ column
 * @method     ChildData findOneByVersion(int $version) Return the first ChildData filtered by the version column
 * @method     ChildData findOneByVersionCreatedAt(string $version_created_at) Return the first ChildData filtered by the version_created_at column
 * @method     ChildData findOneByVersionCreatedBy(string $version_created_by) Return the first ChildData filtered by the version_created_by column
 * @method     ChildData findOneByVersionComment(string $version_comment) Return the first ChildData filtered by the version_comment column *

 * @method     ChildData requirePk($key, ConnectionInterface $con = null) Return the ChildData by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildData requireOne(ConnectionInterface $con = null) Return the first ChildData matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildData requireOneById(int $id) Return the first ChildData filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildData requireOneByForcontribution(int $_forcontribution) Return the first ChildData filtered by the _forcontribution column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildData requireOneByFortemplatefield(int $_fortemplatefield) Return the first ChildData filtered by the _fortemplatefield column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildData requireOneByContent(string $_content) Return the first ChildData filtered by the _content column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildData requireOneByIsjson(boolean $_isjson) Return the first ChildData filtered by the _isjson column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildData requireOneByUserSys(int $__user__) Return the first ChildData filtered by the __user__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildData requireOneByConfigSys(string $__config__) Return the first ChildData filtered by the __config__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildData requireOneBySplit(string $__split__) Return the first ChildData filtered by the __split__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildData requireOneByParentnode(int $__parentnode__) Return the first ChildData filtered by the __parentnode__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildData requireOneBySort(int $__sort__) Return the first ChildData filtered by the __sort__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildData requireOneByVersion(int $version) Return the first ChildData filtered by the version column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildData requireOneByVersionCreatedAt(string $version_created_at) Return the first ChildData filtered by the version_created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildData requireOneByVersionCreatedBy(string $version_created_by) Return the first ChildData filtered by the version_created_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildData requireOneByVersionComment(string $version_comment) Return the first ChildData filtered by the version_comment column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildData[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildData objects based on current ModelCriteria
 * @method     ChildData[]|ObjectCollection findById(int $id) Return ChildData objects filtered by the id column
 * @method     ChildData[]|ObjectCollection findByForcontribution(int $_forcontribution) Return ChildData objects filtered by the _forcontribution column
 * @method     ChildData[]|ObjectCollection findByFortemplatefield(int $_fortemplatefield) Return ChildData objects filtered by the _fortemplatefield column
 * @method     ChildData[]|ObjectCollection findByContent(string $_content) Return ChildData objects filtered by the _content column
 * @method     ChildData[]|ObjectCollection findByIsjson(boolean $_isjson) Return ChildData objects filtered by the _isjson column
 * @method     ChildData[]|ObjectCollection findByUserSys(int $__user__) Return ChildData objects filtered by the __user__ column
 * @method     ChildData[]|ObjectCollection findByConfigSys(string $__config__) Return ChildData objects filtered by the __config__ column
 * @method     ChildData[]|ObjectCollection findBySplit(string $__split__) Return ChildData objects filtered by the __split__ column
 * @method     ChildData[]|ObjectCollection findByParentnode(int $__parentnode__) Return ChildData objects filtered by the __parentnode__ column
 * @method     ChildData[]|ObjectCollection findBySort(int $__sort__) Return ChildData objects filtered by the __sort__ column
 * @method     ChildData[]|ObjectCollection findByVersion(int $version) Return ChildData objects filtered by the version column
 * @method     ChildData[]|ObjectCollection findByVersionCreatedAt(string $version_created_at) Return ChildData objects filtered by the version_created_at column
 * @method     ChildData[]|ObjectCollection findByVersionCreatedBy(string $version_created_by) Return ChildData objects filtered by the version_created_by column
 * @method     ChildData[]|ObjectCollection findByVersionComment(string $version_comment) Return ChildData objects filtered by the version_comment column
 * @method     ChildData[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DataQuery extends ModelCriteria
{

    // versionable behavior

    /**
     * Whether the versioning is enabled
     */
    static $isVersioningEnabled = true;
protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\DataQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\Data', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDataQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDataQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDataQuery) {
            return $criteria;
        }
        $query = new ChildDataQuery();
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
     * @return ChildData|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DataTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = DataTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildData A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, _forcontribution, _fortemplatefield, _content, _isjson, __user__, __config__, __split__, __parentnode__, __sort__, version, version_created_at, version_created_by, version_comment FROM _data WHERE id = :p0';
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
            /** @var ChildData $obj */
            $obj = new ChildData();
            $obj->hydrate($row);
            DataTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildData|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DataTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DataTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(DataTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(DataTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DataTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the _forcontribution column
     *
     * Example usage:
     * <code>
     * $query->filterByForcontribution(1234); // WHERE _forcontribution = 1234
     * $query->filterByForcontribution(array(12, 34)); // WHERE _forcontribution IN (12, 34)
     * $query->filterByForcontribution(array('min' => 12)); // WHERE _forcontribution > 12
     * </code>
     *
     * @see       filterByContributions()
     *
     * @param     mixed $forcontribution The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function filterByForcontribution($forcontribution = null, $comparison = null)
    {
        if (is_array($forcontribution)) {
            $useMinMax = false;
            if (isset($forcontribution['min'])) {
                $this->addUsingAlias(DataTableMap::COL__FORCONTRIBUTION, $forcontribution['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($forcontribution['max'])) {
                $this->addUsingAlias(DataTableMap::COL__FORCONTRIBUTION, $forcontribution['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DataTableMap::COL__FORCONTRIBUTION, $forcontribution, $comparison);
    }

    /**
     * Filter the query on the _fortemplatefield column
     *
     * Example usage:
     * <code>
     * $query->filterByFortemplatefield(1234); // WHERE _fortemplatefield = 1234
     * $query->filterByFortemplatefield(array(12, 34)); // WHERE _fortemplatefield IN (12, 34)
     * $query->filterByFortemplatefield(array('min' => 12)); // WHERE _fortemplatefield > 12
     * </code>
     *
     * @see       filterByTemplates()
     *
     * @param     mixed $fortemplatefield The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function filterByFortemplatefield($fortemplatefield = null, $comparison = null)
    {
        if (is_array($fortemplatefield)) {
            $useMinMax = false;
            if (isset($fortemplatefield['min'])) {
                $this->addUsingAlias(DataTableMap::COL__FORTEMPLATEFIELD, $fortemplatefield['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fortemplatefield['max'])) {
                $this->addUsingAlias(DataTableMap::COL__FORTEMPLATEFIELD, $fortemplatefield['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DataTableMap::COL__FORTEMPLATEFIELD, $fortemplatefield, $comparison);
    }

    /**
     * Filter the query on the _content column
     *
     * Example usage:
     * <code>
     * $query->filterByContent('fooValue');   // WHERE _content = 'fooValue'
     * $query->filterByContent('%fooValue%', Criteria::LIKE); // WHERE _content LIKE '%fooValue%'
     * </code>
     *
     * @param     string $content The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function filterByContent($content = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($content)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DataTableMap::COL__CONTENT, $content, $comparison);
    }

    /**
     * Filter the query on the _isjson column
     *
     * Example usage:
     * <code>
     * $query->filterByIsjson(true); // WHERE _isjson = true
     * $query->filterByIsjson('yes'); // WHERE _isjson = true
     * </code>
     *
     * @param     boolean|string $isjson The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function filterByIsjson($isjson = null, $comparison = null)
    {
        if (is_string($isjson)) {
            $isjson = in_array(strtolower($isjson), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(DataTableMap::COL__ISJSON, $isjson, $comparison);
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
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function filterByUserSys($userSys = null, $comparison = null)
    {
        if (is_array($userSys)) {
            $useMinMax = false;
            if (isset($userSys['min'])) {
                $this->addUsingAlias(DataTableMap::COL___USER__, $userSys['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userSys['max'])) {
                $this->addUsingAlias(DataTableMap::COL___USER__, $userSys['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DataTableMap::COL___USER__, $userSys, $comparison);
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
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function filterByConfigSys($configSys = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($configSys)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DataTableMap::COL___CONFIG__, $configSys, $comparison);
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
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function filterBySplit($split = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($split)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DataTableMap::COL___SPLIT__, $split, $comparison);
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
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function filterByParentnode($parentnode = null, $comparison = null)
    {
        if (is_array($parentnode)) {
            $useMinMax = false;
            if (isset($parentnode['min'])) {
                $this->addUsingAlias(DataTableMap::COL___PARENTNODE__, $parentnode['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentnode['max'])) {
                $this->addUsingAlias(DataTableMap::COL___PARENTNODE__, $parentnode['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DataTableMap::COL___PARENTNODE__, $parentnode, $comparison);
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
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function filterBySort($sort = null, $comparison = null)
    {
        if (is_array($sort)) {
            $useMinMax = false;
            if (isset($sort['min'])) {
                $this->addUsingAlias(DataTableMap::COL___SORT__, $sort['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sort['max'])) {
                $this->addUsingAlias(DataTableMap::COL___SORT__, $sort['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DataTableMap::COL___SORT__, $sort, $comparison);
    }

    /**
     * Filter the query on the version column
     *
     * Example usage:
     * <code>
     * $query->filterByVersion(1234); // WHERE version = 1234
     * $query->filterByVersion(array(12, 34)); // WHERE version IN (12, 34)
     * $query->filterByVersion(array('min' => 12)); // WHERE version > 12
     * </code>
     *
     * @param     mixed $version The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(DataTableMap::COL_VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(DataTableMap::COL_VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DataTableMap::COL_VERSION, $version, $comparison);
    }

    /**
     * Filter the query on the version_created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByVersionCreatedAt('2011-03-14'); // WHERE version_created_at = '2011-03-14'
     * $query->filterByVersionCreatedAt('now'); // WHERE version_created_at = '2011-03-14'
     * $query->filterByVersionCreatedAt(array('max' => 'yesterday')); // WHERE version_created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $versionCreatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedAt($versionCreatedAt = null, $comparison = null)
    {
        if (is_array($versionCreatedAt)) {
            $useMinMax = false;
            if (isset($versionCreatedAt['min'])) {
                $this->addUsingAlias(DataTableMap::COL_VERSION_CREATED_AT, $versionCreatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($versionCreatedAt['max'])) {
                $this->addUsingAlias(DataTableMap::COL_VERSION_CREATED_AT, $versionCreatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DataTableMap::COL_VERSION_CREATED_AT, $versionCreatedAt, $comparison);
    }

    /**
     * Filter the query on the version_created_by column
     *
     * Example usage:
     * <code>
     * $query->filterByVersionCreatedBy('fooValue');   // WHERE version_created_by = 'fooValue'
     * $query->filterByVersionCreatedBy('%fooValue%', Criteria::LIKE); // WHERE version_created_by LIKE '%fooValue%'
     * </code>
     *
     * @param     string $versionCreatedBy The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedBy($versionCreatedBy = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($versionCreatedBy)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DataTableMap::COL_VERSION_CREATED_BY, $versionCreatedBy, $comparison);
    }

    /**
     * Filter the query on the version_comment column
     *
     * Example usage:
     * <code>
     * $query->filterByVersionComment('fooValue');   // WHERE version_comment = 'fooValue'
     * $query->filterByVersionComment('%fooValue%', Criteria::LIKE); // WHERE version_comment LIKE '%fooValue%'
     * </code>
     *
     * @param     string $versionComment The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function filterByVersionComment($versionComment = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($versionComment)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DataTableMap::COL_VERSION_COMMENT, $versionComment, $comparison);
    }

    /**
     * Filter the query by a related \Users object
     *
     * @param \Users|ObjectCollection $users The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDataQuery The current query, for fluid interface
     */
    public function filterByuserSysRef($users, $comparison = null)
    {
        if ($users instanceof \Users) {
            return $this
                ->addUsingAlias(DataTableMap::COL___USER__, $users->getId(), $comparison);
        } elseif ($users instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DataTableMap::COL___USER__, $users->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildDataQuery The current query, for fluid interface
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
     * Filter the query by a related \Contributions object
     *
     * @param \Contributions|ObjectCollection $contributions The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDataQuery The current query, for fluid interface
     */
    public function filterByContributions($contributions, $comparison = null)
    {
        if ($contributions instanceof \Contributions) {
            return $this
                ->addUsingAlias(DataTableMap::COL__FORCONTRIBUTION, $contributions->getId(), $comparison);
        } elseif ($contributions instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DataTableMap::COL__FORCONTRIBUTION, $contributions->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildDataQuery The current query, for fluid interface
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
     * Filter the query by a related \Templates object
     *
     * @param \Templates|ObjectCollection $templates The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDataQuery The current query, for fluid interface
     */
    public function filterByTemplates($templates, $comparison = null)
    {
        if ($templates instanceof \Templates) {
            return $this
                ->addUsingAlias(DataTableMap::COL__FORTEMPLATEFIELD, $templates->getId(), $comparison);
        } elseif ($templates instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DataTableMap::COL__FORTEMPLATEFIELD, $templates->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildDataQuery The current query, for fluid interface
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
     * Filter the query by a related \RDataData object
     *
     * @param \RDataData|ObjectCollection $rDataData the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDataQuery The current query, for fluid interface
     */
    public function filterByRDataDataRelatedBySource($rDataData, $comparison = null)
    {
        if ($rDataData instanceof \RDataData) {
            return $this
                ->addUsingAlias(DataTableMap::COL_ID, $rDataData->getSource(), $comparison);
        } elseif ($rDataData instanceof ObjectCollection) {
            return $this
                ->useRDataDataRelatedBySourceQuery()
                ->filterByPrimaryKeys($rDataData->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRDataDataRelatedBySource() only accepts arguments of type \RDataData or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RDataDataRelatedBySource relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function joinRDataDataRelatedBySource($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RDataDataRelatedBySource');

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
            $this->addJoinObject($join, 'RDataDataRelatedBySource');
        }

        return $this;
    }

    /**
     * Use the RDataDataRelatedBySource relation RDataData object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RDataDataQuery A secondary query class using the current class as primary query
     */
    public function useRDataDataRelatedBySourceQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRDataDataRelatedBySource($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RDataDataRelatedBySource', '\RDataDataQuery');
    }

    /**
     * Filter the query by a related \RDataData object
     *
     * @param \RDataData|ObjectCollection $rDataData the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDataQuery The current query, for fluid interface
     */
    public function filterByRDataDataRelatedByTarget($rDataData, $comparison = null)
    {
        if ($rDataData instanceof \RDataData) {
            return $this
                ->addUsingAlias(DataTableMap::COL_ID, $rDataData->getTarget(), $comparison);
        } elseif ($rDataData instanceof ObjectCollection) {
            return $this
                ->useRDataDataRelatedByTargetQuery()
                ->filterByPrimaryKeys($rDataData->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRDataDataRelatedByTarget() only accepts arguments of type \RDataData or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RDataDataRelatedByTarget relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function joinRDataDataRelatedByTarget($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RDataDataRelatedByTarget');

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
            $this->addJoinObject($join, 'RDataDataRelatedByTarget');
        }

        return $this;
    }

    /**
     * Use the RDataDataRelatedByTarget relation RDataData object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RDataDataQuery A secondary query class using the current class as primary query
     */
    public function useRDataDataRelatedByTargetQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRDataDataRelatedByTarget($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RDataDataRelatedByTarget', '\RDataDataQuery');
    }

    /**
     * Filter the query by a related \RDataContribution object
     *
     * @param \RDataContribution|ObjectCollection $rDataContribution the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDataQuery The current query, for fluid interface
     */
    public function filterByRDataContribution($rDataContribution, $comparison = null)
    {
        if ($rDataContribution instanceof \RDataContribution) {
            return $this
                ->addUsingAlias(DataTableMap::COL_ID, $rDataContribution->getDataid(), $comparison);
        } elseif ($rDataContribution instanceof ObjectCollection) {
            return $this
                ->useRDataContributionQuery()
                ->filterByPrimaryKeys($rDataContribution->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRDataContribution() only accepts arguments of type \RDataContribution or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RDataContribution relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function joinRDataContribution($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RDataContribution');

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
            $this->addJoinObject($join, 'RDataContribution');
        }

        return $this;
    }

    /**
     * Use the RDataContribution relation RDataContribution object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RDataContributionQuery A secondary query class using the current class as primary query
     */
    public function useRDataContributionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRDataContribution($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RDataContribution', '\RDataContributionQuery');
    }

    /**
     * Filter the query by a related \RDataBook object
     *
     * @param \RDataBook|ObjectCollection $rDataBook the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDataQuery The current query, for fluid interface
     */
    public function filterByRDataBook($rDataBook, $comparison = null)
    {
        if ($rDataBook instanceof \RDataBook) {
            return $this
                ->addUsingAlias(DataTableMap::COL_ID, $rDataBook->getDataid(), $comparison);
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
     * @return $this|ChildDataQuery The current query, for fluid interface
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
     * Filter the query by a related \RDataFormat object
     *
     * @param \RDataFormat|ObjectCollection $rDataFormat the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDataQuery The current query, for fluid interface
     */
    public function filterByRDataFormat($rDataFormat, $comparison = null)
    {
        if ($rDataFormat instanceof \RDataFormat) {
            return $this
                ->addUsingAlias(DataTableMap::COL_ID, $rDataFormat->getDataid(), $comparison);
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
     * @return $this|ChildDataQuery The current query, for fluid interface
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
     * Filter the query by a related \RDataIssue object
     *
     * @param \RDataIssue|ObjectCollection $rDataIssue the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDataQuery The current query, for fluid interface
     */
    public function filterByRDataIssue($rDataIssue, $comparison = null)
    {
        if ($rDataIssue instanceof \RDataIssue) {
            return $this
                ->addUsingAlias(DataTableMap::COL_ID, $rDataIssue->getDataid(), $comparison);
        } elseif ($rDataIssue instanceof ObjectCollection) {
            return $this
                ->useRDataIssueQuery()
                ->filterByPrimaryKeys($rDataIssue->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRDataIssue() only accepts arguments of type \RDataIssue or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RDataIssue relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function joinRDataIssue($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RDataIssue');

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
            $this->addJoinObject($join, 'RDataIssue');
        }

        return $this;
    }

    /**
     * Use the RDataIssue relation RDataIssue object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RDataIssueQuery A secondary query class using the current class as primary query
     */
    public function useRDataIssueQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRDataIssue($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RDataIssue', '\RDataIssueQuery');
    }

    /**
     * Filter the query by a related \RDataTemplate object
     *
     * @param \RDataTemplate|ObjectCollection $rDataTemplate the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDataQuery The current query, for fluid interface
     */
    public function filterByRDataTemplate($rDataTemplate, $comparison = null)
    {
        if ($rDataTemplate instanceof \RDataTemplate) {
            return $this
                ->addUsingAlias(DataTableMap::COL_ID, $rDataTemplate->getDataid(), $comparison);
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
     * @return $this|ChildDataQuery The current query, for fluid interface
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
     * Filter the query by a related \DataVersion object
     *
     * @param \DataVersion|ObjectCollection $dataVersion the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDataQuery The current query, for fluid interface
     */
    public function filterByDataVersion($dataVersion, $comparison = null)
    {
        if ($dataVersion instanceof \DataVersion) {
            return $this
                ->addUsingAlias(DataTableMap::COL_ID, $dataVersion->getId(), $comparison);
        } elseif ($dataVersion instanceof ObjectCollection) {
            return $this
                ->useDataVersionQuery()
                ->filterByPrimaryKeys($dataVersion->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDataVersion() only accepts arguments of type \DataVersion or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DataVersion relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function joinDataVersion($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DataVersion');

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
            $this->addJoinObject($join, 'DataVersion');
        }

        return $this;
    }

    /**
     * Use the DataVersion relation DataVersion object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DataVersionQuery A secondary query class using the current class as primary query
     */
    public function useDataVersionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDataVersion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DataVersion', '\DataVersionQuery');
    }

    /**
     * Filter the query by a related Data object
     * using the R_data_data table as cross reference
     *
     * @param Data $data the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDataQuery The current query, for fluid interface
     */
    public function filterByRDataRef($data, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRDataDataRelatedBySourceQuery()
            ->filterByRDataRef($data, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Data object
     * using the R_data_data table as cross reference
     *
     * @param Data $data the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDataQuery The current query, for fluid interface
     */
    public function filterByRDataSrc($data, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRDataDataRelatedByTargetQuery()
            ->filterByRDataSrc($data, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Contributions object
     * using the R_data_contribution table as cross reference
     *
     * @param Contributions $contributions the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDataQuery The current query, for fluid interface
     */
    public function filterByRContribution($contributions, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRDataContributionQuery()
            ->filterByRContribution($contributions, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Books object
     * using the R_data_book table as cross reference
     *
     * @param Books $books the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDataQuery The current query, for fluid interface
     */
    public function filterByRBook($books, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRDataBookQuery()
            ->filterByRBook($books, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Formats object
     * using the R_data_format table as cross reference
     *
     * @param Formats $formats the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDataQuery The current query, for fluid interface
     */
    public function filterByRFormat($formats, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRDataFormatQuery()
            ->filterByRFormat($formats, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Issues object
     * using the R_data_issue table as cross reference
     *
     * @param Issues $issues the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDataQuery The current query, for fluid interface
     */
    public function filterByRIssue($issues, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRDataIssueQuery()
            ->filterByRIssue($issues, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Templates object
     * using the R_data_template table as cross reference
     *
     * @param Templates $templates the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDataQuery The current query, for fluid interface
     */
    public function filterByRTemplate($templates, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useRDataTemplateQuery()
            ->filterByRTemplate($templates, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildData $data Object to remove from the list of results
     *
     * @return $this|ChildDataQuery The current query, for fluid interface
     */
    public function prune($data = null)
    {
        if ($data) {
            $this->addUsingAlias(DataTableMap::COL_ID, $data->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the _data table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DataTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DataTableMap::clearInstancePool();
            DataTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(DataTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DataTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DataTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DataTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // versionable behavior

    /**
     * Checks whether versioning is enabled
     *
     * @return boolean
     */
    static public function isVersioningEnabled()
    {
        return self::$isVersioningEnabled;
    }

    /**
     * Enables versioning
     */
    static public function enableVersioning()
    {
        self::$isVersioningEnabled = true;
    }

    /**
     * Disables versioning
     */
    static public function disableVersioning()
    {
        self::$isVersioningEnabled = false;
    }

} // DataQuery
