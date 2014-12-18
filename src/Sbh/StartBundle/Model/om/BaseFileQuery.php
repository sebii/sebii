<?php

namespace Sbh\StartBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \PDO;
use \Propel;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Sbh\StartBundle\Model\File;
use Sbh\StartBundle\Model\FilePeer;
use Sbh\StartBundle\Model\FileQuery;

/**
 * @method FileQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method FileQuery orderByOriginalPath($order = Criteria::ASC) Order by the original_path column
 * @method FileQuery orderByPath($order = Criteria::ASC) Order by the path column
 * @method FileQuery orderByOriginalExt($order = Criteria::ASC) Order by the original_ext column
 * @method FileQuery orderByGuessExt($order = Criteria::ASC) Order by the guess_ext column
 * @method FileQuery orderByExt($order = Criteria::ASC) Order by the ext column
 * @method FileQuery orderById($order = Criteria::ASC) Order by the id column
 * @method FileQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method FileQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method FileQuery groupByType() Group by the type column
 * @method FileQuery groupByOriginalPath() Group by the original_path column
 * @method FileQuery groupByPath() Group by the path column
 * @method FileQuery groupByOriginalExt() Group by the original_ext column
 * @method FileQuery groupByGuessExt() Group by the guess_ext column
 * @method FileQuery groupByExt() Group by the ext column
 * @method FileQuery groupById() Group by the id column
 * @method FileQuery groupByCreatedAt() Group by the created_at column
 * @method FileQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method FileQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method FileQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method FileQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method File findOne(PropelPDO $con = null) Return the first File matching the query
 * @method File findOneOrCreate(PropelPDO $con = null) Return the first File matching the query, or a new File object populated from the query conditions when no match is found
 *
 * @method File findOneByType(int $type) Return the first File filtered by the type column
 * @method File findOneByOriginalPath(string $original_path) Return the first File filtered by the original_path column
 * @method File findOneByPath(string $path) Return the first File filtered by the path column
 * @method File findOneByOriginalExt(int $original_ext) Return the first File filtered by the original_ext column
 * @method File findOneByGuessExt(int $guess_ext) Return the first File filtered by the guess_ext column
 * @method File findOneByExt(int $ext) Return the first File filtered by the ext column
 * @method File findOneByCreatedAt(string $created_at) Return the first File filtered by the created_at column
 * @method File findOneByUpdatedAt(string $updated_at) Return the first File filtered by the updated_at column
 *
 * @method array findByType(int $type) Return File objects filtered by the type column
 * @method array findByOriginalPath(string $original_path) Return File objects filtered by the original_path column
 * @method array findByPath(string $path) Return File objects filtered by the path column
 * @method array findByOriginalExt(int $original_ext) Return File objects filtered by the original_ext column
 * @method array findByGuessExt(int $guess_ext) Return File objects filtered by the guess_ext column
 * @method array findByExt(int $ext) Return File objects filtered by the ext column
 * @method array findById(int $id) Return File objects filtered by the id column
 * @method array findByCreatedAt(string $created_at) Return File objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return File objects filtered by the updated_at column
 */
abstract class BaseFileQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseFileQuery object.
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
            $modelName = 'Sbh\\StartBundle\\Model\\File';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new FileQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   FileQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return FileQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof FileQuery) {
            return $criteria;
        }
        $query = new FileQuery(null, null, $modelAlias);

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
     * @return   File|File[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FilePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(FilePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 File A model object, or null if the key is not found
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
     * @return                 File A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `type`, `original_path`, `path`, `original_ext`, `guess_ext`, `ext`, `id`, `created_at`, `updated_at` FROM `file` WHERE `id` = :p0';
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
            $obj = new File();
            $obj->hydrate($row);
            FilePeer::addInstanceToPool($obj, (string) $key);
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
     * @return File|File[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|File[]|mixed the list of results, formatted by the current formatter
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
     * @return FileQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FilePeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return FileQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FilePeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the type column
     *
     * @param     mixed $type The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FileQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (is_scalar($type)) {
            $type = FilePeer::getSqlValueForEnum(FilePeer::TYPE, $type);
        } elseif (is_array($type)) {
            $convertedValues = array();
            foreach ($type as $value) {
                $convertedValues[] = FilePeer::getSqlValueForEnum(FilePeer::TYPE, $value);
            }
            $type = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilePeer::TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the original_path column
     *
     * Example usage:
     * <code>
     * $query->filterByOriginalPath('fooValue');   // WHERE original_path = 'fooValue'
     * $query->filterByOriginalPath('%fooValue%'); // WHERE original_path LIKE '%fooValue%'
     * </code>
     *
     * @param     string $originalPath The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FileQuery The current query, for fluid interface
     */
    public function filterByOriginalPath($originalPath = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($originalPath)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $originalPath)) {
                $originalPath = str_replace('*', '%', $originalPath);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FilePeer::ORIGINAL_PATH, $originalPath, $comparison);
    }

    /**
     * Filter the query on the path column
     *
     * Example usage:
     * <code>
     * $query->filterByPath('fooValue');   // WHERE path = 'fooValue'
     * $query->filterByPath('%fooValue%'); // WHERE path LIKE '%fooValue%'
     * </code>
     *
     * @param     string $path The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FileQuery The current query, for fluid interface
     */
    public function filterByPath($path = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($path)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $path)) {
                $path = str_replace('*', '%', $path);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FilePeer::PATH, $path, $comparison);
    }

    /**
     * Filter the query on the original_ext column
     *
     * @param     mixed $originalExt The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FileQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByOriginalExt($originalExt = null, $comparison = null)
    {
        if (is_scalar($originalExt)) {
            $originalExt = FilePeer::getSqlValueForEnum(FilePeer::ORIGINAL_EXT, $originalExt);
        } elseif (is_array($originalExt)) {
            $convertedValues = array();
            foreach ($originalExt as $value) {
                $convertedValues[] = FilePeer::getSqlValueForEnum(FilePeer::ORIGINAL_EXT, $value);
            }
            $originalExt = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilePeer::ORIGINAL_EXT, $originalExt, $comparison);
    }

    /**
     * Filter the query on the guess_ext column
     *
     * @param     mixed $guessExt The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FileQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByGuessExt($guessExt = null, $comparison = null)
    {
        if (is_scalar($guessExt)) {
            $guessExt = FilePeer::getSqlValueForEnum(FilePeer::GUESS_EXT, $guessExt);
        } elseif (is_array($guessExt)) {
            $convertedValues = array();
            foreach ($guessExt as $value) {
                $convertedValues[] = FilePeer::getSqlValueForEnum(FilePeer::GUESS_EXT, $value);
            }
            $guessExt = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilePeer::GUESS_EXT, $guessExt, $comparison);
    }

    /**
     * Filter the query on the ext column
     *
     * @param     mixed $ext The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FileQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByExt($ext = null, $comparison = null)
    {
        if (is_scalar($ext)) {
            $ext = FilePeer::getSqlValueForEnum(FilePeer::EXT, $ext);
        } elseif (is_array($ext)) {
            $convertedValues = array();
            foreach ($ext as $value) {
                $convertedValues[] = FilePeer::getSqlValueForEnum(FilePeer::EXT, $value);
            }
            $ext = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilePeer::EXT, $ext, $comparison);
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
     * @return FileQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(FilePeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(FilePeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilePeer::ID, $id, $comparison);
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
     * @return FileQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(FilePeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(FilePeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilePeer::CREATED_AT, $createdAt, $comparison);
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
     * @return FileQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(FilePeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(FilePeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FilePeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   File $file Object to remove from the list of results
     *
     * @return FileQuery The current query, for fluid interface
     */
    public function prune($file = null)
    {
        if ($file) {
            $this->addUsingAlias(FilePeer::ID, $file->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

  // timestampable behavior

  /**
   * Filter by the latest updated
   *
   * @param      int $nbDays Maximum age of the latest update in days
   *
   * @return     FileQuery The current query, for fluid interface
   */
  public function recentlyUpdated($nbDays = 7)
  {
      return $this->addUsingAlias(FilePeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by update date desc
   *
   * @return     FileQuery The current query, for fluid interface
   */
  public function lastUpdatedFirst()
  {
      return $this->addDescendingOrderByColumn(FilePeer::UPDATED_AT);
  }

  /**
   * Order by update date asc
   *
   * @return     FileQuery The current query, for fluid interface
   */
  public function firstUpdatedFirst()
  {
      return $this->addAscendingOrderByColumn(FilePeer::UPDATED_AT);
  }

  /**
   * Filter by the latest created
   *
   * @param      int $nbDays Maximum age of in days
   *
   * @return     FileQuery The current query, for fluid interface
   */
  public function recentlyCreated($nbDays = 7)
  {
      return $this->addUsingAlias(FilePeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
  }

  /**
   * Order by create date desc
   *
   * @return     FileQuery The current query, for fluid interface
   */
  public function lastCreatedFirst()
  {
      return $this->addDescendingOrderByColumn(FilePeer::CREATED_AT);
  }

  /**
   * Order by create date asc
   *
   * @return     FileQuery The current query, for fluid interface
   */
  public function firstCreatedFirst()
  {
      return $this->addAscendingOrderByColumn(FilePeer::CREATED_AT);
  }
}
