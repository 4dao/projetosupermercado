<?php
require_once 'config.php';
require_once 'dao/CarrinhoDaoMysql.php';
require_once 'models/auth.php';

// Verifica a autenticação do usuário e seu nível de acesso
$auth = new Auth($pdo, $base);
$userInfo = $auth->checkTokenAndAccess($nivel = null);

// Instancia o DAO do carrinho
$carrinhoDao = new CarrinhoDaoMysql($pdo);

// Obtém os itens do carrinho do usuário autenticado
$carrinhocliente = $carrinhoDao->read($userInfo->id);

// Calcula a quantidade de itens no carrinho
$quantitem = count($carrinhocliente);

// Verifica se o usuário está autenticado, é um usuário comum e tem itens no carrinho
if ($userInfo && $userInfo->nivel == 'user' && $quantitem > 0):
?>

<!-- Bloco HTML a ser exibido apenas se o usuário estiver autenticado e houver itens no carrinho -->
<div class="block-count">
    <!-- Exibe a quantidade de itens no carrinho -->
    <p>itens no carrinho: <?= $quantitem ?></p>
    <!-- Mensagem informativa sobre a remoção automática após 8h no carrinho -->
    <p id="msg">Os itens serão deletados automaticamente após 8h no carrinho</p>
</div>

<?php endif;

