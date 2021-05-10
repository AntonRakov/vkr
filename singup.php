<?php 
	require 'db.php';
?>

<?php if (((!empty($_SESSION['logged_user'])) AND ($_SESSION['logged_user']['access_level'] == '1') )OR ((!empty($_SESSION['logged_user'])) AND ($_SESSION['logged_user']['access_level'] == '2'))) : ?>
	<meta http-equiv="refresh" content="0;URL=admin.php" />

<?php elseif (!empty($_SESSION['logged_user']) AND ($_SESSION['logged_user']['access_level'] == '0')) : ?>
	<meta http-equiv="refresh" content="0;URL=lk.php" />

<?php else : ?>
	<?php
        // хзхз
	?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
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
        <div class="auth_form">
            <div>
                <h2>Создать новый аккаунт</h2>
            </div>
            <?php
            $data = $_POST;

            // проверка формы на пустоту полей
                $errors_users = array();
                if ( trim($data['name']) == '' )
                {
                    $errors_users[] = 'Введите имя';
                }

                if ( trim($data['phone_number']) == '' )
                {
                    $errors_users[] = 'Введите номер телефона';
                }

                if ( $data['password'] == '' )
                {
                    $errors_users[] = 'Введите пароль';
                }

                if ( $data['password_2'] != $data['password'] )
                {
                    $errors_users[] = 'Повторный пароль введен не верно!';
                }

                //проверка на существование одинакового номера телефона
                if ( R::count('users', "phone_number = ?", array($data['phone_number'])) > 0)
                {
                    $errors_users[] = 'Пользователь с таким номером уже существует!';
                }

                if ( empty($errors_users) )
                {
                    //ошибок нет, теперь регистрируем
                    $user = R::dispense('users');
                    $user->name = $data['name'];
                    $user->phone_number = $data['phone_number'];
                    $user->password = password_hash($data['password'], PASSWORD_DEFAULT); //пароль нельзя хранить в открытом виде, мы его шифруем при помощи функции password_hash для php > 5.6
                    $user->access_level = 0;
                    R::store($user);
                    echo '<meta http-equiv="refresh" content="0;URL=lk.php" />';
                }
            ?>

            <div>
                <form action="singup.php" method="POST">
                    <table>
                        <tr>
                            <td><strong>ФИО</strong></td>
                            <td><input type="text" name="name" value="<?php echo @$data['name']; ?>"></td>
                        </tr>
                        <tr>
                            <td><strong>Номер телефона</strong></td>
                            <td><input type="tel" name="phone_number" placeholder="10 цифр, без +7" pattern="\s?[\(]{0,1}9[0-9]{2}[\)]{0,1}\s?\d{3}[-]{0,1}\d{2}[-]{0,1}\d{2}"></td>
                        </tr>
                        <tr>
                            <td><strong>Пароль</strong></td>
                            <td><input type="password" name="password" value="<?php echo @$data['password']; ?>"></td>
                        </tr>
                        <tr>
                            <td><strong>Повторите пароль</strong></td>
                            <td><input type="password" name="password_2" value="<?php echo @$data['password_2']; ?>"></td>
                        </tr>
                        <tr>
                            <td colspan="2"><button type="submit" name="do_signup">Продолжить регистрацию</button></td>
                        </tr>
                        <?php
                            if ( ! empty($errors_users) && isset( $_POST['do_signup'] ) )
                            {
                                //выводим ошибки авторизации
                                echo "<tr><td colspan='2'>" . array_shift($errors_users) . "</td></tr>";
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
