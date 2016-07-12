### [problem]
We would like to inform you that we have been notified that the *server* {{IP}} is currently vulnerable to Padding Oracle On Downgraded Legacy Encryption (POODLE) attacks.
### [/problem]


### [derivated_problem_content]
### Related issues
POODLE is a man-in-the-middle exploit which takes advantage of Internet and security software clients fallback to SSL 3.0. If attackers successfully exploit this vulnerability, sensitive information could be obtained by attackers, compromising confidentiality.
### [/derivated_problem_content]

### [verification_content]
### How to verify the issue
Access the following web page to verify that the services currently provided by your host are in fact, vulnerable to POODLE:

### [destacated]
* [https://www.poodlescan.com/](https://www.poodlescan.com/)
### [/destacated]
### [/verification_content]

### [recommendations_content]
### Recommendations
We recommend avoiding the use of the SSLv2 and SSLv3 libraries, use TLS instead.
### [/recommendations_content]

### [more_information_content]
### For more information
### [destacated]
* [http://www.cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2014-3566](http://www.cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2014-3566)
### [/destacated]

### [/more_information_content]
