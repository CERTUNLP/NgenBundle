### [problem]
We would like to inform you that we have been notified that the **host/servidor** {{IP}} provides insecure **DNS** services. The service  [responds to recursive queries](https://www.us-cert.gov/ncas/alerts/TA13-088A) originated outside your network.
### [/problem]

### [derivated_problem_content]
### Related issues

The *host* under your administration could be used to perform [amplification](https://www.us-cert.gov/ncas/alerts/TA14-017A) attacks. This could allow attacks such as:

* Dos (Denial of service)
* DDOS (Distributed denial of service)

Additionally , the host could be exposed to DNS cache poisoning or **Pharming**..

### [/derivated_problem_content]

### [verification_content]
### How to verify the issue

Use the following command:
### [destacated]
    dig +short test.openresolver.com TXT @{{IP}}
### [/destacated]
or use the following web page:
### [destacated]
    http://openresolver.com/?ip={{IP}}
### [/destacated]

### [/verification_content]
### [recommendations_content]

### Recommendations

Disable recursive answers to queries that does not originate from networks under you'r administration.

### [/recommendations_content]

### [more_information_content]

### For more information
### [destacated]
* [https://www.us-cert.gov/ncas/alerts/TA13-088A](https://www.us-cert.gov/ncas/alerts/TA13-088A)
* [https://www.us-cert.gov/ncas/alerts/TA14-017A](https://www.us-cert.gov/ncas/alerts/TA14-017A)

### [/destacated]
### [/more_information_content]
