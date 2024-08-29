=== bs Share Buttons ===

Contributors: craftwerk

Stable tag: 1.0.1
Tested up to: 6.6
Requires at least: 5.0
Requires PHP: 7.4
License: MIT License
License URI: https://github.com/bootscore/bs-share-buttons/blob/main/LICENSE

Displays share buttons in bootScore WordPress Theme, Copyright 2020 Bastian Kreiter.

== Installation ==

1. In your admin panel, go to Plugins > and click the Add New button.
2. Click Upload Plugin and Choose File, then select the Plugin's .zip file. Click Install Now.
3. Click Activate to use your new Plugin right away.

== Usage ==

Use shortcode to display share buttons in your post, page or widget:

[bs-share-buttons]

Use shortcode to display share buttons in your .php files:

<?php echo do_shortcode("[bs-share-buttons]"); ?>

Remove buttons you do not want to display directly in main.php line 77 to 89 by deleting the respective line or override them by display: none. Use following classes:

.btn-twitter
.btn-facebook
.btn-whatsapp
.btn-pinterest
.btn-linkedin
.btn-reddit
.btn-tumblr
.btn-buffer
.btn-mix
.btn-vk
.btn-mail
.btn-print


== Changelog ==

= 1.0.1 - August 29 2024 =
    
* Fix return Array

= 1.0.0 - January 02 2021 =
    
* Initial release
