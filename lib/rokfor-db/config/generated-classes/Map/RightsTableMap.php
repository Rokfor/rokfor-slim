<?php

namespace Map;

use \Rights;
use \RightsQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the '_rights' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class RightsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.RightsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'rokfor';

    /**
     * The table name for this class
     */
    const TABLE_NAME = '_rights';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Rights';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Rights';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the id field
     */
    const COL_ID = '_rights.id';

    /**
     * the column name for the _group field
     */
    const COL__GROUP = '_rights._group';

    /**
     * the column name for the __config__ field
     */
    const COL___CONFIG__ = '_rights.__config__';

    /**
     * the column name for the __split__ field
     */
    const COL___SPLIT__ = '_rights.__split__';

    /**
     * the column name for the __parentnode__ field
     */
    const COL___PARENTNODE__ = '_rights.__parentnode__';

    /**
     * the column name for the __sort__ field
     */
    const COL___SORT__ = '_rights.__sort__';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Group', 'ConfigSys', 'Split', 'Parentnode', 'Sort', ),
        self::TYPE_CAMELNAME     => array('id', 'group', 'configSys', 'split', 'parentnode', 'sort', ),
        self::TYPE_COLNAME       => array(RightsTableMap::COL_ID, RightsTableMap::COL__GROUP, RightsTableMap::COL___CONFIG__, RightsTableMap::COL___SPLIT__, RightsTableMap::COL___PARENTNODE__, RightsTableMap::COL___SORT__, ),
        self::TYPE_FIELDNAME     => array('id', '_group', '__config__', '__split__', '__parentnode__', '__sort__', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Group' => 1, 'ConfigSys' => 2, 'Split' => 3, 'Parentnode' => 4, 'Sort' => 5, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'group' => 1, 'configSys' => 2, 'split' => 3, 'parentnode' => 4, 'sort' => 5, ),
        self::TYPE_COLNAME       => array(RightsTableMap::COL_ID => 0, RightsTableMap::COL__GROUP => 1, RightsTableMap::COL___CONFIG__ => 2, RightsTableMap::COL___SPLIT__ => 3, RightsTableMap::COL___PARENTNODE__ => 4, RightsTableMap::COL___SORT__ => 5, ),
        self::TYPE_FIELDNAME     => array('id' => 0, '_group' => 1, '__config__' => 2, '__split__' => 3, '__parentnode__' => 4, '__sort__' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('_rights');
        $this->setPhpName('Rights');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Rights');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 4, null);
        $this->addColumn('_group', 'Group', 'LONGVARCHAR', false, null, null);
        $this->addColumn('__config__', 'ConfigSys', 'LONGVARCHAR', false, null, null);
        $this->addColumn('__split__', 'Split', 'LONGVARCHAR', false, null, null);
        $this->addColumn('__parentnode__', 'Parentnode', 'INTEGER', false, 32, null);
        $this->addColumn('__sort__', 'Sort', 'INTEGER', false, 32, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('RRightsForbook', '\\RRightsForbook', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':_rightid',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'RRightsForbooks', false);
        $this->addRelation('RRightsForissue', '\\RRightsForissue', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':_rightid',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'RRightsForissues', false);
        $this->addRelation('RRightsFortemplate', '\\RRightsFortemplate', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':_rightid',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'RRightsFortemplates', false);
        $this->addRelation('RRightsForformat', '\\RRightsForformat', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':_rightid',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'RRightsForformats', false);
        $this->addRelation('RRightsForuser', '\\RRightsForuser', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':_rightid',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'RRightsForusers', false);
        $this->addRelation('Books', '\\Books', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'Bookss');
        $this->addRelation('Issues', '\\Issues', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'Issuess');
        $this->addRelation('Templatenames', '\\Templatenames', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'Templatenamess');
        $this->addRelation('Formats', '\\Formats', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'Formatss');
        $this->addRelation('Users', '\\Users', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'Userss');
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to _rights     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        RRightsForbookTableMap::clearInstancePool();
        RRightsForissueTableMap::clearInstancePool();
        RRightsFortemplateTableMap::clearInstancePool();
        RRightsForformatTableMap::clearInstancePool();
        RRightsForuserTableMap::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? RightsTableMap::CLASS_DEFAULT : RightsTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Rights object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = RightsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = RightsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + RightsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = RightsTableMap::OM_CLASS;
            /** @var Rights $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            RightsTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = RightsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = RightsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Rights $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                RightsTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(RightsTableMap::COL_ID);
            $criteria->addSelectColumn(RightsTableMap::COL__GROUP);
            $criteria->addSelectColumn(RightsTableMap::COL___CONFIG__);
            $criteria->addSelectColumn(RightsTableMap::COL___SPLIT__);
            $criteria->addSelectColumn(RightsTableMap::COL___PARENTNODE__);
            $criteria->addSelectColumn(RightsTableMap::COL___SORT__);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '._group');
            $criteria->addSelectColumn($alias . '.__config__');
            $criteria->addSelectColumn($alias . '.__split__');
            $criteria->addSelectColumn($alias . '.__parentnode__');
            $criteria->addSelectColumn($alias . '.__sort__');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(RightsTableMap::DATABASE_NAME)->getTable(RightsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(RightsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(RightsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new RightsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Rights or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Rights object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RightsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Rights) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(RightsTableMap::DATABASE_NAME);
            $criteria->add(RightsTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = RightsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            RightsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                RightsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the _rights table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return RightsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Rights or Criteria object.
     *
     * @param mixed               $criteria Criteria or Rights object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RightsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Rights object
        }

        if ($criteria->containsKey(RightsTableMap::COL_ID) && $criteria->keyContainsValue(RightsTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.RightsTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = RightsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // RightsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
RightsTableMap::buildTableMap();
