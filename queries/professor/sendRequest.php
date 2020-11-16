<?php
require $_SERVER['DOCUMENT_ROOT']."/db/db.php";
try {
    if (count($_FILES) > 0) {
        $request = R::load('request', $_POST['person_id']);
        $imgData = file_get_contents($_FILES['professor_certificate']['tmp_name']);
        $search =  ["\\",   "\x00", "\n",  "\r",  "'",  '"', "\x1a"];
        $replace = ["\\\\", "\\0",  "\\n", "\\r", "\'", '\"', "\\Z"];
        $changedData = str_replace($search, $replace, $imgData);
        $sql = sprintf("INSERT INTO `request` (`id`, `id_professor`, `certificate`) VALUES (NULL, '%s' , '%s')",$_POST['professor_id'], $changedData);
        R::exec($sql);

        $professor = R::load('professor', $_POST['professor_id']);
        $professor->status = 2;
        R::store($professor);
    }
} catch (Exception $ex) {
    die(header("HTTP/1.1 401 Unauthorized "));
}
?>