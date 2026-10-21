<?php

namespace Base;

use \Batch as ChildBatch;
use \BatchQuery as ChildBatchQuery;
use \Books as ChildBooks;
use \BooksQuery as ChildBooksQuery;
use \Data as ChildData;
use \DataQuery as ChildDataQuery;
use \Formats as ChildFormats;
use \FormatsQuery as ChildFormatsQuery;
use \Issues as ChildIssues;
use \IssuesQuery as ChildIssuesQuery;
use \Plugins as ChildPlugins;
use \PluginsQuery as ChildPluginsQuery;
use \RBatchForbook as ChildRBatchForbook;
use \RBatchForbookQuery as ChildRBatchForbookQuery;
use \RDataBook as ChildRDataBook;
use \RDataBookQuery as ChildRDataBookQuery;
use \RPluginBook as ChildRPluginBook;
use \RPluginBookQuery as ChildRPluginBookQuery;
use \RRightsForbook as ChildRRightsForbook;
use \RRightsForbookQuery as ChildRRightsForbookQuery;
use \RTemplatenamesForbook as ChildRTemplatenamesForbook;
use \RTemplatenamesForbookQuery as ChildRTemplatenamesForbookQuery;
use \Rights as ChildRights;
use \RightsQuery as ChildRightsQuery;
use \Templatenames as ChildTemplatenames;
use \TemplatenamesQuery as ChildTemplatenamesQuery;
use \Users as ChildUsers;
use \UsersQuery as ChildUsersQuery;
use \Exception;
use \PDO;
use Map\BooksTableMap;
use Map\FormatsTableMap;
use Map\IssuesTableMap;
use Map\RBatchForbookTableMap;
use Map\RDataBookTableMap;
use Map\RPluginBookTableMap;
use Map\RRightsForbookTableMap;
use Map\RTemplatenamesForbookTableMap;
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
 * Base class that represents a row from the '_books' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Books implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\BooksTableMap';


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
     * The value for the _name field.
     *
     * @var        string
     */
    protected $_name;

    /**
     * The value for the __user__ field.
     *
     * @var        int
     */
    protected $__user__;

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
     * @var        ChildUsers
     */
    protected $auserSysRef;

    /**
     * @var        ObjectCollection|ChildRBatchForbook[] Collection to store aggregation of ChildRBatchForbook objects.
     */
    protected $collRBatchForbooks;
    protected $collRBatchForbooksPartial;

    /**
     * @var        ObjectCollection|ChildRRightsForbook[] Collection to store aggregation of ChildRRightsForbook objects.
     */
    protected $collRRightsForbooks;
    protected $collRRightsForbooksPartial;

    /**
     * @var        ObjectCollection|ChildRTemplatenamesForbook[] Collection to store aggregation of ChildRTemplatenamesForbook objects.
     */
    protected $collRTemplatenamesForbooks;
    protected $collRTemplatenamesForbooksPartial;

    /**
     * @var        ObjectCollection|ChildRDataBook[] Collection to store aggregation of ChildRDataBook objects.
     */
    protected $collRDataBooks;
    protected $collRDataBooksPartial;

    /**
     * @var        ObjectCollection|ChildRPluginBook[] Collection to store aggregation of ChildRPluginBook objects.
     */
    protected $collRPluginBooks;
    protected $collRPluginBooksPartial;

    /**
     * @var        ObjectCollection|ChildFormats[] Collection to store aggregation of ChildFormats objects.
     */
    protected $collFormatss;
    protected $collFormatssPartial;

    /**
     * @var        ObjectCollection|ChildIssues[] Collection to store aggregation of ChildIssues objects.
     */
    protected $collIssuess;
    protected $collIssuessPartial;

    /**
     * @var        ObjectCollection|ChildBatch[] Cross Collection to store aggregation of ChildBatch objects.
     */
    protected $collBatches;

    /**
     * @var bool
     */
    protected $collBatchesPartial;

    /**
     * @var        ObjectCollection|ChildRights[] Cross Collection to store aggregation of ChildRights objects.
     */
    protected $collRightss;

    /**
     * @var bool
     */
    protected $collRightssPartial;

    /**
     * @var        ObjectCollection|ChildTemplatenames[] Cross Collection to store aggregation of ChildTemplatenames objects.
     */
    protected $collTemplatenamess;

    /**
     * @var bool
     */
    protected $collTemplatenamessPartial;

    /**
     * @var        ObjectCollection|ChildData[] Cross Collection to store aggregation of ChildData objects.
     */
    protected $collRDatas;

    /**
     * @var bool
     */
    protected $collRDatasPartial;

    /**
     * @var        ObjectCollection|ChildPlugins[] Cross Collection to store aggregation of ChildPlugins objects.
     */
    protected $collRPlugins;

    /**
     * @var bool
     */
    protected $collRPluginsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildBatch[]
     */
    protected $batchesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRights[]
     */
    protected $rightssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTemplatenames[]
     */
    protected $templatenamessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildData[]
     */
    protected $rDatasScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPlugins[]
     */
    protected $rPluginsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRBatchForbook[]
     */
    protected $rBatchForbooksScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRRightsForbook[]
     */
    protected $rRightsForbooksScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRTemplatenamesForbook[]
     */
    protected $rTemplatenamesForbooksScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRDataBook[]
     */
    protected $rDataBooksScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRPluginBook[]
     */
    protected $rPluginBooksScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildFormats[]
     */
    protected $formatssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildIssues[]
     */
    protected $issuessScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Books object.
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
     * Compares this with another <code>Books</code> instance.  If
     * <code>obj</code> is an instance of <code>Books</code>, delegates to
     * <code>equals(Books)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Books The current object, for fluid interface
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
     * Get the [_name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Get the [__user__] column value.
     *
     * @return int
     */
    public function getUserSys()
    {
        return $this->__user__;
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
     * @return $this|\Books The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[BooksTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [_name] column.
     *
     * @param string $v new value
     * @return $this|\Books The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_name !== $v) {
            $this->_name = $v;
            $this->modifiedColumns[BooksTableMap::COL__NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [__user__] column.
     *
     * @param int $v new value
     * @return $this|\Books The current object (for fluent API support)
     */
    public function setUserSys($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__user__ !== $v) {
            $this->__user__ = $v;
            $this->modifiedColumns[BooksTableMap::COL___USER__] = true;
        }

        if ($this->auserSysRef !== null && $this->auserSysRef->getId() !== $v) {
            $this->auserSysRef = null;
        }

        return $this;
    } // setUserSys()

    /**
     * Set the value of [__config__] column.
     *
     * @param string $v new value
     * @return $this|\Books The current object (for fluent API support)
     */
    public function setConfigSys($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->__config__ !== $v) {
            $this->__config__ = $v;
            $this->modifiedColumns[BooksTableMap::COL___CONFIG__] = true;
        }

        return $this;
    } // setConfigSys()

    /**
     * Set the value of [__split__] column.
     *
     * @param string $v new value
     * @return $this|\Books The current object (for fluent API support)
     */
    public function setSplit($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->__split__ !== $v) {
            $this->__split__ = $v;
            $this->modifiedColumns[BooksTableMap::COL___SPLIT__] = true;
        }

        return $this;
    } // setSplit()

    /**
     * Set the value of [__parentnode__] column.
     *
     * @param int $v new value
     * @return $this|\Books The current object (for fluent API support)
     */
    public function setParentnode($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__parentnode__ !== $v) {
            $this->__parentnode__ = $v;
            $this->modifiedColumns[BooksTableMap::COL___PARENTNODE__] = true;
        }

        return $this;
    } // setParentnode()

    /**
     * Set the value of [__sort__] column.
     *
     * @param int $v new value
     * @return $this|\Books The current object (for fluent API support)
     */
    public function setSort($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__sort__ !== $v) {
            $this->__sort__ = $v;
            $this->modifiedColumns[BooksTableMap::COL___SORT__] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : BooksTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : BooksTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : BooksTableMap::translateFieldName('UserSys', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__user__ = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : BooksTableMap::translateFieldName('ConfigSys', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__config__ = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : BooksTableMap::translateFieldName('Split', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__split__ = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : BooksTableMap::translateFieldName('Parentnode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__parentnode__ = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : BooksTableMap::translateFieldName('Sort', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__sort__ = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = BooksTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Books'), 0, $e);
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
        if ($this->auserSysRef !== null && $this->__user__ !== $this->auserSysRef->getId()) {
            $this->auserSysRef = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(BooksTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildBooksQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->auserSysRef = null;
            $this->collRBatchForbooks = null;

            $this->collRRightsForbooks = null;

            $this->collRTemplatenamesForbooks = null;

            $this->collRDataBooks = null;

            $this->collRPluginBooks = null;

            $this->collFormatss = null;

            $this->collIssuess = null;

            $this->collBatches = null;
            $this->collRightss = null;
            $this->collTemplatenamess = null;
            $this->collRDatas = null;
            $this->collRPlugins = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Books::setDeleted()
     * @see Books::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(BooksTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildBooksQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(BooksTableMap::DATABASE_NAME);
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
                BooksTableMap::addInstanceToPool($this);
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

            if ($this->auserSysRef !== null) {
                if ($this->auserSysRef->isModified() || $this->auserSysRef->isNew()) {
                    $affectedRows += $this->auserSysRef->save($con);
                }
                $this->setuserSysRef($this->auserSysRef);
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

            if ($this->batchesScheduledForDeletion !== null) {
                if (!$this->batchesScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->batchesScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RBatchForbookQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->batchesScheduledForDeletion = null;
                }

            }

            if ($this->collBatches) {
                foreach ($this->collBatches as $batch) {
                    if (!$batch->isDeleted() && ($batch->isNew() || $batch->isModified())) {
                        $batch->save($con);
                    }
                }
            }


            if ($this->rightssScheduledForDeletion !== null) {
                if (!$this->rightssScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->rightssScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RRightsForbookQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->rightssScheduledForDeletion = null;
                }

            }

            if ($this->collRightss) {
                foreach ($this->collRightss as $rights) {
                    if (!$rights->isDeleted() && ($rights->isNew() || $rights->isModified())) {
                        $rights->save($con);
                    }
                }
            }


            if ($this->templatenamessScheduledForDeletion !== null) {
                if (!$this->templatenamessScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->templatenamessScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RTemplatenamesForbookQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->templatenamessScheduledForDeletion = null;
                }

            }

            if ($this->collTemplatenamess) {
                foreach ($this->collTemplatenamess as $templatenames) {
                    if (!$templatenames->isDeleted() && ($templatenames->isNew() || $templatenames->isModified())) {
                        $templatenames->save($con);
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

                    \RDataBookQuery::create()
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


            if ($this->rPluginsScheduledForDeletion !== null) {
                if (!$this->rPluginsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->rPluginsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RPluginBookQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->rPluginsScheduledForDeletion = null;
                }

            }

            if ($this->collRPlugins) {
                foreach ($this->collRPlugins as $rPlugin) {
                    if (!$rPlugin->isDeleted() && ($rPlugin->isNew() || $rPlugin->isModified())) {
                        $rPlugin->save($con);
                    }
                }
            }


            if ($this->rBatchForbooksScheduledForDeletion !== null) {
                if (!$this->rBatchForbooksScheduledForDeletion->isEmpty()) {
                    \RBatchForbookQuery::create()
                        ->filterByPrimaryKeys($this->rBatchForbooksScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rBatchForbooksScheduledForDeletion = null;
                }
            }

            if ($this->collRBatchForbooks !== null) {
                foreach ($this->collRBatchForbooks as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->rRightsForbooksScheduledForDeletion !== null) {
                if (!$this->rRightsForbooksScheduledForDeletion->isEmpty()) {
                    \RRightsForbookQuery::create()
                        ->filterByPrimaryKeys($this->rRightsForbooksScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rRightsForbooksScheduledForDeletion = null;
                }
            }

            if ($this->collRRightsForbooks !== null) {
                foreach ($this->collRRightsForbooks as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->rTemplatenamesForbooksScheduledForDeletion !== null) {
                if (!$this->rTemplatenamesForbooksScheduledForDeletion->isEmpty()) {
                    \RTemplatenamesForbookQuery::create()
                        ->filterByPrimaryKeys($this->rTemplatenamesForbooksScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rTemplatenamesForbooksScheduledForDeletion = null;
                }
            }

            if ($this->collRTemplatenamesForbooks !== null) {
                foreach ($this->collRTemplatenamesForbooks as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->rDataBooksScheduledForDeletion !== null) {
                if (!$this->rDataBooksScheduledForDeletion->isEmpty()) {
                    \RDataBookQuery::create()
                        ->filterByPrimaryKeys($this->rDataBooksScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rDataBooksScheduledForDeletion = null;
                }
            }

            if ($this->collRDataBooks !== null) {
                foreach ($this->collRDataBooks as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->rPluginBooksScheduledForDeletion !== null) {
                if (!$this->rPluginBooksScheduledForDeletion->isEmpty()) {
                    \RPluginBookQuery::create()
                        ->filterByPrimaryKeys($this->rPluginBooksScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rPluginBooksScheduledForDeletion = null;
                }
            }

            if ($this->collRPluginBooks !== null) {
                foreach ($this->collRPluginBooks as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->formatssScheduledForDeletion !== null) {
                if (!$this->formatssScheduledForDeletion->isEmpty()) {
                    \FormatsQuery::create()
                        ->filterByPrimaryKeys($this->formatssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->formatssScheduledForDeletion = null;
                }
            }

            if ($this->collFormatss !== null) {
                foreach ($this->collFormatss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->issuessScheduledForDeletion !== null) {
                if (!$this->issuessScheduledForDeletion->isEmpty()) {
                    \IssuesQuery::create()
                        ->filterByPrimaryKeys($this->issuessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->issuessScheduledForDeletion = null;
                }
            }

            if ($this->collIssuess !== null) {
                foreach ($this->collIssuess as $referrerFK) {
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

        $this->modifiedColumns[BooksTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . BooksTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(BooksTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(BooksTableMap::COL__NAME)) {
            $modifiedColumns[':p' . $index++]  = '_name';
        }
        if ($this->isColumnModified(BooksTableMap::COL___USER__)) {
            $modifiedColumns[':p' . $index++]  = '__user__';
        }
        if ($this->isColumnModified(BooksTableMap::COL___CONFIG__)) {
            $modifiedColumns[':p' . $index++]  = '__config__';
        }
        if ($this->isColumnModified(BooksTableMap::COL___SPLIT__)) {
            $modifiedColumns[':p' . $index++]  = '__split__';
        }
        if ($this->isColumnModified(BooksTableMap::COL___PARENTNODE__)) {
            $modifiedColumns[':p' . $index++]  = '__parentnode__';
        }
        if ($this->isColumnModified(BooksTableMap::COL___SORT__)) {
            $modifiedColumns[':p' . $index++]  = '__sort__';
        }

        $sql = sprintf(
            'INSERT INTO _books (%s) VALUES (%s)',
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
                    case '_name':
                        $stmt->bindValue($identifier, $this->_name, PDO::PARAM_STR);
                        break;
                    case '__user__':
                        $stmt->bindValue($identifier, $this->__user__, PDO::PARAM_INT);
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
        $pos = BooksTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getName();
                break;
            case 2:
                return $this->getUserSys();
                break;
            case 3:
                return $this->getConfigSys();
                break;
            case 4:
                return $this->getSplit();
                break;
            case 5:
                return $this->getParentnode();
                break;
            case 6:
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

        if (isset($alreadyDumpedObjects['Books'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Books'][$this->hashCode()] = true;
        $keys = BooksTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getUserSys(),
            $keys[3] => $this->getConfigSys(),
            $keys[4] => $this->getSplit(),
            $keys[5] => $this->getParentnode(),
            $keys[6] => $this->getSort(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->auserSysRef) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'users';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'users';
                        break;
                    default:
                        $key = 'userSysRef';
                }

                $result[$key] = $this->auserSysRef->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collRBatchForbooks) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rBatchForbooks';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_batch_forbooks';
                        break;
                    default:
                        $key = 'RBatchForbooks';
                }

                $result[$key] = $this->collRBatchForbooks->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRRightsForbooks) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rRightsForbooks';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_rights_forbooks';
                        break;
                    default:
                        $key = 'RRightsForbooks';
                }

                $result[$key] = $this->collRRightsForbooks->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRTemplatenamesForbooks) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rTemplatenamesForbooks';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_templatenames_forbooks';
                        break;
                    default:
                        $key = 'RTemplatenamesForbooks';
                }

                $result[$key] = $this->collRTemplatenamesForbooks->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRDataBooks) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rDataBooks';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_data_books';
                        break;
                    default:
                        $key = 'RDataBooks';
                }

                $result[$key] = $this->collRDataBooks->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRPluginBooks) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rPluginBooks';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_plugin_books';
                        break;
                    default:
                        $key = 'RPluginBooks';
                }

                $result[$key] = $this->collRPluginBooks->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFormatss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'formatss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = '_formatss';
                        break;
                    default:
                        $key = 'Formatss';
                }

                $result[$key] = $this->collFormatss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collIssuess) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'issuess';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = '_issuess';
                        break;
                    default:
                        $key = 'Issuess';
                }

                $result[$key] = $this->collIssuess->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Books
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = BooksTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Books
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setUserSys($value);
                break;
            case 3:
                $this->setConfigSys($value);
                break;
            case 4:
                $this->setSplit($value);
                break;
            case 5:
                $this->setParentnode($value);
                break;
            case 6:
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
        $keys = BooksTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setUserSys($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setConfigSys($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setSplit($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setParentnode($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setSort($arr[$keys[6]]);
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
     * @return $this|\Books The current object, for fluid interface
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
        $criteria = new Criteria(BooksTableMap::DATABASE_NAME);

        if ($this->isColumnModified(BooksTableMap::COL_ID)) {
            $criteria->add(BooksTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(BooksTableMap::COL__NAME)) {
            $criteria->add(BooksTableMap::COL__NAME, $this->_name);
        }
        if ($this->isColumnModified(BooksTableMap::COL___USER__)) {
            $criteria->add(BooksTableMap::COL___USER__, $this->__user__);
        }
        if ($this->isColumnModified(BooksTableMap::COL___CONFIG__)) {
            $criteria->add(BooksTableMap::COL___CONFIG__, $this->__config__);
        }
        if ($this->isColumnModified(BooksTableMap::COL___SPLIT__)) {
            $criteria->add(BooksTableMap::COL___SPLIT__, $this->__split__);
        }
        if ($this->isColumnModified(BooksTableMap::COL___PARENTNODE__)) {
            $criteria->add(BooksTableMap::COL___PARENTNODE__, $this->__parentnode__);
        }
        if ($this->isColumnModified(BooksTableMap::COL___SORT__)) {
            $criteria->add(BooksTableMap::COL___SORT__, $this->__sort__);
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
        $criteria = ChildBooksQuery::create();
        $criteria->add(BooksTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Books (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setUserSys($this->getUserSys());
        $copyObj->setConfigSys($this->getConfigSys());
        $copyObj->setSplit($this->getSplit());
        $copyObj->setParentnode($this->getParentnode());
        $copyObj->setSort($this->getSort());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getRBatchForbooks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRBatchForbook($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRRightsForbooks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRRightsForbook($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRTemplatenamesForbooks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRTemplatenamesForbook($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRDataBooks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRDataBook($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRPluginBooks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRPluginBook($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFormatss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFormats($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getIssuess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addIssues($relObj->copy($deepCopy));
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
     * @return \Books Clone of current object.
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
     * Declares an association between this object and a ChildUsers object.
     *
     * @param  ChildUsers $v
     * @return $this|\Books The current object (for fluent API support)
     * @throws PropelException
     */
    public function setuserSysRef(ChildUsers $v = null)
    {
        if ($v === null) {
            $this->setUserSys(NULL);
        } else {
            $this->setUserSys($v->getId());
        }

        $this->auserSysRef = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUsers object, it will not be re-added.
        if ($v !== null) {
            $v->addBooks($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUsers object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUsers The associated ChildUsers object.
     * @throws PropelException
     */
    public function getuserSysRef(ConnectionInterface $con = null)
    {
        if ($this->auserSysRef === null && ($this->__user__ != 0)) {
            $this->auserSysRef = ChildUsersQuery::create()->findPk($this->__user__, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->auserSysRef->addBookss($this);
             */
        }

        return $this->auserSysRef;
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
        if ('RBatchForbook' == $relationName) {
            $this->initRBatchForbooks();
            return;
        }
        if ('RRightsForbook' == $relationName) {
            $this->initRRightsForbooks();
            return;
        }
        if ('RTemplatenamesForbook' == $relationName) {
            $this->initRTemplatenamesForbooks();
            return;
        }
        if ('RDataBook' == $relationName) {
            $this->initRDataBooks();
            return;
        }
        if ('RPluginBook' == $relationName) {
            $this->initRPluginBooks();
            return;
        }
        if ('Formats' == $relationName) {
            $this->initFormatss();
            return;
        }
        if ('Issues' == $relationName) {
            $this->initIssuess();
            return;
        }
    }

    /**
     * Clears out the collRBatchForbooks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRBatchForbooks()
     */
    public function clearRBatchForbooks()
    {
        $this->collRBatchForbooks = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRBatchForbooks collection loaded partially.
     */
    public function resetPartialRBatchForbooks($v = true)
    {
        $this->collRBatchForbooksPartial = $v;
    }

    /**
     * Initializes the collRBatchForbooks collection.
     *
     * By default this just sets the collRBatchForbooks collection to an empty array (like clearcollRBatchForbooks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRBatchForbooks($overrideExisting = true)
    {
        if (null !== $this->collRBatchForbooks && !$overrideExisting) {
            return;
        }

        $collectionClassName = RBatchForbookTableMap::getTableMap()->getCollectionClassName();

        $this->collRBatchForbooks = new $collectionClassName;
        $this->collRBatchForbooks->setModel('\RBatchForbook');
    }

    /**
     * Gets an array of ChildRBatchForbook objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBooks is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRBatchForbook[] List of ChildRBatchForbook objects
     * @throws PropelException
     */
    public function getRBatchForbooks(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRBatchForbooksPartial && !$this->isNew();
        if (null === $this->collRBatchForbooks || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRBatchForbooks) {
                // return empty collection
                $this->initRBatchForbooks();
            } else {
                $collRBatchForbooks = ChildRBatchForbookQuery::create(null, $criteria)
                    ->filterByBooks($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRBatchForbooksPartial && count($collRBatchForbooks)) {
                        $this->initRBatchForbooks(false);

                        foreach ($collRBatchForbooks as $obj) {
                            if (false == $this->collRBatchForbooks->contains($obj)) {
                                $this->collRBatchForbooks->append($obj);
                            }
                        }

                        $this->collRBatchForbooksPartial = true;
                    }

                    return $collRBatchForbooks;
                }

                if ($partial && $this->collRBatchForbooks) {
                    foreach ($this->collRBatchForbooks as $obj) {
                        if ($obj->isNew()) {
                            $collRBatchForbooks[] = $obj;
                        }
                    }
                }

                $this->collRBatchForbooks = $collRBatchForbooks;
                $this->collRBatchForbooksPartial = false;
            }
        }

        return $this->collRBatchForbooks;
    }

    /**
     * Sets a collection of ChildRBatchForbook objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rBatchForbooks A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildBooks The current object (for fluent API support)
     */
    public function setRBatchForbooks(Collection $rBatchForbooks, ConnectionInterface $con = null)
    {
        /** @var ChildRBatchForbook[] $rBatchForbooksToDelete */
        $rBatchForbooksToDelete = $this->getRBatchForbooks(new Criteria(), $con)->diff($rBatchForbooks);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rBatchForbooksScheduledForDeletion = clone $rBatchForbooksToDelete;

        foreach ($rBatchForbooksToDelete as $rBatchForbookRemoved) {
            $rBatchForbookRemoved->setBooks(null);
        }

        $this->collRBatchForbooks = null;
        foreach ($rBatchForbooks as $rBatchForbook) {
            $this->addRBatchForbook($rBatchForbook);
        }

        $this->collRBatchForbooks = $rBatchForbooks;
        $this->collRBatchForbooksPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RBatchForbook objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RBatchForbook objects.
     * @throws PropelException
     */
    public function countRBatchForbooks(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRBatchForbooksPartial && !$this->isNew();
        if (null === $this->collRBatchForbooks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRBatchForbooks) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRBatchForbooks());
            }

            $query = ChildRBatchForbookQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBooks($this)
                ->count($con);
        }

        return count($this->collRBatchForbooks);
    }

    /**
     * Method called to associate a ChildRBatchForbook object to this object
     * through the ChildRBatchForbook foreign key attribute.
     *
     * @param  ChildRBatchForbook $l ChildRBatchForbook
     * @return $this|\Books The current object (for fluent API support)
     */
    public function addRBatchForbook(ChildRBatchForbook $l)
    {
        if ($this->collRBatchForbooks === null) {
            $this->initRBatchForbooks();
            $this->collRBatchForbooksPartial = true;
        }

        if (!$this->collRBatchForbooks->contains($l)) {
            $this->doAddRBatchForbook($l);

            if ($this->rBatchForbooksScheduledForDeletion and $this->rBatchForbooksScheduledForDeletion->contains($l)) {
                $this->rBatchForbooksScheduledForDeletion->remove($this->rBatchForbooksScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRBatchForbook $rBatchForbook The ChildRBatchForbook object to add.
     */
    protected function doAddRBatchForbook(ChildRBatchForbook $rBatchForbook)
    {
        $this->collRBatchForbooks[]= $rBatchForbook;
        $rBatchForbook->setBooks($this);
    }

    /**
     * @param  ChildRBatchForbook $rBatchForbook The ChildRBatchForbook object to remove.
     * @return $this|ChildBooks The current object (for fluent API support)
     */
    public function removeRBatchForbook(ChildRBatchForbook $rBatchForbook)
    {
        if ($this->getRBatchForbooks()->contains($rBatchForbook)) {
            $pos = $this->collRBatchForbooks->search($rBatchForbook);
            $this->collRBatchForbooks->remove($pos);
            if (null === $this->rBatchForbooksScheduledForDeletion) {
                $this->rBatchForbooksScheduledForDeletion = clone $this->collRBatchForbooks;
                $this->rBatchForbooksScheduledForDeletion->clear();
            }
            $this->rBatchForbooksScheduledForDeletion[]= clone $rBatchForbook;
            $rBatchForbook->setBooks(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Books is new, it will return
     * an empty collection; or if this Books has previously
     * been saved, it will retrieve related RBatchForbooks from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Books.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRBatchForbook[] List of ChildRBatchForbook objects
     */
    public function getRBatchForbooksJoinBatch(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRBatchForbookQuery::create(null, $criteria);
        $query->joinWith('Batch', $joinBehavior);

        return $this->getRBatchForbooks($query, $con);
    }

    /**
     * Clears out the collRRightsForbooks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRRightsForbooks()
     */
    public function clearRRightsForbooks()
    {
        $this->collRRightsForbooks = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRRightsForbooks collection loaded partially.
     */
    public function resetPartialRRightsForbooks($v = true)
    {
        $this->collRRightsForbooksPartial = $v;
    }

    /**
     * Initializes the collRRightsForbooks collection.
     *
     * By default this just sets the collRRightsForbooks collection to an empty array (like clearcollRRightsForbooks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRRightsForbooks($overrideExisting = true)
    {
        if (null !== $this->collRRightsForbooks && !$overrideExisting) {
            return;
        }

        $collectionClassName = RRightsForbookTableMap::getTableMap()->getCollectionClassName();

        $this->collRRightsForbooks = new $collectionClassName;
        $this->collRRightsForbooks->setModel('\RRightsForbook');
    }

    /**
     * Gets an array of ChildRRightsForbook objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBooks is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRRightsForbook[] List of ChildRRightsForbook objects
     * @throws PropelException
     */
    public function getRRightsForbooks(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRRightsForbooksPartial && !$this->isNew();
        if (null === $this->collRRightsForbooks || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRRightsForbooks) {
                // return empty collection
                $this->initRRightsForbooks();
            } else {
                $collRRightsForbooks = ChildRRightsForbookQuery::create(null, $criteria)
                    ->filterByBooks($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRRightsForbooksPartial && count($collRRightsForbooks)) {
                        $this->initRRightsForbooks(false);

                        foreach ($collRRightsForbooks as $obj) {
                            if (false == $this->collRRightsForbooks->contains($obj)) {
                                $this->collRRightsForbooks->append($obj);
                            }
                        }

                        $this->collRRightsForbooksPartial = true;
                    }

                    return $collRRightsForbooks;
                }

                if ($partial && $this->collRRightsForbooks) {
                    foreach ($this->collRRightsForbooks as $obj) {
                        if ($obj->isNew()) {
                            $collRRightsForbooks[] = $obj;
                        }
                    }
                }

                $this->collRRightsForbooks = $collRRightsForbooks;
                $this->collRRightsForbooksPartial = false;
            }
        }

        return $this->collRRightsForbooks;
    }

    /**
     * Sets a collection of ChildRRightsForbook objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rRightsForbooks A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildBooks The current object (for fluent API support)
     */
    public function setRRightsForbooks(Collection $rRightsForbooks, ConnectionInterface $con = null)
    {
        /** @var ChildRRightsForbook[] $rRightsForbooksToDelete */
        $rRightsForbooksToDelete = $this->getRRightsForbooks(new Criteria(), $con)->diff($rRightsForbooks);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rRightsForbooksScheduledForDeletion = clone $rRightsForbooksToDelete;

        foreach ($rRightsForbooksToDelete as $rRightsForbookRemoved) {
            $rRightsForbookRemoved->setBooks(null);
        }

        $this->collRRightsForbooks = null;
        foreach ($rRightsForbooks as $rRightsForbook) {
            $this->addRRightsForbook($rRightsForbook);
        }

        $this->collRRightsForbooks = $rRightsForbooks;
        $this->collRRightsForbooksPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RRightsForbook objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RRightsForbook objects.
     * @throws PropelException
     */
    public function countRRightsForbooks(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRRightsForbooksPartial && !$this->isNew();
        if (null === $this->collRRightsForbooks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRRightsForbooks) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRRightsForbooks());
            }

            $query = ChildRRightsForbookQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBooks($this)
                ->count($con);
        }

        return count($this->collRRightsForbooks);
    }

    /**
     * Method called to associate a ChildRRightsForbook object to this object
     * through the ChildRRightsForbook foreign key attribute.
     *
     * @param  ChildRRightsForbook $l ChildRRightsForbook
     * @return $this|\Books The current object (for fluent API support)
     */
    public function addRRightsForbook(ChildRRightsForbook $l)
    {
        if ($this->collRRightsForbooks === null) {
            $this->initRRightsForbooks();
            $this->collRRightsForbooksPartial = true;
        }

        if (!$this->collRRightsForbooks->contains($l)) {
            $this->doAddRRightsForbook($l);

            if ($this->rRightsForbooksScheduledForDeletion and $this->rRightsForbooksScheduledForDeletion->contains($l)) {
                $this->rRightsForbooksScheduledForDeletion->remove($this->rRightsForbooksScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRRightsForbook $rRightsForbook The ChildRRightsForbook object to add.
     */
    protected function doAddRRightsForbook(ChildRRightsForbook $rRightsForbook)
    {
        $this->collRRightsForbooks[]= $rRightsForbook;
        $rRightsForbook->setBooks($this);
    }

    /**
     * @param  ChildRRightsForbook $rRightsForbook The ChildRRightsForbook object to remove.
     * @return $this|ChildBooks The current object (for fluent API support)
     */
    public function removeRRightsForbook(ChildRRightsForbook $rRightsForbook)
    {
        if ($this->getRRightsForbooks()->contains($rRightsForbook)) {
            $pos = $this->collRRightsForbooks->search($rRightsForbook);
            $this->collRRightsForbooks->remove($pos);
            if (null === $this->rRightsForbooksScheduledForDeletion) {
                $this->rRightsForbooksScheduledForDeletion = clone $this->collRRightsForbooks;
                $this->rRightsForbooksScheduledForDeletion->clear();
            }
            $this->rRightsForbooksScheduledForDeletion[]= clone $rRightsForbook;
            $rRightsForbook->setBooks(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Books is new, it will return
     * an empty collection; or if this Books has previously
     * been saved, it will retrieve related RRightsForbooks from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Books.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRRightsForbook[] List of ChildRRightsForbook objects
     */
    public function getRRightsForbooksJoinRights(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRRightsForbookQuery::create(null, $criteria);
        $query->joinWith('Rights', $joinBehavior);

        return $this->getRRightsForbooks($query, $con);
    }

    /**
     * Clears out the collRTemplatenamesForbooks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRTemplatenamesForbooks()
     */
    public function clearRTemplatenamesForbooks()
    {
        $this->collRTemplatenamesForbooks = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRTemplatenamesForbooks collection loaded partially.
     */
    public function resetPartialRTemplatenamesForbooks($v = true)
    {
        $this->collRTemplatenamesForbooksPartial = $v;
    }

    /**
     * Initializes the collRTemplatenamesForbooks collection.
     *
     * By default this just sets the collRTemplatenamesForbooks collection to an empty array (like clearcollRTemplatenamesForbooks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRTemplatenamesForbooks($overrideExisting = true)
    {
        if (null !== $this->collRTemplatenamesForbooks && !$overrideExisting) {
            return;
        }

        $collectionClassName = RTemplatenamesForbookTableMap::getTableMap()->getCollectionClassName();

        $this->collRTemplatenamesForbooks = new $collectionClassName;
        $this->collRTemplatenamesForbooks->setModel('\RTemplatenamesForbook');
    }

    /**
     * Gets an array of ChildRTemplatenamesForbook objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBooks is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRTemplatenamesForbook[] List of ChildRTemplatenamesForbook objects
     * @throws PropelException
     */
    public function getRTemplatenamesForbooks(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRTemplatenamesForbooksPartial && !$this->isNew();
        if (null === $this->collRTemplatenamesForbooks || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRTemplatenamesForbooks) {
                // return empty collection
                $this->initRTemplatenamesForbooks();
            } else {
                $collRTemplatenamesForbooks = ChildRTemplatenamesForbookQuery::create(null, $criteria)
                    ->filterByBooks($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRTemplatenamesForbooksPartial && count($collRTemplatenamesForbooks)) {
                        $this->initRTemplatenamesForbooks(false);

                        foreach ($collRTemplatenamesForbooks as $obj) {
                            if (false == $this->collRTemplatenamesForbooks->contains($obj)) {
                                $this->collRTemplatenamesForbooks->append($obj);
                            }
                        }

                        $this->collRTemplatenamesForbooksPartial = true;
                    }

                    return $collRTemplatenamesForbooks;
                }

                if ($partial && $this->collRTemplatenamesForbooks) {
                    foreach ($this->collRTemplatenamesForbooks as $obj) {
                        if ($obj->isNew()) {
                            $collRTemplatenamesForbooks[] = $obj;
                        }
                    }
                }

                $this->collRTemplatenamesForbooks = $collRTemplatenamesForbooks;
                $this->collRTemplatenamesForbooksPartial = false;
            }
        }

        return $this->collRTemplatenamesForbooks;
    }

    /**
     * Sets a collection of ChildRTemplatenamesForbook objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rTemplatenamesForbooks A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildBooks The current object (for fluent API support)
     */
    public function setRTemplatenamesForbooks(Collection $rTemplatenamesForbooks, ConnectionInterface $con = null)
    {
        /** @var ChildRTemplatenamesForbook[] $rTemplatenamesForbooksToDelete */
        $rTemplatenamesForbooksToDelete = $this->getRTemplatenamesForbooks(new Criteria(), $con)->diff($rTemplatenamesForbooks);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rTemplatenamesForbooksScheduledForDeletion = clone $rTemplatenamesForbooksToDelete;

        foreach ($rTemplatenamesForbooksToDelete as $rTemplatenamesForbookRemoved) {
            $rTemplatenamesForbookRemoved->setBooks(null);
        }

        $this->collRTemplatenamesForbooks = null;
        foreach ($rTemplatenamesForbooks as $rTemplatenamesForbook) {
            $this->addRTemplatenamesForbook($rTemplatenamesForbook);
        }

        $this->collRTemplatenamesForbooks = $rTemplatenamesForbooks;
        $this->collRTemplatenamesForbooksPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RTemplatenamesForbook objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RTemplatenamesForbook objects.
     * @throws PropelException
     */
    public function countRTemplatenamesForbooks(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRTemplatenamesForbooksPartial && !$this->isNew();
        if (null === $this->collRTemplatenamesForbooks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRTemplatenamesForbooks) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRTemplatenamesForbooks());
            }

            $query = ChildRTemplatenamesForbookQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBooks($this)
                ->count($con);
        }

        return count($this->collRTemplatenamesForbooks);
    }

    /**
     * Method called to associate a ChildRTemplatenamesForbook object to this object
     * through the ChildRTemplatenamesForbook foreign key attribute.
     *
     * @param  ChildRTemplatenamesForbook $l ChildRTemplatenamesForbook
     * @return $this|\Books The current object (for fluent API support)
     */
    public function addRTemplatenamesForbook(ChildRTemplatenamesForbook $l)
    {
        if ($this->collRTemplatenamesForbooks === null) {
            $this->initRTemplatenamesForbooks();
            $this->collRTemplatenamesForbooksPartial = true;
        }

        if (!$this->collRTemplatenamesForbooks->contains($l)) {
            $this->doAddRTemplatenamesForbook($l);

            if ($this->rTemplatenamesForbooksScheduledForDeletion and $this->rTemplatenamesForbooksScheduledForDeletion->contains($l)) {
                $this->rTemplatenamesForbooksScheduledForDeletion->remove($this->rTemplatenamesForbooksScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRTemplatenamesForbook $rTemplatenamesForbook The ChildRTemplatenamesForbook object to add.
     */
    protected function doAddRTemplatenamesForbook(ChildRTemplatenamesForbook $rTemplatenamesForbook)
    {
        $this->collRTemplatenamesForbooks[]= $rTemplatenamesForbook;
        $rTemplatenamesForbook->setBooks($this);
    }

    /**
     * @param  ChildRTemplatenamesForbook $rTemplatenamesForbook The ChildRTemplatenamesForbook object to remove.
     * @return $this|ChildBooks The current object (for fluent API support)
     */
    public function removeRTemplatenamesForbook(ChildRTemplatenamesForbook $rTemplatenamesForbook)
    {
        if ($this->getRTemplatenamesForbooks()->contains($rTemplatenamesForbook)) {
            $pos = $this->collRTemplatenamesForbooks->search($rTemplatenamesForbook);
            $this->collRTemplatenamesForbooks->remove($pos);
            if (null === $this->rTemplatenamesForbooksScheduledForDeletion) {
                $this->rTemplatenamesForbooksScheduledForDeletion = clone $this->collRTemplatenamesForbooks;
                $this->rTemplatenamesForbooksScheduledForDeletion->clear();
            }
            $this->rTemplatenamesForbooksScheduledForDeletion[]= clone $rTemplatenamesForbook;
            $rTemplatenamesForbook->setBooks(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Books is new, it will return
     * an empty collection; or if this Books has previously
     * been saved, it will retrieve related RTemplatenamesForbooks from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Books.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRTemplatenamesForbook[] List of ChildRTemplatenamesForbook objects
     */
    public function getRTemplatenamesForbooksJoinTemplatenames(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRTemplatenamesForbookQuery::create(null, $criteria);
        $query->joinWith('Templatenames', $joinBehavior);

        return $this->getRTemplatenamesForbooks($query, $con);
    }

    /**
     * Clears out the collRDataBooks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRDataBooks()
     */
    public function clearRDataBooks()
    {
        $this->collRDataBooks = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRDataBooks collection loaded partially.
     */
    public function resetPartialRDataBooks($v = true)
    {
        $this->collRDataBooksPartial = $v;
    }

    /**
     * Initializes the collRDataBooks collection.
     *
     * By default this just sets the collRDataBooks collection to an empty array (like clearcollRDataBooks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRDataBooks($overrideExisting = true)
    {
        if (null !== $this->collRDataBooks && !$overrideExisting) {
            return;
        }

        $collectionClassName = RDataBookTableMap::getTableMap()->getCollectionClassName();

        $this->collRDataBooks = new $collectionClassName;
        $this->collRDataBooks->setModel('\RDataBook');
    }

    /**
     * Gets an array of ChildRDataBook objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBooks is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRDataBook[] List of ChildRDataBook objects
     * @throws PropelException
     */
    public function getRDataBooks(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRDataBooksPartial && !$this->isNew();
        if (null === $this->collRDataBooks || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRDataBooks) {
                // return empty collection
                $this->initRDataBooks();
            } else {
                $collRDataBooks = ChildRDataBookQuery::create(null, $criteria)
                    ->filterByRBook($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRDataBooksPartial && count($collRDataBooks)) {
                        $this->initRDataBooks(false);

                        foreach ($collRDataBooks as $obj) {
                            if (false == $this->collRDataBooks->contains($obj)) {
                                $this->collRDataBooks->append($obj);
                            }
                        }

                        $this->collRDataBooksPartial = true;
                    }

                    return $collRDataBooks;
                }

                if ($partial && $this->collRDataBooks) {
                    foreach ($this->collRDataBooks as $obj) {
                        if ($obj->isNew()) {
                            $collRDataBooks[] = $obj;
                        }
                    }
                }

                $this->collRDataBooks = $collRDataBooks;
                $this->collRDataBooksPartial = false;
            }
        }

        return $this->collRDataBooks;
    }

    /**
     * Sets a collection of ChildRDataBook objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rDataBooks A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildBooks The current object (for fluent API support)
     */
    public function setRDataBooks(Collection $rDataBooks, ConnectionInterface $con = null)
    {
        /** @var ChildRDataBook[] $rDataBooksToDelete */
        $rDataBooksToDelete = $this->getRDataBooks(new Criteria(), $con)->diff($rDataBooks);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rDataBooksScheduledForDeletion = clone $rDataBooksToDelete;

        foreach ($rDataBooksToDelete as $rDataBookRemoved) {
            $rDataBookRemoved->setRBook(null);
        }

        $this->collRDataBooks = null;
        foreach ($rDataBooks as $rDataBook) {
            $this->addRDataBook($rDataBook);
        }

        $this->collRDataBooks = $rDataBooks;
        $this->collRDataBooksPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RDataBook objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RDataBook objects.
     * @throws PropelException
     */
    public function countRDataBooks(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRDataBooksPartial && !$this->isNew();
        if (null === $this->collRDataBooks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRDataBooks) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRDataBooks());
            }

            $query = ChildRDataBookQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRBook($this)
                ->count($con);
        }

        return count($this->collRDataBooks);
    }

    /**
     * Method called to associate a ChildRDataBook object to this object
     * through the ChildRDataBook foreign key attribute.
     *
     * @param  ChildRDataBook $l ChildRDataBook
     * @return $this|\Books The current object (for fluent API support)
     */
    public function addRDataBook(ChildRDataBook $l)
    {
        if ($this->collRDataBooks === null) {
            $this->initRDataBooks();
            $this->collRDataBooksPartial = true;
        }

        if (!$this->collRDataBooks->contains($l)) {
            $this->doAddRDataBook($l);

            if ($this->rDataBooksScheduledForDeletion and $this->rDataBooksScheduledForDeletion->contains($l)) {
                $this->rDataBooksScheduledForDeletion->remove($this->rDataBooksScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRDataBook $rDataBook The ChildRDataBook object to add.
     */
    protected function doAddRDataBook(ChildRDataBook $rDataBook)
    {
        $this->collRDataBooks[]= $rDataBook;
        $rDataBook->setRBook($this);
    }

    /**
     * @param  ChildRDataBook $rDataBook The ChildRDataBook object to remove.
     * @return $this|ChildBooks The current object (for fluent API support)
     */
    public function removeRDataBook(ChildRDataBook $rDataBook)
    {
        if ($this->getRDataBooks()->contains($rDataBook)) {
            $pos = $this->collRDataBooks->search($rDataBook);
            $this->collRDataBooks->remove($pos);
            if (null === $this->rDataBooksScheduledForDeletion) {
                $this->rDataBooksScheduledForDeletion = clone $this->collRDataBooks;
                $this->rDataBooksScheduledForDeletion->clear();
            }
            $this->rDataBooksScheduledForDeletion[]= clone $rDataBook;
            $rDataBook->setRBook(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Books is new, it will return
     * an empty collection; or if this Books has previously
     * been saved, it will retrieve related RDataBooks from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Books.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRDataBook[] List of ChildRDataBook objects
     */
    public function getRDataBooksJoinRData(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRDataBookQuery::create(null, $criteria);
        $query->joinWith('RData', $joinBehavior);

        return $this->getRDataBooks($query, $con);
    }

    /**
     * Clears out the collRPluginBooks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRPluginBooks()
     */
    public function clearRPluginBooks()
    {
        $this->collRPluginBooks = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRPluginBooks collection loaded partially.
     */
    public function resetPartialRPluginBooks($v = true)
    {
        $this->collRPluginBooksPartial = $v;
    }

    /**
     * Initializes the collRPluginBooks collection.
     *
     * By default this just sets the collRPluginBooks collection to an empty array (like clearcollRPluginBooks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRPluginBooks($overrideExisting = true)
    {
        if (null !== $this->collRPluginBooks && !$overrideExisting) {
            return;
        }

        $collectionClassName = RPluginBookTableMap::getTableMap()->getCollectionClassName();

        $this->collRPluginBooks = new $collectionClassName;
        $this->collRPluginBooks->setModel('\RPluginBook');
    }

    /**
     * Gets an array of ChildRPluginBook objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBooks is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRPluginBook[] List of ChildRPluginBook objects
     * @throws PropelException
     */
    public function getRPluginBooks(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRPluginBooksPartial && !$this->isNew();
        if (null === $this->collRPluginBooks || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRPluginBooks) {
                // return empty collection
                $this->initRPluginBooks();
            } else {
                $collRPluginBooks = ChildRPluginBookQuery::create(null, $criteria)
                    ->filterByRBook($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRPluginBooksPartial && count($collRPluginBooks)) {
                        $this->initRPluginBooks(false);

                        foreach ($collRPluginBooks as $obj) {
                            if (false == $this->collRPluginBooks->contains($obj)) {
                                $this->collRPluginBooks->append($obj);
                            }
                        }

                        $this->collRPluginBooksPartial = true;
                    }

                    return $collRPluginBooks;
                }

                if ($partial && $this->collRPluginBooks) {
                    foreach ($this->collRPluginBooks as $obj) {
                        if ($obj->isNew()) {
                            $collRPluginBooks[] = $obj;
                        }
                    }
                }

                $this->collRPluginBooks = $collRPluginBooks;
                $this->collRPluginBooksPartial = false;
            }
        }

        return $this->collRPluginBooks;
    }

    /**
     * Sets a collection of ChildRPluginBook objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rPluginBooks A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildBooks The current object (for fluent API support)
     */
    public function setRPluginBooks(Collection $rPluginBooks, ConnectionInterface $con = null)
    {
        /** @var ChildRPluginBook[] $rPluginBooksToDelete */
        $rPluginBooksToDelete = $this->getRPluginBooks(new Criteria(), $con)->diff($rPluginBooks);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rPluginBooksScheduledForDeletion = clone $rPluginBooksToDelete;

        foreach ($rPluginBooksToDelete as $rPluginBookRemoved) {
            $rPluginBookRemoved->setRBook(null);
        }

        $this->collRPluginBooks = null;
        foreach ($rPluginBooks as $rPluginBook) {
            $this->addRPluginBook($rPluginBook);
        }

        $this->collRPluginBooks = $rPluginBooks;
        $this->collRPluginBooksPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RPluginBook objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RPluginBook objects.
     * @throws PropelException
     */
    public function countRPluginBooks(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRPluginBooksPartial && !$this->isNew();
        if (null === $this->collRPluginBooks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRPluginBooks) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRPluginBooks());
            }

            $query = ChildRPluginBookQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRBook($this)
                ->count($con);
        }

        return count($this->collRPluginBooks);
    }

    /**
     * Method called to associate a ChildRPluginBook object to this object
     * through the ChildRPluginBook foreign key attribute.
     *
     * @param  ChildRPluginBook $l ChildRPluginBook
     * @return $this|\Books The current object (for fluent API support)
     */
    public function addRPluginBook(ChildRPluginBook $l)
    {
        if ($this->collRPluginBooks === null) {
            $this->initRPluginBooks();
            $this->collRPluginBooksPartial = true;
        }

        if (!$this->collRPluginBooks->contains($l)) {
            $this->doAddRPluginBook($l);

            if ($this->rPluginBooksScheduledForDeletion and $this->rPluginBooksScheduledForDeletion->contains($l)) {
                $this->rPluginBooksScheduledForDeletion->remove($this->rPluginBooksScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRPluginBook $rPluginBook The ChildRPluginBook object to add.
     */
    protected function doAddRPluginBook(ChildRPluginBook $rPluginBook)
    {
        $this->collRPluginBooks[]= $rPluginBook;
        $rPluginBook->setRBook($this);
    }

    /**
     * @param  ChildRPluginBook $rPluginBook The ChildRPluginBook object to remove.
     * @return $this|ChildBooks The current object (for fluent API support)
     */
    public function removeRPluginBook(ChildRPluginBook $rPluginBook)
    {
        if ($this->getRPluginBooks()->contains($rPluginBook)) {
            $pos = $this->collRPluginBooks->search($rPluginBook);
            $this->collRPluginBooks->remove($pos);
            if (null === $this->rPluginBooksScheduledForDeletion) {
                $this->rPluginBooksScheduledForDeletion = clone $this->collRPluginBooks;
                $this->rPluginBooksScheduledForDeletion->clear();
            }
            $this->rPluginBooksScheduledForDeletion[]= clone $rPluginBook;
            $rPluginBook->setRBook(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Books is new, it will return
     * an empty collection; or if this Books has previously
     * been saved, it will retrieve related RPluginBooks from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Books.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRPluginBook[] List of ChildRPluginBook objects
     */
    public function getRPluginBooksJoinRPlugin(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRPluginBookQuery::create(null, $criteria);
        $query->joinWith('RPlugin', $joinBehavior);

        return $this->getRPluginBooks($query, $con);
    }

    /**
     * Clears out the collFormatss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFormatss()
     */
    public function clearFormatss()
    {
        $this->collFormatss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collFormatss collection loaded partially.
     */
    public function resetPartialFormatss($v = true)
    {
        $this->collFormatssPartial = $v;
    }

    /**
     * Initializes the collFormatss collection.
     *
     * By default this just sets the collFormatss collection to an empty array (like clearcollFormatss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFormatss($overrideExisting = true)
    {
        if (null !== $this->collFormatss && !$overrideExisting) {
            return;
        }

        $collectionClassName = FormatsTableMap::getTableMap()->getCollectionClassName();

        $this->collFormatss = new $collectionClassName;
        $this->collFormatss->setModel('\Formats');
    }

    /**
     * Gets an array of ChildFormats objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBooks is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildFormats[] List of ChildFormats objects
     * @throws PropelException
     */
    public function getFormatss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFormatssPartial && !$this->isNew();
        if (null === $this->collFormatss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFormatss) {
                // return empty collection
                $this->initFormatss();
            } else {
                $collFormatss = ChildFormatsQuery::create(null, $criteria)
                    ->filterByBooks($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collFormatssPartial && count($collFormatss)) {
                        $this->initFormatss(false);

                        foreach ($collFormatss as $obj) {
                            if (false == $this->collFormatss->contains($obj)) {
                                $this->collFormatss->append($obj);
                            }
                        }

                        $this->collFormatssPartial = true;
                    }

                    return $collFormatss;
                }

                if ($partial && $this->collFormatss) {
                    foreach ($this->collFormatss as $obj) {
                        if ($obj->isNew()) {
                            $collFormatss[] = $obj;
                        }
                    }
                }

                $this->collFormatss = $collFormatss;
                $this->collFormatssPartial = false;
            }
        }

        return $this->collFormatss;
    }

    /**
     * Sets a collection of ChildFormats objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $formatss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildBooks The current object (for fluent API support)
     */
    public function setFormatss(Collection $formatss, ConnectionInterface $con = null)
    {
        /** @var ChildFormats[] $formatssToDelete */
        $formatssToDelete = $this->getFormatss(new Criteria(), $con)->diff($formatss);


        $this->formatssScheduledForDeletion = $formatssToDelete;

        foreach ($formatssToDelete as $formatsRemoved) {
            $formatsRemoved->setBooks(null);
        }

        $this->collFormatss = null;
        foreach ($formatss as $formats) {
            $this->addFormats($formats);
        }

        $this->collFormatss = $formatss;
        $this->collFormatssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Formats objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Formats objects.
     * @throws PropelException
     */
    public function countFormatss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFormatssPartial && !$this->isNew();
        if (null === $this->collFormatss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFormatss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFormatss());
            }

            $query = ChildFormatsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBooks($this)
                ->count($con);
        }

        return count($this->collFormatss);
    }

    /**
     * Method called to associate a ChildFormats object to this object
     * through the ChildFormats foreign key attribute.
     *
     * @param  ChildFormats $l ChildFormats
     * @return $this|\Books The current object (for fluent API support)
     */
    public function addFormats(ChildFormats $l)
    {
        if ($this->collFormatss === null) {
            $this->initFormatss();
            $this->collFormatssPartial = true;
        }

        if (!$this->collFormatss->contains($l)) {
            $this->doAddFormats($l);

            if ($this->formatssScheduledForDeletion and $this->formatssScheduledForDeletion->contains($l)) {
                $this->formatssScheduledForDeletion->remove($this->formatssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildFormats $formats The ChildFormats object to add.
     */
    protected function doAddFormats(ChildFormats $formats)
    {
        $this->collFormatss[]= $formats;
        $formats->setBooks($this);
    }

    /**
     * @param  ChildFormats $formats The ChildFormats object to remove.
     * @return $this|ChildBooks The current object (for fluent API support)
     */
    public function removeFormats(ChildFormats $formats)
    {
        if ($this->getFormatss()->contains($formats)) {
            $pos = $this->collFormatss->search($formats);
            $this->collFormatss->remove($pos);
            if (null === $this->formatssScheduledForDeletion) {
                $this->formatssScheduledForDeletion = clone $this->collFormatss;
                $this->formatssScheduledForDeletion->clear();
            }
            $this->formatssScheduledForDeletion[]= $formats;
            $formats->setBooks(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Books is new, it will return
     * an empty collection; or if this Books has previously
     * been saved, it will retrieve related Formatss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Books.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildFormats[] List of ChildFormats objects
     */
    public function getFormatssJoinuserSysRef(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFormatsQuery::create(null, $criteria);
        $query->joinWith('userSysRef', $joinBehavior);

        return $this->getFormatss($query, $con);
    }

    /**
     * Clears out the collIssuess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addIssuess()
     */
    public function clearIssuess()
    {
        $this->collIssuess = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collIssuess collection loaded partially.
     */
    public function resetPartialIssuess($v = true)
    {
        $this->collIssuessPartial = $v;
    }

    /**
     * Initializes the collIssuess collection.
     *
     * By default this just sets the collIssuess collection to an empty array (like clearcollIssuess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initIssuess($overrideExisting = true)
    {
        if (null !== $this->collIssuess && !$overrideExisting) {
            return;
        }

        $collectionClassName = IssuesTableMap::getTableMap()->getCollectionClassName();

        $this->collIssuess = new $collectionClassName;
        $this->collIssuess->setModel('\Issues');
    }

    /**
     * Gets an array of ChildIssues objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBooks is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildIssues[] List of ChildIssues objects
     * @throws PropelException
     */
    public function getIssuess(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collIssuessPartial && !$this->isNew();
        if (null === $this->collIssuess || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collIssuess) {
                // return empty collection
                $this->initIssuess();
            } else {
                $collIssuess = ChildIssuesQuery::create(null, $criteria)
                    ->filterByBooks($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collIssuessPartial && count($collIssuess)) {
                        $this->initIssuess(false);

                        foreach ($collIssuess as $obj) {
                            if (false == $this->collIssuess->contains($obj)) {
                                $this->collIssuess->append($obj);
                            }
                        }

                        $this->collIssuessPartial = true;
                    }

                    return $collIssuess;
                }

                if ($partial && $this->collIssuess) {
                    foreach ($this->collIssuess as $obj) {
                        if ($obj->isNew()) {
                            $collIssuess[] = $obj;
                        }
                    }
                }

                $this->collIssuess = $collIssuess;
                $this->collIssuessPartial = false;
            }
        }

        return $this->collIssuess;
    }

    /**
     * Sets a collection of ChildIssues objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $issuess A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildBooks The current object (for fluent API support)
     */
    public function setIssuess(Collection $issuess, ConnectionInterface $con = null)
    {
        /** @var ChildIssues[] $issuessToDelete */
        $issuessToDelete = $this->getIssuess(new Criteria(), $con)->diff($issuess);


        $this->issuessScheduledForDeletion = $issuessToDelete;

        foreach ($issuessToDelete as $issuesRemoved) {
            $issuesRemoved->setBooks(null);
        }

        $this->collIssuess = null;
        foreach ($issuess as $issues) {
            $this->addIssues($issues);
        }

        $this->collIssuess = $issuess;
        $this->collIssuessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Issues objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Issues objects.
     * @throws PropelException
     */
    public function countIssuess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collIssuessPartial && !$this->isNew();
        if (null === $this->collIssuess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collIssuess) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getIssuess());
            }

            $query = ChildIssuesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBooks($this)
                ->count($con);
        }

        return count($this->collIssuess);
    }

    /**
     * Method called to associate a ChildIssues object to this object
     * through the ChildIssues foreign key attribute.
     *
     * @param  ChildIssues $l ChildIssues
     * @return $this|\Books The current object (for fluent API support)
     */
    public function addIssues(ChildIssues $l)
    {
        if ($this->collIssuess === null) {
            $this->initIssuess();
            $this->collIssuessPartial = true;
        }

        if (!$this->collIssuess->contains($l)) {
            $this->doAddIssues($l);

            if ($this->issuessScheduledForDeletion and $this->issuessScheduledForDeletion->contains($l)) {
                $this->issuessScheduledForDeletion->remove($this->issuessScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildIssues $issues The ChildIssues object to add.
     */
    protected function doAddIssues(ChildIssues $issues)
    {
        $this->collIssuess[]= $issues;
        $issues->setBooks($this);
    }

    /**
     * @param  ChildIssues $issues The ChildIssues object to remove.
     * @return $this|ChildBooks The current object (for fluent API support)
     */
    public function removeIssues(ChildIssues $issues)
    {
        if ($this->getIssuess()->contains($issues)) {
            $pos = $this->collIssuess->search($issues);
            $this->collIssuess->remove($pos);
            if (null === $this->issuessScheduledForDeletion) {
                $this->issuessScheduledForDeletion = clone $this->collIssuess;
                $this->issuessScheduledForDeletion->clear();
            }
            $this->issuessScheduledForDeletion[]= $issues;
            $issues->setBooks(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Books is new, it will return
     * an empty collection; or if this Books has previously
     * been saved, it will retrieve related Issuess from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Books.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildIssues[] List of ChildIssues objects
     */
    public function getIssuessJoinuserSysRef(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildIssuesQuery::create(null, $criteria);
        $query->joinWith('userSysRef', $joinBehavior);

        return $this->getIssuess($query, $con);
    }

    /**
     * Clears out the collBatches collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addBatches()
     */
    public function clearBatches()
    {
        $this->collBatches = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collBatches crossRef collection.
     *
     * By default this just sets the collBatches collection to an empty collection (like clearBatches());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initBatches()
    {
        $collectionClassName = RBatchForbookTableMap::getTableMap()->getCollectionClassName();

        $this->collBatches = new $collectionClassName;
        $this->collBatchesPartial = true;
        $this->collBatches->setModel('\Batch');
    }

    /**
     * Checks if the collBatches collection is loaded.
     *
     * @return bool
     */
    public function isBatchesLoaded()
    {
        return null !== $this->collBatches;
    }

    /**
     * Gets a collection of ChildBatch objects related by a many-to-many relationship
     * to the current object by way of the R_batch_forbook cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBooks is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildBatch[] List of ChildBatch objects
     */
    public function getBatches(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBatchesPartial && !$this->isNew();
        if (null === $this->collBatches || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collBatches) {
                    $this->initBatches();
                }
            } else {

                $query = ChildBatchQuery::create(null, $criteria)
                    ->filterByBooks($this);
                $collBatches = $query->find($con);
                if (null !== $criteria) {
                    return $collBatches;
                }

                if ($partial && $this->collBatches) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collBatches as $obj) {
                        if (!$collBatches->contains($obj)) {
                            $collBatches[] = $obj;
                        }
                    }
                }

                $this->collBatches = $collBatches;
                $this->collBatchesPartial = false;
            }
        }

        return $this->collBatches;
    }

    /**
     * Sets a collection of Batch objects related by a many-to-many relationship
     * to the current object by way of the R_batch_forbook cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $batches A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildBooks The current object (for fluent API support)
     */
    public function setBatches(Collection $batches, ConnectionInterface $con = null)
    {
        $this->clearBatches();
        $currentBatches = $this->getBatches();

        $batchesScheduledForDeletion = $currentBatches->diff($batches);

        foreach ($batchesScheduledForDeletion as $toDelete) {
            $this->removeBatch($toDelete);
        }

        foreach ($batches as $batch) {
            if (!$currentBatches->contains($batch)) {
                $this->doAddBatch($batch);
            }
        }

        $this->collBatchesPartial = false;
        $this->collBatches = $batches;

        return $this;
    }

    /**
     * Gets the number of Batch objects related by a many-to-many relationship
     * to the current object by way of the R_batch_forbook cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Batch objects
     */
    public function countBatches(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBatchesPartial && !$this->isNew();
        if (null === $this->collBatches || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBatches) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getBatches());
                }

                $query = ChildBatchQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByBooks($this)
                    ->count($con);
            }
        } else {
            return count($this->collBatches);
        }
    }

    /**
     * Associate a ChildBatch to this object
     * through the R_batch_forbook cross reference table.
     *
     * @param ChildBatch $batch
     * @return ChildBooks The current object (for fluent API support)
     */
    public function addBatch(ChildBatch $batch)
    {
        if ($this->collBatches === null) {
            $this->initBatches();
        }

        if (!$this->getBatches()->contains($batch)) {
            // only add it if the **same** object is not already associated
            $this->collBatches->push($batch);
            $this->doAddBatch($batch);
        }

        return $this;
    }

    /**
     *
     * @param ChildBatch $batch
     */
    protected function doAddBatch(ChildBatch $batch)
    {
        $rBatchForbook = new ChildRBatchForbook();

        $rBatchForbook->setBatch($batch);

        $rBatchForbook->setBooks($this);

        $this->addRBatchForbook($rBatchForbook);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$batch->isBookssLoaded()) {
            $batch->initBookss();
            $batch->getBookss()->push($this);
        } elseif (!$batch->getBookss()->contains($this)) {
            $batch->getBookss()->push($this);
        }

    }

    /**
     * Remove batch of this object
     * through the R_batch_forbook cross reference table.
     *
     * @param ChildBatch $batch
     * @return ChildBooks The current object (for fluent API support)
     */
    public function removeBatch(ChildBatch $batch)
    {
        if ($this->getBatches()->contains($batch)) {
            $rBatchForbook = new ChildRBatchForbook();
            $rBatchForbook->setBatch($batch);
            if ($batch->isBookssLoaded()) {
                //remove the back reference if available
                $batch->getBookss()->removeObject($this);
            }

            $rBatchForbook->setBooks($this);
            $this->removeRBatchForbook(clone $rBatchForbook);
            $rBatchForbook->clear();

            $this->collBatches->remove($this->collBatches->search($batch));

            if (null === $this->batchesScheduledForDeletion) {
                $this->batchesScheduledForDeletion = clone $this->collBatches;
                $this->batchesScheduledForDeletion->clear();
            }

            $this->batchesScheduledForDeletion->push($batch);
        }


        return $this;
    }

    /**
     * Clears out the collRightss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRightss()
     */
    public function clearRightss()
    {
        $this->collRightss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collRightss crossRef collection.
     *
     * By default this just sets the collRightss collection to an empty collection (like clearRightss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initRightss()
    {
        $collectionClassName = RRightsForbookTableMap::getTableMap()->getCollectionClassName();

        $this->collRightss = new $collectionClassName;
        $this->collRightssPartial = true;
        $this->collRightss->setModel('\Rights');
    }

    /**
     * Checks if the collRightss collection is loaded.
     *
     * @return bool
     */
    public function isRightssLoaded()
    {
        return null !== $this->collRightss;
    }

    /**
     * Gets a collection of ChildRights objects related by a many-to-many relationship
     * to the current object by way of the R_rights_forbook cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBooks is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildRights[] List of ChildRights objects
     */
    public function getRightss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRightssPartial && !$this->isNew();
        if (null === $this->collRightss || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collRightss) {
                    $this->initRightss();
                }
            } else {

                $query = ChildRightsQuery::create(null, $criteria)
                    ->filterByBooks($this);
                $collRightss = $query->find($con);
                if (null !== $criteria) {
                    return $collRightss;
                }

                if ($partial && $this->collRightss) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collRightss as $obj) {
                        if (!$collRightss->contains($obj)) {
                            $collRightss[] = $obj;
                        }
                    }
                }

                $this->collRightss = $collRightss;
                $this->collRightssPartial = false;
            }
        }

        return $this->collRightss;
    }

    /**
     * Sets a collection of Rights objects related by a many-to-many relationship
     * to the current object by way of the R_rights_forbook cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $rightss A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildBooks The current object (for fluent API support)
     */
    public function setRightss(Collection $rightss, ConnectionInterface $con = null)
    {
        $this->clearRightss();
        $currentRightss = $this->getRightss();

        $rightssScheduledForDeletion = $currentRightss->diff($rightss);

        foreach ($rightssScheduledForDeletion as $toDelete) {
            $this->removeRights($toDelete);
        }

        foreach ($rightss as $rights) {
            if (!$currentRightss->contains($rights)) {
                $this->doAddRights($rights);
            }
        }

        $this->collRightssPartial = false;
        $this->collRightss = $rightss;

        return $this;
    }

    /**
     * Gets the number of Rights objects related by a many-to-many relationship
     * to the current object by way of the R_rights_forbook cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Rights objects
     */
    public function countRightss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRightssPartial && !$this->isNew();
        if (null === $this->collRightss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRightss) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getRightss());
                }

                $query = ChildRightsQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByBooks($this)
                    ->count($con);
            }
        } else {
            return count($this->collRightss);
        }
    }

    /**
     * Associate a ChildRights to this object
     * through the R_rights_forbook cross reference table.
     *
     * @param ChildRights $rights
     * @return ChildBooks The current object (for fluent API support)
     */
    public function addRights(ChildRights $rights)
    {
        if ($this->collRightss === null) {
            $this->initRightss();
        }

        if (!$this->getRightss()->contains($rights)) {
            // only add it if the **same** object is not already associated
            $this->collRightss->push($rights);
            $this->doAddRights($rights);
        }

        return $this;
    }

    /**
     *
     * @param ChildRights $rights
     */
    protected function doAddRights(ChildRights $rights)
    {
        $rRightsForbook = new ChildRRightsForbook();

        $rRightsForbook->setRights($rights);

        $rRightsForbook->setBooks($this);

        $this->addRRightsForbook($rRightsForbook);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$rights->isBookssLoaded()) {
            $rights->initBookss();
            $rights->getBookss()->push($this);
        } elseif (!$rights->getBookss()->contains($this)) {
            $rights->getBookss()->push($this);
        }

    }

    /**
     * Remove rights of this object
     * through the R_rights_forbook cross reference table.
     *
     * @param ChildRights $rights
     * @return ChildBooks The current object (for fluent API support)
     */
    public function removeRights(ChildRights $rights)
    {
        if ($this->getRightss()->contains($rights)) {
            $rRightsForbook = new ChildRRightsForbook();
            $rRightsForbook->setRights($rights);
            if ($rights->isBookssLoaded()) {
                //remove the back reference if available
                $rights->getBookss()->removeObject($this);
            }

            $rRightsForbook->setBooks($this);
            $this->removeRRightsForbook(clone $rRightsForbook);
            $rRightsForbook->clear();

            $this->collRightss->remove($this->collRightss->search($rights));

            if (null === $this->rightssScheduledForDeletion) {
                $this->rightssScheduledForDeletion = clone $this->collRightss;
                $this->rightssScheduledForDeletion->clear();
            }

            $this->rightssScheduledForDeletion->push($rights);
        }


        return $this;
    }

    /**
     * Clears out the collTemplatenamess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTemplatenamess()
     */
    public function clearTemplatenamess()
    {
        $this->collTemplatenamess = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collTemplatenamess crossRef collection.
     *
     * By default this just sets the collTemplatenamess collection to an empty collection (like clearTemplatenamess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initTemplatenamess()
    {
        $collectionClassName = RTemplatenamesForbookTableMap::getTableMap()->getCollectionClassName();

        $this->collTemplatenamess = new $collectionClassName;
        $this->collTemplatenamessPartial = true;
        $this->collTemplatenamess->setModel('\Templatenames');
    }

    /**
     * Checks if the collTemplatenamess collection is loaded.
     *
     * @return bool
     */
    public function isTemplatenamessLoaded()
    {
        return null !== $this->collTemplatenamess;
    }

    /**
     * Gets a collection of ChildTemplatenames objects related by a many-to-many relationship
     * to the current object by way of the R_templatenames_forbook cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBooks is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildTemplatenames[] List of ChildTemplatenames objects
     */
    public function getTemplatenamess(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTemplatenamessPartial && !$this->isNew();
        if (null === $this->collTemplatenamess || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collTemplatenamess) {
                    $this->initTemplatenamess();
                }
            } else {

                $query = ChildTemplatenamesQuery::create(null, $criteria)
                    ->filterByBooks($this);
                $collTemplatenamess = $query->find($con);
                if (null !== $criteria) {
                    return $collTemplatenamess;
                }

                if ($partial && $this->collTemplatenamess) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collTemplatenamess as $obj) {
                        if (!$collTemplatenamess->contains($obj)) {
                            $collTemplatenamess[] = $obj;
                        }
                    }
                }

                $this->collTemplatenamess = $collTemplatenamess;
                $this->collTemplatenamessPartial = false;
            }
        }

        return $this->collTemplatenamess;
    }

    /**
     * Sets a collection of Templatenames objects related by a many-to-many relationship
     * to the current object by way of the R_templatenames_forbook cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $templatenamess A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildBooks The current object (for fluent API support)
     */
    public function setTemplatenamess(Collection $templatenamess, ConnectionInterface $con = null)
    {
        $this->clearTemplatenamess();
        $currentTemplatenamess = $this->getTemplatenamess();

        $templatenamessScheduledForDeletion = $currentTemplatenamess->diff($templatenamess);

        foreach ($templatenamessScheduledForDeletion as $toDelete) {
            $this->removeTemplatenames($toDelete);
        }

        foreach ($templatenamess as $templatenames) {
            if (!$currentTemplatenamess->contains($templatenames)) {
                $this->doAddTemplatenames($templatenames);
            }
        }

        $this->collTemplatenamessPartial = false;
        $this->collTemplatenamess = $templatenamess;

        return $this;
    }

    /**
     * Gets the number of Templatenames objects related by a many-to-many relationship
     * to the current object by way of the R_templatenames_forbook cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Templatenames objects
     */
    public function countTemplatenamess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTemplatenamessPartial && !$this->isNew();
        if (null === $this->collTemplatenamess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTemplatenamess) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getTemplatenamess());
                }

                $query = ChildTemplatenamesQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByBooks($this)
                    ->count($con);
            }
        } else {
            return count($this->collTemplatenamess);
        }
    }

    /**
     * Associate a ChildTemplatenames to this object
     * through the R_templatenames_forbook cross reference table.
     *
     * @param ChildTemplatenames $templatenames
     * @return ChildBooks The current object (for fluent API support)
     */
    public function addTemplatenames(ChildTemplatenames $templatenames)
    {
        if ($this->collTemplatenamess === null) {
            $this->initTemplatenamess();
        }

        if (!$this->getTemplatenamess()->contains($templatenames)) {
            // only add it if the **same** object is not already associated
            $this->collTemplatenamess->push($templatenames);
            $this->doAddTemplatenames($templatenames);
        }

        return $this;
    }

    /**
     *
     * @param ChildTemplatenames $templatenames
     */
    protected function doAddTemplatenames(ChildTemplatenames $templatenames)
    {
        $rTemplatenamesForbook = new ChildRTemplatenamesForbook();

        $rTemplatenamesForbook->setTemplatenames($templatenames);

        $rTemplatenamesForbook->setBooks($this);

        $this->addRTemplatenamesForbook($rTemplatenamesForbook);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$templatenames->isBookssLoaded()) {
            $templatenames->initBookss();
            $templatenames->getBookss()->push($this);
        } elseif (!$templatenames->getBookss()->contains($this)) {
            $templatenames->getBookss()->push($this);
        }

    }

    /**
     * Remove templatenames of this object
     * through the R_templatenames_forbook cross reference table.
     *
     * @param ChildTemplatenames $templatenames
     * @return ChildBooks The current object (for fluent API support)
     */
    public function removeTemplatenames(ChildTemplatenames $templatenames)
    {
        if ($this->getTemplatenamess()->contains($templatenames)) {
            $rTemplatenamesForbook = new ChildRTemplatenamesForbook();
            $rTemplatenamesForbook->setTemplatenames($templatenames);
            if ($templatenames->isBookssLoaded()) {
                //remove the back reference if available
                $templatenames->getBookss()->removeObject($this);
            }

            $rTemplatenamesForbook->setBooks($this);
            $this->removeRTemplatenamesForbook(clone $rTemplatenamesForbook);
            $rTemplatenamesForbook->clear();

            $this->collTemplatenamess->remove($this->collTemplatenamess->search($templatenames));

            if (null === $this->templatenamessScheduledForDeletion) {
                $this->templatenamessScheduledForDeletion = clone $this->collTemplatenamess;
                $this->templatenamessScheduledForDeletion->clear();
            }

            $this->templatenamessScheduledForDeletion->push($templatenames);
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
        $collectionClassName = RDataBookTableMap::getTableMap()->getCollectionClassName();

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
     * to the current object by way of the R_data_book cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBooks is new, it will return
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
                    ->filterByRBook($this);
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
     * to the current object by way of the R_data_book cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $rDatas A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildBooks The current object (for fluent API support)
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
     * to the current object by way of the R_data_book cross-reference table.
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
                    ->filterByRBook($this)
                    ->count($con);
            }
        } else {
            return count($this->collRDatas);
        }
    }

    /**
     * Associate a ChildData to this object
     * through the R_data_book cross reference table.
     *
     * @param ChildData $rData
     * @return ChildBooks The current object (for fluent API support)
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
        $rDataBook = new ChildRDataBook();

        $rDataBook->setRData($rData);

        $rDataBook->setRBook($this);

        $this->addRDataBook($rDataBook);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$rData->isRBooksLoaded()) {
            $rData->initRBooks();
            $rData->getRBooks()->push($this);
        } elseif (!$rData->getRBooks()->contains($this)) {
            $rData->getRBooks()->push($this);
        }

    }

    /**
     * Remove rData of this object
     * through the R_data_book cross reference table.
     *
     * @param ChildData $rData
     * @return ChildBooks The current object (for fluent API support)
     */
    public function removeRData(ChildData $rData)
    {
        if ($this->getRDatas()->contains($rData)) {
            $rDataBook = new ChildRDataBook();
            $rDataBook->setRData($rData);
            if ($rData->isRBooksLoaded()) {
                //remove the back reference if available
                $rData->getRBooks()->removeObject($this);
            }

            $rDataBook->setRBook($this);
            $this->removeRDataBook(clone $rDataBook);
            $rDataBook->clear();

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
     * Clears out the collRPlugins collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRPlugins()
     */
    public function clearRPlugins()
    {
        $this->collRPlugins = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collRPlugins crossRef collection.
     *
     * By default this just sets the collRPlugins collection to an empty collection (like clearRPlugins());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initRPlugins()
    {
        $collectionClassName = RPluginBookTableMap::getTableMap()->getCollectionClassName();

        $this->collRPlugins = new $collectionClassName;
        $this->collRPluginsPartial = true;
        $this->collRPlugins->setModel('\Plugins');
    }

    /**
     * Checks if the collRPlugins collection is loaded.
     *
     * @return bool
     */
    public function isRPluginsLoaded()
    {
        return null !== $this->collRPlugins;
    }

    /**
     * Gets a collection of ChildPlugins objects related by a many-to-many relationship
     * to the current object by way of the R_plugin_book cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBooks is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildPlugins[] List of ChildPlugins objects
     */
    public function getRPlugins(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRPluginsPartial && !$this->isNew();
        if (null === $this->collRPlugins || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collRPlugins) {
                    $this->initRPlugins();
                }
            } else {

                $query = ChildPluginsQuery::create(null, $criteria)
                    ->filterByRBook($this);
                $collRPlugins = $query->find($con);
                if (null !== $criteria) {
                    return $collRPlugins;
                }

                if ($partial && $this->collRPlugins) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collRPlugins as $obj) {
                        if (!$collRPlugins->contains($obj)) {
                            $collRPlugins[] = $obj;
                        }
                    }
                }

                $this->collRPlugins = $collRPlugins;
                $this->collRPluginsPartial = false;
            }
        }

        return $this->collRPlugins;
    }

    /**
     * Sets a collection of Plugins objects related by a many-to-many relationship
     * to the current object by way of the R_plugin_book cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $rPlugins A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildBooks The current object (for fluent API support)
     */
    public function setRPlugins(Collection $rPlugins, ConnectionInterface $con = null)
    {
        $this->clearRPlugins();
        $currentRPlugins = $this->getRPlugins();

        $rPluginsScheduledForDeletion = $currentRPlugins->diff($rPlugins);

        foreach ($rPluginsScheduledForDeletion as $toDelete) {
            $this->removeRPlugin($toDelete);
        }

        foreach ($rPlugins as $rPlugin) {
            if (!$currentRPlugins->contains($rPlugin)) {
                $this->doAddRPlugin($rPlugin);
            }
        }

        $this->collRPluginsPartial = false;
        $this->collRPlugins = $rPlugins;

        return $this;
    }

    /**
     * Gets the number of Plugins objects related by a many-to-many relationship
     * to the current object by way of the R_plugin_book cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Plugins objects
     */
    public function countRPlugins(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRPluginsPartial && !$this->isNew();
        if (null === $this->collRPlugins || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRPlugins) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getRPlugins());
                }

                $query = ChildPluginsQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByRBook($this)
                    ->count($con);
            }
        } else {
            return count($this->collRPlugins);
        }
    }

    /**
     * Associate a ChildPlugins to this object
     * through the R_plugin_book cross reference table.
     *
     * @param ChildPlugins $rPlugin
     * @return ChildBooks The current object (for fluent API support)
     */
    public function addRPlugin(ChildPlugins $rPlugin)
    {
        if ($this->collRPlugins === null) {
            $this->initRPlugins();
        }

        if (!$this->getRPlugins()->contains($rPlugin)) {
            // only add it if the **same** object is not already associated
            $this->collRPlugins->push($rPlugin);
            $this->doAddRPlugin($rPlugin);
        }

        return $this;
    }

    /**
     *
     * @param ChildPlugins $rPlugin
     */
    protected function doAddRPlugin(ChildPlugins $rPlugin)
    {
        $rPluginBook = new ChildRPluginBook();

        $rPluginBook->setRPlugin($rPlugin);

        $rPluginBook->setRBook($this);

        $this->addRPluginBook($rPluginBook);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$rPlugin->isRBooksLoaded()) {
            $rPlugin->initRBooks();
            $rPlugin->getRBooks()->push($this);
        } elseif (!$rPlugin->getRBooks()->contains($this)) {
            $rPlugin->getRBooks()->push($this);
        }

    }

    /**
     * Remove rPlugin of this object
     * through the R_plugin_book cross reference table.
     *
     * @param ChildPlugins $rPlugin
     * @return ChildBooks The current object (for fluent API support)
     */
    public function removeRPlugin(ChildPlugins $rPlugin)
    {
        if ($this->getRPlugins()->contains($rPlugin)) {
            $rPluginBook = new ChildRPluginBook();
            $rPluginBook->setRPlugin($rPlugin);
            if ($rPlugin->isRBooksLoaded()) {
                //remove the back reference if available
                $rPlugin->getRBooks()->removeObject($this);
            }

            $rPluginBook->setRBook($this);
            $this->removeRPluginBook(clone $rPluginBook);
            $rPluginBook->clear();

            $this->collRPlugins->remove($this->collRPlugins->search($rPlugin));

            if (null === $this->rPluginsScheduledForDeletion) {
                $this->rPluginsScheduledForDeletion = clone $this->collRPlugins;
                $this->rPluginsScheduledForDeletion->clear();
            }

            $this->rPluginsScheduledForDeletion->push($rPlugin);
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
        if (null !== $this->auserSysRef) {
            $this->auserSysRef->removeBooks($this);
        }
        $this->id = null;
        $this->_name = null;
        $this->__user__ = null;
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
            if ($this->collRBatchForbooks) {
                foreach ($this->collRBatchForbooks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRRightsForbooks) {
                foreach ($this->collRRightsForbooks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRTemplatenamesForbooks) {
                foreach ($this->collRTemplatenamesForbooks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRDataBooks) {
                foreach ($this->collRDataBooks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRPluginBooks) {
                foreach ($this->collRPluginBooks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFormatss) {
                foreach ($this->collFormatss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collIssuess) {
                foreach ($this->collIssuess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collBatches) {
                foreach ($this->collBatches as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRightss) {
                foreach ($this->collRightss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTemplatenamess) {
                foreach ($this->collTemplatenamess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRDatas) {
                foreach ($this->collRDatas as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRPlugins) {
                foreach ($this->collRPlugins as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collRBatchForbooks = null;
        $this->collRRightsForbooks = null;
        $this->collRTemplatenamesForbooks = null;
        $this->collRDataBooks = null;
        $this->collRPluginBooks = null;
        $this->collFormatss = null;
        $this->collIssuess = null;
        $this->collBatches = null;
        $this->collRightss = null;
        $this->collTemplatenamess = null;
        $this->collRDatas = null;
        $this->collRPlugins = null;
        $this->auserSysRef = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(BooksTableMap::DEFAULT_STRING_FORMAT);
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
