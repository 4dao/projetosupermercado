<?php

require_once 'config.php';
require_once 'models/Auth.php';
require_once 'models/produtoverify.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkTokenAndAccess($nivel = 'admin');

$verify = new Produtoverify($pdo, $base);

$id = filter_input(INPUT_GET, 'id');
$nome = filter_input(INPUT_POST, 'nome');
$descricao = filter_input(INPUT_POST, 'descricao');
$categoria = filter_input(INPUT_POST, 'categoria');
$preco = filter_input(INPUT_POST, 'preco');
$estoque = filter_input(INPUT_POST, 'estoque');
$promocao = filter_input(INPUT_POST, 'promocao');
$valorpromocao = filter_input(INPUT_POST, 'valorpromocao');




if ($id && $nome && $descricao && $categoria && $preco && $estoque) {

    // cadastrar produto 
    $cadastroproduto = $verify->editarproduto($id, $nome, $descricao, $categoria, $preco, $estoque, $promocao, $valorpromocao);
    header("Location: produtos_cadastrados.php");
    exit;
} else {
    echo 'ALGUMAS INFORMAÇÕES NÃO FORAM PASSADAS!';
    exit;
}
