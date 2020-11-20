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
        <a href="/professor/lk.php" class="ui floated small blue labeled icon button" style="margin-bottom: 10px">
            <i class="arrow left icon"></i>Назад
        </a>
        <button onclick="openModalWindowForAddGroup()" class="ui floated small green labeled icon button"
                style="margin-bottom: 10px">
            <i class="plus circle icon"></i>Добавить группу
        </button>
        <button onclick="openModalWindowGuide()" class="ui floated small black labeled icon button">
            <i class="info circle icon"></i>Руководство
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
        <tr id = "<? echo 'gr_row_id-' . $group->id;?>">
            <td><? echo $specializations[$group->id_specialization]->name; ?></td>
            <td><a href="<? echo '/professor/group.php?id=' . $group->id;?>"><? echo $group->name; ?></a></td>
            <td><? echo $countStudentsOfGroup; ?></td>
            <td>
                <div id="<? echo $group->name;?>" hidden><?echo $group->code_word; ?></div>
                <button class="ui brown icon button" onclick="copyKeyWord('#<? echo $group->name;?>')" data-content="Скопировано">
                    <i class="icon clone outline" style="color: white"></i>
                </button>
            </td>
            <td>
                <button id = "<? echo 'gr_btn_id-' . $group->id;?>" class="ui red icon button" onclick="openModalWindowForGroupRemove(this)">
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
                    <input type="text" name="name_group" placeholder="На кириллице с цифрами" minlength="3" maxlength="30" onkeyup="Cyrillic(this)" required>
                    <i class="font icon red"></i>
                </div>
            </div>
            <input type="hidden" value=" <? echo $professor->id; ?>" name="id_professor">
        </form>
        <? if(count($specializations) == null) { ?>
        <div class="ui warning message">
            <div class="header">Специализации отсутствуют:</div>
            <ul>
                <li>Вы не можете добавить группу, пока нет специализаций</li>
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
    <div class="actions" <? if(count($specializations) == null) echo "hidden"; ?>>
        <button class="ui right labeled icon green button"
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
        <button class="ui right labeled icon green button" onclick="removeAndHideModalFormFormGroup()">
            Подтвердить
            <i class="check icon"></i>
        </button>
    </div>
</div>

<div class="ui large modal horizontal flip " id="modalGuide">
    <h1 class="ui header" style="color: #db2828">Руководство</h1>
    <div class="content">
        <h3 class="ui header center aligned">Обозначение элементов интерфейса</h3>
        <h2 class="ui header">
            <i class="icon star blue"></i>
            <div class="content">
                <div class="sub header">
                    Количество баллов студента группы, рассчитанные за выполнения нормативов из 100.
                </div>
            </div>
        </h2>
        <h2 class="ui header">
            <i class="icon calendar outline blue"></i>
            <div class="content">
                <div class="sub header">
                    Число посещений занятий студентом группы из общего числа занятий.
                </div>
            </div>
        </h2>
        <h2 class="ui header">
            <i class="icon clone outline inverted" style="background: #a5673f; border-radius: 5px"></i>
            <div class="content">
                <div class="sub header">
                    Кнопка редактирования/отправки данных на проверку преподавателю группы.
                </div>
            </div>
        </h2>
        <h2 class="ui header">
            <div class="ui orange label" style="margin-left:0"><i class="users icon"></i> 3 </div>
            <div class="ui orange label" style="margin-left:0"><i class="user icon"></i> 3 </div>
            <div class="ui orange label" style="margin-left:0"><i class="calendar icon"></i> 3 </div>
            <div class="ui orange label" style="margin-left:0"><i class="calendar check icon"></i> 3 </div>
            <div class="content">
                <div class="sub header" style="margin-top: 5px">
                    Количество элементов в таблице/списке или общее количество.
                </div>
            </div>
        </h2>

        <h3 class="ui header center aligned">Указания</h3>
        <div class="ui message">
            <ul>
                <li>Для перехода к созданной вами группе нажмите на ее название в таблице групп.</li>
                <li>Если нужная для вас специализация отсутствует, то обратитесь
                    к администратору (заведующему учебной частью), чтобы он добавил её.</li>
                <li>Старайтесь не создавать занятия наперед, иначе студенты начнут отправлять занятия
                    на последующие дни и так будет неудобно фиксировать посещения и проверять все данные.</li>
                <li>Создавайте занятия строго в возрастающем порядке дат.</li>
            </ul>
        </div>
    </div>
</div>

</body>
<script>
    function Cyrillic(obj) {
        if (/^[а-яА-Я0-9_]*?$/.test(obj.value))
            obj.defaultValue = obj.value;
        else
            obj.value = obj.defaultValue;
    }


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

    function openModalWindowForGroupRemove(btn) {
        $('#modalGroupRemove')
            .data('groupId', btn.id)
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

    function openModalWindowGuide() {
        $('#modalGuide')
            .modal({
                inverted: true
            })
            .modal('show')
        ;
    }

    function removeAndHideModalFormFormGroup() {
        var groupId = $('#modalGroupRemove').data('groupId').split('-')[1];
        $.ajax({
            url: "/queries/professor/removeGroup.php",
            method: "POST",
            data: {'id': groupId},
            success: function () {
                hideModalWindowForGroupRemove();
                var rowId = 'gr_row_id-' + groupId;
                $('#' + rowId).remove();
            },
            error: function () {
                console.log('ERROR');
            }
        });

    }

</script>
</html>