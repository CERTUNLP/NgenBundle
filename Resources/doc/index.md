CERT UNLP Ngen Bundle
========================

1) Installing
----------------------------------



### Add the routing resource to your appkernel
    new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
    new FOS\RestBundle\FOSRestBundle(),
    new FOS\CommentBundle\FOSCommentBundle(),
    new FOS\ElasticaBundle\FOSElasticaBundle(),
    new JMS\SerializerBundle\JMSSerializerBundle($this),
    new Nelmio\ApiDocBundle\NelmioApiDocBundle(),
    new CertUnlp\NgenBundle\CertUnlpNgenBundle(),
    new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
    new Ddeboer\DataImportBundle\DdeboerDataImportBundle(),
    new Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(),
    new Knp\Bundle\MenuBundle\KnpMenuBundle(),
    new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
    new Braincrafted\Bundle\BootstrapBundle\BraincraftedBootstrapBundle(),
    new Stfalcon\Bundle\TinymceBundle\StfalconTinymceBundle()
### Add the routing resource to your app
    cert_unlp_ngen:
        resource: "@CertUnlpNgenBundle/Resources/config/routing.yml"     

### Import the configuration
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
               #sender_address: # optional cert_unlp.ngen.team.mail by default
           username:  
           password: 
    feeds:
        shadowserver:
            client:
                user: 
                password:

### deploy
    php app/console d:d:c --no-interaction
    php app/console d:s:cx --no-interaction
    php app/console d:f:l --no-interaction
### deploy
    rm -rf app/logs/* app/cache/*;
    setfacl -R -m u:jenkins:rwx -m u:www-data:rwx  app/cache app/logs;
    setfacl -dR -m u:jenkins:rwx -m u:www-data:rwx  app/cache app/logs;
    composer install --optimize-autoloader
    php app/console cache:clear --env=prod --no-debug
    php app/console assetic:dump --env=prod --no-debug
    php app/console assets:install --symlink 
    php -r apc_clear_cache();apc_clear_cache('user');apc_clear_cache('opcode');
    php app/console braincrafted:bootstrap:install
    php app/console braincrafted:bootstrap:generate