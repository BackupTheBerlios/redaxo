## Redaxo Database Dump Version 3.0 
DROP TABLE IF EXISTS rex_5_article_comment;
CREATE TABLE rex_5_article_comment ( id int(11) NOT NULL  auto_increment, user_id int(11) NULL DEFAULT 0  , article_id int(11) NULL DEFAULT 0  , comment text NULL  , stamp int(11) NULL DEFAULT 0  , status tinyint(4) NULL DEFAULT 0  , PRIMARY KEY(id))TYPE=MyISAM;
DROP TABLE IF EXISTS rex_5_board;
CREATE TABLE rex_5_board ( message_id int(11) NOT NULL  auto_increment, re_message_id int(11) NULL DEFAULT 0  , board_id varchar(255) NULL  , user_id int(11) NULL DEFAULT 0  , replies int(11) NULL DEFAULT 0  , last_entry varchar(14) NULL  , subject varchar(255) NULL  , message text NULL  , stamp varchar(14) NULL  , status int(11) NULL DEFAULT 1  , anonymous_user varchar(50) NULL  , PRIMARY KEY(message_id))TYPE=MyISAM;
DROP TABLE IF EXISTS rex_5_session;
CREATE TABLE rex_5_session ( session varchar(50) NOT NULL  , user_id int(11) NULL DEFAULT 0  , name varchar(50) NULL  , stamp int(11) NULL DEFAULT 0  , PRIMARY KEY(session))TYPE=MyISAM;
DROP TABLE IF EXISTS rex_5_user;
CREATE TABLE rex_5_user ( id int(11) NOT NULL  auto_increment, login varchar(255) NULL  , psw varchar(255) NULL  , email varchar(255) NULL  , name varchar(255) NULL  , firstname varchar(255) NULL  , sex char(1) NULL  , singlestatus varchar(25) NULL DEFAULT 0  , street varchar(255) NULL  , zip varchar(5) NULL  , city varchar(255) NULL  , phone varchar(255) NULL  , fax varchar(255) NULL  , mobil varchar(255) NULL  , posx int(11) NULL DEFAULT 0  , posy int(11) NULL DEFAULT 0  , file varchar(255) NULL  , birthday varchar(14) NULL DEFAULT 0  , interests text NULL  , motto text NULL  , ilike text NULL  , aboutme text NULL  , size varchar(255) NULL  , wheight varchar(255) NULL  , color_eyes varchar(255) NULL  , color_hair varchar(255) NULL  , profession varchar(255) NULL  , homepage varchar(255) NULL  , newsletter tinyint(1) NULL DEFAULT 0  , check1 tinyint(1) NULL DEFAULT 0  , check2 tinyint(1) NULL DEFAULT 0  , check3 tinyint(1) NULL DEFAULT 0  , check4 tinyint(1) NULL DEFAULT 0  , amount_profile_viewed int(11) NULL DEFAULT 0  , amount_comments int(11) NULL DEFAULT 0  , amount_board_topics int(11) NULL DEFAULT 0  , amount_board_replies int(11) NULL DEFAULT 0  , amount_mail_inbox int(11) NULL DEFAULT 0  , amount_mail_outbox int(11) NULL DEFAULT 0  , showinfo tinyint(1) NULL DEFAULT 0  , first_login int(11) NULL DEFAULT 0  , last_login int(11) NULL DEFAULT 0  , last_action int(11) NULL DEFAULT 0  , stamp int(11) NULL DEFAULT 0  , status tinyint(4) NULL DEFAULT 1  , PRIMARY KEY(id))TYPE=MyISAM;
DROP TABLE IF EXISTS rex_5_user_comment;
CREATE TABLE rex_5_user_comment ( id int(11) NOT NULL  auto_increment, user_id int(11) NULL DEFAULT 0  , from_user_id int(11) NULL DEFAULT 0  , message text NULL  , stamp varchar(14) NULL  , status tinyint(1) NULL DEFAULT 0  , PRIMARY KEY(id))TYPE=MyISAM;
DROP TABLE IF EXISTS rex_5_user_mail;
CREATE TABLE rex_5_user_mail ( id int(11) NOT NULL  auto_increment, user_id int(11) NULL DEFAULT 0  , from_user_id int(11) NULL DEFAULT 0  , message text NULL  , stamp varchar(14) NULL  , status tinyint(1) NULL DEFAULT 0  , PRIMARY KEY(id))TYPE=MyISAM;
DROP TABLE IF EXISTS rex_action;
CREATE TABLE rex_action ( id int(11) NOT NULL  auto_increment, name varchar(255) NULL  , action text NULL  , prepost tinyint(4) NULL DEFAULT 0  , status tinyint(4) NULL DEFAULT 0  , PRIMARY KEY(id))TYPE=MyISAM;
DROP TABLE IF EXISTS rex_article;
CREATE TABLE rex_article ( id int(11) NULL DEFAULT 0  , re_id int(11) NULL DEFAULT 0  , name varchar(255) NULL  , catname varchar(255) NULL  , cattype int(11) NULL DEFAULT 0  , alias varchar(255) NULL  , description text NULL  , attribute text NULL  , file text NULL  , type_id int(11) NULL DEFAULT 0  , teaser tinyint(4) NULL DEFAULT 0  , startpage tinyint(1) NULL DEFAULT 0  , prior int(11) NULL DEFAULT 0  , path varchar(255) NULL  , status tinyint(1) NULL DEFAULT 0  , online_from int(11) NULL DEFAULT 0  , online_to int(11) NULL DEFAULT 0  , createdate int(11) NULL DEFAULT 0  , updatedate int(11) NULL DEFAULT 0  , keywords text NULL  , template_id int(5) NULL DEFAULT 0  , clang int(11) NULL DEFAULT 0  , createuser varchar(255) NULL  , updateuser varchar(255) NULL  )TYPE=MyISAM;
INSERT INTO rex_article VALUES ('1','0','Home','Home','0','','','','','0','0','1','1','|','1','2147483647','20100101','20050408','0','','1','0','','');
INSERT INTO rex_article VALUES ('1','0','Home','Home','0','','','','','0','0','1','1','|','1','2147483647','20100101','20050408','0','','1','2','','');
INSERT INTO rex_article VALUES ('1','0','erster ordner','erster ordner','0','','','','','0','0','1','1','|','1','2147483647','20100101','20050408','0','','0','10','','');
INSERT INTO rex_article VALUES ('2','0','Neuigkeiten','Neuigkeiten','0','','','','','0','0','1','1','|','1','2147483647','20100101','20050414','0','','1','0','','');
INSERT INTO rex_article VALUES ('2','0','News','News','0','','','','','0','0','1','1','|','1','2147483647','20100101','20050414','0','','1','2','','');
INSERT INTO rex_article VALUES ('3','0','Produkte','Produkte','0','','','','','0','0','1','1','|','1','2147483647','20100101','20050414','0','','1','0','','');
INSERT INTO rex_article VALUES ('3','0','Products','Products','0','','','','','0','0','1','1','|','1','2147483647','20100101','20050414','0','','1','2','','');
INSERT INTO rex_article VALUES ('4','0','Sitemap','Sitemap','0','','','','','0','0','1','1','|','1','2147483647','20100101','20050414','0','','1','0','','');
INSERT INTO rex_article VALUES ('4','0','Sitemap','Sitemap','0','','','','','0','0','1','1','|','1','2147483647','20100101','20050414','0','','1','2','','');
INSERT INTO rex_article VALUES ('5','0','Impressum','Impressum','0','','','','','0','0','1','1','|','1','2147483647','20100101','20050414','0','','1','0','','');
INSERT INTO rex_article VALUES ('5','0','Inprint','Inprint','0','','','','','0','0','1','1','|','1','2147483647','20100101','20050414','0','','1','2','','');
INSERT INTO rex_article VALUES ('6','0','Referenzen','Referenzen','0','','','','','0','0','1','1','|','1','2147483647','20100101','20050414','0','','1','0','','');
INSERT INTO rex_article VALUES ('6','0','References','Referenzen','0','','','','','0','0','1','1','|','1','2147483647','20100101','20050414','0','','1','2','','');
INSERT INTO rex_article VALUES ('7','3','Produkt A','Produkt A','0','','','','','0','0','1','1','|3|','1','2147483647','20100101','20050414','0','','1','0','','');
INSERT INTO rex_article VALUES ('7','3','Product A','Product A','0','','','','','0','0','1','1','|3|','1','2147483647','20100101','20050414','0','','1','2','','');
INSERT INTO rex_article VALUES ('8','3','Produkt B','Produkt B','0','','','','','0','0','1','1','|3|','1','2147483647','20100101','20050414','0','','1','0','','');
INSERT INTO rex_article VALUES ('8','3','Product B','Product B','0','','','','','0','0','1','1','|3|','1','2147483647','20100101','20050414','0','','1','2','','');
INSERT INTO rex_article VALUES ('9','3','Produkt C','Produkt C','0','','','','','0','0','1','1','|3|','1','2147483647','20100101','20050414','0','','1','0','','');
INSERT INTO rex_article VALUES ('9','3','Product C','Product C','0','','','','','0','0','1','1','|3|','1','2147483647','20100101','20050414','0','','1','2','','');
INSERT INTO rex_article VALUES ('10','3','Produkt D','Produkt D','0','','','','','0','0','1','1','|3|','1','2147483647','20100101','20050414','0','','1','0','','');
INSERT INTO rex_article VALUES ('10','3','Product D','Product D','0','','','','','0','0','1','1','|3|','1','2147483647','20100101','20050414','0','','1','2','','');
DROP TABLE IF EXISTS rex_article_slice;
CREATE TABLE rex_article_slice ( id int(11) NOT NULL  auto_increment, clang int(11) NULL DEFAULT 0  , ctype int(11) NULL DEFAULT 0  , re_article_slice_id int(11) NOT NULL DEFAULT 0  , value1 text NULL  , value2 text NULL  , value3 text NULL  , value4 text NULL  , value5 text NULL  , value6 text NULL  , value7 text NULL  , value8 text NULL  , value9 text NULL  , value10 text NULL  , value11 text NULL  , value12 text NULL  , value13 text NULL  , value14 text NULL  , value15 text NULL  , value16 text NULL  , value17 text NULL  , value18 text NULL  , value19 text NULL  , value20 text NULL  , file1 varchar(255) NULL  , file2 varchar(255) NULL  , file3 varchar(255) NULL  , file4 varchar(255) NULL  , file5 varchar(255) NULL  , file6 varchar(255) NULL  , file7 varchar(255) NULL  , file8 varchar(255) NULL  , file9 varchar(255) NULL  , file10 varchar(255) NULL  , filelist1 text NULL  , filelist2 text NULL  , filelist3 text NULL  , filelist4 text NULL  , filelist5 text NULL  , filelist6 text NULL  , filelist7 text NULL  , filelist8 text NULL  , filelist9 text NULL  , filelist10 text NULL  , link1 int(11) NULL DEFAULT 0  , link2 int(11) NULL DEFAULT 0  , link3 int(11) NULL DEFAULT 0  , link4 int(11) NULL DEFAULT 0  , link5 int(11) NULL DEFAULT 0  , link6 int(11) NULL DEFAULT 0  , link7 int(11) NULL DEFAULT 0  , link8 int(11) NULL DEFAULT 0  , link9 int(11) NULL DEFAULT 0  , link10 int(11) NULL DEFAULT 0  , linklist1 text NULL  , linklist2 text NULL  , linklist3 text NULL  , linklist4 text NULL  , linklist5 text NULL  , linklist6 text NULL  , linklist7 text NULL  , linklist8 text NULL  , linklist9 text NULL  , linklist10 text NULL  , php text NULL  , html text NULL  , article_id int(11) NOT NULL DEFAULT 0  , modultyp_id int(5) NOT NULL DEFAULT 0  , createdate int(11) NULL DEFAULT 0  , updatedate int(11) NULL DEFAULT 0  , createuser varchar(255) NULL  , updateuser varchar(255) NULL  , PRIMARY KEY(id,re_article_slice_id,article_id,modultyp_id))TYPE=MyISAM;
INSERT INTO rex_article_slice VALUES ('12','2','0','10','<p>ola the forestfee.</p><p>a little <span class=\"red\">senseless </span>description<br />||||||+N+||||||in <span class=\"blue\">different</span> colors.<br />||||||+N+||||||</p>','','','','','','','','0','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','1','5','0','0','','');
INSERT INTO rex_article_slice VALUES ('11','0','0','9','<p>und <span class=\"red\">hier </span>mien text</p><p>holla die waldfee<br />||||||+N+||||||und hier <span class=\"blue\">gehts</span> weiter <br />||||||+N+||||||</p>','','','','','','','','0','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','1','5','0','0','','');
INSERT INTO rex_article_slice VALUES ('10','2','0','0','My Homepage','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','1','6','0','0','','');
INSERT INTO rex_article_slice VALUES ('9','0','0','0','Meine Homepage','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','1','6','0','0','','');
DROP TABLE IF EXISTS rex_article_type;
CREATE TABLE rex_article_type ( type_id int(5) NOT NULL  auto_increment, name varchar(255) NULL  , description text NULL  , PRIMARY KEY(type_id))TYPE=MyISAM;
INSERT INTO rex_article_type VALUES ('1','Standard','Zugriff f�r alle');
DROP TABLE IF EXISTS rex_clang;
CREATE TABLE rex_clang ( id int(11) NOT NULL DEFAULT 0  , name varchar(255) NULL  , PRIMARY KEY(id))TYPE=MyISAM;
INSERT INTO rex_clang VALUES ('0','deutsch');
INSERT INTO rex_clang VALUES ('2','english');
DROP TABLE IF EXISTS rex_file;
CREATE TABLE rex_file ( file_id int(11) NOT NULL  auto_increment, ctype int(11) NULL DEFAULT 0  , re_file_id int(11) NULL DEFAULT 0  , category_id int(11) NULL DEFAULT 0  , filetype varchar(255) NULL  , filename varchar(255) NULL  , originalname varchar(255) NULL  , filesize varchar(255) NULL  , width int(11) NULL DEFAULT 0  , height int(11) NULL DEFAULT 0  , title varchar(255) NULL  , description text NULL  , copyright varchar(255) NULL  , stamp int(11) NULL DEFAULT 0  , user_login varchar(255) NULL  , createdate int(11) NULL DEFAULT 0  , updatedate int(11) NULL DEFAULT 0  , createuser varchar(255) NULL  , updateuser varchar(255) NULL  , PRIMARY KEY(file_id))TYPE=MyISAM;
INSERT INTO rex_file VALUES ('2','0','0','2','image/gif','m.gif','m.gif','102','0','0','','','','1090419953','','0','0','','');
INSERT INTO rex_file VALUES ('3','0','0','2','image/gif','w.gif','w.gif','103','0','0','','','','1090419960','','0','0','','');
INSERT INTO rex_file VALUES ('4','0','0','2','image/jpeg','banner.jpg','banner.jpg','10913','0','0','','','','1090420572','','0','0','','');
INSERT INTO rex_file VALUES ('5','0','0','2','image/gif','o.gif','o.gif','85','0','0','','','','1090420702','','0','0','','');
INSERT INTO rex_file VALUES ('6','0','0','2','image/gif','u.gif','u.gif','87','0','0','','','','1090420707','','0','0','','');
INSERT INTO rex_file VALUES ('7','0','0','2','image/gif','na.gif','na.gif','54','0','0','','','','1090420730','','0','0','','');
INSERT INTO rex_file VALUES ('8','0','0','2','image/gif','np.gif','np.gif','54','0','0','','','','1090420735','','0','0','','');
INSERT INTO rex_file VALUES ('9','0','0','2','image/gif','head_links.gif','head_links.gif','344','0','0','','','','1090421393','','0','0','','');
INSERT INTO rex_file VALUES ('10','0','0','2','image/gif','kdummy.gif','kdummy.gif','289','0','0','','','','1090421406','','0','0','','');
INSERT INTO rex_file VALUES ('11','0','0','2','image/gif','sbg.gif','sbg.gif','97','0','0','','','','1090421555','','0','0','','');
INSERT INTO rex_file VALUES ('12','0','0','2','image/gif','bg.gif','bg.gif','307','0','0','','','','1090421559','','0','0','','');
INSERT INTO rex_file VALUES ('16','0','0','2','image/gif','a.gif','a.gif','91','0','0','','','','1090586371','','0','0','','');
INSERT INTO rex_file VALUES ('14','0','0','2','image/gif','logo.gif','logo.gif','1322','0','0','','','','1090421738','','0','0','','');
INSERT INTO rex_file VALUES ('15','0','0','3','text/css','style.css','style.css','804','0','0','','','','1090421793','','0','0','','');
INSERT INTO rex_file VALUES ('17','0','0','2','image/gif','e.gif','e.gif','87','0','0','','','','1090586377','','0','0','','');
INSERT INTO rex_file VALUES ('18','0','0','2','image/gif','n.gif','n.gif','62','0','0','','','','1090586383','','0','0','','');
INSERT INTO rex_file VALUES ('20','0','0','3','text/css','import.css','C:PHPuploadtempphp41.tmp','1142','0','0','','','','1098972872','','0','0','','');
INSERT INTO rex_file VALUES ('21','0','0','3','text/css','articlelist.css','articlelist.css','1450','0','0','','','','1098972710','','0','0','','');
INSERT INTO rex_file VALUES ('22','0','0','3','text/css','board_open.css','C:PHPuploadtempphp7A.tmp','3161','0','0','','','','1099074289','','0','0','','');
INSERT INTO rex_file VALUES ('23','0','0','3','text/css','calendar.css','calendar.css','2003','0','0','','','','1098972718','','0','0','','');
INSERT INTO rex_file VALUES ('24','0','0','3','text/css','categorylist.css','categorylist.css','1189','0','0','','','','1098972722','','0','0','','');
INSERT INTO rex_file VALUES ('25','0','0','3','text/css','contact.css','contact.css','2904','0','0','','','','1098972725','','0','0','','');
INSERT INTO rex_file VALUES ('26','0','0','3','text/css','headlines.css','headlines.css','3182','0','0','','','','1098972730','','0','0','','');
INSERT INTO rex_file VALUES ('27','0','0','3','text/css','main.css','C:PHPuploadtempphp43.tmp','2955','0','0','','','','1098973463','','0','0','','');
INSERT INTO rex_file VALUES ('28','0','0','3','text/css','menu.css','menu.css','3540','0','0','','','','1098972737','','0','0','','');
INSERT INTO rex_file VALUES ('29','0','0','3','text/css','productdesc.css','productdesc.css','1222','0','0','','','','1098972740','','0','0','','');
INSERT INTO rex_file VALUES ('30','0','0','3','text/css','sitemap.css','sitemap.css','1371','0','0','','','','1098972743','','0','0','','');
INSERT INTO rex_file VALUES ('31','0','0','3','text/css','text.css','text.css','781','0','0','','','','1098972746','','0','0','','');
INSERT INTO rex_file VALUES ('32','0','0','2','image/gif','t.gif','t.gif','91','0','0','','','','1098973592','','0','0','','');
INSERT INTO rex_file VALUES ('33','0','0','1','image/gif','cat29.gif','cat29.gif','2179','76','19','','','','1107026916','','0','0','','');
DROP TABLE IF EXISTS rex_file_category;
CREATE TABLE rex_file_category ( id int(11) NOT NULL DEFAULT 0  , name varchar(255) NULL  , re_id int(11) NULL DEFAULT 0  , path varchar(255) NULL  , clang int(11) NULL DEFAULT 0  , hide tinyint(4) NULL DEFAULT 0  , createdate int(11) NULL DEFAULT 0  , updatedate int(11) NULL DEFAULT 0  , createuser varchar(255) NULL  , updateuser varchar(255) NULL  , PRIMARY KEY(id))TYPE=MyISAM;
INSERT INTO rex_file_category VALUES ('1','Bilder','0','','0','1','0','0','','');
INSERT INTO rex_file_category VALUES ('2','Hilfsgrafiken','0','','0','1','0','0','','');
INSERT INTO rex_file_category VALUES ('3','Stylesheet','0','','0','1','0','0','','');
DROP TABLE IF EXISTS rex_help;
CREATE TABLE rex_help ( id int(11) NOT NULL  auto_increment, page varchar(255) NULL  , name varchar(255) NULL  , description text NULL  , comment text NULL  , lang varchar(255) NULL  , PRIMARY KEY(id))TYPE=MyISAM;
DROP TABLE IF EXISTS rex_module_action;
CREATE TABLE rex_module_action ( id int(11) NOT NULL  auto_increment, module_id int(11) NULL DEFAULT 0  , action_id int(11) NULL DEFAULT 0  , PRIMARY KEY(id))TYPE=MyISAM;
DROP TABLE IF EXISTS rex_modultyp;
CREATE TABLE rex_modultyp ( id int(5) NOT NULL  auto_increment, label varchar(255) NULL  , name varchar(255) NULL  , category_id int(11) NOT NULL DEFAULT 0  , ausgabe text NULL  , bausgabe text NULL  , eingabe text NULL  , func text NULL  , php_enable tinyint(1) NOT NULL DEFAULT 0  , html_enable tinyint(1) NOT NULL DEFAULT 0  , perm_category text NULL  , PRIMARY KEY(id,category_id,php_enable,html_enable))TYPE=MyISAM;
INSERT INTO rex_modultyp VALUES ('1','','00.01 - php','0','REX_PHP','','PHP:<br>||||||+N+||||||<textarea name=INPUT_PHP cols=80 rows=20 class=inp100>REX_PHP</textarea>||||||+N+||||||<br><br>','','0','0','');
INSERT INTO rex_modultyp VALUES ('2','','02.03 - Text [NO WYSIWYG]','0','<div class=Text>REX_VALUE[1]</div>','','<?php||||||+N+||||||||||||+N+||||||MEDIA_HTMLAREA(1,\"REX_VALUE[1]\");||||||+N+||||||||||||+N+||||||?>','','0','0','');
INSERT INTO rex_modultyp VALUES ('3','','01.01 - Board','0','<?||||||+N+||||||||||||+N+||||||$board = new board;||||||+N+||||||$board->setDB(1);||||||+N+||||||$board->setTable(\"rex__board\");||||||+N+||||||$board->setDocname(\"index.php\");||||||+N+||||||$board->addLink(\"article_id\",REX_ARTICLE_ID);||||||+N+||||||$board->setBoardname(\"REX_VALUE[1]\");||||||+N+||||||$board->setRealBoardname(\"REX_VALUE[2]\");||||||+N+||||||$board->anonymous = true;||||||+N+||||||||||||+N+||||||echo $board->showBoard();||||||+N+||||||||||||+N+||||||?>','','Bitte gib die Boardbezeichnung ein:<br>||||||+N+||||||<input type=text size=50 name=VALUE[2] value=\"REX_VALUE[2]\">||||||+N+||||||||||||+N+||||||<br><br>Bitte gib den Boardname f�r die Datenbank ein:<br>||||||+N+||||||<input type=text size=50 name=VALUE[1] value=\"REX_VALUE[1]\">||||||+N+||||||||||||+N+||||||<br><br>','','0','0','');
INSERT INTO rex_modultyp VALUES ('11','','03.03 - Kategorienliste','0','<?||||||+N+||||||||||||+N+||||||$GC = new sql;||||||+N+||||||// $GC->debugsql = 1;||||||+N+||||||$GC->setQuery(\"select * from rex_category,rex_article ||||||+N+||||||where ||||||+N+||||||rex_category.re_category_id=\'REX_CATEGORY_ID\' and ||||||+N+||||||rex_article.startpage=1 and ||||||+N+||||||rex_article.category_id=rex_category.id  ||||||+N+||||||order by rex_article.prior,rex_article.name\");||||||+N+||||||||||||+N+||||||||||||+N+||||||for ($i=0;$i<$GC->getRows();$i++)||||||+N+||||||{||||||+N+||||||||||||+N+|||||| if ($i!=0)  echo \"<img src=$REX[HTDOCS_PATH]/pics/lgrey.gif width=450 height=1 vspace=10>\";||||||+N+||||||||||||+N+|||||| if ($GC->getValue(\"rex_article.file\") != \"\") $file = \"<img src=$REX[HTDOCS_PATH]/files/\".$GC->getValue(\"rex_article.file\").\" width=155 height=90>\";||||||+N+|||||| else $file = \"<img src=$REX[HTDOCS_PATH]/files/kdummy.gif width=155 height=90 border=0>\";||||||+N+||||||||||||+N+|||||| // $file = \"&nbsp;\";||||||+N+|||||| ||||||+N+|||||| echo \"<div class=Categorylist>\";||||||+N+|||||| echo \"<div class=CategorylistPic>$file</div>\";||||||+N+|||||| echo \"<div class=CategorylistArticle>\";||||||+N+||||||||||||+N+|||||| echo \"<div class=CategorylistArticleName>\".htmlentities($GC->getValue(\"rex_article.name\")).\"</div>||||||+N+||||||\".nl2br(htmlentities($GC->getValue(\"rex_article.beschreibung\"))).\"<br>&raquo;&nbsp;<a href=index.php?article_id=\".$GC->getValue(\"rex_article.id\").\">Detailinformationen</a>\";||||||+N+||||||||||||+N+|||||| echo \"</div>\";||||||+N+|||||| echo \"</div>\";||||||+N+||||||||||||+N+||||||||||||+N+|||||| $GC->next();||||||+N+||||||}||||||+N+||||||||||||+N+||||||?>','','','','0','0','');
INSERT INTO rex_modultyp VALUES ('5','','02.02 - Text [WYSIWYG]','0','<table width=\"100%\" cellpadding=0 cellspacing=0 border=0>||||||+N+||||||<tr>||||||+N+||||||||||||+N+||||||<td><font class=content>REX_HTML_VALUE[1]</font></td>||||||+N+||||||||||||+N+||||||</tr></table><?php||||||+N+||||||||||||+N+||||||if (\"REX_VALUE[9]\" == \"1\") echo \"<br>\";||||||+N+||||||if (\"REX_VALUE[9]\" == \"2\") echo \"<br><br>\";||||||+N+||||||||||||+N+||||||?>','','Bitte gib den Text ein der zu Sehen sein soll:<br>||||||+N+||||||<?php||||||+N+||||||||||||+N+||||||$a = new editor();||||||+N+||||||$a->buttonrow1 = \"styleselect,separator,bold,italic,separator,bullist,numlist\";||||||+N+||||||$a->buttonrow2 = \"link,linkHack,unlink,insertEmail,separator,removeformat,pasteRichtext,code\";||||||+N+||||||$a->buttonrow3 = \"tablecontrols, separator, visualaid\";||||||+N+||||||$a->buttonrow4 = \"rowseparator,formatselect,fontselect,fontsizeselect,forecolor,charmap\";||||||+N+||||||$a->stylesheet = \"/redaxo3_0/files/text.css\";||||||+N+||||||$a->content = \"REX_VALUE[1]\";||||||+N+||||||$a->id = 1;||||||+N+||||||$a->show();||||||+N+||||||||||||+N+||||||// mit umbruch ?||||||+N+||||||echo \"<br><br><select name=VALUE[9] size=1><option value=\'1\'\";||||||+N+||||||if (\"REX_VALUE[9]\" == \"1\") echo \" selected\";||||||+N+||||||echo \">Mit einfachem Umbruch</option><option value=\'2\'\";||||||+N+||||||if (\"REX_VALUE[9]\" == \"2\") echo \" selected\";||||||+N+||||||echo \">Mit doppeltem Umbruch</option><option value=\'0\'\";||||||+N+||||||if (\"REX_VALUE[9]\" == \"0\" or \"REX_VALUE[9]\" == \"\") echo \" selected\";||||||+N+||||||echo \">Ohne Umbruch</option></select>\";||||||+N+||||||||||||+N+||||||?>','','0','0','');
INSERT INTO rex_modultyp VALUES ('6','','02.01 - Headline','0','<div class=Headline>REX_VALUE[1]</div>','','Headline:||||||+N+||||||<br><input type=text size=30 name=VALUE[1] value=\"REX_VALUE[1]\" class=inp100>||||||+N+||||||<br><br>||||||+N+||||||||||||+N+||||||','','0','0','');
INSERT INTO rex_modultyp VALUES ('8','','03.01 - Artikelliste','0','<div class=ArticlelistContainer>||||||+N+||||||<?||||||+N+||||||||||||+N+||||||if (\"REX_VALUE[1]\" == 2) $sql = \"select * from rex_article where startpage=0 and checkbox01=1 and status=1 order by rex_article.prior\";||||||+N+||||||else if (\"REX_VALUE[1]\" == 1) $sql = \"select * from rex_article where rex_article.category_id=\'REX_CATEGORY_ID\' and startpage=0 and checkbox01=1 and status=1 order by rex_article.prior\";||||||+N+||||||else $sql = \"select * from rex_article where rex_article.category_id=\'REX_CATEGORY_ID\' and startpage=0 and status=1 order by rex_article.prior\";||||||+N+||||||||||||+N+||||||$GC = new sql;||||||+N+||||||||||||+N+||||||// $GC->setQuery(\"select * from rex_article where rex_article.category_id=\'REX_CATEGORY_ID\' and startpage=0 and status=1 order by rex_article.prior\");||||||+N+||||||$GC->setQuery($sql);||||||+N+||||||||||||+N+||||||for ($i=0;$i<$GC->getRows();$i++)||||||+N+||||||{||||||+N+||||||||||||+N+|||||| if ($i!=0)  echo \"<!--||||||+N+|||||| 	||||||+N+|||||| 	<hr style=\'width:100%; height:1px;\' vspace=4> -->\";||||||+N+||||||||||||+N+|||||| $aid = $GC->getValue(\"rex_article.id\");||||||+N+||||||||||||+N+|||||| $jahr = substr($GC->getValue(\"rex_article.online_von\"),0,4);||||||+N+|||||| $monat = substr($GC->getValue(\"rex_article.online_von\"),4,2);||||||+N+|||||| $tag = substr($GC->getValue(\"rex_article.online_von\"),6,2);||||||+N+||||||||||||+N+|||||| $date = \"$tag.$monat.$jahr\";||||||+N+||||||||||||+N+|||||| echo \"<div class=ArticlelistArticle>\";||||||+N+|||||| echo \"<div class=ArticlelistHead>\";||||||+N+|||||| echo \"	<div class=ArticlelistHeadline>\".htmlentities($GC->getValue(\"rex_article.name\")).\"</div>\";||||||+N+|||||| echo \"	<div class=ArticlelistDate>\".htmlentities($date).\"</div>\";||||||+N+|||||| echo \"</div>\";||||||+N+|||||| echo \"<div>||||||+N+||||||		<div class=ArticlelistIntro>\";||||||+N+||||||||||||+N+|||||| if ($GC->getValue(\"rex_article.file\")!=\"\") echo \"||||||+N+||||||		<img src=<?=$REX[HTDOCS_PATH]?>/files/\".$GC->getValue(\"rex_article.file\").\" align=left style=\'border-right:10px #ffffff solid; border-bottom:10px #ffffff solid;\'>\";||||||+N+||||||||||||+N+|||||| echo htmlentities($GC->getValue(\"rex_article.beschreibung\")).\" \";||||||+N+||||||||||||+N+|||||| if ($REX[GG]) echo \"<a href=index.php?article_id=$aid><b>&raquo;&nbsp;mehr...</b></a>\";||||||+N+|||||| echo \"	</div></div>\";||||||+N+|||||| echo \"</div>\";||||||+N+||||||||||||+N+|||||| $GC->next();||||||+N+||||||}||||||+N+||||||||||||+N+||||||?>||||||+N+||||||</div>','','<?||||||+N+||||||||||||+N+||||||echo \"<br><br>Folgende Artikel sollen angezeigt werden:<br>\";||||||+N+||||||||||||+N+||||||$format = new select;||||||+N+||||||$format->set_name(\"VALUE[1]\");||||||+N+||||||$format->set_size(1);||||||+N+||||||$format->set_style(\"\' class=\'inp100\");||||||+N+||||||||||||+N+||||||$format->add_option(\"Alle Artikel aus dieser Kategorie\",0);||||||+N+||||||$format->add_option(\"Alle Artikel aus dieser Kategorie die als Teaser gekennzeichnet sind\",1);||||||+N+||||||$format->add_option(\"Alle Artikel die als Teaser gekennzeichnet sind\",2);||||||+N+||||||$format->set_selected(\"REX_VALUE[1]\");||||||+N+||||||echo $format->out();||||||+N+||||||||||||+N+||||||?><br><br>','','0','0','');
INSERT INTO rex_modultyp VALUES ('9','','03.02 - Artikeliste als Kalender','0','<?||||||+N+||||||||||||+N+||||||$category_id = $this->getValue(\"category_id\");||||||+N+||||||$path  = $this->getValue(\"path\");||||||+N+||||||preg_match_all(\"/-([0-9]+)/i\",$path,$match);||||||+N+||||||$spath = $match[0][0];||||||+N+||||||||||||+N+||||||$GC = new sql;||||||+N+||||||// $GC->debugsql = 1;||||||+N+||||||$GC->setQuery(\"select * from rex_article ||||||+N+||||||where ||||||+N+||||||(rex_article.path like \'$spath-%\' or rex_article.path=\'$spath\') and ||||||+N+||||||rex_article.startpage=0 and rex_article.status = 1 ||||||+N+||||||order by rex_article.prior,rex_article.name\");||||||+N+||||||||||||+N+||||||for ($i=0;$i<$GC->getRows();$i++)||||||+N+||||||{||||||+N+|||||| $KAL[$GC->getValue(\"rex_article.online_von\")] = $GC->getValue(\"rex_article.id\");||||||+N+|||||| $KALNAME[$GC->getValue(\"rex_article.online_von\")] = $GC->getValue(\"rex_article.name\");||||||+N+|||||| $GC->next();||||||+N+||||||}||||||+N+||||||||||||+N+||||||||||||+N+||||||// ----- KALENDER||||||+N+||||||||||||+N+||||||if ($FORM[date]!=\"\") ||||||+N+||||||{ ||||||+N+|||||| $FORM[year] = substr($FORM[date],0,4); ||||||+N+|||||| $FORM[month] = substr($FORM[date],4,2); ||||||+N+|||||| $FORM[day] = substr($FORM[date],6,2); ||||||+N+||||||} ||||||+N+||||||||||||+N+||||||if (!checkdate($FORM[month],$FORM[day],$FORM[year])) ||||||+N+||||||||||||+N+||||||{ ||||||+N+|||||| $FORM[year] = date(\"Y\"); ||||||+N+|||||| $FORM[month] = date(\"m\"); ||||||+N+|||||| $FORM[day] = date(\"d\"); ||||||+N+||||||} ||||||+N+||||||||||||+N+||||||$FORM[date] = $FORM[year].$FORM[month].$FORM[day]; ||||||+N+||||||||||||+N+||||||$today = date(\"Ymd\");||||||+N+||||||$FORM[link] = \"index.php?article_id=REX_ARTICLE_ID\";||||||+N+||||||$link = $FORM[link];||||||+N+||||||$month_days = date(\"j\",mktime(0,0,0,$FORM[month]+1,1,$FORM[year])-1);||||||+N+||||||$month_before = $FORM[month]-1;||||||+N+||||||$month_later = $FORM[month]+1;||||||+N+||||||$year_before = $FORM[year];||||||+N+||||||$year_later = $FORM[year];||||||+N+||||||if ($month_before<1){ $month_before = 12; $year_before= $year_before-1;}||||||+N+||||||if ($month_later>12){ $month_later = 1; $year_later= $year_later+1;}||||||+N+||||||if ($month_before<10){ $month_before = \"0$month_before\"; }||||||+N+||||||if ($month_later<10){ $month_later = \"0$month_later\"; }||||||+N+||||||$before = $year_before.$month_before.\"01\";||||||+N+||||||$later  = $year_later.$month_later.\"01\";||||||+N+||||||||||||+N+||||||$KALENDER .= \"||||||+N+||||||	<div class=Calendar>\";||||||+N+||||||$KALENDER .= \"||||||+N+||||||	<div class=CalendarHead>||||||+N+||||||		<div class=CalendarHeadLeft><a href=$link&FORM[date]=$before class=calhead><b>&laquo;</b></a>&nbsp;<a href=$link&FORM[date]=$later class=calhead><b>&raquo;</b></a></div>||||||+N+||||||		<div class=CalendarHeadRight>\".$FORM[month].\"/\".$FORM[year].\"</div>||||||+N+||||||	</div>\";||||||+N+||||||$KALENDER .= \"||||||+N+||||||	<div class=CalendarWeekdays>||||||+N+||||||		<span>Mo</span>||||||+N+||||||		<span>Tu</span>||||||+N+||||||		<span>We</span>||||||+N+||||||		<span>Th</span>||||||+N+||||||		<span>Fr</span>||||||+N+||||||		<span>Sa</span>||||||+N+||||||		<span>Su</span>||||||+N+||||||	</div>\";||||||+N+||||||	||||||+N+||||||$k = 1;||||||+N+||||||for ($i=1;$i<7;$i++)||||||+N+||||||{||||||+N+|||||| $KALENDER .= \"||||||+N+||||||	<div class=CalendarDays>\";||||||+N+||||||	||||||+N+|||||| for($j=0;$j<7;$j++)||||||+N+|||||| {||||||+N+||||||  $k = $k + 0;||||||+N+||||||  if ($k<10) $k=\"0$k\";||||||+N+||||||  if ($FORM[month]<10) $comp_month=\"\".$FORM[month]; ||||||+N+||||||  else $comp_month=$FORM[month];||||||+N+||||||  $which_weekday = date(\"w\",mktime(0,0,0,$FORM[month],$k-1,$FORM[year]));||||||+N+||||||  if ($which_weekday == $j and $month_days>=$k)||||||+N+||||||  { 	||||||+N+||||||   $loop_day = $FORM[year].\"$comp_month$k\";||||||+N+||||||   $KALENDER .= \"||||||+N+||||||		<span\";||||||+N+||||||   if ($FORM[date] == $loop_day) $KALENDER .= \" class=CalendarDaysActive>\";||||||+N+||||||   elseif ($today == $loop_day) $KALENDER .= \" class=CalendarDaysIdontknow>\";||||||+N+||||||   elseif ($j == 5 or $j == 6) $KALENDER .= \" class=CalendarDaysWeekenddays>\";||||||+N+||||||   else $KALENDER .= \" class=CalendarDaysWeekdays>\";||||||+N+||||||   if ($KAL[$loop_day] != \"\") $KALENDER .= \"<a href=index.php?article_id=\".$KAL[$loop_day].\"&FORM[date]=$loop_day>$k</a>\";||||||+N+||||||   else $KALENDER .= \"$k\";||||||+N+||||||   $KALENDER .= \"||||||+N+||||||		</span>\";||||||+N+||||||   $k++;||||||+N+||||||  }else||||||+N+||||||  {||||||+N+||||||   $KALENDER .= \"<span></span>\";||||||+N+||||||  }||||||+N+|||||| }||||||+N+|||||| $KALENDER .= \"</div>\";||||||+N+|||||| if ($month_days<$k) break;||||||+N+||||||}||||||+N+||||||$KALENDER .= \"</div>\";||||||+N+||||||||||||+N+||||||// ----- / KALENDER||||||+N+||||||||||||+N+||||||echo \"<div class=CalendarContainer>$KALENDER<div class=Clear>&nbsp;</div></div>\";||||||+N+||||||||||||+N+||||||?>','','<br><br>','','0','0','');
INSERT INTO rex_modultyp VALUES ('10','','04.01 - Bild','0','<?||||||+N+||||||||||||+N+||||||if (\"FILE[1]\" != \"\")||||||+N+||||||{||||||+N+|||||| echo \"<img src=$REX[HTDOCS_PATH]/files/FILE[1] width=100>\";||||||+N+||||||}||||||+N+||||||||||||+N+||||||?><br><br>','','REX_MEDIA_BUTTON[1]||||||+N+||||||||||||+N+||||||<?||||||+N+||||||||||||+N+||||||if (\"FILE[1]\" != \"\")||||||+N+||||||{||||||+N+|||||| echo \"<img src=$REX[HTDOCS_PATH]/files/FILE[1]>\";||||||+N+||||||}||||||+N+||||||||||||+N+||||||?><br><br>','','0','0','');
DROP TABLE IF EXISTS rex_template;
CREATE TABLE rex_template ( id int(5) NOT NULL  auto_increment, label varchar(255) NULL  , name varchar(255) NULL  , content text NULL  , bcontent text NULL  , active tinyint(1) NULL DEFAULT 0  , date timestamp(14) NULL  , PRIMARY KEY(id))TYPE=MyISAM;
INSERT INTO rex_template VALUES ('1','','01.01 Default','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/2000/REC-xhtml1-20000126/DTD/xhtml1-transitional.dtd\">||||||+N+||||||<html>||||||+N+||||||<?||||||+N+||||||||||||+N+||||||setlocale(LC_ALL,\"de_DE\");||||||+N+||||||||||||+N+||||||?>||||||+N+||||||<head>||||||+N+||||||<title>Redaxo Demo 2.1 - CSS</title>||||||+N+||||||<link rel=stylesheet type=text/css href=<? echo $REX[HTDOCS_PATH] ?>files/import.css>||||||+N+||||||<script language=Javascript src=<? echo $REX[HTDOCS_PATH] ?>js/standard.js></script>||||||+N+||||||<script language=Javascript src=<? echo $REX[HTDOCS_PATH] ?>js/flashdetect.js></script>||||||+N+||||||||||||+N+||||||||||||+N+||||||</head>||||||+N+||||||<body>||||||+N+||||||<a name=top></a>||||||+N+||||||<div class=\"Website\">||||||+N+||||||||||||+N+||||||||||||+N+||||||	<div class=\"LeftContainer\">||||||+N+||||||		<div class=\"Logo\"><img src=<? echo $REX[HTDOCS_PATH] ?>files/logo.gif></div>||||||+N+||||||		<div class=\"MenuContainer\"><? include $REX[INCLUDE_PATH].\"/generated/templates/2.template\"; ?></div>||||||+N+||||||	</div>		||||||+N+||||||||||||+N+||||||||||||+N+||||||	<div class=\"RightContainer\">||||||+N+||||||		<div class=\"Banner\"><? include $REX[INCLUDE_PATH].\"/generated/templates/5.template\"; ?></div>||||||+N+||||||		<div class=\"ContentContainer\"><? echo $this->getArticle(); ?></div>||||||+N+||||||||||||+N+||||||	<div class=\"Copyright\">created 2004 by <a href=http://www.pergopa.de target=_blank>pergopa kristinus gbr</a> |  <a href=<? echo rex_getUrl(12,$clang);?>>Impressum</a> | wcms: <a href=http://www.redaxo.de target=_blank>redaxo 2.7</a></div>||||||+N+||||||	</div>||||||+N+||||||||||||+N+||||||	<br style=\"clear:both;\" />||||||+N+||||||</div>||||||+N+||||||||||||+N+||||||</body>||||||+N+||||||</html>','','1','20050414163537');
INSERT INTO rex_template VALUES ('2','','02.01 Navigation','<?php||||||+N+||||||||||||+N+||||||// EXPLODE PATH||||||+N+||||||$PATH = explode(\"-\",$this->getValue(\"path\"));||||||+N+||||||||||||+N+||||||||||||+N+||||||// GET CURRENTS||||||+N+||||||$path1 = $PATH[1];||||||+N+||||||$path2 = $PATH[2];||||||+N+||||||$path3 = $PATH[3];||||||+N+||||||||||||+N+||||||echo||||||+N+||||||\'<ul class=\"nav1st\">\';||||||+N+||||||||||||+N+||||||/* START 1st level categories */||||||+N+||||||foreach (OOCategory::getRootCategories() as $lev1):||||||+N+||||||      ||||||+N+||||||   if ($lev1->isOnline()):||||||+N+||||||   // if ($lev1->isOnline() AND $lev1->getId() != 1): // wenn nur hauptkategorie angezeigt werden soll||||||+N+||||||||||||+N+||||||   /* 1st level - active link */||||||+N+||||||   if ($lev1->getId() == $path1) {||||||+N+||||||      echo||||||+N+||||||      \'<li class=\"active\">\'.$lev1->getName();||||||+N+||||||   }||||||+N+||||||   /* 1st level - no active link */||||||+N+||||||   else {||||||+N+||||||      echo||||||+N+||||||      \'<li>\'.$lev1->getName();||||||+N+||||||   }||||||+N+||||||   ||||||+N+||||||   /* 1st level had categories? -> go on */||||||+N+||||||   $lev1Size = sizeof($lev1->getChildren());||||||+N+||||||   ||||||+N+||||||   if($lev1Size != \"0\"):||||||+N+||||||      echo||||||+N+||||||      \'<ul class=\"nav2nd\">\';||||||+N+||||||||||||+N+||||||||||||+N+||||||      /* START 2nd level categories */||||||+N+||||||      foreach ($lev1->getChildren() as $lev2):||||||+N+||||||         ||||||+N+||||||         if ($lev2->isOnline()):||||||+N+||||||   ||||||+N+||||||         /* 2nd level - active link */||||||+N+||||||         if ($lev2->getId() == $path2) {||||||+N+||||||            echo||||||+N+||||||            \'<li class=\"active\"><a class=\"current\" href=\"\'.$lev2->getUrl().\'\">\'.$lev2->getName().\'</a>\';||||||+N+||||||         }||||||+N+||||||         /* 2nd level - no active link */||||||+N+||||||         else {||||||+N+||||||            echo||||||+N+||||||            \'<li><a href=\"\'.$lev2->getUrl().\'\">\'.$lev2->getName().\'</a>\';||||||+N+||||||         }||||||+N+||||||         ||||||+N+||||||         /* 2nd level had categories? -> go on */||||||+N+||||||         $lev2Size = sizeof($lev2->getChildren());||||||+N+||||||                  ||||||+N+||||||         if($lev2Size != \"0\"):||||||+N+||||||            echo||||||+N+||||||            \'<ul class=\"nav3rd\">\';||||||+N+||||||||||||+N+||||||            /* START 3rd level categories */||||||+N+||||||            foreach ($lev2->getChildren() as $lev3):||||||+N+||||||   ||||||+N+||||||               if ($lev3->isOnline()):||||||+N+||||||   ||||||+N+||||||               /* 3rd level - active link */||||||+N+||||||               if ($lev3->getId() == $path3) {||||||+N+||||||                  echo \'<li class=\"active\"><a class=\"current\" href=\"\'.$lev3->getUrl().\'\">\'.$lev3->getName().\'</a></li>\';||||||+N+||||||               }||||||+N+||||||               /* 3rd level - no active link */||||||+N+||||||               else {||||||+N+||||||                  echo \'<li><a href=\"\'.$lev3->getUrl().\'\">\'.$lev3->getName().\'</a></li>\';||||||+N+||||||               }||||||+N+||||||               ||||||+N+||||||               endif;||||||+N+||||||            endforeach;||||||+N+||||||            /* END 3rd level categories */||||||+N+||||||||||||+N+||||||            echo||||||+N+||||||            \'</ul>\';||||||+N+||||||         endif;||||||+N+||||||         ||||||+N+||||||||||||+N+||||||         echo||||||+N+||||||         \'</li>\';||||||+N+||||||         ||||||+N+||||||         endif;||||||+N+||||||         ||||||+N+||||||      endforeach;||||||+N+||||||      /* END 2nd level categories */||||||+N+||||||      ||||||+N+||||||      ||||||+N+||||||      echo \'</ul>\';||||||+N+||||||   endif;||||||+N+||||||   ||||||+N+||||||   echo||||||+N+||||||   \'</li>\';||||||+N+||||||   ||||||+N+||||||   endif;||||||+N+||||||endforeach;||||||+N+||||||/* END 1st level categories */||||||+N+||||||||||||+N+||||||||||||+N+||||||echo||||||+N+||||||\'</ul>\';||||||+N+||||||?> ','','0','20050414211745');
INSERT INTO rex_template VALUES ('5','','03.01 Banner','<a href=http://www.redaxo.de><img src=<? echo $REX[HTDOCS_PATH]; ?>files/banner.jpg width=468 height=60 border=0></a>','','0','20041028000000');
