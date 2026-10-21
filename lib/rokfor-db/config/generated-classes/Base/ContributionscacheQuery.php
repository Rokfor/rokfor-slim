<?php

namespace Base;

use \Contributionscache as ChildContributionscache;
use \ContributionscacheQuery as ChildContributionscacheQuery;
use \Exception;
use \PDO;
use Map\ContributionscacheTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the '_contributions_cache' table.
 *
 *
 *
 * @method     ChildContributionscacheQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildContributionscacheQuery orderBySignature($order = Criteria::ASC) Order by the _signature column
 * @method     ChildContributionscacheQuery orderByForcontribution($order = Criteria::ASC) Order by the _forcontribution column
 * @method     ChildContributionscacheQuery orderByCache($order = Criteria::ASC) Order by the _cache column
 * @method     ChildContributionscacheQuery orderByBook($order = Criteria::ASC) Order by the _book column
 * @method     ChildContributionscacheQuery orderByIssue($order = Criteria::ASC) Order by the _issue column
 * @method     ChildContributionscacheQuery orderByChapter($order = Criteria::ASC) Order by the _chapter column
 * @method     ChildContributionscacheQuery orderByTemplate($order = Criteria::ASC) Order by the _template column
 * @method     ChildContributionscacheQuery orderByContribution($order = Criteria::ASC) Order by the _contribution column
 * @method     ChildContributionscacheQuery orderByTouched($order = Criteria::ASC) Order by the _touched column
 *
 * @method     ChildContributionscacheQuery groupById() Group by the id column
 * @method     ChildContributionscacheQuery groupBySignature() Group by the _signature column
 * @method     ChildContributionscacheQuery groupByForcontribution() Group by the _forcontribution column
 * @method     ChildContributionscacheQuery groupByCache() Group by the _cache column
 * @method     ChildContributionscacheQuery groupByBook() Group by the _book column
 * @method     ChildContributionscacheQuery groupByIssue() Group by the _issue column
 * @method     ChildContributionscacheQuery groupByChapter() Group by the _chapter column
 * @method     ChildContributionscacheQuery groupByTemplate() Group by the _template column
 * @method     ChildContributionscacheQuery groupByContribution() Group by the _contribution column
 * @method     ChildContributionscacheQuery groupByTouched() Group by the _touched column
 *
 * @method     ChildContributionscacheQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildContributionscacheQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildContributionscacheQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildContributionscacheQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildContributionscacheQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildContributionscacheQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildContributionscacheQuery leftJoinContributions($relationAlias = null) Adds a LEFT JOIN clause to the query using the Contributions relation
 * @method     ChildContributionscacheQuery rightJoinContributions($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Contributions relation
 * @method     ChildContributionscacheQuery innerJoinContributions($relationAlias = null) Adds a INNER JOIN clause to the query using the Contributions relation
 *
 * @method     ChildContributionscacheQuery joinWithContributions($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Contributions relation
 *
 * @method     ChildContributionscacheQuery leftJoinWithContributions() Adds a LEFT JOIN clause and with to the query using the Contributions relation
 * @method     ChildContributionscacheQuery rightJoinWithContributions() Adds a RIGHT JOIN clause and with to the query using the Contributions relation
 * @method     ChildContributionscacheQuery innerJoinWithContributions() Adds a INNER JOIN clause and with to the query using the Contributions relation
 *
 * @method     \ContributionsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildContributionscache findOne(ConnectionInterface $con = null) Return the first ChildContributionscache matching the query
 * @method     ChildContributionscache findOneOrCreate(ConnectionInterface $con = null) Return the first ChildContributionscache matching the query, or a new ChildContributionscache object populated from the query conditions when no match is found
 *
 * @method     ChildContributionscache findOneById(int $id) Return the first ChildContributionscache filtered by the id column
 * @method     ChildContributionscache findOneBySignature(string $_signature) Return the first ChildContributionscache filtered by the _signature column
 * @method     ChildContributionscache findOneByForcontribution(int $_forcontribution) Return the first ChildContributionscache filtered by the _forcontribution column
 * @method     ChildContributionscache findOneByCache(string $_cache) Return the first ChildContributionscache filtered by the _cache column
 * @method     ChildContributionscache findOneByBook(string $_book) Return the first ChildContributionscache filtered by the _book column
 * @method     ChildContributionscache findOneByIssue(string $_issue) Return the first ChildContributionscache filtered by the _issue column
 * @method     ChildContributionscache findOneByChapter(string $_chapter) Return the first ChildContributionscache filtered by the _chapter column
 * @method     ChildContributionscache findOneByTemplate(string $_template) Return the first ChildContributionscache filtered by the _template column
 * @method     ChildContributionscache findOneByContribution(string $_contribution) Return the first ChildContributionscache filtered by the _contribution column
 * @method     ChildContributionscache findOneByTouched(string $_touched) Return the first ChildContributionscache filtered by the _touched column *

 * @method     ChildContributionscache requirePk($key, ConnectionInterface $con = null) Return the ChildContributionscache by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionscache requireOne(ConnectionInterface $con = null) Return the first ChildContributionscache matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildContributionscache requireOneById(int $id) Return the first ChildContributionscache filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionscache requireOneBySignature(string $_signature) Return the first ChildContributionscache filtered by the _signature column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionscache requireOneByForcontribution(int $_forcontribution) Return the first ChildContributionscache filtered by the _forcontribution column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionscache requireOneByCache(string $_cache) Return the first ChildContributionscache filtered by the _cache column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionscache requireOneByBook(string $_book) Return the first ChildContributionscache filtered by the _book column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionscache requireOneByIssue(string $_issue) Return the first ChildContributionscache filtered by the _issue column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionscache requireOneByChapter(string $_chapter) Return the first ChildContributionscache filtered by the _chapter column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionscache requireOneByTemplate(string $_template) Return the first ChildContributionscache filtered by the _template column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionscache requireOneByContribution(string $_contribution) Return the first ChildContributionscache filtered by the _contribution column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildContributionscache requireOneByTouched(string $_touched) Return the first ChildContributionscache filtered by the _touched column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildContributionscache[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildContributionscache objects based on current ModelCriteria
 * @method     ChildContributionscache[]|ObjectCollection findById(int $id) Return ChildContributionscache objects filtered by the id column
 * @method     ChildContributionscache[]|ObjectCollection findBySignature(string $_signature) Return ChildContributionscache objects filtered by the _signature column
 * @method     ChildContributionscache[]|ObjectCollection findByForcontribution(int $_forcontribution) Return ChildContributionscache objects filtered by the _forcontribution column
 * @method     ChildContributionscache[]|ObjectCollection findByCache(string $_cache) Return ChildContributionscache objects filtered by the _cache column
 * @method     ChildContributionscache[]|ObjectCollection findByBook(string $_book) Return ChildContributionscache objects filtered by the _book column
 * @method     ChildContributionscache[]|ObjectCollection findByIssue(string $_issue) Return ChildContributionscache objects filtered by the _issue column
 * @method     ChildContributionscache[]|ObjectCollection findByChapter(string $_chapter) Return ChildContributionscache objects filtered by the _chapter column
 * @method     ChildContributionscache[]|ObjectCollection findByTemplate(string $_template) Return ChildContributionscache objects filtered by the _template column
 * @method     ChildContributionscache[]|ObjectCollection findByContribution(string $_contribution) Return ChildContributionscache objects filtered by the _contribution column
 * @method     ChildContributionscache[]|ObjectCollection findByTouched(string $_touched) Return ChildContributionscache objects filtered by the _touched column
 * @method     ChildContributionscache[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ContributionscacheQuery extends ModelCriteria
{

    // data_cache behavior

    protected $cacheKey      = '';
    protected $cacheLocale   = '';
    protected $cacheEnable   = true;
    protected $cacheLifeTime = 0;
            protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ContributionscacheQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\Contributionscache', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildContributionscacheQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildContributionscacheQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildContributionscacheQuery) {
            return $criteria;
        }
        $query = new ChildContributionscacheQuery();
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
     * @return ChildContributionscache|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ContributionscacheTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ContributionscacheTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->filterByPrimaryKey($key)->findOne($con);
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
     * @return ChildContributionscache A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, _signature, _forcontribution, _cache, _book, _issue, _chapter, _template, _contribution, _touched FROM _contributions_cache WHERE id = :p0';
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
            /** @var ChildContributionscache $obj */
            $obj = new ChildContributionscache();
            $obj->hydrate($row);
            ContributionscacheTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildContributionscache|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildContributionscacheQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ContributionscacheTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildContributionscacheQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ContributionscacheTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildContributionscacheQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ContributionscacheTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ContributionscacheTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionscacheTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the _signature column
     *
     * Example usage:
     * <code>
     * $query->filterBySignature('fooValue');   // WHERE _signature = 'fooValue'
     * $query->filterBySignature('%fooValue%', Criteria::LIKE); // WHERE _signature LIKE '%fooValue%'
     * </code>
     *
     * @param     string $signature The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContributionscacheQuery The current query, for fluid interface
     */
    public function filterBySignature($signature = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($signature)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionscacheTableMap::COL__SIGNATURE, $signature, $comparison);
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
     * @return $this|ChildContributionscacheQuery The current query, for fluid interface
     */
    public function filterByForcontribution($forcontribution = null, $comparison = null)
    {
        if (is_array($forcontribution)) {
            $useMinMax = false;
            if (isset($forcontribution['min'])) {
                $this->addUsingAlias(ContributionscacheTableMap::COL__FORCONTRIBUTION, $forcontribution['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($forcontribution['max'])) {
                $this->addUsingAlias(ContributionscacheTableMap::COL__FORCONTRIBUTION, $forcontribution['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionscacheTableMap::COL__FORCONTRIBUTION, $forcontribution, $comparison);
    }

    /**
     * Filter the query on the _cache column
     *
     * Example usage:
     * <code>
     * $query->filterByCache('fooValue');   // WHERE _cache = 'fooValue'
     * $query->filterByCache('%fooValue%', Criteria::LIKE); // WHERE _cache LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cache The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContributionscacheQuery The current query, for fluid interface
     */
    public function filterByCache($cache = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cache)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionscacheTableMap::COL__CACHE, $cache, $comparison);
    }

    /**
     * Filter the query on the _book column
     *
     * Example usage:
     * <code>
     * $query->filterByBook('fooValue');   // WHERE _book = 'fooValue'
     * $query->filterByBook('%fooValue%', Criteria::LIKE); // WHERE _book LIKE '%fooValue%'
     * </code>
     *
     * @param     string $book The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContributionscacheQuery The current query, for fluid interface
     */
    public function filterByBook($book = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($book)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionscacheTableMap::COL__BOOK, $book, $comparison);
    }

    /**
     * Filter the query on the _issue column
     *
     * Example usage:
     * <code>
     * $query->filterByIssue('fooValue');   // WHERE _issue = 'fooValue'
     * $query->filterByIssue('%fooValue%', Criteria::LIKE); // WHERE _issue LIKE '%fooValue%'
     * </code>
     *
     * @param     string $issue The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContributionscacheQuery The current query, for fluid interface
     */
    public function filterByIssue($issue = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($issue)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionscacheTableMap::COL__ISSUE, $issue, $comparison);
    }

    /**
     * Filter the query on the _chapter column
     *
     * Example usage:
     * <code>
     * $query->filterByChapter('fooValue');   // WHERE _chapter = 'fooValue'
     * $query->filterByChapter('%fooValue%', Criteria::LIKE); // WHERE _chapter LIKE '%fooValue%'
     * </code>
     *
     * @param     string $chapter The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContributionscacheQuery The current query, for fluid interface
     */
    public function filterByChapter($chapter = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($chapter)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionscacheTableMap::COL__CHAPTER, $chapter, $comparison);
    }

    /**
     * Filter the query on the _template column
     *
     * Example usage:
     * <code>
     * $query->filterByTemplate('fooValue');   // WHERE _template = 'fooValue'
     * $query->filterByTemplate('%fooValue%', Criteria::LIKE); // WHERE _template LIKE '%fooValue%'
     * </code>
     *
     * @param     string $template The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContributionscacheQuery The current query, for fluid interface
     */
    public function filterByTemplate($template = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($template)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionscacheTableMap::COL__TEMPLATE, $template, $comparison);
    }

    /**
     * Filter the query on the _contribution column
     *
     * Example usage:
     * <code>
     * $query->filterByContribution('fooValue');   // WHERE _contribution = 'fooValue'
     * $query->filterByContribution('%fooValue%', Criteria::LIKE); // WHERE _contribution LIKE '%fooValue%'
     * </code>
     *
     * @param     string $contribution The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContributionscacheQuery The current query, for fluid interface
     */
    public function filterByContribution($contribution = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($contribution)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionscacheTableMap::COL__CONTRIBUTION, $contribution, $comparison);
    }

    /**
     * Filter the query on the _touched column
     *
     * Example usage:
     * <code>
     * $query->filterByTouched('2011-03-14'); // WHERE _touched = '2011-03-14'
     * $query->filterByTouched('now'); // WHERE _touched = '2011-03-14'
     * $query->filterByTouched(array('max' => 'yesterday')); // WHERE _touched > '2011-03-13'
     * </code>
     *
     * @param     mixed $touched The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildContributionscacheQuery The current query, for fluid interface
     */
    public function filterByTouched($touched = null, $comparison = null)
    {
        if (is_array($touched)) {
            $useMinMax = false;
            if (isset($touched['min'])) {
                $this->addUsingAlias(ContributionscacheTableMap::COL__TOUCHED, $touched['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($touched['max'])) {
                $this->addUsingAlias(ContributionscacheTableMap::COL__TOUCHED, $touched['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ContributionscacheTableMap::COL__TOUCHED, $touched, $comparison);
    }

    /**
     * Filter the query by a related \Contributions object
     *
     * @param \Contributions|ObjectCollection $contributions The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildContributionscacheQuery The current query, for fluid interface
     */
    public function filterByContributions($contributions, $comparison = null)
    {
        if ($contributions instanceof \Contributions) {
            return $this
                ->addUsingAlias(ContributionscacheTableMap::COL__FORCONTRIBUTION, $contributions->getId(), $comparison);
        } elseif ($contributions instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ContributionscacheTableMap::COL__FORCONTRIBUTION, $contributions->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildContributionscacheQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildContributionscache $contributionscache Object to remove from the list of results
     *
     * @return $this|ChildContributionscacheQuery The current query, for fluid interface
     */
    public function prune($contributionscache = null)
    {
        if ($contributionscache) {
            $this->addUsingAlias(ContributionscacheTableMap::COL_ID, $contributionscache->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Code to execute after every DELETE statement
     *
     * @param     int $affectedRows the number of deleted rows
     * @param     ConnectionInterface $con The connection object used by the query
     */
    protected function basePostDelete($affectedRows, ConnectionInterface $con)
    {
        // data_cache behavior
        \ContributionscacheQuery::purgeCache();

        return $this->postDelete($affectedRows, $con);
    }

    /**
     * Code to execute after every UPDATE statement
     *
     * @param     int $affectedRows the number of updated rows
     * @param     ConnectionInterface $con The connection object used by the query
     */
    protected function basePostUpdate($affectedRows, ConnectionInterface $con)
    {
        // data_cache behavior
        \ContributionscacheQuery::purgeCache();

        return $this->postUpdate($affectedRows, $con);
    }

    /**
     * Deletes all rows from the _contributions_cache table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ContributionscacheTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ContributionscacheTableMap::clearInstancePool();
            ContributionscacheTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ContributionscacheTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ContributionscacheTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ContributionscacheTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ContributionscacheTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // data_cache behavior

    public static function purgeCache()
    {

        $driver = \TFC\Cache\DoctrineCacheFactory::factory('redis');
        $driver->setNamespace(ContributionscacheTableMap::TABLE_NAME);

        return $driver->deleteAll();

    }

    public static function cacheFetch($key)
    {

        $driver = \TFC\Cache\DoctrineCacheFactory::factory('redis');
        $driver->setNamespace(ContributionscacheTableMap::TABLE_NAME);

        $result = $driver->fetch($key);

        if ($result !== null) {
            if ($result instanceof \ArrayAccess) {
                foreach ($result as $element) {
                    if ($element instanceof \Contributionscache) {
                        ContributionscacheTableMap::addInstanceToPool($element);
                    }
                }
            } else if ($result instanceof \Contributionscache) {
                ContributionscacheTableMap::addInstanceToPool($result);
            }
        }

        return $result;


    }

    public static function cacheStore($key, $data, $lifetime)
    {
        $driver = \TFC\Cache\DoctrineCacheFactory::factory('redis');
        $driver->setNamespace(ContributionscacheTableMap::TABLE_NAME);

        return $driver->save($key,$data,$lifetime);
    }

    public static function cacheDelete($key)
    {
        $driver = \TFC\Cache\DoctrineCacheFactory::factory('redis');
        $driver->setNamespace(ContributionscacheTableMap::TABLE_NAME);

        return $driver->delete($key);
    }

    public function setCacheEnable()
    {
        $this->cacheEnable = true;

        return $this;
    }

    public function setCacheDisable()
    {
        $this->cacheEnable = false;

        return $this;
    }

    public function isCacheEnable()
    {
        return (bool)$this->cacheEnable;
    }

    public function getCacheKey()
    {
        if ($this->cacheKey) {
            return $this->cacheKey;
        }
        $params      = array();
        $sql_hash    = hash('md4', $this->createSelectSql($params));
        $params_hash = hash('md4', json_encode($params));
        $locale      = $this->cacheLocale ? '_' . $this->cacheLocale : '';
        $this->cacheKey = $sql_hash . '_' . $params_hash . $locale;

        return $this->cacheKey;
    }

    public function setCacheKey($cacheKey)
    {
        $this->cacheKey = $cacheKey;

        return $this;
    }

    public function setCacheLocale($locale)
    {
        $this->cacheLocale = $locale;

        return $this;
    }

    public function setLifeTime($lifetime)
    {
        $this->cacheLifeTime = $lifetime;

        return $this;
    }

    public function getLifeTime()
    {
        return $this->cacheLifeTime;
    }

    /**
     * Issue a SELECT query based on the current ModelCriteria
     * and format the list of results with the current formatter
     * By default, returns an array of model objects
     *
     * @param ConnectionInterface $con an optional connection object
     *
     * @return \Propel\Runtime\Collection\ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function find(ConnectionInterface $con = null)
    {
        if ($this->isCacheEnable() && $cache = \ContributionscacheQuery::cacheFetch($this->getCacheKey())) {
            if ($cache instanceof \Propel\Runtime\Collection\ObjectCollection) {
                $formatter = $this->getFormatter()->init($this);
                $cache->setFormatter($formatter);
            }
            return $cache;
        }

        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }

        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria->doSelect($con);

        $data = $criteria->getFormatter()->init($criteria)->format($dataFetcher);

        if ($this->isCacheEnable()) {
            \ContributionscacheQuery::cacheStore($this->getCacheKey(), $data, $this->getLifeTime());
        }

        return $data;


    }

    /**
     * Issue a SELECT ... LIMIT 1 query based on the current ModelCriteria
     * and format the result with the current formatter
     * By default, returns a model object
     *
     * @param ConnectionInterface $con an optional connection object
     *
     * @return mixed the result, formatted by the current formatter
     */
    public function findOne(ConnectionInterface $con  = null)
    {
        if ($this->isCacheEnable() && $cache = \ContributionscacheQuery::cacheFetch($this->getCacheKey())) {
            if ($cache instanceof \Contributionscache) {
                return $cache;
            }
        }

        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }

        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $criteria->limit(1);
        $dataFetcher = $criteria->doSelect($con);

        $data = $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);

        if ($this->isCacheEnable()) {
            \ContributionscacheQuery::cacheStore($this->getCacheKey(), $data, $this->getLifeTime());
        }

        return $data;
    }

} // ContributionscacheQuery
