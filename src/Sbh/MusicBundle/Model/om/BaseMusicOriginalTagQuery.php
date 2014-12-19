<?php

namespace Sbh\MusicBundle\Model\om;

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
use Sbh\MusicBundle\Model\MusicFile;
use Sbh\MusicBundle\Model\MusicOriginalTag;
use Sbh\MusicBundle\Model\MusicOriginalTagPeer;
use Sbh\MusicBundle\Model\MusicOriginalTagQuery;

/**
 * @method MusicOriginalTagQuery orderByMusicFileId($order = Criteria::ASC) Order by the music_file_id column
 * @method MusicOriginalTagQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method MusicOriginalTagQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method MusicOriginalTagQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method MusicOriginalTagQuery orderById($order = Criteria::ASC) Order by the id column
 * @method MusicOriginalTagQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method MusicOriginalTagQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method MusicOriginalTagQuery groupByMusicFileId() Group by the music_file_id column
 * @method MusicOriginalTagQuery groupByType() Group by the type column
 * @method MusicOriginalTagQuery groupByName() Group by the name column
 * @method MusicOriginalTagQuery groupByValue() Group by the value column
 * @method MusicOriginalTagQuery groupById() Group by the id column
 * @method MusicOriginalTagQuery groupByCreatedAt() Group by the created_at column
 * @method MusicOriginalTagQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method MusicOriginalTagQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method MusicOriginalTagQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method MusicOriginalTagQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method MusicOriginalTagQuery leftJoinMusicFile($relationAlias = null) Adds a LEFT JOIN clause to the query using the MusicFile relation
 * @method MusicOriginalTagQuery rightJoinMusicFile($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MusicFile relation
 * @method MusicOriginalTagQuery innerJoinMusicFile($relationAlias = null) Adds a INNER JOIN clause to the query using the MusicFile relation
 *
 * @method MusicOriginalTag findOne(PropelPDO $con = null) Return the first MusicOriginalTag matching the query
 * @method MusicOriginalTag findOneOrCreate(PropelPDO $con = null) Return the first MusicOriginalTag matching the query, or a new MusicOriginalTag object populated from the query conditions when no match is found
 *
 * @method MusicOriginalTag findOneByMusicFileId(int $music_file_id) Return the first MusicOriginalTag filtered by the music_file_id column
 * @method MusicOriginalTag findOneByType(string $type) Return the first MusicOriginalTag filtered by the type column
 * @method MusicOriginalTag findOneByName(string $name) Return the first MusicOriginalTag filtered by the name column
 * @method MusicOriginalTag findOneByValue(string $value) Return the first MusicOriginalTag filtered by the value column
 * @method MusicOriginalTag findOneByCreatedAt(string $created_at) Return the first MusicOriginalTag filtered by the created_at column
 * @method MusicOriginalTag findOneByUpdatedAt(string $updated_at) Return the first MusicOriginalTag filtered by the updated_at column
 *
 * @method array findByMusicFileId(int $music_file_id) Return MusicOriginalTag objects filtered by the music_file_id column
 * @method array findByType(string $type) Return MusicOriginalTag objects filtered by the type column
 * @method array findByName(string $name) Return MusicOriginalTag objects filtered by the name column
 * @method array findByValue(string $value) Return MusicOriginalTag objects filtered by the value column
 * @method array findById(int $id) Return MusicOriginalTag objects filtered by the id column
 * @method array findByCreatedAt(string $created_at) Return MusicOriginalTag objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return MusicOriginalTag objects filtered by the updated_at column
 */
abstract class BaseMusicOriginalTagQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseMusicOriginalTagQuery object.
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
            $modelName = 'Sbh\\MusicBundle\\Model\\MusicOriginalTag';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new MusicOriginalTagQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   MusicOriginalTagQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return MusicOriginalTagQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof MusicOriginalTagQuery) {
            return $criteria;
        }
        $query = new MusicOriginalTagQuery(null, null, $modelAlias);

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
     * @return   MusicOriginalTag|MusicOriginalTag[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MusicOriginalTagPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(MusicOriginalTagPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 MusicOriginalTag A model object, or null if the key is not found
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
     * @return                 MusicOriginalTag A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `music_file_id`, `type`, `name`, `value`, `id`, `created_at`, `updated_at` FROM `music_original_tag` WHERE `id` = :p0';
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
            $obj = new MusicOriginalTag();
            $obj->hydrate($row);
            MusicOriginalTagPeer::addInstanceToPool($obj, (string) $key);
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
     * @return MusicOriginalTag|MusicOriginalTag[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|MusicOriginalTag[]|mixed the list of results, formatted by the current formatter
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
     * @return MusicOriginalTagQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MusicOriginalTagPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return MusicOriginalTagQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MusicOriginalTagPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the music_file_id column
     *
     * Example usage:
     * <code>
     * $query->filterByMusicFileId(1234); // WHERE music_file_id = 1234
     * $query->filterByMusicFileId(array(12, 34)); // WHERE music_file_id IN (12, 34)
     * $query->filterByMusicFileId(array('min' => 12)); // WHERE music_file_id >= 12
     * $query->filterByMusicFileId(array('max' => 12)); // WHERE music_file_id <= 12
     * </code>
     *
     * @see       filterByMusicFile()
     *
     * @param     mixed $musicFileId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicOriginalTagQuery The current query, for fluid interface
     */
    public function filterByMusicFileId($musicFileId = null, $comparison = null)
    {
        if (is_array($musicFileId)) {
            $useMinMax = false;
            if (isset($musicFileId['min'])) {
                $this->addUsingAlias(MusicOriginalTagPeer::MUSIC_FILE_ID, $musicFileId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($musicFileId['max'])) {
                $this->addUsingAlias(MusicOriginalTagPeer::MUSIC_FILE_ID, $musicFileId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicOriginalTagPeer::MUSIC_FILE_ID, $musicFileId, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue');   // WHERE type = 'fooValue'
     * $query->filterByType('%fooValue%'); // WHERE type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicOriginalTagQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $type)) {
                $type = str_replace('*', '%', $type);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MusicOriginalTagPeer::TYPE, $type, $comparison);
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
     * @return MusicOriginalTagQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MusicOriginalTagPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the value column
     *
     * Example usage:
     * <code>
     * $query->filterByValue('fooValue');   // WHERE value = 'fooValue'
     * $query->filterByValue('%fooValue%'); // WHERE value LIKE '%fooValue%'
     * </code>
     *
     * @param     string $value The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicOriginalTagQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($value)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $value)) {
                $value = str_replace('*', '%', $value);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MusicOriginalTagPeer::VALUE, $value, $comparison);
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
     * @return MusicOriginalTagQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MusicOriginalTagPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MusicOriginalTagPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicOriginalTagPeer::ID, $id, $comparison);
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
     * @return MusicOriginalTagQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(MusicOriginalTagPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(MusicOriginalTagPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicOriginalTagPeer::CREATED_AT, $createdAt, $comparison);
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
     * @return MusicOriginalTagQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(MusicOriginalTagPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(MusicOriginalTagPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicOriginalTagPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related MusicFile object
     *
     * @param   MusicFile|PropelObjectCollection $musicFile The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 MusicOriginalTagQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMusicFile($musicFile, $comparison = null)
    {
        if ($musicFile instanceof MusicFile) {
            return $this
                ->addUsingAlias(MusicOriginalTagPeer::MUSIC_FILE_ID, $musicFile->getId(), $comparison);
        } elseif ($musicFile instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MusicOriginalTagPeer::MUSIC_FILE_ID, $musicFile->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByMusicFile() only accepts arguments of type MusicFile or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MusicFile relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return MusicOriginalTagQuery The current query, for fluid interface
     */
    public function joinMusicFile($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MusicFile');

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
            $this->addJoinObject($join, 'MusicFile');
        }

        return $this;
    }

    /**
     * Use the MusicFile relation MusicFile object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Sbh\MusicBundle\Model\MusicFileQuery A secondary query class using the current class as primary query
     */
    public function useMusicFileQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMusicFile($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MusicFile', '\Sbh\MusicBundle\Model\MusicFileQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   MusicOriginalTag $musicOriginalTag Object to remove from the list of results
     *
     * @return MusicOriginalTagQuery The current query, for fluid interface
     */
    public function prune($musicOriginalTag = null)
    {
        if ($musicOriginalTag) {
            $this->addUsingAlias(MusicOriginalTagPeer::ID, $musicOriginalTag->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

  // timestampable behavior

  /**
   * Filter by the latest updated
   *
   * @param      int $nbDays Maximum age of the latest update in days
   *
   * @return     MusicOriginalTagQuery The current query, for fluid interface
   */
  public function recentlyUpdated($nbDays = 7)
  {
      return $this->addUsingAlias(MusicOriginalTagPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by update date desc
   *
   * @return     MusicOriginalTagQuery The current query, for fluid interface
   */
  public function lastUpdatedFirst()
  {
      return $this->addDescendingOrderByColumn(MusicOriginalTagPeer::UPDATED_AT);
  }

  /**
   * Order by update date asc
   *
   * @return     MusicOriginalTagQuery The current query, for fluid interface
   */
  public function firstUpdatedFirst()
  {
      return $this->addAscendingOrderByColumn(MusicOriginalTagPeer::UPDATED_AT);
  }

  /**
   * Filter by the latest created
   *
   * @param      int $nbDays Maximum age of in days
   *
   * @return     MusicOriginalTagQuery The current query, for fluid interface
   */
  public function recentlyCreated($nbDays = 7)
  {
      return $this->addUsingAlias(MusicOriginalTagPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by create date desc
   *
   * @return     MusicOriginalTagQuery The current query, for fluid interface
   */
  public function lastCreatedFirst()
  {
      return $this->addDescendingOrderByColumn(MusicOriginalTagPeer::CREATED_AT);
  }

  /**
   * Order by create date asc
   *
   * @return     MusicOriginalTagQuery The current query, for fluid interface
   */
  public function firstCreatedFirst()
  {
      return $this->addAscendingOrderByColumn(MusicOriginalTagPeer::CREATED_AT);
  }
}
