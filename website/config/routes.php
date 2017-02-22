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
| 	example.com/class/method/id/
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
| There are two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['scaffolding_trigger'] = 'scaffolding';
|
| This route lets you set a "secret" word that will trigger the
| scaffolding feature for added security. Note: Scaffolding must be
| enabled in the controller in which you intend to use it.   The reserved 
| routes must come before any wildcard or regular expression routes.
|
*/

$route['default_controller'] = "home";
$route['scaffolding_trigger'] = "";

/*
// Route for read article detail
$route['read/([a-z]+)/(\d+)'] = 'read/news/$2';

// Temp routing for changed section name, please remove below routes after June 09.
// Used for handling archived old url from search engine
$route['jakartacorner'] = "sudutkota";
$route['jakartacorner/([a-z]+)'] = "sudutkota/$1";
//$route['greencity'] = "tamu";
//$route['greencity/([a-z]+)'] = "tamu/$1";
$route['mall'] = "mal";
$route['mall/hotdeal'] = "mal/diskon";
$route['mall/hottrend'] = "mal/tren";
$route['mall/newarrival'] = "mal/anyar";
$route['news'] = "warta";
$route['newsindex'] = "indekswarta";
$route['parenting'] = "pendidikan";
$route['publicinfo'] = "infopublik";
$route['publicservice'] = "layananumum";
$route['publicservice/([a-z]+)'] = "layananumum/$1";
$route['sport'] = "olahraga";
$route['wisata/([a-z]+)'] = "pelesir/$1";
$route['womanactivity/([a-z]+)'] = "inspirasiusaha/$1";

// Route for zodiac
$route['zodiak/([a-z]+)'] = "zodiak/index/$1";

// Route for lipsus
$route['lipsus/([a-z0-9]+)'] = "lipsus/index/$1";
*/

/* End of file routes.php */
/* Location: ./system/application/config/routes.php */