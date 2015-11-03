scanserv
========

scanserv is a simple web-based UI for SANE which allows you to share a scanner
on a network without the need for drivers or complicated installation. scanserv
does not do image conversion or manipulation (beyond the bare minimum necessary
for the purposes of browser preview) or OCR.

Copyright 2015	Sam Strachan (sam.strachan@gmail.com)


This program is free software; you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation; either version 2 of the License, or (at your option) any later
version.
This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
details.
You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc., 59
Temple Place, Suite 330, Boston, MA 02111-1307, USA.


requirements
============
* SANE
* ImageMagick
* Apache web-server with PHP-support


background
==========

This is yet another apache-php-scanimage-web-front-end. Why?

 * I wanted a simple server which would simply scan an image with as little
   dependency on other software as possible. I already have Photoshop / GIMP
   I don't need a webapp to do that stuff
 * Desire for easier and cleaner set up and configuration
 * Separation of presentation and control logic with json-rpc
 * I just wanted to

roadmap
=======

 * Nicer looking UI
 * Configuration page for debugging set up assisting new users
 * Multi-language support
 * Server storage of configuration
 * Add local storage too (amplify?)

------------------------------------------------------------------------

installation
============

 * Apache with PHP5+
 * ipkg install libieee1284
 * ipkg install sane-backends
 * ipkg install imagemagick
 * Copy this website to your apache webserver
 * Make sure your website has permission to run the php files, and imagemagick

