### [problem]
We would like to inform you that we have been notified that the *host* {{IP}} is providing insecure **Network Time Protocol** (NTP) service by responding to [NTP monlist](https://www.us-cert.gov/ncas/alerts/TA14-013A) commands.
### [/problem]
### [derivated_problem_content]

### Related issues
The *host* under you'r administration could be used to perform [amplification](https://www.us-cert.gov/ncas/alerts/TA14-017A) attacks to third party's, like:

* Denial of Service attacks (DOS, DDOS).

### [/derivated_problem_content]
### [verification_content]

### How to verify the issue

To manually verify if the service is vulnerable, use the following command:

### [destacated]
    ntpdc -n -c monlist {{IP}}
### [/destacated]

### [/verification_content]
### [recommendations_content]

### Recommendations
Versions of  `ntpd` previous to 4.2.7 are vulnerable. Therefore, we recommend upgrading to the latest version available.
If upgrading is not possible, as an alternative disable `monlist`.

### [/recommendations_content]
### [more_information_content]

[More](http://www.purdue.edu/securepurdue/news/2014/advisory--ntp-amplification-attacks.cfm)
[information](http://www.team-cymru.org/ReadingRoom/Templates/secure-ntp-template.html)
about how to disable `monlist`.
### [/more_information_content]
