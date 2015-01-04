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
use Sbh\MusicBundle\Model\MusicDeezerAlbum;
use Sbh\MusicBundle\Model\MusicDeezerArtist;
use Sbh\MusicBundle\Model\MusicDeezerTrack;
use Sbh\MusicBundle\Model\MusicDeezerTrackPeer;
use Sbh\MusicBundle\Model\MusicDeezerTrackQuery;

/**
 * @method MusicDeezerTrackQuery orderByDeezerId($order = Criteria::ASC) Order by the deezer_id column
 * @method MusicDeezerTrackQuery orderByAlbumDeezerId($order = Criteria::ASC) Order by the album_deezer_id column
 * @method MusicDeezerTrackQuery orderByArtistDeezerId($order = Criteria::ASC) Order by the artist_deezer_id column
 * @method MusicDeezerTrackQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method MusicDeezerTrackQuery orderByReadable($order = Criteria::ASC) Order by the readable column
 * @method MusicDeezerTrackQuery orderByDuration($order = Criteria::ASC) Order by the duration column
 * @method MusicDeezerTrackQuery orderByRank($order = Criteria::ASC) Order by the rank column
 * @method MusicDeezerTrackQuery orderByExplicitLyrics($order = Criteria::ASC) Order by the explicit_lyrics column
 * @method MusicDeezerTrackQuery orderByPreviewLink($order = Criteria::ASC) Order by the preview_link column
 * @method MusicDeezerTrackQuery orderById($order = Criteria::ASC) Order by the id column
 * @method MusicDeezerTrackQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method MusicDeezerTrackQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method MusicDeezerTrackQuery groupByDeezerId() Group by the deezer_id column
 * @method MusicDeezerTrackQuery groupByAlbumDeezerId() Group by the album_deezer_id column
 * @method MusicDeezerTrackQuery groupByArtistDeezerId() Group by the artist_deezer_id column
 * @method MusicDeezerTrackQuery groupByName() Group by the name column
 * @method MusicDeezerTrackQuery groupByReadable() Group by the readable column
 * @method MusicDeezerTrackQuery groupByDuration() Group by the duration column
 * @method MusicDeezerTrackQuery groupByRank() Group by the rank column
 * @method MusicDeezerTrackQuery groupByExplicitLyrics() Group by the explicit_lyrics column
 * @method MusicDeezerTrackQuery groupByPreviewLink() Group by the preview_link column
 * @method MusicDeezerTrackQuery groupById() Group by the id column
 * @method MusicDeezerTrackQuery groupByCreatedAt() Group by the created_at column
 * @method MusicDeezerTrackQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method MusicDeezerTrackQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method MusicDeezerTrackQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method MusicDeezerTrackQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method MusicDeezerTrackQuery leftJoinMusicDeezerAlbum($relationAlias = null) Adds a LEFT JOIN clause to the query using the MusicDeezerAlbum relation
 * @method MusicDeezerTrackQuery rightJoinMusicDeezerAlbum($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MusicDeezerAlbum relation
 * @method MusicDeezerTrackQuery innerJoinMusicDeezerAlbum($relationAlias = null) Adds a INNER JOIN clause to the query using the MusicDeezerAlbum relation
 *
 * @method MusicDeezerTrackQuery leftJoinMusicDeezerArtist($relationAlias = null) Adds a LEFT JOIN clause to the query using the MusicDeezerArtist relation
 * @method MusicDeezerTrackQuery rightJoinMusicDeezerArtist($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MusicDeezerArtist relation
 * @method MusicDeezerTrackQuery innerJoinMusicDeezerArtist($relationAlias = null) Adds a INNER JOIN clause to the query using the MusicDeezerArtist relation
 *
 * @method MusicDeezerTrack findOne(PropelPDO $con = null) Return the first MusicDeezerTrack matching the query
 * @method MusicDeezerTrack findOneOrCreate(PropelPDO $con = null) Return the first MusicDeezerTrack matching the query, or a new MusicDeezerTrack object populated from the query conditions when no match is found
 *
 * @method MusicDeezerTrack findOneByDeezerId(int $deezer_id) Return the first MusicDeezerTrack filtered by the deezer_id column
 * @method MusicDeezerTrack findOneByAlbumDeezerId(int $album_deezer_id) Return the first MusicDeezerTrack filtered by the album_deezer_id column
 * @method MusicDeezerTrack findOneByArtistDeezerId(int $artist_deezer_id) Return the first MusicDeezerTrack filtered by the artist_deezer_id column
 * @method MusicDeezerTrack findOneByName(string $name) Return the first MusicDeezerTrack filtered by the name column
 * @method MusicDeezerTrack findOneByReadable(boolean $readable) Return the first MusicDeezerTrack filtered by the readable column
 * @method MusicDeezerTrack findOneByDuration(int $duration) Return the first MusicDeezerTrack filtered by the duration column
 * @method MusicDeezerTrack findOneByRank(boolean $rank) Return the first MusicDeezerTrack filtered by the rank column
 * @method MusicDeezerTrack findOneByExplicitLyrics(boolean $explicit_lyrics) Return the first MusicDeezerTrack filtered by the explicit_lyrics column
 * @method MusicDeezerTrack findOneByPreviewLink(string $preview_link) Return the first MusicDeezerTrack filtered by the preview_link column
 * @method MusicDeezerTrack findOneByCreatedAt(string $created_at) Return the first MusicDeezerTrack filtered by the created_at column
 * @method MusicDeezerTrack findOneByUpdatedAt(string $updated_at) Return the first MusicDeezerTrack filtered by the updated_at column
 *
 * @method array findByDeezerId(int $deezer_id) Return MusicDeezerTrack objects filtered by the deezer_id column
 * @method array findByAlbumDeezerId(int $album_deezer_id) Return MusicDeezerTrack objects filtered by the album_deezer_id column
 * @method array findByArtistDeezerId(int $artist_deezer_id) Return MusicDeezerTrack objects filtered by the artist_deezer_id column
 * @method array findByName(string $name) Return MusicDeezerTrack objects filtered by the name column
 * @method array findByReadable(boolean $readable) Return MusicDeezerTrack objects filtered by the readable column
 * @method array findByDuration(int $duration) Return MusicDeezerTrack objects filtered by the duration column
 * @method array findByRank(boolean $rank) Return MusicDeezerTrack objects filtered by the rank column
 * @method array findByExplicitLyrics(boolean $explicit_lyrics) Return MusicDeezerTrack objects filtered by the explicit_lyrics column
 * @method array findByPreviewLink(string $preview_link) Return MusicDeezerTrack objects filtered by the preview_link column
 * @method array findById(int $id) Return MusicDeezerTrack objects filtered by the id column
 * @method array findByCreatedAt(string $created_at) Return MusicDeezerTrack objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return MusicDeezerTrack objects filtered by the updated_at column
 */
abstract class BaseMusicDeezerTrackQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseMusicDeezerTrackQuery object.
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
            $modelName = 'Sbh\\MusicBundle\\Model\\MusicDeezerTrack';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new MusicDeezerTrackQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   MusicDeezerTrackQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return MusicDeezerTrackQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof MusicDeezerTrackQuery) {
            return $criteria;
        }
        $query = new MusicDeezerTrackQuery(null, null, $modelAlias);

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
     * @return   MusicDeezerTrack|MusicDeezerTrack[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MusicDeezerTrackPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerTrackPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 MusicDeezerTrack A model object, or null if the key is not found
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
     * @return                 MusicDeezerTrack A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `deezer_id`, `album_deezer_id`, `artist_deezer_id`, `name`, `readable`, `duration`, `rank`, `explicit_lyrics`, `preview_link`, `id`, `created_at`, `updated_at` FROM `music_deezer_track` WHERE `id` = :p0';
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
            $obj = new MusicDeezerTrack();
            $obj->hydrate($row);
            MusicDeezerTrackPeer::addInstanceToPool($obj, (string) $key);
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
     * @return MusicDeezerTrack|MusicDeezerTrack[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|MusicDeezerTrack[]|mixed the list of results, formatted by the current formatter
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
     * @return MusicDeezerTrackQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MusicDeezerTrackPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return MusicDeezerTrackQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MusicDeezerTrackPeer::ID, $keys, Criteria::IN);
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
     * @return MusicDeezerTrackQuery The current query, for fluid interface
     */
    public function filterByDeezerId($deezerId = null, $comparison = null)
    {
        if (is_array($deezerId)) {
            $useMinMax = false;
            if (isset($deezerId['min'])) {
                $this->addUsingAlias(MusicDeezerTrackPeer::DEEZER_ID, $deezerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($deezerId['max'])) {
                $this->addUsingAlias(MusicDeezerTrackPeer::DEEZER_ID, $deezerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicDeezerTrackPeer::DEEZER_ID, $deezerId, $comparison);
    }

    /**
     * Filter the query on the album_deezer_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAlbumDeezerId(1234); // WHERE album_deezer_id = 1234
     * $query->filterByAlbumDeezerId(array(12, 34)); // WHERE album_deezer_id IN (12, 34)
     * $query->filterByAlbumDeezerId(array('min' => 12)); // WHERE album_deezer_id >= 12
     * $query->filterByAlbumDeezerId(array('max' => 12)); // WHERE album_deezer_id <= 12
     * </code>
     *
     * @see       filterByMusicDeezerAlbum()
     *
     * @param     mixed $albumDeezerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicDeezerTrackQuery The current query, for fluid interface
     */
    public function filterByAlbumDeezerId($albumDeezerId = null, $comparison = null)
    {
        if (is_array($albumDeezerId)) {
            $useMinMax = false;
            if (isset($albumDeezerId['min'])) {
                $this->addUsingAlias(MusicDeezerTrackPeer::ALBUM_DEEZER_ID, $albumDeezerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($albumDeezerId['max'])) {
                $this->addUsingAlias(MusicDeezerTrackPeer::ALBUM_DEEZER_ID, $albumDeezerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicDeezerTrackPeer::ALBUM_DEEZER_ID, $albumDeezerId, $comparison);
    }

    /**
     * Filter the query on the artist_deezer_id column
     *
     * Example usage:
     * <code>
     * $query->filterByArtistDeezerId(1234); // WHERE artist_deezer_id = 1234
     * $query->filterByArtistDeezerId(array(12, 34)); // WHERE artist_deezer_id IN (12, 34)
     * $query->filterByArtistDeezerId(array('min' => 12)); // WHERE artist_deezer_id >= 12
     * $query->filterByArtistDeezerId(array('max' => 12)); // WHERE artist_deezer_id <= 12
     * </code>
     *
     * @see       filterByMusicDeezerArtist()
     *
     * @param     mixed $artistDeezerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicDeezerTrackQuery The current query, for fluid interface
     */
    public function filterByArtistDeezerId($artistDeezerId = null, $comparison = null)
    {
        if (is_array($artistDeezerId)) {
            $useMinMax = false;
            if (isset($artistDeezerId['min'])) {
                $this->addUsingAlias(MusicDeezerTrackPeer::ARTIST_DEEZER_ID, $artistDeezerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($artistDeezerId['max'])) {
                $this->addUsingAlias(MusicDeezerTrackPeer::ARTIST_DEEZER_ID, $artistDeezerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicDeezerTrackPeer::ARTIST_DEEZER_ID, $artistDeezerId, $comparison);
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
     * @return MusicDeezerTrackQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MusicDeezerTrackPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the readable column
     *
     * Example usage:
     * <code>
     * $query->filterByReadable(true); // WHERE readable = true
     * $query->filterByReadable('yes'); // WHERE readable = true
     * </code>
     *
     * @param     boolean|string $readable The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicDeezerTrackQuery The current query, for fluid interface
     */
    public function filterByReadable($readable = null, $comparison = null)
    {
        if (is_string($readable)) {
            $readable = in_array(strtolower($readable), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(MusicDeezerTrackPeer::READABLE, $readable, $comparison);
    }

    /**
     * Filter the query on the duration column
     *
     * Example usage:
     * <code>
     * $query->filterByDuration(1234); // WHERE duration = 1234
     * $query->filterByDuration(array(12, 34)); // WHERE duration IN (12, 34)
     * $query->filterByDuration(array('min' => 12)); // WHERE duration >= 12
     * $query->filterByDuration(array('max' => 12)); // WHERE duration <= 12
     * </code>
     *
     * @param     mixed $duration The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicDeezerTrackQuery The current query, for fluid interface
     */
    public function filterByDuration($duration = null, $comparison = null)
    {
        if (is_array($duration)) {
            $useMinMax = false;
            if (isset($duration['min'])) {
                $this->addUsingAlias(MusicDeezerTrackPeer::DURATION, $duration['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($duration['max'])) {
                $this->addUsingAlias(MusicDeezerTrackPeer::DURATION, $duration['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicDeezerTrackPeer::DURATION, $duration, $comparison);
    }

    /**
     * Filter the query on the rank column
     *
     * Example usage:
     * <code>
     * $query->filterByRank(true); // WHERE rank = true
     * $query->filterByRank('yes'); // WHERE rank = true
     * </code>
     *
     * @param     boolean|string $rank The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicDeezerTrackQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_string($rank)) {
            $rank = in_array(strtolower($rank), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(MusicDeezerTrackPeer::RANK, $rank, $comparison);
    }

    /**
     * Filter the query on the explicit_lyrics column
     *
     * Example usage:
     * <code>
     * $query->filterByExplicitLyrics(true); // WHERE explicit_lyrics = true
     * $query->filterByExplicitLyrics('yes'); // WHERE explicit_lyrics = true
     * </code>
     *
     * @param     boolean|string $explicitLyrics The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicDeezerTrackQuery The current query, for fluid interface
     */
    public function filterByExplicitLyrics($explicitLyrics = null, $comparison = null)
    {
        if (is_string($explicitLyrics)) {
            $explicitLyrics = in_array(strtolower($explicitLyrics), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(MusicDeezerTrackPeer::EXPLICIT_LYRICS, $explicitLyrics, $comparison);
    }

    /**
     * Filter the query on the preview_link column
     *
     * Example usage:
     * <code>
     * $query->filterByPreviewLink('fooValue');   // WHERE preview_link = 'fooValue'
     * $query->filterByPreviewLink('%fooValue%'); // WHERE preview_link LIKE '%fooValue%'
     * </code>
     *
     * @param     string $previewLink The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicDeezerTrackQuery The current query, for fluid interface
     */
    public function filterByPreviewLink($previewLink = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($previewLink)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $previewLink)) {
                $previewLink = str_replace('*', '%', $previewLink);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MusicDeezerTrackPeer::PREVIEW_LINK, $previewLink, $comparison);
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
     * @return MusicDeezerTrackQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MusicDeezerTrackPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MusicDeezerTrackPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicDeezerTrackPeer::ID, $id, $comparison);
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
     * @return MusicDeezerTrackQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(MusicDeezerTrackPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(MusicDeezerTrackPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicDeezerTrackPeer::CREATED_AT, $createdAt, $comparison);
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
     * @return MusicDeezerTrackQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(MusicDeezerTrackPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(MusicDeezerTrackPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicDeezerTrackPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related MusicDeezerAlbum object
     *
     * @param   MusicDeezerAlbum|PropelObjectCollection $musicDeezerAlbum The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 MusicDeezerTrackQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMusicDeezerAlbum($musicDeezerAlbum, $comparison = null)
    {
        if ($musicDeezerAlbum instanceof MusicDeezerAlbum) {
            return $this
                ->addUsingAlias(MusicDeezerTrackPeer::ALBUM_DEEZER_ID, $musicDeezerAlbum->getDeezerId(), $comparison);
        } elseif ($musicDeezerAlbum instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MusicDeezerTrackPeer::ALBUM_DEEZER_ID, $musicDeezerAlbum->toKeyValue('PrimaryKey', 'DeezerId'), $comparison);
        } else {
            throw new PropelException('filterByMusicDeezerAlbum() only accepts arguments of type MusicDeezerAlbum or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MusicDeezerAlbum relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return MusicDeezerTrackQuery The current query, for fluid interface
     */
    public function joinMusicDeezerAlbum($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MusicDeezerAlbum');

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
            $this->addJoinObject($join, 'MusicDeezerAlbum');
        }

        return $this;
    }

    /**
     * Use the MusicDeezerAlbum relation MusicDeezerAlbum object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Sbh\MusicBundle\Model\MusicDeezerAlbumQuery A secondary query class using the current class as primary query
     */
    public function useMusicDeezerAlbumQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMusicDeezerAlbum($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MusicDeezerAlbum', '\Sbh\MusicBundle\Model\MusicDeezerAlbumQuery');
    }

    /**
     * Filter the query by a related MusicDeezerArtist object
     *
     * @param   MusicDeezerArtist|PropelObjectCollection $musicDeezerArtist The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 MusicDeezerTrackQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMusicDeezerArtist($musicDeezerArtist, $comparison = null)
    {
        if ($musicDeezerArtist instanceof MusicDeezerArtist) {
            return $this
                ->addUsingAlias(MusicDeezerTrackPeer::ARTIST_DEEZER_ID, $musicDeezerArtist->getDeezerId(), $comparison);
        } elseif ($musicDeezerArtist instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MusicDeezerTrackPeer::ARTIST_DEEZER_ID, $musicDeezerArtist->toKeyValue('PrimaryKey', 'DeezerId'), $comparison);
        } else {
            throw new PropelException('filterByMusicDeezerArtist() only accepts arguments of type MusicDeezerArtist or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MusicDeezerArtist relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return MusicDeezerTrackQuery The current query, for fluid interface
     */
    public function joinMusicDeezerArtist($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MusicDeezerArtist');

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
            $this->addJoinObject($join, 'MusicDeezerArtist');
        }

        return $this;
    }

    /**
     * Use the MusicDeezerArtist relation MusicDeezerArtist object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Sbh\MusicBundle\Model\MusicDeezerArtistQuery A secondary query class using the current class as primary query
     */
    public function useMusicDeezerArtistQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMusicDeezerArtist($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MusicDeezerArtist', '\Sbh\MusicBundle\Model\MusicDeezerArtistQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   MusicDeezerTrack $musicDeezerTrack Object to remove from the list of results
     *
     * @return MusicDeezerTrackQuery The current query, for fluid interface
     */
    public function prune($musicDeezerTrack = null)
    {
        if ($musicDeezerTrack) {
            $this->addUsingAlias(MusicDeezerTrackPeer::ID, $musicDeezerTrack->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

  // timestampable behavior

  /**
   * Filter by the latest updated
   *
   * @param      int $nbDays Maximum age of the latest update in days
   *
   * @return     MusicDeezerTrackQuery The current query, for fluid interface
   */
  public function recentlyUpdated($nbDays = 7)
  {
      return $this->addUsingAlias(MusicDeezerTrackPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by update date desc
   *
   * @return     MusicDeezerTrackQuery The current query, for fluid interface
   */
  public function lastUpdatedFirst()
  {
      return $this->addDescendingOrderByColumn(MusicDeezerTrackPeer::UPDATED_AT);
  }

  /**
   * Order by update date asc
   *
   * @return     MusicDeezerTrackQuery The current query, for fluid interface
   */
  public function firstUpdatedFirst()
  {
      return $this->addAscendingOrderByColumn(MusicDeezerTrackPeer::UPDATED_AT);
  }

  /**
   * Filter by the latest created
   *
   * @param      int $nbDays Maximum age of in days
   *
   * @return     MusicDeezerTrackQuery The current query, for fluid interface
   */
  public function recentlyCreated($nbDays = 7)
  {
      return $this->addUsingAlias(MusicDeezerTrackPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by create date desc
   *
   * @return     MusicDeezerTrackQuery The current query, for fluid interface
   */
  public function lastCreatedFirst()
  {
      return $this->addDescendingOrderByColumn(MusicDeezerTrackPeer::CREATED_AT);
  }

  /**
   * Order by create date asc
   *
   * @return     MusicDeezerTrackQuery The current query, for fluid interface
   */
  public function firstCreatedFirst()
  {
      return $this->addAscendingOrderByColumn(MusicDeezerTrackPeer::CREATED_AT);
  }
}
