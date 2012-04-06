<?php
/**
 * ECassandraCF.php
 * 
 * @author Trần Thanh Tùng <info@lintinzone.com>
 * @link http://lintinzone.com
 * @copyright Copyright &copy; 2012 LintinZone
 * @license http://www.yiiframework.com/license
 * @version 0.1
 * @category ext
 * @package ext.lz_cassandra.ar
 * @since v0.1
 */

require_once(dirname(__FILE__) . '/../phpcassa/columnfamily.php');

 /**
  * ECassandraCF represents a column family.
  * 
  * @author Trần Thanh Tùng <info@lintinzone.com>
  * @version 0.1
  * @package ext.lz_cassandra.ar
  * @since v0.1
  */
 class ECassandraCF extends CModel
 {
 	/**
	 * Name of the column family.
	 * @var string
	 */
	private $_cfName;
	
 	/**
	 * Pool of connections to database instances.
	 * @var ConnectionPool
	 */
 	private static $_connectionPool;
	
	/**
	 * The column family.
	 * @var ColumnFamily
	 */
	private $_columnFamily;
	
	private static $_models = array();
	
	/**
	 * Constructor.
	 * @param string $cfName the column family name (no prefix)
	 * @param string $scenario scenario name. See {@link CModel::scenario} for more details about this parameter
	 */
	public function __construct($cfName, $scenario = 'insert')
	{
		// Specify the column family.
		$this->_cfName = $cfName;
		
		if($scenario === null) // internally used by populateRecord() and model()
			return;

		$this->setScenario($scenario);
		$this->setIsNewRecord(true);
		//$this->_attributes=$this->getMetaData()->attributeDefaults;

		$this->init();

		$this->attachBehaviors($this->behaviors());
		$this->afterConstruct();
	}
	
	/**
	 * Initializes this model.
	 * This method is invoked when an ECassandraCF is newly created.
	 * You should override this method to provide code that is needed to initialize the model.
	 * For example, to specify a column family:
	 * <pre>
	 * 
	 * </pre>
	 */
 	public function init()
	{
		if (self::$_connectionPool === null)
		{
			self::$_connectionPool = Yii::app()->getComponent('cassandradb')->getConnectionPool();
			$this->_columnFamily = new ColumnFamily(self::$_connectionPool, $this->cfName());
		}
		if ($this->_columnFamily === null)
			$this->_columnFamily = new ColumnFamily(self::$_connectionPool, $this->cfName());
		parent::init();
	}
	
	/**
	 * Returns the static model of the specified ECassandraCF class.
	 * The model returned is a static instance of the ECassandraCF class.
	 * It is provided for invoking class-level methods.
	 *
	 * EVERY derived ECassandraCF class must override this method as follows,
	 * <pre>
	 * public static function model($className = __CLASS__)
	 * {
	 *     return parent::model($className);
	 * }
	 * </pre>
	 *
	 * @param string $className ECassandraCF class name.
	 * @return ECassandraCF ECassandraCF model instance.
	 * @since v0.1
	 */
	public static function model($className = __CLASS__)
	{
		// will return an instance of ColumnFamily class.
		if(isset(self::$_models[$className]))
			return self::$_models[$className];
		else
		{
			$model = self::$_models[$className] = new $className(null);
			//$model->_md = new CActiveRecordMetaData($model);
			$model->attachBehaviors($model->behaviors());
			return $model;
		}
	}
	
	/**
	 * Returns the name of the associated column family.
	 * @return string the column family name
	 */
	public function tableName()
	{
		return self::$_connectionPool->tablePrefix . $this->cfName();
	}
	
	/**
	 * Returns the name of the associated column family.
	 * @return string the column family name
	 */
	public function cfName()
	{
		return self::$_connectionPool->tablePrefix . $this->_cfName;
	}
	
	public function getPrimaryKey()
	{
		
	}
	
	/**
     * Fetches a row from this column family.
     *
     * @param string $key row key to fetch
     * @param mixed $columnStart only fetch columns with name >= this
     * @param mixed $columnFinish only fetch columns with name <= this
     * @param bool $columnReversed fetch the columns in reverse order
     * @param int $columnCount limit the number of columns returned to this amount
     * @param mixed $superColumn return only columns in this super column
     * @param cassandra_ConsistencyLevel $readConsistencyLevel affects the guaranteed
     *        number of nodes that must respond before the operation returns
     *
     * @return mixed array(column_name => column_value)
     */
    public function get($key,
                        $columns = null,
                        $columnStart = "",
                        $columnFinish = "",
                        $columnReversed = false,
                        $columnCount = ColumnFamily::DEFAULT_COLUMN_COUNT,
                        $superColumn = null,
                        $readConsistencyLevel = null)
	{
		return $this->_columnFamily->get($key, $columns, $columnStart, $columnFinish, $columnRversed,
											$columnCount, $superColumn, $readConsistencyLevel);
    }
	
	/**
     * Fetches a set of rows from this column family.
     *
     * @param string[] $keys row keys to fetch
     * @param mixed $columnStart only fetch columns with name >= this
     * @param mixed $columnFinish only fetch columns with name <= this
     * @param bool $columnReversed fetch the columns in reverse order
     * @param int $columnCount limit the number of columns returned to this amount
     * @param mixed $superColumn return only columns in this super column
     * @param cassandra_ConsistencyLevel $readConsistencyLevel affects the guaranteed
     *        number of nodes that must respond before the operation returns
     * @param int $bufferSize the number of keys to multiget at a single time. If your
     *        rows are large, having a high buffer size gives poor performance; if your
     *        rows are small, consider increasing this value.
     *
     * @return mixed array(key => array(column_name => column_value))
     */
    public function multiget($keys,
                             $columns = null,
                             $columnStart = "",
                             $columnFinish = "",
                             $columnReversed = false,
                             $columnCount = ColumnFamily::DEFAULT_COLUMN_COUNT,
                             $superColumn = null,
                             $readConsistencyLevel = null,
                             $bufferSize=16)
	{
		return $this->_columnFamily->multiget($keys, $columns, $columnStart, $columnFinish,
										$columnReversed, $columnCount, $superColumn, $readConsistencyLevel, $bufferSize);
    }
	
	/**
     * Counts the number of columns in a row.
     *
     * @param string $key row to be counted
     * @param mixed[] $columns limit the possible columns or super columns counted to this list
     * @param mixed $columnStart only count columns with name >= this
     * @param mixed $columnFinish only count columns with name <= this
     * @param mixed $superColumn count only columns in this super column
     * @param cassandra_ConsistencyLevel $readConsistencyLevel affects the guaranteed
     *        number of nodes that must respond before the operation returns
     *
     * @return int
     */
    public function getCount($key,
                              $columns=null,
                              $columnStart='',
                              $columnFinish='',
                              $superColumn=null,
                              $readConsistencyLevel=null)
	{
		return $this->_columnFamily->get_count($key, $columns, $columnStart, $columnFinish, $superColumn,
												$readConsistencyLevel);
    }

    /**
     * Counts the number of columns in a set of rows.
     *
     * @param string[] $keys rows to be counted
     * @param mixed[] $columns limit the possible columns or super columns counted to this list
     * @param mixed $columnStart only count columns with name >= this
     * @param mixed $columnFinish only count columns with name <= this
     * @param mixed $superColumn count only columns in this super column
     * @param cassandra_ConsistencyLevel $readConsistencyLevel affects the guaranteed
     *        number of nodes that must respond before the operation returns
     *
     * @return mixed array(row_key => row_count)
     */
    public function multigetCount($keys,
                                   $columns=null,
                                   $columnStart='',
                                   $columnFinish='',
                                   $superColumn=null,
                                   $readConsistencyLevel=null)
	{
		return $this->_columnFamily->multiget_count($keys, $columns, $columnStart, $columnFinish, $superColumn,
														$readConsistencyLevel);
    }
	
	/**
     * Gets an iterator over a range of rows.
     *
     * @param string $keyStart fetch rows with a key >= this
     * @param string $keyFinish fetch rows with a key <= this
     * @param int $rowCount limit the number of rows returned to this amount
     * @param mixed[] $columns limit the columns or super columns fetched to this list
     * @param mixed $columnStart only fetch columns with name >= this
     * @param mixed $columnFinish only fetch columns with name <= this
     * @param bool $columnReversed fetch the columns in reverse order
     * @param int $columnCount limit the number of columns returned to this amount
     * @param mixed $superColumn return only columns in this super column
     * @param cassandra_ConsistencyLevel $readConsistencyLevel affects the guaranteed
     *        number of nodes that must respond before the operation returns
     * @param int $bufferSize When calling `get_range`, the intermediate results need
     *        to be buffered if we are fetching many rows, otherwise the Cassandra
     *        server will overallocate memory and fail.  This is the size of
     *        that buffer in number of rows.
     *
     * @return RangeColumnFamilyIterator
     */
    public function getRange($keyStart = "",
                              $keyFinish = "",
                              $rowCount = ColumnFamily::DEFAULT_ROW_COUNT,
                              $columns = null,
                              $columnStart = "",
                              $columnFinish = "",
                              $columnReversed = false,
                              $columnCount = ColumnFamily::DEFAULT_COLUMN_COUNT,
                              $superColumn = null,
                              $readConsistencyLevel = null,
                              $bufferSize = null)
	{
		return $this->_columnFamily->get_range($keyStart, $keyFinish, $rowCount, $columns, $columnStart, $columnFinish,
											$columnReversed, $columnCount, $superColumn, $readConsistencyLevel, $bufferSize);
    }
	
	/**
    * FetchES a set of rows from this column family based on an index clause.
    *
    * @param cassandra_IndexClause $indexClause limits the keys that are returned based
    *        on expressions that compare the value of a column to a given value.  At least
    *        one of the expressions in the IndexClause must be on an indexed column. You
    *        can use the CassandraUtil::create_index_expression() and
    *        CassandraUtil::create_index_clause() methods to help build this.
    * @param mixed[] $columns limit the columns or super columns fetched to this list
    * @param mixed $columnStart only fetch columns with name >= this
    * @param mixed $columnFinish only fetch columns with name <= this
    * @param bool $columnReversed fetch the columns in reverse order
    * @param int $columnCount limit the number of columns returned to this amount
    * @param mixed $superColumn return only columns in this super column
    * @param cassandra_ConsistencyLevel $readConsistencyLevel affects the guaranteed
    * 		 number of nodes that must respond before the operation returns
    *
    * @return mixed array(row_key => array(column_name => column_value))
    */
    public function getIndexedSlices($indexClause,
                                       $columns = null,
                                       $columnStart = '',
                                       $columnFinish = '',
                                       $columnReversed = false,
                                       $columnCount = ColumnFamily::DEFAULT_COLUMN_COUNT,
                                       $superColumn = null,
                                       $readConsistencyLevel = null,
                                       $bufferSize = null)
	{
		return $this->_columnFamily->get_indexed_slices($indexClause, $columns, $columnStart, $columnFinish,
											$columnReversed, $columnCount, $superColumn, $readConsistencyLevel, $bufferSize);
    }
	
	/**
     * Inserts or updates columns in a row.
     *
     * @param string $key the row to insert or update the columns in
     * @param mixed $columns array(column_name => column_value) the columns to insert or update
     * @param int $timestamp the timestamp to use for this insertion. Leaving this as null will
     *        result in a timestamp being generated for you
     * @param int $ttl time to live for the columns; after ttl seconds they will be deleted
     * @param cassandra_ConsistencyLevel $writeConsistencyLevel affects the guaranteed
     *        number of nodes that must respond before the operation returns
     *
     * @return int the timestamp for the operation
     */
	public function insert($key, array $columns, $timestamp = null, $ttl = null, $writeConsistencyLevel = null)
	{
		return $this->_columnFamily->insert($key, $columns, $timestamp, $ttl, $writeConsistencyLevel);
	}
	
	/**
     * Inserts or updates columns in multiple rows. Note that this operation is only atomic
     * per row.
     *
     * @param array $rows an array of keys, each of which maps to an array of columns. This
     *        looks like array(key => array(column_name => column_value))
     * @param int $timestamp the timestamp to use for these insertions. Leaving this as null will
     *        result in a timestamp being generated for you
     * @param int $ttl time to live for the columns; after ttl seconds they will be deleted
     * @param cassandra_ConsistencyLevel $writeConsistencyLevel affects the guaranteed
     *        number of nodes that must respond before the operation returns
     *
     * @return int the timestamp for the operation
     */
    public function batchInsert($rows, $timestamp = null, $ttl = null, $writeConsistencyLevel = null)
    {
    	return $this->_columnFamily->batch_insert($rows, $timestamp, $ttl, $writeConsistencyLevel);
    }
	
	/**
     * Increments or decrements a counter.
     *
     * `value` should be an integer, either positive or negative, to be added
     * to a counter column. By default, `value` is 1.
     *
     * This method is not idempotent. Retrying a failed add may result
     * in a double count. You should consider using a separate
     * ConnectionPool with retries disabled for column families
     * with counters.
     *
     * Only available in Cassandra 0.8.0 and later.
     *
     * @param string $key the row to insert or update the columns in
     * @param mixed $column the column name of the counter
     * @param int $value the amount to adjust the counter by
     * @param mixed $superColumn the super column to use if this is a
     *        super column family
     * @param cassandra_ConsistencyLevel $writeConsistencyLevel affects the guaranteed
     *        number of nodes that must respond before the operation returns
	 * @param ECassandraConnection $cassandraConnection a separate connection pool to execute this kind of query.
	 * 		  If this value is left null, the current pool will be used.
     */
    public function add($key, $column, $value = 1, $superColumn=null,
								$writeConsistencyLevel = null, $cassandraConnection = null)
	{
		// If no separate connection is specified, use the current connection.
		if ($cassandraConnection === null)
		{
			$cassandraConnection = $this;
			$columnFamily = $this->_columnFamily;
		}
		else
		{
			// Create a new ColumnFamily instance to execute this query.
			$columnFamily = new ColumnFamily($cassandraConnection->getConnectionPool(), $this->cfName());
			$shouldDispose = true;
		}
		$returnValue = $columnFamily->add($key, $column, $value, $superColumn, $writeConsistencyLevel);
		// If the column family is newly created, dispose it.
		if (isset($shouldDispose) && $shouldDispose === true)
			$columnFamily = null;
		return $returnValue;
    }
	
	/**
	 * Updates a row.
     *
     * @param string $key the row to update the columns in
     * @param mixed $columns array(column_name => column_value) the columns to update
     * @param int $timestamp the timestamp to use for this insertion. Leaving this as null will
     *        result in a timestamp being generated for you
     * @param int $ttl time to live for the columns; after ttl seconds they will be deleted
     * @param cassandra_ConsistencyLevel $writeConsistencyLevel affects the guaranteed
     *        number of nodes that must respond before the operation returns
     *
     * @return int the timestamp for the operation
     */
	public function update($key, array $columns, $timestamp = null, $ttl = null, $writeConsistencyLevel = null)
	{
		return $this->_columnFamily->insert($key, $columns, $timestamp, $ttl, $writeConsistencyLevel);
	}
	
	/**
     * Removes columns from a row.
	 * My suggestion is not to allow users to delete any pieces of your data.
	 * Instead, use "soft delete" technique, which set a flag to indicate that a column or a row is deleted.
     *
     * @param string $key the row to remove columns from
     * @param mixed[] $columns the columns to remove. If null, the entire row will be removed.
     * @param mixed $superColumn only remove this super column
     * @param cassandra_ConsistencyLevel $writeConsistencyLevel affects the guaranteed
     *        number of nodes that must respond before the operation returns
     *
     * @return int the timestamp for the operation
     */
    public function delete($key, $columns = null, $superColumn = null, $writeConsistencyLevel = null)
    {
    	return $this->_columnFamily->remove($key, $columns, $superColumn, $writeConsistencyLevel);
    }
	
	/**
	 * Does nothing. This class does not represent a single row, but rather a column family (table in relation database).
	 * @return false
	 */
	public function save()
	{
		return false;
	}
 }