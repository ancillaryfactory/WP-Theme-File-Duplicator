<?php
/*

Plugin Name: Theme File Duplicator
Plugin URI: http://wordpress.org/extend/plugins/theme-file-duplicator/
Description: Clone template files from the WP backend. Go to Appearance -> Add Page Template
Version: 1.1
Author: Jon Schwab
Author URI: http://www.ancillaryfactory.com
License: GPL2





Copyright 2011    (email : jsschwab@aoa.org)

    This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See th
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

 
$plugin = plugin_basename(__FILE__); 

function duplicator_admin_actions() {
	//$page = add_menu_page( "File Duplicator", "File Duplicator", "edit_posts", "duplicator", "file_duplicator_admin", "", 35 ); 
	$page = add_submenu_page( 'themes.php', 'Add Page Template', 'Add Page Template', 'edit_themes', 'copy_theme_file', 'file_duplicator_admin' );
}

add_action('admin_menu', 'duplicator_admin_actions');

if (isset($_POST['newFile'])) {
	add_action('admin_init', 'duplicationProcess');
}


function file_duplicator_admin() {   

?>
<!-- Success Messages -->
<?php if (!empty($_POST['newFile'])) { 
	$newFile = str_replace(' ', '-', $_POST['newFile']);
	?>
	<div class="updated fade"><p><strong><?php print $newFile . ' created. <a href="' . admin_url('theme-editor.php') . '">Take a look</a>.'; ?></strong></p></div>  
<?php } ?>



<!-- End Success Messages -->


<div class="wrap"> 
  <div id="icon-plugins" class="icon32" style="float:left"></div>
<h2>Add new page template</h2>

<form id="duplicateFile" method="post" action="admin.php?page=copy_theme_file" style="padding:45px">
	 
	<label for="currentFile"><strong>Template file to copy:</strong></label><br/>
	<select name="currentFile" id="currentFile">
		<?php 
		$files = scandir(TEMPLATEPATH);
		foreach ($files as $file) {
			if ( preg_match( '(\.php$|\.css$|\.js$)', $file) ) {
				echo '<option value="' . $file . '">' . $file . '</option>';
			}
		}
		
		?>
	</select>
	
	<br/><br/>
	
	<input type="checkbox" name="addTemplateID" id="addTemplateID"  checked="checked" />&nbsp;
	<label for="addTemplateID"><strong>Add template name header</strong></label>
	
	<br/>
	
	<div id="templateNameWrapper">
		<br/>
		<label for="newTemplateName"><strong>New template name:</strong></label><br/>
		<input type="text" name="newTemplateName" id="newTemplateName" style="font-size:16px;padding:5px;width:250px" >
	</div>
	
	<br/>
	
	<label for="newFile"><strong>New filename:</strong></label><br/>
	<input type="text" name="newFile" id="newFile" style="font-size:16px;padding:5px;text-align:right;width:250px" value=".php"/>
	<!--<br/><em style="color:#444">If a child theme is currently active, this file will be placed in the parent theme's  folder.</em><br/>-->
	
	<br/><br/>
	
	<input type="submit" name="duplicateFileSubmit" value="Make a new file" class="button-primary" style="position:relative;top:-2px"/>

</form>
</div>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("#currentFile option[value='page.php']").attr('selected','selected');
		
		jQuery('#addTemplateID').click(function() {
			if (jQuery("#addTemplateID").is(":checked"))
			{
				jQuery("#templateNameWrapper").show("fast");
			} else {   
				jQuery("#templateNameWrapper").hide("fast");
			}
		});
		
	});
</script>



<?php } 


function duplicationProcess() {
	  
	$newTemplateName = trim($_POST['newTemplateName']);
	$templateIdentifier = '<?php
/*
Template Name: '. $newTemplateName . '
*/
?>

';
	$newFile = str_replace(' ', '-', $_POST['newFile']);
	$newFile = filter_var($newFile, FILTER_SANITIZE_URL);
	
	$fileToCopy = $_POST['currentFile'];
	$templateDirectory = TEMPLATEPATH . '/'. $fileToCopy;
	
	
	$newFilePath = STYLESHEETPATH . '/' . $newFile;

	
	$currentFile = fopen($templateDirectory,"r");
	$pageTemplate = fread($currentFile,filesize($templateDirectory));
	fclose($currentFile);
	
	$newTemplateFile = fopen($newFilePath,"w");
	
	if ( isset($_POST['addTemplateID']) ) {  // only write identifier if checkbox is checked
		fwrite($newTemplateFile, $templateIdentifier);
	}
	
	fwrite($newTemplateFile, $pageTemplate);
	fclose($newTemplateFile);
	
}