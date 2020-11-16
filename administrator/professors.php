<?php
require $_SERVER['DOCUMENT_ROOT']."/queries/functions.php";
require $_SERVER['DOCUMENT_ROOT']."/db/db.php";

$professors = R::findAll('professor', 'ORDER BY id ASC');

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

        <? foreach ($professors as $professor) {?>
            <? 
                $person = R::load('person', $professor->idPerson);
                $groups = R::find('group', 'id_professor = ?', [$professor->id]);
                
                $studentsCount = 0;
                foreach ($groups as $group) {
                    $studentsCount += R::count('student', 'id_group = ?', [$group->id]);
                }

                $status = $professor->status;
                // 2 - negative => ожидает
                // 0 - warning => не под
                // 1 - positive => под
                $cssClass = "negative";
                if ($status == 1) {
                    $cssClass = "positive";
                } 
                if ($status == 0) {
                    $cssClass = "warning";
                }
            ?>
            <tr class="<? echo $cssClass; ?>" id="<? echo 'tr_pr_id-' . $professor->id; ?>">
                <td>
                    <div class="avatar circle">
                        <img src="/images/user2.jpg" style="object-fit: cover; height: 35px; width: 35px;">
                    </div>
                </td>
                <td><? echo $person->surname . ' ' . $person->name . ' ' . $person->patronymic; ?></td>
                <td><? echo $person->email; ?></td>
                <td><? echo count($groups); ?></td>
                <td><? echo $studentsCount; ?></td>
                <td id="<? echo 'td_pr_id-' . $professor->id; ?>">
                    <?if ($cssClass == "positive") {?>
                        Подтвержден
                    <?} elseif ($cssClass == "warning") {?>
                        Не подтвержден
                    <?} else {?>
                        <a href="#" id="<? echo 'link_pr_id-' . $professor->id; ?>" onclick="openModalWindowForCheckProfessor(this)">Ожидает</a>
                    <?}?>
                </td>
                <td>
                    <button id="<? echo 'btn_pr_id-' . $professor->id; ?>" class="ui red icon button" onclick="openModalWindowForRemoveProfessor(this)">
                        <i class="icon user close" style="color: white"></i>
                    </button>
                </td>
            </tr>
        <?}?>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="7">
                <div class="ui teal label">
                    <i class="list icon"></i><? echo count($professors); ?>
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
        <button class="ui right labeled icon green button" onclick="removeProfessor()">
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
        <!-- ./queries/administator/uploadCertificate.php -->
        <img id="certificate-img" class="ui fluid image" src="">
    </div>
    <div class="actions">
        <button class="ui right labeled icon red button" onclick="hideModalWindowForCheckProfessor()">
            Отклонить
            <i class="close circle icon"></i>
        </button>
        <button class="ui right labeled icon green button" onclick="confirm()">
            Подтвердить
            <i class="check circle icon"></i>
        </button>
    </div>
</div>

<script>
    function openModalWindowForRemoveProfessor(btn) {
        var id = btn.id.split('-')[1];
        $('#modalRemoveProfessor')
            .data('id', id)
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

    function removeProfessor() {
        var id = $('#modalRemoveProfessor').data('id');
        $.ajax({
            url: "/queries/administrator/removeProfessor.php",
            method: "POST",
            data: {'id': id},
            success: function (data) {
                $("#tr_pr_id-" + id).remove();                
                hideModalWindowForRemoveProfessor();
            },
            error: function () {
                console.log('ERROR');
            }
        });
    }

    function openModalWindowForCheckProfessor(a) {
        var id = a.id.split("-")[1];
        $.ajax({
            url: "/queries/administrator/uploadCertificate.php",
            method: "POST",
            data: {'id': id},
            success: function (data) {
                $('#certificate-img').attr('src', 'data:image/jpeg;charset=utf-8;base64,' + data);
            },
            error: function () {
                console.log('ERROR');
            }
        });
        $('#modalCheckProfessor')
            .modal({
                inverted: true
            })
            .data('id', id)
            .modal('show')
        ;
    }

    function hideModalWindowForCheckProfessor() {
        $('#modalCheckProfessor')
            .modal('hide')
        ;
    }

    function confirm() {
        var id = $('#modalCheckProfessor').data('id');
        $.ajax({
            url: "/queries/administrator/confirmCertificate.php",
            method: "POST",
            data: {'id': id},
            success: function (data) {
                $("#tr_pr_id-" + id).attr('class', 'positive');
                $("#td_pr_id-" + id).text('Подтвержден');
                hideModalWindowForCheckProfessor();
            },
            error: function () {
                console.log('ERROR');
            }
        });
    }

</script>
</body>
</html>
