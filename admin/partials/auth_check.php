<?php
session_start();
if (!isset($_SESSION['loggedinOrganizator'])) {
header('Location: /proiect/admin/login');
exit;
}
?>