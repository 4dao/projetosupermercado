<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title> 
</head>

<body>

    <div class="contente">
        <form action="cadastrar_produto_action.php" method="post" enctype="multipart/form-data" required>
            <img id="imagemPreview" alt="Prévia da Imagem" style="max-width: 300px; max-height: 300px; display: none; object-fit: cover;">
            <input type="file" id="imagemInput" name="imagem">

            <input type="text" name="nome" placeholder="Título" required autofocus>

            <input type="text" name="descricao" placeholder="Descrição" required>

            <select name="categoria" id="" required>
                <option value="hortifruti">Hortifruti</option>
                <option value="padaria">Padaria</option>
                <option value="frios e laticínios">Frios e Laticínios</option>
                <option value="congelados">Congelados</option>
                <option value="bebidas não alcoólicas">Bebidas não Alcoólicas</option>
                <option value="bebidas alcoólicas">Bebidas Alcoólicas</option>
                <option value="mercearia">Mercearia</option>
                <option value="perfumaria e higiene">Perfumaria e higiene</option>
                <option value="limpeza">Limpeza</option>
                <option value="animais">Animais</option>
                <option value="descartaveis e festa">Descartaveis e Festa</option>
            </select>

            <!-- Campo de input para preço da oferta -->
            <label for="promocao">Oferta?<input type="checkbox" value="1" name="promocao" id="promocaoCheckbox"></label>
            <div id="precoOfertaContainer" style="display: none;">
                <input type="text" placeholder="DE:valor real " name="valorpromocao" id="precoOferta">
            </div>

            <input type="text" name="preco" placeholder="Valor ofertado" required>


            <input type="text" name="estoque" placeholder="Quant. Estoque" required>

            <button>Cadastrar Produto</button>
        </form>

    </div>

</body>

</html>