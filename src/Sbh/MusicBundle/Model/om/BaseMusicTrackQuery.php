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
use Sbh\MusicBundle\Model\MusicArtist;
use Sbh\MusicBundle\Model\MusicFile;
use Sbh\MusicBundle\Model\MusicTrack;
use Sbh\MusicBundle\Model\MusicTrackPeer;
use Sbh\MusicBundle\Model\MusicTrackQuery;

/**
 * @method MusicTrackQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method MusicTrackQuery orderByTrack($order = Criteria::ASC) Order by the track column
 * @method MusicTrackQuery orderByDisc($order = Criteria::ASC) Order by the disc column
 * @method MusicTrackQuery orderByArtistId($order = Criteria::ASC) Order by the artist_id column
 * @method MusicTrackQuery orderByAlbumId($order = Criteria::ASC) Order by the album_id column
 * @method MusicTrackQuery orderById($order = Criteria::ASC) Order by the id column
 * @method MusicTrackQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method MusicTrackQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method MusicTrackQuery groupByName() Group by the name column
 * @method MusicTrackQuery groupByTrack() Group by the track column
 * @method MusicTrackQuery groupByDisc() Group by the disc column
 * @method MusicTrackQuery groupByArtistId() Group by the artist_id column
 * @method MusicTrackQuery groupByAlbumId() Group by the album_id column
 * @method MusicTrackQuery groupById() Group by the id column
 * @method MusicTrackQuery groupByCreatedAt() Group by the created_at column
 * @method MusicTrackQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method MusicTrackQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method MusicTrackQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method MusicTrackQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method MusicTrackQuery leftJoinMusicArtist($relationAlias = null) Adds a LEFT JOIN clause to the query using the MusicArtist relation
 * @method MusicTrackQuery rightJoinMusicArtist($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MusicArtist relation
 * @method MusicTrackQuery innerJoinMusicArtist($relationAlias = null) Adds a INNER JOIN clause to the query using the MusicArtist relation
 *
 * @method MusicTrackQuery leftJoinMusicAlbum($relationAlias = null) Adds a LEFT JOIN clause to the query using the MusicAlbum relation
 * @method MusicTrackQuery rightJoinMusicAlbum($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MusicAlbum relation
 * @method MusicTrackQuery innerJoinMusicAlbum($relationAlias = null) Adds a INNER JOIN clause to the query using the MusicAlbum relation
 *
 * @method MusicTrackQuery leftJoinMusicFile($relationAlias = null) Adds a LEFT JOIN clause to the query using the MusicFile relation
 * @method MusicTrackQuery rightJoinMusicFile($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MusicFile relation
 * @method MusicTrackQuery innerJoinMusicFile($relationAlias = null) Adds a INNER JOIN clause to the query using the MusicFile relation
 *
 * @method MusicTrack findOne(PropelPDO $con = null) Return the first MusicTrack matching the query
 * @method MusicTrack findOneOrCreate(PropelPDO $con = null) Return the first MusicTrack matching the query, or a new MusicTrack object populated from the query conditions when no match is found
 *
 * @method MusicTrack findOneByName(string $name) Return the first MusicTrack filtered by the name column
 * @method MusicTrack findOneByTrack(int $track) Return the first MusicTrack filtered by the track column
 * @method MusicTrack findOneByDisc(int $disc) Return the first MusicTrack filtered by the disc column
 * @method MusicTrack findOneByArtistId(int $artist_id) Return the first MusicTrack filtered by the artist_id column
 * @method MusicTrack findOneByAlbumId(int $album_id) Return the first MusicTrack filtered by the album_id column
 * @method MusicTrack findOneByCreatedAt(string $created_at) Return the first MusicTrack filtered by the created_at column
 * @method MusicTrack findOneByUpdatedAt(string $updated_at) Return the first MusicTrack filtered by the updated_at column
 *
 * @method array findByName(string $name) Return MusicTrack objects filtered by the name column
 * @method array findByTrack(int $track) Return MusicTrack objects filtered by the track column
 * @method array findByDisc(int $disc) Return MusicTrack objects filtered by the disc column
 * @method array findByArtistId(int $artist_id) Return MusicTrack objects filtered by the artist_id column
 * @method array findByAlbumId(int $album_id) Return MusicTrack objects filtered by the album_id column
 * @method array findById(int $id) Return MusicTrack objects filtered by the id column
 * @method array findByCreatedAt(string $created_at) Return MusicTrack objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return MusicTrack objects filtered by the updated_at column
 */
abstract class BaseMusicTrackQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseMusicTrackQuery object.
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
            $modelName = 'Sbh\\MusicBundle\\Model\\MusicTrack';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new MusicTrackQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   MusicTrackQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return MusicTrackQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof MusicTrackQuery) {
            return $criteria;
        }
        $query = new MusicTrackQuery(null, null, $modelAlias);

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
     * @return   MusicTrack|MusicTrack[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MusicTrackPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(MusicTrackPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 MusicTrack A model object, or null if the key is not found
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
     * @return                 MusicTrack A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `name`, `track`, `disc`, `artist_id`, `album_id`, `id`, `created_at`, `updated_at` FROM `music_track` WHERE `id` = :p0';
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
            $obj = new MusicTrack();
            $obj->hydrate($row);
            MusicTrackPeer::addInstanceToPool($obj, (string) $key);
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
     * @return MusicTrack|MusicTrack[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|MusicTrack[]|mixed the list of results, formatted by the current formatter
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
     * @return MusicTrackQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MusicTrackPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return MusicTrackQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MusicTrackPeer::ID, $keys, Criteria::IN);
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
     * @return MusicTrackQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MusicTrackPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the track column
     *
     * Example usage:
     * <code>
     * $query->filterByTrack(1234); // WHERE track = 1234
     * $query->filterByTrack(array(12, 34)); // WHERE track IN (12, 34)
     * $query->filterByTrack(array('min' => 12)); // WHERE track >= 12
     * $query->filterByTrack(array('max' => 12)); // WHERE track <= 12
     * </code>
     *
     * @param     mixed $track The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicTrackQuery The current query, for fluid interface
     */
    public function filterByTrack($track = null, $comparison = null)
    {
        if (is_array($track)) {
            $useMinMax = false;
            if (isset($track['min'])) {
                $this->addUsingAlias(MusicTrackPeer::TRACK, $track['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($track['max'])) {
                $this->addUsingAlias(MusicTrackPeer::TRACK, $track['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicTrackPeer::TRACK, $track, $comparison);
    }

    /**
     * Filter the query on the disc column
     *
     * Example usage:
     * <code>
     * $query->filterByDisc(1234); // WHERE disc = 1234
     * $query->filterByDisc(array(12, 34)); // WHERE disc IN (12, 34)
     * $query->filterByDisc(array('min' => 12)); // WHERE disc >= 12
     * $query->filterByDisc(array('max' => 12)); // WHERE disc <= 12
     * </code>
     *
     * @param     mixed $disc The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicTrackQuery The current query, for fluid interface
     */
    public function filterByDisc($disc = null, $comparison = null)
    {
        if (is_array($disc)) {
            $useMinMax = false;
            if (isset($disc['min'])) {
                $this->addUsingAlias(MusicTrackPeer::DISC, $disc['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($disc['max'])) {
                $this->addUsingAlias(MusicTrackPeer::DISC, $disc['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicTrackPeer::DISC, $disc, $comparison);
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
     * @return MusicTrackQuery The current query, for fluid interface
     */
    public function filterByArtistId($artistId = null, $comparison = null)
    {
        if (is_array($artistId)) {
            $useMinMax = false;
            if (isset($artistId['min'])) {
                $this->addUsingAlias(MusicTrackPeer::ARTIST_ID, $artistId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($artistId['max'])) {
                $this->addUsingAlias(MusicTrackPeer::ARTIST_ID, $artistId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicTrackPeer::ARTIST_ID, $artistId, $comparison);
    }

    /**
     * Filter the query on the album_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAlbumId(1234); // WHERE album_id = 1234
     * $query->filterByAlbumId(array(12, 34)); // WHERE album_id IN (12, 34)
     * $query->filterByAlbumId(array('min' => 12)); // WHERE album_id >= 12
     * $query->filterByAlbumId(array('max' => 12)); // WHERE album_id <= 12
     * </code>
     *
     * @see       filterByMusicAlbum()
     *
     * @param     mixed $albumId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicTrackQuery The current query, for fluid interface
     */
    public function filterByAlbumId($albumId = null, $comparison = null)
    {
        if (is_array($albumId)) {
            $useMinMax = false;
            if (isset($albumId['min'])) {
                $this->addUsingAlias(MusicTrackPeer::ALBUM_ID, $albumId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($albumId['max'])) {
                $this->addUsingAlias(MusicTrackPeer::ALBUM_ID, $albumId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicTrackPeer::ALBUM_ID, $albumId, $comparison);
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
     * @return MusicTrackQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MusicTrackPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MusicTrackPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicTrackPeer::ID, $id, $comparison);
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
     * @return MusicTrackQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(MusicTrackPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(MusicTrackPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicTrackPeer::CREATED_AT, $createdAt, $comparison);
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
     * @return MusicTrackQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(MusicTrackPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(MusicTrackPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicTrackPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related MusicArtist object
     *
     * @param   MusicArtist|PropelObjectCollection $musicArtist The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 MusicTrackQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMusicArtist($musicArtist, $comparison = null)
    {
        if ($musicArtist instanceof MusicArtist) {
            return $this
                ->addUsingAlias(MusicTrackPeer::ARTIST_ID, $musicArtist->getId(), $comparison);
        } elseif ($musicArtist instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MusicTrackPeer::ARTIST_ID, $musicArtist->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return MusicTrackQuery The current query, for fluid interface
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
     * Filter the query by a related MusicAlbum object
     *
     * @param   MusicAlbum|PropelObjectCollection $musicAlbum The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 MusicTrackQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMusicAlbum($musicAlbum, $comparison = null)
    {
        if ($musicAlbum instanceof MusicAlbum) {
            return $this
                ->addUsingAlias(MusicTrackPeer::ALBUM_ID, $musicAlbum->getId(), $comparison);
        } elseif ($musicAlbum instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MusicTrackPeer::ALBUM_ID, $musicAlbum->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByMusicAlbum() only accepts arguments of type MusicAlbum or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MusicAlbum relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return MusicTrackQuery The current query, for fluid interface
     */
    public function joinMusicAlbum($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MusicAlbum');

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
            $this->addJoinObject($join, 'MusicAlbum');
        }

        return $this;
    }

    /**
     * Use the MusicAlbum relation MusicAlbum object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Sbh\MusicBundle\Model\MusicAlbumQuery A secondary query class using the current class as primary query
     */
    public function useMusicAlbumQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMusicAlbum($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MusicAlbum', '\Sbh\MusicBundle\Model\MusicAlbumQuery');
    }

    /**
     * Filter the query by a related MusicFile object
     *
     * @param   MusicFile|PropelObjectCollection $musicFile  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 MusicTrackQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMusicFile($musicFile, $comparison = null)
    {
        if ($musicFile instanceof MusicFile) {
            return $this
                ->addUsingAlias(MusicTrackPeer::ID, $musicFile->getTrackId(), $comparison);
        } elseif ($musicFile instanceof PropelObjectCollection) {
            return $this
                ->useMusicFileQuery()
                ->filterByPrimaryKeys($musicFile->getPrimaryKeys())
                ->endUse();
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
     * @return MusicTrackQuery The current query, for fluid interface
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
     * @param   MusicTrack $musicTrack Object to remove from the list of results
     *
     * @return MusicTrackQuery The current query, for fluid interface
     */
    public function prune($musicTrack = null)
    {
        if ($musicTrack) {
            $this->addUsingAlias(MusicTrackPeer::ID, $musicTrack->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

  // timestampable behavior

  /**
   * Filter by the latest updated
   *
   * @param      int $nbDays Maximum age of the latest update in days
   *
   * @return     MusicTrackQuery The current query, for fluid interface
   */
  public function recentlyUpdated($nbDays = 7)
  {
      return $this->addUsingAlias(MusicTrackPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by update date desc
   *
   * @return     MusicTrackQuery The current query, for fluid interface
   */
  public function lastUpdatedFirst()
  {
      return $this->addDescendingOrderByColumn(MusicTrackPeer::UPDATED_AT);
  }

  /**
   * Order by update date asc
   *
   * @return     MusicTrackQuery The current query, for fluid interface
   */
  public function firstUpdatedFirst()
  {
      return $this->addAscendingOrderByColumn(MusicTrackPeer::UPDATED_AT);
  }

  /**
   * Filter by the latest created
   *
   * @param      int $nbDays Maximum age of in days
   *
   * @return     MusicTrackQuery The current query, for fluid interface
   */
  public function recentlyCreated($nbDays = 7)
  {
      return $this->addUsingAlias(MusicTrackPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by create date desc
   *
   * @return     MusicTrackQuery The current query, for fluid interface
   */
  public function lastCreatedFirst()
  {
      return $this->addDescendingOrderByColumn(MusicTrackPeer::CREATED_AT);
  }

  /**
   * Order by create date asc
   *
   * @return     MusicTrackQuery The current query, for fluid interface
   */
  public function firstCreatedFirst()
  {
      return $this->addAscendingOrderByColumn(MusicTrackPeer::CREATED_AT);
  }
}
