### [problem]
We would like to inform you that we have been notified that the *host* {{IP}} is being used to perform Denial of Service attacks (DOS), through the **SNMP service** (UDP port 161).
### [/problem]


### [verification_content]
### How to verify the issue
The verification can be achieved analyzing the existing network traffic and observing a mayor UDP traffic consumption corresponding to spoofed SNMP queries received.
### [/verification_content]

### [recomendations_content]
### Recommendations
We recommend:

*TODO pasar al español tambien, https://www.bitag.org/report-snmp-ddos-attacks.php*
* Users should be allowed and encouraged to disable SNMP.
* End-user devices should not be configured with SNMP on by default.
* End-user devices should not be routinely configured with the “public” SNMP community string.
* Establish firewall rules to filter unauthorized queries.
### [/recomendations_content]


### [more_information_content]
### For more information
### [destacated]
* [https://www.us-cert.gov/ncas/alerts/TA14-017A](https://www.us-cert.gov/ncas/alerts/TA14-017A)
### [/destacated]
### [/more_information_content]
