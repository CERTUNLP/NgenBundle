### [problem]
We would like to inform you that we have been detected that the *host* {{IP}} has possible been attacked using the known vulnerability ShellShock.

### [/problem]

### [derivated_problem_content]
### Related issues

This vulnerability allows an attacker to read the device memory, possibly compromising sensitive information such as private SSL keys.


### [/derivated_problem_content]


### [verification_content]
### How to verify the issue
Due to the report possible being a false positive, we recommend to verify the existence of the vulnerability using the following commands:
### [destacated]
    env x='() { :;}; echo vulnerable' bash -c "echo this is a test"
### [/destacated]
If the execution of the previous command returns the string "vulnerable", is most likely that the host has been compromised.
### [/verification_content]

### [recommendations_content]
### Recommendations

We recommend upgrading bash in an urgent manner, and perform a study to analyze possible backdoors in the compromised host.


### [/recommendations_content]

### [more_information_content]
### For more information
### [destacated]
* [http://blog.segu-info.com.ar/2014/09/faq-de-shellshock-exploit-rce-ddos-y.html](http://blog.segu-info.com.ar/2014/09/faq-de-shellshock-exploit-rce-ddos-y.html)
### [/destacated]
### [/more_information_content]
