<?php

setcookie('userID', '', time() - 3600, "/");
setcookie('role',   '', time() - 3600, "/");

header("Location: http://".$_SERVER['HTTP_HOST']);

?>