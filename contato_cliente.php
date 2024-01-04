<?php
require_once 'config.php';
require_once 'models/auth.php';
require_once 'dao/ContatoDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$userInfo = $auth->checkAndDeleteExtraAdmins();
$userInfo = $auth->checkTokenAndAccess($nivel = 'admin');

$ContatoDao = new ContatoDaoMysql($pdo, $base);

$contatos = $ContatoDao->read();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/contato.css">
</head>
<body>

<?php require 'partials/header_painel.php' ?>

    <section class="sec">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NOME</th>
                    <th>CPF</th>
                    <th>EMAIL</th>
                    <th>MENSAGEM</th>
                    <th>DATA</th>
                </tr>
            </thead>
            <?php foreach($contatos as $recla): ?>
            <tbody>
                <tr>
                    <td><?= $recla->id ?></td>
                    <td><?= $recla->nome ?></td>
                    <td><?= $recla->cpf ?></td>
                    <td><?= $recla->email ?></td>
                    <td><?= $recla->mensagem ?></td>
                    <td><?= $recla->data ?></td>
                </tr>
            </tbody>
            <?php endforeach; ?>
        </table>
    </section>

    
</body>
</html>