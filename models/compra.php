<?php

class Compra{
    public $id;
    public $id_user;
    public $id_produto;
    public $id_car;
    public $preco;
    public $nome_cliente;
    public $cpf_cliente;
    public $telefone_cliente;
    public $endereco_cliente;
    public $bairro_cliente;
    public $numero_cliente;
    public $referencia_cliente;
    public $data;
    public $quantidade;
    public $status;
    public $pagamento;


    public $nome_produto;
}

interface CompraDao{
    public function insert(Compra $c);
    public function readadm();
    public function readadmid($id_user);
    public function deletecompra($id); 
    public function deletecompraall($id_user);
}