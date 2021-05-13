<?php 
	require 'db.php';
?>

<?php if (((!empty($_SESSION['logged_user'])) AND ($_SESSION['logged_user']['access_level'] == '1') )OR ((!empty($_SESSION['logged_user'])) AND ($_SESSION['logged_user']['access_level'] == '2'))) : ?>
	<meta http-equiv="refresh" content="0;URL=admin.php" />

<?php elseif ($_SESSION['logged_user']['access_level'] == '0') : ?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <main class="auth_page">
        <div class="second-menu">
            <ul>
                <li><a href="tel:+79028842458">+79028842458</a></li>
                <li><a href="index.php">Главная</a></li>
                <li><a href="lk.php">Личный кабинет</a></li>
                <li>Мира 2В</li>
            </ul>
        </div>
        <div class='spoiler-wrap enable'>
            <div class='spoiler-head'>Текущие записи</div>
            <div class='spoiler-body'>
                <?php
                    $id_client = $_SESSION['logged_user']['id'];
                    if(R::count('records', "client = ?", array($id_client)) < 1){
                        echo("Записи на текущий момент отсутствуют");
                    }
                    else{
                        $active_records = R::findAll('records', "client = ?", array($id_client));
                        foreach($active_records as $item){
                            $date_record = $item['date_record'];
                            $date_record = R::findOne('days', "id = ?", array($date_record));
                            $date_record = $date_record['day'];
                            $time_record = $item['time_record'];
                            $time_record = R::findOne('times', "id = ?", array($time_record));
                            $time_record = $time_record['timing'];
                            $master_record = $item['master'];
                            $master_record = R::findOne('masters', "id = ?", array($master_record));
                            $master_record = $master_record['fio'];

                            echo("Вы записаны: <br>" . $date_record . " " . $time_record . " " . "к барберу " . $master_record . "<br>");
                        }
                    }
                ?>
            </div>
        </div>
        <?php
            $masters = R::find('masters');
            foreach ($masters as $item){
                $id_master = $item['id'];
                echo"<div class='spoiler-wrap disabled'>";
                    echo"<div class='spoiler-head'>" . $item['fio'] . " - " . $item['biography'] . "</div>";
                    echo"<div class='spoiler-body'>";
                        $days = R::find('days');
                        foreach ($days as $item){
                            $day = $item['day'];
                            $id_day = $item['id'];
                            echo"<table>";
                            echo"<tr>";
                            if ($day >= date("Y-m-d")){
                                if($day < date("Y-m-d", strtotime("+7 days"))){
                                    echo"<td>" . $day . "</td>";
                                }
                                $times = R::find('times');
                                foreach ($times as $item){
                                    $id_time = $item['id'];
                                    $record = R::findOne('records','date_record=? AND time_record=? AND master=?',array($id_day,$id_time,$id_master));
                                    $record = $record['id'];
                                    $time = $item['timing'];
                                    if ($record != ''){
                                        if($day < date("Y-m-d", strtotime("+7 days"))){
                                            echo"<td style='text-decoration: line-through'>" . mb_substr($time, 0, 5) . "</td>";
                                        }
                                    }
                                    else{
                                        if($day < date("Y-m-d", strtotime("+7 days"))){
                                            echo"<td><a href='php/create_record.php?time=" . $id_time . "&day=" . $id_day . "&master=" . $id_master . "'>" . mb_substr($time, 0, 5) . "</a></td>";
                                        }
                                    }      
                                }
                                echo"</tr>";
                                echo"</table>";
                            }
                        }
                    echo"</div>";
                echo"</div>";  
            }
        ?> 
        
    </main>
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="js/spoiler.js" type="text/javascript"></script> 
</body>
</html>

<?php else : ?>
    <meta http-equiv="refresh" content="0;URL=authorization.php"/>
<?php endif; ?> 