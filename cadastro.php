<?php require 'config.php' ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>

  <!-- Inclui o arquivo CSS de estilo para o login -->
  <link rel="stylesheet" href="<?= $base ?>/assets/login.css">

  <!-- Estilo específico para o checkbox de mostrar senha -->
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
<div class="formulario">
    <!-- Formulário de cadastro de usuário -->
    <form action="<?= $base ?>/cadastro_action.php" method="post"> 

    <!-- Logo da aplicação -->
    <div class="logo">
        <a href="<?= $base ?>"><img src="<?= $base ?>/assets/imagem/logo.png" alt="Gerim Logo"></a>
    </div>

    <?php
      // Verifica se há mensagens de erro na sessão e exibe se necessário
      if (isset($_SESSION['cadastro_error'])) {
          echo '<div class="error-message">' . $_SESSION['cadastro_error'] . '</div>';
          unset($_SESSION['cadastro_error']); // Remove a mensagem de erro da sessão
      }
    ?>
        <!-- Campos do formulário para nome, CPF e senha -->
        <input type="text" placeholder="Nome Completo" name="nome" required autofocus>
        <input type="number" name="cpf" pattern="(\d{3}\.?\d{3}\.?\d{3}-?\d{2})|(\d{2}\.?\d{3}\.?\d{3}/?\d{4}-?\d{2})" required placeholder="Cpf:xxx.xxx.xxx-xx">
        
        <!-- Wrapper para o campo de senha com a opção de mostrar a senha -->
        <div class="senha-wrapper">
          <input placeholder="Senha" type="password" name="senha" id="pwd" required>
          <label for="chk"><br> <br>
            <input type="checkbox" id="chk">
            Mostrar senha
          </label>
        </div>
        
        <!-- Botão para cadastrar -->
        <button>Cadastrar</button>
        
        <!-- Link para a página de login -->
        <p>Tem uma conta? Faça seu <a href="<?= $base ?>/login/">Login</a></p>
    </form>
</div>

<!-- Script para mostrar/ocultar a senha -->
<script>
  const pwd = document.getElementById('pwd');
  const chk = document.getElementById('chk');

  chk.onchange = function(e){
    pwd.type = chk.checked ? 'text' : 'password';
  };
</script>
</body>
</html>
