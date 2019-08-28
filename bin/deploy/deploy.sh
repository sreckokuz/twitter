sudo rm /var/www/twitter && \
sudo ln -s /var/www/twitter_current /var/www/twitter && \
cd /var/www/twitter && \
sudo APP_ENV=$APP_ENV DATABASE_URL=$DATABASE_URL php bin/console doctrine:migrations:migrate --no-interaction && \
sudo chown -R www-data:www-data /var/www/twitter_current && \
sudo chown -h www-data:www-data /var/www/twitter && \
sudo service apache2 restart
