# Use Alpine for minimal size
FROM alpine:3.20

# Install packages: PHP-FPM, MySQL, Supervisor, and dependencies
RUN apk add --no-cache \
    php82 php82-fpm php82-mysqli php82-json php82-session php82-mbstring php82-xml php82-curl php82-zip php82-gd \
    mysql mysql-client \
    supervisor \
    curl unzip \
    git

# Clone Advaita repo into /var/www/html/Advaita
RUN git clone https://github.com/Ranjan-Shettigar/Advaita.git /var/www/html/Advaita && \
    cp -r /var/www/html/Advaita/* /var/www/html/ && \
    chown -R nobody:nobody /var/www/html && \
    chmod -R 755 /var/www/html

# Configure PHP-FPM
RUN sed -i 's|listen = 127.0.0.1:9000|listen = 0.0.0.0:9000|' /etc/php82/php-fpm.d/www.conf && \
    sed -i 's|;listen.mode = 0660|listen.mode = 0666|' /etc/php82/php-fpm.d/www.conf && \
    sed -i 's|user = .*$|user = nobody|' /etc/php82/php-fpm.d/www.conf && \
    sed -i 's|group = .*$|group = nobody|' /etc/php82/php-fpm.d/www.conf

# Configure Supervisor
COPY supervisord.conf /etc/supervisord.conf

# Configure MySQL
RUN mkdir -p /var/lib/mysql /run/mysqld && \
    chown -R mysql:mysql /var/lib/mysql /run/mysqld && \
    mysql_install_db --user=mysql --datadir=/var/lib/mysql

# Import Advaita/database.sql into MySQL
RUN mysqld_safe --datadir=/var/lib/mysql & \
    sleep 5 && \
    mysql -u root < /var/www/html/Advaita/database.sql && \
    killall mysqld || true

# Expose PHP built-in server port
EXPOSE 7860

# Entrypoint
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]