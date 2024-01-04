<?php

// Inclui o arquivo de configuração
require 'config.php';

// Inclui a classe Auth, que parece estar relacionada à autenticação de usuários
require_once 'models/auth.php';

// Obtém dados do formulário usando filter_input
$nome = filter_input(INPUT_POST, 'nome');
$cpf = filter_input(INPUT_POST, 'cpf');
$senha = filter_input(INPUT_POST, 'senha');

// Verifica se os campos obrigatórios foram preenchidos no formulário
if ($nome && $cpf && $senha) {

    // Cria uma instância da classe Auth, passando a conexão PDO e a URL base como parâmetros
    $auth = new Auth($pdo, $base);

    // Verifica se o CPF já existe no banco de dados
    if ($auth->cpfexist($cpf) === false) {
        // Se o CPF não existe, realiza o registro do usuário
        $auth->registroUser($nome, $cpf, $senha);

        // Redireciona para a página inicial após o registro bem-sucedido
        header("Location: $base");
        exit;
    } else {
        // Se o CPF já existe, define uma mensagem de erro na sessão e redireciona para a página de cadastro
        $_SESSION['cadastro_error'] = 'Erro: CPF já cadastrado, Faça login.';
        header("Location: cadastro.php");
        exit;
    }
}
