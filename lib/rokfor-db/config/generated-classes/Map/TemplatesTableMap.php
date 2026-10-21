<?php

namespace Map;

use \Templates;
use \TemplatesQuery;
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
 * This class defines the structure of the '_templates' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class TemplatesTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.TemplatesTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'rokfor';

    /**
     * The table name for this class
     */
    const TABLE_NAME = '_templates';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Templates';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Templates';

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
    const COL_ID = '_templates.id';

    /**
     * the column name for the _fortemplate field
     */
    const COL__FORTEMPLATE = '_templates._fortemplate';

    /**
     * the column name for the _fieldname field
     */
    const COL__FIELDNAME = '_templates._fieldname';

    /**
     * the column name for the _helpdescription field
     */
    const COL__HELPDESCRIPTION = '_templates._helpdescription';

    /**
     * the column name for the _helpimage field
     */
    const COL__HELPIMAGE = '_templates._helpimage';

    /**
     * the column name for the _fieldtype field
     */
    const COL__FIELDTYPE = '_templates._fieldtype';

    /**
     * the column name for the __config__ field
     */
    const COL___CONFIG__ = '_templates.__config__';

    /**
     * the column name for the __split__ field
     */
    const COL___SPLIT__ = '_templates.__split__';

    /**
     * the column name for the __parentnode__ field
     */
    const COL___PARENTNODE__ = '_templates.__parentnode__';

    /**
     * the column name for the __sort__ field
     */
    const COL___SORT__ = '_templates.__sort__';

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
        self::TYPE_PHPNAME       => array('Id', 'Fortemplate', 'Fieldname', 'Helpdescription', 'Helpimage', 'Fieldtype', 'ConfigSys', 'Split', 'Parentnode', 'Sort', ),
        self::TYPE_CAMELNAME     => array('id', 'fortemplate', 'fieldname', 'helpdescription', 'helpimage', 'fieldtype', 'configSys', 'split', 'parentnode', 'sort', ),
        self::TYPE_COLNAME       => array(TemplatesTableMap::COL_ID, TemplatesTableMap::COL__FORTEMPLATE, TemplatesTableMap::COL__FIELDNAME, TemplatesTableMap::COL__HELPDESCRIPTION, TemplatesTableMap::COL__HELPIMAGE, TemplatesTableMap::COL__FIELDTYPE, TemplatesTableMap::COL___CONFIG__, TemplatesTableMap::COL___SPLIT__, TemplatesTableMap::COL___PARENTNODE__, TemplatesTableMap::COL___SORT__, ),
        self::TYPE_FIELDNAME     => array('id', '_fortemplate', '_fieldname', '_helpdescription', '_helpimage', '_fieldtype', '__config__', '__split__', '__parentnode__', '__sort__', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Fortemplate' => 1, 'Fieldname' => 2, 'Helpdescription' => 3, 'Helpimage' => 4, 'Fieldtype' => 5, 'ConfigSys' => 6, 'Split' => 7, 'Parentnode' => 8, 'Sort' => 9, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'fortemplate' => 1, 'fieldname' => 2, 'helpdescription' => 3, 'helpimage' => 4, 'fieldtype' => 5, 'configSys' => 6, 'split' => 7, 'parentnode' => 8, 'sort' => 9, ),
        self::TYPE_COLNAME       => array(TemplatesTableMap::COL_ID => 0, TemplatesTableMap::COL__FORTEMPLATE => 1, TemplatesTableMap::COL__FIELDNAME => 2, TemplatesTableMap::COL__HELPDESCRIPTION => 3, TemplatesTableMap::COL__HELPIMAGE => 4, TemplatesTableMap::COL__FIELDTYPE => 5, TemplatesTableMap::COL___CONFIG__ => 6, TemplatesTableMap::COL___SPLIT__ => 7, TemplatesTableMap::COL___PARENTNODE__ => 8, TemplatesTableMap::COL___SORT__ => 9, ),
        self::TYPE_FIELDNAME     => array('id' => 0, '_fortemplate' => 1, '_fieldname' => 2, '_helpdescription' => 3, '_helpimage' => 4, '_fieldtype' => 5, '__config__' => 6, '__split__' => 7, '__parentnode__' => 8, '__sort__' => 9, ),
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
        $this->setName('_templates');
        $this->setPhpName('Templates');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Templates');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, 4, null);
        $this->addForeignKey('_fortemplate', 'Fortemplate', 'INTEGER', '_templatenames', 'id', false, 32, null);
        $this->addColumn('_fieldname', 'Fieldname', 'LONGVARCHAR', false, null, null);
        $this->addColumn('_helpdescription', 'Helpdescription', 'LONGVARCHAR', false, null, null);
        $this->addColumn('_helpimage', 'Helpimage', 'LONGVARCHAR', false, null, null);
        $this->addColumn('_fieldtype', 'Fieldtype', 'LONGVARCHAR', false, null, null);
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
        $this->addRelation('Templatenames', '\\Templatenames', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':_fortemplate',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('RFieldpostprocessorForfield', '\\RFieldpostprocessorForfield', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':_templateid',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'RFieldpostprocessorForfields', false);
        $this->addRelation('Data', '\\Data', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':_fortemplatefield',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'Datas', false);
        $this->addRelation('RDataTemplate', '\\RDataTemplate', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':_templateid',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'RDataTemplates', false);
        $this->addRelation('Fieldpostprocessor', '\\Fieldpostprocessor', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'Fieldpostprocessors');
        $this->addRelation('RData', '\\Data', RelationMap::MANY_TO_MANY, array(), 'CASCADE', 'CASCADE', 'RDatas');
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to _templates     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        RFieldpostprocessorForfieldTableMap::clearInstancePool();
        DataTableMap::clearInstancePool();
        RDataTemplateTableMap::clearInstancePool();
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
        return $withPrefix ? TemplatesTableMap::CLASS_DEFAULT : TemplatesTableMap::OM_CLASS;
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
     * @return array           (Templates object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = TemplatesTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = TemplatesTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + TemplatesTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TemplatesTableMap::OM_CLASS;
            /** @var Templates $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            TemplatesTableMap::addInstanceToPool($obj, $key);
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
            $key = TemplatesTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = TemplatesTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Templates $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TemplatesTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(TemplatesTableMap::COL_ID);
            $criteria->addSelectColumn(TemplatesTableMap::COL__FORTEMPLATE);
            $criteria->addSelectColumn(TemplatesTableMap::COL__FIELDNAME);
            $criteria->addSelectColumn(TemplatesTableMap::COL__HELPDESCRIPTION);
            $criteria->addSelectColumn(TemplatesTableMap::COL__HELPIMAGE);
            $criteria->addSelectColumn(TemplatesTableMap::COL__FIELDTYPE);
            $criteria->addSelectColumn(TemplatesTableMap::COL___CONFIG__);
            $criteria->addSelectColumn(TemplatesTableMap::COL___SPLIT__);
            $criteria->addSelectColumn(TemplatesTableMap::COL___PARENTNODE__);
            $criteria->addSelectColumn(TemplatesTableMap::COL___SORT__);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '._fortemplate');
            $criteria->addSelectColumn($alias . '._fieldname');
            $criteria->addSelectColumn($alias . '._helpdescription');
            $criteria->addSelectColumn($alias . '._helpimage');
            $criteria->addSelectColumn($alias . '._fieldtype');
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
        return Propel::getServiceContainer()->getDatabaseMap(TemplatesTableMap::DATABASE_NAME)->getTable(TemplatesTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(TemplatesTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(TemplatesTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new TemplatesTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Templates or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Templates object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(TemplatesTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Templates) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TemplatesTableMap::DATABASE_NAME);
            $criteria->add(TemplatesTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = TemplatesQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            TemplatesTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                TemplatesTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the _templates table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return TemplatesQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Templates or Criteria object.
     *
     * @param mixed               $criteria Criteria or Templates object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TemplatesTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Templates object
        }

        if ($criteria->containsKey(TemplatesTableMap::COL_ID) && $criteria->keyContainsValue(TemplatesTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.TemplatesTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = TemplatesQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // TemplatesTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
TemplatesTableMap::buildTableMap();
