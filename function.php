<?php
include 'db_include.php';
 function register_cust(){
 $sql = "INSERT INTO `user_account` (`user_id`, `username`, `password`, `lastname`, `firstname`, `role`, `status`, `birthdate`, `address`, `contact_num`) VALUES (NULL, '$_POST[username]', '$_POST[password]', '$_POST[lname]', '$_POST[fname]', 'Customer', 'Active', '$_POST[bday]', '$_POST[add]', '$_POST[cp_num]');";
 $result = mysqli_query($conn,$sql);
 header("Location: login.php?login=regsuccess");
}
?>