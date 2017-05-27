<?php
ob_start();
session_start();

if(isset($_SESSION["manager"])) {
	header("location:index.php");
	exit();
}
// Be sure to check that this manager SESSION value is in fact in the database
?>

<?php
	// Parse the log in form if the user has filled out and pressed "log in"
	if(isset($_POST["username"]) && isset($_POST["password"]))  {


			// Be sure to check that this SESSION value is in fact in the DB
		$manager = preg_replace('#[^A-Za-z0-9]#i','',$_POST["username"]);  // Filter everything but numbers and letters
		$password = preg_replace('#[^A-Za-z0-9]#i','',$_POST["password"]);   // Filter everything but numbers and letters
		//Run MySQL query to be sure that this person is an admin and that their password SESSION id is the same as the one in DB
		// Connect to MySQL DB
		include "../storeScripts/connect_to_mysql.php";

		$sql= "SELECT id FROM admin WHERE username = '$manager'  AND password ='$password' LIMIT 1";
		$result = mysqli_query($connection, $sql);
		// Query he person, to make sure they exist
		$existCount = mysqli_num_rows($result);// count the row numbers
		if ($existCount == 1) {
			//evaluate the count
			while($row = mysqli_fetch_array($result)) {
				$id=$row["id"];
			}


		$_SESSION["id"] = $id;
		$_SESSION["manager"] = $manager;
		$_SESSION["password"] = $password;
		header("location:index.php");
		exit();
			
		} else {
		// echo 'That information is incorrect, try again <a href="index.php">Click here</a>';
			
		exit();

	} 
	}
?>

<?php
?>
<!DOCTYPE html>
<html>
<head>
	<title>Store Home Page</title>
	<link rel="stylesheet" type="text/css" href="../styles/style.css">
</head>
<body>
	<div id="mainWrapper">
		<?php include_once("../template_header.php"); ?>
		<div id="pageContent">
			<div id="adminLogin">
				<h2>Please log in</h2>
				<form id="form1" name="form1" method="post" action="admin_login.php">
					User Name: <br/> <input name="username" id="username" size="40"type="text" /><br/>
					Password: <br/> <input name="password" id="password" size="40"type="password" />
					<br/>
					<br/>
					<input type="submit" name="button" id="button" value="Log In"/>

				</form>
			</div>
		</div>	
		<div id="pageFooter">
			<?php include_once("../template_footer.php"); ?>
		</div>	
	</div>
</body>
</html>