<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/icon.min.css'>
    <link rel="stylesheet" href="/frameworks/semantic.min.css"/>
    <link rel="shortcut icon" href="/images/ugatu_logo.png" type="image/x-icon">
    <script src="/frameworks/jquery.min.js"></script>
    <script src="/frameworks/semantic.min.js"></script>
    <title>Панель управления</title>
</head>
<style>
    *
    {
        scroll-behavior: smooth;
    }
</style>
<body style="background-image: url(/images/bg.jpg)">
<div class="ui container">
    <div class="field">
        <a href="/student/lk.php" class="ui floated small blue labeled icon button">
            <i class="arrow left icon"></i>Назад
        </a>
        <button onclick="openModalWindowNormativeData()" class="ui floated small green labeled icon button">
            <i class="heartbeat icon"></i>Сданные нормативы
        </button>
        <button onclick="openModalWindowParticipationData()" class="ui floated small orange labeled icon button">
            <i class="table icon"></i>Данные занятий
        </button>
        <a href="#blockParticipation" class="ui floated small brown labeled icon button">
            <i class="table icon"></i>К занятиям
        </a>
        <a href="#blockCharts" class="ui floated small teal labeled icon button">
            <i class="chart area icon"></i>К графикам
        </a>
    </div>
    <div class="ui segment">
        <h3 class="ui horizontal divider header"><i class="info red icon"></i>Преподаватель</h3>
        <div class="ui comments">
            <div class="comment">
                <a class="avatar">
                    <img src="/images/user2.jpg" style="object-fit: cover; height: 35px; width: 35px;">
                </a>
                <div class="content">
                    <label class="author" style="color: #db2828">Фамилия Имя Отчество</label>
                    <div class="metadata">
                        <div class="date"><i class="user blue icon"></i>"24"</div>
                        <div class="rating"><i class="mail blue icon"></i>"mail@mail.ru"</div>
                    </div>
                    <div class="text">"Должность"</div>
                    <div class="actions">
                        <a class="hide" onclick="openModalWindowForGroupLeaving()">
                            <i class="user close red icon"></i>Отменить привязку
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <h3 class="ui horizontal divider header"><i class="bar chart red icon"></i>Прогресс</h3>
        <div class="ui progress indicating" data-value="100">
            <div class="bar">
                <div class="progress"></div>
            </div>
            <div class="label">Прогресс посещений</div>
        </div>
        <div class="ui progress indicating" data-value="50">
            <div class="bar">
                <div class="progress"></div>
            </div>
            <div class="label">Балл за занятия</div>
        </div>
        <br>
        <h3 class="ui horizontal divider header"><i class="calendar check red icon"></i>Даты занятий</h3>
        <div class="field" style="margin-bottom: 20px">
            <h4 class="ui dividing header">Все даты</h4>
            <div class="ui blue label" style="margin-bottom: 10px">"01.10.2000"</div>
        </div>
        <div class="field" style="margin-bottom: 20px">
            <h4 class="ui dividing header">Посещенные даты</h4>
            <div class="ui green label" style="margin-bottom: 10px">"01.10.2000"</div>
        </div>
    </div>


    <h3 class="ui horizontal top attached divider header" id="blockParticipation"><i class="table red icon"></i>Таблица занятий</h3>
    <table class="ui celled attached table">
        <thead class="center aligned">
        <tr>
            <th>Дата</th>
            <th>Тип занятия</th>
            <th>Посещение</th>
            <th>Действие</th>
        </tr>
        </thead>
        <tbody class="center aligned">
        <tr class="positive">
            <td>"01.01.2000"</td>
            <td>Обычное/С нормативом</td>
            <td>
                <i class="icon big check circle green"></i>
            </td>
            <td>
                <i class="icon big check circle green"></i>
            </td>
        </tr>
        <tr class="warning">
            <td>"01.01.2000"</td>
            <td>Обычное/С нормативом</td>
            <td>
                <i class="icon big circle warning"></i>/<i class="spinner loading big icon"></i
            </td>
            <td>
                <button class="ui blue icon button" onclick="openModalWindowForSendParticipationData()">
                    <i class="icon edit"></i>
                </button>
            </td>
        </tr>
        <tr class="negative">
            <td>"01.01.2000"</td>
            <td>Обычное/С нормативом</td>
            <td>
                <i class="icon big circle close"></i>
            </td>
            <td>
                <i class="icon big circle close"></i>
            </td>
        </tr>
        </tbody>
        <tfoot class="full-width">
        <tr>
            <th colspan="4">
                <div class="ui orange label"><i class="list icon"></i> 1 </div>
            </th>
        </tr>
        </tfoot>
    </table>


    <div class="ui segment" id="blockCharts">
        <h3 class="ui horizontal divider header"><i class="chart area red icon"></i>Графики</h3>
    </div>
</div>



<div class="ui large modal horizontal flip " id="modalNormativeData">
    <h1 class="ui header" style="color: #db2828">Сданные нормативы</h1>
    <div class="content">
        <table class="ui celled table">
            <thead class="center aligned">
            <tr>
                <th>Дата</th>
                <th>Название норматива</th>
                <th>Значение норматива</th>
                <th>Оценка</th>
            </tr>
            </thead>
            <tbody class="center aligned">
            <tr>
                <td>"01.10.2000"</td>
                <td>"Норматив"</td>
                <td>"10"</td>
                <td>"3"</td>
            </tr>
            </tbody>
            <tfoot class="full-width">
            <tr>
                <th colspan="5">
                    <div class="ui orange label"><i class="list icon"></i> 1 </div>
                </th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>

<div class="ui large modal horizontal flip" id="modalParticipationData">
    <h1 class="ui header" style="color: #db2828">Данные занятий</h1>
    <div class="content">
        <div style="overflow-x: scroll; margin-top: 15px">
            <table class="ui sortable  celled table scrolling center aligned">
                <thead>
                <tr>
                    <th rowspan="2">Дата</th>
                    <th rowspan="2">Дистанция (м.)</th>
                    <th colspan="4">Время (мин.)</th>
                    <th colspan="5">Пульс</th>
                    <th rowspan="2">Трекер</th>
                </tr>
                <tr>
                    <th>Общее</th>
                    <th>Основное</th>
                    <th>Разминка</th>
                    <th>Заминка</th>
                    <th>До разминки</th>
                    <th>После разминки</th>
                    <th>После основной</th>
                    <th>После заминки</th>
                    <th>Ч/з 10 мин.</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>"01.10.2000"</td>
                    <td>"10000"</td>
                    <td>"58"</td>
                    <td>"58"</td>
                    <td>"58"</td>
                    <td>"58"</td>
                    <td>"58"</td>
                    <td>"58"</td>
                    <td>"58"</td>
                    <td>"58"</td>
                    <td>"58"</td>
                    <td><a class="ui blue icon button small" href=""><i class="icon linkify"></i></a></td>
                </tr>
                </tbody>
            </table>
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

<div class="ui modal horizontal flip large" id="modalSendParticipationData">
    <h1 class="ui header" style="color: #db2828">Отправка данных занятия</h1>
    <div class="content">
        <form class="ui form">
                <div class="required field">
                    <label>Пульс</label>
                    <div class="five fields">
                        <div class="field">
                            <div class="ui left icon input">
                                <input type="number" placeholder="До разминки" required>
                                <i class="heart icon red"></i>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui left icon input">
                                <input type="number" placeholder="После разминки" required>
                                <i class="heart icon red"></i>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui left icon input">
                                <input type="number" placeholder="После основной" required>
                                <i class="heart icon red"></i>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui left icon input">
                                <input type="number" placeholder="После заминки" required>
                                <i class="heart icon red"></i>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui left icon input">
                                <input type="number" placeholder="Ч/з 10 мин." required>
                                <i class="heart icon red"></i>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="required field">
                <label>Время (минуты)</label>
                <div class="four fields">
                    <div class="field">
                        <div class="ui left icon input">
                            <input type="number" placeholder="Общее" required>
                            <i class="clock icon red"></i>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui left icon input">
                            <input type="number" placeholder="Основное" required>
                            <i class="clock icon red"></i>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui left icon input">
                            <input type="number" placeholder="Разминка" required>
                            <i class="clock icon red"></i>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui left icon input">
                            <input type="number" placeholder="Заминка" required>
                            <i class="clock icon red"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="fields">
                <div class="required field three wide">
                    <label>Дистанция</label>
                    <div class="ui left icon input">
                        <input type="number" placeholder="В метрах" required>
                        <i class="road icon red"></i>
                    </div>
                </div>
                <div class="required field thirteen wide">
                    <label>Ссылка на данные с трекера</label>
                    <div class="ui left icon input">
                        <input type="text" placeholder="Ссылка на Pacer или другое приложение" required>
                        <i class="linkify icon red"></i>
                    </div>
                </div>
            </div>

        </form>
    </div>
    <div class="actions">
        <button class="ui right labeled icon green button">
            Отправить
            <i class="check icon"></i>
        </button>
    </div>
</div>

</body>
<script>
    $('.ui.progress').progress();

    function openModalWindowNormativeData() {
        $('#modalNormativeData')
            .modal({
                inverted: true
            })
            .modal('show')
        ;
    }

    function openModalWindowParticipationData() {
        $('#modalParticipationData')
            .modal({
                inverted: true
            })
            .modal('show')
        ;
    }

    function openModalWindowForSendParticipationData() {
        $('#modalSendParticipationData')
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
</script>
</html>