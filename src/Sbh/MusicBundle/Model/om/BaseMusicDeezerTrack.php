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
use \PropelDateTime;
use \PropelException;
use \PropelPDO;
use Sbh\MusicBundle\Model\MusicDeezerAlbum;
use Sbh\MusicBundle\Model\MusicDeezerAlbumQuery;
use Sbh\MusicBundle\Model\MusicDeezerArtist;
use Sbh\MusicBundle\Model\MusicDeezerArtistQuery;
use Sbh\MusicBundle\Model\MusicDeezerTrack;
use Sbh\MusicBundle\Model\MusicDeezerTrackPeer;
use Sbh\MusicBundle\Model\MusicDeezerTrackQuery;

abstract class BaseMusicDeezerTrack extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Sbh\\MusicBundle\\Model\\MusicDeezerTrackPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        MusicDeezerTrackPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the deezer_id field.
     * @var        int
     */
    protected $deezer_id;

    /**
     * The value for the album_deezer_id field.
     * @var        int
     */
    protected $album_deezer_id;

    /**
     * The value for the artist_deezer_id field.
     * @var        int
     */
    protected $artist_deezer_id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the readable field.
     * @var        boolean
     */
    protected $readable;

    /**
     * The value for the duration field.
     * @var        int
     */
    protected $duration;

    /**
     * The value for the rank field.
     * @var        boolean
     */
    protected $rank;

    /**
     * The value for the explicit_lyrics field.
     * @var        boolean
     */
    protected $explicit_lyrics;

    /**
     * The value for the preview_link field.
     * @var        string
     */
    protected $preview_link;

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
     * @var        MusicDeezerAlbum
     */
    protected $aMusicDeezerAlbum;

    /**
     * @var        MusicDeezerArtist
     */
    protected $aMusicDeezerArtist;

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
     * Get the [deezer_id] column value.
     *
     * @return int
     */
    public function getDeezerId()
    {

        return $this->deezer_id;
    }

    /**
     * Get the [album_deezer_id] column value.
     *
     * @return int
     */
    public function getAlbumDeezerId()
    {

        return $this->album_deezer_id;
    }

    /**
     * Get the [artist_deezer_id] column value.
     *
     * @return int
     */
    public function getArtistDeezerId()
    {

        return $this->artist_deezer_id;
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
     * Get the [readable] column value.
     *
     * @return boolean
     */
    public function getReadable()
    {

        return $this->readable;
    }

    /**
     * Get the [duration] column value.
     *
     * @return int
     */
    public function getDuration()
    {

        return $this->duration;
    }

    /**
     * Get the [rank] column value.
     *
     * @return boolean
     */
    public function getRank()
    {

        return $this->rank;
    }

    /**
     * Get the [explicit_lyrics] column value.
     *
     * @return boolean
     */
    public function getExplicitLyrics()
    {

        return $this->explicit_lyrics;
    }

    /**
     * Get the [preview_link] column value.
     *
     * @return string
     */
    public function getPreviewLink()
    {

        return $this->preview_link;
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
     * Set the value of [deezer_id] column.
     *
     * @param  int $v new value
     * @return MusicDeezerTrack The current object (for fluent API support)
     */
    public function setDeezerId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->deezer_id !== $v) {
            $this->deezer_id = $v;
            $this->modifiedColumns[] = MusicDeezerTrackPeer::DEEZER_ID;
        }


        return $this;
    } // setDeezerId()

    /**
     * Set the value of [album_deezer_id] column.
     *
     * @param  int $v new value
     * @return MusicDeezerTrack The current object (for fluent API support)
     */
    public function setAlbumDeezerId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->album_deezer_id !== $v) {
            $this->album_deezer_id = $v;
            $this->modifiedColumns[] = MusicDeezerTrackPeer::ALBUM_DEEZER_ID;
        }

        if ($this->aMusicDeezerAlbum !== null && $this->aMusicDeezerAlbum->getDeezerId() !== $v) {
            $this->aMusicDeezerAlbum = null;
        }


        return $this;
    } // setAlbumDeezerId()

    /**
     * Set the value of [artist_deezer_id] column.
     *
     * @param  int $v new value
     * @return MusicDeezerTrack The current object (for fluent API support)
     */
    public function setArtistDeezerId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->artist_deezer_id !== $v) {
            $this->artist_deezer_id = $v;
            $this->modifiedColumns[] = MusicDeezerTrackPeer::ARTIST_DEEZER_ID;
        }

        if ($this->aMusicDeezerArtist !== null && $this->aMusicDeezerArtist->getDeezerId() !== $v) {
            $this->aMusicDeezerArtist = null;
        }


        return $this;
    } // setArtistDeezerId()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return MusicDeezerTrack The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = MusicDeezerTrackPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Sets the value of the [readable] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return MusicDeezerTrack The current object (for fluent API support)
     */
    public function setReadable($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->readable !== $v) {
            $this->readable = $v;
            $this->modifiedColumns[] = MusicDeezerTrackPeer::READABLE;
        }


        return $this;
    } // setReadable()

    /**
     * Set the value of [duration] column.
     *
     * @param  int $v new value
     * @return MusicDeezerTrack The current object (for fluent API support)
     */
    public function setDuration($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->duration !== $v) {
            $this->duration = $v;
            $this->modifiedColumns[] = MusicDeezerTrackPeer::DURATION;
        }


        return $this;
    } // setDuration()

    /**
     * Sets the value of the [rank] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return MusicDeezerTrack The current object (for fluent API support)
     */
    public function setRank($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->rank !== $v) {
            $this->rank = $v;
            $this->modifiedColumns[] = MusicDeezerTrackPeer::RANK;
        }


        return $this;
    } // setRank()

    /**
     * Sets the value of the [explicit_lyrics] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return MusicDeezerTrack The current object (for fluent API support)
     */
    public function setExplicitLyrics($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->explicit_lyrics !== $v) {
            $this->explicit_lyrics = $v;
            $this->modifiedColumns[] = MusicDeezerTrackPeer::EXPLICIT_LYRICS;
        }


        return $this;
    } // setExplicitLyrics()

    /**
     * Set the value of [preview_link] column.
     *
     * @param  string $v new value
     * @return MusicDeezerTrack The current object (for fluent API support)
     */
    public function setPreviewLink($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->preview_link !== $v) {
            $this->preview_link = $v;
            $this->modifiedColumns[] = MusicDeezerTrackPeer::PREVIEW_LINK;
        }


        return $this;
    } // setPreviewLink()

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return MusicDeezerTrack The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = MusicDeezerTrackPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return MusicDeezerTrack The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            $currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->created_at = $newDateAsString;
                $this->modifiedColumns[] = MusicDeezerTrackPeer::CREATED_AT;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return MusicDeezerTrack The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            $currentDateAsString = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->updated_at = $newDateAsString;
                $this->modifiedColumns[] = MusicDeezerTrackPeer::UPDATED_AT;
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

            $this->deezer_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->album_deezer_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->artist_deezer_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->name = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->readable = ($row[$startcol + 4] !== null) ? (boolean) $row[$startcol + 4] : null;
            $this->duration = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->rank = ($row[$startcol + 6] !== null) ? (boolean) $row[$startcol + 6] : null;
            $this->explicit_lyrics = ($row[$startcol + 7] !== null) ? (boolean) $row[$startcol + 7] : null;
            $this->preview_link = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->id = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
            $this->created_at = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
            $this->updated_at = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 12; // 12 = MusicDeezerTrackPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating MusicDeezerTrack object", $e);
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

        if ($this->aMusicDeezerAlbum !== null && $this->album_deezer_id !== $this->aMusicDeezerAlbum->getDeezerId()) {
            $this->aMusicDeezerAlbum = null;
        }
        if ($this->aMusicDeezerArtist !== null && $this->artist_deezer_id !== $this->aMusicDeezerArtist->getDeezerId()) {
            $this->aMusicDeezerArtist = null;
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
            $con = Propel::getConnection(MusicDeezerTrackPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = MusicDeezerTrackPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aMusicDeezerAlbum = null;
            $this->aMusicDeezerArtist = null;
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
            $con = Propel::getConnection(MusicDeezerTrackPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = MusicDeezerTrackQuery::create()
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
            $con = Propel::getConnection(MusicDeezerTrackPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
        // timestampable behavior
        if (!$this->isColumnModified(MusicDeezerTrackPeer::CREATED_AT))
        {
            $this->setCreatedAt(time());
        }
        if (!$this->isColumnModified(MusicDeezerTrackPeer::UPDATED_AT))
        {
            $this->setUpdatedAt(time());
        }
            } else {
                $ret = $ret && $this->preUpdate($con);
        // timestampable behavior
        if ($this->isModified() && !$this->isColumnModified(MusicDeezerTrackPeer::UPDATED_AT))
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
                MusicDeezerTrackPeer::addInstanceToPool($this);
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

            if ($this->aMusicDeezerAlbum !== null) {
                if ($this->aMusicDeezerAlbum->isModified() || $this->aMusicDeezerAlbum->isNew()) {
                    $affectedRows += $this->aMusicDeezerAlbum->save($con);
                }
                $this->setMusicDeezerAlbum($this->aMusicDeezerAlbum);
            }

            if ($this->aMusicDeezerArtist !== null) {
                if ($this->aMusicDeezerArtist->isModified() || $this->aMusicDeezerArtist->isNew()) {
                    $affectedRows += $this->aMusicDeezerArtist->save($con);
                }
                $this->setMusicDeezerArtist($this->aMusicDeezerArtist);
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

        $this->modifiedColumns[] = MusicDeezerTrackPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . MusicDeezerTrackPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(MusicDeezerTrackPeer::DEEZER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`deezer_id`';
        }
        if ($this->isColumnModified(MusicDeezerTrackPeer::ALBUM_DEEZER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`album_deezer_id`';
        }
        if ($this->isColumnModified(MusicDeezerTrackPeer::ARTIST_DEEZER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`artist_deezer_id`';
        }
        if ($this->isColumnModified(MusicDeezerTrackPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(MusicDeezerTrackPeer::READABLE)) {
            $modifiedColumns[':p' . $index++]  = '`readable`';
        }
        if ($this->isColumnModified(MusicDeezerTrackPeer::DURATION)) {
            $modifiedColumns[':p' . $index++]  = '`duration`';
        }
        if ($this->isColumnModified(MusicDeezerTrackPeer::RANK)) {
            $modifiedColumns[':p' . $index++]  = '`rank`';
        }
        if ($this->isColumnModified(MusicDeezerTrackPeer::EXPLICIT_LYRICS)) {
            $modifiedColumns[':p' . $index++]  = '`explicit_lyrics`';
        }
        if ($this->isColumnModified(MusicDeezerTrackPeer::PREVIEW_LINK)) {
            $modifiedColumns[':p' . $index++]  = '`preview_link`';
        }
        if ($this->isColumnModified(MusicDeezerTrackPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(MusicDeezerTrackPeer::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }
        if ($this->isColumnModified(MusicDeezerTrackPeer::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`updated_at`';
        }

        $sql = sprintf(
            'INSERT INTO `music_deezer_track` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`deezer_id`':
            $stmt->bindValue($identifier, $this->deezer_id, PDO::PARAM_INT);
                        break;
                    case '`album_deezer_id`':
            $stmt->bindValue($identifier, $this->album_deezer_id, PDO::PARAM_INT);
                        break;
                    case '`artist_deezer_id`':
            $stmt->bindValue($identifier, $this->artist_deezer_id, PDO::PARAM_INT);
                        break;
                    case '`name`':
            $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`readable`':
            $stmt->bindValue($identifier, (int) $this->readable, PDO::PARAM_INT);
                        break;
                    case '`duration`':
            $stmt->bindValue($identifier, $this->duration, PDO::PARAM_INT);
                        break;
                    case '`rank`':
            $stmt->bindValue($identifier, (int) $this->rank, PDO::PARAM_INT);
                        break;
                    case '`explicit_lyrics`':
            $stmt->bindValue($identifier, (int) $this->explicit_lyrics, PDO::PARAM_INT);
                        break;
                    case '`preview_link`':
            $stmt->bindValue($identifier, $this->preview_link, PDO::PARAM_STR);
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

            if ($this->aMusicDeezerAlbum !== null) {
                if (!$this->aMusicDeezerAlbum->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aMusicDeezerAlbum->getValidationFailures());
                }
            }

            if ($this->aMusicDeezerArtist !== null) {
                if (!$this->aMusicDeezerArtist->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aMusicDeezerArtist->getValidationFailures());
                }
            }


            if (($retval = MusicDeezerTrackPeer::doValidate($this, $columns)) !== true) {
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
        $pos = MusicDeezerTrackPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getDeezerId();
                break;
            case 1:
                return $this->getAlbumDeezerId();
                break;
            case 2:
                return $this->getArtistDeezerId();
                break;
            case 3:
                return $this->getName();
                break;
            case 4:
                return $this->getReadable();
                break;
            case 5:
                return $this->getDuration();
                break;
            case 6:
                return $this->getRank();
                break;
            case 7:
                return $this->getExplicitLyrics();
                break;
            case 8:
                return $this->getPreviewLink();
                break;
            case 9:
                return $this->getId();
                break;
            case 10:
                return $this->getCreatedAt();
                break;
            case 11:
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
        if (isset($alreadyDumpedObjects['MusicDeezerTrack'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['MusicDeezerTrack'][$this->getPrimaryKey()] = true;
        $keys = MusicDeezerTrackPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getDeezerId(),
            $keys[1] => $this->getAlbumDeezerId(),
            $keys[2] => $this->getArtistDeezerId(),
            $keys[3] => $this->getName(),
            $keys[4] => $this->getReadable(),
            $keys[5] => $this->getDuration(),
            $keys[6] => $this->getRank(),
            $keys[7] => $this->getExplicitLyrics(),
            $keys[8] => $this->getPreviewLink(),
            $keys[9] => $this->getId(),
            $keys[10] => $this->getCreatedAt(),
            $keys[11] => $this->getUpdatedAt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aMusicDeezerAlbum) {
                $result['MusicDeezerAlbum'] = $this->aMusicDeezerAlbum->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aMusicDeezerArtist) {
                $result['MusicDeezerArtist'] = $this->aMusicDeezerArtist->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
        $pos = MusicDeezerTrackPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setDeezerId($value);
                break;
            case 1:
                $this->setAlbumDeezerId($value);
                break;
            case 2:
                $this->setArtistDeezerId($value);
                break;
            case 3:
                $this->setName($value);
                break;
            case 4:
                $this->setReadable($value);
                break;
            case 5:
                $this->setDuration($value);
                break;
            case 6:
                $this->setRank($value);
                break;
            case 7:
                $this->setExplicitLyrics($value);
                break;
            case 8:
                $this->setPreviewLink($value);
                break;
            case 9:
                $this->setId($value);
                break;
            case 10:
                $this->setCreatedAt($value);
                break;
            case 11:
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
        $keys = MusicDeezerTrackPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setDeezerId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setAlbumDeezerId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setArtistDeezerId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setName($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setReadable($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setDuration($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setRank($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setExplicitLyrics($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setPreviewLink($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setId($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setCreatedAt($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setUpdatedAt($arr[$keys[11]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(MusicDeezerTrackPeer::DATABASE_NAME);

        if ($this->isColumnModified(MusicDeezerTrackPeer::DEEZER_ID)) $criteria->add(MusicDeezerTrackPeer::DEEZER_ID, $this->deezer_id);
        if ($this->isColumnModified(MusicDeezerTrackPeer::ALBUM_DEEZER_ID)) $criteria->add(MusicDeezerTrackPeer::ALBUM_DEEZER_ID, $this->album_deezer_id);
        if ($this->isColumnModified(MusicDeezerTrackPeer::ARTIST_DEEZER_ID)) $criteria->add(MusicDeezerTrackPeer::ARTIST_DEEZER_ID, $this->artist_deezer_id);
        if ($this->isColumnModified(MusicDeezerTrackPeer::NAME)) $criteria->add(MusicDeezerTrackPeer::NAME, $this->name);
        if ($this->isColumnModified(MusicDeezerTrackPeer::READABLE)) $criteria->add(MusicDeezerTrackPeer::READABLE, $this->readable);
        if ($this->isColumnModified(MusicDeezerTrackPeer::DURATION)) $criteria->add(MusicDeezerTrackPeer::DURATION, $this->duration);
        if ($this->isColumnModified(MusicDeezerTrackPeer::RANK)) $criteria->add(MusicDeezerTrackPeer::RANK, $this->rank);
        if ($this->isColumnModified(MusicDeezerTrackPeer::EXPLICIT_LYRICS)) $criteria->add(MusicDeezerTrackPeer::EXPLICIT_LYRICS, $this->explicit_lyrics);
        if ($this->isColumnModified(MusicDeezerTrackPeer::PREVIEW_LINK)) $criteria->add(MusicDeezerTrackPeer::PREVIEW_LINK, $this->preview_link);
        if ($this->isColumnModified(MusicDeezerTrackPeer::ID)) $criteria->add(MusicDeezerTrackPeer::ID, $this->id);
        if ($this->isColumnModified(MusicDeezerTrackPeer::CREATED_AT)) $criteria->add(MusicDeezerTrackPeer::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(MusicDeezerTrackPeer::UPDATED_AT)) $criteria->add(MusicDeezerTrackPeer::UPDATED_AT, $this->updated_at);

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
        $criteria = new Criteria(MusicDeezerTrackPeer::DATABASE_NAME);
        $criteria->add(MusicDeezerTrackPeer::ID, $this->id);

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
     * @param object $copyObj An object of MusicDeezerTrack (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setDeezerId($this->getDeezerId());
        $copyObj->setAlbumDeezerId($this->getAlbumDeezerId());
        $copyObj->setArtistDeezerId($this->getArtistDeezerId());
        $copyObj->setName($this->getName());
        $copyObj->setReadable($this->getReadable());
        $copyObj->setDuration($this->getDuration());
        $copyObj->setRank($this->getRank());
        $copyObj->setExplicitLyrics($this->getExplicitLyrics());
        $copyObj->setPreviewLink($this->getPreviewLink());
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
     * @return MusicDeezerTrack Clone of current object.
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
     * @return MusicDeezerTrackPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new MusicDeezerTrackPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a MusicDeezerAlbum object.
     *
     * @param                  MusicDeezerAlbum $v
     * @return MusicDeezerTrack The current object (for fluent API support)
     * @throws PropelException
     */
    public function setMusicDeezerAlbum(MusicDeezerAlbum $v = null)
    {
        if ($v === null) {
            $this->setAlbumDeezerId(NULL);
        } else {
            $this->setAlbumDeezerId($v->getDeezerId());
        }

        $this->aMusicDeezerAlbum = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the MusicDeezerAlbum object, it will not be re-added.
        if ($v !== null) {
            $v->addMusicDeezerTrack($this);
        }


        return $this;
    }


    /**
     * Get the associated MusicDeezerAlbum object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return MusicDeezerAlbum The associated MusicDeezerAlbum object.
     * @throws PropelException
     */
    public function getMusicDeezerAlbum(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aMusicDeezerAlbum === null && ($this->album_deezer_id !== null) && $doQuery) {
            $this->aMusicDeezerAlbum = MusicDeezerAlbumQuery::create()
                ->filterByMusicDeezerTrack($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aMusicDeezerAlbum->addMusicDeezerTracks($this);
             */
        }

        return $this->aMusicDeezerAlbum;
    }

    /**
     * Declares an association between this object and a MusicDeezerArtist object.
     *
     * @param                  MusicDeezerArtist $v
     * @return MusicDeezerTrack The current object (for fluent API support)
     * @throws PropelException
     */
    public function setMusicDeezerArtist(MusicDeezerArtist $v = null)
    {
        if ($v === null) {
            $this->setArtistDeezerId(NULL);
        } else {
            $this->setArtistDeezerId($v->getDeezerId());
        }

        $this->aMusicDeezerArtist = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the MusicDeezerArtist object, it will not be re-added.
        if ($v !== null) {
            $v->addMusicDeezerTrack($this);
        }


        return $this;
    }


    /**
     * Get the associated MusicDeezerArtist object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return MusicDeezerArtist The associated MusicDeezerArtist object.
     * @throws PropelException
     */
    public function getMusicDeezerArtist(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aMusicDeezerArtist === null && ($this->artist_deezer_id !== null) && $doQuery) {
            $this->aMusicDeezerArtist = MusicDeezerArtistQuery::create()
                ->filterByMusicDeezerTrack($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aMusicDeezerArtist->addMusicDeezerTracks($this);
             */
        }

        return $this->aMusicDeezerArtist;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->deezer_id = null;
        $this->album_deezer_id = null;
        $this->artist_deezer_id = null;
        $this->name = null;
        $this->readable = null;
        $this->duration = null;
        $this->rank = null;
        $this->explicit_lyrics = null;
        $this->preview_link = null;
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
            if ($this->aMusicDeezerAlbum instanceof Persistent) {
              $this->aMusicDeezerAlbum->clearAllReferences($deep);
            }
            if ($this->aMusicDeezerArtist instanceof Persistent) {
              $this->aMusicDeezerArtist->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        $this->aMusicDeezerAlbum = null;
        $this->aMusicDeezerArtist = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(MusicDeezerTrackPeer::DEFAULT_STRING_FORMAT);
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
   * @return     MusicDeezerTrack The current object (for fluent API support)
   */
  public function keepUpdateDateUnchanged()
  {
      $this->modifiedColumns[] = MusicDeezerTrackPeer::UPDATED_AT;

      return $this;
  }

}
