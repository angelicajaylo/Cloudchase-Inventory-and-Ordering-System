<?php include_once 'db_include.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

<form method="post" action="signup.php">
    <input type="text" name="username" placeholder="Username"><br>
    <input type="password" name="password" placeholder="Password"><br>
    <input type="text" name="lastname" placeholder="Lastname"><br>
    <input type="text" name="firsname" placeholder="Firstname"><br>
    <button type="submit">Sign up</button>
</form>

<?php
    // $sql = "Select * from user_account";
    // $result = mysqli_query($conn,$sql);
    // $resultCheck = mysqli_num_rows($result);
    // if($resultCheck > 0 )
    // while ($row = mysqli_fetch_array($result))
    // {
    //     echo $row['user_id'].' '.$row['lastname'];
    // }
?>

</body>
</html>