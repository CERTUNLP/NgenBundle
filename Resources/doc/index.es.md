CERT UNLP Ngen Bundle
========================

Requerimientos:
---------------

    sudo apt-get install apache2 php5 mysql-server php5-mysql php5-curl curl ant php-apc git 
    curl -sS https://getcomposer.org/installer | sudo php
    sudo curl -LsS http://symfony.com/installer -o /usr/local/app/symfony
    sudo a2enmod rewrite ssl

    wget -qO - https://packages.elastic.co/GPG-KEY-elasticsearch | sudo apt-key add -
    echo "deb http://packages.elastic.co/elasticsearch/2.x/debian stable main" | sudo tee -a /etc/apt/sources.list.d/elasticsearch-2.x.list
    sudo apt-get update && sudo apt-get install elasticsearch
    sudo update-rc.d elasticsearch defaults 95 10
    
    curl -sL https://deb.nodesource.com/setup_5.x | sudo -E bash -
    sudo apt-get install --yes nodejs
    sudo ln -s /usr/bin/nodejs /usr/bin/node

    sudo npm install -g less

1) Installing
----------------------------------
### Add the ngen bundle in composer.json
    
        "require": {
        ...
        ...
        "certunlp/ngen-bundle": "~ 0.1.0.0",
        ...
        },
        ...

### Install vendors
    $ composer install
    $ composer update

### Configure apache virtualhost
#### Basic config
    <VirtualHost *:80>
        ServerAdmin     cert@cert.com
        ServerName      ngen.com
        ServerAlias     ngen.com 
        DocumentRoot "$(PATH_TO_WORKSPACE)/web"
        RewriteEngine On
        <Directory "$(PATH_TO_WORKSPACE)/web">
            # enable the .htaccess rewrites
            Options Indexes FollowSymLinks MultiViews
            AllowOverride All
            Order allow,deny
            Allow from All
        </Directory>
    </VirtualHost>

### Edit app/config/parameters.yml
#### add your DB config
#### create the database_user manually 
    parameters:
        database_host: 127.0.0.1
        database_port: null
        database_name: symfony
        database_user: root
        database_password: null
        mailer_transport: smtp
        mailer_host: 127.0.0.1
        mailer_user: null
        mailer_password: null
        secret: b9622e02c564144683568d638137aed04f61359c


### Add the routing resource to your app/AppKernel.php
    new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
    new FOS\RestBundle\FOSRestBundle(),
    new FOS\CommentBundle\FOSCommentBundle(),
    new FOS\ElasticaBundle\FOSElasticaBundle(),
    new JMS\SerializerBundle\JMSSerializerBundle($this),
    new Nelmio\ApiDocBundle\NelmioApiDocBundle(),
    new CertUnlp\NgenBundle\CertUnlpNgenBundle(),
    new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(), //swiftmailer should be here for the conriguration load
    new Ddeboer\DataImportBundle\DdeboerDataImportBundle(),
    new Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(),
    new Knp\Bundle\MenuBundle\KnpMenuBundle(),
    new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
    new Braincrafted\Bundle\BootstrapBundle\BraincraftedBootstrapBundle(),
    new Stfalcon\Bundle\TinymceBundle\StfalconTinymceBundle()
    
### Add the routing resource to your app/config/routing.yml
    cert_unlp_ngen:
        resource: "@CertUnlpNgenBundle/Resources/config/routing.yml"     

### Import the configuration to app/config/config.yml
    
    #if you import the security.yml of NgenBundle you must remove the security.yml of symfony.
    #Either, you can mix both security.yml
    imports:
        - { resource: @CertUnlpNgenBundle/Resources/config/security.yml }
        - { resource: @CertUnlpNgenBundle/Resources/config/config.yml }

    cert_unlp_ngen:
        team:
            mail: #mail of the cert
        incidents:    
            mailer:
               transport: smtp
               host:      
               #sender_address: #optional, cert_unlp.ngen.team.mail will be used by default
               username:  
               password: 

### deploy
    php app/console d:d:c --no-interaction
    php app/console d:s:c --no-interaction
    php app/console d:f:l --no-interaction
### deploy
    rm -rf app/logs/* app/cache/*;

    setfacl -R -m u:<user>:rwx -m u:www-data:rwx  app/cache app/logs  app/Resources/feed/ app/Resources/incident/;
    setfacl -dR -m u:<user>:rwx -m u:www-data:rwx  app/cache app/logs  app/Resources/feed/ app/Resources/incident/;
    composer install --optimize-autoloader
    php app/console cache:clear --env=prod --no-debug
    php app/console assetic:dump --env=prod --no-debug
    php app/console assets:install --symlink 
    php -r "apc_clear_cache(); apc_clear_cache('user');apc_clear_cache('opcode');";
    php app/console braincrafted:bootstrap:install
    php app/console braincrafted:bootstrap:generate
