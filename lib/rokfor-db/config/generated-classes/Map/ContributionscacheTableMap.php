<?php

namespace Map;

use \Contributionscache;
use \ContributionscacheQuery;
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
 * This class defines the structure of the '_contributions_cache' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ContributionscacheTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.ContributionscacheTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'rokfor';

    /**
     * The table name for this class
     */
    const TABLE_NAME = '_contributions_cache';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Contributionscache';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Contributionscache';

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
    const COL_ID = '_contributions_cache.id';

    /**
     * the column name for the _signature field
     */
    const COL__SIGNATURE = '_contributions_cache._signature';

    /**
     * the column name for the _forcontribution field
     */
    const COL__FORCONTRIBUTION = '_contributions_cache._forcontribution';

    /**
     * the column name for the _cache field
     */
    const COL__CACHE = '_contributions_cache._cache';

    /**
     * the column name for the _book field
     */
    const COL__BOOK = '_contributions_cache._book';

    /**
     * the column name for the _issue field
     */
    const COL__ISSUE = '_contributions_cache._issue';

    /**
     * the column name for the _chapter field
     */
    const COL__CHAPTER = '_contributions_cache._chapter';

    /**
     * the column name for the _template field
     */
    const COL__TEMPLATE = '_contributions_cache._template';

    /**
     * the column name for the _contribution field
     */
    const COL__CONTRIBUTION = '_contributions_cache._contribution';

    /**
     * the column name for the _touched field
     */
    const COL__TOUCHED = '_contributions_cache._touched';

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
        self::TYPE_PHPNAME       => array('Id', 'Signature', 'Forcontribution', 'Cache', 'Book', 'Issue', 'Chapter', 'Template', 'Contribution', 'Touched', ),
        self::TYPE_CAMELNAME     => array('id', 'signature', 'forcontribution', 'cache', 'book', 'issue', 'chapter', 'template', 'contribution', 'touched', ),
        self::TYPE_COLNAME       => array(ContributionscacheTableMap::COL_ID, ContributionscacheTableMap::COL__SIGNATURE, ContributionscacheTableMap::COL__FORCONTRIBUTION, ContributionscacheTableMap::COL__CACHE, ContributionscacheTableMap::COL__BOOK, ContributionscacheTableMap::COL__ISSUE, ContributionscacheTableMap::COL__CHAPTER, ContributionscacheTableMap::COL__TEMPLATE, ContributionscacheTableMap::COL__CONTRIBUTION, ContributionscacheTableMap::COL__TOUCHED, ),
        self::TYPE_FIELDNAME     => array('id', '_signature', '_forcontribution', '_cache', '_book', '_issue', '_chapter', '_template', '_contribution', '_touched', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Signature' => 1, 'Forcontribution' => 2, 'Cache' => 3, 'Book' => 4, 'Issue' => 5, 'Chapter' => 6, 'Template' => 7, 'Contribution' => 8, 'Touched' => 9, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'signature' => 1, 'forcontribution' => 2, 'cache' => 3, 'book' => 4, 'issue' => 5, 'chapter' => 6, 'template' => 7, 'contribution' => 8, 'touched' => 9, ),
        self::TYPE_COLNAME       => array(ContributionscacheTableMap::COL_ID => 0, ContributionscacheTableMap::COL__SIGNATURE => 1, ContributionscacheTableMap::COL__FORCONTRIBUTION => 2, ContributionscacheTableMap::COL__CACHE => 3, ContributionscacheTableMap::COL__BOOK => 4, ContributionscacheTableMap::COL__ISSUE => 5, ContributionscacheTableMap::COL__CHAPTER => 6, ContributionscacheTableMap::COL__TEMPLATE => 7, ContributionscacheTableMap::COL__CONTRIBUTION => 8, ContributionscacheTableMap::COL__TOUCHED => 9, ),
        self::TYPE_FIELDNAME     => array('id' => 0, '_signature' => 1, '_forcontribution' => 2, '_cache' => 3, '_book' => 4, '_issue' => 5, '_chapter' => 6, '_template' => 7, '_contribution' => 8, '_touched' => 9, ),
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
        $this->setName('_contributions_cache');
        $this->setPhpName('Contributionscache');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Contributionscache');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 4, null);
        $this->addColumn('_signature', 'Signature', 'VARCHAR', true, 255, null);
        $this->addForeignKey('_forcontribution', 'Forcontribution', 'INTEGER', '_contributions', 'id', false, 4, null);
        $this->addColumn('_cache', 'Cache', 'CLOB', false, null, null);
        $this->addColumn('_book', 'Book', 'VARCHAR', false, 255, null);
        $this->addColumn('_issue', 'Issue', 'VARCHAR', false, 255, null);
        $this->addColumn('_chapter', 'Chapter', 'VARCHAR', false, 255, null);
        $this->addColumn('_template', 'Template', 'VARCHAR', false, 255, null);
        $this->addColumn('_contribution', 'Contribution', 'VARCHAR', false, 255, null);
        $this->addColumn('_touched', 'Touched', 'TIMESTAMP', false, null, 'CURRENT_TIMESTAMP');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Contributions', '\\Contributions', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':_forcontribution',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
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
            'data_cache' => array('backend' => 'redis', 'lifetime' => '0', 'auto_cache' => 'true', ),
        );
    } // getBehaviors()

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
        return $withPrefix ? ContributionscacheTableMap::CLASS_DEFAULT : ContributionscacheTableMap::OM_CLASS;
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
     * @return array           (Contributionscache object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ContributionscacheTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ContributionscacheTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ContributionscacheTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ContributionscacheTableMap::OM_CLASS;
            /** @var Contributionscache $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ContributionscacheTableMap::addInstanceToPool($obj, $key);
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
            $key = ContributionscacheTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ContributionscacheTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Contributionscache $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ContributionscacheTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ContributionscacheTableMap::COL_ID);
            $criteria->addSelectColumn(ContributionscacheTableMap::COL__SIGNATURE);
            $criteria->addSelectColumn(ContributionscacheTableMap::COL__FORCONTRIBUTION);
            $criteria->addSelectColumn(ContributionscacheTableMap::COL__CACHE);
            $criteria->addSelectColumn(ContributionscacheTableMap::COL__BOOK);
            $criteria->addSelectColumn(ContributionscacheTableMap::COL__ISSUE);
            $criteria->addSelectColumn(ContributionscacheTableMap::COL__CHAPTER);
            $criteria->addSelectColumn(ContributionscacheTableMap::COL__TEMPLATE);
            $criteria->addSelectColumn(ContributionscacheTableMap::COL__CONTRIBUTION);
            $criteria->addSelectColumn(ContributionscacheTableMap::COL__TOUCHED);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '._signature');
            $criteria->addSelectColumn($alias . '._forcontribution');
            $criteria->addSelectColumn($alias . '._cache');
            $criteria->addSelectColumn($alias . '._book');
            $criteria->addSelectColumn($alias . '._issue');
            $criteria->addSelectColumn($alias . '._chapter');
            $criteria->addSelectColumn($alias . '._template');
            $criteria->addSelectColumn($alias . '._contribution');
            $criteria->addSelectColumn($alias . '._touched');
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
        return Propel::getServiceContainer()->getDatabaseMap(ContributionscacheTableMap::DATABASE_NAME)->getTable(ContributionscacheTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ContributionscacheTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ContributionscacheTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ContributionscacheTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Contributionscache or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Contributionscache object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ContributionscacheTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Contributionscache) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ContributionscacheTableMap::DATABASE_NAME);
            $criteria->add(ContributionscacheTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = ContributionscacheQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ContributionscacheTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ContributionscacheTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the _contributions_cache table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ContributionscacheQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Contributionscache or Criteria object.
     *
     * @param mixed               $criteria Criteria or Contributionscache object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ContributionscacheTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Contributionscache object
        }

        if ($criteria->containsKey(ContributionscacheTableMap::COL_ID) && $criteria->keyContainsValue(ContributionscacheTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ContributionscacheTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = ContributionscacheQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ContributionscacheTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ContributionscacheTableMap::buildTableMap();
