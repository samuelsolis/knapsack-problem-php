<?php

/**
 * Class Schema.
 */
class Schema {

  /**
   * THe schema defined.
   *
   * @return array
   */
  public function getSchema() {
    $tables = array();
    $tables['items'] = array(
      'name' => 'varchar(255) NOT NULL UNIQUE',
      'volume' => 'int',
      'value' => 'int',
    );

    return $tables;
  }
}