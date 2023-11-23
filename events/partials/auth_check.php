<?php
session_start();
if (!isset($_SESSION['loggedinParticipant'])) {
header('Location: /proiect/participant/');
exit;
}
?>