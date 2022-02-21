<?php
include_once 'db_include.php';

$username = $_POST['username'];
$password = $_POST['password'];
$lastname = $_POST['lastname'];
$firstname = $_POST['firstname'];
$sql = "INSERT INTO `user_account` (`user_id`, `username`, `password`, `lastname`, `firstname`, `role`, `status`) VALUES (NULL, '$username', '$password', '$lastname', '$firstname', '', '');";
mysqli_query($conn,$sql);

header("Location: index.php?signup=success");
?>