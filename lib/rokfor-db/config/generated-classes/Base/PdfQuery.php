<?php

namespace Base;

use \Pdf as ChildPdf;
use \PdfQuery as ChildPdfQuery;
use \Exception;
use \PDO;
use Map\PdfTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the '_pdf' table.
 *
 *
 *
 * @method     ChildPdfQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPdfQuery orderByFile($order = Criteria::ASC) Order by the _file column
 * @method     ChildPdfQuery orderByDate($order = Criteria::ASC) Order by the _date column
 * @method     ChildPdfQuery orderByIssue($order = Criteria::ASC) Order by the _issue column
 * @method     ChildPdfQuery orderByPlugin($order = Criteria::ASC) Order by the _plugin column
 * @method     ChildPdfQuery orderByPages($order = Criteria::ASC) Order by the _fileinfo column
 * @method     ChildPdfQuery orderByOtc($order = Criteria::ASC) Order by the _otc column
 * @method     ChildPdfQuery orderByConfigSys($order = Criteria::ASC) Order by the _config column
 * @method     ChildPdfQuery orderByConfigValue($order = Criteria::ASC) Order by the _configvalue column
 * @method     ChildPdfQuery orderBySort($order = Criteria::ASC) Order by the __sort__ column
 *
 * @method     ChildPdfQuery groupById() Group by the id column
 * @method     ChildPdfQuery groupByFile() Group by the _file column
 * @method     ChildPdfQuery groupByDate() Group by the _date column
 * @method     ChildPdfQuery groupByIssue() Group by the _issue column
 * @method     ChildPdfQuery groupByPlugin() Group by the _plugin column
 * @method     ChildPdfQuery groupByPages() Group by the _fileinfo column
 * @method     ChildPdfQuery groupByOtc() Group by the _otc column
 * @method     ChildPdfQuery groupByConfigSys() Group by the _config column
 * @method     ChildPdfQuery groupByConfigValue() Group by the _configvalue column
 * @method     ChildPdfQuery groupBySort() Group by the __sort__ column
 *
 * @method     ChildPdfQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPdfQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPdfQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPdfQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPdfQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPdfQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPdfQuery leftJoinPlugins($relationAlias = null) Adds a LEFT JOIN clause to the query using the Plugins relation
 * @method     ChildPdfQuery rightJoinPlugins($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Plugins relation
 * @method     ChildPdfQuery innerJoinPlugins($relationAlias = null) Adds a INNER JOIN clause to the query using the Plugins relation
 *
 * @method     ChildPdfQuery joinWithPlugins($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Plugins relation
 *
 * @method     ChildPdfQuery leftJoinWithPlugins() Adds a LEFT JOIN clause and with to the query using the Plugins relation
 * @method     ChildPdfQuery rightJoinWithPlugins() Adds a RIGHT JOIN clause and with to the query using the Plugins relation
 * @method     ChildPdfQuery innerJoinWithPlugins() Adds a INNER JOIN clause and with to the query using the Plugins relation
 *
 * @method     \PluginsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPdf findOne(ConnectionInterface $con = null) Return the first ChildPdf matching the query
 * @method     ChildPdf findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPdf matching the query, or a new ChildPdf object populated from the query conditions when no match is found
 *
 * @method     ChildPdf findOneById(int $id) Return the first ChildPdf filtered by the id column
 * @method     ChildPdf findOneByFile(string $_file) Return the first ChildPdf filtered by the _file column
 * @method     ChildPdf findOneByDate(int $_date) Return the first ChildPdf filtered by the _date column
 * @method     ChildPdf findOneByIssue(int $_issue) Return the first ChildPdf filtered by the _issue column
 * @method     ChildPdf findOneByPlugin(int $_plugin) Return the first ChildPdf filtered by the _plugin column
 * @method     ChildPdf findOneByPages(string $_fileinfo) Return the first ChildPdf filtered by the _fileinfo column
 * @method     ChildPdf findOneByOtc(string $_otc) Return the first ChildPdf filtered by the _otc column
 * @method     ChildPdf findOneByConfigSys(string $_config) Return the first ChildPdf filtered by the _config column
 * @method     ChildPdf findOneByConfigValue(int $_configvalue) Return the first ChildPdf filtered by the _configvalue column
 * @method     ChildPdf findOneBySort(int $__sort__) Return the first ChildPdf filtered by the __sort__ column *

 * @method     ChildPdf requirePk($key, ConnectionInterface $con = null) Return the ChildPdf by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPdf requireOne(ConnectionInterface $con = null) Return the first ChildPdf matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPdf requireOneById(int $id) Return the first ChildPdf filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPdf requireOneByFile(string $_file) Return the first ChildPdf filtered by the _file column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPdf requireOneByDate(int $_date) Return the first ChildPdf filtered by the _date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPdf requireOneByIssue(int $_issue) Return the first ChildPdf filtered by the _issue column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPdf requireOneByPlugin(int $_plugin) Return the first ChildPdf filtered by the _plugin column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPdf requireOneByPages(string $_fileinfo) Return the first ChildPdf filtered by the _fileinfo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPdf requireOneByOtc(string $_otc) Return the first ChildPdf filtered by the _otc column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPdf requireOneByConfigSys(string $_config) Return the first ChildPdf filtered by the _config column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPdf requireOneByConfigValue(int $_configvalue) Return the first ChildPdf filtered by the _configvalue column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPdf requireOneBySort(int $__sort__) Return the first ChildPdf filtered by the __sort__ column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPdf[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPdf objects based on current ModelCriteria
 * @method     ChildPdf[]|ObjectCollection findById(int $id) Return ChildPdf objects filtered by the id column
 * @method     ChildPdf[]|ObjectCollection findByFile(string $_file) Return ChildPdf objects filtered by the _file column
 * @method     ChildPdf[]|ObjectCollection findByDate(int $_date) Return ChildPdf objects filtered by the _date column
 * @method     ChildPdf[]|ObjectCollection findByIssue(int $_issue) Return ChildPdf objects filtered by the _issue column
 * @method     ChildPdf[]|ObjectCollection findByPlugin(int $_plugin) Return ChildPdf objects filtered by the _plugin column
 * @method     ChildPdf[]|ObjectCollection findByPages(string $_fileinfo) Return ChildPdf objects filtered by the _fileinfo column
 * @method     ChildPdf[]|ObjectCollection findByOtc(string $_otc) Return ChildPdf objects filtered by the _otc column
 * @method     ChildPdf[]|ObjectCollection findByConfigSys(string $_config) Return ChildPdf objects filtered by the _config column
 * @method     ChildPdf[]|ObjectCollection findByConfigValue(int $_configvalue) Return ChildPdf objects filtered by the _configvalue column
 * @method     ChildPdf[]|ObjectCollection findBySort(int $__sort__) Return ChildPdf objects filtered by the __sort__ column
 * @method     ChildPdf[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PdfQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PdfQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\Pdf', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPdfQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPdfQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPdfQuery) {
            return $criteria;
        }
        $query = new ChildPdfQuery();
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
     * @return ChildPdf|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PdfTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PdfTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPdf A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, _file, _date, _issue, _plugin, _fileinfo, _otc, _config, _configvalue, __sort__ FROM _pdf WHERE id = :p0';
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
            /** @var ChildPdf $obj */
            $obj = new ChildPdf();
            $obj->hydrate($row);
            PdfTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPdf|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPdfQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PdfTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPdfQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PdfTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPdfQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PdfTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PdfTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PdfTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the _file column
     *
     * Example usage:
     * <code>
     * $query->filterByFile('fooValue');   // WHERE _file = 'fooValue'
     * $query->filterByFile('%fooValue%', Criteria::LIKE); // WHERE _file LIKE '%fooValue%'
     * </code>
     *
     * @param     string $file The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPdfQuery The current query, for fluid interface
     */
    public function filterByFile($file = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($file)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PdfTableMap::COL__FILE, $file, $comparison);
    }

    /**
     * Filter the query on the _date column
     *
     * Example usage:
     * <code>
     * $query->filterByDate(1234); // WHERE _date = 1234
     * $query->filterByDate(array(12, 34)); // WHERE _date IN (12, 34)
     * $query->filterByDate(array('min' => 12)); // WHERE _date > 12
     * </code>
     *
     * @param     mixed $date The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPdfQuery The current query, for fluid interface
     */
    public function filterByDate($date = null, $comparison = null)
    {
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingAlias(PdfTableMap::COL__DATE, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingAlias(PdfTableMap::COL__DATE, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PdfTableMap::COL__DATE, $date, $comparison);
    }

    /**
     * Filter the query on the _issue column
     *
     * Example usage:
     * <code>
     * $query->filterByIssue(1234); // WHERE _issue = 1234
     * $query->filterByIssue(array(12, 34)); // WHERE _issue IN (12, 34)
     * $query->filterByIssue(array('min' => 12)); // WHERE _issue > 12
     * </code>
     *
     * @param     mixed $issue The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPdfQuery The current query, for fluid interface
     */
    public function filterByIssue($issue = null, $comparison = null)
    {
        if (is_array($issue)) {
            $useMinMax = false;
            if (isset($issue['min'])) {
                $this->addUsingAlias(PdfTableMap::COL__ISSUE, $issue['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($issue['max'])) {
                $this->addUsingAlias(PdfTableMap::COL__ISSUE, $issue['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PdfTableMap::COL__ISSUE, $issue, $comparison);
    }

    /**
     * Filter the query on the _plugin column
     *
     * Example usage:
     * <code>
     * $query->filterByPlugin(1234); // WHERE _plugin = 1234
     * $query->filterByPlugin(array(12, 34)); // WHERE _plugin IN (12, 34)
     * $query->filterByPlugin(array('min' => 12)); // WHERE _plugin > 12
     * </code>
     *
     * @see       filterByPlugins()
     *
     * @param     mixed $plugin The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPdfQuery The current query, for fluid interface
     */
    public function filterByPlugin($plugin = null, $comparison = null)
    {
        if (is_array($plugin)) {
            $useMinMax = false;
            if (isset($plugin['min'])) {
                $this->addUsingAlias(PdfTableMap::COL__PLUGIN, $plugin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($plugin['max'])) {
                $this->addUsingAlias(PdfTableMap::COL__PLUGIN, $plugin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PdfTableMap::COL__PLUGIN, $plugin, $comparison);
    }

    /**
     * Filter the query on the _fileinfo column
     *
     * Example usage:
     * <code>
     * $query->filterByPages('fooValue');   // WHERE _fileinfo = 'fooValue'
     * $query->filterByPages('%fooValue%', Criteria::LIKE); // WHERE _fileinfo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pages The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPdfQuery The current query, for fluid interface
     */
    public function filterByPages($pages = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pages)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PdfTableMap::COL__FILEINFO, $pages, $comparison);
    }

    /**
     * Filter the query on the _otc column
     *
     * Example usage:
     * <code>
     * $query->filterByOtc('fooValue');   // WHERE _otc = 'fooValue'
     * $query->filterByOtc('%fooValue%', Criteria::LIKE); // WHERE _otc LIKE '%fooValue%'
     * </code>
     *
     * @param     string $otc The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPdfQuery The current query, for fluid interface
     */
    public function filterByOtc($otc = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($otc)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PdfTableMap::COL__OTC, $otc, $comparison);
    }

    /**
     * Filter the query on the _config column
     *
     * Example usage:
     * <code>
     * $query->filterByConfigSys('fooValue');   // WHERE _config = 'fooValue'
     * $query->filterByConfigSys('%fooValue%', Criteria::LIKE); // WHERE _config LIKE '%fooValue%'
     * </code>
     *
     * @param     string $configSys The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPdfQuery The current query, for fluid interface
     */
    public function filterByConfigSys($configSys = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($configSys)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PdfTableMap::COL__CONFIG, $configSys, $comparison);
    }

    /**
     * Filter the query on the _configvalue column
     *
     * Example usage:
     * <code>
     * $query->filterByConfigValue(1234); // WHERE _configvalue = 1234
     * $query->filterByConfigValue(array(12, 34)); // WHERE _configvalue IN (12, 34)
     * $query->filterByConfigValue(array('min' => 12)); // WHERE _configvalue > 12
     * </code>
     *
     * @param     mixed $configValue The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPdfQuery The current query, for fluid interface
     */
    public function filterByConfigValue($configValue = null, $comparison = null)
    {
        if (is_array($configValue)) {
            $useMinMax = false;
            if (isset($configValue['min'])) {
                $this->addUsingAlias(PdfTableMap::COL__CONFIGVALUE, $configValue['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($configValue['max'])) {
                $this->addUsingAlias(PdfTableMap::COL__CONFIGVALUE, $configValue['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PdfTableMap::COL__CONFIGVALUE, $configValue, $comparison);
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
     * @return $this|ChildPdfQuery The current query, for fluid interface
     */
    public function filterBySort($sort = null, $comparison = null)
    {
        if (is_array($sort)) {
            $useMinMax = false;
            if (isset($sort['min'])) {
                $this->addUsingAlias(PdfTableMap::COL___SORT__, $sort['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sort['max'])) {
                $this->addUsingAlias(PdfTableMap::COL___SORT__, $sort['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PdfTableMap::COL___SORT__, $sort, $comparison);
    }

    /**
     * Filter the query by a related \Plugins object
     *
     * @param \Plugins|ObjectCollection $plugins The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPdfQuery The current query, for fluid interface
     */
    public function filterByPlugins($plugins, $comparison = null)
    {
        if ($plugins instanceof \Plugins) {
            return $this
                ->addUsingAlias(PdfTableMap::COL__PLUGIN, $plugins->getId(), $comparison);
        } elseif ($plugins instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PdfTableMap::COL__PLUGIN, $plugins->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPlugins() only accepts arguments of type \Plugins or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Plugins relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPdfQuery The current query, for fluid interface
     */
    public function joinPlugins($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Plugins');

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
            $this->addJoinObject($join, 'Plugins');
        }

        return $this;
    }

    /**
     * Use the Plugins relation Plugins object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PluginsQuery A secondary query class using the current class as primary query
     */
    public function usePluginsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPlugins($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Plugins', '\PluginsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPdf $pdf Object to remove from the list of results
     *
     * @return $this|ChildPdfQuery The current query, for fluid interface
     */
    public function prune($pdf = null)
    {
        if ($pdf) {
            $this->addUsingAlias(PdfTableMap::COL_ID, $pdf->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the _pdf table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PdfTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PdfTableMap::clearInstancePool();
            PdfTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PdfTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PdfTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PdfTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PdfTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PdfQuery
