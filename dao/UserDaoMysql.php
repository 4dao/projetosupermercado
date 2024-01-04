<?php

require_once 'models/user.php';


class UserDaoMysql implements UserDao
{

    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    private function gerarUser($array)
    {
        $u = new User();

        $u->id = $array['id'] ?? 0;
        $u->nome = $array['nome'] ?? '';
        $u->cpf = $array['cpf'] ?? '';
        $u->senha = $array['senha'] ?? '';
        $u->telefone = $array['telefone'] ?? '';
        $u->endereco = $array['endereco'] ?? '';
        $u->bairro = $array['bairro'] ?? '';
        $u->numero = $array['numero'] ?? '';
        $u->referencia = $array['referencia'] ?? '';
        $u->token = $array['token'] ?? '';
        $u->nivel = $array['nivel'] ?? '';
        $u->atividade = $array['atividade'] ?? '';

        return $u;
    }

    public function findbytoken($token)
    {
        if (!empty($token)) {
            $sql = $this->pdo->prepare("SELECT * FROM user WHERE token=:token");
            $sql->bindValue(':token', $token);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $data = $sql->fetch(PDO::FETCH_ASSOC);

                $user = $this->gerarUser($data);

                return $user;
            }
        }
        return false;
    }

    public function findbyCpf($cpf)
    {
        if (!empty($cpf)) {
            $sql = $this->pdo->prepare("SELECT * FROM user WHERE cpf=:cpf");
            $sql->bindValue(':cpf', $cpf);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $data = $sql->fetch(PDO::FETCH_ASSOC);

                $user = $this->gerarUser($data);

                return $user;
            }
        }
        return false;
    }

    public function insert(User $u)
    {
        $sql = $this->pdo->prepare("INSERT INTO user (nome, cpf, senha, token, nivel, atividade) VALUES (:nome, :cpf, :senha, :token, :nivel, :atividade) ");
        $sql->bindValue(':nome', $u->nome);
        $sql->bindValue(':cpf', $u->cpf);
        $sql->bindValue(':senha', $u->senha);
        $sql->bindValue(':senha', $u->senha);
        $sql->bindValue(':token', $u->token);
        $sql->bindValue(':nivel', $u->nivel = 'user');
        $sql->bindValue(':atividade', $u->atividade);


        $sql->execute();
    }

    public function updatetoken(User $u)
    {
        $sql = $this->pdo->prepare("UPDATE user SET cpf=:cpf, senha=:senha, token=:token WHERE id=:id");
        $sql->bindValue(':cpf', $u->cpf);
        $sql->bindValue(':senha', $u->senha);
        $sql->bindValue('token', $u->token);
        $sql->bindValue(':id', $u->id);
        $sql->execute();

        return true;
    }

    public function read()
    {
        $array = [];

        $sql = $this->pdo->query("SELECT * FROM user ORDER BY nivel ASC, id DESC");

        $data = $sql->fetchAll();

        foreach ($data as $userData) {

            $u = $this->gerarUser($userData);

            $array[] = $u;
        }



        return $array;
    }

    public function updateuser(User $u)
    {
        $sql = $this->pdo->prepare("UPDATE user SET nome=:nome, cpf=:cpf, endereco=:endereco, telefone=:telefone, bairro=:bairro, numero=:numero, referencia=:referencia, nivel=:nivel WHERE id=:id");
        $sql->bindValue(':nome', $u->nome);
        $sql->bindValue(':cpf', $u->cpf);
        $sql->bindValue(':telefone', $u->telefone);
        $sql->bindValue(':endereco', $u->endereco);
        $sql->bindValue(':bairro', $u->bairro);
        $sql->bindValue(':numero', $u->numero);
        $sql->bindValue(':referencia', $u->referencia);
        $sql->bindValue(':nivel', $u->nivel);
        $sql->bindValue(':id', $u->id);

        $sql->execute();
    }

    public function findAdminUsers()
    {
        $sql = $this->pdo->prepare("SELECT * FROM user WHERE nivel = 'admin'");
        $sql->execute();

        $adminUsers = [];

        while ($data = $sql->fetch(PDO::FETCH_ASSOC)) {
            $adminUsers[] = $this->gerarUser($data);
        }

        return $adminUsers;
    }

    public function delete($id)
    {

        $sql = $this->pdo->prepare("DELETE FROM user WHERE id=:id");
        $sql->bindValue(":id", $id);
        $sql->execute();
    }
}
