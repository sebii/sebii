<?php

namespace Sbh\BankBundle\Model\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use Sbh\BankBundle\Model\BankAccountPeer;
use Sbh\BankBundle\Model\BankCategoryPeer;
use Sbh\BankBundle\Model\BankFrequentOperationPeer;
use Sbh\BankBundle\Model\BankOperation;
use Sbh\BankBundle\Model\BankOperationPeer;
use Sbh\BankBundle\Model\BankPayeePeer;
use Sbh\BankBundle\Model\map\BankOperationTableMap;

abstract class BaseBankOperationPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'default';

    /** the table name for this class */
    const TABLE_NAME = 'bank_operation';

    /** the related Propel class for this table */
    const OM_CLASS = 'Sbh\\BankBundle\\Model\\BankOperation';

    /** the related TableMap class for this table */
    const TM_CLASS = 'Sbh\\BankBundle\\Model\\map\\BankOperationTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 11;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 11;

    /** the column name for the bank_account_id field */
    const BANK_ACCOUNT_ID = 'bank_operation.bank_account_id';

    /** the column name for the name field */
    const NAME = 'bank_operation.name';

    /** the column name for the date field */
    const DATE = 'bank_operation.date';

    /** the column name for the bank_payee_id field */
    const BANK_PAYEE_ID = 'bank_operation.bank_payee_id';

    /** the column name for the bank_category_id field */
    const BANK_CATEGORY_ID = 'bank_operation.bank_category_id';

    /** the column name for the payment field */
    const PAYMENT = 'bank_operation.payment';

    /** the column name for the deposit field */
    const DEPOSIT = 'bank_operation.deposit';

    /** the column name for the bank_frequent_operation_id field */
    const BANK_FREQUENT_OPERATION_ID = 'bank_operation.bank_frequent_operation_id';

    /** the column name for the id field */
    const ID = 'bank_operation.id';

    /** the column name for the created_at field */
    const CREATED_AT = 'bank_operation.created_at';

    /** the column name for the updated_at field */
    const UPDATED_AT = 'bank_operation.updated_at';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of BankOperation objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array BankOperation[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. BankOperationPeer::$fieldNames[BankOperationPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('BankAccountId', 'Name', 'Date', 'BankPayeeId', 'BankCategoryId', 'Payment', 'Deposit', 'BankFrequentOperationId', 'Id', 'CreatedAt', 'UpdatedAt', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('bankAccountId', 'name', 'date', 'bankPayeeId', 'bankCategoryId', 'payment', 'deposit', 'bankFrequentOperationId', 'id', 'createdAt', 'updatedAt', ),
        BasePeer::TYPE_COLNAME => array (BankOperationPeer::BANK_ACCOUNT_ID, BankOperationPeer::NAME, BankOperationPeer::DATE, BankOperationPeer::BANK_PAYEE_ID, BankOperationPeer::BANK_CATEGORY_ID, BankOperationPeer::PAYMENT, BankOperationPeer::DEPOSIT, BankOperationPeer::BANK_FREQUENT_OPERATION_ID, BankOperationPeer::ID, BankOperationPeer::CREATED_AT, BankOperationPeer::UPDATED_AT, ),
        BasePeer::TYPE_RAW_COLNAME => array ('BANK_ACCOUNT_ID', 'NAME', 'DATE', 'BANK_PAYEE_ID', 'BANK_CATEGORY_ID', 'PAYMENT', 'DEPOSIT', 'BANK_FREQUENT_OPERATION_ID', 'ID', 'CREATED_AT', 'UPDATED_AT', ),
        BasePeer::TYPE_FIELDNAME => array ('bank_account_id', 'name', 'date', 'bank_payee_id', 'bank_category_id', 'payment', 'deposit', 'bank_frequent_operation_id', 'id', 'created_at', 'updated_at', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. BankOperationPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('BankAccountId' => 0, 'Name' => 1, 'Date' => 2, 'BankPayeeId' => 3, 'BankCategoryId' => 4, 'Payment' => 5, 'Deposit' => 6, 'BankFrequentOperationId' => 7, 'Id' => 8, 'CreatedAt' => 9, 'UpdatedAt' => 10, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('bankAccountId' => 0, 'name' => 1, 'date' => 2, 'bankPayeeId' => 3, 'bankCategoryId' => 4, 'payment' => 5, 'deposit' => 6, 'bankFrequentOperationId' => 7, 'id' => 8, 'createdAt' => 9, 'updatedAt' => 10, ),
        BasePeer::TYPE_COLNAME => array (BankOperationPeer::BANK_ACCOUNT_ID => 0, BankOperationPeer::NAME => 1, BankOperationPeer::DATE => 2, BankOperationPeer::BANK_PAYEE_ID => 3, BankOperationPeer::BANK_CATEGORY_ID => 4, BankOperationPeer::PAYMENT => 5, BankOperationPeer::DEPOSIT => 6, BankOperationPeer::BANK_FREQUENT_OPERATION_ID => 7, BankOperationPeer::ID => 8, BankOperationPeer::CREATED_AT => 9, BankOperationPeer::UPDATED_AT => 10, ),
        BasePeer::TYPE_RAW_COLNAME => array ('BANK_ACCOUNT_ID' => 0, 'NAME' => 1, 'DATE' => 2, 'BANK_PAYEE_ID' => 3, 'BANK_CATEGORY_ID' => 4, 'PAYMENT' => 5, 'DEPOSIT' => 6, 'BANK_FREQUENT_OPERATION_ID' => 7, 'ID' => 8, 'CREATED_AT' => 9, 'UPDATED_AT' => 10, ),
        BasePeer::TYPE_FIELDNAME => array ('bank_account_id' => 0, 'name' => 1, 'date' => 2, 'bank_payee_id' => 3, 'bank_category_id' => 4, 'payment' => 5, 'deposit' => 6, 'bank_frequent_operation_id' => 7, 'id' => 8, 'created_at' => 9, 'updated_at' => 10, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
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
        $toNames = BankOperationPeer::getFieldNames($toType);
        $key = isset(BankOperationPeer::$fieldKeys[$fromType][$name]) ? BankOperationPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(BankOperationPeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, BankOperationPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return BankOperationPeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. BankOperationPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(BankOperationPeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(BankOperationPeer::BANK_ACCOUNT_ID);
            $criteria->addSelectColumn(BankOperationPeer::NAME);
            $criteria->addSelectColumn(BankOperationPeer::DATE);
            $criteria->addSelectColumn(BankOperationPeer::BANK_PAYEE_ID);
            $criteria->addSelectColumn(BankOperationPeer::BANK_CATEGORY_ID);
            $criteria->addSelectColumn(BankOperationPeer::PAYMENT);
            $criteria->addSelectColumn(BankOperationPeer::DEPOSIT);
            $criteria->addSelectColumn(BankOperationPeer::BANK_FREQUENT_OPERATION_ID);
            $criteria->addSelectColumn(BankOperationPeer::ID);
            $criteria->addSelectColumn(BankOperationPeer::CREATED_AT);
            $criteria->addSelectColumn(BankOperationPeer::UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.bank_account_id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.date');
            $criteria->addSelectColumn($alias . '.bank_payee_id');
            $criteria->addSelectColumn($alias . '.bank_category_id');
            $criteria->addSelectColumn($alias . '.payment');
            $criteria->addSelectColumn($alias . '.deposit');
            $criteria->addSelectColumn($alias . '.bank_frequent_operation_id');
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
        $criteria->setPrimaryTableName(BankOperationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BankOperationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(BankOperationPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(BankOperationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return BankOperation
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = BankOperationPeer::doSelect($critcopy, $con);
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
        return BankOperationPeer::populateObjects(BankOperationPeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(BankOperationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            BankOperationPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(BankOperationPeer::DATABASE_NAME);

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
     * @param BankOperation $obj A BankOperation object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getId();
            } // if key === null
            BankOperationPeer::$instances[$key] = $obj;
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
     * @param      mixed $value A BankOperation object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof BankOperation) {
                $key = (string) $value->getId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or BankOperation object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(BankOperationPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return BankOperation Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(BankOperationPeer::$instances[$key])) {
                return BankOperationPeer::$instances[$key];
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
        foreach (BankOperationPeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        BankOperationPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to bank_operation
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
        if ($row[$startcol + 8] === null) {
            return null;
        }

        return (string) $row[$startcol + 8];
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

        return (int) $row[$startcol + 8];
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
        $cls = BankOperationPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = BankOperationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = BankOperationPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                BankOperationPeer::addInstanceToPool($obj, $key);
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
     * @return array (BankOperation object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = BankOperationPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = BankOperationPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + BankOperationPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = BankOperationPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            BankOperationPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }


    /**
     * Returns the number of rows matching criteria, joining the related BankAccount table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinBankAccount(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(BankOperationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BankOperationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(BankOperationPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BankOperationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BankOperationPeer::BANK_ACCOUNT_ID, BankAccountPeer::ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related BankPayee table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinBankPayee(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(BankOperationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BankOperationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(BankOperationPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BankOperationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BankOperationPeer::BANK_PAYEE_ID, BankPayeePeer::ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related BankCategory table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinBankCategory(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(BankOperationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BankOperationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(BankOperationPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BankOperationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BankOperationPeer::BANK_CATEGORY_ID, BankCategoryPeer::ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related BankFrequentOperation table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinBankFrequentOperation(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(BankOperationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BankOperationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(BankOperationPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BankOperationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BankOperationPeer::BANK_FREQUENT_OPERATION_ID, BankFrequentOperationPeer::ID, $join_behavior);

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
     * Selects a collection of BankOperation objects pre-filled with their BankAccount objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of BankOperation objects.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinBankAccount(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BankOperationPeer::DATABASE_NAME);
        }

        BankOperationPeer::addSelectColumns($criteria);
        $startcol = BankOperationPeer::NUM_HYDRATE_COLUMNS;
        BankAccountPeer::addSelectColumns($criteria);

        $criteria->addJoin(BankOperationPeer::BANK_ACCOUNT_ID, BankAccountPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BankOperationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BankOperationPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = BankOperationPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BankOperationPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = BankAccountPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = BankAccountPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = BankAccountPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    BankAccountPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (BankOperation) to $obj2 (BankAccount)
                $obj2->addBankOperation($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of BankOperation objects pre-filled with their BankPayee objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of BankOperation objects.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinBankPayee(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BankOperationPeer::DATABASE_NAME);
        }

        BankOperationPeer::addSelectColumns($criteria);
        $startcol = BankOperationPeer::NUM_HYDRATE_COLUMNS;
        BankPayeePeer::addSelectColumns($criteria);

        $criteria->addJoin(BankOperationPeer::BANK_PAYEE_ID, BankPayeePeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BankOperationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BankOperationPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = BankOperationPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BankOperationPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = BankPayeePeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = BankPayeePeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = BankPayeePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    BankPayeePeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (BankOperation) to $obj2 (BankPayee)
                $obj2->addBankOperation($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of BankOperation objects pre-filled with their BankCategory objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of BankOperation objects.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinBankCategory(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BankOperationPeer::DATABASE_NAME);
        }

        BankOperationPeer::addSelectColumns($criteria);
        $startcol = BankOperationPeer::NUM_HYDRATE_COLUMNS;
        BankCategoryPeer::addSelectColumns($criteria);

        $criteria->addJoin(BankOperationPeer::BANK_CATEGORY_ID, BankCategoryPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BankOperationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BankOperationPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = BankOperationPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BankOperationPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = BankCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = BankCategoryPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = BankCategoryPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    BankCategoryPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (BankOperation) to $obj2 (BankCategory)
                $obj2->addBankOperation($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of BankOperation objects pre-filled with their BankFrequentOperation objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of BankOperation objects.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinBankFrequentOperation(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BankOperationPeer::DATABASE_NAME);
        }

        BankOperationPeer::addSelectColumns($criteria);
        $startcol = BankOperationPeer::NUM_HYDRATE_COLUMNS;
        BankFrequentOperationPeer::addSelectColumns($criteria);

        $criteria->addJoin(BankOperationPeer::BANK_FREQUENT_OPERATION_ID, BankFrequentOperationPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BankOperationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BankOperationPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = BankOperationPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BankOperationPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = BankFrequentOperationPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = BankFrequentOperationPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = BankFrequentOperationPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    BankFrequentOperationPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (BankOperation) to $obj2 (BankFrequentOperation)
                $obj2->addBankOperation($obj1);

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
        $criteria->setPrimaryTableName(BankOperationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BankOperationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(BankOperationPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BankOperationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BankOperationPeer::BANK_ACCOUNT_ID, BankAccountPeer::ID, $join_behavior);

        $criteria->addJoin(BankOperationPeer::BANK_PAYEE_ID, BankPayeePeer::ID, $join_behavior);

        $criteria->addJoin(BankOperationPeer::BANK_CATEGORY_ID, BankCategoryPeer::ID, $join_behavior);

        $criteria->addJoin(BankOperationPeer::BANK_FREQUENT_OPERATION_ID, BankFrequentOperationPeer::ID, $join_behavior);

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
     * Selects a collection of BankOperation objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of BankOperation objects.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BankOperationPeer::DATABASE_NAME);
        }

        BankOperationPeer::addSelectColumns($criteria);
        $startcol2 = BankOperationPeer::NUM_HYDRATE_COLUMNS;

        BankAccountPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + BankAccountPeer::NUM_HYDRATE_COLUMNS;

        BankPayeePeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + BankPayeePeer::NUM_HYDRATE_COLUMNS;

        BankCategoryPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + BankCategoryPeer::NUM_HYDRATE_COLUMNS;

        BankFrequentOperationPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + BankFrequentOperationPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(BankOperationPeer::BANK_ACCOUNT_ID, BankAccountPeer::ID, $join_behavior);

        $criteria->addJoin(BankOperationPeer::BANK_PAYEE_ID, BankPayeePeer::ID, $join_behavior);

        $criteria->addJoin(BankOperationPeer::BANK_CATEGORY_ID, BankCategoryPeer::ID, $join_behavior);

        $criteria->addJoin(BankOperationPeer::BANK_FREQUENT_OPERATION_ID, BankFrequentOperationPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BankOperationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BankOperationPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = BankOperationPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BankOperationPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined BankAccount rows

            $key2 = BankAccountPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = BankAccountPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = BankAccountPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    BankAccountPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (BankOperation) to the collection in $obj2 (BankAccount)
                $obj2->addBankOperation($obj1);
            } // if joined row not null

            // Add objects for joined BankPayee rows

            $key3 = BankPayeePeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = BankPayeePeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = BankPayeePeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    BankPayeePeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (BankOperation) to the collection in $obj3 (BankPayee)
                $obj3->addBankOperation($obj1);
            } // if joined row not null

            // Add objects for joined BankCategory rows

            $key4 = BankCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol4);
            if ($key4 !== null) {
                $obj4 = BankCategoryPeer::getInstanceFromPool($key4);
                if (!$obj4) {

                    $cls = BankCategoryPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    BankCategoryPeer::addInstanceToPool($obj4, $key4);
                } // if obj4 loaded

                // Add the $obj1 (BankOperation) to the collection in $obj4 (BankCategory)
                $obj4->addBankOperation($obj1);
            } // if joined row not null

            // Add objects for joined BankFrequentOperation rows

            $key5 = BankFrequentOperationPeer::getPrimaryKeyHashFromRow($row, $startcol5);
            if ($key5 !== null) {
                $obj5 = BankFrequentOperationPeer::getInstanceFromPool($key5);
                if (!$obj5) {

                    $cls = BankFrequentOperationPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    BankFrequentOperationPeer::addInstanceToPool($obj5, $key5);
                } // if obj5 loaded

                // Add the $obj1 (BankOperation) to the collection in $obj5 (BankFrequentOperation)
                $obj5->addBankOperation($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining the related BankAccount table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptBankAccount(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(BankOperationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BankOperationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(BankOperationPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BankOperationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BankOperationPeer::BANK_PAYEE_ID, BankPayeePeer::ID, $join_behavior);

        $criteria->addJoin(BankOperationPeer::BANK_CATEGORY_ID, BankCategoryPeer::ID, $join_behavior);

        $criteria->addJoin(BankOperationPeer::BANK_FREQUENT_OPERATION_ID, BankFrequentOperationPeer::ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related BankPayee table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptBankPayee(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(BankOperationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BankOperationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(BankOperationPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BankOperationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BankOperationPeer::BANK_ACCOUNT_ID, BankAccountPeer::ID, $join_behavior);

        $criteria->addJoin(BankOperationPeer::BANK_CATEGORY_ID, BankCategoryPeer::ID, $join_behavior);

        $criteria->addJoin(BankOperationPeer::BANK_FREQUENT_OPERATION_ID, BankFrequentOperationPeer::ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related BankCategory table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptBankCategory(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(BankOperationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BankOperationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(BankOperationPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BankOperationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BankOperationPeer::BANK_ACCOUNT_ID, BankAccountPeer::ID, $join_behavior);

        $criteria->addJoin(BankOperationPeer::BANK_PAYEE_ID, BankPayeePeer::ID, $join_behavior);

        $criteria->addJoin(BankOperationPeer::BANK_FREQUENT_OPERATION_ID, BankFrequentOperationPeer::ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related BankFrequentOperation table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptBankFrequentOperation(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(BankOperationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BankOperationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(BankOperationPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BankOperationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BankOperationPeer::BANK_ACCOUNT_ID, BankAccountPeer::ID, $join_behavior);

        $criteria->addJoin(BankOperationPeer::BANK_PAYEE_ID, BankPayeePeer::ID, $join_behavior);

        $criteria->addJoin(BankOperationPeer::BANK_CATEGORY_ID, BankCategoryPeer::ID, $join_behavior);

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
     * Selects a collection of BankOperation objects pre-filled with all related objects except BankAccount.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of BankOperation objects.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptBankAccount(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BankOperationPeer::DATABASE_NAME);
        }

        BankOperationPeer::addSelectColumns($criteria);
        $startcol2 = BankOperationPeer::NUM_HYDRATE_COLUMNS;

        BankPayeePeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + BankPayeePeer::NUM_HYDRATE_COLUMNS;

        BankCategoryPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + BankCategoryPeer::NUM_HYDRATE_COLUMNS;

        BankFrequentOperationPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + BankFrequentOperationPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(BankOperationPeer::BANK_PAYEE_ID, BankPayeePeer::ID, $join_behavior);

        $criteria->addJoin(BankOperationPeer::BANK_CATEGORY_ID, BankCategoryPeer::ID, $join_behavior);

        $criteria->addJoin(BankOperationPeer::BANK_FREQUENT_OPERATION_ID, BankFrequentOperationPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BankOperationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BankOperationPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = BankOperationPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BankOperationPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined BankPayee rows

                $key2 = BankPayeePeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = BankPayeePeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = BankPayeePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    BankPayeePeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (BankOperation) to the collection in $obj2 (BankPayee)
                $obj2->addBankOperation($obj1);

            } // if joined row is not null

                // Add objects for joined BankCategory rows

                $key3 = BankCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = BankCategoryPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = BankCategoryPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    BankCategoryPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (BankOperation) to the collection in $obj3 (BankCategory)
                $obj3->addBankOperation($obj1);

            } // if joined row is not null

                // Add objects for joined BankFrequentOperation rows

                $key4 = BankFrequentOperationPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = BankFrequentOperationPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = BankFrequentOperationPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    BankFrequentOperationPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (BankOperation) to the collection in $obj4 (BankFrequentOperation)
                $obj4->addBankOperation($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of BankOperation objects pre-filled with all related objects except BankPayee.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of BankOperation objects.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptBankPayee(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BankOperationPeer::DATABASE_NAME);
        }

        BankOperationPeer::addSelectColumns($criteria);
        $startcol2 = BankOperationPeer::NUM_HYDRATE_COLUMNS;

        BankAccountPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + BankAccountPeer::NUM_HYDRATE_COLUMNS;

        BankCategoryPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + BankCategoryPeer::NUM_HYDRATE_COLUMNS;

        BankFrequentOperationPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + BankFrequentOperationPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(BankOperationPeer::BANK_ACCOUNT_ID, BankAccountPeer::ID, $join_behavior);

        $criteria->addJoin(BankOperationPeer::BANK_CATEGORY_ID, BankCategoryPeer::ID, $join_behavior);

        $criteria->addJoin(BankOperationPeer::BANK_FREQUENT_OPERATION_ID, BankFrequentOperationPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BankOperationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BankOperationPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = BankOperationPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BankOperationPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined BankAccount rows

                $key2 = BankAccountPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = BankAccountPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = BankAccountPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    BankAccountPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (BankOperation) to the collection in $obj2 (BankAccount)
                $obj2->addBankOperation($obj1);

            } // if joined row is not null

                // Add objects for joined BankCategory rows

                $key3 = BankCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = BankCategoryPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = BankCategoryPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    BankCategoryPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (BankOperation) to the collection in $obj3 (BankCategory)
                $obj3->addBankOperation($obj1);

            } // if joined row is not null

                // Add objects for joined BankFrequentOperation rows

                $key4 = BankFrequentOperationPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = BankFrequentOperationPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = BankFrequentOperationPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    BankFrequentOperationPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (BankOperation) to the collection in $obj4 (BankFrequentOperation)
                $obj4->addBankOperation($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of BankOperation objects pre-filled with all related objects except BankCategory.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of BankOperation objects.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptBankCategory(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BankOperationPeer::DATABASE_NAME);
        }

        BankOperationPeer::addSelectColumns($criteria);
        $startcol2 = BankOperationPeer::NUM_HYDRATE_COLUMNS;

        BankAccountPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + BankAccountPeer::NUM_HYDRATE_COLUMNS;

        BankPayeePeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + BankPayeePeer::NUM_HYDRATE_COLUMNS;

        BankFrequentOperationPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + BankFrequentOperationPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(BankOperationPeer::BANK_ACCOUNT_ID, BankAccountPeer::ID, $join_behavior);

        $criteria->addJoin(BankOperationPeer::BANK_PAYEE_ID, BankPayeePeer::ID, $join_behavior);

        $criteria->addJoin(BankOperationPeer::BANK_FREQUENT_OPERATION_ID, BankFrequentOperationPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BankOperationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BankOperationPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = BankOperationPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BankOperationPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined BankAccount rows

                $key2 = BankAccountPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = BankAccountPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = BankAccountPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    BankAccountPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (BankOperation) to the collection in $obj2 (BankAccount)
                $obj2->addBankOperation($obj1);

            } // if joined row is not null

                // Add objects for joined BankPayee rows

                $key3 = BankPayeePeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = BankPayeePeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = BankPayeePeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    BankPayeePeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (BankOperation) to the collection in $obj3 (BankPayee)
                $obj3->addBankOperation($obj1);

            } // if joined row is not null

                // Add objects for joined BankFrequentOperation rows

                $key4 = BankFrequentOperationPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = BankFrequentOperationPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = BankFrequentOperationPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    BankFrequentOperationPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (BankOperation) to the collection in $obj4 (BankFrequentOperation)
                $obj4->addBankOperation($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of BankOperation objects pre-filled with all related objects except BankFrequentOperation.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of BankOperation objects.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptBankFrequentOperation(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BankOperationPeer::DATABASE_NAME);
        }

        BankOperationPeer::addSelectColumns($criteria);
        $startcol2 = BankOperationPeer::NUM_HYDRATE_COLUMNS;

        BankAccountPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + BankAccountPeer::NUM_HYDRATE_COLUMNS;

        BankPayeePeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + BankPayeePeer::NUM_HYDRATE_COLUMNS;

        BankCategoryPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + BankCategoryPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(BankOperationPeer::BANK_ACCOUNT_ID, BankAccountPeer::ID, $join_behavior);

        $criteria->addJoin(BankOperationPeer::BANK_PAYEE_ID, BankPayeePeer::ID, $join_behavior);

        $criteria->addJoin(BankOperationPeer::BANK_CATEGORY_ID, BankCategoryPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BankOperationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BankOperationPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = BankOperationPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BankOperationPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined BankAccount rows

                $key2 = BankAccountPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = BankAccountPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = BankAccountPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    BankAccountPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (BankOperation) to the collection in $obj2 (BankAccount)
                $obj2->addBankOperation($obj1);

            } // if joined row is not null

                // Add objects for joined BankPayee rows

                $key3 = BankPayeePeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = BankPayeePeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = BankPayeePeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    BankPayeePeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (BankOperation) to the collection in $obj3 (BankPayee)
                $obj3->addBankOperation($obj1);

            } // if joined row is not null

                // Add objects for joined BankCategory rows

                $key4 = BankCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = BankCategoryPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = BankCategoryPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    BankCategoryPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (BankOperation) to the collection in $obj4 (BankCategory)
                $obj4->addBankOperation($obj1);

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
        return Propel::getDatabaseMap(BankOperationPeer::DATABASE_NAME)->getTable(BankOperationPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseBankOperationPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseBankOperationPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \Sbh\BankBundle\Model\map\BankOperationTableMap());
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
        return BankOperationPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a BankOperation or Criteria object.
     *
     * @param      mixed $values Criteria or BankOperation object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BankOperationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from BankOperation object
        }

        if ($criteria->containsKey(BankOperationPeer::ID) && $criteria->keyContainsValue(BankOperationPeer::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.BankOperationPeer::ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(BankOperationPeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a BankOperation or Criteria object.
     *
     * @param      mixed $values Criteria or BankOperation object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BankOperationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(BankOperationPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(BankOperationPeer::ID);
            $value = $criteria->remove(BankOperationPeer::ID);
            if ($value) {
                $selectCriteria->add(BankOperationPeer::ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(BankOperationPeer::TABLE_NAME);
            }

        } else { // $values is BankOperation object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(BankOperationPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the bank_operation table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BankOperationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(BankOperationPeer::TABLE_NAME, $con, BankOperationPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BankOperationPeer::clearInstancePool();
            BankOperationPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a BankOperation or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or BankOperation object or primary key or array of primary keys
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
            $con = Propel::getConnection(BankOperationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            BankOperationPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof BankOperation) { // it's a model object
            // invalidate the cache for this single object
            BankOperationPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(BankOperationPeer::DATABASE_NAME);
            $criteria->add(BankOperationPeer::ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                BankOperationPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(BankOperationPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            BankOperationPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given BankOperation object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param BankOperation $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(BankOperationPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(BankOperationPeer::TABLE_NAME);

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

        return BasePeer::doValidate(BankOperationPeer::DATABASE_NAME, BankOperationPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return BankOperation
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = BankOperationPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(BankOperationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(BankOperationPeer::DATABASE_NAME);
        $criteria->add(BankOperationPeer::ID, $pk);

        $v = BankOperationPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return BankOperation[]
     * @throws PropelException Any exceptions caught during processing will be
     *     rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BankOperationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(BankOperationPeer::DATABASE_NAME);
            $criteria->add(BankOperationPeer::ID, $pks, Criteria::IN);
            $objs = BankOperationPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

}

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseBankOperationPeer::buildTableMap();

