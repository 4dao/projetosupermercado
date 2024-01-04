<?php
require_once "models/user.php";
require_once 'dao/ProdutoDaoMysql.php';
require_once 'models/auth.php';





class Produtoverify
{
    private $pdo;
    private $base;
    public function __construct(PDO $pdo, $base)
    {
        $this->pdo = $pdo;
        $this->base = $base;
    }

    public function cadastrarproduto($nome, $descricao, $categoria, $preco, $estoque, $imagem, $promocao, $valorpromocao)
    {
        $auth = new Auth($this->pdo, $this->base);
        if ($userInfo = $auth->checkTokenAndAccess($nivel = 'admin')) {
            echo 'nivel verificado';
        } else {
            echo 'nivel não compativel';
            exit;
        }

        $valorpromocaoreal = '';
        $valorpromocao = ($promocao < 1) ? '' : $valorpromocao;

        $produto = new Produto();
        $produto->nome = $nome;
        $produto->descricao = $descricao;
        $produto->categoria = $categoria;
        $produto->preco = $preco;
        $produto->estoque = $estoque;
        $produto->imagem = $imagem;
        $produto->data = date("Y-m-d H:i:s");
        $produto->promocao = $promocao;
        $produto->valorpromocao = $valorpromocao;

        $produtoDao = new ProdutoDaoMysql($this->pdo);
        $produtoDao->insert($produto);
    }

    public function editarproduto($id, $nome, $descricao, $categoria, $preco, $estoque, $promocao, $valorpromocao)
    {
        $auth = new Auth($this->pdo, $this->base);
        if ($userInfo = $auth->checkTokenAndAccess($nivel = 'admin')) {
            echo 'nivel verificado';
        } else {
            echo 'nivel não compativel';
            exit;
        }

        $valorpromocaoreal = '';
        $valorpromocao = ($promocao < 1) ? '' : $valorpromocao;


        $produto = new Produto();
        $produto->id = $id;
        $produto->nome = $nome;
        $produto->descricao = $descricao;
        $produto->categoria = $categoria;
        $produto->preco = $preco;
        $produto->estoque = $estoque;
        $produto->promocao = $promocao;
        $produto->valorpromocao = $valorpromocao;

        $produtoDao = new ProdutoDaoMysql($this->pdo);
        $produtoDao->update($produto);


    }
}
