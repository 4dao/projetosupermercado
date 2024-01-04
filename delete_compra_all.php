<?php

require_once 'config.php';
require_once 'models/auth.php';
require_once 'dao/CompraDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$Compra = new CompraDaoMysql($pdo);

$id_user = filter_input(INPUT_GET, 'id_user', FILTER_VALIDATE_INT);

if ($userInfo && $id_user && $userInfo->id == $id_user) {
    try {
        $del = $Compra->deletecompraall($id_user);
        header("Location: $base");
    } catch (\Throwable $th) {
        echo "erro ao deletar item, função comprometida!";
    }

} else {
    // Mensagem de erro se o ID não foi passado corretamente ou usuário não autenticado
    echo 'Erro: ID da compra ou ID do usuário não fornecido corretamente ou usuário não autorizado';
    exit;
}
