$(document).ready(function () {
    // Função para buscar e atualizar os pedidos
    function countcarrinho() {
        $.ajax({
            url: 'carrinho_cliente.php',
            method: 'GET',
            success: function (response) {
                $('#carrinho').html(response);
            },
            error: function (xhr, error) {
                console.error('Erro na requisição AJAX: ');
            }
        });
    }

    // Chame a função inicialmente para exibir os pedidos
    countcarrinho();

    // Defina um intervalo para chamar a função countcarrinho a cada 10 segundos
    setInterval(countcarrinho, 500);
});