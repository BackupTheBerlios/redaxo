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
DROP TABLE IF EXISTS rex__gbook;
CREATE TABLE rex__gbook ( id int(10) unsigned NOT NULL  auto_increment, author varchar(255)   , message text   , url varchar(255)   , email varchar(255)   , created timestamp(14) NULL  , PRIMARY KEY(id))TYPE=MyISAM;
DROP TABLE IF EXISTS rex_action;
CREATE TABLE rex_action ( id int(11) NOT NULL  auto_increment, name varchar(255) NULL  , action text NULL  , prepost tinyint(4) NULL DEFAULT 0  , sadd tinyint(4) NULL DEFAULT 0  , sedit tinyint(4) NULL DEFAULT 0  , sdelete tinyint(4) NULL DEFAULT 0  , PRIMARY KEY(id))TYPE=MyISAM;
INSERT INTO rex_action VALUES ('1','test','<?\r\n\r\n\r\nif (\"REX_VALUE[1]\" == \"\")\r\n{\r\n $REX_ACTION[SAVE] = false;\r\n $REX_ACTION[MSG] = \"Bitte tragen Sie eine Headline ein.\";\r\n}\r\n\r\n?>','0','1','1','1');
DROP TABLE IF EXISTS rex_article;
CREATE TABLE rex_article ( id int(11) NULL DEFAULT 0  , re_id int(11) NULL DEFAULT 0  , name varchar(255) NULL  , catname varchar(255) NULL  , cattype int(11) NULL DEFAULT 0  , alias varchar(255) NULL  , description text NULL  , attribute text NULL  , file text NULL  , type_id int(11) NULL DEFAULT 0  , teaser tinyint(4) NULL DEFAULT 0  , startpage tinyint(1) NULL DEFAULT 0  , prior int(11) NULL DEFAULT 0  , path varchar(255) NULL  , status tinyint(1) NULL DEFAULT 0  , online_from int(11) NULL DEFAULT 0  , online_to int(11) NULL DEFAULT 0  , createdate int(11) NULL DEFAULT 0  , updatedate int(11) NULL DEFAULT 0  , keywords text NULL  , template_id int(5) NULL DEFAULT 0  , clang int(11) NULL DEFAULT 0  , createuser varchar(255) NULL  , updateuser varchar(255) NULL  )TYPE=MyISAM;
INSERT INTO rex_article VALUES ('1','0','Home','Home','0','','','','','0','0','1','1','|','1','2147483647','20100101','20050408','1116066218','','1','0','','jan');
INSERT INTO rex_article VALUES ('1','0','Home','Home','0','','','','','0','0','1','1','|','1','2147483647','20100101','20050408','1115292964','','1','2','','jan');
INSERT INTO rex_article VALUES ('1','0','erster ordner','erster ordner','0','','','','','0','0','1','1','|','1','2147483647','20100101','20050408','0','','0','10','','');
INSERT INTO rex_article VALUES ('2','0','Neuigkeiten','Neuigkeiten','0','','','','','0','0','1','1','|','1','2147483647','20100101','20050414','1115291785','','1','0','','jan');
INSERT INTO rex_article VALUES ('2','0','News','News','0','','','','','0','0','1','1','|','1','2147483647','20100101','20050414','1115292042','','1','2','','jan');
INSERT INTO rex_article VALUES ('3','0','Produkte','Produkte','0','','','','','1','0','1','1','|','1','915145200','1283724000','20050414','1115290031','','1','0','','jan');
INSERT INTO rex_article VALUES ('3','0','Products','Products','0','','','','','0','0','1','1','|','0','2147483647','20100101','20050414','1115292109','','1','2','','jan');
INSERT INTO rex_article VALUES ('4','0','Sitemap','Sitemap','0','','','','','0','0','1','1','|','1','2147483647','20100101','20050414','1115290096','','1','0','','jan');
INSERT INTO rex_article VALUES ('4','0','Sitemap','Sitemap','0','','','','','0','0','1','1','|','0','2147483647','20100101','20050414','1115292109','','1','2','','jan');
INSERT INTO rex_article VALUES ('5','0','Impressum','Impressum','0','','','','','0','0','1','1','|','1','2147483647','20100101','20050414','1115290107','','1','0','','jan');
INSERT INTO rex_article VALUES ('5','0','Inprint','Inprint','0','','','','','0','0','1','1','|','1','2147483647','20100101','20050414','0','','1','2','','');
INSERT INTO rex_article VALUES ('6','0','Referenzen','Referenzen','0','','','','','0','0','1','1','|','1','2147483647','20100101','20050414','1115290115','','1','0','','jan');
INSERT INTO rex_article VALUES ('6','0','References','Referenzen','0','','','','','0','0','1','1','|','1','2147483647','20100101','20050414','0','','1','2','','');
INSERT INTO rex_article VALUES ('7','3','Produkt A','Produkt A','0','','','','','0','0','1','1','|3|','1','2147483647','20100101','20050414','1115290043','','1','0','','jan');
INSERT INTO rex_article VALUES ('7','3','Product A','Product A','0','','','','','0','0','1','1','|3|','1','2147483647','20100101','20050414','0','','1','2','','');
INSERT INTO rex_article VALUES ('8','3','Produkt B','Produkt B','0','','','','','0','0','1','1','|3|','1','2147483647','20100101','20050414','1115290053','','1','0','','jan');
INSERT INTO rex_article VALUES ('8','3','Product B','Product B','0','','','','','0','0','1','1','|3|','1','2147483647','20100101','20050414','0','','1','2','','');
INSERT INTO rex_article VALUES ('9','3','Produkt C','Produkt C','0','','','','','0','0','1','1','|3|','1','2147483647','20100101','20050414','1115290061','','1','0','','jan');
INSERT INTO rex_article VALUES ('9','3','Product C','Product C','0','','','','','0','0','1','1','|3|','1','2147483647','20100101','20050414','0','','1','2','','');
INSERT INTO rex_article VALUES ('10','3','Produkt D','Produkt D','0','','','','','0','0','1','1','|3|','1','2147483647','20100101','20050414','1115290069','','1','0','','jan');
INSERT INTO rex_article VALUES ('10','3','Product D','Product D','0','','','','','0','0','1','1','|3|','1','2147483647','20100101','20050414','0','','1','2','','');
INSERT INTO rex_article VALUES ('13','2','Newskategorie 1','Newskategorie 1','0','','','','','0','0','1','1','|2|','1','1115288830','1262300400','1115288830','1115293014','','1','0','jan','jan');
INSERT INTO rex_article VALUES ('13','2','Newscategorie 1','Newscategorie 1','0','','','','','0','0','1','1','|2|','1','1115288830','1262300400','1115288830','1115293043','','1','2','jan','jan');
INSERT INTO rex_article VALUES ('14','2','Newskategorie 2','Newskategorie 2','0','','','','','0','0','1','1','|2|','1','1115288848','1262300400','1115288848','1115293021','','1','0','jan','jan');
INSERT INTO rex_article VALUES ('14','2','Newscategorie 2','Newscategorie 2','0','','','','','0','0','1','1','|2|','1','1115288848','1262300400','1115288848','1115293058','','1','2','jan','jan');
DROP TABLE IF EXISTS rex_article_slice;
CREATE TABLE rex_article_slice ( id int(11) NOT NULL  auto_increment, clang int(11) NULL DEFAULT 0  , ctype int(11) NULL DEFAULT 0  , re_article_slice_id int(11) NOT NULL DEFAULT 0  , value1 text NULL  , value2 text NULL  , value3 text NULL  , value4 text NULL  , value5 text NULL  , value6 text NULL  , value7 text NULL  , value8 text NULL  , value9 text NULL  , value10 text NULL  , value11 text NULL  , value12 text NULL  , value13 text NULL  , value14 text NULL  , value15 text NULL  , value16 text NULL  , value17 text NULL  , value18 text NULL  , value19 text NULL  , value20 text NULL  , file1 varchar(255) NULL  , file2 varchar(255) NULL  , file3 varchar(255) NULL  , file4 varchar(255) NULL  , file5 varchar(255) NULL  , file6 varchar(255) NULL  , file7 varchar(255) NULL  , file8 varchar(255) NULL  , file9 varchar(255) NULL  , file10 varchar(255) NULL  , filelist1 text NULL  , filelist2 text NULL  , filelist3 text NULL  , filelist4 text NULL  , filelist5 text NULL  , filelist6 text NULL  , filelist7 text NULL  , filelist8 text NULL  , filelist9 text NULL  , filelist10 text NULL  , link1 int(11) NULL DEFAULT 0  , link2 int(11) NULL DEFAULT 0  , link3 int(11) NULL DEFAULT 0  , link4 int(11) NULL DEFAULT 0  , link5 int(11) NULL DEFAULT 0  , link6 int(11) NULL DEFAULT 0  , link7 int(11) NULL DEFAULT 0  , link8 int(11) NULL DEFAULT 0  , link9 int(11) NULL DEFAULT 0  , link10 int(11) NULL DEFAULT 0  , linklist1 text NULL  , linklist2 text NULL  , linklist3 text NULL  , linklist4 text NULL  , linklist5 text NULL  , linklist6 text NULL  , linklist7 text NULL  , linklist8 text NULL  , linklist9 text NULL  , linklist10 text NULL  , php text NULL  , html text NULL  , article_id int(11) NOT NULL DEFAULT 0  , modultyp_id int(5) NOT NULL DEFAULT 0  , createdate int(11) NULL DEFAULT 0  , updatedate int(11) NULL DEFAULT 0  , createuser varchar(255) NULL  , updateuser varchar(255) NULL  , PRIMARY KEY(id,re_article_slice_id,article_id,modultyp_id))TYPE=MyISAM;
INSERT INTO rex_article_slice VALUES ('12','2','0','10','\r\n<p>ola the forestfee.</p>\r\n\r\n<p>a little <span class=\"red\">senseless </span>description<br />\r\nin <span class=\"blue\">different</span> colors.</p>\r\n\r\n<p>-&gt; <a href=\"index.php?article_id=1&clang=0\">deutsche seite</a><br />\r\n</p>','','','','','','','','0','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','1','5','0','1115292964','','jan');
INSERT INTO rex_article_slice VALUES ('11','0','0','9','\r\n<p>und <span class=\"red\">hier </span>mien text</p>\r\n\r\n<p>holla die waldfee<br />\r\nund hier <span class=\"blue\">gehts</span> weiter </p>\r\n\r\n<p>-&gt; <a href=\"index.php?article_id=1&clang=2\">english page</a>\r\n</p>','','','','','','','','0','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','1','5','0','1115292978','','jan');
INSERT INTO rex_article_slice VALUES ('10','2','0','0','My Homepage','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','1','6','0','0','','');
INSERT INTO rex_article_slice VALUES ('9','0','0','28','Meine Homepage','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','1','6','0','0','','');
INSERT INTO rex_article_slice VALUES ('18','0','0','0','Produkte','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','3','6','1115290031','1115290031','jan','jan');
INSERT INTO rex_article_slice VALUES ('15','0','0','0','News 1','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','13','6','1115289139','1115289139','jan','jan');
INSERT INTO rex_article_slice VALUES ('16','0','0','0','News 2','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','14','6','1115289156','1115289156','jan','jan');
INSERT INTO rex_article_slice VALUES ('17','0','0','0','Neuigkeiten','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','2','6','1115290013','1115290013','jan','jan');
INSERT INTO rex_article_slice VALUES ('19','0','0','0','Produkt A','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','7','6','1115290043','1115290043','jan','jan');
INSERT INTO rex_article_slice VALUES ('20','0','0','0','Produkt B','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','8','6','1115290053','1115290053','jan','jan');
INSERT INTO rex_article_slice VALUES ('21','0','0','0','Produkt C','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','9','6','1115290061','1115290061','jan','jan');
INSERT INTO rex_article_slice VALUES ('22','0','0','0','Produkt D','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','10','6','1115290069','1115290069','jan','jan');
INSERT INTO rex_article_slice VALUES ('23','0','0','0','Sitemap','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','4','6','1115290096','1115290096','jan','jan');
INSERT INTO rex_article_slice VALUES ('24','0','0','0','Impressum','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','5','6','1115290107','1115290107','jan','jan');
INSERT INTO rex_article_slice VALUES ('25','0','0','0','Referenzen','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','6','6','1115290115','1115290115','jan','jan');
INSERT INTO rex_article_slice VALUES ('26','2','0','0','News','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','2','6','1115292042','1115292042','jan','jan');
INSERT INTO rex_article_slice VALUES ('28','0','0','29','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','asdfasdfa','','1','1','1116066057','1116066057','jan','jan');
INSERT INTO rex_article_slice VALUES ('29','0','0','0','asdfasdfasdf','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','0','0','0','0','0','0','0','0','0','0','','','','','','','','','','','','','1','6','1116066218','1116066218','jan','jan');
DROP TABLE IF EXISTS rex_article_type;
CREATE TABLE rex_article_type ( type_id int(5) NOT NULL  auto_increment, name varchar(255) NULL  , description text NULL  , PRIMARY KEY(type_id))TYPE=MyISAM;
INSERT INTO rex_article_type VALUES ('1','Standard','Zugriff f�r alle');
DROP TABLE IF EXISTS rex_clang;
CREATE TABLE rex_clang ( id int(11) NOT NULL DEFAULT 0  , name varchar(255) NULL  , PRIMARY KEY(id))TYPE=MyISAM;
INSERT INTO rex_clang VALUES ('0','deutsch');
INSERT INTO rex_clang VALUES ('2','english');
DROP TABLE IF EXISTS rex_file;
CREATE TABLE rex_file ( file_id int(11) NOT NULL  auto_increment, re_file_id int(11)  DEFAULT 0  , category_id int(11)  DEFAULT 0  , filetype varchar(255)   , filename varchar(255)   , originalname varchar(255)   , filesize varchar(255)   , width int(11)  DEFAULT 0  , height int(11)  DEFAULT 0  , title varchar(255)   , description text   , copyright varchar(255)   , createdate int(11)  DEFAULT 0  , updatedate int(11)  DEFAULT 0  , createuser varchar(255)   , updateuser varchar(255)   , PRIMARY KEY(file_id))TYPE=MyISAM;
INSERT INTO rex_file VALUES ('2','0','2','image/gif','m.gif','m.gif','102','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('3','0','2','image/gif','w.gif','w.gif','103','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('4','0','2','image/jpeg','banner.jpg','banner.jpg','10913','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('5','0','2','image/gif','o.gif','o.gif','85','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('6','0','2','image/gif','u.gif','u.gif','87','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('7','0','2','image/gif','na.gif','na.gif','54','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('8','0','2','image/gif','np.gif','np.gif','54','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('9','0','2','image/gif','head_links.gif','head_links.gif','344','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('10','0','2','image/gif','kdummy.gif','kdummy.gif','289','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('11','0','2','image/gif','sbg.gif','sbg.gif','97','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('12','0','2','image/gif','bg.gif','bg.gif','307','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('16','0','2','image/gif','a.gif','a.gif','91','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('14','0','2','image/gif','logo.gif','logo.gif','1322','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('15','0','3','text/css','style.css','style.css','804','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('17','0','2','image/gif','e.gif','e.gif','87','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('18','0','2','image/gif','n.gif','n.gif','62','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('20','0','3','text/css','import.css','C:PHPuploadtempphp41.tmp','1142','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('21','0','3','text/css','articlelist.css','articlelist.css','1450','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('22','0','3','text/css','board_open.css','C:PHPuploadtempphp7A.tmp','3161','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('23','0','3','text/css','calendar.css','calendar.css','2003','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('24','0','3','text/css','categorylist.css','categorylist.css','1189','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('25','0','3','text/css','contact.css','contact.css','2904','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('26','0','3','text/css','headlines.css','headlines.css','3182','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('27','0','3','text/css','main.css','C:PHPuploadtempphp43.tmp','2955','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('28','0','3','text/css','menu.css','menu.css','3540','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('29','0','3','text/css','productdesc.css','productdesc.css','1222','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('30','0','3','text/css','sitemap.css','sitemap.css','1371','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('31','0','3','text/css','text.css','text.css','781','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('32','0','2','image/gif','t.gif','t.gif','91','0','0','','','','0','0','','');
INSERT INTO rex_file VALUES ('33','0','1','image/gif','cat29.gif','cat29.gif','2179','76','19','','','','0','0','','');
INSERT INTO rex_file VALUES ('34','0','0','text/plain','projekte_1.txt','projekte.txt','8498','0','0','22222','','','1114597419','1114597460','jan','jan');
DROP TABLE IF EXISTS rex_file_category;
CREATE TABLE rex_file_category ( id int(11) NOT NULL  auto_increment, name varchar(255)   , re_id int(11)  DEFAULT 0  , path varchar(255)   , hide tinyint(4)  DEFAULT 0  , createdate int(11)  DEFAULT 0  , updatedate int(11)  DEFAULT 0  , createuser varchar(255)   , updateuser varchar(255)   , PRIMARY KEY(id))TYPE=MyISAM;
INSERT INTO rex_file_category VALUES ('1','Bilder','0','','1','0','1114597101','','jan');
INSERT INTO rex_file_category VALUES ('2','Hilfsgrafiken','0','','1','0','0','','');
INSERT INTO rex_file_category VALUES ('3','Stylesheet','0','','1','0','0','','');
INSERT INTO rex_file_category VALUES ('4','2222','0','','0','1114597111','1114597111','jan','jan');
DROP TABLE IF EXISTS rex_help;
CREATE TABLE rex_help ( id int(11) NOT NULL  auto_increment, page varchar(255) NULL  , name varchar(255) NULL  , description text NULL  , comment text NULL  , lang varchar(255) NULL  , PRIMARY KEY(id))TYPE=MyISAM;
DROP TABLE IF EXISTS rex_module_action;
CREATE TABLE rex_module_action ( id int(11) NOT NULL  auto_increment, module_id int(11) NULL DEFAULT 0  , action_id int(11) NULL DEFAULT 0  , PRIMARY KEY(id))TYPE=MyISAM;
INSERT INTO rex_module_action VALUES ('1','6','1');
DROP TABLE IF EXISTS rex_modultyp;
CREATE TABLE rex_modultyp ( id int(5) NOT NULL  auto_increment, label varchar(255) NULL  , name varchar(255) NULL  , category_id int(11) NOT NULL DEFAULT 0  , ausgabe text NULL  , bausgabe text NULL  , eingabe text NULL  , func text NULL  , php_enable tinyint(1) NOT NULL DEFAULT 0  , html_enable tinyint(1) NOT NULL DEFAULT 0  , perm_category text NULL  , PRIMARY KEY(id,category_id,php_enable,html_enable))TYPE=MyISAM;
INSERT INTO rex_modultyp VALUES ('1','','00.01 - php','0','REX_PHP','','PHP:<br>\r\n<textarea name=INPUT_PHP cols=80 rows=20 class=inp100>REX_PHP</textarea>\r\n<br><br>','','0','0','');
INSERT INTO rex_modultyp VALUES ('2','','02.03 - Text [NO WYSIWYG]','0','<div class=Text>REX_VALUE[1]</div>','','<?php\r\n\r\nMEDIA_HTMLAREA(1,\"REX_VALUE[1]\");\r\n\r\n?>','','0','0','');
INSERT INTO rex_modultyp VALUES ('3','','01.01 - Board','0','<?\r\n\r\n$board = new board;\r\n$board->setDB(1);\r\n$board->setTable(\"rex__board\");\r\n$board->setDocname(\"index.php\");\r\n$board->addLink(\"article_id\",REX_ARTICLE_ID);\r\n$board->setBoardname(\"REX_VALUE[1]\");\r\n$board->setRealBoardname(\"REX_VALUE[2]\");\r\n$board->anonymous = true;\r\n\r\necho $board->showBoard();\r\n\r\n?>','','Bitte gib die Boardbezeichnung ein:<br>\r\n<input type=text size=50 name=VALUE[2] value=\"REX_VALUE[2]\">\r\n\r\n<br><br>Bitte gib den Boardname f�r die Datenbank ein:<br>\r\n<input type=text size=50 name=VALUE[1] value=\"REX_VALUE[1]\">\r\n\r\n<br><br>','','0','0','');
INSERT INTO rex_modultyp VALUES ('11','','03.03 - Kategorienliste','0','<?\r\n\r\n$GC = new sql;\r\n// $GC->debugsql = 1;\r\n$GC->setQuery(\"select * from rex_category,rex_article \r\nwhere \r\nrex_category.re_category_id=\'REX_CATEGORY_ID\' and \r\nrex_article.startpage=1 and \r\nrex_article.category_id=rex_category.id  \r\norder by rex_article.prior,rex_article.name\");\r\n\r\n\r\nfor ($i=0;$i<$GC->getRows();$i++)\r\n{\r\n\r\n if ($i!=0)  echo \"<img src=$REX[HTDOCS_PATH]/pics/lgrey.gif width=450 height=1 vspace=10>\";\r\n\r\n if ($GC->getValue(\"rex_article.file\") != \"\") $file = \"<img src=$REX[HTDOCS_PATH]/files/\".$GC->getValue(\"rex_article.file\").\" width=155 height=90>\";\r\n else $file = \"<img src=$REX[HTDOCS_PATH]/files/kdummy.gif width=155 height=90 border=0>\";\r\n\r\n // $file = \"&nbsp;\";\r\n \r\n echo \"<div class=Categorylist>\";\r\n echo \"<div class=CategorylistPic>$file</div>\";\r\n echo \"<div class=CategorylistArticle>\";\r\n\r\n echo \"<div class=CategorylistArticleName>\".htmlentities($GC->getValue(\"rex_article.name\")).\"</div>\r\n\".nl2br(htmlentities($GC->getValue(\"rex_article.beschreibung\"))).\"<br>&raquo;&nbsp;<a href=index.php?article_id=\".$GC->getValue(\"rex_article.id\").\">Detailinformationen</a>\";\r\n\r\n echo \"</div>\";\r\n echo \"</div>\";\r\n\r\n\r\n $GC->next();\r\n}\r\n\r\n?>','','','','0','0','');
INSERT INTO rex_modultyp VALUES ('5','','02.02 - Text [WYSIWYG]','0','<table width=\"100%\" cellpadding=0 cellspacing=0 border=0>\r\n<tr>\r\n\r\n<td><font class=content>REX_HTML_VALUE[1]</font></td>\r\n\r\n</tr></table><?php\r\n\r\nif (\"REX_VALUE[9]\" == \"1\") echo \"<br>\";\r\nif (\"REX_VALUE[9]\" == \"2\") echo \"<br><br>\";\r\n\r\n?>','','Bitte gib den Text ein der zu Sehen sein soll:<br>\r\n<?php\r\n\r\n$a = new editor();\r\n$a->buttonrow1 = \"styleselect,separator,bold,italic,separator,bullist,numlist\";\r\n$a->buttonrow2 = \"link,linkHack,unlink,insertEmail,separator,removeformat,pasteRichtext,code\";\r\n$a->buttonrow3 = \"tablecontrols, separator, visualaid\";\r\n$a->buttonrow4 = \"rowseparator,formatselect,fontselect,fontsizeselect,forecolor,charmap\";\r\n$a->stylesheet = \"/redaxo3_0/files/text.css\";\r\n$a->content = \"REX_VALUE[1]\";\r\n$a->id = 1;\r\n$a->show();\r\n\r\n// mit umbruch ?\r\necho \"<br><br><select name=VALUE[9] size=1><option value=\'1\'\";\r\nif (\"REX_VALUE[9]\" == \"1\") echo \" selected\";\r\necho \">Mit einfachem Umbruch</option><option value=\'2\'\";\r\nif (\"REX_VALUE[9]\" == \"2\") echo \" selected\";\r\necho \">Mit doppeltem Umbruch</option><option value=\'0\'\";\r\nif (\"REX_VALUE[9]\" == \"0\" or \"REX_VALUE[9]\" == \"\") echo \" selected\";\r\necho \">Ohne Umbruch</option></select>\";\r\n\r\n?>','','0','0','');
INSERT INTO rex_modultyp VALUES ('6','','02.01 - Headline','0','<div class=Headline>REX_VALUE[1]</div>','','Headline:\r\n<br><input type=text size=30 name=VALUE[1] value=\"REX_VALUE[1]\" class=inp100>\r\n<br><br>\r\n\r\n','','0','0','');
INSERT INTO rex_modultyp VALUES ('8','','03.01 - Artikelliste','0','<div class=ArticlelistContainer>\r\n<?\r\n\r\nif (\"REX_VALUE[1]\" == 2) $sql = \"select * from rex_article where startpage=0 and checkbox01=1 and status=1 order by rex_article.prior\";\r\nelse if (\"REX_VALUE[1]\" == 1) $sql = \"select * from rex_article where rex_article.category_id=\'REX_CATEGORY_ID\' and startpage=0 and checkbox01=1 and status=1 order by rex_article.prior\";\r\nelse $sql = \"select * from rex_article where rex_article.category_id=\'REX_CATEGORY_ID\' and startpage=0 and status=1 order by rex_article.prior\";\r\n\r\n$GC = new sql;\r\n\r\n// $GC->setQuery(\"select * from rex_article where rex_article.category_id=\'REX_CATEGORY_ID\' and startpage=0 and status=1 order by rex_article.prior\");\r\n$GC->setQuery($sql);\r\n\r\nfor ($i=0;$i<$GC->getRows();$i++)\r\n{\r\n\r\n if ($i!=0)  echo \"<!--\r\n 	\r\n 	<hr style=\'width:100%; height:1px;\' vspace=4> -->\";\r\n\r\n $aid = $GC->getValue(\"rex_article.id\");\r\n\r\n $jahr = substr($GC->getValue(\"rex_article.online_von\"),0,4);\r\n $monat = substr($GC->getValue(\"rex_article.online_von\"),4,2);\r\n $tag = substr($GC->getValue(\"rex_article.online_von\"),6,2);\r\n\r\n $date = \"$tag.$monat.$jahr\";\r\n\r\n echo \"<div class=ArticlelistArticle>\";\r\n echo \"<div class=ArticlelistHead>\";\r\n echo \"	<div class=ArticlelistHeadline>\".htmlentities($GC->getValue(\"rex_article.name\")).\"</div>\";\r\n echo \"	<div class=ArticlelistDate>\".htmlentities($date).\"</div>\";\r\n echo \"</div>\";\r\n echo \"<div>\r\n		<div class=ArticlelistIntro>\";\r\n\r\n if ($GC->getValue(\"rex_article.file\")!=\"\") echo \"\r\n		<img src=<?=$REX[HTDOCS_PATH]?>/files/\".$GC->getValue(\"rex_article.file\").\" align=left style=\'border-right:10px #ffffff solid; border-bottom:10px #ffffff solid;\'>\";\r\n\r\n echo htmlentities($GC->getValue(\"rex_article.beschreibung\")).\" \";\r\n\r\n if ($REX[GG]) echo \"<a href=index.php?article_id=$aid><b>&raquo;&nbsp;mehr...</b></a>\";\r\n echo \"	</div></div>\";\r\n echo \"</div>\";\r\n\r\n $GC->next();\r\n}\r\n\r\n?>\r\n</div>','','<?\r\n\r\necho \"<br><br>Folgende Artikel sollen angezeigt werden:<br>\";\r\n\r\n$format = new select;\r\n$format->set_name(\"VALUE[1]\");\r\n$format->set_size(1);\r\n$format->set_style(\"\' class=\'inp100\");\r\n\r\n$format->add_option(\"Alle Artikel aus dieser Kategorie\",0);\r\n$format->add_option(\"Alle Artikel aus dieser Kategorie die als Teaser gekennzeichnet sind\",1);\r\n$format->add_option(\"Alle Artikel die als Teaser gekennzeichnet sind\",2);\r\n$format->set_selected(\"REX_VALUE[1]\");\r\necho $format->out();\r\n\r\n?><br><br>','','0','0','');
INSERT INTO rex_modultyp VALUES ('9','','03.02 - Artikeliste als Kalender','0','<?\r\n\r\n$category_id = $this->getValue(\"category_id\");\r\n$path  = $this->getValue(\"path\");\r\npreg_match_all(\"/-([0-9]+)/i\",$path,$match);\r\n$spath = $match[0][0];\r\n\r\n$GC = new sql;\r\n// $GC->debugsql = 1;\r\n$GC->setQuery(\"select * from rex_article \r\nwhere \r\n(rex_article.path like \'$spath-%\' or rex_article.path=\'$spath\') and \r\nrex_article.startpage=0 and rex_article.status = 1 \r\norder by rex_article.prior,rex_article.name\");\r\n\r\nfor ($i=0;$i<$GC->getRows();$i++)\r\n{\r\n $KAL[$GC->getValue(\"rex_article.online_von\")] = $GC->getValue(\"rex_article.id\");\r\n $KALNAME[$GC->getValue(\"rex_article.online_von\")] = $GC->getValue(\"rex_article.name\");\r\n $GC->next();\r\n}\r\n\r\n\r\n// ----- KALENDER\r\n\r\nif ($FORM[date]!=\"\") \r\n{ \r\n $FORM[year] = substr($FORM[date],0,4); \r\n $FORM[month] = substr($FORM[date],4,2); \r\n $FORM[day] = substr($FORM[date],6,2); \r\n} \r\n\r\nif (!checkdate($FORM[month],$FORM[day],$FORM[year])) \r\n\r\n{ \r\n $FORM[year] = date(\"Y\"); \r\n $FORM[month] = date(\"m\"); \r\n $FORM[day] = date(\"d\"); \r\n} \r\n\r\n$FORM[date] = $FORM[year].$FORM[month].$FORM[day]; \r\n\r\n$today = date(\"Ymd\");\r\n$FORM[link] = \"index.php?article_id=REX_ARTICLE_ID\";\r\n$link = $FORM[link];\r\n$month_days = date(\"j\",mktime(0,0,0,$FORM[month]+1,1,$FORM[year])-1);\r\n$month_before = $FORM[month]-1;\r\n$month_later = $FORM[month]+1;\r\n$year_before = $FORM[year];\r\n$year_later = $FORM[year];\r\nif ($month_before<1){ $month_before = 12; $year_before= $year_before-1;}\r\nif ($month_later>12){ $month_later = 1; $year_later= $year_later+1;}\r\nif ($month_before<10){ $month_before = \"0$month_before\"; }\r\nif ($month_later<10){ $month_later = \"0$month_later\"; }\r\n$before = $year_before.$month_before.\"01\";\r\n$later  = $year_later.$month_later.\"01\";\r\n\r\n$KALENDER .= \"\r\n	<div class=Calendar>\";\r\n$KALENDER .= \"\r\n	<div class=CalendarHead>\r\n		<div class=CalendarHeadLeft><a href=$link&FORM[date]=$before class=calhead><b>&laquo;</b></a>&nbsp;<a href=$link&FORM[date]=$later class=calhead><b>&raquo;</b></a></div>\r\n		<div class=CalendarHeadRight>\".$FORM[month].\"/\".$FORM[year].\"</div>\r\n	</div>\";\r\n$KALENDER .= \"\r\n	<div class=CalendarWeekdays>\r\n		<span>Mo</span>\r\n		<span>Tu</span>\r\n		<span>We</span>\r\n		<span>Th</span>\r\n		<span>Fr</span>\r\n		<span>Sa</span>\r\n		<span>Su</span>\r\n	</div>\";\r\n	\r\n$k = 1;\r\nfor ($i=1;$i<7;$i++)\r\n{\r\n $KALENDER .= \"\r\n	<div class=CalendarDays>\";\r\n	\r\n for($j=0;$j<7;$j++)\r\n {\r\n  $k = $k + 0;\r\n  if ($k<10) $k=\"0$k\";\r\n  if ($FORM[month]<10) $comp_month=\"\".$FORM[month]; \r\n  else $comp_month=$FORM[month];\r\n  $which_weekday = date(\"w\",mktime(0,0,0,$FORM[month],$k-1,$FORM[year]));\r\n  if ($which_weekday == $j and $month_days>=$k)\r\n  { 	\r\n   $loop_day = $FORM[year].\"$comp_month$k\";\r\n   $KALENDER .= \"\r\n		<span\";\r\n   if ($FORM[date] == $loop_day) $KALENDER .= \" class=CalendarDaysActive>\";\r\n   elseif ($today == $loop_day) $KALENDER .= \" class=CalendarDaysIdontknow>\";\r\n   elseif ($j == 5 or $j == 6) $KALENDER .= \" class=CalendarDaysWeekenddays>\";\r\n   else $KALENDER .= \" class=CalendarDaysWeekdays>\";\r\n   if ($KAL[$loop_day] != \"\") $KALENDER .= \"<a href=index.php?article_id=\".$KAL[$loop_day].\"&FORM[date]=$loop_day>$k</a>\";\r\n   else $KALENDER .= \"$k\";\r\n   $KALENDER .= \"\r\n		</span>\";\r\n   $k++;\r\n  }else\r\n  {\r\n   $KALENDER .= \"<span></span>\";\r\n  }\r\n }\r\n $KALENDER .= \"</div>\";\r\n if ($month_days<$k) break;\r\n}\r\n$KALENDER .= \"</div>\";\r\n\r\n// ----- / KALENDER\r\n\r\necho \"<div class=CalendarContainer>$KALENDER<div class=Clear>&nbsp;</div></div>\";\r\n\r\n?>','','<br><br>','','0','0','');
INSERT INTO rex_modultyp VALUES ('10','','04.01 - Bild','0','<?\r\n\r\nif (\"FILE[1]\" != \"\")\r\n{\r\n echo \"<img src=$REX[HTDOCS_PATH]/files/FILE[1] width=100>\";\r\n}\r\n\r\n?><br><br>','','REX_MEDIA_BUTTON[1]\r\n\r\n<?\r\n\r\nif (\"FILE[1]\" != \"\")\r\n{\r\n echo \"<img src=$REX[HTDOCS_PATH]/files/FILE[1]>\";\r\n}\r\n\r\n?><br><br>','','0','0','');
DROP TABLE IF EXISTS rex_template;
CREATE TABLE rex_template ( id int(5) NOT NULL  auto_increment, label varchar(255) NULL  , name varchar(255) NULL  , content text NULL  , bcontent text NULL  , active tinyint(1) NULL DEFAULT 0  , date timestamp(14) NULL  , PRIMARY KEY(id))TYPE=MyISAM;
INSERT INTO rex_template VALUES ('1','','01.01 Default','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/2000/REC-xhtml1-20000126/DTD/xhtml1-transitional.dtd\">\r\n<html>\r\n<?\r\n\r\nsetlocale(LC_ALL,\"de_DE\");\r\n\r\n?>\r\n<head>\r\n<title>Redaxo Demo 2.1 - CSS</title>\r\n<link rel=stylesheet type=text/css href=<? echo $REX[HTDOCS_PATH] ?>files/import.css>\r\n<script language=Javascript src=<? echo $REX[HTDOCS_PATH] ?>js/standard.js></script>\r\n<script language=Javascript src=<? echo $REX[HTDOCS_PATH] ?>js/flashdetect.js></script>\r\n\r\n\r\n</head>\r\n<body>\r\n<a name=top></a>\r\n<div class=\"Website\">\r\n\r\n\r\n	<div class=\"LeftContainer\">\r\n		<div class=\"Logo\"><img src=<? echo $REX[HTDOCS_PATH] ?>files/logo.gif></div>\r\n		<div class=\"MenuContainer\"><? include $REX[INCLUDE_PATH].\"/generated/templates/2.template\"; ?></div>\r\n	</div>		\r\n\r\n\r\n	<div class=\"RightContainer\">\r\n		<div class=\"Banner\"><? include $REX[INCLUDE_PATH].\"/generated/templates/5.template\"; ?></div>\r\n		<div class=\"ContentContainer\"><? echo $this->getArticle(); ?></div>\r\n\r\n	<div class=\"Copyright\">created 2004 by <a href=http://www.pergopa.de target=_blank>pergopa kristinus gbr</a> |  <a href=<? echo rex_getUrl(12,$clang);?>>Impressum</a> | wcms: <a href=http://www.redaxo.de target=_blank>redaxo 2.7</a></div>\r\n	</div>\r\n\r\n	<br style=\"clear:both;\" />\r\n</div>\r\n\r\n</body>\r\n</html>','','1','20050414163537');
INSERT INTO rex_template VALUES ('2','','02.01 Navigation','<?php\r\n\r\n// Pfad auslesen und als Array speichern\r\n$PATH = explode(\"-\",$this->getValue(\"path\"));\r\n\r\n\r\n// Die Pfadids setzen\r\n$path1 = $PATH[1];\r\n$path2 = $PATH[2];\r\n$path3 = $PATH[3];\r\n$path4 = $PATH[4];\r\n\r\n\r\n// erst ebene ul starten\r\necho \'<ul class=\"nav1st\">\';\r\n\r\n/* START 1st level categories */\r\nforeach (OOCategory::getRootCategories() as $lev1):\r\n	\r\n	$lev1->setClang($REX[CUR_CLANG]);\r\n	\r\n	// if ($lev1->isOnline() AND $lev1->getId() != 1): // wenn nur hauptkategorie angezeigt werden soll\r\n	if ($lev1->isOnline()):\r\n	\r\n		/* 1st level - active link */\r\n		if ($lev1->getId() == $path1) {\r\n			echo \'<li class=\"active\"><a href=\"\'.$lev1->getUrl().\'\">\'.$lev1->getName().\'</a>\';\r\n		}\r\n		/* 1st level - no active link */\r\n		else {\r\n			echo \'<li><a href=\"\'.$lev1->getUrl().\'\">\'.$lev1->getName().\'</a>\';\r\n		}\r\n		\r\n		/* 1st level had categories? -> go on */\r\n		$lev1Size = sizeof($lev1->getChildren());\r\n		\r\n		if($lev1Size != \"0\"):\r\n\r\n		echo \'<ul class=\"nav2nd\">\';\r\n		\r\n		\r\n		/* START 2nd level categories */\r\n		foreach ($lev1->getChildren() as $lev2):\r\n\r\n			if ($lev2->isOnline()):\r\n\r\n				/* 2nd level - active link */\r\n				if ($lev2->getId() == $path2) {\r\n					echo \'<li class=\"active\"><a class=\"current\" href=\"\'.$lev2->getUrl().\'\">\'.$lev2->getName().\'</a>\';\r\n				}\r\n				/* 2nd level - no active link */\r\n				else {\r\n					echo \'<li><a href=\"\'.$lev2->getUrl().\'\">\'.$lev2->getName().\'</a>\';\r\n				}\r\n				\r\n				/* 2nd level had categories? -> go on */\r\n				$lev2Size = sizeof($lev2->getChildren());\r\n		\r\n				if($lev2Size != \"0\"):\r\n					echo \'<ul class=\"nav3rd\">\';\r\n				\r\n					/* START 3rd level categories */\r\n					foreach ($lev2->getChildren() as $lev3):\r\n				\r\n						if ($lev3->isOnline()):\r\n				\r\n							/* 3rd level - active link */\r\n							if ($lev3->getId() == $path3) {\r\n								echo \'<li class=\"active\"><a class=\"current\" href=\"\'.$lev3->getUrl().\'\">\'.$lev3->getName().\'</a></li>\';\r\n							}\r\n							/* 3rd level - no active link */\r\n							else {\r\n								echo \'<li><a href=\"\'.$lev3->getUrl().\'\">\'.$lev3->getName().\'</a></li>\';\r\n							}\r\n		\r\n						endif;\r\n					endforeach;\r\n					/* END 3rd level categories */\r\n		\r\n					echo \'</ul>\';\r\n				endif;\r\n				echo \'</li>\';\r\n			endif;\r\n		\r\n		endforeach;\r\n		/* END 2nd level categories */\r\n		\r\n		echo \'</ul>\';\r\n		endif;\r\n		\r\n		echo \'</li>\';\r\n	\r\n	endif;\r\nendforeach;\r\n/* END 1st level categories */\r\n\r\necho \'</ul>\';\r\n?>','','0','20050505132934');
INSERT INTO rex_template VALUES ('5','','03.01 Banner','<a href=http://www.redaxo.de><img src=<? echo $REX[HTDOCS_PATH]; ?>files/banner.jpg width=468 height=60 border=0></a>','','0','20041028000000');
