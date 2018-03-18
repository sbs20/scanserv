#!/bin/sh

ROOTUID="0"
if [ "$(id -u)" -ne "$ROOTUID" ] ; then
    echo "Error: This script must be executed with root privileges. Try sudo."
    exit 1
fi

if [ -e ~/scanserv.zip ] ; then
    rm ~/scanserv.zip
fi

wget -O ~/scanserv.zip "https://github.com/sbs20/scanserv/archive/master.zip"

if ! cd /var/www/html; then
    echo "Is apache installed? Maybe:"
    echo "  sudo apt install apache2 apache2-utils libapache2-mod-php"
    echo
    echo "You may also want: sudo apt install sane-utils imagemagick"
    exit 1
fi

if [ -d scanserv ]; then
    echo "Destination directory already exists. Aborting installation."
    echo "If you don't care about existing data then:"
    echo
    echo "sudo rm -rf $(pwd)/scanserv"
    exit 1
fi

rm -rf scanserv-master
sudo unzip ~/scanserv.zip

echo "Moving to $(pwd)/scanserv"
sudo mv scanserv-master scanserv

echo "Updating ownership"
sudo chown -R root:www-data scanserv/output/
sudo chown -R root:www-data scanserv/preview/

echo "Updating permissions"
sudo chmod 775 scanserv/output/
sudo chmod 775 scanserv/preview/

echo "Installation complete"
