<?php
require_once 'dao/CarrinhoDaoMysql.php';
require_once 'dao/ProdutoDaoMysql.php';


class Carrinhoverify
{
    private $pdo;
    private $base;
    public function __construct(PDO $pdo, $base)
    {
        $this->pdo = $pdo;
        $this->base = $base;
    }

    public function verifyestoque($quantidade, $id_produto)
    {
        if ($quantidade) {
            $produtoDao = new ProdutoDaoMysql($this->pdo);

            $p = $produtoDao->findbyid($id_produto);

            $quantproduto = $p->estoque;

            if ($quantidade <= $quantproduto) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function insertcar($id_user, $id_produto, $quantidade)
    {

        $carrinhoDao = new CarrinhoDaoMysql($this->pdo, $this->base);

        $car = new Carrinho();

        $car->id_user = $id_user;
        $car->id_produto = $id_produto;
        $car->quantidade = $quantidade;
        $car->data = date("Y-m-d H:i:s");

        $c = $carrinhoDao->insert($car);
    }

    public function updateprodutoestoque($id_produto, $quantidade)
    {
        // Descontar quantidade selecionada do estoque do produto
        $produtoDao = new ProdutoDaoMysql($this->pdo);

        // Encontrar o produto pelo ID
        $p = $produtoDao->findbyid($id_produto);

        // Verificar se o produto foi encontrado
        if ($p) {
            $estoque = $p->estoque;

            // Calcular o novo estoque após a compra
            $novoEstoque = $estoque - $quantidade;

            // Atualizar o estoque no banco de dados
            $updateestoque = $produtoDao->updateestoque($id_produto, $novoEstoque);
        } else {
            // Tratar o caso em que o produto não foi encontrado
            // Pode ser útil lançar uma exceção ou lidar de alguma outra forma
            echo "Produto não encontrado.";
            exit;
        }
    }


    public function verifyitem($id_produto, $id_user)
    {

        $carrinhoDao = new CarrinhoDaoMysql($this->pdo, $this->base);

        $item = $carrinhoDao->getitemcarrinho($id_user, $id_produto);


        if ($item) {
            return true;
        } else {
            return false;
        }
    }

    public function updatequantidade($id_user, $id_produto, $quantidade)
    {

        $carrinhoDao = new CarrinhoDaoMysql($this->pdo, $this->base);

        $item = $carrinhoDao->getitemcarrinho($id_user, $id_produto);

        $quantidadecarrinho = $item->quantidade;

        $novaquantidade = $quantidade + $quantidadecarrinho;

        $updatecarrinho = $carrinhoDao->updateproduto($id_user, $id_produto, $novaquantidade);

        return $updatecarrinho;
    }


    public function estoqueExpiredItems()
    {
        // Instancia os DAOs necessários
        $carrinhoDao = new CarrinhoDaoMysql($this->pdo);
        $produtoDao = new ProdutoDaoMysql($this->pdo);

        // Obtém os itens no carrinho com mais de 60 segundos (1 minuto)
        $expiredItems = $carrinhoDao->getExpiredItems(8 * 60 * 60);

        // Deleta os itens expirados e atualiza o estoque
        foreach ($expiredItems as $item) {


            // Obtém informações do produto e do item no carrinho
            $produto = $produtoDao->findById($item->id_produto);
            $items = $carrinhoDao->getItemCarrinho($item->id_user, $item->id_produto);

            $estoque = $produto->estoque;
            $quantidadeCarrinho = $items->quantidade;

            // Calcula o novo estoque
            $novoEstoque = $estoque + $quantidadeCarrinho;

            // Atualiza o estoque do produto
            $updateEstoque = $produtoDao->updateEstoque($item->id_produto, $novoEstoque);
            echo 'estoque dos itens deletedos foram atualizados com sucesso!';
        }
    }
}
