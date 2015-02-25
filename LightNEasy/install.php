<?php
/*---------------------------------------------------+
| LightNEasy Content Management System
| Copyright 2007 - 2011 Fernando Baptista
| http://www.lightNEasy.org
+----------------------------------------------------+
| Install module install.php
| Version 3.2.4 SQLite/MySQL
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the
| GNU General Public License. For details refer to
| the included gpl.txt file or visit http://gnu.org
+----------------------------------------------------*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>LightNEasy 3.2.4 Install - 1</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body style="background: #606060;">
<div style="width: 600px; margin: auto; background: #004DBF; color: #fff; padding: 10px;">
<img src="../images/Logo.png" alt="LightNEasy" align="middle" border="0" style="float: left;" />
<h1 style="text-align: center;"><br />Install</h1>
<div style="background: #c0c0c0; padding: 10px 0 0 30px; color: #000;">
<h4>LightNEasy is checking for webserver permissions....</h4>
<table><tr><td>Checking Data folders...</td>
<?php
$oldumask = umask(0);
$ok=true;
if(!is_dir("../data")) {
	if(!@mkdir("../data", 0755)) {
		print "<td style=\" color: #ff0000; \">Failed";
		$ok=false;
	} else
		print "<td style=\" color: #00ff00; \">OK";
} else
	print "<td style=\" color: #00ff00; \">OK";
print "</td></tr>\n<tr><td>Checking Galleries folder...</td>";
if(!is_dir("../galeries")) {
	if(!@mkdir("../galeries", 0755)) {
		print "<td style=\" color: #ff0000; \">Failed";
		$ok=false;
	} else
		print "<td style=\" color: #00ff00; \">OK";
} else
	print "<td style=\" color: #00ff00; \">OK";
print "</td></tr>\n<tr><td>Checking thumbnails folder...</td>";
if(!is_dir("../thumbs")) {
	if(!@mkdir("../thumbs", 0755)) {
		print "<td style=\" color: #ff0000; \">Failed";
		$ok=false;
	} else
		print "<td style=\" color: #00ff00; \">OK";
} else
	print "<td style=\" color: #00ff00; \">OK";
print "</td></tr>\n<tr><td>Checking Downloads folder...</td>";
if(!is_dir("../downloads")) {
	if(!@mkdir("../downloads", 0755)) {
		print "<td style=\" color: #ff0000; \">Failed";
		$ok=false;
	} else
		print "<td style=\" color: #00ff00; \">OK";
} else
	print "<td style=\" color: #00ff00; \">OK";
print "</td></tr>\n<tr><td>Checking Uploads folder...</td>";
if(!is_dir("../uploads")) {
	if(!@mkdir("../uploads", 0755)) {
		print "<td style=\" color: #ff0000; \">Failed";
		$ok=false;
	} else
		print "<td style=\" color: #00ff00; \">OK";
} else
	print "<td style=\" color: #00ff00; \">OK";
print "</td></tr>\n<tr><td>Checking Plugins folder...</td>";
if(!is_dir("../plugins")) {
	if(!@mkdir("../plugins", 0777)) {
		print "<td style=\" color: #ff0000; \">Failed";
		$ok=false;
	} else
		print "<td style=\" color: #00ff00; \">OK";
} else
	print "<td style=\" color: #00ff00; \">OK";
umask($oldumask);
print "</td></tr>\n<tr><td>Checking SQLite 2 ...</td>";
if(function_exists('sqlite_escape_string')) {
	print "<td style=\" color: #00ff00; \">Installed, version ".sqlite_libversion();
} else {
	print "<td style=\" color: #ff0000; \">No SQLite 2 installed!";
//	$ok=false;
}
print "</td></tr>\n<tr><td>Checking SQLite 3 ...</td>";
if(defined('SQLITE3_ASSOC')) {
	$res=SQLite3::version();
	print "<td style=\" color: #00ff00; \">Installed, version ".$res['versionString'];
} else {
	print "<td style=\" color: #ff0000; \">No SQLite 3 installed!";
//	$ok=false;
}
print "</td></tr>\n<tr><td>Creating data/index.html...</td>";
if($fp=@fopen("../data/index.html","w")) {
	fwrite($fp,"<html><head><meta http-equiv=\"refresh\" content=\"0;URL=../index.php\" /></head><body></body></html>");
	fclose($fp);
	print "<td style=\" color: #00ff00; \">data/index.html created";
} else {
	print "<td style=\" color: #ff0000; \">Could not create data/index.html!";
	$ok=false;
}
print "</td></tr>\n<tr><td>Creating galeries/index.html...</td>";
if($fp=@fopen("../galeries/index.html","w")) {
	fwrite($fp,"<html><head><meta http-equiv=\"refresh\" content=\"0;URL=../index.php\" /></head><body></body></html>");
	fclose($fp);
	print "<td style=\" color: #00ff00; \">galeries/index.html created";
} else {
	print "<td style=\" color: #ff0000; \">Could not create galeries/index.html!";
	$ok=false;
}
print "</td></tr>\n<tr><td>Creating downloads/index.html...</td>";
if($fp=@fopen("../downloads/index.html","w")) {
	fwrite($fp,"<html><head><meta http-equiv=\"refresh\" content=\"0;URL=../index.php\" /></head><body></body></html>");
	fclose($fp);
	print "<td style=\" color: #00ff00; \">downloads/index.html created";
} else {
	print "<td style=\" color: #ff0000; \">Could not create downloads/index.html!";
	$ok=false;
}
print "</td></tr>\n<tr><td>Creating uploads/index.html...</td>";
if($fp=@fopen("../uploads/index.html","w")) {
	fwrite($fp,"<html><head><meta http-equiv=\"refresh\" content=\"0;URL=../index.php\" /></head><body></body></html>");
	fclose($fp);
	print "<td style=\" color: #00ff00; \">uploads/index.html created";
} else {
	print "<td style=\" color: #ff0000; \">Could not create uploads/index.html!";
	$ok=false;
}
print "</td></tr>\n<tr><td>Creating plugins/index.html...</td>";
if($fp=@fopen("../plugins/index.html","w")) {
	fwrite($fp,"<html><head><meta http-equiv=\"refresh\" content=\"0;URL=../index.php\" /></head><body></body></html>");
	fclose($fp);
	print "<td style=\" color: #00ff00; \">plugins/index.html created";
} else {
	print "<td style=\" color: #ff0000; \">Could not create plugins/index.html!";
	$ok=false;
}
print "</td></tr>\n</table>\n";

if($ok) {
	print "<div style=\"text-align: center\"><h4>All seems to be OK</h4>\n<p><a href=\"install1.php\">Proceed</a></p><br /></div>\n";
} else {
	print "<h3>There were errors in your configuration</h3>\n
	<p>Please correct the permissions and run install again</p>\n";
} ?>
</div>
</div>
</body>
</html>
