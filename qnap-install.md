https://wiki.archlinux.org/index.php/SANE

## QNAP NAS install
 * [Install Qnapware](https://github.com/sbs20/qnap-cookbook/blob/master/basics.md)
 * SSH into your NAS - e.g. use PuTTY as admin
 * Plug your scanner into a USB port
 * Type `lsusb` to check the scanner is attached
 * At the terminal type the following commands
    * `opkg update`
    * `opkg install sane-frontends imagemagick sudo`
 * Confirm installation typing...
    * `sane-find-scanner -q`
    * `scanimage -L`
    * `su -m httpdusr -c 'scanimage --test'` - if this fails you need to give permission to scanimage for httpdusr
    
```
nano /Apps/opt/etc/sudoers
```
add 
```
admin ALL=(ALL) ALL
```
then
```
sudo -i -u httpdusr
scanimage --test
```
If it fails then....

lsusb
 04a9:220d


addgroup scanner
usermod -G scanner httpdusr
chgrp scanner /dev/usb*
chmod g+rw /dev/usb* /dev/ugen*
chgrp scanner /Apps/opt/bin/scanimage


```
cd ~
wget --no-check-certificate https://github.com/sbs20/scanserv/archive/master.zip
cd /share/Qweb
sudo unzip ~/master.zip
sudo mv scanserv-master/ scanserv

```


    
 * [Download the scanserv code](https://github.com/sbs20/scanserv/archive/master.zip) and copy it to your Qweb share
 * You may need to set the permissions of your new directory: `chmod 775 /share/Qweb/scanserv`
 * Ensure your QNAP web server is running
 * Open your browser and navigate to http://YOUR_QNAP:PORT/scanserv/ 
