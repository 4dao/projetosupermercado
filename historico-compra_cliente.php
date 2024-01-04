<?php
require_once 'config.php';
require_once 'models/auth.php';
require_once 'dao/EnviadoDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$userInfo = $auth->checkTokenAndAccess($nivel = 'user');

$enviadoDao = new EnviadoDaoMysql($pdo);

// Chame a função readadm para obter as compras, passando o id_user e a data desejada
// Para pegar todos os itens, deixe os parâmetros em branco
$comprasPorUsuarioEHash = $enviadoDao->readadmidcliente($userInfo->id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?= $base ?>/assets/historico-cliente.css">
</head>

<body>
    <!-- Inclui o cabeçalho da página -->
    <?php require 'partials/header.php' ?>

    <div id="container">
        <!-- Inclui o painel do usuário -->
        <?php require_once 'partials/painel_user.php' ?>

        <section class="section">
            <!-- Itera sobre as compras do usuário e exibe detalhes -->
            <?php foreach ($comprasPorUsuarioEHash as $chaveBloco => $enviados) : ?>
                
                <?php list($id_user, $idhash) = explode('_', $chaveBloco); ?>
                <div class="pedido">
                    <!-- Botão para exibir/ocultar detalhes da compra -->
                    <button id="exibir-compra" onclick="toggleContent(this)">exibir compra</button>

                    <!-- Detalhes do cliente -->
                    <div id="cliente">
                        <p><span>CLIENTE:</span> <?= $enviados[0]->nome_cliente ?></p>
                        <p><span>TELEFONE:</span> <?= $enviados[0]->telefone_cliente ?></p>
                        <p><span>ENDEREÇO:</span> <?= $enviados[0]->endereco_cliente ?></p>
                        <p><span>BAIRRO:</span> <?= $enviados[0]->bairro_cliente ?></p>
                        <p><span>CASA:</span> <?= $enviados[0]->numero_cliente ?></p>
                        <p><span>REFERENCIA:</span> <?= $enviados[0]->referencia_cliente ?></p>
                        <p><span>DATA:</span> <?= $enviados[0]->data ?></p>
                        <p><span>STATUS:</span> <?= $enviados[0]->status ?></p>
                    </div>

                    <!-- Conteúdo detalhado da compra -->
                    <div class="content-compras">
                    <div class="pedido-1">
                            <?php
                            $somaTotal = 2.50; // Reinicia para cada bloco
                            foreach ($enviados as $enviado) :
                                $somaTotal += is_numeric($enviado->preco) ? ((float)$enviado->preco * $enviado->quantidade) : 0;
                            ?>
                                <div class="pedido-div">
                                    <p id="item">item: <?= $enviado->nome_produto ?></p>
                                    <p id="preco"><?= $enviado->quantidade ?></p>
                                    <p id="preco">R$ <?= $enviado->preco ?></p>
                                </div>
                            <?php endforeach; ?>
                            <p>taxa de serviço: R$ 2.50</p>
                        </div>

                        <div class="pedido-2">
                            <!-- Exibe o preço total e método de pagamento -->
                            <p name id="preco">Preço total: R$ <?= number_format($somaTotal, 2, '.', ',') ?></p>
                            <p>PAGAMENTO NO LOCAL</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    </div>

    <!-- Script para mostrar/ocultar detalhes da compra -->
    <script>
        function toggleContent(button) {
            var content = button.parentNode.querySelector('.content-compras');
            content.style.display = (content.style.display === 'none' || content.style.display === '') ? 'block' : 'none';
        }
    </script>
</body>

</html>