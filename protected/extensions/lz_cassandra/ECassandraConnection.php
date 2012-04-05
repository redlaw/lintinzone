<?php
/**
 * ECassandraConnection.php
 * 
 * @author Trần Thanh Tùng <info@lintinzone.com>
 * @link http://lintinzone.com
 * @copyright Copyright &copy; 2012 LintinZone
 * @license http://www.yiiframework.com/license
 * @version 0.1
 * @category ext
 * @package ext.lz_cassandra
 * @since v0.1
 */

require_once(dirname(__FILE__) . '/../phpcassa/connection.php');

 /**
  * ECassandraConnection represents a connection to database.
  * 
  * @author Trần Thanh Tùng <info@lintinzone.com>
  * @version 0.1
  * @package ext.lz_cassandra
  * @since 0.1
  */
 class ECassandraConnection extends CApplicationComponent
 {
 	/**
	 * Name of the keyspace.
	 * @var string
	 */
 	public $keyspace;
	
	/**
	 * An array of username and password to authenticate with Cassandra instance(s).
	 * @var array
	 */
	public $credentials;
	
	/**
	 * List of servers (host:port) that hold DB instances.
	 * @var array
	 */
	public $servers;
	
	/**
	 * The default prefix for column family names. Defaul value is empty.
	 * @string
	 */
	public $tablePrefix = '';
	
	/**
	 * The number of connections to keep in the pool.
	 * If $pool_size is left as NULL, max(5, count($servers) * 2) will be used.
	 * @var int
	 */
	public $poolSize;
	
	/**
	 * Indicates the max times that an operation should be retried before throwing a MaxRetriesException.
	 * Using 0 disables retries; -1 causes unlimited retries. The default is ConnectionPool::DEFAULT_MAX_RETRIES.
	 * @var int
	 */
	public $maxRetries = ConnectionPool::DEFAULT_MAX_RETRIES;
	
	/**
	 * The socket send timeout (in milliseconds). Default value is 5000.
	 * @var int
	 */
	public $sendTimeout = 5000;
	
	/**
	 * The socket receive timeout (in milliseconds). Default value is 5000.
	 * @var int
	 */
	public $recvTimeout = 5000;
	
	/**
	 * The maximum number of operations that a connection executes.
	 * When this number exceeds, the connection will be closed and replaced automatically.
	 * Default value is ConnectionPool::DEFAULT_RECYCLE
	 * @var int
	 */
	public $recycle = ConnectionPool::DEFAULT_RECYCLE;
	
	/**
	 * Indicates whether to use framed transport or buffered transport.
	 * This value must match Cassandra's configuration.
	 * In Cassandra 0.7, framed transport is the default.
	 * Default value is true.
	 * @var boolean
	 */
	public $frameTransport = true;
	
 	/**
	 * Pool of connections to database instances.
	 * @var ConnectionPool
	 */
 	private $_connectionPool;
	
	public function init()
	{
		if (empty($this->keyspace)
			|| empty($this->servers))
			return false;
		
		$this->_connectionPool = new ConnectionPool($this->keyspace,
													$this->servers,
													$this->poolSize,
													$this->maxRetries,
													$this->sendTimeout,
													$this->recvTimeout,
													$this->recycle,
													$this->credentials,
													$this->frameTransport);
		return true;
	}
	
	public function getConnectionPool()
	{
		return $this->_connectionPool;
	}
 }
