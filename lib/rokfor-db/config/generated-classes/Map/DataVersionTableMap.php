<?php

namespace Map;

use \DataVersion;
use \DataVersionQuery;
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
 * This class defines the structure of the '_data_version' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class DataVersionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.DataVersionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'rokfor';

    /**
     * The table name for this class
     */
    const TABLE_NAME = '_data_version';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\DataVersion';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'DataVersion';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 15;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 15;

    /**
     * the column name for the id field
     */
    const COL_ID = '_data_version.id';

    /**
     * the column name for the _forcontribution field
     */
    const COL__FORCONTRIBUTION = '_data_version._forcontribution';

    /**
     * the column name for the _fortemplatefield field
     */
    const COL__FORTEMPLATEFIELD = '_data_version._fortemplatefield';

    /**
     * the column name for the _content field
     */
    const COL__CONTENT = '_data_version._content';

    /**
     * the column name for the _isjson field
     */
    const COL__ISJSON = '_data_version._isjson';

    /**
     * the column name for the __user__ field
     */
    const COL___USER__ = '_data_version.__user__';

    /**
     * the column name for the __config__ field
     */
    const COL___CONFIG__ = '_data_version.__config__';

    /**
     * the column name for the __split__ field
     */
    const COL___SPLIT__ = '_data_version.__split__';

    /**
     * the column name for the __parentnode__ field
     */
    const COL___PARENTNODE__ = '_data_version.__parentnode__';

    /**
     * the column name for the __sort__ field
     */
    const COL___SORT__ = '_data_version.__sort__';

    /**
     * the column name for the version field
     */
    const COL_VERSION = '_data_version.version';

    /**
     * the column name for the version_created_at field
     */
    const COL_VERSION_CREATED_AT = '_data_version.version_created_at';

    /**
     * the column name for the version_created_by field
     */
    const COL_VERSION_CREATED_BY = '_data_version.version_created_by';

    /**
     * the column name for the version_comment field
     */
    const COL_VERSION_COMMENT = '_data_version.version_comment';

    /**
     * the column name for the _forcontribution_version field
     */
    const COL__FORCONTRIBUTION_VERSION = '_data_version._forcontribution_version';

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
        self::TYPE_PHPNAME       => array('Id', 'Forcontribution', 'Fortemplatefield', 'Content', 'Isjson', 'UserSys', 'ConfigSys', 'Split', 'Parentnode', 'Sort', 'Version', 'VersionCreatedAt', 'VersionCreatedBy', 'VersionComment', 'ForcontributionVersion', ),
        self::TYPE_CAMELNAME     => array('id', 'forcontribution', 'fortemplatefield', 'content', 'isjson', 'userSys', 'configSys', 'split', 'parentnode', 'sort', 'version', 'versionCreatedAt', 'versionCreatedBy', 'versionComment', 'forcontributionVersion', ),
        self::TYPE_COLNAME       => array(DataVersionTableMap::COL_ID, DataVersionTableMap::COL__FORCONTRIBUTION, DataVersionTableMap::COL__FORTEMPLATEFIELD, DataVersionTableMap::COL__CONTENT, DataVersionTableMap::COL__ISJSON, DataVersionTableMap::COL___USER__, DataVersionTableMap::COL___CONFIG__, DataVersionTableMap::COL___SPLIT__, DataVersionTableMap::COL___PARENTNODE__, DataVersionTableMap::COL___SORT__, DataVersionTableMap::COL_VERSION, DataVersionTableMap::COL_VERSION_CREATED_AT, DataVersionTableMap::COL_VERSION_CREATED_BY, DataVersionTableMap::COL_VERSION_COMMENT, DataVersionTableMap::COL__FORCONTRIBUTION_VERSION, ),
        self::TYPE_FIELDNAME     => array('id', '_forcontribution', '_fortemplatefield', '_content', '_isjson', '__user__', '__config__', '__split__', '__parentnode__', '__sort__', 'version', 'version_created_at', 'version_created_by', 'version_comment', '_forcontribution_version', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Forcontribution' => 1, 'Fortemplatefield' => 2, 'Content' => 3, 'Isjson' => 4, 'UserSys' => 5, 'ConfigSys' => 6, 'Split' => 7, 'Parentnode' => 8, 'Sort' => 9, 'Version' => 10, 'VersionCreatedAt' => 11, 'VersionCreatedBy' => 12, 'VersionComment' => 13, 'ForcontributionVersion' => 14, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'forcontribution' => 1, 'fortemplatefield' => 2, 'content' => 3, 'isjson' => 4, 'userSys' => 5, 'configSys' => 6, 'split' => 7, 'parentnode' => 8, 'sort' => 9, 'version' => 10, 'versionCreatedAt' => 11, 'versionCreatedBy' => 12, 'versionComment' => 13, 'forcontributionVersion' => 14, ),
        self::TYPE_COLNAME       => array(DataVersionTableMap::COL_ID => 0, DataVersionTableMap::COL__FORCONTRIBUTION => 1, DataVersionTableMap::COL__FORTEMPLATEFIELD => 2, DataVersionTableMap::COL__CONTENT => 3, DataVersionTableMap::COL__ISJSON => 4, DataVersionTableMap::COL___USER__ => 5, DataVersionTableMap::COL___CONFIG__ => 6, DataVersionTableMap::COL___SPLIT__ => 7, DataVersionTableMap::COL___PARENTNODE__ => 8, DataVersionTableMap::COL___SORT__ => 9, DataVersionTableMap::COL_VERSION => 10, DataVersionTableMap::COL_VERSION_CREATED_AT => 11, DataVersionTableMap::COL_VERSION_CREATED_BY => 12, DataVersionTableMap::COL_VERSION_COMMENT => 13, DataVersionTableMap::COL__FORCONTRIBUTION_VERSION => 14, ),
        self::TYPE_FIELDNAME     => array('id' => 0, '_forcontribution' => 1, '_fortemplatefield' => 2, '_content' => 3, '_isjson' => 4, '__user__' => 5, '__config__' => 6, '__split__' => 7, '__parentnode__' => 8, '__sort__' => 9, 'version' => 10, 'version_created_at' => 11, 'version_created_by' => 12, 'version_comment' => 13, '_forcontribution_version' => 14, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
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
        $this->setName('_data_version');
        $this->setPhpName('DataVersion');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\DataVersion');
        $this->setPackage('');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('id', 'Id', 'INTEGER' , '_data', 'id', true, 4, null);
        $this->addColumn('_forcontribution', 'Forcontribution', 'INTEGER', false, 4, null);
        $this->addColumn('_fortemplatefield', 'Fortemplatefield', 'INTEGER', false, 32, null);
        $this->addColumn('_content', 'Content', 'CLOB', false, null, null);
        $this->addColumn('_isjson', 'Isjson', 'BOOLEAN', false, 1, null);
        $this->addColumn('__user__', 'UserSys', 'INTEGER', false, 4, null);
        $this->addColumn('__config__', 'ConfigSys', 'LONGVARCHAR', false, null, null);
        $this->addColumn('__split__', 'Split', 'LONGVARCHAR', false, null, null);
        $this->addColumn('__parentnode__', 'Parentnode', 'INTEGER', false, 32, null);
        $this->addColumn('__sort__', 'Sort', 'INTEGER', false, 32, null);
        $this->addPrimaryKey('version', 'Version', 'INTEGER', true, null, 0);
        $this->addColumn('version_created_at', 'VersionCreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('version_created_by', 'VersionCreatedBy', 'VARCHAR', false, 100, null);
        $this->addColumn('version_comment', 'VersionComment', 'VARCHAR', false, 255, null);
        $this->addColumn('_forcontribution_version', 'ForcontributionVersion', 'INTEGER', false, null, 0);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Data', '\\Data', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
    } // buildRelations()

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \DataVersion $obj A \DataVersion object.
     * @param string $key             (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize([(null === $obj->getId() || is_scalar($obj->getId()) || is_callable([$obj->getId(), '__toString']) ? (string) $obj->getId() : $obj->getId()), (null === $obj->getVersion() || is_scalar($obj->getVersion()) || is_callable([$obj->getVersion(), '__toString']) ? (string) $obj->getVersion() : $obj->getVersion())]);
            } // if key === null
            self::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A \DataVersion object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \DataVersion) {
                $key = serialize([(null === $value->getId() || is_scalar($value->getId()) || is_callable([$value->getId(), '__toString']) ? (string) $value->getId() : $value->getId()), (null === $value->getVersion() || is_scalar($value->getVersion()) || is_callable([$value->getVersion(), '__toString']) ? (string) $value->getVersion() : $value->getVersion())]);

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize([(null === $value[0] || is_scalar($value[0]) || is_callable([$value[0], '__toString']) ? (string) $value[0] : $value[0]), (null === $value[1] || is_scalar($value[1]) || is_callable([$value[1], '__toString']) ? (string) $value[1] : $value[1])]);
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \DataVersion object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 10 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([(null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 10 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 10 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 10 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 10 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 10 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)])]);
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
            $pks = [];

        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 10 + $offset
                : self::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)
        ];

        return $pks;
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
        return $withPrefix ? DataVersionTableMap::CLASS_DEFAULT : DataVersionTableMap::OM_CLASS;
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
     * @return array           (DataVersion object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = DataVersionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = DataVersionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + DataVersionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = DataVersionTableMap::OM_CLASS;
            /** @var DataVersion $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            DataVersionTableMap::addInstanceToPool($obj, $key);
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
            $key = DataVersionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = DataVersionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var DataVersion $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                DataVersionTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(DataVersionTableMap::COL_ID);
            $criteria->addSelectColumn(DataVersionTableMap::COL__FORCONTRIBUTION);
            $criteria->addSelectColumn(DataVersionTableMap::COL__FORTEMPLATEFIELD);
            $criteria->addSelectColumn(DataVersionTableMap::COL__CONTENT);
            $criteria->addSelectColumn(DataVersionTableMap::COL__ISJSON);
            $criteria->addSelectColumn(DataVersionTableMap::COL___USER__);
            $criteria->addSelectColumn(DataVersionTableMap::COL___CONFIG__);
            $criteria->addSelectColumn(DataVersionTableMap::COL___SPLIT__);
            $criteria->addSelectColumn(DataVersionTableMap::COL___PARENTNODE__);
            $criteria->addSelectColumn(DataVersionTableMap::COL___SORT__);
            $criteria->addSelectColumn(DataVersionTableMap::COL_VERSION);
            $criteria->addSelectColumn(DataVersionTableMap::COL_VERSION_CREATED_AT);
            $criteria->addSelectColumn(DataVersionTableMap::COL_VERSION_CREATED_BY);
            $criteria->addSelectColumn(DataVersionTableMap::COL_VERSION_COMMENT);
            $criteria->addSelectColumn(DataVersionTableMap::COL__FORCONTRIBUTION_VERSION);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '._forcontribution');
            $criteria->addSelectColumn($alias . '._fortemplatefield');
            $criteria->addSelectColumn($alias . '._content');
            $criteria->addSelectColumn($alias . '._isjson');
            $criteria->addSelectColumn($alias . '.__user__');
            $criteria->addSelectColumn($alias . '.__config__');
            $criteria->addSelectColumn($alias . '.__split__');
            $criteria->addSelectColumn($alias . '.__parentnode__');
            $criteria->addSelectColumn($alias . '.__sort__');
            $criteria->addSelectColumn($alias . '.version');
            $criteria->addSelectColumn($alias . '.version_created_at');
            $criteria->addSelectColumn($alias . '.version_created_by');
            $criteria->addSelectColumn($alias . '.version_comment');
            $criteria->addSelectColumn($alias . '._forcontribution_version');
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
        return Propel::getServiceContainer()->getDatabaseMap(DataVersionTableMap::DATABASE_NAME)->getTable(DataVersionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(DataVersionTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(DataVersionTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new DataVersionTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a DataVersion or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or DataVersion object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(DataVersionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \DataVersion) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(DataVersionTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(DataVersionTableMap::COL_ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(DataVersionTableMap::COL_VERSION, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = DataVersionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            DataVersionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                DataVersionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the _data_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return DataVersionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a DataVersion or Criteria object.
     *
     * @param mixed               $criteria Criteria or DataVersion object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DataVersionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from DataVersion object
        }


        // Set the correct dbName
        $query = DataVersionQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // DataVersionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
DataVersionTableMap::buildTableMap();
