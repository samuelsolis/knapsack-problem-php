<?php

require_once 'Database.php';

class Item {

  protected $name;
  protected $value;
  protected $volume;

  /**
   * @var Database To persist the values.
   */
  protected $storageController;

  /**
   * @var bool Determine if the color is new or not.
   */
  protected $is_new;

  /**
   * Color constructor.
   *
   * @param Database $database
   */
  public function __construct(Database $database) {
    $this->storageController  = $database;
    $this->is_new = TRUE;
  }

  /**
   * Load the item from Database.
   *
   * @param $name
   *   The name of the item.
   *
   * @return bool
   *   TRUE if the value is loaded succesfully.
   */
  public function load($name) {
    $data = NULL;
    $this->storageController->connect();
    $query = 'SELECT * FROM items WHERE name="%s"';
    $query = sprintf($query, $name);
    $values = $this->storageController->query($query);
    if ($values) {
      $data = $values->fetch_all();
    }
    $this->storageController->close();
    if ($data) {
      $this->name= $data[0][0];
      $this->volume = $data[0][1];
      $this->value = $data[0][2];

      $this->is_new = FALSE;

      return TRUE;
    }
    return FALSE;
  }


  /**
   * Save the Item into the database.
   */
  public function save() {
    $this->storageController->connect();
    if ($this->is_new) {
      $query = 'INSERT INTO items (name,value,volume) VALUES ("%s",%d,%d)';
      $query = sprintf($query, $this->name, $this->value, $this->volume);
    }
    else {
      $query = 'UPDATE items SET `value`=%d,`volume`=%d WHERE name="%s"';
      $query = sprintf($query, $this->value, $this->volume, $this->name);
    }
    $this->storageController->query($query);
    $this->storageController->close();

    $this->is_new = FALSE;
  }

  /**
   * Remove from the database.
   */
  public function delete() {
    $this->storageController->connect();
    $query = sprintf('DELETE FROM items WHERE name="%s"', $this->name);
    $this->storageController->query($query);
    $this->storageController->close();

    $this->is_new = TRUE;
  }

  /**
   * Se the item name.
   *
   * @param string $name
   *   The item name.
   */
  public function setName($name) {
    $this->name = $name;
  }

  /**
   * Set the item value.
   *
   * @param int $value
   *   The value value.
   */
  public function setValue($value) {
    $this->value = $value;
  }

  /**
   * Set the item volume.
   *
   * @param int $volume
   *   The volume.
   */
  public function setVolume($volume) {
    $this->volume = $volume;
  }

  /**
   * Get the item name.
   *
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Get the item value.
   * @return int
   */
  public function getValue() {
    return $this->value;
  }

  /**
   * Get the item volume.
   *
   * @return int
   */
  public function getVolume() {
    return $this->volume;
  }
}