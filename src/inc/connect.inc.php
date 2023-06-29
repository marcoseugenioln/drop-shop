<?php 
	$con = mysqli_connect("localhost","root","", "store") or die("Couldn't connect to SQL server");

	function connect() : mysqli|false
	{
		return mysqli_connect("localhost","root","", "grocery") or die("Couldn't connect to SQL server");
	}
?>