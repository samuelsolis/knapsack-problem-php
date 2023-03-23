<?php

require_once('Database.php');
require_once('vendor/autoload.php');

/**
 * Class KnapsackForm
 */
class KnapsackForm {

  protected $size;

  /**
   * KnapsackForm constructor.
   */
  public function __construct() {
    $this->size = $_COOKIE['knapsacksize'];
  }

  /**
   * Print the form in HTML.
   *
   * @throws \Twig\Error\LoaderError
   * @throws \Twig\Error\RuntimeError
   * @throws \Twig\Error\SyntaxError
   */
  public function render() {

    $loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/templates');
    $twig = new \Twig\Environment($loader);
    print $twig->render('KnapsackSize.twig', ['size' => $this->size]);
  }


  /**
   * Submit method of the form.
   */
  public function submit() {

    if (isset($_GET['size'])) {
      setcookie ( 'knapsacksize', $_GET['size']);
      $this->size = $_GET['size'];
    }
  }
}