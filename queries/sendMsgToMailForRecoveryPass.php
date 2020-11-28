<?php
require $_SERVER['DOCUMENT_ROOT']."/db/db.php";

if(R::count('person', 'email = ? AND login = ?', [$_POST['person_mail'], $_POST['person_login']]) > 0) {
    $password = implode('', str_split(
        substr(
            strtolower(
                md5(microtime().rand(1, 9999))
            ), 0, 12
        ), 1
    ));

    $key = md5(microtime());
    $person = R::findOne('person', 'email = ? AND login = ?', [$_POST['person_mail'], $_POST['person_login']]);


    $recovery = R::findOne('recovery', 'id_person = ?', [$person->id]);

    if(count($recovery) == 0) {
        $recoveryNew = R::dispense('recovery');
        $recoveryNew->id_person = $person->id;
        $recoveryNew->password = password_hash($password, PASSWORD_DEFAULT);
        $recoveryNew->recovery_key = $key;
        R::store($recoveryNew);
    } else {
        $recovery->id_person = $person->id;
        $recovery->password = password_hash($password, PASSWORD_DEFAULT);
        $recovery->recovery_key = $key;
        R::store($recovery);
    }



    $link = $_SERVER['HTTP_HOST']."/recoveryPassword.php?person=".$person->id."&key=".$key;

    $headers  = "Content-type: text/html; charset=windows-1251 \r\n";
    $headers .= "From: help@heartblaze.online\r\n";
    $headers .= "Reply-To: help@heartblaze.online\r\n";

    $message = 'Здравствуйте, '.$_POST['person_login']."! \r\n";
    $message .= 'Вы отправили запрос на смену пароля. Ваш новый пароль: '.$password."\r\n";
    $message .= 'Перейдите по следующей ссылке, чтобы подтвердить его смену: '.$link;

    mail($_POST['person_mail'], 'Восстановление пароля', $message, $headers);

} else {
    die(header("HTTP/1.0 400 Bad Request"));
}

?>
