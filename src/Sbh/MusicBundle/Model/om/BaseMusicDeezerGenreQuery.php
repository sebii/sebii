<?php

namespace Sbh\MusicBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \PDO;
use \Propel;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Sbh\MusicBundle\Model\MusicDeezerGenre;
use Sbh\MusicBundle\Model\MusicDeezerGenrePeer;
use Sbh\MusicBundle\Model\MusicDeezerGenreQuery;

/**
 * @method MusicDeezerGenreQuery orderByDeezerId($order = Criteria::ASC) Order by the deezer_id column
 * @method MusicDeezerGenreQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method MusicDeezerGenreQuery orderById($order = Criteria::ASC) Order by the id column
 * @method MusicDeezerGenreQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method MusicDeezerGenreQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method MusicDeezerGenreQuery groupByDeezerId() Group by the deezer_id column
 * @method MusicDeezerGenreQuery groupByName() Group by the name column
 * @method MusicDeezerGenreQuery groupById() Group by the id column
 * @method MusicDeezerGenreQuery groupByCreatedAt() Group by the created_at column
 * @method MusicDeezerGenreQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method MusicDeezerGenreQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method MusicDeezerGenreQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method MusicDeezerGenreQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method MusicDeezerGenre findOne(PropelPDO $con = null) Return the first MusicDeezerGenre matching the query
 * @method MusicDeezerGenre findOneOrCreate(PropelPDO $con = null) Return the first MusicDeezerGenre matching the query, or a new MusicDeezerGenre object populated from the query conditions when no match is found
 *
 * @method MusicDeezerGenre findOneByDeezerId(int $deezer_id) Return the first MusicDeezerGenre filtered by the deezer_id column
 * @method MusicDeezerGenre findOneByName(string $name) Return the first MusicDeezerGenre filtered by the name column
 * @method MusicDeezerGenre findOneByCreatedAt(string $created_at) Return the first MusicDeezerGenre filtered by the created_at column
 * @method MusicDeezerGenre findOneByUpdatedAt(string $updated_at) Return the first MusicDeezerGenre filtered by the updated_at column
 *
 * @method array findByDeezerId(int $deezer_id) Return MusicDeezerGenre objects filtered by the deezer_id column
 * @method array findByName(string $name) Return MusicDeezerGenre objects filtered by the name column
 * @method array findById(int $id) Return MusicDeezerGenre objects filtered by the id column
 * @method array findByCreatedAt(string $created_at) Return MusicDeezerGenre objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return MusicDeezerGenre objects filtered by the updated_at column
 */
abstract class BaseMusicDeezerGenreQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseMusicDeezerGenreQuery object.
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
            $modelName = 'Sbh\\MusicBundle\\Model\\MusicDeezerGenre';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new MusicDeezerGenreQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   MusicDeezerGenreQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return MusicDeezerGenreQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof MusicDeezerGenreQuery) {
            return $criteria;
        }
        $query = new MusicDeezerGenreQuery(null, null, $modelAlias);

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
     * @return   MusicDeezerGenre|MusicDeezerGenre[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MusicDeezerGenrePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerGenrePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 MusicDeezerGenre A model object, or null if the key is not found
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
     * @return                 MusicDeezerGenre A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `deezer_id`, `name`, `id`, `created_at`, `updated_at` FROM `music_deezer_genre` WHERE `id` = :p0';
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
            $obj = new MusicDeezerGenre();
            $obj->hydrate($row);
            MusicDeezerGenrePeer::addInstanceToPool($obj, (string) $key);
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
     * @return MusicDeezerGenre|MusicDeezerGenre[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|MusicDeezerGenre[]|mixed the list of results, formatted by the current formatter
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
     * @return MusicDeezerGenreQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MusicDeezerGenrePeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return MusicDeezerGenreQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MusicDeezerGenrePeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the deezer_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDeezerId(1234); // WHERE deezer_id = 1234
     * $query->filterByDeezerId(array(12, 34)); // WHERE deezer_id IN (12, 34)
     * $query->filterByDeezerId(array('min' => 12)); // WHERE deezer_id >= 12
     * $query->filterByDeezerId(array('max' => 12)); // WHERE deezer_id <= 12
     * </code>
     *
     * @param     mixed $deezerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicDeezerGenreQuery The current query, for fluid interface
     */
    public function filterByDeezerId($deezerId = null, $comparison = null)
    {
        if (is_array($deezerId)) {
            $useMinMax = false;
            if (isset($deezerId['min'])) {
                $this->addUsingAlias(MusicDeezerGenrePeer::DEEZER_ID, $deezerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($deezerId['max'])) {
                $this->addUsingAlias(MusicDeezerGenrePeer::DEEZER_ID, $deezerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicDeezerGenrePeer::DEEZER_ID, $deezerId, $comparison);
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
     * @return MusicDeezerGenreQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MusicDeezerGenrePeer::NAME, $name, $comparison);
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
     * @return MusicDeezerGenreQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MusicDeezerGenrePeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MusicDeezerGenrePeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicDeezerGenrePeer::ID, $id, $comparison);
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
     * @return MusicDeezerGenreQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(MusicDeezerGenrePeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(MusicDeezerGenrePeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicDeezerGenrePeer::CREATED_AT, $createdAt, $comparison);
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
     * @return MusicDeezerGenreQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(MusicDeezerGenrePeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(MusicDeezerGenrePeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicDeezerGenrePeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   MusicDeezerGenre $musicDeezerGenre Object to remove from the list of results
     *
     * @return MusicDeezerGenreQuery The current query, for fluid interface
     */
    public function prune($musicDeezerGenre = null)
    {
        if ($musicDeezerGenre) {
            $this->addUsingAlias(MusicDeezerGenrePeer::ID, $musicDeezerGenre->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

  // timestampable behavior

  /**
   * Filter by the latest updated
   *
   * @param      int $nbDays Maximum age of the latest update in days
   *
   * @return     MusicDeezerGenreQuery The current query, for fluid interface
   */
  public function recentlyUpdated($nbDays = 7)
  {
      return $this->addUsingAlias(MusicDeezerGenrePeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by update date desc
   *
   * @return     MusicDeezerGenreQuery The current query, for fluid interface
   */
  public function lastUpdatedFirst()
  {
      return $this->addDescendingOrderByColumn(MusicDeezerGenrePeer::UPDATED_AT);
  }

  /**
   * Order by update date asc
   *
   * @return     MusicDeezerGenreQuery The current query, for fluid interface
   */
  public function firstUpdatedFirst()
  {
      return $this->addAscendingOrderByColumn(MusicDeezerGenrePeer::UPDATED_AT);
  }

  /**
   * Filter by the latest created
   *
   * @param      int $nbDays Maximum age of in days
   *
   * @return     MusicDeezerGenreQuery The current query, for fluid interface
   */
  public function recentlyCreated($nbDays = 7)
  {
      return $this->addUsingAlias(MusicDeezerGenrePeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by create date desc
   *
   * @return     MusicDeezerGenreQuery The current query, for fluid interface
   */
  public function lastCreatedFirst()
  {
      return $this->addDescendingOrderByColumn(MusicDeezerGenrePeer::CREATED_AT);
  }

  /**
   * Order by create date asc
   *
   * @return     MusicDeezerGenreQuery The current query, for fluid interface
   */
  public function firstCreatedFirst()
  {
      return $this->addAscendingOrderByColumn(MusicDeezerGenrePeer::CREATED_AT);
  }
}
