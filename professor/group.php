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
    <title>Группа - "Группа"</title>
</head>
<body style="background-image: url(/images/bg.jpg)">
<div class="ui container">
    <div class="field">
        <a href="/professor/panel.php" class="ui floated small blue labeled icon button">
            <i class="arrow left icon"></i>Назад
        </a>
        <button onclick="openModalWindowForAddLesson()" class="ui floated small green labeled icon button">
            <i class="plus circle icon"></i>Добавить занятие
        </button>
        <button onclick="openModalWindowStudentsVisits()" class="ui floated small orange labeled icon button">
            <i class="table icon"></i>Посещения
        </button>
        <button onclick="openModalWindowAllDataStudents()" class="ui floated small brown labeled icon button">
            <i class="table icon"></i>Данные студентов
        </button>
        <button  class="ui floated small teal labeled icon button">
            <i class="excel file icon"></i>Экспортировать данные
        </button>
    </div>
    <div class="ui info message">
        <div class="header">Студенты отсутствуют:</div>
        <ul>
            <li>Отправьте ключевое слово студентам, чтобы они могли привязаться к вашей группе</li>
            <li>Ключевые слова для каждых ваших групп находятся в панели управления в таблице групп</li>
        </ul>
    </div>
    <h3 class="ui top attached header center aligned red" style="margin-top: 20px">
        Список студентов
    </h3>
    <div class="ui segment attached top">
        <div class="ui comments">
            <div class="comment">
                <a class="avatar">
                    <img src="/images/user2.jpg" style="object-fit: cover; height: 35px; width: 35px;">
                </a>
                <div class="content">
                    <a class="author">Фамилия Имя Отчество</a>
                    <div class="metadata">
                        <!--Посещаемость-->
                        <div class="date"><i class="calendar outline blue icon"></i>"2 из 5"</div>
                        <!--Балл-->
                        <div class="rating"><i class="star blue icon"></i>"35"</div>
                    </div>
                    <div class="text">Учится в "Группа студента из группы"</div>
                    <div class="actions">
                        <a class="hide" onclick="openModalWindowForStudentOfGroupRemove()"><i class="user close red icon"></i>Удалить студента</a>
                        <a onclick="openModalWindowStudentCard()"><i class="id card orange icon""></i> Показать физические параметры </a>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="ui info message">
        <div class="header">Занятия отсутствуют:</div>
        <ul>
            <li>Добавьте занятие, чтобы начать получать данные от студентов</li>
        </ul>
    </div>

    <h3 class="ui top attached header center aligned red" style="margin-top: 20px">
        Таблица занятий
    </h3>
    <table class="ui celled attached table">
        <thead class="center aligned">
        <tr>
            <th>Дата</th>
            <th>Проверка</th>
            <th>Удаление</th>
        </tr>
        </thead>
        <tbody class="center aligned">
        <tr>
            <td>"01.01.2000"</td>
            <td>
                <button class="ui orange icon button" onclick="openModalWindowForCheckDataStudents()">
                    <i class="icon checked calendar" style="color: white"></i>
                </button>
                /
                <i class="green check circle icon"></i>
            </td>

            <td>
                <button class="ui red icon button" onclick="openModalWindowForRemoveLesson()">
                    <i class="icon trash" style="color: white"></i>
                </button>
            </td>
        </tr>
        </tbody>
        <tfoot class="full-width">
        <tr>
            <th colspan="4">
                <div class="ui orange label"><i class="calendar icon"></i> "1"</div>
            </th>
        </tr>
        </tfoot>
    </table>
</div>

<div class="ui modal horizontal flip tiny" id="modalStudentOfGroupRemove">
    <h1 class="ui header center aligned">
        Вы уверены, что хотите удалить данного студента из группы?
    </h1>
    <div class="actions">
        <button class="ui right labeled icon red button" onclick="hideModalWindowForStudentOfGroupRemove()">
            Отклонить
            <i class="close icon"></i>
        </button>
        <button class="ui right labeled icon green button">
            Подтвердить
            <i class="check icon"></i>
        </button>
    </div>
</div>

<div class="ui modal horizontal flip tiny" id="modalRemoveLesson">
    <h1 class="ui header center aligned">
        Вы уверены, что хотите удалить данное занятие?
    </h1>
    <div class="actions">
        <button class="ui right labeled icon red button" onclick="hideModalWindowForRemoveLesson()">
            Отклонить
            <i class="close icon"></i>
        </button>
        <button class="ui right labeled icon green button">
            Подтвердить
            <i class="check icon"></i>
        </button>
    </div>
</div>

<div class="ui modal horizontal flip tiny" id="modalAddLesson">
    <h1 class="ui header" style="color: #db2828">
        Добавить занятие
    </h1>
    <div class="content">
        <form class="ui form">
            <div class="field required">
                <label>Дата занятия</label>
                <div class="ui left icon input">
                    <input type="date" required>
                    <i class="calendar alternate red icon"></i>
                </div>
            </div>
            <div class="field">
                <label>Нормативы</label>
                <div class="ui left icon input">
                    <div class="ui fluid search multiple selection dropdown">
                        <input type="hidden" name="normative">
                        <i class="dropdown icon"></i>
                        <div class="default text">Отсутствуют</div>
                        <div class="menu">
                            <div class="item" data-value="1">Подтягивание на перекладине</div>
                            <div class="item" data-value="2">Прыжок в длину</div>
                            <div class="item" data-value="3">Бег 3 км.</div>
                            <div class="item" data-value="4">Бег 12 мин.</div>
                            <div class="item" data-value="5">Подъем туловища лежа</div>
                            <div class="item" data-value="6">Подъем туловища и ног</div>
                            <div class="item" data-value="7">Сгибание и разгибание рук в упоре лежа</div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="ui warning message">
            <div class="header">Студенты отсутствуют:</div>
            <ul>
                <li>Вы не можете создавать занятия, пока нет студентов</li>
            </ul>
        </div>
    </div>
    <div class="actions">
        <button class="ui right labeled icon green button">
            Добавить
            <i class="plus circle icon"></i>
        </button>
    </div>
</div>

<div class="ui horizontal flip modal" id="modalStudentCard">
    <h1 class="ui header" style="color: #db2828">
        "Фамилия И. О."
    </h1>
    <div class="content">
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
        </table>
    </div>
    <h3 class="ui header center aligned" style="color: #db2828">
        Графики
    </h3>
</div>

<div class="ui modal horizontal flip large" id="modalStudentsVisits">
    <h1 class="ui header" style="color: #db2828">
        Посещения занятий студентами
    </h1>
    <div class="content">
        <div style="overflow-x: scroll; margin-top: 15px">
            <table class="ui sortable  celled table scrolling ">
                <thead>
                <tr>
                    <th>Студент</th>
                    <th>"Дата"</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>"Фамилия И. О. (группа)"</td>
                    <td><i class="green plus circle icon"></i>
                        /
                        <i class="red minus circle icon"></i>
                        /
                        <i class="brown question circle icon"></i>
                    </td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th>
                        <div class="ui orange label">
                            <i class="users icon"></i>"22"
                        </div>
                    </th>
                    <th>
                        <div class="ui brown label">
                            <i class="calendar check icon"></i>"15"
                        </div>
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>


<div class="ui large horizontal flip modal" id="modalAllDataStudents">
    <h1 class="ui header" style="color: #db2828">
        Данные студентов за занятия
    </h1>
    <div class="content">
        <h4 class="ui header center aligned">Данные занятия</h4>
        <div style="overflow-x: scroll; margin-top: 15px">
            <table class="ui sortable  celled table scrolling center aligned">
                <thead>
                <tr>
                    <th rowspan="2">Дата</th>
                    <th rowspan="2">Студент</th>
                    <th rowspan="2">Дистанция (м.)</th>
                    <th colspan="4">Время (мин.)</th>
                    <th colspan="5">Пульс</th>
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
                    <td>"10.10.2000"</td>
                    <td>"Фамилия И. О."</td>
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
                </tr>
                </tbody>
            </table>
        </div>
        <h4 class="ui header center aligned">Нормативы</h4>
        <table class="ui sortable celled table scrolling center aligned">
            <thead>
            <tr>
                <th>Норматив</th>
                <th>Значение</th>
                <th>Оценка</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>"Название норматива"</td>
                <td>"214"</td>
                <td>"1/2/3/4/5"</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>


<div class="ui modal horizontal flip large" id="modalCheckDataStudents">
    <h1 class="ui header" style="color: #db2828">
        Проверка данных студентов за занятие ("Дата")
    </h1>
    <div class="content">
        <form class="ui form">
            <h3>"Фамилия И. О."</h3>
            <div style="overflow-x: scroll; margin-top: 15px">
                <table class="ui sortable  celled table scrolling center aligned">
                    <thead>
                    <tr>
                        <th rowspan="2">Дистанция (м.)</th>
                        <th colspan="4">Время (мин.)</th>
                        <th colspan="5">Пульс</th>
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
                    </tr>
                    </tbody>
                </table>
            </div>
                <table class="ui sortable celled table scrolling center aligned">
                    <thead>
                    <tr>
                        <th>Норматив</th>
                        <th>Значение</th>
                        <th>Оценка</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>"Название норматива"</td>
                        <td>"214"</td>
                        <td>
                            <div class="ui left icon input">
                                <div class="ui fluid selection dropdown">
                                    <input type="hidden" name="student_normative_score">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Сделайте выбор</div>
                                    <div class="menu">
                                        <div class="item" data-value="0">0</div>
                                        <div class="item" data-value="1">1</div>
                                        <div class="item" data-value="2">2</div>
                                        <div class="item" data-value="3">3</div>
                                        <div class="item" data-value="4">4</div>
                                        <div class="item" data-value="5">5</div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="field" style="margin-top: 10px">
                    <label>Присутствие</label>
                    <div class="ui checkbox">
                        <input type="checkbox">
                        <label>Присутствовал (-ла)</label>
                    </div>
                </div>
            <div class="ui divider"></div>
        </form>

    </div>
    <div class="actions">
        <button class="ui right labeled icon red button" onclick="hideModalWindowForCheckDataStudents()">
            Отклонить
            <i class="close icon"></i>
        </button>
        <button class="ui right labeled icon green button">
            Подтвердить
            <i class="check icon"></i>
        </button>
    </div>
</div>


</body>
<script>
    $('.ui.dropdown')
        .dropdown()
    ;

    function openModalWindowForStudentOfGroupRemove() {
        $('#modalStudentOfGroupRemove')
            .modal({
                inverted: true
            })
            .modal('setting', 'closable', false)
            .modal('show')
        ;
    }

    function hideModalWindowForStudentOfGroupRemove() {
        $('#modalStudentOfGroupRemove')
            .modal('hide')
        ;
    }

    function openModalWindowForRemoveLesson() {
        $('#modalRemoveLesson')
            .modal({
                inverted: true
            })
            .modal('setting', 'closable', false)
            .modal('show')
        ;
    }

    function hideModalWindowForRemoveLesson() {
        $('#modalRemoveLesson')
            .modal('hide')
        ;
    }


    function openModalWindowStudentCard() {
        $('#modalStudentCard')
            .modal({
                inverted: true
            })
            .modal('show')
        ;
    }

    function openModalWindowForAddLesson() {
        $('#modalAddLesson')
            .modal({
                inverted: true
            })
            .modal('show')
        ;
    }

    function openModalWindowStudentsVisits() {
        $('#modalStudentsVisits')
            .modal({
                inverted: true
            })
            .modal('show')
        ;
    }


    function openModalWindowAllDataStudents() {
        $('#modalAllDataStudents')
            .modal({
                inverted: true
            })
            .modal('show')
        ;
    }

    function openModalWindowForCheckDataStudents() {
        $('#modalCheckDataStudents')
            .modal({
                inverted: true
            })
            .modal('setting', 'closable', false)
            .modal('show')
        ;
    }

    function hideModalWindowForCheckDataStudents() {
        $('#modalCheckDataStudents')
            .modal('hide')
        ;
    }
</script>
</html>
