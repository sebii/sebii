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
use Sbh\BankBundle\Model\BankAccountPeer;
use Sbh\BankBundle\Model\BankAccountQuery;
use Sbh\BankBundle\Model\BankAgency;
use Sbh\BankBundle\Model\BankFrequentOperation;
use Sbh\BankBundle\Model\BankOperation;

/**
 * @method BankAccountQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method BankAccountQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method BankAccountQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method BankAccountQuery orderByBankAgencyId($order = Criteria::ASC) Order by the bank_agency_id column
 * @method BankAccountQuery orderBySlug($order = Criteria::ASC) Order by the slug column
 * @method BankAccountQuery orderById($order = Criteria::ASC) Order by the id column
 * @method BankAccountQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method BankAccountQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method BankAccountQuery groupByName() Group by the name column
 * @method BankAccountQuery groupByUserId() Group by the user_id column
 * @method BankAccountQuery groupByType() Group by the type column
 * @method BankAccountQuery groupByBankAgencyId() Group by the bank_agency_id column
 * @method BankAccountQuery groupBySlug() Group by the slug column
 * @method BankAccountQuery groupById() Group by the id column
 * @method BankAccountQuery groupByCreatedAt() Group by the created_at column
 * @method BankAccountQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method BankAccountQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method BankAccountQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method BankAccountQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method BankAccountQuery leftJoinBankAgency($relationAlias = null) Adds a LEFT JOIN clause to the query using the BankAgency relation
 * @method BankAccountQuery rightJoinBankAgency($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BankAgency relation
 * @method BankAccountQuery innerJoinBankAgency($relationAlias = null) Adds a INNER JOIN clause to the query using the BankAgency relation
 *
 * @method BankAccountQuery leftJoinBankFrequentOperation($relationAlias = null) Adds a LEFT JOIN clause to the query using the BankFrequentOperation relation
 * @method BankAccountQuery rightJoinBankFrequentOperation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BankFrequentOperation relation
 * @method BankAccountQuery innerJoinBankFrequentOperation($relationAlias = null) Adds a INNER JOIN clause to the query using the BankFrequentOperation relation
 *
 * @method BankAccountQuery leftJoinBankOperation($relationAlias = null) Adds a LEFT JOIN clause to the query using the BankOperation relation
 * @method BankAccountQuery rightJoinBankOperation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BankOperation relation
 * @method BankAccountQuery innerJoinBankOperation($relationAlias = null) Adds a INNER JOIN clause to the query using the BankOperation relation
 *
 * @method BankAccount findOne(PropelPDO $con = null) Return the first BankAccount matching the query
 * @method BankAccount findOneOrCreate(PropelPDO $con = null) Return the first BankAccount matching the query, or a new BankAccount object populated from the query conditions when no match is found
 *
 * @method BankAccount findOneByName(string $name) Return the first BankAccount filtered by the name column
 * @method BankAccount findOneByUserId(int $user_id) Return the first BankAccount filtered by the user_id column
 * @method BankAccount findOneByType(int $type) Return the first BankAccount filtered by the type column
 * @method BankAccount findOneByBankAgencyId(int $bank_agency_id) Return the first BankAccount filtered by the bank_agency_id column
 * @method BankAccount findOneBySlug(string $slug) Return the first BankAccount filtered by the slug column
 * @method BankAccount findOneByCreatedAt(string $created_at) Return the first BankAccount filtered by the created_at column
 * @method BankAccount findOneByUpdatedAt(string $updated_at) Return the first BankAccount filtered by the updated_at column
 *
 * @method array findByName(string $name) Return BankAccount objects filtered by the name column
 * @method array findByUserId(int $user_id) Return BankAccount objects filtered by the user_id column
 * @method array findByType(int $type) Return BankAccount objects filtered by the type column
 * @method array findByBankAgencyId(int $bank_agency_id) Return BankAccount objects filtered by the bank_agency_id column
 * @method array findBySlug(string $slug) Return BankAccount objects filtered by the slug column
 * @method array findById(int $id) Return BankAccount objects filtered by the id column
 * @method array findByCreatedAt(string $created_at) Return BankAccount objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return BankAccount objects filtered by the updated_at column
 */
abstract class BaseBankAccountQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseBankAccountQuery object.
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
            $modelName = 'Sbh\\BankBundle\\Model\\BankAccount';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new BankAccountQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   BankAccountQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return BankAccountQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof BankAccountQuery) {
            return $criteria;
        }
        $query = new BankAccountQuery(null, null, $modelAlias);

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
     * @return   BankAccount|BankAccount[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = BankAccountPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(BankAccountPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 BankAccount A model object, or null if the key is not found
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
     * @return                 BankAccount A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `name`, `user_id`, `type`, `bank_agency_id`, `slug`, `id`, `created_at`, `updated_at` FROM `bank_account` WHERE `id` = :p0';
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
            $obj = new BankAccount();
            $obj->hydrate($row);
            BankAccountPeer::addInstanceToPool($obj, (string) $key);
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
     * @return BankAccount|BankAccount[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|BankAccount[]|mixed the list of results, formatted by the current formatter
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
     * @return BankAccountQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BankAccountPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return BankAccountQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BankAccountPeer::ID, $keys, Criteria::IN);
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
     * @return BankAccountQuery The current query, for fluid interface
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

        return $this->addUsingAlias(BankAccountPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id >= 12
     * $query->filterByUserId(array('max' => 12)); // WHERE user_id <= 12
     * </code>
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BankAccountQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(BankAccountPeer::USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(BankAccountPeer::USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BankAccountPeer::USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * @param     mixed $type The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BankAccountQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (is_scalar($type)) {
            $type = BankAccountPeer::getSqlValueForEnum(BankAccountPeer::TYPE, $type);
        } elseif (is_array($type)) {
            $convertedValues = array();
            foreach ($type as $value) {
                $convertedValues[] = BankAccountPeer::getSqlValueForEnum(BankAccountPeer::TYPE, $value);
            }
            $type = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BankAccountPeer::TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the bank_agency_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBankAgencyId(1234); // WHERE bank_agency_id = 1234
     * $query->filterByBankAgencyId(array(12, 34)); // WHERE bank_agency_id IN (12, 34)
     * $query->filterByBankAgencyId(array('min' => 12)); // WHERE bank_agency_id >= 12
     * $query->filterByBankAgencyId(array('max' => 12)); // WHERE bank_agency_id <= 12
     * </code>
     *
     * @see       filterByBankAgency()
     *
     * @param     mixed $bankAgencyId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BankAccountQuery The current query, for fluid interface
     */
    public function filterByBankAgencyId($bankAgencyId = null, $comparison = null)
    {
        if (is_array($bankAgencyId)) {
            $useMinMax = false;
            if (isset($bankAgencyId['min'])) {
                $this->addUsingAlias(BankAccountPeer::BANK_AGENCY_ID, $bankAgencyId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bankAgencyId['max'])) {
                $this->addUsingAlias(BankAccountPeer::BANK_AGENCY_ID, $bankAgencyId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BankAccountPeer::BANK_AGENCY_ID, $bankAgencyId, $comparison);
    }

    /**
     * Filter the query on the slug column
     *
     * Example usage:
     * <code>
     * $query->filterBySlug('fooValue');   // WHERE slug = 'fooValue'
     * $query->filterBySlug('%fooValue%'); // WHERE slug LIKE '%fooValue%'
     * </code>
     *
     * @param     string $slug The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BankAccountQuery The current query, for fluid interface
     */
    public function filterBySlug($slug = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($slug)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $slug)) {
                $slug = str_replace('*', '%', $slug);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BankAccountPeer::SLUG, $slug, $comparison);
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
     * @return BankAccountQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(BankAccountPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(BankAccountPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BankAccountPeer::ID, $id, $comparison);
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
     * @return BankAccountQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(BankAccountPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(BankAccountPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BankAccountPeer::CREATED_AT, $createdAt, $comparison);
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
     * @return BankAccountQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(BankAccountPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(BankAccountPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BankAccountPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related BankAgency object
     *
     * @param   BankAgency|PropelObjectCollection $bankAgency The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BankAccountQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBankAgency($bankAgency, $comparison = null)
    {
        if ($bankAgency instanceof BankAgency) {
            return $this
                ->addUsingAlias(BankAccountPeer::BANK_AGENCY_ID, $bankAgency->getId(), $comparison);
        } elseif ($bankAgency instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BankAccountPeer::BANK_AGENCY_ID, $bankAgency->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByBankAgency() only accepts arguments of type BankAgency or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BankAgency relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return BankAccountQuery The current query, for fluid interface
     */
    public function joinBankAgency($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BankAgency');

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
            $this->addJoinObject($join, 'BankAgency');
        }

        return $this;
    }

    /**
     * Use the BankAgency relation BankAgency object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Sbh\BankBundle\Model\BankAgencyQuery A secondary query class using the current class as primary query
     */
    public function useBankAgencyQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinBankAgency($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BankAgency', '\Sbh\BankBundle\Model\BankAgencyQuery');
    }

    /**
     * Filter the query by a related BankFrequentOperation object
     *
     * @param   BankFrequentOperation|PropelObjectCollection $bankFrequentOperation  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BankAccountQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBankFrequentOperation($bankFrequentOperation, $comparison = null)
    {
        if ($bankFrequentOperation instanceof BankFrequentOperation) {
            return $this
                ->addUsingAlias(BankAccountPeer::ID, $bankFrequentOperation->getBankAccountId(), $comparison);
        } elseif ($bankFrequentOperation instanceof PropelObjectCollection) {
            return $this
                ->useBankFrequentOperationQuery()
                ->filterByPrimaryKeys($bankFrequentOperation->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBankFrequentOperation() only accepts arguments of type BankFrequentOperation or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BankFrequentOperation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return BankAccountQuery The current query, for fluid interface
     */
    public function joinBankFrequentOperation($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BankFrequentOperation');

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
            $this->addJoinObject($join, 'BankFrequentOperation');
        }

        return $this;
    }

    /**
     * Use the BankFrequentOperation relation BankFrequentOperation object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Sbh\BankBundle\Model\BankFrequentOperationQuery A secondary query class using the current class as primary query
     */
    public function useBankFrequentOperationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinBankFrequentOperation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BankFrequentOperation', '\Sbh\BankBundle\Model\BankFrequentOperationQuery');
    }

    /**
     * Filter the query by a related BankOperation object
     *
     * @param   BankOperation|PropelObjectCollection $bankOperation  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BankAccountQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBankOperation($bankOperation, $comparison = null)
    {
        if ($bankOperation instanceof BankOperation) {
            return $this
                ->addUsingAlias(BankAccountPeer::ID, $bankOperation->getBankAccountId(), $comparison);
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
     * @return BankAccountQuery The current query, for fluid interface
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
     * @param   BankAccount $bankAccount Object to remove from the list of results
     *
     * @return BankAccountQuery The current query, for fluid interface
     */
    public function prune($bankAccount = null)
    {
        if ($bankAccount) {
            $this->addUsingAlias(BankAccountPeer::ID, $bankAccount->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

  // timestampable behavior

  /**
   * Filter by the latest updated
   *
   * @param      int $nbDays Maximum age of the latest update in days
   *
   * @return     BankAccountQuery The current query, for fluid interface
   */
  public function recentlyUpdated($nbDays = 7)
  {
      return $this->addUsingAlias(BankAccountPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by update date desc
   *
   * @return     BankAccountQuery The current query, for fluid interface
   */
  public function lastUpdatedFirst()
  {
      return $this->addDescendingOrderByColumn(BankAccountPeer::UPDATED_AT);
  }

  /**
   * Order by update date asc
   *
   * @return     BankAccountQuery The current query, for fluid interface
   */
  public function firstUpdatedFirst()
  {
      return $this->addAscendingOrderByColumn(BankAccountPeer::UPDATED_AT);
  }

  /**
   * Filter by the latest created
   *
   * @param      int $nbDays Maximum age of in days
   *
   * @return     BankAccountQuery The current query, for fluid interface
   */
  public function recentlyCreated($nbDays = 7)
  {
      return $this->addUsingAlias(BankAccountPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by create date desc
   *
   * @return     BankAccountQuery The current query, for fluid interface
   */
  public function lastCreatedFirst()
  {
      return $this->addDescendingOrderByColumn(BankAccountPeer::CREATED_AT);
  }

  /**
   * Order by create date asc
   *
   * @return     BankAccountQuery The current query, for fluid interface
   */
  public function firstCreatedFirst()
  {
      return $this->addAscendingOrderByColumn(BankAccountPeer::CREATED_AT);
  }
}
