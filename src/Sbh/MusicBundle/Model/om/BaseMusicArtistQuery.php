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
use Sbh\MusicBundle\Model\MusicArtistPeer;
use Sbh\MusicBundle\Model\MusicArtistQuery;
use Sbh\MusicBundle\Model\MusicDeezerArtist;
use Sbh\MusicBundle\Model\MusicSpotifyArtist;
use Sbh\MusicBundle\Model\MusicTrack;

/**
 * @method MusicArtistQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method MusicArtistQuery orderByAlias($order = Criteria::ASC) Order by the alias column
 * @method MusicArtistQuery orderByImage($order = Criteria::ASC) Order by the image column
 * @method MusicArtistQuery orderByScanDeezerSearch($order = Criteria::ASC) Order by the scan_deezer_search column
 * @method MusicArtistQuery orderByScanSpotifySearch($order = Criteria::ASC) Order by the scan_spotify_search column
 * @method MusicArtistQuery orderBySlug($order = Criteria::ASC) Order by the slug column
 * @method MusicArtistQuery orderById($order = Criteria::ASC) Order by the id column
 * @method MusicArtistQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method MusicArtistQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method MusicArtistQuery groupByName() Group by the name column
 * @method MusicArtistQuery groupByAlias() Group by the alias column
 * @method MusicArtistQuery groupByImage() Group by the image column
 * @method MusicArtistQuery groupByScanDeezerSearch() Group by the scan_deezer_search column
 * @method MusicArtistQuery groupByScanSpotifySearch() Group by the scan_spotify_search column
 * @method MusicArtistQuery groupBySlug() Group by the slug column
 * @method MusicArtistQuery groupById() Group by the id column
 * @method MusicArtistQuery groupByCreatedAt() Group by the created_at column
 * @method MusicArtistQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method MusicArtistQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method MusicArtistQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method MusicArtistQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method MusicArtistQuery leftJoinMusicAlbum($relationAlias = null) Adds a LEFT JOIN clause to the query using the MusicAlbum relation
 * @method MusicArtistQuery rightJoinMusicAlbum($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MusicAlbum relation
 * @method MusicArtistQuery innerJoinMusicAlbum($relationAlias = null) Adds a INNER JOIN clause to the query using the MusicAlbum relation
 *
 * @method MusicArtistQuery leftJoinMusicTrack($relationAlias = null) Adds a LEFT JOIN clause to the query using the MusicTrack relation
 * @method MusicArtistQuery rightJoinMusicTrack($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MusicTrack relation
 * @method MusicArtistQuery innerJoinMusicTrack($relationAlias = null) Adds a INNER JOIN clause to the query using the MusicTrack relation
 *
 * @method MusicArtistQuery leftJoinMusicDeezerArtist($relationAlias = null) Adds a LEFT JOIN clause to the query using the MusicDeezerArtist relation
 * @method MusicArtistQuery rightJoinMusicDeezerArtist($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MusicDeezerArtist relation
 * @method MusicArtistQuery innerJoinMusicDeezerArtist($relationAlias = null) Adds a INNER JOIN clause to the query using the MusicDeezerArtist relation
 *
 * @method MusicArtistQuery leftJoinMusicSpotifyArtist($relationAlias = null) Adds a LEFT JOIN clause to the query using the MusicSpotifyArtist relation
 * @method MusicArtistQuery rightJoinMusicSpotifyArtist($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MusicSpotifyArtist relation
 * @method MusicArtistQuery innerJoinMusicSpotifyArtist($relationAlias = null) Adds a INNER JOIN clause to the query using the MusicSpotifyArtist relation
 *
 * @method MusicArtist findOne(PropelPDO $con = null) Return the first MusicArtist matching the query
 * @method MusicArtist findOneOrCreate(PropelPDO $con = null) Return the first MusicArtist matching the query, or a new MusicArtist object populated from the query conditions when no match is found
 *
 * @method MusicArtist findOneByName(string $name) Return the first MusicArtist filtered by the name column
 * @method MusicArtist findOneByAlias(int $alias) Return the first MusicArtist filtered by the alias column
 * @method MusicArtist findOneByImage(boolean $image) Return the first MusicArtist filtered by the image column
 * @method MusicArtist findOneByScanDeezerSearch(boolean $scan_deezer_search) Return the first MusicArtist filtered by the scan_deezer_search column
 * @method MusicArtist findOneByScanSpotifySearch(boolean $scan_spotify_search) Return the first MusicArtist filtered by the scan_spotify_search column
 * @method MusicArtist findOneBySlug(string $slug) Return the first MusicArtist filtered by the slug column
 * @method MusicArtist findOneByCreatedAt(string $created_at) Return the first MusicArtist filtered by the created_at column
 * @method MusicArtist findOneByUpdatedAt(string $updated_at) Return the first MusicArtist filtered by the updated_at column
 *
 * @method array findByName(string $name) Return MusicArtist objects filtered by the name column
 * @method array findByAlias(int $alias) Return MusicArtist objects filtered by the alias column
 * @method array findByImage(boolean $image) Return MusicArtist objects filtered by the image column
 * @method array findByScanDeezerSearch(boolean $scan_deezer_search) Return MusicArtist objects filtered by the scan_deezer_search column
 * @method array findByScanSpotifySearch(boolean $scan_spotify_search) Return MusicArtist objects filtered by the scan_spotify_search column
 * @method array findBySlug(string $slug) Return MusicArtist objects filtered by the slug column
 * @method array findById(int $id) Return MusicArtist objects filtered by the id column
 * @method array findByCreatedAt(string $created_at) Return MusicArtist objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return MusicArtist objects filtered by the updated_at column
 */
abstract class BaseMusicArtistQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseMusicArtistQuery object.
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
            $modelName = 'Sbh\\MusicBundle\\Model\\MusicArtist';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new MusicArtistQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   MusicArtistQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return MusicArtistQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof MusicArtistQuery) {
            return $criteria;
        }
        $query = new MusicArtistQuery(null, null, $modelAlias);

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
     * @return   MusicArtist|MusicArtist[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MusicArtistPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(MusicArtistPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 MusicArtist A model object, or null if the key is not found
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
     * @return                 MusicArtist A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `name`, `alias`, `image`, `scan_deezer_search`, `scan_spotify_search`, `slug`, `id`, `created_at`, `updated_at` FROM `music_artist` WHERE `id` = :p0';
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
            $obj = new MusicArtist();
            $obj->hydrate($row);
            MusicArtistPeer::addInstanceToPool($obj, (string) $key);
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
     * @return MusicArtist|MusicArtist[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|MusicArtist[]|mixed the list of results, formatted by the current formatter
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
     * @return MusicArtistQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MusicArtistPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return MusicArtistQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MusicArtistPeer::ID, $keys, Criteria::IN);
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
     * @return MusicArtistQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MusicArtistPeer::NAME, $name, $comparison);
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
     * @return MusicArtistQuery The current query, for fluid interface
     */
    public function filterByAlias($alias = null, $comparison = null)
    {
        if (is_array($alias)) {
            $useMinMax = false;
            if (isset($alias['min'])) {
                $this->addUsingAlias(MusicArtistPeer::ALIAS, $alias['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($alias['max'])) {
                $this->addUsingAlias(MusicArtistPeer::ALIAS, $alias['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicArtistPeer::ALIAS, $alias, $comparison);
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
     * @return MusicArtistQuery The current query, for fluid interface
     */
    public function filterByImage($image = null, $comparison = null)
    {
        if (is_string($image)) {
            $image = in_array(strtolower($image), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(MusicArtistPeer::IMAGE, $image, $comparison);
    }

    /**
     * Filter the query on the scan_deezer_search column
     *
     * Example usage:
     * <code>
     * $query->filterByScanDeezerSearch(true); // WHERE scan_deezer_search = true
     * $query->filterByScanDeezerSearch('yes'); // WHERE scan_deezer_search = true
     * </code>
     *
     * @param     boolean|string $scanDeezerSearch The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicArtistQuery The current query, for fluid interface
     */
    public function filterByScanDeezerSearch($scanDeezerSearch = null, $comparison = null)
    {
        if (is_string($scanDeezerSearch)) {
            $scanDeezerSearch = in_array(strtolower($scanDeezerSearch), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(MusicArtistPeer::SCAN_DEEZER_SEARCH, $scanDeezerSearch, $comparison);
    }

    /**
     * Filter the query on the scan_spotify_search column
     *
     * Example usage:
     * <code>
     * $query->filterByScanSpotifySearch(true); // WHERE scan_spotify_search = true
     * $query->filterByScanSpotifySearch('yes'); // WHERE scan_spotify_search = true
     * </code>
     *
     * @param     boolean|string $scanSpotifySearch The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicArtistQuery The current query, for fluid interface
     */
    public function filterByScanSpotifySearch($scanSpotifySearch = null, $comparison = null)
    {
        if (is_string($scanSpotifySearch)) {
            $scanSpotifySearch = in_array(strtolower($scanSpotifySearch), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(MusicArtistPeer::SCAN_SPOTIFY_SEARCH, $scanSpotifySearch, $comparison);
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
     * @return MusicArtistQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MusicArtistPeer::SLUG, $slug, $comparison);
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
     * @return MusicArtistQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MusicArtistPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MusicArtistPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicArtistPeer::ID, $id, $comparison);
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
     * @return MusicArtistQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(MusicArtistPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(MusicArtistPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicArtistPeer::CREATED_AT, $createdAt, $comparison);
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
     * @return MusicArtistQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(MusicArtistPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(MusicArtistPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicArtistPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related MusicAlbum object
     *
     * @param   MusicAlbum|PropelObjectCollection $musicAlbum  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 MusicArtistQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMusicAlbum($musicAlbum, $comparison = null)
    {
        if ($musicAlbum instanceof MusicAlbum) {
            return $this
                ->addUsingAlias(MusicArtistPeer::ID, $musicAlbum->getArtistId(), $comparison);
        } elseif ($musicAlbum instanceof PropelObjectCollection) {
            return $this
                ->useMusicAlbumQuery()
                ->filterByPrimaryKeys($musicAlbum->getPrimaryKeys())
                ->endUse();
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
     * @return MusicArtistQuery The current query, for fluid interface
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
     * Filter the query by a related MusicTrack object
     *
     * @param   MusicTrack|PropelObjectCollection $musicTrack  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 MusicArtistQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMusicTrack($musicTrack, $comparison = null)
    {
        if ($musicTrack instanceof MusicTrack) {
            return $this
                ->addUsingAlias(MusicArtistPeer::ID, $musicTrack->getArtistId(), $comparison);
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
     * @return MusicArtistQuery The current query, for fluid interface
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
     * Filter the query by a related MusicDeezerArtist object
     *
     * @param   MusicDeezerArtist|PropelObjectCollection $musicDeezerArtist  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 MusicArtistQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMusicDeezerArtist($musicDeezerArtist, $comparison = null)
    {
        if ($musicDeezerArtist instanceof MusicDeezerArtist) {
            return $this
                ->addUsingAlias(MusicArtistPeer::ID, $musicDeezerArtist->getArtistId(), $comparison);
        } elseif ($musicDeezerArtist instanceof PropelObjectCollection) {
            return $this
                ->useMusicDeezerArtistQuery()
                ->filterByPrimaryKeys($musicDeezerArtist->getPrimaryKeys())
                ->endUse();
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
     * @return MusicArtistQuery The current query, for fluid interface
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
     * Filter the query by a related MusicSpotifyArtist object
     *
     * @param   MusicSpotifyArtist|PropelObjectCollection $musicSpotifyArtist  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 MusicArtistQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMusicSpotifyArtist($musicSpotifyArtist, $comparison = null)
    {
        if ($musicSpotifyArtist instanceof MusicSpotifyArtist) {
            return $this
                ->addUsingAlias(MusicArtistPeer::ID, $musicSpotifyArtist->getArtistId(), $comparison);
        } elseif ($musicSpotifyArtist instanceof PropelObjectCollection) {
            return $this
                ->useMusicSpotifyArtistQuery()
                ->filterByPrimaryKeys($musicSpotifyArtist->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMusicSpotifyArtist() only accepts arguments of type MusicSpotifyArtist or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MusicSpotifyArtist relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return MusicArtistQuery The current query, for fluid interface
     */
    public function joinMusicSpotifyArtist($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MusicSpotifyArtist');

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
            $this->addJoinObject($join, 'MusicSpotifyArtist');
        }

        return $this;
    }

    /**
     * Use the MusicSpotifyArtist relation MusicSpotifyArtist object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Sbh\MusicBundle\Model\MusicSpotifyArtistQuery A secondary query class using the current class as primary query
     */
    public function useMusicSpotifyArtistQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMusicSpotifyArtist($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MusicSpotifyArtist', '\Sbh\MusicBundle\Model\MusicSpotifyArtistQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   MusicArtist $musicArtist Object to remove from the list of results
     *
     * @return MusicArtistQuery The current query, for fluid interface
     */
    public function prune($musicArtist = null)
    {
        if ($musicArtist) {
            $this->addUsingAlias(MusicArtistPeer::ID, $musicArtist->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

  // timestampable behavior

  /**
   * Filter by the latest updated
   *
   * @param      int $nbDays Maximum age of the latest update in days
   *
   * @return     MusicArtistQuery The current query, for fluid interface
   */
  public function recentlyUpdated($nbDays = 7)
  {
      return $this->addUsingAlias(MusicArtistPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by update date desc
   *
   * @return     MusicArtistQuery The current query, for fluid interface
   */
  public function lastUpdatedFirst()
  {
      return $this->addDescendingOrderByColumn(MusicArtistPeer::UPDATED_AT);
  }

  /**
   * Order by update date asc
   *
   * @return     MusicArtistQuery The current query, for fluid interface
   */
  public function firstUpdatedFirst()
  {
      return $this->addAscendingOrderByColumn(MusicArtistPeer::UPDATED_AT);
  }

  /**
   * Filter by the latest created
   *
   * @param      int $nbDays Maximum age of in days
   *
   * @return     MusicArtistQuery The current query, for fluid interface
   */
  public function recentlyCreated($nbDays = 7)
  {
      return $this->addUsingAlias(MusicArtistPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by create date desc
   *
   * @return     MusicArtistQuery The current query, for fluid interface
   */
  public function lastCreatedFirst()
  {
      return $this->addDescendingOrderByColumn(MusicArtistPeer::CREATED_AT);
  }

  /**
   * Order by create date asc
   *
   * @return     MusicArtistQuery The current query, for fluid interface
   */
  public function firstCreatedFirst()
  {
      return $this->addAscendingOrderByColumn(MusicArtistPeer::CREATED_AT);
  }
}
