<?php

class Contato{

    public $id;
    public $id_user;
    public $nome;
    public $cpf;
    public $email;
    public $mensagem;
    public $data;
}

interface ContatoDao{
    public function insert(Contato $c);
    public function readUser($id_user);
    public function read();
}