# apps

### installation des paquets
```bash
sudo apt install macchanger dig nettools vim git p7zip-full p7zip-rar 
sudo apt install apache2 php php-intl  php-pgsql php-curl php-xdebug php-sqlite3
sudo apt install certbot python3-certbot-apache
```


### configuration du serveur apache

```xml
<VirtualHost *:80>
    ServerName apps.physique.u-paris.fr
    ServerAdmin Olivier.Cardoso@gmail.com
    DocumentRoot /var/www/apps.physique.u-paris.fr/src
    ErrorLog ${APACHE_LOG_DIR}/apps.physique.u-paris.fr/error.log
    CustomLog ${APACHE_LOG_DIR}/apps.physique.u-paris.fr/access.log combined

    RewriteEngine on
    RewriteCond %{SERVER_NAME} =apps.physique.u-paris.fr
    RewriteRule ^ https://%{SERVER_NAME}%{REQUEST_URI} [END,NE,R=permanent]
</VirtualHost>


<VirtualHost *:443>
    ServerName apps.physique.u-paris.fr
    ServerAdmin Olivier.Cardoso@gmail.com
    DocumentRoot /var/www/apps.physique.u-paris.fr/src
    ErrorLog ${APACHE_LOG_DIR}/apps.physique.u-paris.fr/error.log
    CustomLog ${APACHE_LOG_DIR}/apps.physique.u-paris.fr/access.log combined
    Include /etc/letsencrypt/options-ssl-apache.conf
    RewriteEngine on
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule . index.php [L]
    SSLCertificateFile /etc/letsencrypt/live/apps.physique.u-paris.fr/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/apps.physique.u-paris.fr/privkey.pem
</VirtualHost>
```


# installation de composer


```bash
cd ~/tmp
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer
cd ~
```