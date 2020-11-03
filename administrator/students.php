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
    <title>Студенты</title>
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
            <input class="prompt" type="text" placeholder="Введите ФИО студента">
            <i class="search icon"></i>
        </div>
        <div class="results"></div>
    </div>


    <h2 class="ui header attached top red center aligned">Студенты</h2>
    <table class="ui attached top sortable celled table scrolling center aligned">
        <thead>
        <tr>
            <th>Студент</th>
            <th>Учебная группа</th>
            <th>Группа</th>
            <th>Преподаватель</th>
            <th>Удаление</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>"Фамилия Имя Отчество"</td>
            <td>"Группа"</td>
            <td>"Группа"/Не привязан</td>
            <td>"Фамилия Имя Отчество"/Не привязан</td>
            <td>
                <button class="ui red icon button" onclick="openModalWindowForRemoveStudent()">
                    <i class="icon trash" style="color: white"></i>
                </button>
            </td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="5">
                <div class="ui teal label">
                    <i class="list icon"></i>"22"
                </div>
            </th>
        </tr>
        </tfoot>
    </table>
</div>

<div class="ui modal horizontal flip tiny" id="modalRemoveStudent">
    <h2 class="ui header center aligned">
        Вы уверены, что хотите удалить учетную запись данного студента? Все его данные будут безвозвратно удалены!
    </h2>
    <div class="actions">
        <button class="ui right labeled icon red button" onclick="hideModalWindowForRemoveStudent()">
            Отклонить
            <i class="close icon"></i>
        </button>
        <button class="ui right labeled icon green button">
            Подтвердить
            <i class="check icon"></i>
        </button>
    </div>
</div>

<script>
    function openModalWindowForRemoveStudent() {
        $('#modalRemoveStudent')
            .modal({
                inverted: true
            })
            .modal('setting', 'closable', false)
            .modal('show')
        ;
    }

    function hideModalWindowForRemoveStudent() {
        $('#modalRemoveStudent')
            .modal('hide')
        ;
    }
</script>
</body>
</html>
