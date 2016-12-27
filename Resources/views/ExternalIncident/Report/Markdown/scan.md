### [problem]
We would like to inform you that we have detected that the *host* {{IP}} is currently performing a Scan process over other devices.

### [/problem]

### [derivated_problem_content]
### Related issues

Performing a Scan analysis is likely due to the host being compromised and used to gather information about other hosts inside the network, for possible future attacks. On the other hand, this generates great amount of bandwidth consumption, generating a network speed reduction.


### [/derivated_problem_content]

### [verification_content]
### How to verify the issue

It can be verified by analyzing the existing network traffic, using tools such as:

### [destacated]
    tcpdump
### [/destacated]
or
### [destacated]
    wireshark
### [/destacated]

### [/verification_content]
### [recommendations_content]

### Recommendations

Remove the access to the network to affected host during the analysis, as to determin it's origin.
It is likely that attackers had gained privileges over the compromised host, we recommend you to request a forensic analysis on the server, as to evaluate what has been compromised.
### [/recommendations_content]

### [more_information_content]

### For more information
### [destacated]
* [http://archive.oreilly.com/pub/h/1393](http://archive.oreilly.com/pub/h/1393)
* [http://inai.de/documents/Chaostables.pdf](http://inai.de/documents/Chaostables.pdf)

### [/destacated]
### [/more_information_content]
