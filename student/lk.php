<?php
require $_SERVER['DOCUMENT_ROOT']."/queries/functions.php";
$person = getDataIsAuthAndEmptyPerson('0');
$student = R::findOne('student', 'id_person = ?', [$person->id]);
$parameters = R::findOne('student_data', 'id_student = ? ORDER BY id DESC', [$student->id]);
if($student->id_group !== null) {
    $group = R::findOne('group', 'id = ?', [$student->id_group]);
}
$allParameters = R::findAll('student_data', 'id_student = ? ORDER BY date ASC', [$student->id]);

if($allParameters != null) {
    $chartsDate = array();
    $chartsWeight = array();
    $chartsHeight = array();

    $chartsStateHealth = array();
    $chartsStateMood = array();
    $chartsStateAppetite = array();
    $chartsStateSleep = array();
    $chartsStateEfficiency = array();

    foreach($allParameters as $parameter){

        $chartsDate[] = date("d.m.Y", strtotime($parameter->date));
        $chartsWeight[] = intval($parameter->weight);
        $chartsHeight[] = intval($parameter->height);

        switch ($parameter->state_of_health){
            case "Хорошее":
                $chartsStateHealth[] = 3;
                break;
            case "Удовлетворительное":
                $chartsStateHealth[] = 2;
                break;
            case "Плохое":
                $chartsStateHealth[] = 1;
                break;
        }
        switch ($parameter->mood){
            case "Хорошее":
                $chartsStateMood[] = 3;
                break;
            case "Удовлетворительное":
                $chartsStateMood[] = 2;
                break;
            case "Плохое":
                $chartsStateMood[] = 1;
                break;
        }
        switch ($parameter->appetite){
            case "Повышенный":
                $chartsStateAppetite[] = 3;
                break;
            case "Нормальный":
                $chartsStateAppetite[] = 2;
                break;
            case "Пониженный":
                $chartsStateAppetite[] = 1;
                break;
        }
        switch ($parameter->sleep){
            case "Хороший":
                $chartsStateSleep[] = 3;
                break;
            case "Плохой":
                $chartsStateSleep[] = 2;
                break;
            case "Бессонница":
                $chartsStateSleep[] = 1;
                break;
        }
        switch ($parameter->efficiency){
            case "Повышенная":
                $chartsStateEfficiency[] = 3;
                break;
            case "Обычная":
                $chartsStateEfficiency[] = 2;
                break;
            case "Пониженная":
                $chartsStateEfficiency[] = 1;
                break;
        }

        switch (getIndexQuetelet(intval($parameter->weight) / pow(intval($parameter->height) / 100, 2))){
            case "Ожирение":
                $chartsQuetelet[] = 2;
                break;
            case "Повышенный":
                $chartsQuetelet[] = 1;
                break;
            case "Нормальный":
                $chartsQuetelet[] = 0;
                break;
            case "Пониженный":
                $chartsQuetelet[] = -1;
                break;
            case "Истощение":
                $chartsQuetelet[] = -2;
                break;
        }
        switch (getOrthostaticProbe(intval($parameter->orthostatic))){
            case "Заболевание":
                $chartsOrthostatic[] = -2;
                break;
            case "Выраженное утомление":
                $chartsOrthostatic[] = -1;
                break;
            case "Среднее утомление":
                $chartsOrthostatic[] = 0;
                break;
            case "Легкое утомление":
                $chartsOrthostatic[] = 1;
                break;
            case "Хорошее состояние":
                $chartsOrthostatic[] = 2;
                break;
        }
        switch (getRuffierProbe(intval($parameter->ruffier))){
            case "Сердечная недостаточность высшей степени":
                $chartsRuffierProbe[] = -2;
                break;
            case "Сердечная недостаточность средней степени":
                $chartsRuffierProbe[] = -1;
                break;
            case "Хорошее сердце":
                $chartsRuffierProbe[] = 0;
                break;
            case "Отличное сердце":
                $chartsRuffierProbe[] = 1;
                break;
        }
        switch (getStangeProbe(intval($parameter->stange))){
            case "Отлично":
                $chartsStange[] = 1;
                break;
            case "Хорошо":
                $chartsStange[] = 0;
                break;
            case "Удовлетворительно":
                $chartsStange[] = -1;
                break;
            case "Неудовлетворительно":
                $chartsStange[] = -2;
                break;
        }
        switch (getTappingTest(intval($parameter->tapping_test))){
            case "Отлично":
                $chartsTapping_test[] = 2;
                break;
            case "Хорошо":
                $chartsTapping_test[] = 1;
                break;
            case "Нормально":
                $chartsTapping_test[] = 0;
                break;
            case "Удовлетворительно":
                $chartsTapping_test[] = -1;
                break;
            case "Неудовлетворительно":
                $chartsTapping_test[] = -2;
                break;
        }
    }

    $dataChartsForDrawWeightAndHeight = array_map(null, $chartsDate, $chartsWeight, $chartsHeight);

    $dataChartsForDrawStats = array_map(null, $chartsDate, $chartsStateHealth, $chartsStateMood, $chartsStateSleep, $chartsStateAppetite, $chartsStateEfficiency);
    array_unshift($dataChartsForDrawStats, ['Дата', 'Состояние здоровья', 'Настроение', 'Сон', 'Аппетит', 'Работоспособность']);

    $dataChartsForDrawIndexes = array_map(null, $chartsDate, $chartsQuetelet, $chartsOrthostatic, $chartsRuffierProbe, $chartsStange, $chartsTapping_test);
    array_unshift($dataChartsForDrawIndexes, ['Дата', 'Кетле', 'Ортостатическая проба', 'Руфье', 'Штанге', 'Теппинг-тест']);
}



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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <title>Личный кабинет</title>
</head>
<style>
    *
    {
        scroll-behavior: smooth;
    }
</style>
<body style="background-image: url(/images/bg.jpg);">
<!--
* Контейнер - блок с содержимым, имеющий отступы по краям (слева и справа)
-->
<div class="ui container">
        <!--
        * Делим контейнер на две колонки
        -->
        <div class="ui two column stackable grid">
            <!--
            * Ширина первой колонки - 4. Всего в ширину может быть 16 колонок
            -->
            <div class="column four wide">
                <!--
                * Сегмент, в котором располагается аватарка
                -->
                <div class="ui segment inverted blue">
                    <div class="ui red left ribbon label"><?php echo $person->login; ?></div>

                    <img class="ui image centered" src="<? echo getImageSource($person->photo);?>"
                         style="object-fit: cover; height: 200px; width: 200px;
                         border-radius: 54% 46% 47% 53% / 24% 55% 45% 76%;">
                    <div class="ui tiny icon buttons orange fluid" style="margin-top: 20px">
                        <a href="/queries/exit.php" class="ui button hint" data-content="Выйти" data-position="top center">
                            <i class="sign-out large icon"></i>
                        </a>
                        <button class="ui button hint" data-content="Сменить фотографию" data-position="top center"
                                onclick="openModalWindowForAvatarReplace()" >
                            <i class="file large image icon"></i>
                        </button>
                    </div>
                </div>
                <!--
                * Кнопка для перехода в панель управления
                -->



                <a href="/student/panel.php"
                   class="ui green button fluid <? if($student->id_group === null) echo "disabled";?>">
                    Панель управления
                </a>
                <a href="#segmentCharts" class="ui teal button fluid" style="margin-top: 10px">
                    К графикам
                </a>
            </div>
            <div class="column twelve wide">
                <div class="ui segment">
                    <h2 class="ui center aligned header" style="color: #db2828">Портфолио</h2>
                    <h4 class="ui horizontal divider header"><i class="address book red icon"></i> Личные данные </h4>
                    <table class="ui very basic table">
                        <tbody class="center aligned">
                        <tr>
                            <td><b>ФИО:</b></td>
                            <td>
                                <?php echo $person->surname, " ", $person->name, " ", $person->patronymic; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Учебная группа:</b></td>
                            <td><?php if($student->group_study == null) echo "—"; else echo $student->group_study; ?></td>
                        </tr>
                        <tr>
                            <td><b>Роль:</b></td>
                            <td>Студент</td>
                        </tr>
                        <tr>
                            <td><b>Дата рождения:</b></td>
                            <td>
                                <?php
                                if($student->birth_date == null) echo "—";
                                else echo date("d.m.Y", strtotime($student->birth_date));
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Возраст:</b></td>
                            <td>
                                <?php
                                if($student->birth_date == null) echo "—";
                                else echo floor( (time() - strtotime($student->birth_date)) /(60 * 60 * 24 * 365.25));
                                ?>
                            </td>
                        </tr>
                        </tbody>
                        <tfoot class="full-width">
                        <tr>
                            <th></th>
                            <th>
                                <div class="ui right floated small green labeled icon button" onclick="openModalForReplacePersonalData()">
                                    <i class="edit icon"></i>
                                    Изменить
                                </div>
                            </th>
                        </tr>
                        </tfoot>
                    </table>
                    <h4 class="ui horizontal divider header"><i class="address book red icon"></i> Учетные данные </h4>
                    <table class="ui very basic table">
                        <tbody class="center aligned">
                        <tr>
                            <td><b>Почта:</b></td>
                            <td><?php echo $person->email; ?></td>
                        </tr>
                        <tr>
                            <td><b>Смена пароля:</b></td>
                            <td><a href="#" onclick="openModalWindowForPassReplace()">Изменить</a></td>
                        </tr>
                        <tr>
                            <td><b>Группа:</b></td>
                            <td>
                                <? if ($group == null) {?>
                                <a href="#" onclick="openModalWindowForGroupBinding()">Привязаться</a>
                                <? } else { ?>
                                    <label style="color: #db2828"> <? echo $group->name;  ?> </label>
                                    <a href="#" onclick="openModalWindowForGroupLeaving()">(Выйти)</a>
                                <? } ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <h4 class="ui horizontal divider header"><i class="chart bar red icon"></i> Физические параметры </h4>
                    <table class="ui very basic table">
                        <tbody class="center aligned">
                        <tr>
                            <td><b>Вес:</b></td>
                            <td><? if($parameters == null) echo "—"; else echo $parameters->weight;?></td>
                        </tr>
                        <tr>
                            <td><b>Рост:</b></td>
                            <td><? if($parameters == null) echo "—"; else echo $parameters->height;?></td>
                        </tr>
                        <tr>
                            <td><b>Индекс Кетле:</b></td>
                            <td><? if($parameters == null) echo "—"; else echo getIndexQuetelet($parameters->quetelet); ?></td>
                        </tr>
                        <tr>
                            <td><b>Ортостатическая проба:</b></td>
                            <td><? if($parameters == null) echo "—"; else echo getOrthostaticProbe($parameters->orthostatic); ?></td>
                        </tr>
                        <tr>
                            <td><b>Проба Руфье:</b></td>
                            <td><? if($parameters == null) echo "—"; else echo getRuffierProbe($parameters->ruffier); ?></td>
                        </tr>
                        <tr>
                            <td><b>Проба Штанге:</b></td>
                            <td><? if($parameters == null) echo "—"; else echo getStangeProbe($parameters->stange); ?></td>
                        </tr>
                        <tr>
                            <td><b>Теппинг тест:</b></td>
                            <td><? if($parameters == null) echo "—"; else echo getStangeProbe($parameters->getTappingTest); ?></td>
                        </tr>
                        <tr>
                            <td><b>Жалобы на здоровье:</b></td>
                            <td><? if($parameters == null) echo "—"; else echo $parameters->complaints;?></td>
                        </tr>
                        <tr>
                            <td><b>Самочувствие:</b></td>
                            <td><? if($parameters == null) echo "—"; else echo $parameters->state_of_health;?></td>
                        </tr>
                        <tr>
                            <td><b>Настроение:</b></td>
                            <td><? if($parameters == null) echo "—"; else echo $parameters->mood;?></td>
                        </tr>
                        <tr>
                            <td><b>Сон:</b></td>
                            <td><? if($parameters == null) echo "—"; else echo $parameters->sleep;?></td>
                        </tr>
                        <tr>
                            <td><b>Аппетит:</b></td>
                            <td><? if($parameters == null) echo "—"; else echo $parameters->appetite;?></td>
                        </tr>
                        <tr>
                            <td><b>Работоспособность:</b></td>
                            <td><? if($parameters == null) echo "—"; else echo $parameters->efficiency;?></td>
                        </tr>
                        </tbody>
                        <tfoot class="full-width">
                        <tr>
                            <th class="center aligned">
                                <p style="color: #2185d0">
                                    <? if ($parameters != null)
                                        echo "Последнее добавление: ".date("d.m.Y в H:i", strtotime($parameters->date));
                                    ?>
                                </p>
                            </th>
                            <th>
                                <div class="ui right floated small green labeled icon button" onclick="openModalForSendPhysicalParameters()">
                                    <i class="edit icon"></i>
                                    Отправить новые
                                </div>
                                <div class="ui right floated small teal labeled icon button" onclick="openModalWindowInfoFormulae()">
                                    <i class="calculator icon"></i>
                                    Формулы
                                </div>
                            </th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="ui segment" id="segmentCharts">
                    <h2 class="ui center aligned header" style="color: #db2828">Графики</h2>
                    <div id="heightAndWeight"></div>
                    <div id="stats"></div>
                    <div id="indexes"></div>
                </div>
            </div>
        </div>
</div>

<!--
*  Модальное окно смены пароля
-->
<div class="ui modal horizontal flip tiny" id="modalPassReplace">
    <div class="header" style="color: #db2828">
        Смена пароля
    </div>
    <div class="content">
        <form class="ui form" id="formReplacePersonalPassword">
            <div class="required field">
                <label>Старый пароль</label>
                <div class="ui left icon input">
                    <input type="password" placeholder="Введите старый пароль" name="person_old_password" required>
                    <i class="lock icon red"></i>
                </div>
            </div>
            <div class="required field">
                <label>Новый пароль</label>
                <div class="ui left icon input">
                    <input type="password" placeholder="Введите новый пароль" name="person_new_password" required>
                    <i class="lock icon red"></i>
                </div>
            </div>
            <div class="required field">
                <label>Повтор пароля</label>
                <div class="ui left icon input">
                    <input type="password" placeholder="Повторите новый пароль" maxlength="20" minlength="6" name="person_repeat_password" required>
                    <i class="lock icon red"></i>
                </div>
            </div>
            <input type="hidden" name="person_id" value="<? echo $person->id; ?>">
        </form>
        <div class="ui error message" id="msgErrorReplacePassword" style="display: none">
            <i class="close icon"></i>
            <div class="header">Ошибка смены пароля</div>
            <ul>
                <li>Старый пароль неверен или новые не совпадают</li>
                <li>Повторите ввод</li>
            </ul>
        </div>
        <div class="ui success message" id="msgSuccessReplacePassword" style="display: none">
            <div class="header">Пароль успешно сменился на новый!</div>
        </div>
    </div>
    <div class="actions" id="actionsReplacePassword">
        <button class="ui right labeled icon green button" type="submit" form="formReplacePersonalPassword">
            Подтвердить
            <i class="check icon"></i>
        </button>
    </div>
</div>


<!--
*  Модальное окно с инфромацией о формулах физических расчетов
-->
<div class="ui modal horizontal flip" id="modalInfoFormulae">
    <div class="header" style="color: #db2828">
        Формулы расчета физических параметров
    </div>
    <div class="content">
        <h4 class="ui header">
            <i class="info blue icon"></i>
            <div class="content">Что такое индекс Кетле?
                <div class="sub header">
                    Это индекс массы тела, с помощью которого можно определить степень ожирения
                    и оценить возможный риск развития заболеваний, связанных с избыточной массой тела.
                </div>
            </div>
        </h4>
        <h4 class="ui header">
            <i class="info blue icon"></i>
            <div class="content">Как расчитать ортостатическую пробу?
                <div class="sub header">
                    Данный метод исследования и диагностирования состояния сердечно-сосудистой и нервной систем
                    позволяет выявить нарушения в регуляции работы сердца.
                    <br>
                    Лежать спокойно в горизонтальном положении 5 минут, затем подсчитать ЧСС1 за минуту,
                    после чего встать и вновь подсчитать ЧСС2 за минуту (ЧСС - частота сердечных сокращений).
                    Затем находим разницу между двумя величинами ЧСС=(ЧСС2–ЧСС1).
                </div>
            </div>
        </h4>
        <h4 class="ui header">
            <i class="info blue icon"></i>
            <div class="content">Как расчитать пробу Руфье?
                <div class="sub header">
                    Предназначена для оценки работоспособности сердца при физической нагрузке.
                    <br>
                    После короткого отдыха в течение 5 минут в положении сидя подсчитать ЧСС за 10 секунд (Р0).
                    Далее в течение 30 секунд выполнить 30 приседаний, после чего в положении сидя подсчитать ЧСС
                    в течение первых (Р1) и последних (Р2) 10 с первой минуты восстановления.
                    Полученные значения подставить в формулу: ПР = (6*(Р0+Р1+Р2) – 200)/10.
                </div>
            </div>
        </h4>
        <h4 class="ui header">
            <i class="info blue icon"></i>
            <div class="content">Как расчитать пробу Штанге?
                <div class="sub header">
                    Позволяет оценить функциональное состояние дыхательной и в определенной мере
                    сердечно-сосудистой системы.
                    <br>
                    В положении сидя на стуле сделать спокойный вдох, затем глубокий выдох,
                    затем глубокий вдох и задержать дыхание, зажав нос большим и указательным пальцами.
                    По секундомеру (или секундной стрелке часов) фиксировать время задержки дыхания.
                    Внести время в секундах.
                </div>
            </div>
        </h4>
        <h4 class="ui header">
            <i class="info blue icon"></i>
            <div class="content">Как расчитать теппинг-тест?
                <div class="sub header">
                    Методика экспресс-диагностики свойств нервной системы по психомоторным показателям
                    <br>
                    Взять лист бумаги А4, разделить карандашом на 4 равных прямоугольника. Сидя за столом
                    по команде «старт» (родственника или друга) начинать с максимальной частотой ставить точки на бумаге
                    в течение 10 секунд. После паузы в 20 секунд перенести руку на следующий квадрат,
                    продолжая выполнять движения с максимальной частотой. После четырехкратного повторения
                    по команде «стоп» работу прекратить. При подсчитывании точек, чтобы не ошибиться, карандаш вести
                    от точки к точке, не отрывая его от бумаги. Внести сумму количества всех точек.
                </div>
            </div>
        </h4>
    </div>
</div>




<!--
*  Модальное окно привязки к группе
-->
<div class="ui modal horizontal flip tiny" id="modalGroupBinding">
    <div class="header" style="color: #db2828">
        Привязаться к группе
    </div>
    <div class="content">
        <form class="ui form" id="formReferenceGroup"
            <?if($student->group_study === null || $student->birth_date === null ) echo "hidden"?>>
            <div class="required field">
                <label>Ключевое слово</label>
                <div class="ui left icon input">
                    <input type="text" placeholder="Введите ключевое слово привязки" name="code_word" required>
                    <i class="key icon red"></i>
                </div>
            </div>
            <input type="hidden" value="<? echo $person->id; ?>" name="student_id">
        </form>
        <? if($student->group_study === null || $student->birth_date === null ) { ?>
        <div class="ui error message">
            <div class="header">Нет доступа:</div>
            <ul>
                <li>Вы не можете подать заявку, заполните все данные</li>
            </ul>
        </div>
        <? } ?>

        <div class="ui error message" id="msgErrorReferenceGroup" style="display: none">
            <i class="close icon"></i>
            <div class="header">Ошибка привязки к группе</div>
            <ul>
                <li>Введенное ключевое слово неактивно</li>
                <li>Обратитесь к старосте или к преподавателю для получения валидного ключевого слова</li>
            </ul>
        </div>

        <div class="ui success message" id="msgSuccessReferenceGroup" style="display: none">
            <div class="header">Успешная привязка к группе!</div>
        </div>

    </div>
    <div class="actions" id="actionReferenceGroup">
        <button class="ui right labeled icon green button
        <?if($student->group_study === null || $student->birth_date === null ) echo "disabled"?>"
        form="formReferenceGroup">
            Подтвердить
            <i class="check icon"></i>
        </div>
    </div>
</div>


<!--
*  Модальное окно выхода из группы
-->
<div class="ui modal horizontal flip tiny" id="modalGroupLeaving">
    <h1 class="ui header center aligned">
        Вы уверены, что хотите выйти из группы?
    </h1>
    <div class="actions">
        <form class="ui form" id="formLeaveGroup">
            <input type="hidden" value="<? echo $person->id; ?>" name="student_id">
        </form>
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

<!--
*  Модальное окно смены личных данных
-->
<div class="ui modal horizontal flip big" id="modalReplacePersonalData">
    <div class="header" style="color: #db2828">
        Смена личных данных
    </div>
    <div class="content">
        <form class="ui form" id="formReplacePersonalData">
            <div class="fields">
                <div class="required field five wide">
                    <label>Фамилия</label>
                    <div class="ui left icon input">
                        <input type="text" placeholder="Ваша фамилия"
                               value="<?php echo $person->surname; ?>" onkeyup="Cyrillic(this)" maxlength="20" minlength="2" name="student_surname" required>
                        <i class="font icon red"></i>
                    </div>
                </div>
                <div class="required field five wide">
                    <label>Имя</label>
                    <div class="ui left icon input">
                        <input type="text" placeholder="Ваше имя"
                               value="<?php echo $person->name;?>" onkeyup="Cyrillic(this)" maxlength="20" minlength="2" name="student_name" required>
                        <i class="font icon red"></i>
                    </div>
                </div>
                <div class="field six wide">
                    <label>Отчество</label>
                    <div class="ui left icon input">
                        <input type="text" placeholder="Ваше отчество"
                               value="<?php echo $person->patronymic; ?>" onkeyup="Cyrillic(this)" maxlength="40" name="student_patronymic">
                        <i class="font icon red"></i>
                    </div>
                </div>
            </div>
            <div class="fields">
                <div class="required field five wide">
                    <label>Учебная группа</label>
                    <div class="ui left icon input">
                        <input type="text" placeholder="Группа направления"
                               value="<?php echo $student->group_study; ?>" onkeyup="CyrillicTwo(this)" minlength="2" maxlength="10" name="student_group_study" required>
                        <i class="users icon red"></i>
                    </div>
                </div>
                <div class="required field five wide">
                    <label>Дата рождения</label>
                    <div class="ui left icon input">
                        <input type="date" value="<? echo $student->birth_date; ?>" name="student_birth_date" required>
                        <i class="calendar icon red"></i>
                    </div>
                </div>
            </div>
            <input type="hidden" value="<? echo $person->id; ?>" name="student_id">
        </form>
    </div>
    <div class="actions">
        <button class="ui right labeled icon red button" onclick="hideModalForReplacePersonalData()">
            Отклонить
            <i class="close icon"></i>
        </button>
        <button class="ui right labeled icon green button" type="submit" form="formReplacePersonalData">
            Изменить
            <i class="check icon"></i>
        </button>
    </div>
</div>

<div class="ui modal horizontal flip big" id="modalSendPhysicalParameters">
    <div class="header" style="color: #db2828">
        Отправка физических параметров
    </div>
    <div class="content">
        <form class="ui form" id="formSendPhysicalParameters">
            <div class="fields">
                <div class="required field three wide">
                    <label>Вес</label>
                    <div class="ui left icon input">
                        <input type="number" placeholder="Ваш вес" name="student_weight"  min="10" max="300" required>
                        <i class="weight icon red"></i>
                    </div>
                </div>
                <div class="required field three wide">
                    <label>Рост</label>
                    <div class="ui left icon input">
                        <input type="number" placeholder="Ваш рост" name="student_height" min="100" max="300" required>
                        <i class="child icon red"></i>
                    </div>
                </div>
            </div>

            <div class="four fields">
                <div class="required field">
                    <label>Ортостатическая проба</label>
                    <div class="ui left icon input">
                        <input type="number" placeholder="Числовое" name="student_orthostatic" max="9999" required>
                        <i class="chart line icon red"></i>
                    </div>
                </div>
                <div class="required field">
                    <label>Проба Руфье</label>
                    <div class="ui left icon input">
                        <input type="number" placeholder="Числовое" name="student_ruffier" max="9999" required>
                        <i class="chart line icon red"></i>
                    </div>
                </div>
                <div class="required field">
                    <label>Проба Штанге</label>
                    <div class="ui left icon input">
                        <input type="number" placeholder="Числовое" name="student_stange" max="9999" required>
                        <i class="chart line icon red"></i>
                    </div>
                </div>
                <div class="required field">
                    <label>Теппинг тест</label>
                    <div class="ui left icon input">
                        <input type="number" placeholder="Числовое" name="student_tapping_test" max="9999" required>
                        <i class="chart line icon red"></i>
                    </div>
                </div>
            </div>

            <div class="field">
                <label>Жалобы на здоровье</label>
                <div class="ui left icon input">
                    <input type="text" placeholder="Перечислите, если есть" onkeyup="CyrillicTwo(this)" name="student_complaints">
                    <i class="stethoscope icon red"></i>
                </div>
            </div>

            <div class="fields">
                <div class="required four wide field">
                    <label>Самочувствие</label>
                    <div class="ui input">
                        <select class="ui fluid dropdown" name="student_state_of_health" required>
                            <option value="">Выберите</option>
                            <option value="Хорошее">Хорошее</option>
                            <option value="Удовлетворительное">Удовлетворительное</option>
                            <option value="Плохое">Плохое</option>
                        </select>
                    </div>
                </div>

                <div class="required four wide field">
                    <label>Настроение</label>
                    <div class="ui input">
                        <select class="ui fluid dropdown" name="student_mood" required>
                            <option value="">Выберите</option>
                            <option value="Хорошее">Хорошее</option>
                            <option value="Плохое">Плохое</option>
                            <option value="Удовлетворительное">Удовлетворительное</option>
                        </select>
                    </div>
                </div>

                <div class="required four wide field">
                    <label>Сон</label>
                    <div class="ui input">
                        <select class="ui fluid dropdown" name="student_sleep" required>
                            <option value="">Выберите</option>
                            <option value="Хороший">Хороший</option>
                            <option value="Плохой">Плохой</option>
                            <option value="Бессонница">Бессонница</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="fields">
                <div class="required four wide field">
                    <label>Аппетит</label>
                    <div class="ui input">
                        <select class="ui fluid dropdown" name="student_appetite" required>
                            <option value="">Выберите</option>
                            <option value="Повышенный">Повышенный</option>
                            <option value="Нормальный">Нормальный</option>
                            <option value="Пониженный">Пониженный</option>
                        </select>
                    </div>
                </div>

                <div class="required four wide field">
                    <label>Работоспособность</label>
                    <div class="ui input">
                        <select class="ui fluid dropdown" name="student_efficiency" required>
                            <option value="">Выберите</option>
                            <option value="Повышенная">Повышенная</option>
                            <option value="Обычная">Обычная</option>
                            <option value="Пониженная">Пониженная</option>
                        </select>
                    </div>
                </div>
            </div>
            <input type="hidden" value="<? echo $student->id; ?>" name="student_id">
        </form>
    </div>
    <div class="actions">
        <button class="ui right labeled icon red button" onclick="hideModalForSendPhysicalParameters()">
            Отклонить
            <i class="close icon"></i>
        </button>
        <button class="ui right labeled icon green button" type="submit" form="formSendPhysicalParameters">
            Изменить
            <i class="check icon"></i>
        </button>
    </div>
</div>

<div class="ui modal horizontal flip tiny" id="modalAvatarReplace">
    <div class="header" style="color: #db2828">
        Смена фотографии
    </div>
    <div class="content">
        <form class="ui form" id="formReplacePersonalAvatar">
            <div class="ui left icon input fluid">
                <input type="file" accept="image/png,image/jpeg" name="person_photo" required>
                <i class="image icon red"></i>
            </div>
            <input type="hidden" value="<? echo $person->id; ?>" name="person_id">
        </form>
    </div>
    <div class="actions">
        <button class="ui right labeled icon green button" type="submit" form="formReplacePersonalAvatar">
            Сменить
            <i class="check icon"></i>
        </button>
    </div>
</div>

</body>



<script>
    function Latin(obj) {
        if (/^[a-zA-Z0-9 ,@.\-:"()]*?$/.test(obj.value))
            obj.defaultValue = obj.value;
        else
            obj.value = obj.defaultValue;
    }

    function Cyrillic(obj) {
        if (/^[а-яА-Я]*?$/.test(obj.value))
            obj.defaultValue = obj.value;
        else
            obj.value = obj.defaultValue;
    }

    function CyrillicTwo(obj) {
        if (/^[а-яА-Я0-9 .,-]*?$/.test(obj.value))
            obj.defaultValue = obj.value;
        else
            obj.value = obj.defaultValue;
    }


    $("#formSendPhysicalParameters").submit(function () {
        $.ajax({
            url: "/queries/student/sendPhysicalParameters.php",
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

    $("#formReferenceGroup").submit(function () {
        $.ajax({
            url: "/queries/student/referenceGroup.php",
            method: "POST",
            data: $(this).serialize(),
            success: function () {
                document.getElementById("msgSuccessReferenceGroup").style.display = "block";
                document.getElementById("msgErrorReferenceGroup").style.display = "none";
                document.getElementById("actionReferenceGroup").hidden = true;
                document.getElementById("formReferenceGroup").hidden = true;
                setTimeout(function(){ location.reload() ;}, 1100);
            },
            error: function () {
                document.getElementById("msgSuccessReferenceGroup").style.display = "none";
                document.getElementById("msgErrorReferenceGroup").style.display = "block";
                document.getElementsByName("code_word")[0].value = "";
            }
        });
        return false;
    });

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

    $("#formReplacePersonalData").submit(function () {
        $.ajax({
            url: "/queries/student/replacePersonalData.php",
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

    $("#formReplacePersonalAvatar").submit(function () {
        $.ajax({
            url: "/queries/replaceAvatar.php",
            contentType: false,
            processData: false,
            method: "POST",
            data: new FormData(this),
            success: function () {
                location.reload();
            },
            error: function () {
                //location.reload();
            }
        });
        return false;
    });

    $("#formReplacePersonalPassword").submit(function () {
        $.ajax({
            url: "/queries/replacePassword.php",
            method: "POST",
            data: $(this).serialize(),
            success: function () {
                document.getElementById("msgSuccessReplacePassword").style.display = "block";
                document.getElementById("msgErrorReplacePassword").style.display = "none";
                document.getElementById("actionsReplacePassword").style.display = "none";
                document.getElementById("formReplacePersonalPassword").hidden = true;
                setTimeout(function(){ location.reload() ;}, 1100);
            },
            error: function () {
                document.getElementById("msgSuccessReplacePassword").style.display = "none";
                document.getElementById("msgErrorReplacePassword").style.display = "block";
                document.getElementsByName("person_old_password")[0].value = "";
                document.getElementsByName("person_new_password")[0].value = "";
                document.getElementsByName("person_repeat_password")[0].value = "";
            }
        });
        return false;
    });
</script>

<script>
    $('.message .close')
        .on('click', function() {
            $(this)
                .closest('.message')
                .transition('fade')
            ;
        })
    ;

    $('.hint')
        .popup()
    ;

    $('.ui.dropdown')
        .dropdown()
    ;

    function openModalWindowForAvatarReplace() {
        $('#modalAvatarReplace')
            .modal({
                inverted: true
            })
            .modal('show')
        ;
    }

    function openModalWindowInfoFormulae() {
        $('#modalInfoFormulae')
            .modal({
                inverted: true
            })
            .modal('show')
        ;
    }

    function openModalWindowForPassReplace() {
        $('#modalPassReplace')
            .modal({
                inverted: true
            })
            .modal('show')
        ;
    }

    function openModalWindowForGroupBinding() {
        $('#modalGroupBinding')
            .modal({
                inverted: true
            })
            .modal('show')
        ;
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

    function openModalForReplacePersonalData() {
        $('#modalReplacePersonalData')
            .modal({
                inverted: true
            })
            .modal('setting', 'closable', false)
            .modal('show')
        ;
    }

    function hideModalForReplacePersonalData() {
        $('#modalReplacePersonalData')
            .modal('hide')
        ;
    }


    function openModalForSendPhysicalParameters() {
        $('#modalSendPhysicalParameters')
            .modal({
                inverted: true
            })
            .modal('setting', 'closable', false)
            .modal('show')
        ;
    }

    function hideModalForSendPhysicalParameters() {
        $('#modalSendPhysicalParameters')
            .modal('hide')
        ;
    }
</script>

<script type="text/javascript">
    google.charts.load('current', {'packages':['line']});
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChartHeightAndWeight);
    google.charts.setOnLoadCallback(drawChartState);
    google.charts.setOnLoadCallback(drawChartIndexes);

    function drawChartHeightAndWeight() {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Дата');
        data.addColumn('number', 'Вес');
        data.addColumn('number', 'Рост');

        data.addRows(<? echo json_encode($dataChartsForDrawWeightAndHeight); ?>);

        var options = {
            chart: { title: 'График изменения роста и веса студента.'},
            height: 500,
            legend: { position: 'none'}
        };

        var chart = new google.charts.Line(document.getElementById('heightAndWeight'));
        chart.draw(data, google.charts.Line.convertOptions(options));
    }

    function drawChartState() {
        var data = google.visualization.arrayToDataTable(<? echo json_encode($dataChartsForDrawStats); ?>);
        var options = {
            title: 'Состояния студента.',
            height: 500,
        };
        var chart = new google.charts.Bar(document.getElementById("stats"));
        chart.draw(data, google.charts.Bar.convertOptions(options));
    }

    function drawChartIndexes() {
        var data = google.visualization.arrayToDataTable(<? echo json_encode($dataChartsForDrawIndexes); ?>);
        var options = {
            title: 'Индексы студента.',
            height: 500,
        };
        var chart = new google.charts.Bar(document.getElementById("indexes"));
        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>
</html>