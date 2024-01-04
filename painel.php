<?php
require 'config.php';
require_once 'models/auth.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
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
    <?php require 'partials/header_painel.php' ?>
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
