<?php





	$hide = array(	'resources',
					'index.php',
					'.htaccess',
					'.htpasswd',
					'.DS_Store');
			
	error_reporting(E_ERROR);
	
	
	$filepath = $_SERVER['SCRIPT_FILENAME'];
	$scriptname = basename($filepath);
	$readpath = str_replace($scriptname, "", $filepath)."/secret";

	$handle = opendir($readpath);
	

	while ($file = readdir($handle)) { 
		
		if ($file == "." || $file == ".." || in_array($file, $hide))  continue;
		

		
		$files[] = $file;
		
	}

	closedir($handle); 

	// Sort our files
	@ksort($files, SORT_NUMERIC);
	$files = @array_reverse($files);

?>
	
	<!DOCTYPE html>
	<html>
	
		<head>
	<link rel="stylesheet" type="text/css" href="styles.css" />
	<script src="jquery-1.5.js"></script>
<script type="text/javascript">

$(document).ready(function(){
	$(".piece").hover(
		function(){

			$("#_"+this.id).animate({opacity:1},500,function(){});
			console.log($("#_"+this.id));
	},
		function(){
			$("#_"+this.id).animate({opacity:0},500,function(){});

	});

});

</script>
			
			<title>Artist Name</title>

			
		</head>
		
		<body style="padding:10px; font-size:11pt; padding-top:160px;">

			<div id="header"><a href=".">Artist Name</a><br>
			<sub><a href="mailto:mail@gmail.com">mail</a> - <a href="./secret/CV.pdf">CV</a></sub>
			</div>
<!--<br><br><br><br><br><br><br><br><br>-->
	  	
			<?php $baseurl = $_SERVER['PHP_SELF']; ?>

			<table border="0" cellspacing="5" cellpadding="5">

				<?php
					$arsize = sizeof($files);

					//print_r($files);
					//echo"<br>";				
					$end = "</div><br><br><br><br><br><br>";
					for ($i=0; $i<$arsize; $i++) {
					
						$ext = strtolower(substr($files[$i], strrpos($files[$i], '.')+1));
						$filename = str_replace(".".$ext, "",stripslashes($files[$i]));
						$fileURL = "./secret/".stripslashes($files[$i]);

						//echo"filename = $filename - fileurl = $fileurl - file = ".$files[$i]."<br>";
					$infoArray = explode("_",$filename);
					$count = count($infoArray);
					//print_r($infoArray);
					//echo"<br>";
					$order = $infoArray[0];
					$title = $infoArray[1];
					$side = $infoArray[2];
					$sideSay = ($side == "l" ? "left" : ($side == "r" ? "right" : "center"));
					$start = "<div style=\"text-align:$sideSay;\">";
					if ($order == $lastOrder){$end = "";$start = "";}
					//$lastOrder = $order;
					if($i==0){$lastOrder = $order;}
					else{echo $end;}


					if ($ext == "jpg" || $ext == "gif" || $ext == "png" || $ext == "jpeg"):	
					if ($count == 3):		
					//echo"'$order'";	
				?>
				<?php echo $start; ?><img  id="<?echo$order;?>" class="piece"  style="padding:10px;" alt="<?php echo $title; ?>" src="<?php echo $fileURL; ?>">	
				<div class="titles" id="_<?echo$order;?>"><?echo"<h3>$title</h3>";?></div>
				<?php
				echo"\n";
				endif;
				endif;
 } ?>
			
			</table>
	


		</body>
		
	</html>
