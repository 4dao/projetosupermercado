<?php

require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/UserDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$userDao = new UserDaoMysql($pdo);



$allUsers = $userDao->read(); // Alterei o nome da variável para $allUsers

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];

    // Verificar se há usuários antes de filtrar
    if (!empty($allUsers)) {
        // Filtrar os usuários com base no nome ou CPF pesquisado
        $filteredUsers = array_filter($allUsers, function ($user) use ($search) {
            // Verificar se o nome ou CPF do usuário contém a pesquisa (case-insensitive)
            return stripos($user->nome, $search) !== false || stripos($user->cpf, $search) !== false;
        });

        // Usar os usuários filtrados para a iteração
        $allUsers = $filteredUsers;
    } else {
        // Se não houver usuários, definir $allUsers como um array vazio
        $allUsers = [];
    }
}
$count = count($allUsers);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="stylesheet" href="assets/clientes.css">
</head>

<body>

    <?php require 'partials/header_painel.php' ?>

    <section class="block">
        <div class="block_option">
            <a href="adicionar_usuario.php">Adicionar cliente</a>
            <a href="">Historico de conta</a>
        </div>

    </section>

    <section class="sec">
        <form id="forme" method="GET" action="">
            <input type="text" name="search" placeholder="Digite o nome do usuário ou cpf | clientes encontrados:<?= $count ?>">
            <button type="submit"><img src="assets/imagem/pesquisa.png" alt=""></button>
        </form>
        <table>
            <tr>
                <th>ID</th>
                <th>NOME</th>
                <th>CPF</th>
                <th>TELEFONE</th>
                <th>ENDEREÇO</th>
                <th>BAIRRO</th>
                <th>NUMERO</th>
                <th>REFERENCIA</th>
                <th>NIVEL</th>
                <th>DATA</th>
                <th>AÇÃO</th>
            </tr>

            <?php foreach ($allUsers as $user) : ?>
                <?php if ($user->nivel == 'user') : ?>

                    <tr>
                        <td><?= $user->id ?></td>
                        <td><?= substr($user->nome, 0, 20) ?></td>
                        <td><?= $user->cpf ?></td>
                        <td><?= $user->telefone ?></td>
                        <td><?= substr($user->endereco, 0, 20) ?></td>
                        <td><?= substr($user->bairro, 0, 20) ?></td>
                        <td><?= $user->numero ?></td>
                        <td><?= substr($user->referencia, 0, 10) ?></td>
                        <td><?= $user->nivel ?></td>
                        <td><?= substr($user->atividade, 0, 10) ?></td>
                        <td id="acao">
                            <button class="button" onclick="mostrarFormulario(<?= $user->id ?>)">editar</button>
                            <a class="button" href="delete_user.php?id=<?= $user->id ?>" onclick="return confirm('Tem certeza que deseja excluir o usuário: <?= $user->nome ?>?')">excluir</a>

                            <form class="editar" id="formulario-<?= $user->id ?>" method="post" action="editar_cliente.php?id=<?= $user->id ?>" style="display: none;">
                                <input type="text" name="nome" value="<?= $user->nome ?>" placeholder="nome completo" required><br>
                                <input type="text" name="cpf" value="<?= $user->cpf ?>" placeholder="cpf"><br>
                                <input type="text" name="telefone" value="<?= $user->telefone ?>" placeholder="telefone"><br>
                                <input type="text" name="endereco" value="<?= $user->endereco ?>" placeholder="endereco"><br>
                                <input type="text" name="bairro" value="<?= $user->bairro ?>" placeholder="bairro"><br>
                                <input type="text" name="numero" value="<?= $user->numero ?>" placeholder="numero"><br>
                                <input type="text" name="referencia" value="<?= $user->referencia ?>" placeholder="referencia"><br>
                                <input type="text" name="nivel" value="<?= $user->nivel ?>" placeholder="nivel"><br>
                                <button class="button" id="agendar">Salvar</button>
                            </form>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>
    </section>


    <script>
        function mostrarFormulario(profissionalId) {
            var formulario = document.getElementById("formulario-" + profissionalId);
            if (formulario.style.display === "none") {
                formulario.style.display = "block";
            } else {
                formulario.style.display = "none";
            }
        }
    </script>
</body>

</html>