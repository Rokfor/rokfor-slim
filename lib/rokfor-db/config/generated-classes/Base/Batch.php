<?php

namespace Base;

use \Batch as ChildBatch;
use \BatchQuery as ChildBatchQuery;
use \Books as ChildBooks;
use \BooksQuery as ChildBooksQuery;
use \RBatchForbook as ChildRBatchForbook;
use \RBatchForbookQuery as ChildRBatchForbookQuery;
use \Exception;
use \PDO;
use Map\BatchTableMap;
use Map\RBatchForbookTableMap;
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
 * Base class that represents a row from the '_batch' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Batch implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\BatchTableMap';


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
     * The value for the _description field.
     *
     * @var        string
     */
    protected $_description;

    /**
     * The value for the _precode field.
     *
     * @var        string
     */
    protected $_precode;

    /**
     * The value for the _postcode field.
     *
     * @var        string
     */
    protected $_postcode;

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
     * @var        ObjectCollection|ChildRBatchForbook[] Collection to store aggregation of ChildRBatchForbook objects.
     */
    protected $collRBatchForbooks;
    protected $collRBatchForbooksPartial;

    /**
     * @var        ObjectCollection|ChildBooks[] Cross Collection to store aggregation of ChildBooks objects.
     */
    protected $collBookss;

    /**
     * @var bool
     */
    protected $collBookssPartial;

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
     * @var ObjectCollection|ChildRBatchForbook[]
     */
    protected $rBatchForbooksScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Batch object.
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
     * Compares this with another <code>Batch</code> instance.  If
     * <code>obj</code> is an instance of <code>Batch</code>, delegates to
     * <code>equals(Batch)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Batch The current object, for fluid interface
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
     * Get the [_description] column value.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * Get the [_precode] column value.
     *
     * @return string
     */
    public function getPrecode()
    {
        return $this->_precode;
    }

    /**
     * Get the [_postcode] column value.
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->_postcode;
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
     * @return $this|\Batch The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[BatchTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [_name] column.
     *
     * @param string $v new value
     * @return $this|\Batch The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_name !== $v) {
            $this->_name = $v;
            $this->modifiedColumns[BatchTableMap::COL__NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [_description] column.
     *
     * @param string $v new value
     * @return $this|\Batch The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_description !== $v) {
            $this->_description = $v;
            $this->modifiedColumns[BatchTableMap::COL__DESCRIPTION] = true;
        }

        return $this;
    } // setDescription()

    /**
     * Set the value of [_precode] column.
     *
     * @param string $v new value
     * @return $this|\Batch The current object (for fluent API support)
     */
    public function setPrecode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_precode !== $v) {
            $this->_precode = $v;
            $this->modifiedColumns[BatchTableMap::COL__PRECODE] = true;
        }

        return $this;
    } // setPrecode()

    /**
     * Set the value of [_postcode] column.
     *
     * @param string $v new value
     * @return $this|\Batch The current object (for fluent API support)
     */
    public function setPostcode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_postcode !== $v) {
            $this->_postcode = $v;
            $this->modifiedColumns[BatchTableMap::COL__POSTCODE] = true;
        }

        return $this;
    } // setPostcode()

    /**
     * Set the value of [__config__] column.
     *
     * @param string $v new value
     * @return $this|\Batch The current object (for fluent API support)
     */
    public function setConfigSys($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->__config__ !== $v) {
            $this->__config__ = $v;
            $this->modifiedColumns[BatchTableMap::COL___CONFIG__] = true;
        }

        return $this;
    } // setConfigSys()

    /**
     * Set the value of [__split__] column.
     *
     * @param string $v new value
     * @return $this|\Batch The current object (for fluent API support)
     */
    public function setSplit($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->__split__ !== $v) {
            $this->__split__ = $v;
            $this->modifiedColumns[BatchTableMap::COL___SPLIT__] = true;
        }

        return $this;
    } // setSplit()

    /**
     * Set the value of [__parentnode__] column.
     *
     * @param int $v new value
     * @return $this|\Batch The current object (for fluent API support)
     */
    public function setParentnode($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__parentnode__ !== $v) {
            $this->__parentnode__ = $v;
            $this->modifiedColumns[BatchTableMap::COL___PARENTNODE__] = true;
        }

        return $this;
    } // setParentnode()

    /**
     * Set the value of [__sort__] column.
     *
     * @param int $v new value
     * @return $this|\Batch The current object (for fluent API support)
     */
    public function setSort($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__sort__ !== $v) {
            $this->__sort__ = $v;
            $this->modifiedColumns[BatchTableMap::COL___SORT__] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : BatchTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : BatchTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : BatchTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : BatchTableMap::translateFieldName('Precode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_precode = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : BatchTableMap::translateFieldName('Postcode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_postcode = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : BatchTableMap::translateFieldName('ConfigSys', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__config__ = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : BatchTableMap::translateFieldName('Split', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__split__ = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : BatchTableMap::translateFieldName('Parentnode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__parentnode__ = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : BatchTableMap::translateFieldName('Sort', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__sort__ = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = BatchTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Batch'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(BatchTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildBatchQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collRBatchForbooks = null;

            $this->collBookss = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Batch::setDeleted()
     * @see Batch::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(BatchTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildBatchQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(BatchTableMap::DATABASE_NAME);
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
                BatchTableMap::addInstanceToPool($this);
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

                    \RBatchForbookQuery::create()
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

        $this->modifiedColumns[BatchTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . BatchTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(BatchTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(BatchTableMap::COL__NAME)) {
            $modifiedColumns[':p' . $index++]  = '_name';
        }
        if ($this->isColumnModified(BatchTableMap::COL__DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '_description';
        }
        if ($this->isColumnModified(BatchTableMap::COL__PRECODE)) {
            $modifiedColumns[':p' . $index++]  = '_precode';
        }
        if ($this->isColumnModified(BatchTableMap::COL__POSTCODE)) {
            $modifiedColumns[':p' . $index++]  = '_postcode';
        }
        if ($this->isColumnModified(BatchTableMap::COL___CONFIG__)) {
            $modifiedColumns[':p' . $index++]  = '__config__';
        }
        if ($this->isColumnModified(BatchTableMap::COL___SPLIT__)) {
            $modifiedColumns[':p' . $index++]  = '__split__';
        }
        if ($this->isColumnModified(BatchTableMap::COL___PARENTNODE__)) {
            $modifiedColumns[':p' . $index++]  = '__parentnode__';
        }
        if ($this->isColumnModified(BatchTableMap::COL___SORT__)) {
            $modifiedColumns[':p' . $index++]  = '__sort__';
        }

        $sql = sprintf(
            'INSERT INTO _batch (%s) VALUES (%s)',
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
                    case '_description':
                        $stmt->bindValue($identifier, $this->_description, PDO::PARAM_STR);
                        break;
                    case '_precode':
                        $stmt->bindValue($identifier, $this->_precode, PDO::PARAM_STR);
                        break;
                    case '_postcode':
                        $stmt->bindValue($identifier, $this->_postcode, PDO::PARAM_STR);
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
        $pos = BatchTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getDescription();
                break;
            case 3:
                return $this->getPrecode();
                break;
            case 4:
                return $this->getPostcode();
                break;
            case 5:
                return $this->getConfigSys();
                break;
            case 6:
                return $this->getSplit();
                break;
            case 7:
                return $this->getParentnode();
                break;
            case 8:
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

        if (isset($alreadyDumpedObjects['Batch'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Batch'][$this->hashCode()] = true;
        $keys = BatchTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getDescription(),
            $keys[3] => $this->getPrecode(),
            $keys[4] => $this->getPostcode(),
            $keys[5] => $this->getConfigSys(),
            $keys[6] => $this->getSplit(),
            $keys[7] => $this->getParentnode(),
            $keys[8] => $this->getSort(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
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
     * @return $this|\Batch
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = BatchTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Batch
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
                $this->setDescription($value);
                break;
            case 3:
                $this->setPrecode($value);
                break;
            case 4:
                $this->setPostcode($value);
                break;
            case 5:
                $this->setConfigSys($value);
                break;
            case 6:
                $this->setSplit($value);
                break;
            case 7:
                $this->setParentnode($value);
                break;
            case 8:
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
        $keys = BatchTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDescription($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPrecode($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setPostcode($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setConfigSys($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setSplit($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setParentnode($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setSort($arr[$keys[8]]);
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
     * @return $this|\Batch The current object, for fluid interface
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
        $criteria = new Criteria(BatchTableMap::DATABASE_NAME);

        if ($this->isColumnModified(BatchTableMap::COL_ID)) {
            $criteria->add(BatchTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(BatchTableMap::COL__NAME)) {
            $criteria->add(BatchTableMap::COL__NAME, $this->_name);
        }
        if ($this->isColumnModified(BatchTableMap::COL__DESCRIPTION)) {
            $criteria->add(BatchTableMap::COL__DESCRIPTION, $this->_description);
        }
        if ($this->isColumnModified(BatchTableMap::COL__PRECODE)) {
            $criteria->add(BatchTableMap::COL__PRECODE, $this->_precode);
        }
        if ($this->isColumnModified(BatchTableMap::COL__POSTCODE)) {
            $criteria->add(BatchTableMap::COL__POSTCODE, $this->_postcode);
        }
        if ($this->isColumnModified(BatchTableMap::COL___CONFIG__)) {
            $criteria->add(BatchTableMap::COL___CONFIG__, $this->__config__);
        }
        if ($this->isColumnModified(BatchTableMap::COL___SPLIT__)) {
            $criteria->add(BatchTableMap::COL___SPLIT__, $this->__split__);
        }
        if ($this->isColumnModified(BatchTableMap::COL___PARENTNODE__)) {
            $criteria->add(BatchTableMap::COL___PARENTNODE__, $this->__parentnode__);
        }
        if ($this->isColumnModified(BatchTableMap::COL___SORT__)) {
            $criteria->add(BatchTableMap::COL___SORT__, $this->__sort__);
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
        $criteria = ChildBatchQuery::create();
        $criteria->add(BatchTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Batch (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setPrecode($this->getPrecode());
        $copyObj->setPostcode($this->getPostcode());
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
     * @return \Batch Clone of current object.
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
        if ('RBatchForbook' == $relationName) {
            $this->initRBatchForbooks();
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
     * If this ChildBatch is new, it will return
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
                    ->filterByBatch($this)
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
     * @return $this|ChildBatch The current object (for fluent API support)
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
            $rBatchForbookRemoved->setBatch(null);
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
                ->filterByBatch($this)
                ->count($con);
        }

        return count($this->collRBatchForbooks);
    }

    /**
     * Method called to associate a ChildRBatchForbook object to this object
     * through the ChildRBatchForbook foreign key attribute.
     *
     * @param  ChildRBatchForbook $l ChildRBatchForbook
     * @return $this|\Batch The current object (for fluent API support)
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
        $rBatchForbook->setBatch($this);
    }

    /**
     * @param  ChildRBatchForbook $rBatchForbook The ChildRBatchForbook object to remove.
     * @return $this|ChildBatch The current object (for fluent API support)
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
            $rBatchForbook->setBatch(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Batch is new, it will return
     * an empty collection; or if this Batch has previously
     * been saved, it will retrieve related RBatchForbooks from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Batch.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRBatchForbook[] List of ChildRBatchForbook objects
     */
    public function getRBatchForbooksJoinBooks(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRBatchForbookQuery::create(null, $criteria);
        $query->joinWith('Books', $joinBehavior);

        return $this->getRBatchForbooks($query, $con);
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
        $collectionClassName = RBatchForbookTableMap::getTableMap()->getCollectionClassName();

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
     * to the current object by way of the R_batch_forbook cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildBatch is new, it will return
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
                    ->filterByBatch($this);
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
     * to the current object by way of the R_batch_forbook cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $bookss A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildBatch The current object (for fluent API support)
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
     * to the current object by way of the R_batch_forbook cross-reference table.
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
                    ->filterByBatch($this)
                    ->count($con);
            }
        } else {
            return count($this->collBookss);
        }
    }

    /**
     * Associate a ChildBooks to this object
     * through the R_batch_forbook cross reference table.
     *
     * @param ChildBooks $books
     * @return ChildBatch The current object (for fluent API support)
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
        $rBatchForbook = new ChildRBatchForbook();

        $rBatchForbook->setBooks($books);

        $rBatchForbook->setBatch($this);

        $this->addRBatchForbook($rBatchForbook);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$books->isBatchesLoaded()) {
            $books->initBatches();
            $books->getBatches()->push($this);
        } elseif (!$books->getBatches()->contains($this)) {
            $books->getBatches()->push($this);
        }

    }

    /**
     * Remove books of this object
     * through the R_batch_forbook cross reference table.
     *
     * @param ChildBooks $books
     * @return ChildBatch The current object (for fluent API support)
     */
    public function removeBooks(ChildBooks $books)
    {
        if ($this->getBookss()->contains($books)) {
            $rBatchForbook = new ChildRBatchForbook();
            $rBatchForbook->setBooks($books);
            if ($books->isBatchesLoaded()) {
                //remove the back reference if available
                $books->getBatches()->removeObject($this);
            }

            $rBatchForbook->setBatch($this);
            $this->removeRBatchForbook(clone $rBatchForbook);
            $rBatchForbook->clear();

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
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->_name = null;
        $this->_description = null;
        $this->_precode = null;
        $this->_postcode = null;
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
            if ($this->collBookss) {
                foreach ($this->collBookss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collRBatchForbooks = null;
        $this->collBookss = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(BatchTableMap::DEFAULT_STRING_FORMAT);
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
