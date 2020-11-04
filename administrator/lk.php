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
    <link rel="shortcut icon" href="/images/ugatu_logo.png" type="image/x-icon">
    <script src="/frameworks/jquery.min.js"></script>
    <script src="/frameworks/semantic.min.js"></script>
    <title>Личный кабинет</title>
</head>
<body style="background-image: url(/images/bg.jpg)">
<!--
* Контейнер - блок с содержимым, имеющий отступы по краям (слева и справа)
-->
<div class="ui container">
    <div class="ui labeled icon buttons">
        <a href="/queries/exit.php" class="ui button red">
            <i class="sign-out icon"></i>
            Выйти
        </a>
        <a href="/administrator/professors.php" class="ui button green">
            <i class="user icon"></i>
            Преподаватели
        </a>
        <a href="/administrator/students.php" class="ui button orange">
            <i class="user icon"></i>
            Студенты
        </a>
        <a href="/administrator/groups.php" class="ui button teal">
            <i class="users icon"></i>
            Группы
        </a>
    </div>

    <div class="ui segment">
        <h2 class="ui center aligned header" style="color: #db2828">Портфолио</h2>
        <h4 class="ui horizontal divider header"><i class="address book red icon"></i> Учетные данные </h4>
        <table class="ui very basic table">
            <tbody class="center aligned">
            <tr>
                <td><b>Логин:</b></td>
                <td><?php echo $person->login; ?></td>
            </tr>
            <tr>
                <td><b>Роль:</b></td>
                <td>Администратор</td>
            </tr>
            <tr>
                <td><b>Почта:</b></td>
                <td><?php echo $person->email; ?></td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="ui info message">
        <div class="header">Специализации отсутствуют:</div>
        <ul>
            <li>Добавьте специализации, чтобы преподаватели могли создавать группы</li>
        </ul>
    </div>

    <h2 class="ui header attached top red center aligned">Специализации</h2>
    <table class="ui attached top sortable celled table scrolling center aligned">
            <thead>
            <tr>
                <th>Название</th>
                <th>Количество групп</th>
                <th>Количество преподавателей</th>
                <th>Количество студентов</th>
                <th>Удаление</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                <!-- <?php $specialization = R::dispense('specialization'); echo $specialization->name;?> -->
                "Cпециализация"
                </td>
                <td><?php echo R::count("group");?></td>
                <td><?php echo R::count("professor");?></td>
                <td><?php echo R::count("student");?></td>
                <td>
                    <button class="ui red icon button" onclick="openModalWindowForRemoveSpecialization()">
                        <i class="icon trash" style="color: white"></i>
                    </button>
                </td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <th>
                    <div class="ui teal label">
                        <i class="list icon"></i><?php echo R::count("specialization");?>
                    </div>
                </th>
                <th>
                    <div class="ui brown label">
                        <i class="users icon"></i>"15"
                    </div>
                </th>
                <th>
                    <div class="ui blue label">
                        <i class="user icon"></i>"15"
                    </div>
                </th>
                <th>
                    <div class="ui blue label">
                        <i class="user icon"></i>"15"
                    </div>
                </th>
                <th></th>
            </tr>
            <tr>
                <th colspan="5">
                    <button onclick="openModalWindowForAddSpecialization()" class="ui floated small green labeled icon button">
                        <i class="plus circle icon"></i>Добавить
                    </button>
                </th>
            </tr>
            </tfoot>
        </table>
</div>

<div class="ui modal horizontal flip tiny" id="modalRemoveSpecialization">
    <h2 class="ui header center aligned">
        Вы уверены, что хотите удалить данную специализацию? Все данные студентов и преподавателей, привязанные
        к этой специализации будут очищены!
    </h2>
    <div class="actions">
        <button class="ui right labeled icon red button" onclick="hideModalWindowForRemoveSpecialization()">
            Отклонить
            <i class="close icon"></i>
        </button>
        <button class="ui right labeled icon green button">
            Подтвердить
            <i class="check icon"></i>
        </button>
    </div>
</div>

<div class="ui modal horizontal flip tiny" id="modalAddSpecialization">
    <h1 class="ui header" style="color: #db2828">
        Добавить специализацию
    </h1>
    <div class="content">
        <div class="ui info message">
            <div class="header">Примечание:</div>
            <ul>
                <li>Создавайте специализации только с уникальными названиями</li>
                <li>Например: аэробика, бег, плавание, футбол и т.д.</li>
            </ul>
        </div>
        <form class="ui form" id="formAddSpecialization">
            <div class="field required">
                <label>Название специализации</label>
                <div class="ui left icon input">
                    <input type="text" name="nameSpecialization" placeholder="С заглавной буквы" required>
                    <i class="font alternate red icon"></i>
                </div>
            </div>
        </form>
        <div class="ui success message" style="display: none" id="msgSuccessAddSpecialization">
            <div class="header">Специализация успешно добавлена!</div>
        </div>
    </div>
    <div class="actions">
        <button type="submit" class="ui right labeled icon green button" id="btnAddSpecialization">
            Добавить
            <i class="plus circle icon"></i>
        </button>
    </div>
</div>

</body>
<script>
    $('#btnAddSpecialization').on('click', function() {
        $.ajax({
            url: "/queries/addSpecialization.php",
            method: "POST",
            data: $('#formAddSpecialization').serialize(),
            success: function () {
                document.getElementById("msgSuccessAddSpecialization").style.display = "block";
                document.getElementsByName("nameSpecialization")[0].value = "";
            },
            error: function () {

            }
        });
        return false;
    });

    $('#btnRemoveSpecialization').on('click', function() {
        $.ajax({
            url: "/queries/addRemoveialization.php",
            method: "POST",
            data: $('#formAddRemoveialization').serialize(),
            success: function () {
                document.getElementById("msgSuccessAddSpecialization").style.display = "block";
            },
            error: function () {

            }
        });
        return false;
    });

    function openModalWindowForRemoveSpecialization() {
        $('#modalRemoveSpecialization')
            .modal({
                inverted: true
            })
            .modal('setting', 'closable', false)
            .modal('show')
        ;
    }

    function hideModalWindowForRemoveSpecialization() {
        $('#modalRemoveSpecialization')
            .modal('hide')
        ;
    }
    function openModalWindowForAddSpecialization() {
        $('#modalAddSpecialization')
            .modal({
                inverted: true
            })
            .modal('show')
        ;
    }
</script>
</html>