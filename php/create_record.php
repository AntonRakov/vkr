<?php
    require '../db.php';

    $id_time = $_GET['time'];
    $id_day = $_GET['day'];
    $id_master = $_GET['master'];
    $id_client = $_SESSION['logged_user']['id'];

    if(R::count('records', "client = ?", array($id_client)) < 2){
        header('Refresh: 0; url=../lk.php');
        $record = R::dispense('records');
        $record->client = $id_client;
        $record->date_record = $id_day;
        $record->time_record = $id_time;
        $record->master = $id_master;
        R::store($record);
    }
    else{
        header('Refresh: 5; url=../lk.php');
        echo "Превышено число записей";
    }

?>