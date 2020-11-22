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

    $link = null;

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
