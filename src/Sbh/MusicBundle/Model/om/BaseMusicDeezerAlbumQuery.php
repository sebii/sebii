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
use Sbh\MusicBundle\Model\MusicDeezerAlbum;
use Sbh\MusicBundle\Model\MusicDeezerAlbumPeer;
use Sbh\MusicBundle\Model\MusicDeezerAlbumQuery;
use Sbh\MusicBundle\Model\MusicDeezerArtist;
use Sbh\MusicBundle\Model\MusicDeezerTrack;

/**
 * @method MusicDeezerAlbumQuery orderByDeezerId($order = Criteria::ASC) Order by the deezer_id column
 * @method MusicDeezerAlbumQuery orderByAlbumId($order = Criteria::ASC) Order by the album_id column
 * @method MusicDeezerAlbumQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method MusicDeezerAlbumQuery orderByArtistDeezerId($order = Criteria::ASC) Order by the artist_deezer_id column
 * @method MusicDeezerAlbumQuery orderByMainGenreDeezerId($order = Criteria::ASC) Order by the main_genre_deezer_id column
 * @method MusicDeezerAlbumQuery orderByGenreDeezerIds($order = Criteria::ASC) Order by the genre_deezer_ids column
 * @method MusicDeezerAlbumQuery orderByRecordType($order = Criteria::ASC) Order by the record_type column
 * @method MusicDeezerAlbumQuery orderByUpc($order = Criteria::ASC) Order by the upc column
 * @method MusicDeezerAlbumQuery orderByLabel($order = Criteria::ASC) Order by the label column
 * @method MusicDeezerAlbumQuery orderByNbTracks($order = Criteria::ASC) Order by the nb_tracks column
 * @method MusicDeezerAlbumQuery orderByDuration($order = Criteria::ASC) Order by the duration column
 * @method MusicDeezerAlbumQuery orderByNbFans($order = Criteria::ASC) Order by the nb_fans column
 * @method MusicDeezerAlbumQuery orderByRating($order = Criteria::ASC) Order by the rating column
 * @method MusicDeezerAlbumQuery orderByReleaseDate($order = Criteria::ASC) Order by the release_date column
 * @method MusicDeezerAlbumQuery orderByAvailable($order = Criteria::ASC) Order by the available column
 * @method MusicDeezerAlbumQuery orderByExplicitLyrics($order = Criteria::ASC) Order by the explicit_lyrics column
 * @method MusicDeezerAlbumQuery orderById($order = Criteria::ASC) Order by the id column
 * @method MusicDeezerAlbumQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method MusicDeezerAlbumQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method MusicDeezerAlbumQuery groupByDeezerId() Group by the deezer_id column
 * @method MusicDeezerAlbumQuery groupByAlbumId() Group by the album_id column
 * @method MusicDeezerAlbumQuery groupByName() Group by the name column
 * @method MusicDeezerAlbumQuery groupByArtistDeezerId() Group by the artist_deezer_id column
 * @method MusicDeezerAlbumQuery groupByMainGenreDeezerId() Group by the main_genre_deezer_id column
 * @method MusicDeezerAlbumQuery groupByGenreDeezerIds() Group by the genre_deezer_ids column
 * @method MusicDeezerAlbumQuery groupByRecordType() Group by the record_type column
 * @method MusicDeezerAlbumQuery groupByUpc() Group by the upc column
 * @method MusicDeezerAlbumQuery groupByLabel() Group by the label column
 * @method MusicDeezerAlbumQuery groupByNbTracks() Group by the nb_tracks column
 * @method MusicDeezerAlbumQuery groupByDuration() Group by the duration column
 * @method MusicDeezerAlbumQuery groupByNbFans() Group by the nb_fans column
 * @method MusicDeezerAlbumQuery groupByRating() Group by the rating column
 * @method MusicDeezerAlbumQuery groupByReleaseDate() Group by the release_date column
 * @method MusicDeezerAlbumQuery groupByAvailable() Group by the available column
 * @method MusicDeezerAlbumQuery groupByExplicitLyrics() Group by the explicit_lyrics column
 * @method MusicDeezerAlbumQuery groupById() Group by the id column
 * @method MusicDeezerAlbumQuery groupByCreatedAt() Group by the created_at column
 * @method MusicDeezerAlbumQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method MusicDeezerAlbumQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method MusicDeezerAlbumQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method MusicDeezerAlbumQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method MusicDeezerAlbumQuery leftJoinMusicAlbum($relationAlias = null) Adds a LEFT JOIN clause to the query using the MusicAlbum relation
 * @method MusicDeezerAlbumQuery rightJoinMusicAlbum($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MusicAlbum relation
 * @method MusicDeezerAlbumQuery innerJoinMusicAlbum($relationAlias = null) Adds a INNER JOIN clause to the query using the MusicAlbum relation
 *
 * @method MusicDeezerAlbumQuery leftJoinMusicDeezerArtist($relationAlias = null) Adds a LEFT JOIN clause to the query using the MusicDeezerArtist relation
 * @method MusicDeezerAlbumQuery rightJoinMusicDeezerArtist($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MusicDeezerArtist relation
 * @method MusicDeezerAlbumQuery innerJoinMusicDeezerArtist($relationAlias = null) Adds a INNER JOIN clause to the query using the MusicDeezerArtist relation
 *
 * @method MusicDeezerAlbumQuery leftJoinMusicDeezerTrack($relationAlias = null) Adds a LEFT JOIN clause to the query using the MusicDeezerTrack relation
 * @method MusicDeezerAlbumQuery rightJoinMusicDeezerTrack($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MusicDeezerTrack relation
 * @method MusicDeezerAlbumQuery innerJoinMusicDeezerTrack($relationAlias = null) Adds a INNER JOIN clause to the query using the MusicDeezerTrack relation
 *
 * @method MusicDeezerAlbum findOne(PropelPDO $con = null) Return the first MusicDeezerAlbum matching the query
 * @method MusicDeezerAlbum findOneOrCreate(PropelPDO $con = null) Return the first MusicDeezerAlbum matching the query, or a new MusicDeezerAlbum object populated from the query conditions when no match is found
 *
 * @method MusicDeezerAlbum findOneByDeezerId(int $deezer_id) Return the first MusicDeezerAlbum filtered by the deezer_id column
 * @method MusicDeezerAlbum findOneByAlbumId(int $album_id) Return the first MusicDeezerAlbum filtered by the album_id column
 * @method MusicDeezerAlbum findOneByName(string $name) Return the first MusicDeezerAlbum filtered by the name column
 * @method MusicDeezerAlbum findOneByArtistDeezerId(int $artist_deezer_id) Return the first MusicDeezerAlbum filtered by the artist_deezer_id column
 * @method MusicDeezerAlbum findOneByMainGenreDeezerId(int $main_genre_deezer_id) Return the first MusicDeezerAlbum filtered by the main_genre_deezer_id column
 * @method MusicDeezerAlbum findOneByGenreDeezerIds(array $genre_deezer_ids) Return the first MusicDeezerAlbum filtered by the genre_deezer_ids column
 * @method MusicDeezerAlbum findOneByRecordType(int $record_type) Return the first MusicDeezerAlbum filtered by the record_type column
 * @method MusicDeezerAlbum findOneByUpc(string $upc) Return the first MusicDeezerAlbum filtered by the upc column
 * @method MusicDeezerAlbum findOneByLabel(string $label) Return the first MusicDeezerAlbum filtered by the label column
 * @method MusicDeezerAlbum findOneByNbTracks(int $nb_tracks) Return the first MusicDeezerAlbum filtered by the nb_tracks column
 * @method MusicDeezerAlbum findOneByDuration(int $duration) Return the first MusicDeezerAlbum filtered by the duration column
 * @method MusicDeezerAlbum findOneByNbFans(int $nb_fans) Return the first MusicDeezerAlbum filtered by the nb_fans column
 * @method MusicDeezerAlbum findOneByRating(int $rating) Return the first MusicDeezerAlbum filtered by the rating column
 * @method MusicDeezerAlbum findOneByReleaseDate(string $release_date) Return the first MusicDeezerAlbum filtered by the release_date column
 * @method MusicDeezerAlbum findOneByAvailable(boolean $available) Return the first MusicDeezerAlbum filtered by the available column
 * @method MusicDeezerAlbum findOneByExplicitLyrics(boolean $explicit_lyrics) Return the first MusicDeezerAlbum filtered by the explicit_lyrics column
 * @method MusicDeezerAlbum findOneByCreatedAt(string $created_at) Return the first MusicDeezerAlbum filtered by the created_at column
 * @method MusicDeezerAlbum findOneByUpdatedAt(string $updated_at) Return the first MusicDeezerAlbum filtered by the updated_at column
 *
 * @method array findByDeezerId(int $deezer_id) Return MusicDeezerAlbum objects filtered by the deezer_id column
 * @method array findByAlbumId(int $album_id) Return MusicDeezerAlbum objects filtered by the album_id column
 * @method array findByName(string $name) Return MusicDeezerAlbum objects filtered by the name column
 * @method array findByArtistDeezerId(int $artist_deezer_id) Return MusicDeezerAlbum objects filtered by the artist_deezer_id column
 * @method array findByMainGenreDeezerId(int $main_genre_deezer_id) Return MusicDeezerAlbum objects filtered by the main_genre_deezer_id column
 * @method array findByGenreDeezerIds(array $genre_deezer_ids) Return MusicDeezerAlbum objects filtered by the genre_deezer_ids column
 * @method array findByRecordType(int $record_type) Return MusicDeezerAlbum objects filtered by the record_type column
 * @method array findByUpc(string $upc) Return MusicDeezerAlbum objects filtered by the upc column
 * @method array findByLabel(string $label) Return MusicDeezerAlbum objects filtered by the label column
 * @method array findByNbTracks(int $nb_tracks) Return MusicDeezerAlbum objects filtered by the nb_tracks column
 * @method array findByDuration(int $duration) Return MusicDeezerAlbum objects filtered by the duration column
 * @method array findByNbFans(int $nb_fans) Return MusicDeezerAlbum objects filtered by the nb_fans column
 * @method array findByRating(int $rating) Return MusicDeezerAlbum objects filtered by the rating column
 * @method array findByReleaseDate(string $release_date) Return MusicDeezerAlbum objects filtered by the release_date column
 * @method array findByAvailable(boolean $available) Return MusicDeezerAlbum objects filtered by the available column
 * @method array findByExplicitLyrics(boolean $explicit_lyrics) Return MusicDeezerAlbum objects filtered by the explicit_lyrics column
 * @method array findById(int $id) Return MusicDeezerAlbum objects filtered by the id column
 * @method array findByCreatedAt(string $created_at) Return MusicDeezerAlbum objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return MusicDeezerAlbum objects filtered by the updated_at column
 */
abstract class BaseMusicDeezerAlbumQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseMusicDeezerAlbumQuery object.
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
            $modelName = 'Sbh\\MusicBundle\\Model\\MusicDeezerAlbum';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new MusicDeezerAlbumQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   MusicDeezerAlbumQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return MusicDeezerAlbumQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof MusicDeezerAlbumQuery) {
            return $criteria;
        }
        $query = new MusicDeezerAlbumQuery(null, null, $modelAlias);

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
     * @return   MusicDeezerAlbum|MusicDeezerAlbum[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MusicDeezerAlbumPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(MusicDeezerAlbumPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 MusicDeezerAlbum A model object, or null if the key is not found
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
     * @return                 MusicDeezerAlbum A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `deezer_id`, `album_id`, `name`, `artist_deezer_id`, `main_genre_deezer_id`, `genre_deezer_ids`, `record_type`, `upc`, `label`, `nb_tracks`, `duration`, `nb_fans`, `rating`, `release_date`, `available`, `explicit_lyrics`, `id`, `created_at`, `updated_at` FROM `music_deezer_album` WHERE `id` = :p0';
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
            $obj = new MusicDeezerAlbum();
            $obj->hydrate($row);
            MusicDeezerAlbumPeer::addInstanceToPool($obj, (string) $key);
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
     * @return MusicDeezerAlbum|MusicDeezerAlbum[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|MusicDeezerAlbum[]|mixed the list of results, formatted by the current formatter
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
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MusicDeezerAlbumPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MusicDeezerAlbumPeer::ID, $keys, Criteria::IN);
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
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
     */
    public function filterByDeezerId($deezerId = null, $comparison = null)
    {
        if (is_array($deezerId)) {
            $useMinMax = false;
            if (isset($deezerId['min'])) {
                $this->addUsingAlias(MusicDeezerAlbumPeer::DEEZER_ID, $deezerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($deezerId['max'])) {
                $this->addUsingAlias(MusicDeezerAlbumPeer::DEEZER_ID, $deezerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicDeezerAlbumPeer::DEEZER_ID, $deezerId, $comparison);
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
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
     */
    public function filterByAlbumId($albumId = null, $comparison = null)
    {
        if (is_array($albumId)) {
            $useMinMax = false;
            if (isset($albumId['min'])) {
                $this->addUsingAlias(MusicDeezerAlbumPeer::ALBUM_ID, $albumId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($albumId['max'])) {
                $this->addUsingAlias(MusicDeezerAlbumPeer::ALBUM_ID, $albumId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicDeezerAlbumPeer::ALBUM_ID, $albumId, $comparison);
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
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MusicDeezerAlbumPeer::NAME, $name, $comparison);
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
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
     */
    public function filterByArtistDeezerId($artistDeezerId = null, $comparison = null)
    {
        if (is_array($artistDeezerId)) {
            $useMinMax = false;
            if (isset($artistDeezerId['min'])) {
                $this->addUsingAlias(MusicDeezerAlbumPeer::ARTIST_DEEZER_ID, $artistDeezerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($artistDeezerId['max'])) {
                $this->addUsingAlias(MusicDeezerAlbumPeer::ARTIST_DEEZER_ID, $artistDeezerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicDeezerAlbumPeer::ARTIST_DEEZER_ID, $artistDeezerId, $comparison);
    }

    /**
     * Filter the query on the main_genre_deezer_id column
     *
     * Example usage:
     * <code>
     * $query->filterByMainGenreDeezerId(1234); // WHERE main_genre_deezer_id = 1234
     * $query->filterByMainGenreDeezerId(array(12, 34)); // WHERE main_genre_deezer_id IN (12, 34)
     * $query->filterByMainGenreDeezerId(array('min' => 12)); // WHERE main_genre_deezer_id >= 12
     * $query->filterByMainGenreDeezerId(array('max' => 12)); // WHERE main_genre_deezer_id <= 12
     * </code>
     *
     * @param     mixed $mainGenreDeezerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
     */
    public function filterByMainGenreDeezerId($mainGenreDeezerId = null, $comparison = null)
    {
        if (is_array($mainGenreDeezerId)) {
            $useMinMax = false;
            if (isset($mainGenreDeezerId['min'])) {
                $this->addUsingAlias(MusicDeezerAlbumPeer::MAIN_GENRE_DEEZER_ID, $mainGenreDeezerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($mainGenreDeezerId['max'])) {
                $this->addUsingAlias(MusicDeezerAlbumPeer::MAIN_GENRE_DEEZER_ID, $mainGenreDeezerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicDeezerAlbumPeer::MAIN_GENRE_DEEZER_ID, $mainGenreDeezerId, $comparison);
    }

    /**
     * Filter the query on the genre_deezer_ids column
     *
     * @param     array $genreDeezerIds The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
     */
    public function filterByGenreDeezerIds($genreDeezerIds = null, $comparison = null)
    {
        $key = $this->getAliasedColName(MusicDeezerAlbumPeer::GENRE_DEEZER_IDS);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($genreDeezerIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($genreDeezerIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($genreDeezerIds as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::NOT_LIKE);
                } else {
                    $this->add($key, $value, Criteria::NOT_LIKE);
                }
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(MusicDeezerAlbumPeer::GENRE_DEEZER_IDS, $genreDeezerIds, $comparison);
    }

    /**
     * Filter the query on the genre_deezer_ids column
     * @param     mixed $genreDeezerIds The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
     */
    public function filterByGenreDeezerId($genreDeezerIds = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($genreDeezerIds)) {
                $genreDeezerIds = '%| ' . $genreDeezerIds . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $genreDeezerIds = '%| ' . $genreDeezerIds . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(MusicDeezerAlbumPeer::GENRE_DEEZER_IDS);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $genreDeezerIds, $comparison);
            } else {
                $this->addAnd($key, $genreDeezerIds, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(MusicDeezerAlbumPeer::GENRE_DEEZER_IDS, $genreDeezerIds, $comparison);
    }

    /**
     * Filter the query on the record_type column
     *
     * @param     mixed $recordType The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByRecordType($recordType = null, $comparison = null)
    {
        if (is_scalar($recordType)) {
            $recordType = MusicDeezerAlbumPeer::getSqlValueForEnum(MusicDeezerAlbumPeer::RECORD_TYPE, $recordType);
        } elseif (is_array($recordType)) {
            $convertedValues = array();
            foreach ($recordType as $value) {
                $convertedValues[] = MusicDeezerAlbumPeer::getSqlValueForEnum(MusicDeezerAlbumPeer::RECORD_TYPE, $value);
            }
            $recordType = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicDeezerAlbumPeer::RECORD_TYPE, $recordType, $comparison);
    }

    /**
     * Filter the query on the upc column
     *
     * Example usage:
     * <code>
     * $query->filterByUpc('fooValue');   // WHERE upc = 'fooValue'
     * $query->filterByUpc('%fooValue%'); // WHERE upc LIKE '%fooValue%'
     * </code>
     *
     * @param     string $upc The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
     */
    public function filterByUpc($upc = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($upc)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $upc)) {
                $upc = str_replace('*', '%', $upc);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MusicDeezerAlbumPeer::UPC, $upc, $comparison);
    }

    /**
     * Filter the query on the label column
     *
     * Example usage:
     * <code>
     * $query->filterByLabel('fooValue');   // WHERE label = 'fooValue'
     * $query->filterByLabel('%fooValue%'); // WHERE label LIKE '%fooValue%'
     * </code>
     *
     * @param     string $label The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
     */
    public function filterByLabel($label = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($label)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $label)) {
                $label = str_replace('*', '%', $label);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MusicDeezerAlbumPeer::LABEL, $label, $comparison);
    }

    /**
     * Filter the query on the nb_tracks column
     *
     * Example usage:
     * <code>
     * $query->filterByNbTracks(1234); // WHERE nb_tracks = 1234
     * $query->filterByNbTracks(array(12, 34)); // WHERE nb_tracks IN (12, 34)
     * $query->filterByNbTracks(array('min' => 12)); // WHERE nb_tracks >= 12
     * $query->filterByNbTracks(array('max' => 12)); // WHERE nb_tracks <= 12
     * </code>
     *
     * @param     mixed $nbTracks The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
     */
    public function filterByNbTracks($nbTracks = null, $comparison = null)
    {
        if (is_array($nbTracks)) {
            $useMinMax = false;
            if (isset($nbTracks['min'])) {
                $this->addUsingAlias(MusicDeezerAlbumPeer::NB_TRACKS, $nbTracks['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($nbTracks['max'])) {
                $this->addUsingAlias(MusicDeezerAlbumPeer::NB_TRACKS, $nbTracks['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicDeezerAlbumPeer::NB_TRACKS, $nbTracks, $comparison);
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
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
     */
    public function filterByDuration($duration = null, $comparison = null)
    {
        if (is_array($duration)) {
            $useMinMax = false;
            if (isset($duration['min'])) {
                $this->addUsingAlias(MusicDeezerAlbumPeer::DURATION, $duration['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($duration['max'])) {
                $this->addUsingAlias(MusicDeezerAlbumPeer::DURATION, $duration['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicDeezerAlbumPeer::DURATION, $duration, $comparison);
    }

    /**
     * Filter the query on the nb_fans column
     *
     * Example usage:
     * <code>
     * $query->filterByNbFans(1234); // WHERE nb_fans = 1234
     * $query->filterByNbFans(array(12, 34)); // WHERE nb_fans IN (12, 34)
     * $query->filterByNbFans(array('min' => 12)); // WHERE nb_fans >= 12
     * $query->filterByNbFans(array('max' => 12)); // WHERE nb_fans <= 12
     * </code>
     *
     * @param     mixed $nbFans The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
     */
    public function filterByNbFans($nbFans = null, $comparison = null)
    {
        if (is_array($nbFans)) {
            $useMinMax = false;
            if (isset($nbFans['min'])) {
                $this->addUsingAlias(MusicDeezerAlbumPeer::NB_FANS, $nbFans['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($nbFans['max'])) {
                $this->addUsingAlias(MusicDeezerAlbumPeer::NB_FANS, $nbFans['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicDeezerAlbumPeer::NB_FANS, $nbFans, $comparison);
    }

    /**
     * Filter the query on the rating column
     *
     * Example usage:
     * <code>
     * $query->filterByRating(1234); // WHERE rating = 1234
     * $query->filterByRating(array(12, 34)); // WHERE rating IN (12, 34)
     * $query->filterByRating(array('min' => 12)); // WHERE rating >= 12
     * $query->filterByRating(array('max' => 12)); // WHERE rating <= 12
     * </code>
     *
     * @param     mixed $rating The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
     */
    public function filterByRating($rating = null, $comparison = null)
    {
        if (is_array($rating)) {
            $useMinMax = false;
            if (isset($rating['min'])) {
                $this->addUsingAlias(MusicDeezerAlbumPeer::RATING, $rating['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rating['max'])) {
                $this->addUsingAlias(MusicDeezerAlbumPeer::RATING, $rating['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicDeezerAlbumPeer::RATING, $rating, $comparison);
    }

    /**
     * Filter the query on the release_date column
     *
     * Example usage:
     * <code>
     * $query->filterByReleaseDate('2011-03-14'); // WHERE release_date = '2011-03-14'
     * $query->filterByReleaseDate('now'); // WHERE release_date = '2011-03-14'
     * $query->filterByReleaseDate(array('max' => 'yesterday')); // WHERE release_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $releaseDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
     */
    public function filterByReleaseDate($releaseDate = null, $comparison = null)
    {
        if (is_array($releaseDate)) {
            $useMinMax = false;
            if (isset($releaseDate['min'])) {
                $this->addUsingAlias(MusicDeezerAlbumPeer::RELEASE_DATE, $releaseDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($releaseDate['max'])) {
                $this->addUsingAlias(MusicDeezerAlbumPeer::RELEASE_DATE, $releaseDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicDeezerAlbumPeer::RELEASE_DATE, $releaseDate, $comparison);
    }

    /**
     * Filter the query on the available column
     *
     * Example usage:
     * <code>
     * $query->filterByAvailable(true); // WHERE available = true
     * $query->filterByAvailable('yes'); // WHERE available = true
     * </code>
     *
     * @param     boolean|string $available The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
     */
    public function filterByAvailable($available = null, $comparison = null)
    {
        if (is_string($available)) {
            $available = in_array(strtolower($available), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(MusicDeezerAlbumPeer::AVAILABLE, $available, $comparison);
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
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
     */
    public function filterByExplicitLyrics($explicitLyrics = null, $comparison = null)
    {
        if (is_string($explicitLyrics)) {
            $explicitLyrics = in_array(strtolower($explicitLyrics), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(MusicDeezerAlbumPeer::EXPLICIT_LYRICS, $explicitLyrics, $comparison);
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
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MusicDeezerAlbumPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MusicDeezerAlbumPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicDeezerAlbumPeer::ID, $id, $comparison);
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
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(MusicDeezerAlbumPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(MusicDeezerAlbumPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicDeezerAlbumPeer::CREATED_AT, $createdAt, $comparison);
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
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(MusicDeezerAlbumPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(MusicDeezerAlbumPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicDeezerAlbumPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related MusicAlbum object
     *
     * @param   MusicAlbum|PropelObjectCollection $musicAlbum The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 MusicDeezerAlbumQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMusicAlbum($musicAlbum, $comparison = null)
    {
        if ($musicAlbum instanceof MusicAlbum) {
            return $this
                ->addUsingAlias(MusicDeezerAlbumPeer::ALBUM_ID, $musicAlbum->getId(), $comparison);
        } elseif ($musicAlbum instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MusicDeezerAlbumPeer::ALBUM_ID, $musicAlbum->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
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
     * Filter the query by a related MusicDeezerArtist object
     *
     * @param   MusicDeezerArtist|PropelObjectCollection $musicDeezerArtist The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 MusicDeezerAlbumQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMusicDeezerArtist($musicDeezerArtist, $comparison = null)
    {
        if ($musicDeezerArtist instanceof MusicDeezerArtist) {
            return $this
                ->addUsingAlias(MusicDeezerAlbumPeer::ARTIST_DEEZER_ID, $musicDeezerArtist->getDeezerId(), $comparison);
        } elseif ($musicDeezerArtist instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MusicDeezerAlbumPeer::ARTIST_DEEZER_ID, $musicDeezerArtist->toKeyValue('PrimaryKey', 'DeezerId'), $comparison);
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
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
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
     * Filter the query by a related MusicDeezerTrack object
     *
     * @param   MusicDeezerTrack|PropelObjectCollection $musicDeezerTrack  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 MusicDeezerAlbumQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMusicDeezerTrack($musicDeezerTrack, $comparison = null)
    {
        if ($musicDeezerTrack instanceof MusicDeezerTrack) {
            return $this
                ->addUsingAlias(MusicDeezerAlbumPeer::DEEZER_ID, $musicDeezerTrack->getAlbumDeezerId(), $comparison);
        } elseif ($musicDeezerTrack instanceof PropelObjectCollection) {
            return $this
                ->useMusicDeezerTrackQuery()
                ->filterByPrimaryKeys($musicDeezerTrack->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMusicDeezerTrack() only accepts arguments of type MusicDeezerTrack or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MusicDeezerTrack relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
     */
    public function joinMusicDeezerTrack($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MusicDeezerTrack');

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
            $this->addJoinObject($join, 'MusicDeezerTrack');
        }

        return $this;
    }

    /**
     * Use the MusicDeezerTrack relation MusicDeezerTrack object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Sbh\MusicBundle\Model\MusicDeezerTrackQuery A secondary query class using the current class as primary query
     */
    public function useMusicDeezerTrackQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMusicDeezerTrack($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MusicDeezerTrack', '\Sbh\MusicBundle\Model\MusicDeezerTrackQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   MusicDeezerAlbum $musicDeezerAlbum Object to remove from the list of results
     *
     * @return MusicDeezerAlbumQuery The current query, for fluid interface
     */
    public function prune($musicDeezerAlbum = null)
    {
        if ($musicDeezerAlbum) {
            $this->addUsingAlias(MusicDeezerAlbumPeer::ID, $musicDeezerAlbum->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

  // timestampable behavior

  /**
   * Filter by the latest updated
   *
   * @param      int $nbDays Maximum age of the latest update in days
   *
   * @return     MusicDeezerAlbumQuery The current query, for fluid interface
   */
  public function recentlyUpdated($nbDays = 7)
  {
      return $this->addUsingAlias(MusicDeezerAlbumPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by update date desc
   *
   * @return     MusicDeezerAlbumQuery The current query, for fluid interface
   */
  public function lastUpdatedFirst()
  {
      return $this->addDescendingOrderByColumn(MusicDeezerAlbumPeer::UPDATED_AT);
  }

  /**
   * Order by update date asc
   *
   * @return     MusicDeezerAlbumQuery The current query, for fluid interface
   */
  public function firstUpdatedFirst()
  {
      return $this->addAscendingOrderByColumn(MusicDeezerAlbumPeer::UPDATED_AT);
  }

  /**
   * Filter by the latest created
   *
   * @param      int $nbDays Maximum age of in days
   *
   * @return     MusicDeezerAlbumQuery The current query, for fluid interface
   */
  public function recentlyCreated($nbDays = 7)
  {
      return $this->addUsingAlias(MusicDeezerAlbumPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by create date desc
   *
   * @return     MusicDeezerAlbumQuery The current query, for fluid interface
   */
  public function lastCreatedFirst()
  {
      return $this->addDescendingOrderByColumn(MusicDeezerAlbumPeer::CREATED_AT);
  }

  /**
   * Order by create date asc
   *
   * @return     MusicDeezerAlbumQuery The current query, for fluid interface
   */
  public function firstCreatedFirst()
  {
      return $this->addAscendingOrderByColumn(MusicDeezerAlbumPeer::CREATED_AT);
  }
}
