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
from email.header import decode_header

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

from_complete = decode_header(message['from'])
from_email = from_complete[0][0]
if len(from_complete) > 1 and from_complete[1]:
    from_email = "{0}{1}".format(from_complete[0][0].decode(), from_complete[1])

while type(message.get_payload()[0]) == email.message.Message:
    message = message.get_payload()[0]

body = message.get_payload()
tmp_body = re.split('\n[\>\-\=]', body)
if len(tmp_body) > 1:
    # delete message On ... wrote:
    body = '\n'.join(tmp_body[0].split('\n')[:-1])


comment = 'From {0}\n\n{1}'.format(from_email, body)

session = requests.Session()

headers = {'content-type': 'application/json'}
payload = json.dumps({'fos_comment_comment': {'body': comment}})
url = parse.urljoin(config['api']['api_server'], '/api/v1/threads/{0}/comments.json?apikey={1}'.format(incident_id['id'],
                                                                                             config['api']['apikey']))
print('[i] Requesting {0}'.format(url))

response = session.post(url, data=payload, headers=headers, verify=False)

print('[i] Response Status Code: {0}'.format(response.status_code))