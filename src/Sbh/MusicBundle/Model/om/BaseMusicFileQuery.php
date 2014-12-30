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
use Sbh\MusicBundle\Model\MusicFilePeer;
use Sbh\MusicBundle\Model\MusicFileQuery;
use Sbh\MusicBundle\Model\MusicOriginalTag;
use Sbh\MusicBundle\Model\MusicTrack;
use Sbh\StartBundle\Model\File;

/**
 * @method MusicFileQuery orderByFileId($order = Criteria::ASC) Order by the file_id column
 * @method MusicFileQuery orderByTrackId($order = Criteria::ASC) Order by the track_id column
 * @method MusicFileQuery orderByScanOriginalTag($order = Criteria::ASC) Order by the scan_original_tag column
 * @method MusicFileQuery orderByAssociateTags($order = Criteria::ASC) Order by the associate_tags column
 * @method MusicFileQuery orderById($order = Criteria::ASC) Order by the id column
 * @method MusicFileQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method MusicFileQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method MusicFileQuery groupByFileId() Group by the file_id column
 * @method MusicFileQuery groupByTrackId() Group by the track_id column
 * @method MusicFileQuery groupByScanOriginalTag() Group by the scan_original_tag column
 * @method MusicFileQuery groupByAssociateTags() Group by the associate_tags column
 * @method MusicFileQuery groupById() Group by the id column
 * @method MusicFileQuery groupByCreatedAt() Group by the created_at column
 * @method MusicFileQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method MusicFileQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method MusicFileQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method MusicFileQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method MusicFileQuery leftJoinFile($relationAlias = null) Adds a LEFT JOIN clause to the query using the File relation
 * @method MusicFileQuery rightJoinFile($relationAlias = null) Adds a RIGHT JOIN clause to the query using the File relation
 * @method MusicFileQuery innerJoinFile($relationAlias = null) Adds a INNER JOIN clause to the query using the File relation
 *
 * @method MusicFileQuery leftJoinMusicTrack($relationAlias = null) Adds a LEFT JOIN clause to the query using the MusicTrack relation
 * @method MusicFileQuery rightJoinMusicTrack($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MusicTrack relation
 * @method MusicFileQuery innerJoinMusicTrack($relationAlias = null) Adds a INNER JOIN clause to the query using the MusicTrack relation
 *
 * @method MusicFileQuery leftJoinMusicOriginalTag($relationAlias = null) Adds a LEFT JOIN clause to the query using the MusicOriginalTag relation
 * @method MusicFileQuery rightJoinMusicOriginalTag($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MusicOriginalTag relation
 * @method MusicFileQuery innerJoinMusicOriginalTag($relationAlias = null) Adds a INNER JOIN clause to the query using the MusicOriginalTag relation
 *
 * @method MusicFile findOne(PropelPDO $con = null) Return the first MusicFile matching the query
 * @method MusicFile findOneOrCreate(PropelPDO $con = null) Return the first MusicFile matching the query, or a new MusicFile object populated from the query conditions when no match is found
 *
 * @method MusicFile findOneByFileId(int $file_id) Return the first MusicFile filtered by the file_id column
 * @method MusicFile findOneByTrackId(int $track_id) Return the first MusicFile filtered by the track_id column
 * @method MusicFile findOneByScanOriginalTag(boolean $scan_original_tag) Return the first MusicFile filtered by the scan_original_tag column
 * @method MusicFile findOneByAssociateTags(boolean $associate_tags) Return the first MusicFile filtered by the associate_tags column
 * @method MusicFile findOneByCreatedAt(string $created_at) Return the first MusicFile filtered by the created_at column
 * @method MusicFile findOneByUpdatedAt(string $updated_at) Return the first MusicFile filtered by the updated_at column
 *
 * @method array findByFileId(int $file_id) Return MusicFile objects filtered by the file_id column
 * @method array findByTrackId(int $track_id) Return MusicFile objects filtered by the track_id column
 * @method array findByScanOriginalTag(boolean $scan_original_tag) Return MusicFile objects filtered by the scan_original_tag column
 * @method array findByAssociateTags(boolean $associate_tags) Return MusicFile objects filtered by the associate_tags column
 * @method array findById(int $id) Return MusicFile objects filtered by the id column
 * @method array findByCreatedAt(string $created_at) Return MusicFile objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return MusicFile objects filtered by the updated_at column
 */
abstract class BaseMusicFileQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseMusicFileQuery object.
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
            $modelName = 'Sbh\\MusicBundle\\Model\\MusicFile';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new MusicFileQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   MusicFileQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return MusicFileQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof MusicFileQuery) {
            return $criteria;
        }
        $query = new MusicFileQuery(null, null, $modelAlias);

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
     * @return   MusicFile|MusicFile[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MusicFilePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(MusicFilePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 MusicFile A model object, or null if the key is not found
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
     * @return                 MusicFile A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `file_id`, `track_id`, `scan_original_tag`, `associate_tags`, `id`, `created_at`, `updated_at` FROM `music_file` WHERE `id` = :p0';
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
            $obj = new MusicFile();
            $obj->hydrate($row);
            MusicFilePeer::addInstanceToPool($obj, (string) $key);
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
     * @return MusicFile|MusicFile[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|MusicFile[]|mixed the list of results, formatted by the current formatter
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
     * @return MusicFileQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MusicFilePeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return MusicFileQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MusicFilePeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the file_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFileId(1234); // WHERE file_id = 1234
     * $query->filterByFileId(array(12, 34)); // WHERE file_id IN (12, 34)
     * $query->filterByFileId(array('min' => 12)); // WHERE file_id >= 12
     * $query->filterByFileId(array('max' => 12)); // WHERE file_id <= 12
     * </code>
     *
     * @see       filterByFile()
     *
     * @param     mixed $fileId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicFileQuery The current query, for fluid interface
     */
    public function filterByFileId($fileId = null, $comparison = null)
    {
        if (is_array($fileId)) {
            $useMinMax = false;
            if (isset($fileId['min'])) {
                $this->addUsingAlias(MusicFilePeer::FILE_ID, $fileId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fileId['max'])) {
                $this->addUsingAlias(MusicFilePeer::FILE_ID, $fileId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicFilePeer::FILE_ID, $fileId, $comparison);
    }

    /**
     * Filter the query on the track_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTrackId(1234); // WHERE track_id = 1234
     * $query->filterByTrackId(array(12, 34)); // WHERE track_id IN (12, 34)
     * $query->filterByTrackId(array('min' => 12)); // WHERE track_id >= 12
     * $query->filterByTrackId(array('max' => 12)); // WHERE track_id <= 12
     * </code>
     *
     * @see       filterByMusicTrack()
     *
     * @param     mixed $trackId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicFileQuery The current query, for fluid interface
     */
    public function filterByTrackId($trackId = null, $comparison = null)
    {
        if (is_array($trackId)) {
            $useMinMax = false;
            if (isset($trackId['min'])) {
                $this->addUsingAlias(MusicFilePeer::TRACK_ID, $trackId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($trackId['max'])) {
                $this->addUsingAlias(MusicFilePeer::TRACK_ID, $trackId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicFilePeer::TRACK_ID, $trackId, $comparison);
    }

    /**
     * Filter the query on the scan_original_tag column
     *
     * Example usage:
     * <code>
     * $query->filterByScanOriginalTag(true); // WHERE scan_original_tag = true
     * $query->filterByScanOriginalTag('yes'); // WHERE scan_original_tag = true
     * </code>
     *
     * @param     boolean|string $scanOriginalTag The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicFileQuery The current query, for fluid interface
     */
    public function filterByScanOriginalTag($scanOriginalTag = null, $comparison = null)
    {
        if (is_string($scanOriginalTag)) {
            $scanOriginalTag = in_array(strtolower($scanOriginalTag), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(MusicFilePeer::SCAN_ORIGINAL_TAG, $scanOriginalTag, $comparison);
    }

    /**
     * Filter the query on the associate_tags column
     *
     * Example usage:
     * <code>
     * $query->filterByAssociateTags(true); // WHERE associate_tags = true
     * $query->filterByAssociateTags('yes'); // WHERE associate_tags = true
     * </code>
     *
     * @param     boolean|string $associateTags The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MusicFileQuery The current query, for fluid interface
     */
    public function filterByAssociateTags($associateTags = null, $comparison = null)
    {
        if (is_string($associateTags)) {
            $associateTags = in_array(strtolower($associateTags), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(MusicFilePeer::ASSOCIATE_TAGS, $associateTags, $comparison);
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
     * @return MusicFileQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MusicFilePeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MusicFilePeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicFilePeer::ID, $id, $comparison);
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
     * @return MusicFileQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(MusicFilePeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(MusicFilePeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicFilePeer::CREATED_AT, $createdAt, $comparison);
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
     * @return MusicFileQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(MusicFilePeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(MusicFilePeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MusicFilePeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related File object
     *
     * @param   File|PropelObjectCollection $file The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 MusicFileQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFile($file, $comparison = null)
    {
        if ($file instanceof File) {
            return $this
                ->addUsingAlias(MusicFilePeer::FILE_ID, $file->getId(), $comparison);
        } elseif ($file instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MusicFilePeer::FILE_ID, $file->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByFile() only accepts arguments of type File or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the File relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return MusicFileQuery The current query, for fluid interface
     */
    public function joinFile($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('File');

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
            $this->addJoinObject($join, 'File');
        }

        return $this;
    }

    /**
     * Use the File relation File object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Sbh\StartBundle\Model\FileQuery A secondary query class using the current class as primary query
     */
    public function useFileQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinFile($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'File', '\Sbh\StartBundle\Model\FileQuery');
    }

    /**
     * Filter the query by a related MusicTrack object
     *
     * @param   MusicTrack|PropelObjectCollection $musicTrack The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 MusicFileQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMusicTrack($musicTrack, $comparison = null)
    {
        if ($musicTrack instanceof MusicTrack) {
            return $this
                ->addUsingAlias(MusicFilePeer::TRACK_ID, $musicTrack->getId(), $comparison);
        } elseif ($musicTrack instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MusicFilePeer::TRACK_ID, $musicTrack->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return MusicFileQuery The current query, for fluid interface
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
     * Filter the query by a related MusicOriginalTag object
     *
     * @param   MusicOriginalTag|PropelObjectCollection $musicOriginalTag  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 MusicFileQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMusicOriginalTag($musicOriginalTag, $comparison = null)
    {
        if ($musicOriginalTag instanceof MusicOriginalTag) {
            return $this
                ->addUsingAlias(MusicFilePeer::ID, $musicOriginalTag->getMusicFileId(), $comparison);
        } elseif ($musicOriginalTag instanceof PropelObjectCollection) {
            return $this
                ->useMusicOriginalTagQuery()
                ->filterByPrimaryKeys($musicOriginalTag->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMusicOriginalTag() only accepts arguments of type MusicOriginalTag or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MusicOriginalTag relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return MusicFileQuery The current query, for fluid interface
     */
    public function joinMusicOriginalTag($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MusicOriginalTag');

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
            $this->addJoinObject($join, 'MusicOriginalTag');
        }

        return $this;
    }

    /**
     * Use the MusicOriginalTag relation MusicOriginalTag object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Sbh\MusicBundle\Model\MusicOriginalTagQuery A secondary query class using the current class as primary query
     */
    public function useMusicOriginalTagQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMusicOriginalTag($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MusicOriginalTag', '\Sbh\MusicBundle\Model\MusicOriginalTagQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   MusicFile $musicFile Object to remove from the list of results
     *
     * @return MusicFileQuery The current query, for fluid interface
     */
    public function prune($musicFile = null)
    {
        if ($musicFile) {
            $this->addUsingAlias(MusicFilePeer::ID, $musicFile->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

  // timestampable behavior

  /**
   * Filter by the latest updated
   *
   * @param      int $nbDays Maximum age of the latest update in days
   *
   * @return     MusicFileQuery The current query, for fluid interface
   */
  public function recentlyUpdated($nbDays = 7)
  {
      return $this->addUsingAlias(MusicFilePeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by update date desc
   *
   * @return     MusicFileQuery The current query, for fluid interface
   */
  public function lastUpdatedFirst()
  {
      return $this->addDescendingOrderByColumn(MusicFilePeer::UPDATED_AT);
  }

  /**
   * Order by update date asc
   *
   * @return     MusicFileQuery The current query, for fluid interface
   */
  public function firstUpdatedFirst()
  {
      return $this->addAscendingOrderByColumn(MusicFilePeer::UPDATED_AT);
  }

  /**
   * Filter by the latest created
   *
   * @param      int $nbDays Maximum age of in days
   *
   * @return     MusicFileQuery The current query, for fluid interface
   */
  public function recentlyCreated($nbDays = 7)
  {
      return $this->addUsingAlias(MusicFilePeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by create date desc
   *
   * @return     MusicFileQuery The current query, for fluid interface
   */
  public function lastCreatedFirst()
  {
      return $this->addDescendingOrderByColumn(MusicFilePeer::CREATED_AT);
  }

  /**
   * Order by create date asc
   *
   * @return     MusicFileQuery The current query, for fluid interface
   */
  public function firstCreatedFirst()
  {
      return $this->addAscendingOrderByColumn(MusicFilePeer::CREATED_AT);
  }
}
