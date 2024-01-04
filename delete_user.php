<?php

// Inclui o arquivo de configuração e as dependências necessárias
require_once 'config.php';
require_once 'models/auth.php';
require_once 'dao/UserDaoMysql.php';

// Instancia o objeto de autenticação
$auth = new Auth($pdo, $base);

// Verifica o token de autenticação e o nível de acesso do usuário
$userInfo = $auth->checkToken();
$userInfo = $auth->checkTokenAndAccess($nivel = 'admin');

// Instancia o DAO para manipulação de usuários
$userDao = new UserDaoMysql($pdo);

// Obtém o ID do usuário a ser removido da consulta GET
$id = filter_input(INPUT_GET, 'id');

// Verifica se o ID do usuário foi fornecido
if($id){

    // Verifica se o ID não corresponde ao ID do usuário atual
    if($id != $userInfo->id){
        // Chama o método delete no DAO para remover o usuário pelo ID
        $del = $userDao->delete($id);

        // Redireciona de volta para a página de clientes após a remoção
        header("Location: clientes.php");
        exit;
    }
    else{
        // Exibe um alerta e redireciona se o usuário tentar excluir a si mesmo (admin)
        echo '<script>';
        echo 'alert("IMPOSSÍVEL EXCLUIR ADMIN!");';
        echo 'window.location.href = "clientes.php";'; // Redireciona após o alerta
        echo '</script>';
        exit;
    }
}

// Exibe "erro" se o ID não foi passado corretamente
echo "Erro: ID do usuário não fornecido corretamente";
