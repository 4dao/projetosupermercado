<?php

class User {

    public $id;
    public $nome;
    public $cpf;
    public $senha;
    public $telefone;
    public $endereco;
    public $bairro;
    public $numero;
    public $referencia;
    public $token;
    public $nivel;
    public $atividade;

}

interface UserDao{
    public function findbytoken($token);
    public function findbyCpf($cpf);
    public function insert(User $u);
    public function updatetoken(User $u);
    public function read();
    public function updateuser(User $u);
    public function findAdminUsers();
    public function delete($id);
}