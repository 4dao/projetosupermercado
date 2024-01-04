<?php
require_once 'config.php';
require_once 'models/auth.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$userInfo = $auth->checkAndDeleteExtraAdmins();
$userInfo = $auth->checkTokenAndAccess($nivel = 'admin');


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/painel.css">
    <title>Admin Page</title>
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" id="sidebar">
            <button id="toggleBtn" onclick="toggleSidebar()">☰</button>
            <ul>
                <li><a href="<?= $base ?>">Home</a></li>
                <li><a href="clientes.php">Clientes💻</a></li>
                <li><a href="funcionarios.php">Servidor👩‍👩‍👦‍👦</a></li>
                <li><a href="contato_cliente.php">Contato📱</a></li>
                <li><a href="compra_cliente.php">Compras🛍️</a></li>
                <li><a href="enviado_cliente.php">Enviados📩</a></li>
                <li><a href="#">Historico🗃️</a></li>
                <li><a href="produtos_cadastrados.php">Produtos🛒</a></li>
                <li><a href="banner.php">Banner🖼️</a></li>
                <li><a href="ofertas.php">Ofertas🎁</a></li>
                <li><a href="#">Relatorio📈</a></li>
                <li><a href="<?= $base ?>/sair/">Sair</a></li>
            </ul>
        </div>
        <div class="content">
            <!-- Conteúdo da página de admin aqui -->
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');
        }
    </script>
</body>

</html>