<?php
// Created by Laszlo Habuda www.lhdigitals.net
/*
1: "Die will exit the script and show an error statement if something is wrong with the "A"
2: "A mysql_connect() error usually mean your username/passowrd are wrong.""
3: "A mysql_select_db() error usually means the database does not exist."
*/


//Place db host name. Sometimes "localhost" but 
//sometimes looks like this >>   ???mysql??.someserver.net
$db_host = "localhost";
//place the username for the MySQL database here
$db_username = "habudala_builder";
//place the password for the MySQL database here
$db_pass = "guest";
//place the name of the MySQL database here
$db_name = "habudala_mystore";


//Run the actual connection here
$connection = mysqli_connect($db_host,$db_username,$db_pass,$db_name);



if(mysqli_connect_errno()) {
	die ("Database connection failed: " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")");
}



?>