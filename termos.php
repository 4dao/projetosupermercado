<?php
require_once 'config.php';
require_once 'models/auth.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$userInfo = $auth->checkTokenAndAccess($nivel = 'user');

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Termos de Uso - Supermercado Gerim</title>
  <link rel="stylesheet" href="<?= $base ?>/assets/termos.css">
</head>
<body>
  <header>
    <h1>Termos de Uso - Supermercado Gerim</h1>
  </header>
  <section class="content">
    <h2>1. Aceitação dos Termos</h2>
    <p>Ao acessar e utilizar o site do Supermercado Gerim ("nós", "nosso" ou "Supermercado Gerim"), você concorda em cumprir e ficar vinculado aos seguintes Termos de Uso. Estes termos se aplicam a todos os visitantes, usuários e outras pessoas que acessam ou utilizam o serviço.</p>

    <h2>2. Compras Online</h2>
    <p>O Supermercado Gerim oferece serviços de compras online. Ao realizar uma compra em nosso site, você concorda em fornecer informações precisas, completas e atualizadas para todas as compras realizadas em nossa loja.</p>

    <!-- Adicione mais seções conforme necessário -->

    <h2>3. Entrega</h2>
    <p>Oferecemos serviços de entrega para a comodidade dos nossos clientes. As informações de entrega devem ser fornecidas corretamente para garantir um serviço eficiente.</p>
  </section>
  <footer>
    <button id="aceitarButton">Aceitar Termos</button>
    <p>&copy; 2023 Supermercado Gerim</p>
  </footer>
  <script src="script.js"></script>
</body>
</html>
