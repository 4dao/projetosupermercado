<?php

// Inclui o arquivo de configuração e as dependências necessárias
require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/ProdutoDaoMysql.php';

// Instancia o objeto de autenticação
$auth = new Auth($pdo, $base);

// Verifica o token de autenticação e o nível de acesso do usuário
$checktoken = $auth->checkTokenAndAccess($nivel == 'admin');

// Instancia o DAO para manipulação de produtos
$produto = new ProdutoDaoMysql($pdo);

// Obtém o ID do produto a ser removido da consulta GET
$id = filter_input(INPUT_GET, 'id');

// Verifica se o ID do produto foi fornecido
if($id){
    // Chama o método delete no DAO para remover o produto pelo ID
    $del = $produto->delete($id);

    // Redireciona de volta para a página de produtos cadastrados após a remoção
    header("Location: produtos_cadastrados.php");
    exit;
} else {
    // Mensagem de erro se o ID não foi passado corretamente
    echo 'Erro: ID do produto não fornecido corretamente';
    exit;
}
