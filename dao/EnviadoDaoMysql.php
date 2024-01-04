<?php

require_once 'models/enviado.php';
require_once 'models/produto.php';


class EnviadoDaoMysql implements EnviadoDao
{

    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }


    public function insert(Enviado $c)
    {
        $sql = $this->pdo->prepare("INSERT INTO enviado (id_user, id_produto, id_car, idhash, preco_total, nome_cliente, cpf_cliente, telefone_cliente,
        endereco_cliente, bairro_cliente, numero_cliente, referencia_cliente, data, quantidade, status, pagamento) VALUES (:id_user, :id_produto, :id_car, :idhash, :preco_total, :nome_cliente, :cpf_cliente, :telefone_cliente,
        :endereco_cliente, :bairro_cliente, :numero_cliente, :referencia_cliente, :data, :quantidade, :status, :pagamento)");
        $sql->bindValue(':id_user', $c->id_user);
        $sql->bindValue(':id_produto', $c->id_produto);
        $sql->bindValue(':id_car', $c->id_car);
        $sql->bindValue(':idhash', $c->idhash);
        $sql->bindValue(':preco_total', $c->preco);
        $sql->bindValue(':nome_cliente', $c->nome_cliente);
        $sql->bindValue(':cpf_cliente', $c->cpf_cliente);
        $sql->bindValue(':telefone_cliente', $c->telefone_cliente);
        $sql->bindValue(':endereco_cliente', $c->endereco_cliente);
        $sql->bindValue(':bairro_cliente', $c->bairro_cliente);
        $sql->bindValue(':numero_cliente', $c->numero_cliente);
        $sql->bindValue(':referencia_cliente', $c->referencia_cliente);
        $sql->bindValue(':data', $c->data);
        $sql->bindValue(':quantidade', $c->quantidade);
        $sql->bindValue(':status', "PEDIDO ENVIADO");
        $sql->bindValue(':pagamento', 'em dinheiro');


        $sql->execute();
    }

    public function readadm()
    {
        $comprasPorUsuarioEHash = array();
    
        $sql = $this->pdo->query("SELECT c.*, p.* FROM enviado c
            JOIN produto p ON c.id_produto = p.id
            ORDER BY c.id DESC");
    
        $sql->execute();
    
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
    
            foreach ($data as $conteudo) {
                $c = new Enviado();
                $c->id = $conteudo['id'];
                $c->id_user = $conteudo['id_user'];
                $c->id_produto = $conteudo['id_produto'];
                $c->id_car = $conteudo['id_car'];
                $c->idhash = $conteudo['idhash'];
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
    
                // Informações adicionais do produto
                $c->nome_produto = $conteudo['nome'];
                // Adicione mais campos conforme necessário
    
                $id_user = $c->id_user;
                $idhash = $c->idhash;
    
                // Crie um bloco separado se id_user ou idhash for diferente
                $chaveBloco = $id_user . '_' . $idhash;
                if (!array_key_exists($chaveBloco, $comprasPorUsuarioEHash)) {
                    $comprasPorUsuarioEHash[$chaveBloco] = array();
                }
    
                $comprasPorUsuarioEHash[$chaveBloco][] = $c;
            }
        }
    
        return $comprasPorUsuarioEHash;
    }
    
    

    public function readadmid($id_user, $idhash)
    {
        $comprasPorUsuarioEHash = array();
    
        $sql = $this->pdo->prepare("SELECT c.*, p.* FROM enviado c
        JOIN produto p ON c.id_produto = p.id
        WHERE c.id_user = :id_user AND c.idhash = :idhash
        ORDER BY c.id DESC");
    
        $sql->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $sql->bindParam(':idhash', $idhash, PDO::PARAM_INT);
        $sql->execute();
    
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
    
            foreach ($data as $conteudo) {
                $c = new Enviado();
                $c->id = $conteudo['id'];
                $c->id_user = $conteudo['id_user'];
                $c->id_produto = $conteudo['id_produto'];
                $c->id_car = $conteudo['id_car'];
                $c->idhash = $conteudo['idhash'];
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
    
                // Informações adicionais do produto
                $c->nome_produto = $conteudo['nome'];
                // Adicione mais campos conforme necessário
    
                $id_user = $c->id_user;
                $idhash = $c->idhash;
    
                // Crie um bloco separado se id_user ou idhash for diferente
                $chaveBloco = $id_user . '_' . $idhash;
                if (!array_key_exists($chaveBloco, $comprasPorUsuarioEHash)) {
                    $comprasPorUsuarioEHash[$chaveBloco] = array();
                }
    
                $comprasPorUsuarioEHash[$chaveBloco][] = $c;
            }
        }
    
        return $comprasPorUsuarioEHash;
    }

    public function readadmidcliente($id_user)
    {
        $comprasPorUsuarioEHash = array();
    
        $sql = $this->pdo->prepare("SELECT c.*, p.* FROM enviado c
        JOIN produto p ON c.id_produto = p.id
        WHERE c.id_user = :id_user
        ORDER BY c.id DESC");
    
        $sql->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $sql->execute();
    
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
    
            foreach ($data as $conteudo) {
                $c = new Enviado();
                $c->id = $conteudo['id'];
                $c->id_user = $conteudo['id_user'];
                $c->id_produto = $conteudo['id_produto'];
                $c->id_car = $conteudo['id_car'];
                $c->idhash = $conteudo['idhash'];
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
    
                // Informações adicionais do produto
                $c->nome_produto = $conteudo['nome'];
                // Adicione mais campos conforme necessário
    
                $id_user = $c->id_user;
                $idhash = $c->idhash;
    
                // Crie um bloco separado se id_user ou idhash for diferente
                $chaveBloco = $id_user . '_' . $idhash;
                if (!array_key_exists($chaveBloco, $comprasPorUsuarioEHash)) {
                    $comprasPorUsuarioEHash[$chaveBloco] = array();
                }
    
                $comprasPorUsuarioEHash[$chaveBloco][] = $c;
            }
        }
    
        return $comprasPorUsuarioEHash;
    }
    
}
