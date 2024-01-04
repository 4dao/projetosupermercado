<?php

require_once 'models/banner.php';


class BannerDaoMysql implements BannerDao{

    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }


    public function insert(Banner $b){
        $sql = $this->pdo->prepare('INSERT INTO banner (banner, data) VALUES (:banner, :data)');
        $sql->bindValue('banner', $b->banner);
        $sql->bindValue('data', $b->data);

        $sql->execute();
    }

    public function read(){

        $array = [];

        $sql = $this->pdo->query('SELECT * FROM banner ORDER BY id DESC');

        $data = $sql->fetchAll();

        foreach($data as $banner){
            $b = new Banner();

            $b->id = $banner['id'];
            $b->banner = $banner['banner'];
            $b->data = $banner['data'];

            $array[] = $b;
        }

        return $array;

    }

    public function delete($id){
        $sql = $this->pdo->prepare("DELETE FROM banner WHERE id=:id");
        $sql->bindValue(':id', $id);
        $sql->execute();
    }
}