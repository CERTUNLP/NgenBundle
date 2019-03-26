#!/bin/bash

source "/root/.env"

configurarAppKernel(){

    cp "$DEPENDENCIAS_PATH/AppKernel.php" app/

}

configurarApache(){

    if [ -z $APACHE_HOSTNAME ]
       then
       APACHE_HOSTNAME=$(hostname)
    fi

    cp "$DEPENDENCIAS_PATH/ngen.conf" /etc/apache2/sites-available/

    sed -i "s#PATH_TO_WORKSPACE#$PATH_WEB/ngen_basic#g" /etc/apache2/sites-available/ngen.conf ;
    sed -i "s/SERVER_NAME/$APACHE_HOSTNAME/g" /etc/apache2/sites-available/ngen.conf ;

    $SUDO a2enmod rewrite ssl
    $SUDO a2ensite ngen
    $SUDO service apache2 restart

    }

configurarParameters(){
    cp "$DEPENDENCIAS_PATH/parameters.yml" "$PARAMETERS_PATH"

    SEC_TEMPORAL=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1)
    if [ -z $SEC_KEY ]
       then
       SEC_KEY=$SEC_TEMPORAL
    fi

    sed -i "s/DATABASE_IP/$DB_IP/g" "$PARAMETERS_PATH" ;
    sed -i "s/DATABASE_PORT/$DB_PORT/g" "$PARAMETERS_PATH" ;
    sed -i "s/DATABASE_NAME/$DB_NAME/g" "$PARAMETERS_PATH" ;
    sed -i "s/DATABASE_USER/$DB_USER/g" "$PARAMETERS_PATH" ;
    sed -i "s/DATABASE_PASSWORD/$DB_PASSWORD/g" "$PARAMETERS_PATH" ;
    sed -i "s/MAILER_TRANSPORT/$ML_TRANSPORT/g" "$PARAMETERS_PATH" ;
    sed -i "s/MAILER_IP/$ML_IP/g" "$PARAMETERS_PATH" ;
    sed -i "s/MAILER_USER/$ML_USER/g" "$PARAMETERS_PATH" ;
    sed -i "s/MAILER_PASSWORD/$ML_PASSWORD/g" "$PARAMETERS_PATH" ;
    sed -i "s/SECRET_KEY/$SEC_KEY/g" "$PARAMETERS_PATH" ;

    }

instalarElastic(){
    $SUDO wget -qO - https://packages.elastic.co/GPG-KEY-elasticsearch | sudo apt-key add -
    $SUDO echo "deb http://packages.elastic.co/elasticsearch/2.x/debian stable main" | sudo tee -a /etc/apt/sources.list.d/elasticsearch-2.x.list
    # mysql_secure_installation
    $SUDO apt-get update;
    $SUDO apt-get -y install apache2 php5 mysql-client php5-mysql php5-curl curl ant php-apc git elasticsearch
    $SUDO update-rc.d elasticsearch defaults 95 10
    # /app_dev.php/user/login
    # /app_dev.php/incidents/internals
    $SUDO a2dissite 000-default
    }

instalarComposer(){
    curl -sS https://getcomposer.org/installer | $SUDO php
    }

instalarSymfony(){
    $SUDO curl -LsS http://symfony.com/installer -o "$BINARIOS_PATH/symfony"
    $SUDO chmod +x "$BINARIOS_PATH/symfony"
}

instalarNode(){
    curl -sL https://deb.nodesource.com/setup_4.x | $SUDO bash -
    $SUDO apt-get install --yes nodejs
    $SUDO ln -s /usr/bin/nodejs /usr/bin/node
    $SUDO npm install -g less
    }

bajarArchivosTemplates(){
    cd $DEPENDENCIAS_PATH
    wget -q https://raw.githubusercontent.com/CERTUNLP/NgenBundle/master/Resources/installer/dependencias/AppKernel.php
    wget -q https://raw.githubusercontent.com/CERTUNLP/NgenBundle/master/Resources/installer/dependencias/ngen.conf
    wget -q https://raw.githubusercontent.com/CERTUNLP/NgenBundle/master/Resources/installer/dependencias/parameters.yml
    cd $OLDPWD
    }

configurarDependencias(){
    cd $BINARIOS_PATH
    instalarElastic
    instalarComposer
    cd $OLDPWD
    instalarSymfony
    instalarNode
    bajarArchivosTemplates
    }

configurarConfigYML(){
    CONFIGYML_ORIG="$PATH_WEB/ngen_basic/app/config/config.yml"
    CONFIGYML_DEST="$CONFIGYML_ORIG"
    cp "$CONFIGYML_ORIG" "$CONFIGYML_DEST"
    BORRAR="- { resource: security.yml }"
    sed -i "/$BORRAR/d" "$CONFIGYML_DEST"
    BUSCAR="- { resource: services\.yml }"
    REEMPLAZAR="- { resource: services\.yml }\n    - { resource: @CertUnlpNgenBundle\/Resources\/config\/security\.yml }\n    - { resource: @CertUnlpNgenBundle\/Resources\/config\/config\.yml }\n"
    #Rubio aca ver de donde sale el archivo ese, si baja de jitjab o es el de symfony?
    sed -i "s/$BUSCAR/$REEMPLAZAR/g" "$CONFIGYML_DEST"

    if [ -z $DEFAULT_FROM ]
       then
       DEFAULT_FROM="mail@cert.example.com"
    fi
    if [ -z $DEFAULT_NETWORK ]
       then
       DEFAULT_NETWORK="10.0.0.0"
    fi

    if [ -z $SHADOW_USER ]
       then
       SHADOW_USER="mail@cert.example.com"
    fi

    if [ -z $SHADOW_PASS ]
       then
       SHADOW_PASS="mail@cert.example.com"
    fi

    echo "cert_unlp_ngen:
    team:
        mail: $DEFAULT_FROM
    incidents:
        mailer:
           transport: $ML_TRANSPORT
           host:      $ML_IP
           sender_address: $ML_USER@$ML_IP
           username:  $ML_USER
           password:  $ML_PASSWORD
    networks:
        default_network: $DEFAULT_NETWORK
}

configurarRouting(){

    ROUTING_DEST="$PATH_WEB/ngen_basic/app/config/routing.yml"
    echo 'cert_unlp_ngen:
        resource: "@CertUnlpNgenBundle/Resources/config/routing.yml"' > "$ROUTING_DEST";
    }


instalarNgen(){
    cd $PATH_WEB/
    $BINARIOS_PATH/symfony new ngen_basic 2.8
    cd ngen_basic
    php $BINARIOS_PATH/composer.phar require certunlp/ngen-bundle:dev-develop
    php $BINARIOS_PATH/composer.phar update
    configurarParameters
    configurarAppKernel
    configurarConfigYML
    configurarRouting
}

clear
echo "# -----------------------------------------------------------"
echo "# ------------------------- Instalando NGEN------------------"
echo "# -----------------------------------------------------------"

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

DEPENDENCIAS_PATH="$(pwd)/dependencias";
BINARIOS_PATH="$PATH_WEB/binarios";
PARAMETERS_PATH="$PATH_WEB/ngen_basic/app/config/parameters.yml";
mkdir $DEPENDENCIAS_PATH
mkdir -p $BINARIOS_PATH
configurarDependencias
configurarApache
instalarNgen
# Pisamos al archivo app_dev.php
mv /root/app_dev.php $PATH_WEB/ngen_basic/web/
