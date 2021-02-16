<?php 
	require 'db.php';
?>

<?php if (((!empty($_SESSION['logged_user'])) AND ($_SESSION['logged_user']['access_level'] == '1') )OR ((!empty($_SESSION['logged_user'])) AND ($_SESSION['logged_user']['access_level'] == '2'))) : ?>
	<meta http-equiv="refresh" content="0;URL=admin.php" />

<?php elseif (!empty($_SESSION['logged_user']) AND ($_SESSION['logged_user']['access_level'] == '0')) : ?>
	<meta http-equiv="refresh" content="0;URL=lk.php" />

<?php else : ?>
	<?php 

		$data = $_POST;
		if ( isset($data['do_login']) )
		{
			$user = R::findOne('users', 'phone_number = ?', array($data['phone_number']));
			
			if ( $user )
			{
				//логин существует
				if ( password_verify($data['password'], $user->password) )
				{
					//если пароль совпадает, то нужно авторизовать пользователя
					$_SESSION['logged_user'] = $user;
					echo '<meta http-equiv="refresh" content="0;URL=admin.php" />';
					// header( "refresh:2;url=recording.php" );
				}else
				{
					$errors[] = 'Неверно введен пароль и/или логин';
				}

			}else
			{
				$errors[] = 'Неверно введен логин и/или пароль';
			}

		}

	?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <main class="auth_page">
        <div class="second-menu">
            <ul>
                <li>
                    <a href="index.php">Главная</a>
                </li>
                <li>
                    <a href="about.html">О нас</a>
                </li>
                <li>
                    <a href="shop.html">Ассортимент товаров</a>
                </li>
                <li>
                    <a href="lk.php">Личный кабинет</a>
                </li>
            </ul>
        </div>
        <div class="auth_form">
            <div>
                <h2>Необходимо авторизоваться</h2>
            </div>
            <div>
                <form action="authorization.php" method="POST">
                    <table>
                        <tr>
                            <td><strong>Номер телефона</strong></td>
                            <td><input type="text" name="phone_number" value="<?php echo @$data['phone_number']; ?>" placeholder="10 цифр, без +7" pattern="\s?[\(]{0,1}9[0-9]{2}[\)]{0,1}\s?\d{3}[-]{0,1}\d{2}[-]{0,1}\d{2}"></td>
                        </tr>
                        <tr>
                            <td><strong>Пароль</strong></td>
                            <td><input type="password" name="password" value="<?php echo @$data['password']; ?>"></td>
                        </tr>
                        <tr>
                            <td colspan="2"><button type="submit" name="do_login">Войти</button></td>
                        </tr>
                        <?php
                        if ( ! empty($errors) )
                        {
                            //выводим ошибки авторизации
                            echo "<tr><td colspan='2'>" . array_shift($errors) . "</td></tr>";
                        }
                        ?>
                    </table>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
<?php endif; ?>
