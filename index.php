<?php

require_once('vendor/autoload.php');

require_once('src/Database.class.php');
require_once('src/ItemsForm.class.php');
require_once('src/KnapsackForm.class.php');
require_once('src/Backtraking.class.php');

// Item control.
$db = new Database();
$form = new ItemsForm($db);

if (!empty($_POST)) {
  $form->submit();
  // Reload the data.
  $form = new ItemsForm($db);
}
$form->render();

// Knapsack size control.
$knapForm = new KnapsackForm();
if (!empty($_GET)) {
  $knapForm->submit();
}

$knapForm->render();


// KnapsackSize Algorithm
$algorithm = new Backtraking($db);

$values = $algorithm->getItemValues();
$max_value = $algorithm->knapSack($values, $algorithm->getItemVolumes(), count($values) - 1, $algorithm->getSize());

print '<p> The higher volume that can contain the knamsack is ' . $max_value;