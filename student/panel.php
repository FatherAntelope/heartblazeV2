<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/icon.min.css'>
    <link rel="stylesheet" href="/frameworks/semantic.min.css"/>
    <script src="/frameworks/jquery.min.js"></script>
    <script src="/frameworks/semantic.min.js"></script>
    <title>Панель управления</title>
</head>
<body style="background-image: url(/images/bg.jpg)">
<div class="ui container">
    <div class="field">
        <a href="/student/lk.php" class="ui floated small blue labeled icon button">
            <i class="arrow left icon"></i>Назад
        </a>
        <button onclick="openModalWindowForAddGroup()" class="ui floated small green labeled icon button">
            <i class="plus circle icon"></i>Добавить группу
        </button>
    </div>
    <div class="ui segment">
        <h3 class="ui horizontal divider header"><i class="info red icon"></i>Информация о группе</h3>
        <div class="ui comments">
            <label for=""></label>
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
                        <a onclick="openModalWindowStudentCard()"><i class="id card orange icon"></i> Показать физические параметры </a>
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
        <div class="ui progress indicating" data-value="10">
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


    <h3 class="ui top attached header center aligned red" style="margin-top: 20px">
        Таблица занятий
    </h3>
    <table class="ui celled attached table">
        <thead class="center aligned">
        <tr>
            <th>Дата</th>
            <th>Группа</th>
            <th>Количество студентов</th>
            <th>Ключевое слово</th>
            <th>Удаление</th>
        </tr>
        </thead>
        <tbody class="center aligned">
        <tr>
            <td>"Дата"</td>
            <td><a href="">"СМГ"</a></td>
            <td>"10"</td>
            <td>
                <button class="ui brown icon button"><i class="icon clone outline" style="color: white"></i></button>
            </td>
            <td>
                <button class="ui red icon button" onclick="openModalWindowForGroupRemove()">
                    <i class="icon trash" style="color: white"></i>
                </button>
            </td>
        </tr>
        </tbody>
        <tfoot class="full-width">
        <tr>
            <th colspan="5">
                <div class="ui orange label"><i class="users icon"></i> 1 </div>
                <div class="ui orange label"><i class="id badge icon"></i> "10" </div>
            </th>
        </tr>
        </tfoot>
    </table>
</div>
</body>
<script>
    $('.ui.progress').progress();
</script>
</html>