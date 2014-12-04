fairtradeinspires.com
=====================

Source to the e-commerce site, fairtradoeinspires.com, which has now closed shop and does the local market. 

Written in PHP, some javascript and a MySQL backing store.


### Setup

~~~
DB/db_layout.sql
~~~
This contains the database structure and can be imported to a blank database. It has categories and size/colour options relevant to fairtrade inspies' needs, so you may want to edit it.

<br>

~~~
Server/mysqli_connect_inspires.php
~~~
This file should be placed directly above the root of your server pages. It needs edited to reflect database name, username and password.

<br>

~~~
Server/public_html/shop/
~~~
This should be placed in the appropriate directery and set as the root of your site.

<br>

~~~
Server/public_html/shop/upload/
~~~
This should be password protected. It is where you go to add products. If images don't seem to upload properly, check the permissions of:
~~~
Server/public_html/shop/images/products/*
~~~
