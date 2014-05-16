#!/sh/bin


# NGINXROOTPATH = "/usr/share/nginx/html/"
# NGINXCONFIGPATH = "/etc/nginx/sites-available/default"
# PHPPATH = ""


echo "########################################"
echo "      Server install script start      "
echo "########################################"

#################################
###       clone project       ###
#################################

## Before install.... do this!

## sudo apt-get install git
## git clone https://github.com/imsukmin/GamjaChip.git


#################################
###    Register tool's ppa    ###
#################################
# 1. add repository of NginX
sudo add-apt-repository -y ppa:nginx/development

# 2. add repository of node.js
sudo add-apt-repository -y ppa:chris-lea/node.js

# 3. apply ppa
sudo apt-get update

#################################
###       install NginX       ###
#################################

# aptitude ==> install tool seems like apt-get
sudo apt-get install aptitude
sudo aptitude install software-properties-common
sudo apt-get install nginx

#################################
###  install MySql and php5   ###
#################################

sudo apt-get install mysql-server mysql-client

# php-fpm 설치시 의존성으로 php5 가 설치된다.
$ sudo apt-get install php5-fpm

# php5 모듈 설치
$ sudo apt-get install php5-cli php5-mcrypt php5-gd

# php-fpm 과 mysql 연동
$ sudo apt-get install php5-mysql


#################################
### NginX - PHP collaboration ###
#################################

# 2. change php5-fpm config 
sudo cp /etc/php5/fpm/pool.d/www.conf ./www.conf-original

##### changed infomation ##### 
## ; Note: This value is mandatory.
## ;listen = 127.0.0.1:9000
## listen = /dev/shm/php5-fpm.sock
sudo mv ./www.conf /etc/php5/fpm/pool.d/www.conf

# 3. php5-fpm restart
sudo /etc/init.d/php5-fpm restart

# 4. change nginx config 
sudo cp /etc/nginx/sites-available/default ./default-original

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
sudo mv ./default /etc/nginx/sites-available/default

# 5. check nginx configuration
sudo nginx -t 

# 6. nginx setting complete and reload
sudo nginx -s reload

#################################
###      install node.js      ###
#################################

# 1. install tools to install node.js
sudo apt-get install python-software-properties python g++ make

# 2. install node.js
sudo apt-get install nodejs

#################################
###    install node server    ###
#################################
cp ./server $NGINXROOTPATH

#################################
###    install Web Manager    ###
#################################
cp ./www $NGINXROOTPATH



