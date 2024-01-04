<?php

require_once 'config.php';
require_once 'dao/CarrinhoDaoMysql.php';
require_once 'models/auth.php';
require_once 'dao/CompraDaoMysql.php';

// Inicializa a autenticação e obtém informações do usuário
$auth = new Auth($pdo, $base);
$userInfo = $auth->checkTokenAndAccess($nivel = null);

// Cria instâncias dos DAOs necessários
$CompraDao = new CompraDaoMysql($pdo);
$carrinhoDao = new CarrinhoDaoMysql($pdo);

// Lê os itens do carrinho para o usuário atual
$carrinhocliente = $carrinhoDao->read($userInfo->id);

// Obtém o preço total da compra a partir dos dados do formulário
$preco_total = filter_input(INPUT_POST, 'preco_total');

// Verifica se o usuário está autenticado e se há itens no carrinho
if ($userInfo && count($carrinhocliente) > 0) {

    // Obtém informações do usuário para a entrega
    $nome = $userInfo->nome;
    $cpf = $userInfo->cpf;
    $telefone = $userInfo->telefone;
    $endereco = $userInfo->endereco;
    $bairro = $userInfo->bairro;
    $numero = $userInfo->numero;
    $referencia = $userInfo->referencia;

    // Verifica se todas as informações de entrega foram fornecidas
    if ($nome && $cpf && $telefone && $endereco && $bairro && $numero && $referencia) {

        // Loop através dos itens do carrinho para criar registros de compra
        foreach ($carrinhocliente as $item) {
            $compra = new Compra();

            // Preenche os dados da compra com informações do carrinho e do usuário
            $compra->id_user = $item->id_user;
            $compra->id_produto = $item->id_produto;
            $compra->id_car = $item->id;
            $compra->preco = $item->preco_produto;
            $compra->nome_cliente = $nome;
            $compra->cpf_cliente = $cpf;
            $compra->telefone_cliente = $telefone;
            $compra->endereco_cliente = $endereco;
            $compra->bairro_cliente = $bairro;
            $compra->numero_cliente = $numero;
            $compra->referencia_cliente = $referencia;
            $compra->data = date("Y-m-d");
            $compra->quantidade = $item->quantidade;
            $compra->status = 'em preparo';

            // Insere o registro de compra no banco de dados
            $insert = $CompraDao->insert($compra);

            // Remove o item do carrinho
            $del = $carrinhoDao->deletetemp($item->id_user);
        }

        // Redireciona para a página principal após a conclusão da compra
        header("Location: $base");
    } else {
        // Exibe um alerta se as informações de entrega estiverem incompletas
        echo '<script>alert("Preencha as informações de entrega antes de comprar!");';
        echo 'window.location.href = "minha-conta/dados-cadastrados/";</script>';
    }
} else {
    // Exibe uma mensagem se o usuário não estiver logado ou se o carrinho estiver vazio
    echo 'Usuário não logado ou carrinho vazio';
    exit;
}
