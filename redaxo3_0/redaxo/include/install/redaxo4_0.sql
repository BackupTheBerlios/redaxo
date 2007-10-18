## Redaxo Database Dump Version 4
## Prefix rex_

CREATE TABLE `rex_action` ( `id` int(11) NOT NULL  auto_increment, `name` varchar(255) NOT NULL  , `preview` text NULL  , `presave` text NULL  , `postsave` text NULL  , `previewmode` tinyint(4) NULL  , `presavemode` tinyint(4) NULL  , `postsavemode` tinyint(4) NULL  , `createuser` varchar(255) NOT NULL  , `createdate` int(11) NOT NULL  , `updateuser` varchar(255) NOT NULL  , `updatedate` int(11) NOT NULL  , `revision` int(11) NULL  , PRIMARY KEY (`id`)) TYPE=MyISAM;
CREATE TABLE `rex_article` ( `pid` int(11) NOT NULL  auto_increment, `id` int(11) NOT NULL  , `re_id` int(11) NOT NULL  , `name` varchar(255) NOT NULL  , `catname` varchar(255) NOT NULL  , `catprior` int(11) NOT NULL  , `attributes` text NOT NULL  , `startpage` tinyint(1) NOT NULL  , `prior` int(11) NOT NULL  , `path` varchar(255) NOT NULL  , `status` tinyint(1) NOT NULL  , `createdate` int(11) NOT NULL  , `updatedate` int(11) NOT NULL  , `template_id` int(11) NOT NULL  , `clang` int(11) NOT NULL  , `createuser` varchar(255) NOT NULL  , `updateuser` varchar(255) NOT NULL  , `revision` int(11) NULL  , PRIMARY KEY (`pid`)) TYPE=MyISAM;
CREATE TABLE `rex_article_slice` ( `id` int(11) NOT NULL  auto_increment, `clang` int(11) NOT NULL  , `ctype` int(11) NOT NULL  , `re_article_slice_id` int(11) NOT NULL  , `value1` text NOT NULL  , `value2` text NULL  , `value3` text NULL  , `value4` text NULL  , `value5` text NULL  , `value6` text NULL  , `value7` text NULL  , `value8` text NULL  , `value9` text NULL  , `value10` text NULL  , `value11` text NULL  , `value12` text NULL  , `value13` text NULL  , `value14` text NULL  , `value15` text NULL  , `value16` text NULL  , `value17` text NULL  , `value18` text NULL  , `value19` text NULL  , `value20` text NULL  , `file1` varchar(255) NULL  , `file2` varchar(255) NULL  , `file3` varchar(255) NULL  , `file4` varchar(255) NULL  , `file5` varchar(255) NULL  , `file6` varchar(255) NULL  , `file7` varchar(255) NULL  , `file8` varchar(255) NULL  , `file9` varchar(255) NULL  , `file10` varchar(255) NULL  , `filelist1` text NULL  , `filelist2` text NULL  , `filelist3` text NULL  , `filelist4` text NULL  , `filelist5` text NULL  , `filelist6` text NULL  , `filelist7` text NULL  , `filelist8` text NULL  , `filelist9` text NULL  , `filelist10` text NULL  , `link1` varchar(10) NULL  , `link2` varchar(10) NULL  , `link3` varchar(10) NULL  , `link4` varchar(10) NULL  , `link5` varchar(10) NULL  , `link6` varchar(10) NULL  , `link7` varchar(10) NULL  , `link8` varchar(10) NULL  , `link9` varchar(10) NULL  , `link10` varchar(10) NULL  , `linklist1` text NULL  , `linklist2` text NULL  , `linklist3` text NULL  , `linklist4` text NULL  , `linklist5` text NULL  , `linklist6` text NULL  , `linklist7` text NULL  , `linklist8` text NULL  , `linklist9` text NULL  , `linklist10` text NULL  , `php` text NULL  , `html` text NULL  , `article_id` int(11) NOT NULL  , `modultyp_id` int(11) NOT NULL  , `createdate` int(11) NOT NULL  , `updatedate` int(11) NOT NULL  , `createuser` varchar(255) NOT NULL  , `updateuser` varchar(255) NOT NULL  , `next_article_slice_id` int(11) NULL  , `revision` int(11) NULL  , PRIMARY KEY (`id`,`re_article_slice_id`,`article_id`,`modultyp_id`)) TYPE=MyISAM;
CREATE TABLE `rex_clang` ( `id` int(11) NOT NULL  , `name` varchar(255) NOT NULL  , `revision` int(11) NULL  , PRIMARY KEY (`id`)) TYPE=MyISAM;
CREATE TABLE `rex_file` ( `file_id` int(11) NOT NULL  auto_increment, `re_file_id` int(11) NOT NULL  , `category_id` int(11) NOT NULL  , `attributes` text NULL  , `filetype` varchar(255) NULL  , `filename` varchar(255) NULL  , `originalname` varchar(255) NULL  , `filesize` varchar(255) NULL  , `width` int(11) NULL  , `height` int(11) NULL  , `title` varchar(255) NULL  , `createdate` int(11) NOT NULL  , `updatedate` int(11) NOT NULL  , `createuser` varchar(255) NOT NULL  , `updateuser` varchar(255) NOT NULL  , `revision` int(11) NULL  , PRIMARY KEY (`file_id`)) TYPE=MyISAM;
CREATE TABLE `rex_file_category` ( `id` int(11) NOT NULL  auto_increment, `name` varchar(255) NOT NULL  , `re_id` int(11) NOT NULL  , `path` varchar(255) NOT NULL  , `createdate` int(11) NOT NULL  , `updatedate` int(11) NOT NULL  , `createuser` varchar(255) NOT NULL  , `updateuser` varchar(255) NOT NULL  , `attributes` text NULL  , `revision` int(11) NULL  , PRIMARY KEY (`id`,`name`)) TYPE=MyISAM;
CREATE TABLE `rex_module` ( `id` int(11) NOT NULL  auto_increment, `name` varchar(255) NOT NULL  , `category_id` int(11) NOT NULL  , `ausgabe` text NOT NULL  , `eingabe` text NOT NULL  , `createuser` varchar(255) NOT NULL  , `updateuser` varchar(255) NOT NULL  , `createdate` int(11) NOT NULL  , `updatedate` int(11) NOT NULL  , `attributes` text NULL  , `revision` int(11) NULL  , PRIMARY KEY (`id`,`category_id`)) TYPE=MyISAM;
CREATE TABLE `rex_module_action` ( `id` int(11) NOT NULL  auto_increment, `module_id` int(11) NOT NULL  , `action_id` int(11) NOT NULL  , `revision` int(11) NULL  , PRIMARY KEY (`id`)) TYPE=MyISAM;
CREATE TABLE `rex_template` ( `id` int(11) NOT NULL  auto_increment, `label` varchar(255) NULL  , `name` varchar(255) NULL  , `content` text NULL  , `active` tinyint(1) NULL  , `createuser` varchar(255) NOT NULL  , `updateuser` varchar(255) NOT NULL  , `createdate` int(11) NOT NULL  , `updatedate` int(11) NOT NULL  , `attributes` text NULL  , `revision` int(11) NULL  , PRIMARY KEY (`id`)) TYPE=MyISAM;
CREATE TABLE `rex_user` ( `user_id` int(11) NOT NULL auto_increment, `name` varchar(255) , `description` text , `login` varchar(50) NOT NULL  , `psw` varchar(50) NOT NULL  , `status` varchar(5) NOT NULL  , `rights` text NOT NULL  , `login_tries` tinyint(4) DEFAULT 0 , `createuser` varchar(255) NOT NULL  , `updateuser` varchar(255) NOT NULL  , `createdate` int(11) NOT NULL , `updatedate` int(11) NOT NULL , `lasttrydate` int(11) DEFAULT 0 , `session_id` varchar(255) , `cookiekey` varchar(255) , `revision` int(11), PRIMARY KEY(`user_id`))TYPE=MyISAM;

INSERT INTO `rex_clang` VALUES ('0','deutsch', 0);