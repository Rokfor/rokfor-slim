<?php

namespace Base;

use \Books as ChildBooks;
use \BooksQuery as ChildBooksQuery;
use \Formats as ChildFormats;
use \FormatsQuery as ChildFormatsQuery;
use \Issues as ChildIssues;
use \IssuesQuery as ChildIssuesQuery;
use \Pdf as ChildPdf;
use \PdfQuery as ChildPdfQuery;
use \Plugins as ChildPlugins;
use \PluginsQuery as ChildPluginsQuery;
use \RPluginBook as ChildRPluginBook;
use \RPluginBookQuery as ChildRPluginBookQuery;
use \RPluginFormat as ChildRPluginFormat;
use \RPluginFormatQuery as ChildRPluginFormatQuery;
use \RPluginIssue as ChildRPluginIssue;
use \RPluginIssueQuery as ChildRPluginIssueQuery;
use \RPluginTemplate as ChildRPluginTemplate;
use \RPluginTemplateQuery as ChildRPluginTemplateQuery;
use \Templatenames as ChildTemplatenames;
use \TemplatenamesQuery as ChildTemplatenamesQuery;
use \Exception;
use \PDO;
use Map\PdfTableMap;
use Map\PluginsTableMap;
use Map\RPluginBookTableMap;
use Map\RPluginFormatTableMap;
use Map\RPluginIssueTableMap;
use Map\RPluginTemplateTableMap;
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
 * Base class that represents a row from the '_plugins' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Plugins implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\PluginsTableMap';


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
     * The value for the _api field.
     *
     * @var        string
     */
    protected $_api;

    /**
     * @var        ObjectCollection|ChildRPluginBook[] Collection to store aggregation of ChildRPluginBook objects.
     */
    protected $collRPluginBooks;
    protected $collRPluginBooksPartial;

    /**
     * @var        ObjectCollection|ChildRPluginFormat[] Collection to store aggregation of ChildRPluginFormat objects.
     */
    protected $collRPluginFormats;
    protected $collRPluginFormatsPartial;

    /**
     * @var        ObjectCollection|ChildRPluginIssue[] Collection to store aggregation of ChildRPluginIssue objects.
     */
    protected $collRPluginIssues;
    protected $collRPluginIssuesPartial;

    /**
     * @var        ObjectCollection|ChildRPluginTemplate[] Collection to store aggregation of ChildRPluginTemplate objects.
     */
    protected $collRPluginTemplates;
    protected $collRPluginTemplatesPartial;

    /**
     * @var        ObjectCollection|ChildPdf[] Collection to store aggregation of ChildPdf objects.
     */
    protected $collPdfs;
    protected $collPdfsPartial;

    /**
     * @var        ObjectCollection|ChildBooks[] Cross Collection to store aggregation of ChildBooks objects.
     */
    protected $collRBooks;

    /**
     * @var bool
     */
    protected $collRBooksPartial;

    /**
     * @var        ObjectCollection|ChildFormats[] Cross Collection to store aggregation of ChildFormats objects.
     */
    protected $collRFormats;

    /**
     * @var bool
     */
    protected $collRFormatsPartial;

    /**
     * @var        ObjectCollection|ChildIssues[] Cross Collection to store aggregation of ChildIssues objects.
     */
    protected $collRIssues;

    /**
     * @var bool
     */
    protected $collRIssuesPartial;

    /**
     * @var        ObjectCollection|ChildTemplatenames[] Cross Collection to store aggregation of ChildTemplatenames objects.
     */
    protected $collTemplatenamess;

    /**
     * @var bool
     */
    protected $collTemplatenamessPartial;

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
    protected $rBooksScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildFormats[]
     */
    protected $rFormatsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildIssues[]
     */
    protected $rIssuesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTemplatenames[]
     */
    protected $templatenamessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRPluginBook[]
     */
    protected $rPluginBooksScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRPluginFormat[]
     */
    protected $rPluginFormatsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRPluginIssue[]
     */
    protected $rPluginIssuesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRPluginTemplate[]
     */
    protected $rPluginTemplatesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPdf[]
     */
    protected $pdfsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Plugins object.
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
     * Compares this with another <code>Plugins</code> instance.  If
     * <code>obj</code> is an instance of <code>Plugins</code>, delegates to
     * <code>equals(Plugins)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Plugins The current object, for fluid interface
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
     * Get the [_api] column value.
     *
     * @return string
     */
    public function getApi()
    {
        return $this->_api;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Plugins The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PluginsTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [_name] column.
     *
     * @param string $v new value
     * @return $this|\Plugins The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_name !== $v) {
            $this->_name = $v;
            $this->modifiedColumns[PluginsTableMap::COL__NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [_api] column.
     *
     * @param string $v new value
     * @return $this|\Plugins The current object (for fluent API support)
     */
    public function setApi($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_api !== $v) {
            $this->_api = $v;
            $this->modifiedColumns[PluginsTableMap::COL__API] = true;
        }

        return $this;
    } // setApi()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PluginsTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PluginsTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PluginsTableMap::translateFieldName('Api', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_api = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = PluginsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Plugins'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(PluginsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPluginsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collRPluginBooks = null;

            $this->collRPluginFormats = null;

            $this->collRPluginIssues = null;

            $this->collRPluginTemplates = null;

            $this->collPdfs = null;

            $this->collRBooks = null;
            $this->collRFormats = null;
            $this->collRIssues = null;
            $this->collTemplatenamess = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Plugins::setDeleted()
     * @see Plugins::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PluginsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPluginsQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PluginsTableMap::DATABASE_NAME);
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
                PluginsTableMap::addInstanceToPool($this);
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

            if ($this->rBooksScheduledForDeletion !== null) {
                if (!$this->rBooksScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->rBooksScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RPluginBookQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->rBooksScheduledForDeletion = null;
                }

            }

            if ($this->collRBooks) {
                foreach ($this->collRBooks as $rBook) {
                    if (!$rBook->isDeleted() && ($rBook->isNew() || $rBook->isModified())) {
                        $rBook->save($con);
                    }
                }
            }


            if ($this->rFormatsScheduledForDeletion !== null) {
                if (!$this->rFormatsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->rFormatsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RPluginFormatQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->rFormatsScheduledForDeletion = null;
                }

            }

            if ($this->collRFormats) {
                foreach ($this->collRFormats as $rFormat) {
                    if (!$rFormat->isDeleted() && ($rFormat->isNew() || $rFormat->isModified())) {
                        $rFormat->save($con);
                    }
                }
            }


            if ($this->rIssuesScheduledForDeletion !== null) {
                if (!$this->rIssuesScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->rIssuesScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RPluginIssueQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->rIssuesScheduledForDeletion = null;
                }

            }

            if ($this->collRIssues) {
                foreach ($this->collRIssues as $rIssue) {
                    if (!$rIssue->isDeleted() && ($rIssue->isNew() || $rIssue->isModified())) {
                        $rIssue->save($con);
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

                    \RPluginTemplateQuery::create()
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

            if ($this->rPluginFormatsScheduledForDeletion !== null) {
                if (!$this->rPluginFormatsScheduledForDeletion->isEmpty()) {
                    \RPluginFormatQuery::create()
                        ->filterByPrimaryKeys($this->rPluginFormatsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rPluginFormatsScheduledForDeletion = null;
                }
            }

            if ($this->collRPluginFormats !== null) {
                foreach ($this->collRPluginFormats as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->rPluginIssuesScheduledForDeletion !== null) {
                if (!$this->rPluginIssuesScheduledForDeletion->isEmpty()) {
                    \RPluginIssueQuery::create()
                        ->filterByPrimaryKeys($this->rPluginIssuesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rPluginIssuesScheduledForDeletion = null;
                }
            }

            if ($this->collRPluginIssues !== null) {
                foreach ($this->collRPluginIssues as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->rPluginTemplatesScheduledForDeletion !== null) {
                if (!$this->rPluginTemplatesScheduledForDeletion->isEmpty()) {
                    \RPluginTemplateQuery::create()
                        ->filterByPrimaryKeys($this->rPluginTemplatesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rPluginTemplatesScheduledForDeletion = null;
                }
            }

            if ($this->collRPluginTemplates !== null) {
                foreach ($this->collRPluginTemplates as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pdfsScheduledForDeletion !== null) {
                if (!$this->pdfsScheduledForDeletion->isEmpty()) {
                    \PdfQuery::create()
                        ->filterByPrimaryKeys($this->pdfsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pdfsScheduledForDeletion = null;
                }
            }

            if ($this->collPdfs !== null) {
                foreach ($this->collPdfs as $referrerFK) {
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

        $this->modifiedColumns[PluginsTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PluginsTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PluginsTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PluginsTableMap::COL__NAME)) {
            $modifiedColumns[':p' . $index++]  = '_name';
        }
        if ($this->isColumnModified(PluginsTableMap::COL__API)) {
            $modifiedColumns[':p' . $index++]  = '_api';
        }

        $sql = sprintf(
            'INSERT INTO _plugins (%s) VALUES (%s)',
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
                    case '_api':
                        $stmt->bindValue($identifier, $this->_api, PDO::PARAM_STR);
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
        $pos = PluginsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getApi();
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

        if (isset($alreadyDumpedObjects['Plugins'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Plugins'][$this->hashCode()] = true;
        $keys = PluginsTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getApi(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
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
            if (null !== $this->collRPluginFormats) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rPluginFormats';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_plugin_formats';
                        break;
                    default:
                        $key = 'RPluginFormats';
                }

                $result[$key] = $this->collRPluginFormats->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRPluginIssues) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rPluginIssues';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_plugin_issues';
                        break;
                    default:
                        $key = 'RPluginIssues';
                }

                $result[$key] = $this->collRPluginIssues->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRPluginTemplates) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rPluginTemplates';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_plugin_templates';
                        break;
                    default:
                        $key = 'RPluginTemplates';
                }

                $result[$key] = $this->collRPluginTemplates->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPdfs) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'pdfs';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = '_pdfs';
                        break;
                    default:
                        $key = 'Pdfs';
                }

                $result[$key] = $this->collPdfs->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Plugins
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PluginsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Plugins
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
                $this->setApi($value);
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
        $keys = PluginsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setApi($arr[$keys[2]]);
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
     * @return $this|\Plugins The current object, for fluid interface
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
        $criteria = new Criteria(PluginsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PluginsTableMap::COL_ID)) {
            $criteria->add(PluginsTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PluginsTableMap::COL__NAME)) {
            $criteria->add(PluginsTableMap::COL__NAME, $this->_name);
        }
        if ($this->isColumnModified(PluginsTableMap::COL__API)) {
            $criteria->add(PluginsTableMap::COL__API, $this->_api);
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
        $criteria = ChildPluginsQuery::create();
        $criteria->add(PluginsTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Plugins (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setApi($this->getApi());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getRPluginBooks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRPluginBook($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRPluginFormats() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRPluginFormat($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRPluginIssues() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRPluginIssue($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRPluginTemplates() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRPluginTemplate($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPdfs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPdf($relObj->copy($deepCopy));
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
     * @return \Plugins Clone of current object.
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
        if ('RPluginBook' == $relationName) {
            $this->initRPluginBooks();
            return;
        }
        if ('RPluginFormat' == $relationName) {
            $this->initRPluginFormats();
            return;
        }
        if ('RPluginIssue' == $relationName) {
            $this->initRPluginIssues();
            return;
        }
        if ('RPluginTemplate' == $relationName) {
            $this->initRPluginTemplates();
            return;
        }
        if ('Pdf' == $relationName) {
            $this->initPdfs();
            return;
        }
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
     * If this ChildPlugins is new, it will return
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
                    ->filterByRPlugin($this)
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
     * @return $this|ChildPlugins The current object (for fluent API support)
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
            $rPluginBookRemoved->setRPlugin(null);
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
                ->filterByRPlugin($this)
                ->count($con);
        }

        return count($this->collRPluginBooks);
    }

    /**
     * Method called to associate a ChildRPluginBook object to this object
     * through the ChildRPluginBook foreign key attribute.
     *
     * @param  ChildRPluginBook $l ChildRPluginBook
     * @return $this|\Plugins The current object (for fluent API support)
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
        $rPluginBook->setRPlugin($this);
    }

    /**
     * @param  ChildRPluginBook $rPluginBook The ChildRPluginBook object to remove.
     * @return $this|ChildPlugins The current object (for fluent API support)
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
            $rPluginBook->setRPlugin(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Plugins is new, it will return
     * an empty collection; or if this Plugins has previously
     * been saved, it will retrieve related RPluginBooks from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Plugins.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRPluginBook[] List of ChildRPluginBook objects
     */
    public function getRPluginBooksJoinRBook(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRPluginBookQuery::create(null, $criteria);
        $query->joinWith('RBook', $joinBehavior);

        return $this->getRPluginBooks($query, $con);
    }

    /**
     * Clears out the collRPluginFormats collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRPluginFormats()
     */
    public function clearRPluginFormats()
    {
        $this->collRPluginFormats = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRPluginFormats collection loaded partially.
     */
    public function resetPartialRPluginFormats($v = true)
    {
        $this->collRPluginFormatsPartial = $v;
    }

    /**
     * Initializes the collRPluginFormats collection.
     *
     * By default this just sets the collRPluginFormats collection to an empty array (like clearcollRPluginFormats());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRPluginFormats($overrideExisting = true)
    {
        if (null !== $this->collRPluginFormats && !$overrideExisting) {
            return;
        }

        $collectionClassName = RPluginFormatTableMap::getTableMap()->getCollectionClassName();

        $this->collRPluginFormats = new $collectionClassName;
        $this->collRPluginFormats->setModel('\RPluginFormat');
    }

    /**
     * Gets an array of ChildRPluginFormat objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlugins is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRPluginFormat[] List of ChildRPluginFormat objects
     * @throws PropelException
     */
    public function getRPluginFormats(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRPluginFormatsPartial && !$this->isNew();
        if (null === $this->collRPluginFormats || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRPluginFormats) {
                // return empty collection
                $this->initRPluginFormats();
            } else {
                $collRPluginFormats = ChildRPluginFormatQuery::create(null, $criteria)
                    ->filterByRPlugin($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRPluginFormatsPartial && count($collRPluginFormats)) {
                        $this->initRPluginFormats(false);

                        foreach ($collRPluginFormats as $obj) {
                            if (false == $this->collRPluginFormats->contains($obj)) {
                                $this->collRPluginFormats->append($obj);
                            }
                        }

                        $this->collRPluginFormatsPartial = true;
                    }

                    return $collRPluginFormats;
                }

                if ($partial && $this->collRPluginFormats) {
                    foreach ($this->collRPluginFormats as $obj) {
                        if ($obj->isNew()) {
                            $collRPluginFormats[] = $obj;
                        }
                    }
                }

                $this->collRPluginFormats = $collRPluginFormats;
                $this->collRPluginFormatsPartial = false;
            }
        }

        return $this->collRPluginFormats;
    }

    /**
     * Sets a collection of ChildRPluginFormat objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rPluginFormats A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function setRPluginFormats(Collection $rPluginFormats, ConnectionInterface $con = null)
    {
        /** @var ChildRPluginFormat[] $rPluginFormatsToDelete */
        $rPluginFormatsToDelete = $this->getRPluginFormats(new Criteria(), $con)->diff($rPluginFormats);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rPluginFormatsScheduledForDeletion = clone $rPluginFormatsToDelete;

        foreach ($rPluginFormatsToDelete as $rPluginFormatRemoved) {
            $rPluginFormatRemoved->setRPlugin(null);
        }

        $this->collRPluginFormats = null;
        foreach ($rPluginFormats as $rPluginFormat) {
            $this->addRPluginFormat($rPluginFormat);
        }

        $this->collRPluginFormats = $rPluginFormats;
        $this->collRPluginFormatsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RPluginFormat objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RPluginFormat objects.
     * @throws PropelException
     */
    public function countRPluginFormats(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRPluginFormatsPartial && !$this->isNew();
        if (null === $this->collRPluginFormats || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRPluginFormats) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRPluginFormats());
            }

            $query = ChildRPluginFormatQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRPlugin($this)
                ->count($con);
        }

        return count($this->collRPluginFormats);
    }

    /**
     * Method called to associate a ChildRPluginFormat object to this object
     * through the ChildRPluginFormat foreign key attribute.
     *
     * @param  ChildRPluginFormat $l ChildRPluginFormat
     * @return $this|\Plugins The current object (for fluent API support)
     */
    public function addRPluginFormat(ChildRPluginFormat $l)
    {
        if ($this->collRPluginFormats === null) {
            $this->initRPluginFormats();
            $this->collRPluginFormatsPartial = true;
        }

        if (!$this->collRPluginFormats->contains($l)) {
            $this->doAddRPluginFormat($l);

            if ($this->rPluginFormatsScheduledForDeletion and $this->rPluginFormatsScheduledForDeletion->contains($l)) {
                $this->rPluginFormatsScheduledForDeletion->remove($this->rPluginFormatsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRPluginFormat $rPluginFormat The ChildRPluginFormat object to add.
     */
    protected function doAddRPluginFormat(ChildRPluginFormat $rPluginFormat)
    {
        $this->collRPluginFormats[]= $rPluginFormat;
        $rPluginFormat->setRPlugin($this);
    }

    /**
     * @param  ChildRPluginFormat $rPluginFormat The ChildRPluginFormat object to remove.
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function removeRPluginFormat(ChildRPluginFormat $rPluginFormat)
    {
        if ($this->getRPluginFormats()->contains($rPluginFormat)) {
            $pos = $this->collRPluginFormats->search($rPluginFormat);
            $this->collRPluginFormats->remove($pos);
            if (null === $this->rPluginFormatsScheduledForDeletion) {
                $this->rPluginFormatsScheduledForDeletion = clone $this->collRPluginFormats;
                $this->rPluginFormatsScheduledForDeletion->clear();
            }
            $this->rPluginFormatsScheduledForDeletion[]= clone $rPluginFormat;
            $rPluginFormat->setRPlugin(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Plugins is new, it will return
     * an empty collection; or if this Plugins has previously
     * been saved, it will retrieve related RPluginFormats from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Plugins.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRPluginFormat[] List of ChildRPluginFormat objects
     */
    public function getRPluginFormatsJoinRFormat(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRPluginFormatQuery::create(null, $criteria);
        $query->joinWith('RFormat', $joinBehavior);

        return $this->getRPluginFormats($query, $con);
    }

    /**
     * Clears out the collRPluginIssues collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRPluginIssues()
     */
    public function clearRPluginIssues()
    {
        $this->collRPluginIssues = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRPluginIssues collection loaded partially.
     */
    public function resetPartialRPluginIssues($v = true)
    {
        $this->collRPluginIssuesPartial = $v;
    }

    /**
     * Initializes the collRPluginIssues collection.
     *
     * By default this just sets the collRPluginIssues collection to an empty array (like clearcollRPluginIssues());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRPluginIssues($overrideExisting = true)
    {
        if (null !== $this->collRPluginIssues && !$overrideExisting) {
            return;
        }

        $collectionClassName = RPluginIssueTableMap::getTableMap()->getCollectionClassName();

        $this->collRPluginIssues = new $collectionClassName;
        $this->collRPluginIssues->setModel('\RPluginIssue');
    }

    /**
     * Gets an array of ChildRPluginIssue objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlugins is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRPluginIssue[] List of ChildRPluginIssue objects
     * @throws PropelException
     */
    public function getRPluginIssues(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRPluginIssuesPartial && !$this->isNew();
        if (null === $this->collRPluginIssues || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRPluginIssues) {
                // return empty collection
                $this->initRPluginIssues();
            } else {
                $collRPluginIssues = ChildRPluginIssueQuery::create(null, $criteria)
                    ->filterByRPlugin($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRPluginIssuesPartial && count($collRPluginIssues)) {
                        $this->initRPluginIssues(false);

                        foreach ($collRPluginIssues as $obj) {
                            if (false == $this->collRPluginIssues->contains($obj)) {
                                $this->collRPluginIssues->append($obj);
                            }
                        }

                        $this->collRPluginIssuesPartial = true;
                    }

                    return $collRPluginIssues;
                }

                if ($partial && $this->collRPluginIssues) {
                    foreach ($this->collRPluginIssues as $obj) {
                        if ($obj->isNew()) {
                            $collRPluginIssues[] = $obj;
                        }
                    }
                }

                $this->collRPluginIssues = $collRPluginIssues;
                $this->collRPluginIssuesPartial = false;
            }
        }

        return $this->collRPluginIssues;
    }

    /**
     * Sets a collection of ChildRPluginIssue objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rPluginIssues A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function setRPluginIssues(Collection $rPluginIssues, ConnectionInterface $con = null)
    {
        /** @var ChildRPluginIssue[] $rPluginIssuesToDelete */
        $rPluginIssuesToDelete = $this->getRPluginIssues(new Criteria(), $con)->diff($rPluginIssues);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rPluginIssuesScheduledForDeletion = clone $rPluginIssuesToDelete;

        foreach ($rPluginIssuesToDelete as $rPluginIssueRemoved) {
            $rPluginIssueRemoved->setRPlugin(null);
        }

        $this->collRPluginIssues = null;
        foreach ($rPluginIssues as $rPluginIssue) {
            $this->addRPluginIssue($rPluginIssue);
        }

        $this->collRPluginIssues = $rPluginIssues;
        $this->collRPluginIssuesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RPluginIssue objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RPluginIssue objects.
     * @throws PropelException
     */
    public function countRPluginIssues(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRPluginIssuesPartial && !$this->isNew();
        if (null === $this->collRPluginIssues || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRPluginIssues) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRPluginIssues());
            }

            $query = ChildRPluginIssueQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRPlugin($this)
                ->count($con);
        }

        return count($this->collRPluginIssues);
    }

    /**
     * Method called to associate a ChildRPluginIssue object to this object
     * through the ChildRPluginIssue foreign key attribute.
     *
     * @param  ChildRPluginIssue $l ChildRPluginIssue
     * @return $this|\Plugins The current object (for fluent API support)
     */
    public function addRPluginIssue(ChildRPluginIssue $l)
    {
        if ($this->collRPluginIssues === null) {
            $this->initRPluginIssues();
            $this->collRPluginIssuesPartial = true;
        }

        if (!$this->collRPluginIssues->contains($l)) {
            $this->doAddRPluginIssue($l);

            if ($this->rPluginIssuesScheduledForDeletion and $this->rPluginIssuesScheduledForDeletion->contains($l)) {
                $this->rPluginIssuesScheduledForDeletion->remove($this->rPluginIssuesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRPluginIssue $rPluginIssue The ChildRPluginIssue object to add.
     */
    protected function doAddRPluginIssue(ChildRPluginIssue $rPluginIssue)
    {
        $this->collRPluginIssues[]= $rPluginIssue;
        $rPluginIssue->setRPlugin($this);
    }

    /**
     * @param  ChildRPluginIssue $rPluginIssue The ChildRPluginIssue object to remove.
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function removeRPluginIssue(ChildRPluginIssue $rPluginIssue)
    {
        if ($this->getRPluginIssues()->contains($rPluginIssue)) {
            $pos = $this->collRPluginIssues->search($rPluginIssue);
            $this->collRPluginIssues->remove($pos);
            if (null === $this->rPluginIssuesScheduledForDeletion) {
                $this->rPluginIssuesScheduledForDeletion = clone $this->collRPluginIssues;
                $this->rPluginIssuesScheduledForDeletion->clear();
            }
            $this->rPluginIssuesScheduledForDeletion[]= clone $rPluginIssue;
            $rPluginIssue->setRPlugin(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Plugins is new, it will return
     * an empty collection; or if this Plugins has previously
     * been saved, it will retrieve related RPluginIssues from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Plugins.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRPluginIssue[] List of ChildRPluginIssue objects
     */
    public function getRPluginIssuesJoinRIssue(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRPluginIssueQuery::create(null, $criteria);
        $query->joinWith('RIssue', $joinBehavior);

        return $this->getRPluginIssues($query, $con);
    }

    /**
     * Clears out the collRPluginTemplates collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRPluginTemplates()
     */
    public function clearRPluginTemplates()
    {
        $this->collRPluginTemplates = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRPluginTemplates collection loaded partially.
     */
    public function resetPartialRPluginTemplates($v = true)
    {
        $this->collRPluginTemplatesPartial = $v;
    }

    /**
     * Initializes the collRPluginTemplates collection.
     *
     * By default this just sets the collRPluginTemplates collection to an empty array (like clearcollRPluginTemplates());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRPluginTemplates($overrideExisting = true)
    {
        if (null !== $this->collRPluginTemplates && !$overrideExisting) {
            return;
        }

        $collectionClassName = RPluginTemplateTableMap::getTableMap()->getCollectionClassName();

        $this->collRPluginTemplates = new $collectionClassName;
        $this->collRPluginTemplates->setModel('\RPluginTemplate');
    }

    /**
     * Gets an array of ChildRPluginTemplate objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlugins is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRPluginTemplate[] List of ChildRPluginTemplate objects
     * @throws PropelException
     */
    public function getRPluginTemplates(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRPluginTemplatesPartial && !$this->isNew();
        if (null === $this->collRPluginTemplates || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRPluginTemplates) {
                // return empty collection
                $this->initRPluginTemplates();
            } else {
                $collRPluginTemplates = ChildRPluginTemplateQuery::create(null, $criteria)
                    ->filterByRPlugin($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRPluginTemplatesPartial && count($collRPluginTemplates)) {
                        $this->initRPluginTemplates(false);

                        foreach ($collRPluginTemplates as $obj) {
                            if (false == $this->collRPluginTemplates->contains($obj)) {
                                $this->collRPluginTemplates->append($obj);
                            }
                        }

                        $this->collRPluginTemplatesPartial = true;
                    }

                    return $collRPluginTemplates;
                }

                if ($partial && $this->collRPluginTemplates) {
                    foreach ($this->collRPluginTemplates as $obj) {
                        if ($obj->isNew()) {
                            $collRPluginTemplates[] = $obj;
                        }
                    }
                }

                $this->collRPluginTemplates = $collRPluginTemplates;
                $this->collRPluginTemplatesPartial = false;
            }
        }

        return $this->collRPluginTemplates;
    }

    /**
     * Sets a collection of ChildRPluginTemplate objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rPluginTemplates A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function setRPluginTemplates(Collection $rPluginTemplates, ConnectionInterface $con = null)
    {
        /** @var ChildRPluginTemplate[] $rPluginTemplatesToDelete */
        $rPluginTemplatesToDelete = $this->getRPluginTemplates(new Criteria(), $con)->diff($rPluginTemplates);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rPluginTemplatesScheduledForDeletion = clone $rPluginTemplatesToDelete;

        foreach ($rPluginTemplatesToDelete as $rPluginTemplateRemoved) {
            $rPluginTemplateRemoved->setRPlugin(null);
        }

        $this->collRPluginTemplates = null;
        foreach ($rPluginTemplates as $rPluginTemplate) {
            $this->addRPluginTemplate($rPluginTemplate);
        }

        $this->collRPluginTemplates = $rPluginTemplates;
        $this->collRPluginTemplatesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RPluginTemplate objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RPluginTemplate objects.
     * @throws PropelException
     */
    public function countRPluginTemplates(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRPluginTemplatesPartial && !$this->isNew();
        if (null === $this->collRPluginTemplates || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRPluginTemplates) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRPluginTemplates());
            }

            $query = ChildRPluginTemplateQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRPlugin($this)
                ->count($con);
        }

        return count($this->collRPluginTemplates);
    }

    /**
     * Method called to associate a ChildRPluginTemplate object to this object
     * through the ChildRPluginTemplate foreign key attribute.
     *
     * @param  ChildRPluginTemplate $l ChildRPluginTemplate
     * @return $this|\Plugins The current object (for fluent API support)
     */
    public function addRPluginTemplate(ChildRPluginTemplate $l)
    {
        if ($this->collRPluginTemplates === null) {
            $this->initRPluginTemplates();
            $this->collRPluginTemplatesPartial = true;
        }

        if (!$this->collRPluginTemplates->contains($l)) {
            $this->doAddRPluginTemplate($l);

            if ($this->rPluginTemplatesScheduledForDeletion and $this->rPluginTemplatesScheduledForDeletion->contains($l)) {
                $this->rPluginTemplatesScheduledForDeletion->remove($this->rPluginTemplatesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRPluginTemplate $rPluginTemplate The ChildRPluginTemplate object to add.
     */
    protected function doAddRPluginTemplate(ChildRPluginTemplate $rPluginTemplate)
    {
        $this->collRPluginTemplates[]= $rPluginTemplate;
        $rPluginTemplate->setRPlugin($this);
    }

    /**
     * @param  ChildRPluginTemplate $rPluginTemplate The ChildRPluginTemplate object to remove.
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function removeRPluginTemplate(ChildRPluginTemplate $rPluginTemplate)
    {
        if ($this->getRPluginTemplates()->contains($rPluginTemplate)) {
            $pos = $this->collRPluginTemplates->search($rPluginTemplate);
            $this->collRPluginTemplates->remove($pos);
            if (null === $this->rPluginTemplatesScheduledForDeletion) {
                $this->rPluginTemplatesScheduledForDeletion = clone $this->collRPluginTemplates;
                $this->rPluginTemplatesScheduledForDeletion->clear();
            }
            $this->rPluginTemplatesScheduledForDeletion[]= clone $rPluginTemplate;
            $rPluginTemplate->setRPlugin(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Plugins is new, it will return
     * an empty collection; or if this Plugins has previously
     * been saved, it will retrieve related RPluginTemplates from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Plugins.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRPluginTemplate[] List of ChildRPluginTemplate objects
     */
    public function getRPluginTemplatesJoinTemplatenames(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRPluginTemplateQuery::create(null, $criteria);
        $query->joinWith('Templatenames', $joinBehavior);

        return $this->getRPluginTemplates($query, $con);
    }

    /**
     * Clears out the collPdfs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPdfs()
     */
    public function clearPdfs()
    {
        $this->collPdfs = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPdfs collection loaded partially.
     */
    public function resetPartialPdfs($v = true)
    {
        $this->collPdfsPartial = $v;
    }

    /**
     * Initializes the collPdfs collection.
     *
     * By default this just sets the collPdfs collection to an empty array (like clearcollPdfs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPdfs($overrideExisting = true)
    {
        if (null !== $this->collPdfs && !$overrideExisting) {
            return;
        }

        $collectionClassName = PdfTableMap::getTableMap()->getCollectionClassName();

        $this->collPdfs = new $collectionClassName;
        $this->collPdfs->setModel('\Pdf');
    }

    /**
     * Gets an array of ChildPdf objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlugins is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPdf[] List of ChildPdf objects
     * @throws PropelException
     */
    public function getPdfs(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPdfsPartial && !$this->isNew();
        if (null === $this->collPdfs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPdfs) {
                // return empty collection
                $this->initPdfs();
            } else {
                $collPdfs = ChildPdfQuery::create(null, $criteria)
                    ->filterByPlugins($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPdfsPartial && count($collPdfs)) {
                        $this->initPdfs(false);

                        foreach ($collPdfs as $obj) {
                            if (false == $this->collPdfs->contains($obj)) {
                                $this->collPdfs->append($obj);
                            }
                        }

                        $this->collPdfsPartial = true;
                    }

                    return $collPdfs;
                }

                if ($partial && $this->collPdfs) {
                    foreach ($this->collPdfs as $obj) {
                        if ($obj->isNew()) {
                            $collPdfs[] = $obj;
                        }
                    }
                }

                $this->collPdfs = $collPdfs;
                $this->collPdfsPartial = false;
            }
        }

        return $this->collPdfs;
    }

    /**
     * Sets a collection of ChildPdf objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $pdfs A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function setPdfs(Collection $pdfs, ConnectionInterface $con = null)
    {
        /** @var ChildPdf[] $pdfsToDelete */
        $pdfsToDelete = $this->getPdfs(new Criteria(), $con)->diff($pdfs);


        $this->pdfsScheduledForDeletion = $pdfsToDelete;

        foreach ($pdfsToDelete as $pdfRemoved) {
            $pdfRemoved->setPlugins(null);
        }

        $this->collPdfs = null;
        foreach ($pdfs as $pdf) {
            $this->addPdf($pdf);
        }

        $this->collPdfs = $pdfs;
        $this->collPdfsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Pdf objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Pdf objects.
     * @throws PropelException
     */
    public function countPdfs(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPdfsPartial && !$this->isNew();
        if (null === $this->collPdfs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPdfs) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPdfs());
            }

            $query = ChildPdfQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPlugins($this)
                ->count($con);
        }

        return count($this->collPdfs);
    }

    /**
     * Method called to associate a ChildPdf object to this object
     * through the ChildPdf foreign key attribute.
     *
     * @param  ChildPdf $l ChildPdf
     * @return $this|\Plugins The current object (for fluent API support)
     */
    public function addPdf(ChildPdf $l)
    {
        if ($this->collPdfs === null) {
            $this->initPdfs();
            $this->collPdfsPartial = true;
        }

        if (!$this->collPdfs->contains($l)) {
            $this->doAddPdf($l);

            if ($this->pdfsScheduledForDeletion and $this->pdfsScheduledForDeletion->contains($l)) {
                $this->pdfsScheduledForDeletion->remove($this->pdfsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPdf $pdf The ChildPdf object to add.
     */
    protected function doAddPdf(ChildPdf $pdf)
    {
        $this->collPdfs[]= $pdf;
        $pdf->setPlugins($this);
    }

    /**
     * @param  ChildPdf $pdf The ChildPdf object to remove.
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function removePdf(ChildPdf $pdf)
    {
        if ($this->getPdfs()->contains($pdf)) {
            $pos = $this->collPdfs->search($pdf);
            $this->collPdfs->remove($pos);
            if (null === $this->pdfsScheduledForDeletion) {
                $this->pdfsScheduledForDeletion = clone $this->collPdfs;
                $this->pdfsScheduledForDeletion->clear();
            }
            $this->pdfsScheduledForDeletion[]= $pdf;
            $pdf->setPlugins(null);
        }

        return $this;
    }

    /**
     * Clears out the collRBooks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRBooks()
     */
    public function clearRBooks()
    {
        $this->collRBooks = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collRBooks crossRef collection.
     *
     * By default this just sets the collRBooks collection to an empty collection (like clearRBooks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initRBooks()
    {
        $collectionClassName = RPluginBookTableMap::getTableMap()->getCollectionClassName();

        $this->collRBooks = new $collectionClassName;
        $this->collRBooksPartial = true;
        $this->collRBooks->setModel('\Books');
    }

    /**
     * Checks if the collRBooks collection is loaded.
     *
     * @return bool
     */
    public function isRBooksLoaded()
    {
        return null !== $this->collRBooks;
    }

    /**
     * Gets a collection of ChildBooks objects related by a many-to-many relationship
     * to the current object by way of the R_plugin_book cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlugins is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildBooks[] List of ChildBooks objects
     */
    public function getRBooks(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRBooksPartial && !$this->isNew();
        if (null === $this->collRBooks || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collRBooks) {
                    $this->initRBooks();
                }
            } else {

                $query = ChildBooksQuery::create(null, $criteria)
                    ->filterByRPlugin($this);
                $collRBooks = $query->find($con);
                if (null !== $criteria) {
                    return $collRBooks;
                }

                if ($partial && $this->collRBooks) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collRBooks as $obj) {
                        if (!$collRBooks->contains($obj)) {
                            $collRBooks[] = $obj;
                        }
                    }
                }

                $this->collRBooks = $collRBooks;
                $this->collRBooksPartial = false;
            }
        }

        return $this->collRBooks;
    }

    /**
     * Sets a collection of Books objects related by a many-to-many relationship
     * to the current object by way of the R_plugin_book cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $rBooks A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function setRBooks(Collection $rBooks, ConnectionInterface $con = null)
    {
        $this->clearRBooks();
        $currentRBooks = $this->getRBooks();

        $rBooksScheduledForDeletion = $currentRBooks->diff($rBooks);

        foreach ($rBooksScheduledForDeletion as $toDelete) {
            $this->removeRBook($toDelete);
        }

        foreach ($rBooks as $rBook) {
            if (!$currentRBooks->contains($rBook)) {
                $this->doAddRBook($rBook);
            }
        }

        $this->collRBooksPartial = false;
        $this->collRBooks = $rBooks;

        return $this;
    }

    /**
     * Gets the number of Books objects related by a many-to-many relationship
     * to the current object by way of the R_plugin_book cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Books objects
     */
    public function countRBooks(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRBooksPartial && !$this->isNew();
        if (null === $this->collRBooks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRBooks) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getRBooks());
                }

                $query = ChildBooksQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByRPlugin($this)
                    ->count($con);
            }
        } else {
            return count($this->collRBooks);
        }
    }

    /**
     * Associate a ChildBooks to this object
     * through the R_plugin_book cross reference table.
     *
     * @param ChildBooks $rBook
     * @return ChildPlugins The current object (for fluent API support)
     */
    public function addRBook(ChildBooks $rBook)
    {
        if ($this->collRBooks === null) {
            $this->initRBooks();
        }

        if (!$this->getRBooks()->contains($rBook)) {
            // only add it if the **same** object is not already associated
            $this->collRBooks->push($rBook);
            $this->doAddRBook($rBook);
        }

        return $this;
    }

    /**
     *
     * @param ChildBooks $rBook
     */
    protected function doAddRBook(ChildBooks $rBook)
    {
        $rPluginBook = new ChildRPluginBook();

        $rPluginBook->setRBook($rBook);

        $rPluginBook->setRPlugin($this);

        $this->addRPluginBook($rPluginBook);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$rBook->isRPluginsLoaded()) {
            $rBook->initRPlugins();
            $rBook->getRPlugins()->push($this);
        } elseif (!$rBook->getRPlugins()->contains($this)) {
            $rBook->getRPlugins()->push($this);
        }

    }

    /**
     * Remove rBook of this object
     * through the R_plugin_book cross reference table.
     *
     * @param ChildBooks $rBook
     * @return ChildPlugins The current object (for fluent API support)
     */
    public function removeRBook(ChildBooks $rBook)
    {
        if ($this->getRBooks()->contains($rBook)) {
            $rPluginBook = new ChildRPluginBook();
            $rPluginBook->setRBook($rBook);
            if ($rBook->isRPluginsLoaded()) {
                //remove the back reference if available
                $rBook->getRPlugins()->removeObject($this);
            }

            $rPluginBook->setRPlugin($this);
            $this->removeRPluginBook(clone $rPluginBook);
            $rPluginBook->clear();

            $this->collRBooks->remove($this->collRBooks->search($rBook));

            if (null === $this->rBooksScheduledForDeletion) {
                $this->rBooksScheduledForDeletion = clone $this->collRBooks;
                $this->rBooksScheduledForDeletion->clear();
            }

            $this->rBooksScheduledForDeletion->push($rBook);
        }


        return $this;
    }

    /**
     * Clears out the collRFormats collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRFormats()
     */
    public function clearRFormats()
    {
        $this->collRFormats = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collRFormats crossRef collection.
     *
     * By default this just sets the collRFormats collection to an empty collection (like clearRFormats());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initRFormats()
    {
        $collectionClassName = RPluginFormatTableMap::getTableMap()->getCollectionClassName();

        $this->collRFormats = new $collectionClassName;
        $this->collRFormatsPartial = true;
        $this->collRFormats->setModel('\Formats');
    }

    /**
     * Checks if the collRFormats collection is loaded.
     *
     * @return bool
     */
    public function isRFormatsLoaded()
    {
        return null !== $this->collRFormats;
    }

    /**
     * Gets a collection of ChildFormats objects related by a many-to-many relationship
     * to the current object by way of the R_plugin_format cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlugins is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildFormats[] List of ChildFormats objects
     */
    public function getRFormats(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRFormatsPartial && !$this->isNew();
        if (null === $this->collRFormats || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collRFormats) {
                    $this->initRFormats();
                }
            } else {

                $query = ChildFormatsQuery::create(null, $criteria)
                    ->filterByRPlugin($this);
                $collRFormats = $query->find($con);
                if (null !== $criteria) {
                    return $collRFormats;
                }

                if ($partial && $this->collRFormats) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collRFormats as $obj) {
                        if (!$collRFormats->contains($obj)) {
                            $collRFormats[] = $obj;
                        }
                    }
                }

                $this->collRFormats = $collRFormats;
                $this->collRFormatsPartial = false;
            }
        }

        return $this->collRFormats;
    }

    /**
     * Sets a collection of Formats objects related by a many-to-many relationship
     * to the current object by way of the R_plugin_format cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $rFormats A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function setRFormats(Collection $rFormats, ConnectionInterface $con = null)
    {
        $this->clearRFormats();
        $currentRFormats = $this->getRFormats();

        $rFormatsScheduledForDeletion = $currentRFormats->diff($rFormats);

        foreach ($rFormatsScheduledForDeletion as $toDelete) {
            $this->removeRFormat($toDelete);
        }

        foreach ($rFormats as $rFormat) {
            if (!$currentRFormats->contains($rFormat)) {
                $this->doAddRFormat($rFormat);
            }
        }

        $this->collRFormatsPartial = false;
        $this->collRFormats = $rFormats;

        return $this;
    }

    /**
     * Gets the number of Formats objects related by a many-to-many relationship
     * to the current object by way of the R_plugin_format cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Formats objects
     */
    public function countRFormats(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRFormatsPartial && !$this->isNew();
        if (null === $this->collRFormats || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRFormats) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getRFormats());
                }

                $query = ChildFormatsQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByRPlugin($this)
                    ->count($con);
            }
        } else {
            return count($this->collRFormats);
        }
    }

    /**
     * Associate a ChildFormats to this object
     * through the R_plugin_format cross reference table.
     *
     * @param ChildFormats $rFormat
     * @return ChildPlugins The current object (for fluent API support)
     */
    public function addRFormat(ChildFormats $rFormat)
    {
        if ($this->collRFormats === null) {
            $this->initRFormats();
        }

        if (!$this->getRFormats()->contains($rFormat)) {
            // only add it if the **same** object is not already associated
            $this->collRFormats->push($rFormat);
            $this->doAddRFormat($rFormat);
        }

        return $this;
    }

    /**
     *
     * @param ChildFormats $rFormat
     */
    protected function doAddRFormat(ChildFormats $rFormat)
    {
        $rPluginFormat = new ChildRPluginFormat();

        $rPluginFormat->setRFormat($rFormat);

        $rPluginFormat->setRPlugin($this);

        $this->addRPluginFormat($rPluginFormat);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$rFormat->isRPluginsLoaded()) {
            $rFormat->initRPlugins();
            $rFormat->getRPlugins()->push($this);
        } elseif (!$rFormat->getRPlugins()->contains($this)) {
            $rFormat->getRPlugins()->push($this);
        }

    }

    /**
     * Remove rFormat of this object
     * through the R_plugin_format cross reference table.
     *
     * @param ChildFormats $rFormat
     * @return ChildPlugins The current object (for fluent API support)
     */
    public function removeRFormat(ChildFormats $rFormat)
    {
        if ($this->getRFormats()->contains($rFormat)) {
            $rPluginFormat = new ChildRPluginFormat();
            $rPluginFormat->setRFormat($rFormat);
            if ($rFormat->isRPluginsLoaded()) {
                //remove the back reference if available
                $rFormat->getRPlugins()->removeObject($this);
            }

            $rPluginFormat->setRPlugin($this);
            $this->removeRPluginFormat(clone $rPluginFormat);
            $rPluginFormat->clear();

            $this->collRFormats->remove($this->collRFormats->search($rFormat));

            if (null === $this->rFormatsScheduledForDeletion) {
                $this->rFormatsScheduledForDeletion = clone $this->collRFormats;
                $this->rFormatsScheduledForDeletion->clear();
            }

            $this->rFormatsScheduledForDeletion->push($rFormat);
        }


        return $this;
    }

    /**
     * Clears out the collRIssues collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRIssues()
     */
    public function clearRIssues()
    {
        $this->collRIssues = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collRIssues crossRef collection.
     *
     * By default this just sets the collRIssues collection to an empty collection (like clearRIssues());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initRIssues()
    {
        $collectionClassName = RPluginIssueTableMap::getTableMap()->getCollectionClassName();

        $this->collRIssues = new $collectionClassName;
        $this->collRIssuesPartial = true;
        $this->collRIssues->setModel('\Issues');
    }

    /**
     * Checks if the collRIssues collection is loaded.
     *
     * @return bool
     */
    public function isRIssuesLoaded()
    {
        return null !== $this->collRIssues;
    }

    /**
     * Gets a collection of ChildIssues objects related by a many-to-many relationship
     * to the current object by way of the R_plugin_issue cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlugins is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildIssues[] List of ChildIssues objects
     */
    public function getRIssues(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRIssuesPartial && !$this->isNew();
        if (null === $this->collRIssues || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collRIssues) {
                    $this->initRIssues();
                }
            } else {

                $query = ChildIssuesQuery::create(null, $criteria)
                    ->filterByRPlugin($this);
                $collRIssues = $query->find($con);
                if (null !== $criteria) {
                    return $collRIssues;
                }

                if ($partial && $this->collRIssues) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collRIssues as $obj) {
                        if (!$collRIssues->contains($obj)) {
                            $collRIssues[] = $obj;
                        }
                    }
                }

                $this->collRIssues = $collRIssues;
                $this->collRIssuesPartial = false;
            }
        }

        return $this->collRIssues;
    }

    /**
     * Sets a collection of Issues objects related by a many-to-many relationship
     * to the current object by way of the R_plugin_issue cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $rIssues A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildPlugins The current object (for fluent API support)
     */
    public function setRIssues(Collection $rIssues, ConnectionInterface $con = null)
    {
        $this->clearRIssues();
        $currentRIssues = $this->getRIssues();

        $rIssuesScheduledForDeletion = $currentRIssues->diff($rIssues);

        foreach ($rIssuesScheduledForDeletion as $toDelete) {
            $this->removeRIssue($toDelete);
        }

        foreach ($rIssues as $rIssue) {
            if (!$currentRIssues->contains($rIssue)) {
                $this->doAddRIssue($rIssue);
            }
        }

        $this->collRIssuesPartial = false;
        $this->collRIssues = $rIssues;

        return $this;
    }

    /**
     * Gets the number of Issues objects related by a many-to-many relationship
     * to the current object by way of the R_plugin_issue cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Issues objects
     */
    public function countRIssues(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRIssuesPartial && !$this->isNew();
        if (null === $this->collRIssues || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRIssues) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getRIssues());
                }

                $query = ChildIssuesQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByRPlugin($this)
                    ->count($con);
            }
        } else {
            return count($this->collRIssues);
        }
    }

    /**
     * Associate a ChildIssues to this object
     * through the R_plugin_issue cross reference table.
     *
     * @param ChildIssues $rIssue
     * @return ChildPlugins The current object (for fluent API support)
     */
    public function addRIssue(ChildIssues $rIssue)
    {
        if ($this->collRIssues === null) {
            $this->initRIssues();
        }

        if (!$this->getRIssues()->contains($rIssue)) {
            // only add it if the **same** object is not already associated
            $this->collRIssues->push($rIssue);
            $this->doAddRIssue($rIssue);
        }

        return $this;
    }

    /**
     *
     * @param ChildIssues $rIssue
     */
    protected function doAddRIssue(ChildIssues $rIssue)
    {
        $rPluginIssue = new ChildRPluginIssue();

        $rPluginIssue->setRIssue($rIssue);

        $rPluginIssue->setRPlugin($this);

        $this->addRPluginIssue($rPluginIssue);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$rIssue->isRPluginsLoaded()) {
            $rIssue->initRPlugins();
            $rIssue->getRPlugins()->push($this);
        } elseif (!$rIssue->getRPlugins()->contains($this)) {
            $rIssue->getRPlugins()->push($this);
        }

    }

    /**
     * Remove rIssue of this object
     * through the R_plugin_issue cross reference table.
     *
     * @param ChildIssues $rIssue
     * @return ChildPlugins The current object (for fluent API support)
     */
    public function removeRIssue(ChildIssues $rIssue)
    {
        if ($this->getRIssues()->contains($rIssue)) {
            $rPluginIssue = new ChildRPluginIssue();
            $rPluginIssue->setRIssue($rIssue);
            if ($rIssue->isRPluginsLoaded()) {
                //remove the back reference if available
                $rIssue->getRPlugins()->removeObject($this);
            }

            $rPluginIssue->setRPlugin($this);
            $this->removeRPluginIssue(clone $rPluginIssue);
            $rPluginIssue->clear();

            $this->collRIssues->remove($this->collRIssues->search($rIssue));

            if (null === $this->rIssuesScheduledForDeletion) {
                $this->rIssuesScheduledForDeletion = clone $this->collRIssues;
                $this->rIssuesScheduledForDeletion->clear();
            }

            $this->rIssuesScheduledForDeletion->push($rIssue);
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
        $collectionClassName = RPluginTemplateTableMap::getTableMap()->getCollectionClassName();

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
     * to the current object by way of the R_plugin_template cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPlugins is new, it will return
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
                    ->filterByRPlugin($this);
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
     * to the current object by way of the R_plugin_template cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $templatenamess A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildPlugins The current object (for fluent API support)
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
     * to the current object by way of the R_plugin_template cross-reference table.
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
                    ->filterByRPlugin($this)
                    ->count($con);
            }
        } else {
            return count($this->collTemplatenamess);
        }
    }

    /**
     * Associate a ChildTemplatenames to this object
     * through the R_plugin_template cross reference table.
     *
     * @param ChildTemplatenames $templatenames
     * @return ChildPlugins The current object (for fluent API support)
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
        $rPluginTemplate = new ChildRPluginTemplate();

        $rPluginTemplate->setTemplatenames($templatenames);

        $rPluginTemplate->setRPlugin($this);

        $this->addRPluginTemplate($rPluginTemplate);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$templatenames->isRPluginsLoaded()) {
            $templatenames->initRPlugins();
            $templatenames->getRPlugins()->push($this);
        } elseif (!$templatenames->getRPlugins()->contains($this)) {
            $templatenames->getRPlugins()->push($this);
        }

    }

    /**
     * Remove templatenames of this object
     * through the R_plugin_template cross reference table.
     *
     * @param ChildTemplatenames $templatenames
     * @return ChildPlugins The current object (for fluent API support)
     */
    public function removeTemplatenames(ChildTemplatenames $templatenames)
    {
        if ($this->getTemplatenamess()->contains($templatenames)) {
            $rPluginTemplate = new ChildRPluginTemplate();
            $rPluginTemplate->setTemplatenames($templatenames);
            if ($templatenames->isRPluginsLoaded()) {
                //remove the back reference if available
                $templatenames->getRPlugins()->removeObject($this);
            }

            $rPluginTemplate->setRPlugin($this);
            $this->removeRPluginTemplate(clone $rPluginTemplate);
            $rPluginTemplate->clear();

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
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->_name = null;
        $this->_api = null;
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
            if ($this->collRPluginBooks) {
                foreach ($this->collRPluginBooks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRPluginFormats) {
                foreach ($this->collRPluginFormats as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRPluginIssues) {
                foreach ($this->collRPluginIssues as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRPluginTemplates) {
                foreach ($this->collRPluginTemplates as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPdfs) {
                foreach ($this->collPdfs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRBooks) {
                foreach ($this->collRBooks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRFormats) {
                foreach ($this->collRFormats as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRIssues) {
                foreach ($this->collRIssues as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTemplatenamess) {
                foreach ($this->collTemplatenamess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collRPluginBooks = null;
        $this->collRPluginFormats = null;
        $this->collRPluginIssues = null;
        $this->collRPluginTemplates = null;
        $this->collPdfs = null;
        $this->collRBooks = null;
        $this->collRFormats = null;
        $this->collRIssues = null;
        $this->collTemplatenamess = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PluginsTableMap::DEFAULT_STRING_FORMAT);
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
