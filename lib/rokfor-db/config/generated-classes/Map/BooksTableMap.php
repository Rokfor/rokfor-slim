<?php

namespace Map;

use \Books;
use \BooksQuery;
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
 * This class defines the structure of the '_books' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class BooksTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.BooksTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'rokfor';

    /**
     * The table name for this class
     */
    const TABLE_NAME = '_books';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Books';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Books';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the id field
     */
    const COL_ID = '_books.id';

    /**
     * the column name for the _name field
     */
    const COL__NAME = '_books._name';

    /**
     * the column name for the __user__ field
     */
    const COL___USER__ = '_books.__user__';

    /**
     * the column name for the __config__ field
     */
    const COL___CONFIG__ = '_books.__config__';

    /**
     * the column name for the __split__ field
     */
    const COL___SPLIT__ = '_books.__split__';

    /**
     * the column name for the __parentnode__ field
     */
    const COL___PARENTNODE__ = '_books.__parentnode__';

    /**
     * the column name for the __sort__ field
     */
    const COL___SORT__ = '_books.__sort__';

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
        self::TYPE_PHPNAME       => array('Id', 'Name', 'UserSys', 'ConfigSys', 'Split', 'Parentnode', 'Sort', ),
        self::TYPE_CAMELNAME     => array('id', 'name', 'userSys', 'configSys', 'split', 'parentnode', 'sort', ),
        self::TYPE_COLNAME       => array(BooksTableMap::COL_ID, BooksTableMap::COL__NAME, BooksTableMap::COL___USER__, BooksTableMap::COL___CONFIG__, BooksTableMap::COL___SPLIT__, BooksTableMap::COL___PARENTNODE__, BooksTableMap::COL___SORT__, ),
        self::TYPE_FIELDNAME     => array('id', '_name', '__user__', '__config__', '__split__', '__parentnode__', '__sort__', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'UserSys' => 2, 'ConfigSys' => 3, 'Split' => 4, 'Parentnode' => 5, 'Sort' => 6, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'name' => 1, 'userSys' => 2, 'configSys' => 3, 'split' => 4, 'parentnode' => 5, 'sort' => 6, ),
        self::TYPE_COLNAME       => array(BooksTableMap::COL_ID => 0, BooksTableMap::COL__NAME => 1, BooksTableMap::COL___USER__ => 2, BooksTableMap::COL___CONFIG__ => 3, BooksTableMap::COL___SPLIT__ => 4, BooksTableMap::COL___PARENTNODE__ => 5, BooksTableMap::COL___SORT__ => 6, ),
        self::TYPE_FIELDNAME     => array('id' => 0, '_name' => 1, '__user__' => 2, '__config__' => 3, '__split__' => 4, '__parentnode__' => 5, '__sort__' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
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
        $this->setName('_books');
        $this->setPhpName('Books');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Books');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 4, null);
        $this->addColumn('_name', 'Name', 'LONGVARCHAR', false, null, null);
        $this->addForeignKey('__user__', 'UserSys', 'INTEGER', 'users', 'id', false, 4, null);
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
        $this->addRelation('userSysRef', '\\Users', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':__user__',
    1 => ':id',
  ),
), 'SET NULL', 'SET NULL', null, false);
        $this->addRelation('RBatchForbook', '\\RBatchForbook', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':_bookid',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'RBatchForbooks', false);
        $this->addRelation('RRightsForbook', '\\RRightsForbook', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':_bookid',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'RRightsForbooks', false);
        $this->addRelation('RTemplatenamesForbook', '\\RTemplatenamesForbook', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':_bookid',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'RTemplatenamesForbooks', false);
        $this->addRelation('RDataBook', '\\RDataBook', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':_bookid',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'RDataBooks', false);
        $this->addRelation('RPluginBook', '\\RPluginBook', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':_bookid',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'RPluginBooks', false);
        $this->addRelation('Formats', '\\Formats', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':_forbook',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'Formatss', false);
        $this->addRelation('Issues', '\\Issues', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':_forbook',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'Issuess', false);
        $this->addRelation('Batch', '\\Batch', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'Batches');
        $this->addRelation('Rights', '\\Rights', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'Rightss');
        $this->addRelation('Templatenames', '\\Templatenames', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'Templatenamess');
        $this->addRelation('RData', '\\Data', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'RDatas');
        $this->addRelation('RPlugin', '\\Plugins', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'RPlugins');
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to _books     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        RBatchForbookTableMap::clearInstancePool();
        RRightsForbookTableMap::clearInstancePool();
        RTemplatenamesForbookTableMap::clearInstancePool();
        RDataBookTableMap::clearInstancePool();
        RPluginBookTableMap::clearInstancePool();
        FormatsTableMap::clearInstancePool();
        IssuesTableMap::clearInstancePool();
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
        return $withPrefix ? BooksTableMap::CLASS_DEFAULT : BooksTableMap::OM_CLASS;
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
     * @return array           (Books object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = BooksTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = BooksTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + BooksTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = BooksTableMap::OM_CLASS;
            /** @var Books $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            BooksTableMap::addInstanceToPool($obj, $key);
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
            $key = BooksTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = BooksTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Books $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                BooksTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(BooksTableMap::COL_ID);
            $criteria->addSelectColumn(BooksTableMap::COL__NAME);
            $criteria->addSelectColumn(BooksTableMap::COL___USER__);
            $criteria->addSelectColumn(BooksTableMap::COL___CONFIG__);
            $criteria->addSelectColumn(BooksTableMap::COL___SPLIT__);
            $criteria->addSelectColumn(BooksTableMap::COL___PARENTNODE__);
            $criteria->addSelectColumn(BooksTableMap::COL___SORT__);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '._name');
            $criteria->addSelectColumn($alias . '.__user__');
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
        return Propel::getServiceContainer()->getDatabaseMap(BooksTableMap::DATABASE_NAME)->getTable(BooksTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(BooksTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(BooksTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new BooksTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Books or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Books object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(BooksTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Books) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(BooksTableMap::DATABASE_NAME);
            $criteria->add(BooksTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = BooksQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            BooksTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                BooksTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the _books table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return BooksQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Books or Criteria object.
     *
     * @param mixed               $criteria Criteria or Books object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(BooksTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Books object
        }

        if ($criteria->containsKey(BooksTableMap::COL_ID) && $criteria->keyContainsValue(BooksTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.BooksTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = BooksQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // BooksTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BooksTableMap::buildTableMap();
