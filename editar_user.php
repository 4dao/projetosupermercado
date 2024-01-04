<?php




require_once 'config.php';

require_once 'dao/UserDaoMysql.php';

require_once 'models/auth.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();



$userDao = new UserDaoMysql($pdo);


$nome = filter_input(INPUT_POST, 'nome');
$cpf = filter_input(INPUT_POST, 'cpf');
$endereco = filter_input(INPUT_POST, 'endereco');
$telefone = filter_input(INPUT_POST, 'telefone');
$bairro = filter_input(INPUT_POST, 'bairro');
$numero = filter_input(INPUT_POST, 'numero');
$referencia = filter_input(INPUT_POST, 'referencia');
$nivel = filter_input(INPUT_POST, 'nivel');
$id = filter_input(INPUT_POST, 'id');


if($id == $userInfo->id){
    echo "certo ate aqui";
exit;

    if($nome && $cpf){


        $up = new User();

        $up->nome = $nome;
        $up->cpf = $cpf;
        $up->endereco = $endereco;
        $up->telefone = $telefone;
        $up->bairro = $bairro;
        $up->numero = $numero;
        $up->referencia = $referencia;
        $up->nivel = $nivel;
        $up->id = $id;

        $userDao->updateuser($up);
        header("Location: $base/minha-conta/dados-cadastrados/");
        exit;

    }else{
        echo 'erro ao editar usuario!';
    }
}
else{
    echo 'Você não tem permissão para editar esse perfil!';
    exit;
}