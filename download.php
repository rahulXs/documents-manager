<?php

include 'setup.php';
if (isset($_GET['down'])){
	$id= $_GET['down'];
	$qry= "UPDATE docs SET count=count+1 WHERE docs.id ='$id'";
	mysqli_query($conn, $qry);
	$sql= "SELECT * FROM docs WHERE id='$id'";
	$res= mysqli_query($conn, $sql);
	while($data = mysqli_fetch_array($res))
			{ 
			$file_name= $data['file_name'];
	
	}

	#echo $file_name;
	$path= "doc/". $file_name; 
	#echo $path;
	#echo filesize($path);

	header('Content-Disposition: attachment; filename = '.$path);
	header('Content-Type: application/pdf');
	header('Content-Length: '. filesize($path));
	readfile($path);

}