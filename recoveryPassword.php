<?php
require $_SERVER['DOCUMENT_ROOT']."/db/db.php";

$recoveryPassword = R::findOne('recovery', 'id_person = ? AND recovery_key = ?', [$_GET['person'], $_GET['key']]);


if($recoveryPassword != null) {
    $person = R::load('person', $recoveryPassword->id_person);
    $person->password = $recoveryPassword->password;
    R::store($person);
    R::trash($recoveryPassword);
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
    <title>Восстановление пароля</title>
</head>
<body style="
        background-image: url(/images/bg.jpg);
        display: flex;
        justify-content: center;
        align-items: center">

<? if($recoveryPassword != null) {?>

<div class="ui segment big">
    <h2 class="ui icon header">
        <i class="check icon green"></i>
        <div class="content" style="color: #db2828">Восстановление пароля
            <div class="sub header" style="margin-top: 10px">
                Ваш пароль успешно изменился на указанный в почте. Войдите в личный кабинет и смените его на тот, который вам будет легко запомнить!
            </div>
        </div>
    </h2>
</div>

<? } else { ?>
    <div class="ui segment big">
        <h2 class="ui icon header">
            <i class="close icon red"></i>
            <div class="content" style="color: #db2828">Восстановление пароля
                <div class="sub header">
                    Ссылка неверная или уже не существует!
                </div>
            </div>
        </h2>
    </div>

<? } ?>
</body>
</html>
