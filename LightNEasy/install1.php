<?php
/*---------------------------------------------------+
| LightNEasy Content Management System
| Copyright 2007 - 2012 Fernando Baptista
| http://www.lightNEasy.org
+----------------------------------------------------+
| Install module install1.php
| Version 3.3.0 SQLite/MySQL
+----------------------------------------------------+
| Released under the terms & conditions of v2 of the
| GNU General Public License. For details refer to
| the included gpl.txt file or visit http://gnu.org
+----------------------------------------------------*/
?>
<!DOCTYPE html>
<html>
	<head>
		<title>LightNEasy 3.3.0 Install - 2</title>
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
				<?php
				if(isset($_POST['submit'])&&$_POST['submit'] == "Create Database") {
					unset($_POST['submit']);
					if($_POST['password']!="" && $_POST['password1']!="" && $_POST['password']==$_POST['password1']) {
						//TODO: password_hash, password_verify, password_needs_rehash
						$pass=sha1($_POST['password']);
						$admin=$_POST['admin'];
						$email=$_POST['email'];
						$wemail=$_POST['wemail'];
						$prefix=$_POST['prefix'];
						if(!$fp=@fopen("../data/database.php","w"))
							die("Error - unable to write to database.php");
						if($_POST['database']=="SQLite2" || $_POST['database']=="SQLite3") {
							//SQLite
							if($_POST['database']=="SQLite2")
							$MySQL=0;
						else
							$MySQL=2;
						srand((double) microtime() * 1000000);
						$databasename = "";
						for($i = 0; $i < 8; $i++)
							$databasename .= rand(0, 9);
							clearstatcache();
							fwrite($fp,"<?php\n\$MySQL=".$MySQL.";\n\$databasename=\"".$databasename."\";\n");
						} else {
							//MySQL
							$MySQL=1;
							fwrite($fp,"<?php\n\$MySQL=1;\n\$databasename=\"".$_POST['databasename']."\";\n");
							fwrite($fp,"\$databaselogin=\"".$_POST['databaselogin']."\";\n");
							fwrite($fp,"\$databasepassword=\"".$_POST['databasepassword']."\";\n");
							fwrite($fp,"\$databasehost=\"".$_POST['databasehost']."\";\n");
						}
						fwrite($fp,"\$prefix=\"$prefix\";\n?>\n");
						fclose($fp);
						switch($MySQL) {
							case 2:
								if(!$sqldb= new SQLite3("../data/$databasename.db")) die ("Couldn't open SQLite 3 database");
								break;
							case 1:
								$sqldb= mysql_connect($_POST['databasehost'], $_POST['databaselogin'], $_POST['databasepassword']) or die (mysql_error());
								mysql_query("CREATE DATABASE IF NOT EXISTS ".$_POST['databasename'],$sqldb) or die (mysql_error());
								mysql_select_db($_POST['databasename']) or die (mysql_error());
								break;
							case 0:
								$sqldb= sqlite_open("../data/$databasename.db") or die ("Couldn't open database: ".sqlite_error_string(sqlite_last_error($sqldb)));
						}
						# table for banned ips
						dbquery("CREATE TABLE ".$prefix."bannedips ( ip VARCHAR ( 20 ) NOT NULL )");
						if($MySQL==1) {
						# users table structure
							dbquery("CREATE TABLE ".$prefix."users ( id INTEGER NOT NULL auto_increment , handle VARCHAR(30) NOT NULL , password VARCHAR(40) NOT NULL , adminlevel INTEGER NOT NULL, ip VARCHAR(15) NOT NULL, datejoined VARCHAR(10) NOT NULL, email VARCHAR(50) NOT NULL, firstname VARCHAR(50), lastname VARCHAR(50), website VARCHAR(50), location VARCHAR(50), PRIMARY KEY (id))");
						# table structure for comments
							dbquery("CREATE TABLE ".$prefix."comments ( id INTEGER NOT NULL auto_increment , newsid INTEGER NOT NULL , poster VARCHAR (30) NOT NULL, postermail VARCHAR ( 40 ) , time VARCHAR (10) NOT NULL, text TEXT NOT NULL, PRIMARY KEY (id))");
						# Table structure for table: newscat
							dbquery("CREATE TABLE ".$prefix."newscat ( id INTEGER NOT NULL auto_increment, nome VARCHAR(40) NOT NULL, descr VARCHAR(200), PRIMARY KEY (id))");
						# Table structure for table: linkscat
							dbquery("CREATE TABLE ".$prefix."linkscat ( id INTEGER NOT NULL auto_increment, nome VARCHAR(40) NOT NULL, descr VARCHAR(200) NOT NULL, PRIMARY KEY (id))");
						# Table structure for table: downloads
							dbquery("create table ".$prefix."downloads ( reg integer not null auto_increment, nome varchar(40) not null, file varchar(40) not null, downloads integer not null, ex integer, PRIMARY KEY (reg) )");
						# Table structure for table: downloadscat
							dbquery("CREATE TABLE ".$prefix."downloadscat ( id INTEGER NOT NULL auto_increment, nome VARCHAR(40) NOT NULL, descr VARCHAR(200), PRIMARY KEY (id))");
						# Table structure for table: links
							dbquery("create table ".$prefix."links ( id integer not null auto_increment, link varchar(40) not null, name varchar(30) not null, descr varchar(100), hits integer, PRIMARY KEY (id))");
						# Table structure for table: noticias
							dbquery("CREATE TABLE ".$prefix."noticias ( reg INTEGER NOT NULL auto_increment , autor VARCHAR( 50 ) NOT NULL , email VARCHAR( 50 ) , titulo VARCHAR( 60 ) NOT NULL , noticia TEXT NOT NULL , data VARCHAR( 10 ) NOT NULL , visto INTEGER NOT NULL, cat INTEGER NOT NULL, PRIMARY KEY (reg))");
						# Table structure for table: extras
							dbquery("create table ".$prefix."extras ( id INTEGER NOT NULL auto_increment, content text not null, PRIMARY KEY (id))");
						# Table structure for addons
							dbquery("create table ".$prefix."addons ( id INTEGER NOT NULL auto_increment, name VARCHAR( 20 ) NOT NULL , fname VARCHAR (20) NOT NULL , aname VARCHAR (20) , active INTEGER, adminlevel INTEGER, header INTEGER NOT NULL, PRIMARY KEY (id))");
						} else {
						# users table structure
							dbquery("CREATE TABLE ".$prefix."users ( id INTEGER NOT NULL PRIMARY KEY , handle VARCHAR(30) NOT NULL , password VARCHAR(40) NOT NULL , adminlevel INTEGER NOT NULL, ip VARCHAR(15) NOT NULL, datejoined VARCHAR(10) NOT NULL, email VARCHAR(50) NOT NULL, firstname VARCHAR(50), lastname VARCHAR(50), website VARCHAR(50), location VARCHAR(50))");
						# table structure for comments
							dbquery("CREATE TABLE ".$prefix."comments ( id INTEGER NOT NULL PRIMARY KEY , newsid INTEGER NOT NULL , poster VARCHAR ( 30 ) NOT NULL, postermail VARCHAR ( 40 ) , time VARCHAR (10) NOT NULL , text TEXT NOT NULL )");
						# Table structure for table: newscat
							dbquery("CREATE TABLE ".$prefix."newscat ( id INTEGER NOT NULL PRIMARY KEY, nome VARCHAR(40) NOT NULL, descr VARCHAR(200) )");
						# Table structure for table: linkscat
							dbquery("CREATE TABLE ".$prefix."linkscat ( id INTEGER NOT NULL PRIMARY KEY DEFAULT \"0\", nome VARCHAR(40) NOT NULL, descr VARCHAR(200) NOT NULL )");
						# Table structure for table: downloadscat
							dbquery("CREATE TABLE ".$prefix."downloadscat ( id INTEGER NOT NULL PRIMARY KEY, nome VARCHAR(40) NOT NULL, descr VARCHAR(200) )");
						# Table structure for table: downloads
							dbquery("create table ".$prefix."downloads ( reg integer not null unique primary key, nome varchar(40) not null, file varchar(40) not null, downloads integer not null, ex integer )");
						# Table structure for table: links
							dbquery("create table ".$prefix."links ( id integer not null primary key, link varchar(40) not null, name varchar(30) not null, descr varchar(100), hits integer )");
						# Table structure for table: noticias
							dbquery("CREATE TABLE ".$prefix."noticias ( reg INTEGER NOT NULL PRIMARY KEY , autor VARCHAR( 50 ) NOT NULL , email VARCHAR( 50 ) , titulo VARCHAR( 60 ) NOT NULL , noticia TEXT NOT NULL , data VARCHAR( 10 ) NOT NULL , visto INTEGER NOT NULL, cat INTEGER NOT NULL)");
						# Table structure for table: extras
							dbquery("create table ".$prefix."extras ( id INTEGER NOT NULL PRIMARY KEY, content text not null )");
						# Table structure for addons
							dbquery("create table ".$prefix."addons ( id INTEGER NOT NULL PRIMARY KEY, name VARCHAR( 20 ) NOT NULL , fname VARCHAR (20) NOT NULL , aname VARCHAR (20) , active INTEGER, adminlevel INTEGER, header INTEGER NOT NULL DEFAULT '0' )");
						}
						# Table structure for table: menu
						dbquery("CREATE TABLE ".$prefix."menu (m1 integer not null, m2 integer, m3 integer, page varchar(40) not null, nome varchar(40))");
						# Table structure for table: paginas
						dbquery("CREATE TABLE ".$prefix."paginas ( m1 integer not null, m2 integer not null, m3 integer not null, page varchar(20) not null, nome varchar(40) not null, content text, description text, template varchar(30), restricted integer not null )");
						# Table structure for table: settings
						dbquery("create table ".$prefix."settings ( password varchar(40) not null, homepath varchar(60) not null, template varchar(20) not null, title varchar(40) not null, subtitle varchar(60) not null, keywords varchar(120) not null, description varchar(120) not null, author varchar(30) not null, footer varchar(120) not null, openfield varchar(4) not null, closefield varchar(4) not null, gzip integer not null, extension varchar(5) not null, indexfile varchar(15) not null,email varchar(40) not null,admin varchar(20) not null, wemail varchar(40), language varchar(10) not null, langeditor varchar(4) not null, timeoffset integer not null, restricted varchar(40), dateformat VARCHAR(20) )");
						# Start populating the database
						dbquery("INSERT INTO ".$prefix."newscat VALUES (0,'General','General posts')");

						dbquery("INSERT INTO ".$prefix."linkscat VALUES (0,'Links','Links')");

						dbquery("INSERT INTO ".$prefix."downloadscat VALUES (1,'Downloads','Downloads')");
						dbquery("INSERT INTO ".$prefix."downloadscat VALUES (null,'Uploads','Users upload here')");

						dbquery("INSERT INTO ".$prefix."noticias VALUES (null,'Fernbap','my@email.com','News Title','&lt;p&gt;This is some example news.&lt;/p&gt; &lt;p&gt;You can edit/delete this news and enter your own news.&lt;/p&gt;',".time().",0,0)");

						dbquery("INSERT INTO ".$prefix."extras VALUES (null,'&lt;h1&gt;Extra Content&lt;/h1&gt;&lt;p&gt;This is an extra content you can include in all your pages&lt;/p&gt;&lt;p&gt;This is good for announcements, for instance.&lt;/p&gt;&lt;p&gt;You can edit it from the settings menu&lt;/p&gt;')");

						dbquery("INSERT INTO ".$prefix."users VALUES (null,'$admin','$pass',5, '".$_SERVER['REMOTE_ADDR']."',".time().", '$email', '', '', '', '')");

						dbquery("INSERT INTO ".$prefix."settings VALUES ('$pass', './', 'lightneasy', 'LightNEasy', 'Light, simple, practical', 'LightNEasy, CMS, light, easy to use, website builder, content management, php, sqlite, open source', 'LightNEasy is a light and simple Content Management System and Website Builder', 'Fernando Baptista', 'Powered by LightNEasy Content Manager', '$#', '#$', 0, '1', 'LightNEasy.php', '$email' , '$admin', '$wemail', 'en_US', 'en','news', null, '%m/%d/%y - %I:%M %p' )");

						dbquery("INSERT INTO ".$prefix."menu VALUES ('1', '0', '0', 'index', 'Home')");
						dbquery("INSERT INTO ".$prefix."menu VALUES ('1', '1', '0', 'home1', 'Home Submenu')");
						dbquery("INSERT INTO ".$prefix."menu VALUES ('1', '1', '1', 'home2', 'Home Sub-submenu')");
						dbquery("INSERT INTO ".$prefix."menu VALUES ('2', '0', '0', 'about', 'About')");
						dbquery("INSERT INTO ".$prefix."menu VALUES ('3', '0', '0', 'news', 'News')");
						dbquery("INSERT INTO ".$prefix."paginas VALUES ('1', '0', '1', 'index', 'Home', '&lt;h2 class=\&quot;LNE_title\&quot;&gt;LightNEasy 3.2.5 index page&lt;/h2&gt;&lt;p&gt;If you are seeing this, that means &lt;strong&gt;LightNEasy&lt;/strong&gt; installation worked!&lt;/p&gt;&lt;p&gt;This is the start page of your website. &lt;strong&gt;You should never delete this page!&lt;/strong&gt; Instead, edit its content and enter whatever you want as content for this page. You can also alter the menu name, but the filename must be index.&lt;/p&gt;&lt;p&gt;Report to &lt;a href=\&quot;http://www.lightneasy.org\&quot;&gt;LightNEasy website&lt;/a&gt; to look at the instructions manual and how to use LightNEasy functionalities.&lt;/p&gt;&lt;p&gt;Login, chose the template you want or make a LightNEasy template, and start building your website!&lt;/p&gt;&lt;p&gt;Take a look at the bundled template files and see how easy it is to build a LightNEasy template. &lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;', null, null, 0)");

						dbquery("INSERT INTO ".$prefix."paginas VALUES ('1', '1', '1', 'home1', 'Home Submenu', '&lt;h2 class=\&quot;LNE_title\&quot;&gt;Home Submenu&lt;/h2&gt;&lt;p&gt;This is a subpage of Home page, just so that you can look at the menu structure.&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt; ', null,null, 0)");

						dbquery("INSERT INTO ".$prefix."paginas VALUES ('1', '1', '1', 'home2', 'Home Sub-submenu', '&lt;h2 class=\&quot;LNE_title\&quot;&gt;Home Sub-submenu&lt;/h2&gt;&lt;p&gt;Yes, you can make sub-subpages.&amp;nbsp;&lt;/p&gt; ', null, null, 0)");

						dbquery("INSERT INTO ".$prefix."paginas VALUES (' 2', '0', '1', 'about', 'About', '&lt;h2 class=\&quot;LNE_title\&quot;&gt;LightNEasy runs anywhere&lt;/h2&gt;&lt;p&gt;LightNEasy doesn''t require any fancy server stuff, just pure PHP, so will run smoothly in any web host, including most of the free ones. And yes, it works with PHP safe mode on. As SQLite is a standard feature supported by PHP5, and included also in many PHP4 webservers, LightNEasy uses SQLite for its own SQL database, or MySQL, if your server has MySQL. &lt;/p&gt;&lt;h3&gt;FCK WYSIWYG editor&lt;/h3&gt;&lt;p align=&quot;justify&quot;&gt;LighNEasy was built around the excelent open source online editor &lt;a href=&quot;http://fckeditor.net&quot; target=&quot;_blank&quot; title=&quot;FCK Editor&quot;&gt;FCK Editor&lt;/a&gt;, whose work i thank and apreciate.&lt;/p&gt;&lt;p&gt;FCK is a javascript aplication so you need javascript enabled in your browser in order to edit the content in WYSIYG mode. You don''t need javascript, however, to run the website or LightNEasy.&lt;br /&gt; &lt;/p&gt;', null, null, 0)");

						dbquery("INSERT INTO ".$prefix."paginas VALUES ('3', '0', '1', 'news', 'News', '&lt;h2 class=\&quot;LNE_title\&quot;&gt;News&lt;/h2&gt; &lt;p&gt;%!\$news 1 10 2$!%&lt;/p&gt;', null, null, 0)");

						dbquery("INSERT INTO ".$prefix."addons VALUES (null, 'links', 'links', 'alinks', '1', '4', '0')");
						dbquery("INSERT INTO ".$prefix."addons VALUES (null, 'downloads', 'downloads', 'adownloads', '1', '4', '0')");
						dbquery("INSERT INTO ".$prefix."addons VALUES (null, 'uploads', 'uploads', 'auploads', '1', '2', '0')");
						dbquery("INSERT INTO ".$prefix."addons VALUES (null, 'contact', 'contact', NULL, '1', '1', '1')");
						dbquery("INSERT INTO ".$prefix."addons VALUES (null, 'news', 'shownews', 'adminnews', '1', '4', '1')");
						dbquery("INSERT INTO ".$prefix."addons VALUES (null, 'lastnews', 'lastnews', NULL, '1', '1', '1')");
						dbquery("INSERT INTO ".$prefix."addons VALUES (null, 'gallery', 'galery', 'images', '1', '4', '1')");
						dbquery("INSERT INTO ".$prefix."addons VALUES (null, 'mp3', 'mp3', NULL, '1', '1', '0')");
						dbquery("INSERT INTO ".$prefix."addons VALUES (null, 'videoy', 'youtube', NULL, '1', '1', '0')");
						dbquery("INSERT INTO ".$prefix."addons VALUES (null, 'videog', 'googlev', NULL, '1', '1', '0')");
						dbquery("INSERT INTO ".$prefix."addons VALUES (null, 'wrapper', 'iframe', NULL, '1', '1', '1')");
						dbquery("INSERT INTO ".$prefix."addons VALUES (null, 'lyteframe', 'lyteframe', NULL, '1', '1', '1')");
						dbquery("INSERT INTO ".$prefix."addons VALUES (null, 'survey', 'survey', 'asurvey', '1', '4', '1')");
						dbquery("INSERT INTO ".$prefix."addons VALUES (null, 'dropdown', 'dropdownmenu', 'adropdown', '1', '4', '1')");

				echo "<h4>Installation Successfull!</h4>\n
				<hr>\n
				<p>You should make sure the files install.php and install1.php inside LightNEasy folder were deleted, for security reasons.</p>\n
				<div class=\"text-center\"><a class=\"success button\" href=\"../LightNEasy.php\">Start LightNEasy!</a></div>\n";
				} else {
					echo "<h4>Please try Again!</h4>\n
					<hr>\n
					<p>All fields have to be filled</p>\n
					<p>Passwords are either empty or don't match!</p>\n";
					entryform();
				}
				} else {
					if(file_exists("../data/database.php")) {
						echo "<h4>LightNEasy was already installed</h4>\n
						<hr>\n
						<p>If you want to reinstall LightNEasy from scratch, delete the file \"whatever.db\" and \"database.php\" and run install again</p>\n";
					} else {
						echo "<h4>Database setup</h4>\n
						<hr>\n
						<p>Please input all fields below</p>\n";
						entryform();
					}
				}
				?>
				</div>
			</div>
		</div>
	</body>
</html>
<?php
function entryform() { ?>
<form name="form1" action="" method="post">
	<label>Enter password:
		<input type="password" name="password" value="" />
	</label>
	<label>Repeat password:
		<input type="password" name="password1" value="" />
	</label>
	<label>Admin name:
		<input type="text" name="admin" value="" />
	</label>
	<label>Admin email:
		<input type="text" name="email" value="" />
	</label>
	<label>Website email:
		<input type="text" name="wemail" value="" />
	</label>
	<label>Tables prefix:
		<input type="text" name="prefix" value="LNE_" />
	</label>
	<label>Database system:
		<select name="database" >
<?php if(function_exists('mysql_connect')):?><option value="MySQL">MySQL</option><?php endif;?>
<?php if(function_exists('sqlite_escape_string')):?><option value="SQLite2">SQLite 2 (following fields empty)</option><?php endif;?>
<?php if(defined('SQLITE3_ASSOC')):?><option value="SQLite3">SQLite 3 (following fields empty)</option><?php endif;?>
	</select>
	</label>
	<label>Database name:
		<input type="text" name="databasename" value="" />
	</label>
	<label>MySQL login:
		<input type="text" name="databaselogin" value="" />
	</label>
	<label>MySQL password:
		<input type="text" name="databasepassword" value="" />
	</label>
	<label>MySQL host:
		<input type="text" name="databasehost" value="" />
	</label>
	<br>
	<div class="text-center">
		<input class="button small-12 columns" type="submit" name="submit" value="Create Database" />
	</div>
	<br>
</form>
<?php }


function dbquery($query) {
	global $sqldb, $MySQL;
	if($MySQL==1) {
		$result = mysql_query($query);
		if(!$result) {
			echo $query.mysql_error();
			return false;
		} else {
			return $result;
		}
	} elseif($MySQL==0) {
		$result = @sqlite_query($sqldb,$query);
		if (!$result) {
			echo $query." ".sqlite_error_string(sqlite_last_error($sqldb));
			return false;
		} else {
			return $result;
		}
	} else {
		$result = $sqldb->query($query);
		if (!$result) {
			echo $query." ".$sqldb->lastErrorMsg;
			return false;
		} else {
			return $result;
		}
	}
}
?>
