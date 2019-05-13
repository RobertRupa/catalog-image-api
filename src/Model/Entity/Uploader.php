<?php
// src/Model/Entity/Uploader.php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Uploader extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
        'slug' => false,
    ];
}