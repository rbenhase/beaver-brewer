=== Beaver Brewer ===
Contributors: rbenhase
Tags: Beaver Builder, custom modules
Donate link: http://beaverbrewer.com/donate
Requires at least: 4.0
Tested up to: 4.5

Extends the Beaver Builder plugin by giving admins the ability to easily install "homebrew" modules in an a la carte fashion.

== Description ==
Beaver Builder is a fantastic page builder plugin, and its support for custom modules gives it nearly limitless potential. But as the number of Beaver Builder modules increases, they can become a bit difficult for users (and developers) to manage. Beaver Brewer strives to change all that.

= Many modules. Many developers. One plugin. =
Instead of installing a different Wordpress plugin for every set of Beaver Builder modules you want to use, you can now install a single, lightweight plugin that handles them all. This means that a module developer doesn't necessarily need to build out an entire plugin wrapper for his/her project, and this translates into lower overhead and fewer plugins to maintain on your site.

= Pick and choose what you want. =
Why install a plugin that contains 30 modules if you're already certain that you're only going to need one of them? Beaver Brewer lets you install individual modules a la carte.

= Keep things up-to-date. =
Module developers can use our handy module.config file to enable easy, one-click updates for their module from the Wordpress admin area! All you need is a place to host your latest module zipball (GitHub and Bitbucket work great, but hosting it on your own site works too!).

= Brew your own. =
Whether you're a developer who needs to crank out a module post haste, or just someone who wants to experiment a little, Beaver Brewer makes it quicker and easier to develop new modules from scratch. 

== Installation ==
1. Upload the beaver-brewer folder to the /wp-content/plugins/ directory.
2. Activate the Beaver Brewer plugin through the 'Plugins' menu in WordPress.
3. Install and activate modules under the 'Beaver Brewer' menu in the Wordpress admin.

== Frequently Asked Questions ==
= Is this plugin compatible with the free/lite version of Beaver Builder? =
No, this plugin requires Beaver Builder Premium. But believe me, it's worth the investment!

= Will this plugin work with any Beaver Builder module? =
Not necessarily. Some modules are dependent on a parent plugin in order to work. In order to ensure that your module is compatible with Beaver Brewer, please follow our compatibility requirements below.

= Can I still (separately) use Beaver Lodge or other plugins that contain Beaver Builder modules? =
Yes, absolutely-- especially if those developers don't offer individual module updates (e.g. making use of a module.config file).

= A module I'm using doesn't contain a module.config file. Why? =
The module.config file is just something I've come up with to enable simple, one-click updates. Not all developers will take advantage of this feature (especially until Beaver Brewer becomes popular). This means that your module will need to be updated manually if/when the developer releases a new version. 

= I don't want to use the Beaver Brewer admin (or am having file permissions issues). How can I manually add modules? =
Simply drop your module folder into your wp-content/bb-modules directory. If the bb-modules directory does not exist (e.g., because of a permissions issue), you will have to create it.

== Troubleshooting ==

= General file/directory permissions issues = 
File/folder permissions issues are the most likely problem you might experience with this plugin. As a general rule, you should use 644 permissions for folders and 755 permissions for files within your Wordpress installation (note that some files, such as your wp-config.php file, should be stricter than this). If the user that Wordpress uses on your server is not the owner of the files/folders in your Wordpress installation, it must be the group owner (and bumping permissions up to 664 for folders, 775 for files will be necessary). Do not use 777 permissions for anything that is accessible over the internet. For more, visit https://codex.wordpress.org/Changing_File_Permissions.

= A certain module is not showing up in the page builder =
Assuming that you've installed the module correctly, you may want to ensure that it meets the Beaver Brewer compatibility requirements (see below).

= A module is missing from the list on the Beaver Brewer admin page =
Check that your module folder's file permissions allow it to be readable by the webserver. Also check that you've installed it correctly; there should be a folder (e.g., the name of the module) inside the wp-content/bb-modules directory, and inside that folder is where your individual module files should live. If there is no PHP file inside your module folder, Beaver Brewer will not recognize it as a valid module.

= My plugin could not be activated because it triggered a fatal error. =
See your error log for more information.

= "Fatal error: Cannot redeclare class" issues =
This is when you try to activate two modules that contain identical class names (or a two copies of the same module). You must remove one of the modules, or else rename one of the classes causing the issue.

== Compatibility Requirements ==
I plan on releasing complete online documentation for this plugin before it's released into the wild, but the general rule for making your module compatible with Beaver Brewer is that you should avoid making it dependent on a parent plugin. If you follow the Beaver Builder custom module documentation (see https://www.wpbeaverbuilder.com/custom-module-documentation/), only skipping the very first part (about creating a plugin wrapper), you should be fine. The MY_MODULES_DIR and MY_MODULES_URL constants are defined by Beaver Brewer, and the init hook to load your module is already taken care of. You can see and download my plugin boilerplate at http://beaverbrewer.com/downloads if you're having trouble getting started. 

To enable automatic updates for your module, you can utilize the module.config file. See http://beaverbrewer.com/module-config/ for more info.

== To Do ==
There's a lot more I'd like to do with this module in future versions. Here's a few things:

- Add a search / filter modules function on the Beaver Brewer admin page.
- Detect any compatibility issues and warn the user on the admin page.
- Create centralized Beaver Brewer module repository for community use (similar to the Wordpress plugin repository).
- Improve README and provide full online documentation for making modules compatible with Beaver Brewer.
- Improve automatic updates (use a true update server instead of relying on Bitbucket)
- Create simple module boilerplate & generator app (which builds your module.config file, etc. for you).
- Maybe make the Beaver Brewer admin page more closely resemble the Wordpress plugins admin page.
- Invent a machine that warps spacetime just enough to achieve 30 hours's worth of work in just one 8-hour day.