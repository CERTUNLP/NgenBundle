CERT UNLP Ngen Bundle
========================

1) Installing
----------------------------------



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