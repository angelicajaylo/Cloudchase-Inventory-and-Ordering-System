<?php
if(isset($_GET['logout']))
{
    unset($_SESSION['name']);
    unset($_SESSION['username']);
    unset($_SESSION['pass]']);
    header('Location: login.php');
}
?>