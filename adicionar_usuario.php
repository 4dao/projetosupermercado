<?php require 'config.php' ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>

  <!-- Inclui o arquivo de estilo para a página de login -->
  <link rel="stylesheet" href="assets/login.css">
  <style>
    #chk {
      margin: 0;
      padding: 0;
      width: auto;
      border: none;
      vertical-align: middle;
      margin-left: 50px;
    }
  </style>
</head>
<body>

<!-- Inclui o cabeçalho da página a partir de um arquivo separado -->
<?php require 'partials/header_painel.php' ?>

<div class="formulario">
    <!-- Formulário de adição de usuário, a ação é enviada para 'adicionar_usuario_action.php' -->
    <form action="<?= $base ?>/adicionar_usuario_action.php" method="post"> 

    <div class="logo">
        <!-- Logo da página com link para a página inicial -->
        <a href="<?= $base ?>"><img src="assets/imagem/logo.png" alt="Gerim Logo"></a>
    </div>

    <?php
      // Exibe mensagem de erro de cadastro, se existir
      if (isset($_SESSION['cadastro_error'])) {
          echo '<div class="error-message">' . $_SESSION['cadastro_error'] . '</div>';
          unset($_SESSION['cadastro_error']); // Remove a mensagem de erro da sessão após exibição
      }
    ?>

    <!-- Campos do formulário para nome, CPF e senha -->
    <input type="text" placeholder="Nome Completo" name="nome" require autofocus>
    <input type="number" name="cpf" pattern="(\d{3}\.?\d{3}\.?\d{3}-?\d{2})|(\d{2}\.?\d{3}\.?\d{3}/?\d{4}-?\d{2})" required placeholder="Cpf:xxx.xxx.xxx-xx">
    
    <!-- Wrapper para o campo de senha e opção para mostrar a senha -->
    <div class="senha-wrapper">
      <input placeholder="Senha" type="password" name="senha" id="pwd" required>
      <label for="chk"><br> <br>
        <input type="checkbox" id="chk">
        Mostrar senha
      </label>
    </div>

    <!-- Botão para adicionar usuário -->
    <button>Adicionar</button>
  </form>
</div>

<!-- Script JavaScript para alternar a visibilidade da senha -->
<script>
  const pwd = document.getElementById('pwd');
  const chk = document.getElementById('chk');

  chk.onchange = function(e){
    pwd.type = chk.checked ? 'text' : 'password';
  };
</script>
</body>
</html>
