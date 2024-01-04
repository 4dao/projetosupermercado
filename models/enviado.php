<?php

class Enviado{
    public $id;
    public $id_user;
    public $id_produto;
    public $id_car;
    public $idhash;
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

interface EnviadoDao{
    public function insert(Enviado $c);
    public function readadm();
    public function readadmid($id_user, $idhash);
    public function readadmidcliente($id_user);
}