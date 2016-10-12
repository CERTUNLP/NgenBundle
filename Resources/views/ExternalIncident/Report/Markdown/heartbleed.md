### [problem]
We would like to inform you that we have detected that the *host* {{IP}} has possible been attacked trough the OpenSSL vulnerability, known as "[Heartbleed](http://heartbleed.com/)".

### [/problem]

### [derivated_problem_content]
### Related issues

This vulnerability allows an attacker to read part of the memory of a client or server, possibly compromising sensible data.

### [/derivated_problem_content]


### [verification_content]
### How to verify the issue
To verify the vulnerability, access the following site and follow the instructions
### [destacated]
    https://filippo.io/Heartbleed/
### [/destacated]
### [/verification_content]

### [recommendations_content]
### Recommendations

We recommend an immediate  upgrade of the OpenSSL library on the compromised host, and reboot all the services linked to the library.
The SSL certificate on the host could have been compromised, therefore we recommend generating a new one.

### [/recommendations_content]

### [more_information_content]
### For more information
### [destacated]
* [https://www.openssl.org/news/secadv_20140407.txt](https://www.openssl.org/news/secadv_20140407.txt)
### [/destacated]

### [/more_information_content]
