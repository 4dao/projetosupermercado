<?php
require_once 'models/produto.php';


class ProdutoDaoMysql implements ProdutoDao
{

    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    private function gerarproduto($array)
    {
        $p = new Produto();

        $p->id = $array['id'] ?? 0;
        $p->nome = $array['nome'] ?? '';
        $p->descricao = $array['descricao'] ?? '';
        $p->categoria = $array['categoria'] ?? '';
        $p->preco = $array['preco'] ?? '';
        $p->estoque = $array['estoque'] ?? '';
        $p->imagem = $array['imagem'] ?? '';
        $p->data = $array['data'] ?? '';
        $p->promocao = $array['promocao'] ?? '';
        $p->valorpromocao = $array['valorpromocao'] ?? '';

        return $p;
    }

    public function insert(Produto $p)
    {
        $promocao = ($p->promocao === null) ? 0 : $p->promocao;

        $sql = $this->pdo->prepare("INSERT INTO produto (nome, descricao, categoria, preco, estoque, imagem, data, promocao, valorpromocao) VALUES (:nome, :descricao, :categoria, :preco, :estoque, :imagem, :data, :promocao, :valorpromocao)");
        $sql->bindValue(':nome', $p->nome);
        $sql->bindValue(':descricao', $p->descricao);
        $sql->bindValue(':categoria', $p->categoria);
        $sql->bindValue(':preco', $p->preco);
        $sql->bindValue(':estoque', $p->estoque);
        $sql->bindValue(':imagem', $p->imagem);
        $sql->bindValue(':data', $p->data);
        $sql->bindValue(':promocao', $promocao);
        $sql->bindValue(':valorpromocao', $p->valorpromocao);

        $sql->execute();
    }

    public function read()
    {
        $array = [];
        $sql = $this->pdo->query("SELECT * FROM produto ORDER BY promocao DESC, id DESC LIMIT 30");

        $data = $sql->fetchAll();

        foreach ($data as $produto) {
            $u = $this->gerarproduto($produto);

            $array[] = $u;
        }
        return $array;
    }
    public function readadmin()
    {
        $array = [];
        $sql = $this->pdo->query("SELECT * FROM produto ORDER BY promocao DESC, id DESC");

        $data = $sql->fetchAll();

        foreach ($data as $produto) {
            $u = $this->gerarproduto($produto);

            $array[] = $u;
        }
        return $array;
    }

    public function readpromocao()
    {
        $array = [];
        $sql = $this->pdo->query("SELECT * FROM produto WHERE promocao > 0 ORDER BY promocao DESC, id DESC");

        $data = $sql->fetchAll();

        foreach ($data as $produto) {
            $u = $this->gerarproduto($produto);
            $array[] = $u;
        }
        return $array;
    }


    public function findbyid($id)
    {
        $sql = $this->pdo->prepare("SELECT * FROM produto WHERE id=:id");
        $sql->bindValue(':id', $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $produto = $this->gerarproduto($data);

            return $produto;
        }
    }

    public function update(Produto $p)
    {

        $promocao = ($p->promocao === null) ? 0 : $p->promocao;

        $sql = $this->pdo->prepare("UPDATE produto SET nome=:nome, descricao=:descricao, categoria=:categoria, preco=:preco, estoque=:estoque, promocao=:promocao, valorpromocao=:valorpromocao WHERE id=:id ");
        $sql->bindValue(':nome', $p->nome);
        $sql->bindValue(':descricao', $p->descricao);
        $sql->bindValue(':categoria', $p->categoria);
        $sql->bindValue(':preco', $p->preco);
        $sql->bindValue(':estoque', $p->estoque);
        $sql->bindValue(':promocao', $promocao);
        $sql->bindValue(':valorpromocao', $p->valorpromocao);
        $sql->bindValue(':id', $p->id);

        $sql->execute();
    }

    public function delete($id)
    {
        $sql = $this->pdo->prepare("DELETE FROM produto WHERE id=:id");
        $sql->bindValue(':id', $id);

        $sql->execute();
    }

    public function updateestoque($id, $estoque)
    {
        $sql = $this->pdo->prepare("UPDATE produto SET estoque=:estoque WHERE id=:id");
        $sql->bindValue(':estoque', $estoque);
        $sql->bindValue(':id', $id);

        $sql->execute();
    }
}
