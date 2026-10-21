<?php

namespace Map;

use \ContributionsVersion;
use \ContributionsVersionQuery;
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
 * This class defines the structure of the '_contributions_version' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ContributionsVersionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.ContributionsVersionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'rokfor';

    /**
     * The table name for this class
     */
    const TABLE_NAME = '_contributions_version';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\ContributionsVersion';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'ContributionsVersion';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 18;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 18;

    /**
     * the column name for the id field
     */
    const COL_ID = '_contributions_version.id';

    /**
     * the column name for the _fortemplate field
     */
    const COL__FORTEMPLATE = '_contributions_version._fortemplate';

    /**
     * the column name for the _forissue field
     */
    const COL__FORISSUE = '_contributions_version._forissue';

    /**
     * the column name for the _name field
     */
    const COL__NAME = '_contributions_version._name';

    /**
     * the column name for the _status field
     */
    const COL__STATUS = '_contributions_version._status';

    /**
     * the column name for the _newdate field
     */
    const COL__NEWDATE = '_contributions_version._newdate';

    /**
     * the column name for the _moddate field
     */
    const COL__MODDATE = '_contributions_version._moddate';

    /**
     * the column name for the __user__ field
     */
    const COL___USER__ = '_contributions_version.__user__';

    /**
     * the column name for the __config__ field
     */
    const COL___CONFIG__ = '_contributions_version.__config__';

    /**
     * the column name for the _forchapter field
     */
    const COL__FORCHAPTER = '_contributions_version._forchapter';

    /**
     * the column name for the __parentnode__ field
     */
    const COL___PARENTNODE__ = '_contributions_version.__parentnode__';

    /**
     * the column name for the __sort__ field
     */
    const COL___SORT__ = '_contributions_version.__sort__';

    /**
     * the column name for the version field
     */
    const COL_VERSION = '_contributions_version.version';

    /**
     * the column name for the version_created_at field
     */
    const COL_VERSION_CREATED_AT = '_contributions_version.version_created_at';

    /**
     * the column name for the version_created_by field
     */
    const COL_VERSION_CREATED_BY = '_contributions_version.version_created_by';

    /**
     * the column name for the version_comment field
     */
    const COL_VERSION_COMMENT = '_contributions_version.version_comment';

    /**
     * the column name for the _data_ids field
     */
    const COL__DATA_IDS = '_contributions_version._data_ids';

    /**
     * the column name for the _data_versions field
     */
    const COL__DATA_VERSIONS = '_contributions_version._data_versions';

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
        self::TYPE_PHPNAME       => array('Id', 'Fortemplate', 'Forissue', 'Name', 'Status', 'Newdate', 'Moddate', 'UserSys', 'ConfigSys', 'Forchapter', 'Parentnode', 'Sort', 'Version', 'VersionCreatedAt', 'VersionCreatedBy', 'VersionComment', 'DataIds', 'DataVersions', ),
        self::TYPE_CAMELNAME     => array('id', 'fortemplate', 'forissue', 'name', 'status', 'newdate', 'moddate', 'userSys', 'configSys', 'forchapter', 'parentnode', 'sort', 'version', 'versionCreatedAt', 'versionCreatedBy', 'versionComment', 'dataIds', 'dataVersions', ),
        self::TYPE_COLNAME       => array(ContributionsVersionTableMap::COL_ID, ContributionsVersionTableMap::COL__FORTEMPLATE, ContributionsVersionTableMap::COL__FORISSUE, ContributionsVersionTableMap::COL__NAME, ContributionsVersionTableMap::COL__STATUS, ContributionsVersionTableMap::COL__NEWDATE, ContributionsVersionTableMap::COL__MODDATE, ContributionsVersionTableMap::COL___USER__, ContributionsVersionTableMap::COL___CONFIG__, ContributionsVersionTableMap::COL__FORCHAPTER, ContributionsVersionTableMap::COL___PARENTNODE__, ContributionsVersionTableMap::COL___SORT__, ContributionsVersionTableMap::COL_VERSION, ContributionsVersionTableMap::COL_VERSION_CREATED_AT, ContributionsVersionTableMap::COL_VERSION_CREATED_BY, ContributionsVersionTableMap::COL_VERSION_COMMENT, ContributionsVersionTableMap::COL__DATA_IDS, ContributionsVersionTableMap::COL__DATA_VERSIONS, ),
        self::TYPE_FIELDNAME     => array('id', '_fortemplate', '_forissue', '_name', '_status', '_newdate', '_moddate', '__user__', '__config__', '_forchapter', '__parentnode__', '__sort__', 'version', 'version_created_at', 'version_created_by', 'version_comment', '_data_ids', '_data_versions', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Fortemplate' => 1, 'Forissue' => 2, 'Name' => 3, 'Status' => 4, 'Newdate' => 5, 'Moddate' => 6, 'UserSys' => 7, 'ConfigSys' => 8, 'Forchapter' => 9, 'Parentnode' => 10, 'Sort' => 11, 'Version' => 12, 'VersionCreatedAt' => 13, 'VersionCreatedBy' => 14, 'VersionComment' => 15, 'DataIds' => 16, 'DataVersions' => 17, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'fortemplate' => 1, 'forissue' => 2, 'name' => 3, 'status' => 4, 'newdate' => 5, 'moddate' => 6, 'userSys' => 7, 'configSys' => 8, 'forchapter' => 9, 'parentnode' => 10, 'sort' => 11, 'version' => 12, 'versionCreatedAt' => 13, 'versionCreatedBy' => 14, 'versionComment' => 15, 'dataIds' => 16, 'dataVersions' => 17, ),
        self::TYPE_COLNAME       => array(ContributionsVersionTableMap::COL_ID => 0, ContributionsVersionTableMap::COL__FORTEMPLATE => 1, ContributionsVersionTableMap::COL__FORISSUE => 2, ContributionsVersionTableMap::COL__NAME => 3, ContributionsVersionTableMap::COL__STATUS => 4, ContributionsVersionTableMap::COL__NEWDATE => 5, ContributionsVersionTableMap::COL__MODDATE => 6, ContributionsVersionTableMap::COL___USER__ => 7, ContributionsVersionTableMap::COL___CONFIG__ => 8, ContributionsVersionTableMap::COL__FORCHAPTER => 9, ContributionsVersionTableMap::COL___PARENTNODE__ => 10, ContributionsVersionTableMap::COL___SORT__ => 11, ContributionsVersionTableMap::COL_VERSION => 12, ContributionsVersionTableMap::COL_VERSION_CREATED_AT => 13, ContributionsVersionTableMap::COL_VERSION_CREATED_BY => 14, ContributionsVersionTableMap::COL_VERSION_COMMENT => 15, ContributionsVersionTableMap::COL__DATA_IDS => 16, ContributionsVersionTableMap::COL__DATA_VERSIONS => 17, ),
        self::TYPE_FIELDNAME     => array('id' => 0, '_fortemplate' => 1, '_forissue' => 2, '_name' => 3, '_status' => 4, '_newdate' => 5, '_moddate' => 6, '__user__' => 7, '__config__' => 8, '_forchapter' => 9, '__parentnode__' => 10, '__sort__' => 11, 'version' => 12, 'version_created_at' => 13, 'version_created_by' => 14, 'version_comment' => 15, '_data_ids' => 16, '_data_versions' => 17, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
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
        $this->setName('_contributions_version');
        $this->setPhpName('ContributionsVersion');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ContributionsVersion');
        $this->setPackage('');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('id', 'Id', 'INTEGER' , '_contributions', 'id', true, 4, null);
        $this->addColumn('_fortemplate', 'Fortemplate', 'INTEGER', false, 32, null);
        $this->addColumn('_forissue', 'Forissue', 'INTEGER', false, 32, null);
        $this->addColumn('_name', 'Name', 'LONGVARCHAR', false, null, null);
        $this->addColumn('_status', 'Status', 'LONGVARCHAR', false, null, null);
        $this->addColumn('_newdate', 'Newdate', 'INTEGER', false, 40, null);
        $this->addColumn('_moddate', 'Moddate', 'INTEGER', false, 40, null);
        $this->addColumn('__user__', 'UserSys', 'INTEGER', false, 4, null);
        $this->addColumn('__config__', 'ConfigSys', 'LONGVARCHAR', false, null, null);
        $this->addColumn('_forchapter', 'Forchapter', 'INTEGER', false, 32, null);
        $this->addColumn('__parentnode__', 'Parentnode', 'INTEGER', false, 32, null);
        $this->addColumn('__sort__', 'Sort', 'INTEGER', false, 32, null);
        $this->addPrimaryKey('version', 'Version', 'INTEGER', true, null, 0);
        $this->addColumn('version_created_at', 'VersionCreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('version_created_by', 'VersionCreatedBy', 'VARCHAR', false, 100, null);
        $this->addColumn('version_comment', 'VersionComment', 'VARCHAR', false, 255, null);
        $this->addColumn('_data_ids', 'DataIds', 'ARRAY', false, null, null);
        $this->addColumn('_data_versions', 'DataVersions', 'ARRAY', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Contributions', '\\Contributions', RelationMap::MANY_TO_ONE, array (
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
     * @param \ContributionsVersion $obj A \ContributionsVersion object.
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
     * @param mixed $value A \ContributionsVersion object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \ContributionsVersion) {
                $key = serialize([(null === $value->getId() || is_scalar($value->getId()) || is_callable([$value->getId(), '__toString']) ? (string) $value->getId() : $value->getId()), (null === $value->getVersion() || is_scalar($value->getVersion()) || is_callable([$value->getVersion(), '__toString']) ? (string) $value->getVersion() : $value->getVersion())]);

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize([(null === $value[0] || is_scalar($value[0]) || is_callable([$value[0], '__toString']) ? (string) $value[0] : $value[0]), (null === $value[1] || is_scalar($value[1]) || is_callable([$value[1], '__toString']) ? (string) $value[1] : $value[1])]);
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \ContributionsVersion object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 12 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([(null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 12 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 12 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 12 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 12 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 12 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)])]);
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
                ? 12 + $offset
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
        return $withPrefix ? ContributionsVersionTableMap::CLASS_DEFAULT : ContributionsVersionTableMap::OM_CLASS;
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
     * @return array           (ContributionsVersion object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ContributionsVersionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ContributionsVersionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ContributionsVersionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ContributionsVersionTableMap::OM_CLASS;
            /** @var ContributionsVersion $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ContributionsVersionTableMap::addInstanceToPool($obj, $key);
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
            $key = ContributionsVersionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ContributionsVersionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var ContributionsVersion $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ContributionsVersionTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ContributionsVersionTableMap::COL_ID);
            $criteria->addSelectColumn(ContributionsVersionTableMap::COL__FORTEMPLATE);
            $criteria->addSelectColumn(ContributionsVersionTableMap::COL__FORISSUE);
            $criteria->addSelectColumn(ContributionsVersionTableMap::COL__NAME);
            $criteria->addSelectColumn(ContributionsVersionTableMap::COL__STATUS);
            $criteria->addSelectColumn(ContributionsVersionTableMap::COL__NEWDATE);
            $criteria->addSelectColumn(ContributionsVersionTableMap::COL__MODDATE);
            $criteria->addSelectColumn(ContributionsVersionTableMap::COL___USER__);
            $criteria->addSelectColumn(ContributionsVersionTableMap::COL___CONFIG__);
            $criteria->addSelectColumn(ContributionsVersionTableMap::COL__FORCHAPTER);
            $criteria->addSelectColumn(ContributionsVersionTableMap::COL___PARENTNODE__);
            $criteria->addSelectColumn(ContributionsVersionTableMap::COL___SORT__);
            $criteria->addSelectColumn(ContributionsVersionTableMap::COL_VERSION);
            $criteria->addSelectColumn(ContributionsVersionTableMap::COL_VERSION_CREATED_AT);
            $criteria->addSelectColumn(ContributionsVersionTableMap::COL_VERSION_CREATED_BY);
            $criteria->addSelectColumn(ContributionsVersionTableMap::COL_VERSION_COMMENT);
            $criteria->addSelectColumn(ContributionsVersionTableMap::COL__DATA_IDS);
            $criteria->addSelectColumn(ContributionsVersionTableMap::COL__DATA_VERSIONS);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '._fortemplate');
            $criteria->addSelectColumn($alias . '._forissue');
            $criteria->addSelectColumn($alias . '._name');
            $criteria->addSelectColumn($alias . '._status');
            $criteria->addSelectColumn($alias . '._newdate');
            $criteria->addSelectColumn($alias . '._moddate');
            $criteria->addSelectColumn($alias . '.__user__');
            $criteria->addSelectColumn($alias . '.__config__');
            $criteria->addSelectColumn($alias . '._forchapter');
            $criteria->addSelectColumn($alias . '.__parentnode__');
            $criteria->addSelectColumn($alias . '.__sort__');
            $criteria->addSelectColumn($alias . '.version');
            $criteria->addSelectColumn($alias . '.version_created_at');
            $criteria->addSelectColumn($alias . '.version_created_by');
            $criteria->addSelectColumn($alias . '.version_comment');
            $criteria->addSelectColumn($alias . '._data_ids');
            $criteria->addSelectColumn($alias . '._data_versions');
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
        return Propel::getServiceContainer()->getDatabaseMap(ContributionsVersionTableMap::DATABASE_NAME)->getTable(ContributionsVersionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ContributionsVersionTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ContributionsVersionTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ContributionsVersionTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a ContributionsVersion or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ContributionsVersion object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ContributionsVersionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \ContributionsVersion) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ContributionsVersionTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(ContributionsVersionTableMap::COL_ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(ContributionsVersionTableMap::COL_VERSION, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = ContributionsVersionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ContributionsVersionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ContributionsVersionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the _contributions_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ContributionsVersionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ContributionsVersion or Criteria object.
     *
     * @param mixed               $criteria Criteria or ContributionsVersion object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ContributionsVersionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ContributionsVersion object
        }


        // Set the correct dbName
        $query = ContributionsVersionQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ContributionsVersionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ContributionsVersionTableMap::buildTableMap();
