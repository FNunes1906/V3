<?php

//echo '<pre>'.print_r($_REQUEST, 1).'</pre>';

/**
 * @author gabe@fijiwebdesign.com
 * @copyright (c) fijiwebdesign.com
 * @license http://www.fijiwebdesign.com/
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


class com_php_adminHTML {
	
	/**
	 * List Files
	 * @param $files Array
	 */
	function index(&$files) {
		
		$file_dir = JPATH_ROOT . '/components/com_php/files/';
		
		?>
		
		<style type="text/css">
			td.filename {
				width: 20%;
			}
		</style>
		
		<script type="text/javascript">
			var com_php = {
				config: {},
				desc_edit_handler: function(e) {
					this.innerHTML = '';
					// remove edit handler 
					this.removeEvent('click', com_php.desc_edit_handler);
					var name = $(this).getProperty('name');
					var editor = new Element('input', {
						'value': com_php.config[name] || '',
						'events': {
							'blur': com_php.desc_save_edit_handler,
							'click': function(e) {
								new Event(e).stopPropagation();
							},
							'keypress': function(e) {
								var event = new Event(e);
								if (event.key == 'enter') com_php.desc_save_edit_handler.bind(this)(e);
								event.stopPropagation();
							}
						},
						styles: {
							'width': '100%'
						}
					});
					$(this).adopt(editor);
					new Event(e).stopPropagation();
					editor.focus();
				},
				desc_save_edit_handler: function(e) {
					var parent = $(this).getParent();
					var name = parent.getProperty('name');
					var old_value = com_php.config[name] || '';
					var new_value = this.value;
					if (new_value != old_value) {
						// new value. save it
						com_php.config[name] = new_value;
						new XHR({'method': 'post'}).send('index2.php', 'option=com_php&task=config&tmpl=component&no_html=1&config='+Json.toString(com_php.config));
					}
					parent.innerHTML = new_value;
					// re-add edit handler
					parent.addEvent('click', com_php.desc_edit_handler);
					new Event(e).stopPropagation();
					
				}
			}; 

			// configuration
			$(window).addEvent('domready', function() {

				// get the config
				 new XHR({
					'method': 'post', 
					onSuccess: function(response) {
						// json encoded response from server
					 	com_php.config = eval( '(' + response + ')' );
						// set as description of files
						$$('.description').forEach(function(el) {
							var name = $(el).getProperty('name');
							if (typeof(com_php.config[name]) != 'undefined') {
								el.setText(com_php.config[name]);
							} 
						});
					}
				}).send('index2.php', 'option=com_php&task=config&tmpl=component&no_html=1');

				// editable config
				 $$('.description').forEach(function(el) {
					$(el).addEvent('click', com_php.desc_edit_handler);
				});
					
			});
			
		</script>
		
		<form name="adminForm" method="get" action="index2.php">
		<table class="adminlist">
        <thead>
        <tr>
        	<th width="50">&nbsp;</th>
            <th style="text-align:left;">File Name</th>
            <th style="text-align:left;">Description</th>
        </tr>
        </thead>
        <tbody>
		
		<?php foreach($files as $i=>$file) : ?>
	
			<tr class="row<?php echo $i%2; ?>">
	            <td>
	            	<input type="radio"name="file" value="<?php echo $file; ?>" onclick="isChecked(this.checked);" />
	            </td>
	            <td class="filename">
	            	<a href="<?php echo JRoute::_('index2.php?option=com_php&task=edit&file=' . urlencode($file)); ?>"><?php echo htmlentities($file); ?></a>
	            </td>
	            <td class="description" name="<?php echo htmlentities($file); ?>"></td>
			</tr>
			
		<?php endforeach; ?>

		</tbody>
		</table>
		
		<input type="hidden" name="option" value="com_php" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="" />
		
		</form>
		
		<?php
	}
	
	/**
	 * Edit a File
	 * @param $file String
	 */
	function edit($file, &$content) {
		global $mainframe;
		
		$Document =& JFactory::getDocument();
		
		$abs_path = JPATH_ROOT;
		$path = $abs_path.'/components/com_php/files/'.$file;
		
		// codemirror code editor
		$Document->addScript(JURI::base() . '/components/com_php/libs/codemirror/js/codemirror.js');
		
		?>
		
		<style type="text/css">
			.writable {
				color: green;
				font-weight: bold;
			}
			.not_writable {
				color: red;
				font-weight: bold;
			}
			
			/** Styles for editor */
			.CodeMirror-line-numbers {
				font-family: monospace;
    			font-size: 10pt;
    			padding: 5px;
    			border-right: 1px solid #e7e7e7;
    			background: #f0f0f0;
    			color: #bbb;
			}
			.CodeMirror-line-numbers:hover {
    			color: #999;
			}
			.CodeMirror-line-numbers div:hover {
    			text-decoration: underline;
			}
		</style>
		
		<script type="text/javascript">

			var editors = {};

			// overide submit so we save editor contents
			function submitbutton(task) {
				if (task == 'save' || task == 'apply') {
					$each(editors, function(editor, id) {
						$(id).value = editor.getCode();
					});
				}
				submitform(task);
			}

			// loads a HTML code editor
			function htmlCodeEditor(id) {
				var editor = CodeMirror.fromTextArea(id, {
					height: '500px', width: "100%", lineNumbers: true, tabMode: 'shift',
					parserfile: [
						"parsexml.js", 
						"parsecss.js", 
						"tokenizejavascript.js", 
						"parsejavascript.js",
						"../contrib/php/js/tokenizephp.js", 
						"../contrib/php/js/parsephp.js",
						"../contrib/php/js/parsephphtmlmixed.js"],
					stylesheet: [
						"components/com_php/libs/codemirror/css/xmlcolors.css", 
						"components/com_php/libs/codemirror/css/jscolors.css", 
						"components/com_php/libs/codemirror/css/csscolors.css",
						"components/com_php/libs/codemirror/contrib/php/css/phpcolors.css"],
					path: "components/com_php/libs/codemirror/js/",
					continuousScanning: 500,
					saveFunction: function() {
						submitbutton('apply');
					}
				});
				editors[id] = editor;
			}

			// load the HTML code editor
			$(window).addEvent('domready', function() {
				htmlCodeEditor('content');
			});
			
		</script>
		
		<form name="adminForm" method="post" action="index2.php" enctype="application/x-www-form-urlencoded">
		<table class="adminlist">
        <thead>
        <tr>
            <th style="text-align:left;"><?php echo htmlentities($file).' is '.(is_writable($path) ? '<span class="writable">writable</span>' : '<span class="not_writable">not writable</span>'); ?></th>
        </tr>
        </thead>
        <tbody>
			<tr>
	            <td>
	            	<textarea name="content" id="content" style="width:99%;height:500px;"><?php echo htmlspecialchars($content); ?></textarea>
	            </td>
			</tr>
		</tbody>
		</table>
		
		<input type="hidden" name="option" value="com_php" />
		<input type="hidden" name="file" value="<?php echo htmlspecialchars($file); ?>" />
		<input type="hidden" name="task" value="save" />
		<input type="hidden" name="boxchecked" value="" />
		
		</form>
		
		<?php
	}
	
	/**
	 * Add a file
	 */
	function add() {
		?>
		
		<style type="text/css">
			.label {
				font-weight: bold;
				text-align: right;
				padding-right: 6px;
			}
			input[name=file] {
				width:200px;
			}
		</style>
		
		<form name="adminForm" method="get" action="index2.php">
		<table class="adminlist">
        <thead>
        <tr>
            <th style="text-align:left;">Add File</th>
        </tr>
        </thead>
        <tbody>
			<tr>
	            <td>
	            	<span class="label">File Name</span><input name="file" />
					<input type="submit" value="Next" />
	            </td>
			</tr>
		</tbody>
		</table>
		
		<input type="hidden" name="option" value="com_php" />
		<input type="hidden" name="task" value="create" />
		<input type="hidden" name="boxchecked" value="" />
		
		</form>
		
		<?php
	}
	
	function savefile() {
		
	}
	
	function delefile() {
		
	}
	
	function about() {
		?>
		
		<table class="adminlist">
        <thead>
        <tr>
            <th>About PHP Component</th>
        </tr>
        </thead>
        <tbody>

        <tr>
            <td>
            	<p>
            		The PHP Component allows you to create custom pages and use PHP in those pages.
            	</p>
				<p>
            		It allows you to create custom pages, or mini components to do quick tasks, or for testing.
            	</p>
				<p>
            		View the <b>help</b> menu for usage details. 
            	</p>
            </td>
		</tr>
		</tbody>
		</table>
		
		<?php
	}
	
	function help() {
				?>
				
		<style type="text/css">
			pre {
				border-color: #E7E7E7;
			    border-style: solid;
			    border-width: 1px 1px 1px 10px;
			    font-family: monospace;
			    padding: 6px;
			    text-align: left;
			}
		</style>
		
		<table class="adminlist">
        <thead>
        <tr>
            <th>How to use the PHP Component</th>
        </tr>
        </thead>
        <tbody>

        <tr>
            <td>
              <p class="info"><strong>If you have questions, please visit our <a href="http://www.fijiwebdesign.com/">forum</a> which has example code and discussion.</strong></p>
            	<p>
            		First create a PHP file in the PHP component.
            	</p>
				<p>
					<pre>Components -> PHP Component -> Manage Files -> New</pre>
				</p>
				<p>
            		Fill in the File name and click "Next".
            	</p>
				<p>
            		Fill in regular PHP in the form and save the file. 
            	</p>
				<p>
            		You can regular PHP Syntax:
					<pre>&lt;?php echo 'I am some PHP'; ?&gt;</pre> 
					You can also use HTML and PHP.
					<pre><?php
						echo htmlentities('<p>I am some HTML</p><?php echo "I am some PHP";');
					?></pre>
            	</p>
				<p>
            		Then you have to link to this file from the Joomla Menu.
            	</p>
				<p>
            		<pre>Menu -> Main Menu -> New -> Component -> PHP Component</pre>
            	</p>
				<p>
            		Important: Choose the File you created, in the Menu Parameters and publish.
            	</p>
            	<p>
            		You are all set. View the page.
            	</p>
            </td>
		</tr>
		</tbody>
		</table>
		
		<table class="adminlist">
        <thead>
        <tr>
            <th>Linking between pages</th>
        </tr>
        </thead>
        <tbody>

        <tr>
            <td>
            <p>
            		You can link between pages created inside PHP Component. First create the page, then view the page and copy its URL. YOu should notice that it would be index.php?option=com_php&Itemid={Itemid}. 
					The only thing changing will be {Itemid}. This will be the unique id Joomla asigns for each menu Item. 
            	</p>
				<p>
            		So you can create a link using the Joomla1.0 API. 
					<pre>&lt;?php echo sefRelToAbs('index.php?option=com_php&Itemid=1'); ?&gt;</pre>
					For Joomla 1.5 API.
					<pre>&lt;?php echo JRoute::_('index.php?option=com_php&Itemid=1'); ?&gt;</pre>
					It is better to wrap the code in the Joomla API as this caters for SEF URLs also.
            	</p>
            </td>
        </tr>
        </tbody>
        </table>
        
        <table class="adminlist">
        <thead>
        <tr>
            <th>Further Help</th>
        </tr>
        </thead>
        <tbody>

        <tr>
            <td>
            <p>
            You can find further help in our forum at <a href="http://www.fijiwebdesign.com/">Fiji Web Design</a>.
            </p>
            <p>
            You can also send me questions at <a href="mailto:gabe@fijiwebdesign.com">gabe@fijiwebdesign.com</a>.
            </p>
            </td>
        </tr>
        </tbody>
        </table>
		
		<?php
	}

  function footer() {
    echo '<div class="footer" style="text-align:center;"><p>Copyright &copy; 2010 <a href="http://www.fijiwebdesign.com/">Fiji Web Design</a></p></div>';
  }
	
}

?>
