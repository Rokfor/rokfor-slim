<?php

namespace Base;

use \RDataTemplate as ChildRDataTemplate;
use \RDataTemplateQuery as ChildRDataTemplateQuery;
use \Exception;
use \PDO;
use Map\RDataTemplateTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'R_data_template' table.
 *
 *
 *
 * @method     ChildRDataTemplateQuery orderByDataid($order = Criteria::ASC) Order by the _dataid column
 * @method     ChildRDataTemplateQuery orderByTemplateid($order = Criteria::ASC) Order by the _templateid column
 *
 * @method     ChildRDataTemplateQuery groupByDataid() Group by the _dataid column
 * @method     ChildRDataTemplateQuery groupByTemplateid() Group by the _templateid column
 *
 * @method     ChildRDataTemplateQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRDataTemplateQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRDataTemplateQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRDataTemplateQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildRDataTemplateQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildRDataTemplateQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildRDataTemplateQuery leftJoinRData($relationAlias = null) Adds a LEFT JOIN clause to the query using the RData relation
 * @method     ChildRDataTemplateQuery rightJoinRData($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RData relation
 * @method     ChildRDataTemplateQuery innerJoinRData($relationAlias = null) Adds a INNER JOIN clause to the query using the RData relation
 *
 * @method     ChildRDataTemplateQuery joinWithRData($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RData relation
 *
 * @method     ChildRDataTemplateQuery leftJoinWithRData() Adds a LEFT JOIN clause and with to the query using the RData relation
 * @method     ChildRDataTemplateQuery rightJoinWithRData() Adds a RIGHT JOIN clause and with to the query using the RData relation
 * @method     ChildRDataTemplateQuery innerJoinWithRData() Adds a INNER JOIN clause and with to the query using the RData relation
 *
 * @method     ChildRDataTemplateQuery leftJoinRTemplate($relationAlias = null) Adds a LEFT JOIN clause to the query using the RTemplate relation
 * @method     ChildRDataTemplateQuery rightJoinRTemplate($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RTemplate relation
 * @method     ChildRDataTemplateQuery innerJoinRTemplate($relationAlias = null) Adds a INNER JOIN clause to the query using the RTemplate relation
 *
 * @method     ChildRDataTemplateQuery joinWithRTemplate($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RTemplate relation
 *
 * @method     ChildRDataTemplateQuery leftJoinWithRTemplate() Adds a LEFT JOIN clause and with to the query using the RTemplate relation
 * @method     ChildRDataTemplateQuery rightJoinWithRTemplate() Adds a RIGHT JOIN clause and with to the query using the RTemplate relation
 * @method     ChildRDataTemplateQuery innerJoinWithRTemplate() Adds a INNER JOIN clause and with to the query using the RTemplate relation
 *
 * @method     \DataQuery|\TemplatesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRDataTemplate findOne(ConnectionInterface $con = null) Return the first ChildRDataTemplate matching the query
 * @method     ChildRDataTemplate findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRDataTemplate matching the query, or a new ChildRDataTemplate object populated from the query conditions when no match is found
 *
 * @method     ChildRDataTemplate findOneByDataid(int $_dataid) Return the first ChildRDataTemplate filtered by the _dataid column
 * @method     ChildRDataTemplate findOneByTemplateid(int $_templateid) Return the first ChildRDataTemplate filtered by the _templateid column *

 * @method     ChildRDataTemplate requirePk($key, ConnectionInterface $con = null) Return the ChildRDataTemplate by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRDataTemplate requireOne(ConnectionInterface $con = null) Return the first ChildRDataTemplate matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRDataTemplate requireOneByDataid(int $_dataid) Return the first ChildRDataTemplate filtered by the _dataid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRDataTemplate requireOneByTemplateid(int $_templateid) Return the first ChildRDataTemplate filtered by the _templateid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRDataTemplate[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRDataTemplate objects based on current ModelCriteria
 * @method     ChildRDataTemplate[]|ObjectCollection findByDataid(int $_dataid) Return ChildRDataTemplate objects filtered by the _dataid column
 * @method     ChildRDataTemplate[]|ObjectCollection findByTemplateid(int $_templateid) Return ChildRDataTemplate objects filtered by the _templateid column
 * @method     ChildRDataTemplate[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RDataTemplateQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\RDataTemplateQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\RDataTemplate', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRDataTemplateQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRDataTemplateQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRDataTemplateQuery) {
            return $criteria;
        }
        $query = new ChildRDataTemplateQuery();
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
     * @param array[$_dataid, $_templateid] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildRDataTemplate|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RDataTemplateTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = RDataTemplateTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildRDataTemplate A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT _dataid, _templateid FROM R_data_template WHERE _dataid = :p0 AND _templateid = :p1';
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
            /** @var ChildRDataTemplate $obj */
            $obj = new ChildRDataTemplate();
            $obj->hydrate($row);
            RDataTemplateTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildRDataTemplate|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRDataTemplateQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(RDataTemplateTableMap::COL__DATAID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(RDataTemplateTableMap::COL__TEMPLATEID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRDataTemplateQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(RDataTemplateTableMap::COL__DATAID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(RDataTemplateTableMap::COL__TEMPLATEID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the _dataid column
     *
     * Example usage:
     * <code>
     * $query->filterByDataid(1234); // WHERE _dataid = 1234
     * $query->filterByDataid(array(12, 34)); // WHERE _dataid IN (12, 34)
     * $query->filterByDataid(array('min' => 12)); // WHERE _dataid > 12
     * </code>
     *
     * @see       filterByRData()
     *
     * @param     mixed $dataid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRDataTemplateQuery The current query, for fluid interface
     */
    public function filterByDataid($dataid = null, $comparison = null)
    {
        if (is_array($dataid)) {
            $useMinMax = false;
            if (isset($dataid['min'])) {
                $this->addUsingAlias(RDataTemplateTableMap::COL__DATAID, $dataid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dataid['max'])) {
                $this->addUsingAlias(RDataTemplateTableMap::COL__DATAID, $dataid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RDataTemplateTableMap::COL__DATAID, $dataid, $comparison);
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
     * @see       filterByRTemplate()
     *
     * @param     mixed $templateid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRDataTemplateQuery The current query, for fluid interface
     */
    public function filterByTemplateid($templateid = null, $comparison = null)
    {
        if (is_array($templateid)) {
            $useMinMax = false;
            if (isset($templateid['min'])) {
                $this->addUsingAlias(RDataTemplateTableMap::COL__TEMPLATEID, $templateid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($templateid['max'])) {
                $this->addUsingAlias(RDataTemplateTableMap::COL__TEMPLATEID, $templateid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RDataTemplateTableMap::COL__TEMPLATEID, $templateid, $comparison);
    }

    /**
     * Filter the query by a related \Data object
     *
     * @param \Data|ObjectCollection $data The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRDataTemplateQuery The current query, for fluid interface
     */
    public function filterByRData($data, $comparison = null)
    {
        if ($data instanceof \Data) {
            return $this
                ->addUsingAlias(RDataTemplateTableMap::COL__DATAID, $data->getId(), $comparison);
        } elseif ($data instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RDataTemplateTableMap::COL__DATAID, $data->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRData() only accepts arguments of type \Data or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RData relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRDataTemplateQuery The current query, for fluid interface
     */
    public function joinRData($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RData');

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
            $this->addJoinObject($join, 'RData');
        }

        return $this;
    }

    /**
     * Use the RData relation Data object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \DataQuery A secondary query class using the current class as primary query
     */
    public function useRDataQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRData($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RData', '\DataQuery');
    }

    /**
     * Filter the query by a related \Templates object
     *
     * @param \Templates|ObjectCollection $templates The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRDataTemplateQuery The current query, for fluid interface
     */
    public function filterByRTemplate($templates, $comparison = null)
    {
        if ($templates instanceof \Templates) {
            return $this
                ->addUsingAlias(RDataTemplateTableMap::COL__TEMPLATEID, $templates->getId(), $comparison);
        } elseif ($templates instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RDataTemplateTableMap::COL__TEMPLATEID, $templates->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRTemplate() only accepts arguments of type \Templates or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RTemplate relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRDataTemplateQuery The current query, for fluid interface
     */
    public function joinRTemplate($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RTemplate');

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
            $this->addJoinObject($join, 'RTemplate');
        }

        return $this;
    }

    /**
     * Use the RTemplate relation Templates object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TemplatesQuery A secondary query class using the current class as primary query
     */
    public function useRTemplateQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRTemplate($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RTemplate', '\TemplatesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRDataTemplate $rDataTemplate Object to remove from the list of results
     *
     * @return $this|ChildRDataTemplateQuery The current query, for fluid interface
     */
    public function prune($rDataTemplate = null)
    {
        if ($rDataTemplate) {
            $this->addCond('pruneCond0', $this->getAliasedColName(RDataTemplateTableMap::COL__DATAID), $rDataTemplate->getDataid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(RDataTemplateTableMap::COL__TEMPLATEID), $rDataTemplate->getTemplateid(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the R_data_template table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RDataTemplateTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RDataTemplateTableMap::clearInstancePool();
            RDataTemplateTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RDataTemplateTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RDataTemplateTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RDataTemplateTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RDataTemplateTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RDataTemplateQuery
