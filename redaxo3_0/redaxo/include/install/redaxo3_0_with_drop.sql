## Redaxo Database Dump Version 3
## Prefix rex_
DROP TABLE IF EXISTS rex_action
CREATE TABLE rex_action ( id int(11) NOT NULL  auto_increment, name varchar(255) NOT NULL  , action text NOT NULL  , prepost tinyint(4) NOT NULL DEFAULT 0  , sadd tinyint(4) NOT NULL DEFAULT 0  , sedit tinyint(4) NOT NULL DEFAULT 0  , sdelete tinyint(4) NOT NULL DEFAULT 0  , PRIMARY KEY(id))TYPE=MyISAM
DROP TABLE IF EXISTS rex_article
CREATE TABLE rex_article ( pid int(11) NOT NULL  auto_increment, id int(11) NOT NULL DEFAULT 0  , re_id int(11) NOT NULL DEFAULT 0  , name varchar(255) NOT NULL  , catname varchar(255) NOT NULL  , cattype int(11) NOT NULL DEFAULT 0  , catprior int(11) NOT NULL DEFAULT 0  , alias varchar(255) NOT NULL  , description text NOT NULL  , attribute text NOT NULL  , file text NOT NULL  , type_id int(11) NOT NULL DEFAULT 1  , teaser tinyint(4) NOT NULL DEFAULT 0  , startpage tinyint(1) NOT NULL DEFAULT 0  , prior int(11) NOT NULL DEFAULT 0  , path varchar(255) NOT NULL  , status tinyint(1) NOT NULL DEFAULT 0  , online_from int(11) NOT NULL DEFAULT 0  , online_to int(11) NOT NULL DEFAULT 0  , createdate int(11) NOT NULL DEFAULT 0  , updatedate int(11) NOT NULL DEFAULT 0  , keywords text NOT NULL  , template_id int(11) NOT NULL DEFAULT 0  , clang int(11) NOT NULL DEFAULT 0  , createuser varchar(255) NOT NULL  , updateuser varchar(255) NOT NULL  , fe_user text NOT NULL  , fe_group text NOT NULL  , fe_ext text NOT NULL  , PRIMARY KEY(pid))TYPE=MyISAM
DROP TABLE IF EXISTS rex_article_slice
CREATE TABLE rex_article_slice ( id int(11) NOT NULL  auto_increment, clang int(11) NOT NULL DEFAULT 0  , ctype int(11) NOT NULL DEFAULT 0  , re_article_slice_id int(11) NOT NULL DEFAULT 0  , value1 text NOT NULL  , value2 text NOT NULL  , value3 text NOT NULL  , value4 text NOT NULL  , value5 text NOT NULL  , value6 text NOT NULL  , value7 text NOT NULL  , value8 text NOT NULL  , value9 text NOT NULL  , value10 text NOT NULL  , value11 text NOT NULL  , value12 text NOT NULL  , value13 text NOT NULL  , value14 text NOT NULL  , value15 text NOT NULL  , value16 text NOT NULL  , value17 text NOT NULL  , value18 text NOT NULL  , value19 text NOT NULL  , value20 text NOT NULL  , file1 varchar(255) NOT NULL  , file2 varchar(255) NOT NULL  , file3 varchar(255) NOT NULL  , file4 varchar(255) NOT NULL  , file5 varchar(255) NOT NULL  , file6 varchar(255) NOT NULL  , file7 varchar(255) NOT NULL  , file8 varchar(255) NOT NULL  , file9 varchar(255) NOT NULL  , file10 varchar(255) NOT NULL  , filelist1 text NOT NULL  , filelist2 text NOT NULL  , filelist3 text NOT NULL  , filelist4 text NOT NULL  , filelist5 text NOT NULL  , filelist6 text NOT NULL  , filelist7 text NOT NULL  , filelist8 text NOT NULL  , filelist9 text NOT NULL  , filelist10 text NOT NULL  , link1 int(11) NOT NULL DEFAULT 0  , link2 int(11) NOT NULL DEFAULT 0  , link3 int(11) NOT NULL DEFAULT 0  , link4 int(11) NOT NULL DEFAULT 0  , link5 int(11) NOT NULL DEFAULT 0  , link6 int(11) NOT NULL DEFAULT 0  , link7 int(11) NOT NULL DEFAULT 0  , link8 int(11) NOT NULL DEFAULT 0  , link9 int(11) NOT NULL DEFAULT 0  , link10 int(11) NOT NULL DEFAULT 0  , linklist1 text NOT NULL  , linklist2 text NOT NULL  , linklist3 text NOT NULL  , linklist4 text NOT NULL  , linklist5 text NOT NULL  , linklist6 text NOT NULL  , linklist7 text NOT NULL  , linklist8 text NOT NULL  , linklist9 text NOT NULL  , linklist10 text NOT NULL  , php text NOT NULL  , html text NOT NULL  , article_id int(11) NOT NULL DEFAULT 0  , modultyp_id int(11) NOT NULL DEFAULT 0  , createdate int(11) NOT NULL DEFAULT 0  , updatedate int(11) NOT NULL DEFAULT 0  , createuser varchar(255) NOT NULL  , updateuser varchar(255) NOT NULL  , PRIMARY KEY(id,re_article_slice_id,article_id,modultyp_id))TYPE=MyISAM
DROP TABLE IF EXISTS rex_article_type
CREATE TABLE rex_article_type ( type_id int(11) NOT NULL  auto_increment, name varchar(255) NOT NULL  , description text NOT NULL  , PRIMARY KEY(type_id))TYPE=MyISAM
INSERT INTO rex_article_type VALUES ('1','Standard','Zugriff f�r alle')
DROP TABLE IF EXISTS rex_clang
CREATE TABLE rex_clang ( id int(11) NOT NULL DEFAULT 0  , name varchar(255) NOT NULL  , PRIMARY KEY(id))TYPE=MyISAM
INSERT INTO rex_clang VALUES ('0','deutsch')
DROP TABLE IF EXISTS rex_file
CREATE TABLE rex_file ( file_id int(11) NOT NULL  auto_increment, re_file_id int(11) NOT NULL DEFAULT 0  , category_id int(11) NOT NULL DEFAULT 0  , filetype varchar(255) NOT NULL  , filename varchar(255) NOT NULL  , originalname varchar(255) NOT NULL  , filesize varchar(255) NOT NULL  , width int(11) NOT NULL DEFAULT 0  , height int(11) NOT NULL DEFAULT 0  , title varchar(255) NOT NULL  , description text NOT NULL  , copyright varchar(255) NOT NULL  , createdate int(11) NOT NULL DEFAULT 0  , updatedate int(11) NOT NULL DEFAULT 0  , createuser varchar(255) NOT NULL  , updateuser varchar(255) NOT NULL  , PRIMARY KEY(file_id))TYPE=MyISAM
DROP TABLE IF EXISTS rex_file_category
CREATE TABLE rex_file_category ( id int(11) NOT NULL  auto_increment, name varchar(255) NOT NULL  , re_id int(11) NOT NULL DEFAULT 0  , path varchar(255) NOT NULL  , hide tinyint(4) NOT NULL DEFAULT 0  , createdate int(11) NOT NULL DEFAULT 0  , updatedate int(11) NOT NULL DEFAULT 0  , createuser varchar(255) NOT NULL  , updateuser varchar(255) NOT NULL  , PRIMARY KEY(id,name))TYPE=MyISAM
DROP TABLE IF EXISTS rex_module_action
CREATE TABLE rex_module_action ( id int(11) NOT NULL  auto_increment, module_id int(11) NOT NULL DEFAULT 0  , action_id int(11) NOT NULL DEFAULT 0  , PRIMARY KEY(id))TYPE=MyISAM
DROP TABLE IF EXISTS rex_modultyp
CREATE TABLE rex_modultyp ( id int(11) NOT NULL  auto_increment, label varchar(255) NOT NULL  , name varchar(255) NOT NULL  , category_id int(11) NOT NULL DEFAULT 0  , ausgabe text NOT NULL  , bausgabe text NOT NULL  , eingabe text NOT NULL  , func text NOT NULL  , php_enable tinyint(1) NOT NULL DEFAULT 0  , html_enable tinyint(1) NOT NULL DEFAULT 0  , perm_category text NOT NULL  , createuser varchar(255) NOT NULL  , updateuser varchar(255) NOT NULL  , createdate int(11) NOT NULL DEFAULT 0  , updatedate int(11) NOT NULL DEFAULT 0  , PRIMARY KEY(id,category_id,php_enable,html_enable))TYPE=MyISAM
DROP TABLE IF EXISTS rex_template
CREATE TABLE rex_template ( id int(11) NOT NULL  auto_increment, label varchar(255) NOT NULL  , name varchar(255) NOT NULL  , content text NOT NULL  , bcontent text NOT NULL  , active tinyint(1) NOT NULL DEFAULT 0  , date timestamp(14) NULL  , createuser varchar(255) NOT NULL  , updateuser varchar(255) NOT NULL  , createdate int(11) NOT NULL DEFAULT 0  , updatedate int(11) NOT NULL DEFAULT 0  , PRIMARY KEY(id))TYPE=MyISAM
DROP TABLE IF EXISTS rex_user
CREATE TABLE rex_user ( user_id int(11) NOT NULL  auto_increment, name varchar(255) NOT NULL  , description text NOT NULL  , login varchar(50) NOT NULL  , psw varchar(50) NOT NULL  , status varchar(5) NOT NULL  , rights text NOT NULL  , login_tries tinyint(4) NOT NULL DEFAULT 0  , createuser varchar(255) NOT NULL  , updateuser varchar(255) NOT NULL  , createdate int(11) NOT NULL DEFAULT 0  , updatedate int(11) NOT NULL DEFAULT 0  , lasttrydate int(11) NOT NULL DEFAULT 0  , session_id varchar(255) NOT NULL  , PRIMARY KEY(user_id))TYPE=MyISAM