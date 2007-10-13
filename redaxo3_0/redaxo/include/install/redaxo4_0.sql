## Redaxo Database Dump Version 4
## Prefix rex_

CREATE TABLE rex_action ( id int(11) NOT NULL auto_increment, name varchar(255) NOT NULL  , preview text , presave text , postsave text , previewmode tinyint(4) , presavemode tinyint(4) , postsavemode tinyint(4) , createuser varchar(255) NOT NULL  , createdate int(11) NOT NULL  , updateuser varchar(255) NOT NULL  , updatedate int(11) NOT NULL  , revision int(11), PRIMARY KEY(id))TYPE=MyISAM;
CREATE TABLE rex_article ( pid int(11) NOT NULL auto_increment, id int(11) NOT NULL , re_id int(11) NOT NULL , name varchar(255) NOT NULL  , catname varchar(255) NOT NULL  , catprior int(11) NOT NULL , attributes text NOT NULL  , startpage tinyint(1) NOT NULL , prior int(11) NOT NULL , path varchar(255) NOT NULL  , status tinyint(1) NOT NULL , createdate int(11) NOT NULL , updatedate int(11) NOT NULL , template_id int(11) NOT NULL , clang int(11) NOT NULL , createuser varchar(255) NOT NULL  , updateuser varchar(255) NOT NULL  , revision int(11), PRIMARY KEY(pid))TYPE=MyISAM;
CREATE TABLE rex_article_slice ( id int(11) NOT NULL auto_increment, clang int(11) NOT NULL , ctype int(11) NOT NULL , re_article_slice_id int(11) NOT NULL , value1 text NOT NULL  , value2 text , value3 text , value4 text , value5 text , value6 text, value7 text , value8 text , value9 text , value10 text , value11 text , value12 text , value13 text , value14 text , value15 text , value16 text , value17 text , value18 text , value19 text , value20 text , file1 varchar(255) , file2 varchar(255) , file3 varchar(255) , file4 varchar(255) , file5 varchar(255) , file6 varchar(255) , file7 varchar(255), file8 varchar(255) , file9 varchar(255) , file10 varchar(255) , filelist1 text , filelist2 text , filelist3 text , filelist4 text , filelist5 text , filelist6 text , filelist7 text , filelist8 text , filelist9 text , filelist10 text , link1 varchar(10) , link2 varchar(10) , link3 varchar(10) , link4 varchar(10) , link5 varchar(10) , link6 varchar(10) , link7 varchar(10) , link8 varchar(10) , link9 varchar(10) , link10 varchar(10) , linklist1 text , linklist2 text , linklist3 text , linklist4 text , linklist5 text , linklist6 text , linklist7 text , linklist8 text , linklist9 text , linklist10 text , php text , html text , article_id int(11) NOT NULL , modultyp_id int(11) NOT NULL , createdate int(11) NOT NULL , updatedate int(11) NOT NULL , createuser varchar(255) NOT NULL  , updateuser varchar(255) NOT NULL  , next_article_slice_id int(11), revision int(11), PRIMARY KEY(id,re_article_slice_id,article_id,modultyp_id))TYPE=MyISAM;
CREATE TABLE rex_clang ( id int(11) NOT NULL , name varchar(255) NOT NULL  , revision int(11), PRIMARY KEY(id))TYPE=MyISAM;
CREATE TABLE rex_file ( file_id int(11) NOT NULL auto_increment, re_file_id int(11) NOT NULL , category_id int(11) NOT NULL , attributes text , filetype varchar(255) , filename varchar(255) , originalname varchar(255) , filesize varchar(255) , width int(11) , height int(11)  , title varchar(255), createdate int(11) NOT NULL, updatedate int(11) NOT NULL , createuser varchar(255) NOT NULL  , updateuser varchar(255) NOT NULL  , revision int(11), PRIMARY KEY(file_id))TYPE=MyISAM;
CREATE TABLE rex_file_category ( id int(11) NOT NULL auto_increment, name varchar(255) NOT NULL  , re_id int(11) NOT NULL , path varchar(255) NOT NULL  , createdate int(11) NOT NULL , updatedate int(11) NOT NULL , createuser varchar(255) NOT NULL  , updateuser varchar(255) NOT NULL  , attributes text , revision int(11), PRIMARY KEY(id,name))TYPE=MyISAM;
CREATE TABLE rex_module_action ( id int(11) NOT NULL auto_increment, module_id int(11) NOT NULL , action_id int(11) NOT NULL , revision int(11), PRIMARY KEY(id))TYPE=MyISAM;
CREATE TABLE rex_module ( id int(11) NOT NULL auto_increment, name varchar(255) NOT NULL  , category_id int(11) NOT NULL , ausgabe text NOT NULL  , eingabe text NOT NULL  , createuser varchar(255) NOT NULL  , updateuser varchar(255) NOT NULL  , createdate int(11) NOT NULL , updatedate int(11) NOT NULL , attributes text , revision int(11), PRIMARY KEY(id,category_id))TYPE=MyISAM;
CREATE TABLE rex_template ( id int(11) NOT NULL auto_increment, label varchar(255) , name varchar(255) , content text , active tinyint(1) , createuser varchar(255) NOT NULL  , updateuser varchar(255) NOT NULL  , createdate int(11) NOT NULL , updatedate int(11) NOT NULL , attributes text , revision int(11), PRIMARY KEY(id))TYPE=MyISAM;
CREATE TABLE rex_user ( user_id int(11) NOT NULL auto_increment, name varchar(255) , description text , login varchar(50) NOT NULL  , psw varchar(50) NOT NULL  , status varchar(5) NOT NULL  , rights text NOT NULL  , login_tries tinyint(4) DEFAULT 0 , createuser varchar(255) NOT NULL  , updateuser varchar(255) NOT NULL  , createdate int(11) NOT NULL , updatedate int(11) NOT NULL , lasttrydate int(11) DEFAULT 0 , session_id varchar(255) , cookiekey varchar(255) , revision int(11), PRIMARY KEY(user_id))TYPE=MyISAM;

INSERT INTO rex_clang VALUES ('0','deutsch', 0);