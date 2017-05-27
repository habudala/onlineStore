<!-- ///////////////////////////////////////////////////////////////////////////// -->
<?php
// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors','1');
?>
<!-- ///////////////////////////////////////////////////////////////////////////// -->
<?php
// Connect to MySQL DB
include "storeScripts/connect_to_mysql.php";


// Check to see is the URL variable is set and if it exists in db
if(isset($_GET['id'])) {
	$id = $_GET['id'];
	//cleansing variable so people can't type in anything in the URL
	$id = preg_replace('#[^0-9]#i','',$_GET['id']);
	// Use this variable to check if ID exists, and if so, get the product details
	//IF no, the exits with a message.
	$sql = "SELECT * FROM products WHERE id = '$id' LIMIT 1";
	$result = mysqli_query($connection, $sql);
	$productCount = mysqli_num_rows($result); // counting the output amount
	if($productCount > 0) {
		// get all product details
		while($row = mysqli_fetch_array($result)) {

			$product_name = $row["product_name"];
			$price = $row["price"];
			$category = $row["category"];
			$subategory = $row["subcategory"];
			$details = $row["details"];
			$date_added = strftime("%b %d %Y", strtotime($row["date_added"]));
		}
	} else {
		echo "This item does not exist";
	}
} else {
	echo "No data available to render this page... Sorry!";
	exit();
}






// CLOSE DB CONNECTION
mysqli_close($connection);
?>
<!-- ///////////////////////////////////////////////////////////////////////////// -->

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $product_name; ?></title>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
</head>
<body>
	<div id="mainWrapper">
		<?php include_once("template_header.php"); ?>
		<div id="pageContent">
			<div id=welcome>
				<h1>Welcome to NOMAD Online Store</h1>
			</div>
			<div id="mainCont">
				<h2>Product Page</h2>
				<table width="100%">
					<tr>
						<td width="25">
							<a href="product.php?">
								<img src="inventory_images/<?php echo $id; ?>.jpg"/>
							</a>
						</td>
						<td width="75%" valigh="top">
						Product Title<br/>
						Product Price<br/>
						<a href="product.php?">View Product</a><br/>
						</td>
					</tr>
				</table>
			</div><!-- mainCont ENDING-->
			<div  id="sideCol">
				<h3>Dummy Title of a Paragraph 1</h3>
				<p>Lorem ipsum dolor sit amet, his ne decore utamur nonumes, sit te solum nostrum. In equidem disputando dissentiet eum, probo inani aliquando eos et. No vel meis tamquam delicata, et sit laoreet singulis partiendo. Ei vim dicam maiorum copiosae, sit omnium nostrud veritus ad.
				</p>
				<a href="#">Learn more  >>></a>
				<h3>Dummy Title of a Paragraph 2</h3>
				<p>Lorem ipsum dolor sit amet, his ne decore utamur nonumes, sit te solum nostrum. In equidem disputando dissentiet eum, probo inani aliquando eos et. No vel meis tamquam delicata, et sit laoreet singulis partiendo. Ei vim dicam maiorum copiosae, sit omnium nostrud veritus ad.
				</p>
				<a href="#">Learn more  >>></a>
			
				
			</div>
			
		</div>	
		<div id="pageFooter">
			<?php include_once("template_footer.php"); ?>
		</div>	
	</div>
</body>
</html>