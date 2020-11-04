<?php
//проверка доступа к личному кабинету и существование учетной записи, если доступ к нему есть
function getDataIsAuthAndEmptyPerson($isRole) {
    if($_COOKIE['person_role'] === $isRole) {
        require $_SERVER['DOCUMENT_ROOT']."/db/db.php";
        $person = R::load('person', $_COOKIE['person_ID']);
        if(count($person) <= 1) {
            setcookie('person_role',   '', time() - (60*60*24*30), "/");
            setcookie('person_ID',   '', time() - (60*60*24*30), "/");
            header("Location: /");
        }
        return $person;
    } else {
        die(header("HTTP/1.1 401 Unauthorized "));
    }
}

function getIndexQuetelet($quetelet) {
    if($quetelet > 35)
        return "Ожирение";
    elseif ($quetelet > 30 && $quetelet <= 35)
        return "Повышенный";
    elseif ($quetelet > 25 && $quetelet <= 30)
        return "Нормальный";
    elseif ($quetelet > 18.5 && $quetelet <= 25)
        return "Пониженный";
    else
        return "Истощение";
}

function getOrthostaticProbe($orthostatic) {
    if($orthostatic > 30)
        return "Заболевание";
    elseif ($orthostatic > 25 && $orthostatic <= 30)
        return "Выраженное утомление";
    elseif ($orthostatic > 19 && $orthostatic <= 25)
        return "Среднее утомление";
    elseif ($orthostatic > 13 && $orthostatic <= 19)
        return "Легкое утомление";
    else
        return "Хорошее состояние";
}

function getRuffierProbe($ruffier) {
    if($ruffier > 15)
        return "Сердечная недостаточность высшей степени";
    elseif ($ruffier > 10 && $ruffier <= 15)
        return "Сердечная недостаточность средней степени";
    elseif ($ruffier > 5 && $ruffier <= 10)
        return "Хорошее сердце";
    else
        return "Отличное сердце";
}

function getStangeProbe($stange) {
    if($stange > 85)
        return "Отлично";
    elseif ($stange > 60 && $stange <= 85)
        return "Хорошо";
    elseif ($stange > 45 && $stange <= 60)
        return "Удовлетворительно";
    else
        return "Неудовлетворительно";
}

function getTappingTest($countTapping) {
    $countTapping /= 30;
    if($countTapping > 7.5)
        return "Отлично";
    elseif ($countTapping > 7 && $countTapping <= 7.5)
        return "Хорошо";
    elseif ($countTapping > 5.8 && $countTapping <= 7)
        return "Нормально";
    elseif ($countTapping > 5.2 && $countTapping <= 5.8)
        return "Удовлетворительно";
    else
        return "Неудовлетворительно";
}

?>