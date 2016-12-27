
import json
import requests


class RDAP:

    arin_rdap_url = 'https://rdap.arin.net/registry/ip/{0}'

    def get_ip_abuse_emails(self, host_ip):

        # ARIN redirect you to the correct rdap service.
        session = requests.Session()
        response = session.get(self.arin_rdap_url.format(host_ip))

        if response.status_code != 200:
            return []

        abuse_emails = set()
        extra_emails = set()
        entities = json.loads(response.text)['entities']
        while entities:
            entity = entities.pop(0)
            entities += entity['entities'] if 'entities' in entity else []
            if 'roles' in entity:
                if 'abuse' in entity['roles']:
                    abuse_emails.update([entry[-1] for entry in entity['vcardArray'][1] if entry[0] == 'email'])

                if 'noc' in entity['roles'] or 'technical' in entity['roles']:
                    extra_emails.update([entry[-1] for entry in entity['vcardArray'][1] if entry[0] == 'email'])

        return list(abuse_emails) if abuse_emails else list(extra_emails)


if __name__ == '__main__':
    import sys
    if len(sys.argv) < 2:
        print('[!] $ {0} <ip>'.format(sys.argv[0]))
        sys.exit(-1)
    rdap = RDAP()
    print(rdap.get_ip_abuse_emails(sys.argv[1]))