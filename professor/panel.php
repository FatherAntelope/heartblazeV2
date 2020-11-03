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
    <title>Панель управления</title>
</head>
<body style="background-image: url(/images/bg.jpg)">
<div class="ui container">
    <div class="field">
        <a href="/professor/lk.php" class="ui floated small blue labeled icon button">
            <i class="arrow left icon"></i>Назад
        </a>
        <button onclick="openModalWindowForAddGroup()" class="ui floated small green labeled icon button">
            <i class="plus circle icon"></i>Добавить группу
        </button>
    </div>
    <div class="ui warning message">
        <div class="header">Группы отсутствуют:</div>
        <ul>
            <li>Создавайте группы только с уникальными именами</li>
            <li>Называйте группы так: <b>Аббревиатура_Курс_Пол(если нужен)</b></li>
            <li>Пример: <b>СМГ_3_М</b></li>
            <li>После создания группы вы получите ключевое слово привязки, которое необходимо передать студентам</li>
        </ul>
    </div>
    <h3 class="ui top attached header center aligned red" style="margin-top: 20px">
        Таблица групп
    </h3>
    <table class="ui celled attached table">
        <thead class="center aligned">
        <tr>
            <th>Специализация</th>
            <th>Группа</th>
            <th>Количество студентов</th>
            <th>Ключевое слово</th>
            <th>Удаление</th>
        </tr>
        </thead>
        <tbody class="center aligned">
        <tr>
            <td>"Специализация"</td>
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


<div class="ui modal horizontal flip tiny" id="modalAddGroup">
    <div class="header" style="color: #db2828">
        Добавить группу
    </div>
    <div class="content">
        <form class="ui form">
            <div class="required field">
                <label>Специализация</label>
                <div class="ui left icon input">
                    <div class="ui fluid selection dropdown">
                        <input type="hidden" name="specialization">
                        <i class="dropdown icon"></i>
                        <div class="default text">Выберите</div>
                        <div class="menu">
                            <div class="item" data-value="Spec1">Специализация1</div>
                            <div class="item" data-value="Spec2">Специализация2</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="required field">
                <label>Название группы</label>
                <div class="ui left icon input">
                    <input type="text">
                    <i class="font icon red"></i>
                </div>
            </div>
        </form>
        <div class="ui warning message">
            <div class="header">Специализации отсутствуют:</div>
            <ul>
                <li>Вы не можете создать группу, пока нет специализаций</li>
            </ul>
        </div>
        <div class="ui success message">
            <div class="header">Группа успешно создана!</div>
        </div>
    </div>
    <div class="actions">
        <button class="ui right labeled icon green button">
            Добавить
            <i class="plus circle icon"></i>
    </div>
</div>

<div class="ui modal horizontal flip tiny" id="modalGroupRemove">
    <h1 class="ui header center aligned">
        Вы уверены, что хотите удалить группу?
    </h1>
    <div class="actions">
        <button class="ui right labeled icon red button" onclick="hideModalWindowForGroupRemove()">
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

    function openModalWindowForAddGroup() {
        $('#modalAddGroup')
            .modal({
                inverted: true
            })
            .modal('show')
        ;
    }

    function openModalWindowForGroupRemove() {
        $('#modalGroupRemove')
            .modal({
                inverted: true
            })
            .modal('setting', 'closable', false)
            .modal('show')
        ;
    }

    function hideModalWindowForGroupRemove() {
        $('#modalGroupRemove')
            .modal('hide')
        ;
    }
</script>
</html>