<?php

class Banner{
    public $id;
    public $banner;
    public $data;
}


interface BannerDao{
    public function insert(Banner $b);
    public function read();
    public function delete($id);






    
}