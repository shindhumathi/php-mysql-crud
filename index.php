<?php
session_start();
include("db.php");
if($_SERVER["REQUEST_METHOD"]==="POST")
    {
        $stmt=$conn->prepare("SELECT id,password FROM users WHERE email=?");
        $stmt->bind_param("s",$_POST["email"]);
        $stmt->execute();
        $res = $stmt->get_result();
        if($userrow = $res->fetch_assoc())
            {
                if(password_verify($_POST["password"],$userrow["password"]))
                {
                    $_SESSION["userid"]=$userrow["id"];
                    header("Location:search.php");
                    exit;
                }
                else
                {
                    echo "Invalid Password.";
                }
            }
        else
            {
                echo "Invalid credentials.";
            }
    }

?>

<html>
<head>
    <title>Add new user</title>
</head>

<body>

<h2>User List</h2>

<form method="POST">
    <input type="email" name="email" placeholder="Enter Email..." required>
    <input type="password" name="password" placeholder="Enter Password..." required>
    <button type="submit">Login</button>
</form>

</body>
</html>