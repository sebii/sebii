<?php

namespace Sbh\MusicBundle\Model\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use Sbh\MusicBundle\Model\MusicAlbumPeer;
use Sbh\MusicBundle\Model\MusicDeezerAlbum;
use Sbh\MusicBundle\Model\MusicDeezerAlbumPeer;
use Sbh\MusicBundle\Model\MusicDeezerArtistPeer;
use Sbh\MusicBundle\Model\MusicDeezerTrackPeer;
use Sbh\MusicBundle\Model\map\MusicDeezerAlbumTableMap;

abstract class BaseMusicDeezerAlbumPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'default';

    /** the table name for this class */
    const TABLE_NAME = 'music_deezer_album';

    /** the related Propel class for this table */
    const OM_CLASS = 'Sbh\\MusicBundle\\Model\\MusicDeezerAlbum';

    /** the related TableMap class for this table */
    const TM_CLASS = 'Sbh\\MusicBundle\\Model\\map\\MusicDeezerAlbumTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 20;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 20;

    /** the column name for the deezer_id field */
    const DEEZER_ID = 'music_deezer_album.deezer_id';

    /** the column name for the album_id field */
    const ALBUM_ID = 'music_deezer_album.album_id';

    /** the column name for the name field */
    const NAME = 'music_deezer_album.name';

    /** the column name for the image field */
    const IMAGE = 'music_deezer_album.image';

    /** the column name for the artist_deezer_id field */
    const ARTIST_DEEZER_ID = 'music_deezer_album.artist_deezer_id';

    /** the column name for the main_genre_deezer_id field */
    const MAIN_GENRE_DEEZER_ID = 'music_deezer_album.main_genre_deezer_id';

    /** the column name for the genre_deezer_ids field */
    const GENRE_DEEZER_IDS = 'music_deezer_album.genre_deezer_ids';

    /** the column name for the record_type field */
    const RECORD_TYPE = 'music_deezer_album.record_type';

    /** the column name for the upc field */
    const UPC = 'music_deezer_album.upc';

    /** the column name for the label field */
    const LABEL = 'music_deezer_album.label';

    /** the column name for the nb_tracks field */
    const NB_TRACKS = 'music_deezer_album.nb_tracks';

    /** the column name for the duration field */
    const DURATION = 'music_deezer_album.duration';

    /** the column name for the nb_fans field */
    const NB_FANS = 'music_deezer_album.nb_fans';

    /** the column name for the rating field */
    const RATING = 'music_deezer_album.rating';

    /** the column name for the release_date field */
    const RELEASE_DATE = 'music_deezer_album.release_date';

    /** the column name for the available field */
    const AVAILABLE = 'music_deezer_album.available';

    /** the column name for the explicit_lyrics field */
    const EXPLICIT_LYRICS = 'music_deezer_album.explicit_lyrics';

    /** the column name for the id field */
    const ID = 'music_deezer_album.id';

    /** the column name for the created_at field */
    const CREATED_AT = 'music_deezer_album.created_at';

    /** the column name for the updated_at field */
    const UPDATED_AT = 'music_deezer_album.updated_at';

    /** The enumerated values for the record_type field */
    const RECORD_TYPE_ALBUM = 'album';
    const RECORD_TYPE_EP = 'ep';
    const RECORD_TYPE_SINGLE = 'single';
    const RECORD_TYPE_BUNDLE = 'bundle';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of MusicDeezerAlbum objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array MusicDeezerAlbum[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. MusicDeezerAlbumPeer::$fieldNames[MusicDeezerAlbumPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('DeezerId', 'AlbumId', 'Name', 'Image', 'ArtistDeezerId', 'MainGenreDeezerId', 'GenreDeezerIds', 'RecordType', 'Upc', 'Label', 'NbTracks', 'Duration', 'NbFans', 'Rating', 'ReleaseDate', 'Available', 'ExplicitLyrics', 'Id', 'CreatedAt', 'UpdatedAt', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('deezerId', 'albumId', 'name', 'image', 'artistDeezerId', 'mainGenreDeezerId', 'genreDeezerIds', 'recordType', 'upc', 'label', 'nbTracks', 'duration', 'nbFans', 'rating', 'releaseDate', 'available', 'explicitLyrics', 'id', 'createdAt', 'updatedAt', ),
        BasePeer::TYPE_COLNAME => array (MusicDeezerAlbumPeer::DEEZER_ID, MusicDeezerAlbumPeer::ALBUM_ID, MusicDeezerAlbumPeer::NAME, MusicDeezerAlbumPeer::IMAGE, MusicDeezerAlbumPeer::ARTIST_DEEZER_ID, MusicDeezerAlbumPeer::MAIN_GENRE_DEEZER_ID, MusicDeezerAlbumPeer::GENRE_DEEZER_IDS, MusicDeezerAlbumPeer::RECORD_TYPE, MusicDeezerAlbumPeer::UPC, MusicDeezerAlbumPeer::LABEL, MusicDeezerAlbumPeer::NB_TRACKS, MusicDeezerAlbumPeer::DURATION, MusicDeezerAlbumPeer::NB_FANS, MusicDeezerAlbumPeer::RATING, MusicDeezerAlbumPeer::RELEASE_DATE, MusicDeezerAlbumPeer::AVAILABLE, MusicDeezerAlbumPeer::EXPLICIT_LYRICS, MusicDeezerAlbumPeer::ID, MusicDeezerAlbumPeer::CREATED_AT, MusicDeezerAlbumPeer::UPDATED_AT, ),
        BasePeer::TYPE_RAW_COLNAME => array ('DEEZER_ID', 'ALBUM_ID', 'NAME', 'IMAGE', 'ARTIST_DEEZER_ID', 'MAIN_GENRE_DEEZER_ID', 'GENRE_DEEZER_IDS', 'RECORD_TYPE', 'UPC', 'LABEL', 'NB_TRACKS', 'DURATION', 'NB_FANS', 'RATING', 'RELEASE_DATE', 'AVAILABLE', 'EXPLICIT_LYRICS', 'ID', 'CREATED_AT', 'UPDATED_AT', ),
        BasePeer::TYPE_FIELDNAME => array ('deezer_id', 'album_id', 'name', 'image', 'artist_deezer_id', 'main_genre_deezer_id', 'genre_deezer_ids', 'record_type', 'upc', 'label', 'nb_tracks', 'duration', 'nb_fans', 'rating', 'release_date', 'available', 'explicit_lyrics', 'id', 'created_at', 'updated_at', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. MusicDeezerAlbumPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('DeezerId' => 0, 'AlbumId' => 1, 'Name' => 2, 'Image' => 3, 'ArtistDeezerId' => 4, 'MainGenreDeezerId' => 5, 'GenreDeezerIds' => 6, 'RecordType' => 7, 'Upc' => 8, 'Label' => 9, 'NbTracks' => 10, 'Duration' => 11, 'NbFans' => 12, 'Rating' => 13, 'ReleaseDate' => 14, 'Available' => 15, 'ExplicitLyrics' => 16, 'Id' => 17, 'CreatedAt' => 18, 'UpdatedAt' => 19, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('deezerId' => 0, 'albumId' => 1, 'name' => 2, 'image' => 3, 'artistDeezerId' => 4, 'mainGenreDeezerId' => 5, 'genreDeezerIds' => 6, 'recordType' => 7, 'upc' => 8, 'label' => 9, 'nbTracks' => 10, 'duration' => 11, 'nbFans' => 12, 'rating' => 13, 'releaseDate' => 14, 'available' => 15, 'explicitLyrics' => 16, 'id' => 17, 'createdAt' => 18, 'updatedAt' => 19, ),
        BasePeer::TYPE_COLNAME => array (MusicDeezerAlbumPeer::DEEZER_ID => 0, MusicDeezerAlbumPeer::ALBUM_ID => 1, MusicDeezerAlbumPeer::NAME => 2, MusicDeezerAlbumPeer::IMAGE => 3, MusicDeezerAlbumPeer::ARTIST_DEEZER_ID => 4, MusicDeezerAlbumPeer::MAIN_GENRE_DEEZER_ID => 5, MusicDeezerAlbumPeer::GENRE_DEEZER_IDS => 6, MusicDeezerAlbumPeer::RECORD_TYPE => 7, MusicDeezerAlbumPeer::UPC => 8, MusicDeezerAlbumPeer::LABEL => 9, MusicDeezerAlbumPeer::NB_TRACKS => 10, MusicDeezerAlbumPeer::DURATION => 11, MusicDeezerAlbumPeer::NB_FANS => 12, MusicDeezerAlbumPeer::RATING => 13, MusicDeezerAlbumPeer::RELEASE_DATE => 14, MusicDeezerAlbumPeer::AVAILABLE => 15, MusicDeezerAlbumPeer::EXPLICIT_LYRICS => 16, MusicDeezerAlbumPeer::ID => 17, MusicDeezerAlbumPeer::CREATED_AT => 18, MusicDeezerAlbumPeer::UPDATED_AT => 19, ),
        BasePeer::TYPE_RAW_COLNAME => array ('DEEZER_ID' => 0, 'ALBUM_ID' => 1, 'NAME' => 2, 'IMAGE' => 3, 'ARTIST_DEEZER_ID' => 4, 'MAIN_GENRE_DEEZER_ID' => 5, 'GENRE_DEEZER_IDS' => 6, 'RECORD_TYPE' => 7, 'UPC' => 8, 'LABEL' => 9, 'NB_TRACKS' => 10, 'DURATION' => 11, 'NB_FANS' => 12, 'RATING' => 13, 'RELEASE_DATE' => 14, 'AVAILABLE' => 15, 'EXPLICIT_LYRICS' => 16, 'ID' => 17, 'CREATED_AT' => 18, 'UPDATED_AT' => 19, ),
        BasePeer::TYPE_FIELDNAME => array ('deezer_id' => 0, 'album_id' => 1, 'name' => 2, 'image' => 3, 'artist_deezer_id' => 4, 'main_genre_deezer_id' => 5, 'genre_deezer_ids' => 6, 'record_type' => 7, 'upc' => 8, 'label' => 9, 'nb_tracks' => 10, 'duration' => 11, 'nb_fans' => 12, 'rating' => 13, 'release_date' => 14, 'available' => 15, 'explicit_lyrics' => 16, 'id' => 17, 'created_at' => 18, 'updated_at' => 19, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, )
    );

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
        MusicDeezerAlbumPeer::RECORD_TYPE => array(
      MusicDeezerAlbumPeer::RECORD_TYPE_ALBUM,
      MusicDeezerAlbumPeer::RECORD_TYPE_EP,
      MusicDeezerAlbumPeer::RECORD_TYPE_SINGLE,
      MusicDeezerAlbumPeer::RECORD_TYPE_BUNDLE,
    ),
    );

    /**
     * Translates a fieldname to another type
     *
     * @param      string $name field name
     * @param      string $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                         BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @param      string $toType   One of the class type constants
     * @return string          translated name of the field.
     * @throws PropelException - if the specified name could not be found in the fieldname mappings.
     */
    public static function translateFieldName($name, $fromType, $toType)
    {
        $toNames = MusicDeezerAlbumPeer::getFieldNames($toType);
        $key = isset(MusicDeezerAlbumPeer::$fieldKeys[$fromType][$name]) ? MusicDeezerAlbumPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(MusicDeezerAlbumPeer::$fieldKeys[$fromType], true));
        }

        return $toNames[$key];
    }

    /**
     * Returns an array of field names.
     *
     * @param      string $type The type of fieldnames to return:
     *                      One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @return array           A list of field names
     * @throws PropelException - if the type is not valid.
     */
    public static function getFieldNames($type = BasePeer::TYPE_PHPNAME)
    {
        if (!array_key_exists($type, MusicDeezerAlbumPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return MusicDeezerAlbumPeer::$fieldNames[$type];
    }

    /**
     * Gets the list of values for all ENUM columns
     * @return array
     */
    public static function getValueSets()
    {
      return MusicDeezerAlbumPeer::$enumValueSets;
    }

    /**
     * Gets the list of values for an ENUM column
     *
     * @param string $colname The ENUM column name.
     *
     * @return array list of possible values for the column
     */
    public static function getValueSet($colname)
    {
        $valueSets = MusicDeezerAlbumPeer::getValueSets();

        if (!isset($valueSets[$colname])) {
            throw new PropelException(sprintf('Column "%s" has no ValueSet.', $colname));
        }

        return $valueSets[$colname];
    }

    /**
     * Gets the SQL value for the ENUM column value
     *
     * @param string $colname ENUM column name.
     * @param string $enumVal ENUM value.
     *
     * @return int SQL value
     */
    public static function getSqlValueForEnum($colname, $enumVal)
    {
        $values = MusicDeezerAlbumPeer::getValueSet($colname);
        if (!in_array($enumVal, $values)) {
            throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $colname));
        }

        return array_search($enumVal, $values);
    }

    /**
     * Convenience method which changes table.column to alias.column.
     *
     * Using this method you can maintain SQL abstraction while using column aliases.
     * <code>
     *    $c->addAlias("alias1", TablePeer::TABLE_NAME);
     *    $c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
     * </code>
     * @param      string $alias The alias for the current table.
     * @param      string $column The column name for current table. (i.e. MusicDeezerAlbumPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(MusicDeezerAlbumPeer::TABLE_NAME.'.', $alias.'.', $column);
    }

    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param      Criteria $criteria object containing the columns to add.
     * @param      string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(MusicDeezerAlbumPeer::DEEZER_ID);
            $criteria->addSelectColumn(MusicDeezerAlbumPeer::ALBUM_ID);
            $criteria->addSelectColumn(MusicDeezerAlbumPeer::NAME);
            $criteria->addSelectColumn(MusicDeezerAlbumPeer::IMAGE);
            $criteria->addSelectColumn(MusicDeezerAlbumPeer::ARTIST_DEEZER_ID);
            $criteria->addSelectColumn(MusicDeezerAlbumPeer::MAIN_GENRE_DEEZER_ID);
            $criteria->addSelectColumn(MusicDeezerAlbumPeer::GENRE_DEEZER_IDS);
            $criteria->addSelectColumn(MusicDeezerAlbumPeer::RECORD_TYPE);
            $criteria->addSelectColumn(MusicDeezerAlbumPeer::UPC);
            $criteria->addSelectColumn(MusicDeezerAlbumPeer::LABEL);
            $criteria->addSelectColumn(MusicDeezerAlbumPeer::NB_TRACKS);
            $criteria->addSelectColumn(MusicDeezerAlbumPeer::DURATION);
            $criteria->addSelectColumn(MusicDeezerAlbumPeer::NB_FANS);
            $criteria->addSelectColumn(MusicDeezerAlbumPeer::RATING);
            $criteria->addSelectColumn(MusicDeezerAlbumPeer::RELEASE_DATE);
            $criteria->addSelectColumn(MusicDeezerAlbumPeer::AVAILABLE);
            $criteria->addSelectColumn(MusicDeezerAlbumPeer::EXPLICIT_LYRICS);
            $criteria->addSelectColumn(MusicDeezerAlbumPeer::ID);
            $criteria->addSelectColumn(MusicDeezerAlbumPeer::CREATED_AT);
            $criteria->addSelectColumn(MusicDeezerAlbumPeer::UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.deezer_id');
            $criteria->addSelectColumn($alias . '.album_id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.image');
            $criteria->addSelectColumn($alias . '.artist_deezer_id');
            $criteria->addSelectColumn($alias . '.main_genre_deezer_id');
            $criteria->addSelectColumn($alias . '.genre_deezer_ids');
            $criteria->addSelectColumn($alias . '.record_type');
            $criteria->addSelectColumn($alias . '.upc');
            $criteria->addSelectColumn($alias . '.label');
            $criteria->addSelectColumn($alias . '.nb_tracks');
            $criteria->addSelectColumn($alias . '.duration');
            $criteria->addSelectColumn($alias . '.nb_fans');
            $criteria->addSelectColumn($alias . '.rating');
            $criteria->addSelectColumn($alias . '.release_date');
            $criteria->addSelectColumn($alias . '.available');
            $criteria->addSelectColumn($alias . '.explicit_lyrics');
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
        }
    }

    /**
     * Returns the number of rows matching criteria.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @return int Number of matching rows.
     */
    public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
    {
        // we may modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(MusicDeezerAlbumPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            MusicDeezerAlbumPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(MusicDeezerAlbumPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerAlbumPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        // BasePeer returns a PDOStatement
        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }
    /**
     * Selects one object from the DB.
     *
     * @param      Criteria $criteria object used to create the SELECT statement.
     * @param      PropelPDO $con
     * @return MusicDeezerAlbum
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = MusicDeezerAlbumPeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }
    /**
     * Selects several row from the DB.
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con
     * @return array           Array of selected Objects
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return MusicDeezerAlbumPeer::populateObjects(MusicDeezerAlbumPeer::doSelectStmt($criteria, $con));
    }
    /**
     * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
     *
     * Use this method directly if you want to work with an executed statement directly (for example
     * to perform your own object hydration).
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con The connection to use
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     * @return PDOStatement The executed PDOStatement object.
     * @see        BasePeer::doSelect()
     */
    public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerAlbumPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            MusicDeezerAlbumPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(MusicDeezerAlbumPeer::DATABASE_NAME);

        // BasePeer returns a PDOStatement
        return BasePeer::doSelect($criteria, $con);
    }
    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doSelect*()
     * methods in your stub classes -- you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by doSelect*()
     * and retrieveByPK*() calls.
     *
     * @param MusicDeezerAlbum $obj A MusicDeezerAlbum object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getId();
            } // if key === null
            MusicDeezerAlbumPeer::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param      mixed $value A MusicDeezerAlbum object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof MusicDeezerAlbum) {
                $key = (string) $value->getId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or MusicDeezerAlbum object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(MusicDeezerAlbumPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return MusicDeezerAlbum Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(MusicDeezerAlbumPeer::$instances[$key])) {
                return MusicDeezerAlbumPeer::$instances[$key];
            }
        }

        return null; // just to be explicit
    }

    /**
     * Clear the instance pool.
     *
     * @return void
     */
    public static function clearInstancePool($and_clear_all_references = false)
    {
      if ($and_clear_all_references) {
        foreach (MusicDeezerAlbumPeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        MusicDeezerAlbumPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to music_deezer_album
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in MusicDeezerTrackPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        MusicDeezerTrackPeer::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return string A string version of PK or null if the components of primary key in result array are all null.
     */
    public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
    {
        // If the PK cannot be derived from the row, return null.
        if ($row[$startcol + 17] === null) {
            return null;
        }

        return (string) $row[$startcol + 17];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $startcol = 0)
    {

        return (int) $row[$startcol + 17];
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function populateObjects(PDOStatement $stmt)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = MusicDeezerAlbumPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = MusicDeezerAlbumPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = MusicDeezerAlbumPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                MusicDeezerAlbumPeer::addInstanceToPool($obj, $key);
            } // if key exists
        }
        $stmt->closeCursor();

        return $results;
    }
    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     * @return array (MusicDeezerAlbum object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = MusicDeezerAlbumPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = MusicDeezerAlbumPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + MusicDeezerAlbumPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = MusicDeezerAlbumPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            MusicDeezerAlbumPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * Gets the SQL value for RecordType ENUM value
     *
     * @param  string $enumVal ENUM value to get SQL value for
     * @return int SQL value
     */
    public static function getRecordTypeSqlValue($enumVal)
    {
        return MusicDeezerAlbumPeer::getSqlValueForEnum(MusicDeezerAlbumPeer::RECORD_TYPE, $enumVal);
    }


    /**
     * Returns the number of rows matching criteria, joining the related MusicAlbum table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinMusicAlbum(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(MusicDeezerAlbumPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            MusicDeezerAlbumPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(MusicDeezerAlbumPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerAlbumPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(MusicDeezerAlbumPeer::ALBUM_ID, MusicAlbumPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related MusicDeezerArtist table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinMusicDeezerArtist(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(MusicDeezerAlbumPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            MusicDeezerAlbumPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(MusicDeezerAlbumPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerAlbumPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(MusicDeezerAlbumPeer::ARTIST_DEEZER_ID, MusicDeezerArtistPeer::DEEZER_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Selects a collection of MusicDeezerAlbum objects pre-filled with their MusicAlbum objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of MusicDeezerAlbum objects.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinMusicAlbum(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(MusicDeezerAlbumPeer::DATABASE_NAME);
        }

        MusicDeezerAlbumPeer::addSelectColumns($criteria);
        $startcol = MusicDeezerAlbumPeer::NUM_HYDRATE_COLUMNS;
        MusicAlbumPeer::addSelectColumns($criteria);

        $criteria->addJoin(MusicDeezerAlbumPeer::ALBUM_ID, MusicAlbumPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = MusicDeezerAlbumPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = MusicDeezerAlbumPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = MusicDeezerAlbumPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                MusicDeezerAlbumPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = MusicAlbumPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = MusicAlbumPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = MusicAlbumPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    MusicAlbumPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (MusicDeezerAlbum) to $obj2 (MusicAlbum)
                $obj2->addMusicDeezerAlbum($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of MusicDeezerAlbum objects pre-filled with their MusicDeezerArtist objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of MusicDeezerAlbum objects.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinMusicDeezerArtist(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(MusicDeezerAlbumPeer::DATABASE_NAME);
        }

        MusicDeezerAlbumPeer::addSelectColumns($criteria);
        $startcol = MusicDeezerAlbumPeer::NUM_HYDRATE_COLUMNS;
        MusicDeezerArtistPeer::addSelectColumns($criteria);

        $criteria->addJoin(MusicDeezerAlbumPeer::ARTIST_DEEZER_ID, MusicDeezerArtistPeer::DEEZER_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = MusicDeezerAlbumPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = MusicDeezerAlbumPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = MusicDeezerAlbumPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                MusicDeezerAlbumPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = MusicDeezerArtistPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = MusicDeezerArtistPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = MusicDeezerArtistPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    MusicDeezerArtistPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (MusicDeezerAlbum) to $obj2 (MusicDeezerArtist)
                $obj2->addMusicDeezerAlbum($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining all related tables
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(MusicDeezerAlbumPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            MusicDeezerAlbumPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(MusicDeezerAlbumPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerAlbumPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(MusicDeezerAlbumPeer::ALBUM_ID, MusicAlbumPeer::ID, $join_behavior);

        $criteria->addJoin(MusicDeezerAlbumPeer::ARTIST_DEEZER_ID, MusicDeezerArtistPeer::DEEZER_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }

    /**
     * Selects a collection of MusicDeezerAlbum objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of MusicDeezerAlbum objects.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(MusicDeezerAlbumPeer::DATABASE_NAME);
        }

        MusicDeezerAlbumPeer::addSelectColumns($criteria);
        $startcol2 = MusicDeezerAlbumPeer::NUM_HYDRATE_COLUMNS;

        MusicAlbumPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + MusicAlbumPeer::NUM_HYDRATE_COLUMNS;

        MusicDeezerArtistPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + MusicDeezerArtistPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(MusicDeezerAlbumPeer::ALBUM_ID, MusicAlbumPeer::ID, $join_behavior);

        $criteria->addJoin(MusicDeezerAlbumPeer::ARTIST_DEEZER_ID, MusicDeezerArtistPeer::DEEZER_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = MusicDeezerAlbumPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = MusicDeezerAlbumPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = MusicDeezerAlbumPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                MusicDeezerAlbumPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined MusicAlbum rows

            $key2 = MusicAlbumPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = MusicAlbumPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = MusicAlbumPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    MusicAlbumPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (MusicDeezerAlbum) to the collection in $obj2 (MusicAlbum)
                $obj2->addMusicDeezerAlbum($obj1);
            } // if joined row not null

            // Add objects for joined MusicDeezerArtist rows

            $key3 = MusicDeezerArtistPeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = MusicDeezerArtistPeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = MusicDeezerArtistPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    MusicDeezerArtistPeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (MusicDeezerAlbum) to the collection in $obj3 (MusicDeezerArtist)
                $obj3->addMusicDeezerAlbum($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining the related MusicAlbum table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptMusicAlbum(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(MusicDeezerAlbumPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            MusicDeezerAlbumPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(MusicDeezerAlbumPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerAlbumPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(MusicDeezerAlbumPeer::ARTIST_DEEZER_ID, MusicDeezerArtistPeer::DEEZER_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related MusicDeezerArtist table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptMusicDeezerArtist(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(MusicDeezerAlbumPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            MusicDeezerAlbumPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(MusicDeezerAlbumPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerAlbumPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(MusicDeezerAlbumPeer::ALBUM_ID, MusicAlbumPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Selects a collection of MusicDeezerAlbum objects pre-filled with all related objects except MusicAlbum.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of MusicDeezerAlbum objects.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptMusicAlbum(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(MusicDeezerAlbumPeer::DATABASE_NAME);
        }

        MusicDeezerAlbumPeer::addSelectColumns($criteria);
        $startcol2 = MusicDeezerAlbumPeer::NUM_HYDRATE_COLUMNS;

        MusicDeezerArtistPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + MusicDeezerArtistPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(MusicDeezerAlbumPeer::ARTIST_DEEZER_ID, MusicDeezerArtistPeer::DEEZER_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = MusicDeezerAlbumPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = MusicDeezerAlbumPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = MusicDeezerAlbumPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                MusicDeezerAlbumPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined MusicDeezerArtist rows

                $key2 = MusicDeezerArtistPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = MusicDeezerArtistPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = MusicDeezerArtistPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    MusicDeezerArtistPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (MusicDeezerAlbum) to the collection in $obj2 (MusicDeezerArtist)
                $obj2->addMusicDeezerAlbum($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of MusicDeezerAlbum objects pre-filled with all related objects except MusicDeezerArtist.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of MusicDeezerAlbum objects.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptMusicDeezerArtist(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(MusicDeezerAlbumPeer::DATABASE_NAME);
        }

        MusicDeezerAlbumPeer::addSelectColumns($criteria);
        $startcol2 = MusicDeezerAlbumPeer::NUM_HYDRATE_COLUMNS;

        MusicAlbumPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + MusicAlbumPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(MusicDeezerAlbumPeer::ALBUM_ID, MusicAlbumPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = MusicDeezerAlbumPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = MusicDeezerAlbumPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = MusicDeezerAlbumPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                MusicDeezerAlbumPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined MusicAlbum rows

                $key2 = MusicAlbumPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = MusicAlbumPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = MusicAlbumPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    MusicAlbumPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (MusicDeezerAlbum) to the collection in $obj2 (MusicAlbum)
                $obj2->addMusicDeezerAlbum($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }

    /**
     * Returns the TableMap related to this peer.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getDatabaseMap(MusicDeezerAlbumPeer::DATABASE_NAME)->getTable(MusicDeezerAlbumPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseMusicDeezerAlbumPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseMusicDeezerAlbumPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \Sbh\MusicBundle\Model\map\MusicDeezerAlbumTableMap());
      }
    }

    /**
     * The class that the Peer will make instances of.
     *
     *
     * @return string ClassName
     */
    public static function getOMClass($row = 0, $colnum = 0)
    {
        return MusicDeezerAlbumPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a MusicDeezerAlbum or Criteria object.
     *
     * @param      mixed $values Criteria or MusicDeezerAlbum object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerAlbumPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from MusicDeezerAlbum object
        }

        if ($criteria->containsKey(MusicDeezerAlbumPeer::ID) && $criteria->keyContainsValue(MusicDeezerAlbumPeer::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.MusicDeezerAlbumPeer::ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(MusicDeezerAlbumPeer::DATABASE_NAME);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = BasePeer::doInsert($criteria, $con);
            $con->commit();
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

    /**
     * Performs an UPDATE on the database, given a MusicDeezerAlbum or Criteria object.
     *
     * @param      mixed $values Criteria or MusicDeezerAlbum object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerAlbumPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(MusicDeezerAlbumPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(MusicDeezerAlbumPeer::ID);
            $value = $criteria->remove(MusicDeezerAlbumPeer::ID);
            if ($value) {
                $selectCriteria->add(MusicDeezerAlbumPeer::ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(MusicDeezerAlbumPeer::TABLE_NAME);
            }

        } else { // $values is MusicDeezerAlbum object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(MusicDeezerAlbumPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the music_deezer_album table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerAlbumPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(MusicDeezerAlbumPeer::TABLE_NAME, $con, MusicDeezerAlbumPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MusicDeezerAlbumPeer::clearInstancePool();
            MusicDeezerAlbumPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a MusicDeezerAlbum or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or MusicDeezerAlbum object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param      PropelPDO $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *        if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, PropelPDO $con = null)
     {
        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerAlbumPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            MusicDeezerAlbumPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof MusicDeezerAlbum) { // it's a model object
            // invalidate the cache for this single object
            MusicDeezerAlbumPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(MusicDeezerAlbumPeer::DATABASE_NAME);
            $criteria->add(MusicDeezerAlbumPeer::ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                MusicDeezerAlbumPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(MusicDeezerAlbumPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            MusicDeezerAlbumPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given MusicDeezerAlbum object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param MusicDeezerAlbum $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(MusicDeezerAlbumPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(MusicDeezerAlbumPeer::TABLE_NAME);

            if (! is_array($cols)) {
                $cols = array($cols);
            }

            foreach ($cols as $colName) {
                if ($tableMap->hasColumn($colName)) {
                    $get = 'get' . $tableMap->getColumn($colName)->getPhpName();
                    $columns[$colName] = $obj->$get();
                }
            }
        } else {

        }

        return BasePeer::doValidate(MusicDeezerAlbumPeer::DATABASE_NAME, MusicDeezerAlbumPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return MusicDeezerAlbum
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = MusicDeezerAlbumPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerAlbumPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(MusicDeezerAlbumPeer::DATABASE_NAME);
        $criteria->add(MusicDeezerAlbumPeer::ID, $pk);

        $v = MusicDeezerAlbumPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return MusicDeezerAlbum[]
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerAlbumPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(MusicDeezerAlbumPeer::DATABASE_NAME);
            $criteria->add(MusicDeezerAlbumPeer::ID, $pks, Criteria::IN);
            $objs = MusicDeezerAlbumPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

}

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseMusicDeezerAlbumPeer::buildTableMap();

