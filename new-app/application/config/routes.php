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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'User';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//  <!-- User Area -->
// Ìnvoice User

$route['user/invoice'] = 'User/invoice';

$route['user/invoice/detail/(:any)'] = 'User/invoice_detail/$1';
$route['user/invoice/payment/(:any)'] = 'User/invoice_payment/$1';
$route['user/invoice/pembayaran/(:any)'] = 'User/invoice_pembayaran/$1';
$route['user/invoice/cek/(:any)'] = 'User/invoice_cek/$1';
$route['user/invoice/list'] = 'User/invoice_list';
$route['user/account/changepassword'] = 'User/changepassword';
$route['user/invoice/print/(:any)'] = 'User/invoice_print/$1';





// <!--  Admin Area -->
// Admin 

$route['admin/customer/member'] = 'Admin/customer_member';
$route['admin/customer/reseller'] = 'Admin/customer_reseller';


$route['admin/customer/detail/(:any)'] = 'Admin/customer_detail/$1';
$route['admin/customer/edit/(:any)'] = 'Admin/customer_edit/$1';
$route['admin/pool/add'] = 'Admin/pool';
$route['admin/pool/edit'] = 'Admin/pool_edit';
$route['admin/pool/ipisolir'] = 'Admin/ip_isolir';
$route['admin/invoice/generate'] = 'Admin/generate_invoice';



$route['admin/customer/service'] = 'Admin/customer_service';
$route['admin/customer/add/(:any)'] = 'Admin/customer_add/$1';
$route['admin/services/edit/(:any)'] = 'Admin/service_edit/$1';
$route['admin/service/delete/(:any)'] = 'Admin/service_delete/$1';

// Invoice Rumahan
$route['admin/invoice/home'] = 'Admin/invoice_home';
$route['admin/invoice/home/prevmonth'] = 'Admin/invoice_prevmonth';
$route['admin/invoice/home/thismonth'] = 'Admin/invoice_thismonth';
$route['admin/invoice/home/allinvoice'] = 'Admin/allinvoice_home';
$route['admin/invoice/home/edit/(:any)'] = 'Admin/edit_invoice/$1';


//  Invoice Member
$route['admin/invoice/member'] = 'Admin/invoice_member';
$route['admin/invoice/member/prevmonth'] = 'Admin/invoice_prevmonth_member';
$route['admin/invoice/member/thismonth'] = 'Admin/invoice_thismonth_member';
$route['admin/invoice/member/allinvoice'] = 'Admin/allinvoice_member';


// Report
$route['admin/report/masuk'] = 'Admin/report_masuk';
$route['admin/report/keluar'] = 'Admin/report_keluar';


// Ticket
$route['admin/ticket/reply/(:any)'] = 'Admin/ticket_reply/$1';
$route['admin/ticket/open/(:any)'] = 'Admin/ticket_open/$1';


//  Whatsapp Gateway
$route['admin/whatsapp/update'] = 'Admin/update_whatsapp';

$route['admin/whatsapp/setup'] = 'Admin/whatsapp_setup';
$route['admin/whatsapp/scan'] = 'Admin/whatsapp_scan';
$route['admin/whatsapp/cekactive'] = 'Admin/cekactive_whatsapp';

// Change Password
$route['admin/account/changepassword'] = 'Admin/changepassword';



$route['admin/smtp/setup'] = 'Admin/smtp_setup';


// <!-- Router Area -->
// Router

$route['admin/router'] = 'Router/index';
// $route['admin/router/(:any)'] = 'Router/$1';

$route['admin/router/setup'] = 'Router/router_setup';
$route['admin/router/setting'] = 'Router/setting';

//  Router Hotspot 
$route['admin/router/hotspot/users'] = 'Router/hotspot_users';
$route['admin/router/hotspot/adduser'] = 'Router/hotspot_adduser';
$route['admin/router/hotspot/generate'] = 'Router/hotspot_generate';
$route['admin/router/hotspot/prosesgenerate'] = 'Router/hotspot_proses_generate';
$route['admin/router/hotspot/active'] = 'Router/hotspot_active';


// Router PPP

$route['admin/router/ppp/profile'] = 'Router/ppp_profile';
$route['admin/router/ppp/profile/edit/(:any)'] = 'Router/ppp_edit_profile/$1';

$route['admin/router/ppp/secret'] = 'Router/ppp_secret';
$route['admin/router/ppp/secret/edit/(:any)'] = 'Router/ppp_edit_secret/$1';

$route['admin/router/ppp/active'] = 'Router/ppp_active';

// <!-- Member Area --> 

$route['member/history/order'] = 'Member/history_order';
$route['member/history/topup'] = 'Member/history_topup';
$route['member/history/balance'] = 'Member/history_balance';

$route['member/order/detail/(:any)'] = 'Member/detail_order/$1';
$route['member/invoice/detail/(:any)'] = 'Member/invoice_detail/$1';
$route['member/topup/detail/(:any)'] = 'Member/topup_detail/$1';
$route['member/tiket/open/(:any)'] = 'Member/tiket_open/$1';
$route['member/account/changepassword'] = 'Member/changepassword';


// Admin Voucher
$route['admin/voucher'] = 'Voucher/index';
$route['admin/voucher/hotspot/user'] = 'Voucher/users';
$route['admin/voucher/hotspot/generate'] = 'Voucher/generate';
$route['admin/voucher/hotspot/profile'] = 'Voucher/profile';
$route['admin/voucher/hotspot/addprofile'] = 'Voucher/addprofile';
$route['admin/voucher/hotspot/profile/edit/(:any)'] = 'Voucher/edit_profile_hotspot/$1';

$route['admin/voucher/comment/(:any)'] = 'Voucher/cekdatabycomment/$1';
$route['admin/voucher/print/default/(:any)'] = 'Voucher/print_default/$1';
$route['admin/voucher/logs'] = 'Voucher/logs_voucher';
$route['admin/voucher/report'] = 'Voucher/report';
$route['admin/voucher/report/filter'] = 'Voucher/report_filter';
$route['admin/voucher/setting'] = 'Voucher/setting';
