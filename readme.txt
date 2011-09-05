=== Theme File Duplicator ===
Contributors: rockgod100
Tags: theme, template, admin
Requires at least: 3.0
Tested up to: 3.2
Stable tag: 1.0

Clone an existing template file from the Wordpress admin area. Go to Appearance -> Add Page Template

== Description ==

This is a small utility that allows theme authors to clone an existing template file, to avoid having to download, rename and re-upload new files via FTP. Optionally, a user can add a template name, so that the new file will begin with

`
<?php
/*
Template Name: {My new template}
*/
?>
`
and will be automatically recognized as a new page template in the post editor. 


== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to Appearance -> Add Page Template NOTE: If you are using a child theme, the new theme file will be in the parent theme folder

== Frequently Asked Questions ==

= A question that someone might have =

An answer to that question.


== Screenshots ==

1. Appearance -> Add Page Template

== Changelog ==

= 1.0 =
* Initial release
