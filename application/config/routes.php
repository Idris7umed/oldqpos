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

$route['default_controller'] = 'authentication/frontend';
$route['waiter-login'] = 'Login/waiter_login';
$route['waiter-login'] = 'login/waiter_login';
$route['access-denied'] = 'login/accessDenied';
$route['access-denied'] = 'Login/accessDenied';
$route['send-subscribe_email'] = 'authentication/subscribeEmail';
$route['waiter-login-check'] = 'Login/waiter_login_check';
$route['waiter-login-check'] = 'login/waiter_login_check';
$route['customer-panel'] = 'Authentication/customer_panel';
$route['customer-panel'] = 'authentication/customer_panel';
$route['order-status-screen'] = 'Authentication/order_display_screen';
$route['order-status-screen'] = 'authentication/order_display_screen';
$route['online_order_logout'] = 'authentication/logout_online_order';
$route['online_order_logout'] = 'Authentication/logout_online_order'; 
$route['back-to-main-page'] = 'Authentication/backtomainpage'; 
$route['order-status-screen-data'] = 'Authentication/order_display_screen_data';
$route['order-status-screen-data'] = 'authentication/order_display_screen_data';
$route['get_prom_details'] = 'authentication/get_prom_details';
$route['customer-panel-data'] = 'Authentication/customer_panel_data';
$route['customer-panel-data'] = 'authentication/customer_panel_data';;
$route['put-customer-panel-data'] = 'Authentication/put_customer_panel_data';
$route['put-customer-panel-data'] = 'authentication/put_customer_panel_data';
$route['payment-form'] = 'PaymentController/payment';
$route['payment-form-saas'] = 'PaymentController/payment_saas';
$route['payOnline/(:any)'] = 'PaymentController/payOnline/$1';
$route['stripePayment'] = 'PaymentController/stripePayment';
$route['stripePaymentSaas'] = 'PaymentController/stripePaymentSaas';
$route['paymentStatus'] = 'PaymentController/paymentStatus';
$route['ipn_paypal'] = 'PaymentController/ipn_paypal';
$route['plan/(:any)/(:any)'] = 'authentication/plan/$1/$2';
$route['plan/(:any)/(:any)'] = 'Authentication/plan/$1/$2';
$route['plan'] = 'Authentication/plan';
$route['plan'] = 'authentication/plan';
$route['singup'] = 'Authentication/singup';
$route['singup'] = 'authentication/singup';
$route['send-email'] = 'authentication/sendEmail';
$route['contact-us'] = 'authentication/contactUs';
$route['invoice/(:any)'] = 'Authentication/qr_code_invoice/$1';
$route['invoice/(:any)'] = 'authentication/qr_code_invoice/$1';
$route['hst'] = 'authentication/hst';
$route['forgot-password-step-one'] = 'authentication/forgotPasswordStepOne';
$route['forgot-password-step-two'] = 'authentication/forgotPasswordStepTwo';
$route['forgot-password-step-final'] = 'authentication/forgotPasswordStepDone';
$route['self-order/(:any)/(:any)/(:any)/(:any)'] = 'POSChecker/posAndSelfOrderMiddleman/$1/$2/$3/$4';
$route['online-order/(:any)/(:any)'] = 'POSChecker/posAndOnlineOrderMiddleman/$1/$2';
$route['404_override'] = '';
$route['payment-now/(:any)'] = 'Authentication/payment/$1';
$route['active/(:any)'] = 'Frontend/active/$1';
$route['login'] = 'frontend/login';
$route['register'] = 'frontend/register';
$route['forgot-password'] = 'frontend/forgotPassword';
$route['order-success/(:any)'] = 'frontend/orderSuccess/$1';
$route['checkout'] = 'Frontend/checkoutPage';
$route['about-us'] = 'Frontend/aboutUs';
$route['old-orders'] = 'Frontend/oldOrders';
$route['order-details/(:any)'] = 'Frontend/orderDetails/$1';
$route['contact-us'] = 'Frontend/contactUs';
$route['reservation'] = 'Frontend/reservations';
$route['payment-success'] = 'PaymentController/paymentSuccess';
$route['payment-fail'] = 'PaymentController/paymentError';
$route['online-order'] = 'Frontend/menuPage'; 
$route['set-nearest-outlet'] = 'Frontend/setNearestOutlet'; 
$route['food-details/(:any)/(:any)'] = 'Frontend/menuItemDetails/$1/$2';
$route['rating-submit'] = 'Frontend/ratingSubmit';
$route['translate_uri_dashes'] = FALSE;



//--------------------------------------------------------------------------
$route['payment/skipcash_callback'] = 'PaymentController/skipcash_callback';
$route['payment/skipcash_return'] = 'PaymentController/skipcash_return';
$route['api/v2/auth/login'] = 'api/v2/controllers/Auth/login';
$route['api/v2/auth/register']['post'] = 'api/v2/controllers/Auth/register';
$route['api/v2/auth/customer_register']['post'] = 'api/v2/controllers/Auth/customer_register_post';
$route['api/v2/auth/confirm_payment']['post'] = 'api/v2/controllers/Auth/confirm_payment';
$route['api/v2/auth/login_pin']['post'] = 'api/v2/controllers/Auth/login_pin';
$route['api/v2/auth/forgot_password_step1']['post'] = 'api/v2/controllers/Auth/forgot_password_step1';
$route['api/v2/auth/forgot_password_step2']['post'] = 'api/v2/controllers/Auth/forgot_password_step2';
$route['api/v2/auth/forgot_password_final']['post'] = 'api/v2/controllers/Auth/forgot_password_final';
$route['api/v2/auth/pricing_plans']['get'] = 'api/v2/controllers/Auth/pricing_plans';
$route['api/v2/auth/pricing_plans/(:num)']['get'] = 'api/v2/controllers/Auth/pricing_plans/$1';
$route['api/v2/auth/regenerate_payment_link']['post'] = 'api/v2/controllers/Auth/regenerate_payment_link_post';
$route['api/v2/users'] = 'api/v2/controllers/Users';
$route['api/v2/users/(:num)'] = 'api/v2/controllers/Users/index/$1';
$route['api/v2/customers/due/(:num)']['get'] = 'api/v2/controllers/Customers/get_due/$1';
$route['api/v2/customers'] = 'api/v2/controllers/Customers';
$route['api/v2/customers/(:num)'] = 'api/v2/controllers/Customers/index/$1';
$route['api/v2/food_menus'] = 'api/v2/controllers/Food_menus';
$route['api/v2/food_menus/(:num)'] = 'api/v2/controllers/Food_menus/index/$1';
$route['api/v2/food_menu_categories'] = 'api/v2/controllers/Food_menu_categories';
$route['api/v2/food_menu_categories/(:num)'] = 'api/v2/controllers/Food_menu_categories/index/$1';
$route['api/v2/outlets'] = 'api/v2/controllers/Outlets';
$route['api/v2/outlets/(:num)'] = 'api/v2/controllers/Outlets/index/$1';
$route['api/v2/sales/details/(:num)'] = 'api/v2/controllers/Sales/details/$1';
$route['api/v2/sales/running_details/(:num)'] = 'api/v2/controllers/Sales/running_details/$1';
$route['api/v2/sales/split/(:num)']['post'] = 'api/v2/controllers/Sales/split_sale/$1';
$route['api/v2/sales/refund/(:num)']['post'] = 'api/v2/controllers/Sales/process_refund/$1';
$route['api/v2/sales/change_date/(:num)']['put'] = 'api/v2/controllers/Sales/change_date/$1';
$route['api/v2/sales/change_delivery_status/(:num)']['put'] = 'api/v2/controllers/Sales/change_delivery_status/$1';
$route['api/v2/sales/merge']['post'] = 'api/v2/controllers/Sales/merge_orders';
$route['api/v2/sales/transfer/(:num)']['put'] = 'api/v2/controllers/Sales/transfer_order_put/$1'; 
$route['api/v2/sales/(:num)'] = 'api/v2/controllers/Sales/index/$1';
$route['api/v2/sales'] = 'api/v2/controllers/Sales';
$route['api/v2/ingredients'] = 'api/v2/controllers/Ingredients';
$route['api/v2/ingredients/(:num)'] = 'api/v2/controllers/Ingredients/index/$1';
$route['api/v2/suppliers'] = 'api/v2/controllers/Suppliers';
$route['api/v2/suppliers/(:num)'] = 'api/v2/controllers/Suppliers/index/$1';
$route['api/v2/suppliers/due/(:num)']['get'] = 'api/v2/controllers/Suppliers/get_due/$1';
$route['api/v2/purchases'] = 'api/v2/controllers/Purchases';
$route['api/v2/purchases/(:num)'] = 'api/v2/controllers/Purchases/index/$1';
$route['api/v2/inventory_adjustments'] = 'api/v2/controllers/Inventory_adjustments';
$route['api/v2/inventory_adjustments/(:num)'] = 'api/v2/controllers/Inventory_adjustments/index/$1';
$route['api/v2/wastes'] = 'api/v2/controllers/Wastes';
$route['api/v2/wastes/(:num)'] = 'api/v2/controllers/Wastes/index/$1';
$route['api/v2/modifiers'] = 'api/v2/controllers/Modifiers';
$route['api/v2/modifiers/(:num)'] = 'api/v2/controllers/Modifiers/index/$1';
$route['api/v2/reports/daily_summary'] = 'api/v2/controllers/Reports/daily_summary';
$route['api/v2/reports/food_menu_sales'] = 'api/v2/controllers/Reports/food_menu_sales';
$route['api/v2/reports/inventory'] = 'api/v2/controllers/Reports/inventory';
$route['api/v2/reports/low_stock'] = 'api/v2/controllers/Reports/low_stock';
$route['api/v2/reports/profit_loss'] = 'api/v2/controllers/Reports/profit_loss';
$route['api/v2/reports/sales_by_waiter'] = 'api/v2/controllers/Reports/sales_by_waiter';
$route['api/v2/reports/attendance'] = 'api/v2/controllers/Reports/attendance';
$route['api/v2/reports/customer_due'] = 'api/v2/controllers/Reports/customer_due';
$route['api/v2/reports/supplier_due'] = 'api/v2/controllers/Reports/supplier_due';
$route['api/v2/reports/customer_ledger'] = 'api/v2/controllers/Reports/customer_ledger';
$route['api/v2/reports/supplier_ledger'] = 'api/v2/controllers/Reports/supplier_ledger';
$route['api/v2/reports/detailed_sales'] = 'api/v2/controllers/Reports/detailed_sales';
$route['api/v2/dashboard'] = 'api/v2/controllers/Reports/dashboard';
$route['api/v2/reports/full_dashboard'] = 'api/v2/controllers/Reports/full_dashboard';
$route['api/v2/reports/expense'] = 'api/v2/controllers/Reports/expense';
$route['api/v2/reports/waste'] = 'api/v2/controllers/Reports/waste';
$route['api/v2/reports/vat'] = 'api/v2/controllers/Reports/vat';
$route['api/v2/reports/audit_log'] = 'api/v2/controllers/Reports/audit_log';
$route['api/v2/reports/consumption'] = 'api/v2/controllers/Reports/consumption';
$route['api/v2/reports/customer_report'] = 'api/v2/controllers/Reports/customer_report';
$route['api/v2/reports/detailed_purchases'] = 'api/v2/controllers/Reports/detailed_purchases';
$route['api/v2/reports/kitchen_performance'] = 'api/v2/controllers/Reports/kitchen_performance';
$route['api/v2/reports/loyalty_points_available'] = 'api/v2/controllers/Reports/loyalty_points_available';
$route['api/v2/reports/loyalty_points_usage'] = 'api/v2/controllers/Reports/loyalty_points_usage';
$route['api/v2/reports/product_analysis'] = 'api/v2/controllers/Reports/product_analysis';
$route['api/v2/reports/production'] = 'api/v2/controllers/Reports/production';
$route['api/v2/reports/purchases'] = 'api/v2/controllers/Reports/purchases';
$route['api/v2/reports/purchases_by_ingredient'] = 'api/v2/controllers/Reports/purchases_by_ingredient';
$route['api/v2/reports/register'] = 'api/v2/controllers/Reports/register';
$route['api/v2/reports/sales_summary_by_date'] = 'api/v2/controllers/Reports/sales_summary_by_date';
$route['api/v2/reports/sales_summary_by_month'] = 'api/v2/controllers/Reports/sales_summary_by_month';
$route['api/v2/reports/tips'] = 'api/v2/controllers/Reports/tips';
$route['api/v2/reports/transfers'] = 'api/v2/controllers/Reports/transfers';
$route['api/v2/reports/z_report'] = 'api/v2/controllers/Reports/z_report';
$route['api/v2/reports/detailed_purchases'] = 'api/v2/controllers/Reports/detailed_purchases';
$route['api/v2/areas'] = 'api/v2/controllers/Areas';
$route['api/v2/areas/(:num)'] = 'api/v2/controllers/Areas/index/$1';
$route['api/v2/tables'] = 'api/v2/controllers/Tables';
$route['api/v2/tables/(:num)'] = 'api/v2/controllers/Tables/index/$1';
$route['api/v2/payment_methods'] = 'api/v2/controllers/Payment_methods';
$route['api/v2/payment_methods/(:num)'] = 'api/v2/controllers/Payment_methods/index/$1';
$route['api/v2/roles/permissions'] = 'api/v2/controllers/Roles/permissions'; 
$route['api/v2/roles/(:num)'] = 'api/v2/controllers/Roles/index/$1';
$route['api/v2/roles'] = 'api/v2/controllers/Roles'; 
$route['api/v2/holds'] = 'api/v2/controllers/Holds';
$route['api/v2/holds/finalize/(:num)']['post'] = 'api/v2/controllers/Holds/finalize_post/$1'; 
$route['api/v2/holds/(:num)'] = 'api/v2/controllers/Holds/index/$1';
$route['api/v2/units'] = 'api/v2/controllers/Units';
$route['api/v2/units/(:num)'] = 'api/v2/controllers/Units/index/$1';
$route['api/v2/delivery_partners'] = 'api/v2/controllers/Delivery_partners';
$route['api/v2/delivery_partners/(:num)'] = 'api/v2/controllers/Delivery_partners/index/$1';
$route['api/v2/expense_items'] = 'api/v2/controllers/Expense_items';
$route['api/v2/expense_items/(:any)'] = 'api/v2/controllers/Expense_items/index/$1';
$route['api/v2/promotions/check_conflict']['post'] = 'api/v2/controllers/Promotions/check_conflict';
$route['api/v2/promotions'] = 'api/v2/controllers/Promotions';
$route['api/v2/promotions/(:num)'] = 'api/v2/controllers/Promotions/index/$1';
$route['api/v2/reservations'] = 'api/v2/controllers/Reservations';
$route['api/v2/reservations/(:num)'] = 'api/v2/controllers/Reservations/index/$1';
$route['api/v2/register/open'] = 'api/v2/controllers/Register/open';
$route['api/v2/register/details'] = 'api/v2/controllers/Register/details';
$route['api/v2/register/close'] = 'api/v2/controllers/Register/close';
$route['api/v2/expenses'] = 'api/v2/controllers/Expenses';
$route['api/v2/expenses/(:num)'] = 'api/v2/controllers/Expenses/index/$1';
$route['api/v2/attendance']['get'] = 'api/v2/controllers/Attendance/index';
$route['api/v2/attendance']['post'] = 'api/v2/controllers/Attendance/index';
$route['api/v2/attendance/(:num)']['put'] = 'api/v2/controllers/Attendance/index/$1';
$route['api/v2/attendance/(:num)']['delete'] = 'api/v2/controllers/Attendance/index/$1';
$route['api/v2/attendance/check_in']['post'] = 'api/v2/controllers/Attendance/check_in';
$route['api/v2/attendance/check_out']['post'] = 'api/v2/controllers/Attendance/check_out';
$route['api/v2/attendance/status']['get'] = 'api/v2/controllers/Attendance/status';
$route['api/v2/kitchens/categories/(:num)'] = 'api/v2/controllers/Kitchens/categories_get/$1';
$route['api/v2/kitchens'] = 'api/v2/controllers/Kitchens';
$route['api/v2/kitchens/(:num)'] = 'api/v2/controllers/Kitchens/index/$1';
$route['api/v2/orders/place_order']['post'] = 'api/v2/controllers/Orders/place_order';
$route['api/v2/orders/my_orders']['get'] = 'api/v2/controllers/Orders/my_orders';
$route['api/v2/orders/profile_stats']['get'] = 'api/v2/controllers/Orders/profile_stats';
$route['api/v2/kitchen/orders/(:num)']['get'] = 'api/v2/controllers/Kitchen/orders/$1';
$route['api/v2/kitchen/update_status']['post'] = 'api/v2/controllers/Kitchen/update_status';
$route['api/v2/waiter/notifications']['get'] = 'api/v2/controllers/Waiter/notifications';
$route['api/v2/waiter/notifications/mark_as_viewed']['post'] = 'api/v2/controllers/Waiter/mark_as_viewed';
$route['api/v2/waiter/new_orders']['get'] = 'api/v2/controllers/Waiter/new_orders_ajax';
$route['api/v2/waiter/order_details']['post'] = 'api/v2/controllers/Waiter/order_details_ajax';
$route['api/v2/printers'] = 'api/v2/controllers/Printers';
$route['api/v2/printers/(:num)'] = 'api/v2/controllers/Printers/index/$1';
$route['api/v2/counters'] = 'api/v2/controllers/Counters';
$route['api/v2/counters/(:num)'] = 'api/v2/controllers/Counters/index/$1';
$route['api/v2/currencies'] = 'api/v2/controllers/Currencies';
$route['api/v2/currencies/(:num)'] = 'api/v2/controllers/Currencies/index/$1';
$route['api/v2/denominations'] = 'api/v2/controllers/Denominations';
$route['api/v2/denominations/(:num)'] = 'api/v2/controllers/Denominations/index/$1';
$route['api/v2/settings/tax']['get'] = 'api/v2/controllers/Settings/tax';
$route['api/v2/settings/tax']['put'] = 'api/v2/controllers/Settings/tax';
$route['api/v2/settings/currency']['get'] = 'api/v2/controllers/Settings/currency';
$route['api/v2/ingredient_categories'] = 'api/v2/controllers/Ingredient_categories';
$route['api/v2/ingredient_categories/(:num)'] = 'api/v2/controllers/Ingredient_categories/index/$1';
$route['api/v2/productions'] = 'api/v2/controllers/Productions';
$route['api/v2/productions/(:num)'] = 'api/v2/controllers/Productions/index/$1';
$route['api/v2/customer_due_receives'] = 'api/v2/controllers/Customer_due_receives';
$route['api/v2/customer_due_receives/(:num)'] = 'api/v2/controllers/Customer_due_receives/index/$1';
$route['api/v2/supplier_payments'] = 'api/v2/controllers/Supplier_payments';
$route['api/v2/supplier_payments/(:num)'] = 'api/v2/controllers/Supplier_payments/index/$1';
$route['api/v2/transfers'] = 'api/v2/controllers/Transfers';
$route['api/v2/transfers/(:num)'] = 'api/v2/controllers/Transfers/index/$1';
$route['api/v2/profile']['get'] = 'api/v2/controllers/Profile/index';
$route['api/v2/profile']['put'] = 'api/v2/controllers/Profile/index';
$route['api/v2/profile/change_password']['post'] = 'api/v2/controllers/Profile/change_password';
$route['api/v2/profile/change_pin']['post'] = 'api/v2/controllers/Profile/change_pin';
$route['api/v2/profile/security_question']['post'] = 'api/v2/controllers/Profile/security_question';
$route['api/v2/premade_foods'] = 'api/v2/controllers/Premade_foods';
$route['api/v2/premade_foods/(:num)'] = 'api/v2/controllers/Premade_foods/index/$1';
$route['api/v2/service/pricing_plans']['post'] = 'api/v2/controllers/Service/pricing_plans';
$route['api/v2/service/pricing_plans/(:num)']['put'] = 'api/v2/controllers/Service/pricing_plans/$1';
$route['api/v2/service/pricing_plans/(:num)']['delete'] = 'api/v2/controllers/Service/pricing_plans/$1';
$route['api/v2/service/companies'] = 'api/v2/controllers/Service/companies';
$route['api/v2/service/companies/(:num)'] = 'api/v2/controllers/Service/companies/$1';
$route['api/v2/service/companies/(:num)/outlets']['get'] = 'api/v2/controllers/Service/company_outlets/$1';
$route['api/v2/service/companies/(:num)/block']['post'] = 'api/v2/controllers/Service/block_company/$1';
$route['api/v2/service/companies/(:num)/unblock']['post'] = 'api/v2/controllers/Service/unblock_company/$1';

$route['api/v2/service/payments']['get'] = 'api/v2/controllers/Service/payments';
$route['api/v2/service/payments/manual']['post'] = 'api/v2/controllers/Service/manual_payment';
$route['api/v2/service/payments/(:num)']['delete'] = 'api/v2/controllers/Service/payments_delete/$1';
$route['api/v2/service/settings/(:any)']['get'] = 'api/v2/controllers/Service/settings/$1'; 
$route['api/v2/service/settings/(:any)']['put'] = 'api/v2/controllers/Service/settings/$1';
$route['api/v2/service/settings/site']['post'] = 'api/v2/controllers/Service/site_settings_post'; 
$route['api/v2/public/outlets']['get'] = 'api/v2/controllers/PublicApi/outlets';
$route['api/v2/public/menu/(:num)']['get'] = 'api/v2/controllers/PublicApi/menu/$1';
$route['api/v2/public/categories/(:num)']['get'] = 'api/v2/controllers/PublicApi/categories/$1';


