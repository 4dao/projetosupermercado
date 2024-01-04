<?php
// Inclui os arquivos necessários
require_once 'config.php';
require_once 'models/Auth.php';

// Instancia a classe de autenticação com o banco de dados e a URL base
$auth = new Auth($pdo, $base);


// Verifica se o token do usuário é válido
$userInfo = $auth->checkToken();

// Verifica se o token do usuário é válido e se ele possui o nível de acesso de administrador
$userInfo = $auth->checkTokenAndAccess($nivel = 'admin');

// Obtém os dados do formulário
$nome = filter_input(INPUT_POST, 'nome');
$cpf = filter_input(INPUT_POST, 'cpf');
$senha = filter_input(INPUT_POST, 'senha');

// Verifica se todos os campos foram preenchidos no formulário
if ($nome && $cpf && $senha) {

    // Cria uma nova instância da classe de autenticação
    $auth = new Auth($pdo, $base);

    // Verifica se o CPF já existe no banco de dados
    if ($auth->cpfexist($cpf) === false) {
        // Adiciona um novo usuário ao banco de dados
        $auth->adicionarUser($nome, $cpf, $senha);
        
        // Redireciona para a página de clientes após adicionar o usuário
        header("Location: clientes.php");
        exit;
    }
}

// Se o CPF já existe, define uma mensagem de erro na sessão e redireciona para a página de adicionar usuário
$_SESSION['cadastro_error'] = 'Erro: CPF já cadastrado, Faça login.';
header("Location: adicionar_usuario.php");
exit;
