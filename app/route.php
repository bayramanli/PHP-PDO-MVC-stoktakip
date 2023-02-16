<?php
App::getAction('/', '/', false);
App::getAction('/404', '/default/page404', false);
//App::getAction('/index','/default/index');

//USERS
App::getAction('/login', '/default/login');
App::postAction('/login', '/default/loginControl');
App::getAction('/logout', '/default/logout');
App::getAction('/register', '/default/register');
App::postAction('/registerOp', '/default/usersInsertOp');
App::getAction('/dashboard','/default/index', true, "frontend");

//customers
App::getAction('/customers','/default/customers',true,"frontend");
App::getAction('/customers/insert','/default/customersInsert',true,"frontend");
App::postAction('/customers/insert/customersInsertOp','/default/customersInsertOp',true,"frontend");
App::getAction('/customers/update/([0-9a-zA-z-_]+)','/default/customersUpdate/([0-9a-zA-z-_]+)',true,"frontend");
App::postAction('/customers/update/customersUpdateOp','/default/customersUpdateOp',true,"frontend");
App::getAction('/customers/delete/([0-9a-zA-z-_]+)','/default/customersDelete/([0-9a-zA-z-_]+)',true,"frontend");


//PRODUCTS
App::getAction('/products','/default/products',true,"frontend");
App::getAction('/products/insert','/default/productsInsert',true,"frontend");
App::postAction('/products/insert/productsInsertOp','/default/productsInsertOp',true,"frontend");
App::getAction('/products/update/([0-9a-zA-z-_]+)','/default/productsUpdate/([0-9a-zA-z-_]+)',true,"frontend");
App::postAction('/products/update/productsUpdateOp','/default/productsUpdateOp',true,"frontend");
App::getAction('/products/delete/([0-9a-zA-z-_]+)','/default/productsDelete/([0-9a-zA-z-_]+)',true,"frontend");

//PRODUCTS SALES
App::getAction('/products/sales/([0-9a-zA-z-_]+)', '/default/productsSales/([0-9a-zA-z-_]+)', true, "frontend");
App::postAction('/products/sales/salesOp', '/default/productsSalesOp', true, "frontend");
App::getAction('/sales', '/default/sales', true, "frontend");
