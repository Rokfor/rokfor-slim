<?php

namespace Base;

use \Books as ChildBooks;
use \BooksQuery as ChildBooksQuery;
use \Contributions as ChildContributions;
use \ContributionsQuery as ChildContributionsQuery;
use \Formats as ChildFormats;
use \FormatsQuery as ChildFormatsQuery;
use \Plugins as ChildPlugins;
use \PluginsQuery as ChildPluginsQuery;
use \RPluginTemplate as ChildRPluginTemplate;
use \RPluginTemplateQuery as ChildRPluginTemplateQuery;
use \RRightsFortemplate as ChildRRightsFortemplate;
use \RRightsFortemplateQuery as ChildRRightsFortemplateQuery;
use \RTemplatenamesForbook as ChildRTemplatenamesForbook;
use \RTemplatenamesForbookQuery as ChildRTemplatenamesForbookQuery;
use \RTemplatenamesInchapter as ChildRTemplatenamesInchapter;
use \RTemplatenamesInchapterQuery as ChildRTemplatenamesInchapterQuery;
use \Rights as ChildRights;
use \RightsQuery as ChildRightsQuery;
use \Templatenames as ChildTemplatenames;
use \TemplatenamesQuery as ChildTemplatenamesQuery;
use \Templates as ChildTemplates;
use \TemplatesQuery as ChildTemplatesQuery;
use \Exception;
use \PDO;
use Map\ContributionsTableMap;
use Map\RPluginTemplateTableMap;
use Map\RRightsFortemplateTableMap;
use Map\RTemplatenamesForbookTableMap;
use Map\RTemplatenamesInchapterTableMap;
use Map\TemplatenamesTableMap;
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
 * Base class that represents a row from the '_templatenames' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Templatenames implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\TemplatenamesTableMap';


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
     * The value for the _helptext field.
     *
     * @var        string
     */
    protected $_helptext;

    /**
     * The value for the _helpimage field.
     *
     * @var        string
     */
    protected $_helpimage;

    /**
     * The value for the _category field.
     *
     * @var        string
     */
    protected $_category;

    /**
     * The value for the _public field.
     *
     * @var        string
     */
    protected $_public;

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
     * The value for the __sort__ field.
     *
     * @var        int
     */
    protected $__sort__;

    /**
     * The value for the __parentnode__ field.
     *
     * @var        int
     */
    protected $__parentnode__;

    /**
     * @var        ObjectCollection|ChildRRightsFortemplate[] Collection to store aggregation of ChildRRightsFortemplate objects.
     */
    protected $collRRightsFortemplates;
    protected $collRRightsFortemplatesPartial;

    /**
     * @var        ObjectCollection|ChildRTemplatenamesForbook[] Collection to store aggregation of ChildRTemplatenamesForbook objects.
     */
    protected $collRTemplatenamesForbooks;
    protected $collRTemplatenamesForbooksPartial;

    /**
     * @var        ObjectCollection|ChildRTemplatenamesInchapter[] Collection to store aggregation of ChildRTemplatenamesInchapter objects.
     */
    protected $collRTemplatenamesInchapters;
    protected $collRTemplatenamesInchaptersPartial;

    /**
     * @var        ObjectCollection|ChildContributions[] Collection to store aggregation of ChildContributions objects.
     */
    protected $collContributionss;
    protected $collContributionssPartial;

    /**
     * @var        ObjectCollection|ChildRPluginTemplate[] Collection to store aggregation of ChildRPluginTemplate objects.
     */
    protected $collRPluginTemplates;
    protected $collRPluginTemplatesPartial;

    /**
     * @var        ObjectCollection|ChildTemplates[] Collection to store aggregation of ChildTemplates objects.
     */
    protected $collTemplatess;
    protected $collTemplatessPartial;

    /**
     * @var        ObjectCollection|ChildRights[] Cross Collection to store aggregation of ChildRights objects.
     */
    protected $collRightss;

    /**
     * @var bool
     */
    protected $collRightssPartial;

    /**
     * @var        ObjectCollection|ChildBooks[] Cross Collection to store aggregation of ChildBooks objects.
     */
    protected $collBookss;

    /**
     * @var bool
     */
    protected $collBookssPartial;

    /**
     * @var        ObjectCollection|ChildFormats[] Cross Collection to store aggregation of ChildFormats objects.
     */
    protected $collFormatss;

    /**
     * @var bool
     */
    protected $collFormatssPartial;

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
     * @var ObjectCollection|ChildRights[]
     */
    protected $rightssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildBooks[]
     */
    protected $bookssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildFormats[]
     */
    protected $formatssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPlugins[]
     */
    protected $rPluginsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRRightsFortemplate[]
     */
    protected $rRightsFortemplatesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRTemplatenamesForbook[]
     */
    protected $rTemplatenamesForbooksScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRTemplatenamesInchapter[]
     */
    protected $rTemplatenamesInchaptersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildContributions[]
     */
    protected $contributionssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRPluginTemplate[]
     */
    protected $rPluginTemplatesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTemplates[]
     */
    protected $templatessScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Templatenames object.
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
     * Compares this with another <code>Templatenames</code> instance.  If
     * <code>obj</code> is an instance of <code>Templatenames</code>, delegates to
     * <code>equals(Templatenames)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Templatenames The current object, for fluid interface
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
     * Get the [_helptext] column value.
     *
     * @return string
     */
    public function getHelptext()
    {
        return $this->_helptext;
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
     * Get the [_category] column value.
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->_category;
    }

    /**
     * Get the [_public] column value.
     *
     * @return string
     */
    public function getPublic()
    {
        return $this->_public;
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
     * Get the [__sort__] column value.
     *
     * @return int
     */
    public function getSort()
    {
        return $this->__sort__;
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
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Templatenames The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[TemplatenamesTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [_name] column.
     *
     * @param string $v new value
     * @return $this|\Templatenames The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_name !== $v) {
            $this->_name = $v;
            $this->modifiedColumns[TemplatenamesTableMap::COL__NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [_helptext] column.
     *
     * @param string $v new value
     * @return $this|\Templatenames The current object (for fluent API support)
     */
    public function setHelptext($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_helptext !== $v) {
            $this->_helptext = $v;
            $this->modifiedColumns[TemplatenamesTableMap::COL__HELPTEXT] = true;
        }

        return $this;
    } // setHelptext()

    /**
     * Set the value of [_helpimage] column.
     *
     * @param string $v new value
     * @return $this|\Templatenames The current object (for fluent API support)
     */
    public function setHelpimage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_helpimage !== $v) {
            $this->_helpimage = $v;
            $this->modifiedColumns[TemplatenamesTableMap::COL__HELPIMAGE] = true;
        }

        return $this;
    } // setHelpimage()

    /**
     * Set the value of [_category] column.
     *
     * @param string $v new value
     * @return $this|\Templatenames The current object (for fluent API support)
     */
    public function setCategory($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_category !== $v) {
            $this->_category = $v;
            $this->modifiedColumns[TemplatenamesTableMap::COL__CATEGORY] = true;
        }

        return $this;
    } // setCategory()

    /**
     * Set the value of [_public] column.
     *
     * @param string $v new value
     * @return $this|\Templatenames The current object (for fluent API support)
     */
    public function setPublic($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_public !== $v) {
            $this->_public = $v;
            $this->modifiedColumns[TemplatenamesTableMap::COL__PUBLIC] = true;
        }

        return $this;
    } // setPublic()

    /**
     * Set the value of [__config__] column.
     *
     * @param string $v new value
     * @return $this|\Templatenames The current object (for fluent API support)
     */
    public function setConfigSys($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->__config__ !== $v) {
            $this->__config__ = $v;
            $this->modifiedColumns[TemplatenamesTableMap::COL___CONFIG__] = true;
        }

        return $this;
    } // setConfigSys()

    /**
     * Set the value of [__split__] column.
     *
     * @param string $v new value
     * @return $this|\Templatenames The current object (for fluent API support)
     */
    public function setSplit($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->__split__ !== $v) {
            $this->__split__ = $v;
            $this->modifiedColumns[TemplatenamesTableMap::COL___SPLIT__] = true;
        }

        return $this;
    } // setSplit()

    /**
     * Set the value of [__sort__] column.
     *
     * @param int $v new value
     * @return $this|\Templatenames The current object (for fluent API support)
     */
    public function setSort($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__sort__ !== $v) {
            $this->__sort__ = $v;
            $this->modifiedColumns[TemplatenamesTableMap::COL___SORT__] = true;
        }

        return $this;
    } // setSort()

    /**
     * Set the value of [__parentnode__] column.
     *
     * @param int $v new value
     * @return $this|\Templatenames The current object (for fluent API support)
     */
    public function setParentnode($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__parentnode__ !== $v) {
            $this->__parentnode__ = $v;
            $this->modifiedColumns[TemplatenamesTableMap::COL___PARENTNODE__] = true;
        }

        return $this;
    } // setParentnode()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : TemplatenamesTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : TemplatenamesTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : TemplatenamesTableMap::translateFieldName('Helptext', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_helptext = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : TemplatenamesTableMap::translateFieldName('Helpimage', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_helpimage = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : TemplatenamesTableMap::translateFieldName('Category', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_category = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : TemplatenamesTableMap::translateFieldName('Public', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_public = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : TemplatenamesTableMap::translateFieldName('ConfigSys', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__config__ = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : TemplatenamesTableMap::translateFieldName('Split', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__split__ = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : TemplatenamesTableMap::translateFieldName('Sort', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__sort__ = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : TemplatenamesTableMap::translateFieldName('Parentnode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__parentnode__ = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = TemplatenamesTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Templatenames'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(TemplatenamesTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildTemplatenamesQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collRRightsFortemplates = null;

            $this->collRTemplatenamesForbooks = null;

            $this->collRTemplatenamesInchapters = null;

            $this->collContributionss = null;

            $this->collRPluginTemplates = null;

            $this->collTemplatess = null;

            $this->collRightss = null;
            $this->collBookss = null;
            $this->collFormatss = null;
            $this->collRPlugins = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Templatenames::setDeleted()
     * @see Templatenames::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TemplatenamesTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildTemplatenamesQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(TemplatenamesTableMap::DATABASE_NAME);
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
                TemplatenamesTableMap::addInstanceToPool($this);
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

            if ($this->rightssScheduledForDeletion !== null) {
                if (!$this->rightssScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->rightssScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RRightsFortemplateQuery::create()
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


            if ($this->bookssScheduledForDeletion !== null) {
                if (!$this->bookssScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->bookssScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RTemplatenamesForbookQuery::create()
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


            if ($this->formatssScheduledForDeletion !== null) {
                if (!$this->formatssScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->formatssScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RTemplatenamesInchapterQuery::create()
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


            if ($this->rPluginsScheduledForDeletion !== null) {
                if (!$this->rPluginsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->rPluginsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RPluginTemplateQuery::create()
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

            if ($this->rTemplatenamesInchaptersScheduledForDeletion !== null) {
                if (!$this->rTemplatenamesInchaptersScheduledForDeletion->isEmpty()) {
                    \RTemplatenamesInchapterQuery::create()
                        ->filterByPrimaryKeys($this->rTemplatenamesInchaptersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rTemplatenamesInchaptersScheduledForDeletion = null;
                }
            }

            if ($this->collRTemplatenamesInchapters !== null) {
                foreach ($this->collRTemplatenamesInchapters as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->contributionssScheduledForDeletion !== null) {
                if (!$this->contributionssScheduledForDeletion->isEmpty()) {
                    \ContributionsQuery::create()
                        ->filterByPrimaryKeys($this->contributionssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->contributionssScheduledForDeletion = null;
                }
            }

            if ($this->collContributionss !== null) {
                foreach ($this->collContributionss as $referrerFK) {
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

            if ($this->templatessScheduledForDeletion !== null) {
                if (!$this->templatessScheduledForDeletion->isEmpty()) {
                    \TemplatesQuery::create()
                        ->filterByPrimaryKeys($this->templatessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->templatessScheduledForDeletion = null;
                }
            }

            if ($this->collTemplatess !== null) {
                foreach ($this->collTemplatess as $referrerFK) {
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

        $this->modifiedColumns[TemplatenamesTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TemplatenamesTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TemplatenamesTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(TemplatenamesTableMap::COL__NAME)) {
            $modifiedColumns[':p' . $index++]  = '_name';
        }
        if ($this->isColumnModified(TemplatenamesTableMap::COL__HELPTEXT)) {
            $modifiedColumns[':p' . $index++]  = '_helptext';
        }
        if ($this->isColumnModified(TemplatenamesTableMap::COL__HELPIMAGE)) {
            $modifiedColumns[':p' . $index++]  = '_helpimage';
        }
        if ($this->isColumnModified(TemplatenamesTableMap::COL__CATEGORY)) {
            $modifiedColumns[':p' . $index++]  = '_category';
        }
        if ($this->isColumnModified(TemplatenamesTableMap::COL__PUBLIC)) {
            $modifiedColumns[':p' . $index++]  = '_public';
        }
        if ($this->isColumnModified(TemplatenamesTableMap::COL___CONFIG__)) {
            $modifiedColumns[':p' . $index++]  = '__config__';
        }
        if ($this->isColumnModified(TemplatenamesTableMap::COL___SPLIT__)) {
            $modifiedColumns[':p' . $index++]  = '__split__';
        }
        if ($this->isColumnModified(TemplatenamesTableMap::COL___SORT__)) {
            $modifiedColumns[':p' . $index++]  = '__sort__';
        }
        if ($this->isColumnModified(TemplatenamesTableMap::COL___PARENTNODE__)) {
            $modifiedColumns[':p' . $index++]  = '__parentnode__';
        }

        $sql = sprintf(
            'INSERT INTO _templatenames (%s) VALUES (%s)',
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
                    case '_helptext':
                        $stmt->bindValue($identifier, $this->_helptext, PDO::PARAM_STR);
                        break;
                    case '_helpimage':
                        $stmt->bindValue($identifier, $this->_helpimage, PDO::PARAM_STR);
                        break;
                    case '_category':
                        $stmt->bindValue($identifier, $this->_category, PDO::PARAM_STR);
                        break;
                    case '_public':
                        $stmt->bindValue($identifier, $this->_public, PDO::PARAM_STR);
                        break;
                    case '__config__':
                        $stmt->bindValue($identifier, $this->__config__, PDO::PARAM_STR);
                        break;
                    case '__split__':
                        $stmt->bindValue($identifier, $this->__split__, PDO::PARAM_STR);
                        break;
                    case '__sort__':
                        $stmt->bindValue($identifier, $this->__sort__, PDO::PARAM_INT);
                        break;
                    case '__parentnode__':
                        $stmt->bindValue($identifier, $this->__parentnode__, PDO::PARAM_INT);
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
        $pos = TemplatenamesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getHelptext();
                break;
            case 3:
                return $this->getHelpimage();
                break;
            case 4:
                return $this->getCategory();
                break;
            case 5:
                return $this->getPublic();
                break;
            case 6:
                return $this->getConfigSys();
                break;
            case 7:
                return $this->getSplit();
                break;
            case 8:
                return $this->getSort();
                break;
            case 9:
                return $this->getParentnode();
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

        if (isset($alreadyDumpedObjects['Templatenames'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Templatenames'][$this->hashCode()] = true;
        $keys = TemplatenamesTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getHelptext(),
            $keys[3] => $this->getHelpimage(),
            $keys[4] => $this->getCategory(),
            $keys[5] => $this->getPublic(),
            $keys[6] => $this->getConfigSys(),
            $keys[7] => $this->getSplit(),
            $keys[8] => $this->getSort(),
            $keys[9] => $this->getParentnode(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
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
            if (null !== $this->collRTemplatenamesInchapters) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rTemplatenamesInchapters';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_templatenames_inchapters';
                        break;
                    default:
                        $key = 'RTemplatenamesInchapters';
                }

                $result[$key] = $this->collRTemplatenamesInchapters->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collContributionss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'contributionss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = '_contributionss';
                        break;
                    default:
                        $key = 'Contributionss';
                }

                $result[$key] = $this->collContributionss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
            if (null !== $this->collTemplatess) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'templatess';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = '_templatess';
                        break;
                    default:
                        $key = 'Templatess';
                }

                $result[$key] = $this->collTemplatess->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Templatenames
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TemplatenamesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Templatenames
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
                $this->setHelptext($value);
                break;
            case 3:
                $this->setHelpimage($value);
                break;
            case 4:
                $this->setCategory($value);
                break;
            case 5:
                $this->setPublic($value);
                break;
            case 6:
                $this->setConfigSys($value);
                break;
            case 7:
                $this->setSplit($value);
                break;
            case 8:
                $this->setSort($value);
                break;
            case 9:
                $this->setParentnode($value);
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
        $keys = TemplatenamesTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setHelptext($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setHelpimage($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setCategory($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setPublic($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setConfigSys($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setSplit($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setSort($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setParentnode($arr[$keys[9]]);
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
     * @return $this|\Templatenames The current object, for fluid interface
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
        $criteria = new Criteria(TemplatenamesTableMap::DATABASE_NAME);

        if ($this->isColumnModified(TemplatenamesTableMap::COL_ID)) {
            $criteria->add(TemplatenamesTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(TemplatenamesTableMap::COL__NAME)) {
            $criteria->add(TemplatenamesTableMap::COL__NAME, $this->_name);
        }
        if ($this->isColumnModified(TemplatenamesTableMap::COL__HELPTEXT)) {
            $criteria->add(TemplatenamesTableMap::COL__HELPTEXT, $this->_helptext);
        }
        if ($this->isColumnModified(TemplatenamesTableMap::COL__HELPIMAGE)) {
            $criteria->add(TemplatenamesTableMap::COL__HELPIMAGE, $this->_helpimage);
        }
        if ($this->isColumnModified(TemplatenamesTableMap::COL__CATEGORY)) {
            $criteria->add(TemplatenamesTableMap::COL__CATEGORY, $this->_category);
        }
        if ($this->isColumnModified(TemplatenamesTableMap::COL__PUBLIC)) {
            $criteria->add(TemplatenamesTableMap::COL__PUBLIC, $this->_public);
        }
        if ($this->isColumnModified(TemplatenamesTableMap::COL___CONFIG__)) {
            $criteria->add(TemplatenamesTableMap::COL___CONFIG__, $this->__config__);
        }
        if ($this->isColumnModified(TemplatenamesTableMap::COL___SPLIT__)) {
            $criteria->add(TemplatenamesTableMap::COL___SPLIT__, $this->__split__);
        }
        if ($this->isColumnModified(TemplatenamesTableMap::COL___SORT__)) {
            $criteria->add(TemplatenamesTableMap::COL___SORT__, $this->__sort__);
        }
        if ($this->isColumnModified(TemplatenamesTableMap::COL___PARENTNODE__)) {
            $criteria->add(TemplatenamesTableMap::COL___PARENTNODE__, $this->__parentnode__);
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
        $criteria = ChildTemplatenamesQuery::create();
        $criteria->add(TemplatenamesTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Templatenames (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setHelptext($this->getHelptext());
        $copyObj->setHelpimage($this->getHelpimage());
        $copyObj->setCategory($this->getCategory());
        $copyObj->setPublic($this->getPublic());
        $copyObj->setConfigSys($this->getConfigSys());
        $copyObj->setSplit($this->getSplit());
        $copyObj->setSort($this->getSort());
        $copyObj->setParentnode($this->getParentnode());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getRRightsFortemplates() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRRightsFortemplate($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRTemplatenamesForbooks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRTemplatenamesForbook($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRTemplatenamesInchapters() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRTemplatenamesInchapter($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getContributionss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContributions($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRPluginTemplates() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRPluginTemplate($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTemplatess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTemplates($relObj->copy($deepCopy));
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
     * @return \Templatenames Clone of current object.
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
        if ('RRightsFortemplate' == $relationName) {
            $this->initRRightsFortemplates();
            return;
        }
        if ('RTemplatenamesForbook' == $relationName) {
            $this->initRTemplatenamesForbooks();
            return;
        }
        if ('RTemplatenamesInchapter' == $relationName) {
            $this->initRTemplatenamesInchapters();
            return;
        }
        if ('Contributions' == $relationName) {
            $this->initContributionss();
            return;
        }
        if ('RPluginTemplate' == $relationName) {
            $this->initRPluginTemplates();
            return;
        }
        if ('Templates' == $relationName) {
            $this->initTemplatess();
            return;
        }
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
     * If this ChildTemplatenames is new, it will return
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
                    ->filterByTemplatenames($this)
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
     * @return $this|ChildTemplatenames The current object (for fluent API support)
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
            $rRightsFortemplateRemoved->setTemplatenames(null);
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
                ->filterByTemplatenames($this)
                ->count($con);
        }

        return count($this->collRRightsFortemplates);
    }

    /**
     * Method called to associate a ChildRRightsFortemplate object to this object
     * through the ChildRRightsFortemplate foreign key attribute.
     *
     * @param  ChildRRightsFortemplate $l ChildRRightsFortemplate
     * @return $this|\Templatenames The current object (for fluent API support)
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
        $rRightsFortemplate->setTemplatenames($this);
    }

    /**
     * @param  ChildRRightsFortemplate $rRightsFortemplate The ChildRRightsFortemplate object to remove.
     * @return $this|ChildTemplatenames The current object (for fluent API support)
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
            $rRightsFortemplate->setTemplatenames(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Templatenames is new, it will return
     * an empty collection; or if this Templatenames has previously
     * been saved, it will retrieve related RRightsFortemplates from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Templatenames.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRRightsFortemplate[] List of ChildRRightsFortemplate objects
     */
    public function getRRightsFortemplatesJoinRights(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRRightsFortemplateQuery::create(null, $criteria);
        $query->joinWith('Rights', $joinBehavior);

        return $this->getRRightsFortemplates($query, $con);
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
     * If this ChildTemplatenames is new, it will return
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
                    ->filterByTemplatenames($this)
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
     * @return $this|ChildTemplatenames The current object (for fluent API support)
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
            $rTemplatenamesForbookRemoved->setTemplatenames(null);
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
                ->filterByTemplatenames($this)
                ->count($con);
        }

        return count($this->collRTemplatenamesForbooks);
    }

    /**
     * Method called to associate a ChildRTemplatenamesForbook object to this object
     * through the ChildRTemplatenamesForbook foreign key attribute.
     *
     * @param  ChildRTemplatenamesForbook $l ChildRTemplatenamesForbook
     * @return $this|\Templatenames The current object (for fluent API support)
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
        $rTemplatenamesForbook->setTemplatenames($this);
    }

    /**
     * @param  ChildRTemplatenamesForbook $rTemplatenamesForbook The ChildRTemplatenamesForbook object to remove.
     * @return $this|ChildTemplatenames The current object (for fluent API support)
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
            $rTemplatenamesForbook->setTemplatenames(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Templatenames is new, it will return
     * an empty collection; or if this Templatenames has previously
     * been saved, it will retrieve related RTemplatenamesForbooks from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Templatenames.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRTemplatenamesForbook[] List of ChildRTemplatenamesForbook objects
     */
    public function getRTemplatenamesForbooksJoinBooks(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRTemplatenamesForbookQuery::create(null, $criteria);
        $query->joinWith('Books', $joinBehavior);

        return $this->getRTemplatenamesForbooks($query, $con);
    }

    /**
     * Clears out the collRTemplatenamesInchapters collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRTemplatenamesInchapters()
     */
    public function clearRTemplatenamesInchapters()
    {
        $this->collRTemplatenamesInchapters = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRTemplatenamesInchapters collection loaded partially.
     */
    public function resetPartialRTemplatenamesInchapters($v = true)
    {
        $this->collRTemplatenamesInchaptersPartial = $v;
    }

    /**
     * Initializes the collRTemplatenamesInchapters collection.
     *
     * By default this just sets the collRTemplatenamesInchapters collection to an empty array (like clearcollRTemplatenamesInchapters());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRTemplatenamesInchapters($overrideExisting = true)
    {
        if (null !== $this->collRTemplatenamesInchapters && !$overrideExisting) {
            return;
        }

        $collectionClassName = RTemplatenamesInchapterTableMap::getTableMap()->getCollectionClassName();

        $this->collRTemplatenamesInchapters = new $collectionClassName;
        $this->collRTemplatenamesInchapters->setModel('\RTemplatenamesInchapter');
    }

    /**
     * Gets an array of ChildRTemplatenamesInchapter objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTemplatenames is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRTemplatenamesInchapter[] List of ChildRTemplatenamesInchapter objects
     * @throws PropelException
     */
    public function getRTemplatenamesInchapters(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRTemplatenamesInchaptersPartial && !$this->isNew();
        if (null === $this->collRTemplatenamesInchapters || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRTemplatenamesInchapters) {
                // return empty collection
                $this->initRTemplatenamesInchapters();
            } else {
                $collRTemplatenamesInchapters = ChildRTemplatenamesInchapterQuery::create(null, $criteria)
                    ->filterByTemplatenames($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRTemplatenamesInchaptersPartial && count($collRTemplatenamesInchapters)) {
                        $this->initRTemplatenamesInchapters(false);

                        foreach ($collRTemplatenamesInchapters as $obj) {
                            if (false == $this->collRTemplatenamesInchapters->contains($obj)) {
                                $this->collRTemplatenamesInchapters->append($obj);
                            }
                        }

                        $this->collRTemplatenamesInchaptersPartial = true;
                    }

                    return $collRTemplatenamesInchapters;
                }

                if ($partial && $this->collRTemplatenamesInchapters) {
                    foreach ($this->collRTemplatenamesInchapters as $obj) {
                        if ($obj->isNew()) {
                            $collRTemplatenamesInchapters[] = $obj;
                        }
                    }
                }

                $this->collRTemplatenamesInchapters = $collRTemplatenamesInchapters;
                $this->collRTemplatenamesInchaptersPartial = false;
            }
        }

        return $this->collRTemplatenamesInchapters;
    }

    /**
     * Sets a collection of ChildRTemplatenamesInchapter objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rTemplatenamesInchapters A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildTemplatenames The current object (for fluent API support)
     */
    public function setRTemplatenamesInchapters(Collection $rTemplatenamesInchapters, ConnectionInterface $con = null)
    {
        /** @var ChildRTemplatenamesInchapter[] $rTemplatenamesInchaptersToDelete */
        $rTemplatenamesInchaptersToDelete = $this->getRTemplatenamesInchapters(new Criteria(), $con)->diff($rTemplatenamesInchapters);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rTemplatenamesInchaptersScheduledForDeletion = clone $rTemplatenamesInchaptersToDelete;

        foreach ($rTemplatenamesInchaptersToDelete as $rTemplatenamesInchapterRemoved) {
            $rTemplatenamesInchapterRemoved->setTemplatenames(null);
        }

        $this->collRTemplatenamesInchapters = null;
        foreach ($rTemplatenamesInchapters as $rTemplatenamesInchapter) {
            $this->addRTemplatenamesInchapter($rTemplatenamesInchapter);
        }

        $this->collRTemplatenamesInchapters = $rTemplatenamesInchapters;
        $this->collRTemplatenamesInchaptersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RTemplatenamesInchapter objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RTemplatenamesInchapter objects.
     * @throws PropelException
     */
    public function countRTemplatenamesInchapters(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRTemplatenamesInchaptersPartial && !$this->isNew();
        if (null === $this->collRTemplatenamesInchapters || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRTemplatenamesInchapters) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRTemplatenamesInchapters());
            }

            $query = ChildRTemplatenamesInchapterQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTemplatenames($this)
                ->count($con);
        }

        return count($this->collRTemplatenamesInchapters);
    }

    /**
     * Method called to associate a ChildRTemplatenamesInchapter object to this object
     * through the ChildRTemplatenamesInchapter foreign key attribute.
     *
     * @param  ChildRTemplatenamesInchapter $l ChildRTemplatenamesInchapter
     * @return $this|\Templatenames The current object (for fluent API support)
     */
    public function addRTemplatenamesInchapter(ChildRTemplatenamesInchapter $l)
    {
        if ($this->collRTemplatenamesInchapters === null) {
            $this->initRTemplatenamesInchapters();
            $this->collRTemplatenamesInchaptersPartial = true;
        }

        if (!$this->collRTemplatenamesInchapters->contains($l)) {
            $this->doAddRTemplatenamesInchapter($l);

            if ($this->rTemplatenamesInchaptersScheduledForDeletion and $this->rTemplatenamesInchaptersScheduledForDeletion->contains($l)) {
                $this->rTemplatenamesInchaptersScheduledForDeletion->remove($this->rTemplatenamesInchaptersScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRTemplatenamesInchapter $rTemplatenamesInchapter The ChildRTemplatenamesInchapter object to add.
     */
    protected function doAddRTemplatenamesInchapter(ChildRTemplatenamesInchapter $rTemplatenamesInchapter)
    {
        $this->collRTemplatenamesInchapters[]= $rTemplatenamesInchapter;
        $rTemplatenamesInchapter->setTemplatenames($this);
    }

    /**
     * @param  ChildRTemplatenamesInchapter $rTemplatenamesInchapter The ChildRTemplatenamesInchapter object to remove.
     * @return $this|ChildTemplatenames The current object (for fluent API support)
     */
    public function removeRTemplatenamesInchapter(ChildRTemplatenamesInchapter $rTemplatenamesInchapter)
    {
        if ($this->getRTemplatenamesInchapters()->contains($rTemplatenamesInchapter)) {
            $pos = $this->collRTemplatenamesInchapters->search($rTemplatenamesInchapter);
            $this->collRTemplatenamesInchapters->remove($pos);
            if (null === $this->rTemplatenamesInchaptersScheduledForDeletion) {
                $this->rTemplatenamesInchaptersScheduledForDeletion = clone $this->collRTemplatenamesInchapters;
                $this->rTemplatenamesInchaptersScheduledForDeletion->clear();
            }
            $this->rTemplatenamesInchaptersScheduledForDeletion[]= clone $rTemplatenamesInchapter;
            $rTemplatenamesInchapter->setTemplatenames(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Templatenames is new, it will return
     * an empty collection; or if this Templatenames has previously
     * been saved, it will retrieve related RTemplatenamesInchapters from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Templatenames.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRTemplatenamesInchapter[] List of ChildRTemplatenamesInchapter objects
     */
    public function getRTemplatenamesInchaptersJoinFormats(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRTemplatenamesInchapterQuery::create(null, $criteria);
        $query->joinWith('Formats', $joinBehavior);

        return $this->getRTemplatenamesInchapters($query, $con);
    }

    /**
     * Clears out the collContributionss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addContributionss()
     */
    public function clearContributionss()
    {
        $this->collContributionss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collContributionss collection loaded partially.
     */
    public function resetPartialContributionss($v = true)
    {
        $this->collContributionssPartial = $v;
    }

    /**
     * Initializes the collContributionss collection.
     *
     * By default this just sets the collContributionss collection to an empty array (like clearcollContributionss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContributionss($overrideExisting = true)
    {
        if (null !== $this->collContributionss && !$overrideExisting) {
            return;
        }

        $collectionClassName = ContributionsTableMap::getTableMap()->getCollectionClassName();

        $this->collContributionss = new $collectionClassName;
        $this->collContributionss->setModel('\Contributions');
    }

    /**
     * Gets an array of ChildContributions objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTemplatenames is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildContributions[] List of ChildContributions objects
     * @throws PropelException
     */
    public function getContributionss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collContributionssPartial && !$this->isNew();
        if (null === $this->collContributionss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collContributionss) {
                // return empty collection
                $this->initContributionss();
            } else {
                $collContributionss = ChildContributionsQuery::create(null, $criteria)
                    ->filterByTemplatenames($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collContributionssPartial && count($collContributionss)) {
                        $this->initContributionss(false);

                        foreach ($collContributionss as $obj) {
                            if (false == $this->collContributionss->contains($obj)) {
                                $this->collContributionss->append($obj);
                            }
                        }

                        $this->collContributionssPartial = true;
                    }

                    return $collContributionss;
                }

                if ($partial && $this->collContributionss) {
                    foreach ($this->collContributionss as $obj) {
                        if ($obj->isNew()) {
                            $collContributionss[] = $obj;
                        }
                    }
                }

                $this->collContributionss = $collContributionss;
                $this->collContributionssPartial = false;
            }
        }

        return $this->collContributionss;
    }

    /**
     * Sets a collection of ChildContributions objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $contributionss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildTemplatenames The current object (for fluent API support)
     */
    public function setContributionss(Collection $contributionss, ConnectionInterface $con = null)
    {
        /** @var ChildContributions[] $contributionssToDelete */
        $contributionssToDelete = $this->getContributionss(new Criteria(), $con)->diff($contributionss);


        $this->contributionssScheduledForDeletion = $contributionssToDelete;

        foreach ($contributionssToDelete as $contributionsRemoved) {
            $contributionsRemoved->setTemplatenames(null);
        }

        $this->collContributionss = null;
        foreach ($contributionss as $contributions) {
            $this->addContributions($contributions);
        }

        $this->collContributionss = $contributionss;
        $this->collContributionssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Contributions objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Contributions objects.
     * @throws PropelException
     */
    public function countContributionss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collContributionssPartial && !$this->isNew();
        if (null === $this->collContributionss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContributionss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getContributionss());
            }

            $query = ChildContributionsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTemplatenames($this)
                ->count($con);
        }

        return count($this->collContributionss);
    }

    /**
     * Method called to associate a ChildContributions object to this object
     * through the ChildContributions foreign key attribute.
     *
     * @param  ChildContributions $l ChildContributions
     * @return $this|\Templatenames The current object (for fluent API support)
     */
    public function addContributions(ChildContributions $l)
    {
        if ($this->collContributionss === null) {
            $this->initContributionss();
            $this->collContributionssPartial = true;
        }

        if (!$this->collContributionss->contains($l)) {
            $this->doAddContributions($l);

            if ($this->contributionssScheduledForDeletion and $this->contributionssScheduledForDeletion->contains($l)) {
                $this->contributionssScheduledForDeletion->remove($this->contributionssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildContributions $contributions The ChildContributions object to add.
     */
    protected function doAddContributions(ChildContributions $contributions)
    {
        $this->collContributionss[]= $contributions;
        $contributions->setTemplatenames($this);
    }

    /**
     * @param  ChildContributions $contributions The ChildContributions object to remove.
     * @return $this|ChildTemplatenames The current object (for fluent API support)
     */
    public function removeContributions(ChildContributions $contributions)
    {
        if ($this->getContributionss()->contains($contributions)) {
            $pos = $this->collContributionss->search($contributions);
            $this->collContributionss->remove($pos);
            if (null === $this->contributionssScheduledForDeletion) {
                $this->contributionssScheduledForDeletion = clone $this->collContributionss;
                $this->contributionssScheduledForDeletion->clear();
            }
            $this->contributionssScheduledForDeletion[]= $contributions;
            $contributions->setTemplatenames(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Templatenames is new, it will return
     * an empty collection; or if this Templatenames has previously
     * been saved, it will retrieve related Contributionss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Templatenames.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildContributions[] List of ChildContributions objects
     */
    public function getContributionssJoinuserSysRef(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildContributionsQuery::create(null, $criteria);
        $query->joinWith('userSysRef', $joinBehavior);

        return $this->getContributionss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Templatenames is new, it will return
     * an empty collection; or if this Templatenames has previously
     * been saved, it will retrieve related Contributionss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Templatenames.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildContributions[] List of ChildContributions objects
     */
    public function getContributionssJoinFormats(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildContributionsQuery::create(null, $criteria);
        $query->joinWith('Formats', $joinBehavior);

        return $this->getContributionss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Templatenames is new, it will return
     * an empty collection; or if this Templatenames has previously
     * been saved, it will retrieve related Contributionss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Templatenames.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildContributions[] List of ChildContributions objects
     */
    public function getContributionssJoinIssues(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildContributionsQuery::create(null, $criteria);
        $query->joinWith('Issues', $joinBehavior);

        return $this->getContributionss($query, $con);
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
     * If this ChildTemplatenames is new, it will return
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
                    ->filterByTemplatenames($this)
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
     * @return $this|ChildTemplatenames The current object (for fluent API support)
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
            $rPluginTemplateRemoved->setTemplatenames(null);
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
                ->filterByTemplatenames($this)
                ->count($con);
        }

        return count($this->collRPluginTemplates);
    }

    /**
     * Method called to associate a ChildRPluginTemplate object to this object
     * through the ChildRPluginTemplate foreign key attribute.
     *
     * @param  ChildRPluginTemplate $l ChildRPluginTemplate
     * @return $this|\Templatenames The current object (for fluent API support)
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
        $rPluginTemplate->setTemplatenames($this);
    }

    /**
     * @param  ChildRPluginTemplate $rPluginTemplate The ChildRPluginTemplate object to remove.
     * @return $this|ChildTemplatenames The current object (for fluent API support)
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
            $rPluginTemplate->setTemplatenames(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Templatenames is new, it will return
     * an empty collection; or if this Templatenames has previously
     * been saved, it will retrieve related RPluginTemplates from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Templatenames.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRPluginTemplate[] List of ChildRPluginTemplate objects
     */
    public function getRPluginTemplatesJoinRPlugin(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRPluginTemplateQuery::create(null, $criteria);
        $query->joinWith('RPlugin', $joinBehavior);

        return $this->getRPluginTemplates($query, $con);
    }

    /**
     * Clears out the collTemplatess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTemplatess()
     */
    public function clearTemplatess()
    {
        $this->collTemplatess = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTemplatess collection loaded partially.
     */
    public function resetPartialTemplatess($v = true)
    {
        $this->collTemplatessPartial = $v;
    }

    /**
     * Initializes the collTemplatess collection.
     *
     * By default this just sets the collTemplatess collection to an empty array (like clearcollTemplatess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTemplatess($overrideExisting = true)
    {
        if (null !== $this->collTemplatess && !$overrideExisting) {
            return;
        }

        $collectionClassName = TemplatesTableMap::getTableMap()->getCollectionClassName();

        $this->collTemplatess = new $collectionClassName;
        $this->collTemplatess->setModel('\Templates');
    }

    /**
     * Gets an array of ChildTemplates objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTemplatenames is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTemplates[] List of ChildTemplates objects
     * @throws PropelException
     */
    public function getTemplatess(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTemplatessPartial && !$this->isNew();
        if (null === $this->collTemplatess || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTemplatess) {
                // return empty collection
                $this->initTemplatess();
            } else {
                $collTemplatess = ChildTemplatesQuery::create(null, $criteria)
                    ->filterByTemplatenames($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTemplatessPartial && count($collTemplatess)) {
                        $this->initTemplatess(false);

                        foreach ($collTemplatess as $obj) {
                            if (false == $this->collTemplatess->contains($obj)) {
                                $this->collTemplatess->append($obj);
                            }
                        }

                        $this->collTemplatessPartial = true;
                    }

                    return $collTemplatess;
                }

                if ($partial && $this->collTemplatess) {
                    foreach ($this->collTemplatess as $obj) {
                        if ($obj->isNew()) {
                            $collTemplatess[] = $obj;
                        }
                    }
                }

                $this->collTemplatess = $collTemplatess;
                $this->collTemplatessPartial = false;
            }
        }

        return $this->collTemplatess;
    }

    /**
     * Sets a collection of ChildTemplates objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $templatess A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildTemplatenames The current object (for fluent API support)
     */
    public function setTemplatess(Collection $templatess, ConnectionInterface $con = null)
    {
        /** @var ChildTemplates[] $templatessToDelete */
        $templatessToDelete = $this->getTemplatess(new Criteria(), $con)->diff($templatess);


        $this->templatessScheduledForDeletion = $templatessToDelete;

        foreach ($templatessToDelete as $templatesRemoved) {
            $templatesRemoved->setTemplatenames(null);
        }

        $this->collTemplatess = null;
        foreach ($templatess as $templates) {
            $this->addTemplates($templates);
        }

        $this->collTemplatess = $templatess;
        $this->collTemplatessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Templates objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Templates objects.
     * @throws PropelException
     */
    public function countTemplatess(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTemplatessPartial && !$this->isNew();
        if (null === $this->collTemplatess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTemplatess) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTemplatess());
            }

            $query = ChildTemplatesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTemplatenames($this)
                ->count($con);
        }

        return count($this->collTemplatess);
    }

    /**
     * Method called to associate a ChildTemplates object to this object
     * through the ChildTemplates foreign key attribute.
     *
     * @param  ChildTemplates $l ChildTemplates
     * @return $this|\Templatenames The current object (for fluent API support)
     */
    public function addTemplates(ChildTemplates $l)
    {
        if ($this->collTemplatess === null) {
            $this->initTemplatess();
            $this->collTemplatessPartial = true;
        }

        if (!$this->collTemplatess->contains($l)) {
            $this->doAddTemplates($l);

            if ($this->templatessScheduledForDeletion and $this->templatessScheduledForDeletion->contains($l)) {
                $this->templatessScheduledForDeletion->remove($this->templatessScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildTemplates $templates The ChildTemplates object to add.
     */
    protected function doAddTemplates(ChildTemplates $templates)
    {
        $this->collTemplatess[]= $templates;
        $templates->setTemplatenames($this);
    }

    /**
     * @param  ChildTemplates $templates The ChildTemplates object to remove.
     * @return $this|ChildTemplatenames The current object (for fluent API support)
     */
    public function removeTemplates(ChildTemplates $templates)
    {
        if ($this->getTemplatess()->contains($templates)) {
            $pos = $this->collTemplatess->search($templates);
            $this->collTemplatess->remove($pos);
            if (null === $this->templatessScheduledForDeletion) {
                $this->templatessScheduledForDeletion = clone $this->collTemplatess;
                $this->templatessScheduledForDeletion->clear();
            }
            $this->templatessScheduledForDeletion[]= $templates;
            $templates->setTemplatenames(null);
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
        $collectionClassName = RRightsFortemplateTableMap::getTableMap()->getCollectionClassName();

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
     * to the current object by way of the R_rights_fortemplate cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTemplatenames is new, it will return
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
                    ->filterByTemplatenames($this);
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
     * to the current object by way of the R_rights_fortemplate cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $rightss A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildTemplatenames The current object (for fluent API support)
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
     * to the current object by way of the R_rights_fortemplate cross-reference table.
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
                    ->filterByTemplatenames($this)
                    ->count($con);
            }
        } else {
            return count($this->collRightss);
        }
    }

    /**
     * Associate a ChildRights to this object
     * through the R_rights_fortemplate cross reference table.
     *
     * @param ChildRights $rights
     * @return ChildTemplatenames The current object (for fluent API support)
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
        $rRightsFortemplate = new ChildRRightsFortemplate();

        $rRightsFortemplate->setRights($rights);

        $rRightsFortemplate->setTemplatenames($this);

        $this->addRRightsFortemplate($rRightsFortemplate);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$rights->isTemplatenamessLoaded()) {
            $rights->initTemplatenamess();
            $rights->getTemplatenamess()->push($this);
        } elseif (!$rights->getTemplatenamess()->contains($this)) {
            $rights->getTemplatenamess()->push($this);
        }

    }

    /**
     * Remove rights of this object
     * through the R_rights_fortemplate cross reference table.
     *
     * @param ChildRights $rights
     * @return ChildTemplatenames The current object (for fluent API support)
     */
    public function removeRights(ChildRights $rights)
    {
        if ($this->getRightss()->contains($rights)) {
            $rRightsFortemplate = new ChildRRightsFortemplate();
            $rRightsFortemplate->setRights($rights);
            if ($rights->isTemplatenamessLoaded()) {
                //remove the back reference if available
                $rights->getTemplatenamess()->removeObject($this);
            }

            $rRightsFortemplate->setTemplatenames($this);
            $this->removeRRightsFortemplate(clone $rRightsFortemplate);
            $rRightsFortemplate->clear();

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
        $collectionClassName = RTemplatenamesForbookTableMap::getTableMap()->getCollectionClassName();

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
     * to the current object by way of the R_templatenames_forbook cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTemplatenames is new, it will return
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
                    ->filterByTemplatenames($this);
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
     * to the current object by way of the R_templatenames_forbook cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $bookss A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildTemplatenames The current object (for fluent API support)
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
     * to the current object by way of the R_templatenames_forbook cross-reference table.
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
                    ->filterByTemplatenames($this)
                    ->count($con);
            }
        } else {
            return count($this->collBookss);
        }
    }

    /**
     * Associate a ChildBooks to this object
     * through the R_templatenames_forbook cross reference table.
     *
     * @param ChildBooks $books
     * @return ChildTemplatenames The current object (for fluent API support)
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
        $rTemplatenamesForbook = new ChildRTemplatenamesForbook();

        $rTemplatenamesForbook->setBooks($books);

        $rTemplatenamesForbook->setTemplatenames($this);

        $this->addRTemplatenamesForbook($rTemplatenamesForbook);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$books->isTemplatenamessLoaded()) {
            $books->initTemplatenamess();
            $books->getTemplatenamess()->push($this);
        } elseif (!$books->getTemplatenamess()->contains($this)) {
            $books->getTemplatenamess()->push($this);
        }

    }

    /**
     * Remove books of this object
     * through the R_templatenames_forbook cross reference table.
     *
     * @param ChildBooks $books
     * @return ChildTemplatenames The current object (for fluent API support)
     */
    public function removeBooks(ChildBooks $books)
    {
        if ($this->getBookss()->contains($books)) {
            $rTemplatenamesForbook = new ChildRTemplatenamesForbook();
            $rTemplatenamesForbook->setBooks($books);
            if ($books->isTemplatenamessLoaded()) {
                //remove the back reference if available
                $books->getTemplatenamess()->removeObject($this);
            }

            $rTemplatenamesForbook->setTemplatenames($this);
            $this->removeRTemplatenamesForbook(clone $rTemplatenamesForbook);
            $rTemplatenamesForbook->clear();

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
        $collectionClassName = RTemplatenamesInchapterTableMap::getTableMap()->getCollectionClassName();

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
     * to the current object by way of the R_templatenames_inchapter cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTemplatenames is new, it will return
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
                    ->filterByTemplatenames($this);
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
     * to the current object by way of the R_templatenames_inchapter cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $formatss A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildTemplatenames The current object (for fluent API support)
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
     * to the current object by way of the R_templatenames_inchapter cross-reference table.
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
                    ->filterByTemplatenames($this)
                    ->count($con);
            }
        } else {
            return count($this->collFormatss);
        }
    }

    /**
     * Associate a ChildFormats to this object
     * through the R_templatenames_inchapter cross reference table.
     *
     * @param ChildFormats $formats
     * @return ChildTemplatenames The current object (for fluent API support)
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
        $rTemplatenamesInchapter = new ChildRTemplatenamesInchapter();

        $rTemplatenamesInchapter->setFormats($formats);

        $rTemplatenamesInchapter->setTemplatenames($this);

        $this->addRTemplatenamesInchapter($rTemplatenamesInchapter);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$formats->isTemplatenamessLoaded()) {
            $formats->initTemplatenamess();
            $formats->getTemplatenamess()->push($this);
        } elseif (!$formats->getTemplatenamess()->contains($this)) {
            $formats->getTemplatenamess()->push($this);
        }

    }

    /**
     * Remove formats of this object
     * through the R_templatenames_inchapter cross reference table.
     *
     * @param ChildFormats $formats
     * @return ChildTemplatenames The current object (for fluent API support)
     */
    public function removeFormats(ChildFormats $formats)
    {
        if ($this->getFormatss()->contains($formats)) {
            $rTemplatenamesInchapter = new ChildRTemplatenamesInchapter();
            $rTemplatenamesInchapter->setFormats($formats);
            if ($formats->isTemplatenamessLoaded()) {
                //remove the back reference if available
                $formats->getTemplatenamess()->removeObject($this);
            }

            $rTemplatenamesInchapter->setTemplatenames($this);
            $this->removeRTemplatenamesInchapter(clone $rTemplatenamesInchapter);
            $rTemplatenamesInchapter->clear();

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
        $collectionClassName = RPluginTemplateTableMap::getTableMap()->getCollectionClassName();

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
     * to the current object by way of the R_plugin_template cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTemplatenames is new, it will return
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
                    ->filterByTemplatenames($this);
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
     * to the current object by way of the R_plugin_template cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $rPlugins A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildTemplatenames The current object (for fluent API support)
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
     * to the current object by way of the R_plugin_template cross-reference table.
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
                    ->filterByTemplatenames($this)
                    ->count($con);
            }
        } else {
            return count($this->collRPlugins);
        }
    }

    /**
     * Associate a ChildPlugins to this object
     * through the R_plugin_template cross reference table.
     *
     * @param ChildPlugins $rPlugin
     * @return ChildTemplatenames The current object (for fluent API support)
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
        $rPluginTemplate = new ChildRPluginTemplate();

        $rPluginTemplate->setRPlugin($rPlugin);

        $rPluginTemplate->setTemplatenames($this);

        $this->addRPluginTemplate($rPluginTemplate);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$rPlugin->isTemplatenamessLoaded()) {
            $rPlugin->initTemplatenamess();
            $rPlugin->getTemplatenamess()->push($this);
        } elseif (!$rPlugin->getTemplatenamess()->contains($this)) {
            $rPlugin->getTemplatenamess()->push($this);
        }

    }

    /**
     * Remove rPlugin of this object
     * through the R_plugin_template cross reference table.
     *
     * @param ChildPlugins $rPlugin
     * @return ChildTemplatenames The current object (for fluent API support)
     */
    public function removeRPlugin(ChildPlugins $rPlugin)
    {
        if ($this->getRPlugins()->contains($rPlugin)) {
            $rPluginTemplate = new ChildRPluginTemplate();
            $rPluginTemplate->setRPlugin($rPlugin);
            if ($rPlugin->isTemplatenamessLoaded()) {
                //remove the back reference if available
                $rPlugin->getTemplatenamess()->removeObject($this);
            }

            $rPluginTemplate->setTemplatenames($this);
            $this->removeRPluginTemplate(clone $rPluginTemplate);
            $rPluginTemplate->clear();

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
        $this->id = null;
        $this->_name = null;
        $this->_helptext = null;
        $this->_helpimage = null;
        $this->_category = null;
        $this->_public = null;
        $this->__config__ = null;
        $this->__split__ = null;
        $this->__sort__ = null;
        $this->__parentnode__ = null;
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
            if ($this->collRRightsFortemplates) {
                foreach ($this->collRRightsFortemplates as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRTemplatenamesForbooks) {
                foreach ($this->collRTemplatenamesForbooks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRTemplatenamesInchapters) {
                foreach ($this->collRTemplatenamesInchapters as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContributionss) {
                foreach ($this->collContributionss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRPluginTemplates) {
                foreach ($this->collRPluginTemplates as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTemplatess) {
                foreach ($this->collTemplatess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRightss) {
                foreach ($this->collRightss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collBookss) {
                foreach ($this->collBookss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFormatss) {
                foreach ($this->collFormatss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRPlugins) {
                foreach ($this->collRPlugins as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collRRightsFortemplates = null;
        $this->collRTemplatenamesForbooks = null;
        $this->collRTemplatenamesInchapters = null;
        $this->collContributionss = null;
        $this->collRPluginTemplates = null;
        $this->collTemplatess = null;
        $this->collRightss = null;
        $this->collBookss = null;
        $this->collFormatss = null;
        $this->collRPlugins = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(TemplatenamesTableMap::DEFAULT_STRING_FORMAT);
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
