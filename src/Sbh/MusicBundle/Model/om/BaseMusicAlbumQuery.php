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
use Sbh\MusicBundle\Model\MusicAlbum;
use Sbh\MusicBundle\Model\MusicAlbumPeer;
use Sbh\MusicBundle\Model\MusicAlbumQuery;
use Sbh\MusicBundle\Model\MusicArtist;
use Sbh\MusicBundle\Model\MusicTrack;

/**
 * @method MusicAlbumQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method MusicAlbumQuery orderByArtistId($order = Criteria::ASC) Order by the artist_id column
 * @method MusicAlbumQuery orderByAlias($order = Criteria::ASC) Order by the alias column
 * @method MusicAlbumQuery orderById($order = Criteria::ASC) Order by the id column
 * @method MusicAlbumQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method MusicAlbumQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method MusicAlbumQuery groupByName() Group by the name column
 * @method MusicAlbumQuery groupByArtistId() Group by the artist_id column
 * @method MusicAlbumQuery groupByAlias() Group by the alias column
 * @method MusicAlbumQuery groupById() Group by the id column
 * @method MusicAlbumQuery groupByCreatedAt() Group by the created_at column
 * @method MusicAlbumQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method MusicAlbumQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method MusicAlbumQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method MusicAlbumQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method MusicAlbumQuery leftJoinMusicArtist($relationAlias = null) Adds a LEFT JOIN clause to the query using the MusicArtist relation
 * @method MusicAlbumQuery rightJoinMusicArtist($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MusicArtist relation
 * @method MusicAlbumQuery innerJoinMusicArtist($relationAlias = null) Adds a INNER JOIN clause to the query using the MusicArtist relation
 *
 * @method MusicAlbumQuery leftJoinMusicTrack($relationAlias = null) Adds a LEFT JOIN clause to the query using the MusicTrack relation
 * @method MusicAlbumQuery rightJoinMusicTrack($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MusicTrack relation
 * @method MusicAlbumQuery innerJoinMusicTrack($relationAlias = null) Adds a INNER JOIN clause to the query using the MusicTrack relation
 *
 * @method MusicAlbum findOne(PropelPDO $con = null) Return the first MusicAlbum matching the query
 * @method MusicAlbum findOneOrCreate(PropelPDO $con = null) Return the first MusicAlbum matching the query, or a new MusicAlbum object populated from the query conditions when no match is found
 *
 * @method MusicAlbum findOneByName(string $name) Return the first MusicAlbum filtered by the name column
 * @method MusicAlbum findOneByArtistId(int $artist_id) Return the first MusicAlbum filtered by the artist_id column
 * @method MusicAlbum findOneByAlias(int $alias) Return the first MusicAlbum filtered by the alias column
 * @method MusicAlbum findOneByCreatedAt(string $created_at) Return the first MusicAlbum filtered by the created_at column
 * @method MusicAlbum findOneByUpdatedAt(string $updated_at) Return the first MusicAlbum filtered by the updated_at column
 *
 * @method array findByName(string $name) Return MusicAlbum objects filtered by the name column
 * @method array findByArtistId(int $artist_id) Return MusicAlbum objects filtered by the artist_id column
 * @method array findByAlias(int $alias) Return MusicAlbum objects filtered by the alias column
 * @method array findById(int $id) Return MusicAlbum objects filtered by the id column
 * @method array findByCreatedAt(string $created_at) Return MusicAlbum objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return MusicAlbum objects filtered by the updated_at column
 */
abstract class BaseMusicAlbumQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseMusicAlbumQuery object.
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
            $modelName = 'Sbh\\MusicBundle\\Model\\MusicAlbum';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new MusicAlbumQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   MusicAlbumQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return MusicAlbumQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof MusicAlbumQuery) {
            return $criteria;
        }
        $query = new MusicAlbumQuery(null, null, $modelAlias);

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
     * @return   MusicAlbum|MusicAlbum[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MusicAlbumPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(MusicAlbumPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 MusicAlbum A model object, or null if the key is not found
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
     * @return                 MusicAlbum A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `name`, `artist_id`, `alias`, `id`, `created_at`, `updated_at` FROM `music_album` WHERE `id` = :p0';
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
            $obj = new MusicAlbum();
            $obj->hydrate($row);
            MusicAlbumPeer::addInstanceToPool($obj, (string) $key);
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
     * @return MusicAlbum|MusicAlbum[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|MusicAlbum[]|mixed the list of results, formatted by the current formatter
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
     * @return MusicAlbumQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MusicAlbumPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return MusicAlbumQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MusicAlbumPeer::ID, $keys, Criteria::IN);
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
     * @return MusicAlbumQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MusicAlbumPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the artist_id column
     *
     * Example usage:
     * <code>
     * $query->filterByArtistId(1234); // WHERE artist_id = 1234
     * $query->filterByArtistId(array(12, 34)); // WHERE artist_id IN (12, 34)
     * $query->filterByArtistId(array('min' => 12)); // WHERE artist_id >= 12
     * $query->filterByArtistId(array('max' => 12)); // WHERE artist_id <= 12
     * </code>
     *
     * @see       filterByMusicArtist()
     *
     * @param     mixed $artistId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicAlbumQuery The current query, for fluid interface
     */
    public function filterByArtistId($artistId = null, $comparison = null)
    {
        if (is_array($artistId)) {
            $useMinMax = false;
            if (isset($artistId['min'])) {
                $this->addUsingAlias(MusicAlbumPeer::ARTIST_ID, $artistId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($artistId['max'])) {
                $this->addUsingAlias(MusicAlbumPeer::ARTIST_ID, $artistId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicAlbumPeer::ARTIST_ID, $artistId, $comparison);
    }

    /**
     * Filter the query on the alias column
     *
     * Example usage:
     * <code>
     * $query->filterByAlias(1234); // WHERE alias = 1234
     * $query->filterByAlias(array(12, 34)); // WHERE alias IN (12, 34)
     * $query->filterByAlias(array('min' => 12)); // WHERE alias >= 12
     * $query->filterByAlias(array('max' => 12)); // WHERE alias <= 12
     * </code>
     *
     * @param     mixed $alias The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicAlbumQuery The current query, for fluid interface
     */
    public function filterByAlias($alias = null, $comparison = null)
    {
        if (is_array($alias)) {
            $useMinMax = false;
            if (isset($alias['min'])) {
                $this->addUsingAlias(MusicAlbumPeer::ALIAS, $alias['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($alias['max'])) {
                $this->addUsingAlias(MusicAlbumPeer::ALIAS, $alias['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicAlbumPeer::ALIAS, $alias, $comparison);
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
     * @return MusicAlbumQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MusicAlbumPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MusicAlbumPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicAlbumPeer::ID, $id, $comparison);
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
     * @return MusicAlbumQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(MusicAlbumPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(MusicAlbumPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicAlbumPeer::CREATED_AT, $createdAt, $comparison);
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
     * @return MusicAlbumQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(MusicAlbumPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(MusicAlbumPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicAlbumPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related MusicArtist object
     *
     * @param   MusicArtist|PropelObjectCollection $musicArtist The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 MusicAlbumQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMusicArtist($musicArtist, $comparison = null)
    {
        if ($musicArtist instanceof MusicArtist) {
            return $this
                ->addUsingAlias(MusicAlbumPeer::ARTIST_ID, $musicArtist->getId(), $comparison);
        } elseif ($musicArtist instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MusicAlbumPeer::ARTIST_ID, $musicArtist->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByMusicArtist() only accepts arguments of type MusicArtist or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MusicArtist relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return MusicAlbumQuery The current query, for fluid interface
     */
    public function joinMusicArtist($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MusicArtist');

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
            $this->addJoinObject($join, 'MusicArtist');
        }

        return $this;
    }

    /**
     * Use the MusicArtist relation MusicArtist object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Sbh\MusicBundle\Model\MusicArtistQuery A secondary query class using the current class as primary query
     */
    public function useMusicArtistQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMusicArtist($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MusicArtist', '\Sbh\MusicBundle\Model\MusicArtistQuery');
    }

    /**
     * Filter the query by a related MusicTrack object
     *
     * @param   MusicTrack|PropelObjectCollection $musicTrack  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 MusicAlbumQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMusicTrack($musicTrack, $comparison = null)
    {
        if ($musicTrack instanceof MusicTrack) {
            return $this
                ->addUsingAlias(MusicAlbumPeer::ID, $musicTrack->getAlbumId(), $comparison);
        } elseif ($musicTrack instanceof PropelObjectCollection) {
            return $this
                ->useMusicTrackQuery()
                ->filterByPrimaryKeys($musicTrack->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMusicTrack() only accepts arguments of type MusicTrack or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MusicTrack relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return MusicAlbumQuery The current query, for fluid interface
     */
    public function joinMusicTrack($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MusicTrack');

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
            $this->addJoinObject($join, 'MusicTrack');
        }

        return $this;
    }

    /**
     * Use the MusicTrack relation MusicTrack object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Sbh\MusicBundle\Model\MusicTrackQuery A secondary query class using the current class as primary query
     */
    public function useMusicTrackQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMusicTrack($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MusicTrack', '\Sbh\MusicBundle\Model\MusicTrackQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   MusicAlbum $musicAlbum Object to remove from the list of results
     *
     * @return MusicAlbumQuery The current query, for fluid interface
     */
    public function prune($musicAlbum = null)
    {
        if ($musicAlbum) {
            $this->addUsingAlias(MusicAlbumPeer::ID, $musicAlbum->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

  // timestampable behavior

  /**
   * Filter by the latest updated
   *
   * @param      int $nbDays Maximum age of the latest update in days
   *
   * @return     MusicAlbumQuery The current query, for fluid interface
   */
  public function recentlyUpdated($nbDays = 7)
  {
      return $this->addUsingAlias(MusicAlbumPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by update date desc
   *
   * @return     MusicAlbumQuery The current query, for fluid interface
   */
  public function lastUpdatedFirst()
  {
      return $this->addDescendingOrderByColumn(MusicAlbumPeer::UPDATED_AT);
  }

  /**
   * Order by update date asc
   *
   * @return     MusicAlbumQuery The current query, for fluid interface
   */
  public function firstUpdatedFirst()
  {
      return $this->addAscendingOrderByColumn(MusicAlbumPeer::UPDATED_AT);
  }

  /**
   * Filter by the latest created
   *
   * @param      int $nbDays Maximum age of in days
   *
   * @return     MusicAlbumQuery The current query, for fluid interface
   */
  public function recentlyCreated($nbDays = 7)
  {
      return $this->addUsingAlias(MusicAlbumPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by create date desc
   *
   * @return     MusicAlbumQuery The current query, for fluid interface
   */
  public function lastCreatedFirst()
  {
      return $this->addDescendingOrderByColumn(MusicAlbumPeer::CREATED_AT);
  }

  /**
   * Order by create date asc
   *
   * @return     MusicAlbumQuery The current query, for fluid interface
   */
  public function firstCreatedFirst()
  {
      return $this->addAscendingOrderByColumn(MusicAlbumPeer::CREATED_AT);
  }
}
