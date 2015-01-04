<?php

namespace Sbh\MusicBundle\Model\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use Sbh\MusicBundle\Model\MusicDeezerAlbumGenre;
use Sbh\MusicBundle\Model\MusicDeezerAlbumGenrePeer;
use Sbh\MusicBundle\Model\MusicDeezerAlbumPeer;
use Sbh\MusicBundle\Model\MusicDeezerGenrePeer;
use Sbh\MusicBundle\Model\map\MusicDeezerAlbumGenreTableMap;

abstract class BaseMusicDeezerAlbumGenrePeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'default';

    /** the table name for this class */
    const TABLE_NAME = 'music_deezer_album_genre';

    /** the related Propel class for this table */
    const OM_CLASS = 'Sbh\\MusicBundle\\Model\\MusicDeezerAlbumGenre';

    /** the related TableMap class for this table */
    const TM_CLASS = 'Sbh\\MusicBundle\\Model\\map\\MusicDeezerAlbumGenreTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 5;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 5;

    /** the column name for the album_deezer_id field */
    const ALBUM_DEEZER_ID = 'music_deezer_album_genre.album_deezer_id';

    /** the column name for the genre_deezer_id field */
    const GENRE_DEEZER_ID = 'music_deezer_album_genre.genre_deezer_id';

    /** the column name for the id field */
    const ID = 'music_deezer_album_genre.id';

    /** the column name for the created_at field */
    const CREATED_AT = 'music_deezer_album_genre.created_at';

    /** the column name for the updated_at field */
    const UPDATED_AT = 'music_deezer_album_genre.updated_at';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of MusicDeezerAlbumGenre objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array MusicDeezerAlbumGenre[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. MusicDeezerAlbumGenrePeer::$fieldNames[MusicDeezerAlbumGenrePeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('AlbumDeezerId', 'GenreDeezerId', 'Id', 'CreatedAt', 'UpdatedAt', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('albumDeezerId', 'genreDeezerId', 'id', 'createdAt', 'updatedAt', ),
        BasePeer::TYPE_COLNAME => array (MusicDeezerAlbumGenrePeer::ALBUM_DEEZER_ID, MusicDeezerAlbumGenrePeer::GENRE_DEEZER_ID, MusicDeezerAlbumGenrePeer::ID, MusicDeezerAlbumGenrePeer::CREATED_AT, MusicDeezerAlbumGenrePeer::UPDATED_AT, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ALBUM_DEEZER_ID', 'GENRE_DEEZER_ID', 'ID', 'CREATED_AT', 'UPDATED_AT', ),
        BasePeer::TYPE_FIELDNAME => array ('album_deezer_id', 'genre_deezer_id', 'id', 'created_at', 'updated_at', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. MusicDeezerAlbumGenrePeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('AlbumDeezerId' => 0, 'GenreDeezerId' => 1, 'Id' => 2, 'CreatedAt' => 3, 'UpdatedAt' => 4, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('albumDeezerId' => 0, 'genreDeezerId' => 1, 'id' => 2, 'createdAt' => 3, 'updatedAt' => 4, ),
        BasePeer::TYPE_COLNAME => array (MusicDeezerAlbumGenrePeer::ALBUM_DEEZER_ID => 0, MusicDeezerAlbumGenrePeer::GENRE_DEEZER_ID => 1, MusicDeezerAlbumGenrePeer::ID => 2, MusicDeezerAlbumGenrePeer::CREATED_AT => 3, MusicDeezerAlbumGenrePeer::UPDATED_AT => 4, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ALBUM_DEEZER_ID' => 0, 'GENRE_DEEZER_ID' => 1, 'ID' => 2, 'CREATED_AT' => 3, 'UPDATED_AT' => 4, ),
        BasePeer::TYPE_FIELDNAME => array ('album_deezer_id' => 0, 'genre_deezer_id' => 1, 'id' => 2, 'created_at' => 3, 'updated_at' => 4, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
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
        $toNames = MusicDeezerAlbumGenrePeer::getFieldNames($toType);
        $key = isset(MusicDeezerAlbumGenrePeer::$fieldKeys[$fromType][$name]) ? MusicDeezerAlbumGenrePeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(MusicDeezerAlbumGenrePeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, MusicDeezerAlbumGenrePeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return MusicDeezerAlbumGenrePeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. MusicDeezerAlbumGenrePeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(MusicDeezerAlbumGenrePeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(MusicDeezerAlbumGenrePeer::ALBUM_DEEZER_ID);
            $criteria->addSelectColumn(MusicDeezerAlbumGenrePeer::GENRE_DEEZER_ID);
            $criteria->addSelectColumn(MusicDeezerAlbumGenrePeer::ID);
            $criteria->addSelectColumn(MusicDeezerAlbumGenrePeer::CREATED_AT);
            $criteria->addSelectColumn(MusicDeezerAlbumGenrePeer::UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.album_deezer_id');
            $criteria->addSelectColumn($alias . '.genre_deezer_id');
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
        $criteria->setPrimaryTableName(MusicDeezerAlbumGenrePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            MusicDeezerAlbumGenrePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(MusicDeezerAlbumGenrePeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerAlbumGenrePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return MusicDeezerAlbumGenre
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = MusicDeezerAlbumGenrePeer::doSelect($critcopy, $con);
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
        return MusicDeezerAlbumGenrePeer::populateObjects(MusicDeezerAlbumGenrePeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(MusicDeezerAlbumGenrePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            MusicDeezerAlbumGenrePeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(MusicDeezerAlbumGenrePeer::DATABASE_NAME);

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
     * @param MusicDeezerAlbumGenre $obj A MusicDeezerAlbumGenre object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getId();
            } // if key === null
            MusicDeezerAlbumGenrePeer::$instances[$key] = $obj;
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
     * @param      mixed $value A MusicDeezerAlbumGenre object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof MusicDeezerAlbumGenre) {
                $key = (string) $value->getId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or MusicDeezerAlbumGenre object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(MusicDeezerAlbumGenrePeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return MusicDeezerAlbumGenre Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(MusicDeezerAlbumGenrePeer::$instances[$key])) {
                return MusicDeezerAlbumGenrePeer::$instances[$key];
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
        foreach (MusicDeezerAlbumGenrePeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        MusicDeezerAlbumGenrePeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to music_deezer_album_genre
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
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
        if ($row[$startcol + 2] === null) {
            return null;
        }

        return (string) $row[$startcol + 2];
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

        return (int) $row[$startcol + 2];
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
        $cls = MusicDeezerAlbumGenrePeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = MusicDeezerAlbumGenrePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = MusicDeezerAlbumGenrePeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                MusicDeezerAlbumGenrePeer::addInstanceToPool($obj, $key);
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
     * @return array (MusicDeezerAlbumGenre object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = MusicDeezerAlbumGenrePeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = MusicDeezerAlbumGenrePeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + MusicDeezerAlbumGenrePeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = MusicDeezerAlbumGenrePeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            MusicDeezerAlbumGenrePeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }


    /**
     * Returns the number of rows matching criteria, joining the related MusicDeezerAlbum table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinMusicDeezerAlbum(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(MusicDeezerAlbumGenrePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            MusicDeezerAlbumGenrePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(MusicDeezerAlbumGenrePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerAlbumGenrePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(MusicDeezerAlbumGenrePeer::ALBUM_DEEZER_ID, MusicDeezerAlbumPeer::DEEZER_ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related MusicDeezerGenre table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinMusicDeezerGenre(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(MusicDeezerAlbumGenrePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            MusicDeezerAlbumGenrePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(MusicDeezerAlbumGenrePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerAlbumGenrePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(MusicDeezerAlbumGenrePeer::GENRE_DEEZER_ID, MusicDeezerGenrePeer::DEEZER_ID, $join_behavior);

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
     * Selects a collection of MusicDeezerAlbumGenre objects pre-filled with their MusicDeezerAlbum objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of MusicDeezerAlbumGenre objects.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinMusicDeezerAlbum(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(MusicDeezerAlbumGenrePeer::DATABASE_NAME);
        }

        MusicDeezerAlbumGenrePeer::addSelectColumns($criteria);
        $startcol = MusicDeezerAlbumGenrePeer::NUM_HYDRATE_COLUMNS;
        MusicDeezerAlbumPeer::addSelectColumns($criteria);

        $criteria->addJoin(MusicDeezerAlbumGenrePeer::ALBUM_DEEZER_ID, MusicDeezerAlbumPeer::DEEZER_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = MusicDeezerAlbumGenrePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = MusicDeezerAlbumGenrePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = MusicDeezerAlbumGenrePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                MusicDeezerAlbumGenrePeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = MusicDeezerAlbumPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = MusicDeezerAlbumPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = MusicDeezerAlbumPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    MusicDeezerAlbumPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (MusicDeezerAlbumGenre) to $obj2 (MusicDeezerAlbum)
                $obj2->addMusicDeezerAlbumGenre($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of MusicDeezerAlbumGenre objects pre-filled with their MusicDeezerGenre objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of MusicDeezerAlbumGenre objects.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinMusicDeezerGenre(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(MusicDeezerAlbumGenrePeer::DATABASE_NAME);
        }

        MusicDeezerAlbumGenrePeer::addSelectColumns($criteria);
        $startcol = MusicDeezerAlbumGenrePeer::NUM_HYDRATE_COLUMNS;
        MusicDeezerGenrePeer::addSelectColumns($criteria);

        $criteria->addJoin(MusicDeezerAlbumGenrePeer::GENRE_DEEZER_ID, MusicDeezerGenrePeer::DEEZER_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = MusicDeezerAlbumGenrePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = MusicDeezerAlbumGenrePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = MusicDeezerAlbumGenrePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                MusicDeezerAlbumGenrePeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = MusicDeezerGenrePeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = MusicDeezerGenrePeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = MusicDeezerGenrePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    MusicDeezerGenrePeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (MusicDeezerAlbumGenre) to $obj2 (MusicDeezerGenre)
                $obj2->addMusicDeezerAlbumGenre($obj1);

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
        $criteria->setPrimaryTableName(MusicDeezerAlbumGenrePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            MusicDeezerAlbumGenrePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(MusicDeezerAlbumGenrePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerAlbumGenrePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(MusicDeezerAlbumGenrePeer::ALBUM_DEEZER_ID, MusicDeezerAlbumPeer::DEEZER_ID, $join_behavior);

        $criteria->addJoin(MusicDeezerAlbumGenrePeer::GENRE_DEEZER_ID, MusicDeezerGenrePeer::DEEZER_ID, $join_behavior);

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
     * Selects a collection of MusicDeezerAlbumGenre objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of MusicDeezerAlbumGenre objects.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(MusicDeezerAlbumGenrePeer::DATABASE_NAME);
        }

        MusicDeezerAlbumGenrePeer::addSelectColumns($criteria);
        $startcol2 = MusicDeezerAlbumGenrePeer::NUM_HYDRATE_COLUMNS;

        MusicDeezerAlbumPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + MusicDeezerAlbumPeer::NUM_HYDRATE_COLUMNS;

        MusicDeezerGenrePeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + MusicDeezerGenrePeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(MusicDeezerAlbumGenrePeer::ALBUM_DEEZER_ID, MusicDeezerAlbumPeer::DEEZER_ID, $join_behavior);

        $criteria->addJoin(MusicDeezerAlbumGenrePeer::GENRE_DEEZER_ID, MusicDeezerGenrePeer::DEEZER_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = MusicDeezerAlbumGenrePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = MusicDeezerAlbumGenrePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = MusicDeezerAlbumGenrePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                MusicDeezerAlbumGenrePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined MusicDeezerAlbum rows

            $key2 = MusicDeezerAlbumPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = MusicDeezerAlbumPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = MusicDeezerAlbumPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    MusicDeezerAlbumPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (MusicDeezerAlbumGenre) to the collection in $obj2 (MusicDeezerAlbum)
                $obj2->addMusicDeezerAlbumGenre($obj1);
            } // if joined row not null

            // Add objects for joined MusicDeezerGenre rows

            $key3 = MusicDeezerGenrePeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = MusicDeezerGenrePeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = MusicDeezerGenrePeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    MusicDeezerGenrePeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (MusicDeezerAlbumGenre) to the collection in $obj3 (MusicDeezerGenre)
                $obj3->addMusicDeezerAlbumGenre($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining the related MusicDeezerAlbum table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptMusicDeezerAlbum(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(MusicDeezerAlbumGenrePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            MusicDeezerAlbumGenrePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(MusicDeezerAlbumGenrePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerAlbumGenrePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(MusicDeezerAlbumGenrePeer::GENRE_DEEZER_ID, MusicDeezerGenrePeer::DEEZER_ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related MusicDeezerGenre table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptMusicDeezerGenre(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(MusicDeezerAlbumGenrePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            MusicDeezerAlbumGenrePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(MusicDeezerAlbumGenrePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerAlbumGenrePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(MusicDeezerAlbumGenrePeer::ALBUM_DEEZER_ID, MusicDeezerAlbumPeer::DEEZER_ID, $join_behavior);

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
     * Selects a collection of MusicDeezerAlbumGenre objects pre-filled with all related objects except MusicDeezerAlbum.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of MusicDeezerAlbumGenre objects.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptMusicDeezerAlbum(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(MusicDeezerAlbumGenrePeer::DATABASE_NAME);
        }

        MusicDeezerAlbumGenrePeer::addSelectColumns($criteria);
        $startcol2 = MusicDeezerAlbumGenrePeer::NUM_HYDRATE_COLUMNS;

        MusicDeezerGenrePeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + MusicDeezerGenrePeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(MusicDeezerAlbumGenrePeer::GENRE_DEEZER_ID, MusicDeezerGenrePeer::DEEZER_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = MusicDeezerAlbumGenrePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = MusicDeezerAlbumGenrePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = MusicDeezerAlbumGenrePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                MusicDeezerAlbumGenrePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined MusicDeezerGenre rows

                $key2 = MusicDeezerGenrePeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = MusicDeezerGenrePeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = MusicDeezerGenrePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    MusicDeezerGenrePeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (MusicDeezerAlbumGenre) to the collection in $obj2 (MusicDeezerGenre)
                $obj2->addMusicDeezerAlbumGenre($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of MusicDeezerAlbumGenre objects pre-filled with all related objects except MusicDeezerGenre.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of MusicDeezerAlbumGenre objects.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptMusicDeezerGenre(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(MusicDeezerAlbumGenrePeer::DATABASE_NAME);
        }

        MusicDeezerAlbumGenrePeer::addSelectColumns($criteria);
        $startcol2 = MusicDeezerAlbumGenrePeer::NUM_HYDRATE_COLUMNS;

        MusicDeezerAlbumPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + MusicDeezerAlbumPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(MusicDeezerAlbumGenrePeer::ALBUM_DEEZER_ID, MusicDeezerAlbumPeer::DEEZER_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = MusicDeezerAlbumGenrePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = MusicDeezerAlbumGenrePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = MusicDeezerAlbumGenrePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                MusicDeezerAlbumGenrePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined MusicDeezerAlbum rows

                $key2 = MusicDeezerAlbumPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = MusicDeezerAlbumPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = MusicDeezerAlbumPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    MusicDeezerAlbumPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (MusicDeezerAlbumGenre) to the collection in $obj2 (MusicDeezerAlbum)
                $obj2->addMusicDeezerAlbumGenre($obj1);

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
        return Propel::getDatabaseMap(MusicDeezerAlbumGenrePeer::DATABASE_NAME)->getTable(MusicDeezerAlbumGenrePeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseMusicDeezerAlbumGenrePeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseMusicDeezerAlbumGenrePeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \Sbh\MusicBundle\Model\map\MusicDeezerAlbumGenreTableMap());
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
        return MusicDeezerAlbumGenrePeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a MusicDeezerAlbumGenre or Criteria object.
     *
     * @param      mixed $values Criteria or MusicDeezerAlbumGenre object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerAlbumGenrePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from MusicDeezerAlbumGenre object
        }

        if ($criteria->containsKey(MusicDeezerAlbumGenrePeer::ID) && $criteria->keyContainsValue(MusicDeezerAlbumGenrePeer::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.MusicDeezerAlbumGenrePeer::ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(MusicDeezerAlbumGenrePeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a MusicDeezerAlbumGenre or Criteria object.
     *
     * @param      mixed $values Criteria or MusicDeezerAlbumGenre object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerAlbumGenrePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(MusicDeezerAlbumGenrePeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(MusicDeezerAlbumGenrePeer::ID);
            $value = $criteria->remove(MusicDeezerAlbumGenrePeer::ID);
            if ($value) {
                $selectCriteria->add(MusicDeezerAlbumGenrePeer::ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(MusicDeezerAlbumGenrePeer::TABLE_NAME);
            }

        } else { // $values is MusicDeezerAlbumGenre object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(MusicDeezerAlbumGenrePeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the music_deezer_album_genre table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerAlbumGenrePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(MusicDeezerAlbumGenrePeer::TABLE_NAME, $con, MusicDeezerAlbumGenrePeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MusicDeezerAlbumGenrePeer::clearInstancePool();
            MusicDeezerAlbumGenrePeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a MusicDeezerAlbumGenre or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or MusicDeezerAlbumGenre object or primary key or array of primary keys
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
            $con = Propel::getConnection(MusicDeezerAlbumGenrePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            MusicDeezerAlbumGenrePeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof MusicDeezerAlbumGenre) { // it's a model object
            // invalidate the cache for this single object
            MusicDeezerAlbumGenrePeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(MusicDeezerAlbumGenrePeer::DATABASE_NAME);
            $criteria->add(MusicDeezerAlbumGenrePeer::ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                MusicDeezerAlbumGenrePeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(MusicDeezerAlbumGenrePeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            MusicDeezerAlbumGenrePeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given MusicDeezerAlbumGenre object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param MusicDeezerAlbumGenre $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(MusicDeezerAlbumGenrePeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(MusicDeezerAlbumGenrePeer::TABLE_NAME);

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

        return BasePeer::doValidate(MusicDeezerAlbumGenrePeer::DATABASE_NAME, MusicDeezerAlbumGenrePeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return MusicDeezerAlbumGenre
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = MusicDeezerAlbumGenrePeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerAlbumGenrePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(MusicDeezerAlbumGenrePeer::DATABASE_NAME);
        $criteria->add(MusicDeezerAlbumGenrePeer::ID, $pk);

        $v = MusicDeezerAlbumGenrePeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return MusicDeezerAlbumGenre[]
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerAlbumGenrePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(MusicDeezerAlbumGenrePeer::DATABASE_NAME);
            $criteria->add(MusicDeezerAlbumGenrePeer::ID, $pks, Criteria::IN);
            $objs = MusicDeezerAlbumGenrePeer::doSelect($criteria, $con);
        }

        return $objs;
    }

}

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseMusicDeezerAlbumGenrePeer::buildTableMap();
