<?php
session_start();
session_destroy();
header("Location: formulaire.php?msg_login=Vous+avez+été+déconnecté.&form=login");
exit();
?>
