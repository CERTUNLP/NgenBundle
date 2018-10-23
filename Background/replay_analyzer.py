#!/usr/bin/python3
import io
import os
import re
import sys
import json
import email
import requests
from urllib import parse
import configparser

config = configparser.ConfigParser()
config.read(os.path.dirname(os.path.abspath(__file__)) + '/settings.cfg')

try:
        input_stream = io.TextIOWrapper(sys.stdin.buffer, encoding='utf-8')
        raw_email = input_stream.read()
except UnicodeDecodeError:
        sys.exit(0)

message = email.message_from_string(raw_email)
subject = message['subject'].strip()

if not(re.match('^Re\:', subject) and re.search('\[CERTunlp\]', subject)):
    sys.exit()

incident_id = re.search('\[ID:(?P<id>\d+)\]', subject, re.IGNORECASE).groupdict()
from_email = message['from']

while type(message.get_payload()[0]) == email.message.Message:
    message = message.get_payload()[0]

body = message.get_payload()
body = re.split('\n[\>\-\=]', body)[0]

comment = 'From {0}\n\n{1}'.format(from_email, body)

session = requests.Session()

headers = {'content-type': 'application/json'}
payload = json.dumps({'fos_comment_comment': {'body': comment}})
url = parse.urljoin(config['api']['api_server'], '/api/v1/threads/{0}/comments.json?apikey={1}'.format(incident_id['id'], config['api']['apikey']))
print('[i] Requesting {0}'.format(url))

response = session.post(url, data=payload, headers=headers, verify=False)

print('[i] Response Status Code: {0}'.format(response.status_code))
