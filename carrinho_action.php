<?php
require 'config.php';
require 'models/carrinhoverify.php';
require_once 'models/auth.php';

// Inicializa a autenticação e obtém informações do usuário
$auth = new Auth($pdo, $base);
$userInfo = $auth->checkTokenAndAccess($nivel = null);

// Array de resposta que será convertido para JSON
$response = [];

if (!$userInfo) {
    // Se o usuário não estiver autenticado, define mensagens de erro e redireciona para a página de login
    $response['success'] = false;
    $response['message'] = 'Usuário não autenticado';
    $response['redirect'] = "$base/login/"; // Adicione a página de login
} else {
    // Se o usuário estiver autenticado, continua com o processamento

    $Carrinhovarify = new Carrinhoverify($pdo, $base);

    // Obtém dados do formulário
    $id_user = filter_input(INPUT_POST, 'id_user');
    $id_produto = filter_input(INPUT_POST, 'id_produto');
    $quantidade = filter_input(INPUT_POST, 'quantidade');

    if ($id_user && $id_produto && $quantidade) {
        // Se os valores necessários foram passados corretamente

        // Verifica se o item já está no carrinho do usuário
        $verifyitem = $Carrinhovarify->verifyitem($id_produto, $id_user);

        // Verifica se a quantidade selecionada está dentro do estoque
        $verifyestoque = $Carrinhovarify->verifyestoque($quantidade, $id_produto);

        if ($verifyestoque) {
            // Se o estoque estiver OK

            $response['estoquetrue'] = true;

            if ($verifyitem) {
                // Se o item já está no carrinho, atualiza a quantidade
                $update = $Carrinhovarify->updatequantidade($id_user, $id_produto, $quantidade);
                $updateestoque = $Carrinhovarify->updateprodutoestoque($id_produto, $quantidade);
                $response['update'] = "Quantidade adicionada ao item $id_produto do carrinho";
            } else {
                // Se o item não está no carrinho, insere a compra do usuário no carrinho
                $insert = $Carrinhovarify->insertcar($id_user, $id_produto, $quantidade);
                $updateestoque = $Carrinhovarify->updateprodutoestoque($id_produto, $quantidade);
                $response['insertcar'] = 'Item adicionado ao carrinho';
            }
        } else {
            $response['estoque'] = 'O estoque não foi verificado corretamente';
        }
    } else {
        $response['erro'] = 'Erro: $id_user, $id_produto ou $quantidade não foram passadas corretamente'; // Mensagem de erro caso algum valor não seja passado
    }
}

// Define o tipo de conteúdo como JSON e imprime a resposta
header('Content-Type: application/json');
echo json_encode($response);
die();
