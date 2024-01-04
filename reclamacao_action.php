<?php

require_once 'config.php';
require_once 'models/auth.php';
require_once 'dao/ContatoDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$ContatoDao = new ContatoDaoMysql($pdo);

$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$id_user = filter_input(INPUT_POST, 'id_user', FILTER_VALIDATE_INT);
$cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_STRING);

if ($nome && $id_user && $cpf && $email && $mensagem) {
    $c = new Contato();
    $c->nome = $nome;
    $c->id_user = $id_user;
    $c->cpf = $cpf;
    $c->email = $email;
    $c->mensagem = $mensagem;
    $c->data = date("Y-m-d H:i:s");

    try {
        $ContatoDao->insert($c);
        header("Location: reclamacao.php");
        exit;
    } catch (Exception $e) {
        echo "Erro ao enviar a mensagem: " . $e->getMessage();
        // Considere redirecionar para uma página de erro ou tomar outra ação apropriada.
        exit;
    }
} else {
    echo "Erro nos dados de entrada";
    // Considere redirecionar para uma página de erro ou tomar outra ação apropriada.
    exit;
}
