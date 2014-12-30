<?php

namespace Sbh\MusicBundle\Model\om;

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
use Sbh\MusicBundle\Model\MusicFile;
use Sbh\MusicBundle\Model\MusicFilePeer;
use Sbh\MusicBundle\Model\MusicFileQuery;
use Sbh\MusicBundle\Model\MusicOriginalTag;
use Sbh\MusicBundle\Model\MusicOriginalTagQuery;
use Sbh\MusicBundle\Model\MusicTrack;
use Sbh\MusicBundle\Model\MusicTrackQuery;
use Sbh\StartBundle\Model\File;
use Sbh\StartBundle\Model\FileQuery;

abstract class BaseMusicFile extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Sbh\\MusicBundle\\Model\\MusicFilePeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        MusicFilePeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the file_id field.
     * @var        int
     */
    protected $file_id;

    /**
     * The value for the track_id field.
     * @var        int
     */
    protected $track_id;

    /**
     * The value for the scan_original_tag field.
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $scan_original_tag;

    /**
     * The value for the associate_tags field.
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $associate_tags;

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
     * @var        File
     */
    protected $aFile;

    /**
     * @var        MusicTrack
     */
    protected $aMusicTrack;

    /**
     * @var        PropelObjectCollection|MusicOriginalTag[] Collection to store aggregation of MusicOriginalTag objects.
     */
    protected $collMusicOriginalTags;
    protected $collMusicOriginalTagsPartial;

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
    protected $musicOriginalTagsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->scan_original_tag = true;
        $this->associate_tags = true;
    }

    /**
     * Initializes internal state of BaseMusicFile object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [file_id] column value.
     *
     * @return int
     */
    public function getFileId()
    {

        return $this->file_id;
    }

    /**
     * Get the [track_id] column value.
     *
     * @return int
     */
    public function getTrackId()
    {

        return $this->track_id;
    }

    /**
     * Get the [scan_original_tag] column value.
     *
     * @return boolean
     */
    public function getScanOriginalTag()
    {

        return $this->scan_original_tag;
    }

    /**
     * Get the [associate_tags] column value.
     *
     * @return boolean
     */
    public function getAssociateTags()
    {

        return $this->associate_tags;
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
     * Set the value of [file_id] column.
     *
     * @param  int $v new value
     * @return MusicFile The current object (for fluent API support)
     */
    public function setFileId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->file_id !== $v) {
            $this->file_id = $v;
            $this->modifiedColumns[] = MusicFilePeer::FILE_ID;
        }

        if ($this->aFile !== null && $this->aFile->getId() !== $v) {
            $this->aFile = null;
        }


        return $this;
    } // setFileId()

    /**
     * Set the value of [track_id] column.
     *
     * @param  int $v new value
     * @return MusicFile The current object (for fluent API support)
     */
    public function setTrackId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->track_id !== $v) {
            $this->track_id = $v;
            $this->modifiedColumns[] = MusicFilePeer::TRACK_ID;
        }

        if ($this->aMusicTrack !== null && $this->aMusicTrack->getId() !== $v) {
            $this->aMusicTrack = null;
        }


        return $this;
    } // setTrackId()

    /**
     * Sets the value of the [scan_original_tag] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return MusicFile The current object (for fluent API support)
     */
    public function setScanOriginalTag($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->scan_original_tag !== $v) {
            $this->scan_original_tag = $v;
            $this->modifiedColumns[] = MusicFilePeer::SCAN_ORIGINAL_TAG;
        }


        return $this;
    } // setScanOriginalTag()

    /**
     * Sets the value of the [associate_tags] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return MusicFile The current object (for fluent API support)
     */
    public function setAssociateTags($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->associate_tags !== $v) {
            $this->associate_tags = $v;
            $this->modifiedColumns[] = MusicFilePeer::ASSOCIATE_TAGS;
        }


        return $this;
    } // setAssociateTags()

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return MusicFile The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = MusicFilePeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return MusicFile The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            $currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->created_at = $newDateAsString;
                $this->modifiedColumns[] = MusicFilePeer::CREATED_AT;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return MusicFile The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            $currentDateAsString = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->updated_at = $newDateAsString;
                $this->modifiedColumns[] = MusicFilePeer::UPDATED_AT;
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
            if ($this->scan_original_tag !== true) {
                return false;
            }

            if ($this->associate_tags !== true) {
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

            $this->file_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->track_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->scan_original_tag = ($row[$startcol + 2] !== null) ? (boolean) $row[$startcol + 2] : null;
            $this->associate_tags = ($row[$startcol + 3] !== null) ? (boolean) $row[$startcol + 3] : null;
            $this->id = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->created_at = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->updated_at = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 7; // 7 = MusicFilePeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating MusicFile object", $e);
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

        if ($this->aFile !== null && $this->file_id !== $this->aFile->getId()) {
            $this->aFile = null;
        }
        if ($this->aMusicTrack !== null && $this->track_id !== $this->aMusicTrack->getId()) {
            $this->aMusicTrack = null;
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
            $con = Propel::getConnection(MusicFilePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = MusicFilePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aFile = null;
            $this->aMusicTrack = null;
            $this->collMusicOriginalTags = null;

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
            $con = Propel::getConnection(MusicFilePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = MusicFileQuery::create()
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
            $con = Propel::getConnection(MusicFilePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
        // timestampable behavior
        if (!$this->isColumnModified(MusicFilePeer::CREATED_AT))
        {
            $this->setCreatedAt(time());
        }
        if (!$this->isColumnModified(MusicFilePeer::UPDATED_AT))
        {
            $this->setUpdatedAt(time());
        }
            } else {
                $ret = $ret && $this->preUpdate($con);
        // timestampable behavior
        if ($this->isModified() && !$this->isColumnModified(MusicFilePeer::UPDATED_AT))
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
                MusicFilePeer::addInstanceToPool($this);
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

            if ($this->aFile !== null) {
                if ($this->aFile->isModified() || $this->aFile->isNew()) {
                    $affectedRows += $this->aFile->save($con);
                }
                $this->setFile($this->aFile);
            }

            if ($this->aMusicTrack !== null) {
                if ($this->aMusicTrack->isModified() || $this->aMusicTrack->isNew()) {
                    $affectedRows += $this->aMusicTrack->save($con);
                }
                $this->setMusicTrack($this->aMusicTrack);
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

            if ($this->musicOriginalTagsScheduledForDeletion !== null) {
                if (!$this->musicOriginalTagsScheduledForDeletion->isEmpty()) {
                    foreach ($this->musicOriginalTagsScheduledForDeletion as $musicOriginalTag) {
                        // need to save related object because we set the relation to null
                        $musicOriginalTag->save($con);
                    }
                    $this->musicOriginalTagsScheduledForDeletion = null;
                }
            }

            if ($this->collMusicOriginalTags !== null) {
                foreach ($this->collMusicOriginalTags as $referrerFK) {
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

        $this->modifiedColumns[] = MusicFilePeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . MusicFilePeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(MusicFilePeer::FILE_ID)) {
            $modifiedColumns[':p' . $index++]  = '`file_id`';
        }
        if ($this->isColumnModified(MusicFilePeer::TRACK_ID)) {
            $modifiedColumns[':p' . $index++]  = '`track_id`';
        }
        if ($this->isColumnModified(MusicFilePeer::SCAN_ORIGINAL_TAG)) {
            $modifiedColumns[':p' . $index++]  = '`scan_original_tag`';
        }
        if ($this->isColumnModified(MusicFilePeer::ASSOCIATE_TAGS)) {
            $modifiedColumns[':p' . $index++]  = '`associate_tags`';
        }
        if ($this->isColumnModified(MusicFilePeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(MusicFilePeer::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }
        if ($this->isColumnModified(MusicFilePeer::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`updated_at`';
        }

        $sql = sprintf(
            'INSERT INTO `music_file` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`file_id`':
            $stmt->bindValue($identifier, $this->file_id, PDO::PARAM_INT);
                        break;
                    case '`track_id`':
            $stmt->bindValue($identifier, $this->track_id, PDO::PARAM_INT);
                        break;
                    case '`scan_original_tag`':
            $stmt->bindValue($identifier, (int) $this->scan_original_tag, PDO::PARAM_INT);
                        break;
                    case '`associate_tags`':
            $stmt->bindValue($identifier, (int) $this->associate_tags, PDO::PARAM_INT);
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

            if ($this->aFile !== null) {
                if (!$this->aFile->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aFile->getValidationFailures());
                }
            }

            if ($this->aMusicTrack !== null) {
                if (!$this->aMusicTrack->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aMusicTrack->getValidationFailures());
                }
            }


            if (($retval = MusicFilePeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collMusicOriginalTags !== null) {
                    foreach ($this->collMusicOriginalTags as $referrerFK) {
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
        $pos = MusicFilePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getFileId();
                break;
            case 1:
                return $this->getTrackId();
                break;
            case 2:
                return $this->getScanOriginalTag();
                break;
            case 3:
                return $this->getAssociateTags();
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
        if (isset($alreadyDumpedObjects['MusicFile'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['MusicFile'][$this->getPrimaryKey()] = true;
        $keys = MusicFilePeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getFileId(),
            $keys[1] => $this->getTrackId(),
            $keys[2] => $this->getScanOriginalTag(),
            $keys[3] => $this->getAssociateTags(),
            $keys[4] => $this->getId(),
            $keys[5] => $this->getCreatedAt(),
            $keys[6] => $this->getUpdatedAt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aFile) {
                $result['File'] = $this->aFile->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aMusicTrack) {
                $result['MusicTrack'] = $this->aMusicTrack->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collMusicOriginalTags) {
                $result['MusicOriginalTags'] = $this->collMusicOriginalTags->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = MusicFilePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setFileId($value);
                break;
            case 1:
                $this->setTrackId($value);
                break;
            case 2:
                $this->setScanOriginalTag($value);
                break;
            case 3:
                $this->setAssociateTags($value);
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
        $keys = MusicFilePeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setFileId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setTrackId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setScanOriginalTag($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setAssociateTags($arr[$keys[3]]);
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
        $criteria = new Criteria(MusicFilePeer::DATABASE_NAME);

        if ($this->isColumnModified(MusicFilePeer::FILE_ID)) $criteria->add(MusicFilePeer::FILE_ID, $this->file_id);
        if ($this->isColumnModified(MusicFilePeer::TRACK_ID)) $criteria->add(MusicFilePeer::TRACK_ID, $this->track_id);
        if ($this->isColumnModified(MusicFilePeer::SCAN_ORIGINAL_TAG)) $criteria->add(MusicFilePeer::SCAN_ORIGINAL_TAG, $this->scan_original_tag);
        if ($this->isColumnModified(MusicFilePeer::ASSOCIATE_TAGS)) $criteria->add(MusicFilePeer::ASSOCIATE_TAGS, $this->associate_tags);
        if ($this->isColumnModified(MusicFilePeer::ID)) $criteria->add(MusicFilePeer::ID, $this->id);
        if ($this->isColumnModified(MusicFilePeer::CREATED_AT)) $criteria->add(MusicFilePeer::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(MusicFilePeer::UPDATED_AT)) $criteria->add(MusicFilePeer::UPDATED_AT, $this->updated_at);

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
        $criteria = new Criteria(MusicFilePeer::DATABASE_NAME);
        $criteria->add(MusicFilePeer::ID, $this->id);

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
     * @param object $copyObj An object of MusicFile (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setFileId($this->getFileId());
        $copyObj->setTrackId($this->getTrackId());
        $copyObj->setScanOriginalTag($this->getScanOriginalTag());
        $copyObj->setAssociateTags($this->getAssociateTags());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getMusicOriginalTags() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMusicOriginalTag($relObj->copy($deepCopy));
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
     * @return MusicFile Clone of current object.
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
     * @return MusicFilePeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new MusicFilePeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a File object.
     *
     * @param                  File $v
     * @return MusicFile The current object (for fluent API support)
     * @throws PropelException
     */
    public function setFile(File $v = null)
    {
        if ($v === null) {
            $this->setFileId(NULL);
        } else {
            $this->setFileId($v->getId());
        }

        $this->aFile = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the File object, it will not be re-added.
        if ($v !== null) {
            $v->addMusicFile($this);
        }


        return $this;
    }


    /**
     * Get the associated File object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return File The associated File object.
     * @throws PropelException
     */
    public function getFile(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aFile === null && ($this->file_id !== null) && $doQuery) {
            $this->aFile = FileQuery::create()->findPk($this->file_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aFile->addMusicFiles($this);
             */
        }

        return $this->aFile;
    }

    /**
     * Declares an association between this object and a MusicTrack object.
     *
     * @param                  MusicTrack $v
     * @return MusicFile The current object (for fluent API support)
     * @throws PropelException
     */
    public function setMusicTrack(MusicTrack $v = null)
    {
        if ($v === null) {
            $this->setTrackId(NULL);
        } else {
            $this->setTrackId($v->getId());
        }

        $this->aMusicTrack = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the MusicTrack object, it will not be re-added.
        if ($v !== null) {
            $v->addMusicFile($this);
        }


        return $this;
    }


    /**
     * Get the associated MusicTrack object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return MusicTrack The associated MusicTrack object.
     * @throws PropelException
     */
    public function getMusicTrack(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aMusicTrack === null && ($this->track_id !== null) && $doQuery) {
            $this->aMusicTrack = MusicTrackQuery::create()->findPk($this->track_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aMusicTrack->addMusicFiles($this);
             */
        }

        return $this->aMusicTrack;
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
        if ('MusicOriginalTag' == $relationName) {
            $this->initMusicOriginalTags();
        }
    }

    /**
     * Clears out the collMusicOriginalTags collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return MusicFile The current object (for fluent API support)
     * @see        addMusicOriginalTags()
     */
    public function clearMusicOriginalTags()
    {
        $this->collMusicOriginalTags = null; // important to set this to null since that means it is uninitialized
        $this->collMusicOriginalTagsPartial = null;

        return $this;
    }

    /**
     * reset is the collMusicOriginalTags collection loaded partially
     *
     * @return void
     */
    public function resetPartialMusicOriginalTags($v = true)
    {
        $this->collMusicOriginalTagsPartial = $v;
    }

    /**
     * Initializes the collMusicOriginalTags collection.
     *
     * By default this just sets the collMusicOriginalTags collection to an empty array (like clearcollMusicOriginalTags());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMusicOriginalTags($overrideExisting = true)
    {
        if (null !== $this->collMusicOriginalTags && !$overrideExisting) {
            return;
        }
        $this->collMusicOriginalTags = new PropelObjectCollection();
        $this->collMusicOriginalTags->setModel('MusicOriginalTag');
    }

    /**
     * Gets an array of MusicOriginalTag objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this MusicFile is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|MusicOriginalTag[] List of MusicOriginalTag objects
     * @throws PropelException
     */
    public function getMusicOriginalTags($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collMusicOriginalTagsPartial && !$this->isNew();
        if (null === $this->collMusicOriginalTags || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMusicOriginalTags) {
                // return empty collection
                $this->initMusicOriginalTags();
            } else {
                $collMusicOriginalTags = MusicOriginalTagQuery::create(null, $criteria)
                    ->filterByMusicFile($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collMusicOriginalTagsPartial && count($collMusicOriginalTags)) {
                      $this->initMusicOriginalTags(false);

                      foreach ($collMusicOriginalTags as $obj) {
                        if (false == $this->collMusicOriginalTags->contains($obj)) {
                          $this->collMusicOriginalTags->append($obj);
                        }
                      }

                      $this->collMusicOriginalTagsPartial = true;
                    }

                    $collMusicOriginalTags->getInternalIterator()->rewind();

                    return $collMusicOriginalTags;
                }

                if ($partial && $this->collMusicOriginalTags) {
                    foreach ($this->collMusicOriginalTags as $obj) {
                        if ($obj->isNew()) {
                            $collMusicOriginalTags[] = $obj;
                        }
                    }
                }

                $this->collMusicOriginalTags = $collMusicOriginalTags;
                $this->collMusicOriginalTagsPartial = false;
            }
        }

        return $this->collMusicOriginalTags;
    }

    /**
     * Sets a collection of MusicOriginalTag objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $musicOriginalTags A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return MusicFile The current object (for fluent API support)
     */
    public function setMusicOriginalTags(PropelCollection $musicOriginalTags, PropelPDO $con = null)
    {
        $musicOriginalTagsToDelete = $this->getMusicOriginalTags(new Criteria(), $con)->diff($musicOriginalTags);


        $this->musicOriginalTagsScheduledForDeletion = $musicOriginalTagsToDelete;

        foreach ($musicOriginalTagsToDelete as $musicOriginalTagRemoved) {
            $musicOriginalTagRemoved->setMusicFile(null);
        }

        $this->collMusicOriginalTags = null;
        foreach ($musicOriginalTags as $musicOriginalTag) {
            $this->addMusicOriginalTag($musicOriginalTag);
        }

        $this->collMusicOriginalTags = $musicOriginalTags;
        $this->collMusicOriginalTagsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related MusicOriginalTag objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related MusicOriginalTag objects.
     * @throws PropelException
     */
    public function countMusicOriginalTags(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collMusicOriginalTagsPartial && !$this->isNew();
        if (null === $this->collMusicOriginalTags || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMusicOriginalTags) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMusicOriginalTags());
            }
            $query = MusicOriginalTagQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMusicFile($this)
                ->count($con);
        }

        return count($this->collMusicOriginalTags);
    }

    /**
     * Method called to associate a MusicOriginalTag object to this object
     * through the MusicOriginalTag foreign key attribute.
     *
     * @param    MusicOriginalTag $l MusicOriginalTag
     * @return MusicFile The current object (for fluent API support)
     */
    public function addMusicOriginalTag(MusicOriginalTag $l)
    {
        if ($this->collMusicOriginalTags === null) {
            $this->initMusicOriginalTags();
            $this->collMusicOriginalTagsPartial = true;
        }

        if (!in_array($l, $this->collMusicOriginalTags->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddMusicOriginalTag($l);

            if ($this->musicOriginalTagsScheduledForDeletion and $this->musicOriginalTagsScheduledForDeletion->contains($l)) {
                $this->musicOriginalTagsScheduledForDeletion->remove($this->musicOriginalTagsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param  MusicOriginalTag $musicOriginalTag The musicOriginalTag object to add.
     */
    protected function doAddMusicOriginalTag($musicOriginalTag)
    {
        $this->collMusicOriginalTags[]= $musicOriginalTag;
        $musicOriginalTag->setMusicFile($this);
    }

    /**
     * @param  MusicOriginalTag $musicOriginalTag The musicOriginalTag object to remove.
     * @return MusicFile The current object (for fluent API support)
     */
    public function removeMusicOriginalTag($musicOriginalTag)
    {
        if ($this->getMusicOriginalTags()->contains($musicOriginalTag)) {
            $this->collMusicOriginalTags->remove($this->collMusicOriginalTags->search($musicOriginalTag));
            if (null === $this->musicOriginalTagsScheduledForDeletion) {
                $this->musicOriginalTagsScheduledForDeletion = clone $this->collMusicOriginalTags;
                $this->musicOriginalTagsScheduledForDeletion->clear();
            }
            $this->musicOriginalTagsScheduledForDeletion[]= $musicOriginalTag;
            $musicOriginalTag->setMusicFile(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->file_id = null;
        $this->track_id = null;
        $this->scan_original_tag = null;
        $this->associate_tags = null;
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
            if ($this->collMusicOriginalTags) {
                foreach ($this->collMusicOriginalTags as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aFile instanceof Persistent) {
              $this->aFile->clearAllReferences($deep);
            }
            if ($this->aMusicTrack instanceof Persistent) {
              $this->aMusicTrack->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collMusicOriginalTags instanceof PropelCollection) {
            $this->collMusicOriginalTags->clearIterator();
        }
        $this->collMusicOriginalTags = null;
        $this->aFile = null;
        $this->aMusicTrack = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(MusicFilePeer::DEFAULT_STRING_FORMAT);
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
   * @return     MusicFile The current object (for fluent API support)
   */
  public function keepUpdateDateUnchanged()
  {
      $this->modifiedColumns[] = MusicFilePeer::UPDATED_AT;

      return $this;
  }

}
