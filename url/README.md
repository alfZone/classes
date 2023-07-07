// --------------------------------------------------------------------------------
// @version 1.1 - readme.txt
// --------------------------------------------------------------------------------
// License GNU/LGPL - March 2021
// @author António Lira Fernandes - alf@esmonserrate.org
// https://github.com/alfZone
// --------------------------------------------------------------------------------




0 - Sommaire
============
    1 - Introduction
    2 - What's new
    3 - Corrected bugs
    4 - Known bugs or limitations
    5 - License
    6 - Warning
    7 - Documentation
    8 - Author
    9 - Contribute

1 - Introduction
================

 # URL
 Generic class that allows get parts of the url
 
 The idea for this object is to facilitate the obtentions of parts of the url.

 ## public function getUrlPart($pos,$order="normal")
 This method return a part of the url located in the position $pos starting from tbe left, by default, or conting from right suplaying $order!="normal". 

http://www.domain.com/part1/part2/part3/part3/last
```
 $url=new URL();
 $param3=$url->getUrlPart(3);
 $last=$url->getUrlPart(1,"i");
```

2 - What's new
==============

      


3 - Corrected bugs
==================



4 - Known bugs or limitations
=============================

  

5 - License
===========

  Is released under GNU/LGPL license.
  This library is free, so you can use it at no cost.

  I will also appreciate that you send me a mail (alf@esmonserrate.org), just to
  be aware that someone is using #tabledb.

  For more information about GNU/LGPL license : http://www.gnu.org

6 - Warning
=================

  This library and the associated files are non commercial, non professional work.
  It should not have unexpected results. However if any damage is caused by this software
  the author can not be responsible.
  The use of this software is at the risk of the user.

7 - Documentation
=================

  

8 - Author
==========

  This software was written by António Lira Fernandes (alf@esmonserrate.org) on its leasure time.

9 - Contribute
==============
  If you want to contribute to the development of FILE, please contact alf@esmonserrate.org.
 
