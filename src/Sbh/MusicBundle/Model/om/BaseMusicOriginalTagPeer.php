<?php

namespace Sbh\MusicBundle\Model\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use Sbh\MusicBundle\Model\MusicFilePeer;
use Sbh\MusicBundle\Model\MusicOriginalTag;
use Sbh\MusicBundle\Model\MusicOriginalTagPeer;
use Sbh\MusicBundle\Model\map\MusicOriginalTagTableMap;

abstract class BaseMusicOriginalTagPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'default';

    /** the table name for this class */
    const TABLE_NAME = 'music_original_tag';

    /** the related Propel class for this table */
    const OM_CLASS = 'Sbh\\MusicBundle\\Model\\MusicOriginalTag';

    /** the related TableMap class for this table */
    const TM_CLASS = 'Sbh\\MusicBundle\\Model\\map\\MusicOriginalTagTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 7;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 7;

    /** the column name for the music_file_id field */
    const MUSIC_FILE_ID = 'music_original_tag.music_file_id';

    /** the column name for the type field */
    const TYPE = 'music_original_tag.type';

    /** the column name for the name field */
    const NAME = 'music_original_tag.name';

    /** the column name for the value field */
    const VALUE = 'music_original_tag.value';

    /** the column name for the id field */
    const ID = 'music_original_tag.id';

    /** the column name for the created_at field */
    const CREATED_AT = 'music_original_tag.created_at';

    /** the column name for the updated_at field */
    const UPDATED_AT = 'music_original_tag.updated_at';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of MusicOriginalTag objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array MusicOriginalTag[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. MusicOriginalTagPeer::$fieldNames[MusicOriginalTagPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('MusicFileId', 'Type', 'Name', 'Value', 'Id', 'CreatedAt', 'UpdatedAt', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('musicFileId', 'type', 'name', 'value', 'id', 'createdAt', 'updatedAt', ),
        BasePeer::TYPE_COLNAME => array (MusicOriginalTagPeer::MUSIC_FILE_ID, MusicOriginalTagPeer::TYPE, MusicOriginalTagPeer::NAME, MusicOriginalTagPeer::VALUE, MusicOriginalTagPeer::ID, MusicOriginalTagPeer::CREATED_AT, MusicOriginalTagPeer::UPDATED_AT, ),
        BasePeer::TYPE_RAW_COLNAME => array ('MUSIC_FILE_ID', 'TYPE', 'NAME', 'VALUE', 'ID', 'CREATED_AT', 'UPDATED_AT', ),
        BasePeer::TYPE_FIELDNAME => array ('music_file_id', 'type', 'name', 'value', 'id', 'created_at', 'updated_at', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. MusicOriginalTagPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('MusicFileId' => 0, 'Type' => 1, 'Name' => 2, 'Value' => 3, 'Id' => 4, 'CreatedAt' => 5, 'UpdatedAt' => 6, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('musicFileId' => 0, 'type' => 1, 'name' => 2, 'value' => 3, 'id' => 4, 'createdAt' => 5, 'updatedAt' => 6, ),
        BasePeer::TYPE_COLNAME => array (MusicOriginalTagPeer::MUSIC_FILE_ID => 0, MusicOriginalTagPeer::TYPE => 1, MusicOriginalTagPeer::NAME => 2, MusicOriginalTagPeer::VALUE => 3, MusicOriginalTagPeer::ID => 4, MusicOriginalTagPeer::CREATED_AT => 5, MusicOriginalTagPeer::UPDATED_AT => 6, ),
        BasePeer::TYPE_RAW_COLNAME => array ('MUSIC_FILE_ID' => 0, 'TYPE' => 1, 'NAME' => 2, 'VALUE' => 3, 'ID' => 4, 'CREATED_AT' => 5, 'UPDATED_AT' => 6, ),
        BasePeer::TYPE_FIELDNAME => array ('music_file_id' => 0, 'type' => 1, 'name' => 2, 'value' => 3, 'id' => 4, 'created_at' => 5, 'updated_at' => 6, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
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
        $toNames = MusicOriginalTagPeer::getFieldNames($toType);
        $key = isset(MusicOriginalTagPeer::$fieldKeys[$fromType][$name]) ? MusicOriginalTagPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(MusicOriginalTagPeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, MusicOriginalTagPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return MusicOriginalTagPeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. MusicOriginalTagPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(MusicOriginalTagPeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(MusicOriginalTagPeer::MUSIC_FILE_ID);
            $criteria->addSelectColumn(MusicOriginalTagPeer::TYPE);
            $criteria->addSelectColumn(MusicOriginalTagPeer::NAME);
            $criteria->addSelectColumn(MusicOriginalTagPeer::VALUE);
            $criteria->addSelectColumn(MusicOriginalTagPeer::ID);
            $criteria->addSelectColumn(MusicOriginalTagPeer::CREATED_AT);
            $criteria->addSelectColumn(MusicOriginalTagPeer::UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.music_file_id');
            $criteria->addSelectColumn($alias . '.type');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.value');
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
        $criteria->setPrimaryTableName(MusicOriginalTagPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            MusicOriginalTagPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(MusicOriginalTagPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(MusicOriginalTagPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return MusicOriginalTag
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = MusicOriginalTagPeer::doSelect($critcopy, $con);
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
        return MusicOriginalTagPeer::populateObjects(MusicOriginalTagPeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(MusicOriginalTagPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            MusicOriginalTagPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(MusicOriginalTagPeer::DATABASE_NAME);

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
     * @param MusicOriginalTag $obj A MusicOriginalTag object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getId();
            } // if key === null
            MusicOriginalTagPeer::$instances[$key] = $obj;
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
     * @param      mixed $value A MusicOriginalTag object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof MusicOriginalTag) {
                $key = (string) $value->getId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or MusicOriginalTag object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(MusicOriginalTagPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return MusicOriginalTag Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(MusicOriginalTagPeer::$instances[$key])) {
                return MusicOriginalTagPeer::$instances[$key];
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
        foreach (MusicOriginalTagPeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        MusicOriginalTagPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to music_original_tag
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
        if ($row[$startcol + 4] === null) {
            return null;
        }

        return (string) $row[$startcol + 4];
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

        return (int) $row[$startcol + 4];
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
        $cls = MusicOriginalTagPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = MusicOriginalTagPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = MusicOriginalTagPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                MusicOriginalTagPeer::addInstanceToPool($obj, $key);
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
     * @return array (MusicOriginalTag object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = MusicOriginalTagPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = MusicOriginalTagPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + MusicOriginalTagPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = MusicOriginalTagPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            MusicOriginalTagPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }


    /**
     * Returns the number of rows matching criteria, joining the related MusicFile table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinMusicFile(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(MusicOriginalTagPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            MusicOriginalTagPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(MusicOriginalTagPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(MusicOriginalTagPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(MusicOriginalTagPeer::MUSIC_FILE_ID, MusicFilePeer::ID, $join_behavior);

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
     * Selects a collection of MusicOriginalTag objects pre-filled with their MusicFile objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of MusicOriginalTag objects.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinMusicFile(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(MusicOriginalTagPeer::DATABASE_NAME);
        }

        MusicOriginalTagPeer::addSelectColumns($criteria);
        $startcol = MusicOriginalTagPeer::NUM_HYDRATE_COLUMNS;
        MusicFilePeer::addSelectColumns($criteria);

        $criteria->addJoin(MusicOriginalTagPeer::MUSIC_FILE_ID, MusicFilePeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = MusicOriginalTagPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = MusicOriginalTagPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = MusicOriginalTagPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                MusicOriginalTagPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = MusicFilePeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = MusicFilePeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = MusicFilePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    MusicFilePeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (MusicOriginalTag) to $obj2 (MusicFile)
                $obj2->addMusicOriginalTag($obj1);

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
        $criteria->setPrimaryTableName(MusicOriginalTagPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            MusicOriginalTagPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(MusicOriginalTagPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(MusicOriginalTagPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(MusicOriginalTagPeer::MUSIC_FILE_ID, MusicFilePeer::ID, $join_behavior);

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
     * Selects a collection of MusicOriginalTag objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of MusicOriginalTag objects.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(MusicOriginalTagPeer::DATABASE_NAME);
        }

        MusicOriginalTagPeer::addSelectColumns($criteria);
        $startcol2 = MusicOriginalTagPeer::NUM_HYDRATE_COLUMNS;

        MusicFilePeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + MusicFilePeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(MusicOriginalTagPeer::MUSIC_FILE_ID, MusicFilePeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = MusicOriginalTagPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = MusicOriginalTagPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = MusicOriginalTagPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                MusicOriginalTagPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined MusicFile rows

            $key2 = MusicFilePeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = MusicFilePeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = MusicFilePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    MusicFilePeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (MusicOriginalTag) to the collection in $obj2 (MusicFile)
                $obj2->addMusicOriginalTag($obj1);
            } // if joined row not null

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
        return Propel::getDatabaseMap(MusicOriginalTagPeer::DATABASE_NAME)->getTable(MusicOriginalTagPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseMusicOriginalTagPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseMusicOriginalTagPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \Sbh\MusicBundle\Model\map\MusicOriginalTagTableMap());
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
        return MusicOriginalTagPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a MusicOriginalTag or Criteria object.
     *
     * @param      mixed $values Criteria or MusicOriginalTag object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(MusicOriginalTagPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from MusicOriginalTag object
        }

        if ($criteria->containsKey(MusicOriginalTagPeer::ID) && $criteria->keyContainsValue(MusicOriginalTagPeer::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.MusicOriginalTagPeer::ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(MusicOriginalTagPeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a MusicOriginalTag or Criteria object.
     *
     * @param      mixed $values Criteria or MusicOriginalTag object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(MusicOriginalTagPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(MusicOriginalTagPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(MusicOriginalTagPeer::ID);
            $value = $criteria->remove(MusicOriginalTagPeer::ID);
            if ($value) {
                $selectCriteria->add(MusicOriginalTagPeer::ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(MusicOriginalTagPeer::TABLE_NAME);
            }

        } else { // $values is MusicOriginalTag object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(MusicOriginalTagPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the music_original_tag table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(MusicOriginalTagPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(MusicOriginalTagPeer::TABLE_NAME, $con, MusicOriginalTagPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MusicOriginalTagPeer::clearInstancePool();
            MusicOriginalTagPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a MusicOriginalTag or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or MusicOriginalTag object or primary key or array of primary keys
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
            $con = Propel::getConnection(MusicOriginalTagPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            MusicOriginalTagPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof MusicOriginalTag) { // it's a model object
            // invalidate the cache for this single object
            MusicOriginalTagPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(MusicOriginalTagPeer::DATABASE_NAME);
            $criteria->add(MusicOriginalTagPeer::ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                MusicOriginalTagPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(MusicOriginalTagPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            MusicOriginalTagPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given MusicOriginalTag object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param MusicOriginalTag $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(MusicOriginalTagPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(MusicOriginalTagPeer::TABLE_NAME);

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

        return BasePeer::doValidate(MusicOriginalTagPeer::DATABASE_NAME, MusicOriginalTagPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return MusicOriginalTag
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = MusicOriginalTagPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(MusicOriginalTagPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(MusicOriginalTagPeer::DATABASE_NAME);
        $criteria->add(MusicOriginalTagPeer::ID, $pk);

        $v = MusicOriginalTagPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return MusicOriginalTag[]
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(MusicOriginalTagPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(MusicOriginalTagPeer::DATABASE_NAME);
            $criteria->add(MusicOriginalTagPeer::ID, $pks, Criteria::IN);
            $objs = MusicOriginalTagPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

}

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseMusicOriginalTagPeer::buildTableMap();

