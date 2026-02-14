<?php
// app/controllers/LoginController.php

class LoginController extends Controller {
    
    public function index() {
        // Se já estiver logado, redireciona para dashboard
        if (isset($_SESSION['user_id'])) {
            $this->redirect('home/index');
        }

        // Buscar Filiais para o dropdown
        $filialModel = $this->model('Filial');
        $filiais = $filialModel->getAll();

        $data = [
            'view' => 'login/index',
            'error' => '',
            'filiais' => $filiais
        ];

        // Processar formulário de login via POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            $userModel = $this->model('User');
            $user = $userModel->login($email, $password);

            if ($user) {
                // Configurar Sessão
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nome'] = $user['nome'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_nivel'] = $user['nivel'];
                $_SESSION['user_nivel'] = $user['nivel'];
                
                // Definir Filial da Sessão (Pode ser a selecionada ou a do usuário)
                // Se o usuário selecionou uma, usamos ela. Se não, a do cadastro.
                $filial_selecionada = filter_input(INPUT_POST, 'filial_id', FILTER_VALIDATE_INT);
                $_SESSION['user_filial_id'] = $filial_selecionada ? $filial_selecionada : $user['filial_id'];

                $this->redirect('home/index');
            } else {
                $data['error'] = 'Credenciais inválidas ou usuário inativo.';
            }
        }

        // Carregar View de Login (sem header/footer padrão, layout limpo)
        require_once '../app/views/login/index.php';
    }

    public function logout() {
        session_destroy();
        $this->redirect('login');
    }
}
