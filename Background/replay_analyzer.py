'''
 This file is part of the Ngen - CSIRT InternalIncident Report System.
 
 (c) CERT UNLP <support@cert.unlp.edu.ar>
 
 This source file is subject to the GPL v3.0 license that is bundled
 with this source code in the file LICENSE.
'''

#!/usr/bin/python3
import io
import re
import sys
import json
import email
import requests
from urllib import parse

import config

'''
    http://163.10.42.233/app_dev.php/api/v1/threads/1783/comments.html

    fos_comment_comment[body]="LALALALAL Soy hacker"
'''
input_stream = io.TextIOWrapper(sys.stdin.buffer, encoding='latin1')
raw_email = input_stream.read()

message = email.message_from_string(raw_email)
subject = message['subject'].strip()

if not(re.match('^Re\:', subject) and re.search('\[CERTunlp\]', subject)):
    sys.exit()

incident_id = re.search('\[ID:(?P<id>\d+)\]', subject, re.IGNORECASE).groupdict()
from_email = message['from']

print('[incident] {id}'.format(**incident_id))

while type(message.get_payload()[0]) == email.message.Message:
    message = message.get_payload()[0]

body = message.get_payload()
body = re.split('\n[\>\-\=]', body)[0]

comment = 'From {0}\n\n{1}'.format(from_email, body)

session = requests.Session()

headers = {'content-type': 'application/json'}
payload = json.dumps({'fos_comment_comment' : {'body': comment}})
url = parse.urljoin(config.api_server, '/api/v1/threads/{0}/comments.json?apikey={1}'.format(incident_id['id'], config.apikey))
print('[i] Requesting {0}'.format(url))

response = session.post(url, data=payload, headers=headers, verify=False)

print('[i] Response Status Code: {0}'.format(response.status_code))



