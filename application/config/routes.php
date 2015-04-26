<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['login/(:any)'] = 'login/$1';
$route['login'] = 'login';

$route['employee/(:any)'] = 'employee/$1';
$route['employee'] = 'employee';

$route['project/(:any)'] = 'project/$1';
$route['project'] = 'project';

$route['timesheet/(:any)'] = 'timesheet/$1';
$route['timesheet'] = 'timesheet';

$route['finance/(:any)'] = 'finance/$1';
$route['finance'] = 'finance';

$route['supplier/(:any)'] = 'supplier/$1';
$route['supplier'] = 'supplier';

$route['settings/(:any)'] = 'settings/$1';
$route['settings'] = 'settings';

$route['task/(:any)'] = 'task/$1';
$route['task'] = 'task';

$route['chart/(:any)'] = 'chart/$1';
$route['chart'] = 'chart';

$route['dict/(:any)'] = 'dict/$1';
$route['dict'] = 'dict';

$route['stats/(:any)'] = 'stats/$1';
$route['stats'] = 'stats';

$route['default_controller'] = "pages/view";
$route['(:any)'] = "pages/view/$1";

//$route['404_override'] = 'errors/page_missing';
//$route['500_override'] = 'errors/page_error';
/* End of file routes.php */
/* Location: ./application/config/routes.php */
