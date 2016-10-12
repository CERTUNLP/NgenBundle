### [problem]
We would like to inform you that we have been notified that the *host/server*  {{IP}} has the **Portmap** service, accessible from the Internet.
### [/problem]

### [derivated_problem_content]
### Related issues

The *host* under your administration could be used to perform [amplification](https://www.us-cert.gov/ncas/alerts/TA14-017A) attacks to third party's, like:

* Denial of Service attacks (DOS, DDOS).

Additionally, the **host/servidor** could expose other misconfigured services, such as NFS shared folders.

### [/derivated_problem_content]

### [verification_content]
### How to verify the issue

To manually verify if the service is vulnerable, use the following command:
### [destacated]
    rpcinfo -T udp -p {{IP}}
### [/destacated]
View the NFS shared folders using the command:
### [destacated]
    showmount -e {{IP}}
### [/destacated]

### [/verification_content]
### [recommendations_content]

### Recommendations

* We recommend filtering unauthorized access to Portmap service, or disabling the service.
* If NFS shared folders are being used, use proper filtering methods, or deactivate the feature.

### [/recommendations_content]

### [more_information_content]

### For more information
### [destacated]
* [https://web.nvd.nist.gov/view/vuln/detail?vulnId=CVE-2005-2132](https://web.nvd.nist.gov/view/vuln/detail?vulnId=CVE-2005-2132)
* [http://blog.level3.com/security/a-new-ddos-reflection-attack-portmapper-an-early-warning-to-the-industry/](http://blog.level3.com/security/a-new-ddos-reflection-attack-portmapper-an-early-warning-to-the-industry/)
* [https://www.us-cert.gov/ncas/alerts/TA14-017A](https://www.us-cert.gov/ncas/alerts/TA14-017A)

### [/destacated]
### [/more_information_content]
