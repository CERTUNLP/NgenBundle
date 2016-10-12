### [problem]
We would like to inform you that we have been notified that the *host* {{IP}} has the **Memcached** service, accessible from the Internet.

### [/problem]

### [derivated_problem_content]
### Related issues
Due to the service not providing an authentication mechanism, any third party accessing the Memcache service would have total over the stored information. The following items could be compromised:

* Access to sensitive information.
* Perform a defacement's attack to the web server.
* Perform a Denial of Service attack (DOS) to the server.
### [/derivated_problem_content]

### [verification_content]
### How to verify the issue
To verify that the service is currently open, use the `telnet` command in the following way:
### [destacated]
    telnet {{IP}} 11211
    stats items
### [/destacated]
### [/verification_content]

### [recommendations_content]
### Recommendations
* Establish firewall rules to filter unauthorized queries.
### [/recommendations_content]

### [more_information_content]
### For more information
### [destacated]
* [memcached.org] (memcached.org)
* [http://infiltrate.tumblr.com/post/38565427/hacking-memcache] (http://infiltrate.tumblr.com/post/38565427/hacking-memcache)
* [http://es.wikipedia.org/wiki/Defacement] (http://es.wikipedia.org/wiki/Defacement)
### [/destacated]
### [/more_information_content]
