<?php
// app/models/Filial.php

class Filial extends Model {
    
    public function getAll() {
        $stmt = $this->db->query("SELECT id, nome FROM filiais ORDER BY nome");
        return $stmt->fetchAll();
    }
}
