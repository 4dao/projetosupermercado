<?php

class ConexaoAPI
{
    private $urlBase;

    public function __construct($urlBase)
    {
        $this->urlBase = $urlBase;
    }

    public function conexao($endpoint)
    {
        $urlcompleta = $this->urlBase . $endpoint;

        $ch = curl_init($urlcompleta);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $resultado = curl_exec($ch);

        if ($resultado === false) {
            // Lidar com erros
            echo 'Erro na solicitação cURL: ' . curl_error($ch);
            return null;
        }

        return json_decode($resultado);
    }


    
        public function conexaoPorId($id) {
            $urlCompleta = $this->urlBase . '/receitas/' . $id;
            
            $ch = curl_init($urlCompleta);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            $resultado = curl_exec($ch);
            
            if ($resultado === false) {
                echo 'Erro na solicitação cURL: ' . curl_error($ch);
                return null;
            }
            
            return json_decode($resultado);
        }

    
}
