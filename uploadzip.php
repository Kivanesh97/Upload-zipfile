<?php
error_reporting(0);
function recursive_dir($dir) {
    foreach(scandir($dir) as $file) {
	    if ('.' === $file || '..' === $file) continue;
		    if (is_dir("$dir/$file")) recursive_dir("$dir/$file");
				    else unlink("$dir/$file");
			}
	    rmdir($dir);
	}
 
if($_FILES["zip_file"]["name"]) {
	$filename = $_FILES["zip_file"]["name"];
	$source = $_FILES["zip_file"]["tmp_name"];
	$type = $_FILES["zip_file"]["type"];
 
	$name = explode(".", $filename);
	$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
	foreach($accepted_types as $mime_type) {
		if($mime_type == $type) {
		$okay = true;
		break;
	}
}
 
$continue = strtolower($name[1]) == 'zip' ? true : false;
if(!$continue) {
	$myMsg = "Please upload a valid .zip file.";
}
 
/* PHP current path */
$path = dirname(__FILE__).'/'; 
$filenoext = basename ($filename, '.zip'); 
$filenoext = basename ($filenoext, '.ZIP');
 
$myDir = $path . $filenoext; // target directory
$myFile = $path . $filename; // target zip file
 

if (is_dir($myDir)) recursive_dir ( $myDir);
     
mkdir($myDir, 0777);
 
/* here it is really happening */
 
if(move_uploaded_file($source, $myFile)) {
	$zip = new ZipArchive();
	$x = $zip->open($myFile); // open the zip file to extract
if ($x === true) {
	$zip->extractTo($myDir); // place in the directory with same name
	$zip->close();
    unlink($myFile);
}
	$myMsg = "Your .zip file uploaded and unziped.";
	
	
} else {	
	$myMsg = "There was a problem with the upload.";
}
}
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Engineering Internship Assessment</title>
  <meta name="description" content="The HTML5 Herald" />
  <meta name="author" content="Digi-X Internship Committee" />

  <link rel="stylesheet" href="style.css?v=1.0" />
  <link rel="stylesheet" href="custom.css?v=1.0" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
  

</head>

<body>

    <div class="top-wrapper">
        <img src="https://assets.website-files.com/5cd4f29af95bc7d8af794e0e/5cfe060171000aa66754447a_n-digi-x-logo-white-yellow-standard.svg" alt="digi-x logo" height="70" />
        <h1>Engineering Internship Assessment</h1>
    </div>

    <div class="instruction-wrapper">
        <h2>What you need to do?</h2>
        <h3 style="margin-top:31px;">Using this HTML template, create a page that can:</h3>
        <ol>
            <li><b class="yellow">Upload</b> a zip file - containing 5 images (Cats, or Dogs, or even Pokemons)</li>
            <li>after uploading, <b class="yellow">Extract</b> the zip to get the images </li>
            <li><b class="yellow">Display</b> the images on this page</li>
        </ol>

        <h2 style="margin-top:51px;">The rules?</h2>
        <ol>
            <li>May use <b class="yellow">any programming language/script</b>. The simplest the better *wink*</li>
            <li><b class="yellow">Best if this project could be hosted</b></li>
            <li><b class="yellow">If you are not hosting</b>, please provide a video as proof (GDrive video link is ok)</li>
            <li><b class="yellow">Submit your code</b> by pushing to your own github account, and share the link with us</li>
        </ol>
    </div>
	<div class="display-wrapper">
        <h2 style="margin-top:51px;">My images</h2>
        <div class="append-images-here">
            <!-- THE IMAGES SHOULD BE DISPLAYED INSIDE HERE -->
<?php
$dirname = pathinfo($filename, PATHINFO_FILENAME);
$dirname1 = $dirname."/";
$images = glob($dirname1."*.jpg");

foreach($images as $image) {
   echo '<img src="'.$image.'" /><br />';
}
	

	?>
	<div class="box">
	<div class="heading">Upload File and Unzip</div>
	<div class="msg"><?php if($myMsg) echo "<p>$myMsg</p>"; ?></div>
	<div class="form_field">
		<form enctype="multipart/form-data" method="post" action="">
		<label>Upload Zip File: </label> <input type="file" name="zip_file">
		<br><br>
		<input type="submit" name="submit" value="Upload" class="upload"> <br><br>
		</form>
	</div>
</div>
</body>
</html>