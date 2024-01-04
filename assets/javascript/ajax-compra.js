$(function () {
    // Associa um evento de envio de formulário a todos os elementos com a classe 'form'
    $('.form').bind('submit', function (e) {
        // Impede o envio padrão do formulário para evitar recarregamento da página
        e.preventDefault();

        // Serializa os dados do formulário em formato de string
        var formcar = $(this).serialize();

        // Envia uma requisição AJAX para 'carrinho_action.php'
        $.ajax({
            type: 'POST',           // Método HTTP da requisição
            url: 'carrinho_action.php',  // URL do script PHP
            data: formcar,          // Dados do formulário a serem enviados
            success: function (response) {
                // Função executada quando a requisição é bem-sucedida

                console.log('Requisição efetuada com sucesso');

                // Verifica se a resposta do servidor indica sucesso
                if (response.success) {
                    console.log('Resposta negativa (usuario logado): ' + response.success);
                } else {
                    console.log('Resposta positiva (usuario não logado): ' + response.message);

                    // Se houver um redirecionamento, redireciona a página
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    } else {
                        console.log('Ocorreu um erro (usuario logado): ' + response.message);
                    }
                }


                //verificação dos item adicionados ao carrinho

                //verifica se a quantidade selecionada é menor que no estoque
                if (response.estoquetrue) {

                    if (response.update && response) {
                        alert(response.update);

                    }
                    else {
                        console.log('item adicionado ao carrinho');

                    }

                } else {
                    alert('quantidade maior que estoque');

                }


            },
            error: function (error) {
                // Função executada em caso de erro na requisição AJAX
                alert('Ocorreu um erro durante a requisição AJAX');
            }
        });
    });
});




// Função para obter a contagem de itens do carrinho

$(document).ready(function () {
    // Função para buscar e atualizar os pedidos
    function countcar() {
        $.ajax({
            url: 'contagem-item-carrinho.php',
            method: 'GET',
            success: function (response) {
                $('#pedidos-section').html(response);
            },
            error: function (xhr, error) {
                console.error('Erro na requisição AJAX: ');
            }
        });
    }

    // Chame a função inicialmente para exibir os pedidos
    countcar();

    // Defina um intervalo para chamar a função countcar a cada 10 segundos
    setInterval(countcar, 500);
});



//funçao para obter os itens no carrinho em tempo real




