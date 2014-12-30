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
use Sbh\MusicBundle\Model\MusicAlbum;
use Sbh\MusicBundle\Model\MusicAlbumQuery;
use Sbh\MusicBundle\Model\MusicArtist;
use Sbh\MusicBundle\Model\MusicArtistQuery;
use Sbh\MusicBundle\Model\MusicFile;
use Sbh\MusicBundle\Model\MusicFileQuery;
use Sbh\MusicBundle\Model\MusicTrack;
use Sbh\MusicBundle\Model\MusicTrackPeer;
use Sbh\MusicBundle\Model\MusicTrackQuery;

abstract class BaseMusicTrack extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Sbh\\MusicBundle\\Model\\MusicTrackPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        MusicTrackPeer
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
     * The value for the track field.
     * @var        int
     */
    protected $track;

    /**
     * The value for the disc field.
     * @var        int
     */
    protected $disc;

    /**
     * The value for the artist_id field.
     * @var        int
     */
    protected $artist_id;

    /**
     * The value for the album_id field.
     * @var        int
     */
    protected $album_id;

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
     * @var        MusicArtist
     */
    protected $aMusicArtist;

    /**
     * @var        MusicAlbum
     */
    protected $aMusicAlbum;

    /**
     * @var        PropelObjectCollection|MusicFile[] Collection to store aggregation of MusicFile objects.
     */
    protected $collMusicFiles;
    protected $collMusicFilesPartial;

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
    protected $musicFilesScheduledForDeletion = null;

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
     * Get the [track] column value.
     *
     * @return int
     */
    public function getTrack()
    {

        return $this->track;
    }

    /**
     * Get the [disc] column value.
     *
     * @return int
     */
    public function getDisc()
    {

        return $this->disc;
    }

    /**
     * Get the [artist_id] column value.
     *
     * @return int
     */
    public function getArtistId()
    {

        return $this->artist_id;
    }

    /**
     * Get the [album_id] column value.
     *
     * @return int
     */
    public function getAlbumId()
    {

        return $this->album_id;
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
     * @return MusicTrack The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = MusicTrackPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [track] column.
     *
     * @param  int $v new value
     * @return MusicTrack The current object (for fluent API support)
     */
    public function setTrack($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->track !== $v) {
            $this->track = $v;
            $this->modifiedColumns[] = MusicTrackPeer::TRACK;
        }


        return $this;
    } // setTrack()

    /**
     * Set the value of [disc] column.
     *
     * @param  int $v new value
     * @return MusicTrack The current object (for fluent API support)
     */
    public function setDisc($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->disc !== $v) {
            $this->disc = $v;
            $this->modifiedColumns[] = MusicTrackPeer::DISC;
        }


        return $this;
    } // setDisc()

    /**
     * Set the value of [artist_id] column.
     *
     * @param  int $v new value
     * @return MusicTrack The current object (for fluent API support)
     */
    public function setArtistId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->artist_id !== $v) {
            $this->artist_id = $v;
            $this->modifiedColumns[] = MusicTrackPeer::ARTIST_ID;
        }

        if ($this->aMusicArtist !== null && $this->aMusicArtist->getId() !== $v) {
            $this->aMusicArtist = null;
        }


        return $this;
    } // setArtistId()

    /**
     * Set the value of [album_id] column.
     *
     * @param  int $v new value
     * @return MusicTrack The current object (for fluent API support)
     */
    public function setAlbumId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->album_id !== $v) {
            $this->album_id = $v;
            $this->modifiedColumns[] = MusicTrackPeer::ALBUM_ID;
        }

        if ($this->aMusicAlbum !== null && $this->aMusicAlbum->getId() !== $v) {
            $this->aMusicAlbum = null;
        }


        return $this;
    } // setAlbumId()

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return MusicTrack The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = MusicTrackPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return MusicTrack The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            $currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->created_at = $newDateAsString;
                $this->modifiedColumns[] = MusicTrackPeer::CREATED_AT;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return MusicTrack The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            $currentDateAsString = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->updated_at = $newDateAsString;
                $this->modifiedColumns[] = MusicTrackPeer::UPDATED_AT;
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

            $this->name = ($row[$startcol + 0] !== null) ? (string) $row[$startcol + 0] : null;
            $this->track = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->disc = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->artist_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->album_id = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->id = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->created_at = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->updated_at = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 8; // 8 = MusicTrackPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating MusicTrack object", $e);
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

        if ($this->aMusicArtist !== null && $this->artist_id !== $this->aMusicArtist->getId()) {
            $this->aMusicArtist = null;
        }
        if ($this->aMusicAlbum !== null && $this->album_id !== $this->aMusicAlbum->getId()) {
            $this->aMusicAlbum = null;
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
            $con = Propel::getConnection(MusicTrackPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = MusicTrackPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aMusicArtist = null;
            $this->aMusicAlbum = null;
            $this->collMusicFiles = null;

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
            $con = Propel::getConnection(MusicTrackPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = MusicTrackQuery::create()
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
            $con = Propel::getConnection(MusicTrackPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
        // timestampable behavior
        if (!$this->isColumnModified(MusicTrackPeer::CREATED_AT))
        {
            $this->setCreatedAt(time());
        }
        if (!$this->isColumnModified(MusicTrackPeer::UPDATED_AT))
        {
            $this->setUpdatedAt(time());
        }
            } else {
                $ret = $ret && $this->preUpdate($con);
        // timestampable behavior
        if ($this->isModified() && !$this->isColumnModified(MusicTrackPeer::UPDATED_AT))
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
                MusicTrackPeer::addInstanceToPool($this);
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

            if ($this->aMusicArtist !== null) {
                if ($this->aMusicArtist->isModified() || $this->aMusicArtist->isNew()) {
                    $affectedRows += $this->aMusicArtist->save($con);
                }
                $this->setMusicArtist($this->aMusicArtist);
            }

            if ($this->aMusicAlbum !== null) {
                if ($this->aMusicAlbum->isModified() || $this->aMusicAlbum->isNew()) {
                    $affectedRows += $this->aMusicAlbum->save($con);
                }
                $this->setMusicAlbum($this->aMusicAlbum);
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

            if ($this->musicFilesScheduledForDeletion !== null) {
                if (!$this->musicFilesScheduledForDeletion->isEmpty()) {
                    foreach ($this->musicFilesScheduledForDeletion as $musicFile) {
                        // need to save related object because we set the relation to null
                        $musicFile->save($con);
                    }
                    $this->musicFilesScheduledForDeletion = null;
                }
            }

            if ($this->collMusicFiles !== null) {
                foreach ($this->collMusicFiles as $referrerFK) {
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

        $this->modifiedColumns[] = MusicTrackPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . MusicTrackPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(MusicTrackPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(MusicTrackPeer::TRACK)) {
            $modifiedColumns[':p' . $index++]  = '`track`';
        }
        if ($this->isColumnModified(MusicTrackPeer::DISC)) {
            $modifiedColumns[':p' . $index++]  = '`disc`';
        }
        if ($this->isColumnModified(MusicTrackPeer::ARTIST_ID)) {
            $modifiedColumns[':p' . $index++]  = '`artist_id`';
        }
        if ($this->isColumnModified(MusicTrackPeer::ALBUM_ID)) {
            $modifiedColumns[':p' . $index++]  = '`album_id`';
        }
        if ($this->isColumnModified(MusicTrackPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(MusicTrackPeer::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }
        if ($this->isColumnModified(MusicTrackPeer::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`updated_at`';
        }

        $sql = sprintf(
            'INSERT INTO `music_track` (%s) VALUES (%s)',
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
                    case '`track`':
            $stmt->bindValue($identifier, $this->track, PDO::PARAM_INT);
                        break;
                    case '`disc`':
            $stmt->bindValue($identifier, $this->disc, PDO::PARAM_INT);
                        break;
                    case '`artist_id`':
            $stmt->bindValue($identifier, $this->artist_id, PDO::PARAM_INT);
                        break;
                    case '`album_id`':
            $stmt->bindValue($identifier, $this->album_id, PDO::PARAM_INT);
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

            if ($this->aMusicArtist !== null) {
                if (!$this->aMusicArtist->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aMusicArtist->getValidationFailures());
                }
            }

            if ($this->aMusicAlbum !== null) {
                if (!$this->aMusicAlbum->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aMusicAlbum->getValidationFailures());
                }
            }


            if (($retval = MusicTrackPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collMusicFiles !== null) {
                    foreach ($this->collMusicFiles as $referrerFK) {
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
        $pos = MusicTrackPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getTrack();
                break;
            case 2:
                return $this->getDisc();
                break;
            case 3:
                return $this->getArtistId();
                break;
            case 4:
                return $this->getAlbumId();
                break;
            case 5:
                return $this->getId();
                break;
            case 6:
                return $this->getCreatedAt();
                break;
            case 7:
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
        if (isset($alreadyDumpedObjects['MusicTrack'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['MusicTrack'][$this->getPrimaryKey()] = true;
        $keys = MusicTrackPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getName(),
            $keys[1] => $this->getTrack(),
            $keys[2] => $this->getDisc(),
            $keys[3] => $this->getArtistId(),
            $keys[4] => $this->getAlbumId(),
            $keys[5] => $this->getId(),
            $keys[6] => $this->getCreatedAt(),
            $keys[7] => $this->getUpdatedAt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aMusicArtist) {
                $result['MusicArtist'] = $this->aMusicArtist->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aMusicAlbum) {
                $result['MusicAlbum'] = $this->aMusicAlbum->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collMusicFiles) {
                $result['MusicFiles'] = $this->collMusicFiles->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = MusicTrackPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setTrack($value);
                break;
            case 2:
                $this->setDisc($value);
                break;
            case 3:
                $this->setArtistId($value);
                break;
            case 4:
                $this->setAlbumId($value);
                break;
            case 5:
                $this->setId($value);
                break;
            case 6:
                $this->setCreatedAt($value);
                break;
            case 7:
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
        $keys = MusicTrackPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setName($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setTrack($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setDisc($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setArtistId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setAlbumId($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setId($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setCreatedAt($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setUpdatedAt($arr[$keys[7]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(MusicTrackPeer::DATABASE_NAME);

        if ($this->isColumnModified(MusicTrackPeer::NAME)) $criteria->add(MusicTrackPeer::NAME, $this->name);
        if ($this->isColumnModified(MusicTrackPeer::TRACK)) $criteria->add(MusicTrackPeer::TRACK, $this->track);
        if ($this->isColumnModified(MusicTrackPeer::DISC)) $criteria->add(MusicTrackPeer::DISC, $this->disc);
        if ($this->isColumnModified(MusicTrackPeer::ARTIST_ID)) $criteria->add(MusicTrackPeer::ARTIST_ID, $this->artist_id);
        if ($this->isColumnModified(MusicTrackPeer::ALBUM_ID)) $criteria->add(MusicTrackPeer::ALBUM_ID, $this->album_id);
        if ($this->isColumnModified(MusicTrackPeer::ID)) $criteria->add(MusicTrackPeer::ID, $this->id);
        if ($this->isColumnModified(MusicTrackPeer::CREATED_AT)) $criteria->add(MusicTrackPeer::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(MusicTrackPeer::UPDATED_AT)) $criteria->add(MusicTrackPeer::UPDATED_AT, $this->updated_at);

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
        $criteria = new Criteria(MusicTrackPeer::DATABASE_NAME);
        $criteria->add(MusicTrackPeer::ID, $this->id);

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
     * @param object $copyObj An object of MusicTrack (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setTrack($this->getTrack());
        $copyObj->setDisc($this->getDisc());
        $copyObj->setArtistId($this->getArtistId());
        $copyObj->setAlbumId($this->getAlbumId());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getMusicFiles() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMusicFile($relObj->copy($deepCopy));
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
     * @return MusicTrack Clone of current object.
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
     * @return MusicTrackPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new MusicTrackPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a MusicArtist object.
     *
     * @param                  MusicArtist $v
     * @return MusicTrack The current object (for fluent API support)
     * @throws PropelException
     */
    public function setMusicArtist(MusicArtist $v = null)
    {
        if ($v === null) {
            $this->setArtistId(NULL);
        } else {
            $this->setArtistId($v->getId());
        }

        $this->aMusicArtist = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the MusicArtist object, it will not be re-added.
        if ($v !== null) {
            $v->addMusicTrack($this);
        }


        return $this;
    }


    /**
     * Get the associated MusicArtist object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return MusicArtist The associated MusicArtist object.
     * @throws PropelException
     */
    public function getMusicArtist(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aMusicArtist === null && ($this->artist_id !== null) && $doQuery) {
            $this->aMusicArtist = MusicArtistQuery::create()->findPk($this->artist_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aMusicArtist->addMusicTracks($this);
             */
        }

        return $this->aMusicArtist;
    }

    /**
     * Declares an association between this object and a MusicAlbum object.
     *
     * @param                  MusicAlbum $v
     * @return MusicTrack The current object (for fluent API support)
     * @throws PropelException
     */
    public function setMusicAlbum(MusicAlbum $v = null)
    {
        if ($v === null) {
            $this->setAlbumId(NULL);
        } else {
            $this->setAlbumId($v->getId());
        }

        $this->aMusicAlbum = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the MusicAlbum object, it will not be re-added.
        if ($v !== null) {
            $v->addMusicTrack($this);
        }


        return $this;
    }


    /**
     * Get the associated MusicAlbum object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return MusicAlbum The associated MusicAlbum object.
     * @throws PropelException
     */
    public function getMusicAlbum(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aMusicAlbum === null && ($this->album_id !== null) && $doQuery) {
            $this->aMusicAlbum = MusicAlbumQuery::create()->findPk($this->album_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aMusicAlbum->addMusicTracks($this);
             */
        }

        return $this->aMusicAlbum;
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
        if ('MusicFile' == $relationName) {
            $this->initMusicFiles();
        }
    }

    /**
     * Clears out the collMusicFiles collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return MusicTrack The current object (for fluent API support)
     * @see        addMusicFiles()
     */
    public function clearMusicFiles()
    {
        $this->collMusicFiles = null; // important to set this to null since that means it is uninitialized
        $this->collMusicFilesPartial = null;

        return $this;
    }

    /**
     * reset is the collMusicFiles collection loaded partially
     *
     * @return void
     */
    public function resetPartialMusicFiles($v = true)
    {
        $this->collMusicFilesPartial = $v;
    }

    /**
     * Initializes the collMusicFiles collection.
     *
     * By default this just sets the collMusicFiles collection to an empty array (like clearcollMusicFiles());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMusicFiles($overrideExisting = true)
    {
        if (null !== $this->collMusicFiles && !$overrideExisting) {
            return;
        }
        $this->collMusicFiles = new PropelObjectCollection();
        $this->collMusicFiles->setModel('MusicFile');
    }

    /**
     * Gets an array of MusicFile objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this MusicTrack is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|MusicFile[] List of MusicFile objects
     * @throws PropelException
     */
    public function getMusicFiles($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collMusicFilesPartial && !$this->isNew();
        if (null === $this->collMusicFiles || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMusicFiles) {
                // return empty collection
                $this->initMusicFiles();
            } else {
                $collMusicFiles = MusicFileQuery::create(null, $criteria)
                    ->filterByMusicTrack($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collMusicFilesPartial && count($collMusicFiles)) {
                      $this->initMusicFiles(false);

                      foreach ($collMusicFiles as $obj) {
                        if (false == $this->collMusicFiles->contains($obj)) {
                          $this->collMusicFiles->append($obj);
                        }
                      }

                      $this->collMusicFilesPartial = true;
                    }

                    $collMusicFiles->getInternalIterator()->rewind();

                    return $collMusicFiles;
                }

                if ($partial && $this->collMusicFiles) {
                    foreach ($this->collMusicFiles as $obj) {
                        if ($obj->isNew()) {
                            $collMusicFiles[] = $obj;
                        }
                    }
                }

                $this->collMusicFiles = $collMusicFiles;
                $this->collMusicFilesPartial = false;
            }
        }

        return $this->collMusicFiles;
    }

    /**
     * Sets a collection of MusicFile objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $musicFiles A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return MusicTrack The current object (for fluent API support)
     */
    public function setMusicFiles(PropelCollection $musicFiles, PropelPDO $con = null)
    {
        $musicFilesToDelete = $this->getMusicFiles(new Criteria(), $con)->diff($musicFiles);


        $this->musicFilesScheduledForDeletion = $musicFilesToDelete;

        foreach ($musicFilesToDelete as $musicFileRemoved) {
            $musicFileRemoved->setMusicTrack(null);
        }

        $this->collMusicFiles = null;
        foreach ($musicFiles as $musicFile) {
            $this->addMusicFile($musicFile);
        }

        $this->collMusicFiles = $musicFiles;
        $this->collMusicFilesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related MusicFile objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related MusicFile objects.
     * @throws PropelException
     */
    public function countMusicFiles(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collMusicFilesPartial && !$this->isNew();
        if (null === $this->collMusicFiles || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMusicFiles) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMusicFiles());
            }
            $query = MusicFileQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMusicTrack($this)
                ->count($con);
        }

        return count($this->collMusicFiles);
    }

    /**
     * Method called to associate a MusicFile object to this object
     * through the MusicFile foreign key attribute.
     *
     * @param    MusicFile $l MusicFile
     * @return MusicTrack The current object (for fluent API support)
     */
    public function addMusicFile(MusicFile $l)
    {
        if ($this->collMusicFiles === null) {
            $this->initMusicFiles();
            $this->collMusicFilesPartial = true;
        }

        if (!in_array($l, $this->collMusicFiles->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddMusicFile($l);

            if ($this->musicFilesScheduledForDeletion and $this->musicFilesScheduledForDeletion->contains($l)) {
                $this->musicFilesScheduledForDeletion->remove($this->musicFilesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param  MusicFile $musicFile The musicFile object to add.
     */
    protected function doAddMusicFile($musicFile)
    {
        $this->collMusicFiles[]= $musicFile;
        $musicFile->setMusicTrack($this);
    }

    /**
     * @param  MusicFile $musicFile The musicFile object to remove.
     * @return MusicTrack The current object (for fluent API support)
     */
    public function removeMusicFile($musicFile)
    {
        if ($this->getMusicFiles()->contains($musicFile)) {
            $this->collMusicFiles->remove($this->collMusicFiles->search($musicFile));
            if (null === $this->musicFilesScheduledForDeletion) {
                $this->musicFilesScheduledForDeletion = clone $this->collMusicFiles;
                $this->musicFilesScheduledForDeletion->clear();
            }
            $this->musicFilesScheduledForDeletion[]= $musicFile;
            $musicFile->setMusicTrack(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this MusicTrack is new, it will return
     * an empty collection; or if this MusicTrack has previously
     * been saved, it will retrieve related MusicFiles from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in MusicTrack.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|MusicFile[] List of MusicFile objects
     */
    public function getMusicFilesJoinFile($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = MusicFileQuery::create(null, $criteria);
        $query->joinWith('File', $join_behavior);

        return $this->getMusicFiles($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->name = null;
        $this->track = null;
        $this->disc = null;
        $this->artist_id = null;
        $this->album_id = null;
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
            if ($this->collMusicFiles) {
                foreach ($this->collMusicFiles as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aMusicArtist instanceof Persistent) {
              $this->aMusicArtist->clearAllReferences($deep);
            }
            if ($this->aMusicAlbum instanceof Persistent) {
              $this->aMusicAlbum->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collMusicFiles instanceof PropelCollection) {
            $this->collMusicFiles->clearIterator();
        }
        $this->collMusicFiles = null;
        $this->aMusicArtist = null;
        $this->aMusicAlbum = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(MusicTrackPeer::DEFAULT_STRING_FORMAT);
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
   * @return     MusicTrack The current object (for fluent API support)
   */
  public function keepUpdateDateUnchanged()
  {
      $this->modifiedColumns[] = MusicTrackPeer::UPDATED_AT;

      return $this;
  }

}