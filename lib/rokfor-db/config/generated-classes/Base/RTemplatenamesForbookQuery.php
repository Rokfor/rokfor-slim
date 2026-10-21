<?php

namespace Base;

use \RTemplatenamesForbook as ChildRTemplatenamesForbook;
use \RTemplatenamesForbookQuery as ChildRTemplatenamesForbookQuery;
use \Exception;
use \PDO;
use Map\RTemplatenamesForbookTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'R_templatenames_forbook' table.
 *
 *
 *
 * @method     ChildRTemplatenamesForbookQuery orderByTemplateid($order = Criteria::ASC) Order by the _templateid column
 * @method     ChildRTemplatenamesForbookQuery orderByBookid($order = Criteria::ASC) Order by the _bookid column
 *
 * @method     ChildRTemplatenamesForbookQuery groupByTemplateid() Group by the _templateid column
 * @method     ChildRTemplatenamesForbookQuery groupByBookid() Group by the _bookid column
 *
 * @method     ChildRTemplatenamesForbookQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRTemplatenamesForbookQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRTemplatenamesForbookQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRTemplatenamesForbookQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildRTemplatenamesForbookQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildRTemplatenamesForbookQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildRTemplatenamesForbookQuery leftJoinTemplatenames($relationAlias = null) Adds a LEFT JOIN clause to the query using the Templatenames relation
 * @method     ChildRTemplatenamesForbookQuery rightJoinTemplatenames($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Templatenames relation
 * @method     ChildRTemplatenamesForbookQuery innerJoinTemplatenames($relationAlias = null) Adds a INNER JOIN clause to the query using the Templatenames relation
 *
 * @method     ChildRTemplatenamesForbookQuery joinWithTemplatenames($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Templatenames relation
 *
 * @method     ChildRTemplatenamesForbookQuery leftJoinWithTemplatenames() Adds a LEFT JOIN clause and with to the query using the Templatenames relation
 * @method     ChildRTemplatenamesForbookQuery rightJoinWithTemplatenames() Adds a RIGHT JOIN clause and with to the query using the Templatenames relation
 * @method     ChildRTemplatenamesForbookQuery innerJoinWithTemplatenames() Adds a INNER JOIN clause and with to the query using the Templatenames relation
 *
 * @method     ChildRTemplatenamesForbookQuery leftJoinBooks($relationAlias = null) Adds a LEFT JOIN clause to the query using the Books relation
 * @method     ChildRTemplatenamesForbookQuery rightJoinBooks($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Books relation
 * @method     ChildRTemplatenamesForbookQuery innerJoinBooks($relationAlias = null) Adds a INNER JOIN clause to the query using the Books relation
 *
 * @method     ChildRTemplatenamesForbookQuery joinWithBooks($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Books relation
 *
 * @method     ChildRTemplatenamesForbookQuery leftJoinWithBooks() Adds a LEFT JOIN clause and with to the query using the Books relation
 * @method     ChildRTemplatenamesForbookQuery rightJoinWithBooks() Adds a RIGHT JOIN clause and with to the query using the Books relation
 * @method     ChildRTemplatenamesForbookQuery innerJoinWithBooks() Adds a INNER JOIN clause and with to the query using the Books relation
 *
 * @method     \TemplatenamesQuery|\BooksQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRTemplatenamesForbook findOne(ConnectionInterface $con = null) Return the first ChildRTemplatenamesForbook matching the query
 * @method     ChildRTemplatenamesForbook findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRTemplatenamesForbook matching the query, or a new ChildRTemplatenamesForbook object populated from the query conditions when no match is found
 *
 * @method     ChildRTemplatenamesForbook findOneByTemplateid(int $_templateid) Return the first ChildRTemplatenamesForbook filtered by the _templateid column
 * @method     ChildRTemplatenamesForbook findOneByBookid(int $_bookid) Return the first ChildRTemplatenamesForbook filtered by the _bookid column *

 * @method     ChildRTemplatenamesForbook requirePk($key, ConnectionInterface $con = null) Return the ChildRTemplatenamesForbook by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRTemplatenamesForbook requireOne(ConnectionInterface $con = null) Return the first ChildRTemplatenamesForbook matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRTemplatenamesForbook requireOneByTemplateid(int $_templateid) Return the first ChildRTemplatenamesForbook filtered by the _templateid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRTemplatenamesForbook requireOneByBookid(int $_bookid) Return the first ChildRTemplatenamesForbook filtered by the _bookid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRTemplatenamesForbook[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRTemplatenamesForbook objects based on current ModelCriteria
 * @method     ChildRTemplatenamesForbook[]|ObjectCollection findByTemplateid(int $_templateid) Return ChildRTemplatenamesForbook objects filtered by the _templateid column
 * @method     ChildRTemplatenamesForbook[]|ObjectCollection findByBookid(int $_bookid) Return ChildRTemplatenamesForbook objects filtered by the _bookid column
 * @method     ChildRTemplatenamesForbook[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RTemplatenamesForbookQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\RTemplatenamesForbookQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\RTemplatenamesForbook', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRTemplatenamesForbookQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRTemplatenamesForbookQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRTemplatenamesForbookQuery) {
            return $criteria;
        }
        $query = new ChildRTemplatenamesForbookQuery();
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
     * @param array[$_templateid, $_bookid] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildRTemplatenamesForbook|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RTemplatenamesForbookTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = RTemplatenamesForbookTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildRTemplatenamesForbook A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT _templateid, _bookid FROM R_templatenames_forbook WHERE _templateid = :p0 AND _bookid = :p1';
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
            /** @var ChildRTemplatenamesForbook $obj */
            $obj = new ChildRTemplatenamesForbook();
            $obj->hydrate($row);
            RTemplatenamesForbookTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildRTemplatenamesForbook|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRTemplatenamesForbookQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(RTemplatenamesForbookTableMap::COL__TEMPLATEID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(RTemplatenamesForbookTableMap::COL__BOOKID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRTemplatenamesForbookQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(RTemplatenamesForbookTableMap::COL__TEMPLATEID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(RTemplatenamesForbookTableMap::COL__BOOKID, $key[1], Criteria::EQUAL);
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
     * @return $this|ChildRTemplatenamesForbookQuery The current query, for fluid interface
     */
    public function filterByTemplateid($templateid = null, $comparison = null)
    {
        if (is_array($templateid)) {
            $useMinMax = false;
            if (isset($templateid['min'])) {
                $this->addUsingAlias(RTemplatenamesForbookTableMap::COL__TEMPLATEID, $templateid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($templateid['max'])) {
                $this->addUsingAlias(RTemplatenamesForbookTableMap::COL__TEMPLATEID, $templateid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RTemplatenamesForbookTableMap::COL__TEMPLATEID, $templateid, $comparison);
    }

    /**
     * Filter the query on the _bookid column
     *
     * Example usage:
     * <code>
     * $query->filterByBookid(1234); // WHERE _bookid = 1234
     * $query->filterByBookid(array(12, 34)); // WHERE _bookid IN (12, 34)
     * $query->filterByBookid(array('min' => 12)); // WHERE _bookid > 12
     * </code>
     *
     * @see       filterByBooks()
     *
     * @param     mixed $bookid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRTemplatenamesForbookQuery The current query, for fluid interface
     */
    public function filterByBookid($bookid = null, $comparison = null)
    {
        if (is_array($bookid)) {
            $useMinMax = false;
            if (isset($bookid['min'])) {
                $this->addUsingAlias(RTemplatenamesForbookTableMap::COL__BOOKID, $bookid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bookid['max'])) {
                $this->addUsingAlias(RTemplatenamesForbookTableMap::COL__BOOKID, $bookid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RTemplatenamesForbookTableMap::COL__BOOKID, $bookid, $comparison);
    }

    /**
     * Filter the query by a related \Templatenames object
     *
     * @param \Templatenames|ObjectCollection $templatenames The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRTemplatenamesForbookQuery The current query, for fluid interface
     */
    public function filterByTemplatenames($templatenames, $comparison = null)
    {
        if ($templatenames instanceof \Templatenames) {
            return $this
                ->addUsingAlias(RTemplatenamesForbookTableMap::COL__TEMPLATEID, $templatenames->getId(), $comparison);
        } elseif ($templatenames instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RTemplatenamesForbookTableMap::COL__TEMPLATEID, $templatenames->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildRTemplatenamesForbookQuery The current query, for fluid interface
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
     * Filter the query by a related \Books object
     *
     * @param \Books|ObjectCollection $books The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRTemplatenamesForbookQuery The current query, for fluid interface
     */
    public function filterByBooks($books, $comparison = null)
    {
        if ($books instanceof \Books) {
            return $this
                ->addUsingAlias(RTemplatenamesForbookTableMap::COL__BOOKID, $books->getId(), $comparison);
        } elseif ($books instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RTemplatenamesForbookTableMap::COL__BOOKID, $books->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByBooks() only accepts arguments of type \Books or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Books relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRTemplatenamesForbookQuery The current query, for fluid interface
     */
    public function joinBooks($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Books');

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
            $this->addJoinObject($join, 'Books');
        }

        return $this;
    }

    /**
     * Use the Books relation Books object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \BooksQuery A secondary query class using the current class as primary query
     */
    public function useBooksQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBooks($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Books', '\BooksQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRTemplatenamesForbook $rTemplatenamesForbook Object to remove from the list of results
     *
     * @return $this|ChildRTemplatenamesForbookQuery The current query, for fluid interface
     */
    public function prune($rTemplatenamesForbook = null)
    {
        if ($rTemplatenamesForbook) {
            $this->addCond('pruneCond0', $this->getAliasedColName(RTemplatenamesForbookTableMap::COL__TEMPLATEID), $rTemplatenamesForbook->getTemplateid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(RTemplatenamesForbookTableMap::COL__BOOKID), $rTemplatenamesForbook->getBookid(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the R_templatenames_forbook table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RTemplatenamesForbookTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RTemplatenamesForbookTableMap::clearInstancePool();
            RTemplatenamesForbookTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RTemplatenamesForbookTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RTemplatenamesForbookTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RTemplatenamesForbookTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RTemplatenamesForbookTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RTemplatenamesForbookQuery
