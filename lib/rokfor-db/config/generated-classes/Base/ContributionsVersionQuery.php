<?php

namespace Base;

use \ContributionsVersion as ChildContributionsVersion;
use \ContributionsVersionQuery as ChildContributionsVersionQuery;
use \Exception;
use \PDO;
use Map\ContributionsVersionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the '_contributions_version' table.
 *
 *
 *
 * @method     ChildContributionsVersionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildContributionsVersionQuery orderByFortemplate($order = Criteria::ASC) Order by the _fortemplate column
 * @method     ChildContributionsVersionQuery orderByForissue($order = Criteria::ASC) Order by the _forissue column
 * @method     ChildContributionsVersionQuery orderByName($order = Criteria::ASC) Order by the _name column
 * @method     ChildContributionsVersionQuery orderByStatus($order = Criteria::ASC) Order by the _status column
 * @method     ChildContributionsVersionQuery orderByNewdate($order = Criteria::ASC) Order by the _newdate column
 * @method     ChildContributionsVersionQuery orderByModdate($order = Criteria::ASC) Order by the _moddate column
 * @method     ChildContributionsVersionQuery orderByUserSys($order = Criteria::ASC) Order by the __user__ column
 * @method     ChildContributionsVersionQuery orderByConfigSys($order = Criteria::ASC) Order by the __config__ column
 * @method     ChildContributionsVersionQuery orderByForchapter($order = Criteria::ASC) Order by the _forchapter column
 * @method     ChildContributionsVersionQuery orderByParentnode($order = Criteria::ASC) Order by the __parentnode__ column
 * @method     ChildContributionsVersionQuery orderBySort($order = Criteria::ASC) Order by the __sort__ column
 * @method     ChildContributionsVersionQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildContributionsVersionQuery orderByVersionCreatedAt($order = Criteria::ASC) Order by the version_created_at column
 * @method     ChildContributionsVersionQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 * @method     ChildContributionsVersionQuery orderByVersionComment($order = Criteria::ASC) Order by the version_comment column
 * @method     ChildContributionsVersionQuery orderByDataIds($order = Criteria::ASC) Order by the _data_ids column
 * @method     ChildContributionsVersionQuery orderByDataVersions($order = Criteria::ASC) Order by the _data_versions column
 *
 * @method     ChildContributionsVersionQuery groupById() Group by the id column
 * @method     ChildContributionsVersionQuery groupByFortemplate() Group by the _fortemplate column
 * @method     ChildContributionsVersionQuery groupByForissue() Group by the _forissue column
 * @method     ChildContributionsVersionQuery groupByName() Group by the _name column
 * @method     ChildContributionsVersionQuery groupByStatus() Group by the _status column
 * @method     ChildContributionsVersionQuery groupByNewdate() Group by the _newdate column
 * @method     ChildContributionsVersionQuery groupByModdate() Group by the _moddate column
 * @method     ChildContributionsVersionQuery groupByUserSys() Group by the __user__ column
 * @method     ChildContributionsVersionQuery groupByConfigSys() Group by the __config__ column
 * @method     ChildContributionsVersionQuery groupByForchapter() Group by the _forchapter column
 * @method     ChildContributionsVersionQuery groupByParentnode() Group by the __parentnode__ column
 * @method     ChildContributionsVersionQuery groupBySort() Group by the __sort__ column
 * @method     ChildContributionsVersionQuery groupByVersion() Group by the version column
 * @method     ChildContributionsVersionQuery groupByVersionCreatedAt() Group by the version_created_at column
 * @method     ChildContributionsVersionQuery groupByVersionCreatedBy() Group by the version_created_by column
 * @method     ChildContributionsVersionQuery groupByVersionComment() Group by the version_comment column
 * @method     ChildContributionsVersionQuery groupByDataIds() Group by the _data_ids column
 * @method     ChildContributionsVersionQuery groupByDataVersions() Group by the _data_versions column
 *
 * @method     ChildContributionsVersionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildContributionsVersionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildContributionsVersionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildContributionsVersionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildContributionsVersionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildContributionsVersionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildContributionsVersionQuery leftJoinContributions($relationAlias = null) Adds a LEFT JOIN clause to the query using the Contributions relation
 * @method     ChildContributionsVersionQuery rightJoinContributions($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Contributions relation
 * @method     ChildContributionsVersionQuery innerJoinContributions($relationAlias = null) Adds a INNER JOIN clause to the query using the Contributions relation
 *
 * @method     ChildContributionsVersionQuery joinWithContributions($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Contributions relation
 *
 * @method     ChildContributionsVersionQuery leftJoinWithContributions() Adds a LEFT JOIN clause and with to the query using the Contributions relation
 * @method     ChildContributionsVersionQuery rightJoinWithContributions() Adds a RIGHT JOIN clause and with to the query using the Contributions relation
 * @method     ChildContributionsVersionQuery innerJoinWithContributions() Adds a INNER JOIN clause and with to the query using the Contributions relation
 *
 * @method     \ContributionsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildContributionsVersion findOne(ConnectionInterface $con = null) Return the first ChildContributionsVersion matching the query
 * @method     ChildContributionsVersion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildContributionsVersion matching the query, or a new ChildContributionsVersion object populated from the query conditions when no match is found
 *
 * @method     ChildContributionsVersion findOneById(int $id) Return the first ChildContributionsVersion filtered by the id column
 * @method     ChildContributionsVersion findOneByFortemplate(int $_fortemplate) Return the first ChildContributionsVersion filtered by the _fortemplate column
 * @method     ChildContributionsVersion findOneByForissue(int $_forissue) Return the first ChildContributionsVersion filtered by the _forissue column
 * @method     ChildContributionsVersion findOneByName(string $_name) Return the first ChildContributionsVersion filtered by the _name column
 * @method     ChildContributionsVersion findOneByStatus(string $_status) Return the first ChildContributionsVersion filtered by the _status column
 * @method     ChildContributionsVersion findOneByNewdate(int $_newdate) Return the first ChildContributionsVersion filtered by the _newdate column
 * @method     ChildContributionsVersion findOneByModdate(int $_moddate) Return the first ChildContributionsVersion filtered by the _moddate column
 * @method     ChildContributionsVersion findOneByUserSys(int $__user__) Return the first ChildContributionsVersion filtered by the __user__ column
 * @method     ChildContributionsVersion findOneByConfigSys(string $__config__) Return the first ChildContributionsVersion filtered by the __config__ column
 * @method     ChildContributionsVersion findOneByForchapter(int $_forchapter) Return the first ChildContributionsVersion filtered by the _forchapter column
 * @method     ChildContributionsVersion findOneByParentnode(int $__parentnode__) Return the first ChildContributionsVersion filtered by the __parentnode__ column
 * @method     ChildContributionsVersion findOneBySort(int $__sort__) Return the first ChildContributionsVersion filtered by the __sort__ column
 * @method     ChildContributionsVersion findOneByVersion(int $version) Return the first ChildContributionsVersion filtered by the version column
 * @method     ChildContributionsVersion findOneByVersionCreatedAt(string $version_created_at) Return the first ChildContributionsVersion filtered by the version_created_at column
 * @method     ChildContributionsVersion findOneByVersionCreatedBy(string $version_created_by) Return the first ChildContributionsVersion filtered by the version_created_by column
 * @method     ChildContributionsVersion findOneByVersionComment(string $version_comment) Return the first ChildContributionsVersion filtered by the version_comment column
 * @method     ChildContributionsVersion findOneByDataIds(array $_data_ids) Return the first ChildContributionsVersion filtered by the _data_ids column
 * @method     ChildContributionsVersion findOneByDataVersions(array $_data_versions) Return the first ChildContributionsVersion filtered by the _data_versions column *

 * @method     ChildContributionsVersion requirePk($key, ConnectionInterface $con = null) Return the ChildContributionsVersion by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionsVersion requireOne(ConnectionInterface $con = null) Return the first ChildContributionsVersion matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildContributionsVersion requireOneById(int $id) Return the first ChildContributionsVersion filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionsVersion requireOneByFortemplate(int $_fortemplate) Return the first ChildContributionsVersion filtered by the _fortemplate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionsVersion requireOneByForissue(int $_forissue) Return the first ChildContributionsVersion filtered by the _forissue column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionsVersion requireOneByName(string $_name) Return the first ChildContributionsVersion filtered by the _name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionsVersion requireOneByStatus(string $_status) Return the first ChildContributionsVersion filtered by the _status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionsVersion requireOneByNewdate(int $_newdate) Return the first ChildContributionsVersion filtered by the _newdate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionsVersion requireOneByModdate(int $_moddate) Return the first ChildContributionsVersion filtered by the _moddate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionsVersion requireOneByUserSys(int $__user__) Return the first ChildContributionsVersion filtered by the __user__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionsVersion requireOneByConfigSys(string $__config__) Return the first ChildContributionsVersion filtered by the __config__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionsVersion requireOneByForchapter(int $_forchapter) Return the first ChildContributionsVersion filtered by the _forchapter column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionsVersion requireOneByParentnode(int $__parentnode__) Return the first ChildContributionsVersion filtered by the __parentnode__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionsVersion requireOneBySort(int $__sort__) Return the first ChildContributionsVersion filtered by the __sort__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionsVersion requireOneByVersion(int $version) Return the first ChildContributionsVersion filtered by the version column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionsVersion requireOneByVersionCreatedAt(string $version_created_at) Return the first ChildContributionsVersion filtered by the version_created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionsVersion requireOneByVersionCreatedBy(string $version_created_by) Return the first ChildContributionsVersion filtered by the version_created_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionsVersion requireOneByVersionComment(string $version_comment) Return the first ChildContributionsVersion filtered by the version_comment column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionsVersion requireOneByDataIds(array $_data_ids) Return the first ChildContributionsVersion filtered by the _data_ids column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionsVersion requireOneByDataVersions(array $_data_versions) Return the first ChildContributionsVersion filtered by the _data_versions column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildContributionsVersion[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildContributionsVersion objects based on current ModelCriteria
 * @method     ChildContributionsVersion[]|ObjectCollection findById(int $id) Return ChildContributionsVersion objects filtered by the id column
 * @method     ChildContributionsVersion[]|ObjectCollection findByFortemplate(int $_fortemplate) Return ChildContributionsVersion objects filtered by the _fortemplate column
 * @method     ChildContributionsVersion[]|ObjectCollection findByForissue(int $_forissue) Return ChildContributionsVersion objects filtered by the _forissue column
 * @method     ChildContributionsVersion[]|ObjectCollection findByName(string $_name) Return ChildContributionsVersion objects filtered by the _name column
 * @method     ChildContributionsVersion[]|ObjectCollection findByStatus(string $_status) Return ChildContributionsVersion objects filtered by the _status column
 * @method     ChildContributionsVersion[]|ObjectCollection findByNewdate(int $_newdate) Return ChildContributionsVersion objects filtered by the _newdate column
 * @method     ChildContributionsVersion[]|ObjectCollection findByModdate(int $_moddate) Return ChildContributionsVersion objects filtered by the _moddate column
 * @method     ChildContributionsVersion[]|ObjectCollection findByUserSys(int $__user__) Return ChildContributionsVersion objects filtered by the __user__ column
 * @method     ChildContributionsVersion[]|ObjectCollection findByConfigSys(string $__config__) Return ChildContributionsVersion objects filtered by the __config__ column
 * @method     ChildContributionsVersion[]|ObjectCollection findByForchapter(int $_forchapter) Return ChildContributionsVersion objects filtered by the _forchapter column
 * @method     ChildContributionsVersion[]|ObjectCollection findByParentnode(int $__parentnode__) Return ChildContributionsVersion objects filtered by the __parentnode__ column
 * @method     ChildContributionsVersion[]|ObjectCollection findBySort(int $__sort__) Return ChildContributionsVersion objects filtered by the __sort__ column
 * @method     ChildContributionsVersion[]|ObjectCollection findByVersion(int $version) Return ChildContributionsVersion objects filtered by the version column
 * @method     ChildContributionsVersion[]|ObjectCollection findByVersionCreatedAt(string $version_created_at) Return ChildContributionsVersion objects filtered by the version_created_at column
 * @method     ChildContributionsVersion[]|ObjectCollection findByVersionCreatedBy(string $version_created_by) Return ChildContributionsVersion objects filtered by the version_created_by column
 * @method     ChildContributionsVersion[]|ObjectCollection findByVersionComment(string $version_comment) Return ChildContributionsVersion objects filtered by the version_comment column
 * @method     ChildContributionsVersion[]|ObjectCollection findByDataIds(array $_data_ids) Return ChildContributionsVersion objects filtered by the _data_ids column
 * @method     ChildContributionsVersion[]|ObjectCollection findByDataVersions(array $_data_versions) Return ChildContributionsVersion objects filtered by the _data_versions column
 * @method     ChildContributionsVersion[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ContributionsVersionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ContributionsVersionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\ContributionsVersion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildContributionsVersionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildContributionsVersionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildContributionsVersionQuery) {
            return $criteria;
        }
        $query = new ChildContributionsVersionQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$id, $version] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildContributionsVersion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ContributionsVersionTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ContributionsVersionTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildContributionsVersion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, _fortemplate, _forissue, _name, _status, _newdate, _moddate, __user__, __config__, _forchapter, __parentnode__, __sort__, version, version_created_at, version_created_by, version_comment, _data_ids, _data_versions FROM _contributions_version WHERE id = :p0 AND version = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildContributionsVersion $obj */
            $obj = new ChildContributionsVersion();
            $obj->hydrate($row);
            ContributionsVersionTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildContributionsVersion|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildContributionsVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ContributionsVersionTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ContributionsVersionTableMap::COL_VERSION, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildContributionsVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ContributionsVersionTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ContributionsVersionTableMap::COL_VERSION, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @see       filterByContributions()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContributionsVersionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ContributionsVersionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ContributionsVersionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionsVersionTableMap::COL_ID, $id, $comparison);
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
     * @param     mixed $fortemplate The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContributionsVersionQuery The current query, for fluid interface
     */
    public function filterByFortemplate($fortemplate = null, $comparison = null)
    {
        if (is_array($fortemplate)) {
            $useMinMax = false;
            if (isset($fortemplate['min'])) {
                $this->addUsingAlias(ContributionsVersionTableMap::COL__FORTEMPLATE, $fortemplate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fortemplate['max'])) {
                $this->addUsingAlias(ContributionsVersionTableMap::COL__FORTEMPLATE, $fortemplate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionsVersionTableMap::COL__FORTEMPLATE, $fortemplate, $comparison);
    }

    /**
     * Filter the query on the _forissue column
     *
     * Example usage:
     * <code>
     * $query->filterByForissue(1234); // WHERE _forissue = 1234
     * $query->filterByForissue(array(12, 34)); // WHERE _forissue IN (12, 34)
     * $query->filterByForissue(array('min' => 12)); // WHERE _forissue > 12
     * </code>
     *
     * @param     mixed $forissue The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContributionsVersionQuery The current query, for fluid interface
     */
    public function filterByForissue($forissue = null, $comparison = null)
    {
        if (is_array($forissue)) {
            $useMinMax = false;
            if (isset($forissue['min'])) {
                $this->addUsingAlias(ContributionsVersionTableMap::COL__FORISSUE, $forissue['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($forissue['max'])) {
                $this->addUsingAlias(ContributionsVersionTableMap::COL__FORISSUE, $forissue['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionsVersionTableMap::COL__FORISSUE, $forissue, $comparison);
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
     * @return $this|ChildContributionsVersionQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionsVersionTableMap::COL__NAME, $name, $comparison);
    }

    /**
     * Filter the query on the _status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus('fooValue');   // WHERE _status = 'fooValue'
     * $query->filterByStatus('%fooValue%', Criteria::LIKE); // WHERE _status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $status The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContributionsVersionQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionsVersionTableMap::COL__STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the _newdate column
     *
     * Example usage:
     * <code>
     * $query->filterByNewdate(1234); // WHERE _newdate = 1234
     * $query->filterByNewdate(array(12, 34)); // WHERE _newdate IN (12, 34)
     * $query->filterByNewdate(array('min' => 12)); // WHERE _newdate > 12
     * </code>
     *
     * @param     mixed $newdate The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContributionsVersionQuery The current query, for fluid interface
     */
    public function filterByNewdate($newdate = null, $comparison = null)
    {
        if (is_array($newdate)) {
            $useMinMax = false;
            if (isset($newdate['min'])) {
                $this->addUsingAlias(ContributionsVersionTableMap::COL__NEWDATE, $newdate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($newdate['max'])) {
                $this->addUsingAlias(ContributionsVersionTableMap::COL__NEWDATE, $newdate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionsVersionTableMap::COL__NEWDATE, $newdate, $comparison);
    }

    /**
     * Filter the query on the _moddate column
     *
     * Example usage:
     * <code>
     * $query->filterByModdate(1234); // WHERE _moddate = 1234
     * $query->filterByModdate(array(12, 34)); // WHERE _moddate IN (12, 34)
     * $query->filterByModdate(array('min' => 12)); // WHERE _moddate > 12
     * </code>
     *
     * @param     mixed $moddate The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContributionsVersionQuery The current query, for fluid interface
     */
    public function filterByModdate($moddate = null, $comparison = null)
    {
        if (is_array($moddate)) {
            $useMinMax = false;
            if (isset($moddate['min'])) {
                $this->addUsingAlias(ContributionsVersionTableMap::COL__MODDATE, $moddate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($moddate['max'])) {
                $this->addUsingAlias(ContributionsVersionTableMap::COL__MODDATE, $moddate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionsVersionTableMap::COL__MODDATE, $moddate, $comparison);
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
     * @param     mixed $userSys The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContributionsVersionQuery The current query, for fluid interface
     */
    public function filterByUserSys($userSys = null, $comparison = null)
    {
        if (is_array($userSys)) {
            $useMinMax = false;
            if (isset($userSys['min'])) {
                $this->addUsingAlias(ContributionsVersionTableMap::COL___USER__, $userSys['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userSys['max'])) {
                $this->addUsingAlias(ContributionsVersionTableMap::COL___USER__, $userSys['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionsVersionTableMap::COL___USER__, $userSys, $comparison);
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
     * @return $this|ChildContributionsVersionQuery The current query, for fluid interface
     */
    public function filterByConfigSys($configSys = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($configSys)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionsVersionTableMap::COL___CONFIG__, $configSys, $comparison);
    }

    /**
     * Filter the query on the _forchapter column
     *
     * Example usage:
     * <code>
     * $query->filterByForchapter(1234); // WHERE _forchapter = 1234
     * $query->filterByForchapter(array(12, 34)); // WHERE _forchapter IN (12, 34)
     * $query->filterByForchapter(array('min' => 12)); // WHERE _forchapter > 12
     * </code>
     *
     * @param     mixed $forchapter The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContributionsVersionQuery The current query, for fluid interface
     */
    public function filterByForchapter($forchapter = null, $comparison = null)
    {
        if (is_array($forchapter)) {
            $useMinMax = false;
            if (isset($forchapter['min'])) {
                $this->addUsingAlias(ContributionsVersionTableMap::COL__FORCHAPTER, $forchapter['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($forchapter['max'])) {
                $this->addUsingAlias(ContributionsVersionTableMap::COL__FORCHAPTER, $forchapter['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionsVersionTableMap::COL__FORCHAPTER, $forchapter, $comparison);
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
     * @return $this|ChildContributionsVersionQuery The current query, for fluid interface
     */
    public function filterByParentnode($parentnode = null, $comparison = null)
    {
        if (is_array($parentnode)) {
            $useMinMax = false;
            if (isset($parentnode['min'])) {
                $this->addUsingAlias(ContributionsVersionTableMap::COL___PARENTNODE__, $parentnode['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentnode['max'])) {
                $this->addUsingAlias(ContributionsVersionTableMap::COL___PARENTNODE__, $parentnode['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionsVersionTableMap::COL___PARENTNODE__, $parentnode, $comparison);
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
     * @return $this|ChildContributionsVersionQuery The current query, for fluid interface
     */
    public function filterBySort($sort = null, $comparison = null)
    {
        if (is_array($sort)) {
            $useMinMax = false;
            if (isset($sort['min'])) {
                $this->addUsingAlias(ContributionsVersionTableMap::COL___SORT__, $sort['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sort['max'])) {
                $this->addUsingAlias(ContributionsVersionTableMap::COL___SORT__, $sort['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionsVersionTableMap::COL___SORT__, $sort, $comparison);
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
     * @return $this|ChildContributionsVersionQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(ContributionsVersionTableMap::COL_VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(ContributionsVersionTableMap::COL_VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionsVersionTableMap::COL_VERSION, $version, $comparison);
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
     * @return $this|ChildContributionsVersionQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedAt($versionCreatedAt = null, $comparison = null)
    {
        if (is_array($versionCreatedAt)) {
            $useMinMax = false;
            if (isset($versionCreatedAt['min'])) {
                $this->addUsingAlias(ContributionsVersionTableMap::COL_VERSION_CREATED_AT, $versionCreatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($versionCreatedAt['max'])) {
                $this->addUsingAlias(ContributionsVersionTableMap::COL_VERSION_CREATED_AT, $versionCreatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionsVersionTableMap::COL_VERSION_CREATED_AT, $versionCreatedAt, $comparison);
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
     * @return $this|ChildContributionsVersionQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedBy($versionCreatedBy = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($versionCreatedBy)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionsVersionTableMap::COL_VERSION_CREATED_BY, $versionCreatedBy, $comparison);
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
     * @return $this|ChildContributionsVersionQuery The current query, for fluid interface
     */
    public function filterByVersionComment($versionComment = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($versionComment)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionsVersionTableMap::COL_VERSION_COMMENT, $versionComment, $comparison);
    }

    /**
     * Filter the query on the _data_ids column
     *
     * @param     array $dataIds The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContributionsVersionQuery The current query, for fluid interface
     */
    public function filterByDataIds($dataIds = null, $comparison = null)
    {
        $key = $this->getAliasedColName(ContributionsVersionTableMap::COL__DATA_IDS);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($dataIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($dataIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($dataIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::NOT_LIKE);
                } else {
                    $this->add($key, $value, Criteria::NOT_LIKE);
                }
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(ContributionsVersionTableMap::COL__DATA_IDS, $dataIds, $comparison);
    }

    /**
     * Filter the query on the _data_ids column
     * @param     mixed $dataIds The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return $this|ChildContributionsVersionQuery The current query, for fluid interface
     */
    public function filterByDataId($dataIds = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($dataIds)) {
                $dataIds = '%| ' . $dataIds . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $dataIds = '%| ' . $dataIds . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(ContributionsVersionTableMap::COL__DATA_IDS);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $dataIds, $comparison);
            } else {
                $this->addAnd($key, $dataIds, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(ContributionsVersionTableMap::COL__DATA_IDS, $dataIds, $comparison);
    }

    /**
     * Filter the query on the _data_versions column
     *
     * @param     array $dataVersions The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContributionsVersionQuery The current query, for fluid interface
     */
    public function filterByDataVersions($dataVersions = null, $comparison = null)
    {
        $key = $this->getAliasedColName(ContributionsVersionTableMap::COL__DATA_VERSIONS);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($dataVersions as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($dataVersions as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($dataVersions as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::NOT_LIKE);
                } else {
                    $this->add($key, $value, Criteria::NOT_LIKE);
                }
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(ContributionsVersionTableMap::COL__DATA_VERSIONS, $dataVersions, $comparison);
    }

    /**
     * Filter the query on the _data_versions column
     * @param     mixed $dataVersions The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return $this|ChildContributionsVersionQuery The current query, for fluid interface
     */
    public function filterByDataVersion($dataVersions = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($dataVersions)) {
                $dataVersions = '%| ' . $dataVersions . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $dataVersions = '%| ' . $dataVersions . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(ContributionsVersionTableMap::COL__DATA_VERSIONS);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $dataVersions, $comparison);
            } else {
                $this->addAnd($key, $dataVersions, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(ContributionsVersionTableMap::COL__DATA_VERSIONS, $dataVersions, $comparison);
    }

    /**
     * Filter the query by a related \Contributions object
     *
     * @param \Contributions|ObjectCollection $contributions The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildContributionsVersionQuery The current query, for fluid interface
     */
    public function filterByContributions($contributions, $comparison = null)
    {
        if ($contributions instanceof \Contributions) {
            return $this
                ->addUsingAlias(ContributionsVersionTableMap::COL_ID, $contributions->getId(), $comparison);
        } elseif ($contributions instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ContributionsVersionTableMap::COL_ID, $contributions->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildContributionsVersionQuery The current query, for fluid interface
     */
    public function joinContributions($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useContributionsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinContributions($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Contributions', '\ContributionsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildContributionsVersion $contributionsVersion Object to remove from the list of results
     *
     * @return $this|ChildContributionsVersionQuery The current query, for fluid interface
     */
    public function prune($contributionsVersion = null)
    {
        if ($contributionsVersion) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ContributionsVersionTableMap::COL_ID), $contributionsVersion->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ContributionsVersionTableMap::COL_VERSION), $contributionsVersion->getVersion(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the _contributions_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ContributionsVersionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ContributionsVersionTableMap::clearInstancePool();
            ContributionsVersionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ContributionsVersionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ContributionsVersionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ContributionsVersionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ContributionsVersionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ContributionsVersionQuery
