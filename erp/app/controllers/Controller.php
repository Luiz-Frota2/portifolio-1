<?php
// app/controllers/Controller.php

class Controller {

    public function view($view, $data = []) {
        // Extrair dados para variáveis
        extract($data);

        // Verificar se arquivo da view existe
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            die("View '$view' não encontrada.");
        }
    }

    public function model($model) {
        if (file_exists('../app/models/' . $model . '.php')) {
            require_once '../app/models/' . $model . '.php';
            return new $model();
        } else {
            die("Model '$model' não encontrado.");
        }
    }

    public function redirect($url) {
        // Usa a constante BASE_URL definida no config.php para redirecionamento correto
        // Remove barras duplicadas se houver
        $url = ltrim($url, '/');
        header('Location: ' . BASE_URL . '/' . $url);
        exit;
    }
}
