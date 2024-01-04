<?php
require_once 'config.php';
require_once 'dao/CarrinhoDaoMysql.php';
require_once 'models/auth.php';

// Inicializa a autenticação e obtém informações do usuário
$auth = new Auth($pdo, $base);
$userInfo = $auth->checkTokenAndAccess($nivel = null);

$carrinhoDao = new CarrinhoDaoMysql($pdo);
$somaTotal = 0;

// Verifica se o usuário está autenticado
if ($userInfo) {
    $carrinhocliente = $carrinhoDao->read($userInfo->id);

    // Calcula o preço total dos itens no carrinho
    foreach ($carrinhocliente as $item) {
        $somaTotal += is_numeric($item->preco_produto) ? (float)$item->preco_produto * $item->quantidade : 0;
    }
}

// Verifica se há itens no carrinho antes de exibir o HTML
if (count($carrinhocliente) > 0):
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Carrinho</title>
    <link rel="stylesheet" href="assets/carrinho.css">
</head>

<body>
    <section class="block">
        <div class="header">
            <h1>Meu carrinho de compras</h1>
            <!-- Exibe o preço total formatado -->
            Preço total: R$<?= number_format($somaTotal, 2, '.', '.') ?>
            <!-- Formulário para realizar a compra -->
            <form action="compra_action.php" method="post">
                <input type="hidden" value="<?= number_format($somaTotal, 2, '.', '.') ?>" name="preco_total">
                <button>Realizar Compra</button>
            </form>
        </div>

        <?php if ($carrinhocliente) : ?>
            <?php foreach ($carrinhocliente as $carrinho) : ?>
                <!-- Formulário para cada item no carrinho -->
                <form class="form">
                    <p id="nome"><?= $carrinho->nome_produto ?></p>
                    <p>R$<?= $carrinho->preco_produto ?></p>
                    <input type="number" class="quantity-input" value="<?= $carrinho->quantidade ?>" name="quantidade">
                    <a style="color: red; text-decoration: none;" href="delete_carrinho.php?id_carrinho=<?= $carrinho->id ?>&id_user=<?= $carrinho->id_user ?>">X</a>
                </form>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</body>

</html>
<?php endif; ?>
