
import re
import socket
import struct
import logging

# from lib.whois_api import Whois
from lib.rdap_api import RDAP
from lib.dns_resolver import DNSResolver
from lib.smtp_header import SMTPHeader


class MailParser:
    
    def __init__(self, network, netmask, domain):
        self.domain = domain
        self.network = network
        self.netmask = netmask
        self.resolver = DNSResolver()
        
        self.header_entities = ['\nReceived:', '\nFrom:', '\nSubject:']
        self.phishing_conditions = ['password', 'contrase[^a\s]+a', 'clave']
        
        self.raw_email = None
        self.spam_email = ''
        
        self.is_phishing = False
        self.spammer_host = None
        
        self.spam_header = None
        self.reporter_header = None

    def __str__(self):
        if self.is_phishing:
            return "phishing"
        return "spam"

    def _is_header(self, chunck):
        for entity in self.header_entities:
            if not re.search(entity, chunck):
                return False
        return True

    def _is_local_ip(self, ip):
        if not ip:
            return False
        
        ip_32bits = struct.unpack('i', socket.inet_aton(ip))[0]
        mask_32bits = struct.unpack('i', socket.inet_aton(self.netmask))[0]
        
        network_ip = struct.pack('i', (ip_32bits & mask_32bits))
        
        if socket.inet_ntoa(network_ip) == self.network:
            return True
        return False

    def _is_private_ip(self, ip):

        a, b, c, d = ip.split('.')

        if a == '10':
            pass
        elif (a == '172') and (int(b) >= 16) and (int(b) <= 31):
            pass
        elif (a == '192') and (b == '168'):
            pass
        elif a == '127':
            pass
        else:
            return False
        return True
    
    def _is_ip_addrs(self, host):
        if re.match('(?:\d{1,3}\.){3}(?:\d{1,3})', host):
            return True
        return False

    def _get_spam_email(self):
        last_index = 0
        index = 0

        while True:
            match = re.search('\r\n\r\n|\n\n', self.raw_email[index:])
            
            if not (match and re.search('\sReceived:\s', self.raw_email[index:])):
                break

            last_index = index
            index += (match.start() + len(match.group()))

        return self.raw_email[last_index:]

    ''' ################# - Public Interface - ##################
    '''
    def is_incoming(self):
        return not self._is_local_ip(self.spammer_host)

    def clean_body(self):
        
        mails = set(re.findall('[\w\.\-]+@(?:[\w\-]+\.)*' + self.domain, self.spam_email))
        
        result = self.spam_email
        
        replace_mail = 'nobody@{0}'.format(self.domain)
        for mail in mails:
            if self.domain in mail:
                result = result.replace(mail, replace_mail)
        
        return result
    
    ''' METODO CONFLICTIVO!!!
        Este metodo se encarga de buscar, en los headers del mail de
        spam, la informacion necesaria para saber que host es el spammer.
    '''
    def get_spammer_host(self):

        if self.spammer_host:
            return self.spammer_host

        ips = None
        for key in ['Spam', 'Abuse']:
            if re.search(key, self.reporter_header.extra_info, flags=re.IGNORECASE):
                ips = re.findall('(?:^|[\s\[\(])((?:\d{1,3}(?:\.\d{1,3}){3}))(?:$|[\s\]\)])', self.reporter_header.extra_info)
                break

        if ips:
            local_ips = [ip for ip in ips if self._is_local_ip(ip)]
            if local_ips:
                self.spammer_host = local_ips[0]
                return self.spammer_host

        ''' Controlar que la IP del FROM del primer received no sea de la UNLP (SpamCop)
        '''

        if 'x-sender-host-address' in self.spam_header.interesting_fields:
            dt_ips = self.spam_header.interesting_fields['x-sender-host-address']

        elif 'delivered-to':
            dt_domain = self.spam_header.interesting_fields['delivered-to'].split('@')[1]
            dt_ips = self.resolver.getmxips(dt_domain)

        else:
            return None

        self.spammer_host = None
        for received in self.spam_header.received_entries:

            ips = [ip for ip in received['by']['ips'] if not self._is_private_ip(ip)]
            _ips = [self.resolver.gethostbyname(domain) for domain in received['by']['domains']]
            ips += [ip for ip in _ips if not self._is_private_ip(ip)]

            if not ips:
                continue

            if received['for']:
                dt_domain = received['for'].split('@')[1]
                dt_ips = self.resolver.getmxips(dt_domain)

            if set(ips).intersection(dt_ips):
                self.spammer_host = received['from']['ips'][0]
            else:
                self.spammer_host = ips[0]

            if self.spammer_host:
                break

        logging.debug("SPAMMER!!!: {0}".format(self.spammer_host))

        return self.spammer_host

    def get_spammer_email(self):

        raw_emails = (self.spam_header.repl_email +
                      self.spam_header.from_email)
        
        emails = [mail for mail in raw_emails if self.domain not in mail]
        
        if not emails:
            emails = ['']
            
        return emails[0]

    def get_abuse_emails(self):
        ''' Sacamos la IP del sitio que usa whois. En caso de que no funcione, inventamos mails a
            partir del dominio
        '''
        rdap = RDAP()
        ip = self.resolver.gethostbyname(self.get_spammer_host())
        emails = rdap.get_ip_abuse_emails(ip)
        if emails:
            return emails

        ''' Si llego a esta instancia es porque no encontro nada, entonces hay inventar el email
            en base a lo que sabemos
        '''
        domain = self.get_spammer_host()
        if self._is_ip_addrs(domain):
            return None

    def reporter(self):
        return list(self.reporter_header.received_entries[0]['from']['ips'])[0]

    def digest(self, raw_email):

        self.raw_email = raw_email

        ''' Spliteamos el mail en todos los posibles headers y despues
            vemos cuales lo son en base a como estan compuestos
        '''
        chuncks = re.split('\r\n\r\n|\n\n', self.raw_email)

        headers = [chunck for chunck in chuncks if self._is_header(chunck)]

        self.spam_header = SMTPHeader(headers[-1].strip())
        self.spam_header.digest()

        self.reporter_header = SMTPHeader(headers[0].strip())
        self.reporter_header.digest()

        ''' Extraemos el email de spam del email raw
        '''
        self.spam_email = self._get_spam_email()
        logging.debug('[!] Spammer email: {0}'.format(self.spam_email))
        with open('/tmp/spam.eml', 'w') as spam_file:
            spam_file.write(self.spam_email)
        
        ''' Controlamos si es un phishing
        '''
        for regex in self.phishing_conditions:
            if re.search(regex, self.spam_email, re.IGNORECASE):
                self.is_phishing = True
                break
