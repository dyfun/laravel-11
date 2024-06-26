# 1. Uygulama Gereksinimleri
- Composer [*](https://getcomposer.org/)
- Mysql 8.0+ [*](https://dev.mysql.com/downloads/mysql/8.0.26.html)
- PHP 8.2+ [*](https://www.php.net/releases/)
- Nginx [*](https://www.nginx.com/)

# 2. Uygulama Kurulum
### 2.1. Sunucu Kurulumu
- Mevcut işletim sisteminize uygun yazılımları yükleyin: (Ubuntu)
    ```
    # PHP
    sudo apt install php8.2
    sudo apt install php8.2-fpm php8.2-common php8.2-opcache php8.2-cli
    sudo apt install php8.2-gd php8.2-curl php8.2-mysql
    sudo apt install php8.2-xml
    sudo apt install php8.2-mbstring
    sudo apt install zip unzip php8.2-zip
    ```

    ```
    # Composer
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php 
    sudo mv composer.phar /usr/local/bin/composer
    
    # Nginx Web Server
    sudo apt install nginx
    systemctl enable nginx
    
    # Mysql Database
    sudo apt install mysql-server
    sudo mysql_secure_installation
    systemctl start mysql
    systemctl enable mysql

    ```
- __PHP Ayarları:__
    ```shell
    nano /etc/php/8.2/cli/php.ini
    ```
    ```
    upload_max_filesize = 100M
    post_max_size = 100M
    max_file_uploads = 50
    max_execution_time = 60
    memory_limit = 1024M
    expose_php = off
    opcache.max_accelerated_files = 50000
    ```

- __Nginx Ayarları:__
    ```
    nano /etc/nginx/sites-available/task-project
    ```
    ```
    server {
        listen 80;
        root /var/www/task-project/public;
        index index.php index.html index.htm index.nginx-debian.html;
        server_name _;

        location / {
           try_files $uri /index.php$is_args$args;
        }
    
        location ~ \.php$ {
            include snippets/fastcgi-php.conf;
            #fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
            fastcgi_pass 127.0.0.1:9000;
        }
    }
    ```
    ```
    sudo ln -s /etc/nginx/sites-available/task-project /etc/nginx/sites-enabled/
    sudo nginx -t
    sudo systemctl restart nginx
    ```
### 2.2. Uygulamayı Yükleyin
- Uygulama dosyalarını __"/var/www/task-project"__ dizinine kopyalayın ve yeni .env dosyası oluşturup gerekli ayarları girin.
    ```shell
    cd /var/www/task-project
    cp .env.example .env
    nano .env
    ```

- **Kurulumu Başlatın:**
    ```shell
    sudo chown -R www-data:www-data storage
    chmod -R 755 storage
    composer install
    php artisan migrate
    php artisan db:seed
    ```
### 2.3. Docker
- Docker ile uygulamayı çalıştırmak için:
    ```shell
    docker compose up -d --build
    docker compose exec phpmyadmin chmod 777 /sessions
    docker compose exec php bash
    chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache
    composer setup
    ```

# 3. Not
- Kod stili formatlamak için pint [*](https://laravel.com/docs/11.x/pint) kullanılmıştır.
- Docker için starter kit [*](https://github.com/refactorian/laravel-docker) kullanılmıştır.
- Macos üzerinden Valet [*](https://laravel.com/docs/11.x/valet) ile de kullabilirsiniz.

# 4. Öneri
Blogumda [*](https://tayfunguler.org/blog) Laravel ile ilgili içerikler bulabilirsiniz.
