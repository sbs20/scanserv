# installation
Make sure your scanner is [working with SANE](install-sane.md).

## Debian / Raspbian / Ubuntu

### Prerequisites

```
sudo apt-get update
sudo apt-get install apache2 apache2-utils libapache2-mod-php5 php5 sane-utils imagemagick
```
On newer debians you will need
```
sudo apt install apache2 apache2-utils libapache2-mod-php sane-utils imagemagick
```

Check apache can use SANE. If you know about saned and permissions then you may
not need to worry about this.

```
sudo su -m www-data -c 'scanimage --test'
```

if not then try

```
sudo gpasswd -a www-data scanner
```

### Install
Here's a one liner to install
```
wget -O ~/install.sh https://raw.githubusercontent.com/sbs20/scanserv/master/install.sh && chmod +x ~/install.sh && sudo ~/install.sh
```

If you want to change any configuration then look in
`/var/www/html/scanserv/classes_php/Config.php`

## QNAP
```
cd ~
wget --no-check-certificate https://github.com/sbs20/scanserv/archive/master.zip
cd /share/Qweb
sudo unzip ~/master.zip
sudo mv scanserv-master/ scanserv
```

Set variables correctly

```
/opt/bin/nano /share/Qweb/classes_php/Config.php
```

Then set the Scanimage and Convert lines - mine were as follows

```
<?php
class Config {
        const IsTrace = false;
        const TraceLineEnding = "<br>\n";
        const Scanimage  = "/opt/bin/scanimage";
        const Convert  = "/usr/local/sbin/convert";
        const BypassSystemExecute = false;
        const OutputDirectory = "./output/";
        const PreviewDirectory = "./preview/";
        const MaximumScanWidthInMm = 215;
        const MaximumScanHeightInMm = 297;
}
?>
```

### Test
 * You may need to set the permissions of your new directory: `chmod 775 /share/Qweb/scanserv`
 * Ensure your QNAP web server is running
 * Open your browser and navigate to http://YOUR_QNAP:PORT/scanserv/ 

## Arch
To fix permissions

 * useradd -m scanservhttpd
 * sudo usermod -G scanner scanservhttpd

Confirm:
```
sudo -i -u scanservhttd
scanimage -L
```

## QNAP NAS install OLD (Pre QTS version 4.0?)
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

## References
 * http://forum.qnap.com/viewtopic.php?f=182&t=8351
 * http://sourceforge.net/p/phpsane/wiki/FreeBSD/
