<?php

namespace Base;

use \Contributions as ChildContributions;
use \ContributionsQuery as ChildContributionsQuery;
use \ContributionsVersionQuery as ChildContributionsVersionQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\ContributionsVersionTableMap;
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
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the '_contributions_version' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class ContributionsVersion implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\ContributionsVersionTableMap';


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
     * The value for the _forissue field.
     *
     * @var        int
     */
    protected $_forissue;

    /**
     * The value for the _name field.
     *
     * @var        string
     */
    protected $_name;

    /**
     * The value for the _status field.
     *
     * @var        string
     */
    protected $_status;

    /**
     * The value for the _newdate field.
     *
     * @var        int
     */
    protected $_newdate;

    /**
     * The value for the _moddate field.
     *
     * @var        int
     */
    protected $_moddate;

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
     * The value for the _forchapter field.
     *
     * @var        int
     */
    protected $_forchapter;

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
     * The value for the _data_ids field.
     *
     * @var        array
     */
    protected $_data_ids;

    /**
     * The unserialized $_data_ids value - i.e. the persisted object.
     * This is necessary to avoid repeated calls to unserialize() at runtime.
     * @var object
     */
    protected $_data_ids_unserialized;

    /**
     * The value for the _data_versions field.
     *
     * @var        array
     */
    protected $_data_versions;

    /**
     * The unserialized $_data_versions value - i.e. the persisted object.
     * This is necessary to avoid repeated calls to unserialize() at runtime.
     * @var object
     */
    protected $_data_versions_unserialized;

    /**
     * @var        ChildContributions
     */
    protected $aContributions;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

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
     * Initializes internal state of Base\ContributionsVersion object.
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
     * Compares this with another <code>ContributionsVersion</code> instance.  If
     * <code>obj</code> is an instance of <code>ContributionsVersion</code>, delegates to
     * <code>equals(ContributionsVersion)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|ContributionsVersion The current object, for fluid interface
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
     * Get the [_forissue] column value.
     *
     * @return int
     */
    public function getForissue()
    {
        return $this->_forissue;
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
     * Get the [_status] column value.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * Get the [_newdate] column value.
     *
     * @return int
     */
    public function getNewdate()
    {
        return $this->_newdate;
    }

    /**
     * Get the [_moddate] column value.
     *
     * @return int
     */
    public function getModdate()
    {
        return $this->_moddate;
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
     * Get the [_forchapter] column value.
     *
     * @return int
     */
    public function getForchapter()
    {
        return $this->_forchapter;
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
     * Get the [_data_ids] column value.
     *
     * @return array
     */
    public function getDataIds()
    {
        if (null === $this->_data_ids_unserialized) {
            $this->_data_ids_unserialized = array();
        }
        if (!$this->_data_ids_unserialized && null !== $this->_data_ids) {
            $_data_ids_unserialized = substr($this->_data_ids, 2, -2);
            $this->_data_ids_unserialized = '' !== $_data_ids_unserialized ? explode(' | ', $_data_ids_unserialized) : array();
        }

        return $this->_data_ids_unserialized;
    }

    /**
     * Test the presence of a value in the [_data_ids] array column value.
     * @param      mixed $value
     *
     * @return boolean
     */
    public function hasDataId($value)
    {
        return in_array($value, $this->getDataIds());
    } // hasDataId()

    /**
     * Get the [_data_versions] column value.
     *
     * @return array
     */
    public function getDataVersions()
    {
        if (null === $this->_data_versions_unserialized) {
            $this->_data_versions_unserialized = array();
        }
        if (!$this->_data_versions_unserialized && null !== $this->_data_versions) {
            $_data_versions_unserialized = substr($this->_data_versions, 2, -2);
            $this->_data_versions_unserialized = '' !== $_data_versions_unserialized ? explode(' | ', $_data_versions_unserialized) : array();
        }

        return $this->_data_versions_unserialized;
    }

    /**
     * Test the presence of a value in the [_data_versions] array column value.
     * @param      mixed $value
     *
     * @return boolean
     */
    public function hasDataVersion($value)
    {
        return in_array($value, $this->getDataVersions());
    } // hasDataVersion()

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\ContributionsVersion The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ContributionsVersionTableMap::COL_ID] = true;
        }

        if ($this->aContributions !== null && $this->aContributions->getId() !== $v) {
            $this->aContributions = null;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [_fortemplate] column.
     *
     * @param int $v new value
     * @return $this|\ContributionsVersion The current object (for fluent API support)
     */
    public function setFortemplate($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->_fortemplate !== $v) {
            $this->_fortemplate = $v;
            $this->modifiedColumns[ContributionsVersionTableMap::COL__FORTEMPLATE] = true;
        }

        return $this;
    } // setFortemplate()

    /**
     * Set the value of [_forissue] column.
     *
     * @param int $v new value
     * @return $this|\ContributionsVersion The current object (for fluent API support)
     */
    public function setForissue($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->_forissue !== $v) {
            $this->_forissue = $v;
            $this->modifiedColumns[ContributionsVersionTableMap::COL__FORISSUE] = true;
        }

        return $this;
    } // setForissue()

    /**
     * Set the value of [_name] column.
     *
     * @param string $v new value
     * @return $this|\ContributionsVersion The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_name !== $v) {
            $this->_name = $v;
            $this->modifiedColumns[ContributionsVersionTableMap::COL__NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [_status] column.
     *
     * @param string $v new value
     * @return $this|\ContributionsVersion The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->_status !== $v) {
            $this->_status = $v;
            $this->modifiedColumns[ContributionsVersionTableMap::COL__STATUS] = true;
        }

        return $this;
    } // setStatus()

    /**
     * Set the value of [_newdate] column.
     *
     * @param int $v new value
     * @return $this|\ContributionsVersion The current object (for fluent API support)
     */
    public function setNewdate($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->_newdate !== $v) {
            $this->_newdate = $v;
            $this->modifiedColumns[ContributionsVersionTableMap::COL__NEWDATE] = true;
        }

        return $this;
    } // setNewdate()

    /**
     * Set the value of [_moddate] column.
     *
     * @param int $v new value
     * @return $this|\ContributionsVersion The current object (for fluent API support)
     */
    public function setModdate($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->_moddate !== $v) {
            $this->_moddate = $v;
            $this->modifiedColumns[ContributionsVersionTableMap::COL__MODDATE] = true;
        }

        return $this;
    } // setModdate()

    /**
     * Set the value of [__user__] column.
     *
     * @param int $v new value
     * @return $this|\ContributionsVersion The current object (for fluent API support)
     */
    public function setUserSys($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__user__ !== $v) {
            $this->__user__ = $v;
            $this->modifiedColumns[ContributionsVersionTableMap::COL___USER__] = true;
        }

        return $this;
    } // setUserSys()

    /**
     * Set the value of [__config__] column.
     *
     * @param string $v new value
     * @return $this|\ContributionsVersion The current object (for fluent API support)
     */
    public function setConfigSys($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->__config__ !== $v) {
            $this->__config__ = $v;
            $this->modifiedColumns[ContributionsVersionTableMap::COL___CONFIG__] = true;
        }

        return $this;
    } // setConfigSys()

    /**
     * Set the value of [_forchapter] column.
     *
     * @param int $v new value
     * @return $this|\ContributionsVersion The current object (for fluent API support)
     */
    public function setForchapter($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->_forchapter !== $v) {
            $this->_forchapter = $v;
            $this->modifiedColumns[ContributionsVersionTableMap::COL__FORCHAPTER] = true;
        }

        return $this;
    } // setForchapter()

    /**
     * Set the value of [__parentnode__] column.
     *
     * @param int $v new value
     * @return $this|\ContributionsVersion The current object (for fluent API support)
     */
    public function setParentnode($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__parentnode__ !== $v) {
            $this->__parentnode__ = $v;
            $this->modifiedColumns[ContributionsVersionTableMap::COL___PARENTNODE__] = true;
        }

        return $this;
    } // setParentnode()

    /**
     * Set the value of [__sort__] column.
     *
     * @param int $v new value
     * @return $this|\ContributionsVersion The current object (for fluent API support)
     */
    public function setSort($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->__sort__ !== $v) {
            $this->__sort__ = $v;
            $this->modifiedColumns[ContributionsVersionTableMap::COL___SORT__] = true;
        }

        return $this;
    } // setSort()

    /**
     * Set the value of [version] column.
     *
     * @param int $v new value
     * @return $this|\ContributionsVersion The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[ContributionsVersionTableMap::COL_VERSION] = true;
        }

        return $this;
    } // setVersion()

    /**
     * Sets the value of [version_created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\ContributionsVersion The current object (for fluent API support)
     */
    public function setVersionCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->version_created_at !== null || $dt !== null) {
            if ($this->version_created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->version_created_at->format("Y-m-d H:i:s.u")) {
                $this->version_created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ContributionsVersionTableMap::COL_VERSION_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setVersionCreatedAt()

    /**
     * Set the value of [version_created_by] column.
     *
     * @param string $v new value
     * @return $this|\ContributionsVersion The current object (for fluent API support)
     */
    public function setVersionCreatedBy($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->version_created_by !== $v) {
            $this->version_created_by = $v;
            $this->modifiedColumns[ContributionsVersionTableMap::COL_VERSION_CREATED_BY] = true;
        }

        return $this;
    } // setVersionCreatedBy()

    /**
     * Set the value of [version_comment] column.
     *
     * @param string $v new value
     * @return $this|\ContributionsVersion The current object (for fluent API support)
     */
    public function setVersionComment($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->version_comment !== $v) {
            $this->version_comment = $v;
            $this->modifiedColumns[ContributionsVersionTableMap::COL_VERSION_COMMENT] = true;
        }

        return $this;
    } // setVersionComment()

    /**
     * Set the value of [_data_ids] column.
     *
     * @param array $v new value
     * @return $this|\ContributionsVersion The current object (for fluent API support)
     */
    public function setDataIds($v)
    {
        if ($this->_data_ids_unserialized !== $v) {
            $this->_data_ids_unserialized = $v;
            $this->_data_ids = '| ' . implode(' | ', $v) . ' |';
            $this->modifiedColumns[ContributionsVersionTableMap::COL__DATA_IDS] = true;
        }

        return $this;
    } // setDataIds()

    /**
     * Adds a value to the [_data_ids] array column value.
     * @param  mixed $value
     *
     * @return $this|\ContributionsVersion The current object (for fluent API support)
     */
    public function addDataId($value)
    {
        $currentArray = $this->getDataIds();
        $currentArray []= $value;
        $this->setDataIds($currentArray);

        return $this;
    } // addDataId()

    /**
     * Removes a value from the [_data_ids] array column value.
     * @param  mixed $value
     *
     * @return $this|\ContributionsVersion The current object (for fluent API support)
     */
    public function removeDataId($value)
    {
        $targetArray = array();
        foreach ($this->getDataIds() as $element) {
            if ($element != $value) {
                $targetArray []= $element;
            }
        }
        $this->setDataIds($targetArray);

        return $this;
    } // removeDataId()

    /**
     * Set the value of [_data_versions] column.
     *
     * @param array $v new value
     * @return $this|\ContributionsVersion The current object (for fluent API support)
     */
    public function setDataVersions($v)
    {
        if ($this->_data_versions_unserialized !== $v) {
            $this->_data_versions_unserialized = $v;
            $this->_data_versions = '| ' . implode(' | ', $v) . ' |';
            $this->modifiedColumns[ContributionsVersionTableMap::COL__DATA_VERSIONS] = true;
        }

        return $this;
    } // setDataVersions()

    /**
     * Adds a value to the [_data_versions] array column value.
     * @param  mixed $value
     *
     * @return $this|\ContributionsVersion The current object (for fluent API support)
     */
    public function addDataVersion($value)
    {
        $currentArray = $this->getDataVersions();
        $currentArray []= $value;
        $this->setDataVersions($currentArray);

        return $this;
    } // addDataVersion()

    /**
     * Removes a value from the [_data_versions] array column value.
     * @param  mixed $value
     *
     * @return $this|\ContributionsVersion The current object (for fluent API support)
     */
    public function removeDataVersion($value)
    {
        $targetArray = array();
        foreach ($this->getDataVersions() as $element) {
            if ($element != $value) {
                $targetArray []= $element;
            }
        }
        $this->setDataVersions($targetArray);

        return $this;
    } // removeDataVersion()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ContributionsVersionTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ContributionsVersionTableMap::translateFieldName('Fortemplate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_fortemplate = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ContributionsVersionTableMap::translateFieldName('Forissue', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_forissue = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ContributionsVersionTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ContributionsVersionTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_status = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ContributionsVersionTableMap::translateFieldName('Newdate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_newdate = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ContributionsVersionTableMap::translateFieldName('Moddate', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_moddate = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ContributionsVersionTableMap::translateFieldName('UserSys', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__user__ = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : ContributionsVersionTableMap::translateFieldName('ConfigSys', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__config__ = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : ContributionsVersionTableMap::translateFieldName('Forchapter', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_forchapter = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : ContributionsVersionTableMap::translateFieldName('Parentnode', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__parentnode__ = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : ContributionsVersionTableMap::translateFieldName('Sort', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__sort__ = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : ContributionsVersionTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : ContributionsVersionTableMap::translateFieldName('VersionCreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->version_created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 14 + $startcol : ContributionsVersionTableMap::translateFieldName('VersionCreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version_created_by = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 15 + $startcol : ContributionsVersionTableMap::translateFieldName('VersionComment', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version_comment = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 16 + $startcol : ContributionsVersionTableMap::translateFieldName('DataIds', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_data_ids = $col;
            $this->_data_ids_unserialized = null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 17 + $startcol : ContributionsVersionTableMap::translateFieldName('DataVersions', TableMap::TYPE_PHPNAME, $indexType)];
            $this->_data_versions = $col;
            $this->_data_versions_unserialized = null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 18; // 18 = ContributionsVersionTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\ContributionsVersion'), 0, $e);
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
        if ($this->aContributions !== null && $this->id !== $this->aContributions->getId()) {
            $this->aContributions = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(ContributionsVersionTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildContributionsVersionQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aContributions = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see ContributionsVersion::setDeleted()
     * @see ContributionsVersion::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ContributionsVersionTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildContributionsVersionQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ContributionsVersionTableMap::DATABASE_NAME);
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
                ContributionsVersionTableMap::addInstanceToPool($this);
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

            if ($this->aContributions !== null) {
                if ($this->aContributions->isModified() || $this->aContributions->isNew()) {
                    $affectedRows += $this->aContributions->save($con);
                }
                $this->setContributions($this->aContributions);
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ContributionsVersionTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL__FORTEMPLATE)) {
            $modifiedColumns[':p' . $index++]  = '_fortemplate';
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL__FORISSUE)) {
            $modifiedColumns[':p' . $index++]  = '_forissue';
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL__NAME)) {
            $modifiedColumns[':p' . $index++]  = '_name';
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL__STATUS)) {
            $modifiedColumns[':p' . $index++]  = '_status';
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL__NEWDATE)) {
            $modifiedColumns[':p' . $index++]  = '_newdate';
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL__MODDATE)) {
            $modifiedColumns[':p' . $index++]  = '_moddate';
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL___USER__)) {
            $modifiedColumns[':p' . $index++]  = '__user__';
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL___CONFIG__)) {
            $modifiedColumns[':p' . $index++]  = '__config__';
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL__FORCHAPTER)) {
            $modifiedColumns[':p' . $index++]  = '_forchapter';
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL___PARENTNODE__)) {
            $modifiedColumns[':p' . $index++]  = '__parentnode__';
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL___SORT__)) {
            $modifiedColumns[':p' . $index++]  = '__sort__';
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL_VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'version';
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL_VERSION_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'version_created_at';
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL_VERSION_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'version_created_by';
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL_VERSION_COMMENT)) {
            $modifiedColumns[':p' . $index++]  = 'version_comment';
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL__DATA_IDS)) {
            $modifiedColumns[':p' . $index++]  = '_data_ids';
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL__DATA_VERSIONS)) {
            $modifiedColumns[':p' . $index++]  = '_data_versions';
        }

        $sql = sprintf(
            'INSERT INTO _contributions_version (%s) VALUES (%s)',
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
                    case '_forissue':
                        $stmt->bindValue($identifier, $this->_forissue, PDO::PARAM_INT);
                        break;
                    case '_name':
                        $stmt->bindValue($identifier, $this->_name, PDO::PARAM_STR);
                        break;
                    case '_status':
                        $stmt->bindValue($identifier, $this->_status, PDO::PARAM_STR);
                        break;
                    case '_newdate':
                        $stmt->bindValue($identifier, $this->_newdate, PDO::PARAM_INT);
                        break;
                    case '_moddate':
                        $stmt->bindValue($identifier, $this->_moddate, PDO::PARAM_INT);
                        break;
                    case '__user__':
                        $stmt->bindValue($identifier, $this->__user__, PDO::PARAM_INT);
                        break;
                    case '__config__':
                        $stmt->bindValue($identifier, $this->__config__, PDO::PARAM_STR);
                        break;
                    case '_forchapter':
                        $stmt->bindValue($identifier, $this->_forchapter, PDO::PARAM_INT);
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
                    case '_data_ids':
                        $stmt->bindValue($identifier, $this->_data_ids, PDO::PARAM_STR);
                        break;
                    case '_data_versions':
                        $stmt->bindValue($identifier, $this->_data_versions, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

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
        $pos = ContributionsVersionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getForissue();
                break;
            case 3:
                return $this->getName();
                break;
            case 4:
                return $this->getStatus();
                break;
            case 5:
                return $this->getNewdate();
                break;
            case 6:
                return $this->getModdate();
                break;
            case 7:
                return $this->getUserSys();
                break;
            case 8:
                return $this->getConfigSys();
                break;
            case 9:
                return $this->getForchapter();
                break;
            case 10:
                return $this->getParentnode();
                break;
            case 11:
                return $this->getSort();
                break;
            case 12:
                return $this->getVersion();
                break;
            case 13:
                return $this->getVersionCreatedAt();
                break;
            case 14:
                return $this->getVersionCreatedBy();
                break;
            case 15:
                return $this->getVersionComment();
                break;
            case 16:
                return $this->getDataIds();
                break;
            case 17:
                return $this->getDataVersions();
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

        if (isset($alreadyDumpedObjects['ContributionsVersion'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['ContributionsVersion'][$this->hashCode()] = true;
        $keys = ContributionsVersionTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getFortemplate(),
            $keys[2] => $this->getForissue(),
            $keys[3] => $this->getName(),
            $keys[4] => $this->getStatus(),
            $keys[5] => $this->getNewdate(),
            $keys[6] => $this->getModdate(),
            $keys[7] => $this->getUserSys(),
            $keys[8] => $this->getConfigSys(),
            $keys[9] => $this->getForchapter(),
            $keys[10] => $this->getParentnode(),
            $keys[11] => $this->getSort(),
            $keys[12] => $this->getVersion(),
            $keys[13] => $this->getVersionCreatedAt(),
            $keys[14] => $this->getVersionCreatedBy(),
            $keys[15] => $this->getVersionComment(),
            $keys[16] => $this->getDataIds(),
            $keys[17] => $this->getDataVersions(),
        );
        if ($result[$keys[13]] instanceof \DateTimeInterface) {
            $result[$keys[13]] = $result[$keys[13]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
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
     * @return $this|\ContributionsVersion
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ContributionsVersionTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\ContributionsVersion
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
                $this->setForissue($value);
                break;
            case 3:
                $this->setName($value);
                break;
            case 4:
                $this->setStatus($value);
                break;
            case 5:
                $this->setNewdate($value);
                break;
            case 6:
                $this->setModdate($value);
                break;
            case 7:
                $this->setUserSys($value);
                break;
            case 8:
                $this->setConfigSys($value);
                break;
            case 9:
                $this->setForchapter($value);
                break;
            case 10:
                $this->setParentnode($value);
                break;
            case 11:
                $this->setSort($value);
                break;
            case 12:
                $this->setVersion($value);
                break;
            case 13:
                $this->setVersionCreatedAt($value);
                break;
            case 14:
                $this->setVersionCreatedBy($value);
                break;
            case 15:
                $this->setVersionComment($value);
                break;
            case 16:
                if (!is_array($value)) {
                    $v = trim(substr($value, 2, -2));
                    $value = $v ? explode(' | ', $v) : array();
                }
                $this->setDataIds($value);
                break;
            case 17:
                if (!is_array($value)) {
                    $v = trim(substr($value, 2, -2));
                    $value = $v ? explode(' | ', $v) : array();
                }
                $this->setDataVersions($value);
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
        $keys = ContributionsVersionTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setFortemplate($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setForissue($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setName($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setStatus($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setNewdate($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setModdate($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setUserSys($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setConfigSys($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setForchapter($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setParentnode($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setSort($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setVersion($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setVersionCreatedAt($arr[$keys[13]]);
        }
        if (array_key_exists($keys[14], $arr)) {
            $this->setVersionCreatedBy($arr[$keys[14]]);
        }
        if (array_key_exists($keys[15], $arr)) {
            $this->setVersionComment($arr[$keys[15]]);
        }
        if (array_key_exists($keys[16], $arr)) {
            $this->setDataIds($arr[$keys[16]]);
        }
        if (array_key_exists($keys[17], $arr)) {
            $this->setDataVersions($arr[$keys[17]]);
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
     * @return $this|\ContributionsVersion The current object, for fluid interface
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
        $criteria = new Criteria(ContributionsVersionTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ContributionsVersionTableMap::COL_ID)) {
            $criteria->add(ContributionsVersionTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL__FORTEMPLATE)) {
            $criteria->add(ContributionsVersionTableMap::COL__FORTEMPLATE, $this->_fortemplate);
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL__FORISSUE)) {
            $criteria->add(ContributionsVersionTableMap::COL__FORISSUE, $this->_forissue);
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL__NAME)) {
            $criteria->add(ContributionsVersionTableMap::COL__NAME, $this->_name);
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL__STATUS)) {
            $criteria->add(ContributionsVersionTableMap::COL__STATUS, $this->_status);
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL__NEWDATE)) {
            $criteria->add(ContributionsVersionTableMap::COL__NEWDATE, $this->_newdate);
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL__MODDATE)) {
            $criteria->add(ContributionsVersionTableMap::COL__MODDATE, $this->_moddate);
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL___USER__)) {
            $criteria->add(ContributionsVersionTableMap::COL___USER__, $this->__user__);
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL___CONFIG__)) {
            $criteria->add(ContributionsVersionTableMap::COL___CONFIG__, $this->__config__);
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL__FORCHAPTER)) {
            $criteria->add(ContributionsVersionTableMap::COL__FORCHAPTER, $this->_forchapter);
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL___PARENTNODE__)) {
            $criteria->add(ContributionsVersionTableMap::COL___PARENTNODE__, $this->__parentnode__);
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL___SORT__)) {
            $criteria->add(ContributionsVersionTableMap::COL___SORT__, $this->__sort__);
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL_VERSION)) {
            $criteria->add(ContributionsVersionTableMap::COL_VERSION, $this->version);
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL_VERSION_CREATED_AT)) {
            $criteria->add(ContributionsVersionTableMap::COL_VERSION_CREATED_AT, $this->version_created_at);
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL_VERSION_CREATED_BY)) {
            $criteria->add(ContributionsVersionTableMap::COL_VERSION_CREATED_BY, $this->version_created_by);
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL_VERSION_COMMENT)) {
            $criteria->add(ContributionsVersionTableMap::COL_VERSION_COMMENT, $this->version_comment);
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL__DATA_IDS)) {
            $criteria->add(ContributionsVersionTableMap::COL__DATA_IDS, $this->_data_ids);
        }
        if ($this->isColumnModified(ContributionsVersionTableMap::COL__DATA_VERSIONS)) {
            $criteria->add(ContributionsVersionTableMap::COL__DATA_VERSIONS, $this->_data_versions);
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
        $criteria = ChildContributionsVersionQuery::create();
        $criteria->add(ContributionsVersionTableMap::COL_ID, $this->id);
        $criteria->add(ContributionsVersionTableMap::COL_VERSION, $this->version);

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
        $validPk = null !== $this->getId() &&
            null !== $this->getVersion();

        $validPrimaryKeyFKs = 1;
        $primaryKeyFKs = [];

        //relation _contributions_version_fk_58714c to table _contributions
        if ($this->aContributions && $hash = spl_object_hash($this->aContributions)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = array();
        $pks[0] = $this->getId();
        $pks[1] = $this->getVersion();

        return $pks;
    }

    /**
     * Set the [composite] primary key.
     *
     * @param      array $keys The elements of the composite key (order must match the order in XML file).
     * @return void
     */
    public function setPrimaryKey($keys)
    {
        $this->setId($keys[0]);
        $this->setVersion($keys[1]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return (null === $this->getId()) && (null === $this->getVersion());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \ContributionsVersion (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setId($this->getId());
        $copyObj->setFortemplate($this->getFortemplate());
        $copyObj->setForissue($this->getForissue());
        $copyObj->setName($this->getName());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setNewdate($this->getNewdate());
        $copyObj->setModdate($this->getModdate());
        $copyObj->setUserSys($this->getUserSys());
        $copyObj->setConfigSys($this->getConfigSys());
        $copyObj->setForchapter($this->getForchapter());
        $copyObj->setParentnode($this->getParentnode());
        $copyObj->setSort($this->getSort());
        $copyObj->setVersion($this->getVersion());
        $copyObj->setVersionCreatedAt($this->getVersionCreatedAt());
        $copyObj->setVersionCreatedBy($this->getVersionCreatedBy());
        $copyObj->setVersionComment($this->getVersionComment());
        $copyObj->setDataIds($this->getDataIds());
        $copyObj->setDataVersions($this->getDataVersions());
        if ($makeNew) {
            $copyObj->setNew(true);
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
     * @return \ContributionsVersion Clone of current object.
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
     * Declares an association between this object and a ChildContributions object.
     *
     * @param  ChildContributions $v
     * @return $this|\ContributionsVersion The current object (for fluent API support)
     * @throws PropelException
     */
    public function setContributions(ChildContributions $v = null)
    {
        if ($v === null) {
            $this->setId(NULL);
        } else {
            $this->setId($v->getId());
        }

        $this->aContributions = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildContributions object, it will not be re-added.
        if ($v !== null) {
            $v->addContributionsVersion($this);
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
        if ($this->aContributions === null && ($this->id != 0)) {
            $this->aContributions = ChildContributionsQuery::create()->findPk($this->id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aContributions->addContributionsVersions($this);
             */
        }

        return $this->aContributions;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aContributions) {
            $this->aContributions->removeContributionsVersion($this);
        }
        $this->id = null;
        $this->_fortemplate = null;
        $this->_forissue = null;
        $this->_name = null;
        $this->_status = null;
        $this->_newdate = null;
        $this->_moddate = null;
        $this->__user__ = null;
        $this->__config__ = null;
        $this->_forchapter = null;
        $this->__parentnode__ = null;
        $this->__sort__ = null;
        $this->version = null;
        $this->version_created_at = null;
        $this->version_created_by = null;
        $this->version_comment = null;
        $this->_data_ids = null;
        $this->_data_ids_unserialized = null;
        $this->_data_versions = null;
        $this->_data_versions_unserialized = null;
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
        } // if ($deep)

        $this->aContributions = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ContributionsVersionTableMap::DEFAULT_STRING_FORMAT);
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
