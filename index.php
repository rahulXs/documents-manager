<?php
	include 'setup.php';

	$loc = "doc/";
	$fname = basename($_FILES["file"]["name"]);
	$newloc = $loc . $fname;
	$filetype = pathinfo($newloc,PATHINFO_EXTENSION);

	if(isset($_POST["submit"])){
	    $allowtypes = array('pdf');
	    if(in_array($filetype, $allowtypes)){
	        if(move_uploaded_file($_FILES["file"]["tmp_name"], $newloc)){
	            $sql = mysqli_query($conn, "INSERT into docs (file_name, uploaded_on) VALUES ('".$fname."', NOW())");
	            if($sql){
	                $msg = "file ".$fname. " uploaded";
	            }
	        }
	    }else{
	        $msg = 'only PDF allowed.';
	    }
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>file module</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<fieldset style="margin: 50px; padding: 20px">
		<legend>Upload PDF</legend>
			<form  action="index.php" method="post" enctype="multipart/form-data">
			    Select File to Upload:
			    <input type="file" name="file"><br>
			    <input type="submit" name="submit" value="Upload">
			</form>
			<?php
				echo $msg;
			?>
	</fieldset>
	<fieldset style="margin: 50px; padding: 20px">
		<legend>Download PDFs</legend>
		<?php
				include 'setup.php';
				$sql= "SELECT * FROM docs";
				$result = mysqli_query($conn, $sql);
				echo "<table class='table ver1'>";  
				echo'<th>ID</th><th>File name</th><th>Size (KB)</th><th>No. of downloads</th><th>Link</th>'; 
				while($data = mysqli_fetch_array($result))
				{
				$id=$data['id'];
				$file_name= $data['file_name'];
				$path= "doc/". $file_name; 
				$size= filesize($path)/1024;
				$size1= round($size, 3);
				echo"<tr class='row'>"; 
			echo '<td>'.$data['id'].'</td><td>'.$data['file_name'].'</td><td>'.$size1.'</td><td>'.$data['count'].'</td><td>'."<a href='download.php?down=$id'>download</a>".'</td>'; 
			echo'</tr>'; 
			
				}

			echo "</table>"; 
	
			?>

	</fieldset>
</body>
</html>
