<?php

require_once('Database.class.php');
require_once('vendor/autoload.php');

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

    $loader = new \Twig_Loader_Filesystem(__DIR__.'/../templates');
    $twig = new \Twig_Environment($loader);
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