<?php

require $_SERVER['DOCUMENT_ROOT']."/db/db.php";

$group_id = $_POST['id'];
$group = R::load('group', $group_id);
R::trash($group);

?>