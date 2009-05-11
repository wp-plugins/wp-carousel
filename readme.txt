=== Plugin Name ===
Tags: posts, images, carousel, theme
Requires at least: 2.5
Tested up to: 2.7.1

== Description ==

WP Carousel is a plugin that create a carousel with a category's posts, and you can put it anywhere on the blog.

In the plugin's options page you can select the posts's category and the number of posts to show.

The plugin uses jQuery, and load it directly from your WordPress installation files, so if you have a WordPress version without jQuery, it won't work.

== Installation ==

1. Upload `wp-carousel` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php wp_carousel(''); ?>` in your templates

== Frequently Asked Questions ==

= How can I edit the carousel's style =

You can edit the carousel's images placed in `img` folder (inside `wp-carousel` folder).

CSS code is located in `carousel-css.php`, in `wp-carousel`.

== Screenshots ==

1. Carousel in WordPress Default theme
2. Carousel in WordPress Default theme (too)
3. WP Carousel's options page