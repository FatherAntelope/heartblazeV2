<?php
require $_SERVER['DOCUMENT_ROOT']."/db/db.php";
try {
    if (count($_FILES) > 0) {
        $person = R::load('person', $_POST['person_id']);
        $imgData = file_get_contents($_FILES['person_photo']['tmp_name']);
        $search =  ["\\",   "\x00", "\n",  "\r",  "'",  '"', "\x1a"];
        $replace = ["\\\\", "\\0",  "\\n", "\\r", "\'", '\"', "\\Z"];
        $changedData = str_replace($search, $replace, $imgData);
        $sql = sprintf("UPDATE person SET photo = '%s' WHERE person.id='%s'",$changedData, $_POST['person_id']);
        R::exec($sql);
    }
} catch (Exception $ex) {
    die(header("HTTP/1.1 401 Unauthorized "));
}
?>