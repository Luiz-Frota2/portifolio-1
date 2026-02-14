<?php

namespace App\Core;

use Database;
use PDO;

class Model {
    protected $conn;

    public function __construct() {
        $this->conn = Database::connect();
    }
}
