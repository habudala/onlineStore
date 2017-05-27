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
<!-- ///////////////////////////////////////////////////////////////////////////// -->
<?php
// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors','1');
?>
<!-- /////////////////////////////////////////////////////////////////////////////// -->
<?php
// delete item? question to admin and delete product if they choose
if(isset($_GET['deleteid'])) {
	echo "Do you really want to delete product with ID of " . $_GET['deleteid'] . "? <a href='inventory_list.php?yesdelete=" .$_GET['deleteid'] . "'>Yes</a> | <a href='inventory_list.php'> No </a> ";
	exit();
}

if(isset($_GET['yesdelete'])) {
	// remove items from system and delete its picture
	//delete from database
	$id_to_delete = $_GET['yesdelete'];
	mysqli_query($connection,"DELETE FROM products WHERE id = '$id_to_delete' LIMIT 1") or die(mysql_error());
	// unlink the image from server
	$pictodelete = ("../inventory_images/$id_to_delete.jpg");
	if(file_exists($pictodelete)) {
		unlink($pictodelete);
	}

	 header("location: inventory_list.php"); 
	exit();
}



?>
<!-- /////////////////////////////////////////////////////////////////////////////// -->
<?php
// parse form data and adds inventory to the system
if(isset($_POST["product_name"])) {

	$product_name = mysqli_escape_string($connection, $_POST["product_name"]);
	$price = mysqli_escape_string($connection, $_POST["product_price"]);
	$category = mysqli_escape_string($connection, $_POST["product_category"]);
	$subcategory = mysqli_escape_string($connection, $_POST["product_sub"]);
	$details = mysqli_escape_string($connection, $_POST["product_desc"]);
	// see if that product name is an identical match to another product in the system
	$sql = "SELECT id FROM products WHERE product_name = '$product_name' LIMIT 1";
	$result = mysqli_query($connection, $sql);
	$productMatch = mysqli_num_rows($result); // count the output amount
	if($productMatch > 0) {
		echo 'Sorry, you tried to place a duplicate "Product Name" into the system, <a href="inventory_list.php">click here</a>';
		exit();
	}
	// Add this product into database now
	
	mysqli_query($connection,"INSERT INTO products (product_name,price,details,category,subcategory,date_added) VALUES('$product_name','$price','$details','$category','$subcategory',now())") or die(mysql_error());

	$prodId = mysqli_insert_id($connection);
	// Place image in folder
	 $newName = "$prodId.jpg";
	 move_uploaded_file($_FILES["product_img"]["tmp_name"],"../inventory_images/$newName");

	 header("location: inventory_list.php"); // so if i refresh, it wont try to re-add item
	exit();

}
?>
<!-- /////////////////////////////////////////////////////////////////////////////// -->
<?php
// this block grabs the whole list for viewing
$product_list = ""; // initializing variable
$sql = "SELECT * FROM products ORDER BY date_added DESC";
$result = mysqli_query($connection, $sql);
$productCount = mysqli_num_rows($result); // counting the output amount

if($productCount > 0) {
	while($row = mysqli_fetch_array($result)) {
		$id = $row["id"];
		$product_name = $row["product_name"];
		$date_added = strftime("%b %d %Y", strtotime($row["date_added"]));
		$product_list.= "&bull; &nbsp;  $date_added - $id - $product_name &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href='inventory_edit.php?pid=$id'>edit</a> &bull; <a href='inventory_list.php?deleteid=$id'>delete</a><br/>";
	}

}else{
	$product_list = "You have no products in the system";
}

?>
<!-- ///////////////////////////////////////////////////////////////////////////////// -->
<!DOCTYPE html>
<html>
<head>
	<title>Inventory List</title>
	<link rel="stylesheet" type="text/css" href="../styles/style.css">
</head>
<body>
	<div id="mainWrapper">
		<?php include_once("../template_header.php"); ?>
		<div id="pageContent">
			<div id="addInventory">
				<a href="inventory_list.php#inventoryForm"> &darr;+ Add New Inventory Item &darr;</a>
			</div>
			<div>
				<h2>Inventory list</h2>
				<?php echo "$product_list"; ?>
			</div>
			<div id="InvFormCont">
				<a name="inventoryForm"></a>
				<form action="inventory_list.php" enctype="multipart/form-data" name="myForm" id="myForm" method="post">
					<table id="myTable" width="50%">
						<tr>
							<td width="30%">Product Name</td>
							<td width="70%">
								<input name="product_name" type="text" id="product_name" size="64" /> 
							</td>
						</tr>
						<tr>
							<td width="30%">Product Price</td>
							<td width="70%">
							$
							<input name="product_price" type="text" id="price" size="12" />
							</td>
						</tr>
						<tr>
							<td width="30%">Category</td>
							<td width="70%">
							<select name="product_category"  id="category"> 
								<option value="clothing">Clothing</option>
								<option value="electronics">Electronics</option>
								<!-- <option value="food">Food</option> -->
							</select>
							</td>
						</tr>
						<tr>
							<td width="30%">Subcategory</td>
							<td width="70%">
							<select name="product_sub"  id="subCat"> 
								<option value="hats">Hats</option>
								<option value="jackets">Jackets</option>
								<option value="footwear">Footwear</option>
							</select>
							</td>
						</tr>
						<tr>
							<td width="30%">Product Details</td>
							<td width="70%">
							<textarea name="product_desc" type="text" id="product_desc" rows="5"></textarea>
							</td>
						</tr>
						<tr>
							<td width="30%">Product Image</td>
							<td width="70%">
							<input name="product_img" type="file" id="product_img"  />
							</td>
						</tr>
						<tr>
							<td width="30%"></td>
							<td width="70%"><input name="submit" type="submit" id="submit" value="Add this Item"  /></td>
						</tr>
					</table>
				</form>
			</div>
			<a href="phpinfo.php">php info</a>

		</div>	
		<div id="pageFooter">
			<?php include_once("../template_footer.php"); ?>
		</div>	
	</div>
</body>
</html>
<?php mysqli_close($connection);?>