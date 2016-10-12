
### [problem]
We would like to inform you that we have been notified that the *host* {{IP}} is being used to perform Denial of Service attacks (DOS), through the **chargen** service (UDP port 19).
### [/problem]


### [verification_content]
### How to verify the issue
The verification can be achieved analyzing the existing network traffic and observing UDP datagrams from and towards the port 19. Alternatively, it can be verified by manually connecting to the service using the following command:
### [destacated]
    ncat -u {{IP}} 19
### [/destacated]
### [/verification_content]

### [recommendations_content]
### Recommendations
We recommend:
### [destacated]
* Disable corresponding service.
* Establish firewall rules to filter incoming and outgoing network traffic in the port 19/UDP.
### [/destacated]
### [/recommendations_content]


### [more_information_content]
### For more information
### [destacated]
* [https://www.us-cert.gov/ncas/alerts/TA14-017A](https://www.us-cert.gov/ncas/alerts/TA14-017A)
### [/destacated]
### [/more_information_content]
