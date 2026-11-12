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
$id=$_GET["id"]??null;
if(!$id)die("INVALID ID.");
$stmt = $conn->prepare("DELETE FROM users WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
echo "<p>User deleted</p>";
?>
<html>
<head>
    <title>Add new user</title>
</head>

<body>

<a href="search.php?msg=Recored deleted">Back to user list</a>

</body>
</html>