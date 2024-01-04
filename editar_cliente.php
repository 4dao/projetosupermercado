<?php
require_once 'config.php';
require_once 'models/auth.php';
require_once 'dao/UserDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$userInfo = $auth->checkTokenAndAccess($nivel = 'admin');


$userDao = new UserDaoMysql($pdo);


$nome = filter_input(INPUT_POST, 'nome');
$cpf = filter_input(INPUT_POST, 'cpf');
$endereco = filter_input(INPUT_POST, 'endereco');
$telefone = filter_input(INPUT_POST, 'telefone');
$bairro = filter_input(INPUT_POST, 'bairro');
$numero = filter_input(INPUT_POST, 'numero');
$referencia = filter_input(INPUT_POST, 'referencia');
$nivel = filter_input(INPUT_POST, 'nivel');
$id = filter_input(INPUT_GET, 'id');


if($nome && $cpf && $nivel){

    $up = new User();

    $up->nome = $nome;
    $up->cpf = $cpf;
    $up->endereco = $endereco;
    $up->telefone = $telefone;
    $up->bairro = $bairro;
    $up->numero = $numero;
    $up->referencia = $referencia;
    $up->nivel = $nivel;
    $up->id = $id;

    $userDao->updateuser($up);
    header("Location: clientes.php");
    exit;

}
else{
    echo 'erro';
    exit;
}