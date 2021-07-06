<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
$route['default_controller'] = 'Admin_login/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;



/* Admin pannel */

$route['Adminlogout'] = 'Admin/logout';
$route['adminprofile'] = 'Admin/adminprofile';
$route['updateprofile'] = 'Admin/updateprofile';
$route['Dashboard'] = 'Admin/Home';
$route['AdminForgot'] = 'Admin_login/AdminForgot';
$route['AdminUpdatepassword'] = 'Admin_login/Adminupdate';
$route['AdminUpdateLink/(:any)'] = 'Admin_login/AdminUpdateLink/$1';
$route['AdminLogin'] = 'Admin_login/index';



$route['Registeredusers'] = 'Admin/Registeredusers';
$route['Verifiedusers'] = 'Admin/Verifiedusers';
$route['Updateuser'] = 'Admin/Updateuser';
$route['Anonymoususers'] = 'Admin/Anonymoususers';
$route['Userlog'] = 'Admin/Userlog';

$route['ViewSOS/(:any)'] = 'Admin/ViewSOS/$1';
$route['ViewFieldReport/(:any)'] = 'Admin/ViewFieldReport/$1';


//  code by Invito / Rummy

$route['sub-admins'] = 'Admin/sub_admins';
$route['update-subadmin'] = 'Admin/update_subadmin';
$route['delete-subadmin'] = 'Admin/delete_subadmin';
$route['new-subadmin'] = 'Admin/addsubadmin';

$route['police-unit-type'] = 'Admin/PoliceUnittype';
$route['create-unit-type'] = 'Admin/Create_PoliceUnittype';
$route['update-unit-type'] = 'Admin/UpdatePoliceUnitType';
$route['application-settings'] = 'Admin/AppSettings';
$route['update-settings'] = 'Admin/UpdateSettings';
$route['Subadminlogs'] = 'Admin/SubadminLogs';


$route['AgencyList'] = 'Admin/AgencyList';
$route['application-agency'] = 'Admin/AppAgency';
$route['updateagency'] = 'Admin/saveAgency';
$route['agencydel'] = 'Admin/agencydel';

$route['addagency'] = 'Admin/addagency';
//  code by Invito / Rummy


//$route['EditPitch/(:any)']='Admin/EditPitch/$1';

$route['RegisteredOfficer'] = 'Admin/RegisteredOfficer';
$route['VerifiedOfficer'] = 'Admin/VerifiedOfficer';
$route['UpdateOfficer'] = 'Admin/UpdateOfficer';
$route['Officerlog'] = 'Admin/Officerlog';

$route['CreateOfficerUnit'] = 'Admin/CreateOfficerUnit';
$route['OfficerUnit'] = 'Admin/OfficerUnit';
// $route['EditUnit/(:any)']='Admin/EditUnit/$1';
$route['UpdateOfficerUnit'] = 'Admin/UpdateOfficerUnit';

$route['CreateUnit'] = 'Admin/CreateUnit';
$route['PoliceUnit'] = 'Admin/PoliceUnit';
$route['EditUnit/(:any)'] = 'Admin/EditUnit/$1';
$route['UpdatePoliceUnit'] = 'Admin/UpdatePoliceUnit';

$route['CrimeMap'] = 'Admin/CrimeMap';

$route['CrimemapPopularity'] = 'Admin/CrimemapPopularity';
$route['CrimemapState'] = 'Admin/CrimemapState';
$route['CrimemapResponsetime'] = 'Admin/CrimemapResponsetime';
$route['CrimemapLocation'] = 'Admin/CrimemapLocation';

$route['WantedPersons'] = 'Admin/WantedPersons';
$route['WantedPersonssAdd'] = 'Admin/WantedPersonssAdd';
$route['WantedPersonsUpdate'] = 'Admin/WantedPersonsUpdate';

$route['MissingPersons'] = 'Admin/MissingPersons';
$route['MissingPersonsAdd'] = 'Admin/MissingPersonsAdd';
$route['MissingPersonsUpdate'] = 'Admin/MissingPersonsUpdate';

$route['StolenVehicle'] = 'Admin/StolenVehicle';
$route['StolenVehicleAdd'] = 'Admin/StolenVehicleAdd';
$route['StolenVehicleUpdate'] = 'Admin/StolenVehicleUpdate';

$route['PublicEvents'] = 'Admin/PublicEvents';
$route['PublicEventsAdd'] = 'Admin/PublicEventsAdd';
$route['PublicEventsUpdate'] = 'Admin/PublicEventsUpdate';

$route['SecurityTips'] = 'Admin/SecurityTips';
$route['SecurityTipsAdd'] = 'Admin/SecurityTipsAdd';
$route['SecurityTipsUpdate'] = 'Admin/SecurityTipsUpdate';

$route['VehicleProfile'] = 'Admin/VehicleProfile';
$route['UpdateVehicleProfile'] = 'Admin/UpdateVehicleProfile';
$route['PropertyProfile'] = 'Admin/PropertyProfile';
$route['UpdatePropertyProfile'] = 'Admin/UpdatePropertyProfile';

$route['SOSManagement'] = 'Admin/SOSManagement';

$route['FeedbackSOS'] = 'Admin/FeedbackSOS';

$route['FiledReport'] = 'Admin/FiledReport';
$route['FeedbackFiledReport'] = 'Admin/FeedbackFiledReport';
$route['Report'] = 'Admin/Report';

$route['FiledReportsPopularity'] = 'Admin/FiledReportsPopularity';
$route['FiledReportsState'] = 'Admin/FiledReportsState';
$route['FiledReportsResponsetime'] = 'Admin/FiledReportsResponsetime';
$route['SoSReportsPopularity'] = 'Admin/SoSReportsPopularity';
$route['SOSReportsLocation'] = 'Admin/SOSReportsLocation';
$route['FiledReportsLocation'] = 'Admin/FiledReportsLocation';
$route['SOSReportsState'] = 'Admin/SOSReportsState';
$route['SOSReportsResponsetime'] = 'Admin/SOSReportsResponsetime';


$route['TrafficReports'] = 'Admin/TrafficReports';
$route['TrafficReportsAdd'] = 'Admin/TrafficReportsAdd';
$route['TrafficReportsUpdate'] = 'Admin/TrafficReportsUpdate';

$route['eDirectory'] = 'Admin/eDirectory';
$route['eDirectoryAdd'] = 'Admin/eDirectoryAdd';
$route['eDirectoryUpdate'] = 'Admin/eDirectoryUpdate';

$route['BusinessCategory'] = 'Admin/BusinessCategory';
$route['BusinessCategoryAdd'] = 'Admin/BusinessCategoryAdd';
$route['BusinessCategoryUpdate'] = 'Admin/BusinessCategoryUpdate';
