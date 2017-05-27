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

<!-- /////////////////////////////////////////////////////////////////////////////// -->
<?php
// parse form data and adds inventory to the system
if(isset($_POST["product_name"])) {

	$prodId = mysqli_escape_string($connection, $_POST["thisID"]);
	$product_name = mysqli_escape_string($connection, $_POST["product_name"]);
	$price = mysqli_escape_string($connection, $_POST["product_price"]);
	$category = mysqli_escape_string($connection, $_POST["product_category"]);
	$subcategory = mysqli_escape_string($connection, $_POST["product_sub"]);
	$details = mysqli_escape_string($connection, $_POST["product_desc"]);
	// see if that product name is an identical match to another product in the system
	$sql = "UPDATE products SET product_name = '$product_name', price ='$price', category ='$category', subcategory ='$subcategory', details ='$details' WHERE id = '$prodId' ";
	$result = mysqli_query($connection, $sql);
	

	if($_FILES["product_img"]["tmp_name"] != "") {
		// Place image in folder
		 $newName = "$prodId.jpg";
		 move_uploaded_file($_FILES["product_img"]["tmp_name"],"../inventory_images/$newName");
	}

	header("location: inventory_list.php"); // so if i refresh, it wont try to re-add item
	exit();
}
?>
<!-- /////////////////////////////////////////////////////////////////////////////// -->
<?php
// Gather this product's full information for inserting automtically int othe edit form below


if(isset($_GET['pid'])) {
	$targetId = $_GET['pid'];
	$sql = "SELECT * FROM products WHERE id = '$targetId' LIMIT 1";
	$result = mysqli_query($connection, $sql);
	$productCount = mysqli_num_rows($result); // counting the output amount

	if($productCount > 0) {
		while($row = mysqli_fetch_array($result)) {
			$id = $row["id"];
			$product_name = $row["product_name"];
			$price = $row["price"];
			$category = $row["category"];
			$subcategory = $row["subcategory"];
			$details = $row["details"];
			$date_added = strftime("%b %d %Y", strtotime($row["date_added"]));
			
		}

	}else{
		echo "Sorry man, it doesn't exist";
		exit();
	}
	}



?>
<!-- ///////////////////////////////////////////////////////////////////////////////// -->
<!DOCTYPE html>
<html>
<head>
	<title>Inventory Edit</title>
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
			</div>
			<div id="InvFormCont">
				<a name="inventoryForm"></a>
				<form action="inventory_edit.php" enctype="multipart/form-data" name="myForm" id="myForm" method="post">
					<table id="myTable" width="50%">
						<tr>
							<td width="30%">Product Name</td>
							<td width="70%">
								<input name="product_name" type="text" id="product_name" size="64" value="<?php echo $product_name?>" /> 
							</td>
						</tr>
						<tr>
							<td width="30%">Product Price</td>
							<td width="70%">
							$
							<input name="product_price" type="text" id="price" size="12" value="<?php echo $price?>" />
							</td>
						</tr>
						<tr>
							<td width="30%">Category</td>
							<td width="70%">
							<select name="product_category"  id="category"> 
								<option value="<?php echo $category;?>"><?php echo $category;?></option>
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
								<option value="<?php echo $subcategory;?>"><?php echo $subcategory;?></option>
								<option value="hats">hats</option>
								<option value="jackets">jackets</option>
								<option value="footwear">footwear</option>
							</select>
							</td>
						</tr>
						<tr>
							<td width="30%">Product Details</td>
							<td width="70%">
							<textarea name="product_desc" type="text" id="product_desc" rows="5">
								<?php echo $details;?>
							</textarea>
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
							<td width="70%">
							<input name="thisID" type="hidden"  value="<?php echo $targetId; ?>"  />
							<input name="submit" type="submit" id="submit" value="Update this Item"  /></td>
						</tr>
					</table>
				</form>
			</div>

		</div>	
		<div id="pageFooter">
			<?php include_once("../template_footer.php"); ?>
		</div>	
	</div>
</body>
</html>
<?php mysqli_close($connection);?>