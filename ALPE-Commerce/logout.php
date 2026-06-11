<?php
session_start();
// hapusin semua data session
session_unset();
session_destroy();

header("Location: login.php");
exit;
?>