<?php

namespace Base;

use \RTemplatenamesInchapter as ChildRTemplatenamesInchapter;
use \RTemplatenamesInchapterQuery as ChildRTemplatenamesInchapterQuery;
use \Exception;
use \PDO;
use Map\RTemplatenamesInchapterTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'R_templatenames_inchapter' table.
 *
 *
 *
 * @method     ChildRTemplatenamesInchapterQuery orderByTemplateid($order = Criteria::ASC) Order by the _templateid column
 * @method     ChildRTemplatenamesInchapterQuery orderByChapterid($order = Criteria::ASC) Order by the _chapterid column
 *
 * @method     ChildRTemplatenamesInchapterQuery groupByTemplateid() Group by the _templateid column
 * @method     ChildRTemplatenamesInchapterQuery groupByChapterid() Group by the _chapterid column
 *
 * @method     ChildRTemplatenamesInchapterQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRTemplatenamesInchapterQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRTemplatenamesInchapterQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRTemplatenamesInchapterQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildRTemplatenamesInchapterQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildRTemplatenamesInchapterQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildRTemplatenamesInchapterQuery leftJoinTemplatenames($relationAlias = null) Adds a LEFT JOIN clause to the query using the Templatenames relation
 * @method     ChildRTemplatenamesInchapterQuery rightJoinTemplatenames($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Templatenames relation
 * @method     ChildRTemplatenamesInchapterQuery innerJoinTemplatenames($relationAlias = null) Adds a INNER JOIN clause to the query using the Templatenames relation
 *
 * @method     ChildRTemplatenamesInchapterQuery joinWithTemplatenames($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Templatenames relation
 *
 * @method     ChildRTemplatenamesInchapterQuery leftJoinWithTemplatenames() Adds a LEFT JOIN clause and with to the query using the Templatenames relation
 * @method     ChildRTemplatenamesInchapterQuery rightJoinWithTemplatenames() Adds a RIGHT JOIN clause and with to the query using the Templatenames relation
 * @method     ChildRTemplatenamesInchapterQuery innerJoinWithTemplatenames() Adds a INNER JOIN clause and with to the query using the Templatenames relation
 *
 * @method     ChildRTemplatenamesInchapterQuery leftJoinFormats($relationAlias = null) Adds a LEFT JOIN clause to the query using the Formats relation
 * @method     ChildRTemplatenamesInchapterQuery rightJoinFormats($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Formats relation
 * @method     ChildRTemplatenamesInchapterQuery innerJoinFormats($relationAlias = null) Adds a INNER JOIN clause to the query using the Formats relation
 *
 * @method     ChildRTemplatenamesInchapterQuery joinWithFormats($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Formats relation
 *
 * @method     ChildRTemplatenamesInchapterQuery leftJoinWithFormats() Adds a LEFT JOIN clause and with to the query using the Formats relation
 * @method     ChildRTemplatenamesInchapterQuery rightJoinWithFormats() Adds a RIGHT JOIN clause and with to the query using the Formats relation
 * @method     ChildRTemplatenamesInchapterQuery innerJoinWithFormats() Adds a INNER JOIN clause and with to the query using the Formats relation
 *
 * @method     \TemplatenamesQuery|\FormatsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRTemplatenamesInchapter findOne(ConnectionInterface $con = null) Return the first ChildRTemplatenamesInchapter matching the query
 * @method     ChildRTemplatenamesInchapter findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRTemplatenamesInchapter matching the query, or a new ChildRTemplatenamesInchapter object populated from the query conditions when no match is found
 *
 * @method     ChildRTemplatenamesInchapter findOneByTemplateid(int $_templateid) Return the first ChildRTemplatenamesInchapter filtered by the _templateid column
 * @method     ChildRTemplatenamesInchapter findOneByChapterid(int $_chapterid) Return the first ChildRTemplatenamesInchapter filtered by the _chapterid column *

 * @method     ChildRTemplatenamesInchapter requirePk($key, ConnectionInterface $con = null) Return the ChildRTemplatenamesInchapter by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRTemplatenamesInchapter requireOne(ConnectionInterface $con = null) Return the first ChildRTemplatenamesInchapter matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRTemplatenamesInchapter requireOneByTemplateid(int $_templateid) Return the first ChildRTemplatenamesInchapter filtered by the _templateid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRTemplatenamesInchapter requireOneByChapterid(int $_chapterid) Return the first ChildRTemplatenamesInchapter filtered by the _chapterid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRTemplatenamesInchapter[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRTemplatenamesInchapter objects based on current ModelCriteria
 * @method     ChildRTemplatenamesInchapter[]|ObjectCollection findByTemplateid(int $_templateid) Return ChildRTemplatenamesInchapter objects filtered by the _templateid column
 * @method     ChildRTemplatenamesInchapter[]|ObjectCollection findByChapterid(int $_chapterid) Return ChildRTemplatenamesInchapter objects filtered by the _chapterid column
 * @method     ChildRTemplatenamesInchapter[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RTemplatenamesInchapterQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\RTemplatenamesInchapterQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\RTemplatenamesInchapter', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRTemplatenamesInchapterQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRTemplatenamesInchapterQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRTemplatenamesInchapterQuery) {
            return $criteria;
        }
        $query = new ChildRTemplatenamesInchapterQuery();
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
     * @param array[$_templateid, $_chapterid] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildRTemplatenamesInchapter|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RTemplatenamesInchapterTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = RTemplatenamesInchapterTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildRTemplatenamesInchapter A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT _templateid, _chapterid FROM R_templatenames_inchapter WHERE _templateid = :p0 AND _chapterid = :p1';
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
            /** @var ChildRTemplatenamesInchapter $obj */
            $obj = new ChildRTemplatenamesInchapter();
            $obj->hydrate($row);
            RTemplatenamesInchapterTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildRTemplatenamesInchapter|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRTemplatenamesInchapterQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(RTemplatenamesInchapterTableMap::COL__TEMPLATEID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(RTemplatenamesInchapterTableMap::COL__CHAPTERID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRTemplatenamesInchapterQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(RTemplatenamesInchapterTableMap::COL__TEMPLATEID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(RTemplatenamesInchapterTableMap::COL__CHAPTERID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the _templateid column
     *
     * Example usage:
     * <code>
     * $query->filterByTemplateid(1234); // WHERE _templateid = 1234
     * $query->filterByTemplateid(array(12, 34)); // WHERE _templateid IN (12, 34)
     * $query->filterByTemplateid(array('min' => 12)); // WHERE _templateid > 12
     * </code>
     *
     * @see       filterByTemplatenames()
     *
     * @param     mixed $templateid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRTemplatenamesInchapterQuery The current query, for fluid interface
     */
    public function filterByTemplateid($templateid = null, $comparison = null)
    {
        if (is_array($templateid)) {
            $useMinMax = false;
            if (isset($templateid['min'])) {
                $this->addUsingAlias(RTemplatenamesInchapterTableMap::COL__TEMPLATEID, $templateid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($templateid['max'])) {
                $this->addUsingAlias(RTemplatenamesInchapterTableMap::COL__TEMPLATEID, $templateid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RTemplatenamesInchapterTableMap::COL__TEMPLATEID, $templateid, $comparison);
    }

    /**
     * Filter the query on the _chapterid column
     *
     * Example usage:
     * <code>
     * $query->filterByChapterid(1234); // WHERE _chapterid = 1234
     * $query->filterByChapterid(array(12, 34)); // WHERE _chapterid IN (12, 34)
     * $query->filterByChapterid(array('min' => 12)); // WHERE _chapterid > 12
     * </code>
     *
     * @see       filterByFormats()
     *
     * @param     mixed $chapterid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRTemplatenamesInchapterQuery The current query, for fluid interface
     */
    public function filterByChapterid($chapterid = null, $comparison = null)
    {
        if (is_array($chapterid)) {
            $useMinMax = false;
            if (isset($chapterid['min'])) {
                $this->addUsingAlias(RTemplatenamesInchapterTableMap::COL__CHAPTERID, $chapterid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($chapterid['max'])) {
                $this->addUsingAlias(RTemplatenamesInchapterTableMap::COL__CHAPTERID, $chapterid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RTemplatenamesInchapterTableMap::COL__CHAPTERID, $chapterid, $comparison);
    }

    /**
     * Filter the query by a related \Templatenames object
     *
     * @param \Templatenames|ObjectCollection $templatenames The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRTemplatenamesInchapterQuery The current query, for fluid interface
     */
    public function filterByTemplatenames($templatenames, $comparison = null)
    {
        if ($templatenames instanceof \Templatenames) {
            return $this
                ->addUsingAlias(RTemplatenamesInchapterTableMap::COL__TEMPLATEID, $templatenames->getId(), $comparison);
        } elseif ($templatenames instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RTemplatenamesInchapterTableMap::COL__TEMPLATEID, $templatenames->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildRTemplatenamesInchapterQuery The current query, for fluid interface
     */
    public function joinTemplatenames($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useTemplatenamesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTemplatenames($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Templatenames', '\TemplatenamesQuery');
    }

    /**
     * Filter the query by a related \Formats object
     *
     * @param \Formats|ObjectCollection $formats The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRTemplatenamesInchapterQuery The current query, for fluid interface
     */
    public function filterByFormats($formats, $comparison = null)
    {
        if ($formats instanceof \Formats) {
            return $this
                ->addUsingAlias(RTemplatenamesInchapterTableMap::COL__CHAPTERID, $formats->getId(), $comparison);
        } elseif ($formats instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RTemplatenamesInchapterTableMap::COL__CHAPTERID, $formats->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByFormats() only accepts arguments of type \Formats or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Formats relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRTemplatenamesInchapterQuery The current query, for fluid interface
     */
    public function joinFormats($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Formats');

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
            $this->addJoinObject($join, 'Formats');
        }

        return $this;
    }

    /**
     * Use the Formats relation Formats object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \FormatsQuery A secondary query class using the current class as primary query
     */
    public function useFormatsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFormats($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Formats', '\FormatsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRTemplatenamesInchapter $rTemplatenamesInchapter Object to remove from the list of results
     *
     * @return $this|ChildRTemplatenamesInchapterQuery The current query, for fluid interface
     */
    public function prune($rTemplatenamesInchapter = null)
    {
        if ($rTemplatenamesInchapter) {
            $this->addCond('pruneCond0', $this->getAliasedColName(RTemplatenamesInchapterTableMap::COL__TEMPLATEID), $rTemplatenamesInchapter->getTemplateid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(RTemplatenamesInchapterTableMap::COL__CHAPTERID), $rTemplatenamesInchapter->getChapterid(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the R_templatenames_inchapter table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RTemplatenamesInchapterTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RTemplatenamesInchapterTableMap::clearInstancePool();
            RTemplatenamesInchapterTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RTemplatenamesInchapterTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RTemplatenamesInchapterTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RTemplatenamesInchapterTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RTemplatenamesInchapterTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RTemplatenamesInchapterQuery
