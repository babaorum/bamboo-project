VHOST :

  $ sudo nano /etc/apache2/sites-available/bamboo-project.dev


    <VirtualHost *:80>
                ServerAdmin webmaster@localhost
                ServerName bamboo-project.dev
                ServerAlias www.bamboo-project.dev

                DocumentRoot /var/www/bamboo-project
                <Directory /var/www/bamboo-project>
                        Options Indexes FollowSymLinks MultiViews
                        AllowOverride All
                        Order allow,deny
                        allow from all
                </Directory>

                ScriptAlias /cgi-bin/ /usr/lib/cgi-bin/

                ErrorLog ${APACHE_LOG_DIR}/error.log

                # Possible values include: debug, info, notice, warn, error, crit,
                # alert, emerg.
                LogLevel warn

                CustomLog ${APACHE_LOG_DIR}/access.log combined
        </VirtualHost>

####

    $ sudo a2ensite bamboo-project.dev
    $ sudo service apache2 reload

####

Host to add (Windows ou Mac) AND VM :

    127.0.0.1       bamboo-project.dev

path VM :

    sudo nano /etc/hosts