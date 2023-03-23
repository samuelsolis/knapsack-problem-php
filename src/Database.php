<?php
require_once 'config.php';

class Database {

  protected string $database_server;
  protected string  $database_name;
  protected string  $user;
  protected string $pass;
  protected int $port;

  /** @var \mysqli */
  protected ?mysqli $connection;

  /**
   * Database constructor.
   */
  public function __construct() {
    global $database;
    $this->database_server = $database['server'];
    $this->user = $database['user'];
    $this->pass = $database['pass'];
    $this->database_name = $database['name'];
    $this->port = $database['port'];
    $this->connection = null;

  }

  /**
   * Connect to the database.
   *
   * @return bool
   */
  public function connect() : bool{

      $this->connection = new mysqli($this->database_server, $this->user, $this->pass, $this->database_name, $this->port);

    // Check connection
    if ($this->connection->connect_error) {
      return FALSE;
    }
    // Choose the database inside the database server.
    $this->connection->select_db($this->database_name);
    return TRUE;
  }

  /**
   * Close the database connection.
   */
  public function close() {
    $this->connection->close();
  }

  /**
   * Create the table $name with the field specified in $fields.
   *
   * @param string $name
   *   Table name.
   * @param array $fields
   *   List of fields in string format.
   */
  public function createTable(string $name, array $fields) {
    $field_rendered = array();
    foreach ($fields as $field_name => $definition) {
      $field_rendered[] = $field_name . ' ' . $definition;
    }
    $field_rendered = implode(',', $field_rendered);
    $query = 'CREATE TABLE ' . $name . ' (' . $field_rendered . ')';
    $this->connection->query($query);
  }

    /**
     * Insert into $table de element describes in $values.
     * @param string $table
     * @param array $values
     */
  public function insert(string $table, array $values) {
    $query = 'INSERT INTO ' . $table . ' VALUES (' . implode(',', $values). ')';
    $this->connection->query($query);
  }

  /**
   * Execute the query into the database loaded.
   *
   * @param $query
   *   The Query
   * .
   * @return bool|mysqli_result
   */
  public function query(string $query): mysqli_result|bool {
    return $this->connection->query($query);
  }
}