<?php
require_once 'config.php';
require_once 'models/auth.php';
require_once 'dao/CompraDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$userInfo = $auth->checkAndDeleteExtraAdmins();
$userInfo = $auth->checkTokenAndAccess($nivel = 'admin');

$compraDao = new CompraDaoMysql($pdo);

// Chame a função readadm para obter as compras
$compra = $compraDao->readadm();
$somaTotal = 2.50;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/compra.css">
</head>

<body>

    <?php require_once 'partials/header_painel.php' ?>

    <section class="section">
        <?php foreach ($compra as $id_user => $compras) : ?>
            <div class="pedido">
                <button id="exibir-compra" onclick="toggleContent(this)">exibir compra</button>
                <div id="cliente">
                    <p><span>CLIENTE:</span> <?= $compras[0]->nome_cliente ?></p>
                    <p><span>CPF:</span> <?= $compras[0]->cpf_cliente ?></p>
                    <p><span>TELEFONE:</span> <?= $compras[0]->telefone_cliente ?></p>
                    <p><span>ENDEREÇO:</span> <?= $compras[0]->endereco_cliente ?></p>
                    <p><span>BAIRRO:</span> <?= $compras[0]->bairro_cliente ?></p>
                    <p><span>CASA:</span> <?= $compras[0]->numero_cliente ?></p>
                    <p><span>REFERENCIA:</span> <?= $compras[0]->referencia_cliente ?></p>
                    <p><span>DATA:</span> <?= $compras[0]->data ?></p>
                    <p><span>STATUS:</span> <?= $compras[0]->status ?></p>
                </div>

                <div class="content-compras">
                    <div class="pedido-1">
                        <?php foreach ($compras as $compra) : ?>
                            <?php
                            $somaTotal += is_numeric($compra->preco) ? ((float)$compra->preco * $compra->quantidade) : 0;                                 ?>
                            <div class="pedido-div">
                                <p id="item">item: <?= $compra->nome_produto ?></p>
                                <p id="preco"><?= $compra->quantidade ?></p>
                                <p id="preco">R$ <?= $compra->preco ?></p>
                            </div>
                        <?php endforeach; ?>
                        <p>taxa de serviço: R$ 2.50</p>

                    </div>

                    <div class="pedido-2">
                        <p name id="preco">Preço total: R$ <?= number_format($somaTotal, 2, '.', ',') ?></p>
                        <p>PAGAMENTO NO LOCAL</p>
                        <form action="enviados_action.php" method="post">

                            <button>O PEDIDO DE <?= $compras[0]->nome_cliente ?> JÁ ESTÁ PRONTO?</button>
                    </div>
                </div>
            </div>

            <input type="hidden" name="id_user" value="<?= $compras[0]->id_user ?>">
            <input type="hidden" name="nome_cliente" value="<?= $compras[0]->nome_cliente ?>">
            <input type="hidden" name="cpf_cliente" value="<?= $compras[0]->cpf_cliente ?>">
            <input type="hidden" name="telefone_cliente" value="<?= $compras[0]->telefone_cliente ?>">
            <input type="hidden" name="endereco_cliente" value="<?= $compras[0]->endereco_cliente ?>">
            <input type="hidden" name="bairro_cliente" value="<?= $compras[0]->bairro_cliente ?>">
            <input type="hidden" name="numero_cliente" value="<?= $compras[0]->numero_cliente ?>">
            <input type="hidden" name="referencia_cliente" value="<?= $compras[0]->referencia_cliente ?>">
            <input type="hidden" name="data" value="<?= $compras[0]->data ?>">
            <input type="hidden" name="status" value="<?= $compras[0]->status ?>">

            <input type="hidden" name="id_produto" value="<?= $compra->id_produto ?>">
            <input type="hidden" name="id_car" value="<?= $compra->id_car ?>">
            <input type="hidden" name="quantidade" value="<?= $compra->quantidade ?>">
            <input type="hidden" name="preco" value="<?= $compra->preco ?>">
            </form>

        <?php endforeach; ?>
    </section>


    <script>
        function toggleContent(button) {
            var content = button.parentNode.querySelector('.content-compras');
            content.style.display = (content.style.display === 'none' || content.style.display === '') ? 'block' : 'none';
        }
    </script>

</body>

</html>