<?php
require $_SERVER['DOCUMENT_ROOT']."/queries/functions.php";
$person = getDataIsAuthAndEmptyPerson('1');
$professor = R::findOne('professor', 'id_person = ?', [$person->id]);
$groups = R::find('group', "id_professor = ?", [$professor->id]);
$specializations = R::findAll('specialization', 'ORDER BY name ASC');
$countStudentsOfAllGroups = 0;
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
    <div class="ui info message">
        <div class="header">Примечание:</div>
        <ul>
            <li>Создавайте группы только с уникальными именами</li>
            <li>Называйте группы так: <b>Аббревиатура_Курс_Пол (если нужен)</b></li>
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
        <? foreach ($groups as $group) {
            $countStudentsOfAllGroups += $countStudentsOfGroup = R::count('student', 'id_group = ?', [$group->id]);
            ?>
        <tr>
            <td><? echo $specializations[$group->id_specialization]->name; ?></td>
            <td><a href=""><? echo $group->name; ?></a></td>
            <td><? echo $countStudentsOfGroup; ?></td>
            <td>
                <div id="<? echo $group->name;?>" hidden><?echo $group->code_word; ?></div>
                <button class="ui brown icon button" onclick="copyKeyWord('#<? echo $group->name;?>')" data-content="Скопировано">
                    <i class="icon clone outline" style="color: white"></i>
                </button>
            </td>
            <td>
                <button class="ui red icon button" onclick="openModalWindowForGroupRemove()">
                    <i class="icon trash" style="color: white"></i>
                </button>
            </td>
        </tr>
        <? } ?>
        </tbody>
        <tfoot class="full-width">
        <tr>
            <th colspan="5">
                <div class="ui orange label"><i class="users icon"></i> <? echo count($groups); ?> </div>
                <div class="ui orange label"><i class="id badge icon"></i> <? echo $countStudentsOfAllGroups; ?> </div>
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
        <form class="ui form" id="formAddGroup" <? if(count($specializations) == null) echo "hidden"; ?>>
            <div class="required field">
                <label>Специализация</label>
                <div class="ui input">
                    <select class="ui fluid dropdown" name="id_specialization" required>
                        <option value="">Выберите</option>
                        <? foreach ($specializations as $specialization) { ?>
                            <option value="<? echo $specialization->id; ?>">
                                <? echo $specialization->name; ?>
                            </option>
                        <? } ?>
                    </select>
                </div>
            </div>
            <div class="required field">
                <label>Название группы</label>
                <div class="ui left icon input">
                    <input type="text" name="name_group" required>
                    <i class="font icon red"></i>
                </div>
            </div>
            <input type="hidden" value=" <? echo $professor->id; ?>" name="id_professor">
        </form>
        <? if(count($specializations) == null) { ?>
        <div class="ui warning message">
            <div class="header">Специализации отсутствуют:</div>
            <ul>
                <li>Вы не можете создать группу, пока нет специализаций</li>
            </ul>
        </div>
        <? } ?>
        <div class="ui success message" id="msgSuccessAddGroup" style="display: none;">
            <div class="header">Группа успешно создана! Добавьте еще или перезагрузите страницу</div>
        </div>
        <div class="ui error message" id="msgErrorAddGroup" style="display: none;">
            <div class="header">Ошибка создания группы:</div>
            <ul>
                <li>Группа с данным названием существует</li>
                <li>Создавайте группы только с уникальными названиями!</li>
            </ul>
        </div>

    </div>
    <div class="actions">
        <button class="ui right labeled icon green button <? if(count($specializations) == null) echo "disabled"; ?>"
        form="formAddGroup">
            Добавить
            <i class="plus circle icon"></i>
        </button>
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
    $("#formAddGroup").submit(function () {
        $.ajax({
            url: "/queries/professor/addGroup.php",
            method: "POST",
            data: $(this).serialize(),
            success: function () {
                document.getElementById("msgErrorAddGroup").style.display = "none";
                document.getElementById("msgSuccessAddGroup").style.display = "block";
                document.getElementsByName("id_specialization")[0].selectedIndex = -1;
                document.getElementsByName("name_group")[0].value = "";
            },
            error: function () {
                document.getElementById("msgErrorAddGroup").style.display = "block";
                document.getElementById("msgSuccessAddGroup").style.display = "none";
                document.getElementsByName("name_group")[0].value = "";
            }
        });
        return false;
    });
</script>

<script>

    $('.ui.brown.icon.button').popup();

    function copyKeyWord(keyWord) {
        var $tmp = $("<input>");
        $("body").append($tmp);
        $tmp.val($(keyWord).text()).select();
        document.execCommand("copy");
        $tmp.remove();


    }

    $('.ui.dropdown').dropdown();

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