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
    <title>HeartBlaze</title>
</head>
<style>
    @media (max-width: 767px) {
        .ui.vertical.divider
        {
            display: none;
        }
        body
        {
            height: auto;
        }
    }
</style>
<body style="
        background-image: url(/images/bg.jpg);
        display: flex;
        justify-content: center;
        align-items: center">

<!--
* Сегмент(1) Здесь находится блок авторизации.
* data-tab - ID сегмента, который должен быть активен. В классе указано свойство - active
 -->
<div class="ui segment tab active blue" data-tab="1">
    <!--
    * Сегмент делим на две колонки (свойство - two column)
    -->
    <div class="ui two column very relaxed stackable grid">
        <!--
        * первая колонка
        -->
        <div class="column">
            <!--
            * Логотип и заголовок первой колонки
            -->
            <img class="ui small circular image centered" src="/images/ugatu_logo.png">
            <h2 class="ui header center aligned" style="color: #db2828">Авторизация в системе</h2>

            <!--
            * Форма отправки данных авторизации на проверку (добавить method="post")
            -->
            <form class="ui form" id="loginPerson">
                <!--
                * Каждое поле ввода содержит ПОЛЕ, и заголовок над полем, также есть иконка
                * required - обязательное для ввода
                -->
                <div class="field">
                    <label>Логин</label>
                    <div class="ui left icon input">
                        <input type="text" placeholder="Логин" name="user_name" required>
                        <i class="user icon red"></i>
                    </div>
                </div>
                <div class="field">
                    <!--
                    * Ссылка, активирующая функцию с помощью onclick
                    *
                    -->
                    <div class="inline">
                        <a href="#" class="fluid" style="float: right" onclick="openModalWindowForPassRecovery()">Забыли пароль?</a>
                    </div>
                    <label>Пароль</label>
                    <div class="ui left icon input">
                        <input type="password" placeholder="Пароль" required>
                        <i class="lock icon red"></i>
                    </div>
                </div>
                <!--
                * Кнопка, активирующая отправку POST запроса
                -->
                <button class="ui blue submit button fluid">Войти</button>
            </form>
            <!--
            * Вывод сообщения об ошибке
            -->
            <div class="ui error message" id="errorLogin" style="display: none">
                <i class="close icon"></i>
                <div class="header">Ошибка авторизации</div>
                <ul>
                    <li>Неверно введен логин или пароль</li>
                    <li>Повторите ввод или восстановите доступ к учетной записи</li>
                </ul>
            </div>
        </div>

        <!--
        * Вторая колонка, с информацией о регистрации
        -->
        <div class="column">
            <h2 class="ui header center aligned" style="color: #db2828; margin-bottom: 40px">Регистрация нового пользователя</h2>
            <div class="ui list">
                <a class="item" style="margin-bottom: 20px">
                    <i class="right triangle red icon"></i>
                    <div class="content">
                        <div class="header">Вносите данные</div>
                        <div class="description">Делитесь своими данными занятий с преподавателем</div>
                    </div>
                </a>
                <a class="item" style="margin-bottom: 20px">
                    <i class="right triangle red icon"></i>
                    <div class="content">
                        <div class="header">Отслеживайте свой прогресс</div>
                        <div class="description">Вы можете следить за своими успехами с помощью удобных диаграмм</div>
                    </div>
                </a>
                <a class="item" style="margin-bottom: 20px">
                    <i class="right triangle red icon"></i>
                    <div class="content">
                        <div class="header">Посещайте занятия</div>
                        <div class="description">И сдавайте нормативы онлайн</div>
                    </div>
                </a>
                <a class="item" style="margin-bottom: 20px">
                    <i class="right triangle red icon"></i>
                    <div class="content">
                        <div class="header">Рассчитывайте физиологические индексы онлайн</div>
                        <div class="description">Анализ ваших физических данных</div>
                    </div>
                </a>
                <a class="item" style="margin-bottom: 20px">
                    <i class="right triangle red icon"></i>
                    <div class="content">
                        <div class="header">Проверяйте посещаемость студентов</div>
                        <div class="description">Выставляйте оценки и следите за успеваемостью</div>
                    </div>
                </a>
            </div>
            <!--
            * Активирует сегмент с data-tab="2"
            -->
            <a class="ui blue submit button fluid item" data-tab="2" id="tabular">Зарегистрироваться</a>
        </div>
    </div>
    <!--
    * Разделитель колонок
    -->
    <div class="ui vertical divider"></div>
</div>

<!--
* Семент регистрации
* Он не активен при первом запуске, его активирует кнопка "Зарегистрироваться"
-->
<div class="ui segment tab blue" style="width: 80%" data-tab="2">
    <a href="/" class="ui labeled icon button blue" style="margin-bottom: 20px"><i class="icon arrow left"></i> Вход </a>
    <!--
    * Сообщение об ошибке
    -->
    <div class="ui error message">
        <i class="close icon"></i>
        <div class="header">Ошибка регистрации</div>
        <ul>
            <li>Пользователь с данным логином уже зарегистрирован</li>
            <li>Смените логин или обратитесь к администратору</li>
        </ul>
    </div>

    <!--
    * Форма регистрации
    -->
    <form class="ui form">
        <h4 class="ui dividing header" style="color: #db2828">Персональные данные</h4>
        <!--
        * В одной строке три поля (имя и фамилия обязательны для ввода)
        -->
        <div class="three fields">
            <div class="required field">
                <label>Фамилия</label>
                <input type="text" placeholder="Ваша фамилия" required>
            </div>
            <div class="required field">
                <label>Имя</label>
                <input type="text" placeholder="Ваше имя" required>
            </div>
            <div class="field">
                <label>Отчество</label>
                <input type="text" placeholder="Ваше отчество">
            </div>
        </div>
        <h4 class="ui dividing header" style="color: #db2828">Данные авторизации</h4>
        <div class="three fields">
            <div class="required field">
                <label>Логин</label>
                <input type="text" placeholder="Логин для входа" required>
            </div>
            <div class="required field">
                <label>Пароль</label>
                <input type="password" placeholder="Пароль для входа" required>
            </div>
            <div class="required field">
                <label>Почта</label>
                <input type="email" placeholder="Ваша электронная почта" required>
            </div>
        </div>
        <!--
        * Поле в одну строку, в котром находятся радиокнопки
        -->
        <div class="field inline" style="margin-top: 5px">
            <div class="ui slider checkbox">
                <input type="radio" name="whoAuthorization" value="0" checked="checked">
                <label>Я студент</label>
            </div>
            <div class="ui slider checkbox">
                <input type="radio" name="whoAuthorization" value="1">
                <label>Я преподаватель</label>
            </div>
        </div>
        <div class="required inline field">
            <div class="ui checkbox">
                <input type="checkbox" required>
                <label>Я согласен(-на) с обработкой персональных данных</label>
            </div>
        </div>
    <!--
    * Кнопка, активирующая отправку POST запроса
    -->
    <button class="ui right floated labeled icon button green"><i class="right arrow icon"></i> Создать аккаунт </button>
    </form>
</div>

<!--
* Модальное окно восстановления пароля
-->
<div class="ui modal tiny">
    <i class="close icon"></i>
    <div class="header" style="color: #db2828">
        Восстановление пароля
    </div>
    <div class="content">
        <p>На указанную почту придет новый пароль и ссылка подтверждения для его смены</p>
        <form class="ui form">
            <div class="required field">
                <label>Логин</label>
                <div class="ui left icon input">
                    <input type="text" placeholder="Логин для проверки" required>
                    <i class="user icon red"></i>
                </div>
            </div>
            <div class="required field">
                <label>Почта</label>
                <div class="ui left icon input">
                    <input type="email" placeholder="Почта" required>
                    <i class="mail icon red"></i>
                </div>
            </div>
        </form>
        <div class="ui error message">
            <i class="close icon"></i>
            <div class="header">Ошибка восстановления пароля</div>
            <ul>
                <li>Пользователя с данным логином или почтой не существует</li>
                <li>Повторите ввод</li>
            </ul>
        </div>
    </div>
    <div class="actions">
        <div class="ui right labeled icon blue button">
            Отправить сообщение
            <i class="mail icon"></i>
        </div>
    </div>
</div>

</body>
<script>
    //скрипт скрытия сообщения об ошибке по нажатию на иконку крестика
    $('.message .close')
        .on('click', function() {
            $(this)
                .closest('.message')
                .transition('fade')
            ;
        })
    ;

    //таблуляция сегментов (скрытие их как вкладки)
    $('#tabular')
        .tab()
    ;

    //функция отображения модального окна
    function openModalWindowForPassRecovery() {
        $('.ui.modal')
            .modal({
                inverted: true
            })
            .modal('show')
        ;
    }


    /**Динамическая отправка запроса (авторизация)
     * done - есть запрос выполнился успешно
     * error - если запрос вернулся с ошибкой, ее надо делать в try {} catch() {}
     */
    $("#loginPerson").submit(function () {
        $.ajax({
            url: "/queries/login.php",
            method: "POST",
            data: $(this).serialize(),
            success: function () {

            },
            error: function () {
                //запрос вернул ошибку, сменим стиль блока (блока ошибки), то есть отобразим его
                document.getElementById("errorLogin").style.display = "block";
            }
        });
        return false;
    });
</script>
</html>