/**
 * $RCSfile: tiny_mce_src.js,v $
 * $Revision: 1.1 $
 * $Date: 2004/08/19 12:08:51 $
 *
 * @author Moxiecode
 * @copyright Copyright � 2004, Moxiecode Systems AB, All rights reserved.
 */

function TinyMCE() {
	this.instances = new Array();
	this.stickyClassesLookup = new Array();

	this.isMSIE = (navigator.appName == "Microsoft Internet Explorer");
	this.idCounter = 0;

	// * * Functions
	this.init = TinyMCE_init;
	this.addMCEControl = TinyMCE_addMCEControl;
	this.createMCEControl = TinyMCE_createMCEControl;
	this.triggerSave = TinyMCE_triggerSave;
	this.execCommand = TinyMCE_execCommand;
	this.setEditMode = TinyMCE_setEditMode;
	this.handleEvent = TinyMCE_handleEvent;
	this.setupContent = TinyMCE_setupContent;
	this.switchClass = TinyMCE_switchClass;
	this.restoreAndSwitchClass = TinyMCE_restoreAndSwitchClass;
	this.switchClassSticky = TinyMCE_switchClassSticky;
	this.restoreClass = TinyMCE_restoreClass;
	this.setClassLock = TinyMCE_setClassLock;
	this.onLoad = TinyMCE_onLoad;
	this.removeMCEControl = TinyMCE_removeMCEControl;
	this._cleanupHTML = TinyMCE__cleanupHTML;
	this.cleanupNode = TinyMCE_cleanupNode;
	this.convertStringToXML = TinyMCE_convertStringToXML;
	this.insertLink = TinyMCE_insertLink;
	this.insertImage = TinyMCE_insertImage;
	this.getElementByAttributeValue = TinyMCE_getElementByAttributeValue;
	this.getElementsByAttributeValue = TinyMCE_getElementsByAttributeValue;
	this.getParentElement = TinyMCE_getParentElement;
	this.getParam = TinyMCE_getParam;
	this.replaceVar = TinyMCE_replaceVar;
	this.replaceVars = TinyMCE_replaceVars;
	this.triggerNodeChange = TinyMCE_triggerNodeChange;
	this.parseURL = TinyMCE_parseURL;
	this.convertAbsoluteURLToRelativeURL = TinyMCE_convertAbsoluteURLToRelativeURL;
	this.updateContent = TinyMCE_updateContent;
	this.getContent = TinyMCE_getContent;
	this.setContent = TinyMCE_setContent;
	this.importThemeLanguagePack = TinyMCE_importThemeLanguagePack;
	this.applyTemplate = TinyMCE_applyTemplate;
	this.openWindow = TinyMCE_openWindow;
	this.handleVisualAid = TinyMCE_handleVisualAid;
	this.setAttrib = TinyMCE_setAttrib;
	this.getAttrib = TinyMCE_getAttrib;
	this._getThemeFunction = TinyMCE__getThemeFunction;
	this._setHTML = TinyMCE__setHTML;
}

function TinyMCE_init(settings) {
	var theme;

	// * * Check if valid browser
	if (typeof document.execCommand == 'undefined')
		return;

	// * * Get script base path
	if (!tinyMCE.baseURL) {
		var elements = document.getElementsByTagName('script');

		for (var i=0; i<elements.length; i++) {
			if (elements[i].src && (elements[i].src.indexOf("tiny_mce.js") != -1 || elements[i].src.indexOf("tiny_mce_src.js") != -1)) {
				var src = elements[i].src;

				src = src.substring(0, src.lastIndexOf('/'));

				tinyMCE.baseURL = src;
				break;
			}
		}
	}

	// * * Get document base path
	this.documentBasePath = document.location.href;
	if (this.documentBasePath.indexOf('?') != -1)
		this.documentBasePath = this.documentBasePath.substring(0, this.documentBasePath.indexOf('?'));
	this.documentBasePath = this.documentBasePath.substring(0, this.documentBasePath.lastIndexOf('/'));

	// * * If not HTTP absolute
	if (tinyMCE.baseURL.indexOf('://') == -1 && tinyMCE.baseURL.charAt(0) != '/') {
		// * * If site absolute
		tinyMCE.baseURL = this.documentBasePath + "/" + tinyMCE.baseURL;
	}

	this.settings = settings;
	this.settings['mode'] = tinyMCE.getParam("mode", "none");
	this.settings['theme'] = tinyMCE.getParam("theme", "default");
	this.settings['theme_plugins'] = tinyMCE.getParam("theme_plugins", "");
	this.settings['language'] = tinyMCE.getParam("language", "uk");
	this.settings['docs_language'] = tinyMCE.getParam("docs_language", this.settings['language']);
	this.settings['elements'] = tinyMCE.getParam("elements", "");
	this.settings['textarea_trigger'] = tinyMCE.getParam("textarea_trigger", "mce_editable");
	this.settings['valid_elements'] = tinyMCE.getParam("valid_elements", "a[href|target],strong/b[class],em/i[class],strike[class],u[class],p[class|align],ol,ul,li,br,img[class|src|border=0|alt|hspace|vspace|width|height|align],sub,sup,blockquote[dir|style],table[border=0|cellspacing|cellpadding|width|height|class|align],tr[rowspan],td[colspan|rowspan|width|height],div[class|align],span[class|align]");
	this.settings['extended_valid_elements'] =  tinyMCE.getParam("extended_valid_elements", "");
	this.settings['invalid_elements'] = tinyMCE.getParam("invalid_elements", "");
	this.settings['encoding'] = tinyMCE.getParam("encoding", "");
	this.settings['urlconvertor_callback'] = tinyMCE.getParam("urlconvertor_callback", "TinyMCE_convertURL");
	this.settings['save_callback'] = tinyMCE.getParam("save_callback", "");
	this.settings['debug'] = tinyMCE.getParam("debug", false);
	this.settings['force_br_newlines'] = tinyMCE.getParam("force_br_newlines", false);
	this.settings['add_form_submit_trigger'] = tinyMCE.getParam("add_form_submit_trigger", true);
	this.settings['relative_urls'] = tinyMCE.getParam("relative_urls", true);
	this.settings['remove_script_host'] = tinyMCE.getParam("remove_script_host", true);
	this.settings['focus_alert'] = tinyMCE.getParam("focus_alert", true);
	this.settings['document_base_url'] = tinyMCE.getParam("document_base_url", "" + document.location.href);
	this.settings['visual'] = tinyMCE.getParam("visual", true);
	this.settings['visual_table_style'] = tinyMCE.getParam("visual_table_style", "border: 1px dashed #BBBBBB");
	this.settings['setupcontent_callback'] = tinyMCE.getParam("setupcontent_callback", "");
	this.settings['fix_content_duplication'] = tinyMCE.getParam("fix_content_duplication", true);
	this.settings['custom_undo_redo'] = tinyMCE.getParam("custom_undo_redo", true);
	this.settings['custom_undo_redo_levels'] = tinyMCE.getParam("custom_undo_redo_levels", -1);

	// Setup baseHREF
	var baseHREF = tinyMCE.settings['document_base_url'];
	if (baseHREF.indexOf('?') != -1)
		baseHREF = baseHREF.substring(0, baseHREF.indexOf('?'));
	this.settings['base_href'] = baseHREF.substring(0, baseHREF.lastIndexOf('/')) + "/";

	theme = this.settings['theme'];

	if (!tinyMCE.isMSIE)
		this.settings['force_br_newlines'] = false;

	if (tinyMCE.getParam("content_css", false)) {
		var cssPath = tinyMCE.getParam("content_css", "");

		// Is relative
		if (cssPath.indexOf('://') == -1 && cssPath.charAt(0) != '/')
			this.settings['content_css'] = this.documentBasePath + "/" + cssPath;
		else
			this.settings['content_css'] = cssPath;
	} else
		this.settings['content_css'] = tinyMCE.baseURL + "/themes/" + theme + "/editor_content.css";

	if (tinyMCE.getParam("popups_css", false)) {
		var cssPath = tinyMCE.getParam("popups_css", "");

		// Is relative
		if (cssPath.indexOf('://') == -1 && cssPath.charAt(0) != '/')
			this.settings['popups_css'] = this.documentBasePath + "/" + cssPath;
		else
			this.settings['popups_css'] = cssPath;
	} else
		this.settings['popups_css'] = tinyMCE.baseURL + "/themes/" + theme + "/editor_popup.css";

	if (tinyMCE.getParam("editor_css", false)) {
		var cssPath = tinyMCE.getParam("editor_css", "");

		// Is relative
		if (cssPath.indexOf('://') == -1 && cssPath.charAt(0) != '/')
			this.settings['editor_css'] = this.documentBasePath + "/" + cssPath;
		else
			this.settings['editor_css'] = cssPath;
	} else
		this.settings['editor_css'] = tinyMCE.baseURL + "/themes/" + theme + "/editor_ui.css";

	this.settings['ask'] = tinyMCE.getParam("ask", false);

	if (tinyMCE.settings['debug']) {
		var msg = "Debug: \n";

		msg += "baseURL: " + this.baseURL + "\n";
		msg += "documentBasePath: " + this.documentBasePath + "\n";
		msg += "content_css: " + this.settings['content_css'] + "\n";
		msg += "popups_css: " + this.settings['popups_css'] + "\n";
		msg += "editor_css: " + this.settings['editor_css'] + "\n";

		alert(msg);
	}

	if (this.isMSIE)
		attachEvent("onload", TinyMCE_onLoad);
	else
		addEventListener("load", TinyMCE_onLoad, false);

	document.write('<sc'+'ript language="javascript" type="text/javascript" src="' + tinyMCE.baseURL + '/themes/' + this.settings['theme'] + '/editor_template.js"></script>');
	document.write('<sc'+'ript language="javascript" type="text/javascript" src="' + tinyMCE.baseURL + '/langs/' + this.settings['language'] +  '.js"></script>');
	document.write('<link href="' + this.settings['editor_css'] + '" rel="stylesheet" type="text/css">');

	// Add theme plugins
	var themePlugins = this.settings['theme_plugins'].split(',');
	if (this.settings['theme_plugins'] != '') {
		for (var i=0; i<themePlugins.length; i++)
			document.write('<sc'+'ript language="javascript" type="text/javascript" src="' + tinyMCE.baseURL + '/themes/' + themePlugins[i] + '/editor_plugin.js"></script>');
	}
}

function TinyMCE_confirmAdd(e) {
	if (tinyMCE.isMSIE)
		var targetElement = event.srcElement;
	else
		var targetElement = e.target;

	var elementId = targetElement .name ? targetElement .name : targetElement.id;

	if (!targetElement.getAttribute('mce_noask') && confirm(tinyMCELang['lang_edit_confirm']))
		tinyMCE.addMCEControl(targetElement, elementId, tinyMCE.createMCEControl(tinyMCE.settings));
	else
		targetElement.setAttribute('mce_noask', 'true');
}

function TinyMCE_updateContent(form_element_name) {
	// find MCE instance linked to given form element and copy it's value
	var formElement = document.getElementById(form_element_name);
	for (var instanceName in tinyMCE.instances) {
		var instance = tinyMCE.instances[instanceName];
		if (instance.formElement == formElement) {
			tinyMCE._setHTML(instance.contentWindow.document, instance.formElement.value);

			if (!tinyMCE.isMSIE)
				instance.contentWindow.document.body.innerHTML = tinyMCE._cleanupHTML(instance.contentWindow.document, this.settings, instance.contentWindow.document.body);
		}
	}
}

function TinyMCE_addMCEControl(replace_element, form_element_name, mce_control) {
	var editorId = "mce_editor_" + tinyMCE.idCounter++;
	mce_control.editorId = editorId;
	this.instances[editorId] = mce_control;
	mce_control.onAdd(replace_element, form_element_name);
}

function TinyMCE_createMCEControl(settings) {
	return new TinyMCEControl(settings);
}

function TinyMCE_triggerSave() {
	// * * Cleanup and set all form fields
	for (var instanceName in tinyMCE.instances) {
		var instance = tinyMCE.instances[instanceName];
		tinyMCE.settings['preformatted'] = false;
		var cleanedHTML = tinyMCE._cleanupHTML(instance.contentWindow.document, tinyMCE.settings, instance.contentWindow.document.body, false, true);

		if (tinyMCE.settings["encoding"] == "xml" || tinyMCE.settings["encoding"] == "html")
			cleanedHTML = tinyMCE.convertStringToXML(cleanedHTML);

		if (tinyMCE.settings['save_callback'] != "")
			var content = eval(tinyMCE.settings['save_callback'] + "(instance.formTargetElementId,cleanedHTML,instance.contentWindow.document.body);");

		// Use callback content if available
		if ((typeof content != "undefined") && content != null)
			cleanedHTML = content;

		instance.formElement.value = cleanedHTML;
	}
}

function TinyMCE_execCommand(command, user_interface, value) {
	// Command within editor instance?
	if (this.selectedInstance && tinyMCE.isMSIE) {
		var node = this.selectedInstance.getFocusElement();
		while (node = node.parentNode) {
			if (node.nodeName == "#document" && (node.location.href.indexOf('blank.htm') == -1)) {
				this.selectedInstance = null;
				break;
			}
		}
	}

	// Default input
	user_interface = user_interface ? user_interface : false;
	value = value ? value : null;

	switch (command) {
		case 'mceHelp':
			window.open(tinyMCE.themeURL + "/docs/" + this.settings['docs_language'] + "/index.htm", "mceHelp", "menubar=yes,toolbar=yes,scrollbars=yes,left=20,top=20,width=550,height=600");
		return;

		case 'mceFocus':
			tinyMCE.instances[value].contentWindow.focus();
		return;
	}

	if (this.selectedInstance)
		this.selectedInstance.execCommand(command, user_interface, value);
	else if (tinyMCE.settings['focus_alert'])
		alert(tinyMCELang['lang_focus_alert']);
}

function TinyMCE_addEventHandlers(editor_id) {
	var instance = tinyMCE.instances[editor_id];
	instance.contentWindow.document.editor_id = editor_id;
	instance.contentWindow.document.addEventListener("keypress", tinyMCE.handleEvent, false);
	instance.contentWindow.document.addEventListener("keydown", tinyMCE.handleEvent, false);
	instance.contentWindow.document.addEventListener("keyup", tinyMCE.handleEvent, false);
	instance.contentWindow.document.addEventListener("click", tinyMCE.handleEvent, false);
	instance.contentWindow.document.addEventListener("focus", tinyMCE.handleEvent, false);
	instance.contentWindow.document.designMode = "on";
}

function TinyMCE_setEditMode(editor_id, mode) {
	var targetMCEControl = this.instances[editor_id];

	if (!this.isMSIE) {
		var targetElement = document.getElementById(editor_id);

		targetMCEControl.targetElement = targetElement;
		targetMCEControl.contentDocument = targetElement.contentDocument;
		targetMCEControl.contentWindow = targetElement.contentWindow;

		targetMCEControl.contentWindow.document.designMode = mode ? "on" : "off";
	} else {
		var targetElement = document.frames[editor_id];

		targetMCEControl.targetElement = targetElement;
		targetMCEControl.contentDocument = targetElement.window.document;
		targetMCEControl.contentWindow = targetElement.window;

		targetMCEControl.contentDocument.designMode = mode ? "on" : "off";
	}

	if (!tinyMCE.isMSIE) {
		// Fixed some strange Mozilla focus bug
		window.setTimeout('TinyMCE_addEventHandlers("' + editor_id + '");', 300);
	} else {
		document.frames[editor_id].document.ondeactive = tinyMCE.handleEvent;

		var patchFunc = function() {
			var event = document.frames[editor_id].event;

			event.target = event.srcElement;
			event.target.editor_id = editor_id;

			TinyMCE_handleEvent(event);
		};

		// * * Event patch
		document.frames[editor_id].document.onkeypress = patchFunc;
		document.frames[editor_id].document.onkeyup = patchFunc;
		document.frames[editor_id].document.onkeydown = patchFunc;

		// Due to stange focus bug in MSIE this line is disabled for now
		//document.frames[editor_id].document.onmousedown = patchFunc;
		document.frames[editor_id].document.onmouseup = patchFunc;
		document.frames[editor_id].document.onclick = patchFunc;
	}

	window.setTimeout("tinyMCE.setupContent('" + editor_id + "');", 300);
}

function TinyMCE_setupContent(editor_id) {
	var instance = tinyMCE.instances[editor_id];
	var doc = instance.contentWindow.document;
	var head = doc.getElementsByTagName('head').item(0);

	if (!head) {
		window.setTimeout("tinyMCE.setupContent('" + editor_id + "');", 300);
		return;
	}

	// Setup base element
	base = doc.createElement("base");
	base.setAttribute('href', tinyMCE.settings['base_href']);
	head.appendChild(base);

	var oldElement = instance.oldTargetElement;
	if (oldElement.nodeName.toLowerCase() == "textarea")
		var content = oldElement.value;
	else
		var content = instance.oldTargetElement.innerHTML;

	if (tinyMCE.isMSIE) {
		document.frames[editor_id].document.createStyleSheet(instance.settings['content_css']);
		if (tinyMCE.settings["force_br_newlines"])
			document.frames[editor_id].document.styleSheets[0].addRule("p", "margin: 0px;");

		var patchFunc = function() {
			var event = document.frames[editor_id].event;

			event.target = document.frames[editor_id].document;

			TinyMCE_handleEvent(event);
		};

		document.frames[editor_id].document.body.onblur = patchFunc;
		document.frames[editor_id].document.body.onbeforepaste = patchFunc;
		document.frames[editor_id].document.body.onbeforecut = patchFunc;

		document.frames[editor_id].document.body.editorId = editor_id;
	} else {
		var targetDocument = document.getElementById(editor_id).contentWindow.document;

		// * * Import editor css
		var cssImporter = targetDocument.createElement("link");
		cssImporter.rel = "stylesheet";
		cssImporter.href = instance.settings['content_css'];
		if (headArr = targetDocument.getElementsByTagName("head"));
		headArr[0].appendChild(cssImporter);
	}

	// Fix for bug #958637
	if (!tinyMCE.isMSIE) {
		var contentElement = instance.contentWindow.document.createElement("body");
		contentElement.innerHTML = content;
		instance.contentWindow.document.body.innerHTML = tinyMCE._cleanupHTML(instance.contentWindow.document, this.settings, contentElement);
	} else {
		tinyMCE._setHTML(instance.contentWindow.document, content);
		//instance.contentWindow.document.body.innerHTML = tinyMCE.cleanupHTML(this.settings, instance.contentWindow.document.body);
	}

	// Fix for bug #957681
	instance.contentWindow.document.designMode = instance.contentWindow.document.designMode;

	// Setup element references
	var parentElm = document.getElementById(instance.editorId + '_parent');
	instance.formElement = parentElm.getElementsByTagName("input").item(0);

	if (tinyMCE.settings['handleNodeChangeCallback']) {
		var undoIndex = -1;
		var undoLevels = -1;

		if (tinyMCE.settings['custom_undo_redo']) {
			undoIndex = 0;
			undoLevels = 0;
		}

		eval(tinyMCE.settings['handleNodeChangeCallback'] + '("' + editor_id + '", tinyMCE.instances["' + editor_id + '"].contentWindow.document.body,undoIndex,undoLevels);');
		//window.setTimeout(tinyMCE.settings['handleNodeChangeCallback'] + '("' + editor_id + '", tinyMCE.instances["' + editor_id + '"].contentWindow.document.body,undoIndex,undoLevels);', 10);
	}

	tinyMCE.handleVisualAid(instance.contentWindow.document.body, true);

	// Trigger setup content
	if (tinyMCE.settings['setupcontent_callback'] != "")
		eval(tinyMCE.settings['setupcontent_callback'] + '(editor_id,instance.contentWindow.document.body);');
}

function TinyMCE_handleEvent(e) {
	//window.status = e.type + " " + e.target.nodeName + " " + (e.relatedTarget ? e.relatedTarget.nodeName : "");

	switch (e.type) {
		case "beforecut":
		case "beforepaste":
			tinyMCE.selectedInstance.execCommand("mceAddUndoLevel");
			break;

		case "keypress":
			// Mozilla custom key handling
			if (!tinyMCE.isMSIE && e.ctrlKey) {
				if (e.charCode == 120 || e.charCode == 118) { // Ctrl+X, Ctrl+V
					tinyMCE.selectedInstance.execCommand("mceAddUndoLevel");
					return;
				}

				if (e.charCode == 122) { // Ctrl+Z
					tinyMCE.selectedInstance.execCommand("Undo");

					// Cancel event
					e.preventDefault();
					return false;
				}

				if (e.charCode == 121) { // Ctrl+Y
					tinyMCE.selectedInstance.execCommand("Redo");

					// Cancel event
					e.preventDefault();
					return false;
				}
			}

			// Check if it's a position key press
			var keys = new Array(9,45,36,35,33,34,37,38,39,40);
			var posKey = false;
			for (var i=0; i<keys.length; i++) {
				if (keys[i] == e.keyCode) {
					tinyMCE.selectedInstance.typing = false;
					posKey = true;
					break;
				}
			}

			// Add typing undo level
			if (!tinyMCE.selectedInstance.typing && !posKey) {
				tinyMCE.selectedInstance.execCommand("mceAddUndoLevel");
				tinyMCE.selectedInstance.typing = true;
			}

			//window.status = e.keyCode;
			//window.status = e.type + " " + e.target.nodeName;

			// Return key pressed
			if (tinyMCE.isMSIE && tinyMCE.settings['force_br_newlines'] && e.keyCode == 13) {
				if (e.target.editorId)
					tinyMCE.selectedInstance = tinyMCE.instances[e.target.editorId];

				if (tinyMCE.selectedInstance) {
					var sel = tinyMCE.selectedInstance.contentWindow.document.selection;
					var rng = sel.createRange();

					if (tinyMCE.getParentElement(rng.parentElement(), "li") != null)
						return false;

					if (tinyMCE.getParentElement(rng.parentElement(), "div") == null)
						return false;

					// Cancel event
					e.returnValue = false;
					e.cancelBubble = true;

					// Insert BR element
					rng.pasteHTML("<br>");
					rng.collapse(false);
					rng.select();
				}
			}

			return false;
		break;

		case "keyup":
		case "keydown":
			if (e.target.editorId)
				tinyMCE.selectedInstance = tinyMCE.instances[e.target.editorId];

			var elm = tinyMCE.selectedInstance.getFocusElement();
			tinyMCE.linkElement = tinyMCE.getParentElement(elm, "a");
			tinyMCE.imgElement = tinyMCE.getParentElement(elm, "img");
			tinyMCE.selectedElement = elm;

			tinyMCE.triggerNodeChange();

			// MSIE custom key handling
			if (tinyMCE.isMSIE && e.ctrlKey) {
				var keys = new Array(66,73,85,86,88); // B/I/U/V/X
				for (var i=0; i<keys.length; i++) {
					if (keys[i] == e.keyCode) {
						tinyMCE.selectedInstance.execCommand("mceAddUndoLevel");
						return;
					}
				}

				if (e.keyCode == 90) { // Ctrl+Z
					tinyMCE.selectedInstance.execCommand("Undo");

					// Cancel event
					e.returnValue = false;
					e.cancelBubble = true;
					return false;
				}

				if (e.keyCode == 89) { // Ctrl+Y
					tinyMCE.selectedInstance.execCommand("Redo");

					// Cancel event
					e.returnValue = false;
					e.cancelBubble = true;
					return false;
				}
			}
		break;

		case "mousedown":
		case "mouseup":
		case "click":
		case "focus":
			if (e.target.nodeName.toLowerCase() == "img")
				tinyMCE.selectedElement = e.target;
			else if (tinyMCE.selectedInstance)
				tinyMCE.selectedElement = tinyMCE.selectedInstance.getFocusElement();

			tinyMCE.linkElement = tinyMCE.getParentElement(tinyMCE.selectedElement, "a");
			tinyMCE.imgElement = tinyMCE.getParentElement(tinyMCE.selectedElement, "img");

			if (e.target.editor_id)
				tinyMCE.selectedInstance = tinyMCE.instances[e.target.editor_id];

			// Reset typing
			tinyMCE.selectedInstance.typing = false;
			tinyMCE.triggerNodeChange();
		break;
	}
}

function TinyMCE_switchClass(element, class_name, lock_state) {
	var lockChanged = false;

	if (typeof lock_state != "undefined" && element != null) {
		element.classLock = lock_state;
		lockChanged = true;
	}

	if (element != null && (lockChanged || !element.classLock)) {
		element.oldClassName = element.className;
		element.className = class_name;
	}
}

function TinyMCE_restoreAndSwitchClass(element, class_name) {
	if (element != null && !element.classLock) {
		this.restoreClass(element);
		this.switchClass(element, class_name);
	}
}

function TinyMCE_switchClassSticky(element_name, class_name, lock_state) {
	var element, lockChanged = false;

	// Performance issue
	if (!this.stickyClassesLookup[element_name])
		this.stickyClassesLookup[element_name] = document.getElementById(element_name);

//	element = document.getElementById(element_name);
	element = this.stickyClassesLookup[element_name];

	if (typeof lock_state != "undefined" && element != null) {
		element.classLock = lock_state;
		lockChanged = true;
	}

	if (element != null && (lockChanged || !element.classLock)) {
		element.className = class_name;
		element.oldClassName = class_name;
	}
}

function TinyMCE_restoreClass(element) {
	if (element != null && element.oldClassName && !element.classLock) {
		element.className = element.oldClassName;
		element.oldClassName = null;
	}
}

function TinyMCE_setClassLock(element, lock_state) {
	if (element != null)
		element.classLock = lock_state;
}

function TinyMCE_onLoad() {
	if (tinyMCE.isMSIE) {
		if (document.forms && tinyMCE.settings['add_form_submit_trigger']) {
			for (var i=0; i<document.forms.length; i++)
				document.forms[i].attachEvent("onsubmit", TinyMCE_triggerSave);
		}
	} else {
		if (document.forms && tinyMCE.settings['add_form_submit_trigger']) {
			for (var i=0; i<document.forms.length; i++)
				document.forms[i].addEventListener("submit", TinyMCE_triggerSave, false);
		}
	}

	switch (tinyMCE.settings['mode']) {
		case "exact":
			var elements = tinyMCE.settings['elements'].split(',');

			for (var i=0; i<elements.length; i++) {
				var element = document.getElementById(elements[i]);
				if (!element) {
					// Check for element in forms
					for (var j=0;j<document.forms.length; j++) {
						for (var k = 0; k < document.forms[j].elements.length; k++) {
							if (document.forms[j].elements[k].name == elements[i]) {
								element = document.forms[j].elements[k];
								break;
							}
						}
					}
				}

				if (element)
					tinyMCE.addMCEControl(element, elements[i], tinyMCE.createMCEControl(tinyMCE.settings));
				else
					//alert("Error: Could not find element by id or name: " + elements[i]);
					var alert = 0;

			}
		break;

		case "specific_textareas":
		case "textareas":
			var nodeList = document.getElementsByTagName("textarea");
			var elementRefAr = new Array();

			for (var i=0; i<nodeList.length; i++) {
				if (tinyMCE.settings['mode'] != "specific_textareas" || nodeList.item(i).getAttribute(tinyMCE.settings['textarea_trigger']) == "true")
					elementRefAr[elementRefAr.length] = nodeList.item(i);
			}

			for (var i=0; i<elementRefAr.length; i++) {
				var element = elementRefAr[i];
				var elementId = element.name ? element.name : element.id;

				if (tinyMCE.settings['ask']) {
					if (tinyMCE.isMSIE)
						element.attachEvent("onmousedown", TinyMCE_confirmAdd);
					else
						element.addEventListener("mousedown", TinyMCE_confirmAdd, false);
				} else
					tinyMCE.addMCEControl(element, elementId, tinyMCE.createMCEControl(tinyMCE.settings));
			}
		break;
	}
}

function TinyMCE_removeMCEControl(editor_id) {
	var mceControl = this.instances[editor_id];
	this.instances.splice(editor_id);

	tinyMCE.selectedElement = null;
	tinyMCE.selectedInstance = null;

	// Remove element
	var replaceElement = document.getElementById(editor_id + "_parent");
	replaceElement.parentNode.insertBefore(mceControl.oldTargetElement, replaceElement);
	replaceElement.parentNode.removeChild(replaceElement);
}

function TinyMCE_cleanupNode(config, node) {
	var output = "";
	var validElements = config["valid_elements"];
	var isMSIE = config["is_msie"];
	var visual = config["visual"];
	var urlConvertorCallbackStr = config['urlconvertor_callback'];
	var mouseOverMode = config['mouse_over'];
	var onSave = config['on_save'];
	var doc = config['document'];

	// * * If node is an Element
	if (node.nodeType == 1) {
		var elementAttribs = null;
		elementName = node.nodeName.toLowerCase();

		// * * Check if invalid element
		for (var i=0; i<config["invalid_elements"].length; i++) {
			if (elementName == config["invalid_elements"][i]) {
				if (node.hasChildNodes()) {
					for (var i=0; i<node.childNodes.length; i++)
						output += this.cleanupNode(config, node.childNodes[i]);
				}

				return output;
			}
		}

		// * * Check if valid element
		for (var i=0; i<validElements.length && !elementAttribs; i++) {
			for (var x=0; x<validElements[i][0].length; x++) {
				if (validElements[i][0][x] == elementName) {
					elementAttribs = validElements[i];
					break;
				}
			}
		}

		if (config["force_br_newlines"] && elementName == "p") {
			if ((align = node.getAttribute('align')) != "")
				output += "<div align=" + align + ">";

			elementAttribs = null;
		}

		if (elementAttribs != null) {
			var elementName = elementAttribs[0][0];

			// * * Remove some span elements
			if (elementName == "span" && node.hasChildNodes()) {
				var nonDefinedCSS = false;

				// Remove span with non existent classes
				if (onSave) {
					var csses = isMSIE ? doc.styleSheets(0).rules : doc.styleSheets[0].cssRules;
					nonDefinedCSS = true;

					for (var c=0; c<csses.length; c++) {
						var className = csses[c].selectorText;
						var nodeClassName = isMSIE ? node.className : node.getAttribute("class");
						if (className.charAt(0) == '.' && className.substring(1) == node.className) {
							nonDefinedCSS = false;
							break;
						}
					}
				}

				var re = new RegExp('^[ \t]+', 'g');
				var onlyWhiteSpace = true;
				for (var a=0; a<node.childNodes.length; a++) {
					var tmpNode = node.childNodes[a];
					if ((tmpNode.nodeType == 3 && !tmpNode.nodeValue.match(re)) || tmpNode.nodeName.toLowerCase() != "span") {
						onlyWhiteSpace = false;
						break;
					}
				}

				// Remove span if only whitespace or classnames are the same
				if (onlyWhiteSpace || node.parentNode.className == node.className || nonDefinedCSS) {
					if (node.hasChildNodes()) {
						for (var i=0; i<node.childNodes.length; i++)
							output += this.cleanupNode(config, node.childNodes[i]);
					}

					return output;
				}
			}

			// Special Mozilla stuff
			if (!isMSIE) {
				// Fix for bug #958498
				if (elementName == "strong" && !onSave)
					elementName = "b";
				else if (elementName == "em" && !onSave)
					elementName = "i";
			}

			output += "<" + elementName;

			// * * Handle attributes
			for (var i=1; i<elementAttribs.length; i++) {
				var attribName = elementAttribs[i][0];
				var attribDefaultValue = elementAttribs[i][1];
				var attribForceValue = elementAttribs[i][2];
				var attribValue = attribForceValue ? attribForceValue : node.getAttribute(attribName);
				// * * Handle URL convertor callback
				if (urlConvertorCallbackStr && attribValue && attribValue != "" && (attribName == "src" || attribName == "href" || attribName == "mceOverSrc"))
					attribValue = eval(urlConvertorCallbackStr + "(attribValue, node, onSave);");

				// * * Special MSIE stuff
				if (isMSIE && !attribForceValue) {
					switch (attribName) {
						case "class":
							attribValue = node.getAttribute('className');
						break;

						case "style":
							attribValue = node.style.cssText.toLowerCase();
						break;

						case "colspan":
						case "rowspan":
							if ("" + attribValue == "1")
								attribValue = null;
						break;
					}

					switch (elementName) {
						case "table":
							// Produced a weird bug, hope "-" fixes it
							if (attribName == "width")
								attribValue = node.style.pixelWidth == 0 ? node.getAttribute("width") : node.style.pixelWidth;

							if (attribName == "height")
								attribValue = node.style.pixelHeight == 0 ? node.getAttribute("height") : node.style.pixelHeight;
						break;
					}
				}

				// * * Fix TD alignments
				if (elementName == "td" && attribName == "align") {
					// * * Search for children P and their alignments
					if (!attribValue && node.hasChildNodes) {
						for (var x=0; x<node.childNodes.length; x++) {
							if (node.childNodes[x].nodeName.toLowerCase() == "p") {
								attribValue = node.childNodes[x].getAttribute('align');
								break;
							}
						}
					}
				}

				// * * Handle mouseover
				if (mouseOverMode && elementName == "img" && attribName == "mceoversrc") {
					output += ' onmouseover="mce_swapImage(this,\'' + attribValue + '\');"';
					output += ' onmouseout="mce_restoreImage(this);"';
					output += ' mceOverSrc="' + attribValue + '"';
				}

				if (!attribValue && attribDefaultValue)
					attribValue = attribDefaultValue;

				if (attribValue && attribValue != "")
					output += " " + attribName + '="' + this.convertStringToXML("" + attribValue) + '"';
			}

			// * * Handle visual aid
			if (visual && (elementName == "table" || elementName == "td")) {
				// * * Find parent table
				var tableElement = node;
				if (elementName == "td")
					tableElement = tinyMCE.getParentElement(tableElement, "table");

				if (tableElement && tableElement.getAttribute("border") == 0)
					output += ' style="' + tinyMCE.settings['visual_table_style'] + '"';
			}

			// Add nbsp to table
			if (elementName == "td" && node.innerHTML == "&nbsp;") {
				output += ">&nbsp;</td>";

				return output;
			}

			if (node.hasChildNodes()) {
				output += ">";

				for (var i=0; i<node.childNodes.length; i++)
					output += this.cleanupNode(config, node.childNodes[i]);

				output += "</" + elementName + ">";
			} else {
				if (elementName == "p" || elementName == "td")
					output += ">&nbsp;</" + elementName + ">";
				else
					output += " />";
			}
		} else {
			if (node.hasChildNodes()) {
				for (var i=0; i<node.childNodes.length; i++)
					output += this.cleanupNode(config, node.childNodes[i]);
			}
		}
	} else if (node.nodeType == 3) // Text node
		output += this.convertStringToXML(node.nodeValue);

	// Add end align span
	if (config["force_br_newlines"] && elementName == "p") {
		if ((align = node.getAttribute('align')) != "")
			output += "</div>";

		output += "<br />";
	}

	return output;
}

function TinyMCE_convertStringToXML(html_data) {
	var output = "";

	if (!html_data)
		return null;

	for (var i=0; i<html_data.length; i++) {
		var chr = html_data.charAt(i);

		// * * Check and convert to XML format
		switch (chr) {
			case ''+String.fromCharCode(8482):
				output += "&#x2122;";
			break;

			case ''+String.fromCharCode(8211):
				output += "-";
			break;

			case '\u0093':
			case '\u0094':
			case ''+String.fromCharCode(8220):
			case ''+String.fromCharCode(8221):
			case '"':
				output += "&quot;";
			break;

			case ''+String.fromCharCode(8217):
			case ''+String.fromCharCode(180):
			case '\'':
				output += "&#39;";
			break;

			case '<':
				output += "&lt;";
			break;

			case '>':
				output += "&gt;";
			break;

			case '&':
				output += "&amp;";
			break;

			case ''+String.fromCharCode(8230):
				output += "...";
			break;

			case '\\':
				output += "&#92;";
			break;

			default:
				output += chr;
		}
	}

	return output;
}

function TinyMCE__cleanupHTML(doc, config, element, visual, on_save) {
	function getElementName(chunk) {
		var pos;

		if ((pos = chunk.indexOf('/')) != -1)
			chunk = chunk.substring(0, pos);

		if ((pos = chunk.indexOf('[')) != -1)
			chunk = chunk.substring(0, pos);

		return chunk;
	}

	if (visual == null)
		visual = config["visual"] ? config["visual"] : false;

	// Parse valid elements and attributes
	var validElements = config["valid_elements"] ? config["valid_elements"] : "b,i,ul,li,br,p";
	validElements = validElements.split(',');

	// Handle extended valid elements
	var extendedValidElements = config["extended_valid_elements"] ? config["extended_valid_elements"] : "";
	extendedValidElements = extendedValidElements.split(',');
	for (var i=0; i<extendedValidElements.length; i++) {
		var elementName = getElementName(extendedValidElements[i]);
		var skipAdd = false;

		// Check if it's defined before, if so override that one
		for (var x=0; x<validElements.length; x++) {
			if (getElementName(validElements[x]) == elementName) {
				validElements[x] = extendedValidElements[i];
				skipAdd = true;
				break;
			}
		}

		if (!skipAdd)
			validElements[validElements.length] = extendedValidElements[i];
	}

	for (var i=0; i<validElements.length; i++) {
		var item = validElements[i];
		item = item.replace('[','|');
		item = item.replace(']','');

		// * * Split and convert
		var attribs = item.split('|');
		for (var x=0; x<attribs.length; x++)
			attribs[x] = attribs[x].toLowerCase();

		// * * Handle change elements
		attribs[0] = attribs[0].split('/');

		// * * Handle default attribute values
		for (var x=1; x<attribs.length; x++) {
			var attribName = attribs[x];
			var attribDefault = null;
			var attribForce = null;

			if ((pos = attribName.indexOf('=')) != -1) {
				attribDefault = attribName.substring(pos+1);
				attribName = attribName.substring(0, pos);
			}

			// * * Force check
			if ((pos = attribName.indexOf(':')) != -1) {
				attribForce = attribName.substring(pos+1);
				attribName = attribName.substring(0, pos);
			}

			attribs[x] = new Array(attribName, attribDefault, attribForce);
		}

		validElements[i] = attribs;
	}

	var invalidElements = config['invalid_elements'].split(',');
	for (var i=0; i<invalidElements.length; i++)
		invalidElements[i] = invalidElements[i].toLowerCase();

	var html = this.cleanupNode({
		"valid_elements" : validElements,
		"invalid_elements" : invalidElements,
		"is_msie" : (navigator.appName == "Microsoft Internet Explorer"),
		"visual" : visual,
		"force_br_newlines" : config["force_br_newlines"],
		"urlconvertor_callback" : config["urlconvertor_callback"],
		"on_save" : on_save,
		"document" : doc,
		"mouse_over" : (config["mouse_over"] ? config["mouse_over"] : false)
		}, element);

	// Emtpy node, return empty
	if (html == "<br />" || html == "<p>&nbsp;</p>")
		html = "";

	if (config["preformatted"])
		return "<pre>" + html + "</pre>";

	return html;
}

function TinyMCE_insertLink(href, target) {
	if (this.selectedInstance && this.selectedElement && this.selectedElement.nodeName.toLowerCase() == "img") {
		var doc = this.selectedInstance.contentWindow.document;

		var linkElement = doc.createElement("a");

		href = eval(tinyMCE.settings['urlconvertor_callback'] + "(href, linkElement);");
		linkElement.setAttribute('href', href);
		linkElement.setAttribute('target', target);
		linkElement.appendChild(this.selectedElement.cloneNode(true));

		this.selectedElement.parentNode.replaceChild(linkElement, this.selectedElement);

		return;
	}

	if (!this.linkElement && this.selectedInstance) {
		this.selectedInstance.contentDocument.execCommand("createlink", false, "#mce_temp_url#");
		tinyMCE.linkElement = this.getElementByAttributeValue(this.selectedInstance.contentDocument.body, "a", "href", "#mce_temp_url#");

		var elementArray = this.getElementsByAttributeValue(this.selectedInstance.contentDocument.body, "a", "href", "#mce_temp_url#");

		for (var i=0; i<elementArray.length; i++) {
			href = eval(tinyMCE.settings['urlconvertor_callback'] + "(href, elementArray[i]);");
			elementArray[i].setAttribute('href', href);
			elementArray[i].setAttribute('target', target);
		}

		tinyMCE.linkElement = elementArray[0];
	}

	if (this.linkElement) {
		href = eval(tinyMCE.settings['urlconvertor_callback'] + "(href, this.linkElement);");
		this.linkElement.setAttribute('href', href);
		this.linkElement.setAttribute('target', target);
	}
}

function TinyMCE_insertImage(src, alt, border, hspace, vspace, width, height, align) {
	function setAttrib(element, name, value, no_fix_value) {
		if (!no_fix_value && value != null) {
			var re = new RegExp('[^0-9%]', 'g');
			value = value.replace(re, '');
		}

		if (value != null && value != "")
			element.setAttribute(name, value);
		else
			element.removeAttribute(name);
	}

	if (!this.imgElement && this.selectedInstance) {
		this.selectedInstance.contentDocument.execCommand("insertimage", false, "#mce_temp_url#");
		tinyMCE.imgElement = this.getElementByAttributeValue(this.selectedInstance.contentDocument.body, "img", "src", "#mce_temp_url#");
	}

	if (this.imgElement) {
		src = eval(tinyMCE.settings['urlconvertor_callback'] + "(src, tinyMCE.imgElement);");

		tinyMCE.setAttrib(this.imgElement, 'src', src, true);
		tinyMCE.setAttrib(this.imgElement, 'alt', alt, true);
		tinyMCE.setAttrib(this.imgElement, 'align', align, true);
		tinyMCE.setAttrib(this.imgElement, 'border', border);
		tinyMCE.setAttrib(this.imgElement, 'hspace', hspace);
		tinyMCE.setAttrib(this.imgElement, 'vspace', vspace);
		tinyMCE.setAttrib(this.imgElement, 'width', width);
		tinyMCE.setAttrib(this.imgElement, 'height', height);
		tinyMCE.setAttrib(this.imgElement, 'border', border);

		// Fix for bug #989846 - Image resize bug
		if (width != "")
			this.imgElement.style.pixelWidth = width;

		if (height != "")
			this.imgElement.style.pixelHeight = height;
	}
}

function TinyMCE_getElementByAttributeValue(node, element_name, attrib, value) {
	var elements = this.getElementsByAttributeValue(node, element_name, attrib, value);
	if (elements.length == 0)
		return null;

	return elements[0];
}

function TinyMCE_getElementsByAttributeValue(node, element_name, attrib, value) {
	var elements = new Array();

	if (node && node.nodeName.toLowerCase() == element_name) {
		if (node.getAttribute(attrib).indexOf(value) != -1)
			elements[elements.length] = node;
	}

	if (node.hasChildNodes) {
		for (var x=0; x<node.childNodes.length; x++) {
			var childElements = this.getElementsByAttributeValue(node.childNodes[x], element_name, attrib, value);
			for (var i=0; i<childElements.length; i++)
				elements[elements.length] = childElements[i];
		}
	}

	return elements;
}

function TinyMCE_getParentElement(node, names) {
	var namesAr = names.split(',');

	if (node == null)
		return null;

	do {
		for (var i=0; i<namesAr.length; i++) {
			if (node.nodeName.toLowerCase() == namesAr[i].toLowerCase())
				return node;
		}
	} while (node = node.parentNode);

	return null;
}

function TinyMCE_convertURL(url, node, on_save) {
	var fileProto = (document.location.protocol == "file:");

	// Mailto link or anchor (Pass through)
	if (url.indexOf('mailto:') != -1 || url.indexOf('javascript:') != -1 || url.replace(' ','').charAt(0) == "#")
		return url;

	// Fix relative/Mozilla
	if (!tinyMCE.isMSIE && !on_save && url.indexOf("://") == -1 && url.charAt(0) != '/')
		return tinyMCE.settings['base_href'] + url;

	// Convert to relative urls
	if (on_save && tinyMCE.settings['relative_urls']) {
		var urlParts = tinyMCE.parseURL(url);

		// If not absolute url, do nothing (Mozilla)
		if (!urlParts['protocol'] && !tinyMCE.isMSIE) {
			var urlPrefix = "http://";
			urlPrefix += document.location.hostname;
			if (document.location.port != "")
				urlPrefix += document.location.port;

			url = urlPrefix + url;
			urlParts = tinyMCE.parseURL(url);
		}

		var tmpUrlParts = tinyMCE.parseURL(tinyMCE.settings['document_base_url']);

		// Link is within this site
		if (urlParts['host'] == tmpUrlParts['host'] && (!urlParts['port'] || urlParts['port'] == tmpUrlParts['port']))
			return tinyMCE.convertAbsoluteURLToRelativeURL(tinyMCE.settings['document_base_url'], url);
	}

	// Remove current domain
	if (!fileProto && tinyMCE.settings['remove_script_host']) {
		var start = document.location.protocol + "//" + document.location.hostname + "/";
		if (url.indexOf(start) == 0)
			url = url.substring(start.length-1);
	}

	return url;
}

/**
 * Parses a URL in to its diffrent components.
 */
function TinyMCE_parseURL(url_str) {
	var urlParts = new Array();

	if (url_str) {
		var pos, lastPos;

		// Parse protocol part
		pos = url_str.indexOf('://');
		if (pos != -1) {
			urlParts['protocol'] = url_str.substring(0, pos);
			lastPos = pos + 3;
		}

		// Find port or path start
		for (var i=lastPos; i<url_str.length; i++) {
			var chr = url_str.charAt(i);

			if (chr == ':')
				break;

			if (chr == '/')
				break;
		}
		pos = i;

		// Get host
		urlParts['host'] = url_str.substring(lastPos, pos);

		// Get port
		lastPos = pos;
		if (url_str.charAt(pos) == ':') {
			pos = url_str.indexOf('/', lastPos);
			urlParts['port'] = url_str.substring(lastPos+1, pos);
		}

		// Get path
		lastPos = pos;
		pos = url_str.indexOf('?', lastPos);
		if (pos == -1)
			pos = url_str.length;

		urlParts['path'] = url_str.substring(lastPos, pos);

		// Get query
		lastPos = pos;
		if (url_str.charAt(pos) == '?') {
			pos = url_str.length;
			urlParts['query'] = url_str.substring(lastPos+1, pos);
		}
	}

	return urlParts;
}

/**
 * Converts an absolute path to relative path.
 */
function TinyMCE_convertAbsoluteURLToRelativeURL(base_url, url_to_relative) {
	var strTok1;
	var strTok2;
	var breakPoint = 0;
	var outputString = "";

	// * * Crop away last path part
	base_url = base_url.substring(0, base_url.lastIndexOf('/'));
	strTok1 = base_url.split('/');
	strTok2 = url_to_relative.split('/');

	if (strTok1.length >= strTok2.length) {
		for (var i=0; i<strTok1.length; i++) {
			if (i >= strTok2.length || strTok1[i] != strTok2[i]) {
				breakPoint = i + 1;
				break;
			}
		}
	}

	if (strTok1.length < strTok2.length) {
		for (var i=0; i<strTok2.length; i++) {
			if (i >= strTok1.length || strTok1[i] != strTok2[i]) {
				breakPoint = i + 1;
				break;
			}
		}
	}

	if (breakPoint == 1)
		return url_to_relative;

	for (var i=0; i<(strTok1.length-(breakPoint-1)); i++)
		outputString += "../";

	for (var i=breakPoint-1; i<strTok2.length; i++) {
		if (i != (breakPoint-1))
			outputString += "/" + strTok2[i];
		else
			outputString += strTok2[i];
	}

	return outputString;
}


function TinyMCE_getParam(name, default_value) {
	return (typeof this.settings[name] == "undefined") ? default_value : this.settings[name];
}

function TinyMCE_replaceVar(replace_haystack, replace_var, replace_str) {
	var re = new RegExp('{\\\$' + replace_var + '}', 'g');
	return replace_haystack.replace(re, replace_str);
}

function TinyMCE_replaceVars(replace_haystack, replace_vars) {
	var variables = replace_haystack.match(new RegExp('{\\\$.*?}', 'g'));

	if (variables != null) {
		for (var i=0; i<variables.length; i++) {
			var variableName = variables[i].substring(2);
			variableName = variableName.substring(0, variableName.length-1);
			if (typeof replace_vars[variableName] != "undefined")
				replace_haystack = replace_haystack.replace(variables[i], replace_vars[variableName]);
		}
	}

	return replace_haystack;
}

function TinyMCE_triggerNodeChange() {
	if (tinyMCE.settings['handleNodeChangeCallback']) {
		if (tinyMCE.selectedInstance) {
			var editorId = tinyMCE.selectedInstance.editorId;
			var elm = tinyMCE.selectedInstance.getFocusElement();
			var undoIndex = -1;
			var undoLevels = -1;

			if (tinyMCE.settings['custom_undo_redo']) {
				undoIndex = tinyMCE.selectedInstance.undoIndex;
				undoLevels = tinyMCE.selectedInstance.undoLevels.length;
			}

			eval(tinyMCE.settings['handleNodeChangeCallback'] + "(editorId, elm, undoIndex, undoLevels);");
		}
	}

	if (tinyMCE.selectedInstance)
		this.selectedInstance.contentWindow.focus();
}

function TinyMCE_getContent() {
	if (tinyMCE.selectedInstance) {
		var cleanedHTML = tinyMCE._cleanupHTML(this.selectedInstance.contentWindow.document, tinyMCE.settings, this.selectedInstance.contentWindow.document.body, false, true);
		return cleanedHTML;
	}

	return null;
}

function TinyMCE_setContent(html_content) {
	if (tinyMCE.selectedInstance) {
		var doc = this.selectedInstance.contentWindow.document;
		tinyMCE._setHTML(doc, html_content);
		doc.body.innerHTML = tinyMCE._cleanupHTML(doc, tinyMCE.settings, doc.body);
		tinyMCE.handleVisualAid(doc.body, true);
	}
}

function TinyMCE_importThemeLanguagePack(theme_name) {
	if (typeof theme_name == "undefined")
		theme_name = tinyMCE.settings['theme'];

	document.write('<script language="javascript" type="text/javascript" src="' + tinyMCE.baseURL + '/themes/' + theme_name + '/langs/' + tinyMCE.settings['language'] +  '.js"></script>');
}

/**
 * Adds themeurl, settings and lang to HTML code.
 */
function TinyMCE_applyTemplate(html, args) {
	html = tinyMCE.replaceVar(html, "themeurl", tinyMCE.themeURL);

	if (typeof args != "undefined")
		html = tinyMCE.replaceVars(html, args);

	html = tinyMCE.replaceVars(html, tinyMCE.settings);
	html = tinyMCE.replaceVars(html, tinyMCELang);

	return html;
}

function TinyMCE_openWindow(template, args, skip_lang) {
	var html, width, height, x, y;

	html = template['html'];
	if (!(width = template['width']))
		width = 320;

	if (!(height = template['height']))
		height = 200;

	html = tinyMCE.replaceVar(html, "css", this.settings['popups_css']);
	html = tinyMCE.applyTemplate(html, args, skip_lang);

	x = parseInt(screen.width / 2.0) - (width / 2.0);
	y = parseInt(screen.height / 2.0) - (height / 2.0);

	var win = window.open("", "mcePopup", "top=" + y + ",left=" + x + ",scrollbars=no,modal=yes,width=" + width + ",height=" + height);
	win.document.write(html);
	win.document.close();
}

function TinyMCE_handleVisualAid(element, deep) {
	var tableElement = null;

	switch (element.nodeName.toLowerCase()) {
		case "table":
			var cssText = element.getAttribute("border") == 0 ? tinyMCE.settings['visual_table_style'] : "";

			element.style.cssText = cssText;

			for (var y=0; y<element.rows.length; y++) {
				for (var x=0; x<element.rows[y].cells.length; x++)
					element.rows[y].cells[x].style.cssText = cssText;
			}

			break;
	}

	if (deep && element.hasChildNodes()) {
		for (var i=0; i<element.childNodes.length; i++)
			tinyMCE.handleVisualAid(element.childNodes[i], deep);
	}
}

function TinyMCE_getAttrib(elm, name, default_value) {
	var v = elm.getAttribute(name);
	return (v && v != "") ? v : default_value;
}

function TinyMCE_setAttrib(element, name, value, no_fix_value) {
	if (!no_fix_value && value != null && value != -1) {
		var re = new RegExp('[^0-9%]', 'g');
		value = value.replace(re, '');
	}

	if (value != null && value != "" && value != -1)
		element.setAttribute(name, value);
	else
		element.removeAttribute(name);
}

function TinyMCE__setHTML(doc, html_content) {
	doc.body.innerHTML = html_content;

	// * * Content duplication bug fix
	if (tinyMCE.isMSIE && tinyMCE.settings['fix_content_duplication']) {
		// Remove P elements in P elements
		var paras = doc.getElementsByTagName("P");
		for (var i=0; i<paras.length; i++) {
			var node = paras[i];
			while ((node = node.parentNode) != null) {
				if (node.nodeName.toLowerCase() == "p")
					node.outerHTML = node.innerHTML;
			}
		}

		// Content duplication bug fix
		doc.body.innerHTML = doc.body.createTextRange().htmlText;
	}
}

// * * TinyMCEControl
function TinyMCEControl(settings) {
	// * * Undo levels
	this.undoLevels = new Array();
	this.undoIndex = 0;

	// * * Default settings
	this.settings = settings;
	this.settings['theme'] = tinyMCE.getParam("theme", "default");
	this.settings['width'] = tinyMCE.getParam("width", -1);
	this.settings['height'] = tinyMCE.getParam("height", -1);

	// * * Functions
	this.execCommand = TinyMCEControl_execCommand;
	this.onAdd = TinyMCEControl_onAdd;
	this.getFocusElement = TinyMCEControl_getFocusElement;
}

function TinyMCEControl_execCommand(command, user_interface, value) {
	// Mozilla issue
	if (!tinyMCE.isMSIE && !this.useCSS) {
		this.contentWindow.document.execCommand("useCSS", false, true);
		this.useCSS = true;
	}

	//alert("command: " + command + ", user_interface: " + user_interface + ", value: " + value);
	this.contentDocument = this.contentWindow.document; // <-- Strange!!

	var execCommandFunction = tinyMCE._getThemeFunction('_execCommand');
	if (eval("typeof " + execCommandFunction) != 'undefined') {
		if (eval(execCommandFunction + '(this.editorId, this.contentDocument.body, command, user_interface, value);'))
			return;
	}

	// Add undo level of operation
	if (command != "mceAddUndoLevel" && command != "Undo" && command != "Redo")
		this.execCommand("mceAddUndoLevel");

	// Fix align on images
	if (this.getFocusElement() && this.getFocusElement().nodeName.toLowerCase() == "img") {
		var align = this.getFocusElement().getAttribute('align');

		switch (command) {
			case "JustifyLeft":
				if (align == 'left')
					this.getFocusElement().removeAttribute('align');
				else
					this.getFocusElement().setAttribute('align', 'left');

				tinyMCE.triggerNodeChange();
				return;

			case "JustifyCenter":
				if (align == 'middle')
					this.getFocusElement().removeAttribute('align');
				else
					this.getFocusElement().setAttribute('align', 'middle');

				tinyMCE.triggerNodeChange();
				return;

			case "JustifyRight":
				if (align == 'right')
					this.getFocusElement().removeAttribute('align');
				else
					this.getFocusElement().setAttribute('align', 'right');

				tinyMCE.triggerNodeChange();
				return;
		}
	}

	if (tinyMCE.settings['force_br_newlines']) {
		var documentRef = this.contentWindow.document;
		var alignValue = "";

		if (documentRef.selection.type != "Control") {
			switch (command) {
					case "JustifyLeft":
						alignValue = "left";
						break;

					case "JustifyCenter":
						alignValue = "center";
						break;

					case "JustifyFull":
						alignValue = "justify";
						break;

					case "JustifyRight":
						alignValue = "right";
						break;
			}

			if (alignValue != "") {
				var rng = documentRef.selection.createRange();

				if ((divElm = tinyMCE.getParentElement(rng.parentElement(), "div")) != null)
					divElm.setAttribute("align", alignValue);
				else if (rng.pasteHTML && rng.htmlText.length > 0)
					rng.pasteHTML('<div align="' + alignValue + '">' + rng.htmlText + "</div>");

				tinyMCE.triggerNodeChange();
				return;
			}
		}
	}

	switch (command) {
		case "mceLink":
			var href = "", target = "";

			if (tinyMCE.selectedElement.nodeName.toLowerCase() == "a")
				tinyMCE.linkElement = tinyMCE.selectedElement;

			if (tinyMCE.linkElement) {
				href= tinyMCE.linkElement.getAttribute('href') ? tinyMCE.linkElement.getAttribute('href') : "";
				target = tinyMCE.linkElement.getAttribute('target') ? tinyMCE.linkElement.getAttribute('target') : "";
				href = eval(tinyMCE.settings['urlconvertor_callback'] + "(href, tinyMCE.linkElement, true);");
			}

			tinyMCE.openWindow(this.insertLinkTemplate, {href : href, target : target});

		break;

		case "mceLinkInt":
			var href = "", target = "";

			if (tinyMCE.selectedElement.nodeName.toLowerCase() == "a")
				tinyMCE.linkElement = tinyMCE.selectedElement;

			if (tinyMCE.linkElement) {
				href= tinyMCE.linkElement.getAttribute('href') ? tinyMCE.linkElement.getAttribute('href') : "";
				target = tinyMCE.linkElement.getAttribute('target') ? tinyMCE.linkElement.getAttribute('target') : "";
				href = eval(tinyMCE.settings['urlconvertor_callback'] + "(href, tinyMCE.linkElement, true);");
			}

			var returnVal = eval(this.settings['insertlink_callback'] + "(href, target);");
			if (returnVal && returnVal['href'])
				tinyMCE.insertLink(returnVal['href'], returnVal['target']);
				
		break;

		case "mceImage":
			var src = "", alt = "", border = "", hspace = "", vspace = "", width = "", height = "", align = "";

			if (tinyMCE.selectedElement != null && tinyMCE.selectedElement.nodeName.toLowerCase() == "img")
				tinyMCE.imgElement = tinyMCE.selectedElement;

			if (tinyMCE.imgElement) {
				src = tinyMCE.imgElement.getAttribute('src') ? tinyMCE.imgElement.getAttribute('src') : "";
				alt = tinyMCE.imgElement.getAttribute('alt') ? tinyMCE.imgElement.getAttribute('alt') : "";
				border = tinyMCE.imgElement.getAttribute('border') ? tinyMCE.imgElement.getAttribute('border') : "";
				hspace = tinyMCE.imgElement.getAttribute('hspace') ? tinyMCE.imgElement.getAttribute('hspace') : "";
				vspace = tinyMCE.imgElement.getAttribute('vspace') ? tinyMCE.imgElement.getAttribute('vspace') : "";
				width = tinyMCE.imgElement.getAttribute('width') ? tinyMCE.imgElement.getAttribute('width') : "";
				height = tinyMCE.imgElement.getAttribute('height') ? tinyMCE.imgElement.getAttribute('height') : "";
				align = tinyMCE.imgElement.getAttribute('align') ? tinyMCE.imgElement.getAttribute('align') : "";
				src = eval(tinyMCE.settings['urlconvertor_callback'] + "(src, tinyMCE.imgElement, true);");
			}

			if (this.settings['insertimage_callback']) {
				var returnVal = eval(this.settings['insertimage_callback'] + "(src, alt, border, hspace, vspace, width, height, align);");
				if (returnVal && returnVal['src'])
					tinyMCE.insertImage(returnVal['src'], returnVal['alt'], returnVal['border'], returnVal['hspace'], returnVal['vspace'], returnVal['width'], returnVal['height'], returnVal['align']);
			} else
				tinyMCE.openWindow(this.insertImageTemplate, {src : src, alt : alt, border : border, hspace : hspace, vspace : vspace, width : width, height : height, align : align});
		break;

		case "mceCleanup":
			tinyMCE._setHTML(this.contentDocument, this.contentDocument.body.innerHTML);
			var cleanedHTML = tinyMCE._cleanupHTML(this.contentDocument, this.settings, this.contentDocument.body);
			this.contentDocument.body.innerHTML = cleanedHTML;
		break;

		case "mceRemoveControl":
		case "mceRemoveEditor":
			tinyMCE.removeMCEControl(value);
		break;

		case "mceReplaceContent":
			var selectedText = "";

			if (tinyMCE.isMSIE) {
				var documentRef = this.contentWindow.document;
				var rng = documentRef.selection.createRange();
				selectedText = rng.text;
			} else
				selectedText = this.contentWindow.getSelection().toString();

			if (selectedText.length > 0) {
				value = tinyMCE.replaceVar(value, "selection", selectedText);
				tinyMCE.execCommand('mceInsertContent',false,value);
			}
		break;

		case "mceSetCSSClass":
			var selectedText = false;

			if (tinyMCE.isMSIE) {
				var documentRef = this.contentWindow.document;
				var rng = documentRef.selection.createRange();
				selectedText = (rng.text && rng.text.length > 0);
			} else
				selectedText = (this.contentWindow.getSelection().toString().length > 0);

			if (selectedText) {
				this.contentDocument.execCommand("removeformat", false, null);
				this.contentDocument.execCommand("fontname", false, "#mce_temp_font#");
				var elementArray = tinyMCE.getElementsByAttributeValue(this.contentDocument.body, "font", "face", "#mce_temp_font#");
/*				this.contentDocument.execCommand("createlink", false, "#mce_temp_url#");
				var elementArray = tinyMCE.getElementsByAttributeValue(this.contentDocument.body, "a", "href", "#mce_temp_url#");
*/
				// Change them all
				for (var x=0; x<elementArray.length; x++) {
					elm = elementArray[x];
					if (elm) {
						var spanElm = this.contentDocument.createElement("span");
						spanElm.className = value;
						if (elm.hasChildNodes()) {
							for (var i=0; i<elm.childNodes.length; i++)
								spanElm.appendChild(elm.childNodes[i].cloneNode(true));
						}

						elm.parentNode.replaceChild(spanElm, elm);
					}
				}

				tinyMCE.setContent(this.contentDocument.body.innerHTML);
			} else {
				var targetNode = tinyMCE.getParentElement(this.getFocusElement(), "p,img,span,div,td");

				// Mozilla img patch
				if (!tinyMCE.isMSIE && !targetNode)
					targetNode = tinyMCE.imgElement;

				if (targetNode) {
					if (targetNode.nodeName.toLowerCase() == "span" && (!value || value == "")) {
						if (targetNode.hasChildNodes()) {
							for (var i=0; i<targetNode.childNodes.length; i++)
								targetNode.parentNode.insertBefore(targetNode.childNodes[i].cloneNode(true), targetNode);
						}

						targetNode.parentNode.removeChild(targetNode);
					} else {
						if (value != null && value != "")
							targetNode.className = value;
						else {
							targetNode.removeAttribute("className");
							targetNode.removeAttribute("class");
						}
					}
				}
			}

			tinyMCE.triggerNodeChange();
		break;

		case "mceInsertContent":
			if (!tinyMCE.isMSIE) {
				this.contentDocument.execCommand("insertimage", false, "#mce_temp_url#");
				elm = tinyMCE.getElementByAttributeValue(this.contentDocument.body, "img", "src", "#mce_temp_url#");

				if (elm) {
					var rng = elm.ownerDocument.createRange();
					rng.setStartBefore(elm);
					var fragment = rng.createContextualFragment(value);
					elm.parentNode.replaceChild(fragment, elm);
				}
			} else {
				var rng = this.contentWindow.document.selection.createRange();

				if (rng.item)
					rng.item(0).outerHTML = value;
				else
					rng.pasteHTML(value);
			}

			tinyMCE.triggerNodeChange();
		break;

		case "mceInsertTable":
			if (user_interface) {
				var cols = 2, rows = 2, border = 0, cellpadding = "", cellspacing = "", align = "", width = "", height = "", action = "insert";

				tinyMCE.tableElement = tinyMCE.getParentElement(this.getFocusElement(), "table");

				if (tinyMCE.tableElement) {
					var rowsAr = tinyMCE.tableElement.rows;
					var cols = 0;
					for (var i=0; i<rowsAr.length; i++)
						if (rowsAr[i].cells.length > cols)
							cols = rowsAr[i].cells.length;

					cols = cols;
					rows = rowsAr.length;

					border = tinyMCE.getAttrib(tinyMCE.tableElement, 'border', border);
					cellpadding = tinyMCE.getAttrib(tinyMCE.tableElement, 'cellpadding', "");
					cellspacing = tinyMCE.getAttrib(tinyMCE.tableElement, 'cellspacing', "");
					width = tinyMCE.getAttrib(tinyMCE.tableElement, 'width', width);
					height = tinyMCE.getAttrib(tinyMCE.tableElement, 'height', height);
					align = tinyMCE.getAttrib(tinyMCE.tableElement, 'align', align);

					if (tinyMCE.isMSIE) {
						width = tinyMCE.tableElement.style.pixelWidth == 0 ? tinyMCE.tableElement.getAttribute("width") : tinyMCE.tableElement.style.pixelWidth;
						height = tinyMCE.tableElement.style.pixelHeight == 0 ? tinyMCE.tableElement.getAttribute("height") : tinyMCE.tableElement.style.pixelHeight;
					}

					action = "update";
				}

				tinyMCE.openWindow(this.insertTableTemplate, {cols : cols, rows : rows, border : border, cellpadding : cellpadding, cellspacing : cellspacing, align : align, width : width, height : height, action : action});
			} else {
				var html = '';
				var cols = 2, rows = 2, border = 0, cellpadding = -1, cellspacing = -1, align, width, height;

				if (typeof value == 'object') {
					cols = value['cols'];
					rows = value['rows'];
					border = value['border'] != "" ? value['border'] : 0;
					cellpadding = value['cellpadding'] != "" ? value['cellpadding'] : -1;
					cellspacing = value['cellspacing'] != "" ? value['cellspacing'] : -1;
					align = value['align'];
					width = value['width'];
					height = value['height'];
				}

				// Update table
				if (tinyMCE.tableElement) {
					tinyMCE.setAttrib(tinyMCE.tableElement, 'cellPadding', cellpadding);
					tinyMCE.setAttrib(tinyMCE.tableElement, 'cellSpacing', cellspacing);
					tinyMCE.setAttrib(tinyMCE.tableElement, 'border', border);
					tinyMCE.setAttrib(tinyMCE.tableElement, 'width', width);
					tinyMCE.setAttrib(tinyMCE.tableElement, 'height', height);
					tinyMCE.setAttrib(tinyMCE.tableElement, 'align', align, true);

					if (tinyMCE.isMSIE) {
						tinyMCE.tableElement.style.pixelWidth = (width == null || width == "") ? 0 : width;
						tinyMCE.tableElement.style.pixelHeight = (height == null || height == "") ? 0 : height;
					}

					tinyMCE.handleVisualAid(tinyMCE.tableElement);

					// Fix for stange MSIE align bug
					tinyMCE.tableElement.outerHTML = tinyMCE.tableElement.outerHTML;

					//this.contentWindow.dispatchEvent(createEvent("click"));

					tinyMCE.triggerNodeChange();
					return;
				}

				// Create new table
				html += '<table border="' + border + '" ';

				if (cellpadding != -1)
					html += 'cellpadding="' + cellpadding + '" ';

				if (cellspacing != -1)
					html += 'cellspacing="' + cellspacing + '" ';

				if (width != 0 && width != "")
					html += 'width="' + width + '" ';

				if (height != 0 && height != "")
					html += 'height="' + height + '" ';

				if (align)
					html += 'align="' + align + '" ';

				if (border == 0 && tinyMCE.settings['visual'])
					html += 'style="' + tinyMCE.settings['visual_table_style'] + '" ';

				html += '>';

				for (var y=0; y<rows; y++) {
					html += "<tr>";
					for (var x=0; x<cols; x++) {
						if (border == 0 && tinyMCE.settings['visual'])
							html += '<td style="' + tinyMCE.settings['visual_table_style'] + '">';
						else
							html += '<td>';

						html += "&nbsp;</td>";
					}
					html += "</tr>";
				}

				html += "</table>";

				this.execCommand('mceInsertContent', false, html);
			}
			break;

		case "mceTableInsertRowBefore":
		case "mceTableInsertRowAfter":
		case "mceTableDeleteRow":
		case "mceTableInsertColBefore":
		case "mceTableInsertColAfter":
		case "mceTableDeleteCol":
			var trElement = tinyMCE.getParentElement(this.getFocusElement(), "tr");
			var tdElement = tinyMCE.getParentElement(this.getFocusElement(), "td");
			var tableElement = tinyMCE.getParentElement(this.getFocusElement(), "table");
			var documentRef = this.contentWindow.document;
			var tableBorder = tableElement.getAttribute("border");

			// Table has a tbody use that reference
			if (tableElement.firstChild && tableElement.firstChild.nodeName.toLowerCase() == "tbody")
				tableElement = tableElement.firstChild;

			if (tableElement && trElement) {
				switch (command) {
					case "mceTableInsertRowBefore":
						var numcells = trElement.cells.length;
						var rowCount = 0;
						var tmpTR = trElement;

						// Count rows
						while (tmpTR) {
							if (tmpTR.nodeName.toLowerCase() == "tr")
								rowCount++;

							tmpTR = tmpTR.previousSibling;
						}

						var r = tableElement.insertRow(rowCount == 0 ? 1 : rowCount-1);
						for (var i=0; i<numcells; i++) {
							var newTD = documentRef.createElement("td");
							newTD.innerHTML = "&nbsp;";

							if (tableBorder == 0 && tinyMCE.settings['visual'])
								newTD.style.cssText = tinyMCE.settings['visual_table_style'];

							var c = r.appendChild(newTD);

							if (tdElement.parentNode.childNodes[i].colSpan)
								c.colSpan = tdElement.parentNode.childNodes[i].colSpan;
						}
					break;

					case "mceTableInsertRowAfter":
						var numcells = trElement.cells.length;
						var rowCount = 0;
						var tmpTR = trElement;
						var documentRef = this.contentWindow.document;

						// Count rows
						while (tmpTR) {
							if (tmpTR.nodeName.toLowerCase() == "tr")
								rowCount++;

							tmpTR = tmpTR.previousSibling;
						}

						var r = tableElement.insertRow(rowCount == 0 ? 1 : rowCount);
						for (var i=0; i<numcells; i++) {
							var newTD = documentRef.createElement("td");
							newTD.innerHTML = "&nbsp;";

							if (tableBorder == 0 && tinyMCE.settings['visual'])
								newTD.style.cssText = tinyMCE.settings['visual_table_style'];

							var c = r.appendChild(newTD);

							if (tdElement.parentNode.childNodes[i].colSpan)
								c.colSpan = tdElement.parentNode.childNodes[i].colSpan;
						}
					break;

					case "mceTableDeleteRow":
						// Remove whole table
						if (tableElement.rows.length <= 1) {
							tableElement.parentNode.removeChild(tableElement);
							tinyMCE.triggerNodeChange();
							return;
						}

						// Delete row
						trElement.parentNode.removeChild(trElement);
					break;

					case "mceTableInsertColBefore":
						var cellCount = tdElement.cellIndex;

						// Add columns
						for (var y=0; y<tableElement.rows.length; y++) {
							var cell = tableElement.rows[y].cells[cellCount];

							// Can't add cell after cell that doesn't exist
							if (!cell)
								break;

							var newTD = documentRef.createElement("td");
							newTD.innerHTML = "&nbsp;";

							if (tableBorder == 0 && tinyMCE.settings['visual'])
								newTD.style.cssText = tinyMCE.settings['visual_table_style'];

							cell.parentNode.insertBefore(newTD, cell);
						}
					break;

					case "mceTableInsertColAfter":
						var cellCount = tdElement.cellIndex;

						// Add columns
						for (var y=0; y<tableElement.rows.length; y++) {
							var append = false;
							var cell = tableElement.rows[y].cells[cellCount];
							if (cellCount == tableElement.rows[y].cells.length-1)
								append = true;
							else
								cell = tableElement.rows[y].cells[cellCount+1];

							var newTD = documentRef.createElement("td");
							newTD.innerHTML = "&nbsp;";

							if (tableBorder == 0 && tinyMCE.settings['visual'])
								newTD.style.cssText = tinyMCE.settings['visual_table_style'];

							if (append)
								cell.parentNode.appendChild(newTD);
							else
								cell.parentNode.insertBefore(newTD, cell);
						}
					break;

					case "mceTableDeleteCol":
						var index = tdElement.cellIndex;

						var numCols = 0;
						for (var y=0; y<tableElement.rows.length; y++) {
							if (tableElement.rows[y].cells.length > numCols)
								numCols = tableElement.rows[y].cells.length;
						}

						// Remove whole table
						if (numCols <= 1) {
							tableElement.parentNode.removeChild(tableElement);
							tinyMCE.triggerNodeChange();
							return;
						}

						// Remove columns
						for (var y=0; y<tableElement.rows.length; y++) {
							var cell = tableElement.rows[y].cells[index];
							if (cell)
								cell.parentNode.removeChild(cell);
						}
					break;
				}

				tinyMCE.triggerNodeChange();
			}
		break;

		case "mceAddUndoLevel":
			if (tinyMCE.settings['custom_undo_redo']) {
				var customUndoLevels = tinyMCE.settings['custom_undo_redo_levels'];

				var newHTML = this.contentWindow.document.body.innerHTML;
				if (newHTML != this.undoLevels[this.undoLevels.length-1]) {
					// Time to compress
					if (customUndoLevels != -1 &&  this.undoLevels.length > customUndoLevels) {
						for (var i=0; i<this.undoLevels.length-1; i++) {
							//alert(this.undoLevels[i] + "=" + this.undoLevels[i+1]);
							this.undoLevels[i] = this.undoLevels[i+1];
						}

						this.undoLevels.length--;
						this.undoIndex--;
					}

					//alert(newHTML + "=" + this.undoLevels[this.undoIndex]);
					// Add new level
					this.undoLevels[this.undoIndex++] = newHTML;
					this.undoLevels.length = this.undoIndex;
					//window.status = "mceAddUndoLevel - undo levels:" + this.undoLevels.length + ", undo index: " + this.undoIndex;
				}

				tinyMCE.triggerNodeChange();
			}
			break;

		case "Undo":
			if (tinyMCE.settings['custom_undo_redo']) {
				// Is first level
				if (this.undoIndex == this.undoLevels.length) {
					this.execCommand("mceAddUndoLevel");
					this.undoIndex--;
				}

				// Do undo
				if (this.undoIndex > 0) {
					this.undoIndex--;
					this.contentWindow.document.body.innerHTML = this.undoLevels[this.undoIndex];
				}

				//window.status = "Undo - undo levels:" + this.undoLevels.length + ", undo index: " + this.undoIndex;
				tinyMCE.triggerNodeChange();
			} else
				this.contentDocument.execCommand(command, user_interface, value);
			break;

		case "Redo":
			if (tinyMCE.settings['custom_undo_redo']) {
				if (this.undoIndex < (this.undoLevels.length-1)) {
					this.undoIndex++;
					this.contentWindow.document.body.innerHTML = this.undoLevels[this.undoIndex];
					//window.status = "Redo - undo levels:" + this.undoLevels.length + ", undo index: " + this.undoIndex;
				}

				tinyMCE.triggerNodeChange();
			} else
				this.contentDocument.execCommand(command, user_interface, value);
			break;

		default:
			this.contentDocument.execCommand(command, user_interface, value);
			tinyMCE.triggerNodeChange();
	}
}

function TinyMCE__getThemeFunction(suffix) {
	var themePlugins = tinyMCE.settings['theme_plugins'].split(',');
	var templateFunction;

	// Is it defined in any plugins
	for (var i=themePlugins.length; i>=0; i--) {
		templateFunction = 'TinyMCE_' + themePlugins[i] + suffix;
		if (eval("typeof " + templateFunction) != 'undefined')
			return templateFunction;
	}

	return 'TinyMCE_' + tinyMCE.settings['theme'] + suffix;
}

function TinyMCEControl_onAdd(replace_element, form_element_name) {
	tinyMCE.themeURL = tinyMCE.baseURL + "/themes/" + this.settings['theme'];

	if (!replace_element) {
		alert("Error: Could not find the target element.");
		return false;
	}

	var templateFunction = tinyMCE._getThemeFunction('_getInsertTableTemplate');
	if (eval("typeof " + templateFunction) != 'undefined')
		this.insertTableTemplate = eval(templateFunction + '(this.settings);');

	var templateFunction = tinyMCE._getThemeFunction('_getInsertLinkTemplate');
	if (eval("typeof " + templateFunction) != 'undefined')
		this.insertLinkTemplate = eval(templateFunction + '(this.settings);');

	var templateFunction = tinyMCE._getThemeFunction('_getInsertImageTemplate');
	if (eval("typeof " + templateFunction) != 'undefined')
		this.insertImageTemplate = eval(templateFunction + '(this.settings);');

	var templateFunction = tinyMCE._getThemeFunction('_getEditorTemplate');
	if (eval("typeof " + templateFunction) == 'undefined') {
		alert("Error: Could not find the template function: " + templateFunction);
		return false;
	}

	var editorTemplate = eval(templateFunction + '(this.settings);');

	var deltaWidth = editorTemplate['delta_width'] ? editorTemplate['delta_width'] : 0;
	var deltaHeight = editorTemplate['delta_height'] ? editorTemplate['delta_height'] : 0;
	var html = '<span id="' + this.editorId + '_parent">' + editorTemplate['html'];

	var templateFunction = tinyMCE._getThemeFunction('_handleNodeChange');
	if (eval("typeof " + templateFunction) != 'undefined')
		this.settings['handleNodeChangeCallback'] = templateFunction;

	html = tinyMCE.replaceVar(html, "editor_id", this.editorId);
	html = tinyMCE.replaceVar(html, "default_document", tinyMCE.baseURL + "/blank.htm");

	this.settings['old_width'] = this.settings['width'];
	this.settings['old_height'] = this.settings['height'];

	// * * Set default width, height
	if (this.settings['width'] == -1)
		this.settings['width'] = replace_element.offsetWidth;

	if (this.settings['height'] == -1)
		this.settings['height'] = replace_element.offsetHeight;

	this.settings['area_width'] = this.settings['width'];
	this.settings['area_height'] = this.settings['height'];
	this.settings['area_width'] += deltaWidth;
	this.settings['area_height'] += deltaHeight;

	// * * Special % handling
	if (("" + this.settings['width']).indexOf('%') != -1)
		this.settings['area_width'] = "100%";

	if (("" + this.settings['height']).indexOf('%') != -1)
		this.settings['area_height'] = "100%";

	if (("" + replace_element.style.width).indexOf('%') != -1) {
		this.settings['width'] = replace_element.style.width;
		this.settings['area_width'] = "100%";
	}

	if (("" + replace_element.style.height).indexOf('%') != -1) {
		this.settings['height'] = replace_element.style.height;
		this.settings['area_height'] = "100%";
	}

	html = tinyMCE.applyTemplate(html);

	this.settings['width'] = this.settings['old_width'];
	this.settings['height'] = this.settings['old_height'];

	this.oldTargetElement = replace_element.cloneNode(true);
	this.formTargetElementId = form_element_name;

	html = html + '<input type="hidden" id="' + form_element_name + '" name="' + form_element_name + '" value=""></span>';

	// * * Output HTML and set editable
	if (!tinyMCE.isMSIE) {
		var rng = replace_element.ownerDocument.createRange();
		rng.setStartBefore(replace_element);

		var fragment = rng.createContextualFragment(html);
		replace_element.parentNode.replaceChild(fragment, replace_element);
	} else
		replace_element.outerHTML = html;

	window.setTimeout("tinyMCE.setEditMode('" + this.editorId + "', true)", 1);

	return true;
}

function TinyMCEControl_getFocusElement() {
	if (tinyMCE.isMSIE) {
		var documentRef = this.contentWindow.document;
		var rng = documentRef.selection.createRange();
		var elm = rng.item ? rng.item(0) : rng.parentElement();
	} else {
		var sel = this.contentWindow.getSelection();
		var elm = sel.anchorNode;
	}

	return elm;
}

// * * Global instances
var tinyMCE = new TinyMCE();
var tinyMCELang = new Array();