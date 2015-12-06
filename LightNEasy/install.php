<?php
/*---------------------------------------------------+
| LightNEasy Content Management System
| Copyright 2007 - 2011 Fernando Baptista
| http://www.lightNEasy.org
+----------------------------------------------------+
| Install module install.php
| Version 3.3.0 SQLite/MySQL
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the
| GNU General Public License. For details refer to
| the included gpl.txt file or visit http://gnu.org
+----------------------------------------------------*/
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<title>LightNEasy 3.3.0 Install - 1</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.0.1/css/foundation.min.css">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.0.1/js/vendor/jquery.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.0.1/js/foundation.min.js"></script>
	</head>
	<body>
		<div class="row">
			<div class="large-8 large-offset-2 columns">
				<h1 class="text-center">
					<img src="../images/LNElogo.png" alt="LightNEasy">
					<span>LightNEasy Installation</span>
				</h1>
				<div class="callout large">
					<h4>Initial check</h4>
					<hr>
					<p>
						LightNEasy is checking for webserver permissions ...
					</p>
					<?php
					$oldumask = umask(0);
					$ok=true;
					if(!is_dir("../data")) {
						if(!@mkdir("../data", 0755)) {
							$ok=false;
							$class = " alert";
							$text = "Failed";
						} else {
							$class= " success";
							$text = "OK";
						}
					} else {
						$class= " success";
						$text = "OK";
					} ?>
						<div>Checking Data folders ...
							<span class="<?php echo $class; ?> label float-right"><?php echo $text; ?></span>
						</div>
						<br>
					<?php
					if(!is_dir("../galeries")) {
						if(!@mkdir("../galeries", 0755)) {
							$ok=false;
							$class = " alert";
							$text = "Failed";
						} else {
							$class= " success";
							$text = "OK";
						}
					} else {
						$class= " success";
						$text = "OK";
					} ?>
						<div>Checking Galleries folder ...
							<span class="<?php echo $class; ?> label float-right"><?php echo $text; ?></span>
						</div>
						<br>
					<?php
					if(!is_dir("../thumbs")) {
						if(!@mkdir("../thumbs", 0755)) {
							$ok=false;
							$class = " alert";
							$text = "Failed";
						} else {
							$class= " success";
							$text = "OK";
						}
					} else {
						$class= " success";
						$text = "OK";
					} ?>
						<div>Checking Thumbnails folder ...
							<span class="<?php echo $class; ?> label float-right"><?php echo $text; ?></span>
						</div>
						<br>
					<?php
					if(!is_dir("../downloads")) {
						if(!@mkdir("../downloads", 0755)) {
							$ok=false;
							$class = " alert";
							$text = "Failed";
						} else {
							$class= " success";
							$text = "OK";
						}
					} else {
						$class= " success";
						$text = "OK";
					} ?>
						<div>Checking Downloads folder ...
							<span class="<?php echo $class; ?> label float-right"><?php echo $text; ?></span>
						</div>
						<br>
					<?php
					if(!is_dir("../uploads")) {
						if(!@mkdir("../uploads", 0755)) {
							$ok=false;
							$class = " alert";
							$text = "Failed";
						} else {
							$class= " success";
							$text = "OK";
						}
					} else {
						$class= " success";
						$text = "OK";
					} ?>
						<div>Checking Plugins folder ...
							<span class="<?php echo $class; ?> label float-right"><?php echo $text; ?></span>
						</div>
						<br>
					<?php
					if(!is_dir("../plugins")) {
						if(!@mkdir("../plugins", 0755)) {
							$ok=false;
							$class = " alert";
							$text = "Failed";
						} else {
							$class= " success";
							$text = "OK";
						}
					} else {
						$class= " success";
						$text = "OK";
					} ?>
						<div>Checking Uploads folder ...
							<span class="<?php echo $class; ?> label float-right"><?php echo $text; ?></span>
						</div>
						<br>
					<?php
					umask($oldumask);
					if(function_exists('sqlite_escape_string')) {
						$class = " success";
						$text = "Installed, version ".sqlite_libversion();
					} else {
						$class= " alert";
						$text = "No SQLite 2 installed!";
					} ?>
						<div>Checking SQLite 2 ...
							<span class="<?php echo $class; ?> label float-right"><?php echo $text; ?></span>
						</div>
						<br>
					<?php
					if(defined('SQLITE3_ASSOC')) {
						$res=SQLite3::version();
						$class = " success";
						$text = "Installed, version ".$res['versionString'];
					} else {
						$class= " alert";
						$text = "No SQLite 3 installed!";
					} ?>
						<div>Checking SQLite 3 ...
							<span class="<?php echo $class; ?> label float-right"><?php echo $text; ?></span>
						</div>
						<br>
					<?php
					if($fp=@fopen("../data/index.html","w")) {
						fwrite($fp,"<html><head><meta http-equiv=\"refresh\" content=\"0;URL=../index.php\" /></head><body></body></html>");
						fclose($fp);
						$class = " success";
						$text = "data/index.html created";
					} else {
						$class= " alert";
						$text = "Could not create data/index.html";
						$ok = false;
					} ?>
						<div>Creating data/index.html ...
							<span class="<?php echo $class; ?> label float-right"><?php echo $text; ?></span>
						</div>
						<br>
					<?php
					if($fp=@fopen("../galeries/index.html","w")) {
						fwrite($fp,"<html><head><meta http-equiv=\"refresh\" content=\"0;URL=../index.php\" /></head><body></body></html>");
						fclose($fp);
						$class = " success";
						$text = "galeries/index.html created";
					} else {
						$class= " alert";
						$text = "Could not create galeries/index.html";
						$ok = false;
					} ?>
						<div>Creating galeries/index.html ...
							<span class="<?php echo $class; ?> label float-right"><?php echo $text; ?></span>
						</div>
						<br>
					<?php
					if($fp=@fopen("../downloads/index.html","w")) {
						fwrite($fp,"<html><head><meta http-equiv=\"refresh\" content=\"0;URL=../index.php\" /></head><body></body></html>");
						fclose($fp);
						$class = " success";
						$text = "downloads/index.html created";
					} else {
						$class= " alert";
						$text = "Could not create downloads/index.html";
						$ok = false;
					} ?>
						<div>Creating download/index.html ...
							<span class="<?php echo $class; ?> label float-right"><?php echo $text; ?></span>
						</div>
						<br>
					<?php
					if($fp=@fopen("../uploads/index.html","w")) {
						fwrite($fp,"<html><head><meta http-equiv=\"refresh\" content=\"0;URL=../index.php\" /></head><body></body></html>");
						fclose($fp);
						$class = " success";
						$text = "uploads/index.html created";
					} else {
						$class= " alert";
						$text = "Could not create uploads/index.html";
						$ok = false;
					} ?>
						<div>Creating uploads/index.html ...
							<span class="<?php echo $class; ?> label float-right"><?php echo $text; ?></span>
						</div>
						<br>
					<?php
					if($fp=@fopen("../plugins/index.html","w")) {
						fwrite($fp,"<html><head><meta http-equiv=\"refresh\" content=\"0;URL=../index.php\" /></head><body></body></html>");
						fclose($fp);
						$class = " success";
						$text = "plugins/index.html created";
					} else {
						$class= " alert";
						$text = "Could not create plugins/index.html";
						$ok = false;
					} ?>
						<div>Creating plugins/index.html ...
							<span class="<?php echo $class; ?> label float-right"><?php echo $text; ?></span>
						</div>
						<br>
					<?php
					if($ok) {
						$class = " success";
						$text = "<h5>All seems to be OK</h5>\n
						</div><br>\n
						<div class=\"text-center\"><a class=\"button success\" href=\"install1.php\">Proceed</a>";
					} else {
						$class= " alert";
						$text = "<h5>There were errors in your configuration</h5>\n
						<div class=\"text-center\"><span class=\"alert label\">Please correct the permissions and run install again</span>\n
						</div>";
					}
					?>
					<div class="<?php echo $class; ?> callout text-center"><?php echo $text; ?></div>
				</div>
			</div>
		</div>
	</body>
</html>
