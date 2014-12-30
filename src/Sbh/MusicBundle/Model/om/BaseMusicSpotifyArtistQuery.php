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
use Sbh\MusicBundle\Model\MusicArtist;
use Sbh\MusicBundle\Model\MusicSpotifyArtist;
use Sbh\MusicBundle\Model\MusicSpotifyArtistPeer;
use Sbh\MusicBundle\Model\MusicSpotifyArtistQuery;

/**
 * @method MusicSpotifyArtistQuery orderBySpotifyId($order = Criteria::ASC) Order by the spotify_id column
 * @method MusicSpotifyArtistQuery orderByArtistId($order = Criteria::ASC) Order by the artist_id column
 * @method MusicSpotifyArtistQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method MusicSpotifyArtistQuery orderByImage($order = Criteria::ASC) Order by the image column
 * @method MusicSpotifyArtistQuery orderByImageId($order = Criteria::ASC) Order by the image_id column
 * @method MusicSpotifyArtistQuery orderByPopularity($order = Criteria::ASC) Order by the popularity column
 * @method MusicSpotifyArtistQuery orderByUri($order = Criteria::ASC) Order by the uri column
 * @method MusicSpotifyArtistQuery orderById($order = Criteria::ASC) Order by the id column
 * @method MusicSpotifyArtistQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method MusicSpotifyArtistQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method MusicSpotifyArtistQuery groupBySpotifyId() Group by the spotify_id column
 * @method MusicSpotifyArtistQuery groupByArtistId() Group by the artist_id column
 * @method MusicSpotifyArtistQuery groupByName() Group by the name column
 * @method MusicSpotifyArtistQuery groupByImage() Group by the image column
 * @method MusicSpotifyArtistQuery groupByImageId() Group by the image_id column
 * @method MusicSpotifyArtistQuery groupByPopularity() Group by the popularity column
 * @method MusicSpotifyArtistQuery groupByUri() Group by the uri column
 * @method MusicSpotifyArtistQuery groupById() Group by the id column
 * @method MusicSpotifyArtistQuery groupByCreatedAt() Group by the created_at column
 * @method MusicSpotifyArtistQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method MusicSpotifyArtistQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method MusicSpotifyArtistQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method MusicSpotifyArtistQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method MusicSpotifyArtistQuery leftJoinMusicArtist($relationAlias = null) Adds a LEFT JOIN clause to the query using the MusicArtist relation
 * @method MusicSpotifyArtistQuery rightJoinMusicArtist($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MusicArtist relation
 * @method MusicSpotifyArtistQuery innerJoinMusicArtist($relationAlias = null) Adds a INNER JOIN clause to the query using the MusicArtist relation
 *
 * @method MusicSpotifyArtist findOne(PropelPDO $con = null) Return the first MusicSpotifyArtist matching the query
 * @method MusicSpotifyArtist findOneOrCreate(PropelPDO $con = null) Return the first MusicSpotifyArtist matching the query, or a new MusicSpotifyArtist object populated from the query conditions when no match is found
 *
 * @method MusicSpotifyArtist findOneBySpotifyId(string $spotify_id) Return the first MusicSpotifyArtist filtered by the spotify_id column
 * @method MusicSpotifyArtist findOneByArtistId(int $artist_id) Return the first MusicSpotifyArtist filtered by the artist_id column
 * @method MusicSpotifyArtist findOneByName(string $name) Return the first MusicSpotifyArtist filtered by the name column
 * @method MusicSpotifyArtist findOneByImage(boolean $image) Return the first MusicSpotifyArtist filtered by the image column
 * @method MusicSpotifyArtist findOneByImageId(string $image_id) Return the first MusicSpotifyArtist filtered by the image_id column
 * @method MusicSpotifyArtist findOneByPopularity(int $popularity) Return the first MusicSpotifyArtist filtered by the popularity column
 * @method MusicSpotifyArtist findOneByUri(string $uri) Return the first MusicSpotifyArtist filtered by the uri column
 * @method MusicSpotifyArtist findOneByCreatedAt(string $created_at) Return the first MusicSpotifyArtist filtered by the created_at column
 * @method MusicSpotifyArtist findOneByUpdatedAt(string $updated_at) Return the first MusicSpotifyArtist filtered by the updated_at column
 *
 * @method array findBySpotifyId(string $spotify_id) Return MusicSpotifyArtist objects filtered by the spotify_id column
 * @method array findByArtistId(int $artist_id) Return MusicSpotifyArtist objects filtered by the artist_id column
 * @method array findByName(string $name) Return MusicSpotifyArtist objects filtered by the name column
 * @method array findByImage(boolean $image) Return MusicSpotifyArtist objects filtered by the image column
 * @method array findByImageId(string $image_id) Return MusicSpotifyArtist objects filtered by the image_id column
 * @method array findByPopularity(int $popularity) Return MusicSpotifyArtist objects filtered by the popularity column
 * @method array findByUri(string $uri) Return MusicSpotifyArtist objects filtered by the uri column
 * @method array findById(int $id) Return MusicSpotifyArtist objects filtered by the id column
 * @method array findByCreatedAt(string $created_at) Return MusicSpotifyArtist objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return MusicSpotifyArtist objects filtered by the updated_at column
 */
abstract class BaseMusicSpotifyArtistQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseMusicSpotifyArtistQuery object.
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
            $modelName = 'Sbh\\MusicBundle\\Model\\MusicSpotifyArtist';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new MusicSpotifyArtistQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   MusicSpotifyArtistQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return MusicSpotifyArtistQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof MusicSpotifyArtistQuery) {
            return $criteria;
        }
        $query = new MusicSpotifyArtistQuery(null, null, $modelAlias);

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
     * @return   MusicSpotifyArtist|MusicSpotifyArtist[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MusicSpotifyArtistPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(MusicSpotifyArtistPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 MusicSpotifyArtist A model object, or null if the key is not found
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
     * @return                 MusicSpotifyArtist A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `spotify_id`, `artist_id`, `name`, `image`, `image_id`, `popularity`, `uri`, `id`, `created_at`, `updated_at` FROM `music_spotify_artist` WHERE `id` = :p0';
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
            $obj = new MusicSpotifyArtist();
            $obj->hydrate($row);
            MusicSpotifyArtistPeer::addInstanceToPool($obj, (string) $key);
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
     * @return MusicSpotifyArtist|MusicSpotifyArtist[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|MusicSpotifyArtist[]|mixed the list of results, formatted by the current formatter
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
     * @return MusicSpotifyArtistQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MusicSpotifyArtistPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return MusicSpotifyArtistQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MusicSpotifyArtistPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the spotify_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySpotifyId('fooValue');   // WHERE spotify_id = 'fooValue'
     * $query->filterBySpotifyId('%fooValue%'); // WHERE spotify_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $spotifyId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicSpotifyArtistQuery The current query, for fluid interface
     */
    public function filterBySpotifyId($spotifyId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($spotifyId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $spotifyId)) {
                $spotifyId = str_replace('*', '%', $spotifyId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MusicSpotifyArtistPeer::SPOTIFY_ID, $spotifyId, $comparison);
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
     * @return MusicSpotifyArtistQuery The current query, for fluid interface
     */
    public function filterByArtistId($artistId = null, $comparison = null)
    {
        if (is_array($artistId)) {
            $useMinMax = false;
            if (isset($artistId['min'])) {
                $this->addUsingAlias(MusicSpotifyArtistPeer::ARTIST_ID, $artistId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($artistId['max'])) {
                $this->addUsingAlias(MusicSpotifyArtistPeer::ARTIST_ID, $artistId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicSpotifyArtistPeer::ARTIST_ID, $artistId, $comparison);
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
     * @return MusicSpotifyArtistQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MusicSpotifyArtistPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the image column
     *
     * Example usage:
     * <code>
     * $query->filterByImage(true); // WHERE image = true
     * $query->filterByImage('yes'); // WHERE image = true
     * </code>
     *
     * @param     boolean|string $image The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicSpotifyArtistQuery The current query, for fluid interface
     */
    public function filterByImage($image = null, $comparison = null)
    {
        if (is_string($image)) {
            $image = in_array(strtolower($image), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(MusicSpotifyArtistPeer::IMAGE, $image, $comparison);
    }

    /**
     * Filter the query on the image_id column
     *
     * Example usage:
     * <code>
     * $query->filterByImageId('fooValue');   // WHERE image_id = 'fooValue'
     * $query->filterByImageId('%fooValue%'); // WHERE image_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $imageId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicSpotifyArtistQuery The current query, for fluid interface
     */
    public function filterByImageId($imageId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($imageId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $imageId)) {
                $imageId = str_replace('*', '%', $imageId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MusicSpotifyArtistPeer::IMAGE_ID, $imageId, $comparison);
    }

    /**
     * Filter the query on the popularity column
     *
     * Example usage:
     * <code>
     * $query->filterByPopularity(1234); // WHERE popularity = 1234
     * $query->filterByPopularity(array(12, 34)); // WHERE popularity IN (12, 34)
     * $query->filterByPopularity(array('min' => 12)); // WHERE popularity >= 12
     * $query->filterByPopularity(array('max' => 12)); // WHERE popularity <= 12
     * </code>
     *
     * @param     mixed $popularity The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicSpotifyArtistQuery The current query, for fluid interface
     */
    public function filterByPopularity($popularity = null, $comparison = null)
    {
        if (is_array($popularity)) {
            $useMinMax = false;
            if (isset($popularity['min'])) {
                $this->addUsingAlias(MusicSpotifyArtistPeer::POPULARITY, $popularity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($popularity['max'])) {
                $this->addUsingAlias(MusicSpotifyArtistPeer::POPULARITY, $popularity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicSpotifyArtistPeer::POPULARITY, $popularity, $comparison);
    }

    /**
     * Filter the query on the uri column
     *
     * Example usage:
     * <code>
     * $query->filterByUri('fooValue');   // WHERE uri = 'fooValue'
     * $query->filterByUri('%fooValue%'); // WHERE uri LIKE '%fooValue%'
     * </code>
     *
     * @param     string $uri The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicSpotifyArtistQuery The current query, for fluid interface
     */
    public function filterByUri($uri = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($uri)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $uri)) {
                $uri = str_replace('*', '%', $uri);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MusicSpotifyArtistPeer::URI, $uri, $comparison);
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
     * @return MusicSpotifyArtistQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MusicSpotifyArtistPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MusicSpotifyArtistPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicSpotifyArtistPeer::ID, $id, $comparison);
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
     * @return MusicSpotifyArtistQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(MusicSpotifyArtistPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(MusicSpotifyArtistPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicSpotifyArtistPeer::CREATED_AT, $createdAt, $comparison);
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
     * @return MusicSpotifyArtistQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(MusicSpotifyArtistPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(MusicSpotifyArtistPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicSpotifyArtistPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related MusicArtist object
     *
     * @param   MusicArtist|PropelObjectCollection $musicArtist The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 MusicSpotifyArtistQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMusicArtist($musicArtist, $comparison = null)
    {
        if ($musicArtist instanceof MusicArtist) {
            return $this
                ->addUsingAlias(MusicSpotifyArtistPeer::ARTIST_ID, $musicArtist->getId(), $comparison);
        } elseif ($musicArtist instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MusicSpotifyArtistPeer::ARTIST_ID, $musicArtist->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return MusicSpotifyArtistQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   MusicSpotifyArtist $musicSpotifyArtist Object to remove from the list of results
     *
     * @return MusicSpotifyArtistQuery The current query, for fluid interface
     */
    public function prune($musicSpotifyArtist = null)
    {
        if ($musicSpotifyArtist) {
            $this->addUsingAlias(MusicSpotifyArtistPeer::ID, $musicSpotifyArtist->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

  // timestampable behavior

  /**
   * Filter by the latest updated
   *
   * @param      int $nbDays Maximum age of the latest update in days
   *
   * @return     MusicSpotifyArtistQuery The current query, for fluid interface
   */
  public function recentlyUpdated($nbDays = 7)
  {
      return $this->addUsingAlias(MusicSpotifyArtistPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by update date desc
   *
   * @return     MusicSpotifyArtistQuery The current query, for fluid interface
   */
  public function lastUpdatedFirst()
  {
      return $this->addDescendingOrderByColumn(MusicSpotifyArtistPeer::UPDATED_AT);
  }

  /**
   * Order by update date asc
   *
   * @return     MusicSpotifyArtistQuery The current query, for fluid interface
   */
  public function firstUpdatedFirst()
  {
      return $this->addAscendingOrderByColumn(MusicSpotifyArtistPeer::UPDATED_AT);
  }

  /**
   * Filter by the latest created
   *
   * @param      int $nbDays Maximum age of in days
   *
   * @return     MusicSpotifyArtistQuery The current query, for fluid interface
   */
  public function recentlyCreated($nbDays = 7)
  {
      return $this->addUsingAlias(MusicSpotifyArtistPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by create date desc
   *
   * @return     MusicSpotifyArtistQuery The current query, for fluid interface
   */
  public function lastCreatedFirst()
  {
      return $this->addDescendingOrderByColumn(MusicSpotifyArtistPeer::CREATED_AT);
  }

  /**
   * Order by create date asc
   *
   * @return     MusicSpotifyArtistQuery The current query, for fluid interface
   */
  public function firstCreatedFirst()
  {
      return $this->addAscendingOrderByColumn(MusicSpotifyArtistPeer::CREATED_AT);
  }
}
