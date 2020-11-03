<?php
function getDataIsAuthAndEmptyPerson($isRole) {
    if($_COOKIE['role'] === $isRole) {
        require $_SERVER['DOCUMENT_ROOT']."/db/db.php";
        $person = R::load('person', $_COOKIE['userID']);
        if(count($person) <= 1) {
            setcookie('role',   '', time() - (60*60*24*30), "/");
            setcookie('userID',   '', time() - (60*60*24*30), "/");
            header("Location: /");
        }
        return $person;
    } else {
        die(header("HTTP/1.1 401 Unauthorized "));
    }
}

$person = getDataIsAuthAndEmptyPerson('0');

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
                    <div class="ui red left ribbon label"><?php echo $person -> login; ?></div>

                    <img class="ui image centered" src="/images/user2.jpg"
                         style="object-fit: cover; height: 200px; width: 200px;
                         border-radius: 54% 46% 47% 53% / 24% 55% 45% 76%;">
                    <div class="ui tiny icon buttons orange fluid" style="margin-top: 20px">
                        <a href="/queries/exit.php" class="ui button"><i class=" sign-out large icon"></i></a>
                        <button class="ui button"  onclick="openModalWindowForAvatarReplace()" >
                            <i class="file large image icon"></i>
                        </button>
                    </div>

                </div>
                <!--
                * Кнопка для перехода в панель управления
                -->
                <a href="/student/panel.php" class="ui green button fluid">Панель управления</a>
            </div>
            <div class="column twelve wide">
                <div class="ui segment">
                    <h2 class="ui center aligned header" style="color: #db2828">Портфолио</h2>
                    <h4 class="ui horizontal divider header"><i class="address book red icon"></i> Учетные данные </h4>
                    <table class="ui very basic table">
                        <tbody class="center aligned">
                        <tr>
                            <td><b>Фио:</b></td>
                            <td>
                                <?php echo $person -> surname, " ", $person -> name, " ", $person -> patronymic; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Группа:</b></td>
                            <td>"Группа студента"</td>
                        </tr>
                        <tr>
                            <td><b>Роль:</b></td>
                            <td>Студент</td>
                        </tr>
                        <tr>
                            <td><b>Дата рождения:</b></td>
                            <td>"01.01.1000"</td>
                        </tr>
                        <tr>
                            <td><b>Возраст:</b></td>
                            <td>"10"</td>
                        </tr>
                        <tr>
                            <td><b>Почта:</b></td>
                            <td><?php echo $person -> email; ?></td>
                        </tr>
                        <tr>
                            <td><b>Смена пароля:</b></td>
                            <td><a href="#" onclick="openModalWindowForPassReplace()">Сменить</a></td>
                        </tr>
                        <tr>
                            <td><b>Учебная группа:</b></td>
                            <td>
                                <a href="#" onclick="openModalWindowForGroupBinding()">"Привязаться"</a>
                                /"Группа"
                                <a href="#" onclick="openModalWindowForGroupLeaving()">(Выйти)</a>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Преподаватель:</b></td>
                            <td>"Фамилия И. О."</td>
                        </tr>
                        </tbody>
                    </table>
                    <h4 class="ui horizontal divider header"><i class="chart bar red icon"></i> Физические параметры </h4>
                    <table class="ui very basic table">
                        <tbody class="center aligned">
                        <tr>
                            <td><b>Вес:</b></td>
                            <td>"10"</td>
                        </tr>
                        <tr>
                            <td><b>Рост:</b></td>
                            <td>"100"</td>
                        </tr>
                        <tr>
                            <td><b>Индекс Кетле:</b></td>
                            <td>"Истощение/Пониженный/Нормальный/Повышенный/Ожирение"</td>
                        </tr>
                        <tr>
                            <td><b>Ортостатическая проба:</b></td>
                            <td>"Отлично/Хорошо/Удовлетворительно/Неудовлетворительно"</td>
                        </tr>
                        <tr>
                            <td><b>Индекс Руффье:</b></td>
                            <td>"Отлично/Хорошо/Удовлетворительно/Неудовлетворительно"</td>
                        </tr>
                        <tr>
                            <td><b>Проба Штанге:</b></td>
                            <td>"Отлично/Хорошо/Удовлетворительно/Неудовлетворительно"</td>
                        </tr>
                        <tr>
                            <td><b>Жалобы на здоровье:</b></td>
                            <td>"Отсутствуют/Перечисление"</td>
                        </tr>
                        <tr>
                            <td><b>Самочувствие:</b></td>
                            <td>"Хорошее/Удовлетворительное/Плохое"</td>
                        </tr>
                        <tr>
                            <td><b>Настроение:</b></td>
                            <td>"Хорошее/Удовлетворительное/Плохое"</td>
                        </tr>
                        <tr>
                            <td><b>Сон:</b></td>
                            <td>"Хороший/Плохой/Бессонница"</td>
                        </tr>
                        <tr>
                            <td><b>Аппетит:</b></td>
                            <td>"Повышенный/Нормальный/Пониженный"</td>
                        </tr>
                        <tr>
                            <td><b>Работоспособность:</b></td>
                            <td>"Повышенная/Обычная/Пониженная"</td>
                        </tr>
                        </tbody>
                        <tfoot class="full-width">
                        <tr>
                            <th></th>
                            <th>
                                <div class="ui right floated small green labeled icon button" onclick="openModalSendPhysicalParameters()">
                                    <i class="edit icon"></i>
                                    Изменить
                                </div>
                            </th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="ui segment">
                    <h2 class="ui center aligned header" style="color: #db2828">Графики</h2>
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
                <li>Старый пароль неверен или новые несовпадают</li>
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


<div class="ui modal horizontal flip tiny" id="modalGroupBinding">
    <div class="header" style="color: #db2828">
        Привязаться к группе
    </div>
    <div class="content">
        <form class="ui form">
            <div class="required field">
                <label>Ключевое слово</label>
                <div class="ui left icon input">
                    <input type="text" placeholder="Введите ключевое слово привязки" required>
                    <i class="key icon red"></i>
                </div>
            </div>
        </form>
        <div class="ui error message">
            <i class="close icon"></i>
            <div class="header">Ошибка привязки к группе</div>
            <ul>
                <li>Используемое ключевое слово неактивно</li>
                <li>Обратитесь к старосте или к преподавателю для получения валидного ключевого слова</li>
            </ul>
        </div>
    </div>
    <div class="actions">
        <button class="ui right labeled icon green button">
            Подтвердить
            <i class="check icon"></i>
        </div>
    </div>
</div>

<div class="ui modal horizontal flip tiny" id="modalGroupLeaving">
    <h1 class="ui header center aligned">
        Вы уверены, что хотите выйти из группы?
    </h1>
    <div class="actions">
        <button class="ui right labeled icon red button" onclick="hideModalWindowForGroupLeaving()">
            Отклонить
            <i class="close icon"></i>
        </button>
        <button class="ui right labeled icon green button">
            Подтвердить
            <i class="check icon"></i>
        </button>
    </div>
</div>

<div class="ui modal horizontal flip big" id="modalSendPhysicalParameters">
    <div class="header" style="color: #db2828">
        Изменить физические параметры
    </div>
    <div class="content">
        <form class="ui form">
            <div class="fields">
                <div class="required field three wide">
                    <label>Вес</label>
                    <div class="ui left icon input">
                        <input type="number" placeholder="Ваш рост" required>
                        <i class="weight icon red"></i>
                    </div>
                </div>
                <div class="required field three wide">
                    <label>Рост</label>
                    <div class="ui left icon input">
                        <input type="number" placeholder="Ваш вес" required>
                        <i class="child icon red"></i>
                    </div>
                </div>
            </div>

            <div class="four fields">
                <div class="required field">
                    <label>Индекс Кетле</label>
                    <div class="ui left icon input">
                        <input type="number" placeholder="Числовое значение" required>
                        <i class="chart line icon red"></i>
                    </div>
                </div>
                <div class="required field">
                    <label>Ортостатическая проба</label>
                    <div class="ui left icon input">
                        <input type="number" placeholder="Числовое значение" required>
                        <i class="chart line icon red"></i>
                    </div>
                </div>
                <div class="required field">
                    <label>Индекс Руффье</label>
                    <div class="ui left icon input">
                        <input type="number" placeholder="Числовое значение" required>
                        <i class="chart line icon red"></i>
                    </div>
                </div>
                <div class="required field">
                    <label>Проба Штанге</label>
                    <div class="ui left icon input">
                        <input type="number" placeholder="Числовое значение" required>
                        <i class="chart line icon red"></i>
                    </div>
                </div>
            </div>


            <div class="field">
                <label>Жалобы на здоровье</label>
                <div class="ui left icon input">
                    <input type="text" placeholder="Перечислите, если есть">
                    <i class="stethoscope icon red"></i>
                </div>
            </div>

            <div class="fields">
                <div class="required field">
                    <label>Самочувствие</label>
                    <div class="ui left icon input">
                        <div class="ui selection dropdown">
                            <input type="hidden" name="student_state_of_health">
                            <i class="dropdown icon"></i>
                            <div class="default text">Выберите</div>
                            <div class="menu">
                                <div class="item" data-value="2">Хорошее</div>
                                <div class="item" data-value="1">Удовлетворительное</div>
                                <div class="item" data-value="0">Плохое</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="required field">
                    <label>Настроение</label>
                    <div class="ui left icon input">
                        <div class="ui selection dropdown">
                            <input type="hidden" name="student_mood">
                            <i class="dropdown icon"></i>
                            <div class="default text">Выберите</div>
                            <div class="menu">
                                <div class="item" data-value="2">Хорошее</div>
                                <div class="item" data-value="1">Удовлетворительное</div>
                                <div class="item" data-value="0">Плохое</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="required field">
                    <label>Сон</label>
                    <div class="ui left icon input">
                        <div class="ui selection dropdown">
                            <input type="hidden" name="student_sleep">
                            <i class="dropdown icon"></i>
                            <div class="default text">Выберите</div>
                            <div class="menu">
                                <div class="item" data-value="2">Хороший</div>
                                <div class="item" data-value="1">Плохой</div>
                                <div class="item" data-value="0">Бессонница</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="fields">
                <div class="required field">
                    <label>Аппетит</label>
                    <div class="ui left icon input">
                        <div class="ui selection dropdown">
                            <input type="hidden" name="student_appetite">
                            <i class="dropdown icon"></i>
                            <div class="default text">Выберите</div>
                            <div class="menu">
                                <div class="item" data-value="2">Повышенный</div>
                                <div class="item" data-value="1">Нормальный</div>
                                <div class="item" data-value="0">Пониженный</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="required field">
                    <label>Работоспособность</label>
                    <div class="ui left icon input">
                        <div class="ui selection dropdown">
                            <input type="hidden" name="student_efficiency">
                            <i class="dropdown icon"></i>
                            <div class="default text">Выберите</div>
                            <div class="menu">
                                <div class="item" data-value="2">Повышенная</div>
                                <div class="item" data-value="1">Обычная</div>
                                <div class="item" data-value="0">Пониженная</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="actions">
        <button class="ui right labeled icon red button" onclick="hideModalSendPhysicalParameters()">
            Отклонить
            <i class="close icon"></i>
        </button>
        <button class="ui right labeled icon green button">
            Изменить
            <i class="check icon"></i>
        </button>
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

    function openModalWindowForGroupBinding() {
        $('#modalGroupBinding')
            .modal({
                inverted: true
            })
            .modal('show')
        ;
    }

    function openModalWindowForGroupLeaving() {
        $('#modalGroupLeaving')
            .modal({
                inverted: true
            })
            .modal('setting', 'closable', false)
            .modal('show')
        ;
    }

    function hideModalWindowForGroupLeaving() {
        $('#modalGroupLeaving')
            .modal('hide')
        ;
    }

    function openModalSendPhysicalParameters() {
        $('#modalSendPhysicalParameters')
            .modal({
                inverted: true
            })
            .modal('setting', 'closable', false)
            .modal('show')
        ;
    }

    function hideModalSendPhysicalParameters() {
        $('#modalSendPhysicalParameters')
            .modal('hide')
        ;
    }
</script>
</html>