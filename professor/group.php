<?
require $_SERVER['DOCUMENT_ROOT'] . "/queries/functions.php";
$person = getDataIsAuthAndEmptyPerson('1');
$group_id = $_GET['id'];
$group = R::load('group', $group_id);
if($group->id_professor != (R::findOne('professor', 'id_person = ?', [$person->id])->id)) {
    die(header("HTTP/1.0 403 Forbidden "));
}

$students = R::findAll('student', ' id_group = ? ', [$group_id]);
$students_id = array();
foreach ($students as $student) {
    $students_id[] = $student->id;
}

$lessons = R::findAll('lesson', ' id_group = ?', [$group_id]);

$lessonsParticipation = R::findLike('lesson_participation', ['id_student' => $students_id]);
$normativesTest = R::findLike('normative_test', ['id_student' => $students_id]);

$arrSumStudentsVisits = array();

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
    <title>Группа - <? echo $group->name; ?></title>
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

    <? if (count($students) == 0) { ?>
        <div class="ui info message">
        <div class="header">Студенты отсутствуют:</div>
        <ul>
            <li>Отправьте ключевое слово студентам, чтобы они могли привязаться к вашей группе</li>
            <li>Ключевые слова для каждых ваших групп находятся в панели управления в таблице групп</li>
        </ul>
        </div>
    <?} else {?>
        <h3 class="ui top attached header center aligned red" style="margin-top: 20px">
        Список студентов
        </h3>
        <div class="ui segment attached top">
            <div class="ui comments">
                <? foreach ($students as $student) {?>
                    <? $personStudent = R::load('person', $student->id_person);
                        $studentLessonParticipation = R::findLike('lesson_participation', ['id_student' => $student->id]);
                        $studentNormativeTest = R::findLike('normative_test', ['id_student' => $student->id]);
                        $countStudentVisits = 0;
                        foreach ($studentLessonParticipation as $item) {
                            if($item->status == 1) {
                                $countStudentVisits++;
                            }
                        }
                    ?>
                    <div class="comment" id="<?echo 'row_student_id-' . $student->id; ?>">
                        <a class="avatar">
                            <img src="/images/user2.jpg" style="object-fit: cover; height: 35px; width: 35px;">
                        </a>
                        <div class="content">
                            <label class="author" style="color: #db2828"><? echo $personStudent->surname . " " . $personStudent->name . " " . $personStudent->patronymic; ?></label>
                            <div class="metadata">
                                <!--Посещаемость-->
                                <div class="date"><i class="calendar outline blue icon"></i>
                                    <? echo $countStudentVisits." из ".count($lessons);?>
                                </div>
                                <!--Балл-->
                                <div class="rating"><i class="star blue icon"></i>
                                    <? if ($studentNormativeTest != null) echo getStudentScore($studentNormativeTest); else echo "0"; ?>
                                </div>
                            </div>
                            <div class="text">Учится в <? echo $student->group_study; ?></div>
                            <div class="actions">
                                <a class="hide" id="<?echo 'link_student_id-' . $student->id; ?>" onclick="openModalWindowForStudentOfGroupRemove(this)"><i class="user close red icon"></i>Удалить студента</a>
                                <a onclick="openModalWindowStudentCard()"><i class="id card orange icon"></i> Показать физические параметры </a>
                            </div>
                        </div>
                    </div>
                <?}?>
            </div>
        </div>
    <?}?>

    <? if (count($lessons) == 0) { ?>
    <div class="ui info message">
        <div class="header">Занятия отсутствуют:</div>
        <ul>
            <li>Добавьте занятие, чтобы начать получать данные от студентов</li>
        </ul>
    </div>
    <? } ?>

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
        <? foreach ($lessons as $lesson) { ?>
        <tr id="<? echo 'tr_lesson_id-' . $lesson->id; ?>" class="<? if($lesson->checked == false) echo "warning"; else echo "success";?>">
            <td><? echo date("d.m.Y", strtotime($lesson->date)); ?></td>
            <td>
                <? if($lesson->checked == false) {?>
                <button class="ui orange icon button" onclick="openModalWindowForCheckDataStudents()">
                    <i class="icon checked calendar" style="color: white"></i>
                </button>
                <? } else { ?>
                <i class="green check circle icon"></i>
                <? } ?>
            </td>

            <td>
                <button id="<? echo 'btn_lessond_id-' . $lesson->id; ?>" class="ui red icon button" onclick="openModalWindowForRemoveLesson(this)">
                    <i class="icon trash" style="color: white"></i>
                </button>
            </td>
        </tr>
        <? } ?>
        </tbody>
        <tfoot class="full-width">
        <tr>
            <th colspan="4">
                <div class="ui orange label"><i class="calendar icon"></i> <? echo count($lessons); ?></div>
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
        <button class="ui right labeled icon green button" onclick="removeAndHideStudentFromGroup()">
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
        <button class="ui right labeled icon green button" onclick="removeLesson()">
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
        <form class="ui form" id="formAddLesson" <? if(count($students) == 0) echo "hidden"; ?> >
            <div class="field required">
                <label>Дата занятия</label>
                <div class="ui left icon input">
                    <input type="date" name="lesson_date" required>
                    <i class="calendar alternate red icon"></i>
                </div>
            </div>
            <div class="field">
                <label>Нормативы</label>
                <div class="ui left icon input">
                    <div class="ui fluid search multiple selection dropdown">
                        <input type="hidden" name="lesson_normative">
                        <i class="dropdown icon"></i>
                        <div class="default text">Отсутствуют</div>
                        <div class="menu">
                            <div class="item" data-value="Подтягивание на перекладине">Подтягивание на перекладине</div>
                            <div class="item" data-value="Прыжок в длину">Прыжок в длину</div>
                            <div class="item" data-value="Бег 3 км.">Бег 3 км.</div>
                            <div class="item" data-value="Бег 12 мин.">Бег 12 мин.</div>
                            <div class="item" data-value="Подъем туловища лежа">Подъем туловища лежа</div>
                            <div class="item" data-value="Подъем туловища и ног">Подъем туловища и ног</div>
                            <div class="item" data-value="Сгибание и разгибание рук в упоре лежа">Сгибание и разгибание рук в упоре лежа</div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="group_id" value="<? echo $group_id; ?>">
            <? foreach ($students_id as $student_id) { ?>
            <input type="hidden" name="students_id[]" value="<? echo $student_id; ?>">
            <? } ?>
        </form>
        <? if(count($students) == 0) {?>
        <div class="ui warning message">
            <div class="header">Студенты отсутствуют:</div>
            <ul>
                <li>Вы не можете создавать занятия, пока нет студентов</li>
            </ul>
        </div>
        <? } ?>
        <div class="ui success message" id="msgSuccessAddLesson" style="display: none">
            <div class="header">Занятие успешно добавлено! Обновите страницу или добавьте еще</div>
        </div>
        <div class="ui error message" id="msgErrorAddLesson" style="display: none">
            <div class="header">Ошибка создания занятия:</div>
            <ul>
                <li>Вы не можете создать несколько занятия в один день!</li>
                <li>Выберите другую дату, либо удалите старое занятие, если допустили ошибку в его создании</li>
            </ul>
        </div>
    </div>

    <div class="actions">
        <button class="ui right labeled icon green button <? if(count($students) == 0) echo "disabled"; ?>" form="formAddLesson">
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
                    <?
                    foreach ($lessons as $lesson) { ?>
                        <th> <? echo date("d.m.Y", strtotime($lesson->date)) ?></th>
                    <? } ?>
                </tr>
                </thead>
                <tbody>
                <? foreach ($students as $student) {
                    $personStudent = R::load('person', $student->id_person);
                    $stepVisits = 0;
                    ?>
                <tr>
                    <td><? echo $personStudent->surname . " " . substr($personStudent->name, 0, 2) . ". " . substr($personStudent->patronymic, 0, 2).". (".$student->group_study.")"; ?></td>
                    <?  foreach ($lessons as $lesson) {
                        $studentVisit = R::findOne('lesson_participation', 'id_lesson = ? AND id_student = ?', [$lesson->id, $student->id]);
                        ?>
                    <td>
                        <? if($studentVisit->status == 1) { $arrSumStudentsVisits[$stepVisits++]++;?>
                        <i class="green plus circle icon"></i>
                        <? } elseif ($studentVisit->status == 3) { $stepVisits++?>
                        <i class="red minus circle icon"></i>
                        <? } else { $stepVisits++?>
                        <i class="brown question circle icon"></i>
                        <? } ?>
                    </td>
                    <? } ?>
                </tr>
                <? } ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>
                        <div class="ui orange label">
                            <i class="users icon"></i> <? echo count($students); ?>
                        </div>
                    </th>
                    <? for($i = 0; $i < count($lessons); $i++) {?>
                    <th>
                        <div class="ui brown label">
                            <i class="calendar check icon"></i>
                            <? if($arrSumStudentsVisits[$i] != null) echo $arrSumStudentsVisits[$i]; else echo '0'; ?>
                        </div>
                    </th>
                    <? } ?>
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
                    <th rowspan="2">Трекер</th>
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
                <?
                foreach ($lessonsParticipation as $lessonParticipation) {
                    if ($lessonParticipation->status == 1) {
                        $personStudent = R::load('person', $students[$lessonParticipation->id_student]->id_person);?>
                <tr>
                    <td><? echo date("d.m.Y", strtotime($lessons[$lessonParticipation->id_lesson]->date)); ?></td>
                    <td><? echo $personStudent->surname . " " . substr($personStudent->name, 0, 2) . ". " . substr($personStudent->patronymic, 0, 2)."."; ?></td>
                    <td><? echo $lessonParticipation->distance; ?></td>
                    <td><? echo $lessonParticipation->time_overall; ?></td>
                    <td><? echo $lessonParticipation->time_main; ?></td>
                    <td><? echo $lessonParticipation->time_warmup; ?></td>
                    <td><? echo $lessonParticipation->time_final; ?></td>
                    <td><? echo $lessonParticipation->pulse_before_warmup; ?></td>
                    <td><? echo $lessonParticipation->pulse_after_warmup; ?></td>
                    <td><? echo $lessonParticipation->pulse_after_main; ?></td>
                    <td><? echo $lessonParticipation->pulse_after_final; ?></td>
                    <td><? echo $lessonParticipation->pulse_after_rest; ?></td>
                    <td>
                        <a class="ui blue icon button small" target="_blank"
                           href="<? echo $lessonParticipation->tracker_link; ?>">
                            <i class="icon linkify"></i>
                        </a>
                    </td>
                </tr>
                    <? }
                } ?>
                </tbody>
            </table>
        </div>
        <h4 class="ui header center aligned">Нормативы</h4>
        <table class="ui sortable celled table scrolling center aligned">
            <thead>
            <tr>
                <th>Дата</th>
                <th>Студент</th>
                <th>Норматив</th>
                <th>Значение</th>
                <th>Оценка</th>
            </tr>
            </thead>
            <tbody>
            <?
            $countNormTest = 0;
            foreach ($normativesTest as $normativeTest) {
                if($normativeTest->score !== null) {
                    $personStudent = R::load('person', $students[$normativeTest->id_student]->id_person);?>
            <tr>
                <td>
                    <? echo date("d.m.Y", strtotime($lessons[R::load('normative', $normativeTest->id_normative)->id_lesson]->date)); ?>
                </td>
                <td><? echo $personStudent->surname . " " . substr($personStudent->name, 0, 2) . ". " . substr($personStudent->patronymic, 0, 2)."."; ?></td>
                <td><? echo R::load('normative', $normativeTest->id_normative)->text; ?></td>
                <td><? echo $normativeTest->grade; ?></td>
                <td><? echo $normativeTest->score; ?></td>
            </tr>
            <? }
            } ?>
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
                        <th rowspan="2">Трекер</th>
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
                        <td><a class="ui blue icon button small" href=""><i class="icon linkify"></i></a></td>
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
    $("#formAddLesson").submit(function () {
        $.ajax({
            url: "/queries/professor/addLesson.php",
            method: "POST",
            data: $(this).serialize(),
            success: function () {
                document.getElementById("msgSuccessAddLesson").style.display = "block";
                document.getElementById("msgErrorAddLesson").style.display = "none";
            },
            error: function () {
                document.getElementById("msgSuccessAddLesson").style.display = "none";
                document.getElementById("msgErrorAddLesson").style.display = "block";
            }
        });
        return false;
    });
</script>


<script>
    $('.ui.dropdown')
        .dropdown()
    ;

    function openModalWindowForStudentOfGroupRemove(a) {
        $('#modalStudentOfGroupRemove')
            .data('student_id', a.id)
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

    function removeAndHideStudentFromGroup() {
        var id = $('#modalStudentOfGroupRemove').data('student_id').split('-')[1];
        $.ajax({
            url: "/queries/professor/removeStudent.php",
            method: "POST",
            data: {'id': id},
            success: function () {
                hideModalWindowForStudentOfGroupRemove();
                var rowId = 'row_student_id-' + id;
                $('#' + rowId).remove();
            },
            error: function () {
                console.log('ERROR');
            }
        });
    }

    function openModalWindowForRemoveLesson(btn) {
        var id = btn.id.split('-')[1];
        $('#modalRemoveLesson')
            .data('id', id)
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

    function removeLesson() {
        var id = $('#modalRemoveLesson').data('id');
        $.ajax({
            url: "/queries/professor/removeLesson.php",
            method: "POST",
            data: {'id': id},
            success: function () {
                $('#tr_lesson_id-' + id).remove();
                hideModalWindowForRemoveLesson();
            },
            error: function () {
                
            }
        });
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
