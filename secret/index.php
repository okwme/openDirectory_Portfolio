<?php

//secret


$hide = array(	'resources',
	'styles.css',
	'index.php',
	'.htaccess',
	'.htpasswd',
	'.DS_Store');

error_reporting(E_ERROR);

if (stripslashes($_GET['download']) ) {
	$file = str_replace('/', '', $_GET['download']);
	$file = str_replace('..', '', $file);

	if (file_exists($file)) {
		header("Content-type: application/x-download");
		header("Content-Length: ".filesize($file)); 
		header('Content-Disposition: attachment; filename="'.$file.'"');
		readfile($file);
		die();
	}
}

$filepath = $_SERVER['SCRIPT_FILENAME'];
$scriptname = basename($filepath);
$readpath = str_replace($scriptname, "", $filepath);
$handle = opendir($readpath);

$password = "password";


//DELETE
if (isset($_GET['rmfile']) && (stripslashes($_REQUEST['pw']) == $password)) {
	unlink($readpath . $_GET['rmfile']);
}

//allowed extensions
$exts = array("jpg","jpeg","gif","png","bmp","pdf");

//UPLOAD
if ($_FILES['file'] && stripslashes($_REQUEST['pw']) == $password) {
	$ext = strtolower(substr($_FILES['file']['name'], strrpos($_FILES['file']['name'], '.')+1));
	if ($_REQUEST['order'] != ""&&in_array(strtolower($ext),$exts))
	{
		$success = move_uploaded_file($_FILES['file']['tmp_name'], stripslashes($_REQUEST['order'])."_".preg_replace("/[^a-zA-Z0-9]/", "-", $_REQUEST['title'])."_".strtolower(stripslashes($_REQUEST['side'])).".".$ext);
	}
	else
	{
		echo "<h1>NOPE</h1>";
	}
}

while ($file = readdir($handle)) { 
	//echo $file."<br>";
	if ($file == "." || $file == ".." || in_array($file, $hide))  continue;

	$key = @filemtime($file);

	$files[$key] = $file;

}

closedir($handle); 

// SORT
@ksort($files, SORT_NUMERIC);
$files = @array_reverse($files);

?>

	<!DOCTYPE html>
	<html>

	<head>

	<title>Secret Stuff</title>
	<link rel="stylesheet" type="text/css" href="../styles.css" />
	<script src="../jquery-1.5.js"></script>
<script type="text/javascript">
	function deleteFile(filename)
{
	password = $("#pw").val();
	var url = "./index.php?rmfile="+filename+"&pw="+password;   
	if (confirm("delete "+filename+"?"))
	{ 
		$(location).attr('href',url);
	}
}
function checkForm()
{
	side = $("#side");
	order = $("#order");
	title = $("#title");
	file = $("#file");
	var thisext = file.val().substr(file.val().lastIndexOf('.'));
	if (thisext == ".jpg" || thisext == ".jpeg" || thisext == ".gif" || thisext == ".png" )
	{
		console.log(side.val());
console.log(side.val().toLowerCase());
		if (side.val().toLowerCase() != "l" && side.val().toLowerCase() != "r" && side.val().toLowerCase() != "c")
		{
			side.css("background","red");
			alert('you fucked up side');
			return false;
		}
		else if (isNaN(order.val()))
		{
			order.css("background","red");
			alert('you fucked up order');
			return false;	
		}
		else if (title.val() == "")
		{
			title.css("background","red");
			alert('you fucked up title');
			return false;	
		}
		else
		{
			return true;
		}
	}
	else
	{
		return true;
	}

return false;
}
</script>			
	</head>	
	<body>
<a href="..">HOME</a><br>
	<?php $baseurl = $_SERVER['PHP_SELF']; ?>
<table border="0" cellspacing="5" cellpadding="5">
	<?php
$arsize = sizeof($files);	
for ($i=0; $i<$arsize; $i++) {	
	$ext = strtolower(substr($files[$i], strrpos($files[$i], '.')+1));
	$filename = stripslashes($files[$i]);
	$fileurl = $files[$i];
	if (strlen($filename) > 43) 
	{
		$filename = substr($files[$i], 0, 40) . '...';
	}
	?>
		<tr>
		<td>-</td>
		<td><a href="./index.php?download=<?php echo $filename; ?>"><?php echo $filename; ?></a></td>
	<td><?php echo round(filesize($leadon.$files[$i])/1024); ?>KB</td>
	<td><?php echo date ("d/m/y", filemtime($leadon.$files[$i]));?></td>
	<td><a onClick="deleteFile('<?php echo $filename; ?>'); return false;" href="#">Delete</a></td>
	</tr>
		<?php } ?>
	</table>

		<div id="upload">
		<form method="post" onSubmit="return checkForm();" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
	<p><input type="text" autocomplete="off" id="side" name="side"></input> L, R, or C</p>
		<p><input type="text" autocomplete="off" id="order" name="order"></input> order</p>
		<p><input type="text" autocomplete="off" id="title" name="title"></input> title</p>
		<p><input type="text" autocomplete="off" id="pw" name="pw" value="<?php echo stripslashes($_REQUEST['pw']) ?>"></input> password</p>
	<p><input type="file" autocomplete="off" id="file" name="file" /></p>
		<p><input type="submit" value="Upload" /></p>
		</form>

		</div>

		</body>

		</html>
