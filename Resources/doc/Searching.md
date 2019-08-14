# Searchs
## General Search

You can search in any screen of Ngen using the search box at the top left.


## How to use it

* Ngen uses context for searchs at input 'search' box. For example, if you are in networks list, the search is going to be applied to find a Network in the system.
  * You can search using simple/keyword search, you just enter any term and press search, Ngen will try to match anything in his indexes with this term.
  * You can write your own elastic specific search using the indexes. Take a look at the Section Elastic Indexes.

![alt text](https://github.com/CERTUNLP/NgenBundle/raw/master/Resources/doc/imagenes/ngenfilters.png) 
  
 ## Specific Filters
 
 * In all item lists you can access to pre-writed filters plus the search box.

![alt text](https://github.com/CERTUNLP/NgenBundle/raw/master/Resources/doc/imagenes/ngenfilters.png)


* In the way it works the differents terms and filters you enter are going to be aggregated as 'and' clause.  
 
![alt text](https://github.com/CERTUNLP/NgenBundle/raw/master/Resources/doc/imagenes/ngenfilters.png)

 ## Advanced Search
 
 * Take a look at Resosurces/config/elastica_config.yml to see all the parameters you can use.
 * Some examples:
 
