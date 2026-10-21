<?php

namespace Base;

use \Books as ChildBooks;
use \BooksQuery as ChildBooksQuery;
use \Contributions as ChildContributions;
use \ContributionsQuery as ChildContributionsQuery;
use \Data as ChildData;
use \DataQuery as ChildDataQuery;
use \Formats as ChildFormats;
use \FormatsQuery as ChildFormatsQuery;
use \Issues as ChildIssues;
use \IssuesQuery as ChildIssuesQuery;
use \RRightsForuser as ChildRRightsForuser;
use \RRightsForuserQuery as ChildRRightsForuserQuery;
use \Rights as ChildRights;
use \RightsQuery as ChildRightsQuery;
use \Users as ChildUsers;
use \UsersQuery as ChildUsersQuery;
use \Exception;
use \PDO;
use Map\BooksTableMap;
use Map\ContributionsTableMap;
use Map\DataTableMap;
use Map\FormatsTableMap;
use Map\IssuesTableMap;
use Map\RRightsForuserTableMap;
use Map\UsersTableMap;
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
 * Base class that represents a row from the 'users' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Users implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\UsersTableMap';


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
     * The value for the username field.
     *
     * @var        string
     */
    protected $username;

    /**
     * The value for the password field.
     *
     * @var        string
     */
    protected $password;

    /**
     * The value for the usergroup field.
     *
     * @var        string
     */
    protected $usergroup;

    /**
     * The value for the email field.
     *
     * @var        string
     */
    protected $email;

    /**
     * The value for the roapikey field.
     *
     * @var        string
     */
    protected $roapikey;

    /**
     * The value for the rwapikey field.
     *
     * @var        string
     */
    protected $rwapikey;

    /**
     * The value for the __ip__ field.
     *
     * @var        string
     */
    protected $__ip__;

    /**
     * The value for the __config__ field.
     *
     * @var        string
     */
    protected $__config__;

    /**
     * @var        ObjectCollection|ChildRRightsForuser[] Collection to store aggregation of ChildRRightsForuser objects.
     */
    protected $collRRightsForusers;
    protected $collRRightsForusersPartial;

    /**
     * @var        ObjectCollection|ChildBooks[] Collection to store aggregation of ChildBooks objects.
     */
    protected $collBookss;
    protected $collBookssPartial;

    /**
     * @var        ObjectCollection|ChildContributions[] Collection to store aggregation of ChildContributions objects.
     */
    protected $collContributionss;
    protected $collContributionssPartial;

    /**
     * @var        ObjectCollection|ChildData[] Collection to store aggregation of ChildData objects.
     */
    protected $collDatas;
    protected $collDatasPartial;

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
     * @var        ObjectCollection|ChildRights[] Cross Collection to store aggregation of ChildRights objects.
     */
    protected $collRightss;

    /**
     * @var bool
     */
    protected $collRightssPartial;

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
     * @var ObjectCollection|ChildRRightsForuser[]
     */
    protected $rRightsForusersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildBooks[]
     */
    protected $bookssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildContributions[]
     */
    protected $contributionssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildData[]
     */
    protected $datasScheduledForDeletion = null;

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
     * Initializes internal state of Base\Users object.
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
     * Compares this with another <code>Users</code> instance.  If
     * <code>obj</code> is an instance of <code>Users</code>, delegates to
     * <code>equals(Users)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Users The current object, for fluid interface
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
     * Get the [username] column value.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the [password] column value.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the [usergroup] column value.
     *
     * @return string
     */
    public function getUsergroup()
    {
        return $this->usergroup;
    }

    /**
     * Get the [email] column value.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the [roapikey] column value.
     *
     * @return string
     */
    public function getRoapikey()
    {
        return $this->roapikey;
    }

    /**
     * Get the [rwapikey] column value.
     *
     * @return string
     */
    public function getRwapikey()
    {
        return $this->rwapikey;
    }

    /**
     * Get the [__ip__] column value.
     *
     * @return string
     */
    public function getIp()
    {
        return $this->__ip__;
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
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Users The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[UsersTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [username] column.
     *
     * @param string $v new value
     * @return $this|\Users The current object (for fluent API support)
     */
    public function setUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->username !== $v) {
            $this->username = $v;
            $this->modifiedColumns[UsersTableMap::COL_USERNAME] = true;
        }

        return $this;
    } // setUsername()

    /**
     * Set the value of [password] column.
     *
     * @param string $v new value
     * @return $this|\Users The current object (for fluent API support)
     */
    public function setPassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->password !== $v) {
            $this->password = $v;
            $this->modifiedColumns[UsersTableMap::COL_PASSWORD] = true;
        }

        return $this;
    } // setPassword()

    /**
     * Set the value of [usergroup] column.
     *
     * @param string $v new value
     * @return $this|\Users The current object (for fluent API support)
     */
    public function setUsergroup($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->usergroup !== $v) {
            $this->usergroup = $v;
            $this->modifiedColumns[UsersTableMap::COL_USERGROUP] = true;
        }

        return $this;
    } // setUsergroup()

    /**
     * Set the value of [email] column.
     *
     * @param string $v new value
     * @return $this|\Users The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[UsersTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Set the value of [roapikey] column.
     *
     * @param string $v new value
     * @return $this|\Users The current object (for fluent API support)
     */
    public function setRoapikey($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->roapikey !== $v) {
            $this->roapikey = $v;
            $this->modifiedColumns[UsersTableMap::COL_ROAPIKEY] = true;
        }

        return $this;
    } // setRoapikey()

    /**
     * Set the value of [rwapikey] column.
     *
     * @param string $v new value
     * @return $this|\Users The current object (for fluent API support)
     */
    public function setRwapikey($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->rwapikey !== $v) {
            $this->rwapikey = $v;
            $this->modifiedColumns[UsersTableMap::COL_RWAPIKEY] = true;
        }

        return $this;
    } // setRwapikey()

    /**
     * Set the value of [__ip__] column.
     *
     * @param string $v new value
     * @return $this|\Users The current object (for fluent API support)
     */
    public function setIp($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->__ip__ !== $v) {
            $this->__ip__ = $v;
            $this->modifiedColumns[UsersTableMap::COL___IP__] = true;
        }

        return $this;
    } // setIp()

    /**
     * Set the value of [__config__] column.
     *
     * @param string $v new value
     * @return $this|\Users The current object (for fluent API support)
     */
    public function setConfigSys($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->__config__ !== $v) {
            $this->__config__ = $v;
            $this->modifiedColumns[UsersTableMap::COL___CONFIG__] = true;
        }

        return $this;
    } // setConfigSys()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UsersTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UsersTableMap::translateFieldName('Username', TableMap::TYPE_PHPNAME, $indexType)];
            $this->username = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UsersTableMap::translateFieldName('Password', TableMap::TYPE_PHPNAME, $indexType)];
            $this->password = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UsersTableMap::translateFieldName('Usergroup', TableMap::TYPE_PHPNAME, $indexType)];
            $this->usergroup = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : UsersTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : UsersTableMap::translateFieldName('Roapikey', TableMap::TYPE_PHPNAME, $indexType)];
            $this->roapikey = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : UsersTableMap::translateFieldName('Rwapikey', TableMap::TYPE_PHPNAME, $indexType)];
            $this->rwapikey = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : UsersTableMap::translateFieldName('Ip', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__ip__ = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : UsersTableMap::translateFieldName('ConfigSys', TableMap::TYPE_PHPNAME, $indexType)];
            $this->__config__ = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = UsersTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Users'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(UsersTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUsersQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collRRightsForusers = null;

            $this->collBookss = null;

            $this->collContributionss = null;

            $this->collDatas = null;

            $this->collFormatss = null;

            $this->collIssuess = null;

            $this->collRightss = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Users::setDeleted()
     * @see Users::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UsersTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUsersQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(UsersTableMap::DATABASE_NAME);
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
                UsersTableMap::addInstanceToPool($this);
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

                    \RRightsForuserQuery::create()
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

            if ($this->bookssScheduledForDeletion !== null) {
                if (!$this->bookssScheduledForDeletion->isEmpty()) {
                    foreach ($this->bookssScheduledForDeletion as $books) {
                        // need to save related object because we set the relation to null
                        $books->save($con);
                    }
                    $this->bookssScheduledForDeletion = null;
                }
            }

            if ($this->collBookss !== null) {
                foreach ($this->collBookss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->contributionssScheduledForDeletion !== null) {
                if (!$this->contributionssScheduledForDeletion->isEmpty()) {
                    foreach ($this->contributionssScheduledForDeletion as $contributions) {
                        // need to save related object because we set the relation to null
                        $contributions->save($con);
                    }
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

            if ($this->datasScheduledForDeletion !== null) {
                if (!$this->datasScheduledForDeletion->isEmpty()) {
                    foreach ($this->datasScheduledForDeletion as $data) {
                        // need to save related object because we set the relation to null
                        $data->save($con);
                    }
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

            if ($this->formatssScheduledForDeletion !== null) {
                if (!$this->formatssScheduledForDeletion->isEmpty()) {
                    foreach ($this->formatssScheduledForDeletion as $formats) {
                        // need to save related object because we set the relation to null
                        $formats->save($con);
                    }
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
                    foreach ($this->issuessScheduledForDeletion as $issues) {
                        // need to save related object because we set the relation to null
                        $issues->save($con);
                    }
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

        $this->modifiedColumns[UsersTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UsersTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UsersTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(UsersTableMap::COL_USERNAME)) {
            $modifiedColumns[':p' . $index++]  = 'username';
        }
        if ($this->isColumnModified(UsersTableMap::COL_PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = 'password';
        }
        if ($this->isColumnModified(UsersTableMap::COL_USERGROUP)) {
            $modifiedColumns[':p' . $index++]  = 'usergroup';
        }
        if ($this->isColumnModified(UsersTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }
        if ($this->isColumnModified(UsersTableMap::COL_ROAPIKEY)) {
            $modifiedColumns[':p' . $index++]  = 'roapikey';
        }
        if ($this->isColumnModified(UsersTableMap::COL_RWAPIKEY)) {
            $modifiedColumns[':p' . $index++]  = 'rwapikey';
        }
        if ($this->isColumnModified(UsersTableMap::COL___IP__)) {
            $modifiedColumns[':p' . $index++]  = '__ip__';
        }
        if ($this->isColumnModified(UsersTableMap::COL___CONFIG__)) {
            $modifiedColumns[':p' . $index++]  = '__config__';
        }

        $sql = sprintf(
            'INSERT INTO users (%s) VALUES (%s)',
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
                    case 'username':
                        $stmt->bindValue($identifier, $this->username, PDO::PARAM_STR);
                        break;
                    case 'password':
                        $stmt->bindValue($identifier, $this->password, PDO::PARAM_STR);
                        break;
                    case 'usergroup':
                        $stmt->bindValue($identifier, $this->usergroup, PDO::PARAM_STR);
                        break;
                    case 'email':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case 'roapikey':
                        $stmt->bindValue($identifier, $this->roapikey, PDO::PARAM_STR);
                        break;
                    case 'rwapikey':
                        $stmt->bindValue($identifier, $this->rwapikey, PDO::PARAM_STR);
                        break;
                    case '__ip__':
                        $stmt->bindValue($identifier, $this->__ip__, PDO::PARAM_STR);
                        break;
                    case '__config__':
                        $stmt->bindValue($identifier, $this->__config__, PDO::PARAM_STR);
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
        $pos = UsersTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getUsername();
                break;
            case 2:
                return $this->getPassword();
                break;
            case 3:
                return $this->getUsergroup();
                break;
            case 4:
                return $this->getEmail();
                break;
            case 5:
                return $this->getRoapikey();
                break;
            case 6:
                return $this->getRwapikey();
                break;
            case 7:
                return $this->getIp();
                break;
            case 8:
                return $this->getConfigSys();
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

        if (isset($alreadyDumpedObjects['Users'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Users'][$this->hashCode()] = true;
        $keys = UsersTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getUsername(),
            $keys[2] => $this->getPassword(),
            $keys[3] => $this->getUsergroup(),
            $keys[4] => $this->getEmail(),
            $keys[5] => $this->getRoapikey(),
            $keys[6] => $this->getRwapikey(),
            $keys[7] => $this->getIp(),
            $keys[8] => $this->getConfigSys(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
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
            if (null !== $this->collBookss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'bookss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = '_bookss';
                        break;
                    default:
                        $key = 'Bookss';
                }

                $result[$key] = $this->collBookss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Users
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UsersTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Users
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setUsername($value);
                break;
            case 2:
                $this->setPassword($value);
                break;
            case 3:
                $this->setUsergroup($value);
                break;
            case 4:
                $this->setEmail($value);
                break;
            case 5:
                $this->setRoapikey($value);
                break;
            case 6:
                $this->setRwapikey($value);
                break;
            case 7:
                $this->setIp($value);
                break;
            case 8:
                $this->setConfigSys($value);
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
        $keys = UsersTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setUsername($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setPassword($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setUsergroup($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setEmail($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setRoapikey($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setRwapikey($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setIp($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setConfigSys($arr[$keys[8]]);
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
     * @return $this|\Users The current object, for fluid interface
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
        $criteria = new Criteria(UsersTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UsersTableMap::COL_ID)) {
            $criteria->add(UsersTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(UsersTableMap::COL_USERNAME)) {
            $criteria->add(UsersTableMap::COL_USERNAME, $this->username);
        }
        if ($this->isColumnModified(UsersTableMap::COL_PASSWORD)) {
            $criteria->add(UsersTableMap::COL_PASSWORD, $this->password);
        }
        if ($this->isColumnModified(UsersTableMap::COL_USERGROUP)) {
            $criteria->add(UsersTableMap::COL_USERGROUP, $this->usergroup);
        }
        if ($this->isColumnModified(UsersTableMap::COL_EMAIL)) {
            $criteria->add(UsersTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(UsersTableMap::COL_ROAPIKEY)) {
            $criteria->add(UsersTableMap::COL_ROAPIKEY, $this->roapikey);
        }
        if ($this->isColumnModified(UsersTableMap::COL_RWAPIKEY)) {
            $criteria->add(UsersTableMap::COL_RWAPIKEY, $this->rwapikey);
        }
        if ($this->isColumnModified(UsersTableMap::COL___IP__)) {
            $criteria->add(UsersTableMap::COL___IP__, $this->__ip__);
        }
        if ($this->isColumnModified(UsersTableMap::COL___CONFIG__)) {
            $criteria->add(UsersTableMap::COL___CONFIG__, $this->__config__);
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
        $criteria = ChildUsersQuery::create();
        $criteria->add(UsersTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Users (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setUsername($this->getUsername());
        $copyObj->setPassword($this->getPassword());
        $copyObj->setUsergroup($this->getUsergroup());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setRoapikey($this->getRoapikey());
        $copyObj->setRwapikey($this->getRwapikey());
        $copyObj->setIp($this->getIp());
        $copyObj->setConfigSys($this->getConfigSys());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getRRightsForusers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRRightsForuser($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getBookss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBooks($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getContributionss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContributions($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDatas() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addData($relObj->copy($deepCopy));
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
     * @return \Users Clone of current object.
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
        if ('RRightsForuser' == $relationName) {
            $this->initRRightsForusers();
            return;
        }
        if ('Books' == $relationName) {
            $this->initBookss();
            return;
        }
        if ('Contributions' == $relationName) {
            $this->initContributionss();
            return;
        }
        if ('Data' == $relationName) {
            $this->initDatas();
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
     * If this ChildUsers is new, it will return
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
                    ->filterByUsers($this)
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
     * @return $this|ChildUsers The current object (for fluent API support)
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
            $rRightsForuserRemoved->setUsers(null);
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
                ->filterByUsers($this)
                ->count($con);
        }

        return count($this->collRRightsForusers);
    }

    /**
     * Method called to associate a ChildRRightsForuser object to this object
     * through the ChildRRightsForuser foreign key attribute.
     *
     * @param  ChildRRightsForuser $l ChildRRightsForuser
     * @return $this|\Users The current object (for fluent API support)
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
        $rRightsForuser->setUsers($this);
    }

    /**
     * @param  ChildRRightsForuser $rRightsForuser The ChildRRightsForuser object to remove.
     * @return $this|ChildUsers The current object (for fluent API support)
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
            $rRightsForuser->setUsers(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Users is new, it will return
     * an empty collection; or if this Users has previously
     * been saved, it will retrieve related RRightsForusers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Users.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildRRightsForuser[] List of ChildRRightsForuser objects
     */
    public function getRRightsForusersJoinRights(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildRRightsForuserQuery::create(null, $criteria);
        $query->joinWith('Rights', $joinBehavior);

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
     * Reset is the collBookss collection loaded partially.
     */
    public function resetPartialBookss($v = true)
    {
        $this->collBookssPartial = $v;
    }

    /**
     * Initializes the collBookss collection.
     *
     * By default this just sets the collBookss collection to an empty array (like clearcollBookss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBookss($overrideExisting = true)
    {
        if (null !== $this->collBookss && !$overrideExisting) {
            return;
        }

        $collectionClassName = BooksTableMap::getTableMap()->getCollectionClassName();

        $this->collBookss = new $collectionClassName;
        $this->collBookss->setModel('\Books');
    }

    /**
     * Gets an array of ChildBooks objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsers is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildBooks[] List of ChildBooks objects
     * @throws PropelException
     */
    public function getBookss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collBookssPartial && !$this->isNew();
        if (null === $this->collBookss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBookss) {
                // return empty collection
                $this->initBookss();
            } else {
                $collBookss = ChildBooksQuery::create(null, $criteria)
                    ->filterByuserSysRef($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collBookssPartial && count($collBookss)) {
                        $this->initBookss(false);

                        foreach ($collBookss as $obj) {
                            if (false == $this->collBookss->contains($obj)) {
                                $this->collBookss->append($obj);
                            }
                        }

                        $this->collBookssPartial = true;
                    }

                    return $collBookss;
                }

                if ($partial && $this->collBookss) {
                    foreach ($this->collBookss as $obj) {
                        if ($obj->isNew()) {
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
     * Sets a collection of ChildBooks objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $bookss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function setBookss(Collection $bookss, ConnectionInterface $con = null)
    {
        /** @var ChildBooks[] $bookssToDelete */
        $bookssToDelete = $this->getBookss(new Criteria(), $con)->diff($bookss);


        $this->bookssScheduledForDeletion = $bookssToDelete;

        foreach ($bookssToDelete as $booksRemoved) {
            $booksRemoved->setuserSysRef(null);
        }

        $this->collBookss = null;
        foreach ($bookss as $books) {
            $this->addBooks($books);
        }

        $this->collBookss = $bookss;
        $this->collBookssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Books objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Books objects.
     * @throws PropelException
     */
    public function countBookss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collBookssPartial && !$this->isNew();
        if (null === $this->collBookss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBookss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBookss());
            }

            $query = ChildBooksQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByuserSysRef($this)
                ->count($con);
        }

        return count($this->collBookss);
    }

    /**
     * Method called to associate a ChildBooks object to this object
     * through the ChildBooks foreign key attribute.
     *
     * @param  ChildBooks $l ChildBooks
     * @return $this|\Users The current object (for fluent API support)
     */
    public function addBooks(ChildBooks $l)
    {
        if ($this->collBookss === null) {
            $this->initBookss();
            $this->collBookssPartial = true;
        }

        if (!$this->collBookss->contains($l)) {
            $this->doAddBooks($l);

            if ($this->bookssScheduledForDeletion and $this->bookssScheduledForDeletion->contains($l)) {
                $this->bookssScheduledForDeletion->remove($this->bookssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildBooks $books The ChildBooks object to add.
     */
    protected function doAddBooks(ChildBooks $books)
    {
        $this->collBookss[]= $books;
        $books->setuserSysRef($this);
    }

    /**
     * @param  ChildBooks $books The ChildBooks object to remove.
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function removeBooks(ChildBooks $books)
    {
        if ($this->getBookss()->contains($books)) {
            $pos = $this->collBookss->search($books);
            $this->collBookss->remove($pos);
            if (null === $this->bookssScheduledForDeletion) {
                $this->bookssScheduledForDeletion = clone $this->collBookss;
                $this->bookssScheduledForDeletion->clear();
            }
            $this->bookssScheduledForDeletion[]= $books;
            $books->setuserSysRef(null);
        }

        return $this;
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
     * If this ChildUsers is new, it will return
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
                    ->filterByuserSysRef($this)
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
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function setContributionss(Collection $contributionss, ConnectionInterface $con = null)
    {
        /** @var ChildContributions[] $contributionssToDelete */
        $contributionssToDelete = $this->getContributionss(new Criteria(), $con)->diff($contributionss);


        $this->contributionssScheduledForDeletion = $contributionssToDelete;

        foreach ($contributionssToDelete as $contributionsRemoved) {
            $contributionsRemoved->setuserSysRef(null);
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
                ->filterByuserSysRef($this)
                ->count($con);
        }

        return count($this->collContributionss);
    }

    /**
     * Method called to associate a ChildContributions object to this object
     * through the ChildContributions foreign key attribute.
     *
     * @param  ChildContributions $l ChildContributions
     * @return $this|\Users The current object (for fluent API support)
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
        $contributions->setuserSysRef($this);
    }

    /**
     * @param  ChildContributions $contributions The ChildContributions object to remove.
     * @return $this|ChildUsers The current object (for fluent API support)
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
            $contributions->setuserSysRef(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Users is new, it will return
     * an empty collection; or if this Users has previously
     * been saved, it will retrieve related Contributionss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Users.
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
     * Otherwise if this Users is new, it will return
     * an empty collection; or if this Users has previously
     * been saved, it will retrieve related Contributionss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Users.
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
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Users is new, it will return
     * an empty collection; or if this Users has previously
     * been saved, it will retrieve related Contributionss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Users.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildContributions[] List of ChildContributions objects
     */
    public function getContributionssJoinTemplatenames(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildContributionsQuery::create(null, $criteria);
        $query->joinWith('Templatenames', $joinBehavior);

        return $this->getContributionss($query, $con);
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
     * If this ChildUsers is new, it will return
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
                    ->filterByuserSysRef($this)
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
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function setDatas(Collection $datas, ConnectionInterface $con = null)
    {
        /** @var ChildData[] $datasToDelete */
        $datasToDelete = $this->getDatas(new Criteria(), $con)->diff($datas);


        $this->datasScheduledForDeletion = $datasToDelete;

        foreach ($datasToDelete as $dataRemoved) {
            $dataRemoved->setuserSysRef(null);
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
                ->filterByuserSysRef($this)
                ->count($con);
        }

        return count($this->collDatas);
    }

    /**
     * Method called to associate a ChildData object to this object
     * through the ChildData foreign key attribute.
     *
     * @param  ChildData $l ChildData
     * @return $this|\Users The current object (for fluent API support)
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
        $data->setuserSysRef($this);
    }

    /**
     * @param  ChildData $data The ChildData object to remove.
     * @return $this|ChildUsers The current object (for fluent API support)
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
            $data->setuserSysRef(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Users is new, it will return
     * an empty collection; or if this Users has previously
     * been saved, it will retrieve related Datas from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Users.
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
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Users is new, it will return
     * an empty collection; or if this Users has previously
     * been saved, it will retrieve related Datas from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Users.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildData[] List of ChildData objects
     */
    public function getDatasJoinTemplates(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDataQuery::create(null, $criteria);
        $query->joinWith('Templates', $joinBehavior);

        return $this->getDatas($query, $con);
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
     * If this ChildUsers is new, it will return
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
                    ->filterByuserSysRef($this)
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
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function setFormatss(Collection $formatss, ConnectionInterface $con = null)
    {
        /** @var ChildFormats[] $formatssToDelete */
        $formatssToDelete = $this->getFormatss(new Criteria(), $con)->diff($formatss);


        $this->formatssScheduledForDeletion = $formatssToDelete;

        foreach ($formatssToDelete as $formatsRemoved) {
            $formatsRemoved->setuserSysRef(null);
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
                ->filterByuserSysRef($this)
                ->count($con);
        }

        return count($this->collFormatss);
    }

    /**
     * Method called to associate a ChildFormats object to this object
     * through the ChildFormats foreign key attribute.
     *
     * @param  ChildFormats $l ChildFormats
     * @return $this|\Users The current object (for fluent API support)
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
        $formats->setuserSysRef($this);
    }

    /**
     * @param  ChildFormats $formats The ChildFormats object to remove.
     * @return $this|ChildUsers The current object (for fluent API support)
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
            $formats->setuserSysRef(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Users is new, it will return
     * an empty collection; or if this Users has previously
     * been saved, it will retrieve related Formatss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Users.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildFormats[] List of ChildFormats objects
     */
    public function getFormatssJoinBooks(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildFormatsQuery::create(null, $criteria);
        $query->joinWith('Books', $joinBehavior);

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
     * If this ChildUsers is new, it will return
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
                    ->filterByuserSysRef($this)
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
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function setIssuess(Collection $issuess, ConnectionInterface $con = null)
    {
        /** @var ChildIssues[] $issuessToDelete */
        $issuessToDelete = $this->getIssuess(new Criteria(), $con)->diff($issuess);


        $this->issuessScheduledForDeletion = $issuessToDelete;

        foreach ($issuessToDelete as $issuesRemoved) {
            $issuesRemoved->setuserSysRef(null);
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
                ->filterByuserSysRef($this)
                ->count($con);
        }

        return count($this->collIssuess);
    }

    /**
     * Method called to associate a ChildIssues object to this object
     * through the ChildIssues foreign key attribute.
     *
     * @param  ChildIssues $l ChildIssues
     * @return $this|\Users The current object (for fluent API support)
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
        $issues->setuserSysRef($this);
    }

    /**
     * @param  ChildIssues $issues The ChildIssues object to remove.
     * @return $this|ChildUsers The current object (for fluent API support)
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
            $issues->setuserSysRef(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Users is new, it will return
     * an empty collection; or if this Users has previously
     * been saved, it will retrieve related Issuess from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Users.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildIssues[] List of ChildIssues objects
     */
    public function getIssuessJoinBooks(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildIssuesQuery::create(null, $criteria);
        $query->joinWith('Books', $joinBehavior);

        return $this->getIssuess($query, $con);
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
        $collectionClassName = RRightsForuserTableMap::getTableMap()->getCollectionClassName();

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
     * to the current object by way of the R_rights_foruser cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsers is new, it will return
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
                    ->filterByUsers($this);
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
     * to the current object by way of the R_rights_foruser cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $rightss A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildUsers The current object (for fluent API support)
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
     * to the current object by way of the R_rights_foruser cross-reference table.
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
                    ->filterByUsers($this)
                    ->count($con);
            }
        } else {
            return count($this->collRightss);
        }
    }

    /**
     * Associate a ChildRights to this object
     * through the R_rights_foruser cross reference table.
     *
     * @param ChildRights $rights
     * @return ChildUsers The current object (for fluent API support)
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
        $rRightsForuser = new ChildRRightsForuser();

        $rRightsForuser->setRights($rights);

        $rRightsForuser->setUsers($this);

        $this->addRRightsForuser($rRightsForuser);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$rights->isUserssLoaded()) {
            $rights->initUserss();
            $rights->getUserss()->push($this);
        } elseif (!$rights->getUserss()->contains($this)) {
            $rights->getUserss()->push($this);
        }

    }

    /**
     * Remove rights of this object
     * through the R_rights_foruser cross reference table.
     *
     * @param ChildRights $rights
     * @return ChildUsers The current object (for fluent API support)
     */
    public function removeRights(ChildRights $rights)
    {
        if ($this->getRightss()->contains($rights)) {
            $rRightsForuser = new ChildRRightsForuser();
            $rRightsForuser->setRights($rights);
            if ($rights->isUserssLoaded()) {
                //remove the back reference if available
                $rights->getUserss()->removeObject($this);
            }

            $rRightsForuser->setUsers($this);
            $this->removeRRightsForuser(clone $rRightsForuser);
            $rRightsForuser->clear();

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
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->username = null;
        $this->password = null;
        $this->usergroup = null;
        $this->email = null;
        $this->roapikey = null;
        $this->rwapikey = null;
        $this->__ip__ = null;
        $this->__config__ = null;
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
            if ($this->collContributionss) {
                foreach ($this->collContributionss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDatas) {
                foreach ($this->collDatas as $o) {
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
            if ($this->collRightss) {
                foreach ($this->collRightss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collRRightsForusers = null;
        $this->collBookss = null;
        $this->collContributionss = null;
        $this->collDatas = null;
        $this->collFormatss = null;
        $this->collIssuess = null;
        $this->collRightss = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UsersTableMap::DEFAULT_STRING_FORMAT);
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
