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
use Sbh\BankBundle\Model\BankCategory;
use Sbh\BankBundle\Model\BankCategoryPeer;
use Sbh\BankBundle\Model\BankCategoryQuery;
use Sbh\BankBundle\Model\BankCategoryRegroupment;
use Sbh\BankBundle\Model\BankFrequentOperation;
use Sbh\BankBundle\Model\BankOperation;

/**
 * @method BankCategoryQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method BankCategoryQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method BankCategoryQuery orderByBankCategoryRegroupmentId($order = Criteria::ASC) Order by the bank_category_regroupment_id column
 * @method BankCategoryQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method BankCategoryQuery orderById($order = Criteria::ASC) Order by the id column
 * @method BankCategoryQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method BankCategoryQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method BankCategoryQuery groupByName() Group by the name column
 * @method BankCategoryQuery groupByUserId() Group by the user_id column
 * @method BankCategoryQuery groupByBankCategoryRegroupmentId() Group by the bank_category_regroupment_id column
 * @method BankCategoryQuery groupByType() Group by the type column
 * @method BankCategoryQuery groupById() Group by the id column
 * @method BankCategoryQuery groupByCreatedAt() Group by the created_at column
 * @method BankCategoryQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method BankCategoryQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method BankCategoryQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method BankCategoryQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method BankCategoryQuery leftJoinBankCategoryRegroupment($relationAlias = null) Adds a LEFT JOIN clause to the query using the BankCategoryRegroupment relation
 * @method BankCategoryQuery rightJoinBankCategoryRegroupment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BankCategoryRegroupment relation
 * @method BankCategoryQuery innerJoinBankCategoryRegroupment($relationAlias = null) Adds a INNER JOIN clause to the query using the BankCategoryRegroupment relation
 *
 * @method BankCategoryQuery leftJoinBankFrequentOperation($relationAlias = null) Adds a LEFT JOIN clause to the query using the BankFrequentOperation relation
 * @method BankCategoryQuery rightJoinBankFrequentOperation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BankFrequentOperation relation
 * @method BankCategoryQuery innerJoinBankFrequentOperation($relationAlias = null) Adds a INNER JOIN clause to the query using the BankFrequentOperation relation
 *
 * @method BankCategoryQuery leftJoinBankOperation($relationAlias = null) Adds a LEFT JOIN clause to the query using the BankOperation relation
 * @method BankCategoryQuery rightJoinBankOperation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BankOperation relation
 * @method BankCategoryQuery innerJoinBankOperation($relationAlias = null) Adds a INNER JOIN clause to the query using the BankOperation relation
 *
 * @method BankCategory findOne(PropelPDO $con = null) Return the first BankCategory matching the query
 * @method BankCategory findOneOrCreate(PropelPDO $con = null) Return the first BankCategory matching the query, or a new BankCategory object populated from the query conditions when no match is found
 *
 * @method BankCategory findOneByName(string $name) Return the first BankCategory filtered by the name column
 * @method BankCategory findOneByUserId(int $user_id) Return the first BankCategory filtered by the user_id column
 * @method BankCategory findOneByBankCategoryRegroupmentId(int $bank_category_regroupment_id) Return the first BankCategory filtered by the bank_category_regroupment_id column
 * @method BankCategory findOneByType(int $type) Return the first BankCategory filtered by the type column
 * @method BankCategory findOneByCreatedAt(string $created_at) Return the first BankCategory filtered by the created_at column
 * @method BankCategory findOneByUpdatedAt(string $updated_at) Return the first BankCategory filtered by the updated_at column
 *
 * @method array findByName(string $name) Return BankCategory objects filtered by the name column
 * @method array findByUserId(int $user_id) Return BankCategory objects filtered by the user_id column
 * @method array findByBankCategoryRegroupmentId(int $bank_category_regroupment_id) Return BankCategory objects filtered by the bank_category_regroupment_id column
 * @method array findByType(int $type) Return BankCategory objects filtered by the type column
 * @method array findById(int $id) Return BankCategory objects filtered by the id column
 * @method array findByCreatedAt(string $created_at) Return BankCategory objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return BankCategory objects filtered by the updated_at column
 */
abstract class BaseBankCategoryQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseBankCategoryQuery object.
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
            $modelName = 'Sbh\\BankBundle\\Model\\BankCategory';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new BankCategoryQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   BankCategoryQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return BankCategoryQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof BankCategoryQuery) {
            return $criteria;
        }
        $query = new BankCategoryQuery(null, null, $modelAlias);

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
     * @return   BankCategory|BankCategory[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = BankCategoryPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(BankCategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 BankCategory A model object, or null if the key is not found
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
     * @return                 BankCategory A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `name`, `user_id`, `bank_category_regroupment_id`, `type`, `id`, `created_at`, `updated_at` FROM `bank_category` WHERE `id` = :p0';
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
            $obj = new BankCategory();
            $obj->hydrate($row);
            BankCategoryPeer::addInstanceToPool($obj, (string) $key);
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
     * @return BankCategory|BankCategory[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|BankCategory[]|mixed the list of results, formatted by the current formatter
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
     * @return BankCategoryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BankCategoryPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return BankCategoryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BankCategoryPeer::ID, $keys, Criteria::IN);
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
     * @return BankCategoryQuery The current query, for fluid interface
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

        return $this->addUsingAlias(BankCategoryPeer::NAME, $name, $comparison);
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
     * @return BankCategoryQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(BankCategoryPeer::USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(BankCategoryPeer::USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BankCategoryPeer::USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the bank_category_regroupment_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBankCategoryRegroupmentId(1234); // WHERE bank_category_regroupment_id = 1234
     * $query->filterByBankCategoryRegroupmentId(array(12, 34)); // WHERE bank_category_regroupment_id IN (12, 34)
     * $query->filterByBankCategoryRegroupmentId(array('min' => 12)); // WHERE bank_category_regroupment_id >= 12
     * $query->filterByBankCategoryRegroupmentId(array('max' => 12)); // WHERE bank_category_regroupment_id <= 12
     * </code>
     *
     * @see       filterByBankCategoryRegroupment()
     *
     * @param     mixed $bankCategoryRegroupmentId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BankCategoryQuery The current query, for fluid interface
     */
    public function filterByBankCategoryRegroupmentId($bankCategoryRegroupmentId = null, $comparison = null)
    {
        if (is_array($bankCategoryRegroupmentId)) {
            $useMinMax = false;
            if (isset($bankCategoryRegroupmentId['min'])) {
                $this->addUsingAlias(BankCategoryPeer::BANK_CATEGORY_REGROUPMENT_ID, $bankCategoryRegroupmentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bankCategoryRegroupmentId['max'])) {
                $this->addUsingAlias(BankCategoryPeer::BANK_CATEGORY_REGROUPMENT_ID, $bankCategoryRegroupmentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BankCategoryPeer::BANK_CATEGORY_REGROUPMENT_ID, $bankCategoryRegroupmentId, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * @param     mixed $type The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BankCategoryQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (is_scalar($type)) {
            $type = BankCategoryPeer::getSqlValueForEnum(BankCategoryPeer::TYPE, $type);
        } elseif (is_array($type)) {
            $convertedValues = array();
            foreach ($type as $value) {
                $convertedValues[] = BankCategoryPeer::getSqlValueForEnum(BankCategoryPeer::TYPE, $value);
            }
            $type = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BankCategoryPeer::TYPE, $type, $comparison);
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
     * @return BankCategoryQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(BankCategoryPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(BankCategoryPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BankCategoryPeer::ID, $id, $comparison);
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
     * @return BankCategoryQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(BankCategoryPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(BankCategoryPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BankCategoryPeer::CREATED_AT, $createdAt, $comparison);
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
     * @return BankCategoryQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(BankCategoryPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(BankCategoryPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BankCategoryPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related BankCategoryRegroupment object
     *
     * @param   BankCategoryRegroupment|PropelObjectCollection $bankCategoryRegroupment The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BankCategoryQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBankCategoryRegroupment($bankCategoryRegroupment, $comparison = null)
    {
        if ($bankCategoryRegroupment instanceof BankCategoryRegroupment) {
            return $this
                ->addUsingAlias(BankCategoryPeer::BANK_CATEGORY_REGROUPMENT_ID, $bankCategoryRegroupment->getId(), $comparison);
        } elseif ($bankCategoryRegroupment instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BankCategoryPeer::BANK_CATEGORY_REGROUPMENT_ID, $bankCategoryRegroupment->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByBankCategoryRegroupment() only accepts arguments of type BankCategoryRegroupment or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BankCategoryRegroupment relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return BankCategoryQuery The current query, for fluid interface
     */
    public function joinBankCategoryRegroupment($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BankCategoryRegroupment');

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
            $this->addJoinObject($join, 'BankCategoryRegroupment');
        }

        return $this;
    }

    /**
     * Use the BankCategoryRegroupment relation BankCategoryRegroupment object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Sbh\BankBundle\Model\BankCategoryRegroupmentQuery A secondary query class using the current class as primary query
     */
    public function useBankCategoryRegroupmentQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinBankCategoryRegroupment($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BankCategoryRegroupment', '\Sbh\BankBundle\Model\BankCategoryRegroupmentQuery');
    }

    /**
     * Filter the query by a related BankFrequentOperation object
     *
     * @param   BankFrequentOperation|PropelObjectCollection $bankFrequentOperation  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BankCategoryQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBankFrequentOperation($bankFrequentOperation, $comparison = null)
    {
        if ($bankFrequentOperation instanceof BankFrequentOperation) {
            return $this
                ->addUsingAlias(BankCategoryPeer::ID, $bankFrequentOperation->getBankCategoryId(), $comparison);
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
     * @return BankCategoryQuery The current query, for fluid interface
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
     * @return                 BankCategoryQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBankOperation($bankOperation, $comparison = null)
    {
        if ($bankOperation instanceof BankOperation) {
            return $this
                ->addUsingAlias(BankCategoryPeer::ID, $bankOperation->getBankCategoryId(), $comparison);
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
     * @return BankCategoryQuery The current query, for fluid interface
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
     * @param   BankCategory $bankCategory Object to remove from the list of results
     *
     * @return BankCategoryQuery The current query, for fluid interface
     */
    public function prune($bankCategory = null)
    {
        if ($bankCategory) {
            $this->addUsingAlias(BankCategoryPeer::ID, $bankCategory->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

  // timestampable behavior

  /**
   * Filter by the latest updated
   *
   * @param      int $nbDays Maximum age of the latest update in days
   *
   * @return     BankCategoryQuery The current query, for fluid interface
   */
  public function recentlyUpdated($nbDays = 7)
  {
      return $this->addUsingAlias(BankCategoryPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by update date desc
   *
   * @return     BankCategoryQuery The current query, for fluid interface
   */
  public function lastUpdatedFirst()
  {
      return $this->addDescendingOrderByColumn(BankCategoryPeer::UPDATED_AT);
  }

  /**
   * Order by update date asc
   *
   * @return     BankCategoryQuery The current query, for fluid interface
   */
  public function firstUpdatedFirst()
  {
      return $this->addAscendingOrderByColumn(BankCategoryPeer::UPDATED_AT);
  }

  /**
   * Filter by the latest created
   *
   * @param      int $nbDays Maximum age of in days
   *
   * @return     BankCategoryQuery The current query, for fluid interface
   */
  public function recentlyCreated($nbDays = 7)
  {
      return $this->addUsingAlias(BankCategoryPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by create date desc
   *
   * @return     BankCategoryQuery The current query, for fluid interface
   */
  public function lastCreatedFirst()
  {
      return $this->addDescendingOrderByColumn(BankCategoryPeer::CREATED_AT);
  }

  /**
   * Order by create date asc
   *
   * @return     BankCategoryQuery The current query, for fluid interface
   */
  public function firstCreatedFirst()
  {
      return $this->addAscendingOrderByColumn(BankCategoryPeer::CREATED_AT);
  }
}
