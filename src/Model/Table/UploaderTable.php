<?php
// src/Model/Table/UploaderTable.php
namespace App\Model\Table;

use Cake\ORM\Table;

class UploaderTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
    }
}