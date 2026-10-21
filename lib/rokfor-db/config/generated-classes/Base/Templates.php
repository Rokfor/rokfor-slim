<?php

namespace Base;

use \Data as ChildData;
use \DataQuery as ChildDataQuery;
use \Fieldpostprocessor as ChildFieldpostprocessor;
use \FieldpostprocessorQuery as ChildFieldpostprocessorQuery;
use \RDataTemplate as ChildRDataTemplate;
use \RDataTemplateQuery as ChildRDataTemplateQuery;
use \RFieldpostprocessorForfield as ChildRFieldpostprocessorForfield;
use \RFieldpostprocessorForfieldQuery as ChildRFieldpostprocessorForfieldQuery;
use \Templatenames as ChildTemplatenames;
use \TemplatenamesQuery as ChildTemplatenamesQuery;
use \Templates as ChildTemplates;
use \TemplatesQuery as ChildTemplatesQuery;
use \Exception;
use \PDO;
use Map\DataTableMap;
use Map\RDataTemplateTableMap;
use Map\RFieldpostprocessorForfieldTableMap;
use Map\TemplatesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the '_templates' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Templates implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\TemplatesTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the _fortemplate field.
     *
     * @var        int
     */
    protected $_fortemplate;

    /**
     * The value for the _fieldname field.
     *
     * @var        string
     */
    protected $_fieldname;

    /**
     * The value for the _helpdescription field.
     *
     * @var        string
     */
    protected $_helpdescription;

    /**
     * The value for the _helpimage field.
     *
     * @var        string
     */
    protected $_helpimage;

    /**
     * The value for the _fieldtype field.
     *
     * @var        string
     */
    protected $_fieldtype;

    /**
     * The value for the __config__ field.
     *
     * @var        string
     */
    protected $__config__;

    /**
     * The value for the __split__ field.
     *
     * @var        string
     */
    protected $__split__;

    /**
     * The value for the __parentnode__ field.
     *
     * @var        int
     */
    protected $__parentnode__;

    /**
     * The value for the __sort__ field.
     *
     * @var        int
     */
    protected $__sort__;

    /**
     * @var        ChildTemplatenames
     */
    protected $aTemplatenames;

    /**
     * @var        ObjectCollection|ChildRFieldpostprocessorForfield[] Collection to store aggregation of ChildRFieldpostprocessorForfield objects.
     */
    protected $collRFieldpostprocessorForfields;
    protected $collRFieldpostprocessorForfieldsPartial;

    /**
     * @var        ObjectCollection|ChildData[] Collection to store aggregation of ChildData objects.
     */
    protected $collDatas;
    protected $collDatasPartial;

    /**
     * @var        ObjectCollection|ChildRDataTemplate[] Collection to store aggregation of ChildRDataTemplate objects.
     */
    protected $collRDataTemplates;
    protected $collRDataTemplatesPartial;

    /**
     * @var        ObjectCollection|ChildFieldpostprocessor[] Cross Collection to store aggregation of ChildFieldpostprocessor objects.
     */
    protected $collFieldpostprocessors;

    /**
     * @var bool
     */
    protected $collFieldpostprocessorsPartial;

    /**
     * @var        ObjectCollection|ChildData[] Cross Collection to store aggregation of ChildData objects.
     */
    protected $collRDatas;

    /**
     * @var bool
     */
    protected $collRDatasPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildFieldpostprocessor[]
     */
    protected $fieldpostprocessorsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildData[]
     */
    protected $rDatasScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRFieldpostprocessorForfield[]
     */
    protected $rFieldpostprocessorForfieldsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildData[]
     */
    protected $datasScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRDataTemplate[]
     */
    protected $rDataTemplatesScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Templates object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Templates</code> instance.  If
     * <code>obj</code> is an instance of <code>Templates</code>, delegates to
     * <code>equals(Templates)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Templates The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [_fortemplate] column value.
     *
     * @return int
     */
    public function getFortemplate()
    {
        return $this->_fortemplate;
    }

    /**
     * Get the [_fieldname] column value.
     *
     * @return string
     */
    public function getFieldname()
    {
        return $this->_fieldname;
    }

    /**
     * Get the [_helpdescription] column value.
     *
     * @return string
     */
    public function getHelpdescription()
    {
        return $this->_helpdescription;
    }

    /**
     * Get the [_helpimage] column value.
     *
     * @return string
     */
    public function getHelpimage()
    {
        return $this->_helpimage;
    }

    /**
     * Get the [_fieldtype] column value.
     *
     * @return string
     */
    public function getFieldtype()
    {
        return $this->_fieldtype;
    }

    /**
     * Get the [__config__] column value.
     *
     * @return string
     */
    public function getConfigSys()
    {
        return $this->__config__;
    }

    /**
     * Get the [__split__] column value.
     *
     * @return string
     */
    public function getSplit()
    {
        return $this->__split__;
    }

    /**
     * Get the [__parentnode__] column value.
     *
     * @return int
     */
    public function getParentnode()
    {
        return $this->__parentnode__;
    }

    /**
     * Get the [__sort__] column value.
     *
     * @return int
     */
    public function getSort()
    {
        return $this->__sort__;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Templates The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[TemplatesTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [_fortemplate] column.
     *
     * @param int $v new value
     * @return $this|\Templates The current object (for fluent API support)
     */
    public function setFortemplate($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->_fortemplate !== $v) {
            $this->_fortemplate = $v;
            $this->modifiedColumns[TemplatesTableMap::COL__FORTEMPLATE] = true;
        }

        if ($this->aTemplatenames !== null && $this->aTemplatenames->getId() !== $v) {
            $this->aTemplatenames = null;
        }

        return $this;
    } // setFortemplate()

    /**
     * Set the value of [_fieldname] column.
     *
     * @param string $v new value
     * @return $this|\Templates The current object (for fluent API support)
     */
    public function setFieldname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_fieldname !== $v) {
            $this->_fieldname = $v;
            $this->modifiedColumns[TemplatesTableMap::COL__FIELDNAME] = true;
        }

        return $this;
    } // setFieldname()

    /**
     * Set the value of [_helpdescription] column.
     *
     * @param string $v new value
     * @return $this|\Templates The current object (for fluent API support)
     */
    public function setHelpdescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_helpdescription !== $v) {
            $this->_helpdescription = $v;
            $this->modifiedColumns[TemplatesTableMap::COL__HELPDESCRIPTION] = true;
        }

        return $this;
    } // setHelpdescription()

    /**
     * Set the value of [_helpimage] column.
     *
     * @param string $v new value
     * @return $this|\Templates The current object (for fluent API support)
     */
    public function setHelpimage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_helpimage !== $v) {
            $this->_helpimage = $v;
            $this->modifiedColumns[TemplatesTableMap::COL__HELPIMAGE] = true;
        }

        return $this;
    } // setHelpimage()

    /**
     * Set the value of [_fieldtype] column.
     *
     * @param string $v new value
     * @return $this|\Templates The current object (for fluent API support)
     */
    public function setFieldtype($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_fieldtype !== $v) {
            $this->_fieldtype = $v;
            $this->modifiedColumns[TemplatesTableMap::COL__FIELDTYPE] = true;
        }

        return $this;
    } // setFieldtype()

    /**
     * Set the value of [__config__] column.
     *
     * @param string $v new value
     * @return $this|\Templates The current object (for fluent API support)
     */
    public function setConfigSys($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->__config__ !== $v) {
            $this->__config__ = $v;
            $this->modifiedColumns[TemplatesTableMap::COL___CONFIG__] = true;
        }

        return $this;
    } // setConfigSys()

    /**
     * Set the value of [__split__] column.
     *
     * @param string $v new value
     * @return $this|\Templates The current object (for fluent API support)
     */
    public function setSplit($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->__split__ !== $v) {
            $this->__split__ = $v;
            $this->modifiedColumns[TemplatesTableMap::COL___SPLIT__] = true;
        }

        return $this;
    } // setSplit()

    /**
     * Set the value of [__parentnode__] column.
     *
     * @param int $v new value
     * @return $this|\Templates The current object (for fluent API support)
     */
    public function setParentnode($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__parentnode__ !== $v) {
            $this->__parentnode__ = $v;
            $this->modifiedColumns[TemplatesTableMap::COL___PARENTNODE__] = true;
        }

        return $this;
    } // setParentnode()

    /**
     * Set the value of [__sort__] column.
     *
     * @param int $v new value
     * @return $this|\Templates The current object (for fluent API support)
     */
    public function setSort($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__sort__ !== $v) {
            $this->__sort__ = $v;
            $this->modifiedColumns[TemplatesTableMap::COL___SORT__] = true;
        }

        return $this;
    } // setSort()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : TemplatesTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : TemplatesTableMap::translateFieldName('Fortemplate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_fortemplate = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : TemplatesTableMap::translateFieldName('Fieldname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_fieldname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : TemplatesTableMap::translateFieldName('Helpdescription', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_helpdescription = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : TemplatesTableMap::translateFieldName('Helpimage', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_helpimage = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : TemplatesTableMap::translateFieldName('Fieldtype', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_fieldtype = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : TemplatesTableMap::translateFieldName('ConfigSys', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__config__ = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : TemplatesTableMap::translateFieldName('Split', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__split__ = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : TemplatesTableMap::translateFieldName('Parentnode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__parentnode__ = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : TemplatesTableMap::translateFieldName('Sort', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__sort__ = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = TemplatesTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Templates'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aTemplatenames !== null && $this->_fortemplate !== $this->aTemplatenames->getId()) {
            $this->aTemplatenames = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TemplatesTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildTemplatesQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aTemplatenames = null;
            $this->collRFieldpostprocessorForfields = null;

            $this->collDatas = null;

            $this->collRDataTemplates = null;

            $this->collFieldpostprocessors = null;
            $this->collRDatas = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Templates::setDeleted()
     * @see Templates::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TemplatesTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildTemplatesQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TemplatesTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                TemplatesTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aTemplatenames !== null) {
                if ($this->aTemplatenames->isModified() || $this->aTemplatenames->isNew()) {
                    $affectedRows += $this->aTemplatenames->save($con);
                }
                $this->setTemplatenames($this->aTemplatenames);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->fieldpostprocessorsScheduledForDeletion !== null) {
                if (!$this->fieldpostprocessorsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->fieldpostprocessorsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RFieldpostprocessorForfieldQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->fieldpostprocessorsScheduledForDeletion = null;
                }

            }

            if ($this->collFieldpostprocessors) {
                foreach ($this->collFieldpostprocessors as $fieldpostprocessor) {
                    if (!$fieldpostprocessor->isDeleted() && ($fieldpostprocessor->isNew() || $fieldpostprocessor->isModified())) {
                        $fieldpostprocessor->save($con);
                    }
                }
            }


            if ($this->rDatasScheduledForDeletion !== null) {
                if (!$this->rDatasScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->rDatasScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RDataTemplateQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->rDatasScheduledForDeletion = null;
                }

            }

            if ($this->collRDatas) {
                foreach ($this->collRDatas as $rData) {
                    if (!$rData->isDeleted() && ($rData->isNew() || $rData->isModified())) {
                        $rData->save($con);
                    }
                }
            }


            if ($this->rFieldpostprocessorForfieldsScheduledForDeletion !== null) {
                if (!$this->rFieldpostprocessorForfieldsScheduledForDeletion->isEmpty()) {
                    \RFieldpostprocessorForfieldQuery::create()
                        ->filterByPrimaryKeys($this->rFieldpostprocessorForfieldsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rFieldpostprocessorForfieldsScheduledForDeletion = null;
                }
            }

            if ($this->collRFieldpostprocessorForfields !== null) {
                foreach ($this->collRFieldpostprocessorForfields as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->datasScheduledForDeletion !== null) {
                if (!$this->datasScheduledForDeletion->isEmpty()) {
                    \DataQuery::create()
                        ->filterByPrimaryKeys($this->datasScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->datasScheduledForDeletion = null;
                }
            }

            if ($this->collDatas !== null) {
                foreach ($this->collDatas as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->rDataTemplatesScheduledForDeletion !== null) {
                if (!$this->rDataTemplatesScheduledForDeletion->isEmpty()) {
                    \RDataTemplateQuery::create()
                        ->filterByPrimaryKeys($this->rDataTemplatesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rDataTemplatesScheduledForDeletion = null;
                }
            }

            if ($this->collRDataTemplates !== null) {
                foreach ($this->collRDataTemplates as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[TemplatesTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TemplatesTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TemplatesTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(TemplatesTableMap::COL__FORTEMPLATE)) {
            $modifiedColumns[':p' . $index++]  = '_fortemplate';
        }
        if ($this->isColumnModified(TemplatesTableMap::COL__FIELDNAME)) {
            $modifiedColumns[':p' . $index++]  = '_fieldname';
        }
        if ($this->isColumnModified(TemplatesTableMap::COL__HELPDESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '_helpdescription';
        }
        if ($this->isColumnModified(TemplatesTableMap::COL__HELPIMAGE)) {
            $modifiedColumns[':p' . $index++]  = '_helpimage';
        }
        if ($this->isColumnModified(TemplatesTableMap::COL__FIELDTYPE)) {
            $modifiedColumns[':p' . $index++]  = '_fieldtype';
        }
        if ($this->isColumnModified(TemplatesTableMap::COL___CONFIG__)) {
            $modifiedColumns[':p' . $index++]  = '__config__';
        }
        if ($this->isColumnModified(TemplatesTableMap::COL___SPLIT__)) {
            $modifiedColumns[':p' . $index++]  = '__split__';
        }
        if ($this->isColumnModified(TemplatesTableMap::COL___PARENTNODE__)) {
            $modifiedColumns[':p' . $index++]  = '__parentnode__';
        }
        if ($this->isColumnModified(TemplatesTableMap::COL___SORT__)) {
            $modifiedColumns[':p' . $index++]  = '__sort__';
        }

        $sql = sprintf(
            'INSERT INTO _templates (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '_fortemplate':
                        $stmt->bindValue($identifier, $this->_fortemplate, PDO::PARAM_INT);
                        break;
                    case '_fieldname':
                        $stmt->bindValue($identifier, $this->_fieldname, PDO::PARAM_STR);
                        break;
                    case '_helpdescription':
                        $stmt->bindValue($identifier, $this->_helpdescription, PDO::PARAM_STR);
                        break;
                    case '_helpimage':
                        $stmt->bindValue($identifier, $this->_helpimage, PDO::PARAM_STR);
                        break;
                    case '_fieldtype':
                        $stmt->bindValue($identifier, $this->_fieldtype, PDO::PARAM_STR);
                        break;
                    case '__config__':
                        $stmt->bindValue($identifier, $this->__config__, PDO::PARAM_STR);
                        break;
                    case '__split__':
                        $stmt->bindValue($identifier, $this->__split__, PDO::PARAM_STR);
                        break;
                    case '__parentnode__':
                        $stmt->bindValue($identifier, $this->__parentnode__, PDO::PARAM_INT);
                        break;
                    case '__sort__':
                        $stmt->bindValue($identifier, $this->__sort__, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TemplatesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getFortemplate();
                break;
            case 2:
                return $this->getFieldname();
                break;
            case 3:
                return $this->getHelpdescription();
                break;
            case 4:
                return $this->getHelpimage();
                break;
            case 5:
                return $this->getFieldtype();
                break;
            case 6:
                return $this->getConfigSys();
                break;
            case 7:
                return $this->getSplit();
                break;
            case 8:
                return $this->getParentnode();
                break;
            case 9:
                return $this->getSort();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Templates'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Templates'][$this->hashCode()] = true;
        $keys = TemplatesTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getFortemplate(),
            $keys[2] => $this->getFieldname(),
            $keys[3] => $this->getHelpdescription(),
            $keys[4] => $this->getHelpimage(),
            $keys[5] => $this->getFieldtype(),
            $keys[6] => $this->getConfigSys(),
            $keys[7] => $this->getSplit(),
            $keys[8] => $this->getParentnode(),
            $keys[9] => $this->getSort(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aTemplatenames) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'templatenames';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = '_templatenames';
                        break;
                    default:
                        $key = 'Templatenames';
                }

                $result[$key] = $this->aTemplatenames->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collRFieldpostprocessorForfields) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rFieldpostprocessorForfields';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_fieldpostprocessor_forfields';
                        break;
                    default:
                        $key = 'RFieldpostprocessorForfields';
                }

                $result[$key] = $this->collRFieldpostprocessorForfields->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collDatas) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'datas';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = '_datas';
                        break;
                    default:
                        $key = 'Datas';
                }

                $result[$key] = $this->collDatas->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRDataTemplates) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rDataTemplates';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_data_templates';
                        break;
                    default:
                        $key = 'RDataTemplates';
                }

                $result[$key] = $this->collRDataTemplates->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Templates
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TemplatesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Templates
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setFortemplate($value);
                break;
            case 2:
                $this->setFieldname($value);
                break;
            case 3:
                $this->setHelpdescription($value);
                break;
            case 4:
                $this->setHelpimage($value);
                break;
            case 5:
                $this->setFieldtype($value);
                break;
            case 6:
                $this->setConfigSys($value);
                break;
            case 7:
                $this->setSplit($value);
                break;
            case 8:
                $this->setParentnode($value);
                break;
            case 9:
                $this->setSort($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = TemplatesTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setFortemplate($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setFieldname($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setHelpdescription($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setHelpimage($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setFieldtype($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setConfigSys($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setSplit($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setParentnode($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setSort($arr[$keys[9]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Templates The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(TemplatesTableMap::DATABASE_NAME);

        if ($this->isColumnModified(TemplatesTableMap::COL_ID)) {
            $criteria->add(TemplatesTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(TemplatesTableMap::COL__FORTEMPLATE)) {
            $criteria->add(TemplatesTableMap::COL__FORTEMPLATE, $this->_fortemplate);
        }
        if ($this->isColumnModified(TemplatesTableMap::COL__FIELDNAME)) {
            $criteria->add(TemplatesTableMap::COL__FIELDNAME, $this->_fieldname);
        }
        if ($this->isColumnModified(TemplatesTableMap::COL__HELPDESCRIPTION)) {
            $criteria->add(TemplatesTableMap::COL__HELPDESCRIPTION, $this->_helpdescription);
        }
        if ($this->isColumnModified(TemplatesTableMap::COL__HELPIMAGE)) {
            $criteria->add(TemplatesTableMap::COL__HELPIMAGE, $this->_helpimage);
        }
        if ($this->isColumnModified(TemplatesTableMap::COL__FIELDTYPE)) {
            $criteria->add(TemplatesTableMap::COL__FIELDTYPE, $this->_fieldtype);
        }
        if ($this->isColumnModified(TemplatesTableMap::COL___CONFIG__)) {
            $criteria->add(TemplatesTableMap::COL___CONFIG__, $this->__config__);
        }
        if ($this->isColumnModified(TemplatesTableMap::COL___SPLIT__)) {
            $criteria->add(TemplatesTableMap::COL___SPLIT__, $this->__split__);
        }
        if ($this->isColumnModified(TemplatesTableMap::COL___PARENTNODE__)) {
            $criteria->add(TemplatesTableMap::COL___PARENTNODE__, $this->__parentnode__);
        }
        if ($this->isColumnModified(TemplatesTableMap::COL___SORT__)) {
            $criteria->add(TemplatesTableMap::COL___SORT__, $this->__sort__);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildTemplatesQuery::create();
        $criteria->add(TemplatesTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Templates (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setFortemplate($this->getFortemplate());
        $copyObj->setFieldname($this->getFieldname());
        $copyObj->setHelpdescription($this->getHelpdescription());
        $copyObj->setHelpimage($this->getHelpimage());
        $copyObj->setFieldtype($this->getFieldtype());
        $copyObj->setConfigSys($this->getConfigSys());
        $copyObj->setSplit($this->getSplit());
        $copyObj->setParentnode($this->getParentnode());
        $copyObj->setSort($this->getSort());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getRFieldpostprocessorForfields() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRFieldpostprocessorForfield($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDatas() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addData($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRDataTemplates() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRDataTemplate($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Templates Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildTemplatenames object.
     *
     * @param  ChildTemplatenames $v
     * @return $this|\Templates The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTemplatenames(ChildTemplatenames $v = null)
    {
        if ($v === null) {
            $this->setFortemplate(NULL);
        } else {
            $this->setFortemplate($v->getId());
        }

        $this->aTemplatenames = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildTemplatenames object, it will not be re-added.
        if ($v !== null) {
            $v->addTemplates($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildTemplatenames object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildTemplatenames The associated ChildTemplatenames object.
     * @throws PropelException
     */
    public function getTemplatenames(ConnectionInterface $con = null)
    {
        if ($this->aTemplatenames === null && ($this->_fortemplate != 0)) {
            $this->aTemplatenames = ChildTemplatenamesQuery::create()->findPk($this->_fortemplate, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aTemplatenames->addTemplatess($this);
             */
        }

        return $this->aTemplatenames;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('RFieldpostprocessorForfield' == $relationName) {
            $this->initRFieldpostprocessorForfields();
            return;
        }
        if ('Data' == $relationName) {
            $this->initDatas();
            return;
        }
        if ('RDataTemplate' == $relationName) {
            $this->initRDataTemplates();
            return;
        }
    }

    /**
     * Clears out the collRFieldpostprocessorForfields collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRFieldpostprocessorForfields()
     */
    public function clearRFieldpostprocessorForfields()
    {
        $this->collRFieldpostprocessorForfields = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRFieldpostprocessorForfields collection loaded partially.
     */
    public function resetPartialRFieldpostprocessorForfields($v = true)
    {
        $this->collRFieldpostprocessorForfieldsPartial = $v;
    }

    /**
     * Initializes the collRFieldpostprocessorForfields collection.
     *
     * By default this just sets the collRFieldpostprocessorForfields collection to an empty array (like clearcollRFieldpostprocessorForfields());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRFieldpostprocessorForfields($overrideExisting = true)
    {
        if (null !== $this->collRFieldpostprocessorForfields && !$overrideExisting) {
            return;
        }

        $collectionClassName = RFieldpostprocessorForfieldTableMap::getTableMap()->getCollectionClassName();

        $this->collRFieldpostprocessorForfields = new $collectionClassName;
        $this->collRFieldpostprocessorForfields->setModel('\RFieldpostprocessorForfield');
    }

    /**
     * Gets an array of ChildRFieldpostprocessorForfield objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTemplates is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRFieldpostprocessorForfield[] List of ChildRFieldpostprocessorForfield objects
     * @throws PropelException
     */
    public function getRFieldpostprocessorForfields(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRFieldpostprocessorForfieldsPartial && !$this->isNew();
        if (null === $this->collRFieldpostprocessorForfields || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRFieldpostprocessorForfields) {
                // return empty collection
                $this->initRFieldpostprocessorForfields();
            } else {
                $collRFieldpostprocessorForfields = ChildRFieldpostprocessorForfieldQuery::create(null, $criteria)
                    ->filterByTemplates($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRFieldpostprocessorForfieldsPartial && count($collRFieldpostprocessorForfields)) {
                        $this->initRFieldpostprocessorForfields(false);

                        foreach ($collRFieldpostprocessorForfields as $obj) {
                            if (false == $this->collRFieldpostprocessorForfields->contains($obj)) {
                                $this->collRFieldpostprocessorForfields->append($obj);
                            }
                        }

                        $this->collRFieldpostprocessorForfieldsPartial = true;
                    }

                    return $collRFieldpostprocessorForfields;
                }

                if ($partial && $this->collRFieldpostprocessorForfields) {
                    foreach ($this->collRFieldpostprocessorForfields as $obj) {
                        if ($obj->isNew()) {
                            $collRFieldpostprocessorForfields[] = $obj;
                        }
                    }
                }

                $this->collRFieldpostprocessorForfields = $collRFieldpostprocessorForfields;
                $this->collRFieldpostprocessorForfieldsPartial = false;
            }
        }

        return $this->collRFieldpostprocessorForfields;
    }

    /**
     * Sets a collection of ChildRFieldpostprocessorForfield objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rFieldpostprocessorForfields A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildTemplates The current object (for fluent API support)
     */
    public function setRFieldpostprocessorForfields(Collection $rFieldpostprocessorForfields, ConnectionInterface $con = null)
    {
        /** @var ChildRFieldpostprocessorForfield[] $rFieldpostprocessorForfieldsToDelete */
        $rFieldpostprocessorForfieldsToDelete = $this->getRFieldpostprocessorForfields(new Criteria(), $con)->diff($rFieldpostprocessorForfields);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rFieldpostprocessorForfieldsScheduledForDeletion = clone $rFieldpostprocessorForfieldsToDelete;

        foreach ($rFieldpostprocessorForfieldsToDelete as $rFieldpostprocessorForfieldRemoved) {
            $rFieldpostprocessorForfieldRemoved->setTemplates(null);
        }

        $this->collRFieldpostprocessorForfields = null;
        foreach ($rFieldpostprocessorForfields as $rFieldpostprocessorForfield) {
            $this->addRFieldpostprocessorForfield($rFieldpostprocessorForfield);
        }

        $this->collRFieldpostprocessorForfields = $rFieldpostprocessorForfields;
        $this->collRFieldpostprocessorForfieldsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RFieldpostprocessorForfield objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RFieldpostprocessorForfield objects.
     * @throws PropelException
     */
    public function countRFieldpostprocessorForfields(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRFieldpostprocessorForfieldsPartial && !$this->isNew();
        if (null === $this->collRFieldpostprocessorForfields || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRFieldpostprocessorForfields) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRFieldpostprocessorForfields());
            }

            $query = ChildRFieldpostprocessorForfieldQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTemplates($this)
                ->count($con);
        }

        return count($this->collRFieldpostprocessorForfields);
    }

    /**
     * Method called to associate a ChildRFieldpostprocessorForfield object to this object
     * through the ChildRFieldpostprocessorForfield foreign key attribute.
     *
     * @param  ChildRFieldpostprocessorForfield $l ChildRFieldpostprocessorForfield
     * @return $this|\Templates The current object (for fluent API support)
     */
    public function addRFieldpostprocessorForfield(ChildRFieldpostprocessorForfield $l)
    {
        if ($this->collRFieldpostprocessorForfields === null) {
            $this->initRFieldpostprocessorForfields();
            $this->collRFieldpostprocessorForfieldsPartial = true;
        }

        if (!$this->collRFieldpostprocessorForfields->contains($l)) {
            $this->doAddRFieldpostprocessorForfield($l);

            if ($this->rFieldpostprocessorForfieldsScheduledForDeletion and $this->rFieldpostprocessorForfieldsScheduledForDeletion->contains($l)) {
                $this->rFieldpostprocessorForfieldsScheduledForDeletion->remove($this->rFieldpostprocessorForfieldsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRFieldpostprocessorForfield $rFieldpostprocessorForfield The ChildRFieldpostprocessorForfield object to add.
     */
    protected function doAddRFieldpostprocessorForfield(ChildRFieldpostprocessorForfield $rFieldpostprocessorForfield)
    {
        $this->collRFieldpostprocessorForfields[]= $rFieldpostprocessorForfield;
        $rFieldpostprocessorForfield->setTemplates($this);
    }

    /**
     * @param  ChildRFieldpostprocessorForfield $rFieldpostprocessorForfield The ChildRFieldpostprocessorForfield object to remove.
     * @return $this|ChildTemplates The current object (for fluent API support)
     */
    public function removeRFieldpostprocessorForfield(ChildRFieldpostprocessorForfield $rFieldpostprocessorForfield)
    {
        if ($this->getRFieldpostprocessorForfields()->contains($rFieldpostprocessorForfield)) {
            $pos = $this->collRFieldpostprocessorForfields->search($rFieldpostprocessorForfield);
            $this->collRFieldpostprocessorForfields->remove($pos);
            if (null === $this->rFieldpostprocessorForfieldsScheduledForDeletion) {
                $this->rFieldpostprocessorForfieldsScheduledForDeletion = clone $this->collRFieldpostprocessorForfields;
                $this->rFieldpostprocessorForfieldsScheduledForDeletion->clear();
            }
            $this->rFieldpostprocessorForfieldsScheduledForDeletion[]= clone $rFieldpostprocessorForfield;
            $rFieldpostprocessorForfield->setTemplates(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Templates is new, it will return
     * an empty collection; or if this Templates has previously
     * been saved, it will retrieve related RFieldpostprocessorForfields from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Templates.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRFieldpostprocessorForfield[] List of ChildRFieldpostprocessorForfield objects
     */
    public function getRFieldpostprocessorForfieldsJoinFieldpostprocessor(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRFieldpostprocessorForfieldQuery::create(null, $criteria);
        $query->joinWith('Fieldpostprocessor', $joinBehavior);

        return $this->getRFieldpostprocessorForfields($query, $con);
    }

    /**
     * Clears out the collDatas collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDatas()
     */
    public function clearDatas()
    {
        $this->collDatas = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDatas collection loaded partially.
     */
    public function resetPartialDatas($v = true)
    {
        $this->collDatasPartial = $v;
    }

    /**
     * Initializes the collDatas collection.
     *
     * By default this just sets the collDatas collection to an empty array (like clearcollDatas());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDatas($overrideExisting = true)
    {
        if (null !== $this->collDatas && !$overrideExisting) {
            return;
        }

        $collectionClassName = DataTableMap::getTableMap()->getCollectionClassName();

        $this->collDatas = new $collectionClassName;
        $this->collDatas->setModel('\Data');
    }

    /**
     * Gets an array of ChildData objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTemplates is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildData[] List of ChildData objects
     * @throws PropelException
     */
    public function getDatas(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDatasPartial && !$this->isNew();
        if (null === $this->collDatas || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDatas) {
                // return empty collection
                $this->initDatas();
            } else {
                $collDatas = ChildDataQuery::create(null, $criteria)
                    ->filterByTemplates($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDatasPartial && count($collDatas)) {
                        $this->initDatas(false);

                        foreach ($collDatas as $obj) {
                            if (false == $this->collDatas->contains($obj)) {
                                $this->collDatas->append($obj);
                            }
                        }

                        $this->collDatasPartial = true;
                    }

                    return $collDatas;
                }

                if ($partial && $this->collDatas) {
                    foreach ($this->collDatas as $obj) {
                        if ($obj->isNew()) {
                            $collDatas[] = $obj;
                        }
                    }
                }

                $this->collDatas = $collDatas;
                $this->collDatasPartial = false;
            }
        }

        return $this->collDatas;
    }

    /**
     * Sets a collection of ChildData objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $datas A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildTemplates The current object (for fluent API support)
     */
    public function setDatas(Collection $datas, ConnectionInterface $con = null)
    {
        /** @var ChildData[] $datasToDelete */
        $datasToDelete = $this->getDatas(new Criteria(), $con)->diff($datas);


        $this->datasScheduledForDeletion = $datasToDelete;

        foreach ($datasToDelete as $dataRemoved) {
            $dataRemoved->setTemplates(null);
        }

        $this->collDatas = null;
        foreach ($datas as $data) {
            $this->addData($data);
        }

        $this->collDatas = $datas;
        $this->collDatasPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Data objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Data objects.
     * @throws PropelException
     */
    public function countDatas(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDatasPartial && !$this->isNew();
        if (null === $this->collDatas || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDatas) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDatas());
            }

            $query = ChildDataQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTemplates($this)
                ->count($con);
        }

        return count($this->collDatas);
    }

    /**
     * Method called to associate a ChildData object to this object
     * through the ChildData foreign key attribute.
     *
     * @param  ChildData $l ChildData
     * @return $this|\Templates The current object (for fluent API support)
     */
    public function addData(ChildData $l)
    {
        if ($this->collDatas === null) {
            $this->initDatas();
            $this->collDatasPartial = true;
        }

        if (!$this->collDatas->contains($l)) {
            $this->doAddData($l);

            if ($this->datasScheduledForDeletion and $this->datasScheduledForDeletion->contains($l)) {
                $this->datasScheduledForDeletion->remove($this->datasScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildData $data The ChildData object to add.
     */
    protected function doAddData(ChildData $data)
    {
        $this->collDatas[]= $data;
        $data->setTemplates($this);
    }

    /**
     * @param  ChildData $data The ChildData object to remove.
     * @return $this|ChildTemplates The current object (for fluent API support)
     */
    public function removeData(ChildData $data)
    {
        if ($this->getDatas()->contains($data)) {
            $pos = $this->collDatas->search($data);
            $this->collDatas->remove($pos);
            if (null === $this->datasScheduledForDeletion) {
                $this->datasScheduledForDeletion = clone $this->collDatas;
                $this->datasScheduledForDeletion->clear();
            }
            $this->datasScheduledForDeletion[]= $data;
            $data->setTemplates(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Templates is new, it will return
     * an empty collection; or if this Templates has previously
     * been saved, it will retrieve related Datas from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Templates.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildData[] List of ChildData objects
     */
    public function getDatasJoinuserSysRef(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDataQuery::create(null, $criteria);
        $query->joinWith('userSysRef', $joinBehavior);

        return $this->getDatas($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Templates is new, it will return
     * an empty collection; or if this Templates has previously
     * been saved, it will retrieve related Datas from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Templates.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildData[] List of ChildData objects
     */
    public function getDatasJoinContributions(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDataQuery::create(null, $criteria);
        $query->joinWith('Contributions', $joinBehavior);

        return $this->getDatas($query, $con);
    }

    /**
     * Clears out the collRDataTemplates collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRDataTemplates()
     */
    public function clearRDataTemplates()
    {
        $this->collRDataTemplates = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRDataTemplates collection loaded partially.
     */
    public function resetPartialRDataTemplates($v = true)
    {
        $this->collRDataTemplatesPartial = $v;
    }

    /**
     * Initializes the collRDataTemplates collection.
     *
     * By default this just sets the collRDataTemplates collection to an empty array (like clearcollRDataTemplates());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRDataTemplates($overrideExisting = true)
    {
        if (null !== $this->collRDataTemplates && !$overrideExisting) {
            return;
        }

        $collectionClassName = RDataTemplateTableMap::getTableMap()->getCollectionClassName();

        $this->collRDataTemplates = new $collectionClassName;
        $this->collRDataTemplates->setModel('\RDataTemplate');
    }

    /**
     * Gets an array of ChildRDataTemplate objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTemplates is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRDataTemplate[] List of ChildRDataTemplate objects
     * @throws PropelException
     */
    public function getRDataTemplates(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRDataTemplatesPartial && !$this->isNew();
        if (null === $this->collRDataTemplates || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRDataTemplates) {
                // return empty collection
                $this->initRDataTemplates();
            } else {
                $collRDataTemplates = ChildRDataTemplateQuery::create(null, $criteria)
                    ->filterByRTemplate($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRDataTemplatesPartial && count($collRDataTemplates)) {
                        $this->initRDataTemplates(false);

                        foreach ($collRDataTemplates as $obj) {
                            if (false == $this->collRDataTemplates->contains($obj)) {
                                $this->collRDataTemplates->append($obj);
                            }
                        }

                        $this->collRDataTemplatesPartial = true;
                    }

                    return $collRDataTemplates;
                }

                if ($partial && $this->collRDataTemplates) {
                    foreach ($this->collRDataTemplates as $obj) {
                        if ($obj->isNew()) {
                            $collRDataTemplates[] = $obj;
                        }
                    }
                }

                $this->collRDataTemplates = $collRDataTemplates;
                $this->collRDataTemplatesPartial = false;
            }
        }

        return $this->collRDataTemplates;
    }

    /**
     * Sets a collection of ChildRDataTemplate objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rDataTemplates A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildTemplates The current object (for fluent API support)
     */
    public function setRDataTemplates(Collection $rDataTemplates, ConnectionInterface $con = null)
    {
        /** @var ChildRDataTemplate[] $rDataTemplatesToDelete */
        $rDataTemplatesToDelete = $this->getRDataTemplates(new Criteria(), $con)->diff($rDataTemplates);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rDataTemplatesScheduledForDeletion = clone $rDataTemplatesToDelete;

        foreach ($rDataTemplatesToDelete as $rDataTemplateRemoved) {
            $rDataTemplateRemoved->setRTemplate(null);
        }

        $this->collRDataTemplates = null;
        foreach ($rDataTemplates as $rDataTemplate) {
            $this->addRDataTemplate($rDataTemplate);
        }

        $this->collRDataTemplates = $rDataTemplates;
        $this->collRDataTemplatesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RDataTemplate objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RDataTemplate objects.
     * @throws PropelException
     */
    public function countRDataTemplates(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRDataTemplatesPartial && !$this->isNew();
        if (null === $this->collRDataTemplates || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRDataTemplates) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRDataTemplates());
            }

            $query = ChildRDataTemplateQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRTemplate($this)
                ->count($con);
        }

        return count($this->collRDataTemplates);
    }

    /**
     * Method called to associate a ChildRDataTemplate object to this object
     * through the ChildRDataTemplate foreign key attribute.
     *
     * @param  ChildRDataTemplate $l ChildRDataTemplate
     * @return $this|\Templates The current object (for fluent API support)
     */
    public function addRDataTemplate(ChildRDataTemplate $l)
    {
        if ($this->collRDataTemplates === null) {
            $this->initRDataTemplates();
            $this->collRDataTemplatesPartial = true;
        }

        if (!$this->collRDataTemplates->contains($l)) {
            $this->doAddRDataTemplate($l);

            if ($this->rDataTemplatesScheduledForDeletion and $this->rDataTemplatesScheduledForDeletion->contains($l)) {
                $this->rDataTemplatesScheduledForDeletion->remove($this->rDataTemplatesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRDataTemplate $rDataTemplate The ChildRDataTemplate object to add.
     */
    protected function doAddRDataTemplate(ChildRDataTemplate $rDataTemplate)
    {
        $this->collRDataTemplates[]= $rDataTemplate;
        $rDataTemplate->setRTemplate($this);
    }

    /**
     * @param  ChildRDataTemplate $rDataTemplate The ChildRDataTemplate object to remove.
     * @return $this|ChildTemplates The current object (for fluent API support)
     */
    public function removeRDataTemplate(ChildRDataTemplate $rDataTemplate)
    {
        if ($this->getRDataTemplates()->contains($rDataTemplate)) {
            $pos = $this->collRDataTemplates->search($rDataTemplate);
            $this->collRDataTemplates->remove($pos);
            if (null === $this->rDataTemplatesScheduledForDeletion) {
                $this->rDataTemplatesScheduledForDeletion = clone $this->collRDataTemplates;
                $this->rDataTemplatesScheduledForDeletion->clear();
            }
            $this->rDataTemplatesScheduledForDeletion[]= clone $rDataTemplate;
            $rDataTemplate->setRTemplate(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Templates is new, it will return
     * an empty collection; or if this Templates has previously
     * been saved, it will retrieve related RDataTemplates from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Templates.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRDataTemplate[] List of ChildRDataTemplate objects
     */
    public function getRDataTemplatesJoinRData(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRDataTemplateQuery::create(null, $criteria);
        $query->joinWith('RData', $joinBehavior);

        return $this->getRDataTemplates($query, $con);
    }

    /**
     * Clears out the collFieldpostprocessors collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFieldpostprocessors()
     */
    public function clearFieldpostprocessors()
    {
        $this->collFieldpostprocessors = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collFieldpostprocessors crossRef collection.
     *
     * By default this just sets the collFieldpostprocessors collection to an empty collection (like clearFieldpostprocessors());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initFieldpostprocessors()
    {
        $collectionClassName = RFieldpostprocessorForfieldTableMap::getTableMap()->getCollectionClassName();

        $this->collFieldpostprocessors = new $collectionClassName;
        $this->collFieldpostprocessorsPartial = true;
        $this->collFieldpostprocessors->setModel('\Fieldpostprocessor');
    }

    /**
     * Checks if the collFieldpostprocessors collection is loaded.
     *
     * @return bool
     */
    public function isFieldpostprocessorsLoaded()
    {
        return null !== $this->collFieldpostprocessors;
    }

    /**
     * Gets a collection of ChildFieldpostprocessor objects related by a many-to-many relationship
     * to the current object by way of the R_fieldpostprocessor_forfield cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTemplates is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildFieldpostprocessor[] List of ChildFieldpostprocessor objects
     */
    public function getFieldpostprocessors(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFieldpostprocessorsPartial && !$this->isNew();
        if (null === $this->collFieldpostprocessors || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collFieldpostprocessors) {
                    $this->initFieldpostprocessors();
                }
            } else {

                $query = ChildFieldpostprocessorQuery::create(null, $criteria)
                    ->filterByTemplates($this);
                $collFieldpostprocessors = $query->find($con);
                if (null !== $criteria) {
                    return $collFieldpostprocessors;
                }

                if ($partial && $this->collFieldpostprocessors) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collFieldpostprocessors as $obj) {
                        if (!$collFieldpostprocessors->contains($obj)) {
                            $collFieldpostprocessors[] = $obj;
                        }
                    }
                }

                $this->collFieldpostprocessors = $collFieldpostprocessors;
                $this->collFieldpostprocessorsPartial = false;
            }
        }

        return $this->collFieldpostprocessors;
    }

    /**
     * Sets a collection of Fieldpostprocessor objects related by a many-to-many relationship
     * to the current object by way of the R_fieldpostprocessor_forfield cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $fieldpostprocessors A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildTemplates The current object (for fluent API support)
     */
    public function setFieldpostprocessors(Collection $fieldpostprocessors, ConnectionInterface $con = null)
    {
        $this->clearFieldpostprocessors();
        $currentFieldpostprocessors = $this->getFieldpostprocessors();

        $fieldpostprocessorsScheduledForDeletion = $currentFieldpostprocessors->diff($fieldpostprocessors);

        foreach ($fieldpostprocessorsScheduledForDeletion as $toDelete) {
            $this->removeFieldpostprocessor($toDelete);
        }

        foreach ($fieldpostprocessors as $fieldpostprocessor) {
            if (!$currentFieldpostprocessors->contains($fieldpostprocessor)) {
                $this->doAddFieldpostprocessor($fieldpostprocessor);
            }
        }

        $this->collFieldpostprocessorsPartial = false;
        $this->collFieldpostprocessors = $fieldpostprocessors;

        return $this;
    }

    /**
     * Gets the number of Fieldpostprocessor objects related by a many-to-many relationship
     * to the current object by way of the R_fieldpostprocessor_forfield cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Fieldpostprocessor objects
     */
    public function countFieldpostprocessors(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFieldpostprocessorsPartial && !$this->isNew();
        if (null === $this->collFieldpostprocessors || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFieldpostprocessors) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getFieldpostprocessors());
                }

                $query = ChildFieldpostprocessorQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByTemplates($this)
                    ->count($con);
            }
        } else {
            return count($this->collFieldpostprocessors);
        }
    }

    /**
     * Associate a ChildFieldpostprocessor to this object
     * through the R_fieldpostprocessor_forfield cross reference table.
     *
     * @param ChildFieldpostprocessor $fieldpostprocessor
     * @return ChildTemplates The current object (for fluent API support)
     */
    public function addFieldpostprocessor(ChildFieldpostprocessor $fieldpostprocessor)
    {
        if ($this->collFieldpostprocessors === null) {
            $this->initFieldpostprocessors();
        }

        if (!$this->getFieldpostprocessors()->contains($fieldpostprocessor)) {
            // only add it if the **same** object is not already associated
            $this->collFieldpostprocessors->push($fieldpostprocessor);
            $this->doAddFieldpostprocessor($fieldpostprocessor);
        }

        return $this;
    }

    /**
     *
     * @param ChildFieldpostprocessor $fieldpostprocessor
     */
    protected function doAddFieldpostprocessor(ChildFieldpostprocessor $fieldpostprocessor)
    {
        $rFieldpostprocessorForfield = new ChildRFieldpostprocessorForfield();

        $rFieldpostprocessorForfield->setFieldpostprocessor($fieldpostprocessor);

        $rFieldpostprocessorForfield->setTemplates($this);

        $this->addRFieldpostprocessorForfield($rFieldpostprocessorForfield);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$fieldpostprocessor->isTemplatessLoaded()) {
            $fieldpostprocessor->initTemplatess();
            $fieldpostprocessor->getTemplatess()->push($this);
        } elseif (!$fieldpostprocessor->getTemplatess()->contains($this)) {
            $fieldpostprocessor->getTemplatess()->push($this);
        }

    }

    /**
     * Remove fieldpostprocessor of this object
     * through the R_fieldpostprocessor_forfield cross reference table.
     *
     * @param ChildFieldpostprocessor $fieldpostprocessor
     * @return ChildTemplates The current object (for fluent API support)
     */
    public function removeFieldpostprocessor(ChildFieldpostprocessor $fieldpostprocessor)
    {
        if ($this->getFieldpostprocessors()->contains($fieldpostprocessor)) {
            $rFieldpostprocessorForfield = new ChildRFieldpostprocessorForfield();
            $rFieldpostprocessorForfield->setFieldpostprocessor($fieldpostprocessor);
            if ($fieldpostprocessor->isTemplatessLoaded()) {
                //remove the back reference if available
                $fieldpostprocessor->getTemplatess()->removeObject($this);
            }

            $rFieldpostprocessorForfield->setTemplates($this);
            $this->removeRFieldpostprocessorForfield(clone $rFieldpostprocessorForfield);
            $rFieldpostprocessorForfield->clear();

            $this->collFieldpostprocessors->remove($this->collFieldpostprocessors->search($fieldpostprocessor));

            if (null === $this->fieldpostprocessorsScheduledForDeletion) {
                $this->fieldpostprocessorsScheduledForDeletion = clone $this->collFieldpostprocessors;
                $this->fieldpostprocessorsScheduledForDeletion->clear();
            }

            $this->fieldpostprocessorsScheduledForDeletion->push($fieldpostprocessor);
        }


        return $this;
    }

    /**
     * Clears out the collRDatas collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRDatas()
     */
    public function clearRDatas()
    {
        $this->collRDatas = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collRDatas crossRef collection.
     *
     * By default this just sets the collRDatas collection to an empty collection (like clearRDatas());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initRDatas()
    {
        $collectionClassName = RDataTemplateTableMap::getTableMap()->getCollectionClassName();

        $this->collRDatas = new $collectionClassName;
        $this->collRDatasPartial = true;
        $this->collRDatas->setModel('\Data');
    }

    /**
     * Checks if the collRDatas collection is loaded.
     *
     * @return bool
     */
    public function isRDatasLoaded()
    {
        return null !== $this->collRDatas;
    }

    /**
     * Gets a collection of ChildData objects related by a many-to-many relationship
     * to the current object by way of the R_data_template cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTemplates is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildData[] List of ChildData objects
     */
    public function getRDatas(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRDatasPartial && !$this->isNew();
        if (null === $this->collRDatas || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collRDatas) {
                    $this->initRDatas();
                }
            } else {

                $query = ChildDataQuery::create(null, $criteria)
                    ->filterByRTemplate($this);
                $collRDatas = $query->find($con);
                if (null !== $criteria) {
                    return $collRDatas;
                }

                if ($partial && $this->collRDatas) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collRDatas as $obj) {
                        if (!$collRDatas->contains($obj)) {
                            $collRDatas[] = $obj;
                        }
                    }
                }

                $this->collRDatas = $collRDatas;
                $this->collRDatasPartial = false;
            }
        }

        return $this->collRDatas;
    }

    /**
     * Sets a collection of Data objects related by a many-to-many relationship
     * to the current object by way of the R_data_template cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $rDatas A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildTemplates The current object (for fluent API support)
     */
    public function setRDatas(Collection $rDatas, ConnectionInterface $con = null)
    {
        $this->clearRDatas();
        $currentRDatas = $this->getRDatas();

        $rDatasScheduledForDeletion = $currentRDatas->diff($rDatas);

        foreach ($rDatasScheduledForDeletion as $toDelete) {
            $this->removeRData($toDelete);
        }

        foreach ($rDatas as $rData) {
            if (!$currentRDatas->contains($rData)) {
                $this->doAddRData($rData);
            }
        }

        $this->collRDatasPartial = false;
        $this->collRDatas = $rDatas;

        return $this;
    }

    /**
     * Gets the number of Data objects related by a many-to-many relationship
     * to the current object by way of the R_data_template cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Data objects
     */
    public function countRDatas(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRDatasPartial && !$this->isNew();
        if (null === $this->collRDatas || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRDatas) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getRDatas());
                }

                $query = ChildDataQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByRTemplate($this)
                    ->count($con);
            }
        } else {
            return count($this->collRDatas);
        }
    }

    /**
     * Associate a ChildData to this object
     * through the R_data_template cross reference table.
     *
     * @param ChildData $rData
     * @return ChildTemplates The current object (for fluent API support)
     */
    public function addRData(ChildData $rData)
    {
        if ($this->collRDatas === null) {
            $this->initRDatas();
        }

        if (!$this->getRDatas()->contains($rData)) {
            // only add it if the **same** object is not already associated
            $this->collRDatas->push($rData);
            $this->doAddRData($rData);
        }

        return $this;
    }

    /**
     *
     * @param ChildData $rData
     */
    protected function doAddRData(ChildData $rData)
    {
        $rDataTemplate = new ChildRDataTemplate();

        $rDataTemplate->setRData($rData);

        $rDataTemplate->setRTemplate($this);

        $this->addRDataTemplate($rDataTemplate);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$rData->isRTemplatesLoaded()) {
            $rData->initRTemplates();
            $rData->getRTemplates()->push($this);
        } elseif (!$rData->getRTemplates()->contains($this)) {
            $rData->getRTemplates()->push($this);
        }

    }

    /**
     * Remove rData of this object
     * through the R_data_template cross reference table.
     *
     * @param ChildData $rData
     * @return ChildTemplates The current object (for fluent API support)
     */
    public function removeRData(ChildData $rData)
    {
        if ($this->getRDatas()->contains($rData)) {
            $rDataTemplate = new ChildRDataTemplate();
            $rDataTemplate->setRData($rData);
            if ($rData->isRTemplatesLoaded()) {
                //remove the back reference if available
                $rData->getRTemplates()->removeObject($this);
            }

            $rDataTemplate->setRTemplate($this);
            $this->removeRDataTemplate(clone $rDataTemplate);
            $rDataTemplate->clear();

            $this->collRDatas->remove($this->collRDatas->search($rData));

            if (null === $this->rDatasScheduledForDeletion) {
                $this->rDatasScheduledForDeletion = clone $this->collRDatas;
                $this->rDatasScheduledForDeletion->clear();
            }

            $this->rDatasScheduledForDeletion->push($rData);
        }


        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aTemplatenames) {
            $this->aTemplatenames->removeTemplates($this);
        }
        $this->id = null;
        $this->_fortemplate = null;
        $this->_fieldname = null;
        $this->_helpdescription = null;
        $this->_helpimage = null;
        $this->_fieldtype = null;
        $this->__config__ = null;
        $this->__split__ = null;
        $this->__parentnode__ = null;
        $this->__sort__ = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collRFieldpostprocessorForfields) {
                foreach ($this->collRFieldpostprocessorForfields as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDatas) {
                foreach ($this->collDatas as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRDataTemplates) {
                foreach ($this->collRDataTemplates as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFieldpostprocessors) {
                foreach ($this->collFieldpostprocessors as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRDatas) {
                foreach ($this->collRDatas as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collRFieldpostprocessorForfields = null;
        $this->collDatas = null;
        $this->collRDataTemplates = null;
        $this->collFieldpostprocessors = null;
        $this->collRDatas = null;
        $this->aTemplatenames = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(TemplatesTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
