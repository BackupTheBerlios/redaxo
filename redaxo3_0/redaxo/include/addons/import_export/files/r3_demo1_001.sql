## Redaxo Database Dump Version 3.0 
DROP TABLE IF EXISTS rex_action;
CREATE TABLE rex_action ( id int(11) NOT NULL  auto_increment, name varchar(255) NOT NULL  , action text NOT NULL  , prepost tinyint(4) NOT NULL DEFAULT 0  , sadd tinyint(4) NOT NULL DEFAULT 0  , sedit tinyint(4) NOT NULL DEFAULT 0  , sdelete tinyint(4) NOT NULL DEFAULT 0  , PRIMARY KEY(id))TYPE=MyISAM;
DROP TABLE IF EXISTS rex_article;
CREATE TABLE rex_article ( pid int(11) NOT NULL  auto_increment, id int(11) NOT NULL DEFAULT 0  , re_id int(11) NOT NULL DEFAULT 0  , name varchar(255) NOT NULL  , catname varchar(255) NOT NULL  , cattype int(11) NOT NULL DEFAULT 0  , catprior int(11) NOT NULL DEFAULT 0  , alias varchar(255) NOT NULL  , description text NOT NULL  , attribute text NOT NULL  , file text NOT NULL  , type_id int(11) NOT NULL DEFAULT 1  , teaser tinyint(4) NOT NULL DEFAULT 0  , startpage tinyint(1) NOT NULL DEFAULT 0  , prior int(11) NOT NULL DEFAULT 0  , path varchar(255) NOT NULL  , status tinyint(1) NOT NULL DEFAULT 0  , online_from int(11) NOT NULL DEFAULT 0  , online_to int(11) NOT NULL DEFAULT 0  , createdate int(11) NOT NULL DEFAULT 0  , updatedate int(11) NOT NULL DEFAULT 0  , keywords text NOT NULL  , template_id int(11) NOT NULL DEFAULT 0  , clang int(11) NOT NULL DEFAULT 0  , createuser varchar(255) NOT NULL  , updateuser varchar(255) NOT NULL  , fe_user text NOT NULL  , fe_group text NOT NULL  , fe_ext text NOT NULL  , PRIMARY KEY(pid))TYPE=MyISAM;
INSERT INTO rex_article VALUES ('1','1','0','Home','Home','0','1','','','','','1','0','1','1','|','1','1119546396','1262300400','1119546396','1119967284','','1','0','thomas','thomas','','','');
INSERT INTO rex_article VALUES ('3','2','0','�ber mich','�ber mich','0','2','','','','','1','0','1','1','|','1','1119547412','1262300400','1119547412','1120201966','','1','0','thomas','thomas','','','');
INSERT INTO rex_article VALUES ('5','3','0','Referenzen','Referenzen','0','4','','','','','1','0','1','1','|','1','1119547423','1262300400','1119547423','1120171293','','1','0','thomas','thomas','','','');
INSERT INTO rex_article VALUES ('7','4','0','Leistungen','Leistungen','0','3','','','','','1','0','1','1','|','1','1119547436','1262300400','1119547436','1120161444','','1','0','thomas','thomas','','','');
INSERT INTO rex_article VALUES ('9','5','0','Kontakt','Kontakt','0','5','','','','','1','0','1','1','|','1','1119547449','1262300400','1119547449','1123425434','','1','0','thomas','jan','','','');
INSERT INTO rex_article VALUES ('11','6','4','Content Management System','CMS','0','1','','\"Einfach, flexibel, sinnvoll!\"\r\n\r\nF�r uns kein Widerspruch. Schliesslich muss nicht alles was komplex ist,...','','delete file','1','0','1','1','|4|','1','1119564000','1262300400','1119595838','1120202078','','1','0','thomas','thomas','','','');
INSERT INTO rex_article VALUES ('13','7','4','Template Design','Template Design','0','2','','','','','1','0','1','1','|4|','1','1119595855','1262300400','1119595855','1119950374','','1','0','thomas','Jan','','','');
INSERT INTO rex_article VALUES ('15','8','0','Sitemap','Sitemap','0','7','','','','','1','0','1','1','|','1','1119636215','1262300400','1119636215','1122328720','','1','0','thomas','jan','','','');
INSERT INTO rex_article VALUES ('17','9','0','Impressum','Impressum','0','6','','','','','1','0','1','1','|','1','1119638108','1262300400','1119638108','1120469214','','1','0','thomas','jan','','','');
INSERT INTO rex_article VALUES ('27','10','3','Referenz 1','Referenz 1','0','0','','','','','1','0','0','2','|3|','0','1120171450','1262300400','1120171450','1120463617','','1','0','thomas','thomas','','','');
INSERT INTO rex_article VALUES ('28','11','3','Referenz 2','Referenz 2','0','0','','','','','1','0','0','3','|3|','0','1120201626','1262300400','1120201626','1120463619','','1','0','thomas','thomas','','','');
DROP TABLE IF EXISTS rex_article_slice;
CREATE TABLE rex_article_slice ( id int(11) NOT NULL  auto_increment, clang int(11) NOT NULL DEFAULT 0  , ctype int(11) NOT NULL DEFAULT 0  , re_article_slice_id int(11) NOT NULL DEFAULT 0  , value1 text NOT NULL  , value2 text NOT NULL  , value3 text NOT NULL  , value4 text NOT NULL  , value5 text NOT NULL  , value6 text NOT NULL  , value7 text NOT NULL  , value8 text NOT NULL  , value9 text NOT NULL  , value10 text NOT NULL  , value11 text NOT NULL  , value12 text NOT NULL  , value13 text NOT NULL  , value14 text NOT NULL  , value15 text NOT NULL  , value16 text NOT NULL  , value17 text NOT NULL  , value18 text NOT NULL  , value19 text NOT NULL  , value20 text NOT NULL  , file1 varchar(255) NOT NULL  , file2 varchar(255) NOT NULL  , file3 varchar(255) NOT NULL  , file4 varchar(255) NOT NULL  , file5 varchar(255) NOT NULL  , file6 varchar(255) NOT NULL  , file7 varchar(255) NOT NULL  , file8 varchar(255) NOT NULL  , file9 varchar(255) NOT NULL  , file10 varchar(255) NOT NULL  , filelist1 text NOT NULL  , filelist2 text NOT NULL  , filelist3 text NOT NULL  , filelist4 text NOT NULL  , filelist5 text NOT NULL  , filelist6 text NOT NULL  , filelist7 text NOT NULL  , filelist8 text NOT NULL  , filelist9 text NOT NULL  , filelist10 text NOT NULL  , link1 int(11) NOT NULL DEFAULT 0  , link2 int(11) NOT NULL DEFAULT 0  , link3 int(11) NOT NULL DEFAULT 0  , link4 int(11) NOT NULL DEFAULT 0  , link5 int(11) NOT NULL DEFAULT 0  , link6 int(11) NOT NULL DEFAULT 0  , link7 int(11) NOT NULL DEFAULT 0  , link8 int(11) NOT NULL DEFAULT 0  , link9 int(11) NOT NULL DEFAULT 0  , link10 int(11) NOT NULL DEFAULT 0  , linklist1 text NOT NULL  , linklist2 text NOT NULL  , linklist3 text NOT NULL  , linklist4 text NOT NULL  , linklist5 text NOT NULL  , linklist6 text NOT NULL  , linklist7 text NOT NULL  , linklist8 text NOT NULL  , linklist9 text NOT NULL  , linklist10 text NOT NULL  , php text NOT NULL  , html text NOT NULL  , article_id int(11) NOT NULL DEFAULT 0  , modultyp_id int(11) NOT NULL DEFAULT 0  , createdate int(11) NOT NULL DEFAULT 0  , updatedate int(11) NOT NULL DEFAULT 0  , createuser varchar(255) NOT NULL  , updateuser varchar(255) NOT NULL  , PRIMARY KEY(id,re_article_slice_id,article_id,modultyp_id))TYPE=MyISAM;
INSERT INTO rex_article_slice VALUES ('1','0','0','0','Ersparen Sie sich und Ihren Mitarbeitern viel Zeit, denn die Zeiten f�r die Erstellung und Pflege von kostenintensiven statischen Webseiten sind vorbei. Endg�ltig!\r\n\r\nOptimieren Sie stattdessen Ihre professionelle Online-Kommunikation mit einem automatisierten Redaktionssystem, bei dem Sie den �berblick behalten.\r\n\r\nSo profitieren Sie von den zahlreichen Vorteilen, die Ihnen ein Redaktionssystem wie REDAXO bieten kann. Ohne hohen zeitlichen und finanziellen Aufwand werden Sie in die Lage versetzt Ihre Inhalte zu verwalten, zu strukturieren und zu gestalten. Erm�glicht wird dies durch die logische Konzeption von REDAXO und dessen st�ndige Weiterentwicklung.\r\n\r\nDas Einsatzgebiet von REDAXO ist beliebig. REDAXO kann im Internet, Ihrem Intranet oder Extranet eingesetzt werden. Ebenso ist der Zweck f�r die Verwendung von Redaxo beliebig. Egal, ob Mediendatenbank oder Groupware, REDAXO findet �berall dort seine Anwendung wo Inhalte schnell online publiziert werden sollen.','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','1','2','1119595220','1119595220','thomas','thomas');
INSERT INTO rex_article_slice VALUES ('3','0','0','0','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','<?php\r\n\r\necho \'<ul class=\"sitemap\">\';\r\n\r\nforeach (OOCategory::getRootCategories() as $lev1):\r\n\r\n	if($lev1->isOnline()):\r\n		echo \'<li><a href=\"\'.$lev1->getUrl().\'\">\'.$lev1->getName().\'</a>\';\r\n		\r\n		$lev1Size = sizeof($lev1->getChildren());\r\n		if($lev1Size != \"0\"):\r\n		echo \'<ul>\';\r\n		foreach ($lev1->getChildren() as $lev2):\r\n\r\n			if ($lev2->isOnline()):\r\n			echo \'<li><a href=\"\'.$lev2->getUrl().\'\">\'.$lev2->getName().\'</a></li>\';\r\n			endif;\r\n		endforeach;\r\n		echo \'</ul>\';\r\n		endif;\r\n		\r\n		echo \'</li>\';		\r\n	endif;\r\n\r\nendforeach;\r\necho \'</ul>\';\r\n\r\n?>','','8','4','1119636515','1122328720','thomas','jan');
INSERT INTO rex_article_slice VALUES ('4','0','0','0','\"Einfach, flexibel, sinnvoll!\"\r\n\r\nF�r uns kein Widerspruch. Schliesslich muss nicht alles was komplex ist, gleichzeitig kompliziert sein. Schon gar nicht ein Content-Management-System!\r\n\r\nAls Content-Managment-System deckt REDAXO alle erforderlichen Funktionalit�ten eines handels�blichen Redaktionssystems ab.','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','6','2','1119637201','1119637201','thomas','thomas');
INSERT INTO rex_article_slice VALUES ('10','0','0','0','All each tun! Gundherzl ich engl�ck. Wunsch siege \"h�r enzu\" denwen. Igenau ser w�hl, Tendie heraus. Gef und enha, Bendass diesk eing ew�hn, li cherbl Indtex tist. Sie � sin dof fens ichtl ichje mandders ich nich: tso-lei chtand Ernas ehe, Rumf�h Ren. L�sst ei nerder mi tal Lenwas sern gew asch: Enis tein alt, er Hase sozu sag. Enund sieha Benwie der ei Nmal Denricht igenrie Cher ge? Habtdenntats �chl ichverb. Irgt si chin (dies Enbel anglo) sersch einend enz. Eilen einebotsch, aftei, negehei, menach richtdiesichnur. Dengew it ztes tenunt, erdenbet racht ern, Bein� he remhin seh en. Ersch liesst: Manmuss scho neinziem li cher trott elsei. Nund nix Gesch ei tes. Mitsei nemle benanzu \"fang\", en wis senumb lind? Tex tezu le sen.','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','2','2','1119956030','1119956030','thomas','thomas');
INSERT INTO rex_article_slice VALUES ('9','0','0','0','<p><strong>REDAXO.de</strong><br />\r\nLange Strasse 31<br />\r\n60311 Frankfurt/Main</p><p><a title=\"Zur Webseite von REDAXO\" target=\"_blank\" href=\"http://redaxo.de\">www.redaxo.de</a>&nbsp;</p>','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','9','1','1119955027','1120469214','thomas','jan');
INSERT INTO rex_article_slice VALUES ('11','0','0','0','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','4','3','1120161444','1120161444','thomas','thomas');
INSERT INTO rex_article_slice VALUES ('12','0','0','0','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','<?php\r\nif(!isset($FORM[send])){\r\n$FORM[send] = \"\";\r\n}\r\n\r\n$w_style = \'class=\"warning\"\';\r\n$warning = \"\";\r\n$korrektur = \"<p $w_style>Bitte korrigieren Sie die rot gekennzeichneten Felder.</p>\";\r\n$danksagung = \"<p>Vielen Dank f�r Ihr Interesse. Wir werden uns schnellst m�glichst mit Ihnen in Verbindung setzen.</p>\";\r\n$msg = \"\";\r\n\r\nif($FORM[send] != \"\"){\r\n\r\nif(trim($FORM[vorname]) == \"\"){$warning[vorname] = $w_style;}\r\nif(trim($FORM[name]) == \"\"){$warning[name] = $w_style;}\r\nif(!ereg(\'^[-!#$%&\\\'*+\\\\./0-9=?A-Z^_`a-z{|}~]+\'.\'@\'.\'[-!#$%&\\\'*+\\\\./0-9=?A-Z^_`a-z{|}~]+\\.\'.\'[-!#$%&\\\'*+\\\\./0-9=?A-Z^_`a-z{|}~]+$\',$FORM[email])){$warning[email] = $w_style;}\r\n\r\n\r\nif(is_array($warning)){\r\n\r\n$FORM[send] = \"\";\r\n$msg = $korrektur;\r\n\r\n}else{\r\n\r\n$mailbody = \"\r\n\r\nAnliegen:\r\n\".stripslashes($FORM[anliegen]).\"\r\n\r\nName: \".stripslashes($FORM[name]).\"\r\nVorname: \".stripslashes($FORM[vorname]).\"\r\nFirma: \".stripslashes($FORM[firma]).\"\r\nStrasse: \".stripslashes($FORM[strasse]).\"\r\nPLZ/Ort: \".stripslashes($FORM[plz]).\"\r\nE-Mail: \".stripslashes($FORM[email]);\r\n\r\n\r\n$subject = \"Kontaktformular Redaxo Demo\";\r\n$mail_to = $REX[error_emailaddress];\r\n$mail_from = $FORM[email];\r\n\r\n$mailbody_prefix = \"\";\r\n$mailbody_postfix = \"\";\r\n\r\n$mail = new PHPMailer();\r\n$mail->AddAddress($mail_to);\r\n$mail->From = $mail_from;\r\n$mail->FromName = $FORM[vorname].\" \".$FORM[name];\r\n$mail->Subject = $subject;\r\n$mail->Body = $mailbody_prefix.$mailbody.$mailbody_postfix;\r\n$mail->Send(); \r\n\r\n$msg = $danksagung;\r\n}\r\n\r\n\r\n}\r\n\r\n$out = \'<h2>Nehmen Sie Kontakt auf</h2>\';\r\n\r\nif($msg == $danksagung) {\r\n	$out .= $msg;\r\n}\r\nelseif($msg != \"\") {\r\n	$msg = \'<p>\'.$msg.\'</p>\';\r\n}\r\n\r\nif($FORM[send] == \"\"){\r\n\r\n$out .= \"\r\n<!--\r\n<table bordeR=0 cellspacing=0 cellpadding=0>\r\n<form action=index.php method=post name=kontaktform>\r\n<input type=hidden name=article_id value=\'5\'>\r\n<input type=hidden name=FORM[send] value=\'1\'>\r\n<input type=hidden name=clang value=\'\".$REX[\'CUR_CLANG\'].\"\'>\r\n$msg\r\n<tr>\r\n<td width=85><img src=pics/leer.gif width=85px height=1px border=0 title=\'\' alt=\'\'></td>\r\n<td><img src=pics/leer.gif width=320px height=1px border=0 title=\'\' alt=\'\'></td>\r\n\r\n</tr>\r\n\r\n<tr>\r\n<td colspan=2><div class=checkbox><input type=checkbox name=FORM[inform] value=\\\"Bitte senden Sie mir Informationsmaterial zum Seminarprogramm\\\" \"; if($FORM[inform] != \"\"){ $out .=\"checked\";} $out .=\" /></div><div class=aftercheckbox>Bitte senden Sie mir Informationsmaterial zum Seminarprogramm</div></td>\r\n</tr>\r\n\r\n<tr>\r\n<td colspan=2><div class=checkbox><input type=checkbox name=FORM[interessant] value=\\\"Das Programm k�nnte auch interessant sein f�r:\\\" \"; if($FORM[interessant] != \"\"){ $out .=\"checked\";} $out .=\"/></div><div class=aftercheckbox style=\'padding-bottom:8px;\'>Das Programm k�nnte auch interessant sein f�r:</div></td>\r\n</tr>\r\n\r\n<tr>\r\n<td colspan=2><input type=text name=FORM[interessantfuer] value=\\\"\".stripslashes(htmlentities($FORM[interessantfuer])).\"\\\" class=inputtext style=\'width:405px;\'></td>\r\n</tr>\r\n\r\n<tr>\r\n<td colspan=2>&nbsp;</td>\r\n</tr>\r\n\r\n<tr>\r\n<td colspan=2>Ich habe folgenden spezifische Frage:</td>\r\n</tr>\r\n\r\n<tr>\r\n<td colspan=2><textarea name=FORM[spezifischefrage] class=inputtext style=\'width:405px;\'>\".stripslashes(htmlentities($FORM[spezifischefrage])).\"</textarea></td>\r\n</tr>\r\n\r\n<tr>\r\n<td colspan=2>&nbsp;</td>\r\n</tr>\r\n\r\n\r\n<tr>\r\n<td class=inputtlabelsmall \".$warning[name].\" width=80>Name</td>\r\n<td ><input type=text name=FORM[name] value=\\\"\".stripslashes(htmlentities($FORM[name])).\"\\\" class=inputtext style=\'width:320px;\'></td>\r\n</tr>\r\n\r\n<tr>\r\n<td class=inputtlabelsmall \".$warning[vorname].\" >Vorname</td>\r\n<td ><input type=text name=FORM[vorname] value=\\\"\".stripslashes(htmlentities($FORM[vorname])).\"\\\" class=inputtext style=\'width:320px;\'></td>\r\n</tr>\r\n\r\n<tr>\r\n<td class=inputtlabelsmall \".$warning[firma].\" >Firma</td>\r\n<td ><input type=text name=FORM[firma] value=\\\"\".stripslashes(htmlentities($FORM[firma])).\"\\\" class=inputtext style=\'width:320px;\'></td>\r\n</tr>\r\n\r\n<tr>\r\n<td class=inputtlabelsmall \".$warning[abteilung].\" >Abteilung</td>\r\n<td ><input type=text name=FORM[abteilung] value=\\\"\".stripslashes(htmlentities($FORM[abteilung])).\"\\\" class=inputtext style=\'width:320px;\'></td>\r\n</tr>\r\n\r\n<tr>\r\n<td class=inputtlabelsmall \".$warning[strasse].\" >Stra�e, Nr.</td>\r\n<td ><input type=text name=FORM[strasse] value=\\\"\".stripslashes(htmlentities($FORM[strasse])).\"\\\" class=inputtext style=\'width:320px;\'></td>\r\n</tr>\r\n\r\n<tr>\r\n<td class=inputtlabelsmall \".$warning[plz].\" >PLZ/Ort</td>\r\n<td ><input type=text name=FORM[plz] value=\\\"\".stripslashes(htmlentities($FORM[plz])).\"\\\" class=inputtext style=\'width:320px;\'></td>\r\n</tr>\r\n\r\n<tr>\r\n<td class=inputtlabelsmall \".$warning[land].\" >Land</td>\r\n<td ><input type=text name=FORM[land] value=\\\"\".stripslashes(htmlentities($FORM[land])).\"\\\" class=inputtext style=\'width:320px;\'></td>\r\n</tr>\r\n\r\n<tr>\r\n<td class=inputtlabelsmall \".$warning[email].\" >E-Mail</td>\r\n<td ><input type=text name=FORM[email] value=\\\"\".stripslashes(htmlentities($FORM[email])).\"\\\" class=inputtext style=\'width:320px;\'></td>\r\n</tr>\r\n\r\n\r\n<tr>\r\n<td colspan=2>&nbsp;</td>\r\n</tr>\r\n\r\n\r\n<td colspan=2><a href=\'#\' onclick=\\\"document.forms.kontaktform.submit();\\\" target=\'_self\'>senden >></a><input type=image src=pics/leer.gif border=0></td>\r\n</tr></form>\r\n</table>-->\";\r\n\r\n\r\n$out .= \'\r\n<div class=\"fcontact\">\r\n<form action=\"index.php\" method=\"post\" name=\"kontaktform\">\r\n<fieldset>\r\n<legend>Formular</legend>\r\n<input class=\"hide\" type=\"hidden\" name=\"article_id\" value=\"5\" />\r\n<input class=\"hide\" type=\"hidden\" name=\"FORM[send]\" value=\"1\" />\r\n<input class=\"hide\" type=\"hidden\" name=\"clang\" value=\"\'.$REX[\'CUR_CLANG\'].\'\" />\r\n\r\n\'.$msg.\'\r\n\r\n<label \'.$warning[name].\' for=\"FORM[name]\">Name</label>\r\n<input \'.$warning[name].\' type=\"text\" name=\"FORM[name]\" value=\"\'.stripslashes(htmlentities($FORM[name])).\'\" />\r\n\r\n<label \'.$warning[vorname].\' for=\"FORM[vorname]\">Vorname</label>\r\n<input \'.$warning[vorname].\' type=\"text\" name=\"FORM[vorname]\" value=\"\'.stripslashes(htmlentities($FORM[vorname])).\'\" />\r\n\r\n<label \'.$warning[firma].\' for=\"FORM[firma]\">Firma</label>\r\n<input \'.$warning[firma].\' type=\"text\" name=\"FORM[firma]\" value=\"\'.stripslashes(htmlentities($FORM[firma])).\'\" />\r\n\r\n<label \'.$warning[strasse].\' for=\"FORM[strasse]\">Stra�e</label>\r\n<input \'.$warning[strasse].\' type=\"text\" name=\"FORM[strasse]\" value=\"\'.stripslashes(htmlentities($FORM[strasse])).\'\" />\r\n\r\n<label \'.$warning[plz].\' for=\"FORM[plz]\">PLZ / Ort</label>\r\n<input \'.$warning[plz].\' type=\"text\" name=\"FORM[plz]\" value=\"\'.stripslashes(htmlentities($FORM[plz])).\'\" />\r\n\r\n<label \'.$warning[email].\' for=\"FORM[email]\" >E-Mail</label>\r\n<input \'.$warning[email].\' type=\"text\" name=\"FORM[email]\" value=\"\'.stripslashes(htmlentities($FORM[email])).\'\" />\r\n\r\n<label \'.$warning[anliegen].\' for=\"FORM[anliegen]\">Ihr Anliegen:</label>\r\n<textarea \'.$warning[anliegen].\' name=\"FORM[anliegen]\">\'.stripslashes(htmlentities($FORM[anliegen])).\'</textarea>\r\n\r\n\r\n\r\n<p><a href=\"#\" onclick=\"document.forms.kontaktform.submit();\" target=\"_self\">senden >></a></p>\r\n</fieldset>\r\n</form>\r\n</div>\';\r\n\r\n}\r\n\r\necho $out;\r\n\r\n?>','','5','4','1120163040','1123425434','Jan','jan');
INSERT INTO rex_article_slice VALUES ('13','0','0','0','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','3','6','1120171293','1120171293','thomas','thomas');
DROP TABLE IF EXISTS rex_article_type;
CREATE TABLE rex_article_type ( type_id int(11) NOT NULL  auto_increment, name varchar(255) NOT NULL  , description text NOT NULL  , PRIMARY KEY(type_id))TYPE=MyISAM;
INSERT INTO rex_article_type VALUES ('1','Standard','Zugriff f�r alle');
DROP TABLE IF EXISTS rex_clang;
CREATE TABLE rex_clang ( id int(11) NOT NULL DEFAULT 0  , name varchar(255) NOT NULL  , PRIMARY KEY(id))TYPE=MyISAM;
INSERT INTO rex_clang VALUES ('0','deutsch');
DROP TABLE IF EXISTS rex_file;
CREATE TABLE rex_file ( file_id int(11) NOT NULL  auto_increment, re_file_id int(11) NOT NULL DEFAULT 0  , category_id int(11) NOT NULL DEFAULT 0  , filetype varchar(255) NOT NULL  , filename varchar(255) NOT NULL  , originalname varchar(255) NOT NULL  , filesize varchar(255) NOT NULL  , width int(11) NOT NULL DEFAULT 0  , height int(11) NOT NULL DEFAULT 0  , title varchar(255) NOT NULL  , description text NOT NULL  , copyright varchar(255) NOT NULL  , createdate int(11) NOT NULL DEFAULT 0  , updatedate int(11) NOT NULL DEFAULT 0  , createuser varchar(255) NOT NULL  , updateuser varchar(255) NOT NULL  , PRIMARY KEY(file_id))TYPE=MyISAM;
INSERT INTO rex_file VALUES ('1','0','1','text/css','main.css','main.css','6142','0','0','Main','','','1119548963','1120201471','thomas','thomas');
INSERT INTO rex_file VALUES ('2','0','1','image/gif','logo.gif','logo.gif','1322','172','95','Logo','','','1119549281','1119553157','thomas','thomas');
INSERT INTO rex_file VALUES ('3','0','1','image/jpeg','banner.jpg','banner.jpg','10913','468','60','Banner','','','1119550049','1119550049','thomas','thomas');
INSERT INTO rex_file VALUES ('5','0','1','image/gif','e.gif','e.gif','87','64','16','Navi BG','','','1119596721','1119596721','thomas','thomas');
INSERT INTO rex_file VALUES ('6','0','1','image/gif','na.gif','na.gif','54','8','8','NAVI - LSI - HO','','','1119596813','1119596813','thomas','thomas');
INSERT INTO rex_file VALUES ('7','0','1','image/gif','np.gif','np.gif','54','8','8','NAVI - LTI - NO','','','1119596825','1119596825','thomas','thomas');
DROP TABLE IF EXISTS rex_file_category;
CREATE TABLE rex_file_category ( id int(11) NOT NULL  auto_increment, name varchar(255) NOT NULL  , re_id int(11) NOT NULL DEFAULT 0  , path varchar(255) NOT NULL  , hide tinyint(4) NOT NULL DEFAULT 0  , createdate int(11) NOT NULL DEFAULT 0  , updatedate int(11) NOT NULL DEFAULT 0  , createuser varchar(255) NOT NULL  , updateuser varchar(255) NOT NULL  , PRIMARY KEY(id,name))TYPE=MyISAM;
INSERT INTO rex_file_category VALUES ('1','CSS','0','|','0','1119548943','1119548943','thomas','thomas');
INSERT INTO rex_file_category VALUES ('2','Images','0','|','0','1120169419','1120169419','thomas','thomas');
DROP TABLE IF EXISTS rex_help;
CREATE TABLE rex_help ( id int(11) NOT NULL  auto_increment, page varchar(255) NOT NULL  , name varchar(255) NOT NULL  , description text NOT NULL  , comment text NOT NULL  , lang varchar(255) NOT NULL  , PRIMARY KEY(id))TYPE=MyISAM;
DROP TABLE IF EXISTS rex_module_action;
CREATE TABLE rex_module_action ( id int(11) NOT NULL  auto_increment, module_id int(11) NOT NULL DEFAULT 0  , action_id int(11) NOT NULL DEFAULT 0  , PRIMARY KEY(id))TYPE=MyISAM;
DROP TABLE IF EXISTS rex_modultyp;
CREATE TABLE rex_modultyp ( id int(11) NOT NULL  auto_increment, label varchar(255) NOT NULL  , name varchar(255) NOT NULL  , category_id int(11) NOT NULL DEFAULT 0  , ausgabe text NOT NULL  , bausgabe text NOT NULL  , eingabe text NOT NULL  , func text NOT NULL  , php_enable tinyint(1) NOT NULL DEFAULT 0  , html_enable tinyint(1) NOT NULL DEFAULT 0  , perm_category text NOT NULL  , createuser varchar(255) NOT NULL  , updateuser varchar(255) NOT NULL  , createdate int(11) NOT NULL DEFAULT 0  , updatedate int(11) NOT NULL DEFAULT 0  , PRIMARY KEY(id,category_id,php_enable,html_enable))TYPE=MyISAM;
INSERT INTO rex_modultyp VALUES ('1','','01 - Text [wysiwyg]','0','REX_HTML_VALUE[1]','',' Bitte gib den Text ein der zu Sehen sein soll:<br>\r\n<?php\r\n\r\n$a = new rex_wysiwyg_editor();\r\n$a->buttonrow1 = \"styleselect,separator,bold,italic,separator,bullist,numlist,image\";\r\n$a->buttonrow2 = \"link,linkHack,unlink,insertEmail,separator,removeformat,pasteRichtext,code\";\r\n$a->buttonrow3 = \"tablecontrols, separator, visualaid\";\r\n$a->buttonrow4 = \"rowseparator,formatselect,fontselect,fontsizeselect,forecolor,charmap\";\r\n$a->stylesheet = \"/redaxo3_0/files/text.css\";\r\n$a->content = \"REX_VALUE[1]\";\r\n$a->id = 1;\r\n$a->show();\r\n\r\n?><br>','','0','0','','','','0','0');
INSERT INTO rex_modultyp VALUES ('2','','01 - Text [no wysiwyg]','0','<div class=\"article\"><p>REX_VALUE[1]</p></div>','','Bitte gib den Text ein der zu Sehen sein soll:<br>\r\n<textarea name=VALUE[1] cols=80 rows=10 class=inp100>REX_VALUE[1]</textarea>\r\n<br><br>','','0','0','','','','0','0');
INSERT INTO rex_modultyp VALUES ('3','','02 - Categorylist','0','<?\r\n$cat = OOCategory::getCategoryById($this->getValue(category_id));\r\n$cat = $cat->getChildren();\r\n\r\n\r\nif (is_array($cat)) {\r\n	foreach ($cat as $var) {\r\n\r\n	$catId			= $var->getId();\r\n	$catName		= $var->getValue(name);\r\n	$catFile		= $var->getValue(file);\r\n	$catDescription	= $var->getDescription();\r\n	\r\n	if ($catFile == \"\") $catFile = \'<div class=\"image\"> </div>\';\r\n	else $catFile = \'<div class=\"image\"><img src=\"/files/\'.$catFile.\'\" width=\"120\" height=\"80\" /></div>\';\r\n	\r\n	echo \'<div class=\"category-list\">\'.$catFile.\'<div class=\"text\"><h2>\'.$catName.\'</h2><p>\'.$catDescription.\'</p><p><a href=\"\'.rex_getUrl($catId).\'\">mehr >></a></p></div><div class=\"clearer\"> </div></div>\';\r\n	}\r\n}\r\n?>','','','','0','0','','','','0','0');
INSERT INTO rex_modultyp VALUES ('4','','00 - PHP','0','REX_PHP','','PHP:<br>\r\n<textarea name=INPUT_PHP cols=80 rows=20 class=inp100>REX_PHP</textarea>\r\n<br><br>','','0','0','','','','0','0');
INSERT INTO rex_modultyp VALUES ('5','','01 - Bild','0','<?\r\n\r\nif (\"REX_FILE[1]\" != \"\")\r\n{\r\n echo \'<img src=\"\'.$REX[HTDOCS_PATH].\'/files/REX_FILE[1]\" width=\"100\">\';\r\n}\r\n\r\n?>','','REX_MEDIA_BUTTON[1]\r\n\r\n<?\r\n\r\nif (\"REX_FILE[1]\" != \"\")\r\n{\r\n echo \"<img src=$REX[HTDOCS_PATH]files/REX_FILE[1]>\";\r\n}\r\n?>','','0','0','','','','0','0');
INSERT INTO rex_modultyp VALUES ('6','','02 - Articlellist','0','<?\r\n\r\n$cat = OOCategory::getCategoryById($this->getValue(\"category_id\"));\r\n$article = $cat->getArticles();\r\n\r\n\r\nif (is_array($article)) {\r\n	foreach ($article as $var) {\r\n\r\n	$articleId		= $var->getId();\r\n	$articleName		= $var->getName();\r\n	$articleDescription	= $var->getDescription();\r\n	\r\n		if ($var->getValue(_startpage) != 1) {\r\n			echo \'<div class=\"article-list\"><h2>\'.$articleName.\'</h2><p>\'.$articleDescription.\'</p><p><a href=\"\'.rex_getUrl($articleId).\'\">mehr >></a></p></div>\';\r\n		}\r\n	}\r\n}\r\n?>','','','','0','0','','','','0','0');
INSERT INTO rex_modultyp VALUES ('7','','01 - Headline','0','<REX_VALUE[2]>REX_VALUE[1]</REX_VALUE[2]>','','&Uuml;berschrift:<br />\r\n<input type=\"text\" size=\"50\" name=\"VALUE[1]\" value=\"REX_VALUE[1]\" />\r\n<select name=\"VALUE[2]\" >\r\n<?php\r\nforeach (array(\"h1\",\"h2\",\"h3\",\"h4\",\"h5\",\"h6\") as $value) {\r\n	echo \'<option value=\"\'.$value.\'\" \';\r\n	\r\n	if ( \"REX_VALUE[2]\"==\"$value\" ) {\r\n		echo \'selected=\"selected\" \';\r\n	}\r\n	echo \'>\'.$value.\'</option>\';\r\n}\r\n?>\r\n</select>','','0','0','','','','0','0');
DROP TABLE IF EXISTS rex_template;
CREATE TABLE rex_template ( id int(11) NOT NULL  auto_increment, label varchar(255) NOT NULL  , name varchar(255) NOT NULL  , content text NOT NULL  , bcontent text NOT NULL  , active tinyint(1) NOT NULL DEFAULT 0  , date timestamp(14) NULL  , createuser varchar(255) NOT NULL  , updateuser varchar(255) NOT NULL  , createdate int(11) NOT NULL DEFAULT 0  , updatedate int(11) NOT NULL DEFAULT 0  , PRIMARY KEY(id))TYPE=MyISAM;
INSERT INTO rex_template VALUES ('1','','Default','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"de\" lang=\"de\">\r\n<head>\r\n<meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-1\" />\r\n<title>REDAXO SimpleDemo - <? echo $this->getValue(\"name\"); ?></title>\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"files/main.css\" media=\"screen\" />\r\n<script type=\"text/javascript\" src=\"js/standard.js\"></script>\r\n<script type=\"text/javascript\" src=\"js/flashdetect.js\"></script>\r\n</head>\r\n<body>\r\n<div><a name=\"top\"></a></div>\r\n<div id=\"website\">\r\n\r\n<!-- start #content -->	\r\n	<div id=\"content\">\r\n	<div id=\"content2\">\r\n		\r\n		<div id=\"main-block\">\r\n		<div id=\"main-block2\">\r\n			<?php\r\n				print \'<h1>\'.$this->getValue(name).\'</h1>\';\r\n				print ($this->getArticle()); \r\n			?>\r\n		</div>\r\n		</div>\r\n			\r\n		<div id=\"sub-block\">\r\n		<div id=\"sub-block2\">\r\n			<?php\r\n			\r\n			echo \'<ul class=\"navigation\">\';\r\n			foreach (OOCategory::getRootCategories() as $lev1):\r\n				if($lev1->isOnline()):\r\n					echo \'<li><a href=\"\'.$lev1->getUrl().\'\">\'.$lev1->getName().\'</a>\';\r\n		\r\n		\r\n					$lev1Size = sizeof($lev1->getChildren());\r\n					if($lev1Size != \"0\"):\r\n						echo \'<ul>\';\r\n						foreach ($lev1->getChildren() as $lev2):\r\n\r\n							if ($lev2->isOnline()):\r\n								echo \'<li><a href=\"\'.$lev2->getUrl().\'\">\'.$lev2->getName().\'</a></li>\';\r\n							endif;\r\n						endforeach;\r\n						echo \'</ul>\';\r\n					endif;\r\n		\r\n		\r\n				echo \'</li>\';		\r\n				endif;\r\n\r\n			endforeach;\r\n			echo \'</ul>\';\r\n			/*\r\n				$navigation = OOTemplate::getNavigation();\r\n				print $navigation;\r\n			*/\r\n			?>\r\n			\r\n		</div>\r\n		</div>\r\n		<br class=\"clear\" />\r\n	\r\n	</div>\r\n	</div>\r\n<!-- end #content -->\r\n\r\n\r\n	<div id=\"footer\">\r\n		<p class=\"flLeft\">Copyright 2005 by REDAXO Group</p>\r\n		<p class=\"flRight\">CMS: Redaxo - Website: XHTML, CSS</p>\r\n		<br class=\"clear\" />\r\n	</div>\r\n\r\n</div> <!-- end #website -->\r\n</body>\r\n\r\n</html>','','1','20050704110831','','','0','0');
