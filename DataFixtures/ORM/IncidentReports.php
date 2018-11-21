<?php
/*
 * This file is part of the Ngen - CSIRT Incident Report System.
 *
 * (c) CERT UNLP <support@cert.unlp.edu.ar>
 *
 * This source file is subject to the GPL v3.0 license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CertUnlp\NgenBundle\DataFixtures\ORM;

use CertUnlp\NgenBundle\Entity\Incident\IncidentReport;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class IncidentReports extends AbstractFixture implements OrderedFixtureInterface
{

    public function getOrder()
    {
        return 1;
    }


    public function load(ObjectManager $manager)
    {

        $incident_reports = $this->getIncidentReports();
        $incidentTypeRepository = $manager->getRepository('CertUnlpNgenBundle:IncidentType');
        foreach ($incident_reports as $incident_report) {
            $newIncidentReport = new IncidentReport();
            foreach ($incident_report as $key => $value) {
                if ($key == 'type') {
                    $newIncidentReport->setType($incidentTypeRepository->findOneBySlug($value));
                } else {
                    if ($key != 'updated_at' && $key != 'created_at') {
                        $method = 'set' . preg_replace_callback('/[-_](.)/', function ($matches) {
                                return strtoupper($matches[1]);
                            }, $key);;
                        $newIncidentReport->$method($incident_report[$key]);
                    }
                }

            }

            $manager->persist($newIncidentReport);
            $manager->flush();
        }

    }

    private function getIncidentReports()
    {
        return array(
            array('lang' => 'en', 'type' => 'blacklist', 'slug' => 'blacklist-en',
                'problem' => 'We would like to inform you that we have detected that the <em>host</em> {{incident.hostAddress}} under your administration has been detected in blacklists. For more information please view the attached file.',
                'derivated_problem' => 'Emails sent to certain destinations could be filtered if they contain the IP  {{incident.hostAddress}}.', 'verification' => 'You can verify the existence of you IP in different blacklists accessing the following site

<div class = "destacated">

<pre><code>http://whatismyipaddress.com/blacklist-check
</code></pre>

</div>', 'recomendations' => 'We suggest you to access the corresponding pages to remove those hosts.', 'more_information' => NULL, 'is_active' => '1', 'created_at' => '2017-12-21 11:57:57', 'updated_at' => '2017-12-21 11:57:57'),
            array('lang' => 'es', 'type' => 'blacklist', 'slug' => 'blacklist-es', 'problem' => 'Nos comunicamos con usted para informarle que hemos detectado que el Host {{incident.hostAddress}} el cual esta bajo su administración, ha sido detectado en blacklists, las cuales se encuentran en el archivo adjunto.', 'derivated_problem' => 'Servicios brindados por la IP {{incident.hostAddress}} puede verse afectados por la existencia de dicha IP en la blacklist reportada.', 'verification' => 'Puede comprobar la existencia de su IP en diferentes blacklist consultando el sitio

<div class="destacated">

<pre><code>http://whatismyipaddress.com/blacklist-check
</code></pre>

</div>', 'recomendations' => 'Le sugerimos acceder a las páginas correspondientes para eliminar dichos hosts de las mismas.', 'more_information' => NULL, 'is_active' => '1', 'created_at' => '2017-12-21 11:57:52', 'updated_at' => '2017-12-21 11:57:52'),
            array('lang' => 'en', 'type' => 'botnet', 'slug' => 'botnet-en', 'problem' => 'We would like to inform you that we have detected that the <em>host</em> {{incident.hostAddress}} is currently infected with malware and part of a BotNet.', 'derivated_problem' => 'The consequences of the host being infected may vary, we can list the following:

<ul>
<li><p>Excessive consumption of bandwidth by the host.</p></li>
<li><p>Compromising other hosts.</p></li>
<li><p>Compromising user information.</p></li>
<li><p>etc</p></li>
</ul>', 'verification' => 'The verification can be achieved analyzing the existing network traffic of the infected host or network, using tools such as:

<div class = "destacated">

<pre><code>tcpdump
</code></pre>

</div>

or

<div class = "destacated">

<pre><code>wireshark
</code></pre>

</div>', 'recomendations' => 'The network traffic should be filtered until the problem is solved.', 'more_information' => '<div class = "destacated">

<ul>
<li><p><a href="http://www.linuxjournal.com/magazine/detecting-botnets">http://www.linuxjournal.com/magazine/detecting-botnets</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:57', 'updated_at' => '2017-12-21 11:57:57'),
            array('lang' => 'es', 'type' => 'botnet', 'slug' => 'botnet-es', 'problem' => 'Nos comunicamos con Ud. para informarle que se detectó que el host {{incident.hostAddress}} se encuentra infectado con un malware el cual participa en la formación de una Botnet.', 'derivated_problem' => 'Encontrándose infectado el equipo, existen diversas consecuencias entre las que podemos listas:

<ul>
<li><p>Consumo excesivo del ancho de banda por parte del host.</p></li>
<li><p>Compromiso de otros equipos.</p></li>
<li><p>Compromiso de información propia de los usuarios.</p></li>
<li><p>etc</p></li>
</ul>', 'verification' => 'Se puede realizar una verificación del problema a través del análisis del tráfico existente en la red o sobre el host afectado, utilizando herramientas como 

<div class="destacated">

<pre><code>tcpdump
</code></pre>

</div>

o 

<div class="destacated">

<pre><code>wireshark
</code></pre>

</div>', 'recomendations' => 'Se recomienda el filtrado del tráfico hasta que el problema se vea resultó.', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="http://www.linuxjournal.com/magazine/detecting-botnets">http://www.linuxjournal.com/magazine/detecting-botnets</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:52', 'updated_at' => '2017-12-21 11:57:52'),
            array('lang' => 'en', 'type' => 'bruteforce', 'slug' => 'bruteforce-en', 'problem' => 'We would like to inform you that we have detected that the <em>host</em> {{incident.hostAddress}} is involved in brute forcing attacks, most likely due the host being compromised.', 'derivated_problem' => 'This type of attacks are commonly linked to a malware trying to infect other devices inside or outside the network, or possibly an attacker realizing a network scan. Whichever the case, there direct consequences are:

<ul>
<li><p>Excessive consumption of bandwidth by the host.</p></li>
<li><p>Compromising other hosts.</p></li>
<li><p>etc</p></li>
</ul>', 'verification' => 'The verification can be achieved analyzing the existing network traffic of the infected host or network, using tools such as:

<div class = "destacated">

<pre><code>tcpdump
</code></pre>

</div>

or

<div class = "destacated">

<pre><code>wireshark
</code></pre>

</div>', 'recomendations' => 'The network traffic should be filtered until the problem is solved.
Attached to this email you can find the connection logs to identify the malicious activity.', 'more_information' => '<div class = "destacated">

<ul>
<li><p><a href="http://www.securityweek.com/exercising-alternatives-detect-and-prevent-brute-force-attacks">http://www.securityweek.com/exercising-alternatives-detect-and-prevent-brute-force-attacks</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:57', 'updated_at' => '2017-12-21 11:57:57'),
            array('lang' => 'es', 'type' => 'bruteforce', 'slug' => 'bruteforce-es', 'problem' => 'Se detectaron ataques de fuerza bruta provenientes del host {{incident.hostAddress}}, los cuales probablemente se deban a que el equipo ha sido comprometido.', 'derivated_problem' => 'Este tipo de ataques suelen estar vinculados a un malware que busca infectar otros dispositivos, de la red o no, o a un atacante que utiliza el mismo para realizar un reconocimiento de la red.
En cualquiera de los dos casos, existen consecuencias directas de su realización:

<ul>
<li><p>Consumo excesivo del ancho de banda por parte del host</p></li>
<li><p>Compromiso de otros equipos</p></li>
<li><p>etc</p></li>
</ul>', 'verification' => 'Se puede realizar una verificación del problema a través del análisis del tráfico existente en la red o sobre el host afectado, utilizando herramientas como 

<div class="destacated">

<pre><code>tcpdump
</code></pre>

</div>

o 

<div class="destacated">

<pre><code>wireshark
</code></pre>

</div>', 'recomendations' => 'Adjunto le enviamos logs de conexiones para que pueda identificar la actividad maliciosa del host.
Se recomienda el filtrado del tráfico hasta que el problema se vea resultó.', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="http://www.securityweek.com/exercising-alternatives-detect-and-prevent-brute-force-attacks">http://www.securityweek.com/exercising-alternatives-detect-and-prevent-brute-force-attacks</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:52', 'updated_at' => '2017-12-21 11:57:52'),
            array('lang' => 'en', 'type' => 'cisco_smart_install', 'slug' => 'cisco_smart_install-en', 'problem' => 'This report identifies hosts that have the Cisco Smart Install feature running and accessible to the internet at large. This feature can be used to read or potentially modify a switch\'s configuration.', 'derivated_problem' => 'Information leaking, modify configuration, update firmware and even run commands.', 'verification' => 'Test with Nmap at port 4786. There is more tools to exploit this vulnerability. From swith you can use command `show vstack config` to test if feature is enabled.', 'recomendations' => 'If customers find devices in their network that continue to have the Smart Install feature enabled, Cisco strongly recommends that they disable the Smart Install feature with the no vstack configuration command.

Otherwise, customers should apply the appropriate security controls for the Smart Install feature and their environment. The recommendations noted below and in the Security response will avoid the risk of attackers abusing this feature.', 'more_information' => 'More details can be found on Cisco\'s PSIRT blog. https://blogs.cisco.com/security/cisco-psirt-mitigating-and-detecting-potential-abuse-of-cisco-smart-install-feature', 'is_active' => '1', 'created_at' => '2018-02-01 15:47:21', 'updated_at' => '2018-02-01 15:47:21'),
            array('lang' => 'es', 'type' => 'cisco_smart_install', 'slug' => 'cisco_smart_install-es', 'problem' => 'Lo contactamos porque hemos sido informados que el dispositivo con IP {{incident.hostAddress}} tiene habilitado y accesible desde internet la característica "Cisco Smart Install".', 'derivated_problem' => 'Podría ser posible leer y modificar la configuración del dispositivo, actualizar el firmware e incluso ejecutar comandos.', 'verification' => 'Realizar un Nmap al puerto 4786. Tener en cuenta que existen otras herramientas desarrolladas para explotar esta vulnerabilidad.
Desde el switch se puede utilizar el comando `show vstack config` para verificar si se encuentra habilitado.', 'recomendations' => 'Deshabilitar la caracteristica "Smart Install" con el comando `no vstack`', 'more_information' => 'https://blogs.cisco.com/security/cisco-psirt-mitigating-and-detecting-potential-abuse-of-cisco-smart-install-feature', 'is_active' => '1', 'created_at' => '2018-02-01 15:36:19', 'updated_at' => '2018-02-01 15:39:36'),
            array('lang' => 'en', 'type' => 'copyright', 'slug' => 'copyright-en', 'problem' => 'We have been notified that the <em>host</em> {{incident.hostAddress}} is distributing copyrighted material. This is due to an improper use of a P2P network.', 'derivated_problem' => 'Legal actions could be taken against the owner of the host responsible.', 'verification' => NULL, 'recomendations' => 'The corresponding network traffic should be filtered to solve this problem. If this is not possible, forward the issue to the corresponding users.

Attached to this email you can find a copy of the report we have received.', 'more_information' => NULL, 'is_active' => '1', 'created_at' => '2017-12-21 11:57:57', 'updated_at' => '2017-12-21 11:57:57'),
            array('lang' => 'es', 'type' => 'copyright', 'slug' => 'copyright-es', 'problem' => 'Nos notificaron que el host {{incident.hostAddress}} está distribuyendo material con copyright. Esto se debe probablemente a que se está utilizando indebidamente una red P2P.', 'derivated_problem' => 'La recepción de acciones legales tomadas contra el responsable del host.', 'verification' => NULL, 'recomendations' => 'La solución a este incidente consiste en filtrar este tipo de tráfico o, en caso de no ser posible, trasladar la inquietud a los usuarios para que estén al tanto de estas notificaciones.

Adjunto le enviamos una copia del informe que recibimos.', 'more_information' => NULL, 'is_active' => '1', 'created_at' => '2017-12-21 11:57:52', 'updated_at' => '2017-12-21 11:57:52'),
            array('lang' => 'en', 'type' => 'data_breach', 'slug' => 'data_breach-en', 'problem' => 'Data Breach', 'derivated_problem' => 'A data breach is the intentional or unintentional release of secure or private/confidential information to an untrusted environment. Other terms for this phenomenon include unintentional information disclosure, data leak and also data spill. For example username and password exposed.', 'verification' => 'Check evidence', 'recomendations' => '* Invalidate data exposed, for example force users to change credenetials.
* Check in the logs if for the compromised data had been used.
* Ask the publisher to remove the leakage information', 'more_information' => '* Check for compromised data in: https://haveibeenpwned.com/', 'is_active' => '1', 'created_at' => '2018-05-03 13:28:52', 'updated_at' => '2018-05-03 13:28:52'),
            array('lang' => 'es', 'type' => 'data_breach', 'slug' => 'data_breach-es', 'problem' => 'Fuga de información.', 'derivated_problem' => 'Pueden verse comprometidas datos sensibles del usuario. Un ejemplo son las credenciales de usuario (username y password) que apliquen a otros sistemas ante una fuga de información.', 'verification' => 'Revisar la evidencia que se adjunta.', 'recomendations' => '* Invalidar los datos relacionados a la fuga de datos. Por ejemplo forzando el cambio de contraseña
* Revisar los accesos realizados con los datos
* Solicitar al que esta publicando los datos que remueva la publicación', 'more_information' => 'Puede chequear adicionalmente: https://haveibeenpwned.com/', 'is_active' => '1', 'created_at' => '2018-05-03 13:30:56', 'updated_at' => '2018-05-03 13:30:56'),
            array('lang' => 'en', 'type' => 'deface', 'slug' => 'deface-en', 'problem' => 'We would like to inform you that we have detected that web page hosted with IP {{incident.hostAddress}} has suffered a defacement\'s attack. This is an attack on a website that changes the visual appearance of the site or a webpage performed by an attacker.', 'derivated_problem' => 'The changes in the existing information of the server indicates that the attackers succeeded to obtain restricted privileges on the server. As a result, the server may be exposed to other types of problems, such as:

<ul>
<li><p>Malware.</p></li>
<li><p>Be used to perform more sophisticated attacks.</p></li>
<li><p>Obtaining more privileges.</p></li>
<li><p>etc.</p></li>
</ul>', 'verification' => 'The defacement\'s attack can be observed in the URL

<div class = "destacated">

<pre><code>http://{{incident.hostAddress}}/
</code></pre>

</div>', 'recomendations' => 'We recommend a forensic analysis on the involved server to obtain information about the source of the problem and it\'s extent. On the other hand, we recommend a penetration test analysis over the involved site, which allows early problem identification that could lead to similar situations.', 'more_information' => NULL, 'is_active' => '1', 'created_at' => '2017-12-21 11:57:58', 'updated_at' => '2017-12-21 11:57:58'),
            array('lang' => 'es', 'type' => 'deface', 'slug' => 'deface-es', 'problem' => 'Nos ponemos en contacto con Ud. para informarle que el sitio web que se encuentra en {{incident.hostAddress}} sufrió un ataque de defacement, el cual consiste en la modificación del contenido propio del portal por terceros.', 'derivated_problem' => 'La modificación de la información existente en el servidor indica la obtención de privilegios sobre el mismo por parte de los atacantes. A raíz de esta situación, el servidor puede encontrarse expuesto a otros tipos de problemas, como ser:

<ul>
<li><p>Alojamiento de malware.</p></li>
<li><p>Servir como origen de ataques más sofisticados.</p></li>
<li><p>Obtención de mayores privilegios sobre el mismo.</p></li>
<li><p>etc.</p></li>
</ul>', 'verification' => 'El defacement puede ser observado a través de la URL 

<div class="destacated">

<pre><code>http://{{incident.hostAddress}}/
</code></pre>

</div>', 'recomendations' => 'Se recomienda la realización de una forensia sobre el servidor con el objetivo de conocer el origen del problema como así también el alcance del ataque. Por otro lado, se recomienda la realización de un pentest sobre el sitio afectado, el cual permitirá la identificación temprana de otros problemas que podrían derivar en situaciones similares a la presente.', 'more_information' => NULL, 'is_active' => '1', 'created_at' => '2017-12-21 11:57:52', 'updated_at' => '2018-05-24 10:59:50'),
            array('lang' => 'en', 'type' => 'dns_zone_transfer', 'slug' => 'dns_zone_transfer-en', 'problem' => 'LWe would like to inform you that we have detected that the DNS <em>server</em> with IP {{incident.hostAddress}} has zone transfer active in some zones, visible at least from our CERT network.', 'derivated_problem' => '<p class="lead">Problemas derivados</p>

The <em>server</em> under your administration could be used in DNS amplification attacks.', 'verification' => 'Use the following command:

<div class = "destacated">

<pre><code>dig &lt;zona&gt;.unlp.edu.ar @{{incident.hostAddress}} axfr
</code></pre>

</div>', 'recomendations' => 'We recommend establishing restrictions to the DNS server allowing zone queries only from secondary DNS servers.', 'more_information' => '<div class = "destacated">

<ul>
<li><p><a href="http://www.sans.org/reading_room/whitepapers/dns/securing-dns-zone-transfer_868">http://www.sans.org/reading_room/whitepapers/dns/securing-dns-zone-transfer_868</a></p></li>
<li><p><a href="http://www.sans.org/reading_room/whitepapers/dns/securing-dns-zone-transfer_868">http://www.esdebian.org/wiki/transferencias-zonas-bind9</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:58', 'updated_at' => '2017-12-21 11:57:58'),
            array('lang' => 'es', 'type' => 'dns_zone_transfer', 'slug' => 'dns_zone_transfer-es', 'problem' => 'Lo contactamos porque hemos detectado que el servidor DNS con IP {{incident.hostAddress}}
tiene habilitada la transferencia de alguna de sus zonas, al menos desde la
red de nuestro CERT.', 'derivated_problem' => 'El host bajo su administración podría llegar a ser usado en ataques de
amplificación DNS.', 'verification' => 'Utilizando el comando:

<div class="destacated">

<pre><code>dig &lt;zona&gt;.unlp.edu.ar @{{incident.hostAddress}} axfr
</code></pre>

</div>', 'recomendations' => 'Se recomienda establecer restricciones en el servidor DNS que permitan la
consultas de requerimiento de zona solo desde los servidores DNS secundarios.', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="http://www.sans.org/reading_room/whitepapers/dns/securing-dns-zone-transfer_868">http://www.sans.org/reading_room/whitepapers/dns/securing-dns-zone-transfer_868</a></p></li>
<li><p><a href="http://www.sans.org/reading_room/whitepapers/dns/securing-dns-zone-transfer_868">http://www.esdebian.org/wiki/transferencias-zonas-bind9</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:52', 'updated_at' => '2017-12-21 11:57:52'),
            array('lang' => 'en', 'type' => 'dos_chargen', 'slug' => 'dos_chargen-en', 'problem' => 'We would like to inform you that we have been notified that the <em>host</em> {{incident.hostAddress}} is being used to perform Denial of Service attacks (DOS), through the <strong>chargen</strong> service (UDP port 19).', 'derivated_problem' => NULL, 'verification' => 'The verification can be achieved analyzing the existing network traffic and observing UDP datagrams from and towards the port 19. Alternatively, it can be verified by manually connecting to the service using the following command:

<div class = "destacated">

<pre><code>ncat -u {{incident.hostAddress}} 19
</code></pre>

</div>', 'recomendations' => 'We recommend:

<div class = "destacated">

<ul>
<li><p>Disable corresponding service.</p></li>
<li><p>Establish firewall rules to filter incoming and outgoing network traffic in the port 19/UDP.</p></li>
</ul>

</div>', 'more_information' => '<div class = "destacated">

<ul>
<li><p><a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:58', 'updated_at' => '2017-12-21 11:57:58'),
            array('lang' => 'es', 'type' => 'dos_chargen', 'slug' => 'dos_chargen-es', 'problem' => 'Le contactamos porque se nos informó que el <em>host</em> con IP {{incident.hostAddress}} está siendo utilizado para realizar ataques de Denegación de Servicio (DOS) a través del servicio <strong>chargen</strong>.', 'derivated_problem' => NULL, 'verification' => 'El problema puede ser verificado mediante el monitoreo de red que permita observar trafico UDP hacia y desde el puerto 19.
Alternativamente puede verificarlo conectándose manualmente a dicho servicio mediante el comando:

<div class="destacated">

<pre><code>ncat -u {{incident.hostAddress}} 19
</code></pre>

</div>', 'recomendations' => 'Se recomienda:

<div class="destacated">

<ul>
<li><p>Deshabilitar el servicio.</p></li>
<li><p>Establecer reglas en el firewall para bloquear de forma entrante y saliente el puerto 19/UDP</p></li>
</ul>

</div>', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:52', 'updated_at' => '2017-12-21 11:57:52'),
            array('lang' => 'en', 'type' => 'dos_ntp', 'slug' => 'dos_ntp-en', 'problem' => 'We would like to inform you that we have been notified that the <em>host</em> {{incident.hostAddress}} is being used to perform Denial of Service attacks (DOS), through the <strong>NTP service</strong> (UDP port 123).', 'derivated_problem' => NULL, 'verification' => 'The verification can be achieved analyzing the server response to the commands <strong><em>NTP readvar</em></strong> and/or <strong><em>NTP monlist</em></strong>. To manually verify if the service responds to these types of commands, use the following commands:


<div class = "destacated">

<pre><code>ntpq -c readvar [{{incident.hostAddress}}]
ntpdc -n -c monlist [{{incident.hostAddress}}]
</code></pre>

</div>', 'recomendations' => 'To address the <strong><em>NTP readvar</em></strong> issue, we recommend:


<div class = "destacated">

<a href="http://www.team-cymru.org/ReadingRoom/Templates/secure-ntp-template.html">Disable</a>
<code>NTP readvar</code> queries.

</div>

To address the <strong><em>NTP monlist</em></strong> issue, we recommend:


<div class = "destacated">

Versions of <code>ntpd</code> previous to 4.2.7 are vulnerable. Therefore, we recommend upgrading to the latest version available.
If upgrading is not possible, as an alternative disable <code>monlist</code>.

<a href="http://www.purdue.edu/securepurdue/news/2014/advisory--ntp-amplification-attacks.cfm">More</a>
<a href="http://www.team-cymru.org/ReadingRoom/Templates/secure-ntp-template.html">Information</a>
about how to disable <code>monlist</code>.


</div>', 'more_information' => '<div class = "destacated">

<ul>
<li><p><a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:58', 'updated_at' => '2017-12-21 11:57:58'),
            array('lang' => 'es', 'type' => 'dos_ntp', 'slug' => 'dos_ntp-es', 'problem' => 'Le contactamos porque se nos informó que el <em>host</em> con IP {{incident.hostAddress}} está siendo utilizado para realizar ataques de Denegación de Servicio (DOS) a través del servicio NTP (UDP 123).', 'derivated_problem' => NULL, 'verification' => 'Probablemente su servidor responde a comandos del tipo <strong><em>NTP readvar</em></strong>  y/o a comandos <strong><em>NTP monlist</em></strong>.
Para testear manualmente si el servicio responde a este tipo de consultas puede utilizar los respectivos comandos:

<div class="destacated">

<pre><code>ntpq -c readvar [{{incident.hostAddress}}]
ntpdc -n -c monlist [{{incident.hostAddress}}]
</code></pre>

</div>', 'recomendations' => 'Para el problema <strong><em>NTP readvar</em></strong>, se recomienda:

<div class="destacated">

<a href="http://www.team-cymru.org/ReadingRoom/Templates/secure-ntp-template.html">Deshabilitar</a>
las consultas <code>NTP readvar</code>.

</div>

Para el problema <strong><em>NTP monlist</em></strong>, se recomienda:

<div class="destacated">

Las versiones de <code>ntpd</code> anteriores a la 4.2.7 son vulnerables por
defecto. Por lo tanto, lo más simple es actualizar a la última versión.

En caso de que actualizar no sea una opción, como alternativa se puede
optar por deshabilitar la funcionalidad <code>monlist</code>.

<a href="http://www.purdue.edu/securepurdue/news/2014/advisory--ntp-amplification-attacks.cfm">Más</a>
<a href="http://www.team-cymru.org/ReadingRoom/Templates/secure-ntp-template.html">información</a>
sobre cómo deshabilitar <code>monlist</code>.


</div>', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:52', 'updated_at' => '2017-12-21 11:57:52'),
            array('lang' => 'en', 'type' => 'dos_snmp', 'slug' => 'dos_snmp-en', 'problem' => 'We would like to inform you that we have been notified that the <em>host</em> {{incident.hostAddress}} is being used to perform Denial of Service attacks (DOS), through the <strong>SNMP service</strong> (UDP port 161).', 'derivated_problem' => NULL, 'verification' => 'The verification can be achieved analyzing the existing network traffic and observing a mayor UDP traffic consumption corresponding to spoofed SNMP queries received.', 'recomendations' => 'We recommend:

* Users should be allowed and encouraged to disable SNMP.
* End-user devices should not be configured with SNMP on by default.
* End-user devices should not be routinely configured with the “public” SNMP community string.
* Establish firewall rules to filter unauthorized queries.', 'more_information' => '<div class = "destacated">

<ul>
<li><p><a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:58', 'updated_at' => '2017-12-21 11:57:58'),
            array('lang' => 'es', 'type' => 'dos_snmp', 'slug' => 'dos_snmp-es', 'problem' => 'Le contactamos porque se nos informó que el <em>host</em> con IP {{incident.hostAddress}} está siendo utilizado para realizar ataques de Denegación de Servicio (DOS) a través del servicio SNMP (UDP 161).', 'derivated_problem' => NULL, 'verification' => 'Mediante el monitoreo de red debería observar grandes cantidades de tráfico UDP correspondientes a consultas SNMP spoofeadas recibidas.', 'recomendations' => 'Se recomienda:

<ul>
<li><p>Deshabilitar el servicio.</p></li>
<li><p>Establecer reglas en el firewall para denegar las consultas desde redes no autorizadas.</p></li>
<li><p>No usar la "comunidad" por defecto.</p></li>
</ul>', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:52', 'updated_at' => '2017-12-21 11:57:52'),
            array('lang' => 'en', 'type' => 'drupal_remote_code_execution', 'slug' => 'drupal_remote_code_execution-en', 'problem' => 'Hemos detectado que el host {{incident.hostAddress}} tiene una version de Drupal insegura. Se trata de una vulnerabilidad que permite ejecutar código remoto arbitrario sin autentificación previa debido a un problema que afecta a múltiples instancias con configuraciones predeterminadas en el núcleo de Drupal versión 6.x 7.x 8.x. .
Se debe actualizar inmediatamente a una versión de Drupal segura.', 'derivated_problem' => 'La vulnerabilidad permite a un atacante efectuar varios vectores de ataque con el fin de tomar el control de un sitio Web Drupal por completo.', 'verification' => 'https://github.com/pimps/CVE-2018-7600 (validar vulnerabilidad)', 'recomendations' => 'Se debe actualizar inmediatamente a una versión de Drupal segura.', 'more_information' => 'https://cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2018-7600', 'is_active' => '1', 'created_at' => '2018-04-20 12:33:24', 'updated_at' => '2018-04-20 12:33:24'),
            array('lang' => 'es', 'type' => 'drupal_remote_code_execution', 'slug' => 'drupal_remote_code_execution-es', 'problem' => 'Hemos detectado que el host  {{incident.hostAddress}} tiene una version de Drupal insegura.

Se trata de una vulnerabilidad que permite ejecutar código remoto arbitrario sin autentificación previa debido a un problema que afecta a múltiples instancias con configuraciones predeterminadas en el núcleo de Drupal versión 6.x 7.x 8.x. .', 'derivated_problem' => 'La vulnerabilidad permite a un atacante efectuar varios vectores de ataque con el fin de tomar el control de un sitio Web Drupal por completo.', 'verification' => 'https://github.com/pimps/CVE-2018-7600 (validar vulnerabilidad)', 'recomendations' => 'Se debe actualizar inmediatamente a una versión de Drupal segura.', 'more_information' => 'https://cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2018-7600', 'is_active' => '1', 'created_at' => '2018-04-20 11:59:45', 'updated_at' => '2018-04-20 11:59:45'),
            array('lang' => 'en', 'type' => 'heartbleed', 'slug' => 'heartbleed-en', 'problem' => 'We would like to inform you that we have detected that the <em>host</em> {{incident.hostAddress}} has possible been attacked trough the OpenSSL vulnerability, known as "<a href="http://heartbleed.com/">Heartbleed</a>".', 'derivated_problem' => 'This vulnerability allows an attacker to read part of the memory of a client or server, possibly compromising sensible data.', 'verification' => 'To verify the vulnerability, access the following site and follow the instructions

<div class = "destacated">

<pre><code>https://filippo.io/Heartbleed/
</code></pre>

</div>', 'recomendations' => 'We recommend an immediate  upgrade of the OpenSSL library on the compromised host, and reboot all the services linked to the library.
The SSL certificate on the host could have been compromised, therefore we recommend generating a new one.', 'more_information' => '<div class = "destacated">

<ul>
<li><p><a href="https://www.openssl.org/news/secadv_20140407.txt">https://www.openssl.org/news/secadv_20140407.txt</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:58', 'updated_at' => '2017-12-21 11:57:58'),
            array('lang' => 'es', 'type' => 'heartbleed', 'slug' => 'heartbleed-es', 'problem' => 'Se detectó que el servidor {{incident.hostAddress}} posiblemente ha sido atacado mediante la
vulnerabilidad de OpenSSL conocida como
"<a href="http://heartbleed.com/">Heartbleed</a>".', 'derivated_problem' => 'Esta vulnerabilidad permite a un atacante leer la memoria de un servidor o
un cliente, permitiéndole por ejemplo, conseguir las claves privadas SSL de
un servidor.', 'verification' => 'Para comprobar que el servicio es vulnerable, acceda al siguiente sitio
web y siga las instrucciones. 

<div class="destacated">

<pre><code>https://filippo.io/Heartbleed/
</code></pre>

</div>', 'recomendations' => 'Se recomienda actualizar de forma inmediata la librería OpenSSL del
servidor y reiniciar los servicios que hagan uso de ésta. La vulnerabilidad
"Heartbleed" permite leer fragmentos de la memoria del servicio
vulnerable. Por este motivo, es posible que el certificado SSL haya sido
comprometido y por lo tanto se recomienda regenerarlo.', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="https://www.openssl.org/news/secadv_20140407.txt">https://www.openssl.org/news/secadv_20140407.txt</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:53', 'updated_at' => '2017-12-21 11:57:53'),
            array('lang' => 'en', 'type' => 'information_leakage', 'slug' => 'information_leakage-en', 'problem' => 'Information leakage', 'derivated_problem' => 'Information leakage happens whenever a system that is designed to be closed to an eavesdropper reveals some information to unauthorized parties nonetheless. For example username and password exposed.', 'verification' => 'Check evidence', 'recomendations' => '* Invalidate data exposed, for example force users to change credenetials.
* Check in the logs if for the compromised data had been used.
* Ask the publisher to remove the leakage information', 'more_information' => '* Check for compromised data in: https://haveibeenpwned.com/', 'is_active' => '1', 'created_at' => '2018-05-03 13:23:16', 'updated_at' => '2018-05-03 13:23:16'),
            array('lang' => 'es', 'type' => 'information_leakage', 'slug' => 'information_leakage-es', 'problem' => 'Fuga de Información', 'derivated_problem' => 'Pueden verse comprometidas datos sensibles del usuario. Un ejemplo son las credenciales de usuario (username y password) que apliquen a otros sistemas ante una fuga de información.', 'verification' => 'Revisar la evidencia que se adjunta.', 'recomendations' => '* Invalidar los datos relacionados a la fuga de datos. Por ejemplo forzando el cambio de contraseña
* Revisar los accesos realizados con los datos
* Solicitar al que esta publicando los datos que remueva la publicación', 'more_information' => 'Puede chequear adicionalmente: https://haveibeenpwned.com/', 'is_active' => '1', 'created_at' => '2018-05-03 13:03:39', 'updated_at' => '2018-05-03 13:03:39'),
            array('lang' => 'en', 'type' => 'malware', 'slug' => 'malware-en', 'problem' => 'We would like to inform you that we have been informed that the <em>host</em> {{incident.hostAddress}} is currently infected with malware.', 'derivated_problem' => 'Being the host infected, we can list the following consequences:

<ul>
<li><p>Excessive consumption of bandwidth by the host.</p></li>
<li><p>Compromising other hosts.</p></li>
<li><p>Compromising user information.</p></li>
<li><p>Forming part of a BotNet.</p></li>
</ul>', 'verification' => NULL, 'recomendations' => 'We recommend to filter the network traffic until the problem is solved.', 'more_information' => NULL, 'is_active' => '1', 'created_at' => '2017-12-21 11:57:58', 'updated_at' => '2017-12-21 11:57:58'),
            array('lang' => 'es', 'type' => 'malware', 'slug' => 'malware-es', 'problem' => 'Nos comunicamos con Ud. porque porque hemos sido informados que el host {{incident.hostAddress}} se encuentra infectado con un malware.', 'derivated_problem' => 'Encontrándose infectado el equipo existen diversas consecuencias, entre las que podemos listar:

<ul>
<li><p>Consumo excesivo del ancho de banda por parte del host.</p></li>
<li><p>Compromiso de otros equipos.</p></li>
<li><p>Compromiso de información propia de los usuarios.</p></li>
<li><p>Ejecute órdenes de una botnet.</p></li>
</ul>', 'verification' => NULL, 'recomendations' => 'Se recomienda el filtrado del tráfico hasta que el problema sea resuelto.', 'more_information' => NULL, 'is_active' => '1', 'created_at' => '2017-12-21 11:57:53', 'updated_at' => '2017-12-21 11:57:53'),
            array('lang' => 'es', 'type' => 'open_chargen', 'slug' => 'open_chargen-es', 'problem' => 'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} dispone del servicio Chargen abierto y accesible desde Internet.', 'derivated_problem' => 'El host bajo su administración podría llegar a ser usado en ataques de amplificación para causar ataques de denegación de servicio (DOS, DDOS).', 'verification' => NULL, 'recomendations' => 'Se recomienda alguna de las siguientes:

<ul>
<li><p>Deshabilitar el servicio.</p></li>
<li><p>Establecer reglas de firewall para denegar las consultas desde redes no autorizadas.</p></li>
</ul>', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="https://en.wikipedia.org/wiki/Character_Generator_Protocol">https://en.wikipedia.org/wiki/Character_Generator_Protocol</a></p></li>
<li><p><a href="https://kb.iweb.com/hc/en-us/articles/230268088-Guide-to-Chargen-Amplification-Issues">https://kb.iweb.com/hc/en-us/articles/230268088-Guide-to-Chargen-Amplification-Issues</a></p></li>
<li><p><a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:53', 'updated_at' => '2017-12-21 11:57:53'),
            array('lang' => 'en', 'type' => 'open_dns', 'slug' => 'open_dns-en', 'problem' => 'We would like to inform you that we have been notified that the <strong>host/servidor</strong> {{incident.hostAddress}} provides insecure <strong>DNS</strong> services. The service  <a href="https://www.us-cert.gov/ncas/alerts/TA13-088A">responds to recursive queries</a> originated outside your network.', 'derivated_problem' => 'The <em>host</em> under your administration could be used to perform <a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">amplification</a> attacks. This could allow attacks such as:

<ul>
<li><p>Dos (Denial of service)</p></li>
<li><p>DDOS (Distributed denial of service)</p></li>
</ul>

Additionally , the host could be exposed to DNS cache poisoning or <strong>Pharming</strong>..', 'verification' => 'Use the following command:

<div class = "destacated">

<pre><code>dig +short test.openresolver.com TXT @{{incident.hostAddress}}
</code></pre>

</div>

or use the following web page:

<div class = "destacated">

<pre><code>http://openresolver.com/?ip={{incident.hostAddress}}
</code></pre>

</div>', 'recomendations' => 'Disable recursive answers to queries that does not originate from networks under your administration.', 'more_information' => '<div class = "destacated">

<ul>
<li><p><a href="https://www.us-cert.gov/ncas/alerts/TA13-088A">https://www.us-cert.gov/ncas/alerts/TA13-088A</a></p></li>
<li><p><a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:58', 'updated_at' => '2017-12-21 11:57:58'),
            array('lang' => 'es', 'type' => 'open_dns', 'slug' => 'open_dns-es', 'problem' => 'Lo contactamos porque hemos sido informados que el <strong>host/servidor</strong> {{incident.hostAddress}} brinda servicios de DNS de manera insegura. 
En particular, la configuración de dicho servicio 
<a href="https://www.us-cert.gov/ncas/alerts/TA13-088A">responde consultas recursivas</a> realizadas desde fuera de la red de la UNLP.', 'derivated_problem' => 'El <em>host</em> bajo su administración podría llegar a ser usado en ataques de
<a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">amplificación</a>. Esto
permitiría realizar ataques a terceros de tipo:

<ul>
<li><p>DoS (Denegación de servicio)</p></li>
<li><p>DDoS (Denegación de servicio distribuida)</p></li>
</ul>

Adicionalmente, el servidor podría verse expuesto a ataques de
envenenamiento de caché de DNS o <strong>Pharming</strong>.', 'verification' => 'Utilizando el comando:

<div class="destacated">

<pre><code>dig +short test.openresolver.com TXT @{{incident.hostAddress}}
</code></pre>

</div>

o vía web a través de la siguiente página:

<div class="destacated">

<pre><code>http://openresolver.com/?ip={{incident.hostAddress}}
</code></pre>

</div>', 'recomendations' => 'Se recomienda desactivar la respuesta recursiva a consultas que no
provienen de redes bajo su administración.', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="https://www.us-cert.gov/ncas/alerts/TA13-088A">https://www.us-cert.gov/ncas/alerts/TA13-088A</a></p></li>
<li><p><a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:53', 'updated_at' => '2017-12-21 11:57:53'),
            array('lang' => 'es', 'type' => 'open_elasticsearch', 'slug' => 'open_elasticsearch-es', 'problem' => 'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} dispone del servicio Elasticseach abierto y accesible desde Internet.', 'derivated_problem' => 'Por defecto, este servicio no brinda ningun tipo de autenticación, lo que significa que cualquier entidad podria tener acceso instantaneo a sus datos.', 'verification' => NULL, 'recomendations' => 'Se recomienda alguna de las siguientes:

<ul>
<li><p>Deshabilitar el servicio.</p></li>
<li><p>Establecer reglas de firewall para denegar las consultas desde redes no autorizadas.</p></li>
</ul>', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="https://www.elastic.co/blog/found-elasticsearch-security">https://www.elastic.co/blog/found-elasticsearch-security</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:53', 'updated_at' => '2017-12-21 11:57:53'),
            array('lang' => 'en', 'type' => 'open_ipmi', 'slug' => 'open_ipmi-en', 'problem' => 'We would like to inform you that we have been informed that web page hosted with the IP {{incident.hostAddress}} has the Intelligent <strong>Intelligent Platform Management Interface</strong> (IPMI) service, accessible from the Internet.', 'derivated_problem' => 'The host under your administration could be controlled remotely. IPMI provides low level access to the device possibly allowing a system reboot, installation of unknown software, access restricted information, etc.', 'verification' => NULL, 'recomendations' => 'We recommend:

<ul>
<li><p>Establish firewall rules and filter unauthorized access to the service.</p></li>
<li><p>In case the service is not being used, disable it.</p></li>
</ul>', 'more_information' => '<div class = "destacated">

<ul>
<li><p>[US-CERT alert TA13-207A] (https://www.us-cert.gov/ncas/alerts/TA13-207A)</p></li>
<li><p>[Dan Farmer on IPMI security issues] (http://fish2.com/ipmi/)</p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:58', 'updated_at' => '2017-12-21 11:57:58'),
            array('lang' => 'es', 'type' => 'open_ipmi', 'slug' => 'open_ipmi-es', 'problem' => 'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} tiene el servicio Intelligent Platform Management Interface (IPMI) accesible desde Internet.', 'derivated_problem' => 'El host bajo su administración podría llegar a ser usado para controlar el dispositivo remotamente. IPMI provee acceso a bajo nivel al dispositivo, pudiendo permitir reiniciar el sistema, instalar un nuevo sistema operativo, acceder a información alojada en el sistema, etc.', 'verification' => NULL, 'recomendations' => 'Se recomienda:

<ul>
<li><p>Establecer filtros de acceso (reglas de firewall) para exponer el servicio solo a las IPs del administrador.</p></li>
<li><p>En caso de no utilizarlo, es recomendable deshabilitar el servicio.</p></li>
</ul>', 'more_information' => '<div class="destacated">

<ul>
<li><p>[US-CERT alert TA13-207A] (https://www.us-cert.gov/ncas/alerts/TA13-207A)</p></li>
<li><p>[Dan Farmer on IPMI security issues] (http://fish2.com/ipmi/)</p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:53', 'updated_at' => '2017-12-21 11:57:53'),
            array('lang' => 'es', 'type' => 'open_isakmp', 'slug' => 'open_isakmp-es', 'problem' => 'Lo contactamos porque hemos sido informados que el dispositivo {{incident.hostAddress}} contiene una vulnerabilidad en el procesamiento de paquetes IKEv1.', 'derivated_problem' => 'Esta vulnerabilidad podría permitir a un atacante remoto no autentiado recuperar el contenido de la memoria, lo cual podría conducir a la divulgación de información confidencial.', 'verification' => NULL, 'recomendations' => 'Se recomienda alguna de las siguientes:

<ul>
<li><p>Actualizar el firmware del dispositivo.</p></li>
<li><p>Deshabilitar el servicio.</p></li>
</ul>', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="https://tools.cisco.com/security/center/content/CiscoSecurityAdvisory/cisco-sa-20160916-ikev1">https://tools.cisco.com/security/center/content/CiscoSecurityAdvisory/cisco-sa-20160916-ikev1</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:53', 'updated_at' => '2017-12-21 11:57:53'),
            array('lang' => 'en', 'type' => 'open_ldap', 'slug' => 'open_ldap-en', 'problem' => 'We would like to inform you that we have been notified that the <em>host</em> {{incident.hostAddress}} has the <strong>Lightweight Directory Access Protocol</strong> (LDAP) service, accessible from the Internet.', 'derivated_problem' => 'The <em>host</em> under your administration could be compromising sensitive information.', 'verification' => NULL, 'recomendations' => '<ul>
<li><p>Establish firewall rules to filter unauthorized queries.</p></li>
<li><p>Use Transport Layer Security (TLS) encryption in the communication service. (IN o OVER - DAniela)</p></li>
<li><p>Deny anonymous bind type connections.</p></li>
<li><p><a href="https://www.sans.org/reading-room/whitepapers/directories/securely-implementing-ldap-109">Additional information</a>.</p></li>
</ul>', 'more_information' => NULL, 'is_active' => '1', 'created_at' => '2017-12-21 11:57:58', 'updated_at' => '2017-12-21 11:57:58'),
            array('lang' => 'es', 'type' => 'open_ldap', 'slug' => 'open_ldap-es', 'problem' => 'Le contactamos porque se nos ha informado que el <em>host</em> con IP {{incident.hostAddress}} tiene el servicio LDAP accesible desde Internet.', 'derivated_problem' => 'El <em>host</em> bajo su administración podría llegar a estar brindando información sensible.', 'verification' => NULL, 'recomendations' => '<ul>
<li><p>Establecer reglas de firewall para permitir consultas sólo desde las redes autorizadas.</p></li>
<li><p>Utilizar TLS en la comunicación con el servicio.</p></li>
<li><p>No permitir conexiones de manera anónima (Anonymous BIND).</p></li>
<li><p><a href="https://www.sans.org/reading-room/whitepapers/directories/securely-implementing-ldap-109">Información adicional</a>.</p></li>
</ul>', 'more_information' => NULL, 'is_active' => '1', 'created_at' => '2017-12-21 11:57:53', 'updated_at' => '2017-12-21 11:57:53'),
            array('lang' => 'es', 'type' => 'open_mdns', 'slug' => 'open_mdns-es', 'problem' => 'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} dispone del servicio mDNS (Multicast DNS) abierto y accesible desde Internet.', 'derivated_problem' => 'El host bajo su administración podría llegar a ser usado en ataques de amplificación para causar ataques de denegación de servicio (DOS, DDOS).', 'verification' => NULL, 'recomendations' => 'Se recomienda alguna de las siguientes:

<ul>
<li><p>Deshabilitar el servicio.</p></li>
<li><p>Establecer reglas de firewall para denegar las consultas desde redes no autorizadas.</p></li>
</ul>', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="https://www.trustwave.com/Resources/SpiderLabs-Blog/mDNS---Telling-the-world-about-you-(and-your-device)/">https://www.trustwave.com/Resources/SpiderLabs-Blog/mDNS---Telling-the-world-about-you-(and-your-device)/</a></p></li>
<li><p><a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:53', 'updated_at' => '2017-12-21 11:57:53'),
            array('lang' => 'en', 'type' => 'open_memcached', 'slug' => 'open_memcached-en', 'problem' => 'We would like to inform you that we have been notified that the <em>host</em> {{incident.hostAddress}} has the <strong>Memcached</strong> service, accessible from the Internet.', 'derivated_problem' => 'The <em>host</em> under your administration could be used to perform <a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">amplification</a> attacks to third party\'s, like:

<div class = "destacated">
<ul>
<li><p>Denial of Service attacks (DOS, DDOS).</p></li>
</ul>
</div>

Also, due to the service not providing an authentication mechanism, any third party accessing the Memcache service would have total over the stored information. The following items could be compromised:

<div class = "destacated">
<ul>
<li><p>Access to sensitive information.</p></li>
<li><p>Perform a defacement\'s attack to the web server.</p></li>
<li><p>Perform a Denial of Service attack (DOS) to the server.</p></li>
</ul>
</div>', 'verification' => 'To verify that the service is currently open, use the <code>telnet</code> command in the following way:
<div class = "destacated">
<pre><code>telnet {{incident.hostAddress}} 11211
stats items
</code></pre>
</div>', 'recomendations' => '<ul>
<li><p>Establish firewall rules to filter unauthorized queries.</p></li>
</ul>', 'more_information' => '<div class = "destacated">
<ul>
<li><p>memcached.org</p></li>
<li><p>http://infiltrate.tumblr.com/post/38565427/hacking-memcache</p></li>
<li><p>http://es.wikipedia.org/wiki/Defacement</p></li>
</ul>
</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:59', 'updated_at' => '2018-03-06 13:06:31'),
            array('lang' => 'es', 'type' => 'open_memcached', 'slug' => 'open_memcached-es', 'problem' => 'Lo contactamos porque hemos sido informados que el host con {{incident.hostAddress}} contiene
una instalación de Memcached accesible desde Internet.', 'derivated_problem' => 'Debido a que este servicio no provee autenticación, cualquier entidad que acceda a la instancia de Memcache, tendrá control total sobre los objetos almacenados, con lo que se podría:

<div class = "destacated">
<ul>
<li><p>Acceder a la información almacenada</p></li>
<li><p>Realizar el defacement del servidor WEB</p></li>
<li><p>Realizar una denegación de servicio sobre el servidor</p></li>
</ul>
</div>', 'verification' => 'Para comprobar que el servicio está abierto, utilice el comando <code>telnet</code> del siguiente modo:

<div class="destacated">

<pre><code>telnet {{incident.hostAddress}} 11211
stats items
</code></pre>

</div>', 'recomendations' => 'Se recomienda alguna de las siguientes:

<ul>
<li><p>Establecer reglas de firewall para denegar las consultas desde hosts/redes no autorizadas.</p></li>
</ul>', 'more_information' => '<div class = "destacated">
<ul>
<li><p>memcached.org</p></li>
<li><p>http://infiltrate.tumblr.com/post/38565427/hacking-memcache</p></li>
<li><p>http://es.wikipedia.org/wiki/Defacement</p></li>
</ul>
</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:54', 'updated_at' => '2018-03-06 12:33:09'),
            array('lang' => 'en', 'type' => 'open_mongodb', 'slug' => 'open_mongodb-en', 'problem' => 'We would like to inform you that we have been informed that the <em>host</em> {{incident.hostAddress}} has a database (MongoDB) with unrestricted access from the Internet.', 'derivated_problem' => 'The <em>host</em> under your administration could be compromising sensitive information.', 'verification' => 'To manually verify the connection to the service, use the following command:

<div class = "destacated">

<pre><code>mongo {{incident.hostAddress}}
</code></pre>

</div>', 'recomendations' => '* Establish firewall rules to filter unauthorized access.
* Enable Access Control and Enforce Authentication
* Configure Role-Based Access Control
* Run MongoDB with Secure Configuration Options
* Enable Secure Sockets Layer (SSL) to encrypt communications.
* Use the loopback address to establish connections to limit exposure.
* Modify the default port.
* Ensure that the HTTP status interface, the REST API, and the JSON API are all disabled in production environments to prevent potential data exposure and vulnerability to attackers.







<div class = "destacated">

<ul>
<li><p><a href="https://docs.mongodb.com/manual/administration/security-checklist/">Security checklist</a></p></li>
<li><p><a href="https://docs.mongodb.com/manual/core/security-mongodb-configuration/#bind-ip">Security configuration</a></p></li>
</ul>

</div>', 'more_information' => '<div class = "destacated">

<ul>
<li><p><a href="https://docs.mongodb.com/manual/administration/security-checklist/">Security checklist</a></p></li>
<li><p><a href="https://docs.mongodb.com/manual/core/security-mongodb-configuration/#bind-ip">Security configuration</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:59', 'updated_at' => '2017-12-21 11:57:59'),
            array('lang' => 'es', 'type' => 'open_mongodb', 'slug' => 'open_mongodb-es', 'problem' => 'Le contactamos porque se nos ha informado que el <em>host</em> con IP {{incident.hostAddress}} tiene una base de datos MongoDB NoSQL accesible sin restricciones desde Internet.', 'derivated_problem' => 'El <em>host</em> bajo su administración podría llegar a estar brindando información sensible, comprometiendo sistemas que corren él.', 'verification' => 'Para testear manualmente la conexión al servicio puede utilizar el comando:

<div class="destacated">

<pre><code>mongo {{incident.hostAddress}}
</code></pre>

</div>', 'recomendations' => '<ul>
<li><p><a href="http://docs.mongodb.org/manual/core/security-network/#firewalls">Agregar</a>
firewalls para restringir accesos no autorizados.</p></li>
<li><p><a href="http://docs.mongodb.org/manual/core/authorization/">Habilitar</a>
la autenticación de accesos.</p></li>
<li><p><a href="http://docs.mongodb.org/manual/core/security-network/#nohttpinterface">Habilitar</a> el servicio con SSL.</p></li>
<li><p><a href="http://docs.mongodb.org/manual/reference/security/#userAdminAnyDatabase">Habilitar</a> la autorización de acciones basada en roles.</p></li>
<li><p><a href="http://docs.mongodb.org/manual/core/security-network/#bind-ip">Configurar</a>
las conexiones en la interfaz de loopback.</p></li>
<li><p>Alternativamente, se puede <a href="http://docs.mongodb.org/manual/core/security-network/#port">cambiar</a> el puerto de conexión.</p></li>
<li><p><a href="http://docs.mongodb.org/manual/core/security-network/#nohttpinterface">Deshabilitar</a> la interfaz http de estado.</p></li>
<li><p><a href="http://docs.mongodb.org/manual/core/security-network/#rest">Deshabilitar</a>
la interfaz REST.</p></li>
</ul>', 'more_information' => NULL, 'is_active' => '1', 'created_at' => '2017-12-21 11:57:54', 'updated_at' => '2017-12-21 11:57:54'),
            array('lang' => 'en', 'type' => 'open_mssql', 'slug' => 'open_mssql-en', 'problem' => 'We would like to inform you that we have been notified that the <em>host</em> {{incident.hostAddress}} has the <strong>Microsoft SQL Server</strong> service, accessible from the Internet.', 'derivated_problem' => 'The <em>host</em> under your administration could be compromising sensitive information, also could victim of UDP amplification performing Denial of Service (DOS,DDOS) attacks.', 'verification' => NULL, 'recomendations' => 'Establish firewall rules to filter unauthorized access.', 'more_information' => '<div class = "destacated">

<ul>
<li><p><a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>
<li><p><a href="https://blogs.akamai.com/2015/02/plxsert-warns-of-ms-sql-reflection-attacks.html">https://blogs.akamai.com/2015/02/plxsert-warns-of-ms-sql-reflection-attacks.html</a></p></li>
<li><p><a href="http://es.wikipedia.org/wiki/SQL_Slammer">http://es.wikipedia.org/wiki/SQL_Slammer</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:59', 'updated_at' => '2017-12-21 11:57:59'),
            array('lang' => 'es', 'type' => 'open_mssql', 'slug' => 'open_mssql-es', 'problem' => 'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} tiene el servicio de resolución de Microsoft SQL Server abierto desde Internet.', 'derivated_problem' => 'El host bajo su administración podría ser usado para revelar información como así también en ataques de amplificación UDP que provoquen denegaciones de servicio (DOS, DDOS).', 'verification' => NULL, 'recomendations' => 'Se recomienda establecer reglas de firewall para permitir solamente las conexiones al servicio solo desde los servidores autorizados.', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>
<li><p><a href="https://blogs.akamai.com/2015/02/plxsert-warns-of-ms-sql-reflection-attacks.html">https://blogs.akamai.com/2015/02/plxsert-warns-of-ms-sql-reflection-attacks.html</a></p></li>
<li><p><a href="http://es.wikipedia.org/wiki/SQL_Slammer">http://es.wikipedia.org/wiki/SQL_Slammer</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:54', 'updated_at' => '2017-12-21 11:57:54'),
            array('lang' => 'en', 'type' => 'open_netbios', 'slug' => 'open_netbios-en', 'problem' => 'We would like to inform you that we have been notified that the <em>host/server</em> {{incident.hostAddress}} has the <strong>Network Basic Input/Output System</strong> (NETBIOS) service, accessible from the Internet.', 'derivated_problem' => 'The <em>host</em> under your administration could be used to perform:

<ul>
<li><p>Denial of Service attacks (DOS, DDOS).</p></li>
<li><p>Gather information shared within the host.</p></li>
<li><p>Perform brute force attacks.</p></li>
<li><p>Malware distribution.</p></li>
<li><p>Store stolen information.</p></li>
</ul>', 'verification' => NULL, 'recomendations' => 'We recommend:

<ul>
<li><p>Do not use the service over the TCP/IP protocol.</p></li>
<li><p>Establish firewall rules to filter unauthorized queries.</p></li>
<li><p>Establish, if possible, access control.</p></li>
</ul>', 'more_information' => '<div class = "destacated">

<ul>
<li><p><a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:59', 'updated_at' => '2017-12-21 11:57:59'),
            array('lang' => 'es', 'type' => 'open_netbios', 'slug' => 'open_netbios-es', 'problem' => 'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} dispone del servicio NETBIOS abierto desde Internet.', 'derivated_problem' => 'El host bajo su administración podría ser usado para:

<ul>
<li><p>Ataques de amplificación que causen denegación de servicio (DOS, DDOS)</p></li>
<li><p>Recopilar información compartida en dicho host</p></li>
<li><p>Realizar ataques de fuerza bruta en caso que el servicio solicite contraseña</p></li>
<li><p>Distribución de malware</p></li>
<li><p>Almacenar información robada</p></li>
</ul>', 'verification' => NULL, 'recomendations' => 'Se recomienda:

<ul>
<li><p>No correr el servicio sobre TCP/IP.</p></li>
<li><p>Establecer reglas en el firewall para denegar las consultas desde redes no autorizadas.</p></li>
</ul>', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:54', 'updated_at' => '2017-12-21 11:57:54'),
            array('lang' => 'en', 'type' => 'open_ntp_monitor', 'slug' => 'open_ntp_monitor-en', 'problem' => 'We would like to inform you that we have been notified that the <em>host</em> {{incident.hostAddress}} is providing insecure <strong>Network Time Protocol</strong> (NTP) service by responding to <a href="https://www.us-cert.gov/ncas/alerts/TA14-013A">NTP monlist</a> commands.', 'derivated_problem' => 'The <em>host</em> under your administration could be used to perform <a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">amplification</a> attacks to third party\'s, like:

<ul>
<li><p>Denial of Service attacks (DOS, DDOS).</p></li>
</ul>', 'verification' => 'To manually verify if the service is vulnerable, use the following command:


<div class = "destacated">

<pre><code>ntpdc -n -c monlist {{incident.hostAddress}}
</code></pre>

</div>', 'recomendations' => 'Versions of  <code>ntpd</code> previous to 4.2.7 are vulnerable. Therefore, we recommend upgrading to the latest version available.
If upgrading is not possible, as an alternative disable <code>monlist</code>.', 'more_information' => '<a href="http://www.purdue.edu/securepurdue/news/2014/advisory--ntp-amplification-attacks.cfm">More</a>
<a href="http://www.team-cymru.org/ReadingRoom/Templates/secure-ntp-template.html">information</a>
about how to disable <code>monlist</code>.', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:59', 'updated_at' => '2017-12-21 11:57:59'),
            array('lang' => 'es', 'type' => 'open_ntp_monitor', 'slug' => 'open_ntp_monitor-es', 'problem' => 'Le contactamos porque se nos ha informado que el <em>host</em> con IP {{incident.hostAddress}} brinda
el servicio de NTP de manera insegura. En particular, el servicio estaría
respondiendo a comandos del tipo
<a href="https://www.us-cert.gov/ncas/alerts/TA14-013A">NTP monlist</a>.', 'derivated_problem' => 'El <em>host</em> bajo su administración podría llegar a ser usado en ataques de
<a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">amplificación</a>. Esto
permitiría realizar ataques a terceros de tipo:

<ul>
<li><p>DoS (Denegación de servicio)</p></li>
<li><p>DDoS (Denegación de servicio distribuida)</p></li>
</ul>', 'verification' => 'Para testear manualmente si el servicio es vulnerable a esta falla, puede
utilizar el comando:

<div class="destacated">

<pre><code>ntpdc -n -c monlist {{incident.hostAddress}}
</code></pre>

</div>', 'recomendations' => 'Las versiones de <code>ntpd</code> anteriores a la 4.2.7 son vulnerables por
defecto. Por lo tanto, lo más simple es actualizar a la última versión.

En caso de que actualizar no sea una opción, como alternativa se puede
optar por deshabilitar la funcionalidad <code>monlist</code>.', 'more_information' => '<a href="http://www.purdue.edu/securepurdue/news/2014/advisory--ntp-amplification-attacks.cfm">Más</a>
<a href="http://www.team-cymru.org/ReadingRoom/Templates/secure-ntp-template.html">información</a>
sobre cómo deshabilitar <code>monlist</code>.', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:54', 'updated_at' => '2017-12-21 11:57:54'),
            array('lang' => 'en', 'type' => 'open_ntp_version', 'slug' => 'open_ntp_version-en', 'problem' => 'We would like to inform you that we have been notified that the <em>host</em>  {{incident.hostAddress}} is providing insecure <strong>Network Time Protocol</strong> (NTP) service by responding to <code>NTP readvar</code> commands.', 'derivated_problem' => '<p class="lead">Problemas derivados</p>

The <em>host</em>  under your administration could be used to perform <a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">amplification</a> attacks to third party\'s, like:

<ul>
<li><p>Denial of Service attacks (DOS, DDOS).</p></li>
</ul>', 'verification' => 'To manually verify if the service is vulnerable, use the following command:


<div class = "destacated">

<pre><code>ntpq -c readvar {{incident.hostAddress}}
</code></pre>

</div>', 'recomendations' => '<a href="http://www.team-cymru.org/ReadingRoom/Templates/secure-ntp-template.html">Disable</a>
<code>NTP readvar</code> queries.', 'more_information' => NULL, 'is_active' => '1', 'created_at' => '2017-12-21 11:57:59', 'updated_at' => '2017-12-21 11:57:59'),
            array('lang' => 'es', 'type' => 'open_ntp_version', 'slug' => 'open_ntp_version-es', 'problem' => 'Le contactamos porque se nos ha informado que el <em>host</em> con IP {{incident.hostAddress}} brinda
el servicio de NTP de manera insegura. En particular, el servicio estaría
respondiendo a comandos del tipo <code>NTP readvar</code>.', 'derivated_problem' => 'El <em>host</em> bajo su administración podría llegar a ser usado en ataques de
<a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">amplificación</a>. Esto
permitiría realizar ataques a terceros de tipo:

<ul>
<li><p>DoS (Denegación de servicio)</p></li>
<li><p>DDoS (Denegación de servicio distribuida)</p></li>
</ul>', 'verification' => 'Para testear manualmente si el servicio es vulnerable a esta falla puede
utilizar el comando:

<div class="destacated">

<pre><code>ntpq -c readvar {{incident.hostAddress}}
</code></pre>

</div>', 'recomendations' => '<a href="http://www.team-cymru.org/ReadingRoom/Templates/secure-ntp-template.html">Deshabilitar</a>
las consultas <code>NTP readvar</code>.', 'more_information' => NULL, 'is_active' => '1', 'created_at' => '2017-12-21 11:57:54', 'updated_at' => '2017-12-21 11:57:54'),
            array('lang' => 'en', 'type' => 'open_portmap', 'slug' => 'open_portmap-en', 'problem' => 'We would like to inform you that we have been notified that the <em>host/server</em>  {{incident.hostAddress}} has the <strong>Portmap</strong> service, accessible from the Internet.', 'derivated_problem' => 'The <em>host</em> under your administration could be used to perform <a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">amplification</a> attacks to third party\'s, like:

<ul>
<li><p>Denial of Service attacks (DOS, DDOS).</p></li>
</ul>

Additionally, the <strong>host/servidor</strong> could expose other misconfigured services, such as NFS shared folders.', 'verification' => 'To manually verify if the service is vulnerable, use the following command:

<div class = "destacated">

<pre><code>rpcinfo -T udp -p {{incident.hostAddress}}
</code></pre>

</div>

View the NFS shared folders using the command:

<div class = "destacated">

<pre><code>showmount -e {{incident.hostAddress}}
</code></pre>

</div>', 'recomendations' => '<ul>
<li><p>We recommend filtering unauthorized access to Portmap service, or disabling the service.</p></li>
<li><p>If NFS shared folders are being used, use proper filtering methods, or deactivate the feature.</p></li>
</ul>', 'more_information' => '<div class = "destacated">

<ul>
<li><p><a href="https://web.nvd.nist.gov/view/vuln/detail?vulnId=CVE-2005-2132">https://web.nvd.nist.gov/view/vuln/detail?vulnId=CVE-2005-2132</a></p></li>
<li><p><a href="http://blog.level3.com/security/a-new-ddos-reflection-attack-portmapper-an-early-warning-to-the-industry/">http://blog.level3.com/security/a-new-ddos-reflection-attack-portmapper-an-early-warning-to-the-industry/</a></p></li>
<li><p><a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:59', 'updated_at' => '2017-12-21 11:57:59'),
            array('lang' => 'es', 'type' => 'open_portmap', 'slug' => 'open_portmap-es', 'problem' => 'Lo contactamos porque hemos sido informados que el <strong>host/servidor</strong> {{incident.hostAddress}} brinda el servicio portmap accesible desde Internet.', 'derivated_problem' => 'El <em>host</em> bajo su administración podría llegar a ser usado en ataques de
<a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">amplificación</a>. Esto 
permitiría realizar ataques a terceros de tipo:

<ul>
<li><p>DoS (Denegación de servicio)</p></li>
<li><p>DDoS (Denegación de servicio distribuida)</p></li>
</ul>

Adicionalmente, el servidor podría exponer otros servicios mal configurados como puede ser carpetas compartidas NFS.', 'verification' => 'Utilizando el comando:

<div class="destacated">

<pre><code>rpcinfo -T udp -p {{incident.hostAddress}}
</code></pre>

</div>

Y ver carpetas compartidas NFS utilizando el comando:

<div class="destacated">

<pre><code>showmount -e {{incident.hostAddress}}
</code></pre>

</div>', 'recomendations' => '<ul>
<li><p>Se recomienda desactivar o filtrar el servicio Portmap para que sólo sea accesible desde las redes que usted necesite.</p></li>
<li><p>En caso de usar carpetas compartidas NFS evaluar la necesidad. Desactivar, configurar o filtrar adecuadamente.</p></li>
</ul>', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="https://web.nvd.nist.gov/view/vuln/detail?vulnId=CVE-2005-2132">https://web.nvd.nist.gov/view/vuln/detail?vulnId=CVE-2005-2132</a></p></li>
<li><p><a href="http://blog.level3.com/security/a-new-ddos-reflection-attack-portmapper-an-early-warning-to-the-industry/">http://blog.level3.com/security/a-new-ddos-reflection-attack-portmapper-an-early-warning-to-the-industry/</a></p></li>
<li><p><a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:55', 'updated_at' => '2017-12-21 11:57:55'),
            array('lang' => 'es', 'type' => 'open_qotd', 'slug' => 'open_qotd-es', 'problem' => 'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} dispone del servicio QOTD (Quote of the Day) abierto y accesible desde Internet.', 'derivated_problem' => 'El host bajo su administración podría llegar a ser usado en ataques de amplificación para causar ataques de denegación de servicio (DOS, DDOS).', 'verification' => NULL, 'recomendations' => 'Se recomienda alguna de las siguientes:

<ul>
<li><p>Deshabilitar el servicio.</p></li>
<li><p>Establecer reglas de firewall para denegar las consultas desde redes no autorizadas.</p></li>
</ul>', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="https://kb.iweb.com/hc/en-us/articles/230268148-Guide-to-QOTD-Amplification-Issues">https://kb.iweb.com/hc/en-us/articles/230268148-Guide-to-QOTD-Amplification-Issues</a></p></li>
<li><p><a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:55', 'updated_at' => '2017-12-21 11:57:55'),
            array('lang' => 'es', 'type' => 'open_rdp', 'slug' => 'open_rdp-es', 'problem' => 'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} tiene el servicio RDP (Remote Desktop Protocol) accesible desde Internet.', 'derivated_problem' => 'Este servicio puede revelar información sensible o el host bajo su administración podría llegar a ser usado para controlar el dispositivo remotamente.', 'verification' => NULL, 'recomendations' => 'Se recomienda:

<ul>
<li><p>Establecer filtros de acceso (reglas de firewall) para exponer el servicio solo a las IPs del administrador.</p></li>
<li><p>En caso de no utilizarlo, es recomendable deshabilitar el servicio.</p></li>
</ul>', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="https://en.wikipedia.org/wiki/Remote_Desktop_Protocol">https://en.wikipedia.org/wiki/Remote_Desktop_Protocol</a></p></li>
<li><p><a href="https://zeltser.com/remote-desktop-security-risks/">https://zeltser.com/remote-desktop-security-risks/</a></p></li>
<li><p><a href="https://www.howtogeek.com/175087/how-to-enable-and-secure-remote-desktop-on-windows/">https://www.howtogeek.com/175087/how-to-enable-and-secure-remote-desktop-on-windows/</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:55', 'updated_at' => '2017-12-21 11:57:55'),
            array('lang' => 'es', 'type' => 'open_redis', 'slug' => 'open_redis-es', 'problem' => 'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} dispone del servicio Redis abierto y accesible desde Internet.', 'derivated_problem' => 'Por defecto, este servicio no brinda ningun tipo de autenticación, lo que significa que cualquier entidad podria tener acceso instantaneo a sus datos.', 'verification' => NULL, 'recomendations' => 'Se recomienda alguna de las siguientes:

<ul>
<li><p>Deshabilitar el servicio.</p></li>
<li><p>Establecer reglas de firewall para denegar las consultas desde redes no autorizadas.</p></li>
</ul>', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="https://redis.io/topics/security">https://redis.io/topics/security</a></p></li>
<li><p><a href="http://antirez.com/news/96">http://antirez.com/news/96</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:55', 'updated_at' => '2017-12-21 11:57:55'),
            array('lang' => 'es', 'type' => 'open_smb', 'slug' => 'open_smb-es', 'problem' => 'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} tiene el servicio SMB (Server Message Block) accesible desde Internet.', 'derivated_problem' => 'Este servicio no utiliza encriptación y puede revelar información sensible o el host bajo su administración podría llegar a ser usado para controlar el dispositivo remotamente.', 'verification' => NULL, 'recomendations' => 'Se recomienda:

<ul>
<li><p>Establecer filtros de acceso (reglas de firewall) para exponer el servicio solo a las IPs del administrador.</p></li>
<li><p>En caso de no utilizarlo, es recomendable deshabilitar el servicio.</p></li>
</ul>', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="https://redmondmag.com/articles/2017/02/03/smb-security-flaw-in-windows-systems.aspx">https://redmondmag.com/articles/2017/02/03/smb-security-flaw-in-windows-systems.aspx</a></p></li>
<li><p><a href="https://www.us-cert.gov/ncas/current-activity/2017/01/16/SMB-Security-Best-Practices">https://www.us-cert.gov/ncas/current-activity/2017/01/16/SMB-Security-Best-Practices</a></p></li>
<li><p><a href="https://technet.microsoft.com/en-us/library/dn551363(v=ws.11).aspx">https://technet.microsoft.com/en-us/library/dn551363(v=ws.11).aspx</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:55', 'updated_at' => '2017-12-21 11:57:55'),
            array('lang' => 'en', 'type' => 'open_snmp', 'slug' => 'open_snmp-en', 'problem' => 'We would like to inform you that we have been notified that the <em>host/server</em> {{incident.hostAddress}} has the <strong>Simple Network Management Protocol</strong> (SNMP - UDP port 161) service, accessible from the Internet.', 'derivated_problem' => 'The <em>host</em> under your administration could be used to perform attacks, such as:

<ul>
<li><p>Obtain unauthorized remote access and information.</p></li>
<li><p>Brute force attacks.</p></li>
</ul>', 'verification' => NULL, 'recomendations' => 'We recommend:

* Users should be allowed and encouraged to disable SNMP.
* End-user devices should not be configured with SNMP on by default.
* End-user devices should not be routinely configured with the “public” SNMP community string.
* Establish firewall rules to filter unauthorized queries.', 'more_information' => NULL, 'is_active' => '1', 'created_at' => '2017-12-21 11:57:59', 'updated_at' => '2017-12-21 11:57:59'),
            array('lang' => 'es', 'type' => 'open_snmp', 'slug' => 'open_snmp-es', 'problem' => 'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} dispone de un servicio SNMP (UDP 161) abierto a redes ajenas de la UNLP.', 'derivated_problem' => 'El host bajo su administración podría llegar a ser usado en ataques de:

<ul>
<li><p>Obtención de información de dispositivos de red en forma remota no autorizada.</p></li>
<li><p>Configuración de dispositivos de red en forma remota no autorizada.</p></li>
<li><p>Ataques de fuerza bruta.</p></li>
</ul>', 'verification' => NULL, 'recomendations' => 'Se recomienda:

<ul>
<li><p>Deshabilitar el servicio.</p></li>
<li><p>Establecer reglas en el firewall para denegar las consultas desde redes no autorizadas.</p></li>
<li><p>No usar la comunidad por defecto.</p></li>
</ul>', 'more_information' => NULL, 'is_active' => '1', 'created_at' => '2017-12-21 11:57:55', 'updated_at' => '2017-12-21 11:57:55'),
            array('lang' => 'en', 'type' => 'open_ssdp', 'slug' => 'open_ssdp-en', 'problem' => 'We would like to inform you that we have been notified that the <em>host/server</em> {{incident.hostAddress}} has the <strong>Simple Service Discovery Protocol</strong> (SSDP) service, accessible from the Internet.', 'derivated_problem' => 'The host under your administration could be used to perform attacks, such as:
* Denial of Service attacks (DOS, DDOS).', 'verification' => NULL, 'recomendations' => 'We recommend:

<ul>
<li><p>Disable the service.</p></li>
<li><p>Establish firewall rules to filter unauthorized queries.</p></li>
</ul>', 'more_information' => '<div class = "destacated">

<ul>
<li><p>[http://es.wikipedia.org/wiki/SSDP] (http://es.wikipedia.org/wiki/SSDP)</p></li>
<li><p><a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:58:00', 'updated_at' => '2017-12-21 11:58:00'),
            array('lang' => 'es', 'type' => 'open_ssdp', 'slug' => 'open_ssdp-es', 'problem' => 'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} dispone del servicio SSDP (Simple Service Discovery Protocol) abierto y accesible desde Internet.', 'derivated_problem' => 'El host bajo su administración podría llegar a ser usado en ataques de amplificación para causar ataques de denegación de servicio (DOS, DDOS).', 'verification' => NULL, 'recomendations' => 'Se recomienda alguna de las siguientes:

<ul>
<li><p>Deshabilitar el servicio.</p></li>
<li><p>Establecer reglas de firewall para denegar las consultas desde redes no autorizadas.</p></li>
</ul>', 'more_information' => '<div class="destacated">

<ul>
<li><p>[http://es.wikipedia.org/wiki/SSDP] (http://es.wikipedia.org/wiki/SSDP)</p></li>
<li><p><a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:55', 'updated_at' => '2017-12-21 11:57:55'),
            array('lang' => 'es', 'type' => 'open_telnet', 'slug' => 'open_telnet-es', 'problem' => 'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} tiene el servicio Telnet accesible desde Internet.', 'derivated_problem' => 'Este servicio no utiliza encriptación y puede revelar información sensible o el host bajo su administración podría llegar a ser usado para controlar el dispositivo remotamente.', 'verification' => NULL, 'recomendations' => 'Se recomienda:

<ul>
<li><p>Establecer filtros de acceso (reglas de firewall) para exponer el servicio solo a las IPs del administrador.</p></li>
<li><p>En caso de no utilizarlo, es recomendable deshabilitar el servicio.</p></li>
</ul>', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="https://technet.microsoft.com/en-us/library/cc755017%28v=ws.10%29.aspx?f=255&amp;MSPPError=-2147217396">https://technet.microsoft.com/en-us/library/cc755017%28v=ws.10%29.aspx?f=255&amp;MSPPError=-2147217396</a></p></li>
<li><p><a href="https://interwork.com/qa-how-to-eliminate-the-security-risks-associated-with-telnet-ftp/">https://interwork.com/qa-how-to-eliminate-the-security-risks-associated-with-telnet-ftp/</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:55', 'updated_at' => '2017-12-21 11:57:55'),
            array('lang' => 'es', 'type' => 'open_tftp', 'slug' => 'open_tftp-es', 'problem' => 'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} dispone del servicio TFTP (Trivial file transfer Protocol) abierto y accesible desde Internet.', 'derivated_problem' => 'El host bajo su administración podría llegar a ser usado en ataques de amplificación para causar ataques de denegación de servicio (DOS, DDOS).', 'verification' => NULL, 'recomendations' => 'Se recomienda alguna de las siguientes:

<ul>
<li><p>Deshabilitar el servicio.</p></li>
<li><p>Establecer reglas de firewall para denegar las consultas desde redes no autorizadas.</p></li>
</ul>', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="https://blogs.akamai.com/2016/06/new-ddos-reflectionamplification-method-exploits-tftp.html">https://blogs.akamai.com/2016/06/new-ddos-reflectionamplification-method-exploits-tftp.html</a></p></li>
<li><p><a href="https://www.us-cert.gov/ncas/alerts/TA14-017A">https://www.us-cert.gov/ncas/alerts/TA14-017A</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:55', 'updated_at' => '2017-12-21 11:57:55'),
            array('lang' => 'es', 'type' => 'open_vnc', 'slug' => 'open_vnc-es', 'problem' => 'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} tiene el servicio VNC (Virtual Network Computer/Computing) accesible desde Internet.', 'derivated_problem' => 'Este servicio no utiliza encriptación y puede revelar información sensible o el host bajo su administración podría llegar a ser usado para controlar el dispositivo remotamente.', 'verification' => NULL, 'recomendations' => 'Se recomienda:

<ul>
<li><p>Establecer filtros de acceso (reglas de firewall) para exponer el servicio solo a las IPs del administrador.</p></li>
<li><p>En caso de no utilizarlo, es recomendable deshabilitar el servicio.</p></li>
</ul>', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="https://security.stackexchange.com/questions/124958/how-do-i-assess-and-mitigate-the-security-risks-of-a-vnc-tool">https://security.stackexchange.com/questions/124958/how-do-i-assess-and-mitigate-the-security-risks-of-a-vnc-tool</a></p></li>
<li><p><a href="http://www.mit.edu/~avp/lqcd/ssh-vnc.html">http://www.mit.edu/~avp/lqcd/ssh-vnc.html</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:55', 'updated_at' => '2017-12-21 11:57:55'),
            array('lang' => 'en', 'type' => 'phishing_mail', 'slug' => 'phishing_mail-en', 'problem' => 'We would like to inform you that we have been notified that the <em>host</em> {{incident.hostAddress}} is being used to send emails containing Phishing.', 'derivated_problem' => 'If this issue is not addressed, the <em>host</em> could be added in public lists of compromised hosts, thus emails from this host will be filtered.', 'verification' => 'It is likely that the Phishing emails are being sent by a compromised email account.
Analyzing the email header, the authenticated user being used to send the emails can be identified (See attached file).', 'recomendations' => '<ul>
<li><p>Modify the compromised user credentials.</p></li>
<li><p>Increase awareness related to Phishing attacks in the users.</p></li>
</ul>', 'more_information' => NULL, 'is_active' => '1', 'created_at' => '2017-12-21 11:58:00', 'updated_at' => '2017-12-21 11:58:00'),
            array('lang' => 'es', 'type' => 'phishing_mail', 'slug' => 'phishing_mail-es', 'problem' => 'Nos notificaron que el host/servidor {{incident.hostAddress}} está enviando correo con contenido de Phishing.', 'derivated_problem' => 'De no solucionar el problema, el host/servidor puede ser introducido en listas públicas de servidores comprometidos que pueden causar que dicho host/servidor no pueda enviar correos a otros servidores.', 'verification' => 'Es probable que el Phishing se envíe utilizando una cuenta de correo comprometida.
Analizando la cabecera del email de spam adjunto, puede distinguirse el usuario autenticado que realizó el envío del mensaje.', 'recomendations' => 'Se recomienda cambiar las credenciales de los usuarios afectados e instruir a los mismos sobre ataques de phishing, probablemente utilizado para el robo de las credenciales del usuario.', 'more_information' => NULL, 'is_active' => '1', 'created_at' => '2017-12-21 11:57:56', 'updated_at' => '2017-12-21 11:57:56'),
            array('lang' => 'en', 'type' => 'phishing_web', 'slug' => 'phishing_web-en', 'problem' => 'We would like to inform you that we have been notified that the <em>server</em> {{incident.hostAddress}} is currently hosting a web service being used to perform Phising attacks.', 'derivated_problem' => 'If this issue is not addressed, the <em>server</em> could be added in public lists of compromised hosts, forcing the web browsers to show security alerts when accessing web pages hosted in the server.', 'verification' => 'Verify the information in the attached file.', 'recomendations' => 'We recommend removing the web content being used to perform the phising attack and request a forensic analysis on the server, as to evaluate what has been compromised.', 'more_information' => '<div class = "destacated">

<ul>
<li><p><a href="https://support.google.com/chrome/answer/99020?hl=es-419">https://support.google.com/chrome/answer/99020?hl=es-419</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:58:00', 'updated_at' => '2017-12-21 11:58:00'),
            array('lang' => 'es', 'type' => 'phishing_web', 'slug' => 'phishing_web-es', 'problem' => 'Nos notificaron que el servidor {{incident.hostAddress}} está alojando un sitio web utilizado para ataques de Phishing.', 'derivated_problem' => 'Este problema puede provocar que su servidor sea introducido en listas públicas de servidores comprometidos pudiendo los navegadores disparar alertas de seguridad a los usuarios cuando accedan a cualquier página web alojada en dicho servidor.', 'verification' => 'Verificar la información enviada en el contenido adjunto.', 'recomendations' => 'Se recomienda dar de baja el contenido WEB utilizado para el ataque de phishing y solicitar a CERTUNLP un análisis forense del servidor para 
determinar la modalidad utilizada por el atacante y el nivel de compromiso del servidor.', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="https://support.google.com/chrome/answer/99020?hl=es-419">https://support.google.com/chrome/answer/99020?hl=es-419</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:56', 'updated_at' => '2017-12-21 11:57:56'),
            array('lang' => 'en', 'type' => 'poodle', 'slug' => 'poodle-en', 'problem' => 'We would like to inform you that we have been notified that the <em>server</em> {{incident.hostAddress}} is currently vulnerable to Padding Oracle On Downgraded Legacy Encryption (POODLE) attacks.', 'derivated_problem' => 'POODLE is a man-in-the-middle exploit which takes advantage of Internet and security software clients fallback to SSL 3.0. If attackers successfully exploit this vulnerability, sensitive information could be obtained by attackers, compromising confidentiality.', 'verification' => 'Access the following web page to verify that the services currently provided by your host are in fact, vulnerable to POODLE:


<div class = "destacated">

<ul>
<li><p><a href="https://www.poodlescan.com/">https://www.poodlescan.com/</a></p></li>
</ul>

</div>', 'recomendations' => 'We recommend avoiding the use of the SSLv2 and SSLv3 libraries, use TLS instead.', 'more_information' => '<div class = "destacated">

<ul>
<li><p><a href="http://www.cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2014-3566">http://www.cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2014-3566</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:58:00', 'updated_at' => '2017-12-21 11:58:00'),
            array('lang' => 'es', 'type' => 'poodle', 'slug' => 'poodle-es', 'problem' => 'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} es
vulnerable a POODLE.', 'derivated_problem' => 'POODLE es una falla en SSLv3 que permite a un atacante recuperar
información cifrada, ocasionando de esta forma pérdida de confidencialidad.', 'verification' => 'Acceda a la siguiente página para verificar que los servicios que usted
provee en el host son vulnerables a POODLE:


<div class="destacated">

<ul>
<li><p><a href="http://poodletest.ntt-security.com/">http://poodletest.ntt-security.com/</a></p></li>
</ul>

</div>', 'recomendations' => 'Se recomienda dejar de utilizar las librerías SSLv2 y SSLv3. Como reemplazo
puede utilizar TLS.', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="http://www.cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2014-3566">http://www.cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2014-3566</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:56', 'updated_at' => '2017-12-21 11:57:56'),
            array('lang' => 'es', 'type' => 'rpz_botnet', 'slug' => 'rpz_botnet-es', 'problem' => 'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} está realizando consultas de DNS que arrojan coincidencia con nuestra zona RPZ "BOTNET".

Dicha RPZ, contiene direcciones de red conocidas que están vinculadas a infraestructuras de botnets.


<p class="lead">Consideraciones</p>

Se debe tener en cuenta que si la IP informada es un servidor de mail, este reporte podría tratarse de un falso positivo. La razón de ello es que en la detección de SPAM, se evalúan URLs observadas en los correos electrónicos.

Por otro lado, si la IP informada es un servidor de DNS (resolver local) el origen del problema no es el servidor sino el host que le hizo la consulta DNS reportada. En este caso, la manera de detectar el host infectado es registrando las consultas DNS.', 'derivated_problem' => 'Es probable que su PC o servidor que esté intentando acceder a dominios de BOTNETs.

Esto indica que la misma esté comprometido con algún tipo de malware y quiera conectarse a un servidor C&amp;C para esperar instrucciones a ejecutar (DoS, fuerza bruta, envío de spams, etc.).', 'verification' => NULL, 'recomendations' => 'Se recomienda analizar el host de la red para verificar y solucionar el problema.', 'more_information' => NULL, 'is_active' => '1', 'created_at' => '2017-12-21 11:57:56', 'updated_at' => '2017-12-21 11:57:56'),
            array('lang' => 'es', 'type' => 'rpz_dbl', 'slug' => 'rpz_dbl-es', 'problem' => 'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} está realizando consultas de DNS que arrojan coincidencia con nuestra zona RPZ “DBL”.

Dicha RPZ, contiene información sobre direcciones de red que son utilizadas como distribuidores de malware, sitios que almacenan malware, redirecciones maliciosas, dominios usados como botnets, servidores de C&amp;C y otras actividades maliciosas.', 'derivated_problem' => 'En la mayoría de los casos puede ser un indicador de que su host está siendo utilizado para enviar spam.', 'verification' => 'Si es el host es un servidor de correo o DNS, es importante que lo notifique al CeRT. Esto es para estudiar con mayor profundidad el caso y ver si se trata de un falso positivo o si realmente su servidor de correo está comprometido.

Si el host no es un servidor de correo ni un DNS, es muy probable que tenga algún malware y sería útil chequear los procesos corriendo en el mísmo.', 'recomendations' => 'Si se trata de un servidor de correo:

<ul>
<li><p>Verificar la configuración del correo o si hay una cuenta comprometida.</p></li>
<li><p>Verificar que nuestro host no esté listado en blacklists.</p></li>
<li><p>Mejorar la infraestructura anti-spam.</p></li>
</ul>', 'more_information' => NULL, 'is_active' => '1', 'created_at' => '2017-12-21 11:57:56', 'updated_at' => '2017-12-21 11:57:56'),
            array('lang' => 'es', 'type' => 'rpz_drop', 'slug' => 'rpz_drop-es', 'problem' => 'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} está realizando consultas de DNS que arrojan coincidencia con nuestra zona RPZ “DROP”.

Dicha RPZ, consiste de bloques de red bogons, que fueron robados o liberados para generar spam u operaciones criminales.', 'derivated_problem' => 'Es probable que su dispositivo se encuentre comprometido.', 'verification' => 'Puede verificar las conexiones establecidas con el comando "netstat".


<div class="destacated">

<ul>
<li><p>netstat -ntulp</p></li>
</ul>

</div>

También verificar tráfico inusual con Wireshark como así también los procesos ejecutándose en el host.', 'recomendations' => 'Se recomienda aislar el host hasta verificar y solucionar el problema.', 'more_information' => NULL, 'is_active' => '1', 'created_at' => '2017-12-21 11:57:56', 'updated_at' => '2017-12-21 11:57:56'),
            array('lang' => 'es', 'type' => 'rpz_malware_aggressive', 'slug' => 'rpz_malware_aggressive-es', 'problem' => 'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} está realizando consultas de DNS que arrojan coincidencia con nuestra zona RPZ “MALWARE-AGGRESSIVE”.

Dicha RPZ, contiene direcciones de red conocidas que están vinculadas al malware, que mediante mecanismos normales de scoring no fueron agregados a otra lista, pero deberían ser incluidos por otras razones. Por la naturaleza de esta lista, es posible (aunque poco probable) que se reporten falsos positivos.', 'derivated_problem' => 'Esto indica que es probable que su servidor esté comprometido.', 'verification' => 'Puede verificar las conexiones establecidas con el comando "netstat".


<div class="destacated">

<ul>
<li><p>netstat -ntulp</p></li>
</ul>

</div>

También verificar tráfico inusual con Wireshark como así también los procesos ejecutándose en el host.', 'recomendations' => 'Se recomienda aislar el host hasta verificar y solucionar el problema.', 'more_information' => NULL, 'is_active' => '1', 'created_at' => '2017-12-21 11:57:56', 'updated_at' => '2017-12-21 11:57:56'),
            array('lang' => 'es', 'type' => 'rpz_malware', 'slug' => 'rpz_malware-es', 'problem' => 'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} está realizando consultas de DNS que arrojan coincidencia con nuestra zona RPZ “MALWARE”.

Dicha RPZ, contiene sólo información de direcciones de red asociadas con malwares. Están excluidos de esta lista fuentes de spam y phising, también dominios de redirección.', 'derivated_problem' => 'Esto indica que es probable que su servidor esté comprometido.', 'verification' => 'Puede verificar las conexiones establecidas con el comando "netstat".


<div class="destacated">

<ul>
<li><p>netstat -ntulp</p></li>
</ul>

</div>

También verificar tráfico inusual con Wireshark como así también los procesos ejecutándose en el host.', 'recomendations' => 'Se recomienda aislar el host hasta verificar y solucionar el problema.', 'more_information' => NULL, 'is_active' => '1', 'created_at' => '2017-12-21 11:57:56', 'updated_at' => '2017-12-21 11:57:56'),
            array('lang' => 'en', 'type' => 'scan', 'slug' => 'scan-en', 'problem' => 'We would like to inform you that we have detected that the <em>host</em> {{incident.hostAddress}} is currently performing a Scan process over other devices.', 'derivated_problem' => 'Performing a Scan analysis is likely due to the host being compromised and used to gather information about other hosts inside the network, for possible future attacks. On the other hand, this generates great amount of bandwidth consumption, generating a network speed reduction.', 'verification' => 'It can be verified by analyzing the existing network traffic, using tools such as:


<div class = "destacated">

<pre><code>tcpdump
</code></pre>

</div>

or

<div class = "destacated">

<pre><code>wireshark
</code></pre>

</div>', 'recomendations' => 'Remove the access to the network to affected host during the analysis, as to determin it\'s origin.
It is likely that attackers had gained privileges over the compromised host, we recommend you to request a forensic analysis on the server, as to evaluate what has been compromised.', 'more_information' => '<div class = "destacated">

<ul>
<li><p><a href="http://archive.oreilly.com/pub/h/1393">http://archive.oreilly.com/pub/h/1393</a></p></li>
<li><p><a href="http://inai.de/documents/Chaostables.pdf">http://inai.de/documents/Chaostables.pdf</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:58:00', 'updated_at' => '2017-12-21 11:58:00'),
            array('lang' => 'es', 'type' => 'scan', 'slug' => 'scan-es', 'problem' => 'Nos comunicamos con Ud. para comunicarle que el host {{incident.hostAddress}} se encuentra realizando un proceso de Scan sobre otros equipos de la UNLP y/o el exterior.', 'derivated_problem' => 'La realización del proceso de Scan probablemente se deba a que el equipo se encuentre comprometido y siendo utilizado para reconocer otros equipos de la red, los cuales dependiendo del scan, serán luego atacados o no.
Por otro lado este problema genera la circulación en la red grandes volúmenes de información que generan problemas o pérdidas velocidad en la misma.', 'verification' => 'Se puede realizar una verificación del problema a través del análisis del tráfico existente en la red o sobre el host afectado, utilizando herramientas como 

<div class="destacated">

<pre><code>tcpdump
</code></pre>

</div>

o 

<div class="destacated">

<pre><code>wireshark
</code></pre>

</div>', 'recomendations' => 'Se recomienda quitar el acceso del host afectado a la red durante la realización del análisis que determine el origen del tráfico.
Habiendo ocurrido una muy probable obtención de privilegios sobre el host por parte de atacantes, se recomienda la realización de una forensia sobre el equipo con el objetivo de determinar la vulnerabilidad que proporcionó dichos privilegios.', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="http://www.hackingarticles.in/detect-nmap-scan-using-snort/">http://www.hackingarticles.in/detect-nmap-scan-using-snort/</a></p></li>
<li><p><a href="http://inai.de/documents/Chaostables.pdf">http://inai.de/documents/Chaostables.pdf</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:56', 'updated_at' => '2018-05-24 11:06:34'),
            array('lang' => 'en', 'type' => 'shellshock', 'slug' => 'shellshock-en', 'problem' => 'We would like to inform you that we have been detected that the <em>host</em> {{incident.hostAddress}} has possible been attacked using the known vulnerability ShellShock.', 'derivated_problem' => 'This vulnerability allows an attacker to read the device memory, possibly compromising sensitive information such as private SSL keys.', 'verification' => 'Due to the report possible being a false positive, we recommend to verify the existence of the vulnerability using the following commands:

<div class = "destacated">

<pre><code>env x=\'() { :;}; echo vulnerable\' bash -c "echo this is a test"
</code></pre>

</div>

If the execution of the previous command returns the string "vulnerable", is most likely that the host has been compromised.', 'recomendations' => 'We recommend upgrading bash in an urgent manner, and perform a study to analyze possible backdoors in the compromised host.', 'more_information' => '<div class = "destacated">

<ul>
<li><p><a href="http://blog.segu-info.com.ar/2014/09/faq-de-shellshock-exploit-rce-ddos-y.html">http://blog.segu-info.com.ar/2014/09/faq-de-shellshock-exploit-rce-ddos-y.html</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:58:00', 'updated_at' => '2017-12-21 11:58:00'),
            array('lang' => 'es', 'type' => 'shellshock', 'slug' => 'shellshock-es', 'problem' => 'Se ha detectado que el servidor con IP {{incident.hostAddress}} posiblemente ha sido atacado mediante la vulnerabilidad conocida como ShellShock.', 'derivated_problem' => 'Esta vulnerabilidad permite a un atacante leer la memoria de un servidor o un cliente, permitiéndole por ejemplo, conseguir las claves privadas SSL de un servidor.', 'verification' => 'Debido a que este reporte puede ser un falso positivo, se recomienda comprobar que el host sea realmente vulnerable a ShellShock:

<div class="destacated">

<pre><code>env x=\'() { :;}; echo vulnerable\' bash -c "echo esto es una prueba"
</code></pre>

</div>

Si la ejecución en bash del comando anterior imprime "vulnerable", entonces es probable que el host haya sido comprometido.', 'recomendations' => 'Se recomienda actualizar bash de forma urgente y realizar un relevamiento
con el fin de comprobar que el host no contenga backdoors.', 'more_information' => '<p class="lead">Más información</p>


<div class="destacated">

<ul>
<li><p><a href="http://blog.segu-info.com.ar/2014/09/faq-de-shellshock-exploit-rce-ddos-y.html">http://blog.segu-info.com.ar/2014/09/faq-de-shellshock-exploit-rce-ddos-y.html</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:57', 'updated_at' => '2017-12-21 11:57:57'),
            array('lang' => 'en', 'type' => 'spam', 'slug' => 'spam-en', 'problem' => 'We would like to inform you that we have been informed that the <em>host</em> {{incident.hostAddress}} is possibly sending SPAM.', 'derivated_problem' => 'If this issue is not addressed, the <em>host</em> could be added in blacklists, thus emails from this host will be filtered.', 'verification' => 'It is likely that the Phishing emails are being sent by a compromised email account.
Analyzing the email header, the authenticated user being used to send the emails can be identified (See attached file).', 'recomendations' => '* Modify the compromised user credentials.
* Increase awareness related to this issue among the users.', 'more_information' => NULL, 'is_active' => '1', 'created_at' => '2017-12-21 11:58:00', 'updated_at' => '2017-12-21 11:58:00'),
            array('lang' => 'es', 'type' => 'spam', 'slug' => 'spam-es', 'problem' => 'Nos notificaron que el host {{incident.hostAddress}} está enviando SPAM.', 'derivated_problem' => 'De no solucionar el problema, su servidor puede ser introducido en distintas blacklists que causarán que dicho servidor no pueda enviar correos a otros servidores.', 'verification' => 'Es probable que el SPAM se envíe utilizando una cuenta de correo comprometida.
Analizando la cabecera del email de spam adjunto, puede distinguirse el usuario autenticado que realizó el envío del mensaje.', 'recomendations' => 'Se recomienda cambiar las credenciales de los usuarios afectados e instruir a los mismos sobre los mails de phishing, ataque que probablemente haya sido utilizado para el robo de las credenciales.', 'more_information' => NULL, 'is_active' => '1', 'created_at' => '2017-12-21 11:57:57', 'updated_at' => '2017-12-21 11:57:57'),
            array('lang' => 'en', 'type' => 'sql_injection', 'slug' => 'sql_injection-en', 'problem' => 'We would like to inform you that we have been informed that the <em>host</em> {{incident.hostAddress}} has SQL injection vulnerabilities.', 'derivated_problem' => 'The <em>host</em> under your administration could be compromising sensitive information.', 'verification' => NULL, 'recomendations' => 'We recommend analyzing the database related entries that use SQL.', 'more_information' => '<div class = "destacated">

<ul>
<li><p><a href="https://www.owasp.org/index.php/SQL_Injection">https://www.owasp.org/index.php/SQL_Injection</a></p></li>
<li><p><a href="https://www.owasp.org/index.php/SQL_Injection_Prevention_Cheat_Sheet">SQL Injection Prevention Cheat Sheet</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:58:01', 'updated_at' => '2017-12-21 11:58:01'),
            array('lang' => 'es', 'type' => 'sql_injection', 'slug' => 'sql_injection-es', 'problem' => 'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} tiene
vulnerabilidades de SQL Injection.', 'derivated_problem' => 'El <em>host</em> bajo su administración podría llegar a estar brindando información sensible, comprometiendo sistemas que corren él.', 'verification' => NULL, 'recomendations' => 'Se recomienda revisar la aplicacion verificando todas las entradas que esten relacionadas con la base de datos y el uso de sql.', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="https://www.owasp.org/index.php/SQL_Injection">https://www.owasp.org/index.php/SQL_Injection</a></p></li>
<li><p><a href="https://www.owasp.org/index.php/SQL_Injection_Prevention_Cheat_Sheet">SQL Injection Prevention Cheat Sheet</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:57', 'updated_at' => '2017-12-21 11:57:57'),
            array('lang' => 'es', 'type' => 'ssl_poodle', 'slug' => 'ssl_poodle-es', 'problem' => 'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} es
vulnerable a POODLE.', 'derivated_problem' => 'POODLE es una falla en SSLv3 que permite a un atacante recuperar
información cifrada, ocasionando de esta forma pérdida de confidencialidad.', 'verification' => 'Acceda a la siguiente página para verificar que los servicios que usted
provee en el host son vulnerables a POODLE:

<div class="destacated">

<ul>
<li><p><a href="https://www.poodlescan.com/">https://www.poodlescan.com/</a></p></li>
</ul>

</div>', 'recomendations' => 'Se recomienda dejar de utilizar las librerías SSLv2 y SSLv3. Como reemplazo
puede utilizar TLS.', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="http://www.cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2014-3566">http://www.cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2014-3566</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:57', 'updated_at' => '2017-12-21 11:57:57'),
            array('lang' => 'es', 'type' => 'suspicious_behavior', 'slug' => 'suspicious_behavior-es', 'problem' => 'Lo contactamos porque hemos sido informados que el host/servidor {{incident.hostAddress}} se está comportando de manera sospechosa.', 'derivated_problem' => 'esto se puede deber a

<ul>
<li><p>El sitio web contiene software malicioso: El sitio podría instalar software malicioso a los usuarios.</p></li>
<li><p>Sitio engañoso: El sitio web podría realizar una suplantación de identidad.</p></li>
<li><p>El sitio contiene programas peligrosos: El sitio podría engañar usuarios para instalar programas que causen problemas cuando navegan.</p></li>
</ul>', 'verification' => NULL, 'recomendations' => 'Se recomienda verificar la herramienta,aplicación o CMS que este utilizando con el fin de encotrar vulnerabilidades o malware.', 'more_information' => '<div class="destacated">

<ul>
<li><p><a href="https://www.owasp.org/index.php/Category:Vulnerability_Scanning_Tools">https://www.owasp.org/index.php/Category:Vulnerability_Scanning_Tools</a></p></li>
<li><p><a href="https://support.google.com/chrome/answer/99020?hl=es-419">https://support.google.com/chrome/answer/99020?hl=es-419</a></p></li>
</ul>

</div>', 'is_active' => '1', 'created_at' => '2017-12-21 11:57:57', 'updated_at' => '2017-12-21 11:57:57')
        );

    }
}