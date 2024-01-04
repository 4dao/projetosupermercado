<?php
// Inclui o arquivo de configuração
require_once 'config.php';

// Inclui a classe Produtoverify, que parece ser responsável por verificar e cadastrar produtos
require_once 'models/produtoverify.php';

// Cria uma instância da classe Produtoverify, passando a conexão PDO e a URL base como parâmetros
$verify = new Produtoverify($pdo, $base);

// Obtém os dados do formulário usando filter_input
$nome = filter_input(INPUT_POST, 'nome');
$descricao = filter_input(INPUT_POST, 'descricao');
$categoria = filter_input(INPUT_POST, 'categoria');
$preco = filter_input(INPUT_POST, 'preco');
$estoque = filter_input(INPUT_POST, 'estoque');
$imagem = $_FILES['imagem']['name'];
$promocao = filter_input(INPUT_POST, 'promocao');
$valorpromocao = filter_input(INPUT_POST, 'valorpromocao');

// Verifica se as condições necessárias para cadastrar o produto estão satisfeitas
if ($promocao == 1 && $valorpromocao == '') {
    echo 'O VALOR DA OFERTA NÃO FOI PASSADO CORRETAMENTE!';
    exit;
}

// Verifica se todas as informações necessárias foram passadas no formulário
if ($nome && $descricao && $categoria && $preco && $estoque && $imagem) {

    // Move o arquivo de imagem para o diretório de destino

    $nomearquivo = $_FILES['imagem']['name'];
    $caminhotemporario = $_FILES['imagem']['tmp_name'];
    $caminhodestino = 'assets/imagem_produto/';

    // Verifica se o diretório de destino existe; se não existir, cria o diretório
    if (!is_dir($caminhodestino)) {
        mkdir($caminhodestino, 0777, true);
    }

    $caminhofinal = $caminhodestino . $nomearquivo;
    // Move o arquivo para o diretório de destino
    move_uploaded_file($caminhotemporario, $caminhofinal);

    // Verifica se o arquivo é uma imagem válida usando exif_imagetype
    if (exif_imagetype($caminhofinal)) {
        echo "Upload bem-sucedido!";
    } else {
        echo "O arquivo não é uma imagem válida.";
    }

    // Cadastra o produto utilizando o método cadastrarproduto da classe Produtoverify
    $cadastroproduto = $verify->cadastrarproduto($nome, $descricao, $categoria, $preco, $estoque, $imagem, $promocao, $valorpromocao);

    // Define uma mensagem de sucesso na sessão e redireciona para a página de produtos cadastrados
    $_SESSION['produto_cadastrado'] = 'Produto Cadastrado com Sucesso!';
    header("Location: produtos_cadastrados.php");
    exit;
} else {
    // Se algumas informações não foram passadas, exibe uma mensagem de erro
    echo 'ALGUMAS INFORMAÇÕES NÃO FORAM PASSADAS!';
    exit;
}
