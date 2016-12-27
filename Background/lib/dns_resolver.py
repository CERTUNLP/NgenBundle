
import re
import dns.resolver


class DNSResolver:

    def __init__(self):
        self.resolver = dns.resolver.Resolver()
        self.resolver.lifetime = 4

        self.resolved = {'A':{}, 'MX':{}}

    def gethostbyname(self, hostname):

        # Si es una IP no hacemos nada
        if re.match('(\d{1,3}\.){3}\d{1,3}', hostname):
            return hostname

        if hostname in self.resolved['A']:
            return self.resolved['A'][hostname]

        try:
            response = self.resolver.query(hostname)
            response = response[0]
        except:
            return None

        result = response.to_text()

        self.resolved['A'][hostname] = result
        return result

    def getmxips(self, hostname):
        # Si es una IP, no hacemos nada
        if re.match('(\d{1,3}\.){3}\d{1,3}', hostname):
            return hostname

        if hostname in self.resolved['MX']:
            return self.resolved['MX'][hostname]

        try:
            responses = self.resolver.query(hostname, 'MX')
        except:
            return []

        self.resolved['MX'][hostname] = [self.gethostbyname(response.exchange.to_text()) for response in responses]
        return self.resolved['MX'][hostname]
