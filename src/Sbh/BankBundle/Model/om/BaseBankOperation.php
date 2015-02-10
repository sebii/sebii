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
use \PropelDateTime;
use \PropelException;
use \PropelPDO;
use Sbh\BankBundle\Model\BankAccount;
use Sbh\BankBundle\Model\BankAccountQuery;
use Sbh\BankBundle\Model\BankCategory;
use Sbh\BankBundle\Model\BankCategoryQuery;
use Sbh\BankBundle\Model\BankFrequentOperation;
use Sbh\BankBundle\Model\BankFrequentOperationQuery;
use Sbh\BankBundle\Model\BankOperation;
use Sbh\BankBundle\Model\BankOperationPeer;
use Sbh\BankBundle\Model\BankOperationQuery;
use Sbh\BankBundle\Model\BankPayee;
use Sbh\BankBundle\Model\BankPayeeQuery;

abstract class BaseBankOperation extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Sbh\\BankBundle\\Model\\BankOperationPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        BankOperationPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the bank_account_id field.
     * @var        int
     */
    protected $bank_account_id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the date field.
     * @var        string
     */
    protected $date;

    /**
     * The value for the bank_payee_id field.
     * @var        int
     */
    protected $bank_payee_id;

    /**
     * The value for the bank_category_id field.
     * @var        int
     */
    protected $bank_category_id;

    /**
     * The value for the payment field.
     * @var        double
     */
    protected $payment;

    /**
     * The value for the deposit field.
     * @var        double
     */
    protected $deposit;

    /**
     * The value for the bank_frequent_operation_id field.
     * @var        int
     */
    protected $bank_frequent_operation_id;

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
     * @var        BankAccount
     */
    protected $aBankAccount;

    /**
     * @var        BankPayee
     */
    protected $aBankPayee;

    /**
     * @var        BankCategory
     */
    protected $aBankCategory;

    /**
     * @var        BankFrequentOperation
     */
    protected $aBankFrequentOperation;

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
     * Get the [bank_account_id] column value.
     *
     * @return int
     */
    public function getBankAccountId()
    {

        return $this->bank_account_id;
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
     * Get the [optionally formatted] temporal [date] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *         If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDate($format = null)
    {
        if ($this->date === null) {
            return null;
        }

        if ($this->date === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->date, true), $x);
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
     * Get the [bank_payee_id] column value.
     *
     * @return int
     */
    public function getBankPayeeId()
    {

        return $this->bank_payee_id;
    }

    /**
     * Get the [bank_category_id] column value.
     *
     * @return int
     */
    public function getBankCategoryId()
    {

        return $this->bank_category_id;
    }

    /**
     * Get the [payment] column value.
     *
     * @return double
     */
    public function getPayment()
    {

        return $this->payment;
    }

    /**
     * Get the [deposit] column value.
     *
     * @return double
     */
    public function getDeposit()
    {

        return $this->deposit;
    }

    /**
     * Get the [bank_frequent_operation_id] column value.
     *
     * @return int
     */
    public function getBankFrequentOperationId()
    {

        return $this->bank_frequent_operation_id;
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
     * Set the value of [bank_account_id] column.
     *
     * @param  int $v new value
     * @return BankOperation The current object (for fluent API support)
     */
    public function setBankAccountId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->bank_account_id !== $v) {
            $this->bank_account_id = $v;
            $this->modifiedColumns[] = BankOperationPeer::BANK_ACCOUNT_ID;
        }

        if ($this->aBankAccount !== null && $this->aBankAccount->getId() !== $v) {
            $this->aBankAccount = null;
        }


        return $this;
    } // setBankAccountId()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return BankOperation The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = BankOperationPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Sets the value of [date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return BankOperation The current object (for fluent API support)
     */
    public function setDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date !== null || $dt !== null) {
            $currentDateAsString = ($this->date !== null && $tmpDt = new DateTime($this->date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->date = $newDateAsString;
                $this->modifiedColumns[] = BankOperationPeer::DATE;
            }
        } // if either are not null


        return $this;
    } // setDate()

    /**
     * Set the value of [bank_payee_id] column.
     *
     * @param  int $v new value
     * @return BankOperation The current object (for fluent API support)
     */
    public function setBankPayeeId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->bank_payee_id !== $v) {
            $this->bank_payee_id = $v;
            $this->modifiedColumns[] = BankOperationPeer::BANK_PAYEE_ID;
        }

        if ($this->aBankPayee !== null && $this->aBankPayee->getId() !== $v) {
            $this->aBankPayee = null;
        }


        return $this;
    } // setBankPayeeId()

    /**
     * Set the value of [bank_category_id] column.
     *
     * @param  int $v new value
     * @return BankOperation The current object (for fluent API support)
     */
    public function setBankCategoryId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->bank_category_id !== $v) {
            $this->bank_category_id = $v;
            $this->modifiedColumns[] = BankOperationPeer::BANK_CATEGORY_ID;
        }

        if ($this->aBankCategory !== null && $this->aBankCategory->getId() !== $v) {
            $this->aBankCategory = null;
        }


        return $this;
    } // setBankCategoryId()

    /**
     * Set the value of [payment] column.
     *
     * @param  double $v new value
     * @return BankOperation The current object (for fluent API support)
     */
    public function setPayment($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (double) $v;
        }

        if ($this->payment !== $v) {
            $this->payment = $v;
            $this->modifiedColumns[] = BankOperationPeer::PAYMENT;
        }


        return $this;
    } // setPayment()

    /**
     * Set the value of [deposit] column.
     *
     * @param  double $v new value
     * @return BankOperation The current object (for fluent API support)
     */
    public function setDeposit($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (double) $v;
        }

        if ($this->deposit !== $v) {
            $this->deposit = $v;
            $this->modifiedColumns[] = BankOperationPeer::DEPOSIT;
        }


        return $this;
    } // setDeposit()

    /**
     * Set the value of [bank_frequent_operation_id] column.
     *
     * @param  int $v new value
     * @return BankOperation The current object (for fluent API support)
     */
    public function setBankFrequentOperationId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->bank_frequent_operation_id !== $v) {
            $this->bank_frequent_operation_id = $v;
            $this->modifiedColumns[] = BankOperationPeer::BANK_FREQUENT_OPERATION_ID;
        }

        if ($this->aBankFrequentOperation !== null && $this->aBankFrequentOperation->getId() !== $v) {
            $this->aBankFrequentOperation = null;
        }


        return $this;
    } // setBankFrequentOperationId()

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return BankOperation The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = BankOperationPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return BankOperation The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            $currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->created_at = $newDateAsString;
                $this->modifiedColumns[] = BankOperationPeer::CREATED_AT;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return BankOperation The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            $currentDateAsString = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->updated_at = $newDateAsString;
                $this->modifiedColumns[] = BankOperationPeer::UPDATED_AT;
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

            $this->bank_account_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->name = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->date = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->bank_payee_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->bank_category_id = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->payment = ($row[$startcol + 5] !== null) ? (double) $row[$startcol + 5] : null;
            $this->deposit = ($row[$startcol + 6] !== null) ? (double) $row[$startcol + 6] : null;
            $this->bank_frequent_operation_id = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->id = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
            $this->created_at = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
            $this->updated_at = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 11; // 11 = BankOperationPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating BankOperation object", $e);
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

        if ($this->aBankAccount !== null && $this->bank_account_id !== $this->aBankAccount->getId()) {
            $this->aBankAccount = null;
        }
        if ($this->aBankPayee !== null && $this->bank_payee_id !== $this->aBankPayee->getId()) {
            $this->aBankPayee = null;
        }
        if ($this->aBankCategory !== null && $this->bank_category_id !== $this->aBankCategory->getId()) {
            $this->aBankCategory = null;
        }
        if ($this->aBankFrequentOperation !== null && $this->bank_frequent_operation_id !== $this->aBankFrequentOperation->getId()) {
            $this->aBankFrequentOperation = null;
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
            $con = Propel::getConnection(BankOperationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = BankOperationPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aBankAccount = null;
            $this->aBankPayee = null;
            $this->aBankCategory = null;
            $this->aBankFrequentOperation = null;
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
            $con = Propel::getConnection(BankOperationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = BankOperationQuery::create()
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
            $con = Propel::getConnection(BankOperationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
        // timestampable behavior
        if (!$this->isColumnModified(BankOperationPeer::CREATED_AT))
        {
            $this->setCreatedAt(time());
        }
        if (!$this->isColumnModified(BankOperationPeer::UPDATED_AT))
        {
            $this->setUpdatedAt(time());
        }
            } else {
                $ret = $ret && $this->preUpdate($con);
        // timestampable behavior
        if ($this->isModified() && !$this->isColumnModified(BankOperationPeer::UPDATED_AT))
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
                BankOperationPeer::addInstanceToPool($this);
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

            if ($this->aBankAccount !== null) {
                if ($this->aBankAccount->isModified() || $this->aBankAccount->isNew()) {
                    $affectedRows += $this->aBankAccount->save($con);
                }
                $this->setBankAccount($this->aBankAccount);
            }

            if ($this->aBankPayee !== null) {
                if ($this->aBankPayee->isModified() || $this->aBankPayee->isNew()) {
                    $affectedRows += $this->aBankPayee->save($con);
                }
                $this->setBankPayee($this->aBankPayee);
            }

            if ($this->aBankCategory !== null) {
                if ($this->aBankCategory->isModified() || $this->aBankCategory->isNew()) {
                    $affectedRows += $this->aBankCategory->save($con);
                }
                $this->setBankCategory($this->aBankCategory);
            }

            if ($this->aBankFrequentOperation !== null) {
                if ($this->aBankFrequentOperation->isModified() || $this->aBankFrequentOperation->isNew()) {
                    $affectedRows += $this->aBankFrequentOperation->save($con);
                }
                $this->setBankFrequentOperation($this->aBankFrequentOperation);
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

        $this->modifiedColumns[] = BankOperationPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . BankOperationPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(BankOperationPeer::BANK_ACCOUNT_ID)) {
            $modifiedColumns[':p' . $index++]  = '`bank_account_id`';
        }
        if ($this->isColumnModified(BankOperationPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(BankOperationPeer::DATE)) {
            $modifiedColumns[':p' . $index++]  = '`date`';
        }
        if ($this->isColumnModified(BankOperationPeer::BANK_PAYEE_ID)) {
            $modifiedColumns[':p' . $index++]  = '`bank_payee_id`';
        }
        if ($this->isColumnModified(BankOperationPeer::BANK_CATEGORY_ID)) {
            $modifiedColumns[':p' . $index++]  = '`bank_category_id`';
        }
        if ($this->isColumnModified(BankOperationPeer::PAYMENT)) {
            $modifiedColumns[':p' . $index++]  = '`payment`';
        }
        if ($this->isColumnModified(BankOperationPeer::DEPOSIT)) {
            $modifiedColumns[':p' . $index++]  = '`deposit`';
        }
        if ($this->isColumnModified(BankOperationPeer::BANK_FREQUENT_OPERATION_ID)) {
            $modifiedColumns[':p' . $index++]  = '`bank_frequent_operation_id`';
        }
        if ($this->isColumnModified(BankOperationPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(BankOperationPeer::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }
        if ($this->isColumnModified(BankOperationPeer::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`updated_at`';
        }

        $sql = sprintf(
            'INSERT INTO `bank_operation` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`bank_account_id`':
            $stmt->bindValue($identifier, $this->bank_account_id, PDO::PARAM_INT);
                        break;
                    case '`name`':
            $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`date`':
            $stmt->bindValue($identifier, $this->date, PDO::PARAM_STR);
                        break;
                    case '`bank_payee_id`':
            $stmt->bindValue($identifier, $this->bank_payee_id, PDO::PARAM_INT);
                        break;
                    case '`bank_category_id`':
            $stmt->bindValue($identifier, $this->bank_category_id, PDO::PARAM_INT);
                        break;
                    case '`payment`':
            $stmt->bindValue($identifier, $this->payment, PDO::PARAM_STR);
                        break;
                    case '`deposit`':
            $stmt->bindValue($identifier, $this->deposit, PDO::PARAM_STR);
                        break;
                    case '`bank_frequent_operation_id`':
            $stmt->bindValue($identifier, $this->bank_frequent_operation_id, PDO::PARAM_INT);
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

            if ($this->aBankAccount !== null) {
                if (!$this->aBankAccount->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aBankAccount->getValidationFailures());
                }
            }

            if ($this->aBankPayee !== null) {
                if (!$this->aBankPayee->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aBankPayee->getValidationFailures());
                }
            }

            if ($this->aBankCategory !== null) {
                if (!$this->aBankCategory->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aBankCategory->getValidationFailures());
                }
            }

            if ($this->aBankFrequentOperation !== null) {
                if (!$this->aBankFrequentOperation->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aBankFrequentOperation->getValidationFailures());
                }
            }


            if (($retval = BankOperationPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
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
        $pos = BankOperationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getBankAccountId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getDate();
                break;
            case 3:
                return $this->getBankPayeeId();
                break;
            case 4:
                return $this->getBankCategoryId();
                break;
            case 5:
                return $this->getPayment();
                break;
            case 6:
                return $this->getDeposit();
                break;
            case 7:
                return $this->getBankFrequentOperationId();
                break;
            case 8:
                return $this->getId();
                break;
            case 9:
                return $this->getCreatedAt();
                break;
            case 10:
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
        if (isset($alreadyDumpedObjects['BankOperation'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['BankOperation'][$this->getPrimaryKey()] = true;
        $keys = BankOperationPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getBankAccountId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getDate(),
            $keys[3] => $this->getBankPayeeId(),
            $keys[4] => $this->getBankCategoryId(),
            $keys[5] => $this->getPayment(),
            $keys[6] => $this->getDeposit(),
            $keys[7] => $this->getBankFrequentOperationId(),
            $keys[8] => $this->getId(),
            $keys[9] => $this->getCreatedAt(),
            $keys[10] => $this->getUpdatedAt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aBankAccount) {
                $result['BankAccount'] = $this->aBankAccount->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aBankPayee) {
                $result['BankPayee'] = $this->aBankPayee->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aBankCategory) {
                $result['BankCategory'] = $this->aBankCategory->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aBankFrequentOperation) {
                $result['BankFrequentOperation'] = $this->aBankFrequentOperation->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
        $pos = BankOperationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setBankAccountId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setDate($value);
                break;
            case 3:
                $this->setBankPayeeId($value);
                break;
            case 4:
                $this->setBankCategoryId($value);
                break;
            case 5:
                $this->setPayment($value);
                break;
            case 6:
                $this->setDeposit($value);
                break;
            case 7:
                $this->setBankFrequentOperationId($value);
                break;
            case 8:
                $this->setId($value);
                break;
            case 9:
                $this->setCreatedAt($value);
                break;
            case 10:
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
        $keys = BankOperationPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setBankAccountId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setDate($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setBankPayeeId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setBankCategoryId($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setPayment($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setDeposit($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setBankFrequentOperationId($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setId($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setCreatedAt($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setUpdatedAt($arr[$keys[10]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(BankOperationPeer::DATABASE_NAME);

        if ($this->isColumnModified(BankOperationPeer::BANK_ACCOUNT_ID)) $criteria->add(BankOperationPeer::BANK_ACCOUNT_ID, $this->bank_account_id);
        if ($this->isColumnModified(BankOperationPeer::NAME)) $criteria->add(BankOperationPeer::NAME, $this->name);
        if ($this->isColumnModified(BankOperationPeer::DATE)) $criteria->add(BankOperationPeer::DATE, $this->date);
        if ($this->isColumnModified(BankOperationPeer::BANK_PAYEE_ID)) $criteria->add(BankOperationPeer::BANK_PAYEE_ID, $this->bank_payee_id);
        if ($this->isColumnModified(BankOperationPeer::BANK_CATEGORY_ID)) $criteria->add(BankOperationPeer::BANK_CATEGORY_ID, $this->bank_category_id);
        if ($this->isColumnModified(BankOperationPeer::PAYMENT)) $criteria->add(BankOperationPeer::PAYMENT, $this->payment);
        if ($this->isColumnModified(BankOperationPeer::DEPOSIT)) $criteria->add(BankOperationPeer::DEPOSIT, $this->deposit);
        if ($this->isColumnModified(BankOperationPeer::BANK_FREQUENT_OPERATION_ID)) $criteria->add(BankOperationPeer::BANK_FREQUENT_OPERATION_ID, $this->bank_frequent_operation_id);
        if ($this->isColumnModified(BankOperationPeer::ID)) $criteria->add(BankOperationPeer::ID, $this->id);
        if ($this->isColumnModified(BankOperationPeer::CREATED_AT)) $criteria->add(BankOperationPeer::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(BankOperationPeer::UPDATED_AT)) $criteria->add(BankOperationPeer::UPDATED_AT, $this->updated_at);

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
        $criteria = new Criteria(BankOperationPeer::DATABASE_NAME);
        $criteria->add(BankOperationPeer::ID, $this->id);

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
     * @param object $copyObj An object of BankOperation (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setBankAccountId($this->getBankAccountId());
        $copyObj->setName($this->getName());
        $copyObj->setDate($this->getDate());
        $copyObj->setBankPayeeId($this->getBankPayeeId());
        $copyObj->setBankCategoryId($this->getBankCategoryId());
        $copyObj->setPayment($this->getPayment());
        $copyObj->setDeposit($this->getDeposit());
        $copyObj->setBankFrequentOperationId($this->getBankFrequentOperationId());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

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
     * @return BankOperation Clone of current object.
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
     * @return BankOperationPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new BankOperationPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a BankAccount object.
     *
     * @param                  BankAccount $v
     * @return BankOperation The current object (for fluent API support)
     * @throws PropelException
     */
    public function setBankAccount(BankAccount $v = null)
    {
        if ($v === null) {
            $this->setBankAccountId(NULL);
        } else {
            $this->setBankAccountId($v->getId());
        }

        $this->aBankAccount = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the BankAccount object, it will not be re-added.
        if ($v !== null) {
            $v->addBankOperation($this);
        }


        return $this;
    }


    /**
     * Get the associated BankAccount object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return BankAccount The associated BankAccount object.
     * @throws PropelException
     */
    public function getBankAccount(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aBankAccount === null && ($this->bank_account_id !== null) && $doQuery) {
            $this->aBankAccount = BankAccountQuery::create()->findPk($this->bank_account_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aBankAccount->addBankOperations($this);
             */
        }

        return $this->aBankAccount;
    }

    /**
     * Declares an association between this object and a BankPayee object.
     *
     * @param                  BankPayee $v
     * @return BankOperation The current object (for fluent API support)
     * @throws PropelException
     */
    public function setBankPayee(BankPayee $v = null)
    {
        if ($v === null) {
            $this->setBankPayeeId(NULL);
        } else {
            $this->setBankPayeeId($v->getId());
        }

        $this->aBankPayee = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the BankPayee object, it will not be re-added.
        if ($v !== null) {
            $v->addBankOperation($this);
        }


        return $this;
    }


    /**
     * Get the associated BankPayee object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return BankPayee The associated BankPayee object.
     * @throws PropelException
     */
    public function getBankPayee(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aBankPayee === null && ($this->bank_payee_id !== null) && $doQuery) {
            $this->aBankPayee = BankPayeeQuery::create()->findPk($this->bank_payee_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aBankPayee->addBankOperations($this);
             */
        }

        return $this->aBankPayee;
    }

    /**
     * Declares an association between this object and a BankCategory object.
     *
     * @param                  BankCategory $v
     * @return BankOperation The current object (for fluent API support)
     * @throws PropelException
     */
    public function setBankCategory(BankCategory $v = null)
    {
        if ($v === null) {
            $this->setBankCategoryId(NULL);
        } else {
            $this->setBankCategoryId($v->getId());
        }

        $this->aBankCategory = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the BankCategory object, it will not be re-added.
        if ($v !== null) {
            $v->addBankOperation($this);
        }


        return $this;
    }


    /**
     * Get the associated BankCategory object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return BankCategory The associated BankCategory object.
     * @throws PropelException
     */
    public function getBankCategory(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aBankCategory === null && ($this->bank_category_id !== null) && $doQuery) {
            $this->aBankCategory = BankCategoryQuery::create()->findPk($this->bank_category_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aBankCategory->addBankOperations($this);
             */
        }

        return $this->aBankCategory;
    }

    /**
     * Declares an association between this object and a BankFrequentOperation object.
     *
     * @param                  BankFrequentOperation $v
     * @return BankOperation The current object (for fluent API support)
     * @throws PropelException
     */
    public function setBankFrequentOperation(BankFrequentOperation $v = null)
    {
        if ($v === null) {
            $this->setBankFrequentOperationId(NULL);
        } else {
            $this->setBankFrequentOperationId($v->getId());
        }

        $this->aBankFrequentOperation = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the BankFrequentOperation object, it will not be re-added.
        if ($v !== null) {
            $v->addBankOperation($this);
        }


        return $this;
    }


    /**
     * Get the associated BankFrequentOperation object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return BankFrequentOperation The associated BankFrequentOperation object.
     * @throws PropelException
     */
    public function getBankFrequentOperation(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aBankFrequentOperation === null && ($this->bank_frequent_operation_id !== null) && $doQuery) {
            $this->aBankFrequentOperation = BankFrequentOperationQuery::create()->findPk($this->bank_frequent_operation_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aBankFrequentOperation->addBankOperations($this);
             */
        }

        return $this->aBankFrequentOperation;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->bank_account_id = null;
        $this->name = null;
        $this->date = null;
        $this->bank_payee_id = null;
        $this->bank_category_id = null;
        $this->payment = null;
        $this->deposit = null;
        $this->bank_frequent_operation_id = null;
        $this->id = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
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
            if ($this->aBankAccount instanceof Persistent) {
              $this->aBankAccount->clearAllReferences($deep);
            }
            if ($this->aBankPayee instanceof Persistent) {
              $this->aBankPayee->clearAllReferences($deep);
            }
            if ($this->aBankCategory instanceof Persistent) {
              $this->aBankCategory->clearAllReferences($deep);
            }
            if ($this->aBankFrequentOperation instanceof Persistent) {
              $this->aBankFrequentOperation->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        $this->aBankAccount = null;
        $this->aBankPayee = null;
        $this->aBankCategory = null;
        $this->aBankFrequentOperation = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(BankOperationPeer::DEFAULT_STRING_FORMAT);
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
   * @return     BankOperation The current object (for fluent API support)
   */
  public function keepUpdateDateUnchanged()
  {
      $this->modifiedColumns[] = BankOperationPeer::UPDATED_AT;

      return $this;
  }

}
