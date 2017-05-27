<!-- ///////////////////////////////////////////////////////////////////////////// -->
<?php
// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors','1');
?>
<!-- ///////////////////////////////////////////////////////////////////////////// -->
<?php
// Check to see is the URL variable is set and if it exists in db
if(isset($_GET['id'])) {
	$id = $_GET['id'];
	//cleansing variable so people can't type in anything in the URL
	$id = preg_replace('#[^0-9]#i','',$_GET['id']);
} else {
	echo "No product in the system with that ID";
}
?>
<!-- ///////////////////////////////////////////////////////////////////////////// -->
<?php
// Run a SELECT query in MySQL to get the last 6 items
// Connect to MySQL DB
include "storeScripts/connect_to_mysql.php";
// this block grabs the whole list for viewing
$dynamicList = ""; // initializing variable
$sql = "SELECT * FROM products ORDER BY date_added DESC LIMIT 6";
$result = mysqli_query($connection, $sql);
$productCount = mysqli_num_rows($result); // counting the output amount

if($productCount > 0) {
	while($row = mysqli_fetch_array($result)) {
		$id = $row["id"];
		$price = $row["price"];
		$product_name = $row["product_name"];
		$date_added = strftime("%b %d %Y", strtotime($row["date_added"]));
		$dynamicList.= '<table id="featured" width="100%">
					<tr>
						<td width="25%">
							<a href="product.php?id=' . $id . '">
								<img id="prodImg" src="inventory_images/' . $id . '.jpg"/>
							</a>
						</td>
						<td width="75%" valigh="top">' . $product_name . '
						<br/>
						$' . $price . '<br/>
						<a href="product.php?id=' . $id . '">View Product</a><br/>
						</td>
					</tr>
				</table>';

		/*&bull; &nbsp;  $date_added - $id - $product_name &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href='inventory_edit.php?pid=$id'>edit</a> &bull; <a href='inventory_list.php?deleteid=$id'>delete</a><br/>"*/
	}

}else{
	$dynamicList = "You have no products in the system";
}




// CLOSE DB CONNECTION
mysqli_close($connection);
?>
<!DOCTYPE html>
<html>
<head>
	<title>$dynamicTitle</title>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
</head>
<body>
	<div id="mainWrapper">
		<?php include_once("template_header.php"); ?>
		<div id="pageContent">
			<div id=welcome>
				<h1>Welcome to NOMAD Online Store</h1>
			</div>
			<div class="sideBar" id="mainCol1">
				<h3>Dummy Title of a Paragraph 1</h3>
				<p>Lorem ipsum dolor sit amet, his ne decore utamur nonumes, sit te solum nostrum. In equidem disputando dissentiet eum, probo inani aliquando eos et. No vel meis tamquam delicata, et sit laoreet singulis partiendo. Ei vim dicam maiorum copiosae, sit omnium nostrud veritus ad.
				</p>
				<a href="#">Learn more  >>></a>
				<h3>Dummy Title of a Paragraph 2</h3>
				<p>Lorem ipsum dolor sit amet, his ne decore utamur nonumes, sit te solum nostrum. In equidem disputando dissentiet eum, probo inani aliquando eos et. No vel meis tamquam delicata, et sit laoreet singulis partiendo. Ei vim dicam maiorum copiosae, sit omnium nostrud veritus ad.
				</p>
				<a href="#">Learn more  >>></a>
				<h3>Dummy Title of a Paragraph 3</h3>
				<p>Lorem ipsum dolor sit amet, his ne decore utamur nonumes, sit te solum nostrum. In equidem disputando dissentiet eum, probo inani aliquando eos et. No vel meis tamquam delicata, et sit laoreet singulis partiendo. Ei vim dicam maiorum copiosae, sit omnium nostrud veritus ad.
				</p>
				<a href="#">Learn more  >>></a>
				<h3>Dummy Title of a Paragraph 4</h3>
				<p>Lorem ipsum dolor sit amet, his ne decore utamur nonumes, sit te solum nostrum. In equidem disputando dissentiet eum, probo inani aliquando eos et. No vel meis tamquam delicata, et sit laoreet singulis partiendo. Ei vim dicam maiorum copiosae, sit omnium nostrud veritus ad.
				</p>
				<a href="#">Learn more  >>></a>
				<h3>Dummy Title of a Paragraph 5</h3>
				<p>Lorem ipsum dolor sit amet, his ne decore utamur nonumes, sit te solum nostrum. In equidem disputando dissentiet eum, probo inani aliquando eos et. No vel meis tamquam delicata, et sit laoreet singulis partiendo. Ei vim dicam maiorum copiosae, sit omnium nostrud veritus ad.
				</p>
				<a href="#">Learn more  >>></a>
			</div>
			<div class="sideBar" id="mainCol2">
				<br/>
				<h3>Dummy Title of a Paragraph 6</h3>
				<p>Lorem ipsum dolor sit amet, his ne decore utamur nonumes, sit te solum nostrum. In equidem disputando dissentiet eum, probo inani aliquando eos et. No vel meis tamquam delicata, et sit laoreet singulis partiendo. Ei vim dicam maiorum copiosae, sit omnium nostrud veritus ad.
				</p>
				<a href="#">Learn more  >>></a>
				<h3>Dummy Title of a Paragraph 7</h3>
				<p>Lorem ipsum dolor sit amet, his ne decore utamur nonumes, sit te solum nostrum. In equidem disputando dissentiet eum, probo inani aliquando eos et. No vel meis tamquam delicata, et sit laoreet singulis partiendo. Ei vim dicam maiorum copiosae, sit omnium nostrud veritus ad.
				</p>
				<a href="#">Learn more  >>></a>
				<h3>Dummy Title of a Paragraph 8</h3>
				<p>Lorem ipsum dolor sit amet, his ne decore utamur nonumes, sit te solum nostrum. In equidem disputando dissentiet eum, probo inani aliquando eos et. No vel meis tamquam delicata, et sit laoreet singulis partiendo. Ei vim dicam maiorum copiosae, sit omnium nostrud veritus ad.
				</p>
				<a href="#">Learn more  >>></a>
				<h3>Dummy Title of a Paragraph 9</h3>
				<p>Lorem ipsum dolor sit amet, his ne decore utamur nonumes, sit te solum nostrum. In equidem disputando dissentiet eum, probo inani aliquando eos et. No vel meis tamquam delicata, et sit laoreet singulis partiendo. Ei vim dicam maiorum copiosae, sit omnium nostrud veritus ad.
				</p>
				<a href="#">Learn more  >>></a>
				<h3>Dummy Title of a Paragraph 10</h3>
				<p>Lorem ipsum dolor sit amet, his ne decore utamur nonumes, sit te solum nostrum. In equidem disputando dissentiet eum, probo inani aliquando eos et. No vel meis tamquam delicata, et sit laoreet singulis partiendo. Ei vim dicam maiorum copiosae, sit omnium nostrud veritus ad.
				</p>
				<a href="#">Learn more  >>></a>
			</div>
			<div id="mainCol">
				<h2>Our Newest Items</h2>
				<?php echo $dynamicList;?>
			<!-- 	<table width="100%" border="0" cellspacing="0" cellpadding="3">
					<tr>
						<td width="25">
							<a href="product.php?">
								<img src=""/>
							</a>
						</td>
						<td width="75%" valigh="top">
						Product Title<br/>
						Product Price<br/>
						<a href="product.php?">View Product</a><br/>
						</td>
					</tr>
				</table> -->
			</div><!-- mainCol ENDING-->
		</div>	
		<div id="pageFooter">
			<?php include_once("template_footer.php"); ?>
		</div>	
	</div>
</body>
</html>