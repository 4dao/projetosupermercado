<?php
require_once 'config.php';
require_once 'models/auth.php';
require_once 'dao/CompraDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkTokenAndAccess($nivel = null);

$compraDao = new CompraDaoMysql($pdo);

$compra = $compraDao->readadmid($userInfo->id);

foreach($compra as $id_user => $compras ){

    $status = $compras[0]->status;

    $pagamento = $compras[0]->pagamento;

}




?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Compras do Usuário</title>
    <style>
        .compra-block{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        #lista-de-compras {
            text-align: center;
        }
        #toggle-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
        }
         a{
            color: red ;
            text-decoration: none;
            font-size: 12px;
        }
    </style>
</head>
<body>
<section class="compra-block">
    <!-- Botão de alternância -->
    <button id="toggle-button" onclick="toggleLista()">Exibir/Ocultar Lista</button>

    <!-- Lista de compras do usuário -->
    <div id="lista-de-compras">
    <div class="conponente">
        <?php if($compra): ?>
            <a href="delete_compra_all.php?id_user=<?= $userInfo->id ?>">delete all</a>
            <p>STATUS: <?= $status ?></p>
            <p>PAGAMENTO: <?= $pagamento ?></p>
            <?php endif; ?>
        </div>

    <ul>
        <li>Taxa de serviço: R$ 2.50</li>
        <?php foreach($compra as $id_user => $compras ): ?>
            <?php foreach($compras as $item): ?>

            <li><?= $item->nome_produto ?> [<?= $item->quantidade ?>] - R$ <?= $item->preco ?> <a href="delete_compra.php?id_compra=<?= $item->id ?>&id_user=<?= $item->id_user ?>">X</a></li>

            <!-- Adicione mais itens conforme necessário -->
            <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    </div>
    </section>

    <!-- Conteúdo adicional do site pode vir aqui -->

    <script>
        function toggleLista() {
            var lista = document.getElementById("lista-de-compras");
            if (lista.style.display === "none") {
                lista.style.display = "block";
            } else {
                lista.style.display = "none";
            }
        }
    </script>
</body>
</html>
