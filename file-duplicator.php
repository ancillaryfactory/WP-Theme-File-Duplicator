<?php
/*

Plugin Name: Template File Duplicator
Plugin URI: 
Description: 
Version: 0.1
Author: 
Author URI: http://www.ancillaryfactory.com
License: GPL2



To do:
Populate a dropdown with a list of all files in the template directory



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

// Add settings link on plugin page

function file_duplicator_settings_link($links) { 
  $settings_link = '<a href="admin.php?page=duplicator">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}

 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'file-duplicator_admin_actions' );


function duplicator_admin_actions() {
	$page = add_menu_page( "File Duplicator", "File Duplicator", "edit_posts", "duplicator", "file_duplicator_admin", "", 35 ); 
}

add_action('admin_menu', 'duplicator_admin_actions');

if (isset($_POST['newFile'])) {
	add_action('admin_init', 'duplicationProcess');
}


function file_duplicator_admin() {   


?>
<!-- Success Messages -->
<?php if (!empty($_POST['newFile'])) { 
	$newFile = $_POST['newFile'];
	?>
	<div class="updated fade"><p><strong><?php print $newFile . ' created. <a href="' . admin_url('theme-editor.php') . '">Take a look</a>.'; ?></strong></p></div>  
<?php } ?>



<!-- End Success Messages -->


<div class="wrap"> 
  <div id="icon-plugins" class="icon32" style="float:left"></div>
<h2>New copy of Page.php</h2>

<pre><?php // print_r($_POST); ?></pre>


<form id="duplicateFile" method="post" action="admin.php?page=duplicator" style="padding:45px">
	
	<br/>
	<label for="newFile"><strong>New template name</strong> <em>(Copy of page.php)</em> </label><br/>
	<input type="text" name="newFile" id="newFile" style="font-size:16px;padding:5px;text-align:right;width:250px" value=".php"/>
	
	<input type="submit" name="duplicateFileSubmit" value="Make a new file" class="button-primary" style="position:relative;top:-2px"/>

</form>
</div>
<?php } 


function duplicationProcess() {
	
	$templateDirectory = TEMPLATEPATH . '/page.php';
	$newFile = $_POST['newFile']; 
	
	
	
	$newFilePath = TEMPLATEPATH . '/' . $newFile;

	
	$currentFile = fopen($templateDirectory,"r");
	$pageTemplate = fread($currentFile,filesize($templateDirectory));
	fclose($currentFile);
	
	$newTemplateFile = fopen($newFilePath,"w");
	fwrite($newTemplateFile, $pageTemplate);
	fclose($newTemplateFile);
	
}