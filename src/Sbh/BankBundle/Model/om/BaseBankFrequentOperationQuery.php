<?php

namespace Sbh\BankBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Sbh\BankBundle\Model\BankAccount;
use Sbh\BankBundle\Model\BankCategory;
use Sbh\BankBundle\Model\BankFrequentOperation;
use Sbh\BankBundle\Model\BankFrequentOperationPeer;
use Sbh\BankBundle\Model\BankFrequentOperationQuery;
use Sbh\BankBundle\Model\BankOperation;
use Sbh\BankBundle\Model\BankPayee;

/**
 * @method BankFrequentOperationQuery orderByBankAccountId($order = Criteria::ASC) Order by the bank_account_id column
 * @method BankFrequentOperationQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method BankFrequentOperationQuery orderByDate($order = Criteria::ASC) Order by the date column
 * @method BankFrequentOperationQuery orderByBankPayeeId($order = Criteria::ASC) Order by the bank_payee_id column
 * @method BankFrequentOperationQuery orderByBankCategoryId($order = Criteria::ASC) Order by the bank_category_id column
 * @method BankFrequentOperationQuery orderByPayment($order = Criteria::ASC) Order by the payment column
 * @method BankFrequentOperationQuery orderByDeposit($order = Criteria::ASC) Order by the deposit column
 * @method BankFrequentOperationQuery orderById($order = Criteria::ASC) Order by the id column
 * @method BankFrequentOperationQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method BankFrequentOperationQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method BankFrequentOperationQuery groupByBankAccountId() Group by the bank_account_id column
 * @method BankFrequentOperationQuery groupByName() Group by the name column
 * @method BankFrequentOperationQuery groupByDate() Group by the date column
 * @method BankFrequentOperationQuery groupByBankPayeeId() Group by the bank_payee_id column
 * @method BankFrequentOperationQuery groupByBankCategoryId() Group by the bank_category_id column
 * @method BankFrequentOperationQuery groupByPayment() Group by the payment column
 * @method BankFrequentOperationQuery groupByDeposit() Group by the deposit column
 * @method BankFrequentOperationQuery groupById() Group by the id column
 * @method BankFrequentOperationQuery groupByCreatedAt() Group by the created_at column
 * @method BankFrequentOperationQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method BankFrequentOperationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method BankFrequentOperationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method BankFrequentOperationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method BankFrequentOperationQuery leftJoinBankAccount($relationAlias = null) Adds a LEFT JOIN clause to the query using the BankAccount relation
 * @method BankFrequentOperationQuery rightJoinBankAccount($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BankAccount relation
 * @method BankFrequentOperationQuery innerJoinBankAccount($relationAlias = null) Adds a INNER JOIN clause to the query using the BankAccount relation
 *
 * @method BankFrequentOperationQuery leftJoinBankPayee($relationAlias = null) Adds a LEFT JOIN clause to the query using the BankPayee relation
 * @method BankFrequentOperationQuery rightJoinBankPayee($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BankPayee relation
 * @method BankFrequentOperationQuery innerJoinBankPayee($relationAlias = null) Adds a INNER JOIN clause to the query using the BankPayee relation
 *
 * @method BankFrequentOperationQuery leftJoinBankCategory($relationAlias = null) Adds a LEFT JOIN clause to the query using the BankCategory relation
 * @method BankFrequentOperationQuery rightJoinBankCategory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BankCategory relation
 * @method BankFrequentOperationQuery innerJoinBankCategory($relationAlias = null) Adds a INNER JOIN clause to the query using the BankCategory relation
 *
 * @method BankFrequentOperationQuery leftJoinBankOperation($relationAlias = null) Adds a LEFT JOIN clause to the query using the BankOperation relation
 * @method BankFrequentOperationQuery rightJoinBankOperation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BankOperation relation
 * @method BankFrequentOperationQuery innerJoinBankOperation($relationAlias = null) Adds a INNER JOIN clause to the query using the BankOperation relation
 *
 * @method BankFrequentOperation findOne(PropelPDO $con = null) Return the first BankFrequentOperation matching the query
 * @method BankFrequentOperation findOneOrCreate(PropelPDO $con = null) Return the first BankFrequentOperation matching the query, or a new BankFrequentOperation object populated from the query conditions when no match is found
 *
 * @method BankFrequentOperation findOneByBankAccountId(int $bank_account_id) Return the first BankFrequentOperation filtered by the bank_account_id column
 * @method BankFrequentOperation findOneByName(string $name) Return the first BankFrequentOperation filtered by the name column
 * @method BankFrequentOperation findOneByDate(string $date) Return the first BankFrequentOperation filtered by the date column
 * @method BankFrequentOperation findOneByBankPayeeId(int $bank_payee_id) Return the first BankFrequentOperation filtered by the bank_payee_id column
 * @method BankFrequentOperation findOneByBankCategoryId(int $bank_category_id) Return the first BankFrequentOperation filtered by the bank_category_id column
 * @method BankFrequentOperation findOneByPayment(double $payment) Return the first BankFrequentOperation filtered by the payment column
 * @method BankFrequentOperation findOneByDeposit(double $deposit) Return the first BankFrequentOperation filtered by the deposit column
 * @method BankFrequentOperation findOneByCreatedAt(string $created_at) Return the first BankFrequentOperation filtered by the created_at column
 * @method BankFrequentOperation findOneByUpdatedAt(string $updated_at) Return the first BankFrequentOperation filtered by the updated_at column
 *
 * @method array findByBankAccountId(int $bank_account_id) Return BankFrequentOperation objects filtered by the bank_account_id column
 * @method array findByName(string $name) Return BankFrequentOperation objects filtered by the name column
 * @method array findByDate(string $date) Return BankFrequentOperation objects filtered by the date column
 * @method array findByBankPayeeId(int $bank_payee_id) Return BankFrequentOperation objects filtered by the bank_payee_id column
 * @method array findByBankCategoryId(int $bank_category_id) Return BankFrequentOperation objects filtered by the bank_category_id column
 * @method array findByPayment(double $payment) Return BankFrequentOperation objects filtered by the payment column
 * @method array findByDeposit(double $deposit) Return BankFrequentOperation objects filtered by the deposit column
 * @method array findById(int $id) Return BankFrequentOperation objects filtered by the id column
 * @method array findByCreatedAt(string $created_at) Return BankFrequentOperation objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return BankFrequentOperation objects filtered by the updated_at column
 */
abstract class BaseBankFrequentOperationQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseBankFrequentOperationQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = null, $modelName = null, $modelAlias = null)
    {
        if (null === $dbName) {
            $dbName = 'default';
        }
        if (null === $modelName) {
            $modelName = 'Sbh\\BankBundle\\Model\\BankFrequentOperation';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new BankFrequentOperationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   BankFrequentOperationQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return BankFrequentOperationQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof BankFrequentOperationQuery) {
            return $criteria;
        }
        $query = new BankFrequentOperationQuery(null, null, $modelAlias);

        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   BankFrequentOperation|BankFrequentOperation[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = BankFrequentOperationPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(BankFrequentOperationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 BankFrequentOperation A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 BankFrequentOperation A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `bank_account_id`, `name`, `date`, `bank_payee_id`, `bank_category_id`, `payment`, `deposit`, `id`, `created_at`, `updated_at` FROM `bank_frequent_operation` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
      $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new BankFrequentOperation();
            $obj->hydrate($row);
            BankFrequentOperationPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return BankFrequentOperation|BankFrequentOperation[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|BankFrequentOperation[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return BankFrequentOperationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BankFrequentOperationPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return BankFrequentOperationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BankFrequentOperationPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the bank_account_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBankAccountId(1234); // WHERE bank_account_id = 1234
     * $query->filterByBankAccountId(array(12, 34)); // WHERE bank_account_id IN (12, 34)
     * $query->filterByBankAccountId(array('min' => 12)); // WHERE bank_account_id >= 12
     * $query->filterByBankAccountId(array('max' => 12)); // WHERE bank_account_id <= 12
     * </code>
     *
     * @see       filterByBankAccount()
     *
     * @param     mixed $bankAccountId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BankFrequentOperationQuery The current query, for fluid interface
     */
    public function filterByBankAccountId($bankAccountId = null, $comparison = null)
    {
        if (is_array($bankAccountId)) {
            $useMinMax = false;
            if (isset($bankAccountId['min'])) {
                $this->addUsingAlias(BankFrequentOperationPeer::BANK_ACCOUNT_ID, $bankAccountId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bankAccountId['max'])) {
                $this->addUsingAlias(BankFrequentOperationPeer::BANK_ACCOUNT_ID, $bankAccountId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BankFrequentOperationPeer::BANK_ACCOUNT_ID, $bankAccountId, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BankFrequentOperationQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BankFrequentOperationPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the date column
     *
     * Example usage:
     * <code>
     * $query->filterByDate('2011-03-14'); // WHERE date = '2011-03-14'
     * $query->filterByDate('now'); // WHERE date = '2011-03-14'
     * $query->filterByDate(array('max' => 'yesterday')); // WHERE date < '2011-03-13'
     * </code>
     *
     * @param     mixed $date The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BankFrequentOperationQuery The current query, for fluid interface
     */
    public function filterByDate($date = null, $comparison = null)
    {
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingAlias(BankFrequentOperationPeer::DATE, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingAlias(BankFrequentOperationPeer::DATE, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BankFrequentOperationPeer::DATE, $date, $comparison);
    }

    /**
     * Filter the query on the bank_payee_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBankPayeeId(1234); // WHERE bank_payee_id = 1234
     * $query->filterByBankPayeeId(array(12, 34)); // WHERE bank_payee_id IN (12, 34)
     * $query->filterByBankPayeeId(array('min' => 12)); // WHERE bank_payee_id >= 12
     * $query->filterByBankPayeeId(array('max' => 12)); // WHERE bank_payee_id <= 12
     * </code>
     *
     * @see       filterByBankPayee()
     *
     * @param     mixed $bankPayeeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BankFrequentOperationQuery The current query, for fluid interface
     */
    public function filterByBankPayeeId($bankPayeeId = null, $comparison = null)
    {
        if (is_array($bankPayeeId)) {
            $useMinMax = false;
            if (isset($bankPayeeId['min'])) {
                $this->addUsingAlias(BankFrequentOperationPeer::BANK_PAYEE_ID, $bankPayeeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bankPayeeId['max'])) {
                $this->addUsingAlias(BankFrequentOperationPeer::BANK_PAYEE_ID, $bankPayeeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BankFrequentOperationPeer::BANK_PAYEE_ID, $bankPayeeId, $comparison);
    }

    /**
     * Filter the query on the bank_category_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBankCategoryId(1234); // WHERE bank_category_id = 1234
     * $query->filterByBankCategoryId(array(12, 34)); // WHERE bank_category_id IN (12, 34)
     * $query->filterByBankCategoryId(array('min' => 12)); // WHERE bank_category_id >= 12
     * $query->filterByBankCategoryId(array('max' => 12)); // WHERE bank_category_id <= 12
     * </code>
     *
     * @see       filterByBankCategory()
     *
     * @param     mixed $bankCategoryId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BankFrequentOperationQuery The current query, for fluid interface
     */
    public function filterByBankCategoryId($bankCategoryId = null, $comparison = null)
    {
        if (is_array($bankCategoryId)) {
            $useMinMax = false;
            if (isset($bankCategoryId['min'])) {
                $this->addUsingAlias(BankFrequentOperationPeer::BANK_CATEGORY_ID, $bankCategoryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bankCategoryId['max'])) {
                $this->addUsingAlias(BankFrequentOperationPeer::BANK_CATEGORY_ID, $bankCategoryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BankFrequentOperationPeer::BANK_CATEGORY_ID, $bankCategoryId, $comparison);
    }

    /**
     * Filter the query on the payment column
     *
     * Example usage:
     * <code>
     * $query->filterByPayment(1234); // WHERE payment = 1234
     * $query->filterByPayment(array(12, 34)); // WHERE payment IN (12, 34)
     * $query->filterByPayment(array('min' => 12)); // WHERE payment >= 12
     * $query->filterByPayment(array('max' => 12)); // WHERE payment <= 12
     * </code>
     *
     * @param     mixed $payment The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BankFrequentOperationQuery The current query, for fluid interface
     */
    public function filterByPayment($payment = null, $comparison = null)
    {
        if (is_array($payment)) {
            $useMinMax = false;
            if (isset($payment['min'])) {
                $this->addUsingAlias(BankFrequentOperationPeer::PAYMENT, $payment['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($payment['max'])) {
                $this->addUsingAlias(BankFrequentOperationPeer::PAYMENT, $payment['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BankFrequentOperationPeer::PAYMENT, $payment, $comparison);
    }

    /**
     * Filter the query on the deposit column
     *
     * Example usage:
     * <code>
     * $query->filterByDeposit(1234); // WHERE deposit = 1234
     * $query->filterByDeposit(array(12, 34)); // WHERE deposit IN (12, 34)
     * $query->filterByDeposit(array('min' => 12)); // WHERE deposit >= 12
     * $query->filterByDeposit(array('max' => 12)); // WHERE deposit <= 12
     * </code>
     *
     * @param     mixed $deposit The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BankFrequentOperationQuery The current query, for fluid interface
     */
    public function filterByDeposit($deposit = null, $comparison = null)
    {
        if (is_array($deposit)) {
            $useMinMax = false;
            if (isset($deposit['min'])) {
                $this->addUsingAlias(BankFrequentOperationPeer::DEPOSIT, $deposit['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($deposit['max'])) {
                $this->addUsingAlias(BankFrequentOperationPeer::DEPOSIT, $deposit['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BankFrequentOperationPeer::DEPOSIT, $deposit, $comparison);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BankFrequentOperationQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(BankFrequentOperationPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(BankFrequentOperationPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BankFrequentOperationPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at < '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BankFrequentOperationQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(BankFrequentOperationPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(BankFrequentOperationPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BankFrequentOperationPeer::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at < '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BankFrequentOperationQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(BankFrequentOperationPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(BankFrequentOperationPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BankFrequentOperationPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related BankAccount object
     *
     * @param   BankAccount|PropelObjectCollection $bankAccount The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BankFrequentOperationQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBankAccount($bankAccount, $comparison = null)
    {
        if ($bankAccount instanceof BankAccount) {
            return $this
                ->addUsingAlias(BankFrequentOperationPeer::BANK_ACCOUNT_ID, $bankAccount->getId(), $comparison);
        } elseif ($bankAccount instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BankFrequentOperationPeer::BANK_ACCOUNT_ID, $bankAccount->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByBankAccount() only accepts arguments of type BankAccount or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BankAccount relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return BankFrequentOperationQuery The current query, for fluid interface
     */
    public function joinBankAccount($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BankAccount');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'BankAccount');
        }

        return $this;
    }

    /**
     * Use the BankAccount relation BankAccount object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Sbh\BankBundle\Model\BankAccountQuery A secondary query class using the current class as primary query
     */
    public function useBankAccountQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinBankAccount($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BankAccount', '\Sbh\BankBundle\Model\BankAccountQuery');
    }

    /**
     * Filter the query by a related BankPayee object
     *
     * @param   BankPayee|PropelObjectCollection $bankPayee The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BankFrequentOperationQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBankPayee($bankPayee, $comparison = null)
    {
        if ($bankPayee instanceof BankPayee) {
            return $this
                ->addUsingAlias(BankFrequentOperationPeer::BANK_PAYEE_ID, $bankPayee->getId(), $comparison);
        } elseif ($bankPayee instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BankFrequentOperationPeer::BANK_PAYEE_ID, $bankPayee->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByBankPayee() only accepts arguments of type BankPayee or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BankPayee relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return BankFrequentOperationQuery The current query, for fluid interface
     */
    public function joinBankPayee($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BankPayee');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'BankPayee');
        }

        return $this;
    }

    /**
     * Use the BankPayee relation BankPayee object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Sbh\BankBundle\Model\BankPayeeQuery A secondary query class using the current class as primary query
     */
    public function useBankPayeeQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinBankPayee($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BankPayee', '\Sbh\BankBundle\Model\BankPayeeQuery');
    }

    /**
     * Filter the query by a related BankCategory object
     *
     * @param   BankCategory|PropelObjectCollection $bankCategory The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BankFrequentOperationQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBankCategory($bankCategory, $comparison = null)
    {
        if ($bankCategory instanceof BankCategory) {
            return $this
                ->addUsingAlias(BankFrequentOperationPeer::BANK_CATEGORY_ID, $bankCategory->getId(), $comparison);
        } elseif ($bankCategory instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BankFrequentOperationPeer::BANK_CATEGORY_ID, $bankCategory->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByBankCategory() only accepts arguments of type BankCategory or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BankCategory relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return BankFrequentOperationQuery The current query, for fluid interface
     */
    public function joinBankCategory($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BankCategory');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'BankCategory');
        }

        return $this;
    }

    /**
     * Use the BankCategory relation BankCategory object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Sbh\BankBundle\Model\BankCategoryQuery A secondary query class using the current class as primary query
     */
    public function useBankCategoryQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinBankCategory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BankCategory', '\Sbh\BankBundle\Model\BankCategoryQuery');
    }

    /**
     * Filter the query by a related BankOperation object
     *
     * @param   BankOperation|PropelObjectCollection $bankOperation  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BankFrequentOperationQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBankOperation($bankOperation, $comparison = null)
    {
        if ($bankOperation instanceof BankOperation) {
            return $this
                ->addUsingAlias(BankFrequentOperationPeer::ID, $bankOperation->getBankFrequentOperationId(), $comparison);
        } elseif ($bankOperation instanceof PropelObjectCollection) {
            return $this
                ->useBankOperationQuery()
                ->filterByPrimaryKeys($bankOperation->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBankOperation() only accepts arguments of type BankOperation or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BankOperation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return BankFrequentOperationQuery The current query, for fluid interface
     */
    public function joinBankOperation($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BankOperation');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'BankOperation');
        }

        return $this;
    }

    /**
     * Use the BankOperation relation BankOperation object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Sbh\BankBundle\Model\BankOperationQuery A secondary query class using the current class as primary query
     */
    public function useBankOperationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinBankOperation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BankOperation', '\Sbh\BankBundle\Model\BankOperationQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   BankFrequentOperation $bankFrequentOperation Object to remove from the list of results
     *
     * @return BankFrequentOperationQuery The current query, for fluid interface
     */
    public function prune($bankFrequentOperation = null)
    {
        if ($bankFrequentOperation) {
            $this->addUsingAlias(BankFrequentOperationPeer::ID, $bankFrequentOperation->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

  // timestampable behavior

  /**
   * Filter by the latest updated
   *
   * @param      int $nbDays Maximum age of the latest update in days
   *
   * @return     BankFrequentOperationQuery The current query, for fluid interface
   */
  public function recentlyUpdated($nbDays = 7)
  {
      return $this->addUsingAlias(BankFrequentOperationPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by update date desc
   *
   * @return     BankFrequentOperationQuery The current query, for fluid interface
   */
  public function lastUpdatedFirst()
  {
      return $this->addDescendingOrderByColumn(BankFrequentOperationPeer::UPDATED_AT);
  }

  /**
   * Order by update date asc
   *
   * @return     BankFrequentOperationQuery The current query, for fluid interface
   */
  public function firstUpdatedFirst()
  {
      return $this->addAscendingOrderByColumn(BankFrequentOperationPeer::UPDATED_AT);
  }

  /**
   * Filter by the latest created
   *
   * @param      int $nbDays Maximum age of in days
   *
   * @return     BankFrequentOperationQuery The current query, for fluid interface
   */
  public function recentlyCreated($nbDays = 7)
  {
      return $this->addUsingAlias(BankFrequentOperationPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by create date desc
   *
   * @return     BankFrequentOperationQuery The current query, for fluid interface
   */
  public function lastCreatedFirst()
  {
      return $this->addDescendingOrderByColumn(BankFrequentOperationPeer::CREATED_AT);
  }

  /**
   * Order by create date asc
   *
   * @return     BankFrequentOperationQuery The current query, for fluid interface
   */
  public function firstCreatedFirst()
  {
      return $this->addAscendingOrderByColumn(BankFrequentOperationPeer::CREATED_AT);
  }
}
