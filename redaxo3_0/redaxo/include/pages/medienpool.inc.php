<?

error_reporting( E_ALL);

// TODO

// Alle Funktionen fuer medienpool nur hier einbauen

// permissions einbauen �ber
// nur user mit $REX_USER->isValueOf("rights","admin[]"); koennen die ordnerverwaltung starten
// sofern zugriff auf eine categorie dann auch zugriff auf die unterkategorien
// keine speziellen filezugriffseinschraenkungen

// wegen der files in ordner verschieben oder loeschen geschichte wuerde ich gerne
// alles �ber "echte" submit buttons abschicken lassen und auch die markierten reihen sollten
// "eingef�rbt" werden

// verschieben funktionen mit $REX_USER->isValueOf("rights","advancedMode[]");  schuetzen


/**
 * Redaxo - Mediapool v3
 * @author Markus Staab http://www.public-4u.de
 */

// Funktionen nur ausf�hren wenn der Medienpool als Page aufgerufen wird.
// 
// Falls dieser nur als include in einem anderen Addon dient,
// => NICHTS anzeigen 
// => NUR Klassen zur Verf�ung stellen
$params = new rexPoolParams();
 
if ( $_REQUEST['page'] == $params->page) {
    $pool = new rexPool( $params);
    
    // Action verarbeiten
    $pool->handleAction();
}

class rexPoolComponent {
    var $params;
    
    function rexPoolComponent( &$params) {
        $this->params =& $params;
    }
    
    function _dateFormat() {
        return 'd-M-Y | H:i';
    }
    
    function _link( $label, $params = '', $additional = array()) {
        $add = '';
        if ( is_array( $additional)) {
            foreach( $additional as $addName => $addValue) 
            {
                $add .= ' '. $addName . '="'. $addValue . '"';
            }
        }
        
        if ( $params != '') { 
            if ( $params[0] != '&') {
                $params = '&' . $params;
            }
            $params = htmlentities( $params);
        }
        return '<a href="?page='. $this->params->page . $params .'"'. $add .'>'. $label .'</a>';
    }
    
    function _title( $title = '') {
        global $I18N;
        title($I18N->msg('pool_name'), '&nbsp;&nbsp;&nbsp;'.$title, 'grey', '100%');
    }
    
    function _imageSrc( $media) {
        global $REX;
        if ( empty( $REX['ABS_REX_ROOT'])) {
            $REX['ABS_REX_ROOT'] = str_replace( "/redaxo/index.php", "",$_SERVER['SCRIPT_NAME']); 
        }
        $src = $REX['ABS_REX_ROOT'] . $REX['WWW_PATH'] .'/files/'. $filename;
        
        return $src;
    }
    
    function _indent( $level, $indentStr = '   ') {
        return str_repeat( $indentStr, $level);
    }
}

class rexPoolComponentList extends rexPoolComponent {
    var $columns;
    
    function rexPoolComponentList( &$params, &$columns) {
        parent::rexPoolComponent( $params);
        $this->columns =& $columns;
    } 
    
    function _getColGroup( $indent = 3) {
        $colgroup = $this->_indent( $indent) .'<colgroup>'. "\n";
        
        foreach ( $this->columns as $columnName => $columnWidth) {
            $colgroup .= $this->_indent( $indent + 1) .'<col width="'. $columnWidth .'"/>'. "\n";
        }
        
        $colgroup .= $this->_indent( $indent) .'</colgroup>'. "\n";
        
        return $colgroup;
    }
    
    function _getColLabels( $indent = 3) {
        $collabels = $this->_indent( $indent) .'<tr>'. "\n";
        
        foreach ( $this->columns as $columnName => $columnWidth) {
            $collabels .= $this->_indent( $indent + 1) .'<th>'. $columnName .'</th>'. "\n";
        }
        
        $collabels .= $this->_indent( $indent) .'</tr>'. "\n";
        
        return $collabels;
    }
    
    function _getTable( $indent = 2) {
        return $this->_indent( $indent) .'<table class="rex" cellpadding="5" cellspacing="1">'. "\n";
    }
    
    function _getTableEnd( $indent = 2) {
        return $this->_indent( $indent) .'</table>'. "\n";
    }
    
    function formatTableHead( $labels = true, $groups = true) {
        $s = $this->_getTable();
        
        if ( $groups) {
            $s .= $this->_getColGroup();
        }
        
        if ( $labels) {
            $s .= $this->_getColLabels();
        }
        
        return $s;
    }
    
    function formatTableEnd() {
        return $this->_getTableEnd();
    }
}


class rexPoolUpload extends rexPoolComponent {
    function rexPoolUpload( $params) {
        parent::rexPoolComponent( $params);
    }
    
    function _title( $modes = array( 'file' => 'pool_upload_file')) {
        global $I18N;
        
        $subtitle = '';
        $actMode = $this->params->mode;
        
        $first = true;
        foreach( $modes as $modeName => $modeLabelKey) {
            $modeLabel = $I18N->msg( $modeLabelKey);
            
            if ( $first) {
                $first = false;
            } else {
                $subtitle .= ' : ';
            }
            
            if( $modeName != $actMode) {
                $subtitle .= rexPool::_link( $modeLabel, 'action=media_upload&mode='. $modeName);
            } else {
                $subtitle .= $modeLabel;
            } 
        }
        
        parent::_title( $subtitle);        
    }
    
    function &handle( &$file, $register = true) {
        global $REX, $REX_USER, $I18N;
        
        $newFilename = basename( strtolower( str_replace( ' ', '_', $file['name'])));
        
        $result = array();
        $result['title']       = isset( $_POST['mediaTitle']) ? $_POST['mediaTitle'] : '';
        $result['description'] = isset( $_POST['mediaDescription']) ? $_POST['mediaDescription'] : '';
        $result['copyright']   = isset( $_POST['mediaCopyright']) ? $_POST['mediaCopyright']: '';
        $result['cat_id']      = isset( $_POST['mediaCatId']) ? $_POST['mediaCatId'] : '';
        
        $result['orgname'] = $file['name'];
        $result['size']    = $file['size'];
        $result['type']    = $file['type'];
        $result['width']   = '';
        $result['height']  = '';

        $result['createdate'] = time();
        $result['createuser'] = $REX_USER->getValue('login');
        $result['updatedate'] = time();
        $result['updateuser'] = $REX_USER->getValue('login');
        
        $result['error'] = '';
            
        if (strrpos($newFilename,'.') != '')
        {
            $fname = substr( $newFilename, 0, strrpos( $newFilename, '.'));
            $extension  = OOMedia::_getExtension( $newFilename);
            
            $illegals = array( 'php', 'php3', 'php4', 'php5', 'phtml', 'pl', 'asp', 'aspx', 'cfm', 'sh');
            if ( in_array( $extension, $illegals))
            {
                $extension .= ".txt";
            }

            $result['name'] = $this->_genFileName( $fname .'.'. $extension);
            $absFile = $REX['MEDIAFOLDER'] . '/'. $result['name'];
            
            if ( move_uploaded_file( $file['tmp_name'], $absFile) || 
                 copy( $file['tmp_name'], $absFile))
            {
                if ( $REX['MEDIAFOLDERPERM'] == '') {
                     $REX['MEDIAFOLDERPERM'] = '0777';
                }
                
                chmod( $absFile, $REX['MEDIAFOLDERPERM']);
            } 
            else
            {
                $result['error'] .= $I18N->msg('pool_error_move_failed', $result['orgname']); 
            }
            
            if ( OOMedia::_isImage( $absFile)) {
                if( $size = @getimagesize( $absFile)) {
                    $result['width'] = $size[0];
                    $result['height'] = $size[1];
                }
            }
        }
        else
        {
            $result['error'] .= $I18N->msg('pool_error_miss_file_ext', $result['orgname']);
        }
        
//        var_dump( $absFile);
//        var_dump( $newFilename);
        
//        var_dump( $result);
        
        // Bei Fehlern ist hier schluss
        if( $result['error'] != '') {
            return $result['error'];
        }
        
        // Dateien die nur hochgeladen werden sollen, aber nicht in der DB registriert
        if( !$register) {
            return true;
        }
        
        // Objekt anlegen
        $media = new OOMedia();
        unset( $result['error']);
        
        // Attribute zuweisen
        foreach ( $result as $detail => $value) {
            $detail = '_'. $detail;
            $media->$detail = $value;
        }
        
        // Speichern
        $media->_insert();
        
        return true;
    }
    
    function _genFileName( $filename) {
        global $REX;
        
        $fname = substr( $filename, 0, strrpos( $filename, '.'));
        $extension  = OOMedia::_getExtension( $filename);
        
        // datei schon vorhanden ? wenn ja dann _1
        $t = 1;
        while( file_exists($absFile = $REX['MEDIAFOLDER'] .'/'. $filename))
        {
            $filename = $fname .'_'. $t .'.'. $extension;
            $t++;
        }
        
        return $filename;
    }
} 

/**
 * Main-Class
 */
class rexPool extends rexPoolComponent {
    /**  Parameter des Medienpools */
    var $params;
    
    /**  Die aktuell angezeigte Kategorie */
    var $cat;
    
    /**  Die Kind-Kategorien der aktuellen Kategorie*/
    var $catList;
    
    /**  Die Medien der aktuellen Kategorie*/
    var $mediaList;
    
    function rexPool( &$params) {
        parent::rexPoolComponent( $params);
        
        // Evtl. Formular Posts verarbeiten
        $this->handlePosts();
        
        // Liste der anzuzeigenden Kategorien
        $catId = $params->catId;
        
        if( $catId !== '') {
            $ooCurrentCat = OOMediaCategory::getCategoryById( $catId);
            $currentCat = new rexMediaCategory( $params, $ooCurrentCat);
        } else {
            $currentCat = null;
            $ooMediaList = null;
        }
        
        $this->cat =& $currentCat;
        $this->catList =& new rexMediaCategoryList( $params, $ooCurrentCat);
        $this->mediaList =& new rexMediaList( $params, $ooCurrentCat); 
    }
    
    function &_getCat() {
        return $this->cat;
    }
    
    function &_getCatList() {
        return $this->catList;
    }
    
    function &_getMediaList() {
        return $this->mediaList;
    }
    
    function listMedia() {
        global $I18N;
        
        $currentCat =& $this->_getCat();
        
        // Pfad der aktuellen Kategorie anzeigen
        $path = 'Pfad: '. rexPool::_link( $I18N->msg('pool_default_cat'), '');
        if( $currentCat != null) {
            $currentOOCat =& $currentCat->_getOOCat();
            
            $pathList = explode( '|', $currentOOCat->getPath());
            
            // Pfad zur aktuellen Kategorie
            foreach ( $pathList as $pathCatId) {
                if( $pathCatId == '') {
                    continue;
                }
                
                $pathCat = OOMediaCategory::getCategoryById( $pathCatId);
                $path .= ' : '.$this->_link( $pathCat->getName(), 'cat_id='. $pathCat->getId());
            }
            
            // Aktuelle Kategorie
            $path .= ' : '. $this->_link( $currentOOCat->getName(), 'cat_id='. $currentOOCat->getId());
        }
        
        $this->_title( $path);
        
        $catList =& $this->_getCatList();
        if ( $catList !== null) {
            echo $catList->format();
        }

        // In der Root-Kategorie keine Medias anzeigen        
        if( $currentCat != null) {
            $mediaList =& $this->_getMediaList();
            if ( $mediaList !== null) {
                echo $mediaList->format();
            }
        }
    }
    
    function mediaDetails() {
        global $I18N;
        
        rexPool::_title( $I18N->msg('pool_file_detail'));
        
        if ( !isset( $_GET['media_id'])) {
            rexParam::miss( 'media_id');
        }
        
        $mediaId = $_GET['media_id'];
        $media = OOMedia::getMediaById( $mediaId);
        
        echo '       <table class="rex" cellpadding="5" cellspacing="1">
             '. rexMedia::formatDetailed( $media) .'
                     </table>';
    }
    
    function handleAction() {
        // Ausgabe des Seitenkopfes
        $this->_header();
        
        switch ( $this->params->action) {
            case 'cat_details'   : $this->catDetails();   break;
            case 'media_details' : $this->mediaDetails(); break;
            case 'media_upload'  : $this->mediaUpload(); break;
        //    case 'media_search'  : rexPool::mediaDetails(); break;
            default              : $this->listMedia();
        }
        
        // Ausgabe des Seitenfu�es
        $this->_footer();
    }
    
    function handlePosts() {
        global $REX_USER;
        
        if ( !isset ( $_POST)) {
            return;
        }
        
        // Kategorie anlegen/speichern
        if ( isset( $_POST['saveCatButton']))
        {
            // Id der Kategorie in der sich die zu editieren de Kategorie befindet (ParentId)
            $catId = $this->params->catId;
            // Id der zu editierenden Kategorie
            $catModId = $this->params->catModId;
            
            if( $catModId !== '') {
                $cat = OOMediaCategory::getCategoryById( $catModId);
            } else {
                $cat = new OOMediaCategory();
                $cat->_parent_id = $catId;
                $cat->_createdate = time();
                $cat->_createuser = $REX_USER->getValue('login');
                
                if ( $cat->hasParent()) {
                    $parent = $cat->getParent();
                    $cat->_path = $parent->getPath() . $parent->getId() . '|';
                } else {
                    $cat->_path = '|'; 
                }
            }
            
            $cat->_updatedate = time();
            $cat->_updateuser = $REX_USER->getValue('login');
            $cat->_name = $_POST['catName'];
            
            $cat->_save();
            
            // Speicher freigeben
            unset( $cat);
        }
        // Kategorie l�schen
        else if ( isset( $_POST['deleteCatButton'])) 
        {
            // Id der zu l�schenden Kategorie
            $catModId = rexPoolParam::catModId();
            $cat = OOMediaCategory::getCategoryById( $catModId);
            
            $cat->_delete();
            
            // Speicher freigeben
            unset( $cat);
        }
    }
    
    function mediaUpload() {
        global $REX,$I18N;
        
        $message = '';
        
        $upload = new rexPoolUpload( $this->params);
        
        echo $upload->_title();
        
        // handle file upload(s)
        if( !empty($_POST)) {
            
            $message = $I18N->msg( 'pool_media_uploaded');
            
            
            foreach( $_FILES as $file) {
                if (( $result = $upload->handle( $file)) !== true) {
                    $message = $result;
                    break;
                }
            }
        }
        
        echo rexMedia::formatForm( $message);
    }
    
    function _header() {
        global $I18N, $REX;
        // TODO HIER NOCH F�LLEN
        $opener_input_field = 'IRGENDWAS';
    ?>
    <html>
       <head>
          <title><?php echo $REX['SERVERNAME'] .' - '. $I18N->msg('pool_name'); ?></title>
          <link rel=stylesheet type=text/css href=css/style.css>
          <script language=Javascript>
          <!--
          var redaxo = true;
          
          function selectMedia(filename)
          {
             opener.document.REX_FORM.<?php echo $opener_input_field ?>.value = filename;
             self.close();
          }
          
          function openImage(image){
             window.open('index.php?page=medienpool&amp;popimage='+image,'popview','width=123,height=111');
          }
          
          function insertHTMLArea(html){
             window.opener.tinyMCE.execCommand('mceInsertContent', false, html);
             self.close();
          }
    
          function fileListFunc(func)  {
             document.rex_file_list.media_method.value=func;
             document.rex_file_list.submit();
          }
          
          function checkBoxes(FormName, FieldName, CheckValue)
          {
             // alert( 'Checkvalue ' + CheckValue);
             if(!document.forms[FormName]) {
                // alert( 'Form gibts nicht');
                return;
             }
             
             var objCheckBoxes = document.forms[FormName].elements[FieldName];
             
             if(!objCheckBoxes) {
                // alert( 'Boxen gibts nicht');
                return;
             }
             
             var countCheckBoxes = objCheckBoxes.length;
             if(!countCheckBoxes) {
                objCheckBoxes.checked = CheckValue;
             } else {
                // set the check value for all check boxes
                for(var i = 0; i < countCheckBoxes; i++) {
                   objCheckBoxes[i].checked = CheckValue;
                }
             }
          }
          //-->
          </script>
       </head>
    <body>
    
       <table class="rexHeader" style="width: 100%;" cellpadding="5" cellspacing="0">
       
          <tr>
             <th colspan="3"><?php echo $I18N->msg('pool_media') .' '. $REX['SERVERNAME']; ?></th>
          </tr>
    
          <tr>
             <td>
               <?php echo rexPool::_link( $I18N->msg('pool_file_list'), '', array( 'class' => 'white')) ?> |
               <?php echo rexPool::_link( $I18N->msg('pool_file_upload'), 'action=media_upload&mode=file', array( 'class' => 'white')) ?> |
               <?php echo rexPool::_link( $I18N->msg('pool_file_search'), 'action=media_search', array( 'class' => 'white')) ?>
             </td>
          </tr>
          
       </table>
       
       <form name="poolForm" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" style="display: inline;" enctype="multipart/form-data">
       
          <input type="hidden" name="page" value="medienpool"/>
          <input type="hidden" name="action" value="<?php echo $this->params->action ?>"/>
          <input type="hidden" name="mode" value="<?php echo $this->params->mode ?>"/>
          <input type="hidden" name="cat_id" value="<?php echo $this->params->catId ?>"/>
          <input type="hidden" name="cat_modid" value="<?php echo $this->params->catModId ?>"/>
          <input type="hidden" name="opener_input_field" value="<?php echo $this->params->editorName ?>"/>
          
    <?php
    }
    
    function _footer() {
        global $I18N;
    ?>
       </form>
       
       <a name="bottom"></a>
       <br/>
       <table class="rexFooter" style="width: 100%" cellpadding="5" cellspacing="0">
       
          <tr>
             <th colspan="2">&nbsp;</th>
          </tr>
          
          <tr>
             <td>
                <a href="http://www.pergopa.de" target="_blank" class="black">pergopa kristinus gbr</a> |
                <a href="http://www.redaxo.de" target="_blank" class="black">redaxo.de</a> |
                <a href="http://forum.redaxo.de">?</a>
             </td>
             <td style="text-align: right;">
                <?php echo showScripttime() ?> sec | <?php echo strftime($I18N->msg("dateformat"))?>
             </td>
          </tr>
             
          </table>
    
       </body>
    </html>
    <?php
    }
} 

/**
 * Class which provides getter functions for all needed pool-parameters
 * All Methods are static!
 */
class rexPoolParams {
    var $page;
    
    var $catId;
    var $catModId;
    
    var $mediaId;
    
    var $action;
    var $mode;
    
    var $editorName;
    var $isEditorMode;
    
    function rexPoolParams() {
        $this->page = 'medienpool';
         
        $this->catId = !empty( $_REQUEST['cat_id']) ? (int) $_REQUEST['cat_id'] : '';
        $this->catModId = !empty( $_REQUEST['cat_modid']) ? (int) $_REQUEST['cat_modid'] : '';
        
        $this->mediaId = !empty( $_REQUEST['media_id']) ? (int) $_REQUEST['media_id'] : '';
        
        $this->action = !empty( $_REQUEST['action']) ? $_REQUEST['action'] : '';
        $this->mode = !empty( $_REQUEST['mode']) ? $_REQUEST['mode'] : '';
        
        $this->editorName = !empty( $_REQUEST['opener_input_field']) ? $_REQUEST['opener_input_field'] : '';
        $this->isEditorMode = $this->editorName != '';  
    }
    
    function miss( $paramName) {
        global $I18N;
        exit( '<p>'. $I18N->msg('pool_error_miss_param', $paramName) .'</p>');
    }
}

// user mit media[all] kann alle ordner sehen und bearbeiten + kategorien erstellen/bearbeiten ...
// user mit media[10] kann in kat 10 alles

// user mit media_add[all] darf adden
// user mit media_edit[all] darf editieren
// user mit media_delete[all] darf l�schen
// user mit media_get[all] darf jedes bild selektieren

// user mit media_add[10] darf in kat 10 adden
// user mit media_edit[10] darf in kat 10 editieren
// user mit media_delete[10] darf in kat 10 l�schen
// user mit media_get[10] darf in kat 10 jedes bild selektieren

/**
 * Class which provides all functions for permission purposes
 * All Methods are static!
 */
class rexPoolPerm {
    function rexPoolPerm() {
        die( 'class-instantiation not allowed for class "' .__CLASS__ .'"');
    }
    
    function hasPerm( $perm) {
//        var_dump( $perm);
        global $REX_USER;
        return $REX_USER->isValueOf( 'rights', $perm);
    }

    function hasMediaPerm( $sub, &$cat) {
        $valids = array( '', '_add', '_edit', '_delete', '_get');
        if ( !in_array( $sub, $valids)) {
            return false;
        }
        $catId = $cat->getId();
        
        if( rexPoolPerm::isAdmin() ||
            rexPoolPerm::isPoolAdmin() ||
            rexPoolPerm::isOwner( $cat->getCreateUser()) ||
            rexPoolPerm::hasCatPerm( $catId)) 
        {
            return true;
        }
        
        return rexPoolPerm::hasPerm( 'media'. $sub .'[all]') ||
               rexPoolPerm::hasPerm( 'media'. $sub .'['. $catId .']');
    }
    
    function isOwner( $userId) {
        global $REX_USER;
        return $REX_USER->isValueOf( 'user_id', $userId);
    }
    
    function isAdvanced() {
        return rexPoolPerm::hasPerm( 'advancedMode[]');
    }
    
    function isAdmin() {
        return rexPoolPerm::hasPerm( 'admin[]');
    }

    function isPoolAdmin() {
        return rexPoolPerm::hasPerm( 'media[all]');
    }
    
    function hasCatPerm( &$cat) {
        return rexPoolPerm::hasMediaPerm( '', $cat);
    }

    function hasAddPerm( &$cat) {
        return rexPoolPerm::hasMediaPerm( '_add', $cat);
    }

    function hasEditPerm( &$cat) {
        return rexPoolPerm::hasMediaPerm( '_edit', $cat);
    }
    
    function hasDelPerm( &$cat) {
        return rexPoolPerm::hasMediaPerm( '_delete', $cat);
    }
    
    function hasGetPerm( &$cat) {
        return rexPoolPerm::hasMediaPerm( '_get', $cat);
    }
}

class rexMediaCategoryList extends rexPoolComponentList  {
    
    var $cat;
    var $cats;
    
    function rexMediaCategoryList( &$params, &$ooCat) {
        global $I18N;
        
        $this->cat =& $ooCat;
        // Parameter hier schon als klassen-variable setzten,
        // da diese unten schon vorm parent-konstruktor aufruf 
        // gebraucht werden (_formatAddLink())
        $this->params =& $params;
        
        if ( $ooCat === null) {
            $ooCatList =& OOMediaCategory::getRootCategories();
        } else {
            $ooCatList =& $ooCat->getChildren();
        }
        
        // hier darf kein foreach stehen wegen problemem mit den referenzen!
        for( $i = 0; $i < count( $ooCatList); $i++) {
            $ooCat =& $ooCatList[ $i];
            $this->cats[] =& new rexMediaCategory( $params, $ooCat); 
        }
        
//            var_dump( $this->cats);
        $columns = array( 
            $this->_formatAddLink() => '30px',
            '<input type="checkbox" onchange="checkBoxes( \'poolForm\', \'cat_id[]\', this.checked)"/>' => '30px',
            $I18N->msg('pool_colhead_category') => '*', 
            $I18N->msg('pool_colhead_details') => '190px',
            $I18N->msg('pool_colhead_edit') => '190px'
        );
        
        parent::rexPoolComponentList( $params, $columns);
    } 
    
    function _formatAddLink() {
        global $I18N;
        $s = '';
        $cat = null;
        $catId = $this->params->catId;
        
        if ( $catId !== '') {
            $cat = OOMediaCategory::getCategoryById( $catId);
        }
        
        if ( $cat === null || rexPoolPerm::hasAddPerm( $cat)) {
            $s .=  $this->_link( '<img src="pics/folder_plus.gif" style="width: 16px; height:16px" alt="'. $I18N->msg('pool_add_category') .'">' , 'action=cat_add&cat_id='. $catId);
        }
        
        return $s;
    }
    
    function _formatParent() {
        if ( $this->cat === null || !$this->cat->hasParent()) {
            return;
        }
        
        $formatCategoryParent = ' 
              <tr>
                 <td></td>
                 <td colspan="4">'. $this->_link( '..', 'cat_id='. $this->cat->getId()) .'</td>
              </tr>'. "\n";
              
        return $formatCategoryParent;
    }
    
    function formatTableHead() {
        return parent::formatTableHead() . $this->_formatParent();
    }
    
    function format() {
        $s = '';
        
        $s .= $this->formatTableHead();
        $catModId = $this->params->catModId;
        
        if ( $this->cats === null) {
            return $s;
        }
                
        foreach( $this->cats as $rexCat) {
            $ooCat =& $rexCat->_getOOCat();
            
            if ( !rexPoolPerm::hasCatPerm( $ooCat)) {
                continue;
            }
            
            if( empty( $_POST) && $ooCat->getId() == $catModId) {
                $s .= $rexCat->formatForm();
            } else {
                $s .= $rexCat->format();
            }
        }
        
        return $s;
    }
}
 
/**
 * Category-Class
 * All Methods are static!
 */
class rexMediaCategory extends rexPoolComponent {
    
    var $ooCat;
    
    function rexMediaCategory( &$params, &$ooCat) {
        parent::rexPoolComponent( $params);
        $this->ooCat =& $ooCat;
    }
    
    function format() {
        $cat =& $this->_getOOCat();
        $s = '
              <tr>
                 <td><img src="pics/folder.gif" style="width: 16px; height:16px; margin: auto;"></td>
                 <td><input type="checkbox" name="cat_id[]" value="'. $cat->getId() .'"/></td>
                 <td>'. $this->_formatName() .'</td>
                 <td>'. $this->_formatDetails() .'</td>
                 <td>'. $this->_formatActions() .'</td>
              </tr>'. "\n";
              
        return $s;
    }
    
    function _formatName() {
        global $REX_USER;
        $cat =& $this->_getOOCat();
        
        $name = rexPool::_link( $cat->getName(), 'cat_id='. $cat->getId());
        
        // Im AdvancedMode IDs der Kategorien anzeigen
        if ( rexPoolPerm::isAdvanced()) {
            $name .= ' ['. $cat->getId() .']';
        } 
        
        return $name;        
    }
    
    function _formatActions() {
        global $I18N;
        $OOCat =& $this->_getOOCat();
        $OOCatId = $OOCat->getId();
        
        // Pr�fen der Berechtigungen
        if ( !rexPoolPerm::hasDelPerm( $OOCat) && !rexPoolPerm::hasEditPerm( $OOCat)) {
            return '';
        }
        
        return rexPool::_link( $I18N->msg('pool_cat_action'), 'cat_id='. $this->params->catId .'&cat_modid='. $OOCatId);;
    }
    
    function _formatDetails() {
        global $I18N;
        $cat =& $this->_getOOCat();
        
        $s = $I18N->msg('pool_subcats').': '. $cat->countChildren() . '<br/>'.
             $I18N->msg('pool_files').': '. $cat->countFiles();
        
        return $s;
    }
    
//    function formatList( &$catList) {
//        if ( !is_array( $catList)) {
//            return '';
//        }
//        
//        $s = "\n".
//             '       <table class="rex" cellpadding="5" cellspacing="1">
//             '. rexMediaCategory::_formatColGroup()
//              . rexMediaCategory::_formatHeader();
//              
//        if ( $this->params->catId !== '') {
//            $s .= rexMediaCategory::_formatParent( $catList);;
//        }
//              
//        $action = $this->params->action;
//        
//        // Eingabeformular f�r neu anlegen von Kategorien 
//        if ( $action == 'cat_add') {
//            $s .= rexMediaCategory::formatForm();
//        }
//        
//        $catModId = $this->params->catModId;
//        
//        foreach( $catList as $cat) {
//            if ( !rexPoolPerm::hasCatPerm( $cat)) {
//                continue;
//            }
//            
//            if( empty( $_POST) && $cat->getId() == $catModId) {
//                $s .= rexMediaCategory::formatForm( $catModId);
//            } else {
//                $s .= rexMediaCategory::format( $cat);
//            }
//        }
//        
//        $s .= "\n".
//              '       </table>'.
//              "\n";
//        
//        return $s;
//    }
    
    function formatForm() {
        $catId = '';
        $catName = '';
        
        // ggf. defaultwerte f�r Kategorie laden
        if ( isset( $this)) {
            $catId = $this->ooCat->getId();
            $catName = $this->ooCat->getName();
        }
        
        $s = '
              <tr>
                 <td><img src="pics/folder.gif" style="width: 16px; height:16px; margin: auto;"></td>
                 <td><input type="checkbox" name="cat_id[]" value="'. $catId .'"/></td>
                 <td><input type="text" name="catName" value="'. $catName .'" style="width: 100%"/></td>
                 <td colspan="2">'. $this->_formatFormButtons() .'</td>
              </tr>'. "\n";
              
        return $s;
    }
    
    function _formatFormButtons() {
        global $I18N;
        
        $cat =& $this->_getOOCat();
        $s = '';
        
        if ( $cat === null || rexPoolPerm::hasEditPerm( $cat)) {
            $s .= '<input type="submit" name="saveCatButton" value="'. $I18N->msg( 'save_category') .'"/>';
        }
        
        if ( $cat === null || rexPoolPerm::hasDelPerm( $cat)) {
            $s .= '<input type="submit" name="deleteCatButton" value="'. $I18N->msg( 'delete_category') .'"/>';
        } 
        
        return $s;
    }
    
    function &_getOOCat() {
        return $this->ooCat;
    }
}

class rexMediaList extends rexPoolComponentList {
    var $medias;
    /** current OOCat */
    var $cat;
    
    function rexMediaList( &$params, &$ooCat) {
        global $I18N;
        
        if ( $ooCat === null) {
            return;
        }
        
        $columns = array( 
            $I18N->msg('pool_colhead_type') => '50px',
            '<input type="checkbox" onchange="checkBoxes( \'poolForm\', \'media_id[]\', this.checked)"/>' => '30px',
            $I18N->msg('pool_colhead_preview') => '90px',
            $I18N->msg('pool_colhead_filedetails') => '130px',
            $I18N->msg('pool_colhead_description')=> '*'
        );
        
        if ( $params->isEditorMode) {
            $columns[$I18N->msg('pool_colhead_functions')] = '80px';
        }
        
        parent::rexPoolComponentList( $params, $columns);
        
        $ooMedias = $ooCat->getFiles();
        // hier darf kein foreach stehen wegen problemem mit den referenzen!
        for( $i = 0; $i < count( $ooMedias); $i++) {
            $ooMedia =& $ooMedias[ $i];
            $this->medias[] = new rexMedia( $params, $ooMedia); 
        }
        
        $this->cat =& $ooCat;
    }
    
    function format() {
        $s = '';
        
        // Berechtigung pr�fen, ob medien selektiert werden d�rfen        
        if ( !rexPoolPerm::hasGetPerm( $this->cat)) {
            return $s;
        }

        if ( $this->medias === null) {
            return $s;
        }
        
        // Kopf nur anzeigen, wenn auch Medien da sind
        $s .= $this->formatTableHead();
        
        foreach( $this->medias as $rexMedia) {
            $s .= $rexMedia->formatListed();
        }
        
        return $s;
    }
}

/**
 * Media-Class
 * All Methods are static!
 */
class rexMedia extends rexPoolComponent {
    
    var $ooMedia;
    
    function rexMedia( &$params, &$ooMedia) {
        parent::rexPoolComponent( $params);
        $this->ooMedia =& $ooMedia;
    }
    
    function _formatPreview() {
        
        $params = array(
            'resize' => true,
            'width'  => '80px',
            'class'  => 'preview',
            'path'   => '../'
        );
        
        return $this->_link( $this->ooMedia->toImage( $params),
                             'action=media_details&media_id='. $this->ooMedia->getId());
    }
    
    function _formatDetails() {
        global $I18N;
        
        $media =& $this->ooMedia;
        
        $s = '';
        $date = '';
        $dateFormat = $this->_dateFormat();
        
        $updatedate = $media->getUpdateDate( $dateFormat);
        $createdate = $media->getCreateDate( $dateFormat);
        
        if ( $updatedate != $createdate) {
            $date .= $I18N->msg('pool_colhead_updated') .':<br/>' . $updatedate . '<br/>';
        }
        $date .= $I18N->msg('pool_colhead_created') .':<br/>' . $createdate;
        
        $s = $this->_link( $media->getTitle(), 'action=media_details&media_id='. $media->getId())
             .'<br/><br/>'
             .$media->getFileName() .'<br/>'
             .$media->getFormattedSize().'<br/><br/>'
             .$date;
        
        return $s;
    }
    
    function _formatDescription() {
        return nl2br( $this->ooMedia->getDescription());
    }
    
    function _formatActions() {
        return '';
    }
    
    function _formatIcon() {
        return $this->ooMedia->toIcon();
    }
    
    function formatListed() {
        $media =& $this->ooMedia;
        
        $s = '
              <tr>
                 <td>'. $this->_formatIcon() .'</td>
                 <td><input type="checkbox" name="media_id[]" value="'. $media->getId() .'"/></td>
                 <td>'. $this->_formatPreview() .'</td>
                 <td>'. $this->_formatDetails() .'</td>
                 <td>'. $this->_formatDescription() .'</td>';
        if ( $this->params->isEditorMode) {
            $s .=  '<td>'. $this->_formatActions() .'</td>';
        }
                 
        $s .= '</tr>'. "\n";
              
        return $s;
    }
    
    function formatDetailed() {
        global $I18N;
        
        $media =& $this->ooMedia;
        $isImage = $media->isImage();
        $dateFormat = rexPool::_dateFormat();
        $rowspan = 7;
        
        if ( $isImage) {
            // 2 Zeilen zus�tzlich
            $rowspan += 2;
        }
        
        $s = '
              <tr>
                 <th colspan="3">'. $I18N->msg('pool_headline_mediadetails') .'</th>
              </tr>

              <tr>
                 <td>'. $I18N->msg('pool_colhead_title') .'</td>
                 <td>'. $media->getTitle() .'</td>
                 <td style="text-align: center" rowspan="'. $rowspan .'">'. $media->toImage( array( 'path' => '../')) .'</td>
              </tr>

              <tr>
                 <td>'. $I18N->msg('pool_colhead_category') .'</td>
                 <td>'. $media->getCategoryName() .'</td>
              </tr>

              <tr>
                 <td>'. $I18N->msg('pool_colhead_description') .'</td>
                 <td>'. $media->getDescription() .'</td>
              </tr>


              <tr>
                 <td>'. $I18N->msg('pool_colhead_copyright') .'</td>
                 <td>'. $media->getCopyright() .'</td>
              </tr>

              <tr>
                 <td>'. $I18N->msg('pool_colhead_filename') .'</td>
                 <td>'. $media->getFileName() .'</td>
              </tr>'. "\n";
              
          if ( $isImage) {
                $s .= '
              <tr>
                 <td>'. $I18N->msg('pool_colhead_width') .'</td>
                 <td>'. $media->getWidth() .'</td>
              </tr>

              <tr>
                 <td>'. $I18N->msg('pool_colhead_height') .'</td>
                 <td>'. $media->getHeight() .'</td>
              </tr>'. "\n";
          }
              
              $s .='
              <tr>
                 <td>'. $I18N->msg('pool_colhead_updated') .'</td>
                 <td>'. $media->getUpdateDate( $dateFormat) .'</td>
              </tr>

              <tr>
                 <td>'. $I18N->msg('pool_colhead_created') .'</td>
                 <td>'. $media->getCreateDate( $dateFormat) .'</td>
              </tr>
              '. "\n";
              
        return $s;
    }
    
//    function formatList( $mediaList) {
//        if ( !is_array( $mediaList)) {
//            return '';
//        }
//        
//        $cat = null;
//        $catId = rexPoolParam::catId();
//        if ( $catId !== '') { 
//            $cat = OOMediaCategory::getCategoryById( $catId);
//        }
//        
//        $s = "\n".
//             '       <table class="rex" cellpadding="5" cellspacing="1">
//             '. rexMedia::_formatColGroup()
//              . rexMedia::_formatHeader();
//        
//        foreach( $mediaList as $media) {
//            if ( $cat === null || !rexPoolPerm::hasGetPerm( $cat)) {
//                continue;
//            }
//            
//            $s .= rexMedia::formatListed( $media);
//        }
//        
//        $s .= "\n".
//              '       </table>'.
//              "\n";
//        
//        return $s;
//    }
    
    function formatForm( $message = '', $messageLevel = 0) {
        global $I18N;
        
        $catSelect = new rexMediaCatSelect();
        $catSelect->set_style( 'width:100%;');
        $catSelect->set_name( 'mediaCatId');
        
        $titleKey = $this->params->mode == 'archive' ?  'pool_headline_mediaarchiveupload' : 'pool_headline_mediaupload';
        
        $s = '
           <table class="rex" cellpadding="5" cellspacing="1">

              <colgroup>
                 <col width="150px"/>
                 <col width="*"/>
                 <col width="100px"/>
              </colgroup>

              <tr>
                 <th colspan="3">'. $I18N->msg( $titleKey) .'</th>
              </tr>'. "\n";
              
        if ( $message != '') {
            // Fehler
            if ( $messageLevel > 0) {
          $s .= '
              <tr class="warning">
                 <td>'. $I18N->msg( 'pool_error') .'</td>
                 <td colspan="2">
                    '. $message .'
                 </td>
              </tr>'. "\n";
            } else {
            // Statusmeldung
          $s .= '
              <tr class="status">
                 <td>'. $I18N->msg( 'pool_status') .'</td>
                 <td colspan="2">
                    '. $message .'
                 </td>
              </tr>'. "\n";
            }
        }
        
        $s .= '
              <tr>
                 <td>'.$I18N->msg("pool_media_title").'</td>
                 <td colspan="2"><input type="text" name="mediaTitle" class="inp100"/></td>
              </tr>'. "\n";
        $s .= '
              <tr>
                 <td>'.$I18N->msg("pool_media_category").'</td>
                 <td colspan="2">'. $catSelect->out() .'</td>
              </tr>'. "\n";

        $s .= '
              <tr>
                 <td>'.$I18N->msg("pool_media_description").'</td>
                 <td colspan="2"><textarea class="inp100" name="mediaDescription"></textarea></td>
              </tr>'. "\n";

        $s .= '
              <tr>
                 <td>'.$I18N->msg("pool_media_copyright").'</td>
                 <td colspan="2"><input type="text" class="inp100" name="mediaCopyright"/></td>
              </tr>'. "\n";
              
        $s .= '
              <tr>
                 <td>'.$I18N->msg("pool_media_location").'</td>
                 <td><input type="file"  name="mediaFile"/></td>
                 <td><input type="submit" name="uploadMediaButton" value="'.$I18N->msg("pool_upload_button").'" class="inp100"/></td>
              </tr>' ."\n";
           
        $s .= '
           </table>'. "\n";
           
        return $s;
    }
    
    function &_getOOMedia() {
        return $this->ooMedia;
    }
}


/**
 * HTML-Selectbox which shows all categories
 */
class rexMediaCatSelect extends select {
    function rexMediaCatSelect( $cat = null) {
        $selectCats = null;
        if ( is_int( $cat)) {
            $selectCats = array( OOMediaCategory::getCategoryById( $cat));
        } else if ( OOMediaCategory::isValid( $cat)) {
            $selectCats = array( $cat);
        } else {
            $selectCats = OOMediaCategory::getRootCategories();
        }
        
        foreach ( $selectCats as $selectCat) {
            $this->add_cat_option( $selectCat);
        }
    }
    
    function add_cat_option( &$cat, $groupName = '') {
        if( empty( $cat)) {
            return;
        }
        
        $this->add_option($cat->getName(), $cat->getId(), $groupName);
        
        if ( $cat->hasChildren()) {
            $childs = $cat->getChildren();
      
            foreach ( $childs as $child) {
                $this->add_cat_option( $child, $cat->getName());
            }
        }
    }
}

/**
 * Not in use!
 * mediapool-v2-functions
 * @author vscope
 */

function media_resize($FILE,$width,$height,$make_copy=false){
    global $REX;
    
    if ($REX[IMAGEMAGICK])
    {
        $magick = $REX[IMAGEMAGICK_PATH];
        $sizer = '';
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
?>