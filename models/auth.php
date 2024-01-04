<?php
require_once("models/user.php");
require_once("dao/UserDaoMysql.php");

class Auth
{
    private $pdo;
    private $base;
    public function __construct(PDO $pdo, $base)
    {
        $this->pdo = $pdo;
        $this->base = $base;
    }

    public function checkToken()
    {

        if (!empty($_SESSION['token'])) {
            $token = $_SESSION['token'];

            $userDao = new UserDaoMysql($this->pdo);
            $user = $userDao->findByToken($token);

            if ($user) {
                return $user;
            }
        }

        header("Location: $this->base/login/");
        exit;
    }

    public function cpfexist($cpf)
    {
        $userDao = new UserDaoMysql($this->pdo);
        if ($userDao->findByCpf($cpf)) {
            return true;
        } else {
            return false;
        }
    }

    public function registroUser($nome, $cpf, $senha)
    {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $token = md5(time() . rand(0, 9999));

        $newuser = new User();

        $newuser->nome = $nome;
        $newuser->cpf = $cpf;
        $newuser->senha = $hash;
        $newuser->token = $token;
        $newuser->atividade = date("Y-m-d H:i:s");

        $userDao = new UserDaoMysql($this->pdo);
        $user = $userDao->insert($newuser);

        $_SESSION['token'] = $token;
    }

    public function checkTokenAndAccess($nivel = null)
    {

        if (!empty($_SESSION['token'])) {
            $token = $_SESSION['token'];

            $userDao = new UserDaoMysql($this->pdo);
            $user = $userDao->findByToken($token);

            if ($user) {
                if ($nivel && $user->nivel !== $nivel) {
                    header("Location: $this->base");
                    exit;
                }
                return $user;
            }
        }

        return false;
    }

    public function validadeLogin($cpf, $senha)
    {

        $userDao = new UserDaoMysql($this->pdo);
        $user = $userDao->findbyCpf($cpf);

        if ($user) {
            $password_correta = password_verify($senha, $user->senha);
            if ($password_correta) {
                $token = md5(time() . rand(0, 9999));

                $_SESSION['token'] = $token;
                $user->token = $token;
                $userDao->updatetoken($user);

                return true;
            }
        }

        return false;
    }

    public function adicionarUser($nome, $cpf, $senha)
    {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $token = md5(time() . rand(0, 9999));

        $newUser = new User();
        $newUser->nome = $nome;
        $newUser->cpf = $cpf;
        $newUser->senha = $hash;
        $newUser->token = $token;

        $userDao = new UserDaoMysql($this->pdo);
        $user = $userDao->insert($newUser);
    }

    public function checkAndDeleteExtraAdmins()
    {
        $userDao = new UserDaoMysql($this->pdo);

        $adminUsers = $userDao->findAdminUsers(); // Substitua 'findAdminUsers' pelo método real que busca usuários com nível 'admin'

        $adminCount = count($adminUsers);

        if ($adminCount > 1) {
            // Se houver mais de um admin, exclua o último
            $lastAdmin = end($adminUsers);
            if ($lastAdmin->id !== 39) {
                // Certifique-se de que não estamos excluindo o admin com ID 39
                $userDao->delete($lastAdmin->id);
                header("Location: $this->base"); // Substitua 'deleteUser' pelo método real que exclui um usuário pelo ID
            }
        }
    }

    public function exibicao()
    {
        $isMobile = false;

        if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/Mobile|Android|iPhone|iPad|iPod|BlackBerry|Opera Mini|IEMobile/i', $_SERVER['HTTP_USER_AGENT'])) {
            $isMobile = true;
        }

        if ($isMobile) {
            header("Location: erro-compatibilidade/"); // Redireciona para a página mobile_page.php em dispositivos móveis
            exit;
        } 
    }
}
