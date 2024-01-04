<?php

class Produto{
    public $id;
    public $nome;
    public $descricao;
    public $categoria;
    public $preco;
    public $estoque;
    public $imagem;
    public $data;
    public $promocao;
    public $valorpromocao;
}

interface ProdutoDao{
    public function insert(Produto $p);
    public function read();
    public function findbyid($id);
    public function update(Produto $p);
    public function delete($id);
    public function updateestoque($id, $estoque);
}