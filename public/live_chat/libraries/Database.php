<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');

/** 
 * Database class
 */ 
class Database {

	/**
	 * PDO
	 *
	 * @access private 
	 */
	private $PDO;

	/**
	 * Config
	 *
	 * @access private 
	 */	
	private $config;

	/**
	 * Where statements
	 *
	 * @access private
	 */	
	private $where;

	/**
	 * Constructor
	 * 
	 * @access public 
	 */	   		
	public function __construct() {
	
		if (!extension_loaded('pdo')) {
			
			die('The PDO extension is required.');
			
		}
		
		$this->config = config_load('database');
		
		$this->connect();
		
	}

	/**
     * Connect
     * 
     * @access private
     */		
	private function connect() {
		
		if (empty($this->config['db_driver'])) {
			
			die('Please set a valid database driver from config/database.php');
			
		}
		
		$driver = strtoupper($this->config['db_driver']);
		
		switch ($driver) {

			case 'MYSQL':

				try {
					
					$this->PDO = new PDO('mysql:host=' . $this->config['db_hostname'] . ';dbname=' . $this->config['db_name'], $this->config['db_username'], $this->config['db_password']);
					$this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$this->PDO->query('SET NAMES ' . $this->config['db_charset']);				
					
				} catch (PDOException $exception) {

					die($exception->getMessage());
						
				}
				
				return $this->PDO;
				
			break;

			default:
				die('This database driver does not support: ' . $this->config['db_driver']);

		}

	}
        
	/**
	 * Executes an sql statement
	 *
	 * @access public 
	 */
     public function query($statement) {
		
		try {
			
			return $this->PDO->query($statement);
		
		} catch (PDOException $exception) {
			
			die($exception->getMessage());
			
		}
		
	}

	/**
	 * Returns the number of rows affected
	 *
	 * @access public 
	 */	
    public function row_count($statement) {
	
		try {
		
			return $this->PDO->query($statement)->rowCount();

		} catch (PDOException $exception) {

			die($exception->getMessage());
			
		}

    }

	/**
	 * Execute query and return all rows in assoc array
	 *
	 * @access public 
	 */	
	public function fetch_all($statement, $fetch_style = PDO::FETCH_ASSOC) {
		
		try {
			
			return $this->PDO->query($statement)->fetchAll($fetch_style);

		} catch (PDOException $exception) {

			die($exception->getMessage());
			
		}
		
	}
	
	/**
	 * Execute query and return one row in assoc array
	 *
	 * @access public 
	 */
    public function fetch_row_assoc($statement) {
	
		try {
			
			return $this->PDO->query($statement)->fetch(PDO::FETCH_ASSOC);

		} catch (PDOException $exception) {

			die($exception->getMessage());
			
		}
		
    }

	/**
	 * Returns the id of the last inserted row
	 *
	 * @access public
	 */
	public function last_insert_id() {
		
		return $this->PDO->lastInsertId();
	
	}

	/**
	 * Builds the where statements to a sql query
	 * 
	 * @access public
	 */ 	
	public function where($value) {

		$this->where = $value;
		
		return $this;
		
	}
	
	/**
	 * Insert a value into a table
	 * 
	 * @access public
	 */ 
	public function insert($table, $values) {			
	
		try {
		
			foreach ($values as $key => $value) {
				
				$field_names[] = $key . ' = :' . $key;
				
			}
			
			$sql = "INSERT INTO " . $table . " SET " . implode(', ', $field_names);

			$stmt = $this->PDO->prepare($sql);
			
			foreach ($values as $key => $value) {
				
				$stmt->bindValue(':' . $key, $value);
				
			}
			
			$stmt->execute();

		} catch (PDOException $exception) {

			die($exception->getMessage());
			
		}

	}
	
	/**
	 * Update a value in a table
	 * 
	 * @access public
	 */ 
	public function update($table, $values) {

		try {

			foreach ($values as $key => $value) {
				
				$field_names[] = $key . ' = :' . $key;
				
			}
			
			$sql  = "UPDATE " . $table . " SET " . implode(', ', $field_names) . " ";
			
			$counter = 0;
			
			foreach ($this->where as $key => $value) {

				if ($counter == 0) {
					
					$sql .= "WHERE {$key} = :{$key} ";
					
				} else {
					
					$sql .= "AND {$key} = :{$key} ";
					
				}
				
				$counter++;
				
			}
			
			$stmt = $this->PDO->prepare($sql);
			
			foreach ($values as $key => $value) {
				
				$stmt->bindValue(':' . $key, $value);
				
			}
			
			foreach ($this->where as $key => $value) {
				
				$stmt->bindValue(':' . $key, $value);
				
			}
			
			$stmt->execute();

		} catch (PDOException $exception) {

			die($exception->getMessage());
			
		}

	}

	/**
	 * Delete a record
	 * 
	 * @access public
	 */ 
	public function delete($table) {

		$sql = "DELETE FROM " . $table . " ";
		
		$counter = 0;
		
		foreach ($this->where as $key => $value) {

			if ($counter == 0) {
				
				$sql .= "WHERE {$key} = :{$key} ";
				
			} else {
				
				$sql .= "AND {$key} = :{$key} ";
				
			}
			
			$counter++;
			
		}
		
		$stmt = $this->PDO->prepare($sql);
		
		foreach ($this->where as $key => $value) {
			
			$stmt->bindValue(':' . $key, $value);
			
		}

		$stmt->execute();

    }

}

?>
