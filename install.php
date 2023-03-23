<?php

require_once './src/Database.php';
require_once './src/Schema.class.php';

$database = new Database();
$database->connect();

// Get the schema base and install it.
$schema = new Schema();
$tables = $schema->getSchema();
foreach ($tables as $table_name => $fields) {
  $database->createTable($table_name, $fields);
}

$database->close();


print 'Database installed. <a href="/">Go to the main page.</a>';