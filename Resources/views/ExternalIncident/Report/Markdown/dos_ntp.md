### [problem]
We would like to inform you that we have been notified that the *host* {{IP}} is being used to perform Denial of Service attacks (DOS), through the **NTP service** (UDP port 123).
### [/problem]

### [verification_content]
### How to verify the issue

The verification can be achieved analyzing the server response to the commands ***NTP readvar*** and/or ***NTP monlist***. To manually verify if the service responds to these types of commands, use the following commands:

### [destacated]
    ntpq -c readvar [{{IP}}]
    ntpdc -n -c monlist [{{IP}}]
### [/destacated]
### [/verification_content]

### [recommendations_content]
### Recommendations

To address the ***NTP readvar*** issue, we recommend:

### [destacated]
[Disable](http://www.team-cymru.org/ReadingRoom/Templates/secure-ntp-template.html)
`NTP readvar` queries.
### [/destacated]

To address the ***NTP monlist*** issue, we recommend:

### [destacated]

Versions of `ntpd` previous to 4.2.7 are vulnerable. Therefore, we recommend upgrading to the latest version available.
If upgrading is not possible, as an alternative disable `monlist`.

[More](http://www.purdue.edu/securepurdue/news/2014/advisory--ntp-amplification-attacks.cfm)
[Information](http://www.team-cymru.org/ReadingRoom/Templates/secure-ntp-template.html)
about how to disable `monlist`.

### [/destacated]
### [/recommendations_content]

### [more_information_content]
### For more information
### [destacated]
* [https://www.us-cert.gov/ncas/alerts/TA14-017A](https://www.us-cert.gov/ncas/alerts/TA14-017A)
### [/destacated]
### [/more_information_content]
