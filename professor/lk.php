<?php
require $_SERVER['DOCUMENT_ROOT']."/queries/functions.php";
$person = getDataIsAuthAndEmptyPerson('1');
?>


<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/icon.min.css'>
    <link rel="stylesheet" href="/frameworks/semantic.min.css"/>
    <script src="/frameworks/jquery.min.js"></script>
    <script src="/frameworks/semantic.min.js"></script>
    <title>Личный кабинет</title>
</head>
<body style="background-image: url(/images/bg.jpg)">
<!--
* Контейнер - блок с содержимым, имеющий отступы по краям (слева и справа)
-->
<div class="ui container">
    <!--
    * Делим контейнер на две колонки
    -->
    <div class="ui two column stackable grid">
        <!--
        * Ширина первой колонки - 4. Всего в ширину может быть 16 колонок
        -->
        <div class="column four wide">
            <!--
            * Сегмент, в котором располагается аватарка
            -->
            <div class="ui segment inverted blue">
                <div class="ui red left ribbon label"><?php echo $person->login; ?></div>

                <img class="ui image centered" src="/images/user2.jpg" style="object-fit: cover; height: 200px; width: 200px; border-radius: 54% 46% 47% 53% / 24% 55% 45% 76%;">
                <div class="ui tiny icon buttons orange fluid" style="margin-top: 20px">
                    <a href="/queries/exit.php" class="ui button"><i class=" sign-out large icon"></i></a>
                    <button class="ui button"  onclick="openModalWindowForAvatarReplace()" ><i class="file large image icon"></i></button>
                </div>
            </div>
            <!--
            * Кнопка для перехода в панель управления
            -->
            <a href="/professor/panel.php" class="ui green button fluid">Панель управления</a>
        </div>
        <div class="column twelve wide">
            <div class="ui segment">
                <h2 class="ui center aligned header" style="color: #db2828">Портфолио</h2>
                <h4 class="ui horizontal divider header"><i class="address book red icon"></i> Учетные данные </h4>
                <table class="ui very basic table">
                    <tbody class="center aligned">
                    <tr>
                        <td><b>Фио:</b></td>
                        <td><?php echo $person->surname, " ", $person->name, " ", $person->patronymic ?></td>
                    </tr>
                    <tr>
                        <td><b>Роль:</b></td>
                        <td>Преподаватель</td>
                    </tr>
                    <tr>
                        <td><b>Должность:</b></td>
                        <td>"Должность"</td>
                    </tr>
                    <tr>
                        <td><b>Почта:</b></td>
                        <td><?php echo $person->email; ?></td>
                    </tr>
                    <tr>
                        <td><b>Смена пароля:</b></td>
                        <td><a href="#" onclick="openModalWindowForPassReplace()">Сменить</a></td>
                    </tr>
                    <tr>
                        <td><b>Статус:</b></td>
                        <td><a href="#" style="color: #db2828" onclick="openModalCheckProfessor()">Подтвердить</a> / <p style="color: green">Подтвержден</p></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="ui segment">
                <h2 class="ui center aligned header" style="color: #db2828">Возможно, что-то будет</h2>
            </div>
        </div>
    </div>

</div>

<div class="ui modal horizontal flip tiny" id="modalPassReplace">
    <div class="header" style="color: #db2828">
        Смена пароля
    </div>
    <div class="content">
        <form class="ui form">
            <div class="required field">
                <label>Старый пароль</label>
                <div class="ui left icon input">
                    <input type="password" placeholder="Введите старый пароль" required>
                    <i class="lock icon red"></i>
                </div>
            </div>
            <div class="required field">
                <label>Новый пароль</label>
                <div class="ui left icon input">
                    <input type="password" placeholder="Введите новый пароль" required>
                    <i class="lock icon red"></i>
                </div>
            </div>
            <div class="required field">
                <label>Повтор пароля</label>
                <div class="ui left icon input">
                    <input type="password" placeholder="Повторите новый пароль" required>
                    <i class="lock icon red"></i>
                </div>
            </div>
        </form>
        <div class="ui error message">
            <i class="close icon"></i>
            <div class="header">Ошибка смены пароля</div>
            <ul>
                <li>Старый пароль неверен или новые не совпадают</li>
                <li>Повторите ввод</li>
            </ul>
        </div>
    </div>
    <div class="actions">
        <div class="ui right labeled icon green button">
            Подтвердить
            <i class="check icon"></i>
        </div>
    </div>
</div>


<div class="ui modal horizontal flip tiny" id="modalCheckProfessor">
    <div class="header" style="color: #db2828">
        Подтвердить личность преподавателя
    </div>
    <div class="content">
        <form class="ui form">
            <div class="required field">
                <label>Ваше удостоверение</label>
                <div class="ui left icon input">
                    <input type="file" accept="image/*" required>
                    <i class="image icon red"></i>
                </div>
            </div>
        </form>
        <div class="ui warning message">
            <div class="header">Вы уже отправили свои данные на проверку</div>
            <ul>
                <li>Дождитесь подтверждения</li>
                <li>Если администратор отклонит запрос, то ваш личный кабинет будет удален</li>
            </ul>
        </div>
    </div>
    <div class="actions">
        <button class="ui right labeled icon green button">
            Отправить
            <i class="check icon"></i>
    </div>
</div>

<div class="ui modal horizontal flip tiny" id="modalAvatarReplace">
    <div class="header" style="color: #db2828">
        Сменить фотографию
    </div>
    <div class="content">
        <form class="ui form">
            <div class="ui left icon input fluid">
                <input type="file" accept="image/png,image/jpeg" required>
                <i class="image icon red"></i>
            </div>
        </form>
    </div>
    <div class="actions">
        <button class="ui right labeled icon green button">
            Сменить
            <i class="check icon"></i>
    </div>
</div>



</body>
<script>
    $('.message .close')
        .on('click', function() {
            $(this)
                .closest('.message')
                .transition('fade')
            ;
        })
    ;

    $('.ui.dropdown')
        .dropdown()
    ;
    function openModalWindowForAvatarReplace() {
        $('#modalAvatarReplace')
            .modal({
                inverted: true
            })
            .modal('show')
        ;
    }

    function openModalWindowForPassReplace() {
        $('#modalPassReplace')
            .modal({
                inverted: true
            })
            .modal('show')
        ;
    }

    function openModalCheckProfessor() {
        $('#modalCheckProfessor')
            .modal({
                inverted: true
            })
            .modal('show')
        ;
    }

</script>
</html>