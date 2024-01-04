<?php
require_once 'config.php';
require_once 'models/auth.php';
require_once 'dao/EnviadoDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$userInfo = $auth->checkTokenAndAccess($nivel = 'user');

$enviadoDao = new EnviadoDaoMysql($pdo);

// Chame a função readadm para obter as compras
$enviado = $enviadoDao->readadmidcliente($userInfo->id);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $base ?>/assets/perfil.css">
    <title>Perfil do Usuário</title>
</head>

<body>
    <?php require 'partials/header.php' ?>

    <div id="container">
        <?php require 'partials/painel_user.php' ?>
        <div id="content">
            <div id="profile-info">
                <h1><?= $userInfo->nome ?></h1>
                <p>CPF: <?= $userInfo->cpf ?></p>
            </div>
            <div id="order-history">
                <h2>Última Compra</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID do Pedido</th>
                            <th>Data da Compra</th>
                            <th>Quantidade de Produtos</th>
                            <th>Taxa de Serviço</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($enviado as $chaveBloco => $enviados) : ?>
                            <?php $taxaServicoExibida = false; ?>
                            <?php foreach ($enviados as $enviado) : ?>
                                <tr>
                                    <td><?= $enviado->idhash ?></td>
                                    <td><?= $enviado->data ?></td>
                                    <td><?= $enviado->quantidade ?></td>
                                    <td><?php
                                        // Exibir taxa de serviço apenas uma vez
                                        if (!$taxaServicoExibida) {
                                            echo 'R$ 2.50';
                                            $taxaServicoExibida = true;
                                        }
                                        ?>
                                    </td>
                                    <td><?= $enviado->status ?></td>
                                </tr>
                            <?php endforeach; ?>

                        <?php break;
                        endforeach; ?>
                        <!-- Adicione mais linhas conforme necessário -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>