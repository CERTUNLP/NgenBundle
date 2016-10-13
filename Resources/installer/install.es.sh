#!/bin/bash



configurarAppKernel(){

    cp $PATH_WEB/dependencias/installer/AppKernel.php app/

    #~ "new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
    #~ new FOS\RestBundle\FOSRestBundle(),
    #~ new FOS\CommentBundle\FOSCommentBundle(),
    #~ new FOS\ElasticaBundle\FOSElasticaBundle(),
    #~ new JMS\SerializerBundle\JMSSerializerBundle($this),
    #~ new Nelmio\ApiDocBundle\NelmioApiDocBundle(),
    #~ new CertUnlp\NgenBundle\CertUnlpNgenBundle(),
    #~ new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(), //swiftmailer should be here for the conriguration load
    #~ new Ddeboer\DataImportBundle\DdeboerDataImportBundle(),
    #~ new Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(),
    #~ new Knp\Bundle\MenuBundle\KnpMenuBundle(),
    #~ new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
    #~ new Braincrafted\Bundle\BootstrapBundle\BraincraftedBootstrapBundle(),
    #~ new Stfalcon\Bundle\TinymceBundle\StfalconTinymceBundle()"
}

configurarApache(){
    
    read -p "Ingrese el nombre del host. Por defecto: "$(hostname) APACHE_HOSTNAME
    if [ -z $APACHE_HOSTNAME ]
       then
       APACHE_HOSTNAME=$(hostname)
    fi
    
    cp $PATH_WEB/dependencias/installer/ngen.conf /etc/apache2/sites-available/    
    
    sed -i "s/PATH_TO_WORKSPACE/$PATH_WEB/g" /etc/apache2/sites-available/ngen.conf ;   
    sed -i "s/SERVER_NAME/$APACHE_HOSTNAME/g" /etc/apache2/sites-available/ngen.conf ;   
    
    $SUDO a2enmod rewrite ssl
    $SUDO a2ensite ngen
    $SUDO service apache2 restart
    
    }

configurarParameters(){
    cp $PATH_WEB/dependencias/installer/parameters.yml $PATH_WEB/ngen_basic/app/config/parameters.yml
    read -p "Ingrese el host de la base de datos. Por defecto: 127.0.0.1)" DB_IP
    if [ -z $DB_IP ]
       then
       DB_IP="127.0.0.1"
    fi
    read -p "Ingrese el port de la base de datos. Por defecto: 3306)" DB_PORT
    if [ -z $DB_PORT ]
       then
       DB_PORT="3306"
    fi
    read -p "Ingrese el nombre de la base de datos. Por defecto: ngen)" DB_NAME
    if [ -z $DB_NAME ]
       then
       DB_NAME="ngen"
    fi
    read -p "Ingrese el usuario de la base de datos. Por defecto: ngen)" DB_USER
    if [ -z $DB_USER ]
       then
       DB_USER="ngen"
    fi
    read -p "Ingrese el password de la base de datos. Por defecto: ngen)" DB_PASSWORD
    if [ -z $DB_PASSWORD ]
       then
       DB_PASSWORD="ngen"
    fi
    read -p "Ingrese el mail transport. Por defecto: smtp)" ML_TRANSPORT
    if [ -z $ML_TRANSPORT ]
       then
       ML_TRANSPORT="smtp"
    fi
    read -p "Ingrese el servidor de correo. Por defecto: 127.0.0.1)" ML_IP
    if [ -z $ML_IP ]
       then
       ML_IP="127.0.0.1"
    fi
    read -p "Ingrese el usuario de mail. Por defecto: null)" ML_USER
    if [ -z $ML_USER ]
       then
       ML_USER="null"
    fi
    read -p "Ingrese el password para el usuario de mail. Por defecto: null)" ML_PASSWORD
    if [ -z $ML_PASSWORD ]
       then
       ML_PASSWORD="null"
    fi
    SEC_TEMPORAL=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1)
    read -p "Ingrese el token. Por defecto: $SEC_TEMPORAL)" SEC_KEY
    if [ -z $SEC_KEY ]
       then
       SEC_KEY=$SEC_TEMPORAL
    fi
    
    sed -i "s/DATABASE_IP/$DB_IP/g" $PATH_WEB/ngen_basic/app/config/parameters.yml ;
    sed -i "s/DATABASE_PORT/$DB_PORT/g" $PATH_WEB/ngen_basic/app/config/parameters.yml ;
    sed -i "s/DATABASE_NAME/$DB_NAME/g" $PATH_WEB/ngen_basic/app/config/parameters.yml ;
    sed -i "s/DATABASE_USER/$DB_USER/g" $PATH_WEB/ngen_basic/app/config/parameters.yml ;
    sed -i "s/DATABASE_PASSWORD/$DB_PASSWORD/g" $PATH_WEB/ngen_basic/app/config/parameters.yml ;
    sed -i "s/MAILER_TRANSPORT/$ML_TRANSPORT/g" $PATH_WEB/ngen_basic/app/config/parameters.yml ;
    sed -i "s/MAILER_IP/$ML_IP/g" $PATH_WEB/ngen_basic/app/config/parameters.yml ;
    sed -i "s/MAILER_USER/$ML_USER/g" $PATH_WEB/ngen_basic/app/config/parameters.yml ;
    sed -i "s/MAILER_PASSWORD/$ML_PASSWORD/g" $PATH_WEB/ngen_basic/app/config/parameters.yml ;
    sed -i "s/SECRET_KEY/$SEC_KEY/g" $PATH_WEB/ngen_basic/app/config/parameters.yml ;
    
    }

instalarElastic(){
    $SUDO wget -qO - https://packages.elastic.co/GPG-KEY-elasticsearch | sudo apt-key add -
    $SUDO echo "deb http://packages.elastic.co/elasticsearch/2.x/debian stable main" | sudo tee -a /etc/apt/sources.list.d/elasticsearch-2.x.list
    $SUDO apt-get update;
    $SUDO apt-get install apache2 php5 mysql-server php5-mysql php5-curl curl ant php-apc git elasticsearch
    $SUDO update-rc.d elasticsearch defaults 95 10
    }
    
instalarComposer(){
    curl -sS https://getcomposer.org/installer | $SUDO php
    }
    
instalarSymfony(){
    $SUDO curl -LsS http://symfony.com/installer -o ../binarios/symfony
    $SUDO chmod +x ../binarios/symfony
}

instalarNode(){
    curl -sL https://deb.nodesource.com/setup_4.x | $SUDO bash -
    $SUDO apt-get install --yes nodejs
    $SUDO ln -s /usr/bin/nodejs /usr/bin/node
    $SUDO npm install -g less
    }
    
configurarDependencias(){
    cd $PATH_WEB/dependencias
    cd ../binarios
    instalarElastic
    instalarComposer
    cd $OLDPWD
    instalarSymfony
    instalarNode
    }
    
deployNgen(){
    #~ ### deploy
    php app/console d:d:c --no-interaction
    php app/console d:s:c --no-interaction
    php app/console d:f:l --no-interaction
    ### deploy
    rm -rf app/logs/* app/cache/*;
    setfacl -R -m u:<user>:rwx -m u:www-data:rwx  app/cache app/logs  app/Resources/feed/ app/Resources/incident/;
    setfacl -dR -m u:<user>:rwx -m u:www-data:rwx  app/cache app/logs  app/Resources/feed/ app/Resources/incident/;
    php ../binarios/composer.phar install --optimize-autoloader
    php app/console cache:clear --env=prod --no-debug
    php app/console assetic:dump --env=prod --no-debug
    php app/console assets:install --symlink 
    php -r "apc_clear_cache(); apc_clear_cache('user');apc_clear_cache('opcode');";
    php app/console braincrafted:bootstrap:install
    php app/console braincrafted:bootstrap:generate
    
    }    
    
instalarNgen(){
    ./binarios/symfony new ngen_basic 2.8
    cd ngen_basic
    php ../binarios/composer.phar require certunlp/ngen-bundle:dev-master
    php ../binarios/composer.phar update
    configurarParameters
    configurarAppKernel
    deployNgen
}
    
clear
echo "# -----------------------------------------------------------"
echo "# ------------------------- Instalando NGEN------------------"
echo "# -----------------------------------------------------------"

echo "Este instalador está pensado para Linux basados en Debian y va a necesitar instalar varias dependencias"
echo "Tenga en cuenta que si en este equipo tiene otras aplicaciones eventualmente podría interferir" 
echo "¿Está seguro que quiere continuar?"
        select sn in "Si" "No"; do
            case $sn in
                Si ) echo "Allá vamos!";
                        METELE=1;
                        break;;
                No ) METELE=0;
                        echo "Decidió cancelar el instalador automático!";
                        exit;
                        break;;
            esac
        done

read -p "Ingrese la carpeta donde quiere que se aloje NGEN:(Por defecto: /var/www/ngen)" PATH_WEB

if [ -z $PATH_WEB ]
       then
       PATH_WEB="/var/www/ngen"
fi

echo "Instalando los paquetes necesarios. Necesitaremos ser root o utilizar sudo"

if [[ $UID != 0 ]]; then
    if type sudo2 2>/dev/null; then
        echo "Somos sudo"
        SUDO=sudo
    else
        echo "ERROR: Por favor o hacete root o instala sudo para correr el script!";
        METELE=0;
    fi
    else
     echo "WARNING: Corriendo como root el script;"
fi


if [[ $METELE != 0 ]]; then
    mkdir -p $PATH_WEB/dependencias;
    mkdir -p $PATH_WEB/binarios
    configurarDependencias
    cd $PATH_WEB
    instalarNgen
    configurarApache
    
fi;



    
#~ ### Add the routing resource to your app/config/routing.yml
    #~ cert_unlp_ngen:
        #~ resource: "@CertUnlpNgenBundle/Resources/config/routing.yml"     
#~ 
#~ ### Import the configuration to app/config/config.yml
    #~ 
    #~ #if you import the security.yml of NgenBundle you must remove the security.yml of symfony.
    #~ #Either, you can mix both security.yml
    #~ imports:
        #~ - { resource: @CertUnlpNgenBundle/Resources/config/security.yml }
        #~ - { resource: @CertUnlpNgenBundle/Resources/config/config.yml }
#~ 
    #~ cert_unlp_ngen:
        #~ team:
            #~ mail: #mail of the cert
        #~ incidents:    
            #~ mailer:
               #~ transport: smtp
               #~ host:      
               #~ #sender_address: #optional, cert_unlp.ngen.team.mail will be used by default
               #~ username:  
               #~ password: 
#~ 
