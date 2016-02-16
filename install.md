# installation

## QNAP NAS install
 * [Install IPKG](http://wiki.qnap.com/wiki/Install_Optware_IPKG)
 * SSH into your NAS - e.g. use PuTTY as admin
 * Plug your scanner into a USB port
 * Type `lsusb` to check the scanner is attached
 * At the terminal type the following commands
    * `ipkg update`
    * `ipkg install libieee1284`
    * `ipkg install sane-backends`
    * `ipkg install imagemagick`
 * Confirm installation typing...
    * `sane-find-scanner -q`
    * `scanimage -L`
    * `su -m httpdusr -c 'scanimage --test'` - if this fails you need to give permission to scanimage for httpdusr
 * [Download the scanserv code](https://github.com/sbs20/scanserv/archive/master.zip) and copy it to your Qweb share
 * You may need to set the permissions of your new directory: `chmod 775 /share/Qweb/scanserv`
 * Ensure your QNAP web server is running
 * Open your browser and navigate to http://YOUR_QNAP:PORT/scanserv/ 

## Raspberry Pi
*Please note:* USB only scanners draw a lot of current relative to the Pi's available power. This manifested itself
in unusual scans - technically valid images but with odd colours and block transforms. So I needed to switch and 
use a powered USB hub for my Canon LIDE 20. Because of my USB3.0 hub that in turn led to USB issues. If you encounter
similar then see here: https://www.raspberrypi.org/forums/viewtopic.php?f=28&t=53832

First we need to install sane, apache, and php5

```
sudo apt-get update
sudo apt-get install apache2 apache2-utils libapache2-mod-php5 php5 sane-utils imagemagick
```

### Check SANE is working
You need to configure sane here - configuring sane is outside the scope of this document, although I have 
found that I didn't need to do anything. To check it's setup correctly see if scanimage -L shows a net scanner

```
pi@printserver:~ $ scanimage -L
```
Should show: something like 
    device `net:localhost:plustek:libusb:001:004' is a Canon CanoScan N1240U/LiDE30 flatbed scanner

### Check apache can use SANE
If you know about saned and permissions then you may not need to worry about this.
```
sudo su -m www-data -c 'scanimage --test'
```
if not then try
```
sudo gpasswd -a www-data scanner
```

### Download and configure
Download and install scanserv (note, this will download a file called master.zip to the current user's home
directory). 

```
cd ~
sudo wget https://github.com/sbs20/scanserv/archive/master.zip
```
Note, older versions of raspbian install web pages in /var/www, we are assuming /var/www/html as that is 
what newer versions use. We are going to install scanserv so that you can access it with the url
http://my.pi.example.com/scanserv

```
cd /var/www/html
sudo unzip ~/master.zip
sudo mv scanserv-master/ scanserv
```
Ideally you should limit access to these directories like this...
```
sudo chown -R root:www-data /var/www/html/scanserv/output/
sudo chown -R root:www-data /var/www/html/scanserv/preview/
```
And set write permissions - the web site needs to create image files in these directories
```
sudo chmod 775 /var/www/html/scanserv/output/
sudo chmod 775 /var/www/html/scanserv/preview/
```
Now configure scanserv to point at the binaries

```
sudo nano /var/www/html/scanserv/classes_php/Config.php
```
    * Change /opt/bin/scanimage to /usr/bin/scanimage
    * Change /opt/bin/convert to /usr/bin/convert

Edit anything else you think is interesting, though the other defaults should be okay.

## References
 * http://forum.qnap.com/viewtopic.php?f=182&t=8351
 * http://sourceforge.net/p/phpsane/wiki/FreeBSD/
  