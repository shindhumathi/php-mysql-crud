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
$result = $conn->query("SELECT * FROM users");

if(isset($_GET["msg"]));
?>
<html>
<head>
    <title>Add new user</title>
</head>

<body>

<h2>User List</h2>

<!--<p style="color:green;"><?php echo htmlspecialchars($_GET["msg"]); ?> </p>-->
<table border="2" cellpadding="5">
    <thead><tr><th>ID</th><th>NAME</th><th>EMAIL</th><th>AGE</th><th>ACTION</th></tr></thead>
    <?php 
    if($result->num_rows>0)
        {
            while($row=$result->fetch_assoc())
                {
                    echo "<tr><td>".$row["id"]."</td>";
                    echo "<td>".$row["name"]."</td>";
                    echo "<td>".$row["email"]."</td>";
                    echo "<td>".$row["age"]."</td>";
                    echo "<td><a href='update.php?id=".$row["id"]."'>EDIT</a>
                    <a href='delete.php?id=".$row["id"]."'>DELETE</a></td></tr>";
                }
        }
        else
        {
            echo "<tr><td colspan='5'>No record</td></tr>";
        }
    ?>
</table>

<a href="create.php">Back to ADD user</a>
<a href="logout.php"><button>Logout</button></a>



</body>
</html>