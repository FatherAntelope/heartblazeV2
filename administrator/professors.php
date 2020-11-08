<?php
require $_SERVER['DOCUMENT_ROOT']."/queries/functions.php";
$person = getDataIsAuthAndEmptyPerson('2');

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
    <link rel="shortcut icon" href="/images/ugatu_logo.png" type="image/x-icon">
    <script src="/frameworks/jquery.min.js"></script>
    <script src="/frameworks/semantic.min.js"></script>
    <title>Преподаватели</title>
</head>
<body style="background-image: url(/images/bg.jpg)">
<div class="ui container">
    <div class="field">
        <a href="/administrator/lk.php" class="ui floated small blue labeled icon button">
            <i class="arrow left icon"></i>Назад
        </a>
    </div>


    <div class="ui search fluid" style="margin-top: 20px">
        <div class="ui icon input fluid">
            <input class="prompt" type="text" placeholder="Введите ФИО преподавателя">
            <i class="search icon"></i>
        </div>
        <div class="results"></div>
    </div>


    <h2 class="ui header attached top red center aligned">Преподаватели</h2>
    <table class="ui attached top sortable celled table scrolling center aligned">
        <thead>
        <tr>
            <th>Аватар</th>
            <th>Преподаватель</th>
            <th>Почта</th>
            <th>Количество групп</th>
            <th>Количество студентов</th>
            <th>Статус</th>
            <th>Удаление</th>
        </tr>
        </thead>
        <tbody>
        <tr class="positive">
            <td>
                <div class="avatar circle">
                    <img src="/images/user2.jpg" style="object-fit: cover; height: 35px; width: 35px;">
                </div>
            </td>
            <td>"Фамилия Имя Отчество"</td>
            <td>"mail@mail.ru"</td>
            <td>"1"</td>
            <td>"2"</td>
            <td>
                Подтвержден
            </td>
            <td>
                <button class="ui red icon button" onclick="openModalWindowForRemoveProfessor()">
                    <i class="icon user close" style="color: white"></i>
                </button>
            </td>
        </tr>
        <tr class="negative">
            <td>
                <div class="avatar circle">
                    <img src="/images/user2.jpg" style="object-fit: cover; height: 35px; width: 35px;">
                </div>
            </td>
            <td>"Фамилия Имя Отчество"</td>
            <td>"mail@mail.ru"</td>
            <td>-</td>
            <td>-</td>
            <td>
                <a href="#" onclick="openModalWindowForCheckProfessor()">Ожидает</a>

            </td>
            <td>
                <button class="ui red icon button" onclick="openModalWindowForRemoveProfessor()">
                    <i class="icon user close" style="color: white"></i>
                </button>
            </td>
        </tr>
        <tr class="warning">
            <td>
                <div class="avatar circle">
                    <img src="/images/user2.jpg" style="object-fit: cover; height: 35px; width: 35px;">
                </div>
            </td>
            <td>"Фамилия Имя Отчество"</td>
            <td>"mail@mail.ru"</td>
            <td>-</td>
            <td>-</td>
            <td>
                Не подтвержден
            </td>
            <td>
                <button class="ui red icon button" onclick="openModalWindowForRemoveProfessor()">
                    <i class="icon user close" style="color: white"></i>
                </button>
            </td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="7">
                <div class="ui teal label">
                    <i class="list icon"></i>"22"
                </div>
            </th>
        </tr>
        </tfoot>
    </table>
</div>

<div class="ui modal horizontal flip tiny" id="modalRemoveProfessor">
    <h2 class="ui header center aligned">
        Вы уверены, что хотите удалить учетную запись данного преаодавателя? Все его данные будут безвозвратно удалены!
    </h2>
    <div class="actions">
        <button class="ui right labeled icon red button" onclick="hideModalWindowForRemoveProfessor()">
            Отклонить
            <i class="close icon"></i>
        </button>
        <button class="ui right labeled icon green button">
            Подтвердить
            <i class="check icon"></i>
        </button>
    </div>
</div>

<div class="ui modal horizontal flip" id="modalCheckProfessor">
    <h1 class="ui header" style="color: #db2828">
        Подтверждение личности преподавателя
    </h1>
    <div class="content">
        <div class="ui info message">
            <div class="header">Примечание:</div>
            <ul>
                <li>Внимательно проверяйте данные удостоверения</li>
                <li>Убедитесь, что удостоверение не было загружено с интернета</li>
            </ul>
        </div>
        <img class="ui fluid image" src="/administrator/professors_id/example1.jpg">
    </div>
    <div class="actions">
        <button class="ui right labeled icon red button">
            Отклонить
            <i class="close circle icon"></i>
        </button>
        <button class="ui right labeled icon green button">
            Подтвердить
            <i class="check circle icon"></i>
        </button>
    </div>
</div>

<script>
    function openModalWindowForRemoveProfessor() {
        $('#modalRemoveProfessor')
            .modal({
                inverted: true
            })
            .modal('setting', 'closable', false)
            .modal('show')
        ;
    }

    function hideModalWindowForRemoveProfessor() {
        $('#modalRemoveProfessor')
            .modal('hide')
        ;
    }

    function openModalWindowForCheckProfessor() {
        $('#modalCheckProfessor')
            .modal({
                inverted: true
            })
            .modal('show')
        ;
    }
</script>
</body>
</html>
