<?php

##################################################################
#
#      Medienpool Functions - vscope new media design
#
##################################################################

class editor {

	var $id;
    var $content;
    var $width = '';
    var $height = '';
    var $stylesheet = '';
    var $styles = '';
    var $lang = '';
    var $buttonrow1 = '';
    var $buttonrow2 = '';
    var $buttonrow3 = 'empty';
    var $buttonrow4 = 'empty';

    function show(){
        MEDIA_HTMLAREA(
        		$this->id,
                $this->content,
                $this->width,
                $this->height,
                $this->stylesheet,
                $this->styles,
                $this->lang,
                $this->buttonrow1,
                $this->buttonrow2,
                $this->buttonrow3,
                $this->buttonrow4
        );
    }

}

function MEDIA_HTMLAREA($VALUE_ID=1,$CONTENT,$WIDTH='',$HEIGHT='',$STYLE_SHEET='',$STYLES='',$LANG='',$BUTTONROW1='',$BUTTONROW2='',$BUTTONROW3='empty',$BUTTONROW4='empty'){

        // lang = de oder en

        global $TINYMCE;

        if($WIDTH =='') 		$WIDTH="100%";
        if($HEIGHT =='') 		$HEIGHT="300px";
        if($STYLE_SHEET =='') 	$STYLE_SHEET="css/style.css";
        if($STYLES =='') 		$STYLES="all";
        if($LANG =='') 			$LANG="de";

		// All buttons
        /*

        editor buttons:
        bold, italic, underline, strikethrough, justifyleft, justifycenter, justifyright, justifyfull,
        styleselect, bullist, numlist, outdent, indent, undo,redo, link, unlink, image,
        cleanup, help, code, table, row_before, row_after, delete_row, separator, rowseparator,
        col_before, col_after, delete_col, hr, removeformat, sub, sup, formatselect, fontselect,
        fontsizeselect, forecolor, charmap, visualaid, spacer, cut, copy, paste,

        redaxo buttons:
        linkHack,pasteRichtext,insertEmail
        

        */

        if($BUTTONROW1==""){
        	$BUTTONROW1 = "styleselect,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,bullist,numlist,outdent,indent";
        }
        if($BUTTONROW2==""){
        	$BUTTONROW2 = "link,linkHack,unlink,insertEmail,separator,image,separator,removeformat,pasteRichtext,code";
        }
        if($BUTTONROW3==""){
        	$BUTTONROW3 = "tablecontrols, separator, visualaid";
        }
        if($BUTTONROW4==""){
        	$BUTTONROW4 = "rowseparator,formatselect,fontselect,fontsizeselect,forecolor,charmap";
        }

        // tiny mce init
        if($TINYMCE!="done"){

				print '
	            <!-- tinyMCE -->
	            <script language="javascript" type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
	            <script language="javascript" type="text/javascript">
	                tinyMCE.init({
	                    language : "'.$LANG.'",
	                    mode : "specific_textareas",
                        plugins : "redaxo",
                        // plugins : "redaxo,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,flash,searchreplace,print",
	                    theme : "advanced",
                        theme_advanced_buttons1 : "'.$BUTTONROW1.'",
                        theme_advanced_buttons2 : "'.$BUTTONROW2.'",
                        theme_advanced_buttons3 : "'.$BUTTONROW3.'",
                        theme_advanced_buttons3_add : "'.$BUTTONROW4.'",
	                    theme_advanced_toolbar_location : "top",
	                    theme_advanced_toolbar_align : "left",
	                    theme_advanced_path_location : "bottom",
	                    content_css : "'.$STYLE_SHEET.'",
	                    plugin_insertdate_dateFormat : "%d.%m.%Y",
	                    plugin_insertdate_timeFormat : "%H:%M:%S",
	                    extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	                    external_link_list_url : "example_link_list.js",
	                    external_image_list_url : "example_image_list.js",
	                    flash_external_list_url : "example_flash_list.js",
	                    insertimage_callback : "insertMediaPool",
	                    insertlink_callback : "insertIntLink"
	                    //file_browser_callback : "fileBrowserCallBack"
	                });

	                function fileBrowserCallBack(field_name, url, type) {
	                    // This is where you insert your custom filebrowser logic
	                    alert("Filebrowser callback: " + field_name + "," + url + "," + type);
	                }

					// custom redaxo callback functions
	                function insertMediaPool(src, alt, border, hspace, vspace, width, height, align){
	                	window.open("index.php?page=medienpool&HTMLArea=TINY","pool","width=660,height=500,status=yes,resizable=yes,scrollbars=yes");
	                }

	                function insertIntLink(href, target){
	                        window.open("index.php?page=linkmap&HTMLArea=TINY","link","width=660,height=500,status=yes,resizable=yes,scrollbars=yes");
	                }

	                function tinyMCEEmail(){
	                        var email = prompt("Geben Sie eine Emailadresse ein","");
	                        alert(tinyMCE.getContent());
	                        tinyMCE.execCommand("mceInsertContent", false, "<a href=mailto:"+email+">"+email+"</a>");
	                }

	            </script>
	            <!-- /tinyMCE -->
	            ';

				$GLOBALS[TINYMCE] = 'done';

        }


        print '

        <textarea id="VALUE['.$VALUE_ID.']" name="VALUE['.$VALUE_ID.']" style="width:'.$WIDTH.';height:'.$HEIGHT.'" rows="15" mce_editable="true">'.$CONTENT.'</textarea>

        ';

}

function media_resize($FILE,$width,$height,$make_copy=false){

        $REX = $GLOBALS[REX];

        if ($REX[IMAGEMAGICK])
        {
                $magick = $REX[IMAGEMAGICK_PATH];

                if($width>0){
                        $sizer = "-geometry ".$width;
                }else if($height>0){
                        $sizer = "-geometry x".$height;
                }else if($width>0 && $height!=""){
                        $sizer = "-geometry ".$width."x".$height."!";
                }

                $system = $magick." ".$FILE." ".$sizer." -colorspace rgb -density 72 ".$FILE;
                system($system);
        }else
        {
                return false;
        }
}

function media_savefile($FILE,$rex_file_category,$FILEINFOS){

        $FILENAME = $FILE[name];
        $FILESIZE = $FILE[size];
        $FILETYPE = $FILE[type];
        $NFILENAME = "";
        $REX = $GLOBALS[REX];

        // generiere neuen dateinamen
        for ($cn=0;$cn<strlen($FILENAME);$cn++)
        {
               $char = substr($FILENAME,$cn,1);
               if ( preg_match("([_A-Za-z0-9\.-])",$char) ) $NFILENAME .= strtolower($char);
               else if ($char == " ") $NFILENAME .= "_";
        }


        if (strrpos($NFILENAME,".") != "")
        {
               $NFILE_NAME = substr($NFILENAME,0,strlen($NFILENAME)-(strlen($NFILENAME)-strrpos($NFILENAME,".")));
               $NFILE_EXT  = substr($NFILENAME,strrpos($NFILENAME,"."),strlen($NFILENAME)-strrpos($NFILENAME,"."));
        }else
        {
               $NFILE_NAME = $NFILENAME;
               $NFILE_EXT  = "";
        }

        if ( $NFILE_EXT == ".php" || $NFILE_EXT == ".php3" || $NFILE_EXT == ".php4" || $NFILE_EXT == ".php5" || $NFILE_EXT == ".phtml" || $NFILE_EXT == ".pl" || $NFILE_EXT == ".asp"|| $NFILE_EXT == ".aspx"|| $NFILE_EXT == ".cfm" )
        {
               $NFILE_EXT .= ".txt";
        }

        $NFILENAME = $NFILE_NAME.$NFILE_EXT;

        if (file_exists($REX[MEDIAFOLDER]."/$NFILENAME"))
        {
               // datei schon vorhanden ? wenn ja dann _1
               for ($cf=0;$cf<1000;$cf++)
               {
                       $NFILENAME = $NFILE_NAME."_$cf"."$NFILE_EXT";
                       if (!file_exists($REX[MEDIAFOLDER]."/$NFILENAME")) break;
               }
        }

        if(!move_uploaded_file($FILE[tmp_name],$REX[MEDIAFOLDER]."/$NFILENAME"))
        {
            if (!copy($FILE[tmp_name],$REX[MEDIAFOLDER]."/$NFILENAME"))
            {
                   $message .= "move file $FILENAME failed | ";
                   $ok = 0;
                   $nocopy = true;
            }
        }

        if(!$nocopy)
        {

                if ($REX[MEDIAFOLDERPERM] == "") $REX[MEDIAFOLDERPERM] = "0777";
                chmod($REX[MEDIAFOLDER]."/$NFILENAME", 0777);

                // get widht height
                $size = @getimagesize($REX[MEDIAFOLDER]."/$NFILENAME");

                $FILESQL = new sql;
                //$FILESQL->debugsql=1;
                $FILESQL->setTable("rex_file");
                $FILESQL->setValue("filetype",$FILETYPE);
                $FILESQL->setValue("title",$FILEINFOS[title]);
                $FILESQL->setValue("description",$FILEINFOS[description]);
                $FILESQL->setValue("copyright",$FILEINFOS[copyright]);
                $FILESQL->setValue("filename",$NFILENAME);
                $FILESQL->setValue("originalname",$FILENAME);
                $FILESQL->setValue("filesize",$FILESIZE);
                $FILESQL->setValue("width",$size[0]);
                $FILESQL->setValue("height",$size[1]);
                $FILESQL->setValue("category_id",$rex_file_category);
                $FILESQL->setValue("stamp",time());
                $FILESQL->insert();

                $ok = 1;
        }

        $RETURN[msg] = $message;
        $RETURN[ok] = $ok;
        $RETURN[filename] = $NFILENAME;

        return $RETURN;
}

function getfilesize($size) {

   // Setup some common file size measurements.
   $kb = 1024;         // Kilobyte
   $mb = 1024 * $kb;   // Megabyte
   $gb = 1024 * $mb;   // Gigabyte
   $tb = 1024 * $gb;   // Terabyte
   // Get the file size in bytes.

   // If it's less than a kb we just return the size, otherwise we keep going until
   // the size is in the appropriate measurement range.
   if($size < $kb) {
       return $size." Bytes";
   }
   else if($size < $mb) {
       return round($size/$kb,2)." KBytes";
   }
   else if($size < $gb) {
       return round($size/$mb,2)." MBbytes";
   }
   else if($size < $tb) {
       return round($size/$gb,2)." GBytes";
   }
   else {
       return round($size/$tb,2)." TBbytes";
   }
}

?>
