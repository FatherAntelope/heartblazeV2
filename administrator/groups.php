<?php
require $_SERVER['DOCUMENT_ROOT']."/queries/functions.php";
$person = getDataIsAuthAndEmptyPerson('2');
$groups = R::findAll('group', 'ORDER BY name ASC');
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
    <title>Группы</title>
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
            <input class="prompt" type="text" placeholder="Введите название группы">
            <i class="search icon"></i>
        </div>
        <div class="results"></div>
    </div>


    <h2 class="ui header attached top red center aligned">Группы</h2>
    <table class="ui attached top sortable celled table scrolling center aligned">
        <thead>
        <tr>
            <th>Название</th>
            <th>Специализация</th>
            <th>Преподаватель</th>
            <th>Количество студентов</th>
            <th>Удаление</th>
        </tr>
        </thead>
        <tbody>
        <? foreach ($groups as $group) {
            $professor = R::load('person',
                R::load('professor', $group->id_professor)->id_person
            );
            ?>
        <tr id="<? echo  'gr_row_id-' . $group->id ;?>">
            <td><? echo $group->name; ?></td>
            <td><? echo R::findOne('specialization', 'id = ?', [$group->id_specialization])->name; ?></td>
            <td><? echo $professor->surname." ".$professor->name." ".$professor->patronymic; ?></td>
            <td><? echo R::count('student', 'id_group = ?', [$group->id]); ?></td>
            <td>
                <button id="<? echo  'btn_gr_id-' . $group->id ;?>" class="ui red icon button" onclick="openModalWindowForRemoveGroup(this)">
                    <i class="icon trash" style="color: white"></i>
                </button>
            </td>
        </tr>
        <? } ?>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="5">
                <div class="ui teal label">
                    <i class="list icon"></i><? echo count($groups); ?>
                </div>
            </th>
        </tr>
        </tfoot>
    </table>
</div>

<div class="ui modal horizontal flip tiny" id="modalRemoveGroup">
    <h2 class="ui header center aligned">
        Вы уверены, что хотите удалить данную группу? Все данные студентов и преподавателей, привязанные
        к этой группе будут очищены!
    </h2>
    <div class="actions">
        <button class="ui right labeled icon red button" onclick="hideModalWindowForRemoveGroup()">
            Отклонить
            <i class="close icon"></i>
        </button>
        <button class="ui right labeled icon green button" onclick="removeGroupAndHide()">
            Подтвердить
            <i class="check icon"></i>
        </button>
    </div>
</div>

<script>
    function openModalWindowForRemoveGroup(btn) {
        var id = btn.id;
        $('#modalRemoveGroup')
            .data('id', id)
            .modal({
                inverted: true
            })
            .modal('setting', 'closable', false)
            .modal('show')
        ;
    }

    function hideModalWindowForRemoveGroup() {
        $('#modalRemoveGroup')
            .modal('hide')
        ;
    }

    function removeGroupAndHide() {
        var id = $('#modalRemoveGroup').data('id').split('-')[1];
        $.ajax({
            url: "/queries/administrator/removeGroup.php",
            method: "POST",
            data: {'id': id},
            success: function () {
                hideModalWindowForRemoveGroup();
                var rowId = 'gr_row_id-' + id;
                $('#' + rowId).remove();
            },
            error: function () {
                console.log('ERROR');
            }
        });
    }


</script>
</body>
</html>
