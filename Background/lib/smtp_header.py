
import re

from lib.dns_resolver import DNSResolver


class SMTPHeader:
    def __init__(self, header):
        self.raw_header = header
        self.resolver = DNSResolver()
        
        self.received_entries = None
        self.from_domain = None
        self.from_email = None
        self.repl_email = None

        ''' Esta variable contiene todos los campos del email que son de algun interes.
        '''
        self.interesting_fields = {}

        self.extra_info = []

    def __str__(self):
        return str(self.received_entries) + ' - {0} - {1}'.format(self.from_email,
                                                                  self.repl_email)

    def _get_valid_references(self, data_block):

        valid_occurrences = {}

        ips = set(re.findall('(?:^|[\s\[\(])((?:\d{1,3}(?:\.\d{1,3}){3}))(?:$|[\s\]\)])', data_block))
        domains = re.findall('([\w\.\-_]+\.[a-zA-Z]{2,3})', data_block)
        
        _tmp = []
        for domain in domains:
            if domain in _tmp:
                continue
            ip = self.resolver.gethostbyname(domain)
            if ip:
                _tmp.append(domain)
                continue

        valid_occurrences['ips'] = list(ips)
        valid_occurrences['domains'] = list(_tmp)

        return valid_occurrences
    
    '''
    '''
    def _received_tags(self):
        
        _tmp_split = re.split('\n\s*[A-Z][\w\-_]+:\s', self.raw_header)
        raw_received = [item for item in _tmp_split if re.search('^from\s|^by\s', item.strip(), flags=re.IGNORECASE)]
        raw_received = [item for item in raw_received if re.search('by\s', item, flags=re.IGNORECASE)]

        received = []
        for received_entry in raw_received:

            tag_components = re.split('by\s', received_entry)

            _by_tag = re.findall('[^\n]+', tag_components[1])[0]

            _from = self._get_valid_references(tag_components[0])
            _by = self._get_valid_references(_by_tag)

            _for_match = re.search('for\s+<?([\w\._\-]+@[\w\._\-]+)', tag_components[1])
            _for = None
            if _for_match:
                _for = _for_match.groups()[0]

            received.append({'from': _from, 'by': _by, 'for': _for})
        
        return received
    
    '''
    '''
    def get_interesting_fields(self):
        fields = ['delivered-to', 'x-sender-host-address']

        for field in fields:
            matches = re.findall(field + ':[^\n]+', self.raw_header, flags=re.IGNORECASE)
            if matches:
                self.interesting_fields[field] = matches[-1].strip() # La ultima ocurrencia

        try:
            self.interesting_fields = re.findall('[\w\.\-_]+@[\w\.]+', delivered_to[-1], flags=re.IGNORECASE)[0]
        except:
            pass

    ''' Obtenemos toda la informacion que el email ofrece en cuanto a
        quien envio el email (dominio, emails, etc).
    '''
    def _sender_data(self):

        repl_email = re.findall('Reply-To:[^\n]+', self.raw_header, flags=re.IGNORECASE)
        for line in repl_email:
            self.repl_email = re.findall('([\w\.\-]+@[\w\.]+)>?\s*$', line, flags=re.IGNORECASE)

        from_email = re.findall('From:[^\n]+', self.raw_header, flags=re.IGNORECASE)
        for line in from_email:
            self.from_email = re.findall('([\w\.\-_]+@[\w\.]+)\s*>?\s*$', line, flags=re.IGNORECASE)

        if self.from_email:
            self.from_domain = self.from_email[0].split('@')[1]

    '''
        Informacion de control que se le pasa al programa a traves del Subject del email.
    '''
    def _extra_info(self):
        subject = re.findall('\sSubject:([^\n]+)', self.raw_header, flags=re.IGNORECASE)

        try:
            self.extra_info = subject[0].strip()
        except:
            pass
    
    def digest(self):

        self._sender_data()
        self.get_interesting_fields()
        self._extra_info()

        self.received_entries = self._received_tags()
        self.received_entries.reverse()
