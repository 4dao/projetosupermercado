<?php

require_once 'models/Compra.php';
require_once 'models/produto.php';


class CompraDaoMysql implements CompraDao{

    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }


    public function insert(Compra $c){
        $sql = $this->pdo->prepare("INSERT INTO compra (id_user, id_produto, id_car, preco_total, nome_cliente, cpf_cliente, telefone_cliente,
        endereco_cliente, bairro_cliente, numero_cliente, referencia_cliente, data, quantidade, status, pagamento) VALUES (:id_user, :id_produto, :id_car, :preco_total, :nome_cliente, :cpf_cliente, :telefone_cliente,
        :endereco_cliente, :bairro_cliente, :numero_cliente, :referencia_cliente, :data, :quantidade, :status, :pagamento)");
        $sql->bindValue('id_user', $c->id_user);
        $sql->bindValue('id_produto', $c->id_produto);
        $sql->bindValue('id_car', $c->id_car);
        $sql->bindValue('preco_total', $c->preco);
        $sql->bindValue('nome_cliente', $c->nome_cliente);
        $sql->bindValue('cpf_cliente', $c->cpf_cliente);
        $sql->bindValue('telefone_cliente', $c->telefone_cliente);
        $sql->bindValue('endereco_cliente', $c->endereco_cliente);
        $sql->bindValue('bairro_cliente', $c->bairro_cliente);
        $sql->bindValue('numero_cliente', $c->numero_cliente);
        $sql->bindValue('referencia_cliente', $c->referencia_cliente);
        $sql->bindValue('data', $c->data);
        $sql->bindValue('quantidade', $c->quantidade);
        $sql->bindValue('status', $c->status);
        $sql->bindValue('pagamento', 'em dinheiro');


        $sql->execute();
    }

    public function readadm() {
        $comprasPorUsuario = array();
    
        $sql = $this->pdo->query("SELECT c.*, p.* FROM compra c
                                 JOIN produto p ON c.id_produto = p.id");
        $sql->execute();
    
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
    
            foreach ($data as $conteudo) {
                $c = new Compra();
                $c->id = $conteudo['id'];
                $c->id_user = $conteudo['id_user'];
                $c->id_produto = $conteudo['id_produto'];
                $c->id_car = $conteudo['id_car'];
                $c->preco = $conteudo['preco_total'];
                $c->nome_cliente = $conteudo['nome_cliente'];
                $c->cpf_cliente = $conteudo['cpf_cliente'];
                $c->telefone_cliente = $conteudo['telefone_cliente'];
                $c->endereco_cliente = $conteudo['endereco_cliente'];
                $c->bairro_cliente = $conteudo['bairro_cliente'];
                $c->numero_cliente = $conteudo['numero_cliente'];
                $c->referencia_cliente = $conteudo['referencia_cliente'];
    
                // Ajustar o formato da data usando DateTime
                $c->data = (new DateTime($conteudo['data']))->format('Y-m-d H:i:s');
    
                $c->quantidade = $conteudo['quantidade'];
                $c->status = $conteudo['status'];
    
                // Informações adicionais do produto
                $c->nome_produto = $conteudo['nome'];
                // Adicione mais campos conforme necessário
    
                $id_user = $c->id_user;
    
                if (!array_key_exists($id_user, $comprasPorUsuario)) {
                    $comprasPorUsuario[$id_user] = array();
                }
    
                $comprasPorUsuario[$id_user][] = $c;
            }
        }
    
        return $comprasPorUsuario;
    }
    

    public function readadmid($id_user) {
        $comprasPorUsuario = array();
    
        $sql = $this->pdo->prepare("SELECT c.*, p.nome as nome_produto FROM compra c
                                   JOIN produto p ON c.id_produto = p.id
                                   WHERE c.id_user = :id_user");
        $sql->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $sql->execute();
    
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($data as $conteudo) {
                $c = new Compra();
                $c->id = $conteudo['id'];
                $c->id_user = $conteudo['id_user'];
                $c->id_produto = $conteudo['id_produto'];
                $c->id_car = $conteudo['id_car'];
                $c->preco = $conteudo['preco_total'];
                $c->nome_cliente = $conteudo['nome_cliente'];
                $c->cpf_cliente = $conteudo['cpf_cliente'];
                $c->telefone_cliente = $conteudo['telefone_cliente'];
                $c->endereco_cliente = $conteudo['endereco_cliente'];
                $c->bairro_cliente = $conteudo['bairro_cliente'];
                $c->numero_cliente = $conteudo['numero_cliente'];
                $c->referencia_cliente = $conteudo['referencia_cliente'];
                $c->data = $conteudo['data'];
                $c->quantidade = $conteudo['quantidade'];
                $c->status = $conteudo['status'];
                $c->pagamento = $conteudo['pagamento'];
                $c->nome_produto = $conteudo['nome_produto'];
    
                // Adicione mais campos conforme necessário
    
                if (!array_key_exists($id_user, $comprasPorUsuario)) {
                    $comprasPorUsuario[$id_user] = array();
                }
    
                $comprasPorUsuario[$id_user][] = $c;
            }
        }
    
        return $comprasPorUsuario;
    }
    
    public function deletecompra($id){
        $sql = $this->pdo->prepare("DELETE FROM compra WHERE id=:id");
        $sql->bindValue(":id", $id);
        $sql->execute();

    }
    public function deletecompraenviado($id_user){
        $sql = $this->pdo->prepare("DELETE FROM compra WHERE id_user=:id_user");
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();

    }
    public function deletecompraall($id_user){
        $sql = $this->pdo->prepare("DELETE FROM compra WHERE id_user=:id_user");
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();

    }

    
    
    
}