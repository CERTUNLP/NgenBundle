# Searchs
## General Search

You can search in any screen of Ngen using the search box at the top left.


## How to use it

Ngen uses context for searchs at input 'search' box. For example, if you are in networks list, the search is going to be applied to find a Network in the system.
  * You can search using simple/keyword search, you just enter any term and press search, Ngen will try to match anything in his indexes with this term. i.e search 'spam'.
![alt text](https://github.com/CERTUNLP/NgenBundle/raw/master/Resources/doc/images/searchspam.png)

  * You can write your own elastic specific search using the indexes. Take a look at the Section Elastic Indexes. i.e you can search for incidents in your own constituency using search 'network.discr:"internal"'.
![alt text](https://github.com/CERTUNLP/NgenBundle/raw/master/Resources/doc/images/advancedsearch.png)

  
 ## Specific Filters
 
 * In incidents list you can access to pre-writed filters plus the search box. i.e filter incidets that feed is 'external report'.
![alt text](https://github.com/CERTUNLP/NgenBundle/raw/master/Resources/doc/images/filterexternalreport.png)

* In the way it works the differents terms and filters you enter are going to be aggregated as 'and' clause. i.e search 'spam' in input box and state 'undefined' in column filter.
![alt text](https://github.com/CERTUNLP/NgenBundle/raw/master/Resources/doc/images/spamwithundefined.png)

 ## Advanced Search
 
 * Take a look at [Resosurces/config/elastica_config.yml](https://github.com/CERTUNLP/NgenBundle/blob/master/Resources/config/elastica_config.yml) to see all the parameters you can use.
 * As example you can search an Elastic query like 'network.discr:"internal" && vnc' with filters feed 'Shadowserver' and state 'staging'.
![alt text](https://github.com/CERTUNLP/NgenBundle/raw/master/Resources/doc/images/advancedsearch2.png)
 
