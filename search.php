<?php
session_start();
include("db.php");

if(isset($_SESSION["userid"]))
    {
        echo "Welcome".$_SESSION["userid"].".";
    }
else
    {
        header("Location:index.php");
    }
if(isset($_GET["msg"]));
$search = $_GET["search"] ?? "";

$limit = 10;
$page = $_GET["page"]??1;
$offset_start = ($page-1)*$limit;

$sql = "SELECT * FROM users WHERE name LIKE ? OR email LIKE ? LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$searchval = "%$search%";
$stmt->bind_param("ssii",$searchval,$searchval,$limit,$offset_start);
$stmt->execute();
$result = $stmt->get_result();

$totalrows = $conn->query("SELECT COUNT(*) AS total FROM users");
$toatalrow = $totalrows->fetch_assoc()['total'];
$noofpages = ceil($toatalrow/$limit);

?>
<html>
<head>
    <title>Add new user</title>
</head>

<body>

<h2>User List</h2>
<!--<p style="color:green;"><?php echo htmlspecialchars($_GET["msg"]); ?> </p>-->
<form method="GET">
    <input type="text" name="search" placeholder="Search Name or Email">
    <button type="submit">Search</button>
</form>
<table border="2" cellpadding="5">
    <thead><tr><th>ID</th><th>NAME</th><th>EMAIL</th><th>AGE</th><th>ACTION</th></tr></thead>
    <?php 
    if($result->num_rows>0)
        {
            while($row=$result->fetch_assoc())
                {
                    echo "<tr><td>".htmlspecialchars($row["id"])."</td>";
                    echo "<td>".htmlspecialchars($row["name"])."</td>";
                    echo "<td>".htmlspecialchars($row["email"])."</td>";
                    echo "<td>".htmlspecialchars($row["age"])."</td>";
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
<br>
<a href="create.php"><button>Back to ADD user</button></a>

<a href="logout.php"><button>Logout</button></a>
<br><br>

<?php for($i=1;$i<=$noofpages;$i++)
{
    echo "<a href='search.php?page=".$i."'>".$i."</a>";
}
?>
</body>
</html>