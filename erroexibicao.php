
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="5; URL='<?php $base ?>'" />
    <title>Erro 404 - Acesso Restrito</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            max-width: 600px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #d9534f;
        }

        p {
            margin-top: 20px;
        }

        img {
            width: 100%;
            max-width: 400px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="<?php $base ?>/assets/imagem/erroimagem.jpg" alt="Somente para Desktop">
        <h1>Erro 404 - Acesso Restrito</h1>
        <p>Lamentamos, mas este site está otimizado apenas para desktop. Por favor, acesse-o de um computador para uma melhor experiência.</p>
    </div>
</body>
</html>
