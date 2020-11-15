<?php

require $_SERVER['DOCUMENT_ROOT']."/db/db.php";

$spec_id = $_POST['id'];
$spec = R::load('specialization', $spec_id);

// при удалении специализации нужно удалить и группы
$groups = R::find('group', 'id_specialization = ?', [$spec_id]);
foreach ($groups as $group) {
    R::trash($group);
}

R::trash($spec);

?>