<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['services_details/(:any)'] = 'services_details/index/$1';
$route['products_details/(:any)'] = 'products_details/index/$1';
$route['blogs_details/(:any)'] = 'blogs_details/index/$1';
$route['services_show/(:any)'] = 'services_show/index/$1';



// Admin area routes
$route['admin'] = 'admin/welcome';
$route['admin/login'] = 'admin/auth/login';
$route['admin/login/(:any)'] = 'admin/auth/login/$1';
$route['admin/logout'] = 'admin/auth/logout';
$route['admin/logout/(:any)'] = 'admin/auth/logout/$1';
$route['admin/forgot_password'] = 'admin/auth/forgot_password';

// System Settings
$route['settings'] = 'admin/sys';


// Branch routes
$route['branch'] = 'admin/branch/index';
$route['branch/(:any)'] = 'admin/branch/$1';
$route['branch/(:any)/(:any)'] = 'admin/branch/$1/$2/$3';
$route['branch/(:any)/(:any)/(:any)'] = 'admin/branch/$1/$2/$3';

// User Routes
$route['user'] = 'admin/user/index';
$route['user/(:any)'] = 'admin/user/$1';
$route['user/(:any)/(:any)'] = 'admin/user/$1/$2/$3';
$route['user/(:any)/(:any)/(:any)'] = 'admin/user/$1/$2/$3';





// Car Model Routes
$route['model'] = 'admin/makemodel/index';
$route['model/(:any)'] = 'admin/makemodel/$1';
$route['model/(:any)/(:any)'] = 'admin/makemodel/$1/$2/$3';
$route['model/(:any)/(:any)/(:any)'] = 'admin/makemodel/$1/$2/$3';

// Model Routes
$route['modal/(:any)'] = 'admin/modal/$1';
$route['modal/(:any)/(:any)'] = 'admin/modal/$1/$2';
$route['modal/(:any)/(:any)/(:any)'] = 'admin/modal/$1/$2/$3';








// Access Rights
$route['accessrights'] = 'admin/accessrights/index';
$route['accessrights/(:any)'] = 'admin/accessrights/$1';
$route['accessrights/(:any)/(:any)'] = 'admin/accessrights/$1/$2/$3';
$route['accessrights/(:any)/(:any)/(:any)'] = 'admin/accessrights/$1/$2/$3';





// API Routes
// $route['api/register'] = 'api/register';