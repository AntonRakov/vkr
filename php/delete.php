<?php 
	require '../db.php';

    $table = $_GET['table'];
    $id = $_GET['id'];

    // Защита от SQL-иньекций и несанкционированного доступа с разделением на роли
    if (!empty($_SESSION['logged_user']) AND $_SESSION['logged_user']['access_level'] == '2'):
    $find = R::findOne($table, 'id = ?',[$id]);
    $delete = R::load($table, $find->id);
    R::trash($delete);
    header("Location: ../admin.php");

    elseif (!empty($_SESSION['logged_user']) AND ($_SESSION['logged_user']['access_level'] == '1' AND $table != 'users')):
    $find = R::findOne($table, 'id = ?',[$id]);
    $delete = R::load($table, $find->id);
    R::trash($delete);
    header("Location: ../admin.php"); 
    else:
    header("Location: ../authorization.php"); 
    endif;
?>