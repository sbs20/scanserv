# Install SANE and imagemagick

## Raspberry Pi / Debian
*Please note:* USB-only scanners draw a lot of current relative to the Pi's available power. This manifested itself
in unusual scans - technically valid images but with odd colours and block transforms. So I needed to switch and 
use a powered USB hub for my Canon LIDE 20. Because of my USB3.0 hub that in turn led to USB issues. If you encounter
similar then see here: https://www.raspberrypi.org/forums/viewtopic.php?f=28&t=53832

First we need to install sane

```
sudo apt-get update
sudo apt-get install sane-utils imagemagick
```

### Check SANE is working
You need to configure sane here - configuring sane is outside the scope of this document, although I have 
found that I didn't need to do anything. To check it's setup correctly see if scanimage -L shows a net scanner

```
pi@printserver:~ $ scanimage -L
```
Should show: something like 
    device `net:localhost:plustek:libusb:001:004' is a Canon CanoScan N1240U/LiDE30 flatbed scanner

## For QNAP NAS install [Works on QTS 4.2.2]

 * [Install Entware](basics.md)
 * SSH into your NAS - e.g. use PuTTY as admin
 * Plug your scanner into a USB port
 * Type `lsusb` to check the scanner is attached
 * At the terminal type the following commands
    * `opkg update`
    * `opkg install sane-frontends imagemagick sudo`
 * Confirm installation typing...
    * `sane-find-scanner -q`
    * `scanimage -L`

### Get permissions working
Pretend to be httpduser
```
sudo -i -u httpdusr
```

If (when) that fails you need to edit sudoers and try again

```
nano /opt/etc/sudoers
```

add 

```
admin ALL=(ALL) ALL
```

Once you're httpdusr then ....
```
/opt/bin/scanimage -L
```

There are any number of problems you might face here. Your user probably won't have
access to "scanimage" or usb devices or the sane.d directory. And you should probably
do this with a group privilege.

[This thread](https://wiki.archlinux.org/index.php/SANE) and 
[that thread](https://bugs.launchpad.net/ubuntu/+source/sane-backends/+bug/270185/comments/3)
are really useful. The short version is to do this:

```
addgroup scanner
usermod -G scanner httpdusr
chgrp scanner /dev/usb/*
chmod g+rw /dev/usb/*
chgrp scanner /opt/bin/scanimage
chmod 644 /opt/etc/sane.d/*
```

Find out the bus and device of your scanner using lsusb ...
```
Bus 003 Device 003: ID 04a9:220d Canon, Inc. CanoScan N670U/N676U/LiDE 20
```
Then do this: chgrp scanner /proc/usb/{bus}/{dev} - so I did this:
```
chgrp scanner /proc/usb/003/003
```

## Arch linux
```
sudo pacman -S sane
```

 * scanimage -L should fail... 
 * sane-find-scanner should fail... need sudo
 * sudo scanimage -L should work

To fix permissions

 * useradd -m scanservhttpd
 * sudo usermod -G scanner scanservhttpd

Confirm:
```
sudo -i -u scanservhttd
scanimage -L
```
