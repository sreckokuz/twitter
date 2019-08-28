# Remove symlink
sudo rm -R /var/www/twitter_old && \
sudo cp -R /var/www/twitter_current /var/www/twitter_old/ && \
sudo rm /var/www/twitter && \
sudo rm -R /var/www/twitter_current && \
# Create symlink to older version && \
sudo ln -s /var/www/twitter_old /var/www/twitter