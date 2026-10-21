<?php

namespace Base;

use \Books as ChildBooks;
use \BooksQuery as ChildBooksQuery;
use \Contributions as ChildContributions;
use \ContributionsQuery as ChildContributionsQuery;
use \ContributionsVersionQuery as ChildContributionsVersionQuery;
use \Data as ChildData;
use \DataQuery as ChildDataQuery;
use \DataVersion as ChildDataVersion;
use \DataVersionQuery as ChildDataVersionQuery;
use \Formats as ChildFormats;
use \FormatsQuery as ChildFormatsQuery;
use \Issues as ChildIssues;
use \IssuesQuery as ChildIssuesQuery;
use \RDataBook as ChildRDataBook;
use \RDataBookQuery as ChildRDataBookQuery;
use \RDataContribution as ChildRDataContribution;
use \RDataContributionQuery as ChildRDataContributionQuery;
use \RDataData as ChildRDataData;
use \RDataDataQuery as ChildRDataDataQuery;
use \RDataFormat as ChildRDataFormat;
use \RDataFormatQuery as ChildRDataFormatQuery;
use \RDataIssue as ChildRDataIssue;
use \RDataIssueQuery as ChildRDataIssueQuery;
use \RDataTemplate as ChildRDataTemplate;
use \RDataTemplateQuery as ChildRDataTemplateQuery;
use \Templates as ChildTemplates;
use \TemplatesQuery as ChildTemplatesQuery;
use \Users as ChildUsers;
use \UsersQuery as ChildUsersQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\DataTableMap;
use Map\DataVersionTableMap;
use Map\RDataBookTableMap;
use Map\RDataContributionTableMap;
use Map\RDataDataTableMap;
use Map\RDataFormatTableMap;
use Map\RDataIssueTableMap;
use Map\RDataTemplateTableMap;
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
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the '_data' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Data implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\DataTableMap';


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
     * The value for the _forcontribution field.
     *
     * @var        int
     */
    protected $_forcontribution;

    /**
     * The value for the _fortemplatefield field.
     *
     * @var        int
     */
    protected $_fortemplatefield;

    /**
     * The value for the _content field.
     *
     * @var        string
     */
    protected $_content;

    /**
     * The value for the _isjson field.
     *
     * @var        boolean
     */
    protected $_isjson;

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
     * The value for the version field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $version;

    /**
     * The value for the version_created_at field.
     *
     * @var        DateTime
     */
    protected $version_created_at;

    /**
     * The value for the version_created_by field.
     *
     * @var        string
     */
    protected $version_created_by;

    /**
     * The value for the version_comment field.
     *
     * @var        string
     */
    protected $version_comment;

    /**
     * @var        ChildUsers
     */
    protected $auserSysRef;

    /**
     * @var        ChildContributions
     */
    protected $aContributions;

    /**
     * @var        ChildTemplates
     */
    protected $aTemplates;

    /**
     * @var        ObjectCollection|ChildRDataData[] Collection to store aggregation of ChildRDataData objects.
     */
    protected $collRDataDatasRelatedBySource;
    protected $collRDataDatasRelatedBySourcePartial;

    /**
     * @var        ObjectCollection|ChildRDataData[] Collection to store aggregation of ChildRDataData objects.
     */
    protected $collRDataDatasRelatedByTarget;
    protected $collRDataDatasRelatedByTargetPartial;

    /**
     * @var        ObjectCollection|ChildRDataContribution[] Collection to store aggregation of ChildRDataContribution objects.
     */
    protected $collRDataContributions;
    protected $collRDataContributionsPartial;

    /**
     * @var        ObjectCollection|ChildRDataBook[] Collection to store aggregation of ChildRDataBook objects.
     */
    protected $collRDataBooks;
    protected $collRDataBooksPartial;

    /**
     * @var        ObjectCollection|ChildRDataFormat[] Collection to store aggregation of ChildRDataFormat objects.
     */
    protected $collRDataFormats;
    protected $collRDataFormatsPartial;

    /**
     * @var        ObjectCollection|ChildRDataIssue[] Collection to store aggregation of ChildRDataIssue objects.
     */
    protected $collRDataIssues;
    protected $collRDataIssuesPartial;

    /**
     * @var        ObjectCollection|ChildRDataTemplate[] Collection to store aggregation of ChildRDataTemplate objects.
     */
    protected $collRDataTemplates;
    protected $collRDataTemplatesPartial;

    /**
     * @var        ObjectCollection|ChildDataVersion[] Collection to store aggregation of ChildDataVersion objects.
     */
    protected $collDataVersions;
    protected $collDataVersionsPartial;

    /**
     * @var        ObjectCollection|ChildData[] Cross Collection to store aggregation of ChildData objects.
     */
    protected $collRDataRefs;

    /**
     * @var bool
     */
    protected $collRDataRefsPartial;

    /**
     * @var        ObjectCollection|ChildData[] Cross Collection to store aggregation of ChildData objects.
     */
    protected $collRDataSrcs;

    /**
     * @var bool
     */
    protected $collRDataSrcsPartial;

    /**
     * @var        ObjectCollection|ChildContributions[] Cross Collection to store aggregation of ChildContributions objects.
     */
    protected $collRContributions;

    /**
     * @var bool
     */
    protected $collRContributionsPartial;

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
     * @var        ObjectCollection|ChildTemplates[] Cross Collection to store aggregation of ChildTemplates objects.
     */
    protected $collRTemplates;

    /**
     * @var bool
     */
    protected $collRTemplatesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    // versionable behavior


    /**
     * @var bool
     */
    protected $enforceVersion = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildData[]
     */
    protected $rDataRefsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildData[]
     */
    protected $rDataSrcsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildContributions[]
     */
    protected $rContributionsScheduledForDeletion = null;

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
     * @var ObjectCollection|ChildTemplates[]
     */
    protected $rTemplatesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRDataData[]
     */
    protected $rDataDatasRelatedBySourceScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRDataData[]
     */
    protected $rDataDatasRelatedByTargetScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRDataContribution[]
     */
    protected $rDataContributionsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRDataBook[]
     */
    protected $rDataBooksScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRDataFormat[]
     */
    protected $rDataFormatsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRDataIssue[]
     */
    protected $rDataIssuesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRDataTemplate[]
     */
    protected $rDataTemplatesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDataVersion[]
     */
    protected $dataVersionsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->version = 0;
    }

    /**
     * Initializes internal state of Base\Data object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
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
     * Compares this with another <code>Data</code> instance.  If
     * <code>obj</code> is an instance of <code>Data</code>, delegates to
     * <code>equals(Data)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Data The current object, for fluid interface
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
     * Get the [_forcontribution] column value.
     *
     * @return int
     */
    public function getForcontribution()
    {
        return $this->_forcontribution;
    }

    /**
     * Get the [_fortemplatefield] column value.
     *
     * @return int
     */
    public function getFortemplatefield()
    {
        return $this->_fortemplatefield;
    }

    /**
     * Get the [_content] column value.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->_content;
    }

    /**
     * Get the [_isjson] column value.
     *
     * @return boolean
     */
    public function getIsjson()
    {
        return $this->_isjson;
    }

    /**
     * Get the [_isjson] column value.
     *
     * @return boolean
     */
    public function isIsjson()
    {
        return $this->getIsjson();
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
     * Get the [version] column value.
     *
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Get the [optionally formatted] temporal [version_created_at] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getVersionCreatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->version_created_at;
        } else {
            return $this->version_created_at instanceof \DateTimeInterface ? $this->version_created_at->format($format) : null;
        }
    }

    /**
     * Get the [version_created_by] column value.
     *
     * @return string
     */
    public function getVersionCreatedBy()
    {
        return $this->version_created_by;
    }

    /**
     * Get the [version_comment] column value.
     *
     * @return string
     */
    public function getVersionComment()
    {
        return $this->version_comment;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[DataTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [_forcontribution] column.
     *
     * @param int $v new value
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setForcontribution($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->_forcontribution !== $v) {
            $this->_forcontribution = $v;
            $this->modifiedColumns[DataTableMap::COL__FORCONTRIBUTION] = true;
        }

        if ($this->aContributions !== null && $this->aContributions->getId() !== $v) {
            $this->aContributions = null;
        }

        return $this;
    } // setForcontribution()

    /**
     * Set the value of [_fortemplatefield] column.
     *
     * @param int $v new value
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setFortemplatefield($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->_fortemplatefield !== $v) {
            $this->_fortemplatefield = $v;
            $this->modifiedColumns[DataTableMap::COL__FORTEMPLATEFIELD] = true;
        }

        if ($this->aTemplates !== null && $this->aTemplates->getId() !== $v) {
            $this->aTemplates = null;
        }

        return $this;
    } // setFortemplatefield()

    /**
     * Set the value of [_content] column.
     *
     * @param string $v new value
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setContent($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_content !== $v) {
            $this->_content = $v;
            $this->modifiedColumns[DataTableMap::COL__CONTENT] = true;
        }

        return $this;
    } // setContent()

    /**
     * Sets the value of the [_isjson] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setIsjson($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->_isjson !== $v) {
            $this->_isjson = $v;
            $this->modifiedColumns[DataTableMap::COL__ISJSON] = true;
        }

        return $this;
    } // setIsjson()

    /**
     * Set the value of [__user__] column.
     *
     * @param int $v new value
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setUserSys($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__user__ !== $v) {
            $this->__user__ = $v;
            $this->modifiedColumns[DataTableMap::COL___USER__] = true;
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
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setConfigSys($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->__config__ !== $v) {
            $this->__config__ = $v;
            $this->modifiedColumns[DataTableMap::COL___CONFIG__] = true;
        }

        return $this;
    } // setConfigSys()

    /**
     * Set the value of [__split__] column.
     *
     * @param string $v new value
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setSplit($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->__split__ !== $v) {
            $this->__split__ = $v;
            $this->modifiedColumns[DataTableMap::COL___SPLIT__] = true;
        }

        return $this;
    } // setSplit()

    /**
     * Set the value of [__parentnode__] column.
     *
     * @param int $v new value
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setParentnode($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__parentnode__ !== $v) {
            $this->__parentnode__ = $v;
            $this->modifiedColumns[DataTableMap::COL___PARENTNODE__] = true;
        }

        return $this;
    } // setParentnode()

    /**
     * Set the value of [__sort__] column.
     *
     * @param int $v new value
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setSort($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__sort__ !== $v) {
            $this->__sort__ = $v;
            $this->modifiedColumns[DataTableMap::COL___SORT__] = true;
        }

        return $this;
    } // setSort()

    /**
     * Set the value of [version] column.
     *
     * @param int $v new value
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[DataTableMap::COL_VERSION] = true;
        }

        return $this;
    } // setVersion()

    /**
     * Sets the value of [version_created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setVersionCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->version_created_at !== null || $dt !== null) {
            if ($this->version_created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->version_created_at->format("Y-m-d H:i:s.u")) {
                $this->version_created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[DataTableMap::COL_VERSION_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setVersionCreatedAt()

    /**
     * Set the value of [version_created_by] column.
     *
     * @param string $v new value
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setVersionCreatedBy($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->version_created_by !== $v) {
            $this->version_created_by = $v;
            $this->modifiedColumns[DataTableMap::COL_VERSION_CREATED_BY] = true;
        }

        return $this;
    } // setVersionCreatedBy()

    /**
     * Set the value of [version_comment] column.
     *
     * @param string $v new value
     * @return $this|\Data The current object (for fluent API support)
     */
    public function setVersionComment($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->version_comment !== $v) {
            $this->version_comment = $v;
            $this->modifiedColumns[DataTableMap::COL_VERSION_COMMENT] = true;
        }

        return $this;
    } // setVersionComment()

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
            if ($this->version !== 0) {
                return false;
            }

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : DataTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : DataTableMap::translateFieldName('Forcontribution', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_forcontribution = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : DataTableMap::translateFieldName('Fortemplatefield', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_fortemplatefield = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : DataTableMap::translateFieldName('Content', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_content = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : DataTableMap::translateFieldName('Isjson', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_isjson = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : DataTableMap::translateFieldName('UserSys', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__user__ = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : DataTableMap::translateFieldName('ConfigSys', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__config__ = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : DataTableMap::translateFieldName('Split', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__split__ = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : DataTableMap::translateFieldName('Parentnode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__parentnode__ = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : DataTableMap::translateFieldName('Sort', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__sort__ = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : DataTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : DataTableMap::translateFieldName('VersionCreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->version_created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : DataTableMap::translateFieldName('VersionCreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version_created_by = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : DataTableMap::translateFieldName('VersionComment', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version_comment = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 14; // 14 = DataTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Data'), 0, $e);
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
        if ($this->aContributions !== null && $this->_forcontribution !== $this->aContributions->getId()) {
            $this->aContributions = null;
        }
        if ($this->aTemplates !== null && $this->_fortemplatefield !== $this->aTemplates->getId()) {
            $this->aTemplates = null;
        }
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
            $con = Propel::getServiceContainer()->getReadConnection(DataTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildDataQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->auserSysRef = null;
            $this->aContributions = null;
            $this->aTemplates = null;
            $this->collRDataDatasRelatedBySource = null;

            $this->collRDataDatasRelatedByTarget = null;

            $this->collRDataContributions = null;

            $this->collRDataBooks = null;

            $this->collRDataFormats = null;

            $this->collRDataIssues = null;

            $this->collRDataTemplates = null;

            $this->collDataVersions = null;

            $this->collRDataRefs = null;
            $this->collRDataSrcs = null;
            $this->collRContributions = null;
            $this->collRBooks = null;
            $this->collRFormats = null;
            $this->collRIssues = null;
            $this->collRTemplates = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Data::setDeleted()
     * @see Data::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(DataTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildDataQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(DataTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            // versionable behavior
            if ($this->isVersioningNecessary()) {
                $this->setVersion($this->isNew() ? 1 : $this->getLastVersionNumber($con) + 1);
                if (!$this->isColumnModified(DataTableMap::COL_VERSION_CREATED_AT)) {
                    $this->setVersionCreatedAt(time());
                }
                $createVersion = true; // for postSave hook
            }
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
                // versionable behavior
                if (isset($createVersion)) {
                    $this->addVersion($con);
                }
                DataTableMap::addInstanceToPool($this);
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

            if ($this->aContributions !== null) {
                if ($this->aContributions->isModified() || $this->aContributions->isNew()) {
                    $affectedRows += $this->aContributions->save($con);
                }
                $this->setContributions($this->aContributions);
            }

            if ($this->aTemplates !== null) {
                if ($this->aTemplates->isModified() || $this->aTemplates->isNew()) {
                    $affectedRows += $this->aTemplates->save($con);
                }
                $this->setTemplates($this->aTemplates);
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

            if ($this->rDataRefsScheduledForDeletion !== null) {
                if (!$this->rDataRefsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->rDataRefsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RDataDataQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->rDataRefsScheduledForDeletion = null;
                }

            }

            if ($this->collRDataRefs) {
                foreach ($this->collRDataRefs as $rDataRef) {
                    if (!$rDataRef->isDeleted() && ($rDataRef->isNew() || $rDataRef->isModified())) {
                        $rDataRef->save($con);
                    }
                }
            }


            if ($this->rDataSrcsScheduledForDeletion !== null) {
                if (!$this->rDataSrcsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->rDataSrcsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RDataDataQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->rDataSrcsScheduledForDeletion = null;
                }

            }

            if ($this->collRDataSrcs) {
                foreach ($this->collRDataSrcs as $rDataSrc) {
                    if (!$rDataSrc->isDeleted() && ($rDataSrc->isNew() || $rDataSrc->isModified())) {
                        $rDataSrc->save($con);
                    }
                }
            }


            if ($this->rContributionsScheduledForDeletion !== null) {
                if (!$this->rContributionsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->rContributionsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RDataContributionQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->rContributionsScheduledForDeletion = null;
                }

            }

            if ($this->collRContributions) {
                foreach ($this->collRContributions as $rContribution) {
                    if (!$rContribution->isDeleted() && ($rContribution->isNew() || $rContribution->isModified())) {
                        $rContribution->save($con);
                    }
                }
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

                    \RDataBookQuery::create()
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

                    \RDataFormatQuery::create()
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

                    \RDataIssueQuery::create()
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


            if ($this->rTemplatesScheduledForDeletion !== null) {
                if (!$this->rTemplatesScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->rTemplatesScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \RDataTemplateQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->rTemplatesScheduledForDeletion = null;
                }

            }

            if ($this->collRTemplates) {
                foreach ($this->collRTemplates as $rTemplate) {
                    if (!$rTemplate->isDeleted() && ($rTemplate->isNew() || $rTemplate->isModified())) {
                        $rTemplate->save($con);
                    }
                }
            }


            if ($this->rDataDatasRelatedBySourceScheduledForDeletion !== null) {
                if (!$this->rDataDatasRelatedBySourceScheduledForDeletion->isEmpty()) {
                    \RDataDataQuery::create()
                        ->filterByPrimaryKeys($this->rDataDatasRelatedBySourceScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rDataDatasRelatedBySourceScheduledForDeletion = null;
                }
            }

            if ($this->collRDataDatasRelatedBySource !== null) {
                foreach ($this->collRDataDatasRelatedBySource as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->rDataDatasRelatedByTargetScheduledForDeletion !== null) {
                if (!$this->rDataDatasRelatedByTargetScheduledForDeletion->isEmpty()) {
                    \RDataDataQuery::create()
                        ->filterByPrimaryKeys($this->rDataDatasRelatedByTargetScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rDataDatasRelatedByTargetScheduledForDeletion = null;
                }
            }

            if ($this->collRDataDatasRelatedByTarget !== null) {
                foreach ($this->collRDataDatasRelatedByTarget as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->rDataContributionsScheduledForDeletion !== null) {
                if (!$this->rDataContributionsScheduledForDeletion->isEmpty()) {
                    \RDataContributionQuery::create()
                        ->filterByPrimaryKeys($this->rDataContributionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rDataContributionsScheduledForDeletion = null;
                }
            }

            if ($this->collRDataContributions !== null) {
                foreach ($this->collRDataContributions as $referrerFK) {
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

            if ($this->rDataFormatsScheduledForDeletion !== null) {
                if (!$this->rDataFormatsScheduledForDeletion->isEmpty()) {
                    \RDataFormatQuery::create()
                        ->filterByPrimaryKeys($this->rDataFormatsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rDataFormatsScheduledForDeletion = null;
                }
            }

            if ($this->collRDataFormats !== null) {
                foreach ($this->collRDataFormats as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->rDataIssuesScheduledForDeletion !== null) {
                if (!$this->rDataIssuesScheduledForDeletion->isEmpty()) {
                    \RDataIssueQuery::create()
                        ->filterByPrimaryKeys($this->rDataIssuesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->rDataIssuesScheduledForDeletion = null;
                }
            }

            if ($this->collRDataIssues !== null) {
                foreach ($this->collRDataIssues as $referrerFK) {
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

            if ($this->dataVersionsScheduledForDeletion !== null) {
                if (!$this->dataVersionsScheduledForDeletion->isEmpty()) {
                    \DataVersionQuery::create()
                        ->filterByPrimaryKeys($this->dataVersionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->dataVersionsScheduledForDeletion = null;
                }
            }

            if ($this->collDataVersions !== null) {
                foreach ($this->collDataVersions as $referrerFK) {
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

        $this->modifiedColumns[DataTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . DataTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(DataTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(DataTableMap::COL__FORCONTRIBUTION)) {
            $modifiedColumns[':p' . $index++]  = '_forcontribution';
        }
        if ($this->isColumnModified(DataTableMap::COL__FORTEMPLATEFIELD)) {
            $modifiedColumns[':p' . $index++]  = '_fortemplatefield';
        }
        if ($this->isColumnModified(DataTableMap::COL__CONTENT)) {
            $modifiedColumns[':p' . $index++]  = '_content';
        }
        if ($this->isColumnModified(DataTableMap::COL__ISJSON)) {
            $modifiedColumns[':p' . $index++]  = '_isjson';
        }
        if ($this->isColumnModified(DataTableMap::COL___USER__)) {
            $modifiedColumns[':p' . $index++]  = '__user__';
        }
        if ($this->isColumnModified(DataTableMap::COL___CONFIG__)) {
            $modifiedColumns[':p' . $index++]  = '__config__';
        }
        if ($this->isColumnModified(DataTableMap::COL___SPLIT__)) {
            $modifiedColumns[':p' . $index++]  = '__split__';
        }
        if ($this->isColumnModified(DataTableMap::COL___PARENTNODE__)) {
            $modifiedColumns[':p' . $index++]  = '__parentnode__';
        }
        if ($this->isColumnModified(DataTableMap::COL___SORT__)) {
            $modifiedColumns[':p' . $index++]  = '__sort__';
        }
        if ($this->isColumnModified(DataTableMap::COL_VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'version';
        }
        if ($this->isColumnModified(DataTableMap::COL_VERSION_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'version_created_at';
        }
        if ($this->isColumnModified(DataTableMap::COL_VERSION_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'version_created_by';
        }
        if ($this->isColumnModified(DataTableMap::COL_VERSION_COMMENT)) {
            $modifiedColumns[':p' . $index++]  = 'version_comment';
        }

        $sql = sprintf(
            'INSERT INTO _data (%s) VALUES (%s)',
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
                    case '_forcontribution':
                        $stmt->bindValue($identifier, $this->_forcontribution, PDO::PARAM_INT);
                        break;
                    case '_fortemplatefield':
                        $stmt->bindValue($identifier, $this->_fortemplatefield, PDO::PARAM_INT);
                        break;
                    case '_content':
                        $stmt->bindValue($identifier, $this->_content, PDO::PARAM_STR);
                        break;
                    case '_isjson':
                        $stmt->bindValue($identifier, (int) $this->_isjson, PDO::PARAM_INT);
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
                    case 'version':
                        $stmt->bindValue($identifier, $this->version, PDO::PARAM_INT);
                        break;
                    case 'version_created_at':
                        $stmt->bindValue($identifier, $this->version_created_at ? $this->version_created_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'version_created_by':
                        $stmt->bindValue($identifier, $this->version_created_by, PDO::PARAM_STR);
                        break;
                    case 'version_comment':
                        $stmt->bindValue($identifier, $this->version_comment, PDO::PARAM_STR);
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
        $pos = DataTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getForcontribution();
                break;
            case 2:
                return $this->getFortemplatefield();
                break;
            case 3:
                return $this->getContent();
                break;
            case 4:
                return $this->getIsjson();
                break;
            case 5:
                return $this->getUserSys();
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
            case 10:
                return $this->getVersion();
                break;
            case 11:
                return $this->getVersionCreatedAt();
                break;
            case 12:
                return $this->getVersionCreatedBy();
                break;
            case 13:
                return $this->getVersionComment();
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

        if (isset($alreadyDumpedObjects['Data'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Data'][$this->hashCode()] = true;
        $keys = DataTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getForcontribution(),
            $keys[2] => $this->getFortemplatefield(),
            $keys[3] => $this->getContent(),
            $keys[4] => $this->getIsjson(),
            $keys[5] => $this->getUserSys(),
            $keys[6] => $this->getConfigSys(),
            $keys[7] => $this->getSplit(),
            $keys[8] => $this->getParentnode(),
            $keys[9] => $this->getSort(),
            $keys[10] => $this->getVersion(),
            $keys[11] => $this->getVersionCreatedAt(),
            $keys[12] => $this->getVersionCreatedBy(),
            $keys[13] => $this->getVersionComment(),
        );
        if ($result[$keys[11]] instanceof \DateTimeInterface) {
            $result[$keys[11]] = $result[$keys[11]]->format('c');
        }

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
            if (null !== $this->aContributions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'contributions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = '_contributions';
                        break;
                    default:
                        $key = 'Contributions';
                }

                $result[$key] = $this->aContributions->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aTemplates) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'templates';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = '_templates';
                        break;
                    default:
                        $key = 'Templates';
                }

                $result[$key] = $this->aTemplates->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collRDataDatasRelatedBySource) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rDataDatas';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_data_datas';
                        break;
                    default:
                        $key = 'RDataDatas';
                }

                $result[$key] = $this->collRDataDatasRelatedBySource->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRDataDatasRelatedByTarget) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rDataDatas';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_data_datas';
                        break;
                    default:
                        $key = 'RDataDatas';
                }

                $result[$key] = $this->collRDataDatasRelatedByTarget->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRDataContributions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rDataContributions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_data_contributions';
                        break;
                    default:
                        $key = 'RDataContributions';
                }

                $result[$key] = $this->collRDataContributions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
            if (null !== $this->collRDataFormats) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rDataFormats';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_data_formats';
                        break;
                    default:
                        $key = 'RDataFormats';
                }

                $result[$key] = $this->collRDataFormats->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collRDataIssues) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'rDataIssues';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'R_data_issues';
                        break;
                    default:
                        $key = 'RDataIssues';
                }

                $result[$key] = $this->collRDataIssues->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
            if (null !== $this->collDataVersions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'dataVersions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = '_data_versions';
                        break;
                    default:
                        $key = 'DataVersions';
                }

                $result[$key] = $this->collDataVersions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Data
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = DataTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Data
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setForcontribution($value);
                break;
            case 2:
                $this->setFortemplatefield($value);
                break;
            case 3:
                $this->setContent($value);
                break;
            case 4:
                $this->setIsjson($value);
                break;
            case 5:
                $this->setUserSys($value);
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
            case 10:
                $this->setVersion($value);
                break;
            case 11:
                $this->setVersionCreatedAt($value);
                break;
            case 12:
                $this->setVersionCreatedBy($value);
                break;
            case 13:
                $this->setVersionComment($value);
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
        $keys = DataTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setForcontribution($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setFortemplatefield($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setContent($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setIsjson($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setUserSys($arr[$keys[5]]);
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
        if (array_key_exists($keys[10], $arr)) {
            $this->setVersion($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setVersionCreatedAt($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setVersionCreatedBy($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setVersionComment($arr[$keys[13]]);
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
     * @return $this|\Data The current object, for fluid interface
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
        $criteria = new Criteria(DataTableMap::DATABASE_NAME);

        if ($this->isColumnModified(DataTableMap::COL_ID)) {
            $criteria->add(DataTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(DataTableMap::COL__FORCONTRIBUTION)) {
            $criteria->add(DataTableMap::COL__FORCONTRIBUTION, $this->_forcontribution);
        }
        if ($this->isColumnModified(DataTableMap::COL__FORTEMPLATEFIELD)) {
            $criteria->add(DataTableMap::COL__FORTEMPLATEFIELD, $this->_fortemplatefield);
        }
        if ($this->isColumnModified(DataTableMap::COL__CONTENT)) {
            $criteria->add(DataTableMap::COL__CONTENT, $this->_content);
        }
        if ($this->isColumnModified(DataTableMap::COL__ISJSON)) {
            $criteria->add(DataTableMap::COL__ISJSON, $this->_isjson);
        }
        if ($this->isColumnModified(DataTableMap::COL___USER__)) {
            $criteria->add(DataTableMap::COL___USER__, $this->__user__);
        }
        if ($this->isColumnModified(DataTableMap::COL___CONFIG__)) {
            $criteria->add(DataTableMap::COL___CONFIG__, $this->__config__);
        }
        if ($this->isColumnModified(DataTableMap::COL___SPLIT__)) {
            $criteria->add(DataTableMap::COL___SPLIT__, $this->__split__);
        }
        if ($this->isColumnModified(DataTableMap::COL___PARENTNODE__)) {
            $criteria->add(DataTableMap::COL___PARENTNODE__, $this->__parentnode__);
        }
        if ($this->isColumnModified(DataTableMap::COL___SORT__)) {
            $criteria->add(DataTableMap::COL___SORT__, $this->__sort__);
        }
        if ($this->isColumnModified(DataTableMap::COL_VERSION)) {
            $criteria->add(DataTableMap::COL_VERSION, $this->version);
        }
        if ($this->isColumnModified(DataTableMap::COL_VERSION_CREATED_AT)) {
            $criteria->add(DataTableMap::COL_VERSION_CREATED_AT, $this->version_created_at);
        }
        if ($this->isColumnModified(DataTableMap::COL_VERSION_CREATED_BY)) {
            $criteria->add(DataTableMap::COL_VERSION_CREATED_BY, $this->version_created_by);
        }
        if ($this->isColumnModified(DataTableMap::COL_VERSION_COMMENT)) {
            $criteria->add(DataTableMap::COL_VERSION_COMMENT, $this->version_comment);
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
        $criteria = ChildDataQuery::create();
        $criteria->add(DataTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Data (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setForcontribution($this->getForcontribution());
        $copyObj->setFortemplatefield($this->getFortemplatefield());
        $copyObj->setContent($this->getContent());
        $copyObj->setIsjson($this->getIsjson());
        $copyObj->setUserSys($this->getUserSys());
        $copyObj->setConfigSys($this->getConfigSys());
        $copyObj->setSplit($this->getSplit());
        $copyObj->setParentnode($this->getParentnode());
        $copyObj->setSort($this->getSort());
        $copyObj->setVersion($this->getVersion());
        $copyObj->setVersionCreatedAt($this->getVersionCreatedAt());
        $copyObj->setVersionCreatedBy($this->getVersionCreatedBy());
        $copyObj->setVersionComment($this->getVersionComment());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getRDataDatasRelatedBySource() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRDataDataRelatedBySource($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRDataDatasRelatedByTarget() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRDataDataRelatedByTarget($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRDataContributions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRDataContribution($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRDataBooks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRDataBook($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRDataFormats() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRDataFormat($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRDataIssues() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRDataIssue($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getRDataTemplates() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRDataTemplate($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDataVersions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDataVersion($relObj->copy($deepCopy));
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
     * @return \Data Clone of current object.
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
     * @return $this|\Data The current object (for fluent API support)
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
            $v->addData($this);
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
                $this->auserSysRef->addDatas($this);
             */
        }

        return $this->auserSysRef;
    }

    /**
     * Declares an association between this object and a ChildContributions object.
     *
     * @param  ChildContributions $v
     * @return $this|\Data The current object (for fluent API support)
     * @throws PropelException
     */
    public function setContributions(ChildContributions $v = null)
    {
        if ($v === null) {
            $this->setForcontribution(NULL);
        } else {
            $this->setForcontribution($v->getId());
        }

        $this->aContributions = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildContributions object, it will not be re-added.
        if ($v !== null) {
            $v->addData($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildContributions object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildContributions The associated ChildContributions object.
     * @throws PropelException
     */
    public function getContributions(ConnectionInterface $con = null)
    {
        if ($this->aContributions === null && ($this->_forcontribution != 0)) {
            $this->aContributions = ChildContributionsQuery::create()->findPk($this->_forcontribution, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aContributions->addDatas($this);
             */
        }

        return $this->aContributions;
    }

    /**
     * Declares an association between this object and a ChildTemplates object.
     *
     * @param  ChildTemplates $v
     * @return $this|\Data The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTemplates(ChildTemplates $v = null)
    {
        if ($v === null) {
            $this->setFortemplatefield(NULL);
        } else {
            $this->setFortemplatefield($v->getId());
        }

        $this->aTemplates = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildTemplates object, it will not be re-added.
        if ($v !== null) {
            $v->addData($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildTemplates object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildTemplates The associated ChildTemplates object.
     * @throws PropelException
     */
    public function getTemplates(ConnectionInterface $con = null)
    {
        if ($this->aTemplates === null && ($this->_fortemplatefield != 0)) {
            $this->aTemplates = ChildTemplatesQuery::create()->findPk($this->_fortemplatefield, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aTemplates->addDatas($this);
             */
        }

        return $this->aTemplates;
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
        if ('RDataDataRelatedBySource' == $relationName) {
            $this->initRDataDatasRelatedBySource();
            return;
        }
        if ('RDataDataRelatedByTarget' == $relationName) {
            $this->initRDataDatasRelatedByTarget();
            return;
        }
        if ('RDataContribution' == $relationName) {
            $this->initRDataContributions();
            return;
        }
        if ('RDataBook' == $relationName) {
            $this->initRDataBooks();
            return;
        }
        if ('RDataFormat' == $relationName) {
            $this->initRDataFormats();
            return;
        }
        if ('RDataIssue' == $relationName) {
            $this->initRDataIssues();
            return;
        }
        if ('RDataTemplate' == $relationName) {
            $this->initRDataTemplates();
            return;
        }
        if ('DataVersion' == $relationName) {
            $this->initDataVersions();
            return;
        }
    }

    /**
     * Clears out the collRDataDatasRelatedBySource collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRDataDatasRelatedBySource()
     */
    public function clearRDataDatasRelatedBySource()
    {
        $this->collRDataDatasRelatedBySource = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRDataDatasRelatedBySource collection loaded partially.
     */
    public function resetPartialRDataDatasRelatedBySource($v = true)
    {
        $this->collRDataDatasRelatedBySourcePartial = $v;
    }

    /**
     * Initializes the collRDataDatasRelatedBySource collection.
     *
     * By default this just sets the collRDataDatasRelatedBySource collection to an empty array (like clearcollRDataDatasRelatedBySource());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRDataDatasRelatedBySource($overrideExisting = true)
    {
        if (null !== $this->collRDataDatasRelatedBySource && !$overrideExisting) {
            return;
        }

        $collectionClassName = RDataDataTableMap::getTableMap()->getCollectionClassName();

        $this->collRDataDatasRelatedBySource = new $collectionClassName;
        $this->collRDataDatasRelatedBySource->setModel('\RDataData');
    }

    /**
     * Gets an array of ChildRDataData objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildData is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRDataData[] List of ChildRDataData objects
     * @throws PropelException
     */
    public function getRDataDatasRelatedBySource(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRDataDatasRelatedBySourcePartial && !$this->isNew();
        if (null === $this->collRDataDatasRelatedBySource || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRDataDatasRelatedBySource) {
                // return empty collection
                $this->initRDataDatasRelatedBySource();
            } else {
                $collRDataDatasRelatedBySource = ChildRDataDataQuery::create(null, $criteria)
                    ->filterByRDataSrc($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRDataDatasRelatedBySourcePartial && count($collRDataDatasRelatedBySource)) {
                        $this->initRDataDatasRelatedBySource(false);

                        foreach ($collRDataDatasRelatedBySource as $obj) {
                            if (false == $this->collRDataDatasRelatedBySource->contains($obj)) {
                                $this->collRDataDatasRelatedBySource->append($obj);
                            }
                        }

                        $this->collRDataDatasRelatedBySourcePartial = true;
                    }

                    return $collRDataDatasRelatedBySource;
                }

                if ($partial && $this->collRDataDatasRelatedBySource) {
                    foreach ($this->collRDataDatasRelatedBySource as $obj) {
                        if ($obj->isNew()) {
                            $collRDataDatasRelatedBySource[] = $obj;
                        }
                    }
                }

                $this->collRDataDatasRelatedBySource = $collRDataDatasRelatedBySource;
                $this->collRDataDatasRelatedBySourcePartial = false;
            }
        }

        return $this->collRDataDatasRelatedBySource;
    }

    /**
     * Sets a collection of ChildRDataData objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rDataDatasRelatedBySource A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildData The current object (for fluent API support)
     */
    public function setRDataDatasRelatedBySource(Collection $rDataDatasRelatedBySource, ConnectionInterface $con = null)
    {
        /** @var ChildRDataData[] $rDataDatasRelatedBySourceToDelete */
        $rDataDatasRelatedBySourceToDelete = $this->getRDataDatasRelatedBySource(new Criteria(), $con)->diff($rDataDatasRelatedBySource);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rDataDatasRelatedBySourceScheduledForDeletion = clone $rDataDatasRelatedBySourceToDelete;

        foreach ($rDataDatasRelatedBySourceToDelete as $rDataDataRelatedBySourceRemoved) {
            $rDataDataRelatedBySourceRemoved->setRDataSrc(null);
        }

        $this->collRDataDatasRelatedBySource = null;
        foreach ($rDataDatasRelatedBySource as $rDataDataRelatedBySource) {
            $this->addRDataDataRelatedBySource($rDataDataRelatedBySource);
        }

        $this->collRDataDatasRelatedBySource = $rDataDatasRelatedBySource;
        $this->collRDataDatasRelatedBySourcePartial = false;

        return $this;
    }

    /**
     * Returns the number of related RDataData objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RDataData objects.
     * @throws PropelException
     */
    public function countRDataDatasRelatedBySource(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRDataDatasRelatedBySourcePartial && !$this->isNew();
        if (null === $this->collRDataDatasRelatedBySource || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRDataDatasRelatedBySource) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRDataDatasRelatedBySource());
            }

            $query = ChildRDataDataQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRDataSrc($this)
                ->count($con);
        }

        return count($this->collRDataDatasRelatedBySource);
    }

    /**
     * Method called to associate a ChildRDataData object to this object
     * through the ChildRDataData foreign key attribute.
     *
     * @param  ChildRDataData $l ChildRDataData
     * @return $this|\Data The current object (for fluent API support)
     */
    public function addRDataDataRelatedBySource(ChildRDataData $l)
    {
        if ($this->collRDataDatasRelatedBySource === null) {
            $this->initRDataDatasRelatedBySource();
            $this->collRDataDatasRelatedBySourcePartial = true;
        }

        if (!$this->collRDataDatasRelatedBySource->contains($l)) {
            $this->doAddRDataDataRelatedBySource($l);

            if ($this->rDataDatasRelatedBySourceScheduledForDeletion and $this->rDataDatasRelatedBySourceScheduledForDeletion->contains($l)) {
                $this->rDataDatasRelatedBySourceScheduledForDeletion->remove($this->rDataDatasRelatedBySourceScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRDataData $rDataDataRelatedBySource The ChildRDataData object to add.
     */
    protected function doAddRDataDataRelatedBySource(ChildRDataData $rDataDataRelatedBySource)
    {
        $this->collRDataDatasRelatedBySource[]= $rDataDataRelatedBySource;
        $rDataDataRelatedBySource->setRDataSrc($this);
    }

    /**
     * @param  ChildRDataData $rDataDataRelatedBySource The ChildRDataData object to remove.
     * @return $this|ChildData The current object (for fluent API support)
     */
    public function removeRDataDataRelatedBySource(ChildRDataData $rDataDataRelatedBySource)
    {
        if ($this->getRDataDatasRelatedBySource()->contains($rDataDataRelatedBySource)) {
            $pos = $this->collRDataDatasRelatedBySource->search($rDataDataRelatedBySource);
            $this->collRDataDatasRelatedBySource->remove($pos);
            if (null === $this->rDataDatasRelatedBySourceScheduledForDeletion) {
                $this->rDataDatasRelatedBySourceScheduledForDeletion = clone $this->collRDataDatasRelatedBySource;
                $this->rDataDatasRelatedBySourceScheduledForDeletion->clear();
            }
            $this->rDataDatasRelatedBySourceScheduledForDeletion[]= clone $rDataDataRelatedBySource;
            $rDataDataRelatedBySource->setRDataSrc(null);
        }

        return $this;
    }

    /**
     * Clears out the collRDataDatasRelatedByTarget collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRDataDatasRelatedByTarget()
     */
    public function clearRDataDatasRelatedByTarget()
    {
        $this->collRDataDatasRelatedByTarget = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRDataDatasRelatedByTarget collection loaded partially.
     */
    public function resetPartialRDataDatasRelatedByTarget($v = true)
    {
        $this->collRDataDatasRelatedByTargetPartial = $v;
    }

    /**
     * Initializes the collRDataDatasRelatedByTarget collection.
     *
     * By default this just sets the collRDataDatasRelatedByTarget collection to an empty array (like clearcollRDataDatasRelatedByTarget());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRDataDatasRelatedByTarget($overrideExisting = true)
    {
        if (null !== $this->collRDataDatasRelatedByTarget && !$overrideExisting) {
            return;
        }

        $collectionClassName = RDataDataTableMap::getTableMap()->getCollectionClassName();

        $this->collRDataDatasRelatedByTarget = new $collectionClassName;
        $this->collRDataDatasRelatedByTarget->setModel('\RDataData');
    }

    /**
     * Gets an array of ChildRDataData objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildData is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRDataData[] List of ChildRDataData objects
     * @throws PropelException
     */
    public function getRDataDatasRelatedByTarget(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRDataDatasRelatedByTargetPartial && !$this->isNew();
        if (null === $this->collRDataDatasRelatedByTarget || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRDataDatasRelatedByTarget) {
                // return empty collection
                $this->initRDataDatasRelatedByTarget();
            } else {
                $collRDataDatasRelatedByTarget = ChildRDataDataQuery::create(null, $criteria)
                    ->filterByRDataRef($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRDataDatasRelatedByTargetPartial && count($collRDataDatasRelatedByTarget)) {
                        $this->initRDataDatasRelatedByTarget(false);

                        foreach ($collRDataDatasRelatedByTarget as $obj) {
                            if (false == $this->collRDataDatasRelatedByTarget->contains($obj)) {
                                $this->collRDataDatasRelatedByTarget->append($obj);
                            }
                        }

                        $this->collRDataDatasRelatedByTargetPartial = true;
                    }

                    return $collRDataDatasRelatedByTarget;
                }

                if ($partial && $this->collRDataDatasRelatedByTarget) {
                    foreach ($this->collRDataDatasRelatedByTarget as $obj) {
                        if ($obj->isNew()) {
                            $collRDataDatasRelatedByTarget[] = $obj;
                        }
                    }
                }

                $this->collRDataDatasRelatedByTarget = $collRDataDatasRelatedByTarget;
                $this->collRDataDatasRelatedByTargetPartial = false;
            }
        }

        return $this->collRDataDatasRelatedByTarget;
    }

    /**
     * Sets a collection of ChildRDataData objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rDataDatasRelatedByTarget A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildData The current object (for fluent API support)
     */
    public function setRDataDatasRelatedByTarget(Collection $rDataDatasRelatedByTarget, ConnectionInterface $con = null)
    {
        /** @var ChildRDataData[] $rDataDatasRelatedByTargetToDelete */
        $rDataDatasRelatedByTargetToDelete = $this->getRDataDatasRelatedByTarget(new Criteria(), $con)->diff($rDataDatasRelatedByTarget);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rDataDatasRelatedByTargetScheduledForDeletion = clone $rDataDatasRelatedByTargetToDelete;

        foreach ($rDataDatasRelatedByTargetToDelete as $rDataDataRelatedByTargetRemoved) {
            $rDataDataRelatedByTargetRemoved->setRDataRef(null);
        }

        $this->collRDataDatasRelatedByTarget = null;
        foreach ($rDataDatasRelatedByTarget as $rDataDataRelatedByTarget) {
            $this->addRDataDataRelatedByTarget($rDataDataRelatedByTarget);
        }

        $this->collRDataDatasRelatedByTarget = $rDataDatasRelatedByTarget;
        $this->collRDataDatasRelatedByTargetPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RDataData objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RDataData objects.
     * @throws PropelException
     */
    public function countRDataDatasRelatedByTarget(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRDataDatasRelatedByTargetPartial && !$this->isNew();
        if (null === $this->collRDataDatasRelatedByTarget || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRDataDatasRelatedByTarget) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRDataDatasRelatedByTarget());
            }

            $query = ChildRDataDataQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRDataRef($this)
                ->count($con);
        }

        return count($this->collRDataDatasRelatedByTarget);
    }

    /**
     * Method called to associate a ChildRDataData object to this object
     * through the ChildRDataData foreign key attribute.
     *
     * @param  ChildRDataData $l ChildRDataData
     * @return $this|\Data The current object (for fluent API support)
     */
    public function addRDataDataRelatedByTarget(ChildRDataData $l)
    {
        if ($this->collRDataDatasRelatedByTarget === null) {
            $this->initRDataDatasRelatedByTarget();
            $this->collRDataDatasRelatedByTargetPartial = true;
        }

        if (!$this->collRDataDatasRelatedByTarget->contains($l)) {
            $this->doAddRDataDataRelatedByTarget($l);

            if ($this->rDataDatasRelatedByTargetScheduledForDeletion and $this->rDataDatasRelatedByTargetScheduledForDeletion->contains($l)) {
                $this->rDataDatasRelatedByTargetScheduledForDeletion->remove($this->rDataDatasRelatedByTargetScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRDataData $rDataDataRelatedByTarget The ChildRDataData object to add.
     */
    protected function doAddRDataDataRelatedByTarget(ChildRDataData $rDataDataRelatedByTarget)
    {
        $this->collRDataDatasRelatedByTarget[]= $rDataDataRelatedByTarget;
        $rDataDataRelatedByTarget->setRDataRef($this);
    }

    /**
     * @param  ChildRDataData $rDataDataRelatedByTarget The ChildRDataData object to remove.
     * @return $this|ChildData The current object (for fluent API support)
     */
    public function removeRDataDataRelatedByTarget(ChildRDataData $rDataDataRelatedByTarget)
    {
        if ($this->getRDataDatasRelatedByTarget()->contains($rDataDataRelatedByTarget)) {
            $pos = $this->collRDataDatasRelatedByTarget->search($rDataDataRelatedByTarget);
            $this->collRDataDatasRelatedByTarget->remove($pos);
            if (null === $this->rDataDatasRelatedByTargetScheduledForDeletion) {
                $this->rDataDatasRelatedByTargetScheduledForDeletion = clone $this->collRDataDatasRelatedByTarget;
                $this->rDataDatasRelatedByTargetScheduledForDeletion->clear();
            }
            $this->rDataDatasRelatedByTargetScheduledForDeletion[]= clone $rDataDataRelatedByTarget;
            $rDataDataRelatedByTarget->setRDataRef(null);
        }

        return $this;
    }

    /**
     * Clears out the collRDataContributions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRDataContributions()
     */
    public function clearRDataContributions()
    {
        $this->collRDataContributions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRDataContributions collection loaded partially.
     */
    public function resetPartialRDataContributions($v = true)
    {
        $this->collRDataContributionsPartial = $v;
    }

    /**
     * Initializes the collRDataContributions collection.
     *
     * By default this just sets the collRDataContributions collection to an empty array (like clearcollRDataContributions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRDataContributions($overrideExisting = true)
    {
        if (null !== $this->collRDataContributions && !$overrideExisting) {
            return;
        }

        $collectionClassName = RDataContributionTableMap::getTableMap()->getCollectionClassName();

        $this->collRDataContributions = new $collectionClassName;
        $this->collRDataContributions->setModel('\RDataContribution');
    }

    /**
     * Gets an array of ChildRDataContribution objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildData is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRDataContribution[] List of ChildRDataContribution objects
     * @throws PropelException
     */
    public function getRDataContributions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRDataContributionsPartial && !$this->isNew();
        if (null === $this->collRDataContributions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRDataContributions) {
                // return empty collection
                $this->initRDataContributions();
            } else {
                $collRDataContributions = ChildRDataContributionQuery::create(null, $criteria)
                    ->filterByRData($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRDataContributionsPartial && count($collRDataContributions)) {
                        $this->initRDataContributions(false);

                        foreach ($collRDataContributions as $obj) {
                            if (false == $this->collRDataContributions->contains($obj)) {
                                $this->collRDataContributions->append($obj);
                            }
                        }

                        $this->collRDataContributionsPartial = true;
                    }

                    return $collRDataContributions;
                }

                if ($partial && $this->collRDataContributions) {
                    foreach ($this->collRDataContributions as $obj) {
                        if ($obj->isNew()) {
                            $collRDataContributions[] = $obj;
                        }
                    }
                }

                $this->collRDataContributions = $collRDataContributions;
                $this->collRDataContributionsPartial = false;
            }
        }

        return $this->collRDataContributions;
    }

    /**
     * Sets a collection of ChildRDataContribution objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rDataContributions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildData The current object (for fluent API support)
     */
    public function setRDataContributions(Collection $rDataContributions, ConnectionInterface $con = null)
    {
        /** @var ChildRDataContribution[] $rDataContributionsToDelete */
        $rDataContributionsToDelete = $this->getRDataContributions(new Criteria(), $con)->diff($rDataContributions);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rDataContributionsScheduledForDeletion = clone $rDataContributionsToDelete;

        foreach ($rDataContributionsToDelete as $rDataContributionRemoved) {
            $rDataContributionRemoved->setRData(null);
        }

        $this->collRDataContributions = null;
        foreach ($rDataContributions as $rDataContribution) {
            $this->addRDataContribution($rDataContribution);
        }

        $this->collRDataContributions = $rDataContributions;
        $this->collRDataContributionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RDataContribution objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RDataContribution objects.
     * @throws PropelException
     */
    public function countRDataContributions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRDataContributionsPartial && !$this->isNew();
        if (null === $this->collRDataContributions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRDataContributions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRDataContributions());
            }

            $query = ChildRDataContributionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRData($this)
                ->count($con);
        }

        return count($this->collRDataContributions);
    }

    /**
     * Method called to associate a ChildRDataContribution object to this object
     * through the ChildRDataContribution foreign key attribute.
     *
     * @param  ChildRDataContribution $l ChildRDataContribution
     * @return $this|\Data The current object (for fluent API support)
     */
    public function addRDataContribution(ChildRDataContribution $l)
    {
        if ($this->collRDataContributions === null) {
            $this->initRDataContributions();
            $this->collRDataContributionsPartial = true;
        }

        if (!$this->collRDataContributions->contains($l)) {
            $this->doAddRDataContribution($l);

            if ($this->rDataContributionsScheduledForDeletion and $this->rDataContributionsScheduledForDeletion->contains($l)) {
                $this->rDataContributionsScheduledForDeletion->remove($this->rDataContributionsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRDataContribution $rDataContribution The ChildRDataContribution object to add.
     */
    protected function doAddRDataContribution(ChildRDataContribution $rDataContribution)
    {
        $this->collRDataContributions[]= $rDataContribution;
        $rDataContribution->setRData($this);
    }

    /**
     * @param  ChildRDataContribution $rDataContribution The ChildRDataContribution object to remove.
     * @return $this|ChildData The current object (for fluent API support)
     */
    public function removeRDataContribution(ChildRDataContribution $rDataContribution)
    {
        if ($this->getRDataContributions()->contains($rDataContribution)) {
            $pos = $this->collRDataContributions->search($rDataContribution);
            $this->collRDataContributions->remove($pos);
            if (null === $this->rDataContributionsScheduledForDeletion) {
                $this->rDataContributionsScheduledForDeletion = clone $this->collRDataContributions;
                $this->rDataContributionsScheduledForDeletion->clear();
            }
            $this->rDataContributionsScheduledForDeletion[]= clone $rDataContribution;
            $rDataContribution->setRData(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Data is new, it will return
     * an empty collection; or if this Data has previously
     * been saved, it will retrieve related RDataContributions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Data.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRDataContribution[] List of ChildRDataContribution objects
     */
    public function getRDataContributionsJoinRContribution(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRDataContributionQuery::create(null, $criteria);
        $query->joinWith('RContribution', $joinBehavior);

        return $this->getRDataContributions($query, $con);
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
     * If this ChildData is new, it will return
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
                    ->filterByRData($this)
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
     * @return $this|ChildData The current object (for fluent API support)
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
            $rDataBookRemoved->setRData(null);
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
                ->filterByRData($this)
                ->count($con);
        }

        return count($this->collRDataBooks);
    }

    /**
     * Method called to associate a ChildRDataBook object to this object
     * through the ChildRDataBook foreign key attribute.
     *
     * @param  ChildRDataBook $l ChildRDataBook
     * @return $this|\Data The current object (for fluent API support)
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
        $rDataBook->setRData($this);
    }

    /**
     * @param  ChildRDataBook $rDataBook The ChildRDataBook object to remove.
     * @return $this|ChildData The current object (for fluent API support)
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
            $rDataBook->setRData(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Data is new, it will return
     * an empty collection; or if this Data has previously
     * been saved, it will retrieve related RDataBooks from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Data.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRDataBook[] List of ChildRDataBook objects
     */
    public function getRDataBooksJoinRBook(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRDataBookQuery::create(null, $criteria);
        $query->joinWith('RBook', $joinBehavior);

        return $this->getRDataBooks($query, $con);
    }

    /**
     * Clears out the collRDataFormats collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRDataFormats()
     */
    public function clearRDataFormats()
    {
        $this->collRDataFormats = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRDataFormats collection loaded partially.
     */
    public function resetPartialRDataFormats($v = true)
    {
        $this->collRDataFormatsPartial = $v;
    }

    /**
     * Initializes the collRDataFormats collection.
     *
     * By default this just sets the collRDataFormats collection to an empty array (like clearcollRDataFormats());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRDataFormats($overrideExisting = true)
    {
        if (null !== $this->collRDataFormats && !$overrideExisting) {
            return;
        }

        $collectionClassName = RDataFormatTableMap::getTableMap()->getCollectionClassName();

        $this->collRDataFormats = new $collectionClassName;
        $this->collRDataFormats->setModel('\RDataFormat');
    }

    /**
     * Gets an array of ChildRDataFormat objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildData is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRDataFormat[] List of ChildRDataFormat objects
     * @throws PropelException
     */
    public function getRDataFormats(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRDataFormatsPartial && !$this->isNew();
        if (null === $this->collRDataFormats || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRDataFormats) {
                // return empty collection
                $this->initRDataFormats();
            } else {
                $collRDataFormats = ChildRDataFormatQuery::create(null, $criteria)
                    ->filterByRData($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRDataFormatsPartial && count($collRDataFormats)) {
                        $this->initRDataFormats(false);

                        foreach ($collRDataFormats as $obj) {
                            if (false == $this->collRDataFormats->contains($obj)) {
                                $this->collRDataFormats->append($obj);
                            }
                        }

                        $this->collRDataFormatsPartial = true;
                    }

                    return $collRDataFormats;
                }

                if ($partial && $this->collRDataFormats) {
                    foreach ($this->collRDataFormats as $obj) {
                        if ($obj->isNew()) {
                            $collRDataFormats[] = $obj;
                        }
                    }
                }

                $this->collRDataFormats = $collRDataFormats;
                $this->collRDataFormatsPartial = false;
            }
        }

        return $this->collRDataFormats;
    }

    /**
     * Sets a collection of ChildRDataFormat objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rDataFormats A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildData The current object (for fluent API support)
     */
    public function setRDataFormats(Collection $rDataFormats, ConnectionInterface $con = null)
    {
        /** @var ChildRDataFormat[] $rDataFormatsToDelete */
        $rDataFormatsToDelete = $this->getRDataFormats(new Criteria(), $con)->diff($rDataFormats);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rDataFormatsScheduledForDeletion = clone $rDataFormatsToDelete;

        foreach ($rDataFormatsToDelete as $rDataFormatRemoved) {
            $rDataFormatRemoved->setRData(null);
        }

        $this->collRDataFormats = null;
        foreach ($rDataFormats as $rDataFormat) {
            $this->addRDataFormat($rDataFormat);
        }

        $this->collRDataFormats = $rDataFormats;
        $this->collRDataFormatsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RDataFormat objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RDataFormat objects.
     * @throws PropelException
     */
    public function countRDataFormats(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRDataFormatsPartial && !$this->isNew();
        if (null === $this->collRDataFormats || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRDataFormats) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRDataFormats());
            }

            $query = ChildRDataFormatQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRData($this)
                ->count($con);
        }

        return count($this->collRDataFormats);
    }

    /**
     * Method called to associate a ChildRDataFormat object to this object
     * through the ChildRDataFormat foreign key attribute.
     *
     * @param  ChildRDataFormat $l ChildRDataFormat
     * @return $this|\Data The current object (for fluent API support)
     */
    public function addRDataFormat(ChildRDataFormat $l)
    {
        if ($this->collRDataFormats === null) {
            $this->initRDataFormats();
            $this->collRDataFormatsPartial = true;
        }

        if (!$this->collRDataFormats->contains($l)) {
            $this->doAddRDataFormat($l);

            if ($this->rDataFormatsScheduledForDeletion and $this->rDataFormatsScheduledForDeletion->contains($l)) {
                $this->rDataFormatsScheduledForDeletion->remove($this->rDataFormatsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRDataFormat $rDataFormat The ChildRDataFormat object to add.
     */
    protected function doAddRDataFormat(ChildRDataFormat $rDataFormat)
    {
        $this->collRDataFormats[]= $rDataFormat;
        $rDataFormat->setRData($this);
    }

    /**
     * @param  ChildRDataFormat $rDataFormat The ChildRDataFormat object to remove.
     * @return $this|ChildData The current object (for fluent API support)
     */
    public function removeRDataFormat(ChildRDataFormat $rDataFormat)
    {
        if ($this->getRDataFormats()->contains($rDataFormat)) {
            $pos = $this->collRDataFormats->search($rDataFormat);
            $this->collRDataFormats->remove($pos);
            if (null === $this->rDataFormatsScheduledForDeletion) {
                $this->rDataFormatsScheduledForDeletion = clone $this->collRDataFormats;
                $this->rDataFormatsScheduledForDeletion->clear();
            }
            $this->rDataFormatsScheduledForDeletion[]= clone $rDataFormat;
            $rDataFormat->setRData(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Data is new, it will return
     * an empty collection; or if this Data has previously
     * been saved, it will retrieve related RDataFormats from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Data.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRDataFormat[] List of ChildRDataFormat objects
     */
    public function getRDataFormatsJoinRFormat(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRDataFormatQuery::create(null, $criteria);
        $query->joinWith('RFormat', $joinBehavior);

        return $this->getRDataFormats($query, $con);
    }

    /**
     * Clears out the collRDataIssues collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRDataIssues()
     */
    public function clearRDataIssues()
    {
        $this->collRDataIssues = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRDataIssues collection loaded partially.
     */
    public function resetPartialRDataIssues($v = true)
    {
        $this->collRDataIssuesPartial = $v;
    }

    /**
     * Initializes the collRDataIssues collection.
     *
     * By default this just sets the collRDataIssues collection to an empty array (like clearcollRDataIssues());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRDataIssues($overrideExisting = true)
    {
        if (null !== $this->collRDataIssues && !$overrideExisting) {
            return;
        }

        $collectionClassName = RDataIssueTableMap::getTableMap()->getCollectionClassName();

        $this->collRDataIssues = new $collectionClassName;
        $this->collRDataIssues->setModel('\RDataIssue');
    }

    /**
     * Gets an array of ChildRDataIssue objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildData is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRDataIssue[] List of ChildRDataIssue objects
     * @throws PropelException
     */
    public function getRDataIssues(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRDataIssuesPartial && !$this->isNew();
        if (null === $this->collRDataIssues || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRDataIssues) {
                // return empty collection
                $this->initRDataIssues();
            } else {
                $collRDataIssues = ChildRDataIssueQuery::create(null, $criteria)
                    ->filterByRData($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRDataIssuesPartial && count($collRDataIssues)) {
                        $this->initRDataIssues(false);

                        foreach ($collRDataIssues as $obj) {
                            if (false == $this->collRDataIssues->contains($obj)) {
                                $this->collRDataIssues->append($obj);
                            }
                        }

                        $this->collRDataIssuesPartial = true;
                    }

                    return $collRDataIssues;
                }

                if ($partial && $this->collRDataIssues) {
                    foreach ($this->collRDataIssues as $obj) {
                        if ($obj->isNew()) {
                            $collRDataIssues[] = $obj;
                        }
                    }
                }

                $this->collRDataIssues = $collRDataIssues;
                $this->collRDataIssuesPartial = false;
            }
        }

        return $this->collRDataIssues;
    }

    /**
     * Sets a collection of ChildRDataIssue objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $rDataIssues A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildData The current object (for fluent API support)
     */
    public function setRDataIssues(Collection $rDataIssues, ConnectionInterface $con = null)
    {
        /** @var ChildRDataIssue[] $rDataIssuesToDelete */
        $rDataIssuesToDelete = $this->getRDataIssues(new Criteria(), $con)->diff($rDataIssues);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->rDataIssuesScheduledForDeletion = clone $rDataIssuesToDelete;

        foreach ($rDataIssuesToDelete as $rDataIssueRemoved) {
            $rDataIssueRemoved->setRData(null);
        }

        $this->collRDataIssues = null;
        foreach ($rDataIssues as $rDataIssue) {
            $this->addRDataIssue($rDataIssue);
        }

        $this->collRDataIssues = $rDataIssues;
        $this->collRDataIssuesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RDataIssue objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RDataIssue objects.
     * @throws PropelException
     */
    public function countRDataIssues(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRDataIssuesPartial && !$this->isNew();
        if (null === $this->collRDataIssues || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRDataIssues) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRDataIssues());
            }

            $query = ChildRDataIssueQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRData($this)
                ->count($con);
        }

        return count($this->collRDataIssues);
    }

    /**
     * Method called to associate a ChildRDataIssue object to this object
     * through the ChildRDataIssue foreign key attribute.
     *
     * @param  ChildRDataIssue $l ChildRDataIssue
     * @return $this|\Data The current object (for fluent API support)
     */
    public function addRDataIssue(ChildRDataIssue $l)
    {
        if ($this->collRDataIssues === null) {
            $this->initRDataIssues();
            $this->collRDataIssuesPartial = true;
        }

        if (!$this->collRDataIssues->contains($l)) {
            $this->doAddRDataIssue($l);

            if ($this->rDataIssuesScheduledForDeletion and $this->rDataIssuesScheduledForDeletion->contains($l)) {
                $this->rDataIssuesScheduledForDeletion->remove($this->rDataIssuesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRDataIssue $rDataIssue The ChildRDataIssue object to add.
     */
    protected function doAddRDataIssue(ChildRDataIssue $rDataIssue)
    {
        $this->collRDataIssues[]= $rDataIssue;
        $rDataIssue->setRData($this);
    }

    /**
     * @param  ChildRDataIssue $rDataIssue The ChildRDataIssue object to remove.
     * @return $this|ChildData The current object (for fluent API support)
     */
    public function removeRDataIssue(ChildRDataIssue $rDataIssue)
    {
        if ($this->getRDataIssues()->contains($rDataIssue)) {
            $pos = $this->collRDataIssues->search($rDataIssue);
            $this->collRDataIssues->remove($pos);
            if (null === $this->rDataIssuesScheduledForDeletion) {
                $this->rDataIssuesScheduledForDeletion = clone $this->collRDataIssues;
                $this->rDataIssuesScheduledForDeletion->clear();
            }
            $this->rDataIssuesScheduledForDeletion[]= clone $rDataIssue;
            $rDataIssue->setRData(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Data is new, it will return
     * an empty collection; or if this Data has previously
     * been saved, it will retrieve related RDataIssues from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Data.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRDataIssue[] List of ChildRDataIssue objects
     */
    public function getRDataIssuesJoinRIssue(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRDataIssueQuery::create(null, $criteria);
        $query->joinWith('RIssue', $joinBehavior);

        return $this->getRDataIssues($query, $con);
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
     * If this ChildData is new, it will return
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
                    ->filterByRData($this)
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
     * @return $this|ChildData The current object (for fluent API support)
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
            $rDataTemplateRemoved->setRData(null);
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
                ->filterByRData($this)
                ->count($con);
        }

        return count($this->collRDataTemplates);
    }

    /**
     * Method called to associate a ChildRDataTemplate object to this object
     * through the ChildRDataTemplate foreign key attribute.
     *
     * @param  ChildRDataTemplate $l ChildRDataTemplate
     * @return $this|\Data The current object (for fluent API support)
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
        $rDataTemplate->setRData($this);
    }

    /**
     * @param  ChildRDataTemplate $rDataTemplate The ChildRDataTemplate object to remove.
     * @return $this|ChildData The current object (for fluent API support)
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
            $rDataTemplate->setRData(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Data is new, it will return
     * an empty collection; or if this Data has previously
     * been saved, it will retrieve related RDataTemplates from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Data.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRDataTemplate[] List of ChildRDataTemplate objects
     */
    public function getRDataTemplatesJoinRTemplate(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRDataTemplateQuery::create(null, $criteria);
        $query->joinWith('RTemplate', $joinBehavior);

        return $this->getRDataTemplates($query, $con);
    }

    /**
     * Clears out the collDataVersions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDataVersions()
     */
    public function clearDataVersions()
    {
        $this->collDataVersions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDataVersions collection loaded partially.
     */
    public function resetPartialDataVersions($v = true)
    {
        $this->collDataVersionsPartial = $v;
    }

    /**
     * Initializes the collDataVersions collection.
     *
     * By default this just sets the collDataVersions collection to an empty array (like clearcollDataVersions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDataVersions($overrideExisting = true)
    {
        if (null !== $this->collDataVersions && !$overrideExisting) {
            return;
        }

        $collectionClassName = DataVersionTableMap::getTableMap()->getCollectionClassName();

        $this->collDataVersions = new $collectionClassName;
        $this->collDataVersions->setModel('\DataVersion');
    }

    /**
     * Gets an array of ChildDataVersion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildData is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDataVersion[] List of ChildDataVersion objects
     * @throws PropelException
     */
    public function getDataVersions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDataVersionsPartial && !$this->isNew();
        if (null === $this->collDataVersions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDataVersions) {
                // return empty collection
                $this->initDataVersions();
            } else {
                $collDataVersions = ChildDataVersionQuery::create(null, $criteria)
                    ->filterByData($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDataVersionsPartial && count($collDataVersions)) {
                        $this->initDataVersions(false);

                        foreach ($collDataVersions as $obj) {
                            if (false == $this->collDataVersions->contains($obj)) {
                                $this->collDataVersions->append($obj);
                            }
                        }

                        $this->collDataVersionsPartial = true;
                    }

                    return $collDataVersions;
                }

                if ($partial && $this->collDataVersions) {
                    foreach ($this->collDataVersions as $obj) {
                        if ($obj->isNew()) {
                            $collDataVersions[] = $obj;
                        }
                    }
                }

                $this->collDataVersions = $collDataVersions;
                $this->collDataVersionsPartial = false;
            }
        }

        return $this->collDataVersions;
    }

    /**
     * Sets a collection of ChildDataVersion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $dataVersions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildData The current object (for fluent API support)
     */
    public function setDataVersions(Collection $dataVersions, ConnectionInterface $con = null)
    {
        /** @var ChildDataVersion[] $dataVersionsToDelete */
        $dataVersionsToDelete = $this->getDataVersions(new Criteria(), $con)->diff($dataVersions);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->dataVersionsScheduledForDeletion = clone $dataVersionsToDelete;

        foreach ($dataVersionsToDelete as $dataVersionRemoved) {
            $dataVersionRemoved->setData(null);
        }

        $this->collDataVersions = null;
        foreach ($dataVersions as $dataVersion) {
            $this->addDataVersion($dataVersion);
        }

        $this->collDataVersions = $dataVersions;
        $this->collDataVersionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related DataVersion objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related DataVersion objects.
     * @throws PropelException
     */
    public function countDataVersions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDataVersionsPartial && !$this->isNew();
        if (null === $this->collDataVersions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDataVersions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDataVersions());
            }

            $query = ChildDataVersionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByData($this)
                ->count($con);
        }

        return count($this->collDataVersions);
    }

    /**
     * Method called to associate a ChildDataVersion object to this object
     * through the ChildDataVersion foreign key attribute.
     *
     * @param  ChildDataVersion $l ChildDataVersion
     * @return $this|\Data The current object (for fluent API support)
     */
    public function addDataVersion(ChildDataVersion $l)
    {
        if ($this->collDataVersions === null) {
            $this->initDataVersions();
            $this->collDataVersionsPartial = true;
        }

        if (!$this->collDataVersions->contains($l)) {
            $this->doAddDataVersion($l);

            if ($this->dataVersionsScheduledForDeletion and $this->dataVersionsScheduledForDeletion->contains($l)) {
                $this->dataVersionsScheduledForDeletion->remove($this->dataVersionsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildDataVersion $dataVersion The ChildDataVersion object to add.
     */
    protected function doAddDataVersion(ChildDataVersion $dataVersion)
    {
        $this->collDataVersions[]= $dataVersion;
        $dataVersion->setData($this);
    }

    /**
     * @param  ChildDataVersion $dataVersion The ChildDataVersion object to remove.
     * @return $this|ChildData The current object (for fluent API support)
     */
    public function removeDataVersion(ChildDataVersion $dataVersion)
    {
        if ($this->getDataVersions()->contains($dataVersion)) {
            $pos = $this->collDataVersions->search($dataVersion);
            $this->collDataVersions->remove($pos);
            if (null === $this->dataVersionsScheduledForDeletion) {
                $this->dataVersionsScheduledForDeletion = clone $this->collDataVersions;
                $this->dataVersionsScheduledForDeletion->clear();
            }
            $this->dataVersionsScheduledForDeletion[]= clone $dataVersion;
            $dataVersion->setData(null);
        }

        return $this;
    }

    /**
     * Clears out the collRDataRefs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRDataRefs()
     */
    public function clearRDataRefs()
    {
        $this->collRDataRefs = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collRDataRefs crossRef collection.
     *
     * By default this just sets the collRDataRefs collection to an empty collection (like clearRDataRefs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initRDataRefs()
    {
        $collectionClassName = RDataDataTableMap::getTableMap()->getCollectionClassName();

        $this->collRDataRefs = new $collectionClassName;
        $this->collRDataRefsPartial = true;
        $this->collRDataRefs->setModel('\Data');
    }

    /**
     * Checks if the collRDataRefs collection is loaded.
     *
     * @return bool
     */
    public function isRDataRefsLoaded()
    {
        return null !== $this->collRDataRefs;
    }

    /**
     * Gets a collection of ChildData objects related by a many-to-many relationship
     * to the current object by way of the R_data_data cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildData is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildData[] List of ChildData objects
     */
    public function getRDataRefs(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRDataRefsPartial && !$this->isNew();
        if (null === $this->collRDataRefs || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collRDataRefs) {
                    $this->initRDataRefs();
                }
            } else {

                $query = ChildDataQuery::create(null, $criteria)
                    ->filterByRDataSrc($this);
                $collRDataRefs = $query->find($con);
                if (null !== $criteria) {
                    return $collRDataRefs;
                }

                if ($partial && $this->collRDataRefs) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collRDataRefs as $obj) {
                        if (!$collRDataRefs->contains($obj)) {
                            $collRDataRefs[] = $obj;
                        }
                    }
                }

                $this->collRDataRefs = $collRDataRefs;
                $this->collRDataRefsPartial = false;
            }
        }

        return $this->collRDataRefs;
    }

    /**
     * Sets a collection of Data objects related by a many-to-many relationship
     * to the current object by way of the R_data_data cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $rDataRefs A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildData The current object (for fluent API support)
     */
    public function setRDataRefs(Collection $rDataRefs, ConnectionInterface $con = null)
    {
        $this->clearRDataRefs();
        $currentRDataRefs = $this->getRDataRefs();

        $rDataRefsScheduledForDeletion = $currentRDataRefs->diff($rDataRefs);

        foreach ($rDataRefsScheduledForDeletion as $toDelete) {
            $this->removeRDataRef($toDelete);
        }

        foreach ($rDataRefs as $rDataRef) {
            if (!$currentRDataRefs->contains($rDataRef)) {
                $this->doAddRDataRef($rDataRef);
            }
        }

        $this->collRDataRefsPartial = false;
        $this->collRDataRefs = $rDataRefs;

        return $this;
    }

    /**
     * Gets the number of Data objects related by a many-to-many relationship
     * to the current object by way of the R_data_data cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Data objects
     */
    public function countRDataRefs(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRDataRefsPartial && !$this->isNew();
        if (null === $this->collRDataRefs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRDataRefs) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getRDataRefs());
                }

                $query = ChildDataQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByRDataSrc($this)
                    ->count($con);
            }
        } else {
            return count($this->collRDataRefs);
        }
    }

    /**
     * Associate a ChildData to this object
     * through the R_data_data cross reference table.
     *
     * @param ChildData $rDataRef
     * @return ChildData The current object (for fluent API support)
     */
    public function addRDataRef(ChildData $rDataRef)
    {
        if ($this->collRDataRefs === null) {
            $this->initRDataRefs();
        }

        if (!$this->getRDataRefs()->contains($rDataRef)) {
            // only add it if the **same** object is not already associated
            $this->collRDataRefs->push($rDataRef);
            $this->doAddRDataRef($rDataRef);
        }

        return $this;
    }

    /**
     *
     * @param ChildData $rDataRef
     */
    protected function doAddRDataRef(ChildData $rDataRef)
    {
        $rDataData = new ChildRDataData();

        $rDataData->setRDataRef($rDataRef);

        $rDataData->setRDataSrc($this);

        $this->addRDataDataRelatedBySource($rDataData);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$rDataRef->isRDataSrcsLoaded()) {
            $rDataRef->initRDataSrcs();
            $rDataRef->getRDataSrcs()->push($this);
        } elseif (!$rDataRef->getRDataSrcs()->contains($this)) {
            $rDataRef->getRDataSrcs()->push($this);
        }

    }

    /**
     * Remove rDataRef of this object
     * through the R_data_data cross reference table.
     *
     * @param ChildData $rDataRef
     * @return ChildData The current object (for fluent API support)
     */
    public function removeRDataRef(ChildData $rDataRef)
    {
        if ($this->getRDataRefs()->contains($rDataRef)) {
            $rDataData = new ChildRDataData();
            $rDataData->setRDataRef($rDataRef);
            if ($rDataRef->isRDataSrcsLoaded()) {
                //remove the back reference if available
                $rDataRef->getRDataSrcs()->removeObject($this);
            }

            $rDataData->setRDataSrc($this);
            $this->removeRDataDataRelatedBySource(clone $rDataData);
            $rDataData->clear();

            $this->collRDataRefs->remove($this->collRDataRefs->search($rDataRef));

            if (null === $this->rDataRefsScheduledForDeletion) {
                $this->rDataRefsScheduledForDeletion = clone $this->collRDataRefs;
                $this->rDataRefsScheduledForDeletion->clear();
            }

            $this->rDataRefsScheduledForDeletion->push($rDataRef);
        }


        return $this;
    }

    /**
     * Clears out the collRDataSrcs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRDataSrcs()
     */
    public function clearRDataSrcs()
    {
        $this->collRDataSrcs = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collRDataSrcs crossRef collection.
     *
     * By default this just sets the collRDataSrcs collection to an empty collection (like clearRDataSrcs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initRDataSrcs()
    {
        $collectionClassName = RDataDataTableMap::getTableMap()->getCollectionClassName();

        $this->collRDataSrcs = new $collectionClassName;
        $this->collRDataSrcsPartial = true;
        $this->collRDataSrcs->setModel('\Data');
    }

    /**
     * Checks if the collRDataSrcs collection is loaded.
     *
     * @return bool
     */
    public function isRDataSrcsLoaded()
    {
        return null !== $this->collRDataSrcs;
    }

    /**
     * Gets a collection of ChildData objects related by a many-to-many relationship
     * to the current object by way of the R_data_data cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildData is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildData[] List of ChildData objects
     */
    public function getRDataSrcs(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRDataSrcsPartial && !$this->isNew();
        if (null === $this->collRDataSrcs || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collRDataSrcs) {
                    $this->initRDataSrcs();
                }
            } else {

                $query = ChildDataQuery::create(null, $criteria)
                    ->filterByRDataRef($this);
                $collRDataSrcs = $query->find($con);
                if (null !== $criteria) {
                    return $collRDataSrcs;
                }

                if ($partial && $this->collRDataSrcs) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collRDataSrcs as $obj) {
                        if (!$collRDataSrcs->contains($obj)) {
                            $collRDataSrcs[] = $obj;
                        }
                    }
                }

                $this->collRDataSrcs = $collRDataSrcs;
                $this->collRDataSrcsPartial = false;
            }
        }

        return $this->collRDataSrcs;
    }

    /**
     * Sets a collection of Data objects related by a many-to-many relationship
     * to the current object by way of the R_data_data cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $rDataSrcs A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildData The current object (for fluent API support)
     */
    public function setRDataSrcs(Collection $rDataSrcs, ConnectionInterface $con = null)
    {
        $this->clearRDataSrcs();
        $currentRDataSrcs = $this->getRDataSrcs();

        $rDataSrcsScheduledForDeletion = $currentRDataSrcs->diff($rDataSrcs);

        foreach ($rDataSrcsScheduledForDeletion as $toDelete) {
            $this->removeRDataSrc($toDelete);
        }

        foreach ($rDataSrcs as $rDataSrc) {
            if (!$currentRDataSrcs->contains($rDataSrc)) {
                $this->doAddRDataSrc($rDataSrc);
            }
        }

        $this->collRDataSrcsPartial = false;
        $this->collRDataSrcs = $rDataSrcs;

        return $this;
    }

    /**
     * Gets the number of Data objects related by a many-to-many relationship
     * to the current object by way of the R_data_data cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Data objects
     */
    public function countRDataSrcs(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRDataSrcsPartial && !$this->isNew();
        if (null === $this->collRDataSrcs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRDataSrcs) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getRDataSrcs());
                }

                $query = ChildDataQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByRDataRef($this)
                    ->count($con);
            }
        } else {
            return count($this->collRDataSrcs);
        }
    }

    /**
     * Associate a ChildData to this object
     * through the R_data_data cross reference table.
     *
     * @param ChildData $rDataSrc
     * @return ChildData The current object (for fluent API support)
     */
    public function addRDataSrc(ChildData $rDataSrc)
    {
        if ($this->collRDataSrcs === null) {
            $this->initRDataSrcs();
        }

        if (!$this->getRDataSrcs()->contains($rDataSrc)) {
            // only add it if the **same** object is not already associated
            $this->collRDataSrcs->push($rDataSrc);
            $this->doAddRDataSrc($rDataSrc);
        }

        return $this;
    }

    /**
     *
     * @param ChildData $rDataSrc
     */
    protected function doAddRDataSrc(ChildData $rDataSrc)
    {
        $rDataData = new ChildRDataData();

        $rDataData->setRDataSrc($rDataSrc);

        $rDataData->setRDataRef($this);

        $this->addRDataDataRelatedByTarget($rDataData);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$rDataSrc->isRDataRefsLoaded()) {
            $rDataSrc->initRDataRefs();
            $rDataSrc->getRDataRefs()->push($this);
        } elseif (!$rDataSrc->getRDataRefs()->contains($this)) {
            $rDataSrc->getRDataRefs()->push($this);
        }

    }

    /**
     * Remove rDataSrc of this object
     * through the R_data_data cross reference table.
     *
     * @param ChildData $rDataSrc
     * @return ChildData The current object (for fluent API support)
     */
    public function removeRDataSrc(ChildData $rDataSrc)
    {
        if ($this->getRDataSrcs()->contains($rDataSrc)) {
            $rDataData = new ChildRDataData();
            $rDataData->setRDataSrc($rDataSrc);
            if ($rDataSrc->isRDataRefsLoaded()) {
                //remove the back reference if available
                $rDataSrc->getRDataRefs()->removeObject($this);
            }

            $rDataData->setRDataRef($this);
            $this->removeRDataDataRelatedByTarget(clone $rDataData);
            $rDataData->clear();

            $this->collRDataSrcs->remove($this->collRDataSrcs->search($rDataSrc));

            if (null === $this->rDataSrcsScheduledForDeletion) {
                $this->rDataSrcsScheduledForDeletion = clone $this->collRDataSrcs;
                $this->rDataSrcsScheduledForDeletion->clear();
            }

            $this->rDataSrcsScheduledForDeletion->push($rDataSrc);
        }


        return $this;
    }

    /**
     * Clears out the collRContributions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRContributions()
     */
    public function clearRContributions()
    {
        $this->collRContributions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collRContributions crossRef collection.
     *
     * By default this just sets the collRContributions collection to an empty collection (like clearRContributions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initRContributions()
    {
        $collectionClassName = RDataContributionTableMap::getTableMap()->getCollectionClassName();

        $this->collRContributions = new $collectionClassName;
        $this->collRContributionsPartial = true;
        $this->collRContributions->setModel('\Contributions');
    }

    /**
     * Checks if the collRContributions collection is loaded.
     *
     * @return bool
     */
    public function isRContributionsLoaded()
    {
        return null !== $this->collRContributions;
    }

    /**
     * Gets a collection of ChildContributions objects related by a many-to-many relationship
     * to the current object by way of the R_data_contribution cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildData is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildContributions[] List of ChildContributions objects
     */
    public function getRContributions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRContributionsPartial && !$this->isNew();
        if (null === $this->collRContributions || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collRContributions) {
                    $this->initRContributions();
                }
            } else {

                $query = ChildContributionsQuery::create(null, $criteria)
                    ->filterByRData($this);
                $collRContributions = $query->find($con);
                if (null !== $criteria) {
                    return $collRContributions;
                }

                if ($partial && $this->collRContributions) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collRContributions as $obj) {
                        if (!$collRContributions->contains($obj)) {
                            $collRContributions[] = $obj;
                        }
                    }
                }

                $this->collRContributions = $collRContributions;
                $this->collRContributionsPartial = false;
            }
        }

        return $this->collRContributions;
    }

    /**
     * Sets a collection of Contributions objects related by a many-to-many relationship
     * to the current object by way of the R_data_contribution cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $rContributions A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildData The current object (for fluent API support)
     */
    public function setRContributions(Collection $rContributions, ConnectionInterface $con = null)
    {
        $this->clearRContributions();
        $currentRContributions = $this->getRContributions();

        $rContributionsScheduledForDeletion = $currentRContributions->diff($rContributions);

        foreach ($rContributionsScheduledForDeletion as $toDelete) {
            $this->removeRContribution($toDelete);
        }

        foreach ($rContributions as $rContribution) {
            if (!$currentRContributions->contains($rContribution)) {
                $this->doAddRContribution($rContribution);
            }
        }

        $this->collRContributionsPartial = false;
        $this->collRContributions = $rContributions;

        return $this;
    }

    /**
     * Gets the number of Contributions objects related by a many-to-many relationship
     * to the current object by way of the R_data_contribution cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Contributions objects
     */
    public function countRContributions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRContributionsPartial && !$this->isNew();
        if (null === $this->collRContributions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRContributions) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getRContributions());
                }

                $query = ChildContributionsQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByRData($this)
                    ->count($con);
            }
        } else {
            return count($this->collRContributions);
        }
    }

    /**
     * Associate a ChildContributions to this object
     * through the R_data_contribution cross reference table.
     *
     * @param ChildContributions $rContribution
     * @return ChildData The current object (for fluent API support)
     */
    public function addRContribution(ChildContributions $rContribution)
    {
        if ($this->collRContributions === null) {
            $this->initRContributions();
        }

        if (!$this->getRContributions()->contains($rContribution)) {
            // only add it if the **same** object is not already associated
            $this->collRContributions->push($rContribution);
            $this->doAddRContribution($rContribution);
        }

        return $this;
    }

    /**
     *
     * @param ChildContributions $rContribution
     */
    protected function doAddRContribution(ChildContributions $rContribution)
    {
        $rDataContribution = new ChildRDataContribution();

        $rDataContribution->setRContribution($rContribution);

        $rDataContribution->setRData($this);

        $this->addRDataContribution($rDataContribution);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$rContribution->isRDatasLoaded()) {
            $rContribution->initRDatas();
            $rContribution->getRDatas()->push($this);
        } elseif (!$rContribution->getRDatas()->contains($this)) {
            $rContribution->getRDatas()->push($this);
        }

    }

    /**
     * Remove rContribution of this object
     * through the R_data_contribution cross reference table.
     *
     * @param ChildContributions $rContribution
     * @return ChildData The current object (for fluent API support)
     */
    public function removeRContribution(ChildContributions $rContribution)
    {
        if ($this->getRContributions()->contains($rContribution)) {
            $rDataContribution = new ChildRDataContribution();
            $rDataContribution->setRContribution($rContribution);
            if ($rContribution->isRDatasLoaded()) {
                //remove the back reference if available
                $rContribution->getRDatas()->removeObject($this);
            }

            $rDataContribution->setRData($this);
            $this->removeRDataContribution(clone $rDataContribution);
            $rDataContribution->clear();

            $this->collRContributions->remove($this->collRContributions->search($rContribution));

            if (null === $this->rContributionsScheduledForDeletion) {
                $this->rContributionsScheduledForDeletion = clone $this->collRContributions;
                $this->rContributionsScheduledForDeletion->clear();
            }

            $this->rContributionsScheduledForDeletion->push($rContribution);
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
        $collectionClassName = RDataBookTableMap::getTableMap()->getCollectionClassName();

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
     * to the current object by way of the R_data_book cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildData is new, it will return
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
                    ->filterByRData($this);
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
     * to the current object by way of the R_data_book cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $rBooks A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildData The current object (for fluent API support)
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
     * to the current object by way of the R_data_book cross-reference table.
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
                    ->filterByRData($this)
                    ->count($con);
            }
        } else {
            return count($this->collRBooks);
        }
    }

    /**
     * Associate a ChildBooks to this object
     * through the R_data_book cross reference table.
     *
     * @param ChildBooks $rBook
     * @return ChildData The current object (for fluent API support)
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
        $rDataBook = new ChildRDataBook();

        $rDataBook->setRBook($rBook);

        $rDataBook->setRData($this);

        $this->addRDataBook($rDataBook);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$rBook->isRDatasLoaded()) {
            $rBook->initRDatas();
            $rBook->getRDatas()->push($this);
        } elseif (!$rBook->getRDatas()->contains($this)) {
            $rBook->getRDatas()->push($this);
        }

    }

    /**
     * Remove rBook of this object
     * through the R_data_book cross reference table.
     *
     * @param ChildBooks $rBook
     * @return ChildData The current object (for fluent API support)
     */
    public function removeRBook(ChildBooks $rBook)
    {
        if ($this->getRBooks()->contains($rBook)) {
            $rDataBook = new ChildRDataBook();
            $rDataBook->setRBook($rBook);
            if ($rBook->isRDatasLoaded()) {
                //remove the back reference if available
                $rBook->getRDatas()->removeObject($this);
            }

            $rDataBook->setRData($this);
            $this->removeRDataBook(clone $rDataBook);
            $rDataBook->clear();

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
        $collectionClassName = RDataFormatTableMap::getTableMap()->getCollectionClassName();

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
     * to the current object by way of the R_data_format cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildData is new, it will return
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
                    ->filterByRData($this);
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
     * to the current object by way of the R_data_format cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $rFormats A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildData The current object (for fluent API support)
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
     * to the current object by way of the R_data_format cross-reference table.
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
                    ->filterByRData($this)
                    ->count($con);
            }
        } else {
            return count($this->collRFormats);
        }
    }

    /**
     * Associate a ChildFormats to this object
     * through the R_data_format cross reference table.
     *
     * @param ChildFormats $rFormat
     * @return ChildData The current object (for fluent API support)
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
        $rDataFormat = new ChildRDataFormat();

        $rDataFormat->setRFormat($rFormat);

        $rDataFormat->setRData($this);

        $this->addRDataFormat($rDataFormat);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$rFormat->isRDatasLoaded()) {
            $rFormat->initRDatas();
            $rFormat->getRDatas()->push($this);
        } elseif (!$rFormat->getRDatas()->contains($this)) {
            $rFormat->getRDatas()->push($this);
        }

    }

    /**
     * Remove rFormat of this object
     * through the R_data_format cross reference table.
     *
     * @param ChildFormats $rFormat
     * @return ChildData The current object (for fluent API support)
     */
    public function removeRFormat(ChildFormats $rFormat)
    {
        if ($this->getRFormats()->contains($rFormat)) {
            $rDataFormat = new ChildRDataFormat();
            $rDataFormat->setRFormat($rFormat);
            if ($rFormat->isRDatasLoaded()) {
                //remove the back reference if available
                $rFormat->getRDatas()->removeObject($this);
            }

            $rDataFormat->setRData($this);
            $this->removeRDataFormat(clone $rDataFormat);
            $rDataFormat->clear();

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
        $collectionClassName = RDataIssueTableMap::getTableMap()->getCollectionClassName();

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
     * to the current object by way of the R_data_issue cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildData is new, it will return
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
                    ->filterByRData($this);
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
     * to the current object by way of the R_data_issue cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $rIssues A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildData The current object (for fluent API support)
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
     * to the current object by way of the R_data_issue cross-reference table.
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
                    ->filterByRData($this)
                    ->count($con);
            }
        } else {
            return count($this->collRIssues);
        }
    }

    /**
     * Associate a ChildIssues to this object
     * through the R_data_issue cross reference table.
     *
     * @param ChildIssues $rIssue
     * @return ChildData The current object (for fluent API support)
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
        $rDataIssue = new ChildRDataIssue();

        $rDataIssue->setRIssue($rIssue);

        $rDataIssue->setRData($this);

        $this->addRDataIssue($rDataIssue);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$rIssue->isRDatasLoaded()) {
            $rIssue->initRDatas();
            $rIssue->getRDatas()->push($this);
        } elseif (!$rIssue->getRDatas()->contains($this)) {
            $rIssue->getRDatas()->push($this);
        }

    }

    /**
     * Remove rIssue of this object
     * through the R_data_issue cross reference table.
     *
     * @param ChildIssues $rIssue
     * @return ChildData The current object (for fluent API support)
     */
    public function removeRIssue(ChildIssues $rIssue)
    {
        if ($this->getRIssues()->contains($rIssue)) {
            $rDataIssue = new ChildRDataIssue();
            $rDataIssue->setRIssue($rIssue);
            if ($rIssue->isRDatasLoaded()) {
                //remove the back reference if available
                $rIssue->getRDatas()->removeObject($this);
            }

            $rDataIssue->setRData($this);
            $this->removeRDataIssue(clone $rDataIssue);
            $rDataIssue->clear();

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
     * Clears out the collRTemplates collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRTemplates()
     */
    public function clearRTemplates()
    {
        $this->collRTemplates = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Initializes the collRTemplates crossRef collection.
     *
     * By default this just sets the collRTemplates collection to an empty collection (like clearRTemplates());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initRTemplates()
    {
        $collectionClassName = RDataTemplateTableMap::getTableMap()->getCollectionClassName();

        $this->collRTemplates = new $collectionClassName;
        $this->collRTemplatesPartial = true;
        $this->collRTemplates->setModel('\Templates');
    }

    /**
     * Checks if the collRTemplates collection is loaded.
     *
     * @return bool
     */
    public function isRTemplatesLoaded()
    {
        return null !== $this->collRTemplates;
    }

    /**
     * Gets a collection of ChildTemplates objects related by a many-to-many relationship
     * to the current object by way of the R_data_template cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildData is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildTemplates[] List of ChildTemplates objects
     */
    public function getRTemplates(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRTemplatesPartial && !$this->isNew();
        if (null === $this->collRTemplates || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collRTemplates) {
                    $this->initRTemplates();
                }
            } else {

                $query = ChildTemplatesQuery::create(null, $criteria)
                    ->filterByRData($this);
                $collRTemplates = $query->find($con);
                if (null !== $criteria) {
                    return $collRTemplates;
                }

                if ($partial && $this->collRTemplates) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collRTemplates as $obj) {
                        if (!$collRTemplates->contains($obj)) {
                            $collRTemplates[] = $obj;
                        }
                    }
                }

                $this->collRTemplates = $collRTemplates;
                $this->collRTemplatesPartial = false;
            }
        }

        return $this->collRTemplates;
    }

    /**
     * Sets a collection of Templates objects related by a many-to-many relationship
     * to the current object by way of the R_data_template cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $rTemplates A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildData The current object (for fluent API support)
     */
    public function setRTemplates(Collection $rTemplates, ConnectionInterface $con = null)
    {
        $this->clearRTemplates();
        $currentRTemplates = $this->getRTemplates();

        $rTemplatesScheduledForDeletion = $currentRTemplates->diff($rTemplates);

        foreach ($rTemplatesScheduledForDeletion as $toDelete) {
            $this->removeRTemplate($toDelete);
        }

        foreach ($rTemplates as $rTemplate) {
            if (!$currentRTemplates->contains($rTemplate)) {
                $this->doAddRTemplate($rTemplate);
            }
        }

        $this->collRTemplatesPartial = false;
        $this->collRTemplates = $rTemplates;

        return $this;
    }

    /**
     * Gets the number of Templates objects related by a many-to-many relationship
     * to the current object by way of the R_data_template cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Templates objects
     */
    public function countRTemplates(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRTemplatesPartial && !$this->isNew();
        if (null === $this->collRTemplates || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRTemplates) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getRTemplates());
                }

                $query = ChildTemplatesQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByRData($this)
                    ->count($con);
            }
        } else {
            return count($this->collRTemplates);
        }
    }

    /**
     * Associate a ChildTemplates to this object
     * through the R_data_template cross reference table.
     *
     * @param ChildTemplates $rTemplate
     * @return ChildData The current object (for fluent API support)
     */
    public function addRTemplate(ChildTemplates $rTemplate)
    {
        if ($this->collRTemplates === null) {
            $this->initRTemplates();
        }

        if (!$this->getRTemplates()->contains($rTemplate)) {
            // only add it if the **same** object is not already associated
            $this->collRTemplates->push($rTemplate);
            $this->doAddRTemplate($rTemplate);
        }

        return $this;
    }

    /**
     *
     * @param ChildTemplates $rTemplate
     */
    protected function doAddRTemplate(ChildTemplates $rTemplate)
    {
        $rDataTemplate = new ChildRDataTemplate();

        $rDataTemplate->setRTemplate($rTemplate);

        $rDataTemplate->setRData($this);

        $this->addRDataTemplate($rDataTemplate);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$rTemplate->isRDatasLoaded()) {
            $rTemplate->initRDatas();
            $rTemplate->getRDatas()->push($this);
        } elseif (!$rTemplate->getRDatas()->contains($this)) {
            $rTemplate->getRDatas()->push($this);
        }

    }

    /**
     * Remove rTemplate of this object
     * through the R_data_template cross reference table.
     *
     * @param ChildTemplates $rTemplate
     * @return ChildData The current object (for fluent API support)
     */
    public function removeRTemplate(ChildTemplates $rTemplate)
    {
        if ($this->getRTemplates()->contains($rTemplate)) {
            $rDataTemplate = new ChildRDataTemplate();
            $rDataTemplate->setRTemplate($rTemplate);
            if ($rTemplate->isRDatasLoaded()) {
                //remove the back reference if available
                $rTemplate->getRDatas()->removeObject($this);
            }

            $rDataTemplate->setRData($this);
            $this->removeRDataTemplate(clone $rDataTemplate);
            $rDataTemplate->clear();

            $this->collRTemplates->remove($this->collRTemplates->search($rTemplate));

            if (null === $this->rTemplatesScheduledForDeletion) {
                $this->rTemplatesScheduledForDeletion = clone $this->collRTemplates;
                $this->rTemplatesScheduledForDeletion->clear();
            }

            $this->rTemplatesScheduledForDeletion->push($rTemplate);
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
            $this->auserSysRef->removeData($this);
        }
        if (null !== $this->aContributions) {
            $this->aContributions->removeData($this);
        }
        if (null !== $this->aTemplates) {
            $this->aTemplates->removeData($this);
        }
        $this->id = null;
        $this->_forcontribution = null;
        $this->_fortemplatefield = null;
        $this->_content = null;
        $this->_isjson = null;
        $this->__user__ = null;
        $this->__config__ = null;
        $this->__split__ = null;
        $this->__parentnode__ = null;
        $this->__sort__ = null;
        $this->version = null;
        $this->version_created_at = null;
        $this->version_created_by = null;
        $this->version_comment = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
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
            if ($this->collRDataDatasRelatedBySource) {
                foreach ($this->collRDataDatasRelatedBySource as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRDataDatasRelatedByTarget) {
                foreach ($this->collRDataDatasRelatedByTarget as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRDataContributions) {
                foreach ($this->collRDataContributions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRDataBooks) {
                foreach ($this->collRDataBooks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRDataFormats) {
                foreach ($this->collRDataFormats as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRDataIssues) {
                foreach ($this->collRDataIssues as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRDataTemplates) {
                foreach ($this->collRDataTemplates as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDataVersions) {
                foreach ($this->collDataVersions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRDataRefs) {
                foreach ($this->collRDataRefs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRDataSrcs) {
                foreach ($this->collRDataSrcs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collRContributions) {
                foreach ($this->collRContributions as $o) {
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
            if ($this->collRTemplates) {
                foreach ($this->collRTemplates as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collRDataDatasRelatedBySource = null;
        $this->collRDataDatasRelatedByTarget = null;
        $this->collRDataContributions = null;
        $this->collRDataBooks = null;
        $this->collRDataFormats = null;
        $this->collRDataIssues = null;
        $this->collRDataTemplates = null;
        $this->collDataVersions = null;
        $this->collRDataRefs = null;
        $this->collRDataSrcs = null;
        $this->collRContributions = null;
        $this->collRBooks = null;
        $this->collRFormats = null;
        $this->collRIssues = null;
        $this->collRTemplates = null;
        $this->auserSysRef = null;
        $this->aContributions = null;
        $this->aTemplates = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(DataTableMap::DEFAULT_STRING_FORMAT);
    }

    // versionable behavior

    /**
     * Enforce a new Version of this object upon next save.
     *
     * @return $this|\Data
     */
    public function enforceVersioning()
    {
        $this->enforceVersion = true;

        return $this;
    }

    /**
     * Checks whether the current state must be recorded as a version
     *
     * @param   ConnectionInterface $con The ConnectionInterface connection to use.
     * @return  boolean
     */
    public function isVersioningNecessary(ConnectionInterface $con = null)
    {
        if ($this->alreadyInSave) {
            return false;
        }

        if ($this->enforceVersion) {
            return true;
        }

        if (ChildDataQuery::isVersioningEnabled() && ($this->isNew() || $this->isModified()) || $this->isDeleted()) {
            return true;
        }
        if (null !== ($object = $this->getContributions($con)) && $object->isVersioningNecessary($con)) {
            return true;
        }


        return false;
    }

    /**
     * Creates a version of the current object and saves it.
     *
     * @param   ConnectionInterface $con The ConnectionInterface connection to use.
     *
     * @return  ChildDataVersion A version object
     */
    public function addVersion(ConnectionInterface $con = null)
    {
        $this->enforceVersion = false;

        $version = new ChildDataVersion();
        $version->setId($this->getId());
        $version->setForcontribution($this->getForcontribution());
        $version->setFortemplatefield($this->getFortemplatefield());
        $version->setContent($this->getContent());
        $version->setIsjson($this->getIsjson());
        $version->setUserSys($this->getUserSys());
        $version->setConfigSys($this->getConfigSys());
        $version->setSplit($this->getSplit());
        $version->setParentnode($this->getParentnode());
        $version->setSort($this->getSort());
        $version->setVersion($this->getVersion());
        $version->setVersionCreatedAt($this->getVersionCreatedAt());
        $version->setVersionCreatedBy($this->getVersionCreatedBy());
        $version->setVersionComment($this->getVersionComment());
        $version->setData($this);
        if (($related = $this->getContributions(null, $con)) && $related->getVersion()) {
            $version->setForcontributionVersion($related->getVersion());
        }
        $version->save($con);

        return $version;
    }

    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param   integer $versionNumber The version number to read
     * @param   ConnectionInterface $con The ConnectionInterface connection to use.
     *
     * @return  $this|ChildData The current object (for fluent API support)
     */
    public function toVersion($versionNumber, ConnectionInterface $con = null)
    {
        $version = $this->getOneVersion($versionNumber, $con);
        if (!$version) {
            throw new PropelException(sprintf('No ChildData object found with version %d', $version));
        }
        $this->populateFromVersion($version, $con);

        return $this;
    }

    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param ChildDataVersion $version The version object to use
     * @param ConnectionInterface   $con the connection to use
     * @param array                 $loadedObjects objects that been loaded in a chain of populateFromVersion calls on referrer or fk objects.
     *
     * @return $this|ChildData The current object (for fluent API support)
     */
    public function populateFromVersion($version, $con = null, &$loadedObjects = array())
    {
        $loadedObjects['ChildData'][$version->getId()][$version->getVersion()] = $this;
        $this->setId($version->getId());
        $this->setForcontribution($version->getForcontribution());
        $this->setFortemplatefield($version->getFortemplatefield());
        $this->setContent($version->getContent());
        $this->setIsjson($version->getIsjson());
        $this->setUserSys($version->getUserSys());
        $this->setConfigSys($version->getConfigSys());
        $this->setSplit($version->getSplit());
        $this->setParentnode($version->getParentnode());
        $this->setSort($version->getSort());
        $this->setVersion($version->getVersion());
        $this->setVersionCreatedAt($version->getVersionCreatedAt());
        $this->setVersionCreatedBy($version->getVersionCreatedBy());
        $this->setVersionComment($version->getVersionComment());
        if ($fkValue = $version->getForcontribution()) {
            if (isset($loadedObjects['ChildContributions']) && isset($loadedObjects['ChildContributions'][$fkValue]) && isset($loadedObjects['ChildContributions'][$fkValue][$version->getForcontributionVersion()])) {
                $related = $loadedObjects['ChildContributions'][$fkValue][$version->getForcontributionVersion()];
            } else {
                $related = new ChildContributions();
                $relatedVersion = ChildContributionsVersionQuery::create()
                    ->filterById($fkValue)
                    ->filterByVersionComment($version->getForcontributionVersion())
                    ->findOne($con);
                $related->populateFromVersion($relatedVersion, $con, $loadedObjects);
                $related->setNew(false);
            }
            $this->setContributions($related);
        }

        return $this;
    }

    /**
     * Gets the latest persisted version number for the current object
     *
     * @param   ConnectionInterface $con The ConnectionInterface connection to use.
     *
     * @return  integer
     */
    public function getLastVersionNumber(ConnectionInterface $con = null)
    {
        $v = ChildDataVersionQuery::create()
            ->filterByData($this)
            ->orderByVersion('desc')
            ->findOne($con);
        if (!$v) {
            return 0;
        }

        return $v->getVersion();
    }

    /**
     * Checks whether the current object is the latest one
     *
     * @param   ConnectionInterface $con The ConnectionInterface connection to use.
     *
     * @return  Boolean
     */
    public function isLastVersion(ConnectionInterface $con = null)
    {
        return $this->getLastVersionNumber($con) == $this->getVersion();
    }

    /**
     * Retrieves a version object for this entity and a version number
     *
     * @param   integer $versionNumber The version number to read
     * @param   ConnectionInterface $con The ConnectionInterface connection to use.
     *
     * @return  ChildDataVersion A version object
     */
    public function getOneVersion($versionNumber, ConnectionInterface $con = null)
    {
        return ChildDataVersionQuery::create()
            ->filterByData($this)
            ->filterByVersion($versionNumber)
            ->findOne($con);
    }

    /**
     * Gets all the versions of this object, in incremental order
     *
     * @param   ConnectionInterface $con The ConnectionInterface connection to use.
     *
     * @return  ObjectCollection|ChildDataVersion[] A list of ChildDataVersion objects
     */
    public function getAllVersions(ConnectionInterface $con = null)
    {
        $criteria = new Criteria();
        $criteria->addAscendingOrderByColumn(DataVersionTableMap::COL_VERSION);

        return $this->getDataVersions($criteria, $con);
    }

    /**
     * Compares the current object with another of its version.
     * <code>
     * print_r($book->compareVersion(1));
     * => array(
     *   '1' => array('Title' => 'Book title at version 1'),
     *   '2' => array('Title' => 'Book title at version 2')
     * );
     * </code>
     *
     * @param   integer             $versionNumber
     * @param   string              $keys Main key used for the result diff (versions|columns)
     * @param   ConnectionInterface $con The ConnectionInterface connection to use.
     * @param   array               $ignoredColumns  The columns to exclude from the diff.
     *
     * @return  array A list of differences
     */
    public function compareVersion($versionNumber, $keys = 'columns', ConnectionInterface $con = null, $ignoredColumns = array())
    {
        $fromVersion = $this->toArray();
        $toVersion = $this->getOneVersion($versionNumber, $con)->toArray();

        return $this->computeDiff($fromVersion, $toVersion, $keys, $ignoredColumns);
    }

    /**
     * Compares two versions of the current object.
     * <code>
     * print_r($book->compareVersions(1, 2));
     * => array(
     *   '1' => array('Title' => 'Book title at version 1'),
     *   '2' => array('Title' => 'Book title at version 2')
     * );
     * </code>
     *
     * @param   integer             $fromVersionNumber
     * @param   integer             $toVersionNumber
     * @param   string              $keys Main key used for the result diff (versions|columns)
     * @param   ConnectionInterface $con The ConnectionInterface connection to use.
     * @param   array               $ignoredColumns  The columns to exclude from the diff.
     *
     * @return  array A list of differences
     */
    public function compareVersions($fromVersionNumber, $toVersionNumber, $keys = 'columns', ConnectionInterface $con = null, $ignoredColumns = array())
    {
        $fromVersion = $this->getOneVersion($fromVersionNumber, $con)->toArray();
        $toVersion = $this->getOneVersion($toVersionNumber, $con)->toArray();

        return $this->computeDiff($fromVersion, $toVersion, $keys, $ignoredColumns);
    }

    /**
     * Computes the diff between two versions.
     * <code>
     * print_r($book->computeDiff(1, 2));
     * => array(
     *   '1' => array('Title' => 'Book title at version 1'),
     *   '2' => array('Title' => 'Book title at version 2')
     * );
     * </code>
     *
     * @param   array     $fromVersion     An array representing the original version.
     * @param   array     $toVersion       An array representing the destination version.
     * @param   string    $keys            Main key used for the result diff (versions|columns).
     * @param   array     $ignoredColumns  The columns to exclude from the diff.
     *
     * @return  array A list of differences
     */
    protected function computeDiff($fromVersion, $toVersion, $keys = 'columns', $ignoredColumns = array())
    {
        $fromVersionNumber = $fromVersion['Version'];
        $toVersionNumber = $toVersion['Version'];
        $ignoredColumns = array_merge(array(
            'Version',
            'VersionCreatedAt',
            'VersionCreatedBy',
            'VersionComment',
        ), $ignoredColumns);
        $diff = array();
        foreach ($fromVersion as $key => $value) {
            if (in_array($key, $ignoredColumns)) {
                continue;
            }
            if ($toVersion[$key] != $value) {
                switch ($keys) {
                    case 'versions':
                        $diff[$fromVersionNumber][$key] = $value;
                        $diff[$toVersionNumber][$key] = $toVersion[$key];
                        break;
                    default:
                        $diff[$key] = array(
                            $fromVersionNumber => $value,
                            $toVersionNumber => $toVersion[$key],
                        );
                        break;
                }
            }
        }

        return $diff;
    }
    /**
     * retrieve the last $number versions.
     *
     * @param  Integer             $number The number of record to return.
     * @param  Criteria            $criteria The Criteria object containing modified values.
     * @param  ConnectionInterface $con The ConnectionInterface connection to use.
     *
     * @return PropelCollection|\DataVersion[] List of \DataVersion objects
     */
    public function getLastVersions($number = 10, $criteria = null, ConnectionInterface $con = null)
    {
        $criteria = ChildDataVersionQuery::create(null, $criteria);
        $criteria->addDescendingOrderByColumn(DataVersionTableMap::COL_VERSION);
        $criteria->limit($number);

        return $this->getDataVersions($criteria, $con);
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
