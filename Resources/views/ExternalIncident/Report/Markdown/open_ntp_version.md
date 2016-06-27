### [problem]
We would like to inform you that we have been notified that the *host*  {{IP}} is providing insecure **Network Time Protocol** (NTP) service by responding to `NTP readvar` commands.

### [/problem]
### [derivated_problem_content]

### Problemas derivados

The *host*  under you'r administration could be used to perform [amplification](https://www.us-cert.gov/ncas/alerts/TA14-017A) attacks to third party's, like:

* Denial of Service attacks (DOS, DDOS).

### [/derivated_problem_content]
### [verification_content]

### How to verify the issue

To manually verify if the service is vulnerable, use the following command:

### [destacated]
    ntpq -c readvar {{IP}}
### [/destacated]

### [/verification_content]
### [recommendations_content]

### Recommendations

[Disable](http://www.team-cymru.org/ReadingRoom/Templates/secure-ntp-template.html)
`NTP readvar` queries.
### [/recommendations_content]
