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
$id=$_GET["id"];
if(!$id)die("INVALID ID.");
if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $name=trim($_POST["name"]);
        $email=trim($_POST["email"]);
        $age=(int)($_POST["age"]);
        $stmt = $conn->prepare("UPDATE users SET name=?,email=?,age=? WHERE id=?");
        $stmt->bind_param("ssii",$name,$email,$age,$id);
        $stmt->execute();
        echo "User Updated Successfully.";
    }
$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$row=$stmt->get_result()->fetch_assoc();
?>

<html>
<head>
    <title>Edit user</title>
</head>

<body>

<form method="POST">
    <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" placeholder="Enter name..." required>
    <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" placeholder="Enter email..." required>
    <input type="number" name="age" value="<?php echo htmlspecialchars($row['age']); ?>" placeholder="Enter age..." required>
    <button type="submit">Submit</button>
</form>
<a href="search.php?msg=Recored Updated">Back to user list</a>
<a href="logout.php"><button>Logout</button></a>
</body>
</html>