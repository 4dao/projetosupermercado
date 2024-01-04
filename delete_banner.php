<?php

// Inclui o arquivo de configuração e as dependências necessárias
require 'config.php';
require_once 'dao/BannerDaoMysql.php';
require_once 'models/auth.php';

// Instancia o objeto de autenticação
$auth = new Auth($pdo, $base);

// Verifica se o usuário autenticado tem acesso de administrador
$userInfo = $auth->checkTokenAndAccess($nivel = 'admin');

// Instancia o DAO para manipulação de banners
$bannerDao = new BannerDaoMysql($pdo);

// Obtém o ID do banner a ser removido da consulta GET
$id = filter_input(INPUT_GET, 'id');

// Verifica se o ID do banner foi fornecido
if($id){

    // Chama o método delete no DAO para remover o banner pelo ID
    $b = $bannerDao->delete($id);

    // Redireciona de volta para a página de banners após a remoção
    header("Location: banner.php");
    exit;
} else {
    // Mensagem de erro se o ID não foi passado corretamente
    echo 'Erro ao deletar banner, o ID não foi passado corretamente!';
    exit;
}
