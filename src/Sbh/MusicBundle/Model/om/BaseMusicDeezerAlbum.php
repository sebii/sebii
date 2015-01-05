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
use Sbh\MusicBundle\Model\MusicDeezerAlbum;
use Sbh\MusicBundle\Model\MusicDeezerAlbumPeer;
use Sbh\MusicBundle\Model\MusicDeezerAlbumQuery;
use Sbh\MusicBundle\Model\MusicDeezerArtist;
use Sbh\MusicBundle\Model\MusicDeezerArtistQuery;
use Sbh\MusicBundle\Model\MusicDeezerTrack;
use Sbh\MusicBundle\Model\MusicDeezerTrackQuery;

abstract class BaseMusicDeezerAlbum extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Sbh\\MusicBundle\\Model\\MusicDeezerAlbumPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        MusicDeezerAlbumPeer
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
     * The value for the album_id field.
     * @var        int
     */
    protected $album_id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the image field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $image;

    /**
     * The value for the artist_deezer_id field.
     * @var        int
     */
    protected $artist_deezer_id;

    /**
     * The value for the main_genre_deezer_id field.
     * @var        int
     */
    protected $main_genre_deezer_id;

    /**
     * The value for the genre_deezer_ids field.
     * @var        array
     */
    protected $genre_deezer_ids;

    /**
     * The unserialized $genre_deezer_ids value - i.e. the persisted object.
     * This is necessary to avoid repeated calls to unserialize() at runtime.
     * @var        object
     */
    protected $genre_deezer_ids_unserialized;

    /**
     * The value for the record_type field.
     * @var        int
     */
    protected $record_type;

    /**
     * The value for the upc field.
     * @var        string
     */
    protected $upc;

    /**
     * The value for the label field.
     * @var        string
     */
    protected $label;

    /**
     * The value for the nb_tracks field.
     * @var        int
     */
    protected $nb_tracks;

    /**
     * The value for the duration field.
     * @var        int
     */
    protected $duration;

    /**
     * The value for the nb_fans field.
     * @var        int
     */
    protected $nb_fans;

    /**
     * The value for the rating field.
     * @var        int
     */
    protected $rating;

    /**
     * The value for the release_date field.
     * @var        string
     */
    protected $release_date;

    /**
     * The value for the available field.
     * @var        boolean
     */
    protected $available;

    /**
     * The value for the explicit_lyrics field.
     * @var        boolean
     */
    protected $explicit_lyrics;

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
     * @var        MusicAlbum
     */
    protected $aMusicAlbum;

    /**
     * @var        MusicDeezerArtist
     */
    protected $aMusicDeezerArtist;

    /**
     * @var        PropelObjectCollection|MusicDeezerTrack[] Collection to store aggregation of MusicDeezerTrack objects.
     */
    protected $collMusicDeezerTracks;
    protected $collMusicDeezerTracksPartial;

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
    protected $musicDeezerTracksScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->image = false;
    }

    /**
     * Initializes internal state of BaseMusicDeezerAlbum object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

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
     * Get the [album_id] column value.
     *
     * @return int
     */
    public function getAlbumId()
    {

        return $this->album_id;
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
     * Get the [image] column value.
     *
     * @return boolean
     */
    public function getImage()
    {

        return $this->image;
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
     * Get the [main_genre_deezer_id] column value.
     *
     * @return int
     */
    public function getMainGenreDeezerId()
    {

        return $this->main_genre_deezer_id;
    }

    /**
     * Get the [genre_deezer_ids] column value.
     *
     * @return array
     */
    public function getGenreDeezerIds()
    {
        if (null === $this->genre_deezer_ids_unserialized) {
            $this->genre_deezer_ids_unserialized = array();
        }
        if (!$this->genre_deezer_ids_unserialized && null !== $this->genre_deezer_ids) {
            $genre_deezer_ids_unserialized = substr($this->genre_deezer_ids, 2, -2);
            $this->genre_deezer_ids_unserialized = $genre_deezer_ids_unserialized ? explode(' | ', $genre_deezer_ids_unserialized) : array();
        }

        return $this->genre_deezer_ids_unserialized;
    }

    /**
     * Test the presence of a value in the [genre_deezer_ids] array column value.
     * @param mixed $value
     *
     * @return boolean
     */
    public function hasGenreDeezerId($value)
    {
        return in_array($value, $this->getGenreDeezerIds());
    } // hasGenreDeezerId()

    /**
     * Get the [record_type] column value.
     *
     * @return int
     * @throws PropelException - if the stored enum key is unknown.
     */
    public function getRecordType()
    {
        if (null === $this->record_type) {
            return null;
        }
        $valueSet = MusicDeezerAlbumPeer::getValueSet(MusicDeezerAlbumPeer::RECORD_TYPE);
        if (!isset($valueSet[$this->record_type])) {
            throw new PropelException('Unknown stored enum key: ' . $this->record_type);
        }

        return $valueSet[$this->record_type];
    }

    /**
     * Get the [upc] column value.
     *
     * @return string
     */
    public function getUpc()
    {

        return $this->upc;
    }

    /**
     * Get the [label] column value.
     *
     * @return string
     */
    public function getLabel()
    {

        return $this->label;
    }

    /**
     * Get the [nb_tracks] column value.
     *
     * @return int
     */
    public function getNbTracks()
    {

        return $this->nb_tracks;
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
     * Get the [nb_fans] column value.
     *
     * @return int
     */
    public function getNbFans()
    {

        return $this->nb_fans;
    }

    /**
     * Get the [rating] column value.
     *
     * @return int
     */
    public function getRating()
    {

        return $this->rating;
    }

    /**
     * Get the [optionally formatted] temporal [release_date] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *         If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getReleaseDate($format = null)
    {
        if ($this->release_date === null) {
            return null;
        }

        if ($this->release_date === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->release_date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->release_date, true), $x);
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
     * Get the [available] column value.
     *
     * @return boolean
     */
    public function getAvailable()
    {

        return $this->available;
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
     * @return MusicDeezerAlbum The current object (for fluent API support)
     */
    public function setDeezerId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->deezer_id !== $v) {
            $this->deezer_id = $v;
            $this->modifiedColumns[] = MusicDeezerAlbumPeer::DEEZER_ID;
        }


        return $this;
    } // setDeezerId()

    /**
     * Set the value of [album_id] column.
     *
     * @param  int $v new value
     * @return MusicDeezerAlbum The current object (for fluent API support)
     */
    public function setAlbumId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->album_id !== $v) {
            $this->album_id = $v;
            $this->modifiedColumns[] = MusicDeezerAlbumPeer::ALBUM_ID;
        }

        if ($this->aMusicAlbum !== null && $this->aMusicAlbum->getId() !== $v) {
            $this->aMusicAlbum = null;
        }


        return $this;
    } // setAlbumId()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return MusicDeezerAlbum The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = MusicDeezerAlbumPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Sets the value of the [image] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return MusicDeezerAlbum The current object (for fluent API support)
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
            $this->modifiedColumns[] = MusicDeezerAlbumPeer::IMAGE;
        }


        return $this;
    } // setImage()

    /**
     * Set the value of [artist_deezer_id] column.
     *
     * @param  int $v new value
     * @return MusicDeezerAlbum The current object (for fluent API support)
     */
    public function setArtistDeezerId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->artist_deezer_id !== $v) {
            $this->artist_deezer_id = $v;
            $this->modifiedColumns[] = MusicDeezerAlbumPeer::ARTIST_DEEZER_ID;
        }

        if ($this->aMusicDeezerArtist !== null && $this->aMusicDeezerArtist->getDeezerId() !== $v) {
            $this->aMusicDeezerArtist = null;
        }


        return $this;
    } // setArtistDeezerId()

    /**
     * Set the value of [main_genre_deezer_id] column.
     *
     * @param  int $v new value
     * @return MusicDeezerAlbum The current object (for fluent API support)
     */
    public function setMainGenreDeezerId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->main_genre_deezer_id !== $v) {
            $this->main_genre_deezer_id = $v;
            $this->modifiedColumns[] = MusicDeezerAlbumPeer::MAIN_GENRE_DEEZER_ID;
        }


        return $this;
    } // setMainGenreDeezerId()

    /**
     * Set the value of [genre_deezer_ids] column.
     *
     * @param  array $v new value
     * @return MusicDeezerAlbum The current object (for fluent API support)
     */
    public function setGenreDeezerIds($v)
    {
        if ($this->genre_deezer_ids_unserialized !== $v) {
            $this->genre_deezer_ids_unserialized = $v;
            $this->genre_deezer_ids = '| ' . implode(' | ', (array) $v) . ' |';
            $this->modifiedColumns[] = MusicDeezerAlbumPeer::GENRE_DEEZER_IDS;
        }


        return $this;
    } // setGenreDeezerIds()

    /**
     * Adds a value to the [genre_deezer_ids] array column value.
     * @param mixed $value
     *
     * @return MusicDeezerAlbum The current object (for fluent API support)
     */
    public function addGenreDeezerId($value)
    {
        $currentArray = $this->getGenreDeezerIds();
        $currentArray []= $value;
        $this->setGenreDeezerIds($currentArray);

        return $this;
    } // addGenreDeezerId()

    /**
     * Removes a value from the [genre_deezer_ids] array column value.
     * @param mixed $value
     *
     * @return MusicDeezerAlbum The current object (for fluent API support)
     */
    public function removeGenreDeezerId($value)
    {
        $targetArray = array();
        foreach ($this->getGenreDeezerIds() as $element) {
            if ($element != $value) {
                $targetArray []= $element;
            }
        }
        $this->setGenreDeezerIds($targetArray);

        return $this;
    } // removeGenreDeezerId()

    /**
     * Set the value of [record_type] column.
     *
     * @param  int $v new value
     * @return MusicDeezerAlbum The current object (for fluent API support)
     * @throws PropelException - if the value is not accepted by this enum.
     */
    public function setRecordType($v)
    {
        if ($v !== null) {
            $valueSet = MusicDeezerAlbumPeer::getValueSet(MusicDeezerAlbumPeer::RECORD_TYPE);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->record_type !== $v) {
            $this->record_type = $v;
            $this->modifiedColumns[] = MusicDeezerAlbumPeer::RECORD_TYPE;
        }


        return $this;
    } // setRecordType()

    /**
     * Set the value of [upc] column.
     *
     * @param  string $v new value
     * @return MusicDeezerAlbum The current object (for fluent API support)
     */
    public function setUpc($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->upc !== $v) {
            $this->upc = $v;
            $this->modifiedColumns[] = MusicDeezerAlbumPeer::UPC;
        }


        return $this;
    } // setUpc()

    /**
     * Set the value of [label] column.
     *
     * @param  string $v new value
     * @return MusicDeezerAlbum The current object (for fluent API support)
     */
    public function setLabel($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->label !== $v) {
            $this->label = $v;
            $this->modifiedColumns[] = MusicDeezerAlbumPeer::LABEL;
        }


        return $this;
    } // setLabel()

    /**
     * Set the value of [nb_tracks] column.
     *
     * @param  int $v new value
     * @return MusicDeezerAlbum The current object (for fluent API support)
     */
    public function setNbTracks($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->nb_tracks !== $v) {
            $this->nb_tracks = $v;
            $this->modifiedColumns[] = MusicDeezerAlbumPeer::NB_TRACKS;
        }


        return $this;
    } // setNbTracks()

    /**
     * Set the value of [duration] column.
     *
     * @param  int $v new value
     * @return MusicDeezerAlbum The current object (for fluent API support)
     */
    public function setDuration($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->duration !== $v) {
            $this->duration = $v;
            $this->modifiedColumns[] = MusicDeezerAlbumPeer::DURATION;
        }


        return $this;
    } // setDuration()

    /**
     * Set the value of [nb_fans] column.
     *
     * @param  int $v new value
     * @return MusicDeezerAlbum The current object (for fluent API support)
     */
    public function setNbFans($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->nb_fans !== $v) {
            $this->nb_fans = $v;
            $this->modifiedColumns[] = MusicDeezerAlbumPeer::NB_FANS;
        }


        return $this;
    } // setNbFans()

    /**
     * Set the value of [rating] column.
     *
     * @param  int $v new value
     * @return MusicDeezerAlbum The current object (for fluent API support)
     */
    public function setRating($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->rating !== $v) {
            $this->rating = $v;
            $this->modifiedColumns[] = MusicDeezerAlbumPeer::RATING;
        }


        return $this;
    } // setRating()

    /**
     * Sets the value of [release_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return MusicDeezerAlbum The current object (for fluent API support)
     */
    public function setReleaseDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->release_date !== null || $dt !== null) {
            $currentDateAsString = ($this->release_date !== null && $tmpDt = new DateTime($this->release_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->release_date = $newDateAsString;
                $this->modifiedColumns[] = MusicDeezerAlbumPeer::RELEASE_DATE;
            }
        } // if either are not null


        return $this;
    } // setReleaseDate()

    /**
     * Sets the value of the [available] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return MusicDeezerAlbum The current object (for fluent API support)
     */
    public function setAvailable($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->available !== $v) {
            $this->available = $v;
            $this->modifiedColumns[] = MusicDeezerAlbumPeer::AVAILABLE;
        }


        return $this;
    } // setAvailable()

    /**
     * Sets the value of the [explicit_lyrics] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return MusicDeezerAlbum The current object (for fluent API support)
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
            $this->modifiedColumns[] = MusicDeezerAlbumPeer::EXPLICIT_LYRICS;
        }


        return $this;
    } // setExplicitLyrics()

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return MusicDeezerAlbum The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = MusicDeezerAlbumPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return MusicDeezerAlbum The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            $currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->created_at = $newDateAsString;
                $this->modifiedColumns[] = MusicDeezerAlbumPeer::CREATED_AT;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return MusicDeezerAlbum The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            $currentDateAsString = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->updated_at = $newDateAsString;
                $this->modifiedColumns[] = MusicDeezerAlbumPeer::UPDATED_AT;
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
            $this->album_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->image = ($row[$startcol + 3] !== null) ? (boolean) $row[$startcol + 3] : null;
            $this->artist_deezer_id = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->main_genre_deezer_id = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->genre_deezer_ids = $row[$startcol + 6];
            $this->genre_deezer_ids_unserialized = null;
            $this->record_type = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->upc = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->label = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
            $this->nb_tracks = ($row[$startcol + 10] !== null) ? (int) $row[$startcol + 10] : null;
            $this->duration = ($row[$startcol + 11] !== null) ? (int) $row[$startcol + 11] : null;
            $this->nb_fans = ($row[$startcol + 12] !== null) ? (int) $row[$startcol + 12] : null;
            $this->rating = ($row[$startcol + 13] !== null) ? (int) $row[$startcol + 13] : null;
            $this->release_date = ($row[$startcol + 14] !== null) ? (string) $row[$startcol + 14] : null;
            $this->available = ($row[$startcol + 15] !== null) ? (boolean) $row[$startcol + 15] : null;
            $this->explicit_lyrics = ($row[$startcol + 16] !== null) ? (boolean) $row[$startcol + 16] : null;
            $this->id = ($row[$startcol + 17] !== null) ? (int) $row[$startcol + 17] : null;
            $this->created_at = ($row[$startcol + 18] !== null) ? (string) $row[$startcol + 18] : null;
            $this->updated_at = ($row[$startcol + 19] !== null) ? (string) $row[$startcol + 19] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 20; // 20 = MusicDeezerAlbumPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating MusicDeezerAlbum object", $e);
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

        if ($this->aMusicAlbum !== null && $this->album_id !== $this->aMusicAlbum->getId()) {
            $this->aMusicAlbum = null;
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
            $con = Propel::getConnection(MusicDeezerAlbumPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = MusicDeezerAlbumPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aMusicAlbum = null;
            $this->aMusicDeezerArtist = null;
            $this->collMusicDeezerTracks = null;

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
            $con = Propel::getConnection(MusicDeezerAlbumPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = MusicDeezerAlbumQuery::create()
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
            $con = Propel::getConnection(MusicDeezerAlbumPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
        // timestampable behavior
        if (!$this->isColumnModified(MusicDeezerAlbumPeer::CREATED_AT))
        {
            $this->setCreatedAt(time());
        }
        if (!$this->isColumnModified(MusicDeezerAlbumPeer::UPDATED_AT))
        {
            $this->setUpdatedAt(time());
        }
            } else {
                $ret = $ret && $this->preUpdate($con);
        // timestampable behavior
        if ($this->isModified() && !$this->isColumnModified(MusicDeezerAlbumPeer::UPDATED_AT))
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
                MusicDeezerAlbumPeer::addInstanceToPool($this);
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

            if ($this->aMusicAlbum !== null) {
                if ($this->aMusicAlbum->isModified() || $this->aMusicAlbum->isNew()) {
                    $affectedRows += $this->aMusicAlbum->save($con);
                }
                $this->setMusicAlbum($this->aMusicAlbum);
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

            if ($this->musicDeezerTracksScheduledForDeletion !== null) {
                if (!$this->musicDeezerTracksScheduledForDeletion->isEmpty()) {
                    foreach ($this->musicDeezerTracksScheduledForDeletion as $musicDeezerTrack) {
                        // need to save related object because we set the relation to null
                        $musicDeezerTrack->save($con);
                    }
                    $this->musicDeezerTracksScheduledForDeletion = null;
                }
            }

            if ($this->collMusicDeezerTracks !== null) {
                foreach ($this->collMusicDeezerTracks as $referrerFK) {
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

        $this->modifiedColumns[] = MusicDeezerAlbumPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . MusicDeezerAlbumPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(MusicDeezerAlbumPeer::DEEZER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`deezer_id`';
        }
        if ($this->isColumnModified(MusicDeezerAlbumPeer::ALBUM_ID)) {
            $modifiedColumns[':p' . $index++]  = '`album_id`';
        }
        if ($this->isColumnModified(MusicDeezerAlbumPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(MusicDeezerAlbumPeer::IMAGE)) {
            $modifiedColumns[':p' . $index++]  = '`image`';
        }
        if ($this->isColumnModified(MusicDeezerAlbumPeer::ARTIST_DEEZER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`artist_deezer_id`';
        }
        if ($this->isColumnModified(MusicDeezerAlbumPeer::MAIN_GENRE_DEEZER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`main_genre_deezer_id`';
        }
        if ($this->isColumnModified(MusicDeezerAlbumPeer::GENRE_DEEZER_IDS)) {
            $modifiedColumns[':p' . $index++]  = '`genre_deezer_ids`';
        }
        if ($this->isColumnModified(MusicDeezerAlbumPeer::RECORD_TYPE)) {
            $modifiedColumns[':p' . $index++]  = '`record_type`';
        }
        if ($this->isColumnModified(MusicDeezerAlbumPeer::UPC)) {
            $modifiedColumns[':p' . $index++]  = '`upc`';
        }
        if ($this->isColumnModified(MusicDeezerAlbumPeer::LABEL)) {
            $modifiedColumns[':p' . $index++]  = '`label`';
        }
        if ($this->isColumnModified(MusicDeezerAlbumPeer::NB_TRACKS)) {
            $modifiedColumns[':p' . $index++]  = '`nb_tracks`';
        }
        if ($this->isColumnModified(MusicDeezerAlbumPeer::DURATION)) {
            $modifiedColumns[':p' . $index++]  = '`duration`';
        }
        if ($this->isColumnModified(MusicDeezerAlbumPeer::NB_FANS)) {
            $modifiedColumns[':p' . $index++]  = '`nb_fans`';
        }
        if ($this->isColumnModified(MusicDeezerAlbumPeer::RATING)) {
            $modifiedColumns[':p' . $index++]  = '`rating`';
        }
        if ($this->isColumnModified(MusicDeezerAlbumPeer::RELEASE_DATE)) {
            $modifiedColumns[':p' . $index++]  = '`release_date`';
        }
        if ($this->isColumnModified(MusicDeezerAlbumPeer::AVAILABLE)) {
            $modifiedColumns[':p' . $index++]  = '`available`';
        }
        if ($this->isColumnModified(MusicDeezerAlbumPeer::EXPLICIT_LYRICS)) {
            $modifiedColumns[':p' . $index++]  = '`explicit_lyrics`';
        }
        if ($this->isColumnModified(MusicDeezerAlbumPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(MusicDeezerAlbumPeer::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }
        if ($this->isColumnModified(MusicDeezerAlbumPeer::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`updated_at`';
        }

        $sql = sprintf(
            'INSERT INTO `music_deezer_album` (%s) VALUES (%s)',
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
                    case '`album_id`':
            $stmt->bindValue($identifier, $this->album_id, PDO::PARAM_INT);
                        break;
                    case '`name`':
            $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`image`':
            $stmt->bindValue($identifier, (int) $this->image, PDO::PARAM_INT);
                        break;
                    case '`artist_deezer_id`':
            $stmt->bindValue($identifier, $this->artist_deezer_id, PDO::PARAM_INT);
                        break;
                    case '`main_genre_deezer_id`':
            $stmt->bindValue($identifier, $this->main_genre_deezer_id, PDO::PARAM_INT);
                        break;
                    case '`genre_deezer_ids`':
            $stmt->bindValue($identifier, $this->genre_deezer_ids, PDO::PARAM_STR);
                        break;
                    case '`record_type`':
            $stmt->bindValue($identifier, $this->record_type, PDO::PARAM_INT);
                        break;
                    case '`upc`':
            $stmt->bindValue($identifier, $this->upc, PDO::PARAM_STR);
                        break;
                    case '`label`':
            $stmt->bindValue($identifier, $this->label, PDO::PARAM_STR);
                        break;
                    case '`nb_tracks`':
            $stmt->bindValue($identifier, $this->nb_tracks, PDO::PARAM_INT);
                        break;
                    case '`duration`':
            $stmt->bindValue($identifier, $this->duration, PDO::PARAM_INT);
                        break;
                    case '`nb_fans`':
            $stmt->bindValue($identifier, $this->nb_fans, PDO::PARAM_INT);
                        break;
                    case '`rating`':
            $stmt->bindValue($identifier, $this->rating, PDO::PARAM_INT);
                        break;
                    case '`release_date`':
            $stmt->bindValue($identifier, $this->release_date, PDO::PARAM_STR);
                        break;
                    case '`available`':
            $stmt->bindValue($identifier, (int) $this->available, PDO::PARAM_INT);
                        break;
                    case '`explicit_lyrics`':
            $stmt->bindValue($identifier, (int) $this->explicit_lyrics, PDO::PARAM_INT);
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

            if ($this->aMusicAlbum !== null) {
                if (!$this->aMusicAlbum->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aMusicAlbum->getValidationFailures());
                }
            }

            if ($this->aMusicDeezerArtist !== null) {
                if (!$this->aMusicDeezerArtist->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aMusicDeezerArtist->getValidationFailures());
                }
            }


            if (($retval = MusicDeezerAlbumPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collMusicDeezerTracks !== null) {
                    foreach ($this->collMusicDeezerTracks as $referrerFK) {
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
        $pos = MusicDeezerAlbumPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getAlbumId();
                break;
            case 2:
                return $this->getName();
                break;
            case 3:
                return $this->getImage();
                break;
            case 4:
                return $this->getArtistDeezerId();
                break;
            case 5:
                return $this->getMainGenreDeezerId();
                break;
            case 6:
                return $this->getGenreDeezerIds();
                break;
            case 7:
                return $this->getRecordType();
                break;
            case 8:
                return $this->getUpc();
                break;
            case 9:
                return $this->getLabel();
                break;
            case 10:
                return $this->getNbTracks();
                break;
            case 11:
                return $this->getDuration();
                break;
            case 12:
                return $this->getNbFans();
                break;
            case 13:
                return $this->getRating();
                break;
            case 14:
                return $this->getReleaseDate();
                break;
            case 15:
                return $this->getAvailable();
                break;
            case 16:
                return $this->getExplicitLyrics();
                break;
            case 17:
                return $this->getId();
                break;
            case 18:
                return $this->getCreatedAt();
                break;
            case 19:
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
        if (isset($alreadyDumpedObjects['MusicDeezerAlbum'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['MusicDeezerAlbum'][$this->getPrimaryKey()] = true;
        $keys = MusicDeezerAlbumPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getDeezerId(),
            $keys[1] => $this->getAlbumId(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getImage(),
            $keys[4] => $this->getArtistDeezerId(),
            $keys[5] => $this->getMainGenreDeezerId(),
            $keys[6] => $this->getGenreDeezerIds(),
            $keys[7] => $this->getRecordType(),
            $keys[8] => $this->getUpc(),
            $keys[9] => $this->getLabel(),
            $keys[10] => $this->getNbTracks(),
            $keys[11] => $this->getDuration(),
            $keys[12] => $this->getNbFans(),
            $keys[13] => $this->getRating(),
            $keys[14] => $this->getReleaseDate(),
            $keys[15] => $this->getAvailable(),
            $keys[16] => $this->getExplicitLyrics(),
            $keys[17] => $this->getId(),
            $keys[18] => $this->getCreatedAt(),
            $keys[19] => $this->getUpdatedAt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aMusicAlbum) {
                $result['MusicAlbum'] = $this->aMusicAlbum->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aMusicDeezerArtist) {
                $result['MusicDeezerArtist'] = $this->aMusicDeezerArtist->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collMusicDeezerTracks) {
                $result['MusicDeezerTracks'] = $this->collMusicDeezerTracks->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = MusicDeezerAlbumPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setAlbumId($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
                $this->setImage($value);
                break;
            case 4:
                $this->setArtistDeezerId($value);
                break;
            case 5:
                $this->setMainGenreDeezerId($value);
                break;
            case 6:
                if (!is_array($value)) {
                    $v = trim(substr($value, 2, -2));
                    $value = $v ? explode(' | ', $v) : array();
                }
                $this->setGenreDeezerIds($value);
                break;
            case 7:
                $valueSet = MusicDeezerAlbumPeer::getValueSet(MusicDeezerAlbumPeer::RECORD_TYPE);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setRecordType($value);
                break;
            case 8:
                $this->setUpc($value);
                break;
            case 9:
                $this->setLabel($value);
                break;
            case 10:
                $this->setNbTracks($value);
                break;
            case 11:
                $this->setDuration($value);
                break;
            case 12:
                $this->setNbFans($value);
                break;
            case 13:
                $this->setRating($value);
                break;
            case 14:
                $this->setReleaseDate($value);
                break;
            case 15:
                $this->setAvailable($value);
                break;
            case 16:
                $this->setExplicitLyrics($value);
                break;
            case 17:
                $this->setId($value);
                break;
            case 18:
                $this->setCreatedAt($value);
                break;
            case 19:
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
        $keys = MusicDeezerAlbumPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setDeezerId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setAlbumId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setImage($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setArtistDeezerId($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setMainGenreDeezerId($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setGenreDeezerIds($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setRecordType($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setUpc($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setLabel($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setNbTracks($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setDuration($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setNbFans($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setRating($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setReleaseDate($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setAvailable($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setExplicitLyrics($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setId($arr[$keys[17]]);
        if (array_key_exists($keys[18], $arr)) $this->setCreatedAt($arr[$keys[18]]);
        if (array_key_exists($keys[19], $arr)) $this->setUpdatedAt($arr[$keys[19]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(MusicDeezerAlbumPeer::DATABASE_NAME);

        if ($this->isColumnModified(MusicDeezerAlbumPeer::DEEZER_ID)) $criteria->add(MusicDeezerAlbumPeer::DEEZER_ID, $this->deezer_id);
        if ($this->isColumnModified(MusicDeezerAlbumPeer::ALBUM_ID)) $criteria->add(MusicDeezerAlbumPeer::ALBUM_ID, $this->album_id);
        if ($this->isColumnModified(MusicDeezerAlbumPeer::NAME)) $criteria->add(MusicDeezerAlbumPeer::NAME, $this->name);
        if ($this->isColumnModified(MusicDeezerAlbumPeer::IMAGE)) $criteria->add(MusicDeezerAlbumPeer::IMAGE, $this->image);
        if ($this->isColumnModified(MusicDeezerAlbumPeer::ARTIST_DEEZER_ID)) $criteria->add(MusicDeezerAlbumPeer::ARTIST_DEEZER_ID, $this->artist_deezer_id);
        if ($this->isColumnModified(MusicDeezerAlbumPeer::MAIN_GENRE_DEEZER_ID)) $criteria->add(MusicDeezerAlbumPeer::MAIN_GENRE_DEEZER_ID, $this->main_genre_deezer_id);
        if ($this->isColumnModified(MusicDeezerAlbumPeer::GENRE_DEEZER_IDS)) $criteria->add(MusicDeezerAlbumPeer::GENRE_DEEZER_IDS, $this->genre_deezer_ids);
        if ($this->isColumnModified(MusicDeezerAlbumPeer::RECORD_TYPE)) $criteria->add(MusicDeezerAlbumPeer::RECORD_TYPE, $this->record_type);
        if ($this->isColumnModified(MusicDeezerAlbumPeer::UPC)) $criteria->add(MusicDeezerAlbumPeer::UPC, $this->upc);
        if ($this->isColumnModified(MusicDeezerAlbumPeer::LABEL)) $criteria->add(MusicDeezerAlbumPeer::LABEL, $this->label);
        if ($this->isColumnModified(MusicDeezerAlbumPeer::NB_TRACKS)) $criteria->add(MusicDeezerAlbumPeer::NB_TRACKS, $this->nb_tracks);
        if ($this->isColumnModified(MusicDeezerAlbumPeer::DURATION)) $criteria->add(MusicDeezerAlbumPeer::DURATION, $this->duration);
        if ($this->isColumnModified(MusicDeezerAlbumPeer::NB_FANS)) $criteria->add(MusicDeezerAlbumPeer::NB_FANS, $this->nb_fans);
        if ($this->isColumnModified(MusicDeezerAlbumPeer::RATING)) $criteria->add(MusicDeezerAlbumPeer::RATING, $this->rating);
        if ($this->isColumnModified(MusicDeezerAlbumPeer::RELEASE_DATE)) $criteria->add(MusicDeezerAlbumPeer::RELEASE_DATE, $this->release_date);
        if ($this->isColumnModified(MusicDeezerAlbumPeer::AVAILABLE)) $criteria->add(MusicDeezerAlbumPeer::AVAILABLE, $this->available);
        if ($this->isColumnModified(MusicDeezerAlbumPeer::EXPLICIT_LYRICS)) $criteria->add(MusicDeezerAlbumPeer::EXPLICIT_LYRICS, $this->explicit_lyrics);
        if ($this->isColumnModified(MusicDeezerAlbumPeer::ID)) $criteria->add(MusicDeezerAlbumPeer::ID, $this->id);
        if ($this->isColumnModified(MusicDeezerAlbumPeer::CREATED_AT)) $criteria->add(MusicDeezerAlbumPeer::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(MusicDeezerAlbumPeer::UPDATED_AT)) $criteria->add(MusicDeezerAlbumPeer::UPDATED_AT, $this->updated_at);

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
        $criteria = new Criteria(MusicDeezerAlbumPeer::DATABASE_NAME);
        $criteria->add(MusicDeezerAlbumPeer::ID, $this->id);

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
     * @param object $copyObj An object of MusicDeezerAlbum (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setDeezerId($this->getDeezerId());
        $copyObj->setAlbumId($this->getAlbumId());
        $copyObj->setName($this->getName());
        $copyObj->setImage($this->getImage());
        $copyObj->setArtistDeezerId($this->getArtistDeezerId());
        $copyObj->setMainGenreDeezerId($this->getMainGenreDeezerId());
        $copyObj->setGenreDeezerIds($this->getGenreDeezerIds());
        $copyObj->setRecordType($this->getRecordType());
        $copyObj->setUpc($this->getUpc());
        $copyObj->setLabel($this->getLabel());
        $copyObj->setNbTracks($this->getNbTracks());
        $copyObj->setDuration($this->getDuration());
        $copyObj->setNbFans($this->getNbFans());
        $copyObj->setRating($this->getRating());
        $copyObj->setReleaseDate($this->getReleaseDate());
        $copyObj->setAvailable($this->getAvailable());
        $copyObj->setExplicitLyrics($this->getExplicitLyrics());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getMusicDeezerTracks() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMusicDeezerTrack($relObj->copy($deepCopy));
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
     * @return MusicDeezerAlbum Clone of current object.
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
     * @return MusicDeezerAlbumPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new MusicDeezerAlbumPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a MusicAlbum object.
     *
     * @param                  MusicAlbum $v
     * @return MusicDeezerAlbum The current object (for fluent API support)
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
            $v->addMusicDeezerAlbum($this);
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
                $this->aMusicAlbum->addMusicDeezerAlbums($this);
             */
        }

        return $this->aMusicAlbum;
    }

    /**
     * Declares an association between this object and a MusicDeezerArtist object.
     *
     * @param                  MusicDeezerArtist $v
     * @return MusicDeezerAlbum The current object (for fluent API support)
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
            $v->addMusicDeezerAlbum($this);
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
                ->filterByMusicDeezerAlbum($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aMusicDeezerArtist->addMusicDeezerAlbums($this);
             */
        }

        return $this->aMusicDeezerArtist;
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
        if ('MusicDeezerTrack' == $relationName) {
            $this->initMusicDeezerTracks();
        }
    }

    /**
     * Clears out the collMusicDeezerTracks collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return MusicDeezerAlbum The current object (for fluent API support)
     * @see        addMusicDeezerTracks()
     */
    public function clearMusicDeezerTracks()
    {
        $this->collMusicDeezerTracks = null; // important to set this to null since that means it is uninitialized
        $this->collMusicDeezerTracksPartial = null;

        return $this;
    }

    /**
     * reset is the collMusicDeezerTracks collection loaded partially
     *
     * @return void
     */
    public function resetPartialMusicDeezerTracks($v = true)
    {
        $this->collMusicDeezerTracksPartial = $v;
    }

    /**
     * Initializes the collMusicDeezerTracks collection.
     *
     * By default this just sets the collMusicDeezerTracks collection to an empty array (like clearcollMusicDeezerTracks());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMusicDeezerTracks($overrideExisting = true)
    {
        if (null !== $this->collMusicDeezerTracks && !$overrideExisting) {
            return;
        }
        $this->collMusicDeezerTracks = new PropelObjectCollection();
        $this->collMusicDeezerTracks->setModel('MusicDeezerTrack');
    }

    /**
     * Gets an array of MusicDeezerTrack objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this MusicDeezerAlbum is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|MusicDeezerTrack[] List of MusicDeezerTrack objects
     * @throws PropelException
     */
    public function getMusicDeezerTracks($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collMusicDeezerTracksPartial && !$this->isNew();
        if (null === $this->collMusicDeezerTracks || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMusicDeezerTracks) {
                // return empty collection
                $this->initMusicDeezerTracks();
            } else {
                $collMusicDeezerTracks = MusicDeezerTrackQuery::create(null, $criteria)
                    ->filterByMusicDeezerAlbum($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collMusicDeezerTracksPartial && count($collMusicDeezerTracks)) {
                      $this->initMusicDeezerTracks(false);

                      foreach ($collMusicDeezerTracks as $obj) {
                        if (false == $this->collMusicDeezerTracks->contains($obj)) {
                          $this->collMusicDeezerTracks->append($obj);
                        }
                      }

                      $this->collMusicDeezerTracksPartial = true;
                    }

                    $collMusicDeezerTracks->getInternalIterator()->rewind();

                    return $collMusicDeezerTracks;
                }

                if ($partial && $this->collMusicDeezerTracks) {
                    foreach ($this->collMusicDeezerTracks as $obj) {
                        if ($obj->isNew()) {
                            $collMusicDeezerTracks[] = $obj;
                        }
                    }
                }

                $this->collMusicDeezerTracks = $collMusicDeezerTracks;
                $this->collMusicDeezerTracksPartial = false;
            }
        }

        return $this->collMusicDeezerTracks;
    }

    /**
     * Sets a collection of MusicDeezerTrack objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $musicDeezerTracks A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return MusicDeezerAlbum The current object (for fluent API support)
     */
    public function setMusicDeezerTracks(PropelCollection $musicDeezerTracks, PropelPDO $con = null)
    {
        $musicDeezerTracksToDelete = $this->getMusicDeezerTracks(new Criteria(), $con)->diff($musicDeezerTracks);


        $this->musicDeezerTracksScheduledForDeletion = $musicDeezerTracksToDelete;

        foreach ($musicDeezerTracksToDelete as $musicDeezerTrackRemoved) {
            $musicDeezerTrackRemoved->setMusicDeezerAlbum(null);
        }

        $this->collMusicDeezerTracks = null;
        foreach ($musicDeezerTracks as $musicDeezerTrack) {
            $this->addMusicDeezerTrack($musicDeezerTrack);
        }

        $this->collMusicDeezerTracks = $musicDeezerTracks;
        $this->collMusicDeezerTracksPartial = false;

        return $this;
    }

    /**
     * Returns the number of related MusicDeezerTrack objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related MusicDeezerTrack objects.
     * @throws PropelException
     */
    public function countMusicDeezerTracks(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collMusicDeezerTracksPartial && !$this->isNew();
        if (null === $this->collMusicDeezerTracks || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMusicDeezerTracks) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMusicDeezerTracks());
            }
            $query = MusicDeezerTrackQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByMusicDeezerAlbum($this)
                ->count($con);
        }

        return count($this->collMusicDeezerTracks);
    }

    /**
     * Method called to associate a MusicDeezerTrack object to this object
     * through the MusicDeezerTrack foreign key attribute.
     *
     * @param    MusicDeezerTrack $l MusicDeezerTrack
     * @return MusicDeezerAlbum The current object (for fluent API support)
     */
    public function addMusicDeezerTrack(MusicDeezerTrack $l)
    {
        if ($this->collMusicDeezerTracks === null) {
            $this->initMusicDeezerTracks();
            $this->collMusicDeezerTracksPartial = true;
        }

        if (!in_array($l, $this->collMusicDeezerTracks->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddMusicDeezerTrack($l);

            if ($this->musicDeezerTracksScheduledForDeletion and $this->musicDeezerTracksScheduledForDeletion->contains($l)) {
                $this->musicDeezerTracksScheduledForDeletion->remove($this->musicDeezerTracksScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param  MusicDeezerTrack $musicDeezerTrack The musicDeezerTrack object to add.
     */
    protected function doAddMusicDeezerTrack($musicDeezerTrack)
    {
        $this->collMusicDeezerTracks[]= $musicDeezerTrack;
        $musicDeezerTrack->setMusicDeezerAlbum($this);
    }

    /**
     * @param  MusicDeezerTrack $musicDeezerTrack The musicDeezerTrack object to remove.
     * @return MusicDeezerAlbum The current object (for fluent API support)
     */
    public function removeMusicDeezerTrack($musicDeezerTrack)
    {
        if ($this->getMusicDeezerTracks()->contains($musicDeezerTrack)) {
            $this->collMusicDeezerTracks->remove($this->collMusicDeezerTracks->search($musicDeezerTrack));
            if (null === $this->musicDeezerTracksScheduledForDeletion) {
                $this->musicDeezerTracksScheduledForDeletion = clone $this->collMusicDeezerTracks;
                $this->musicDeezerTracksScheduledForDeletion->clear();
            }
            $this->musicDeezerTracksScheduledForDeletion[]= $musicDeezerTrack;
            $musicDeezerTrack->setMusicDeezerAlbum(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this MusicDeezerAlbum is new, it will return
     * an empty collection; or if this MusicDeezerAlbum has previously
     * been saved, it will retrieve related MusicDeezerTracks from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in MusicDeezerAlbum.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|MusicDeezerTrack[] List of MusicDeezerTrack objects
     */
    public function getMusicDeezerTracksJoinMusicDeezerArtist($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = MusicDeezerTrackQuery::create(null, $criteria);
        $query->joinWith('MusicDeezerArtist', $join_behavior);

        return $this->getMusicDeezerTracks($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->deezer_id = null;
        $this->album_id = null;
        $this->name = null;
        $this->image = null;
        $this->artist_deezer_id = null;
        $this->main_genre_deezer_id = null;
        $this->genre_deezer_ids = null;
        $this->genre_deezer_ids_unserialized = null;
        $this->record_type = null;
        $this->upc = null;
        $this->label = null;
        $this->nb_tracks = null;
        $this->duration = null;
        $this->nb_fans = null;
        $this->rating = null;
        $this->release_date = null;
        $this->available = null;
        $this->explicit_lyrics = null;
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
            if ($this->collMusicDeezerTracks) {
                foreach ($this->collMusicDeezerTracks as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aMusicAlbum instanceof Persistent) {
              $this->aMusicAlbum->clearAllReferences($deep);
            }
            if ($this->aMusicDeezerArtist instanceof Persistent) {
              $this->aMusicDeezerArtist->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collMusicDeezerTracks instanceof PropelCollection) {
            $this->collMusicDeezerTracks->clearIterator();
        }
        $this->collMusicDeezerTracks = null;
        $this->aMusicAlbum = null;
        $this->aMusicDeezerArtist = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(MusicDeezerAlbumPeer::DEFAULT_STRING_FORMAT);
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
   * @return     MusicDeezerAlbum The current object (for fluent API support)
   */
  public function keepUpdateDateUnchanged()
  {
      $this->modifiedColumns[] = MusicDeezerAlbumPeer::UPDATED_AT;

      return $this;
  }

}
