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
use Sbh\MusicBundle\Model\MusicArtistPeer;
use Sbh\MusicBundle\Model\MusicArtistQuery;
use Sbh\MusicBundle\Model\MusicDeezerArtist;
use Sbh\MusicBundle\Model\MusicDeezerArtistQuery;
use Sbh\MusicBundle\Model\MusicSpotifyArtist;
use Sbh\MusicBundle\Model\MusicSpotifyArtistQuery;
use Sbh\MusicBundle\Model\MusicTrack;
use Sbh\MusicBundle\Model\MusicTrackQuery;

abstract class BaseMusicArtist extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Sbh\\MusicBundle\\Model\\MusicArtistPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        MusicArtistPeer
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
     * The value for the alias field.
     * @var        int
     */
    protected $alias;

    /**
     * The value for the image field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $image;

    /**
     * The value for the scan_deezer_search field.
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $scan_deezer_search;

    /**
     * The value for the scan_spotify_search field.
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $scan_spotify_search;

    /**
     * The value for the slug field.
     * @var        string
     */
    protected $slug;

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
     * @var        PropelObjectCollection|MusicAlbum[] Collection to store aggregation of MusicAlbum objects.
     */
    protected $collMusicAlbums;
    protected $collMusicAlbumsPartial;

    /**
     * @var        PropelObjectCollection|MusicTrack[] Collection to store aggregation of MusicTrack objects.
     */
    protected $collMusicTracks;
    protected $collMusicTracksPartial;

    /**
     * @var        PropelObjectCollection|MusicDeezerArtist[] Collection to store aggregation of MusicDeezerArtist objects.
     */
    protected $collMusicDeezerArtists;
    protected $collMusicDeezerArtistsPartial;

    /**
     * @var        PropelObjectCollection|MusicSpotifyArtist[] Collection to store aggregation of MusicSpotifyArtist objects.
     */
    protected $collMusicSpotifyArtists;
    protected $collMusicSpotifyArtistsPartial;

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
    protected $musicAlbumsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var    PropelObjectCollection
     */
    protected $musicTracksScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var    PropelObjectCollection
     */
    protected $musicDeezerArtistsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var    PropelObjectCollection
     */
    protected $musicSpotifyArtistsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->image = false;
        $this->scan_deezer_search = true;
        $this->scan_spotify_search = true;
    }

    /**
     * Initializes internal state of BaseMusicArtist object.
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
     * Get the [alias] column value.
     *
     * @return int
     */
    public function getAlias()
    {

        return $this->alias;
    }

    /**
     * Get the [image] column value.
     *
     * @return boolean
     */
    public function getImage()
    {

        return $this->image;
    }

    /**
     * Get the [scan_deezer_search] column value.
     *
     * @return boolean
     */
    public function getScanDeezerSearch()
    {

        return $this->scan_deezer_search;
    }

    /**
     * Get the [scan_spotify_search] column value.
     *
     * @return boolean
     */
    public function getScanSpotifySearch()
    {

        return $this->scan_spotify_search;
    }

    /**
     * Get the [slug] column value.
     *
     * @return string
     */
    public function getSlug()
    {

        return $this->slug;
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
     * @return MusicArtist The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = MusicArtistPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [alias] column.
     *
     * @param  int $v new value
     * @return MusicArtist The current object (for fluent API support)
     */
    public function setAlias($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->alias !== $v) {
            $this->alias = $v;
            $this->modifiedColumns[] = MusicArtistPeer::ALIAS;
        }


        return $this;
    } // setAlias()

    /**
     * Sets the value of the [image] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return MusicArtist The current object (for fluent API support)
     */
    public function setImage($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->image !== $v) {
            $this->image = $v;
            $this->modifiedColumns[] = MusicArtistPeer::IMAGE;
        }


        return $this;
    } // setImage()

    /**
     * Sets the value of the [scan_deezer_search] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return MusicArtist The current object (for fluent API support)
     */
    public function setScanDeezerSearch($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->scan_deezer_search !== $v) {
            $this->scan_deezer_search = $v;
            $this->modifiedColumns[] = MusicArtistPeer::SCAN_DEEZER_SEARCH;
        }


        return $this;
    } // setScanDeezerSearch()

    /**
     * Sets the value of the [scan_spotify_search] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return MusicArtist The current object (for fluent API support)
     */
    public function setScanSpotifySearch($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->scan_spotify_search !== $v) {
            $this->scan_spotify_search = $v;
            $this->modifiedColumns[] = MusicArtistPeer::SCAN_SPOTIFY_SEARCH;
        }


        return $this;
    } // setScanSpotifySearch()

    /**
     * Set the value of [slug] column.
     *
     * @param  string $v new value
     * @return MusicArtist The current object (for fluent API support)
     */
    public function setSlug($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->slug !== $v) {
            $this->slug = $v;
            $this->modifiedColumns[] = MusicArtistPeer::SLUG;
        }


        return $this;
    } // setSlug()

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return MusicArtist The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = MusicArtistPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return MusicArtist The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            $currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->created_at = $newDateAsString;
                $this->modifiedColumns[] = MusicArtistPeer::CREATED_AT;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return MusicArtist The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            $currentDateAsString = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->updated_at = $newDateAsString;
                $this->modifiedColumns[] = MusicArtistPeer::UPDATED_AT;
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
            if ($this->image !== false) {
                return false;
            }

            if ($this->scan_deezer_search !== true) {
                return false;
            }

            if ($this->scan_spotify_search !== true) {
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
            $this->alias = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->image = ($row[$startcol + 2] !== null) ? (boolean) $row[$startcol + 2] : null;
            $this->scan_deezer_search = ($row[$startcol + 3] !== null) ? (boolean) $row[$startcol + 3] : null;
            $this->scan_spotify_search = ($row[$startcol + 4] !== null) ? (boolean) $row[$startcol + 4] : null;
            $this->slug = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->id = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->created_at = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->updated_at = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 9; // 9 = MusicArtistPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating MusicArtist object", $e);
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
            $con = Propel::getConnection(MusicArtistPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = MusicArtistPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collMusicAlbums = null;

            $this->collMusicTracks = null;

            $this->collMusicDeezerArtists = null;

            $this->collMusicSpotifyArtists = null;

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
            $con = Propel::getConnection(MusicArtistPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = MusicArtistQuery::create()
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
            $con = Propel::getConnection(MusicArtistPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
      // sluggable behavior

      if ($this->isColumnModified(MusicArtistPeer::SLUG) && $this->getSlug())
      {
          $this->setSlug($this->makeSlugUnique($this->getSlug()));
      }
      else
      {
          $this->setSlug($this->createSlug());
      }
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
        // timestampable behavior
        if (!$this->isColumnModified(MusicArtistPeer::CREATED_AT))
        {
            $this->setCreatedAt(time());
        }
        if (!$this->isColumnModified(MusicArtistPeer::UPDATED_AT))
        {
            $this->setUpdatedAt(time());
        }
            } else {
                $ret = $ret && $this->preUpdate($con);
        // timestampable behavior
        if ($this->isModified() && !$this->isColumnModified(MusicArtistPeer::UPDATED_AT))
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
                MusicArtistPeer::addInstanceToPool($this);
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

            if ($this->musicAlbumsScheduledForDeletion !== null) {
                if (!$this->musicAlbumsScheduledForDeletion->isEmpty()) {
                    foreach ($this->musicAlbumsScheduledForDeletion as $musicAlbum) {
                        // need to save related object because we set the relation to null
                        $musicAlbum->save($con);
                    }
                    $this->musicAlbumsScheduledForDeletion = null;
                }
            }

            if ($this->collMusicAlbums !== null) {
                foreach ($this->collMusicAlbums as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->musicTracksScheduledForDeletion !== null) {
                if (!$this->musicTracksScheduledForDeletion->isEmpty()) {
                    foreach ($this->musicTracksScheduledForDeletion as $musicTrack) {
                        // need to save related object because we set the relation to null
                        $musicTrack->save($con);
                    }
                    $this->musicTracksScheduledForDeletion = null;
                }
            }

            if ($this->collMusicTracks !== null) {
                foreach ($this->collMusicTracks as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->musicDeezerArtistsScheduledForDeletion !== null) {
                if (!$this->musicDeezerArtistsScheduledForDeletion->isEmpty()) {
                    foreach ($this->musicDeezerArtistsScheduledForDeletion as $musicDeezerArtist) {
                        // need to save related object because we set the relation to null
                        $musicDeezerArtist->save($con);
                    }
                    $this->musicDeezerArtistsScheduledForDeletion = null;
                }
            }

            if ($this->collMusicDeezerArtists !== null) {
                foreach ($this->collMusicDeezerArtists as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->musicSpotifyArtistsScheduledForDeletion !== null) {
                if (!$this->musicSpotifyArtistsScheduledForDeletion->isEmpty()) {
                    foreach ($this->musicSpotifyArtistsScheduledForDeletion as $musicSpotifyArtist) {
                        // need to save related object because we set the relation to null
                        $musicSpotifyArtist->save($con);
                    }
                    $this->musicSpotifyArtistsScheduledForDeletion = null;
                }
            }

            if ($this->collMusicSpotifyArtists !== null) {
                foreach ($this->collMusicSpotifyArtists as $referrerFK) {
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

        $this->modifiedColumns[] = MusicArtistPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . MusicArtistPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(MusicArtistPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(MusicArtistPeer::ALIAS)) {
            $modifiedColumns[':p' . $index++]  = '`alias`';
        }
        if ($this->isColumnModified(MusicArtistPeer::IMAGE)) {
            $modifiedColumns[':p' . $index++]  = '`image`';
        }
        if ($this->isColumnModified(MusicArtistPeer::SCAN_DEEZER_SEARCH)) {
            $modifiedColumns[':p' . $index++]  = '`scan_deezer_search`';
        }
        if ($this->isColumnModified(MusicArtistPeer::SCAN_SPOTIFY_SEARCH)) {
            $modifiedColumns[':p' . $index++]  = '`scan_spotify_search`';
        }
        if ($this->isColumnModified(MusicArtistPeer::SLUG)) {
            $modifiedColumns[':p' . $index++]  = '`slug`';
        }
        if ($this->isColumnModified(MusicArtistPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(MusicArtistPeer::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }
        if ($this->isColumnModified(MusicArtistPeer::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`updated_at`';
        }

        $sql = sprintf(
            'INSERT INTO `music_artist` (%s) VALUES (%s)',
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
                    case '`alias`':
            $stmt->bindValue($identifier, $this->alias, PDO::PARAM_INT);
                        break;
                    case '`image`':
            $stmt->bindValue($identifier, (int) $this->image, PDO::PARAM_INT);
                        break;
                    case '`scan_deezer_search`':
            $stmt->bindValue($identifier, (int) $this->scan_deezer_search, PDO::PARAM_INT);
                        break;
                    case '`scan_spotify_search`':
            $stmt->bindValue($identifier, (int) $this->scan_spotify_search, PDO::PARAM_INT);
                        break;
                    case '`slug`':
            $stmt->bindValue($identifier, $this->slug, PDO::PARAM_STR);
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


            if (($retval = MusicArtistPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collMusicAlbums !== null) {
                    foreach ($this->collMusicAlbums as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collMusicTracks !== null) {
                    foreach ($this->collMusicTracks as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collMusicDeezerArtists !== null) {
                    foreach ($this->collMusicDeezerArtists as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collMusicSpotifyArtists !== null) {
                    foreach ($this->collMusicSpotifyArtists as $referrerFK) {
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
        $pos = MusicArtistPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getAlias();
                break;
            case 2:
                return $this->getImage();
                break;
            case 3:
                return $this->getScanDeezerSearch();
                break;
            case 4:
                return $this->getScanSpotifySearch();
                break;
            case 5:
                return $this->getSlug();
                break;
            case 6:
                return $this->getId();
                break;
            case 7:
                return $this->getCreatedAt();
                break;
            case 8:
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
        if (isset($alreadyDumpedObjects['MusicArtist'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['MusicArtist'][$this->getPrimaryKey()] = true;
        $keys = MusicArtistPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getName(),
            $keys[1] => $this->getAlias(),
            $keys[2] => $this->getImage(),
            $keys[3] => $this->getScanDeezerSearch(),
            $keys[4] => $this->getScanSpotifySearch(),
            $keys[5] => $this->getSlug(),
            $keys[6] => $this->getId(),
            $keys[7] => $this->getCreatedAt(),
            $keys[8] => $this->getUpdatedAt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collMusicAlbums) {
                $result['MusicAlbums'] = $this->collMusicAlbums->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collMusicTracks) {
                $result['MusicTracks'] = $this->collMusicTracks->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collMusicDeezerArtists) {
                $result['MusicDeezerArtists'] = $this->collMusicDeezerArtists->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collMusicSpotifyArtists) {
                $result['MusicSpotifyArtists'] = $this->collMusicSpotifyArtists->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = MusicArtistPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setAlias($value);
                break;
            case 2:
                $this->setImage($value);
                break;
            case 3:
                $this->setScanDeezerSearch($value);
                break;
            case 4:
                $this->setScanSpotifySearch($value);
                break;
            case 5:
                $this->setSlug($value);
                break;
            case 6:
                $this->setId($value);
                break;
            case 7:
                $this->setCreatedAt($value);
                break;
            case 8:
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
        $keys = MusicArtistPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setName($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setAlias($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setImage($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setScanDeezerSearch($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setScanSpotifySearch($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setSlug($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setId($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setCreatedAt($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setUpdatedAt($arr[$keys[8]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(MusicArtistPeer::DATABASE_NAME);

        if ($this->isColumnModified(MusicArtistPeer::NAME)) $criteria->add(MusicArtistPeer::NAME, $this->name);
        if ($this->isColumnModified(MusicArtistPeer::ALIAS)) $criteria->add(MusicArtistPeer::ALIAS, $this->alias);
        if ($this->isColumnModified(MusicArtistPeer::IMAGE)) $criteria->add(MusicArtistPeer::IMAGE, $this->image);
        if ($this->isColumnModified(MusicArtistPeer::SCAN_DEEZER_SEARCH)) $criteria->add(MusicArtistPeer::SCAN_DEEZER_SEARCH, $this->scan_deezer_search);
        if ($this->isColumnModified(MusicArtistPeer::SCAN_SPOTIFY_SEARCH)) $criteria->add(MusicArtistPeer::SCAN_SPOTIFY_SEARCH, $this->scan_spotify_search);
        if ($this->isColumnModified(MusicArtistPeer::SLUG)) $criteria->add(MusicArtistPeer::SLUG, $this->slug);
        if ($this->isColumnModified(MusicArtistPeer::ID)) $criteria->add(MusicArtistPeer::ID, $this->id);
        if ($this->isColumnModified(MusicArtistPeer::CREATED_AT)) $criteria->add(MusicArtistPeer::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(MusicArtistPeer::UPDATED_AT)) $criteria->add(MusicArtistPeer::UPDATED_AT, $this->updated_at);

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
        $criteria = new Criteria(MusicArtistPeer::DATABASE_NAME);
        $criteria->add(MusicArtistPeer::ID, $this->id);

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
     * @param object $copyObj An object of MusicArtist (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setAlias($this->getAlias());
        $copyObj->setImage($this->getImage());
        $copyObj->setScanDeezerSearch($this->getScanDeezerSearch());
        $copyObj->setScanSpotifySearch($this->getScanSpotifySearch());
        $copyObj->setSlug($this->getSlug());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getMusicAlbums() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMusicAlbum($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMusicTracks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMusicTrack($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMusicDeezerArtists() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMusicDeezerArtist($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMusicSpotifyArtists() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMusicSpotifyArtist($relObj->copy($deepCopy));
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
     * @return MusicArtist Clone of current object.
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
     * @return MusicArtistPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new MusicArtistPeer();
        }

        return self::$peer;
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
        if ('MusicAlbum' == $relationName) {
            $this->initMusicAlbums();
        }
        if ('MusicTrack' == $relationName) {
            $this->initMusicTracks();
        }
        if ('MusicDeezerArtist' == $relationName) {
            $this->initMusicDeezerArtists();
        }
        if ('MusicSpotifyArtist' == $relationName) {
            $this->initMusicSpotifyArtists();
        }
    }

    /**
     * Clears out the collMusicAlbums collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return MusicArtist The current object (for fluent API support)
     * @see        addMusicAlbums()
     */
    public function clearMusicAlbums()
    {
        $this->collMusicAlbums = null; // important to set this to null since that means it is uninitialized
        $this->collMusicAlbumsPartial = null;

        return $this;
    }

    /**
     * reset is the collMusicAlbums collection loaded partially
     *
     * @return void
     */
    public function resetPartialMusicAlbums($v = true)
    {
        $this->collMusicAlbumsPartial = $v;
    }

    /**
     * Initializes the collMusicAlbums collection.
     *
     * By default this just sets the collMusicAlbums collection to an empty array (like clearcollMusicAlbums());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMusicAlbums($overrideExisting = true)
    {
        if (null !== $this->collMusicAlbums && !$overrideExisting) {
            return;
        }
        $this->collMusicAlbums = new PropelObjectCollection();
        $this->collMusicAlbums->setModel('MusicAlbum');
    }

    /**
     * Gets an array of MusicAlbum objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this MusicArtist is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|MusicAlbum[] List of MusicAlbum objects
     * @throws PropelException
     */
    public function getMusicAlbums($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collMusicAlbumsPartial && !$this->isNew();
        if (null === $this->collMusicAlbums || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMusicAlbums) {
                // return empty collection
                $this->initMusicAlbums();
            } else {
                $collMusicAlbums = MusicAlbumQuery::create(null, $criteria)
                    ->filterByMusicArtist($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collMusicAlbumsPartial && count($collMusicAlbums)) {
                      $this->initMusicAlbums(false);

                      foreach ($collMusicAlbums as $obj) {
                        if (false == $this->collMusicAlbums->contains($obj)) {
                          $this->collMusicAlbums->append($obj);
                        }
                      }

                      $this->collMusicAlbumsPartial = true;
                    }

                    $collMusicAlbums->getInternalIterator()->rewind();

                    return $collMusicAlbums;
                }

                if ($partial && $this->collMusicAlbums) {
                    foreach ($this->collMusicAlbums as $obj) {
                        if ($obj->isNew()) {
                            $collMusicAlbums[] = $obj;
                        }
                    }
                }

                $this->collMusicAlbums = $collMusicAlbums;
                $this->collMusicAlbumsPartial = false;
            }
        }

        return $this->collMusicAlbums;
    }

    /**
     * Sets a collection of MusicAlbum objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $musicAlbums A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return MusicArtist The current object (for fluent API support)
     */
    public function setMusicAlbums(PropelCollection $musicAlbums, PropelPDO $con = null)
    {
        $musicAlbumsToDelete = $this->getMusicAlbums(new Criteria(), $con)->diff($musicAlbums);


        $this->musicAlbumsScheduledForDeletion = $musicAlbumsToDelete;

        foreach ($musicAlbumsToDelete as $musicAlbumRemoved) {
            $musicAlbumRemoved->setMusicArtist(null);
        }

        $this->collMusicAlbums = null;
        foreach ($musicAlbums as $musicAlbum) {
            $this->addMusicAlbum($musicAlbum);
        }

        $this->collMusicAlbums = $musicAlbums;
        $this->collMusicAlbumsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related MusicAlbum objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related MusicAlbum objects.
     * @throws PropelException
     */
    public function countMusicAlbums(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collMusicAlbumsPartial && !$this->isNew();
        if (null === $this->collMusicAlbums || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMusicAlbums) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMusicAlbums());
            }
            $query = MusicAlbumQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMusicArtist($this)
                ->count($con);
        }

        return count($this->collMusicAlbums);
    }

    /**
     * Method called to associate a MusicAlbum object to this object
     * through the MusicAlbum foreign key attribute.
     *
     * @param    MusicAlbum $l MusicAlbum
     * @return MusicArtist The current object (for fluent API support)
     */
    public function addMusicAlbum(MusicAlbum $l)
    {
        if ($this->collMusicAlbums === null) {
            $this->initMusicAlbums();
            $this->collMusicAlbumsPartial = true;
        }

        if (!in_array($l, $this->collMusicAlbums->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddMusicAlbum($l);

            if ($this->musicAlbumsScheduledForDeletion and $this->musicAlbumsScheduledForDeletion->contains($l)) {
                $this->musicAlbumsScheduledForDeletion->remove($this->musicAlbumsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param  MusicAlbum $musicAlbum The musicAlbum object to add.
     */
    protected function doAddMusicAlbum($musicAlbum)
    {
        $this->collMusicAlbums[]= $musicAlbum;
        $musicAlbum->setMusicArtist($this);
    }

    /**
     * @param  MusicAlbum $musicAlbum The musicAlbum object to remove.
     * @return MusicArtist The current object (for fluent API support)
     */
    public function removeMusicAlbum($musicAlbum)
    {
        if ($this->getMusicAlbums()->contains($musicAlbum)) {
            $this->collMusicAlbums->remove($this->collMusicAlbums->search($musicAlbum));
            if (null === $this->musicAlbumsScheduledForDeletion) {
                $this->musicAlbumsScheduledForDeletion = clone $this->collMusicAlbums;
                $this->musicAlbumsScheduledForDeletion->clear();
            }
            $this->musicAlbumsScheduledForDeletion[]= $musicAlbum;
            $musicAlbum->setMusicArtist(null);
        }

        return $this;
    }

    /**
     * Clears out the collMusicTracks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return MusicArtist The current object (for fluent API support)
     * @see        addMusicTracks()
     */
    public function clearMusicTracks()
    {
        $this->collMusicTracks = null; // important to set this to null since that means it is uninitialized
        $this->collMusicTracksPartial = null;

        return $this;
    }

    /**
     * reset is the collMusicTracks collection loaded partially
     *
     * @return void
     */
    public function resetPartialMusicTracks($v = true)
    {
        $this->collMusicTracksPartial = $v;
    }

    /**
     * Initializes the collMusicTracks collection.
     *
     * By default this just sets the collMusicTracks collection to an empty array (like clearcollMusicTracks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMusicTracks($overrideExisting = true)
    {
        if (null !== $this->collMusicTracks && !$overrideExisting) {
            return;
        }
        $this->collMusicTracks = new PropelObjectCollection();
        $this->collMusicTracks->setModel('MusicTrack');
    }

    /**
     * Gets an array of MusicTrack objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this MusicArtist is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|MusicTrack[] List of MusicTrack objects
     * @throws PropelException
     */
    public function getMusicTracks($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collMusicTracksPartial && !$this->isNew();
        if (null === $this->collMusicTracks || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMusicTracks) {
                // return empty collection
                $this->initMusicTracks();
            } else {
                $collMusicTracks = MusicTrackQuery::create(null, $criteria)
                    ->filterByMusicArtist($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collMusicTracksPartial && count($collMusicTracks)) {
                      $this->initMusicTracks(false);

                      foreach ($collMusicTracks as $obj) {
                        if (false == $this->collMusicTracks->contains($obj)) {
                          $this->collMusicTracks->append($obj);
                        }
                      }

                      $this->collMusicTracksPartial = true;
                    }

                    $collMusicTracks->getInternalIterator()->rewind();

                    return $collMusicTracks;
                }

                if ($partial && $this->collMusicTracks) {
                    foreach ($this->collMusicTracks as $obj) {
                        if ($obj->isNew()) {
                            $collMusicTracks[] = $obj;
                        }
                    }
                }

                $this->collMusicTracks = $collMusicTracks;
                $this->collMusicTracksPartial = false;
            }
        }

        return $this->collMusicTracks;
    }

    /**
     * Sets a collection of MusicTrack objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $musicTracks A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return MusicArtist The current object (for fluent API support)
     */
    public function setMusicTracks(PropelCollection $musicTracks, PropelPDO $con = null)
    {
        $musicTracksToDelete = $this->getMusicTracks(new Criteria(), $con)->diff($musicTracks);


        $this->musicTracksScheduledForDeletion = $musicTracksToDelete;

        foreach ($musicTracksToDelete as $musicTrackRemoved) {
            $musicTrackRemoved->setMusicArtist(null);
        }

        $this->collMusicTracks = null;
        foreach ($musicTracks as $musicTrack) {
            $this->addMusicTrack($musicTrack);
        }

        $this->collMusicTracks = $musicTracks;
        $this->collMusicTracksPartial = false;

        return $this;
    }

    /**
     * Returns the number of related MusicTrack objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related MusicTrack objects.
     * @throws PropelException
     */
    public function countMusicTracks(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collMusicTracksPartial && !$this->isNew();
        if (null === $this->collMusicTracks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMusicTracks) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMusicTracks());
            }
            $query = MusicTrackQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMusicArtist($this)
                ->count($con);
        }

        return count($this->collMusicTracks);
    }

    /**
     * Method called to associate a MusicTrack object to this object
     * through the MusicTrack foreign key attribute.
     *
     * @param    MusicTrack $l MusicTrack
     * @return MusicArtist The current object (for fluent API support)
     */
    public function addMusicTrack(MusicTrack $l)
    {
        if ($this->collMusicTracks === null) {
            $this->initMusicTracks();
            $this->collMusicTracksPartial = true;
        }

        if (!in_array($l, $this->collMusicTracks->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddMusicTrack($l);

            if ($this->musicTracksScheduledForDeletion and $this->musicTracksScheduledForDeletion->contains($l)) {
                $this->musicTracksScheduledForDeletion->remove($this->musicTracksScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param  MusicTrack $musicTrack The musicTrack object to add.
     */
    protected function doAddMusicTrack($musicTrack)
    {
        $this->collMusicTracks[]= $musicTrack;
        $musicTrack->setMusicArtist($this);
    }

    /**
     * @param  MusicTrack $musicTrack The musicTrack object to remove.
     * @return MusicArtist The current object (for fluent API support)
     */
    public function removeMusicTrack($musicTrack)
    {
        if ($this->getMusicTracks()->contains($musicTrack)) {
            $this->collMusicTracks->remove($this->collMusicTracks->search($musicTrack));
            if (null === $this->musicTracksScheduledForDeletion) {
                $this->musicTracksScheduledForDeletion = clone $this->collMusicTracks;
                $this->musicTracksScheduledForDeletion->clear();
            }
            $this->musicTracksScheduledForDeletion[]= $musicTrack;
            $musicTrack->setMusicArtist(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this MusicArtist is new, it will return
     * an empty collection; or if this MusicArtist has previously
     * been saved, it will retrieve related MusicTracks from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in MusicArtist.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|MusicTrack[] List of MusicTrack objects
     */
    public function getMusicTracksJoinMusicAlbum($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = MusicTrackQuery::create(null, $criteria);
        $query->joinWith('MusicAlbum', $join_behavior);

        return $this->getMusicTracks($query, $con);
    }

    /**
     * Clears out the collMusicDeezerArtists collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return MusicArtist The current object (for fluent API support)
     * @see        addMusicDeezerArtists()
     */
    public function clearMusicDeezerArtists()
    {
        $this->collMusicDeezerArtists = null; // important to set this to null since that means it is uninitialized
        $this->collMusicDeezerArtistsPartial = null;

        return $this;
    }

    /**
     * reset is the collMusicDeezerArtists collection loaded partially
     *
     * @return void
     */
    public function resetPartialMusicDeezerArtists($v = true)
    {
        $this->collMusicDeezerArtistsPartial = $v;
    }

    /**
     * Initializes the collMusicDeezerArtists collection.
     *
     * By default this just sets the collMusicDeezerArtists collection to an empty array (like clearcollMusicDeezerArtists());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMusicDeezerArtists($overrideExisting = true)
    {
        if (null !== $this->collMusicDeezerArtists && !$overrideExisting) {
            return;
        }
        $this->collMusicDeezerArtists = new PropelObjectCollection();
        $this->collMusicDeezerArtists->setModel('MusicDeezerArtist');
    }

    /**
     * Gets an array of MusicDeezerArtist objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this MusicArtist is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|MusicDeezerArtist[] List of MusicDeezerArtist objects
     * @throws PropelException
     */
    public function getMusicDeezerArtists($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collMusicDeezerArtistsPartial && !$this->isNew();
        if (null === $this->collMusicDeezerArtists || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMusicDeezerArtists) {
                // return empty collection
                $this->initMusicDeezerArtists();
            } else {
                $collMusicDeezerArtists = MusicDeezerArtistQuery::create(null, $criteria)
                    ->filterByMusicArtist($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collMusicDeezerArtistsPartial && count($collMusicDeezerArtists)) {
                      $this->initMusicDeezerArtists(false);

                      foreach ($collMusicDeezerArtists as $obj) {
                        if (false == $this->collMusicDeezerArtists->contains($obj)) {
                          $this->collMusicDeezerArtists->append($obj);
                        }
                      }

                      $this->collMusicDeezerArtistsPartial = true;
                    }

                    $collMusicDeezerArtists->getInternalIterator()->rewind();

                    return $collMusicDeezerArtists;
                }

                if ($partial && $this->collMusicDeezerArtists) {
                    foreach ($this->collMusicDeezerArtists as $obj) {
                        if ($obj->isNew()) {
                            $collMusicDeezerArtists[] = $obj;
                        }
                    }
                }

                $this->collMusicDeezerArtists = $collMusicDeezerArtists;
                $this->collMusicDeezerArtistsPartial = false;
            }
        }

        return $this->collMusicDeezerArtists;
    }

    /**
     * Sets a collection of MusicDeezerArtist objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $musicDeezerArtists A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return MusicArtist The current object (for fluent API support)
     */
    public function setMusicDeezerArtists(PropelCollection $musicDeezerArtists, PropelPDO $con = null)
    {
        $musicDeezerArtistsToDelete = $this->getMusicDeezerArtists(new Criteria(), $con)->diff($musicDeezerArtists);


        $this->musicDeezerArtistsScheduledForDeletion = $musicDeezerArtistsToDelete;

        foreach ($musicDeezerArtistsToDelete as $musicDeezerArtistRemoved) {
            $musicDeezerArtistRemoved->setMusicArtist(null);
        }

        $this->collMusicDeezerArtists = null;
        foreach ($musicDeezerArtists as $musicDeezerArtist) {
            $this->addMusicDeezerArtist($musicDeezerArtist);
        }

        $this->collMusicDeezerArtists = $musicDeezerArtists;
        $this->collMusicDeezerArtistsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related MusicDeezerArtist objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related MusicDeezerArtist objects.
     * @throws PropelException
     */
    public function countMusicDeezerArtists(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collMusicDeezerArtistsPartial && !$this->isNew();
        if (null === $this->collMusicDeezerArtists || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMusicDeezerArtists) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMusicDeezerArtists());
            }
            $query = MusicDeezerArtistQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMusicArtist($this)
                ->count($con);
        }

        return count($this->collMusicDeezerArtists);
    }

    /**
     * Method called to associate a MusicDeezerArtist object to this object
     * through the MusicDeezerArtist foreign key attribute.
     *
     * @param    MusicDeezerArtist $l MusicDeezerArtist
     * @return MusicArtist The current object (for fluent API support)
     */
    public function addMusicDeezerArtist(MusicDeezerArtist $l)
    {
        if ($this->collMusicDeezerArtists === null) {
            $this->initMusicDeezerArtists();
            $this->collMusicDeezerArtistsPartial = true;
        }

        if (!in_array($l, $this->collMusicDeezerArtists->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddMusicDeezerArtist($l);

            if ($this->musicDeezerArtistsScheduledForDeletion and $this->musicDeezerArtistsScheduledForDeletion->contains($l)) {
                $this->musicDeezerArtistsScheduledForDeletion->remove($this->musicDeezerArtistsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param  MusicDeezerArtist $musicDeezerArtist The musicDeezerArtist object to add.
     */
    protected function doAddMusicDeezerArtist($musicDeezerArtist)
    {
        $this->collMusicDeezerArtists[]= $musicDeezerArtist;
        $musicDeezerArtist->setMusicArtist($this);
    }

    /**
     * @param  MusicDeezerArtist $musicDeezerArtist The musicDeezerArtist object to remove.
     * @return MusicArtist The current object (for fluent API support)
     */
    public function removeMusicDeezerArtist($musicDeezerArtist)
    {
        if ($this->getMusicDeezerArtists()->contains($musicDeezerArtist)) {
            $this->collMusicDeezerArtists->remove($this->collMusicDeezerArtists->search($musicDeezerArtist));
            if (null === $this->musicDeezerArtistsScheduledForDeletion) {
                $this->musicDeezerArtistsScheduledForDeletion = clone $this->collMusicDeezerArtists;
                $this->musicDeezerArtistsScheduledForDeletion->clear();
            }
            $this->musicDeezerArtistsScheduledForDeletion[]= $musicDeezerArtist;
            $musicDeezerArtist->setMusicArtist(null);
        }

        return $this;
    }

    /**
     * Clears out the collMusicSpotifyArtists collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return MusicArtist The current object (for fluent API support)
     * @see        addMusicSpotifyArtists()
     */
    public function clearMusicSpotifyArtists()
    {
        $this->collMusicSpotifyArtists = null; // important to set this to null since that means it is uninitialized
        $this->collMusicSpotifyArtistsPartial = null;

        return $this;
    }

    /**
     * reset is the collMusicSpotifyArtists collection loaded partially
     *
     * @return void
     */
    public function resetPartialMusicSpotifyArtists($v = true)
    {
        $this->collMusicSpotifyArtistsPartial = $v;
    }

    /**
     * Initializes the collMusicSpotifyArtists collection.
     *
     * By default this just sets the collMusicSpotifyArtists collection to an empty array (like clearcollMusicSpotifyArtists());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMusicSpotifyArtists($overrideExisting = true)
    {
        if (null !== $this->collMusicSpotifyArtists && !$overrideExisting) {
            return;
        }
        $this->collMusicSpotifyArtists = new PropelObjectCollection();
        $this->collMusicSpotifyArtists->setModel('MusicSpotifyArtist');
    }

    /**
     * Gets an array of MusicSpotifyArtist objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this MusicArtist is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|MusicSpotifyArtist[] List of MusicSpotifyArtist objects
     * @throws PropelException
     */
    public function getMusicSpotifyArtists($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collMusicSpotifyArtistsPartial && !$this->isNew();
        if (null === $this->collMusicSpotifyArtists || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMusicSpotifyArtists) {
                // return empty collection
                $this->initMusicSpotifyArtists();
            } else {
                $collMusicSpotifyArtists = MusicSpotifyArtistQuery::create(null, $criteria)
                    ->filterByMusicArtist($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collMusicSpotifyArtistsPartial && count($collMusicSpotifyArtists)) {
                      $this->initMusicSpotifyArtists(false);

                      foreach ($collMusicSpotifyArtists as $obj) {
                        if (false == $this->collMusicSpotifyArtists->contains($obj)) {
                          $this->collMusicSpotifyArtists->append($obj);
                        }
                      }

                      $this->collMusicSpotifyArtistsPartial = true;
                    }

                    $collMusicSpotifyArtists->getInternalIterator()->rewind();

                    return $collMusicSpotifyArtists;
                }

                if ($partial && $this->collMusicSpotifyArtists) {
                    foreach ($this->collMusicSpotifyArtists as $obj) {
                        if ($obj->isNew()) {
                            $collMusicSpotifyArtists[] = $obj;
                        }
                    }
                }

                $this->collMusicSpotifyArtists = $collMusicSpotifyArtists;
                $this->collMusicSpotifyArtistsPartial = false;
            }
        }

        return $this->collMusicSpotifyArtists;
    }

    /**
     * Sets a collection of MusicSpotifyArtist objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $musicSpotifyArtists A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return MusicArtist The current object (for fluent API support)
     */
    public function setMusicSpotifyArtists(PropelCollection $musicSpotifyArtists, PropelPDO $con = null)
    {
        $musicSpotifyArtistsToDelete = $this->getMusicSpotifyArtists(new Criteria(), $con)->diff($musicSpotifyArtists);


        $this->musicSpotifyArtistsScheduledForDeletion = $musicSpotifyArtistsToDelete;

        foreach ($musicSpotifyArtistsToDelete as $musicSpotifyArtistRemoved) {
            $musicSpotifyArtistRemoved->setMusicArtist(null);
        }

        $this->collMusicSpotifyArtists = null;
        foreach ($musicSpotifyArtists as $musicSpotifyArtist) {
            $this->addMusicSpotifyArtist($musicSpotifyArtist);
        }

        $this->collMusicSpotifyArtists = $musicSpotifyArtists;
        $this->collMusicSpotifyArtistsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related MusicSpotifyArtist objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related MusicSpotifyArtist objects.
     * @throws PropelException
     */
    public function countMusicSpotifyArtists(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collMusicSpotifyArtistsPartial && !$this->isNew();
        if (null === $this->collMusicSpotifyArtists || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMusicSpotifyArtists) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMusicSpotifyArtists());
            }
            $query = MusicSpotifyArtistQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMusicArtist($this)
                ->count($con);
        }

        return count($this->collMusicSpotifyArtists);
    }

    /**
     * Method called to associate a MusicSpotifyArtist object to this object
     * through the MusicSpotifyArtist foreign key attribute.
     *
     * @param    MusicSpotifyArtist $l MusicSpotifyArtist
     * @return MusicArtist The current object (for fluent API support)
     */
    public function addMusicSpotifyArtist(MusicSpotifyArtist $l)
    {
        if ($this->collMusicSpotifyArtists === null) {
            $this->initMusicSpotifyArtists();
            $this->collMusicSpotifyArtistsPartial = true;
        }

        if (!in_array($l, $this->collMusicSpotifyArtists->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddMusicSpotifyArtist($l);

            if ($this->musicSpotifyArtistsScheduledForDeletion and $this->musicSpotifyArtistsScheduledForDeletion->contains($l)) {
                $this->musicSpotifyArtistsScheduledForDeletion->remove($this->musicSpotifyArtistsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param  MusicSpotifyArtist $musicSpotifyArtist The musicSpotifyArtist object to add.
     */
    protected function doAddMusicSpotifyArtist($musicSpotifyArtist)
    {
        $this->collMusicSpotifyArtists[]= $musicSpotifyArtist;
        $musicSpotifyArtist->setMusicArtist($this);
    }

    /**
     * @param  MusicSpotifyArtist $musicSpotifyArtist The musicSpotifyArtist object to remove.
     * @return MusicArtist The current object (for fluent API support)
     */
    public function removeMusicSpotifyArtist($musicSpotifyArtist)
    {
        if ($this->getMusicSpotifyArtists()->contains($musicSpotifyArtist)) {
            $this->collMusicSpotifyArtists->remove($this->collMusicSpotifyArtists->search($musicSpotifyArtist));
            if (null === $this->musicSpotifyArtistsScheduledForDeletion) {
                $this->musicSpotifyArtistsScheduledForDeletion = clone $this->collMusicSpotifyArtists;
                $this->musicSpotifyArtistsScheduledForDeletion->clear();
            }
            $this->musicSpotifyArtistsScheduledForDeletion[]= $musicSpotifyArtist;
            $musicSpotifyArtist->setMusicArtist(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->name = null;
        $this->alias = null;
        $this->image = null;
        $this->scan_deezer_search = null;
        $this->scan_spotify_search = null;
        $this->slug = null;
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
            if ($this->collMusicAlbums) {
                foreach ($this->collMusicAlbums as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMusicTracks) {
                foreach ($this->collMusicTracks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMusicDeezerArtists) {
                foreach ($this->collMusicDeezerArtists as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMusicSpotifyArtists) {
                foreach ($this->collMusicSpotifyArtists as $o) {
                    $o->clearAllReferences($deep);
                }
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collMusicAlbums instanceof PropelCollection) {
            $this->collMusicAlbums->clearIterator();
        }
        $this->collMusicAlbums = null;
        if ($this->collMusicTracks instanceof PropelCollection) {
            $this->collMusicTracks->clearIterator();
        }
        $this->collMusicTracks = null;
        if ($this->collMusicDeezerArtists instanceof PropelCollection) {
            $this->collMusicDeezerArtists->clearIterator();
        }
        $this->collMusicDeezerArtists = null;
        if ($this->collMusicSpotifyArtists instanceof PropelCollection) {
            $this->collMusicSpotifyArtists->clearIterator();
        }
        $this->collMusicSpotifyArtists = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string The value of the 'name' column
     */
    public function __toString()
    {
        return (string) $this->getName();
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

  // sluggable behavior

  /**
   * Create a unique slug based on the object
   *
   * @return string The object slug
   */
  protected function createSlug()
  {
      $slug = $this->createRawSlug();
      $slug = $this->limitSlugSize($slug);
      $slug = $this->makeSlugUnique($slug);

      return $slug;
  }

  /**
   * Create the slug from the appropriate columns
   *
   * @return string
   */
  protected function createRawSlug()
  {
      return $this->cleanupSlugPart($this->__toString());
  }

  /**
   * Cleanup a string to make a slug of it
   * Removes special characters, replaces blanks with a separator, and trim it
   *
   * @param     string $slug        the text to slugify
   * @param     string $replacement the separator used by slug
   * @return    string               the slugified text
   */
  protected static function cleanupSlugPart($slug, $replacement = '-')
  {
      // transliterate
      if (function_exists('iconv')) {
          $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);
      }

      // lowercase
      if (function_exists('mb_strtolower')) {
          $slug = mb_strtolower($slug);
      } else {
          $slug = strtolower($slug);
      }

      // remove accents resulting from OSX's iconv
      $slug = str_replace(array('\'', '`', '^'), '', $slug);

      // replace non letter or digits with separator
      $slug = preg_replace('/\W+/', $replacement, $slug);

      // trim
      $slug = trim($slug, $replacement);

      if (empty($slug)) {
          return 'n-a';
      }

      return $slug;
  }


  /**
   * Make sure the slug is short enough to accommodate the column size
   *
   * @param    string $slug                   the slug to check
   * @param    int    $incrementReservedSpace the number of characters to keep empty
   *
   * @return string                            the truncated slug
   */
  protected static function limitSlugSize($slug, $incrementReservedSpace = 3)
  {
      // check length, as suffix could put it over maximum
      if (strlen($slug) > (255 - $incrementReservedSpace)) {
          $slug = substr($slug, 0, 255 - $incrementReservedSpace);
      }

      return $slug;
  }


  /**
   * Get the slug, ensuring its uniqueness
   *
   * @param    string $slug            the slug to check
   * @param    string $separator       the separator used by slug
   * @param    int    $alreadyExists   false for the first try, true for the second, and take the high count + 1
   * @return   string                   the unique slug
   */
  protected function makeSlugUnique($slug, $separator = '-', $alreadyExists = false)
  {
      if (!$alreadyExists) {
          $slug2 = $slug;
      } else {
          $slug2 = $slug . $separator;

          $count = MusicArtistQuery::create()
              ->filterBySlug($this->getSlug())
              ->filterByPrimaryKey($this->getPrimaryKey())
          ->count();

          if (1 == $count) {
              return $this->getSlug();
          }
      }

       $query = MusicArtistQuery::create('q')
      ->where('q.Slug ' . ($alreadyExists ? 'REGEXP' : '=') . ' ?', $alreadyExists ? '^' . $slug2 . '[0-9]+$' : $slug2)->prune($this)
      ;

      if (!$alreadyExists) {
          $count = $query->count();
          if ($count > 0) {
              return $this->makeSlugUnique($slug, $separator, true);
          }

          return $slug2;
      }

      // Already exists
      $object = $query
          ->addDescendingOrderByColumn('LENGTH(slug)')
          ->addDescendingOrderByColumn('slug')
      ->findOne();

      // First duplicate slug
      if (null == $object) {
          return $slug2 . '1';
      }

      $slugNum = substr($object->getSlug(), strlen($slug) + 1);
      if ('0' === $slugNum[0]) {
          $slugNum[0] = 1;
      }

      return $slug2 . ($slugNum + 1);
  }

  // timestampable behavior

  /**
   * Mark the current object so that the update date doesn't get updated during next save
   *
   * @return     MusicArtist The current object (for fluent API support)
   */
  public function keepUpdateDateUnchanged()
  {
      $this->modifiedColumns[] = MusicArtistPeer::UPDATED_AT;

      return $this;
  }

}
