
import re
import subprocess


class Whois:

    servers = [{'url': 'afrinic.net', 'name': 'afrinic'},
               {'url': 'apnic.net', 'name': 'apnic'},
               {'url': 'lacnic.net', 'name': 'lacnic'},
               {'url': 'ripe.net', 'name': 'ripe'},
               {'url': 'arin.net', 'name': 'arin'}]

    def get_ip_abuse_emails(self, host_ip):
        emails = []

        for server in self.servers:
            output = subprocess.check_output(['whois', '-h', 'whois.' + server['url'], host_ip])
            response = output.decode('utf8')

            lines = response.split('\n')
            for line in lines:
                if re.match('changed:\s+', line):
                    continue
                email_matches = re.findall('[\w\-_\.]+@(?:[\w\-_]+\.)+\w+', line)
                if email_matches:

                    email_type = 'normal'
                    if re.search('abuse', line, re.IGNORECASE):
                        email_type = 'abuse'

                    email_tuple = (email_matches[0].lower(), email_type)

                    if email_tuple not in emails:
                        emails.append(email_tuple)

        nic_domains = [server['url'] for server in self.servers]
        no_nic_emails = [email for email in emails if email[0].split('@')[1] not in nic_domains]
        if no_nic_emails:
            emails = no_nic_emails

        abuse_emails = [email[0] for email in emails if email[1] == 'abuse']
        if abuse_emails:
            emails = abuse_emails
        else:
            emails = [email[0] for email in emails]

        return emails


if __name__ == "__main__":
    import sys
    if len(sys.argv) < 2:
        print('[!] $ {0} <ip>'.format(sys.argv[0]))
        sys.exit()
    whois = Whois()
    print(whois.get_ip_abuse_emails(sys.argv[1]))


