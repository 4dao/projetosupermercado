<?php
require_once 'models/carrinho.php';


class CarrinhoDaoMysql implements CarrinhoDao
{

    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    public function insert(Carrinho $c){

        $sql = $this->pdo->prepare("INSERT INTO carrinho (id_user, id_produto, quantidade, data) VALUES (:id_user, :id_produto, :quantidade, :data)");
        $sql->bindValue(':id_user', $c->id_user);
        $sql->bindValue(':id_produto', $c->id_produto);
        $sql->bindValue(':quantidade', $c->quantidade);
        $sql->bindValue(':data', $c->data);

        $sql->execute();

    }

    public function getitemcarrinho($id_user, $id_produto){
        $sql = $this->pdo->prepare("SELECT * FROM carrinho WHERE id_user=:id_user AND id_produto=:id_produto");
        $sql->bindValue(':id_user', $id_user);
        $sql->bindValue(':id_produto', $id_produto);

        $sql->execute();

        return $sql->fetch(PDO::FETCH_OBJ);
    }

    public function updateproduto($id_user, $id_produto, $quantidade){
        $sql = $this->pdo->prepare("UPDATE carrinho SET quantidade=:quantidade WHERE id_user=:id_user AND id_produto=:id_produto");
        $sql->bindValue(':quantidade', $quantidade);
        $sql->bindValue(':id_user', $id_user);
        $sql->bindValue(':id_produto', $id_produto);

        $sql->execute();

    }

    public function read($id_user){
        $array = [];
    
        $sql = $this->pdo->prepare("SELECT carrinho.*, produto.nome AS nome_produto, produto.preco 
                                    FROM carrinho
                                    INNER JOIN produto ON carrinho.id_produto = produto.id
                                    WHERE carrinho.id_user=:id_user ORDER BY id DESC");
        $sql->bindValue(':id_user', $id_user);
        $sql->execute();

    
        $data = $sql->fetchAll(PDO::FETCH_OBJ);
    
        foreach($data as $carrinho){
            $c = new Carrinho();
            $c->id = $carrinho->id;
            $c->id_user = $carrinho->id_user;
            $c->id_produto = $carrinho->id_produto;
            $c->quantidade = $carrinho->quantidade;
            $c->data = $carrinho->data;
            // Adicionando informações do produto
            $c->nome_produto = $carrinho->nome_produto;
            $c->preco_produto = $carrinho->preco;
    
            $array[] = $c;
        }
    
        return $array;
    }

    public function deletetemp($id_user){
        $sql = $this->pdo->prepare("DELETE FROM carrinho WHERE id_user=:id_user"); 
        $sql->bindValue(':id_user', $id_user);
        $sql->execute();
    }


    public function getExpiredItems($expirationTime) {
        $currentTime = time() - $expirationTime;
    
        $sql = $this->pdo->prepare("SELECT * FROM carrinho WHERE data < :expiration_time");
        $sql->bindValue(':expiration_time', date('Y-m-d H:i:s', $currentTime));
        $sql->execute();
    
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    public function deletecarrinho($id){
        $sql = $this->pdo->prepare("DELETE FROM carrinho WHERE id=:id");
        $sql->bindValue(':id', $id);
        $sql->execute();
    }
    
    
    
}