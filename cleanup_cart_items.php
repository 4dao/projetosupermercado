<?php
require_once 'config.php';
require_once 'dao/CarrinhoDaoMysql.php';
require_once 'models/carrinhoverify.php';



$Carrinhovarify = new Carrinhoverify($pdo, $base);
$carrinhoDao = new CarrinhoDaoMysql($pdo, $base);


$testcar = $Carrinhovarify->estoqueExpiredItems();



// Obtém os itens no carrinho com mais de 60 segundos (1 minuto)
$expiredItems = $carrinhoDao->getExpiredItems(8 * 60 * 60);



// Deleta os itens expirados
foreach ($expiredItems as $item) {
    $carrinhoDao->deletetemp($item->id_user);
    echo "Itens com mais de 8h foram deletados dos carrinhos!</br>";
}





