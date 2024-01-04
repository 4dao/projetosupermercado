<?php

require_once 'models/contato.php';


class ContatoDaoMysql implements ContatoDao{

    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    public function insert(Contato $c){
        $sql = $this->pdo->prepare("INSERT INTO contato (nome, id_user, cpf, email, mensagem, data) VALUES (:nome, :id_user, :cpf, :email, :mensagem, :data)");
        $sql->bindValue(':nome', $c->nome);
        $sql->bindValue(':id_user', $c->id_user);
        $sql->bindValue(':cpf', $c->cpf);
        $sql->bindValue(':email', $c->email);
        $sql->bindValue(':mensagem', $c->mensagem);
        $sql->bindValue(':data', $c->data);
        $sql->execute(); 
    }

    public function readUser($id_user){
        $array = [];

        $sql = $this->pdo->prepare("SELECT * FROM contato WHERE id_user = :id_user ORDER BY id DESC ");
        $sql->bindValue('id_user', $id_user);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll();

            foreach($data as $contato){
                $r = new Contato();

                $r->id = $contato['id'];
                $r->id_user = $contato['id_user'];
                $r->cpf = $contato['cpf'];
                $r->nome = $contato['nome'];
                $r->email = $contato['email'];
                $r->mensagem = $contato['mensagem'];
                $r->data = $contato['data'];

                $array[] = $r;

            }
        }

        return $array;
        
    }

    public function read(){
        $array = [];

        $sql = $this->pdo->query("SELECT * FROM contato ORDER BY id DESC");


        if($sql->rowCount() > 0){
            $data = $sql->fetchAll();

            foreach($data as $contato){
                $r = new Contato();

                $r->id = $contato['id'];
                $r->id_user = $contato['id_user'];
                $r->cpf = $contato['cpf'];
                $r->nome = $contato['nome'];
                $r->email = $contato['email'];
                $r->mensagem = $contato['mensagem'];
                $r->data = $contato['data'];

                $array[] = $r;

            }
        }

        return $array;

    }


}