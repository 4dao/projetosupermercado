<?php
require_once 'config.php';
require_once 'models/auth.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

// Verifica o nível de acesso do usuário
if ($userInfo->nivel == 'user') {
    // Redireciona para a página Minha Conta se for um usuário comum
    header("Location: minha-conta/");
    exit;
} elseif ($userInfo->nivel == 'funcionario') {
    // Redireciona para a página do perfil do funcionário se for um funcionário
    header("Location: perfil_funcionario.php");
    exit;
} elseif ($userInfo->nivel == 'admin') {
    // Redireciona para o painel de administração se for um administrador
    header("Location: painel.php");
    exit;
} else {
    // Caso contrário, exibe uma mensagem de erro interno
    echo 'Usuario não logado';
    exit;
}
?>
