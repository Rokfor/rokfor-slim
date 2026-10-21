<?php

namespace Base;

use \Books as ChildBooks;
use \BooksQuery as ChildBooksQuery;
use \Formats as ChildFormats;
use \FormatsQuery as ChildFormatsQuery;
use \Issues as ChildIssues;
use \IssuesQuery as ChildIssuesQuery;
use \RRightsForbook as ChildRRightsForbook;
use \RRightsForbookQuery as ChildRRightsForbookQuery;
use \RRightsForformat as ChildRRightsForformat;
use \RRightsForformatQuery as ChildRRightsForformatQuery;
use \RRightsForissue as ChildRRightsForissue;
use \RRightsForissueQuery as ChildRRightsForissueQuery;
use \RRightsFortemplate as ChildRRightsFortemplate;
use \RRightsFortemplateQuery as ChildRRightsFortemplateQuery;
use \RRightsForuser as ChildRRightsForuser;
use \RRightsForuserQuery as ChildRRightsForuserQuery;
use \Rights as ChildRights;
use \RightsQuery as ChildRightsQuery;
use \Templatenames as ChildTemplatenames;
use \TemplatenamesQuery as ChildTemplatenamesQuery;
use \Users as ChildUsers;
use \UsersQuery as ChildUsersQuery;
use \Exception;
use \PDO;
use Map\RRightsForbookTableMap;
use Map\RRightsForformatTableMap;
use Map\RRightsForissueTableMap;
use Map\RRightsFortemplateTableMap;
use Map\RRightsForuserTableMap;
use Map\RightsTableMap;
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
 * Base class that represents a row from the '_rights' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Rights implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\RightsTableMap';


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
     * The value for the _group field.
     *
     * @var        string
     */
    protected $_group;

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
     * @var        ObjectCollection|ChildRRightsForbook[] Collection to store aggregation of ChildRRightsForbook objects.
     */
    protected $collRRightsForbooks;
    protected $collRRightsForbooksPartial;

    /**
     * @var        ObjectCollection|ChildRRightsForissue[] Collection to store aggregation of ChildRRightsForissue objects.
     */
    protected $collRRightsForissues;
    protected $collRRightsForissuesPartial;

    /**
     * @var        ObjectCollection|ChildRRightsFortemplate[] Collection to store aggregation of ChildRRightsFortemplate objects.
     */
    protected $collRRightsFortemplates;
    protected $collRRightsFortemplatesPartial;

    /**
     * @var        ObjectCollection|ChildRRightsForformat[] Collection to store aggregation of ChildRRightsForformat objects.
     */
    protected $collRRightsForformats;
    protected $collRRightsForformatsPartial;

    /**
     * @var        ObjectCollection|ChildRRightsForuser[] Collection to store aggregation of ChildRRightsForuser objects.
     */
    protected $collRRightsForusers;
    protected $collRRightsForusersPartial;

    /**
     * @var        ObjectCollection|ChildBooks[] Cross Collection to store aggregation of ChildBooks objects.
     */
    protected $collBookss;

    /**
     * @var bool
     */
    protected $collBookssPartial;

    /**
     * @var        ObjectCollection|ChildIssues[] Cross Collection to store aggregation of ChildIssues objects.
     */
    protected $collIssuess;

    /**
     * @var bool
     */
    protected $collIssuessPartial;

    /**
     * @var        ObjectCollection|ChildTemplatenames[] Cross Collection to store aggregation of ChildTemplatenames objects.
     */
    protected $collTemplatenamess;

    /**
     * @var bool
     */
    protected $collTemplatenamessPartial;

    /**
     * @var        ObjectCollection|ChildFormats[] Cross Collection to store aggregation of ChildFormats objects.
     */
    protected $collFormatss;

    /**
     * @var bool
     */
    protected $collFormatssPartial;

    /**
     * @var        ObjectCollection|ChildUsers[] Cross Collection to store aggregation of ChildUsers objects.
     */
    protected $collUserss;

    /**
     * @var bool
     */
    protected $collUserssPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildBooks[]
     */
    protected $bookssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildIssues[]
     */
    protected $issuessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTemplatenames[]
     */
    protected $templatenamessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildFormats[]
     */
    protected $formatssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUsers[]
     */
    protected $userssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRRightsForbook[]
     */
    protected $rRightsForbooksScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRRightsForissue[]
     */
    protected $rRightsForissuesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRRightsFortemplate[]
     */
    protected $rRightsFortemplatesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRRightsForformat[]
     */
    protected $rRightsForformatsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRRightsForuser[]
     */
    protected $rRightsForusersScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Rights object.
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
     * Compares this with another <code>Rights</code> instance.  If
     * <code>obj</code> is an instance of <code>Rights</code>, delegates to
     * <code>equals(Rights)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Rights The current object, for fluid interface
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
     * Get the [_group] column value.
     *
     * @return string
     */
    public function getGroup()
    {
        return $this->_group;
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
     * @return $this|\Rights The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[RightsTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [_group] column.
     *
     * @param string $v new value
     * @return $this|\Rights The current object (for fluent API support)
     */
    public function setGroup($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_group !== $v) {
            $this->_group = $v;
            $this->modifiedColumns[RightsTableMap::COL__GROUP] = true;
        }

        return $this;
    } // setGroup()

    /**
     * Set the value of [__config__] column.
     *
     * @param string $v new value
     * @return $this|\Rights The current object (for fluent API support)
     */
    public function setConfigSys($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->__config__ !== $v) {
            $this->__config__ = $v;
            $this->modifiedColumns[RightsTableMap::COL___CONFIG__] = true;
        }

        return $this;
    } // setConfigSys()

    /**
     * Set the value of [__split__] column.
     *
     * @param string $v new value
     * @return $this|\Rights The current object (for fluent API support)
     */
    public function setSplit($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->__split__ !== $v) {
            $this->__split__ = $v;
            $this->modifiedColumns[RightsTableMap::COL___SPLIT__] = true;
        }

        return $this;
    } // setSplit()

    /**
     * Set the value of [__parentnode__] column.
     *
     * @param int $v new value
     * @return $this|\Rights The current object (for fluent API support)
     */
    public function setParentnode($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__parentnode__ !== $v) {
            $this->__parentnode__ = $v;
            $this->modifiedColumns[RightsTableMap::COL___PARENTNODE__] = true;
        }

        return $this;
    } // setParentnode()

    /**
     * Set the value of [__sort__] column.
     *
     * @param int $v new value
     * @return $this|\Rights The current object (for fluent API support)
     */
    public function setSort($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__sort__ !== $v) {
            $this->__sort__ = $v;
            $this->modifiedColumns[RightsTableMap::COL___SORT__] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : RightsTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : RightsTableMap::translateFieldName('Group', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_group = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : RightsTableMap::translateFieldName('ConfigSys', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__config__ = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : RightsTableMap::translateFieldName('Split', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__split__ = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : RightsTableMap::translateFieldName('Parentnode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__parentnode__ = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : RightsTableMap::translateFieldName('Sort', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__sort__ = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 6; // 6 = RightsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Rights'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(RightsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildRightsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collRRightsForbooks = null;

            $this->collRRightsForissues = null;

            $this->collRRightsFortemplates = null;

            $this->collRRightsForformats = null;

            $this->collRRightsForusers = null;

            $this->collBookss = null;
            $this->collIssuess = null;
            $this->collTemplatenamess = null;
            $this->collFormatss = null;
            $this->collUserss = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Rights::setDeleted()
     * @see Rights::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(RightsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildRightsQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(RightsTableMap::DATABASE_NAME);
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
                RightsTableMap::addInstanceToPool($this);
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

            if ($this->bookssScheduledForDeletion !== null) {
                if (!$this->bookssScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->bookssScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RRightsForbookQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->bookssScheduledForDeletion = null;
                }

            }

            if ($this->collBookss) {
                foreach ($this->collBookss as $books) {
                    if (!$books->isDeleted() && ($books->isNew() || $books->isModified())) {
                        $books->save($con);
                    }
                }
            }


            if ($this->issuessScheduledForDeletion !== null) {
                if (!$this->issuessScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->issuessScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RRightsForissueQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->issuessScheduledForDeletion = null;
                }

            }

            if ($this->collIssuess) {
                foreach ($this->collIssuess as $issues) {
                    if (!$issues->isDeleted() && ($issues->isNew() || $issues->isModified())) {
                        $issues->save($con);
                    }
                }
            }


            if ($this->templatenamessScheduledForDeletion !== null) {
                if (!$this->templatenamessScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->templatenamessScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RRightsFortemplateQuery::create()
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


            if ($this->formatssScheduledForDeletion !== null) {
                if (!$this->formatssScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->formatssScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RRightsForformatQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->formatssScheduledForDeletion = null;
                }

            }

            if ($this->collFormatss) {
                foreach ($this->collFormatss as $formats) {
                    if (!$formats->isDeleted() && ($formats->isNew() || $formats->isModified())) {
                        $formats->save($con);
                    }
                }
            }


            if ($this->userssScheduledForDeletion !== null) {
                if (!$this->userssScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->userssScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RRightsForuserQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->userssScheduledForDeletion = null;
                }

            }

            if ($this->collUserss) {
                foreach ($this->collUserss as $users) {
                    if (!$users->isDeleted() && ($users->isNew() || $users->isModified())) {
                        $users->save($con);
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

            if ($this->rRightsForissuesScheduledForDeletion !== null) {
                if (!$this->rRightsForissuesScheduledForDeletion->isEmpty()) {
                    \RRightsForissueQuery::create()
                        ->filterByPrimaryKeys($this->rRightsForissuesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rRightsForissuesScheduledForDeletion = null;
                }
            }

            if ($this->collRRightsForissues !== null) {
                foreach ($this->collRRightsForissues as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->rRightsFortemplatesScheduledForDeletion !== null) {
                if (!$this->rRightsFortemplatesScheduledForDeletion->isEmpty()) {
                    \RRightsFortemplateQuery::create()
                        ->filterByPrimaryKeys($this->rRightsFortemplatesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rRightsFortemplatesScheduledForDeletion = null;
                }
            }

            if ($this->collRRightsFortemplates !== null) {
                foreach ($this->collRRightsFortemplates as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->rRightsForformatsScheduledForDeletion !== null) {
                if (!$this->rRightsForformatsScheduledForDeletion->isEmpty()) {
                    \RRightsForformatQuery::create()
                        ->filterByPrimaryKeys($this->rRightsForformatsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rRightsForformatsScheduledForDeletion = null;
                }
            }

            if ($this->collRRightsForformats !== null) {
                foreach ($this->collRRightsForformats as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->rRightsForusersScheduledForDeletion !== null) {
                if (!$this->rRightsForusersScheduledForDeletion->isEmpty()) {
                    \RRightsForuserQuery::create()
                        ->filterByPrimaryKeys($this->rRightsForusersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rRightsForusersScheduledForDeletion = null;
                }
            }

            if ($this->collRRightsForusers !== null) {
                foreach ($this->collRRightsForusers as $referrerFK) {
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

        $this->modifiedColumns[RightsTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . RightsTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(RightsTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(RightsTableMap::COL__GROUP)) {
            $modifiedColumns[':p' . $index++]  = '_group';
        }
        if ($this->isColumnModified(RightsTableMap::COL___CONFIG__)) {
            $modifiedColumns[':p' . $index++]  = '__config__';
        }
        if ($this->isColumnModified(RightsTableMap::COL___SPLIT__)) {
            $modifiedColumns[':p' . $index++]  = '__split__';
        }
        if ($this->isColumnModified(RightsTableMap::COL___PARENTNODE__)) {
            $modifiedColumns[':p' . $index++]  = '__parentnode__';
        }
        if ($this->isColumnModified(RightsTableMap::COL___SORT__)) {
            $modifiedColumns[':p' . $index++]  = '__sort__';
        }

        $sql = sprintf(
            'INSERT INTO _rights (%s) VALUES (%s)',
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
                    case '_group':
                        $stmt->bindValue($identifier, $this->_group, PDO::PARAM_STR);
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
        $pos = RightsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getGroup();
                break;
            case 2:
                return $this->getConfigSys();
                break;
            case 3:
                return $this->getSplit();
                break;
            case 4:
                return $this->getParentnode();
                break;
            case 5:
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

        if (isset($alreadyDumpedObjects['Rights'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Rights'][$this->hashCode()] = true;
        $keys = RightsTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getGroup(),
            $keys[2] => $this->getConfigSys(),
            $keys[3] => $this->getSplit(),
            $keys[4] => $this->getParentnode(),
            $keys[5] => $this->getSort(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
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
            if (null !== $this->collRRightsForissues) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rRightsForissues';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_rights_forissues';
                        break;
                    default:
                        $key = 'RRightsForissues';
                }

                $result[$key] = $this->collRRightsForissues->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRRightsFortemplates) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rRightsFortemplates';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_rights_fortemplates';
                        break;
                    default:
                        $key = 'RRightsFortemplates';
                }

                $result[$key] = $this->collRRightsFortemplates->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRRightsForformats) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rRightsForformats';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_rights_forformats';
                        break;
                    default:
                        $key = 'RRightsForformats';
                }

                $result[$key] = $this->collRRightsForformats->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRRightsForusers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rRightsForusers';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_rights_forusers';
                        break;
                    default:
                        $key = 'RRightsForusers';
                }

                $result[$key] = $this->collRRightsForusers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Rights
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = RightsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Rights
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setGroup($value);
                break;
            case 2:
                $this->setConfigSys($value);
                break;
            case 3:
                $this->setSplit($value);
                break;
            case 4:
                $this->setParentnode($value);
                break;
            case 5:
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
        $keys = RightsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setGroup($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setConfigSys($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setSplit($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setParentnode($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setSort($arr[$keys[5]]);
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
     * @return $this|\Rights The current object, for fluid interface
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
        $criteria = new Criteria(RightsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(RightsTableMap::COL_ID)) {
            $criteria->add(RightsTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(RightsTableMap::COL__GROUP)) {
            $criteria->add(RightsTableMap::COL__GROUP, $this->_group);
        }
        if ($this->isColumnModified(RightsTableMap::COL___CONFIG__)) {
            $criteria->add(RightsTableMap::COL___CONFIG__, $this->__config__);
        }
        if ($this->isColumnModified(RightsTableMap::COL___SPLIT__)) {
            $criteria->add(RightsTableMap::COL___SPLIT__, $this->__split__);
        }
        if ($this->isColumnModified(RightsTableMap::COL___PARENTNODE__)) {
            $criteria->add(RightsTableMap::COL___PARENTNODE__, $this->__parentnode__);
        }
        if ($this->isColumnModified(RightsTableMap::COL___SORT__)) {
            $criteria->add(RightsTableMap::COL___SORT__, $this->__sort__);
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
        $criteria = ChildRightsQuery::create();
        $criteria->add(RightsTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Rights (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setGroup($this->getGroup());
        $copyObj->setConfigSys($this->getConfigSys());
        $copyObj->setSplit($this->getSplit());
        $copyObj->setParentnode($this->getParentnode());
        $copyObj->setSort($this->getSort());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getRRightsForbooks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRRightsForbook($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRRightsForissues() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRRightsForissue($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRRightsFortemplates() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRRightsFortemplate($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRRightsForformats() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRRightsForformat($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRRightsForusers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRRightsForuser($relObj->copy($deepCopy));
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
     * @return \Rights Clone of current object.
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('RRightsForbook' == $relationName) {
            $this->initRRightsForbooks();
            return;
        }
        if ('RRightsForissue' == $relationName) {
            $this->initRRightsForissues();
            return;
        }
        if ('RRightsFortemplate' == $relationName) {
            $this->initRRightsFortemplates();
            return;
        }
        if ('RRightsForformat' == $relationName) {
            $this->initRRightsForformats();
            return;
        }
        if ('RRightsForuser' == $relationName) {
            $this->initRRightsForusers();
            return;
        }
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
     * If this ChildRights is new, it will return
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
                    ->filterByRights($this)
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
     * @return $this|ChildRights The current object (for fluent API support)
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
            $rRightsForbookRemoved->setRights(null);
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
                ->filterByRights($this)
                ->count($con);
        }

        return count($this->collRRightsForbooks);
    }

    /**
     * Method called to associate a ChildRRightsForbook object to this object
     * through the ChildRRightsForbook foreign key attribute.
     *
     * @param  ChildRRightsForbook $l ChildRRightsForbook
     * @return $this|\Rights The current object (for fluent API support)
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
        $rRightsForbook->setRights($this);
    }

    /**
     * @param  ChildRRightsForbook $rRightsForbook The ChildRRightsForbook object to remove.
     * @return $this|ChildRights The current object (for fluent API support)
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
            $rRightsForbook->setRights(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Rights is new, it will return
     * an empty collection; or if this Rights has previously
     * been saved, it will retrieve related RRightsForbooks from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Rights.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRRightsForbook[] List of ChildRRightsForbook objects
     */
    public function getRRightsForbooksJoinBooks(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRRightsForbookQuery::create(null, $criteria);
        $query->joinWith('Books', $joinBehavior);

        return $this->getRRightsForbooks($query, $con);
    }

    /**
     * Clears out the collRRightsForissues collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRRightsForissues()
     */
    public function clearRRightsForissues()
    {
        $this->collRRightsForissues = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRRightsForissues collection loaded partially.
     */
    public function resetPartialRRightsForissues($v = true)
    {
        $this->collRRightsForissuesPartial = $v;
    }

    /**
     * Initializes the collRRightsForissues collection.
     *
     * By default this just sets the collRRightsForissues collection to an empty array (like clearcollRRightsForissues());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRRightsForissues($overrideExisting = true)
    {
        if (null !== $this->collRRightsForissues && !$overrideExisting) {
            return;
        }

        $collectionClassName = RRightsForissueTableMap::getTableMap()->getCollectionClassName();

        $this->collRRightsForissues = new $collectionClassName;
        $this->collRRightsForissues->setModel('\RRightsForissue');
    }

    /**
     * Gets an array of ChildRRightsForissue objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRights is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRRightsForissue[] List of ChildRRightsForissue objects
     * @throws PropelException
     */
    public function getRRightsForissues(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRRightsForissuesPartial && !$this->isNew();
        if (null === $this->collRRightsForissues || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRRightsForissues) {
                // return empty collection
                $this->initRRightsForissues();
            } else {
                $collRRightsForissues = ChildRRightsForissueQuery::create(null, $criteria)
                    ->filterByRights($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRRightsForissuesPartial && count($collRRightsForissues)) {
                        $this->initRRightsForissues(false);

                        foreach ($collRRightsForissues as $obj) {
                            if (false == $this->collRRightsForissues->contains($obj)) {
                                $this->collRRightsForissues->append($obj);
                            }
                        }

                        $this->collRRightsForissuesPartial = true;
                    }

                    return $collRRightsForissues;
                }

                if ($partial && $this->collRRightsForissues) {
                    foreach ($this->collRRightsForissues as $obj) {
                        if ($obj->isNew()) {
                            $collRRightsForissues[] = $obj;
                        }
                    }
                }

                $this->collRRightsForissues = $collRRightsForissues;
                $this->collRRightsForissuesPartial = false;
            }
        }

        return $this->collRRightsForissues;
    }

    /**
     * Sets a collection of ChildRRightsForissue objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rRightsForissues A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildRights The current object (for fluent API support)
     */
    public function setRRightsForissues(Collection $rRightsForissues, ConnectionInterface $con = null)
    {
        /** @var ChildRRightsForissue[] $rRightsForissuesToDelete */
        $rRightsForissuesToDelete = $this->getRRightsForissues(new Criteria(), $con)->diff($rRightsForissues);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rRightsForissuesScheduledForDeletion = clone $rRightsForissuesToDelete;

        foreach ($rRightsForissuesToDelete as $rRightsForissueRemoved) {
            $rRightsForissueRemoved->setRights(null);
        }

        $this->collRRightsForissues = null;
        foreach ($rRightsForissues as $rRightsForissue) {
            $this->addRRightsForissue($rRightsForissue);
        }

        $this->collRRightsForissues = $rRightsForissues;
        $this->collRRightsForissuesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RRightsForissue objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RRightsForissue objects.
     * @throws PropelException
     */
    public function countRRightsForissues(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRRightsForissuesPartial && !$this->isNew();
        if (null === $this->collRRightsForissues || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRRightsForissues) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRRightsForissues());
            }

            $query = ChildRRightsForissueQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRights($this)
                ->count($con);
        }

        return count($this->collRRightsForissues);
    }

    /**
     * Method called to associate a ChildRRightsForissue object to this object
     * through the ChildRRightsForissue foreign key attribute.
     *
     * @param  ChildRRightsForissue $l ChildRRightsForissue
     * @return $this|\Rights The current object (for fluent API support)
     */
    public function addRRightsForissue(ChildRRightsForissue $l)
    {
        if ($this->collRRightsForissues === null) {
            $this->initRRightsForissues();
            $this->collRRightsForissuesPartial = true;
        }

        if (!$this->collRRightsForissues->contains($l)) {
            $this->doAddRRightsForissue($l);

            if ($this->rRightsForissuesScheduledForDeletion and $this->rRightsForissuesScheduledForDeletion->contains($l)) {
                $this->rRightsForissuesScheduledForDeletion->remove($this->rRightsForissuesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRRightsForissue $rRightsForissue The ChildRRightsForissue object to add.
     */
    protected function doAddRRightsForissue(ChildRRightsForissue $rRightsForissue)
    {
        $this->collRRightsForissues[]= $rRightsForissue;
        $rRightsForissue->setRights($this);
    }

    /**
     * @param  ChildRRightsForissue $rRightsForissue The ChildRRightsForissue object to remove.
     * @return $this|ChildRights The current object (for fluent API support)
     */
    public function removeRRightsForissue(ChildRRightsForissue $rRightsForissue)
    {
        if ($this->getRRightsForissues()->contains($rRightsForissue)) {
            $pos = $this->collRRightsForissues->search($rRightsForissue);
            $this->collRRightsForissues->remove($pos);
            if (null === $this->rRightsForissuesScheduledForDeletion) {
                $this->rRightsForissuesScheduledForDeletion = clone $this->collRRightsForissues;
                $this->rRightsForissuesScheduledForDeletion->clear();
            }
            $this->rRightsForissuesScheduledForDeletion[]= clone $rRightsForissue;
            $rRightsForissue->setRights(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Rights is new, it will return
     * an empty collection; or if this Rights has previously
     * been saved, it will retrieve related RRightsForissues from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Rights.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRRightsForissue[] List of ChildRRightsForissue objects
     */
    public function getRRightsForissuesJoinIssues(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRRightsForissueQuery::create(null, $criteria);
        $query->joinWith('Issues', $joinBehavior);

        return $this->getRRightsForissues($query, $con);
    }

    /**
     * Clears out the collRRightsFortemplates collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRRightsFortemplates()
     */
    public function clearRRightsFortemplates()
    {
        $this->collRRightsFortemplates = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRRightsFortemplates collection loaded partially.
     */
    public function resetPartialRRightsFortemplates($v = true)
    {
        $this->collRRightsFortemplatesPartial = $v;
    }

    /**
     * Initializes the collRRightsFortemplates collection.
     *
     * By default this just sets the collRRightsFortemplates collection to an empty array (like clearcollRRightsFortemplates());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRRightsFortemplates($overrideExisting = true)
    {
        if (null !== $this->collRRightsFortemplates && !$overrideExisting) {
            return;
        }

        $collectionClassName = RRightsFortemplateTableMap::getTableMap()->getCollectionClassName();

        $this->collRRightsFortemplates = new $collectionClassName;
        $this->collRRightsFortemplates->setModel('\RRightsFortemplate');
    }

    /**
     * Gets an array of ChildRRightsFortemplate objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRights is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRRightsFortemplate[] List of ChildRRightsFortemplate objects
     * @throws PropelException
     */
    public function getRRightsFortemplates(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRRightsFortemplatesPartial && !$this->isNew();
        if (null === $this->collRRightsFortemplates || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRRightsFortemplates) {
                // return empty collection
                $this->initRRightsFortemplates();
            } else {
                $collRRightsFortemplates = ChildRRightsFortemplateQuery::create(null, $criteria)
                    ->filterByRights($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRRightsFortemplatesPartial && count($collRRightsFortemplates)) {
                        $this->initRRightsFortemplates(false);

                        foreach ($collRRightsFortemplates as $obj) {
                            if (false == $this->collRRightsFortemplates->contains($obj)) {
                                $this->collRRightsFortemplates->append($obj);
                            }
                        }

                        $this->collRRightsFortemplatesPartial = true;
                    }

                    return $collRRightsFortemplates;
                }

                if ($partial && $this->collRRightsFortemplates) {
                    foreach ($this->collRRightsFortemplates as $obj) {
                        if ($obj->isNew()) {
                            $collRRightsFortemplates[] = $obj;
                        }
                    }
                }

                $this->collRRightsFortemplates = $collRRightsFortemplates;
                $this->collRRightsFortemplatesPartial = false;
            }
        }

        return $this->collRRightsFortemplates;
    }

    /**
     * Sets a collection of ChildRRightsFortemplate objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rRightsFortemplates A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildRights The current object (for fluent API support)
     */
    public function setRRightsFortemplates(Collection $rRightsFortemplates, ConnectionInterface $con = null)
    {
        /** @var ChildRRightsFortemplate[] $rRightsFortemplatesToDelete */
        $rRightsFortemplatesToDelete = $this->getRRightsFortemplates(new Criteria(), $con)->diff($rRightsFortemplates);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rRightsFortemplatesScheduledForDeletion = clone $rRightsFortemplatesToDelete;

        foreach ($rRightsFortemplatesToDelete as $rRightsFortemplateRemoved) {
            $rRightsFortemplateRemoved->setRights(null);
        }

        $this->collRRightsFortemplates = null;
        foreach ($rRightsFortemplates as $rRightsFortemplate) {
            $this->addRRightsFortemplate($rRightsFortemplate);
        }

        $this->collRRightsFortemplates = $rRightsFortemplates;
        $this->collRRightsFortemplatesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RRightsFortemplate objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RRightsFortemplate objects.
     * @throws PropelException
     */
    public function countRRightsFortemplates(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRRightsFortemplatesPartial && !$this->isNew();
        if (null === $this->collRRightsFortemplates || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRRightsFortemplates) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRRightsFortemplates());
            }

            $query = ChildRRightsFortemplateQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRights($this)
                ->count($con);
        }

        return count($this->collRRightsFortemplates);
    }

    /**
     * Method called to associate a ChildRRightsFortemplate object to this object
     * through the ChildRRightsFortemplate foreign key attribute.
     *
     * @param  ChildRRightsFortemplate $l ChildRRightsFortemplate
     * @return $this|\Rights The current object (for fluent API support)
     */
    public function addRRightsFortemplate(ChildRRightsFortemplate $l)
    {
        if ($this->collRRightsFortemplates === null) {
            $this->initRRightsFortemplates();
            $this->collRRightsFortemplatesPartial = true;
        }

        if (!$this->collRRightsFortemplates->contains($l)) {
            $this->doAddRRightsFortemplate($l);

            if ($this->rRightsFortemplatesScheduledForDeletion and $this->rRightsFortemplatesScheduledForDeletion->contains($l)) {
                $this->rRightsFortemplatesScheduledForDeletion->remove($this->rRightsFortemplatesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRRightsFortemplate $rRightsFortemplate The ChildRRightsFortemplate object to add.
     */
    protected function doAddRRightsFortemplate(ChildRRightsFortemplate $rRightsFortemplate)
    {
        $this->collRRightsFortemplates[]= $rRightsFortemplate;
        $rRightsFortemplate->setRights($this);
    }

    /**
     * @param  ChildRRightsFortemplate $rRightsFortemplate The ChildRRightsFortemplate object to remove.
     * @return $this|ChildRights The current object (for fluent API support)
     */
    public function removeRRightsFortemplate(ChildRRightsFortemplate $rRightsFortemplate)
    {
        if ($this->getRRightsFortemplates()->contains($rRightsFortemplate)) {
            $pos = $this->collRRightsFortemplates->search($rRightsFortemplate);
            $this->collRRightsFortemplates->remove($pos);
            if (null === $this->rRightsFortemplatesScheduledForDeletion) {
                $this->rRightsFortemplatesScheduledForDeletion = clone $this->collRRightsFortemplates;
                $this->rRightsFortemplatesScheduledForDeletion->clear();
            }
            $this->rRightsFortemplatesScheduledForDeletion[]= clone $rRightsFortemplate;
            $rRightsFortemplate->setRights(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Rights is new, it will return
     * an empty collection; or if this Rights has previously
     * been saved, it will retrieve related RRightsFortemplates from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Rights.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRRightsFortemplate[] List of ChildRRightsFortemplate objects
     */
    public function getRRightsFortemplatesJoinTemplatenames(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRRightsFortemplateQuery::create(null, $criteria);
        $query->joinWith('Templatenames', $joinBehavior);

        return $this->getRRightsFortemplates($query, $con);
    }

    /**
     * Clears out the collRRightsForformats collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRRightsForformats()
     */
    public function clearRRightsForformats()
    {
        $this->collRRightsForformats = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRRightsForformats collection loaded partially.
     */
    public function resetPartialRRightsForformats($v = true)
    {
        $this->collRRightsForformatsPartial = $v;
    }

    /**
     * Initializes the collRRightsForformats collection.
     *
     * By default this just sets the collRRightsForformats collection to an empty array (like clearcollRRightsForformats());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRRightsForformats($overrideExisting = true)
    {
        if (null !== $this->collRRightsForformats && !$overrideExisting) {
            return;
        }

        $collectionClassName = RRightsForformatTableMap::getTableMap()->getCollectionClassName();

        $this->collRRightsForformats = new $collectionClassName;
        $this->collRRightsForformats->setModel('\RRightsForformat');
    }

    /**
     * Gets an array of ChildRRightsForformat objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRights is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRRightsForformat[] List of ChildRRightsForformat objects
     * @throws PropelException
     */
    public function getRRightsForformats(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRRightsForformatsPartial && !$this->isNew();
        if (null === $this->collRRightsForformats || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRRightsForformats) {
                // return empty collection
                $this->initRRightsForformats();
            } else {
                $collRRightsForformats = ChildRRightsForformatQuery::create(null, $criteria)
                    ->filterByRights($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRRightsForformatsPartial && count($collRRightsForformats)) {
                        $this->initRRightsForformats(false);

                        foreach ($collRRightsForformats as $obj) {
                            if (false == $this->collRRightsForformats->contains($obj)) {
                                $this->collRRightsForformats->append($obj);
                            }
                        }

                        $this->collRRightsForformatsPartial = true;
                    }

                    return $collRRightsForformats;
                }

                if ($partial && $this->collRRightsForformats) {
                    foreach ($this->collRRightsForformats as $obj) {
                        if ($obj->isNew()) {
                            $collRRightsForformats[] = $obj;
                        }
                    }
                }

                $this->collRRightsForformats = $collRRightsForformats;
                $this->collRRightsForformatsPartial = false;
            }
        }

        return $this->collRRightsForformats;
    }

    /**
     * Sets a collection of ChildRRightsForformat objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rRightsForformats A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildRights The current object (for fluent API support)
     */
    public function setRRightsForformats(Collection $rRightsForformats, ConnectionInterface $con = null)
    {
        /** @var ChildRRightsForformat[] $rRightsForformatsToDelete */
        $rRightsForformatsToDelete = $this->getRRightsForformats(new Criteria(), $con)->diff($rRightsForformats);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rRightsForformatsScheduledForDeletion = clone $rRightsForformatsToDelete;

        foreach ($rRightsForformatsToDelete as $rRightsForformatRemoved) {
            $rRightsForformatRemoved->setRights(null);
        }

        $this->collRRightsForformats = null;
        foreach ($rRightsForformats as $rRightsForformat) {
            $this->addRRightsForformat($rRightsForformat);
        }

        $this->collRRightsForformats = $rRightsForformats;
        $this->collRRightsForformatsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RRightsForformat objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RRightsForformat objects.
     * @throws PropelException
     */
    public function countRRightsForformats(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRRightsForformatsPartial && !$this->isNew();
        if (null === $this->collRRightsForformats || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRRightsForformats) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRRightsForformats());
            }

            $query = ChildRRightsForformatQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRights($this)
                ->count($con);
        }

        return count($this->collRRightsForformats);
    }

    /**
     * Method called to associate a ChildRRightsForformat object to this object
     * through the ChildRRightsForformat foreign key attribute.
     *
     * @param  ChildRRightsForformat $l ChildRRightsForformat
     * @return $this|\Rights The current object (for fluent API support)
     */
    public function addRRightsForformat(ChildRRightsForformat $l)
    {
        if ($this->collRRightsForformats === null) {
            $this->initRRightsForformats();
            $this->collRRightsForformatsPartial = true;
        }

        if (!$this->collRRightsForformats->contains($l)) {
            $this->doAddRRightsForformat($l);

            if ($this->rRightsForformatsScheduledForDeletion and $this->rRightsForformatsScheduledForDeletion->contains($l)) {
                $this->rRightsForformatsScheduledForDeletion->remove($this->rRightsForformatsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRRightsForformat $rRightsForformat The ChildRRightsForformat object to add.
     */
    protected function doAddRRightsForformat(ChildRRightsForformat $rRightsForformat)
    {
        $this->collRRightsForformats[]= $rRightsForformat;
        $rRightsForformat->setRights($this);
    }

    /**
     * @param  ChildRRightsForformat $rRightsForformat The ChildRRightsForformat object to remove.
     * @return $this|ChildRights The current object (for fluent API support)
     */
    public function removeRRightsForformat(ChildRRightsForformat $rRightsForformat)
    {
        if ($this->getRRightsForformats()->contains($rRightsForformat)) {
            $pos = $this->collRRightsForformats->search($rRightsForformat);
            $this->collRRightsForformats->remove($pos);
            if (null === $this->rRightsForformatsScheduledForDeletion) {
                $this->rRightsForformatsScheduledForDeletion = clone $this->collRRightsForformats;
                $this->rRightsForformatsScheduledForDeletion->clear();
            }
            $this->rRightsForformatsScheduledForDeletion[]= clone $rRightsForformat;
            $rRightsForformat->setRights(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Rights is new, it will return
     * an empty collection; or if this Rights has previously
     * been saved, it will retrieve related RRightsForformats from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Rights.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRRightsForformat[] List of ChildRRightsForformat objects
     */
    public function getRRightsForformatsJoinFormats(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRRightsForformatQuery::create(null, $criteria);
        $query->joinWith('Formats', $joinBehavior);

        return $this->getRRightsForformats($query, $con);
    }

    /**
     * Clears out the collRRightsForusers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRRightsForusers()
     */
    public function clearRRightsForusers()
    {
        $this->collRRightsForusers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRRightsForusers collection loaded partially.
     */
    public function resetPartialRRightsForusers($v = true)
    {
        $this->collRRightsForusersPartial = $v;
    }

    /**
     * Initializes the collRRightsForusers collection.
     *
     * By default this just sets the collRRightsForusers collection to an empty array (like clearcollRRightsForusers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRRightsForusers($overrideExisting = true)
    {
        if (null !== $this->collRRightsForusers && !$overrideExisting) {
            return;
        }

        $collectionClassName = RRightsForuserTableMap::getTableMap()->getCollectionClassName();

        $this->collRRightsForusers = new $collectionClassName;
        $this->collRRightsForusers->setModel('\RRightsForuser');
    }

    /**
     * Gets an array of ChildRRightsForuser objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRights is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRRightsForuser[] List of ChildRRightsForuser objects
     * @throws PropelException
     */
    public function getRRightsForusers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRRightsForusersPartial && !$this->isNew();
        if (null === $this->collRRightsForusers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRRightsForusers) {
                // return empty collection
                $this->initRRightsForusers();
            } else {
                $collRRightsForusers = ChildRRightsForuserQuery::create(null, $criteria)
                    ->filterByRights($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRRightsForusersPartial && count($collRRightsForusers)) {
                        $this->initRRightsForusers(false);

                        foreach ($collRRightsForusers as $obj) {
                            if (false == $this->collRRightsForusers->contains($obj)) {
                                $this->collRRightsForusers->append($obj);
                            }
                        }

                        $this->collRRightsForusersPartial = true;
                    }

                    return $collRRightsForusers;
                }

                if ($partial && $this->collRRightsForusers) {
                    foreach ($this->collRRightsForusers as $obj) {
                        if ($obj->isNew()) {
                            $collRRightsForusers[] = $obj;
                        }
                    }
                }

                $this->collRRightsForusers = $collRRightsForusers;
                $this->collRRightsForusersPartial = false;
            }
        }

        return $this->collRRightsForusers;
    }

    /**
     * Sets a collection of ChildRRightsForuser objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rRightsForusers A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildRights The current object (for fluent API support)
     */
    public function setRRightsForusers(Collection $rRightsForusers, ConnectionInterface $con = null)
    {
        /** @var ChildRRightsForuser[] $rRightsForusersToDelete */
        $rRightsForusersToDelete = $this->getRRightsForusers(new Criteria(), $con)->diff($rRightsForusers);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rRightsForusersScheduledForDeletion = clone $rRightsForusersToDelete;

        foreach ($rRightsForusersToDelete as $rRightsForuserRemoved) {
            $rRightsForuserRemoved->setRights(null);
        }

        $this->collRRightsForusers = null;
        foreach ($rRightsForusers as $rRightsForuser) {
            $this->addRRightsForuser($rRightsForuser);
        }

        $this->collRRightsForusers = $rRightsForusers;
        $this->collRRightsForusersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RRightsForuser objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RRightsForuser objects.
     * @throws PropelException
     */
    public function countRRightsForusers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRRightsForusersPartial && !$this->isNew();
        if (null === $this->collRRightsForusers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRRightsForusers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRRightsForusers());
            }

            $query = ChildRRightsForuserQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRights($this)
                ->count($con);
        }

        return count($this->collRRightsForusers);
    }

    /**
     * Method called to associate a ChildRRightsForuser object to this object
     * through the ChildRRightsForuser foreign key attribute.
     *
     * @param  ChildRRightsForuser $l ChildRRightsForuser
     * @return $this|\Rights The current object (for fluent API support)
     */
    public function addRRightsForuser(ChildRRightsForuser $l)
    {
        if ($this->collRRightsForusers === null) {
            $this->initRRightsForusers();
            $this->collRRightsForusersPartial = true;
        }

        if (!$this->collRRightsForusers->contains($l)) {
            $this->doAddRRightsForuser($l);

            if ($this->rRightsForusersScheduledForDeletion and $this->rRightsForusersScheduledForDeletion->contains($l)) {
                $this->rRightsForusersScheduledForDeletion->remove($this->rRightsForusersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRRightsForuser $rRightsForuser The ChildRRightsForuser object to add.
     */
    protected function doAddRRightsForuser(ChildRRightsForuser $rRightsForuser)
    {
        $this->collRRightsForusers[]= $rRightsForuser;
        $rRightsForuser->setRights($this);
    }

    /**
     * @param  ChildRRightsForuser $rRightsForuser The ChildRRightsForuser object to remove.
     * @return $this|ChildRights The current object (for fluent API support)
     */
    public function removeRRightsForuser(ChildRRightsForuser $rRightsForuser)
    {
        if ($this->getRRightsForusers()->contains($rRightsForuser)) {
            $pos = $this->collRRightsForusers->search($rRightsForuser);
            $this->collRRightsForusers->remove($pos);
            if (null === $this->rRightsForusersScheduledForDeletion) {
                $this->rRightsForusersScheduledForDeletion = clone $this->collRRightsForusers;
                $this->rRightsForusersScheduledForDeletion->clear();
            }
            $this->rRightsForusersScheduledForDeletion[]= clone $rRightsForuser;
            $rRightsForuser->setRights(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Rights is new, it will return
     * an empty collection; or if this Rights has previously
     * been saved, it will retrieve related RRightsForusers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Rights.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRRightsForuser[] List of ChildRRightsForuser objects
     */
    public function getRRightsForusersJoinUsers(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRRightsForuserQuery::create(null, $criteria);
        $query->joinWith('Users', $joinBehavior);

        return $this->getRRightsForusers($query, $con);
    }

    /**
     * Clears out the collBookss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addBookss()
     */
    public function clearBookss()
    {
        $this->collBookss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collBookss crossRef collection.
     *
     * By default this just sets the collBookss collection to an empty collection (like clearBookss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initBookss()
    {
        $collectionClassName = RRightsForbookTableMap::getTableMap()->getCollectionClassName();

        $this->collBookss = new $collectionClassName;
        $this->collBookssPartial = true;
        $this->collBookss->setModel('\Books');
    }

    /**
     * Checks if the collBookss collection is loaded.
     *
     * @return bool
     */
    public function isBookssLoaded()
    {
        return null !== $this->collBookss;
    }

    /**
     * Gets a collection of ChildBooks objects related by a many-to-many relationship
     * to the current object by way of the R_rights_forbook cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRights is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildBooks[] List of ChildBooks objects
     */
    public function getBookss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBookssPartial && !$this->isNew();
        if (null === $this->collBookss || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collBookss) {
                    $this->initBookss();
                }
            } else {

                $query = ChildBooksQuery::create(null, $criteria)
                    ->filterByRights($this);
                $collBookss = $query->find($con);
                if (null !== $criteria) {
                    return $collBookss;
                }

                if ($partial && $this->collBookss) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collBookss as $obj) {
                        if (!$collBookss->contains($obj)) {
                            $collBookss[] = $obj;
                        }
                    }
                }

                $this->collBookss = $collBookss;
                $this->collBookssPartial = false;
            }
        }

        return $this->collBookss;
    }

    /**
     * Sets a collection of Books objects related by a many-to-many relationship
     * to the current object by way of the R_rights_forbook cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $bookss A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildRights The current object (for fluent API support)
     */
    public function setBookss(Collection $bookss, ConnectionInterface $con = null)
    {
        $this->clearBookss();
        $currentBookss = $this->getBookss();

        $bookssScheduledForDeletion = $currentBookss->diff($bookss);

        foreach ($bookssScheduledForDeletion as $toDelete) {
            $this->removeBooks($toDelete);
        }

        foreach ($bookss as $books) {
            if (!$currentBookss->contains($books)) {
                $this->doAddBooks($books);
            }
        }

        $this->collBookssPartial = false;
        $this->collBookss = $bookss;

        return $this;
    }

    /**
     * Gets the number of Books objects related by a many-to-many relationship
     * to the current object by way of the R_rights_forbook cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Books objects
     */
    public function countBookss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBookssPartial && !$this->isNew();
        if (null === $this->collBookss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBookss) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getBookss());
                }

                $query = ChildBooksQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByRights($this)
                    ->count($con);
            }
        } else {
            return count($this->collBookss);
        }
    }

    /**
     * Associate a ChildBooks to this object
     * through the R_rights_forbook cross reference table.
     *
     * @param ChildBooks $books
     * @return ChildRights The current object (for fluent API support)
     */
    public function addBooks(ChildBooks $books)
    {
        if ($this->collBookss === null) {
            $this->initBookss();
        }

        if (!$this->getBookss()->contains($books)) {
            // only add it if the **same** object is not already associated
            $this->collBookss->push($books);
            $this->doAddBooks($books);
        }

        return $this;
    }

    /**
     *
     * @param ChildBooks $books
     */
    protected function doAddBooks(ChildBooks $books)
    {
        $rRightsForbook = new ChildRRightsForbook();

        $rRightsForbook->setBooks($books);

        $rRightsForbook->setRights($this);

        $this->addRRightsForbook($rRightsForbook);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$books->isRightssLoaded()) {
            $books->initRightss();
            $books->getRightss()->push($this);
        } elseif (!$books->getRightss()->contains($this)) {
            $books->getRightss()->push($this);
        }

    }

    /**
     * Remove books of this object
     * through the R_rights_forbook cross reference table.
     *
     * @param ChildBooks $books
     * @return ChildRights The current object (for fluent API support)
     */
    public function removeBooks(ChildBooks $books)
    {
        if ($this->getBookss()->contains($books)) {
            $rRightsForbook = new ChildRRightsForbook();
            $rRightsForbook->setBooks($books);
            if ($books->isRightssLoaded()) {
                //remove the back reference if available
                $books->getRightss()->removeObject($this);
            }

            $rRightsForbook->setRights($this);
            $this->removeRRightsForbook(clone $rRightsForbook);
            $rRightsForbook->clear();

            $this->collBookss->remove($this->collBookss->search($books));

            if (null === $this->bookssScheduledForDeletion) {
                $this->bookssScheduledForDeletion = clone $this->collBookss;
                $this->bookssScheduledForDeletion->clear();
            }

            $this->bookssScheduledForDeletion->push($books);
        }


        return $this;
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
     * Initializes the collIssuess crossRef collection.
     *
     * By default this just sets the collIssuess collection to an empty collection (like clearIssuess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initIssuess()
    {
        $collectionClassName = RRightsForissueTableMap::getTableMap()->getCollectionClassName();

        $this->collIssuess = new $collectionClassName;
        $this->collIssuessPartial = true;
        $this->collIssuess->setModel('\Issues');
    }

    /**
     * Checks if the collIssuess collection is loaded.
     *
     * @return bool
     */
    public function isIssuessLoaded()
    {
        return null !== $this->collIssuess;
    }

    /**
     * Gets a collection of ChildIssues objects related by a many-to-many relationship
     * to the current object by way of the R_rights_forissue cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRights is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildIssues[] List of ChildIssues objects
     */
    public function getIssuess(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collIssuessPartial && !$this->isNew();
        if (null === $this->collIssuess || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collIssuess) {
                    $this->initIssuess();
                }
            } else {

                $query = ChildIssuesQuery::create(null, $criteria)
                    ->filterByRights($this);
                $collIssuess = $query->find($con);
                if (null !== $criteria) {
                    return $collIssuess;
                }

                if ($partial && $this->collIssuess) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collIssuess as $obj) {
                        if (!$collIssuess->contains($obj)) {
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
     * Sets a collection of Issues objects related by a many-to-many relationship
     * to the current object by way of the R_rights_forissue cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $issuess A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildRights The current object (for fluent API support)
     */
    public function setIssuess(Collection $issuess, ConnectionInterface $con = null)
    {
        $this->clearIssuess();
        $currentIssuess = $this->getIssuess();

        $issuessScheduledForDeletion = $currentIssuess->diff($issuess);

        foreach ($issuessScheduledForDeletion as $toDelete) {
            $this->removeIssues($toDelete);
        }

        foreach ($issuess as $issues) {
            if (!$currentIssuess->contains($issues)) {
                $this->doAddIssues($issues);
            }
        }

        $this->collIssuessPartial = false;
        $this->collIssuess = $issuess;

        return $this;
    }

    /**
     * Gets the number of Issues objects related by a many-to-many relationship
     * to the current object by way of the R_rights_forissue cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Issues objects
     */
    public function countIssuess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collIssuessPartial && !$this->isNew();
        if (null === $this->collIssuess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collIssuess) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getIssuess());
                }

                $query = ChildIssuesQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByRights($this)
                    ->count($con);
            }
        } else {
            return count($this->collIssuess);
        }
    }

    /**
     * Associate a ChildIssues to this object
     * through the R_rights_forissue cross reference table.
     *
     * @param ChildIssues $issues
     * @return ChildRights The current object (for fluent API support)
     */
    public function addIssues(ChildIssues $issues)
    {
        if ($this->collIssuess === null) {
            $this->initIssuess();
        }

        if (!$this->getIssuess()->contains($issues)) {
            // only add it if the **same** object is not already associated
            $this->collIssuess->push($issues);
            $this->doAddIssues($issues);
        }

        return $this;
    }

    /**
     *
     * @param ChildIssues $issues
     */
    protected function doAddIssues(ChildIssues $issues)
    {
        $rRightsForissue = new ChildRRightsForissue();

        $rRightsForissue->setIssues($issues);

        $rRightsForissue->setRights($this);

        $this->addRRightsForissue($rRightsForissue);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$issues->isRightssLoaded()) {
            $issues->initRightss();
            $issues->getRightss()->push($this);
        } elseif (!$issues->getRightss()->contains($this)) {
            $issues->getRightss()->push($this);
        }

    }

    /**
     * Remove issues of this object
     * through the R_rights_forissue cross reference table.
     *
     * @param ChildIssues $issues
     * @return ChildRights The current object (for fluent API support)
     */
    public function removeIssues(ChildIssues $issues)
    {
        if ($this->getIssuess()->contains($issues)) {
            $rRightsForissue = new ChildRRightsForissue();
            $rRightsForissue->setIssues($issues);
            if ($issues->isRightssLoaded()) {
                //remove the back reference if available
                $issues->getRightss()->removeObject($this);
            }

            $rRightsForissue->setRights($this);
            $this->removeRRightsForissue(clone $rRightsForissue);
            $rRightsForissue->clear();

            $this->collIssuess->remove($this->collIssuess->search($issues));

            if (null === $this->issuessScheduledForDeletion) {
                $this->issuessScheduledForDeletion = clone $this->collIssuess;
                $this->issuessScheduledForDeletion->clear();
            }

            $this->issuessScheduledForDeletion->push($issues);
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
        $collectionClassName = RRightsFortemplateTableMap::getTableMap()->getCollectionClassName();

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
     * to the current object by way of the R_rights_fortemplate cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRights is new, it will return
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
                    ->filterByRights($this);
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
     * to the current object by way of the R_rights_fortemplate cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $templatenamess A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildRights The current object (for fluent API support)
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
     * to the current object by way of the R_rights_fortemplate cross-reference table.
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
                    ->filterByRights($this)
                    ->count($con);
            }
        } else {
            return count($this->collTemplatenamess);
        }
    }

    /**
     * Associate a ChildTemplatenames to this object
     * through the R_rights_fortemplate cross reference table.
     *
     * @param ChildTemplatenames $templatenames
     * @return ChildRights The current object (for fluent API support)
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
        $rRightsFortemplate = new ChildRRightsFortemplate();

        $rRightsFortemplate->setTemplatenames($templatenames);

        $rRightsFortemplate->setRights($this);

        $this->addRRightsFortemplate($rRightsFortemplate);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$templatenames->isRightssLoaded()) {
            $templatenames->initRightss();
            $templatenames->getRightss()->push($this);
        } elseif (!$templatenames->getRightss()->contains($this)) {
            $templatenames->getRightss()->push($this);
        }

    }

    /**
     * Remove templatenames of this object
     * through the R_rights_fortemplate cross reference table.
     *
     * @param ChildTemplatenames $templatenames
     * @return ChildRights The current object (for fluent API support)
     */
    public function removeTemplatenames(ChildTemplatenames $templatenames)
    {
        if ($this->getTemplatenamess()->contains($templatenames)) {
            $rRightsFortemplate = new ChildRRightsFortemplate();
            $rRightsFortemplate->setTemplatenames($templatenames);
            if ($templatenames->isRightssLoaded()) {
                //remove the back reference if available
                $templatenames->getRightss()->removeObject($this);
            }

            $rRightsFortemplate->setRights($this);
            $this->removeRRightsFortemplate(clone $rRightsFortemplate);
            $rRightsFortemplate->clear();

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
     * Initializes the collFormatss crossRef collection.
     *
     * By default this just sets the collFormatss collection to an empty collection (like clearFormatss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initFormatss()
    {
        $collectionClassName = RRightsForformatTableMap::getTableMap()->getCollectionClassName();

        $this->collFormatss = new $collectionClassName;
        $this->collFormatssPartial = true;
        $this->collFormatss->setModel('\Formats');
    }

    /**
     * Checks if the collFormatss collection is loaded.
     *
     * @return bool
     */
    public function isFormatssLoaded()
    {
        return null !== $this->collFormatss;
    }

    /**
     * Gets a collection of ChildFormats objects related by a many-to-many relationship
     * to the current object by way of the R_rights_forformat cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRights is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildFormats[] List of ChildFormats objects
     */
    public function getFormatss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFormatssPartial && !$this->isNew();
        if (null === $this->collFormatss || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collFormatss) {
                    $this->initFormatss();
                }
            } else {

                $query = ChildFormatsQuery::create(null, $criteria)
                    ->filterByRights($this);
                $collFormatss = $query->find($con);
                if (null !== $criteria) {
                    return $collFormatss;
                }

                if ($partial && $this->collFormatss) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collFormatss as $obj) {
                        if (!$collFormatss->contains($obj)) {
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
     * Sets a collection of Formats objects related by a many-to-many relationship
     * to the current object by way of the R_rights_forformat cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $formatss A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildRights The current object (for fluent API support)
     */
    public function setFormatss(Collection $formatss, ConnectionInterface $con = null)
    {
        $this->clearFormatss();
        $currentFormatss = $this->getFormatss();

        $formatssScheduledForDeletion = $currentFormatss->diff($formatss);

        foreach ($formatssScheduledForDeletion as $toDelete) {
            $this->removeFormats($toDelete);
        }

        foreach ($formatss as $formats) {
            if (!$currentFormatss->contains($formats)) {
                $this->doAddFormats($formats);
            }
        }

        $this->collFormatssPartial = false;
        $this->collFormatss = $formatss;

        return $this;
    }

    /**
     * Gets the number of Formats objects related by a many-to-many relationship
     * to the current object by way of the R_rights_forformat cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Formats objects
     */
    public function countFormatss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFormatssPartial && !$this->isNew();
        if (null === $this->collFormatss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFormatss) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getFormatss());
                }

                $query = ChildFormatsQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByRights($this)
                    ->count($con);
            }
        } else {
            return count($this->collFormatss);
        }
    }

    /**
     * Associate a ChildFormats to this object
     * through the R_rights_forformat cross reference table.
     *
     * @param ChildFormats $formats
     * @return ChildRights The current object (for fluent API support)
     */
    public function addFormats(ChildFormats $formats)
    {
        if ($this->collFormatss === null) {
            $this->initFormatss();
        }

        if (!$this->getFormatss()->contains($formats)) {
            // only add it if the **same** object is not already associated
            $this->collFormatss->push($formats);
            $this->doAddFormats($formats);
        }

        return $this;
    }

    /**
     *
     * @param ChildFormats $formats
     */
    protected function doAddFormats(ChildFormats $formats)
    {
        $rRightsForformat = new ChildRRightsForformat();

        $rRightsForformat->setFormats($formats);

        $rRightsForformat->setRights($this);

        $this->addRRightsForformat($rRightsForformat);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$formats->isRightssLoaded()) {
            $formats->initRightss();
            $formats->getRightss()->push($this);
        } elseif (!$formats->getRightss()->contains($this)) {
            $formats->getRightss()->push($this);
        }

    }

    /**
     * Remove formats of this object
     * through the R_rights_forformat cross reference table.
     *
     * @param ChildFormats $formats
     * @return ChildRights The current object (for fluent API support)
     */
    public function removeFormats(ChildFormats $formats)
    {
        if ($this->getFormatss()->contains($formats)) {
            $rRightsForformat = new ChildRRightsForformat();
            $rRightsForformat->setFormats($formats);
            if ($formats->isRightssLoaded()) {
                //remove the back reference if available
                $formats->getRightss()->removeObject($this);
            }

            $rRightsForformat->setRights($this);
            $this->removeRRightsForformat(clone $rRightsForformat);
            $rRightsForformat->clear();

            $this->collFormatss->remove($this->collFormatss->search($formats));

            if (null === $this->formatssScheduledForDeletion) {
                $this->formatssScheduledForDeletion = clone $this->collFormatss;
                $this->formatssScheduledForDeletion->clear();
            }

            $this->formatssScheduledForDeletion->push($formats);
        }


        return $this;
    }

    /**
     * Clears out the collUserss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUserss()
     */
    public function clearUserss()
    {
        $this->collUserss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collUserss crossRef collection.
     *
     * By default this just sets the collUserss collection to an empty collection (like clearUserss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initUserss()
    {
        $collectionClassName = RRightsForuserTableMap::getTableMap()->getCollectionClassName();

        $this->collUserss = new $collectionClassName;
        $this->collUserssPartial = true;
        $this->collUserss->setModel('\Users');
    }

    /**
     * Checks if the collUserss collection is loaded.
     *
     * @return bool
     */
    public function isUserssLoaded()
    {
        return null !== $this->collUserss;
    }

    /**
     * Gets a collection of ChildUsers objects related by a many-to-many relationship
     * to the current object by way of the R_rights_foruser cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildRights is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildUsers[] List of ChildUsers objects
     */
    public function getUserss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUserssPartial && !$this->isNew();
        if (null === $this->collUserss || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collUserss) {
                    $this->initUserss();
                }
            } else {

                $query = ChildUsersQuery::create(null, $criteria)
                    ->filterByRights($this);
                $collUserss = $query->find($con);
                if (null !== $criteria) {
                    return $collUserss;
                }

                if ($partial && $this->collUserss) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collUserss as $obj) {
                        if (!$collUserss->contains($obj)) {
                            $collUserss[] = $obj;
                        }
                    }
                }

                $this->collUserss = $collUserss;
                $this->collUserssPartial = false;
            }
        }

        return $this->collUserss;
    }

    /**
     * Sets a collection of Users objects related by a many-to-many relationship
     * to the current object by way of the R_rights_foruser cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $userss A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildRights The current object (for fluent API support)
     */
    public function setUserss(Collection $userss, ConnectionInterface $con = null)
    {
        $this->clearUserss();
        $currentUserss = $this->getUserss();

        $userssScheduledForDeletion = $currentUserss->diff($userss);

        foreach ($userssScheduledForDeletion as $toDelete) {
            $this->removeUsers($toDelete);
        }

        foreach ($userss as $users) {
            if (!$currentUserss->contains($users)) {
                $this->doAddUsers($users);
            }
        }

        $this->collUserssPartial = false;
        $this->collUserss = $userss;

        return $this;
    }

    /**
     * Gets the number of Users objects related by a many-to-many relationship
     * to the current object by way of the R_rights_foruser cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Users objects
     */
    public function countUserss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUserssPartial && !$this->isNew();
        if (null === $this->collUserss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUserss) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getUserss());
                }

                $query = ChildUsersQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByRights($this)
                    ->count($con);
            }
        } else {
            return count($this->collUserss);
        }
    }

    /**
     * Associate a ChildUsers to this object
     * through the R_rights_foruser cross reference table.
     *
     * @param ChildUsers $users
     * @return ChildRights The current object (for fluent API support)
     */
    public function addUsers(ChildUsers $users)
    {
        if ($this->collUserss === null) {
            $this->initUserss();
        }

        if (!$this->getUserss()->contains($users)) {
            // only add it if the **same** object is not already associated
            $this->collUserss->push($users);
            $this->doAddUsers($users);
        }

        return $this;
    }

    /**
     *
     * @param ChildUsers $users
     */
    protected function doAddUsers(ChildUsers $users)
    {
        $rRightsForuser = new ChildRRightsForuser();

        $rRightsForuser->setUsers($users);

        $rRightsForuser->setRights($this);

        $this->addRRightsForuser($rRightsForuser);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$users->isRightssLoaded()) {
            $users->initRightss();
            $users->getRightss()->push($this);
        } elseif (!$users->getRightss()->contains($this)) {
            $users->getRightss()->push($this);
        }

    }

    /**
     * Remove users of this object
     * through the R_rights_foruser cross reference table.
     *
     * @param ChildUsers $users
     * @return ChildRights The current object (for fluent API support)
     */
    public function removeUsers(ChildUsers $users)
    {
        if ($this->getUserss()->contains($users)) {
            $rRightsForuser = new ChildRRightsForuser();
            $rRightsForuser->setUsers($users);
            if ($users->isRightssLoaded()) {
                //remove the back reference if available
                $users->getRightss()->removeObject($this);
            }

            $rRightsForuser->setRights($this);
            $this->removeRRightsForuser(clone $rRightsForuser);
            $rRightsForuser->clear();

            $this->collUserss->remove($this->collUserss->search($users));

            if (null === $this->userssScheduledForDeletion) {
                $this->userssScheduledForDeletion = clone $this->collUserss;
                $this->userssScheduledForDeletion->clear();
            }

            $this->userssScheduledForDeletion->push($users);
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
        $this->id = null;
        $this->_group = null;
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
            if ($this->collRRightsForbooks) {
                foreach ($this->collRRightsForbooks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRRightsForissues) {
                foreach ($this->collRRightsForissues as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRRightsFortemplates) {
                foreach ($this->collRRightsFortemplates as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRRightsForformats) {
                foreach ($this->collRRightsForformats as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRRightsForusers) {
                foreach ($this->collRRightsForusers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collBookss) {
                foreach ($this->collBookss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collIssuess) {
                foreach ($this->collIssuess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTemplatenamess) {
                foreach ($this->collTemplatenamess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFormatss) {
                foreach ($this->collFormatss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUserss) {
                foreach ($this->collUserss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collRRightsForbooks = null;
        $this->collRRightsForissues = null;
        $this->collRRightsFortemplates = null;
        $this->collRRightsForformats = null;
        $this->collRRightsForusers = null;
        $this->collBookss = null;
        $this->collIssuess = null;
        $this->collTemplatenamess = null;
        $this->collFormatss = null;
        $this->collUserss = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(RightsTableMap::DEFAULT_STRING_FORMAT);
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
