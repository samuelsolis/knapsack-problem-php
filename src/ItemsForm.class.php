<?php

require_once('Database.class.php');
require_once('Item.class.php');
require_once('vendor/autoload.php');

class ItemsForm {

  protected $items;
  protected $storageController;

  /**
   * ItemsForm constructor.
   *
   * @param Database $db
   *   The database.
   */
  public function __construct(Database $db) {
    $this->storageController = $db;

    $data = NULL;
    $this->storageController->connect();
    $query = 'SELECT name FROM items';
    $values = $this->storageController->query($query);

    while ($element = $values->fetch_row()) {
      $item = new Item($db);
      $item->load($element[0]);
      $this->items[] = $item;
    }
  }

  /**
   * Print the form in HTML.
   *
   * @throws \Twig\Error\LoaderError
   * @throws \Twig\Error\RuntimeError
   * @throws \Twig\Error\SyntaxError
   */
  public function render() {

    $loader = new \Twig_Loader_Filesystem(__DIR__.'/../templates');
    $twig = new \Twig_Environment($loader);

    print $twig->render('itemsForm.twig', ['items' => $this->items]);
  }


  /**
   * Submit method of the form.
   */
  public function submit() {

    /**
     * Manage updates.
     */
    $i = 1;
    while (isset($_POST['name' . $i])) {
      $item = new Item($this->storageController);
      $item->load($_POST['name' . $i]);
      $item->setValue($_POST['value' . $i]);
      $item->setVolume($_POST['volume' . $i]);
      $item->save();
      $i++;
    }

    /**
     * Add the new_one
     */
    if (!empty($_POST['name_new'])) {
      $item = new Item($this->storageController);
      $item->setName($_POST['name_new']);
      $item->setValue($_POST['value_new']);
      $item->setVolume($_POST['volume_new']);
      $item->save();
    }
  }
}