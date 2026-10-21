<?php

namespace Base;

use \RFieldpostprocessorForfield as ChildRFieldpostprocessorForfield;
use \RFieldpostprocessorForfieldQuery as ChildRFieldpostprocessorForfieldQuery;
use \Exception;
use \PDO;
use Map\RFieldpostprocessorForfieldTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'R_fieldpostprocessor_forfield' table.
 *
 *
 *
 * @method     ChildRFieldpostprocessorForfieldQuery orderByPostprocessorid($order = Criteria::ASC) Order by the _postprocessorid column
 * @method     ChildRFieldpostprocessorForfieldQuery orderByTemplateid($order = Criteria::ASC) Order by the _templateid column
 *
 * @method     ChildRFieldpostprocessorForfieldQuery groupByPostprocessorid() Group by the _postprocessorid column
 * @method     ChildRFieldpostprocessorForfieldQuery groupByTemplateid() Group by the _templateid column
 *
 * @method     ChildRFieldpostprocessorForfieldQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRFieldpostprocessorForfieldQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRFieldpostprocessorForfieldQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRFieldpostprocessorForfieldQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildRFieldpostprocessorForfieldQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildRFieldpostprocessorForfieldQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildRFieldpostprocessorForfieldQuery leftJoinFieldpostprocessor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Fieldpostprocessor relation
 * @method     ChildRFieldpostprocessorForfieldQuery rightJoinFieldpostprocessor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Fieldpostprocessor relation
 * @method     ChildRFieldpostprocessorForfieldQuery innerJoinFieldpostprocessor($relationAlias = null) Adds a INNER JOIN clause to the query using the Fieldpostprocessor relation
 *
 * @method     ChildRFieldpostprocessorForfieldQuery joinWithFieldpostprocessor($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Fieldpostprocessor relation
 *
 * @method     ChildRFieldpostprocessorForfieldQuery leftJoinWithFieldpostprocessor() Adds a LEFT JOIN clause and with to the query using the Fieldpostprocessor relation
 * @method     ChildRFieldpostprocessorForfieldQuery rightJoinWithFieldpostprocessor() Adds a RIGHT JOIN clause and with to the query using the Fieldpostprocessor relation
 * @method     ChildRFieldpostprocessorForfieldQuery innerJoinWithFieldpostprocessor() Adds a INNER JOIN clause and with to the query using the Fieldpostprocessor relation
 *
 * @method     ChildRFieldpostprocessorForfieldQuery leftJoinTemplates($relationAlias = null) Adds a LEFT JOIN clause to the query using the Templates relation
 * @method     ChildRFieldpostprocessorForfieldQuery rightJoinTemplates($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Templates relation
 * @method     ChildRFieldpostprocessorForfieldQuery innerJoinTemplates($relationAlias = null) Adds a INNER JOIN clause to the query using the Templates relation
 *
 * @method     ChildRFieldpostprocessorForfieldQuery joinWithTemplates($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Templates relation
 *
 * @method     ChildRFieldpostprocessorForfieldQuery leftJoinWithTemplates() Adds a LEFT JOIN clause and with to the query using the Templates relation
 * @method     ChildRFieldpostprocessorForfieldQuery rightJoinWithTemplates() Adds a RIGHT JOIN clause and with to the query using the Templates relation
 * @method     ChildRFieldpostprocessorForfieldQuery innerJoinWithTemplates() Adds a INNER JOIN clause and with to the query using the Templates relation
 *
 * @method     \FieldpostprocessorQuery|\TemplatesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRFieldpostprocessorForfield findOne(ConnectionInterface $con = null) Return the first ChildRFieldpostprocessorForfield matching the query
 * @method     ChildRFieldpostprocessorForfield findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRFieldpostprocessorForfield matching the query, or a new ChildRFieldpostprocessorForfield object populated from the query conditions when no match is found
 *
 * @method     ChildRFieldpostprocessorForfield findOneByPostprocessorid(int $_postprocessorid) Return the first ChildRFieldpostprocessorForfield filtered by the _postprocessorid column
 * @method     ChildRFieldpostprocessorForfield findOneByTemplateid(int $_templateid) Return the first ChildRFieldpostprocessorForfield filtered by the _templateid column *

 * @method     ChildRFieldpostprocessorForfield requirePk($key, ConnectionInterface $con = null) Return the ChildRFieldpostprocessorForfield by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRFieldpostprocessorForfield requireOne(ConnectionInterface $con = null) Return the first ChildRFieldpostprocessorForfield matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRFieldpostprocessorForfield requireOneByPostprocessorid(int $_postprocessorid) Return the first ChildRFieldpostprocessorForfield filtered by the _postprocessorid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRFieldpostprocessorForfield requireOneByTemplateid(int $_templateid) Return the first ChildRFieldpostprocessorForfield filtered by the _templateid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRFieldpostprocessorForfield[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRFieldpostprocessorForfield objects based on current ModelCriteria
 * @method     ChildRFieldpostprocessorForfield[]|ObjectCollection findByPostprocessorid(int $_postprocessorid) Return ChildRFieldpostprocessorForfield objects filtered by the _postprocessorid column
 * @method     ChildRFieldpostprocessorForfield[]|ObjectCollection findByTemplateid(int $_templateid) Return ChildRFieldpostprocessorForfield objects filtered by the _templateid column
 * @method     ChildRFieldpostprocessorForfield[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RFieldpostprocessorForfieldQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\RFieldpostprocessorForfieldQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rokfor', $modelName = '\\RFieldpostprocessorForfield', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRFieldpostprocessorForfieldQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRFieldpostprocessorForfieldQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRFieldpostprocessorForfieldQuery) {
            return $criteria;
        }
        $query = new ChildRFieldpostprocessorForfieldQuery();
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
     * @param array[$_postprocessorid, $_templateid] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildRFieldpostprocessorForfield|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RFieldpostprocessorForfieldTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = RFieldpostprocessorForfieldTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildRFieldpostprocessorForfield A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT _postprocessorid, _templateid FROM R_fieldpostprocessor_forfield WHERE _postprocessorid = :p0 AND _templateid = :p1';
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
            /** @var ChildRFieldpostprocessorForfield $obj */
            $obj = new ChildRFieldpostprocessorForfield();
            $obj->hydrate($row);
            RFieldpostprocessorForfieldTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildRFieldpostprocessorForfield|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRFieldpostprocessorForfieldQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(RFieldpostprocessorForfieldTableMap::COL__POSTPROCESSORID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(RFieldpostprocessorForfieldTableMap::COL__TEMPLATEID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRFieldpostprocessorForfieldQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(RFieldpostprocessorForfieldTableMap::COL__POSTPROCESSORID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(RFieldpostprocessorForfieldTableMap::COL__TEMPLATEID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the _postprocessorid column
     *
     * Example usage:
     * <code>
     * $query->filterByPostprocessorid(1234); // WHERE _postprocessorid = 1234
     * $query->filterByPostprocessorid(array(12, 34)); // WHERE _postprocessorid IN (12, 34)
     * $query->filterByPostprocessorid(array('min' => 12)); // WHERE _postprocessorid > 12
     * </code>
     *
     * @see       filterByFieldpostprocessor()
     *
     * @param     mixed $postprocessorid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRFieldpostprocessorForfieldQuery The current query, for fluid interface
     */
    public function filterByPostprocessorid($postprocessorid = null, $comparison = null)
    {
        if (is_array($postprocessorid)) {
            $useMinMax = false;
            if (isset($postprocessorid['min'])) {
                $this->addUsingAlias(RFieldpostprocessorForfieldTableMap::COL__POSTPROCESSORID, $postprocessorid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($postprocessorid['max'])) {
                $this->addUsingAlias(RFieldpostprocessorForfieldTableMap::COL__POSTPROCESSORID, $postprocessorid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RFieldpostprocessorForfieldTableMap::COL__POSTPROCESSORID, $postprocessorid, $comparison);
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
     * @see       filterByTemplates()
     *
     * @param     mixed $templateid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRFieldpostprocessorForfieldQuery The current query, for fluid interface
     */
    public function filterByTemplateid($templateid = null, $comparison = null)
    {
        if (is_array($templateid)) {
            $useMinMax = false;
            if (isset($templateid['min'])) {
                $this->addUsingAlias(RFieldpostprocessorForfieldTableMap::COL__TEMPLATEID, $templateid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($templateid['max'])) {
                $this->addUsingAlias(RFieldpostprocessorForfieldTableMap::COL__TEMPLATEID, $templateid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RFieldpostprocessorForfieldTableMap::COL__TEMPLATEID, $templateid, $comparison);
    }

    /**
     * Filter the query by a related \Fieldpostprocessor object
     *
     * @param \Fieldpostprocessor|ObjectCollection $fieldpostprocessor The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRFieldpostprocessorForfieldQuery The current query, for fluid interface
     */
    public function filterByFieldpostprocessor($fieldpostprocessor, $comparison = null)
    {
        if ($fieldpostprocessor instanceof \Fieldpostprocessor) {
            return $this
                ->addUsingAlias(RFieldpostprocessorForfieldTableMap::COL__POSTPROCESSORID, $fieldpostprocessor->getId(), $comparison);
        } elseif ($fieldpostprocessor instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RFieldpostprocessorForfieldTableMap::COL__POSTPROCESSORID, $fieldpostprocessor->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByFieldpostprocessor() only accepts arguments of type \Fieldpostprocessor or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Fieldpostprocessor relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRFieldpostprocessorForfieldQuery The current query, for fluid interface
     */
    public function joinFieldpostprocessor($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Fieldpostprocessor');

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
            $this->addJoinObject($join, 'Fieldpostprocessor');
        }

        return $this;
    }

    /**
     * Use the Fieldpostprocessor relation Fieldpostprocessor object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \FieldpostprocessorQuery A secondary query class using the current class as primary query
     */
    public function useFieldpostprocessorQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFieldpostprocessor($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Fieldpostprocessor', '\FieldpostprocessorQuery');
    }

    /**
     * Filter the query by a related \Templates object
     *
     * @param \Templates|ObjectCollection $templates The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRFieldpostprocessorForfieldQuery The current query, for fluid interface
     */
    public function filterByTemplates($templates, $comparison = null)
    {
        if ($templates instanceof \Templates) {
            return $this
                ->addUsingAlias(RFieldpostprocessorForfieldTableMap::COL__TEMPLATEID, $templates->getId(), $comparison);
        } elseif ($templates instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RFieldpostprocessorForfieldTableMap::COL__TEMPLATEID, $templates->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildRFieldpostprocessorForfieldQuery The current query, for fluid interface
     */
    public function joinTemplates($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useTemplatesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTemplates($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Templates', '\TemplatesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRFieldpostprocessorForfield $rFieldpostprocessorForfield Object to remove from the list of results
     *
     * @return $this|ChildRFieldpostprocessorForfieldQuery The current query, for fluid interface
     */
    public function prune($rFieldpostprocessorForfield = null)
    {
        if ($rFieldpostprocessorForfield) {
            $this->addCond('pruneCond0', $this->getAliasedColName(RFieldpostprocessorForfieldTableMap::COL__POSTPROCESSORID), $rFieldpostprocessorForfield->getPostprocessorid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(RFieldpostprocessorForfieldTableMap::COL__TEMPLATEID), $rFieldpostprocessorForfield->getTemplateid(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the R_fieldpostprocessor_forfield table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RFieldpostprocessorForfieldTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RFieldpostprocessorForfieldTableMap::clearInstancePool();
            RFieldpostprocessorForfieldTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RFieldpostprocessorForfieldTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RFieldpostprocessorForfieldTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RFieldpostprocessorForfieldTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RFieldpostprocessorForfieldTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RFieldpostprocessorForfieldQuery
