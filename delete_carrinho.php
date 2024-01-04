<meta http-equiv="refresh" content="5; URL='<?php $base ?>'" />
<?php

require_once 'config.php';
require_once 'models/auth.php';
require_once 'dao/CarrinhoDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$carrinho = new CarrinhoDaoMysql($pdo);

$id_carrinho = filter_input(INPUT_GET, 'id_carrinho', FILTER_VALIDATE_INT);
$id_user = filter_input(INPUT_GET, 'id_user', FILTER_VALIDATE_INT);

if ($userInfo && $id_carrinho && $id_user && $userInfo->id == $id_user) {
    try {
        $del = $carrinho->deletecarrinho($id_carrinho);
        header("Location: $base");
    } catch (\Throwable $th) {
        echo "erro ao deletar item, função comprometida!";
    }

} else {
    // Mensagem de erro se o ID não foi passado corretamente ou usuário não autenticado
    echo 'Erro: ID da carrinho ou ID do usuário não fornecido corretamente ou usuário não autorizado';
    exit;
}
