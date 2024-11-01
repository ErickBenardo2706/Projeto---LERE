<?php
session_start();
session_unset();
session_destroy();
header("Location: pag_inicial_US.php");
exit();
