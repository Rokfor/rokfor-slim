<?php

namespace Map;

use \Formats;
use \FormatsQuery;
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
 * This class defines the structure of the '_formats' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class FormatsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.FormatsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'rokfor';

    /**
     * The table name for this class
     */
    const TABLE_NAME = '_formats';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Formats';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Formats';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the id field
     */
    const COL_ID = '_formats.id';

    /**
     * the column name for the _name field
     */
    const COL__NAME = '_formats._name';

    /**
     * the column name for the _forbook field
     */
    const COL__FORBOOK = '_formats._forbook';

    /**
     * the column name for the __user__ field
     */
    const COL___USER__ = '_formats.__user__';

    /**
     * the column name for the __config__ field
     */
    const COL___CONFIG__ = '_formats.__config__';

    /**
     * the column name for the __split__ field
     */
    const COL___SPLIT__ = '_formats.__split__';

    /**
     * the column name for the __sort__ field
     */
    const COL___SORT__ = '_formats.__sort__';

    /**
     * the column name for the __parentnode__ field
     */
    const COL___PARENTNODE__ = '_formats.__parentnode__';

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
        self::TYPE_PHPNAME       => array('Id', 'Name', 'Forbook', 'UserSys', 'ConfigSys', 'Split', 'Sort', 'Parentnode', ),
        self::TYPE_CAMELNAME     => array('id', 'name', 'forbook', 'userSys', 'configSys', 'split', 'sort', 'parentnode', ),
        self::TYPE_COLNAME       => array(FormatsTableMap::COL_ID, FormatsTableMap::COL__NAME, FormatsTableMap::COL__FORBOOK, FormatsTableMap::COL___USER__, FormatsTableMap::COL___CONFIG__, FormatsTableMap::COL___SPLIT__, FormatsTableMap::COL___SORT__, FormatsTableMap::COL___PARENTNODE__, ),
        self::TYPE_FIELDNAME     => array('id', '_name', '_forbook', '__user__', '__config__', '__split__', '__sort__', '__parentnode__', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'Forbook' => 2, 'UserSys' => 3, 'ConfigSys' => 4, 'Split' => 5, 'Sort' => 6, 'Parentnode' => 7, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'name' => 1, 'forbook' => 2, 'userSys' => 3, 'configSys' => 4, 'split' => 5, 'sort' => 6, 'parentnode' => 7, ),
        self::TYPE_COLNAME       => array(FormatsTableMap::COL_ID => 0, FormatsTableMap::COL__NAME => 1, FormatsTableMap::COL__FORBOOK => 2, FormatsTableMap::COL___USER__ => 3, FormatsTableMap::COL___CONFIG__ => 4, FormatsTableMap::COL___SPLIT__ => 5, FormatsTableMap::COL___SORT__ => 6, FormatsTableMap::COL___PARENTNODE__ => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, '_name' => 1, '_forbook' => 2, '__user__' => 3, '__config__' => 4, '__split__' => 5, '__sort__' => 6, '__parentnode__' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
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
        $this->setName('_formats');
        $this->setPhpName('Formats');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Formats');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 4, null);
        $this->addColumn('_name', 'Name', 'LONGVARCHAR', true, null, null);
        $this->addForeignKey('_forbook', 'Forbook', 'INTEGER', '_books', 'id', false, 32, null);
        $this->addForeignKey('__user__', 'UserSys', 'INTEGER', 'users', 'id', false, 4, null);
        $this->addColumn('__config__', 'ConfigSys', 'LONGVARCHAR', false, null, null);
        $this->addColumn('__split__', 'Split', 'LONGVARCHAR', false, null, null);
        $this->addColumn('__sort__', 'Sort', 'INTEGER', false, 32, null);
        $this->addColumn('__parentnode__', 'Parentnode', 'INTEGER', false, 32, null);
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
        $this->addRelation('Books', '\\Books', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':_forbook',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('RRightsForformat', '\\RRightsForformat', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':_formatid',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'RRightsForformats', false);
        $this->addRelation('RTemplatenamesInchapter', '\\RTemplatenamesInchapter', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':_chapterid',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'RTemplatenamesInchapters', false);
        $this->addRelation('Contributions', '\\Contributions', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':_forchapter',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'Contributionss', false);
        $this->addRelation('RDataFormat', '\\RDataFormat', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':_formatid',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'RDataFormats', false);
        $this->addRelation('RPluginFormat', '\\RPluginFormat', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':_formatid',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'RPluginFormats', false);
        $this->addRelation('Rights', '\\Rights', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'Rightss');
        $this->addRelation('Templatenames', '\\Templatenames', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'Templatenamess');
        $this->addRelation('RData', '\\Data', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'RDatas');
        $this->addRelation('RPlugin', '\\Plugins', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'RPlugins');
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to _formats     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        RRightsForformatTableMap::clearInstancePool();
        RTemplatenamesInchapterTableMap::clearInstancePool();
        ContributionsTableMap::clearInstancePool();
        RDataFormatTableMap::clearInstancePool();
        RPluginFormatTableMap::clearInstancePool();
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
        return $withPrefix ? FormatsTableMap::CLASS_DEFAULT : FormatsTableMap::OM_CLASS;
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
     * @return array           (Formats object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = FormatsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = FormatsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + FormatsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = FormatsTableMap::OM_CLASS;
            /** @var Formats $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            FormatsTableMap::addInstanceToPool($obj, $key);
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
            $key = FormatsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = FormatsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Formats $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                FormatsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(FormatsTableMap::COL_ID);
            $criteria->addSelectColumn(FormatsTableMap::COL__NAME);
            $criteria->addSelectColumn(FormatsTableMap::COL__FORBOOK);
            $criteria->addSelectColumn(FormatsTableMap::COL___USER__);
            $criteria->addSelectColumn(FormatsTableMap::COL___CONFIG__);
            $criteria->addSelectColumn(FormatsTableMap::COL___SPLIT__);
            $criteria->addSelectColumn(FormatsTableMap::COL___SORT__);
            $criteria->addSelectColumn(FormatsTableMap::COL___PARENTNODE__);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '._name');
            $criteria->addSelectColumn($alias . '._forbook');
            $criteria->addSelectColumn($alias . '.__user__');
            $criteria->addSelectColumn($alias . '.__config__');
            $criteria->addSelectColumn($alias . '.__split__');
            $criteria->addSelectColumn($alias . '.__sort__');
            $criteria->addSelectColumn($alias . '.__parentnode__');
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
        return Propel::getServiceContainer()->getDatabaseMap(FormatsTableMap::DATABASE_NAME)->getTable(FormatsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(FormatsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(FormatsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new FormatsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Formats or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Formats object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(FormatsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Formats) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(FormatsTableMap::DATABASE_NAME);
            $criteria->add(FormatsTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = FormatsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            FormatsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                FormatsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the _formats table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return FormatsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Formats or Criteria object.
     *
     * @param mixed               $criteria Criteria or Formats object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FormatsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Formats object
        }

        if ($criteria->containsKey(FormatsTableMap::COL_ID) && $criteria->keyContainsValue(FormatsTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.FormatsTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = FormatsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // FormatsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
FormatsTableMap::buildTableMap();
