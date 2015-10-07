<?php

define('table_test', 'name;date;isactive');

define('table_brand', 'name');
define('table_category', 'name;description');
define('table_configuration', 'name;value;label');
define('table_customer', 'name;tel;description;date;created_date;isboss');
define('table_customer_order', 'id;name;tel;description;date;created_date;isboss');
define('table_user_role','role_id;description;user_id');
define('table_user','shop_id;name;email;phone_number;username;password;confirmcode;status;start_date;end_date;description');
define('table_customer_reservation_histo','customer_id;description;amount;status;date;complete_date;reserved_facture;complete_facture');
?>