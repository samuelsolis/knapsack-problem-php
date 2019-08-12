<?php
require_once('Database.class.php');
require_once('Item.class.php');
require_once('vendor/autoload.php');

class Backtraking
{

  protected $item_volumes;
  protected $item_values;
  protected $item_names;
  protected $size;
  protected $storageController;

  /**
   * Backtraking constructor.
   *
   * @param Database $db
   *   The database.
   */
  public function __construct(Database $db){
    $this->storageController = $db;

    $data = NULL;
    $this->storageController->connect();
    $query = 'SELECT name FROM items';
    $values = $this->storageController->query($query);

    while ($element = $values->fetch_row()) {
      $item = new Item($db);
      $item->load($element[0]);
      $this->item_names[] = $item->getName();
      $this->item_values[] = $item->getValue();
      $this->item_volumes[] = $item->getVolume();
    }

    $this->size = $_COOKIE['knapsacksize'];
  }


  public function getItemNames() {
    return $this->item_names;
  }

  public function getItemValues() {
    return $this->item_values;
  }

  public function getItemVolumes() {
    return $this->item_volumes;
  }

  public function getSize() {
    return $this->size;
  }

  /**
   * @param $values
   *   Values (stored in array v)
   * @param $volumes
   *   Weights (stored in array w)
   * @param $current
   *   Number of distinct items (n)
   * @param $capacity
   *   Knapsack capacity
   *
   * @return int|mixed
   */
  public function knapSack($values, $volumes, $current, $capacity) {
    // base case: Negative capacity
    if ($capacity < 0) {
      return -1;
    }

    // base case: no items left or capacity becomes 0
    if ($current < 0 || $capacity == 0) {
      return 0;
    }

    // Case 1. include current item n in knapSack (v[n]) and recur for
    // remaining items (n - 1) with decreased capacity (W - w[n])
    $include = $values[$current] + $this->knapSack($values, $volumes, $current - 1, $capacity - $volumes[$current]);

    // Case 2. exclude current item n from knapSack and recur for
    // remaining items (n - 1)
    $exclude = $this->knapSack($values, $volumes, $current - 1, $capacity);

    // return maximum value we get by including or excluding current item
    return max($include, $exclude);
  }
}
