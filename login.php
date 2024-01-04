<?php
require 'config.php';

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>

  <link rel="stylesheet" href="<?= $base ?>/assets/login.css">
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
    <form action="<?= $base ?>/login_action.php" method="post"> 

    <div class="logo">
        <a href="<?= $base ?>"><img src="<?= $base ?>/assets/imagem/logo.png" alt="Gerim Logo"></a>
    </div>

    <?php
      if (isset($_SESSION['login_error'])) {
          echo '<div class="error-message">' . $_SESSION['login_error'] . '</div>';
          unset($_SESSION['login_error']); // Remove a mensagem de erro da sessão
      }
    ?>

        <input type="number" name="cpf" pattern="(\d{3}\.?\d{3}\.?\d{3}-?\d{2})|(\d{2}\.?\d{3}\.?\d{3}/?\d{4}-?\d{2})" autofocus required placeholder="Cpf:xxx.xxx.xxx-xx">
        <div class="senha-wrapper">
          <input placeholder="Senha" type="password" name="senha" id="pwd" required>
          <label for="chk"><br> <br>
            <input type="checkbox" id="chk">
            Mostrar senha
          </label>
        </div>
        <button>Entrar</button>
        <p>Ainda não tem uma conta? Faça seu <a href="<?= $base ?>/cadastro/">Cadastro</a></p>
    </form>
</div>

<script>
  const pwd = document.getElementById('pwd');
  const chk = document.getElementById('chk');

  chk.onchange = function(e){
    pwd.type = chk.checked ? 'text' : 'password';
  };
</script>
</body>
</html>
