<?php

namespace Map;

use \Pdf;
use \PdfQuery;
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
 * This class defines the structure of the '_pdf' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PdfTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.PdfTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'rokfor';

    /**
     * The table name for this class
     */
    const TABLE_NAME = '_pdf';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Pdf';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Pdf';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 10;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 10;

    /**
     * the column name for the id field
     */
    const COL_ID = '_pdf.id';

    /**
     * the column name for the _file field
     */
    const COL__FILE = '_pdf._file';

    /**
     * the column name for the _date field
     */
    const COL__DATE = '_pdf._date';

    /**
     * the column name for the _issue field
     */
    const COL__ISSUE = '_pdf._issue';

    /**
     * the column name for the _plugin field
     */
    const COL__PLUGIN = '_pdf._plugin';

    /**
     * the column name for the _fileinfo field
     */
    const COL__FILEINFO = '_pdf._fileinfo';

    /**
     * the column name for the _otc field
     */
    const COL__OTC = '_pdf._otc';

    /**
     * the column name for the _config field
     */
    const COL__CONFIG = '_pdf._config';

    /**
     * the column name for the _configvalue field
     */
    const COL__CONFIGVALUE = '_pdf._configvalue';

    /**
     * the column name for the __sort__ field
     */
    const COL___SORT__ = '_pdf.__sort__';

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
        self::TYPE_PHPNAME       => array('Id', 'File', 'Date', 'Issue', 'Plugin', 'Pages', 'Otc', 'ConfigSys', 'ConfigValue', 'Sort', ),
        self::TYPE_CAMELNAME     => array('id', 'file', 'date', 'issue', 'plugin', 'pages', 'otc', 'configSys', 'configValue', 'sort', ),
        self::TYPE_COLNAME       => array(PdfTableMap::COL_ID, PdfTableMap::COL__FILE, PdfTableMap::COL__DATE, PdfTableMap::COL__ISSUE, PdfTableMap::COL__PLUGIN, PdfTableMap::COL__FILEINFO, PdfTableMap::COL__OTC, PdfTableMap::COL__CONFIG, PdfTableMap::COL__CONFIGVALUE, PdfTableMap::COL___SORT__, ),
        self::TYPE_FIELDNAME     => array('id', '_file', '_date', '_issue', '_plugin', '_fileinfo', '_otc', '_config', '_configvalue', '__sort__', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'File' => 1, 'Date' => 2, 'Issue' => 3, 'Plugin' => 4, 'Pages' => 5, 'Otc' => 6, 'ConfigSys' => 7, 'ConfigValue' => 8, 'Sort' => 9, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'file' => 1, 'date' => 2, 'issue' => 3, 'plugin' => 4, 'pages' => 5, 'otc' => 6, 'configSys' => 7, 'configValue' => 8, 'sort' => 9, ),
        self::TYPE_COLNAME       => array(PdfTableMap::COL_ID => 0, PdfTableMap::COL__FILE => 1, PdfTableMap::COL__DATE => 2, PdfTableMap::COL__ISSUE => 3, PdfTableMap::COL__PLUGIN => 4, PdfTableMap::COL__FILEINFO => 5, PdfTableMap::COL__OTC => 6, PdfTableMap::COL__CONFIG => 7, PdfTableMap::COL__CONFIGVALUE => 8, PdfTableMap::COL___SORT__ => 9, ),
        self::TYPE_FIELDNAME     => array('id' => 0, '_file' => 1, '_date' => 2, '_issue' => 3, '_plugin' => 4, '_fileinfo' => 5, '_otc' => 6, '_config' => 7, '_configvalue' => 8, '__sort__' => 9, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
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
        $this->setName('_pdf');
        $this->setPhpName('Pdf');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Pdf');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 4, null);
        $this->addColumn('_file', 'File', 'LONGVARCHAR', false, null, null);
        $this->addColumn('_date', 'Date', 'INTEGER', false, 40, null);
        $this->addColumn('_issue', 'Issue', 'INTEGER', false, 32, null);
        $this->addForeignKey('_plugin', 'Plugin', 'INTEGER', '_plugins', 'id', false, 32, null);
        $this->addColumn('_fileinfo', 'Pages', 'LONGVARCHAR', false, null, null);
        $this->addColumn('_otc', 'Otc', 'LONGVARCHAR', false, null, null);
        $this->addColumn('_config', 'ConfigSys', 'LONGVARCHAR', false, null, null);
        $this->addColumn('_configvalue', 'ConfigValue', 'INTEGER', false, 32, null);
        $this->addColumn('__sort__', 'Sort', 'INTEGER', false, 32, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Plugins', '\\Plugins', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':_plugin',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
    } // buildRelations()

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
        return $withPrefix ? PdfTableMap::CLASS_DEFAULT : PdfTableMap::OM_CLASS;
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
     * @return array           (Pdf object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PdfTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PdfTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PdfTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PdfTableMap::OM_CLASS;
            /** @var Pdf $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PdfTableMap::addInstanceToPool($obj, $key);
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
            $key = PdfTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PdfTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Pdf $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PdfTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PdfTableMap::COL_ID);
            $criteria->addSelectColumn(PdfTableMap::COL__FILE);
            $criteria->addSelectColumn(PdfTableMap::COL__DATE);
            $criteria->addSelectColumn(PdfTableMap::COL__ISSUE);
            $criteria->addSelectColumn(PdfTableMap::COL__PLUGIN);
            $criteria->addSelectColumn(PdfTableMap::COL__FILEINFO);
            $criteria->addSelectColumn(PdfTableMap::COL__OTC);
            $criteria->addSelectColumn(PdfTableMap::COL__CONFIG);
            $criteria->addSelectColumn(PdfTableMap::COL__CONFIGVALUE);
            $criteria->addSelectColumn(PdfTableMap::COL___SORT__);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '._file');
            $criteria->addSelectColumn($alias . '._date');
            $criteria->addSelectColumn($alias . '._issue');
            $criteria->addSelectColumn($alias . '._plugin');
            $criteria->addSelectColumn($alias . '._fileinfo');
            $criteria->addSelectColumn($alias . '._otc');
            $criteria->addSelectColumn($alias . '._config');
            $criteria->addSelectColumn($alias . '._configvalue');
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
        return Propel::getServiceContainer()->getDatabaseMap(PdfTableMap::DATABASE_NAME)->getTable(PdfTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PdfTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PdfTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PdfTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Pdf or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Pdf object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PdfTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Pdf) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PdfTableMap::DATABASE_NAME);
            $criteria->add(PdfTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PdfQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PdfTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PdfTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the _pdf table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PdfQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Pdf or Criteria object.
     *
     * @param mixed               $criteria Criteria or Pdf object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PdfTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Pdf object
        }

        if ($criteria->containsKey(PdfTableMap::COL_ID) && $criteria->keyContainsValue(PdfTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PdfTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PdfQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PdfTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PdfTableMap::buildTableMap();
