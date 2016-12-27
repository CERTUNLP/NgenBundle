### [problem]
LWe would like to inform you that we have detected that the DNS *server* with IP {{IP}} has zone transfer active in some zones, visible at least from our CERT network.

### [/problem]

### [derivated_problem_content]
### Problemas derivados
The *server* under your administration could be used in DNS amplification attacks.

### [/derivated_problem_content]

### [verification_content]
### How to verify the issue
Use the following command:
### [destacated]
    dig <zona>.unlp.edu.ar @{{IP}} axfr
### [/destacated]
### [/verification_content]

### [recommendations_content]
### Recommendations
We recommend establishing restrictions to the DNS server allowing zone queries only from secondary DNS servers.

### [/recommendations_content]

### [more_information_content]
### For more information
### [destacated]
* [http://www.sans.org/reading_room/whitepapers/dns/securing-dns-zone-transfer_868](http://www.sans.org/reading_room/whitepapers/dns/securing-dns-zone-transfer_868)
* [http://www.esdebian.org/wiki/transferencias-zonas-bind9](http://www.sans.org/reading_room/whitepapers/dns/securing-dns-zone-transfer_868)

### [/destacated]

### [/more_information_content]
