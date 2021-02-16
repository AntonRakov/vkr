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
    <link rel="stylesheet" href="css/styles.css">
    <title>Личный кабинет</title>
</head>
<body>
    Личный кабинет
</body>
</html>

<?php else : ?>
    <meta http-equiv="refresh" content="0;URL=authorization.php"/>
<?php endif; ?> 