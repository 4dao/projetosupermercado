<?php
require_once 'config.php';
require_once 'models/auth.php';
require_once 'dao/EnviadoDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$userInfo = $auth->checkAndDeleteExtraAdmins();
$userInfo = $auth->checkTokenAndAccess($nivel = 'admin');

$enviadoDao = new EnviadoDaoMysql($pdo);

$id_user = filter_input(INPUT_GET, 'id');
$idhash = filter_input(INPUT_GET, 'idhash');

// Chame a função readadm para obter as compras
$enviado = $enviadoDao->readadmid($id_user, $idhash);



$total = filter_input(INPUT_GET, 'total');

foreach ($enviado as $chaveBloco => $enviados){
    foreach($enviados as $hash){
        $codigo_compra = $hash->idhash;
    }
}






?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Fiscal - Supermercado Gerim</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .nota-fiscal {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            width: 80%;
            margin: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .cabecalho {
            text-align: center;
            margin-bottom: 20px;
        }

        .itens {
            border-collapse: collapse;
            width: 100%;
        }

        .itens th,
        .itens td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .itens th {
            background-color: #f2f2f2;
        }

        .total {
            margin-top: 20px;
            text-align: right;
        }

        .assinatura {
            margin-top: 40px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="nota-fiscal">
        <div class="cabecalho">
            <h1>Nota Fiscal - Supermercado Gerim</h1>
            <p>Data: <?php echo date('d/m/Y'); ?></p>
        </div>

        <table class="itens">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aqui você pode adicionar linhas para cada item comprado -->
                <?php foreach ($enviado as $chaveBloco => $enviados) : ?>
                    <?php foreach ($enviados as $enviado) : ?>
                        <?php $totalcompra = $enviado->preco * $enviado->quantidade; ?>
                        <tr>
                            <td><?= $enviado->nome_produto ?></td>
                            <td><?= $enviado->quantidade ?></td>
                            <td><?= $enviado->preco ?></td>
                            <td><?= $totalcompra ?></td>
                            
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                            <td>Taxa de Entrega</td>
                            <td>1</td>
                            <td>2.50</td>
                            <td>2.50</td>
                            
                        </tr>


                    <!-- Adicione mais linhas conforme necessário -->
            </tbody>
            <div class="total">
                <p>preço total: <?= $total ?></p>
            </div>
        </table>
        <h1>Endereço do cliente</h1>
        <p><span>CLIENTE:</span> <?= $enviados[0]->nome_cliente ?></p>
        <p><span>CPF:</span> <?= $enviados[0]->cpf_cliente ?></p>
        <p><span>TELEFONE:</span> <?= $enviados[0]->telefone_cliente ?></p>
        <p><span>ENDEREÇO:</span> <?= $enviados[0]->endereco_cliente ?></p>
        <p><span>BAIRRO:</span> <?= $enviados[0]->bairro_cliente ?></p>
        <p><span>CASA:</span> <?= $enviados[0]->numero_cliente ?></p>
        <p><span>REFERENCIA:</span> <?= $enviados[0]->referencia_cliente ?></p>
        <p><span>DATA:</span> <?= $enviados[0]->data ?></p>
        <p><span>STATUS:</span> Enviado</p>
    <?php endforeach; ?>

    <div class="assinatura">
        <p>__________________________</p>
        <p>Assinatura do Cliente</p>
        <p>id: <?= $codigo_compra ?></p>
    </div>
    </div>

    <script>
        window.print();
    </script>
</body>

</html>