<?php

namespace Map;

use \Contributions;
use \ContributionsQuery;
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
 * This class defines the structure of the '_contributions' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ContributionsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.ContributionsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'rokfor';

    /**
     * The table name for this class
     */
    const TABLE_NAME = '_contributions';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Contributions';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Contributions';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 16;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 16;

    /**
     * the column name for the id field
     */
    const COL_ID = '_contributions.id';

    /**
     * the column name for the _fortemplate field
     */
    const COL__FORTEMPLATE = '_contributions._fortemplate';

    /**
     * the column name for the _forissue field
     */
    const COL__FORISSUE = '_contributions._forissue';

    /**
     * the column name for the _name field
     */
    const COL__NAME = '_contributions._name';

    /**
     * the column name for the _status field
     */
    const COL__STATUS = '_contributions._status';

    /**
     * the column name for the _newdate field
     */
    const COL__NEWDATE = '_contributions._newdate';

    /**
     * the column name for the _moddate field
     */
    const COL__MODDATE = '_contributions._moddate';

    /**
     * the column name for the __user__ field
     */
    const COL___USER__ = '_contributions.__user__';

    /**
     * the column name for the __config__ field
     */
    const COL___CONFIG__ = '_contributions.__config__';

    /**
     * the column name for the _forchapter field
     */
    const COL__FORCHAPTER = '_contributions._forchapter';

    /**
     * the column name for the __parentnode__ field
     */
    const COL___PARENTNODE__ = '_contributions.__parentnode__';

    /**
     * the column name for the __sort__ field
     */
    const COL___SORT__ = '_contributions.__sort__';

    /**
     * the column name for the version field
     */
    const COL_VERSION = '_contributions.version';

    /**
     * the column name for the version_created_at field
     */
    const COL_VERSION_CREATED_AT = '_contributions.version_created_at';

    /**
     * the column name for the version_created_by field
     */
    const COL_VERSION_CREATED_BY = '_contributions.version_created_by';

    /**
     * the column name for the version_comment field
     */
    const COL_VERSION_COMMENT = '_contributions.version_comment';

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
        self::TYPE_PHPNAME       => array('Id', 'Fortemplate', 'Forissue', 'Name', 'Status', 'Newdate', 'Moddate', 'UserSys', 'ConfigSys', 'Forchapter', 'Parentnode', 'Sort', 'Version', 'VersionCreatedAt', 'VersionCreatedBy', 'VersionComment', ),
        self::TYPE_CAMELNAME     => array('id', 'fortemplate', 'forissue', 'name', 'status', 'newdate', 'moddate', 'userSys', 'configSys', 'forchapter', 'parentnode', 'sort', 'version', 'versionCreatedAt', 'versionCreatedBy', 'versionComment', ),
        self::TYPE_COLNAME       => array(ContributionsTableMap::COL_ID, ContributionsTableMap::COL__FORTEMPLATE, ContributionsTableMap::COL__FORISSUE, ContributionsTableMap::COL__NAME, ContributionsTableMap::COL__STATUS, ContributionsTableMap::COL__NEWDATE, ContributionsTableMap::COL__MODDATE, ContributionsTableMap::COL___USER__, ContributionsTableMap::COL___CONFIG__, ContributionsTableMap::COL__FORCHAPTER, ContributionsTableMap::COL___PARENTNODE__, ContributionsTableMap::COL___SORT__, ContributionsTableMap::COL_VERSION, ContributionsTableMap::COL_VERSION_CREATED_AT, ContributionsTableMap::COL_VERSION_CREATED_BY, ContributionsTableMap::COL_VERSION_COMMENT, ),
        self::TYPE_FIELDNAME     => array('id', '_fortemplate', '_forissue', '_name', '_status', '_newdate', '_moddate', '__user__', '__config__', '_forchapter', '__parentnode__', '__sort__', 'version', 'version_created_at', 'version_created_by', 'version_comment', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Fortemplate' => 1, 'Forissue' => 2, 'Name' => 3, 'Status' => 4, 'Newdate' => 5, 'Moddate' => 6, 'UserSys' => 7, 'ConfigSys' => 8, 'Forchapter' => 9, 'Parentnode' => 10, 'Sort' => 11, 'Version' => 12, 'VersionCreatedAt' => 13, 'VersionCreatedBy' => 14, 'VersionComment' => 15, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'fortemplate' => 1, 'forissue' => 2, 'name' => 3, 'status' => 4, 'newdate' => 5, 'moddate' => 6, 'userSys' => 7, 'configSys' => 8, 'forchapter' => 9, 'parentnode' => 10, 'sort' => 11, 'version' => 12, 'versionCreatedAt' => 13, 'versionCreatedBy' => 14, 'versionComment' => 15, ),
        self::TYPE_COLNAME       => array(ContributionsTableMap::COL_ID => 0, ContributionsTableMap::COL__FORTEMPLATE => 1, ContributionsTableMap::COL__FORISSUE => 2, ContributionsTableMap::COL__NAME => 3, ContributionsTableMap::COL__STATUS => 4, ContributionsTableMap::COL__NEWDATE => 5, ContributionsTableMap::COL__MODDATE => 6, ContributionsTableMap::COL___USER__ => 7, ContributionsTableMap::COL___CONFIG__ => 8, ContributionsTableMap::COL__FORCHAPTER => 9, ContributionsTableMap::COL___PARENTNODE__ => 10, ContributionsTableMap::COL___SORT__ => 11, ContributionsTableMap::COL_VERSION => 12, ContributionsTableMap::COL_VERSION_CREATED_AT => 13, ContributionsTableMap::COL_VERSION_CREATED_BY => 14, ContributionsTableMap::COL_VERSION_COMMENT => 15, ),
        self::TYPE_FIELDNAME     => array('id' => 0, '_fortemplate' => 1, '_forissue' => 2, '_name' => 3, '_status' => 4, '_newdate' => 5, '_moddate' => 6, '__user__' => 7, '__config__' => 8, '_forchapter' => 9, '__parentnode__' => 10, '__sort__' => 11, 'version' => 12, 'version_created_at' => 13, 'version_created_by' => 14, 'version_comment' => 15, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
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
        $this->setName('_contributions');
        $this->setPhpName('Contributions');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Contributions');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 4, null);
        $this->addForeignKey('_fortemplate', 'Fortemplate', 'INTEGER', '_templatenames', 'id', false, 32, null);
        $this->addForeignKey('_forissue', 'Forissue', 'INTEGER', '_issues', 'id', false, 32, null);
        $this->addColumn('_name', 'Name', 'LONGVARCHAR', false, null, null);
        $this->addColumn('_status', 'Status', 'LONGVARCHAR', false, null, null);
        $this->addColumn('_newdate', 'Newdate', 'INTEGER', false, 40, null);
        $this->addColumn('_moddate', 'Moddate', 'INTEGER', false, 40, null);
        $this->addForeignKey('__user__', 'UserSys', 'INTEGER', 'users', 'id', false, 4, null);
        $this->addColumn('__config__', 'ConfigSys', 'LONGVARCHAR', false, null, null);
        $this->addForeignKey('_forchapter', 'Forchapter', 'INTEGER', '_formats', 'id', false, 32, null);
        $this->addColumn('__parentnode__', 'Parentnode', 'INTEGER', false, 32, null);
        $this->addColumn('__sort__', 'Sort', 'INTEGER', false, 32, null);
        $this->addColumn('version', 'Version', 'INTEGER', false, null, 0);
        $this->addColumn('version_created_at', 'VersionCreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('version_created_by', 'VersionCreatedBy', 'VARCHAR', false, 100, null);
        $this->addColumn('version_comment', 'VersionComment', 'VARCHAR', false, 255, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('userSysRef', '\\Users', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':__user__',
    1 => ':id',
  ),
), 'SET NULL', 'SET NULL', null, false);
        $this->addRelation('Formats', '\\Formats', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':_forchapter',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Issues', '\\Issues', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':_forissue',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Templatenames', '\\Templatenames', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':_fortemplate',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Contributionscache', '\\Contributionscache', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':_forcontribution',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'Contributionscaches', false);
        $this->addRelation('Data', '\\Data', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':_forcontribution',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'Datas', false);
        $this->addRelation('RDataContribution', '\\RDataContribution', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':_contributionid',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'RDataContributions', false);
        $this->addRelation('ContributionsVersion', '\\ContributionsVersion', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id',
    1 => ':id',
  ),
), 'CASCADE', null, 'ContributionsVersions', false);
        $this->addRelation('RData', '\\Data', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'RDatas');
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'versionable' => array('version_column' => 'version', 'version_table' => '', 'log_created_at' => 'true', 'log_created_by' => 'true', 'log_comment' => 'true', 'version_created_at_column' => 'version_created_at', 'version_created_by_column' => 'version_created_by', 'version_comment_column' => 'version_comment', 'indices' => 'false', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to _contributions     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ContributionscacheTableMap::clearInstancePool();
        DataTableMap::clearInstancePool();
        RDataContributionTableMap::clearInstancePool();
        ContributionsVersionTableMap::clearInstancePool();
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
        return $withPrefix ? ContributionsTableMap::CLASS_DEFAULT : ContributionsTableMap::OM_CLASS;
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
     * @return array           (Contributions object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ContributionsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ContributionsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ContributionsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ContributionsTableMap::OM_CLASS;
            /** @var Contributions $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ContributionsTableMap::addInstanceToPool($obj, $key);
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
            $key = ContributionsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ContributionsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Contributions $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ContributionsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ContributionsTableMap::COL_ID);
            $criteria->addSelectColumn(ContributionsTableMap::COL__FORTEMPLATE);
            $criteria->addSelectColumn(ContributionsTableMap::COL__FORISSUE);
            $criteria->addSelectColumn(ContributionsTableMap::COL__NAME);
            $criteria->addSelectColumn(ContributionsTableMap::COL__STATUS);
            $criteria->addSelectColumn(ContributionsTableMap::COL__NEWDATE);
            $criteria->addSelectColumn(ContributionsTableMap::COL__MODDATE);
            $criteria->addSelectColumn(ContributionsTableMap::COL___USER__);
            $criteria->addSelectColumn(ContributionsTableMap::COL___CONFIG__);
            $criteria->addSelectColumn(ContributionsTableMap::COL__FORCHAPTER);
            $criteria->addSelectColumn(ContributionsTableMap::COL___PARENTNODE__);
            $criteria->addSelectColumn(ContributionsTableMap::COL___SORT__);
            $criteria->addSelectColumn(ContributionsTableMap::COL_VERSION);
            $criteria->addSelectColumn(ContributionsTableMap::COL_VERSION_CREATED_AT);
            $criteria->addSelectColumn(ContributionsTableMap::COL_VERSION_CREATED_BY);
            $criteria->addSelectColumn(ContributionsTableMap::COL_VERSION_COMMENT);
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
        return Propel::getServiceContainer()->getDatabaseMap(ContributionsTableMap::DATABASE_NAME)->getTable(ContributionsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ContributionsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ContributionsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ContributionsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Contributions or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Contributions object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ContributionsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Contributions) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ContributionsTableMap::DATABASE_NAME);
            $criteria->add(ContributionsTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = ContributionsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ContributionsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ContributionsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the _contributions table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ContributionsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Contributions or Criteria object.
     *
     * @param mixed               $criteria Criteria or Contributions object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ContributionsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Contributions object
        }

        if ($criteria->containsKey(ContributionsTableMap::COL_ID) && $criteria->keyContainsValue(ContributionsTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ContributionsTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = ContributionsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ContributionsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ContributionsTableMap::buildTableMap();
