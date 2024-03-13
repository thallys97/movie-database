<?php

namespace App\Controllers;

use App\Database\Database;
use App\Models\User;

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'], $_POST['password'], $_POST['password_confirmation'])) {
            // Validar se as senhas coincidem
            if ($_POST['password'] !== $_POST['password_confirmation']) {
                die("As senhas não coincidem.");
            }
    
            // Processa o registro
            $email = trim($_POST['email']);
            $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
            $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    
            // Verificar se o email já está registrado
            if ($this->userModel->findUserByEmail($email)) {
                die("Email já está registrado.");
            }
    
            // Registrar o usuário
            if ($this->userModel->register($email, $password, $name)) {
                // Registro bem-sucedido
                header('Location: /login');
            } else {
                // Falha no registro
                die("Falha no registro do usuário.");
            }
        } else {
            // Carrega a view de registro
            $this->loadView('register');
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'], $_POST['password'])) {
            // Processa o login
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
    
            $loggedInUser = $this->userModel->login($email, $password);
    
            if ($loggedInUser) {
                // Cria a sessão do usuário
                session_start();
                $_SESSION['user_id'] = $loggedInUser->id;
                $_SESSION['user_email'] = $loggedInUser->email;
                $_SESSION['user_name'] = $loggedInUser->name;
    
                header('Location: /'); // Redireciona para a página inicial após o login
            } else {
                // Redireciona para a página de login com um parâmetro de erro
                header('Location: /login?error=login_failed');
                exit;
            }
        } else {
            // Carrega a view de login
            $this->loadView('login');
        }
    }

    public function logout() {
        // Destruir a sessão do usuário
        session_start();
        session_unset();
        session_destroy();

        header('Location: /login');
    }

    private function loadView($view, $data = []) {
        if (file_exists("../app/views/{$view}.php")) {
            require_once "../app/views/{$view}.php";
        } else {
            die("View does not exist.");
        }
    }
}
