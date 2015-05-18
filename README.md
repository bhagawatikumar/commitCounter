#Contributor Commit Counter (GitHub/BitBucket)
Commit Counter helps to get the count the commit done by a Contributer 

## Requirements

* LAMP
* PHP >= 5.2.
* PHP curl extension must be enabled


Installation / Usage
--------------------

* Download the repository using URL

```html
   https://github.com/bhagawatikumar/commitCounter/archive/master.zip 
```   


* Go to download folder

```shell
    $ cd /home/user/Downloads/
```

* Unzip the downloaded folder 

```shell
    $ sudo unzip commitCounter-master.zip
```

* Go to folder
    
```shell
    $ cd commitCounter-master/
``` 

* Run the following command to get the count

```shell
    $ php commit-count.php -u Username -p secret https://bitbucket.org/example/test contributer 
```
```shell
    $ php commit-count.php -u Username -p secret https://github.com/example/test contributer 
```

Output
--------------------
Count of commits by the contributer in the shell

*Sample Output

```shell
    $ php commit-count.php -u Username -p secret https://github.com/example/test contributer 
    Total Number Of Commits by contributer : 11 

```


Add New Service Except GitHub/BitBucket
----------------------
1. Add the API URL in app/Constant.php

2. Write response parsing logic in app/Api.php

3. Add a switch case statement in method processRequest for the new service 



Author
-----------------------
Bhagawati Kumar (bhagawatikumar@gmail.com)
