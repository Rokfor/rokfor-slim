<?php

namespace Base;

use \PdfQuery as ChildPdfQuery;
use \Plugins as ChildPlugins;
use \PluginsQuery as ChildPluginsQuery;
use \Exception;
use \PDO;
use Map\PdfTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the '_pdf' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Pdf implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\PdfTableMap';


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
     * The value for the _file field.
     *
     * @var        string
     */
    protected $_file;

    /**
     * The value for the _date field.
     *
     * @var        int
     */
    protected $_date;

    /**
     * The value for the _issue field.
     *
     * @var        int
     */
    protected $_issue;

    /**
     * The value for the _plugin field.
     *
     * @var        int
     */
    protected $_plugin;

    /**
     * The value for the _fileinfo field.
     *
     * @var        string
     */
    protected $_fileinfo;

    /**
     * The value for the _otc field.
     *
     * @var        string
     */
    protected $_otc;

    /**
     * The value for the _config field.
     *
     * @var        string
     */
    protected $_config;

    /**
     * The value for the _configvalue field.
     *
     * @var        int
     */
    protected $_configvalue;

    /**
     * The value for the __sort__ field.
     *
     * @var        int
     */
    protected $__sort__;

    /**
     * @var        ChildPlugins
     */
    protected $aPlugins;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of Base\Pdf object.
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
     * Compares this with another <code>Pdf</code> instance.  If
     * <code>obj</code> is an instance of <code>Pdf</code>, delegates to
     * <code>equals(Pdf)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Pdf The current object, for fluid interface
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
     * Get the [_file] column value.
     *
     * @return string
     */
    public function getFile()
    {
        return $this->_file;
    }

    /**
     * Get the [_date] column value.
     *
     * @return int
     */
    public function getDate()
    {
        return $this->_date;
    }

    /**
     * Get the [_issue] column value.
     *
     * @return int
     */
    public function getIssue()
    {
        return $this->_issue;
    }

    /**
     * Get the [_plugin] column value.
     *
     * @return int
     */
    public function getPlugin()
    {
        return $this->_plugin;
    }

    /**
     * Get the [_fileinfo] column value.
     *
     * @return string
     */
    public function getPages()
    {
        return $this->_fileinfo;
    }

    /**
     * Get the [_otc] column value.
     *
     * @return string
     */
    public function getOtc()
    {
        return $this->_otc;
    }

    /**
     * Get the [_config] column value.
     *
     * @return string
     */
    public function getConfigSys()
    {
        return $this->_config;
    }

    /**
     * Get the [_configvalue] column value.
     *
     * @return int
     */
    public function getConfigValue()
    {
        return $this->_configvalue;
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
     * @return $this|\Pdf The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PdfTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [_file] column.
     *
     * @param string $v new value
     * @return $this|\Pdf The current object (for fluent API support)
     */
    public function setFile($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_file !== $v) {
            $this->_file = $v;
            $this->modifiedColumns[PdfTableMap::COL__FILE] = true;
        }

        return $this;
    } // setFile()

    /**
     * Set the value of [_date] column.
     *
     * @param int $v new value
     * @return $this|\Pdf The current object (for fluent API support)
     */
    public function setDate($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->_date !== $v) {
            $this->_date = $v;
            $this->modifiedColumns[PdfTableMap::COL__DATE] = true;
        }

        return $this;
    } // setDate()

    /**
     * Set the value of [_issue] column.
     *
     * @param int $v new value
     * @return $this|\Pdf The current object (for fluent API support)
     */
    public function setIssue($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->_issue !== $v) {
            $this->_issue = $v;
            $this->modifiedColumns[PdfTableMap::COL__ISSUE] = true;
        }

        return $this;
    } // setIssue()

    /**
     * Set the value of [_plugin] column.
     *
     * @param int $v new value
     * @return $this|\Pdf The current object (for fluent API support)
     */
    public function setPlugin($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->_plugin !== $v) {
            $this->_plugin = $v;
            $this->modifiedColumns[PdfTableMap::COL__PLUGIN] = true;
        }

        if ($this->aPlugins !== null && $this->aPlugins->getId() !== $v) {
            $this->aPlugins = null;
        }

        return $this;
    } // setPlugin()

    /**
     * Set the value of [_fileinfo] column.
     *
     * @param string $v new value
     * @return $this|\Pdf The current object (for fluent API support)
     */
    public function setPages($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_fileinfo !== $v) {
            $this->_fileinfo = $v;
            $this->modifiedColumns[PdfTableMap::COL__FILEINFO] = true;
        }

        return $this;
    } // setPages()

    /**
     * Set the value of [_otc] column.
     *
     * @param string $v new value
     * @return $this|\Pdf The current object (for fluent API support)
     */
    public function setOtc($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_otc !== $v) {
            $this->_otc = $v;
            $this->modifiedColumns[PdfTableMap::COL__OTC] = true;
        }

        return $this;
    } // setOtc()

    /**
     * Set the value of [_config] column.
     *
     * @param string $v new value
     * @return $this|\Pdf The current object (for fluent API support)
     */
    public function setConfigSys($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_config !== $v) {
            $this->_config = $v;
            $this->modifiedColumns[PdfTableMap::COL__CONFIG] = true;
        }

        return $this;
    } // setConfigSys()

    /**
     * Set the value of [_configvalue] column.
     *
     * @param int $v new value
     * @return $this|\Pdf The current object (for fluent API support)
     */
    public function setConfigValue($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->_configvalue !== $v) {
            $this->_configvalue = $v;
            $this->modifiedColumns[PdfTableMap::COL__CONFIGVALUE] = true;
        }

        return $this;
    } // setConfigValue()

    /**
     * Set the value of [__sort__] column.
     *
     * @param int $v new value
     * @return $this|\Pdf The current object (for fluent API support)
     */
    public function setSort($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__sort__ !== $v) {
            $this->__sort__ = $v;
            $this->modifiedColumns[PdfTableMap::COL___SORT__] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PdfTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PdfTableMap::translateFieldName('File', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_file = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PdfTableMap::translateFieldName('Date', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_date = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PdfTableMap::translateFieldName('Issue', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_issue = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PdfTableMap::translateFieldName('Plugin', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_plugin = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PdfTableMap::translateFieldName('Pages', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_fileinfo = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PdfTableMap::translateFieldName('Otc', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_otc = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : PdfTableMap::translateFieldName('ConfigSys', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_config = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : PdfTableMap::translateFieldName('ConfigValue', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_configvalue = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : PdfTableMap::translateFieldName('Sort', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__sort__ = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = PdfTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Pdf'), 0, $e);
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
        if ($this->aPlugins !== null && $this->_plugin !== $this->aPlugins->getId()) {
            $this->aPlugins = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(PdfTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPdfQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aPlugins = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Pdf::setDeleted()
     * @see Pdf::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PdfTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPdfQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PdfTableMap::DATABASE_NAME);
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
                PdfTableMap::addInstanceToPool($this);
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

            if ($this->aPlugins !== null) {
                if ($this->aPlugins->isModified() || $this->aPlugins->isNew()) {
                    $affectedRows += $this->aPlugins->save($con);
                }
                $this->setPlugins($this->aPlugins);
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

        $this->modifiedColumns[PdfTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PdfTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PdfTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PdfTableMap::COL__FILE)) {
            $modifiedColumns[':p' . $index++]  = '_file';
        }
        if ($this->isColumnModified(PdfTableMap::COL__DATE)) {
            $modifiedColumns[':p' . $index++]  = '_date';
        }
        if ($this->isColumnModified(PdfTableMap::COL__ISSUE)) {
            $modifiedColumns[':p' . $index++]  = '_issue';
        }
        if ($this->isColumnModified(PdfTableMap::COL__PLUGIN)) {
            $modifiedColumns[':p' . $index++]  = '_plugin';
        }
        if ($this->isColumnModified(PdfTableMap::COL__FILEINFO)) {
            $modifiedColumns[':p' . $index++]  = '_fileinfo';
        }
        if ($this->isColumnModified(PdfTableMap::COL__OTC)) {
            $modifiedColumns[':p' . $index++]  = '_otc';
        }
        if ($this->isColumnModified(PdfTableMap::COL__CONFIG)) {
            $modifiedColumns[':p' . $index++]  = '_config';
        }
        if ($this->isColumnModified(PdfTableMap::COL__CONFIGVALUE)) {
            $modifiedColumns[':p' . $index++]  = '_configvalue';
        }
        if ($this->isColumnModified(PdfTableMap::COL___SORT__)) {
            $modifiedColumns[':p' . $index++]  = '__sort__';
        }

        $sql = sprintf(
            'INSERT INTO _pdf (%s) VALUES (%s)',
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
                    case '_file':
                        $stmt->bindValue($identifier, $this->_file, PDO::PARAM_STR);
                        break;
                    case '_date':
                        $stmt->bindValue($identifier, $this->_date, PDO::PARAM_INT);
                        break;
                    case '_issue':
                        $stmt->bindValue($identifier, $this->_issue, PDO::PARAM_INT);
                        break;
                    case '_plugin':
                        $stmt->bindValue($identifier, $this->_plugin, PDO::PARAM_INT);
                        break;
                    case '_fileinfo':
                        $stmt->bindValue($identifier, $this->_fileinfo, PDO::PARAM_STR);
                        break;
                    case '_otc':
                        $stmt->bindValue($identifier, $this->_otc, PDO::PARAM_STR);
                        break;
                    case '_config':
                        $stmt->bindValue($identifier, $this->_config, PDO::PARAM_STR);
                        break;
                    case '_configvalue':
                        $stmt->bindValue($identifier, $this->_configvalue, PDO::PARAM_INT);
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
        $pos = PdfTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getFile();
                break;
            case 2:
                return $this->getDate();
                break;
            case 3:
                return $this->getIssue();
                break;
            case 4:
                return $this->getPlugin();
                break;
            case 5:
                return $this->getPages();
                break;
            case 6:
                return $this->getOtc();
                break;
            case 7:
                return $this->getConfigSys();
                break;
            case 8:
                return $this->getConfigValue();
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

        if (isset($alreadyDumpedObjects['Pdf'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Pdf'][$this->hashCode()] = true;
        $keys = PdfTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getFile(),
            $keys[2] => $this->getDate(),
            $keys[3] => $this->getIssue(),
            $keys[4] => $this->getPlugin(),
            $keys[5] => $this->getPages(),
            $keys[6] => $this->getOtc(),
            $keys[7] => $this->getConfigSys(),
            $keys[8] => $this->getConfigValue(),
            $keys[9] => $this->getSort(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aPlugins) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'plugins';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = '_plugins';
                        break;
                    default:
                        $key = 'Plugins';
                }

                $result[$key] = $this->aPlugins->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\Pdf
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PdfTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Pdf
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setFile($value);
                break;
            case 2:
                $this->setDate($value);
                break;
            case 3:
                $this->setIssue($value);
                break;
            case 4:
                $this->setPlugin($value);
                break;
            case 5:
                $this->setPages($value);
                break;
            case 6:
                $this->setOtc($value);
                break;
            case 7:
                $this->setConfigSys($value);
                break;
            case 8:
                $this->setConfigValue($value);
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
        $keys = PdfTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setFile($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDate($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setIssue($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setPlugin($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setPages($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setOtc($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setConfigSys($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setConfigValue($arr[$keys[8]]);
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
     * @return $this|\Pdf The current object, for fluid interface
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
        $criteria = new Criteria(PdfTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PdfTableMap::COL_ID)) {
            $criteria->add(PdfTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PdfTableMap::COL__FILE)) {
            $criteria->add(PdfTableMap::COL__FILE, $this->_file);
        }
        if ($this->isColumnModified(PdfTableMap::COL__DATE)) {
            $criteria->add(PdfTableMap::COL__DATE, $this->_date);
        }
        if ($this->isColumnModified(PdfTableMap::COL__ISSUE)) {
            $criteria->add(PdfTableMap::COL__ISSUE, $this->_issue);
        }
        if ($this->isColumnModified(PdfTableMap::COL__PLUGIN)) {
            $criteria->add(PdfTableMap::COL__PLUGIN, $this->_plugin);
        }
        if ($this->isColumnModified(PdfTableMap::COL__FILEINFO)) {
            $criteria->add(PdfTableMap::COL__FILEINFO, $this->_fileinfo);
        }
        if ($this->isColumnModified(PdfTableMap::COL__OTC)) {
            $criteria->add(PdfTableMap::COL__OTC, $this->_otc);
        }
        if ($this->isColumnModified(PdfTableMap::COL__CONFIG)) {
            $criteria->add(PdfTableMap::COL__CONFIG, $this->_config);
        }
        if ($this->isColumnModified(PdfTableMap::COL__CONFIGVALUE)) {
            $criteria->add(PdfTableMap::COL__CONFIGVALUE, $this->_configvalue);
        }
        if ($this->isColumnModified(PdfTableMap::COL___SORT__)) {
            $criteria->add(PdfTableMap::COL___SORT__, $this->__sort__);
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
        $criteria = ChildPdfQuery::create();
        $criteria->add(PdfTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Pdf (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setFile($this->getFile());
        $copyObj->setDate($this->getDate());
        $copyObj->setIssue($this->getIssue());
        $copyObj->setPlugin($this->getPlugin());
        $copyObj->setPages($this->getPages());
        $copyObj->setOtc($this->getOtc());
        $copyObj->setConfigSys($this->getConfigSys());
        $copyObj->setConfigValue($this->getConfigValue());
        $copyObj->setSort($this->getSort());
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
     * @return \Pdf Clone of current object.
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
     * Declares an association between this object and a ChildPlugins object.
     *
     * @param  ChildPlugins $v
     * @return $this|\Pdf The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPlugins(ChildPlugins $v = null)
    {
        if ($v === null) {
            $this->setPlugin(NULL);
        } else {
            $this->setPlugin($v->getId());
        }

        $this->aPlugins = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPlugins object, it will not be re-added.
        if ($v !== null) {
            $v->addPdf($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPlugins object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPlugins The associated ChildPlugins object.
     * @throws PropelException
     */
    public function getPlugins(ConnectionInterface $con = null)
    {
        if ($this->aPlugins === null && ($this->_plugin != 0)) {
            $this->aPlugins = ChildPluginsQuery::create()->findPk($this->_plugin, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPlugins->addPdfs($this);
             */
        }

        return $this->aPlugins;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aPlugins) {
            $this->aPlugins->removePdf($this);
        }
        $this->id = null;
        $this->_file = null;
        $this->_date = null;
        $this->_issue = null;
        $this->_plugin = null;
        $this->_fileinfo = null;
        $this->_otc = null;
        $this->_config = null;
        $this->_configvalue = null;
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
        } // if ($deep)

        $this->aPlugins = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PdfTableMap::DEFAULT_STRING_FORMAT);
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
