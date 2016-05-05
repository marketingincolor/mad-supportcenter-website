=== wp33423 hotfix ===
Contributors: peterwilsoncc
Tags: hotfix, taxonomy, terms
Requires at least: 4.3
Tested up to: 4.3
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This is a hotfix for the ticket #33423.

== Description ==

Hotfix for [ticket 33423](https://core.trac.wordpress.org/ticket/33423).

Reversed arguments for the scheduled task to split terms can cause the database to balloon in some edge cases. This fixes the problem.

A fix will be included in WP 4.3.1 and this plugin will automatically disable itself.

== Installation ==

Install this from the WordPress dashboard.

== Changelog ==

= 1.1 =
Repackage as WordPress.org was having trouble picking up the version number

= 1.0 =
Initial version.