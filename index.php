<?php
    require 'db.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="js/modal.js"></script>
    <title>Главная</title>  
</head>
<body>
    <div class="page-wrapper">
        <header>
            <div class="menu">
                <div class="menu_left">
                    <ul>
                        <li><a href="tel:+79028842458">+79028842458</a></li>
                        <li><a href="#">Главная</a></li>
                    </ul>
                </div>
                <div class="menu_center">
                    <img src="images/logo-big-dark-125x125.png" alt="">
                </div>
                <div class="menu_right">
                    <ul>
                        <li><a href="lk.php">Личный кабинет</a></li>
                        <li>Мира 2В</li>
                    </ul>
                </div>
            </div>
            <div class="header_bottom">
                <h1>Лучший барбершоп в городе</h1>
                <p>Создайте свой новый удивительный внешний вид с помощью услуг парикмахерской! От стрижки до горячего бритья, вы можете испытать лучший уровень парикмахерского искусства в этом районе.</p>
                <a class="btn trigger" href="#">Записаться сейчас</a>
            </div>
        </header>
        <main>
            <div class="block1">
                <div class="left_block">
                    <img src="images/about-1-300x460.jpg" alt="">
                    <img src="images/about-2-300x460.jpg" alt="">
                    <img src="images/about-3-300x460.jpg" alt="">
                </div>
                <div class="right_block">
                    <div class="text_block">
                        <h2>Кто мы такие</h2>
                        <p>Парикмахерская-это команда высококвалифицированных парикмахеров, специализирующихся на предоставлении наилучшей стоимости. Мы делаем это, предоставляя высококачественные салонные услуги.</p>
                        <a href="about.html" class="btn trigger">Узнать больше</a>
                    </div>
                </div>
            </div>
            <div class="block2">
                <div class="left_block">
                    <h2>Наш <br/> сервис</h2>
                    <p>Парикмахерская предлагает мужские стрижки мирового класса, стрижку бороды и бритье горячей бритвой. Вот лишь некоторые из услуг, которыми мы славимся.</p>
                    <a href="about.html" class="btn trigger">Узнать больше</a>
                </div>
                <div class="right_block">
                    <div id="beard_trim">
                        <img src="./images/icon-service-light-3-70x62.png" alt="">
                        <a href="#">Стрижка бороды</a>
                        <p>Хорошо подстриженная борода-обязательный элемент любого мужского образа</p>
                    </div>
                    <div id="mustache_trim">
                        <img src="./images/icon-service-light-4-70x62.png" alt="">
                        <a href="#">Стрижка усов</a>
                        <p>Усы также нужно регулярно подстригать-обязательный элемент любого мужского образа</p>
                    </div>
                    <div id="traditional_haircuts">
                        <img src="./images/icon-service-light-1-70x62.png" alt="">
                        <a href="#">Традициональные стрижки</a>
                        <p>Одна из самых популярных услуг наших парикмахеров</p>
                    </div>
                    <div id="shaves">
                        <img src="./images/icon-service-light-2-70x62.png" alt="">
                        <a href="#">Бритьё</a>
                        <p>Наши услуги по бритью сделают вас действительно красивым</p>
                    </div>
                </div>
            </div>
            <div class="block3">

            </div>
            <div class="block4">
                
            </div>
        </main>
        <footer>
            <div class="pages">

            </div>
            <div class="description">

            </div>
            <div class="follow_us">
                
            </div>
        </footer>
        <!-- Модальное окно -->
        <div class="modal-wrapper">
            <div class="modal">
            <div class="head">
                <p>Форма обратного звонка</p>
                <a class="btn-close trigger" href="#">
                <i class="fa fa-times" aria-hidden="true">×</i>
                </a>
            </div>
            <div class="content">
                <div class="good-job">
                    <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                    <form action="" method="POST">
                        <p>Как к Вам обращаться</p>
                        <input type="text" name="name" class="input_text">
                        <p>Номер телефона</p>
                        <input type="tel" name="phone_number" placeholder="10 цифр, без +7" pattern="\s?[\(]{0,1}9[0-9]{2}[\)]{0,1}\s?\d{3}[-]{0,1}\d{2}[-]{0,1}\d{2}" class="input_text">
                        <input type="submit" id="submit_form">
                    </form>
                    <?php
    
                        $name = $_POST['name'];
                        $phone_number = $_POST['phone_number'];
    
                        if (!empty($name) && !empty($phone_number)) {
                            $requests = R::dispense('requests');
                            $requests->fio = $name;
                            $requests->phone_number = $phone_number;
                            R::store($requests);
                        }
                        
                    ?>
                </div>
            </div>
            </div>
        </div>
        <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Aa5a5a41b4c5755a46c19cd550aca0567d335f7185e8896558c909f2e7617676e&amp;source=constructor" width="100%" height="400" frameborder="0"></iframe>
    </div>
</body>
</html>