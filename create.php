<?php
session_start();
include("db.php");
if(isset($_SESSION["userid"]))
    {
        echo "Welcome". $_SESSION["userid"].".";
    }
else
    {
        header("Location:index.php");
    }
if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if(!filter_var($email,FILTER_VALIDATE_EMAIL))
            {
                die("Invalid Email.");
            }
        if(age<0 || age>120)
            {
                die("Not valid age");
            }
        $name=trim($_POST["name"]);
        $email=trim($_POST["email"]);
        $age=(int)($_POST["age"]);
        $pass=password_hash($_POST["password"],PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users(name,email,age,password) VALUES(?,?,?,?)");
        $stmt->bind_param("ssis",$name,$email,$age,$pass);
        $stmt->execute();
        header("Location:search.php?msg=useradded");
    }
?>
<html>
<head>
    <title>Add new user</title>
</head>

<body>

<form method="POST">
    <input type="text" name="name" placeholder="Enter name..." required>
    <input type="email" name="email" placeholder="Enter email..." required>
    <input type="number" name="age" placeholder="Enter age..." required>
    <input type="password" name="password" placeholder="Enter password..." required>
    <button type="submit">Submit</button>
</form>
<a href="read.php?msg=Recored created">Back to user list</a>
<a href="logout.php"><button>Logout</button></a>
</body>
</html>