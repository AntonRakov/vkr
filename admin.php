<?php 
	require 'db.php';
?>

<?php if (((!empty($_SESSION['logged_user'])) AND ($_SESSION['logged_user']['access_level'] == '1') )OR ((!empty($_SESSION['logged_user'])) AND ($_SESSION['logged_user']['access_level'] == '2'))) : ?>

    <!-- Основная страница -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Панель управления</title>
</head>
<body>
    <div class="admin_panel">
        <h1>Панель управления</h1>
        <div id="logout">
            <a href="logout.php">Выйти</a>
            <a href="index.php">Главная</a>
        </div>
        <div class="spoiler-wrap disabled">
            <div class="spoiler-head">Обратный звонок</div>
            <div class="spoiler-body">
                <table>
                    <tr>
                        <td>#</td>
                        <td>ФИО</td>
                        <td>Номер телефона</td>
                        <td>Действия</td>
                    </tr>
                    <?php
                        $users = R::findAll('requests');
                        foreach ($users as $item){
                            echo"<tr>";
                                echo"<td>" . $item['id'] . "</td>";
                                echo"<td>" . $item['fio'] . "</td>";
                                echo"<td>" . $item['phone_number'] . "</td>";
                                echo"<td><a href='php/delete.php?id=". $item['id'] ."&table=requests'>Удалить</a></td>";
                            echo"</tr>";
                        } 
                    ?> 
                </table>
            </div>
        </div>
        <div class="spoiler-wrap disabled">
            <div class="spoiler-head">Записи</div>
            <div class="spoiler-body">Текст</div>
        </div>
        <div class="spoiler-wrap disabled">
            <div class="spoiler-head">Клиенты</div>
            <div class="spoiler-body">
                <table>
                    <tr>
                        <td>#</td>
                        <td>Имя</td>
                        <td>Номер телефона</td>
                        <td>Скидка</td>
                    </tr>
                    <?php
                        $users = R::findAll('clients');
                        foreach ($users as $item){
                            if($item['access_level'] == 0){
                                echo"<tr>";
                                    echo"<td>" . $item['id'] . "</td>";
                                    echo"<td>" . $item['fio'] . "</td>";
                                    echo"<td>" . $item['phone_number'] . "</td>";
                                    echo"<td>" . $item['discount'] . "%</td>";
                                echo"</tr>";
                            }    
                        }
                    ?> 
                </table>
            </div>
        </div>
        <div class="spoiler-wrap disabled">
            <div class="spoiler-head">Мастера</div>
            <div class="spoiler-body">
                <table>
                    <tr>
                        <td>#</td>
                        <td>ФИО</td>
                        <td>Номер телефона</td>
                        <td>Биография</td>
                        <td>Действия</td>
                    </tr>
                    <?php
                        $users = R::findAll('masters');
                        foreach ($users as $item){
                            echo"<tr>";
                                echo"<td>" . $item['id'] . "</td>";
                                echo"<td>" . $item['fio'] . "</td>";
                                echo"<td>" . $item['phone_number'] . "</td>";
                                echo"<td>" . $item['biography'] . "</td>";
                                echo"<td><a href='php/delete.php?id=". $item['id'] ."&table=masters'>Удалить</a></td>";
                            echo"</tr>";
                        } 
                    ?> 
                </table>
                <p>Добавление мастера</p>
                <?php
                $data = $_POST;

                // проверка формы на пустоту полей
                    $errors = array();
                    if ( trim($data['fio']) == '' )
                    {
                        $errors_masters[] = 'Введите ФИО';
                    }

                    if ( trim($data['phone_number']) == '' )
                    {
                        $errors_masters[] = 'Введите номер телефона';
                    }

                    if ( $data['biography'] == '' )
                    {
                        $errors_masters[] = 'Введите биографию';
                    }

                    if ( empty($errors_masters) )
                    {
                        //ошибок нет, теперь регистрируем
                        $user = R::dispense('masters');
                        $user->fio = $data['fio'];
                        $user->phone_number = $data['phone_number'];
                        $user->biography = $data['biography'];
                        R::store($user);
                        // header( "refresh:0;url=admin.php" );
                    }
                ?>

                <div>
                    <form action="admin.php" method="POST">
                        <table>
                            <tr>
                                <td><strong>ФИО</strong></td>
                                <td><input type="text" name="fio" value="<?php echo @$data['fio']; ?>"></td>
                            </tr>
                            <tr>
                                <td><strong>Номер телефона</strong></td>
                                <td><input type="tel" name="phone_number" placeholder="10 цифр, без +7" pattern="\s?[\(]{0,1}9[0-9]{2}[\)]{0,1}\s?\d{3}[-]{0,1}\d{2}[-]{0,1}\d{2}"></td>
                            </tr>
                            <tr>
                                <td><strong>Биография</strong></td>
                                <td><input type="text" name="biography" value="<?php echo @$data['biography']; ?>"></td>
                            </tr>
                            <tr>
                                <td colspan="2"><button type="submit" name="do_signup">Продолжить регистрацию</button></td>
                            </tr>
                            <?php
                            if ( ! empty($errors_masters) )
                            {
                                //выводим ошибки авторизации
                                echo "<tr><td colspan='2'>" . array_shift($errors) . "</td></tr>";
                            }
                            ?>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <?php if($_SESSION['logged_user']['access_level'] == '2'){ ?>
        <div class="spoiler-wrap disabled">
            <div class="spoiler-head">Управляющий персонал (admin)</div>
            <div class="spoiler-body">
                <table>
                    <tr>
                        <td>#</td>
                        <td>Имя</td>
                        <td>Номер телефона</td>
                        <td>Уровень доступа</td>
                    </tr>
                    <?php
                        $users = R::findAll('users');
                        foreach ($users as $item){
                            echo"<tr>";
                                echo"<td>" . $item['id'] . "</td>";
                                echo"<td>" . $item['name'] . "</td>";
                                echo"<td>" . $item['phone_number'] . "</td>";
                                if($item['access_level'] == 1){
                                    echo"<td>Менеджер</td>";
                                }
                                if($item['access_level'] == 2){
                                    echo"<td>Администратор</td>";
                                }
                            echo"</tr>";   
                        }
                    ?> 
                </table>
                <p>Добавление персонала</p>
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
                        $user->access_level = $data['access_level'];
                        R::store($user);
                        // header( "refresh:0;url=admin.php" );
                    }
                ?>

                <div>
                    <form action="admin.php" method="POST">
                        <table>
                            <tr>
                                <td><strong>Имя</strong></td>
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
                                <td><strong>Уровень доступа</strong></td>
                                <td><input type="text" name="access_level" value="<?php echo @$data['access_level']; ?>"></td>
                            </tr>
                            <tr>
                                <td colspan="2"><button type="submit" name="do_signup">Продолжить регистрацию</button></td>
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
        </div>
        <?php } ?>
    </div>
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="js/spoiler.js" type="text/javascript"></script> 
</body> 
</html>

<?php else: ?>
    <meta http-equiv="refresh" content="0;URL=authorization.php" />
<?php endif; ?>