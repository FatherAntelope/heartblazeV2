<?php
require $_SERVER['DOCUMENT_ROOT']."/queries/functions.php";
$person = getDataIsAuthAndEmptyPerson('0');
$student = R::findOne('student', 'id_person = ?', [$person->id]);
if($student->id_group !== null) {
    $group = R::findOne('group', 'id = ?', [$student->id_group]);
} else {
    header("Location: /student/lk.php");
}

$professorInfo = R::load('professor', $group->id_professor);
$professor =  R::load('person', $professorInfo->id_person);

$lessonsParticipation = R::findAll('lesson_participation', 'id_student = ?', [$student->id]);
$normativesTest = R::findAll('normative_test','id_student = ?', [$student->id]);

if($lessonsParticipation != null) {
    $studentVisitsPercent = getStudentVisitsPercent($lessonsParticipation);
} else {
    $studentVisitsPercent = 0;
}

if($normativesTest != null && $lessonsParticipation != null) {
    $studentScore = getStudentScore($normativesTest);
} else {
    $studentScore = 0;
}

if($lessonsParticipation != null) {
    $chartsLesson = array();
    $chartsTimeWarmup = array();
    $chartsTimeMain = array();
    $chartsTimeFinal = array();
    $chartsPulseBeforeWarmup = array();
    $chartsPulseAfterWarmup = array();
    $chartsPulseAfterMain = array();
    $chartsPulseAfterFinal = array();
    $chartsPulseAfterRest = array();
    $chartsPulseAfterDistance = array();

    foreach($lessonsParticipation as $parameter){

        $dateParameter = R::load('lesson', $parameter->id_lesson);

        $chartsDate[] = date("d.m.Y", strtotime(R::load('lesson', $parameter->id_lesson)->date));

        $chartsTimeWarmup[] = intval($parameter->time_warmup);
        $chartsTimeMain[] = intval($parameter->time_main);
        $chartsTimeFinal[] = intval($parameter->time_final);

        $chartsPulseBeforeWarmup[] = intval($parameter->pulse_before_warmup);
        $chartsPulseAfterWarmup[] = intval($parameter->pulse_after_warmup);
        $chartsPulseAfterMain[] = intval($parameter->pulse_after_main);
        $chartsPulseAfterFinal[] = intval($parameter->pulse_after_final);
        $chartsPulseAfterRest[] = intval($parameter->pulse_after_rest);

        $chartsPulseAfterDistance[] = intval($parameter->distance);
        //var_dump($chartsPulseAfterDistance);
    }
    $dataChartsForDrawTime = array_map(null, $chartsDate, $chartsTimeWarmup, $chartsTimeMain, $chartsTimeFinal);
    $dataChartsForDrawPulse = array_map(null, $chartsDate, $chartsPulseBeforeWarmup, $chartsPulseAfterWarmup, $chartsPulseAfterMain, $chartsPulseAfterFinal, $chartsPulseAfterRest);
    $dataChartsForDrawDistance = array_map(null, $chartsDate, $chartsPulseAfterDistance);
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/icon.min.css'>
    <link rel="stylesheet" href="/frameworks/semantic.min.css"/>
    <link rel="shortcut icon" href="/images/ugatu_logo.png" type="image/x-icon">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="/frameworks/jquery.min.js"></script>
    <script src="/frameworks/semantic.min.js"></script>
    <title>Панель управления</title>
</head>
<style>
    *
    {
        scroll-behavior: smooth;
    }
</style>
<body style="background-image: url(/images/bg.jpg)">
<div class="ui container">
    <div class="field">
        <a href="/student/lk.php" class="ui floated small blue labeled icon button" style="margin-bottom: 10px">
            <i class="arrow left icon"></i>Назад
        </a>
        <button onclick="openModalWindowNormativeData()" style="margin-bottom: 10px"
                class="ui floated small green labeled icon button <? if(count($normativesTest) == 0) echo "disabled"; ?>">
            <i class="heartbeat icon"></i>Сданные нормативы
        </button>
        <button onclick="openModalWindowParticipationData()" style="margin-bottom: 10px"
                class="ui floated small orange labeled icon button <? if(count($lessonsParticipation) == 0) echo "disabled"; ?>">
            <i class="table icon"></i>Данные занятий
        </button>
        <a href="#blockParticipation" class="ui floated small brown labeled icon button" style="margin-bottom: 10px">
            <i class="table icon"></i>К занятиям
        </a>
        <a href="#blockCharts" class="ui floated small teal labeled icon button">
            <i class="chart area icon"></i>К графикам
        </a>
        <button onclick="openModalWindowGuide()"
                class="ui floated small black labeled icon button">
            <i class="info icon"></i>Руководство
        </button>
    </div>
    <div class="ui segment">
        <h3 class="ui horizontal divider header"><i class="info red icon"></i>Преподаватель</h3>
        <div class="ui comments">
            <div class="comment">
                <a class="avatar">
                    <img src="<? echo getImageSource( $professor->photo); ?>" style="object-fit: cover; height: 35px; width: 35px;">
                </a>
                <div class="content">
                    <label class="author" style="color: #db2828">
                        <? echo $professor->surname." ".$professor->name." ".$professor->patronymic; ?>
                    </label>
                    <div class="metadata">
                        <div class="date"><i class="user blue icon"></i><? echo R::count('student', 'id_group = ?', [$student->id_group]); ?></div>
                        <div class="rating"><i class="mail blue icon"></i><? echo $professor->email; ?></div>
                    </div>
                    <div class="text"><? echo $professorInfo->job; ?></div>
                    <div class="actions">
                        <a class="hide" onclick="openModalWindowForGroupLeaving()">
                            <i class="user close red icon"></i>Отменить привязку
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <h3 class="ui horizontal divider header"><i class="bar chart red icon"></i>Прогресс</h3>
        <div class="ui progress indicating" data-value="<? echo $studentVisitsPercent; ?>">
            <div class="bar">
                <div class="progress"></div>
            </div>
            <div class="label">Прогресс посещений</div>
        </div>
        <div class="ui progress indicating" data-percent="<? echo $studentScore;?>">
            <div class="bar"></div>
            <div class="label"><? echo "Ваш балл за нормативы - ".$studentScore; ?></div>
        </div>
        <br>
    </div>

    <? if(count($lessonsParticipation) == 0) {?>
    <div class="ui info message">
        <div class="header">Занятия отсутствуют:</div>
        <ul>
            <li>Ваш преподаватель еще не создал ни одно занятие</li>
            <li>Если в вашем расписании есть занятие, но здесь оно не появилось, то обратитесь к преподавателю!</li>
        </ul>
    </div>
    <? } ?>


    <h3 class="ui horizontal top attached divider header" id="blockParticipation"><i class="table red icon"></i>Таблица занятий</h3>
    <table class="ui celled attached table">
        <thead class="center aligned">
        <tr>
            <th>Дата</th>
            <th>Тип занятия</th>
            <th>Посещение</th>
            <th>Действие</th>
        </tr>
        </thead>
        <tbody class="center aligned">
        <?
        foreach ($lessonsParticipation as $lessonParticipation) {
            $dateLesson = R::load('lesson', $lessonParticipation->id_lesson)->date;
            $isNormative = (R::count('normative', 'id_lesson = ?', [$lessonParticipation->id_lesson]) > 0) ? true : false;
            if($lessonParticipation->status == 1) {?>
                <tr class="positive">
                    <td><? echo date("d.m.Y", strtotime($dateLesson)); ?></td>
                    <td><? if($isNormative) echo "С нормативом"; else echo "Обычное"; ?></td>
                    <td>
                        <i class="icon big check circle green"></i>
                    </td>
                    <td>
                        <i class="icon big check circle green"></i>
                    </td>
                </tr>
            <? } elseif ($lessonParticipation->status == 0 || $lessonParticipation->status == 2) { ?>
                <tr class="warning">
                    <td id="<? echo 'td_date_lesson_participation_id-' . $lessonParticipation->idLesson; ?>"><? echo date("d.m.Y", strtotime($dateLesson)); ?></td>
                    <td><? if($isNormative) echo "С нормативом"; else echo "Обычное"; ?></td>
                    <td>
                        <? if($lessonParticipation->status == 2) { ?>
                            <i class="spinner loading big icon"></i>
                        <? } else { ?>
                            <i class="icon big circle warning"></i>
                        <? } ?>
                    </td>
                    <td>
                        <button id="<? echo 'btn_lesson_participation_id-' . $lessonParticipation->idLesson; ?>" class="ui blue icon button" onclick="openModalWindowForSendParticipationData(this)">
                            <i class="icon edit"></i>
                        </button>
                    </td>
                </tr>
            <? } elseif ($lessonParticipation->status == 3) { ?>
                <tr class="negative">
                    <td><? echo date("d.m.Y", strtotime($dateLesson)); ?></td>
                    <td><? if($isNormative) echo "С нормативом"; else echo "Обычное"; ?></td>
                    <td>
                        <i class="icon big close"></i>
                    </td>
                    <td>
                        <i class="icon big close"></i>
                    </td>
                </tr>
            <? }
        } ?>
        </tbody>
        <tfoot class="full-width">
        <tr>
            <th colspan="4">
                <div class="ui orange label"><i class="list icon"></i> <? echo count($lessonsParticipation); ?> </div>
            </th>
        </tr>
        </tfoot>
    </table>

    <div class="ui segment" id="blockCharts">
        <h3 class="ui horizontal divider header"><i class="chart area red icon"></i>Графики</h3>
        <div id="chartTime"></div>
        <div id="chartPulse"></div>
        <div id="chartDist"></div>
    </div>
</div>



<div class="ui large modal horizontal flip " id="modalNormativeData">
    <h1 class="ui header" style="color: #db2828">Сданные нормативы</h1>
    <div class="content">
        <table class="ui celled table">
            <thead class="center aligned">
            <tr>
                <th>Дата</th>
                <th>Название норматива</th>
                <th>Значение норматива</th>
                <th>Оценка</th>
            </tr>
            </thead>
            <tbody class="center aligned">
            <?
            $countNormTest = 0;
            foreach ($normativesTest as $normativeTest) {
                if($normativeTest->score !== null) {
                    $countNormTest++;?>
            <tr>
                <td>
                    <? echo date(
                            "d.m.Y",
                            strtotime(
                                    R::load(
                                            'lesson',
                                        R::load(
                                            'normative',
                                            $normativeTest->id_normative
                                        )->id_lesson
                                    )->date
                            )
                    ); ?>
                </td>
                <td><? echo R::load('normative', $normativeTest->id_normative)->text; ?></td>
                <td><? echo $normativeTest->grade; ?></td>
                <td><? echo $normativeTest->score; ?></td>
            </tr>
            <? }
            } ?>
            </tbody>
            <tfoot class="full-width">
            <tr>
                <th colspan="5">
                    <div class="ui orange label"><i class="list icon"></i> <? echo  $countNormTest; ?> </div>
                </th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>

<div class="ui large modal horizontal flip " id="modalGuide">
    <h1 class="ui header" style="color: #db2828">Руководство</h1>
    <div class="content">
        <h3 class="ui header center aligned">Обозначение элементов интерфейса</h3>
        <h2 class="ui header">
            <i class="icon check circle green"></i>
            <div class="content">
                <div class="sub header">
                    Вы посетили занятие и ваши данные проверены преподавателем группы.
                </div>
            </div>
        </h2>
        <h2 class="ui header">
            <i class="icon circle warning" style="color: #573a08"></i>
            <div class="content">
                <div class="sub header">
                    Занятие только началось, вы еще не отправили ваши данные на проверку.
                    Преподаватель пока не приступил фиксировать посещаемость студентов вашей группы.
                </div>
            </div>
        </h2>
        <h2 class="ui header">
            <i class="icon spinner loading" style="color: #573a08"></i>
            <div class="content">
                <div class="sub header">
                    Занятие началось, вы отправили данные занятия, но преподаватель пока не проверил их.
                    Ожидайте проверки.
                </div>
            </div>
        </h2>
        <h2 class="ui header">
            <i class="icon close" style="color: #9f3a38"></i>
            <div class="content">
                <div class="sub header">
                    Занятие закончилось, вы не отправили свои данные на проверку, а значит и не посетили занятие.
                </div>
            </div>
        </h2>
        <h2 class="ui header">
            <i class="icon edit inverted" style="background: #2185d0; border-radius: 5px"></i>
            <div class="content">
                <div class="sub header">
                    Кнопка редактирования/отправки данных на проверку преподавателю группы.
                </div>
            </div>
        </h2>
        <h2 class="ui header">
            <div class="ui orange label" style="margin-left:0"><i class="list icon"></i> 3 </div>
            <div class="content">
                <div class="sub header" style="margin-top: 5px">
                    Количество элементов в таблице/списке.
                </div>
            </div>
        </h2>
        <h2 class="ui header">
            <div class="content">
                <div class="sub header">
                    Прогрессбары (горизонтальные полосы) указывают ваш прогресс в выполнении всех занятий
                    и в качестве их выполнений.
                </div>
            </div>
        </h2>

        <h3 class="ui header center aligned">Указания</h3>
        <div class="ui message">
            <ul>
                <li>Не отвязывайтесь от преподавателя без видимой причины. Если вы сменили группу, университет,
                    специализацию, то предупредите об этом вашего преподавателя и по его разрешению отвязывайтесь
                    от группы. Можно также отвязаться, если вы привязались не к тому преподавателю.</li>
                <li>Отправляйте данные в день появления задания за занятия. Если вовремя не отправить данные,
                    то, в противном случае, преподаватель вас не отметит.</li>
                <li>Даже если вы посетили занятие в очной форме, но не отправили свои данные,
                    то преподаватель может вас не отметить.</li>
                <li>Если вы посетили занятие и отправили все данные, но преподаватель вас не отметил,
                    то обратитесь к нему по указанной почте, через старосту или по предпочитаемому самим
                    преподавателем способом связи, а затем решите вашу проблему.</li>
            </ul>
        </div>
    </div>
</div>



<div class="ui large modal horizontal flip" id="modalParticipationData">
    <h1 class="ui header" style="color: #db2828">Данные занятий</h1>
    <div class="content">
        <div style="overflow-x: scroll; margin-top: 15px">
            <table class="ui sortable  celled table scrolling center aligned">
                <thead>
                <tr>
                    <th rowspan="2">Дата</th>
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
                $countVisits = 0;
                foreach ($lessonsParticipation as $lessonParticipation) {
                    if ($lessonParticipation->status == 1) {
                        $countVisits++; ?>
                    <tr>
                        <td>
                            <? echo date("d.m.Y", strtotime(R::load('lesson', $lessonParticipation->id_lesson)->date)); ?>
                        </td>
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
                <tfoot class="full-width">
                <tr>
                    <th colspan="12">
                        <div class="ui orange label"><i class="list icon"></i> <? echo $countVisits; ?> </div>
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>


<div class="ui modal horizontal flip tiny" id="modalGroupLeaving">
    <h1 class="ui header center aligned">
        Вы уверены, что хотите выйти из группы?
    </h1>
    <form class="ui form" id="formLeaveGroup">
        <input type="hidden" value="<? echo $person->id; ?>" name="student_id">
    </form>
    <div class="actions">
        <button class="ui right labeled icon red button" onclick="hideModalWindowForGroupLeaving()">
            Отклонить
            <i class="close icon"></i>
        </button>
        <button class="ui right labeled icon green button" form="formLeaveGroup">
            Подтвердить
            <i class="check icon"></i>
        </button>
    </div>
</div>

<div class="ui modal horizontal flip large" id="modalSendParticipationData">
    <h1 id="headerModalSendParticipationData" class="ui header" style="color: #db2828">Отправка данных занятия за "Дата"</h1>
    <div class="content">
        <form id="lesson-data" class="ui form">
                <div class="required field">
                    <label>Пульс</label>
                    <div class="five fields">
                        <div class="field">
                            <div class="ui left icon input">
                                <input type="number" placeholder="До разминки" name="pulse-before-warmup" required>
                                <i class="heart icon red"></i>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui left icon input">
                                <input type="number" placeholder="После разминки" name="pulse-after-warmup" required>
                                <i class="heart icon red"></i>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui left icon input">
                                <input type="number" placeholder="После основной" name="pulse-after-main" required>
                                <i class="heart icon red"></i>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui left icon input">
                                <input type="number" placeholder="После заминки" name="pulse-after-final" required>
                                <i class="heart icon red"></i>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui left icon input">
                                <input type="number" placeholder="Ч/з 10 мин." name="pulse-after-rest" required>
                                <i class="heart icon red"></i>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="required field">
                <label>Время (минуты)</label>
                <div class="four fields">
                    <div class="field">
                        <div class="ui left icon input">
                            <input type="number" placeholder="Общее" name="time-overall" required>
                            <i class="clock icon red"></i>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui left icon input">
                            <input type="number" placeholder="Основное" name="time-main" required>
                            <i class="clock icon red"></i>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui left icon input">
                            <input type="number" placeholder="Разминка" name="time-warmup" required>
                            <i class="clock icon red"></i>
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui left icon input">
                            <input type="number" placeholder="Заминка" name="time-final" required>
                            <i class="clock icon red"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="fields">
                <div class="required field three wide">
                    <label>Дистанция</label>
                    <div class="ui left icon input">
                        <input type="number" placeholder="В метрах" name="distance" required>
                        <i class="road icon red"></i>
                    </div>
                </div>
                <div class="required field thirteen wide">
                    <label>Ссылка на данные с трекера</label>
                    <div class="ui left icon input">
                        <input type="text" placeholder="Ссылка на Pacer или другое приложение" name="tracker-link" required>
                        <i class="linkify icon red"></i>
                    </div>
                </div>
            </div>
            
            <input type="hidden" id="hidden-lesson-id" name="lesson-id">
            <input type="hidden" id="hidden-student-id" name="student-id">

            <!--Если есть нормативы. Вместе с разделителем!-->
            <div id="norm-divider" class="ui divider"></div>

        </form>
    </div>
    <div class="actions">
                
        <button type="submit" form="lesson-data" class="ui right labeled icon green button">
            Отправить
            <i class="check icon"></i>
        </button>
    </div>
</div>
</body>


<script>
    $("#formLeaveGroup").submit(function () {
        $.ajax({
            url: "/queries/student/leaveGroup.php",
            method: "POST",
            data: $(this).serialize(),
            success: function () {
                location.reload();
            },
            error: function () {
            }
        });
        return false;
    });

    $("#lesson-data").submit(function () {
        var d = $('#lesson-data');
        //console.log(d.html());
        //console.log(d.serialize());
        $.ajax({
                url: "/queries/student/sendLessonParticipation.php",
                method: "POST",
                data: d.serialize(),
                success: function () {
                    location.href = "/student/panel.php";
                },
                error: function () {
                 }
        });
    });


</script>


<script>
    $('.ui.progress').progress();

    function openModalWindowNormativeData() {
        $('#modalNormativeData')
            .modal({
                inverted: true
            })
            .modal('show')
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

    function openModalWindowParticipationData() {
        $('#modalParticipationData')
            .modal({
                inverted: true
            })
            .modal('show')
        ;
    }

    var student_id = <? echo $student->id; ?>;
    var id_lesson;

    function openModalWindowForSendParticipationData(btn) {
        id_lesson = btn.id.split('-')[1];
        fillForm(id_lesson);  
        $('#modalSendParticipationData')
            .modal({
                inverted: true
            })
            .modal('show')
        ;
    
    }

    function fillForm(id_lesson) {
        var date = $('#td_date_lesson_participation_id-' + id_lesson).text();
        $('#headerModalSendParticipationData').text('Отправка данных занятия за ' + date);
        $('.norm-fields').remove();
        $('#hidden-lesson-id').attr('value', id_lesson);
        $('#hidden-student-id').attr('value', student_id);
        
        $.ajax({
            url: "/queries/student/getNormatives.php",
            method: "POST",
            data: {'id': id_lesson},
            success: function (json) {
                var normatives = JSON.parse(json); 
                var normDivider = $('#norm-divider');
                for (const [key, value] of Object.entries(normatives)) {
                  normDivider.after(`
                    <div class="required field three wide norm-fields">
                        <label>${value['text']}</label>
                        <div class="ui left icon input">
                            <input type="number" placeholder="Значение" name="norm-${key}" required>
                            <i class="info icon red"></i>
                        </div>
                    </div>
                  `);
                }

            },
            error: function () {
            }
        });
    }

    function openModalWindowForGroupLeaving() {
        $('#modalGroupLeaving')
            .modal({
                inverted: true
            })
            .modal('setting', 'closable', false)
            .modal('show')
        ;
    }

    function hideModalWindowForGroupLeaving() {
        $('#modalGroupLeaving')
            .modal('hide')
        ;
    }
</script>

<script type="text/javascript">
    google.charts.load('current', {'packages':['line']});
    google.charts.setOnLoadCallback(drawChartTime);
    google.charts.setOnLoadCallback(drawChartPulse);
    google.charts.setOnLoadCallback(drawChartDistance);

    function drawChartTime() {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Дата');
        data.addColumn('number', 'Разминка');
        data.addColumn('number', 'Основная часть');
        data.addColumn('number', 'Заминка');

        data.addRows(<? echo json_encode($dataChartsForDrawTime); ?>);

        var options = {
            chart: { title: 'Время тренировки.'},
            height: 500,
            legend: { position: 'none'}
        };

        var chart = new google.charts.Line(document.getElementById('chartTime'));
        chart.draw(data, google.charts.Line.convertOptions(options));
    }

    function drawChartPulse() {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Дата');
        data.addColumn('number', 'До разминки');
        data.addColumn('number', 'После разминки');
        data.addColumn('number', 'После основной части');
        data.addColumn('number', 'После заминки');
        data.addColumn('number', 'После отдыха');

        data.addRows(<? echo json_encode($dataChartsForDrawPulse); ?>);

        var options = {
            chart: { title: 'Пульс.'},
            height: 500,
            legend: { position: 'none'}
        };

        var chart = new google.charts.Line(document.getElementById('chartPulse'));
        chart.draw(data, google.charts.Line.convertOptions(options));
    }

    function drawChartDistance() {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Дата');
        data.addColumn('number', 'Дистанция');

        data.addRows(<? echo json_encode($dataChartsForDrawDistance); ?>);

        var options = {
            chart: { title: 'Дистанция.'},
            height: 500,
            legend: { position: 'none'}
        };

        var chart = new google.charts.Line(document.getElementById('chartDist'));
        chart.draw(data, google.charts.Line.convertOptions(options));
    }

</script>

</html>