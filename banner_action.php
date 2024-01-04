<?php

// Inclui o arquivo de configuração
require 'config.php';

// Inclui a classe BannerDaoMysql que lida com operações no banco de dados relacionadas a banners
require_once 'dao/BannerDaoMysql.php';

// Cria uma instância da classe BannerDaoMysql, passando a conexão PDO como parâmetro
$bannerdao = new BannerDaoMysql($pdo);

// Obtém o nome do arquivo do banner do formulário de upload
$banner = $_FILES['banner']['name'];

// Verifica se o banner foi enviado com sucesso
if ($banner) {

    // Obtém informações sobre o arquivo enviado
    $nomearquivo = $_FILES['banner']['name'];
    $caminhotemporario = $_FILES['banner']['tmp_name'];
    $caminhodestino = 'assets/banners/';

    // Verifica se o diretório de destino existe; se não existir, cria o diretório
    if (!is_dir($caminhodestino)) {
        mkdir($caminhodestino, 0777, true);
    }

    // Define o caminho final para o arquivo no diretório de destino
    $caminhofinal = $caminhodestino . $nomearquivo;

    // Move o arquivo temporário para o diretório de destino
    move_uploaded_file($caminhotemporario, $caminhofinal);

    // Verifica se o arquivo é uma imagem válida usando exif_imagetype
    if (exif_imagetype($caminhofinal)) {
        echo "Upload bem-sucedido!";
    } else {
        echo "O arquivo não é uma imagem válida.";
    }

    // Cria uma instância da classe Banner e define seus atributos
    $b = new Banner();
    $b->banner = $banner;
    $b->data = date("Y-m-d H:i:s");

    // Insere o banner no banco de dados usando o BannerDaoMysql
    $insert = $bannerdao->insert($b);

    // Redireciona para a página de banners após o upload bem-sucedido
    header("Location: banner.php");
    exit;
} else {
    // Se não houver banner enviado, exibe uma mensagem de erro
    echo 'Erro: Nenhum banner enviado.';
    exit;
}
