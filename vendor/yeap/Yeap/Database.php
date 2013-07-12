<?php
/**
 * Database
 *
 * Provides a database wrapper around the PDO service to help reduce the effort
 * to interact with a data source.
 *
 * @package		MicroMVC
 * @author		David Pennington
 * @copyright	(c) 2011 MicroMVC Framework
 * @license		http://micromvc.com/license
 ********************************** 80 Columns *********************************
 */
namespace Yeap;

use Yeap\Config;
use \PDO;
use \PDOException;

class Database
{
	/**
	 * pdo 
	 * @var object
	 */
	public $pdo = NULL;
	
	/**
	 * database type mysql or pg
	 * @var string
	 */
	public $type = 'mysql';
	
	/**
	 * symbol mysql use "`"
	 * @var string
	 */
	public $i = '"';

	public $statements = array();

	private $config = array();

	public static $queries = array();

	public static $last_query = NULL;
	

	/**
	 * Set the database type and save the config for later.
	 *
	 * @param array $config
	 */
	public function __construct($name = '')
	{
		// Save config for connection
		$cfg = new Config('database');
		$config = $cfg->database;
		$current = $name && isset($config[$name]) ? $name : $cfg->active_db;
		$this->config = $config[$current];
		
		// Auto-detect database type from DNS
		$this->type = str_replace('pdo_', '', $config['driver']);

		// MySQL uses a non-standard column identifier
		if($this->type == 'mysql') {
			$this->i = '`';
		}
	}


	/**
	 * Database lazy-loading to setup connection only when finally needed
	 */
	public function connect()
	{
		extract($this->config);
		
		$dns = "{$this->type}:host={$host};port={$port};dbname={$dbname}";
		$param = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '{$charset}'");

		// Connect to PDO
		try {
			$this->pdo = new PDO($dns, $user, $password, $param);
		} catch(PDOException $e) {
			exit('db connection failed: ' . $e->getMessage());
		}
		
		// PDO should throw exceptions
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	
	/**
	 * reconnect pdo
	 */
	public function reconnect()
	{
		if(! $this->pdo) {
			$this->connect();
		}
	}

	/**
	 * Quotes a string for use in a query
	 *
	 * @param mixed $value to quote
	 * @return string
	 */
	public function quote($value)
	{
		$this->reconnect();
		return $this->pdo->quote($value);
	}


	/**
	 * Run a SQL query and return a single column (i.e. COUNT(*) queries)
	 *
	 * @param string $sql query to run
	 * @param array $params the prepared query params
	 * @param int $column the optional column to return
	 * @return mixed
	 */
	public function column($sql, array $params = NULL, $column = 0)
	{
		// If the query succeeds, fetch the column
		return ($statement = $this->query($sql, $params)) ? $statement->fetchColumn($column) : NULL;
	}


	/**
	 * Run a SQL query and return a single row object
	 *
	 * @param string $sql query to run
	 * @param array $params the prepared query params
	 * @param string $object the optional name of the class for this row
	 * @return array
	 */
	public function row($sql, array $params = NULL, $object = NULL)
	{
		if( ! $statement = $this->query($sql, $params)) {
			return;
		}

		$row = $statement->fetch(PDO::FETCH_OBJ);

		// If they want the row returned as a custom object
		if($object) {
			$row = new $object($row);
		}

		return $row;
	}


	/**
	 * Run a SQL query and return an array of row objects or an array
	 * consisting of all values of a single column.
	 *
	 * @param string $sql query to run
	 * @param array $params the optional prepared query params
	 * @param int $column the optional column to return
	 * @return array
	 */
	public function fetch($sql, array $params = NULL, $column = NULL)
	{
		if( ! $statement = $this->query($sql, $params)) {
			return;
		}

		// Return an array of records
		if($column === NULL) {
			return $statement->fetchAll(PDO::FETCH_OBJ);
		}

		// Fetch a certain column from all rows
		return $statement->fetchAll(PDO::FETCH_COLUMN , $column);
	}


	/**
	 * Run a SQL query and return the statement object
	 *
	 * @param string $sql query to run
	 * @param array $params the prepared query params
	 * @return PDOStatement
	 */
	public function query($sql, array $params = NULL, $cache_statement = FALSE)
	{
		$time = microtime(TRUE);

		self::$last_query = $sql;

		// Connect if needed
		$this->reconnect();

		// Should we cached PDOStatements? (Best for batch inserts/updates)
		if($cache_statement) {
			$hash = md5($sql);

			if(isset($this->statements[$hash])) {
				$statement = $this->statements[$hash];
			} else {
				$statement = $this->statements[$hash] = $this->pdo->prepare($sql);
			}
		} else {
			$statement = $this->pdo->prepare($sql);
		}

		$statement->execute($params);
		//$statement = $this->pdo->query($sql);

		// Save query results by database type
		self::$queries[$this->type][] = array(microtime(TRUE) - $time, $sql);

		return $statement;
	}


	/**
	 * Run a DELETE SQL query and return the number of rows deleted
	 *
	 * @param string $sql query to run
	 * @param array $params the prepared query params
	 * @return int
	 */
	public function delete($sql, array $params = NULL)
	{
		if($statement = $this->query($sql, $params))
		{
			return $statement->rowCount();
		}
	}


	/**
	 * Creates and runs an INSERT statement using the values provided
	 *
	 * @param string $table the table name
	 * @param array $data the column => value pairs
	 * @return int
	 */
	public function insert($table, array $data, $cache_statement = TRUE)
	{
		$i = $this->i;

		// Column names come from the array keys
		$columns = implode("$i, $i", array_keys($data));

		// Build prepared statement SQL
		$sql = "INSERT INTO $i$table$i ($i".$columns."$i) VALUES (" . rtrim(str_repeat('?, ', count($data)), ', ') . ')';	

		// PostgreSQL does not return the ID by default
		if($this->type == 'pgsql') {
			// Insert record and return the whole row (the "id" field may not exist)
			if($statement = $this->query($sql.' RETURNING "id"', array_values($data))) {
				// The first column *should* be the ID
				return $statement->fetchColumn(0);
			}
			return;
		}

		// Insert data and return the new row's ID
		return $this->query($sql, array_values($data), $cache_statement) ? $this->pdo->lastInsertId() : NULL;
	}


	/**
	 * Builds an UPDATE statement using the values provided.
	 * Create a basic WHERE section of a query using the format:
	 * array('column' => $value) or array("column = $value")
	 *
	 * @param string $table the table name
	 * @param array $data the column => value pairs
	 * @return int
	 */
	public function update($table, $data, array $where = NULL, $cache_statement = TRUE)
	{
		$i = $this->i;

		// Column names come from the array keys
		$columns = implode("$i = ?, $i", array_keys($data));

		// Build prepared statement SQL
		$sql = "UPDATE $i$table$i SET $i" . $columns . "$i = ? WHERE ";

		// Process WHERE conditions
		list($where, $params) = $this->where($where);

		// Append WHERE conditions to query and statement params
		if($statement = $this->query($sql . $where, array_merge(array_values($data), $params), $cache_statement))
		{
			return $statement->rowCount();
		}
	}


	/**
	 * Create a basic,  single-table SQL query
	 *
	 * @param string $columns
	 * @param string $table
	 * @param array $where array of conditions
	 * @param int $limit
	 * @param int $offset
	 * @param array $order array of order by conditions
	 * @return array
	 */
	public function select($column, $table, $where = NULL, $limit = NULL, $offset = 0, $order = NULL)
	{
		if(!$column) {
			$column = '*';
		}	
		$sql = "SELECT {$column} FROM {$this->i}{$table}{$this->i}";

		// Process WHERE conditions
		list($where, $params) = $this->where($where);

		// If there are any conditions, append them
		if($where) {
			$sql .= " WHERE $where";
		}

		// Append optional ORDER BY sorting
		$sql .= self::orderBy($order);

		// MySQL/SQLite use a different LIMIT syntax
		if($limit)
		{
			$sql .= $this->type == 'pgsql' ? " LIMIT {$limit} OFFSET {$offset}" : " LIMIT {$offset}, {$limit}";
		}

		return array($sql, $params);
	}


	/**
	 * Generate the SQL WHERE clause options from an array
	 *
	 * @param array $where array of column => $value indexes
	 * @return array
	 */
	public function where($where = NULL)
	{
		$a = $s = array();

		if($where) {
			foreach($where as $c => $v) {
				// Raw WHERE conditions are allowed array(0 => '"a" = NOW()')
				if(is_int($c)) {
					$s[] = $v;
				} else {
					// Column => Value
					$s[] = "{$this->i}{$c}{$this->i} = ?";
					$a[] = $v;
				}
			}
		}

		// Return an array with the SQL string + params
		return array(implode(' AND ', $s), $a);
	}


	/**
	 * Create the ORDER BY clause for MySQL and SQLite (still working on PostgreSQL)
	 *
	 * @param array $fields to order by array('id'=>'asc')
	 */
	public function orderBy($fields = NULL)
	{
		if( ! $fields) return;

		$sql = ' ORDER BY ';

		// Add each order clause
		foreach($fields as $k => $v) {
			$sql .= "{$this->i}{$k}{$this->i} {$v}, ";
		}

		// Remove ending ", "
		return substr($sql, 0, -2);
	}

}

// END
