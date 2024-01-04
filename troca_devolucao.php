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
  <title>Política de Troca e Devolução - Supermercado Gerim</title>
  <link rel="stylesheet" href="<?= $base ?>/assets/troca-devolucao.css">
</head>
<body>
  <header>
    <h1>Política de Troca e Devolução - Supermercado Gerim</h1>
  </header>
  <section class="content">
    <p>Estamos comprometidos em proporcionar a você uma excelente experiência de compra no Supermercado Gerim. Caso precise realizar a troca ou devolução de um produto, siga as orientações abaixo:</p>

    <h2>Procedimento de Troca e Devolução na Loja Física</h2>

    <ol>
      <li>Leve o produto a ser trocado ou devolvido para a loja física do Supermercado Gerim.</li>
      <li>Apresente o comprovante de compra original, que pode ser o cupom fiscal ou a nota fiscal.</li>
      <li>Nosso atendente verificará o estado do produto e o motivo da troca ou devolução.</li>
      <li>Se a troca for aprovada, você poderá escolher um produto equivalente ou receber o reembolso do valor pago.</li>
      <li>Em caso de devolução, o valor será estornado de acordo com a política de reembolso.</li>
    </ol>

    <p>Nossa equipe estará à disposição para auxiliá-lo durante todo o processo, garantindo sua satisfação.</p>

    <p>Esta política de troca e devolução é válida para compras realizadas em nossa loja física e virtual. Para mais informações consulte nossos <a href="<?= $base ?>/termos-de-uso/"> Termos de Uso</a>.</p>
  </section>
  <footer>
    <p>&copy; 2023 Supermercado Gerim</p>
  </footer>
</body>
</html>
