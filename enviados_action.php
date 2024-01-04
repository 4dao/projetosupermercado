<?php
require_once 'config.php';
require_once 'models/auth.php';
require_once 'dao/CompraDaoMysql.php';
require_once 'dao/EnviadoDaoMysql.php';

// Instancia o objeto de autenticação
$auth = new Auth($pdo, $base);

// Verifica e obtém as informações do usuário com base no token
$userInfo = $auth->checkToken();
$userInfo = $auth->checkAndDeleteExtraAdmins(); // Exclui administradores extras para garantir que apenas o usuário real seja considerado
$userInfo = $auth->checkTokenAndAccess($nivel = 'admin'); // Verifica se o usuário possui acesso de administrador

// Instancia os DAOs necessários para manipular compras e envios
$compraDao = new CompraDaoMysql($pdo);
$enviadoDao = new EnviadoDaoMysql($pdo);

// Obtém o ID do usuário da requisição POST
$id_user = filter_input(INPUT_POST, 'id_user');


// Chama a função readadmid para obter as compras do usuário com base no ID
$compra = $compraDao->readadmid($id_user);

// Gera um ID hash aleatório para ser associado a todos os itens enviados
$idhash = bin2hex(random_bytes(8));

// Itera sobre as compras do usuário
foreach ($compra[$id_user] as $compras) {

    // Cria um objeto Enviado com base nas informações da compra
    $enviados = new Enviado();
    $enviados->id_user = $compras->id_user;
    $enviados->id_produto = $compras->id_produto;
    $enviados->id_car = $compras->id_car;
    $enviados->idhash = $idhash;
    $enviados->preco = $compras->preco;
    $enviados->nome_cliente = $compras->nome_cliente;
    $enviados->cpf_cliente = $compras->cpf_cliente;
    $enviados->telefone_cliente = $compras->telefone_cliente;
    $enviados->endereco_cliente = $compras->endereco_cliente;
    $enviados->bairro_cliente = $compras->bairro_cliente;
    $enviados->numero_cliente = $compras->numero_cliente;
    $enviados->referencia_cliente = $compras->referencia_cliente;
    $enviados->data = $compras->data;
    $enviados->quantidade = $compras->quantidade;
    $enviados->status = $compras->status;
    $enviados->pagamento = $compras->pagamento;

    // Insere as informações na tabela Enviado
    $enviadoscompra = $enviadoDao->insert($enviados);

    $del = $compraDao->deletecompraenviado($id_user);
}

// Redireciona para a página de pedidos enviados
header("Location: enviado_cliente.php");
exit;
