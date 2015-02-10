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
use Sbh\BankBundle\Model\BankAgency;
use Sbh\BankBundle\Model\BankAgencyPeer;
use Sbh\BankBundle\Model\BankAgencyQuery;
use Sbh\BankBundle\Model\BankGroup;

/**
 * @method BankAgencyQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method BankAgencyQuery orderByBankGroupId($order = Criteria::ASC) Order by the bank_group_id column
 * @method BankAgencyQuery orderBySlug($order = Criteria::ASC) Order by the slug column
 * @method BankAgencyQuery orderById($order = Criteria::ASC) Order by the id column
 * @method BankAgencyQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method BankAgencyQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method BankAgencyQuery groupByName() Group by the name column
 * @method BankAgencyQuery groupByBankGroupId() Group by the bank_group_id column
 * @method BankAgencyQuery groupBySlug() Group by the slug column
 * @method BankAgencyQuery groupById() Group by the id column
 * @method BankAgencyQuery groupByCreatedAt() Group by the created_at column
 * @method BankAgencyQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method BankAgencyQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method BankAgencyQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method BankAgencyQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method BankAgencyQuery leftJoinBankGroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the BankGroup relation
 * @method BankAgencyQuery rightJoinBankGroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BankGroup relation
 * @method BankAgencyQuery innerJoinBankGroup($relationAlias = null) Adds a INNER JOIN clause to the query using the BankGroup relation
 *
 * @method BankAgencyQuery leftJoinBankAccount($relationAlias = null) Adds a LEFT JOIN clause to the query using the BankAccount relation
 * @method BankAgencyQuery rightJoinBankAccount($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BankAccount relation
 * @method BankAgencyQuery innerJoinBankAccount($relationAlias = null) Adds a INNER JOIN clause to the query using the BankAccount relation
 *
 * @method BankAgency findOne(PropelPDO $con = null) Return the first BankAgency matching the query
 * @method BankAgency findOneOrCreate(PropelPDO $con = null) Return the first BankAgency matching the query, or a new BankAgency object populated from the query conditions when no match is found
 *
 * @method BankAgency findOneByName(string $name) Return the first BankAgency filtered by the name column
 * @method BankAgency findOneByBankGroupId(int $bank_group_id) Return the first BankAgency filtered by the bank_group_id column
 * @method BankAgency findOneBySlug(string $slug) Return the first BankAgency filtered by the slug column
 * @method BankAgency findOneByCreatedAt(string $created_at) Return the first BankAgency filtered by the created_at column
 * @method BankAgency findOneByUpdatedAt(string $updated_at) Return the first BankAgency filtered by the updated_at column
 *
 * @method array findByName(string $name) Return BankAgency objects filtered by the name column
 * @method array findByBankGroupId(int $bank_group_id) Return BankAgency objects filtered by the bank_group_id column
 * @method array findBySlug(string $slug) Return BankAgency objects filtered by the slug column
 * @method array findById(int $id) Return BankAgency objects filtered by the id column
 * @method array findByCreatedAt(string $created_at) Return BankAgency objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return BankAgency objects filtered by the updated_at column
 */
abstract class BaseBankAgencyQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseBankAgencyQuery object.
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
            $modelName = 'Sbh\\BankBundle\\Model\\BankAgency';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new BankAgencyQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   BankAgencyQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return BankAgencyQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof BankAgencyQuery) {
            return $criteria;
        }
        $query = new BankAgencyQuery(null, null, $modelAlias);

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
     * @return   BankAgency|BankAgency[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = BankAgencyPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(BankAgencyPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 BankAgency A model object, or null if the key is not found
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
     * @return                 BankAgency A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `name`, `bank_group_id`, `slug`, `id`, `created_at`, `updated_at` FROM `bank_agency` WHERE `id` = :p0';
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
            $obj = new BankAgency();
            $obj->hydrate($row);
            BankAgencyPeer::addInstanceToPool($obj, (string) $key);
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
     * @return BankAgency|BankAgency[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|BankAgency[]|mixed the list of results, formatted by the current formatter
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
     * @return BankAgencyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BankAgencyPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return BankAgencyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BankAgencyPeer::ID, $keys, Criteria::IN);
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
     * @return BankAgencyQuery The current query, for fluid interface
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

        return $this->addUsingAlias(BankAgencyPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the bank_group_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBankGroupId(1234); // WHERE bank_group_id = 1234
     * $query->filterByBankGroupId(array(12, 34)); // WHERE bank_group_id IN (12, 34)
     * $query->filterByBankGroupId(array('min' => 12)); // WHERE bank_group_id >= 12
     * $query->filterByBankGroupId(array('max' => 12)); // WHERE bank_group_id <= 12
     * </code>
     *
     * @see       filterByBankGroup()
     *
     * @param     mixed $bankGroupId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BankAgencyQuery The current query, for fluid interface
     */
    public function filterByBankGroupId($bankGroupId = null, $comparison = null)
    {
        if (is_array($bankGroupId)) {
            $useMinMax = false;
            if (isset($bankGroupId['min'])) {
                $this->addUsingAlias(BankAgencyPeer::BANK_GROUP_ID, $bankGroupId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bankGroupId['max'])) {
                $this->addUsingAlias(BankAgencyPeer::BANK_GROUP_ID, $bankGroupId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BankAgencyPeer::BANK_GROUP_ID, $bankGroupId, $comparison);
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
     * @return BankAgencyQuery The current query, for fluid interface
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

        return $this->addUsingAlias(BankAgencyPeer::SLUG, $slug, $comparison);
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
     * @return BankAgencyQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(BankAgencyPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(BankAgencyPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BankAgencyPeer::ID, $id, $comparison);
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
     * @return BankAgencyQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(BankAgencyPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(BankAgencyPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BankAgencyPeer::CREATED_AT, $createdAt, $comparison);
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
     * @return BankAgencyQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(BankAgencyPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(BankAgencyPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BankAgencyPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related BankGroup object
     *
     * @param   BankGroup|PropelObjectCollection $bankGroup The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BankAgencyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBankGroup($bankGroup, $comparison = null)
    {
        if ($bankGroup instanceof BankGroup) {
            return $this
                ->addUsingAlias(BankAgencyPeer::BANK_GROUP_ID, $bankGroup->getId(), $comparison);
        } elseif ($bankGroup instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BankAgencyPeer::BANK_GROUP_ID, $bankGroup->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByBankGroup() only accepts arguments of type BankGroup or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BankGroup relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return BankAgencyQuery The current query, for fluid interface
     */
    public function joinBankGroup($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BankGroup');

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
            $this->addJoinObject($join, 'BankGroup');
        }

        return $this;
    }

    /**
     * Use the BankGroup relation BankGroup object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Sbh\BankBundle\Model\BankGroupQuery A secondary query class using the current class as primary query
     */
    public function useBankGroupQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinBankGroup($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BankGroup', '\Sbh\BankBundle\Model\BankGroupQuery');
    }

    /**
     * Filter the query by a related BankAccount object
     *
     * @param   BankAccount|PropelObjectCollection $bankAccount  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BankAgencyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBankAccount($bankAccount, $comparison = null)
    {
        if ($bankAccount instanceof BankAccount) {
            return $this
                ->addUsingAlias(BankAgencyPeer::ID, $bankAccount->getBankAgencyId(), $comparison);
        } elseif ($bankAccount instanceof PropelObjectCollection) {
            return $this
                ->useBankAccountQuery()
                ->filterByPrimaryKeys($bankAccount->getPrimaryKeys())
                ->endUse();
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
     * @return BankAgencyQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   BankAgency $bankAgency Object to remove from the list of results
     *
     * @return BankAgencyQuery The current query, for fluid interface
     */
    public function prune($bankAgency = null)
    {
        if ($bankAgency) {
            $this->addUsingAlias(BankAgencyPeer::ID, $bankAgency->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

  // timestampable behavior

  /**
   * Filter by the latest updated
   *
   * @param      int $nbDays Maximum age of the latest update in days
   *
   * @return     BankAgencyQuery The current query, for fluid interface
   */
  public function recentlyUpdated($nbDays = 7)
  {
      return $this->addUsingAlias(BankAgencyPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by update date desc
   *
   * @return     BankAgencyQuery The current query, for fluid interface
   */
  public function lastUpdatedFirst()
  {
      return $this->addDescendingOrderByColumn(BankAgencyPeer::UPDATED_AT);
  }

  /**
   * Order by update date asc
   *
   * @return     BankAgencyQuery The current query, for fluid interface
   */
  public function firstUpdatedFirst()
  {
      return $this->addAscendingOrderByColumn(BankAgencyPeer::UPDATED_AT);
  }

  /**
   * Filter by the latest created
   *
   * @param      int $nbDays Maximum age of in days
   *
   * @return     BankAgencyQuery The current query, for fluid interface
   */
  public function recentlyCreated($nbDays = 7)
  {
      return $this->addUsingAlias(BankAgencyPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by create date desc
   *
   * @return     BankAgencyQuery The current query, for fluid interface
   */
  public function lastCreatedFirst()
  {
      return $this->addDescendingOrderByColumn(BankAgencyPeer::CREATED_AT);
  }

  /**
   * Order by create date asc
   *
   * @return     BankAgencyQuery The current query, for fluid interface
   */
  public function firstCreatedFirst()
  {
      return $this->addAscendingOrderByColumn(BankAgencyPeer::CREATED_AT);
  }
}
