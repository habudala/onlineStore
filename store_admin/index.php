<?php
ob_start();
session_start();

if(!isset($_SESSION["manager"])) {
	header("location: admin_login.php");
	exit();
}


// Be sure to check that this SESSION value is in fact in the DB
$managerID = preg_replace('#[^0-9]#i','',$_SESSION["id"]); // Filter everything but numbers and letters
$manager = preg_replace('#[^A-Za-z0-9]#i','',$_SESSION["manager"]);  // Filter everything but numbers and letters
$password = preg_replace('#[^A-Za-z0-9]#i','',$_SESSION["password"]);   // Filter everything but numbers and letters
//Run MySQL query to be sure that this person is an admin and that their password SESSION id is the same as the one in DB
// Connect to MySQL DB
include "../storeScripts/connect_to_mysql.php";

$sql= "SELECT * FROM admin WHERE id = '$managerID' AND username ='$manager' AND password ='$password' LIMIT 1";
$result = mysqli_query($connection, $sql);
// Query he person, to make sure they exist
$existCount = mysqli_num_rows($result);// count the row numbers
if ($existCount == 0) {
	//evaluate the count
	// header("location:../index.php");
	echo "Your login session data did not match our records. Sorry!";
	exit();
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Store Admin Area</title>
	<link rel="stylesheet" type="text/css" href="../styles/style.css">
</head>
<body>
	<div id="mainWrapper">
		<?php include_once("../template_header.php"); ?>
		<div id="pageContent">
			<div id="adminNav">
				<h1>Hello store manager! What would you like to do today?</h1>
				<ul>
					<a href="inventory_list.php"><li>Manage Inventory</li></a>
					<a href="#"><li>Manage X</li></a>
					<a href="#"><li>Manage Y</li></a>
					<a href="#"><li>Manage Z</li></a>
				</ul>
			</div>
		</div>	
		<div id="pageFooter">
			<?php include_once("../template_footer.php"); ?>
		</div>	
	</div>
</body>
</html>
<?php mysqli_close($connection);?>