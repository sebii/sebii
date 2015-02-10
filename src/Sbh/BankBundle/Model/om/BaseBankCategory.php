<?php

namespace Sbh\BankBundle\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \DateTime;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelDateTime;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Sbh\BankBundle\Model\BankCategory;
use Sbh\BankBundle\Model\BankCategoryPeer;
use Sbh\BankBundle\Model\BankCategoryQuery;
use Sbh\BankBundle\Model\BankCategoryRegroupment;
use Sbh\BankBundle\Model\BankCategoryRegroupmentQuery;
use Sbh\BankBundle\Model\BankFrequentOperation;
use Sbh\BankBundle\Model\BankFrequentOperationQuery;
use Sbh\BankBundle\Model\BankOperation;
use Sbh\BankBundle\Model\BankOperationQuery;

abstract class BaseBankCategory extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Sbh\\BankBundle\\Model\\BankCategoryPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        BankCategoryPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the user_id field.
     * @var        int
     */
    protected $user_id;

    /**
     * The value for the bank_category_regroupment_id field.
     * @var        int
     */
    protected $bank_category_regroupment_id;

    /**
     * The value for the type field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $type;

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the created_at field.
     * @var        string
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     * @var        string
     */
    protected $updated_at;

    /**
     * @var        BankCategoryRegroupment
     */
    protected $aBankCategoryRegroupment;

    /**
     * @var        PropelObjectCollection|BankFrequentOperation[] Collection to store aggregation of BankFrequentOperation objects.
     */
    protected $collBankFrequentOperations;
    protected $collBankFrequentOperationsPartial;

    /**
     * @var        PropelObjectCollection|BankOperation[] Collection to store aggregation of BankOperation objects.
     */
    protected $collBankOperations;
    protected $collBankOperationsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    /**
     * An array of objects scheduled for deletion.
     * @var    PropelObjectCollection
     */
    protected $bankFrequentOperationsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var    PropelObjectCollection
     */
    protected $bankOperationsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->type = 0;
    }

    /**
     * Initializes internal state of BaseBankCategory object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {

        return $this->name;
    }

    /**
     * Get the [user_id] column value.
     *
     * @return int
     */
    public function getUserId()
    {

        return $this->user_id;
    }

    /**
     * Get the [bank_category_regroupment_id] column value.
     *
     * @return int
     */
    public function getBankCategoryRegroupmentId()
    {

        return $this->bank_category_regroupment_id;
    }

    /**
     * Get the [type] column value.
     *
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getType()
    {
        if (null === $this->type) {
            return null;
        }
        $valueSet = BankCategoryPeer::getValueSet(BankCategoryPeer::TYPE);
        if (!isset($valueSet[$this->type])) {
            throw new PropelException('Unknown stored enum key: ' . $this->type);
        }

        return $valueSet[$this->type];
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
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *         If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = null)
    {
        if ($this->created_at === null) {
            return null;
        }

        if ($this->created_at === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->created_at);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *         If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedAt($format = null)
    {
        if ($this->updated_at === null) {
            return null;
        }

        if ($this->updated_at === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->updated_at);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->updated_at, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return BankCategory The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = BankCategoryPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [user_id] column.
     *
     * @param  int $v new value
     * @return BankCategory The current object (for fluent API support)
     */
    public function setUserId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->user_id !== $v) {
            $this->user_id = $v;
            $this->modifiedColumns[] = BankCategoryPeer::USER_ID;
        }


        return $this;
    } // setUserId()

    /**
     * Set the value of [bank_category_regroupment_id] column.
     *
     * @param  int $v new value
     * @return BankCategory The current object (for fluent API support)
     */
    public function setBankCategoryRegroupmentId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->bank_category_regroupment_id !== $v) {
            $this->bank_category_regroupment_id = $v;
            $this->modifiedColumns[] = BankCategoryPeer::BANK_CATEGORY_REGROUPMENT_ID;
        }

        if ($this->aBankCategoryRegroupment !== null && $this->aBankCategoryRegroupment->getId() !== $v) {
            $this->aBankCategoryRegroupment = null;
        }


        return $this;
    } // setBankCategoryRegroupmentId()

    /**
     * Set the value of [type] column.
     *
     * @param  int $v new value
     * @return BankCategory The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setType($v)
    {
        if ($v !== null) {
            $valueSet = BankCategoryPeer::getValueSet(BankCategoryPeer::TYPE);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[] = BankCategoryPeer::TYPE;
        }


        return $this;
    } // setType()

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return BankCategory The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = BankCategoryPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return BankCategory The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            $currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->created_at = $newDateAsString;
                $this->modifiedColumns[] = BankCategoryPeer::CREATED_AT;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return BankCategory The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            $currentDateAsString = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->updated_at = $newDateAsString;
                $this->modifiedColumns[] = BankCategoryPeer::UPDATED_AT;
            }
        } // if either are not null


        return $this;
    } // setUpdatedAt()

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
            if ($this->type !== 0) {
                return false;
            }

        // otherwise, everything was equal, so return true
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
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->name = ($row[$startcol + 0] !== null) ? (string) $row[$startcol + 0] : null;
            $this->user_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->bank_category_regroupment_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->type = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->id = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->created_at = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->updated_at = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 7; // 7 = BankCategoryPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating BankCategory object", $e);
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

        if ($this->aBankCategoryRegroupment !== null && $this->bank_category_regroupment_id !== $this->aBankCategoryRegroupment->getId()) {
            $this->aBankCategoryRegroupment = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(BankCategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = BankCategoryPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aBankCategoryRegroupment = null;
            $this->collBankFrequentOperations = null;

            $this->collBankOperations = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(BankCategoryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = BankCategoryQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(BankCategoryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
        // timestampable behavior
        if (!$this->isColumnModified(BankCategoryPeer::CREATED_AT))
        {
            $this->setCreatedAt(time());
        }
        if (!$this->isColumnModified(BankCategoryPeer::UPDATED_AT))
        {
            $this->setUpdatedAt(time());
        }
            } else {
                $ret = $ret && $this->preUpdate($con);
        // timestampable behavior
        if ($this->isModified() && !$this->isColumnModified(BankCategoryPeer::UPDATED_AT))
        {
            $this->setUpdatedAt(time());
        }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                BankCategoryPeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aBankCategoryRegroupment !== null) {
                if ($this->aBankCategoryRegroupment->isModified() || $this->aBankCategoryRegroupment->isNew()) {
                    $affectedRows += $this->aBankCategoryRegroupment->save($con);
                }
                $this->setBankCategoryRegroupment($this->aBankCategoryRegroupment);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->bankFrequentOperationsScheduledForDeletion !== null) {
                if (!$this->bankFrequentOperationsScheduledForDeletion->isEmpty()) {
                    foreach ($this->bankFrequentOperationsScheduledForDeletion as $bankFrequentOperation) {
                        // need to save related object because we set the relation to null
                        $bankFrequentOperation->save($con);
                    }
                    $this->bankFrequentOperationsScheduledForDeletion = null;
                }
            }

            if ($this->collBankFrequentOperations !== null) {
                foreach ($this->collBankFrequentOperations as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->bankOperationsScheduledForDeletion !== null) {
                if (!$this->bankOperationsScheduledForDeletion->isEmpty()) {
                    foreach ($this->bankOperationsScheduledForDeletion as $bankOperation) {
                        // need to save related object because we set the relation to null
                        $bankOperation->save($con);
                    }
                    $this->bankOperationsScheduledForDeletion = null;
                }
            }

            if ($this->collBankOperations !== null) {
                foreach ($this->collBankOperations as $referrerFK) {
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
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = BankCategoryPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . BankCategoryPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(BankCategoryPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(BankCategoryPeer::USER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`user_id`';
        }
        if ($this->isColumnModified(BankCategoryPeer::BANK_CATEGORY_REGROUPMENT_ID)) {
            $modifiedColumns[':p' . $index++]  = '`bank_category_regroupment_id`';
        }
        if ($this->isColumnModified(BankCategoryPeer::TYPE)) {
            $modifiedColumns[':p' . $index++]  = '`type`';
        }
        if ($this->isColumnModified(BankCategoryPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(BankCategoryPeer::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }
        if ($this->isColumnModified(BankCategoryPeer::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`updated_at`';
        }

        $sql = sprintf(
            'INSERT INTO `bank_category` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`name`':
            $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`user_id`':
            $stmt->bindValue($identifier, $this->user_id, PDO::PARAM_INT);
                        break;
                    case '`bank_category_regroupment_id`':
            $stmt->bindValue($identifier, $this->bank_category_regroupment_id, PDO::PARAM_INT);
                        break;
                    case '`type`':
            $stmt->bindValue($identifier, $this->type, PDO::PARAM_INT);
                        break;
                    case '`id`':
            $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`created_at`':
            $stmt->bindValue($identifier, $this->created_at, PDO::PARAM_STR);
                        break;
                    case '`updated_at`':
            $stmt->bindValue($identifier, $this->updated_at, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
      $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggregated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objects otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            // We call the validate method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aBankCategoryRegroupment !== null) {
                if (!$this->aBankCategoryRegroupment->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aBankCategoryRegroupment->getValidationFailures());
                }
            }


            if (($retval = BankCategoryPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collBankFrequentOperations !== null) {
                    foreach ($this->collBankFrequentOperations as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collBankOperations !== null) {
                    foreach ($this->collBankOperations as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }


            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = BankCategoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getName();
                break;
            case 1:
                return $this->getUserId();
                break;
            case 2:
                return $this->getBankCategoryRegroupmentId();
                break;
            case 3:
                return $this->getType();
                break;
            case 4:
                return $this->getId();
                break;
            case 5:
                return $this->getCreatedAt();
                break;
            case 6:
                return $this->getUpdatedAt();
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
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['BankCategory'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['BankCategory'][$this->getPrimaryKey()] = true;
        $keys = BankCategoryPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getName(),
            $keys[1] => $this->getUserId(),
            $keys[2] => $this->getBankCategoryRegroupmentId(),
            $keys[3] => $this->getType(),
            $keys[4] => $this->getId(),
            $keys[5] => $this->getCreatedAt(),
            $keys[6] => $this->getUpdatedAt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aBankCategoryRegroupment) {
                $result['BankCategoryRegroupment'] = $this->aBankCategoryRegroupment->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collBankFrequentOperations) {
                $result['BankFrequentOperations'] = $this->collBankFrequentOperations->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collBankOperations) {
                $result['BankOperations'] = $this->collBankOperations->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = BankCategoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setName($value);
                break;
            case 1:
                $this->setUserId($value);
                break;
            case 2:
                $this->setBankCategoryRegroupmentId($value);
                break;
            case 3:
                $valueSet = BankCategoryPeer::getValueSet(BankCategoryPeer::TYPE);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setType($value);
                break;
            case 4:
                $this->setId($value);
                break;
            case 5:
                $this->setCreatedAt($value);
                break;
            case 6:
                $this->setUpdatedAt($value);
                break;
        } // switch()
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
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = BankCategoryPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setName($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setUserId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setBankCategoryRegroupmentId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setType($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setId($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setCreatedAt($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setUpdatedAt($arr[$keys[6]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(BankCategoryPeer::DATABASE_NAME);

        if ($this->isColumnModified(BankCategoryPeer::NAME)) $criteria->add(BankCategoryPeer::NAME, $this->name);
        if ($this->isColumnModified(BankCategoryPeer::USER_ID)) $criteria->add(BankCategoryPeer::USER_ID, $this->user_id);
        if ($this->isColumnModified(BankCategoryPeer::BANK_CATEGORY_REGROUPMENT_ID)) $criteria->add(BankCategoryPeer::BANK_CATEGORY_REGROUPMENT_ID, $this->bank_category_regroupment_id);
        if ($this->isColumnModified(BankCategoryPeer::TYPE)) $criteria->add(BankCategoryPeer::TYPE, $this->type);
        if ($this->isColumnModified(BankCategoryPeer::ID)) $criteria->add(BankCategoryPeer::ID, $this->id);
        if ($this->isColumnModified(BankCategoryPeer::CREATED_AT)) $criteria->add(BankCategoryPeer::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(BankCategoryPeer::UPDATED_AT)) $criteria->add(BankCategoryPeer::UPDATED_AT, $this->updated_at);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(BankCategoryPeer::DATABASE_NAME);
        $criteria->add(BankCategoryPeer::ID, $this->id);

        return $criteria;
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
     * @param  int $key Primary key.
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
     * @param object $copyObj An object of BankCategory (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setUserId($this->getUserId());
        $copyObj->setBankCategoryRegroupmentId($this->getBankCategoryRegroupmentId());
        $copyObj->setType($this->getType());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getBankFrequentOperations() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBankFrequentOperation($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getBankOperations() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBankOperation($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
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
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return BankCategory Clone of current object.
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
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return BankCategoryPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new BankCategoryPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a BankCategoryRegroupment object.
     *
     * @param                  BankCategoryRegroupment $v
     * @return BankCategory The current object (for fluent API support)
     * @throws PropelException
     */
    public function setBankCategoryRegroupment(BankCategoryRegroupment $v = null)
    {
        if ($v === null) {
            $this->setBankCategoryRegroupmentId(NULL);
        } else {
            $this->setBankCategoryRegroupmentId($v->getId());
        }

        $this->aBankCategoryRegroupment = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the BankCategoryRegroupment object, it will not be re-added.
        if ($v !== null) {
            $v->addBankCategory($this);
        }


        return $this;
    }


    /**
     * Get the associated BankCategoryRegroupment object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return BankCategoryRegroupment The associated BankCategoryRegroupment object.
     * @throws PropelException
     */
    public function getBankCategoryRegroupment(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aBankCategoryRegroupment === null && ($this->bank_category_regroupment_id !== null) && $doQuery) {
            $this->aBankCategoryRegroupment = BankCategoryRegroupmentQuery::create()->findPk($this->bank_category_regroupment_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aBankCategoryRegroupment->addBankCategories($this);
             */
        }

        return $this->aBankCategoryRegroupment;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('BankFrequentOperation' == $relationName) {
            $this->initBankFrequentOperations();
        }
        if ('BankOperation' == $relationName) {
            $this->initBankOperations();
        }
    }

    /**
     * Clears out the collBankFrequentOperations collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return BankCategory The current object (for fluent API support)
     * @see        addBankFrequentOperations()
     */
    public function clearBankFrequentOperations()
    {
        $this->collBankFrequentOperations = null; // important to set this to null since that means it is uninitialized
        $this->collBankFrequentOperationsPartial = null;

        return $this;
    }

    /**
     * reset is the collBankFrequentOperations collection loaded partially
     *
     * @return void
     */
    public function resetPartialBankFrequentOperations($v = true)
    {
        $this->collBankFrequentOperationsPartial = $v;
    }

    /**
     * Initializes the collBankFrequentOperations collection.
     *
     * By default this just sets the collBankFrequentOperations collection to an empty array (like clearcollBankFrequentOperations());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBankFrequentOperations($overrideExisting = true)
    {
        if (null !== $this->collBankFrequentOperations && !$overrideExisting) {
            return;
        }
        $this->collBankFrequentOperations = new PropelObjectCollection();
        $this->collBankFrequentOperations->setModel('BankFrequentOperation');
    }

    /**
     * Gets an array of BankFrequentOperation objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this BankCategory is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|BankFrequentOperation[] List of BankFrequentOperation objects
     * @throws PropelException
     */
    public function getBankFrequentOperations($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collBankFrequentOperationsPartial && !$this->isNew();
        if (null === $this->collBankFrequentOperations || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBankFrequentOperations) {
                // return empty collection
                $this->initBankFrequentOperations();
            } else {
                $collBankFrequentOperations = BankFrequentOperationQuery::create(null, $criteria)
                    ->filterByBankCategory($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collBankFrequentOperationsPartial && count($collBankFrequentOperations)) {
                      $this->initBankFrequentOperations(false);

                      foreach ($collBankFrequentOperations as $obj) {
                        if (false == $this->collBankFrequentOperations->contains($obj)) {
                          $this->collBankFrequentOperations->append($obj);
                        }
                      }

                      $this->collBankFrequentOperationsPartial = true;
                    }

                    $collBankFrequentOperations->getInternalIterator()->rewind();

                    return $collBankFrequentOperations;
                }

                if ($partial && $this->collBankFrequentOperations) {
                    foreach ($this->collBankFrequentOperations as $obj) {
                        if ($obj->isNew()) {
                            $collBankFrequentOperations[] = $obj;
                        }
                    }
                }

                $this->collBankFrequentOperations = $collBankFrequentOperations;
                $this->collBankFrequentOperationsPartial = false;
            }
        }

        return $this->collBankFrequentOperations;
    }

    /**
     * Sets a collection of BankFrequentOperation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $bankFrequentOperations A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return BankCategory The current object (for fluent API support)
     */
    public function setBankFrequentOperations(PropelCollection $bankFrequentOperations, PropelPDO $con = null)
    {
        $bankFrequentOperationsToDelete = $this->getBankFrequentOperations(new Criteria(), $con)->diff($bankFrequentOperations);


        $this->bankFrequentOperationsScheduledForDeletion = $bankFrequentOperationsToDelete;

        foreach ($bankFrequentOperationsToDelete as $bankFrequentOperationRemoved) {
            $bankFrequentOperationRemoved->setBankCategory(null);
        }

        $this->collBankFrequentOperations = null;
        foreach ($bankFrequentOperations as $bankFrequentOperation) {
            $this->addBankFrequentOperation($bankFrequentOperation);
        }

        $this->collBankFrequentOperations = $bankFrequentOperations;
        $this->collBankFrequentOperationsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BankFrequentOperation objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related BankFrequentOperation objects.
     * @throws PropelException
     */
    public function countBankFrequentOperations(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collBankFrequentOperationsPartial && !$this->isNew();
        if (null === $this->collBankFrequentOperations || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBankFrequentOperations) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBankFrequentOperations());
            }
            $query = BankFrequentOperationQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBankCategory($this)
                ->count($con);
        }

        return count($this->collBankFrequentOperations);
    }

    /**
     * Method called to associate a BankFrequentOperation object to this object
     * through the BankFrequentOperation foreign key attribute.
     *
     * @param    BankFrequentOperation $l BankFrequentOperation
     * @return BankCategory The current object (for fluent API support)
     */
    public function addBankFrequentOperation(BankFrequentOperation $l)
    {
        if ($this->collBankFrequentOperations === null) {
            $this->initBankFrequentOperations();
            $this->collBankFrequentOperationsPartial = true;
        }

        if (!in_array($l, $this->collBankFrequentOperations->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddBankFrequentOperation($l);

            if ($this->bankFrequentOperationsScheduledForDeletion and $this->bankFrequentOperationsScheduledForDeletion->contains($l)) {
                $this->bankFrequentOperationsScheduledForDeletion->remove($this->bankFrequentOperationsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param  BankFrequentOperation $bankFrequentOperation The bankFrequentOperation object to add.
     */
    protected function doAddBankFrequentOperation($bankFrequentOperation)
    {
        $this->collBankFrequentOperations[]= $bankFrequentOperation;
        $bankFrequentOperation->setBankCategory($this);
    }

    /**
     * @param  BankFrequentOperation $bankFrequentOperation The bankFrequentOperation object to remove.
     * @return BankCategory The current object (for fluent API support)
     */
    public function removeBankFrequentOperation($bankFrequentOperation)
    {
        if ($this->getBankFrequentOperations()->contains($bankFrequentOperation)) {
            $this->collBankFrequentOperations->remove($this->collBankFrequentOperations->search($bankFrequentOperation));
            if (null === $this->bankFrequentOperationsScheduledForDeletion) {
                $this->bankFrequentOperationsScheduledForDeletion = clone $this->collBankFrequentOperations;
                $this->bankFrequentOperationsScheduledForDeletion->clear();
            }
            $this->bankFrequentOperationsScheduledForDeletion[]= $bankFrequentOperation;
            $bankFrequentOperation->setBankCategory(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this BankCategory is new, it will return
     * an empty collection; or if this BankCategory has previously
     * been saved, it will retrieve related BankFrequentOperations from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in BankCategory.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|BankFrequentOperation[] List of BankFrequentOperation objects
     */
    public function getBankFrequentOperationsJoinBankAccount($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = BankFrequentOperationQuery::create(null, $criteria);
        $query->joinWith('BankAccount', $join_behavior);

        return $this->getBankFrequentOperations($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this BankCategory is new, it will return
     * an empty collection; or if this BankCategory has previously
     * been saved, it will retrieve related BankFrequentOperations from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in BankCategory.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|BankFrequentOperation[] List of BankFrequentOperation objects
     */
    public function getBankFrequentOperationsJoinBankPayee($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = BankFrequentOperationQuery::create(null, $criteria);
        $query->joinWith('BankPayee', $join_behavior);

        return $this->getBankFrequentOperations($query, $con);
    }

    /**
     * Clears out the collBankOperations collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return BankCategory The current object (for fluent API support)
     * @see        addBankOperations()
     */
    public function clearBankOperations()
    {
        $this->collBankOperations = null; // important to set this to null since that means it is uninitialized
        $this->collBankOperationsPartial = null;

        return $this;
    }

    /**
     * reset is the collBankOperations collection loaded partially
     *
     * @return void
     */
    public function resetPartialBankOperations($v = true)
    {
        $this->collBankOperationsPartial = $v;
    }

    /**
     * Initializes the collBankOperations collection.
     *
     * By default this just sets the collBankOperations collection to an empty array (like clearcollBankOperations());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBankOperations($overrideExisting = true)
    {
        if (null !== $this->collBankOperations && !$overrideExisting) {
            return;
        }
        $this->collBankOperations = new PropelObjectCollection();
        $this->collBankOperations->setModel('BankOperation');
    }

    /**
     * Gets an array of BankOperation objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this BankCategory is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|BankOperation[] List of BankOperation objects
     * @throws PropelException
     */
    public function getBankOperations($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collBankOperationsPartial && !$this->isNew();
        if (null === $this->collBankOperations || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBankOperations) {
                // return empty collection
                $this->initBankOperations();
            } else {
                $collBankOperations = BankOperationQuery::create(null, $criteria)
                    ->filterByBankCategory($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collBankOperationsPartial && count($collBankOperations)) {
                      $this->initBankOperations(false);

                      foreach ($collBankOperations as $obj) {
                        if (false == $this->collBankOperations->contains($obj)) {
                          $this->collBankOperations->append($obj);
                        }
                      }

                      $this->collBankOperationsPartial = true;
                    }

                    $collBankOperations->getInternalIterator()->rewind();

                    return $collBankOperations;
                }

                if ($partial && $this->collBankOperations) {
                    foreach ($this->collBankOperations as $obj) {
                        if ($obj->isNew()) {
                            $collBankOperations[] = $obj;
                        }
                    }
                }

                $this->collBankOperations = $collBankOperations;
                $this->collBankOperationsPartial = false;
            }
        }

        return $this->collBankOperations;
    }

    /**
     * Sets a collection of BankOperation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $bankOperations A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return BankCategory The current object (for fluent API support)
     */
    public function setBankOperations(PropelCollection $bankOperations, PropelPDO $con = null)
    {
        $bankOperationsToDelete = $this->getBankOperations(new Criteria(), $con)->diff($bankOperations);


        $this->bankOperationsScheduledForDeletion = $bankOperationsToDelete;

        foreach ($bankOperationsToDelete as $bankOperationRemoved) {
            $bankOperationRemoved->setBankCategory(null);
        }

        $this->collBankOperations = null;
        foreach ($bankOperations as $bankOperation) {
            $this->addBankOperation($bankOperation);
        }

        $this->collBankOperations = $bankOperations;
        $this->collBankOperationsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BankOperation objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related BankOperation objects.
     * @throws PropelException
     */
    public function countBankOperations(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collBankOperationsPartial && !$this->isNew();
        if (null === $this->collBankOperations || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBankOperations) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBankOperations());
            }
            $query = BankOperationQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBankCategory($this)
                ->count($con);
        }

        return count($this->collBankOperations);
    }

    /**
     * Method called to associate a BankOperation object to this object
     * through the BankOperation foreign key attribute.
     *
     * @param    BankOperation $l BankOperation
     * @return BankCategory The current object (for fluent API support)
     */
    public function addBankOperation(BankOperation $l)
    {
        if ($this->collBankOperations === null) {
            $this->initBankOperations();
            $this->collBankOperationsPartial = true;
        }

        if (!in_array($l, $this->collBankOperations->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddBankOperation($l);

            if ($this->bankOperationsScheduledForDeletion and $this->bankOperationsScheduledForDeletion->contains($l)) {
                $this->bankOperationsScheduledForDeletion->remove($this->bankOperationsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param  BankOperation $bankOperation The bankOperation object to add.
     */
    protected function doAddBankOperation($bankOperation)
    {
        $this->collBankOperations[]= $bankOperation;
        $bankOperation->setBankCategory($this);
    }

    /**
     * @param  BankOperation $bankOperation The bankOperation object to remove.
     * @return BankCategory The current object (for fluent API support)
     */
    public function removeBankOperation($bankOperation)
    {
        if ($this->getBankOperations()->contains($bankOperation)) {
            $this->collBankOperations->remove($this->collBankOperations->search($bankOperation));
            if (null === $this->bankOperationsScheduledForDeletion) {
                $this->bankOperationsScheduledForDeletion = clone $this->collBankOperations;
                $this->bankOperationsScheduledForDeletion->clear();
            }
            $this->bankOperationsScheduledForDeletion[]= $bankOperation;
            $bankOperation->setBankCategory(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this BankCategory is new, it will return
     * an empty collection; or if this BankCategory has previously
     * been saved, it will retrieve related BankOperations from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in BankCategory.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|BankOperation[] List of BankOperation objects
     */
    public function getBankOperationsJoinBankAccount($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = BankOperationQuery::create(null, $criteria);
        $query->joinWith('BankAccount', $join_behavior);

        return $this->getBankOperations($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this BankCategory is new, it will return
     * an empty collection; or if this BankCategory has previously
     * been saved, it will retrieve related BankOperations from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in BankCategory.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|BankOperation[] List of BankOperation objects
     */
    public function getBankOperationsJoinBankPayee($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = BankOperationQuery::create(null, $criteria);
        $query->joinWith('BankPayee', $join_behavior);

        return $this->getBankOperations($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this BankCategory is new, it will return
     * an empty collection; or if this BankCategory has previously
     * been saved, it will retrieve related BankOperations from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in BankCategory.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|BankOperation[] List of BankOperation objects
     */
    public function getBankOperationsJoinBankFrequentOperation($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = BankOperationQuery::create(null, $criteria);
        $query->joinWith('BankFrequentOperation', $join_behavior);

        return $this->getBankOperations($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->name = null;
        $this->user_id = null;
        $this->bank_category_regroupment_id = null;
        $this->type = null;
        $this->id = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->collBankFrequentOperations) {
                foreach ($this->collBankFrequentOperations as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collBankOperations) {
                foreach ($this->collBankOperations as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aBankCategoryRegroupment instanceof Persistent) {
              $this->aBankCategoryRegroupment->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collBankFrequentOperations instanceof PropelCollection) {
            $this->collBankFrequentOperations->clearIterator();
        }
        $this->collBankFrequentOperations = null;
        if ($this->collBankOperations instanceof PropelCollection) {
            $this->collBankOperations->clearIterator();
        }
        $this->collBankOperations = null;
        $this->aBankCategoryRegroupment = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(BankCategoryPeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

  // timestampable behavior

  /**
   * Mark the current object so that the update date doesn't get updated during next save
   *
   * @return     BankCategory The current object (for fluent API support)
   */
  public function keepUpdateDateUnchanged()
  {
      $this->modifiedColumns[] = BankCategoryPeer::UPDATED_AT;

      return $this;
  }

}
