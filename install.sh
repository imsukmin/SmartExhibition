#!/bin/bash

# Don't use blank if you declear valuable
NGINXROOTPATH="/usr/share/nginx/html/"
NGINXCONFIGPATH="/etc/nginx/sites-available/default"
PHPPATH="/etc/php5/fpm/pool.d/"

clear
echo "########################################"
echo "      Server install script start      "
echo "########################################"


#Check if run as root
if [ "$(whoami)" != "root" ]; then
	echo "ERROR : You must be root to do that! : USE sudo"
	exit 1
else 	
#################################
###       clone project       ###
#################################

## Before install.... do this!

## apt-get install git
## git clone https://github.com/imsukmin/GamjaChip.git


#################################
###    Register tool's ppa    ###
#################################
# 1. add repository of NginX
add-apt-repository -y ppa:nginx/development

# 2. add repository of node.js
add-apt-repository -y ppa:chris-lea/node.js

# 3. apply ppa
apt-get update

#################################
###       install NginX       ###
#################################

# aptitude ==> install tool seems like apt-get
apt-get -y install aptitude
aptitude -y install software-properties-common
apt-get -y install nginx

#################################
###  install MySql and php5   ###
#################################

apt-get -y install mysql-server mysql-client

# When php-fpm install, php5 will install too.
apt-get -y install php5-fpm

# install php5 module
apt-get -y install php5-cli php5-mcrypt php5-gd

# pairing php-fpm and mysql 
apt-get -y install php5-mysql


#################################
### NginX - PHP collaboration ###
#################################

# 1. change php5-fpm config 
cp /etc/php5/fpm/pool.d/www.conf ./www.conf-original

##### changed infomation ##### 
## ; Note: This value is mandatory.
## ;listen = 127.0.0.1:9000
## listen = /dev/shm/php5-fpm.sock
mv ./www.conf /etc/php5/fpm/pool.d/www.conf

# 2. php5-fpm restart
/etc/init.d/php5-fpm restart

# 3. change nginx config 
cp /etc/nginx/sites-available/default ./default-original

##### changed infomation ##### 
### pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000
##location ~ \.php$ {
##                fastcgi_split_path_info ^(.+\.php)(/.+)$;
##                # NOTE: You should have "cgi.fix_pathinfo = 0;" in php.ini
##
##                # With php5-cgi alone:
##                # fastcgi_pass 127.0.0.1:9000;
##                # With php5-fpm:
##                fastcgi_pass unix:/dev/shm/php5-fpm.sock;
##                fastcgi_index index.php;
##                include fastcgi_params;
##        }
mv ./default /etc/nginx/sites-available/default

# 4. check nginx configuration
nginx -t 

# 5. nginx setting complete and reload
nginx -s reload

#################################
###      install node.js      ###
#################################

# 1. install tools to install node.js
apt-get -y install python-software-properties python g++ make

# 2. install node.js
apt-get -y install nodejs

#################################
###    install node server    ###
#################################
## use recursive plag
cp -r server/ $NGINXROOTPATH

#################################
###    install Web Manager    ###
#################################
## use recursive plag
cp -r www/ $NGINXROOTPATH

fi

echo "########################################"
echo "       Server install script end       "
echo "########################################"