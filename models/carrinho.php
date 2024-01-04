<?php

class Carrinho{
    public $id;
    public $id_user;
    public $id_produto;
    public $quantidade;
    public $data;


    public $nome_produto;
    public $preco_produto;
}

interface CarrinhoDao{
    public function insert(Carrinho $c);
    public function getitemcarrinho($id_user, $id_produto);
    public function updateproduto($id_user, $id_produto, $novaquantidade);
    public function read($id_user);
    public function deletecarrinho($id);


}