#!/usr/bin/python3

import sys

import os
import json
import logging
import argparse
import requests
import configparser
from urllib import parse

from lib.mail_parser import MailParser


class Sira:

    def __init__(self, configfile='settings.cfg', debug=False):
        self.mail = None
        self.config = configparser.ConfigParser()
        self.config.read(os.path.dirname(os.path.abspath(__file__)) + '/' + configfile)

        if debug:
            logging.basicConfig(level=logging.DEBUG)
        else:
            logging.basicConfig(filename=self.config['logs']['error_log'], level=logging.ERROR)

    def api_incoming_report(self, spammer_host, abuse_emails):
        logging.debug('[!] Remote spamming from {0}, whose abuse emails are {1}'.format(spammer_host, abuse_email))

        # Cuando se defina la interfaz para los spams externos, modificamos esto.
        return

        apipath = 'api/v1/incidents.json?apikey=' + self.config['api']['apikey']
        headers = {'Content-Type': 'application/json'}
        payload = json.dumps({'type': 'spam', 'ip': spammer_host,
                              'feed': 'external_report'})

        url = parse.urljoin(self.config['api']['api_server'], apipath)

        session = requests.Session()
        response = session.post(url, data=payload, headers=headers, verify=False)

        print('[i] Response Status Code: {0}'.format(response.status_code))

    def api_outgoing_report(self, spammer_host):
        logging.debug('[!] Local spamming from {0}'.format(spammer_host))

        apipath = 'api/v1/incidents.json?apikey=' + self.config['api']['apikey']
        headers = {'Content-Type': 'application/json'}
        payload = json.dumps({'type': 'spam', 'ip': spammer_host,
                              'feed': 'external_report'})

        url = parse.urljoin(self.config['api']['api_server'], apipath)

        session = requests.Session()
        response = session.post(url, data=payload, headers=headers, verify=False)

        logging.debug('[i] Response Status Code: {0}'.format(response.status_code))



    def digest(self, raw_mail):
        self.mail = MailParser(self.config['network']['local_network'],
                               self.config['network']['local_netmask'],
                               self.config['network']['local_domain'])
    
        ''' Parsea el email y crea una instancia que tiene todo lo que hay que saber del email
        '''
        self.mail.digest(raw_mail)
        
        spammer_host = self.mail.get_spammer_host()
        if spammer_host:
            spammer_host = self.mail.get_spammer_host()
            if self.mail.is_incoming():
                abuse_emails = self.mail.get_abuse_emails()
                self.api_incoming_report(spammer_host, abuse_emails)
            else:
                self.api_outgoing_report(spammer_host)


''' #######################################################
                            MAIN
    #######################################################
'''
if __name__ == '__main__':

    parser = argparse.ArgumentParser()

    parser.add_argument('-d', '--debug', action='store_true',
                        help='Debug mode')

    args = parser.parse_args()

    raw_mail = sys.stdin.read()

    sira = Sira(debug=args.debug)

    sira.digest(raw_mail)
