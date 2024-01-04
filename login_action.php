<?php

// Inclui o arquivo de configuração e o modelo de autenticação
require 'config.php';
require 'models/auth.php';

// Obtém os valores do formulário de login
$cpf = filter_input(INPUT_POST, 'cpf');
$senha = filter_input(INPUT_POST, 'senha');

// Verifica se o CPF e a senha foram fornecidos
if ($cpf && $senha) {
    // Instancia o objeto de autenticação
    $auth = new Auth($pdo, $base);

    // Verifica se o login é válido usando o método validadeLogin
    if ($auth->validadeLogin($cpf, $senha)) {
        // Redireciona para a página principal se o login for bem-sucedido
        header("Location: $base");
        exit;
    } else {
        // Se o login falhar, define uma mensagem de erro na sessão e redireciona de volta para a página de login
        $_SESSION['login_error'] = 'Erro: CPF ou senha incorretos.';
        header("Location: login/");
        exit;
    }
} else {
    // Se o CPF ou senha não forem fornecidos, define uma mensagem de erro na sessão e redireciona de volta para a página de login
    $_SESSION['login_error'] = 'Erro: CPF ou senha incorretos.';
    header("Location: login/");
    exit;
}
?>
