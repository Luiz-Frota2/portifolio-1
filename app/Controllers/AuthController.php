<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller {
    
    public function loginForm() {
        // Redirect if already logged in
        if (isset($_SESSION['user_id'])) {
            $this->redirect('dashboard');
        }
        
        $this->view('auth/login');
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                if ($user['active'] != 1) {
                    $this->view('auth/login', ['error' => 'Usuário inativo.']);
                    return;
                }

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['store_id'] = $user['store_id'];

                $this->redirect('dashboard');
            } else {
                $this->view('auth/login', ['error' => 'Credenciais inválidas.']);
            }
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('login');
    }
}
