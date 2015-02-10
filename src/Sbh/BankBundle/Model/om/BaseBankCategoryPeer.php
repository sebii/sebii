<?php

namespace Sbh\BankBundle\Model\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use Sbh\BankBundle\Model\BankCategory;
use Sbh\BankBundle\Model\BankCategoryPeer;
use Sbh\BankBundle\Model\BankCategoryRegroupmentPeer;
use Sbh\BankBundle\Model\BankFrequentOperationPeer;
use Sbh\BankBundle\Model\BankOperationPeer;
use Sbh\BankBundle\Model\map\BankCategoryTableMap;

abstract class BaseBankCategoryPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'default';

    /** the table name for this class */
    const TABLE_NAME = 'bank_category';

    /** the related Propel class for this table */
    const OM_CLASS = 'Sbh\\BankBundle\\Model\\BankCategory';

    /** the related TableMap class for this table */
    const TM_CLASS = 'Sbh\\BankBundle\\Model\\map\\BankCategoryTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 7;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 7;

    /** the column name for the name field */
    const NAME = 'bank_category.name';

    /** the column name for the user_id field */
    const USER_ID = 'bank_category.user_id';

    /** the column name for the bank_category_regroupment_id field */
    const BANK_CATEGORY_REGROUPMENT_ID = 'bank_category.bank_category_regroupment_id';

    /** the column name for the type field */
    const TYPE = 'bank_category.type';

    /** the column name for the id field */
    const ID = 'bank_category.id';

    /** the column name for the created_at field */
    const CREATED_AT = 'bank_category.created_at';

    /** the column name for the updated_at field */
    const UPDATED_AT = 'bank_category.updated_at';

    /** The enumerated values for the type field */
    const TYPE_PAYMENT = 'payment';
    const TYPE_DEPOSIT = 'deposit';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of BankCategory objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array BankCategory[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. BankCategoryPeer::$fieldNames[BankCategoryPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('Name', 'UserId', 'BankCategoryRegroupmentId', 'Type', 'Id', 'CreatedAt', 'UpdatedAt', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('name', 'userId', 'bankCategoryRegroupmentId', 'type', 'id', 'createdAt', 'updatedAt', ),
        BasePeer::TYPE_COLNAME => array (BankCategoryPeer::NAME, BankCategoryPeer::USER_ID, BankCategoryPeer::BANK_CATEGORY_REGROUPMENT_ID, BankCategoryPeer::TYPE, BankCategoryPeer::ID, BankCategoryPeer::CREATED_AT, BankCategoryPeer::UPDATED_AT, ),
        BasePeer::TYPE_RAW_COLNAME => array ('NAME', 'USER_ID', 'BANK_CATEGORY_REGROUPMENT_ID', 'TYPE', 'ID', 'CREATED_AT', 'UPDATED_AT', ),
        BasePeer::TYPE_FIELDNAME => array ('name', 'user_id', 'bank_category_regroupment_id', 'type', 'id', 'created_at', 'updated_at', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. BankCategoryPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('Name' => 0, 'UserId' => 1, 'BankCategoryRegroupmentId' => 2, 'Type' => 3, 'Id' => 4, 'CreatedAt' => 5, 'UpdatedAt' => 6, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('name' => 0, 'userId' => 1, 'bankCategoryRegroupmentId' => 2, 'type' => 3, 'id' => 4, 'createdAt' => 5, 'updatedAt' => 6, ),
        BasePeer::TYPE_COLNAME => array (BankCategoryPeer::NAME => 0, BankCategoryPeer::USER_ID => 1, BankCategoryPeer::BANK_CATEGORY_REGROUPMENT_ID => 2, BankCategoryPeer::TYPE => 3, BankCategoryPeer::ID => 4, BankCategoryPeer::CREATED_AT => 5, BankCategoryPeer::UPDATED_AT => 6, ),
        BasePeer::TYPE_RAW_COLNAME => array ('NAME' => 0, 'USER_ID' => 1, 'BANK_CATEGORY_REGROUPMENT_ID' => 2, 'TYPE' => 3, 'ID' => 4, 'CREATED_AT' => 5, 'UPDATED_AT' => 6, ),
        BasePeer::TYPE_FIELDNAME => array ('name' => 0, 'user_id' => 1, 'bank_category_regroupment_id' => 2, 'type' => 3, 'id' => 4, 'created_at' => 5, 'updated_at' => 6, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
    );

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
        BankCategoryPeer::TYPE => array(
      BankCategoryPeer::TYPE_PAYMENT,
      BankCategoryPeer::TYPE_DEPOSIT,
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
        $toNames = BankCategoryPeer::getFieldNames($toType);
        $key = isset(BankCategoryPeer::$fieldKeys[$fromType][$name]) ? BankCategoryPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(BankCategoryPeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, BankCategoryPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return BankCategoryPeer::$fieldNames[$type];
    }

    /**
     * Gets the list of values for all ENUM columns
     * @return array
     */
    public static function getValueSets()
    {
      return BankCategoryPeer::$enumValueSets;
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
        $valueSets = BankCategoryPeer::getValueSets();

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
        $values = BankCategoryPeer::getValueSet($colname);
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
     * @param      string $column The column name for current table. (i.e. BankCategoryPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(BankCategoryPeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(BankCategoryPeer::NAME);
            $criteria->addSelectColumn(BankCategoryPeer::USER_ID);
            $criteria->addSelectColumn(BankCategoryPeer::BANK_CATEGORY_REGROUPMENT_ID);
            $criteria->addSelectColumn(BankCategoryPeer::TYPE);
            $criteria->addSelectColumn(BankCategoryPeer::ID);
            $criteria->addSelectColumn(BankCategoryPeer::CREATED_AT);
            $criteria->addSelectColumn(BankCategoryPeer::UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.user_id');
            $criteria->addSelectColumn($alias . '.bank_category_regroupment_id');
            $criteria->addSelectColumn($alias . '.type');
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
        $criteria->setPrimaryTableName(BankCategoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BankCategoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(BankCategoryPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(BankCategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return BankCategory
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = BankCategoryPeer::doSelect($critcopy, $con);
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
        return BankCategoryPeer::populateObjects(BankCategoryPeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(BankCategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            BankCategoryPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(BankCategoryPeer::DATABASE_NAME);

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
     * @param BankCategory $obj A BankCategory object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getId();
            } // if key === null
            BankCategoryPeer::$instances[$key] = $obj;
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
     * @param      mixed $value A BankCategory object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof BankCategory) {
                $key = (string) $value->getId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or BankCategory object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(BankCategoryPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return BankCategory Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(BankCategoryPeer::$instances[$key])) {
                return BankCategoryPeer::$instances[$key];
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
        foreach (BankCategoryPeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        BankCategoryPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to bank_category
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in BankFrequentOperationPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        BankFrequentOperationPeer::clearInstancePool();
        // Invalidate objects in BankOperationPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        BankOperationPeer::clearInstancePool();
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
        $cls = BankCategoryPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = BankCategoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = BankCategoryPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                BankCategoryPeer::addInstanceToPool($obj, $key);
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
     * @return array (BankCategory object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = BankCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = BankCategoryPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + BankCategoryPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = BankCategoryPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            BankCategoryPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * Gets the SQL value for Type ENUM value
     *
     * @param  string $enumVal ENUM value to get SQL value for
     * @return int SQL value
     */
    public static function getTypeSqlValue($enumVal)
    {
        return BankCategoryPeer::getSqlValueForEnum(BankCategoryPeer::TYPE, $enumVal);
    }


    /**
     * Returns the number of rows matching criteria, joining the related BankCategoryRegroupment table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinBankCategoryRegroupment(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(BankCategoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BankCategoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(BankCategoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BankCategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BankCategoryPeer::BANK_CATEGORY_REGROUPMENT_ID, BankCategoryRegroupmentPeer::ID, $join_behavior);

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
     * Selects a collection of BankCategory objects pre-filled with their BankCategoryRegroupment objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of BankCategory objects.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinBankCategoryRegroupment(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BankCategoryPeer::DATABASE_NAME);
        }

        BankCategoryPeer::addSelectColumns($criteria);
        $startcol = BankCategoryPeer::NUM_HYDRATE_COLUMNS;
        BankCategoryRegroupmentPeer::addSelectColumns($criteria);

        $criteria->addJoin(BankCategoryPeer::BANK_CATEGORY_REGROUPMENT_ID, BankCategoryRegroupmentPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BankCategoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BankCategoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = BankCategoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BankCategoryPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = BankCategoryRegroupmentPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = BankCategoryRegroupmentPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = BankCategoryRegroupmentPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    BankCategoryRegroupmentPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (BankCategory) to $obj2 (BankCategoryRegroupment)
                $obj2->addBankCategory($obj1);

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
        $criteria->setPrimaryTableName(BankCategoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BankCategoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(BankCategoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BankCategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BankCategoryPeer::BANK_CATEGORY_REGROUPMENT_ID, BankCategoryRegroupmentPeer::ID, $join_behavior);

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
     * Selects a collection of BankCategory objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of BankCategory objects.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BankCategoryPeer::DATABASE_NAME);
        }

        BankCategoryPeer::addSelectColumns($criteria);
        $startcol2 = BankCategoryPeer::NUM_HYDRATE_COLUMNS;

        BankCategoryRegroupmentPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + BankCategoryRegroupmentPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(BankCategoryPeer::BANK_CATEGORY_REGROUPMENT_ID, BankCategoryRegroupmentPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BankCategoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BankCategoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = BankCategoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BankCategoryPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined BankCategoryRegroupment rows

            $key2 = BankCategoryRegroupmentPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = BankCategoryRegroupmentPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = BankCategoryRegroupmentPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    BankCategoryRegroupmentPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (BankCategory) to the collection in $obj2 (BankCategoryRegroupment)
                $obj2->addBankCategory($obj1);
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
        return Propel::getDatabaseMap(BankCategoryPeer::DATABASE_NAME)->getTable(BankCategoryPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseBankCategoryPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseBankCategoryPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \Sbh\BankBundle\Model\map\BankCategoryTableMap());
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
        return BankCategoryPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a BankCategory or Criteria object.
     *
     * @param      mixed $values Criteria or BankCategory object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BankCategoryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from BankCategory object
        }

        if ($criteria->containsKey(BankCategoryPeer::ID) && $criteria->keyContainsValue(BankCategoryPeer::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.BankCategoryPeer::ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(BankCategoryPeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a BankCategory or Criteria object.
     *
     * @param      mixed $values Criteria or BankCategory object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BankCategoryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(BankCategoryPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(BankCategoryPeer::ID);
            $value = $criteria->remove(BankCategoryPeer::ID);
            if ($value) {
                $selectCriteria->add(BankCategoryPeer::ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(BankCategoryPeer::TABLE_NAME);
            }

        } else { // $values is BankCategory object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(BankCategoryPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the bank_category table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BankCategoryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(BankCategoryPeer::TABLE_NAME, $con, BankCategoryPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BankCategoryPeer::clearInstancePool();
            BankCategoryPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a BankCategory or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or BankCategory object or primary key or array of primary keys
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
            $con = Propel::getConnection(BankCategoryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            BankCategoryPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof BankCategory) { // it's a model object
            // invalidate the cache for this single object
            BankCategoryPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(BankCategoryPeer::DATABASE_NAME);
            $criteria->add(BankCategoryPeer::ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                BankCategoryPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(BankCategoryPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            BankCategoryPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given BankCategory object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param BankCategory $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(BankCategoryPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(BankCategoryPeer::TABLE_NAME);

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

        return BasePeer::doValidate(BankCategoryPeer::DATABASE_NAME, BankCategoryPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return BankCategory
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = BankCategoryPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(BankCategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(BankCategoryPeer::DATABASE_NAME);
        $criteria->add(BankCategoryPeer::ID, $pk);

        $v = BankCategoryPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return BankCategory[]
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BankCategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(BankCategoryPeer::DATABASE_NAME);
            $criteria->add(BankCategoryPeer::ID, $pks, Criteria::IN);
            $objs = BankCategoryPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

}

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseBankCategoryPeer::buildTableMap();

