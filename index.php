<?php





	$hide = array(	'.',
					'..',
					'resources',
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
		if (in_array($file, $hide))  continue;	
		$files[] = $file;
	}
	closedir($handle); 

	// Sort our files
	//@ksort($files, SORT_NUMERIC);
	//$files = @array_reverse($files);
	shuffle($files);
?>
	
	<!DOCTYPE html>
	<html>
	
		<head>
	<link rel="stylesheet" type="text/css" href="styles.css" />
	<script src="jquery-1.5.js"></script>
<script type="text/javascript">

$(document).ready(function(){
	$(".pieceHolder").click(function(e){
		console.log(e);
		if($(e.target).hasClass("piece")){
			var holder = $(".pieceHolder").first();
			$(holder).find("img").addClass("visible");
			$(holder).appendTo($("body"));
		}else{
			if($(".visible").length > 1){
				var holder = $(".pieceHolder").last();
				$(holder).find("img").removeClass("visible");
				$(holder).prependTo("body");
			}
		}
		
	});

});

</script>
			
			<title>Artist Name</title>

			
		</head>
		
		<body >

			
			<sub class="mail"><a target="_blank" href="mailto:mail@gmail.com">&#x2709;</a> </sub>
<!--<br><br><br><br><br><br><br><br><br>-->
	  	
			<?php $baseurl = $_SERVER['PHP_SELF']; ?>


				<?php
					$arsize = sizeof($files);

				for ($i=0; $i<$arsize; $i++):
				
					$ext = strtolower(substr($files[$i], strrpos($files[$i], '.')+1));
					$filename = str_replace(".".$ext, "",stripslashes($files[$i]));
					$fileURL = "./secret/".stripslashes($files[$i]);

				
				


					if ($ext == "jpg" || $ext == "gif" || $ext == "png" || $ext == "jpeg"):	
					//echo"'$order'";	
				?>
					<div class="pieceHolder" id="<?=$i;?>">
						<div class="pieceHolderInside">
						<img  id="<?echo$order;?>" class="piece <? echo $i == $arsize -1 ? "visible" : "";  ?>"  style="padding:10px;" alt="<?php echo $title; ?>" src="<?php echo $fileURL; ?>">	
					</div>
					</div>

						<?php
						echo"\n";
					endif;
 				endfor; ?>
			
	


		</body>
		
	</html>
