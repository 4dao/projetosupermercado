<?php
require_once 'config.php';
require_once 'dao/BannerDaoMysql.php';


$bannerDao = new BannerDaoMysql($pdo);

$banner = $bannerDao->read();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/styles.css">

</head>

<body>

    <section class="banner">
        <div class="banner_container">
            <!-- <div class="banner_box">
                <img src="assets/imagem/bannergerim.jpg" alt="First slide">
            </div> -->
            <?php foreach ($banner as $banner_view) : ?>
                <div class="banner_box">
                    <img src="assets/banners/<?= $banner_view->banner ?>" alt="Next slide">
                </div>
            <?php endforeach; ?>
            <!-- Adicione quantos banners desejar -->
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var bannerContainer = document.querySelector('.banner_container');
            var currentIndex = 0;

            setInterval(function () {
                currentIndex = (currentIndex + 1) % bannerContainer.children.length;
                var translateValue = -currentIndex * 100 + '%';
                bannerContainer.style.transform = 'translateX(' + translateValue + ')';
            }, 5000);
        });
    </script>

</body>

</html>


