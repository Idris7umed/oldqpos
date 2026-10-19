]633;E;echo '# POS API Documentation (v2 and v3)';cd561708-75fa-4307-b7c9-eaadf8589ca2]633;C# POS API Documentation (v2 and v3)

Location: application/controllers/api/DOCS.md

## Summary

- v2 source: application/config/routes.php
- v3 source: inferred from controller REST methods in application/controllers/api/v3/controllers (routes.php currently has no api/v3 entries).
- v2 endpoint count: 171
- v3 inferred endpoint count: 240

## Authentication

- Protected endpoints expect: Authorization: Bearer <your_jwt_token>
- Based on API_Controller, Auth and PublicApi are excluded from JWT checks.

## API v2 Endpoints (Configured Routes)

### Areas

- ANY /api/v2/areas
- ANY /api/v2/areas/(:num)

### Auth

- ANY /api/v2/auth/login
- GET /api/v2/auth/pricing_plans
- GET /api/v2/auth/pricing_plans/(:num)
- POST /api/v2/auth/confirm_payment
- POST /api/v2/auth/customer_register
- POST /api/v2/auth/forgot_password_final
- POST /api/v2/auth/forgot_password_step1
- POST /api/v2/auth/forgot_password_step2
- POST /api/v2/auth/login_pin
- POST /api/v2/auth/regenerate_payment_link
- POST /api/v2/auth/register

### Counters

- ANY /api/v2/counters
- ANY /api/v2/counters/(:num)

### Currencies

- ANY /api/v2/currencies
- ANY /api/v2/currencies/(:num)

### Customer due receives

- ANY /api/v2/customer_due_receives
- ANY /api/v2/customer_due_receives/(:num)

### Customers

- ANY /api/v2/customers
- ANY /api/v2/customers/(:num)
- GET /api/v2/customers/due/(:num)

### Dashboard

- ANY /api/v2/dashboard

### Delivery partners

- ANY /api/v2/delivery_partners
- ANY /api/v2/delivery_partners/(:num)

### Denominations

- ANY /api/v2/denominations
- ANY /api/v2/denominations/(:num)

### Expense items

- ANY /api/v2/expense_items
- ANY /api/v2/expense_items/(:any)

### Expenses

- ANY /api/v2/expenses
- ANY /api/v2/expenses/(:num)

### Food menu categories

- ANY /api/v2/food_menu_categories
- ANY /api/v2/food_menu_categories/(:num)

### Food menus

- ANY /api/v2/food_menus
- ANY /api/v2/food_menus/(:num)

### Holds

- ANY /api/v2/holds
- ANY /api/v2/holds/(:num)
- POST /api/v2/holds/finalize/(:num)

### Ingredient categories

- ANY /api/v2/ingredient_categories
- ANY /api/v2/ingredient_categories/(:num)

### Ingredients

- ANY /api/v2/ingredients
- ANY /api/v2/ingredients/(:num)

### Inventory adjustments

- ANY /api/v2/inventory_adjustments
- ANY /api/v2/inventory_adjustments/(:num)

### Kitchens

- ANY /api/v2/kitchens
- ANY /api/v2/kitchens/categories/(:num)
- ANY /api/v2/kitchens/(:num)

### Modifiers

- ANY /api/v2/modifiers
- ANY /api/v2/modifiers/(:num)

### Outlets

- ANY /api/v2/outlets
- ANY /api/v2/outlets/(:num)

### Payment methods

- ANY /api/v2/payment_methods
- ANY /api/v2/payment_methods/(:num)

### Premade foods

- ANY /api/v2/premade_foods
- ANY /api/v2/premade_foods/(:num)

### Printers

- ANY /api/v2/printers
- ANY /api/v2/printers/(:num)

### Productions

- ANY /api/v2/productions
- ANY /api/v2/productions/(:num)

### Promotions

- ANY /api/v2/promotions
- ANY /api/v2/promotions/(:num)
- POST /api/v2/promotions/check_conflict

### Purchases

- ANY /api/v2/purchases
- ANY /api/v2/purchases/(:num)

### Register

- ANY /api/v2/register/close
- ANY /api/v2/register/details
- ANY /api/v2/register/open

### Reports

- ANY /api/v2/reports/attendance
- ANY /api/v2/reports/audit_log
- ANY /api/v2/reports/consumption
- ANY /api/v2/reports/customer_due
- ANY /api/v2/reports/customer_ledger
- ANY /api/v2/reports/customer_report
- ANY /api/v2/reports/daily_summary
- ANY /api/v2/reports/detailed_purchases
- ANY /api/v2/reports/detailed_sales
- ANY /api/v2/reports/expense
- ANY /api/v2/reports/food_menu_sales
- ANY /api/v2/reports/full_dashboard
- ANY /api/v2/reports/inventory
- ANY /api/v2/reports/kitchen_performance
- ANY /api/v2/reports/low_stock
- ANY /api/v2/reports/loyalty_points_available
- ANY /api/v2/reports/loyalty_points_usage
- ANY /api/v2/reports/product_analysis
- ANY /api/v2/reports/production
- ANY /api/v2/reports/profit_loss
- ANY /api/v2/reports/purchases
- ANY /api/v2/reports/purchases_by_ingredient
- ANY /api/v2/reports/register
- ANY /api/v2/reports/sales_by_waiter
- ANY /api/v2/reports/sales_summary_by_date
- ANY /api/v2/reports/sales_summary_by_month
- ANY /api/v2/reports/supplier_due
- ANY /api/v2/reports/supplier_ledger
- ANY /api/v2/reports/tips
- ANY /api/v2/reports/transfers
- ANY /api/v2/reports/vat
- ANY /api/v2/reports/waste
- ANY /api/v2/reports/z_report

### Reservations

- ANY /api/v2/reservations
- ANY /api/v2/reservations/(:num)

### Roles

- ANY /api/v2/roles
- ANY /api/v2/roles/(:num)
- ANY /api/v2/roles/permissions

### Sales

- ANY /api/v2/sales
- ANY /api/v2/sales/details/(:num)
- ANY /api/v2/sales/(:num)
- ANY /api/v2/sales/running_details/(:num)
- POST /api/v2/sales/merge
- POST /api/v2/sales/refund/(:num)
- POST /api/v2/sales/split/(:num)
- PUT /api/v2/sales/change_date/(:num)
- PUT /api/v2/sales/change_delivery_status/(:num)
- PUT /api/v2/sales/transfer/(:num)

### Service

- ANY /api/v2/service/companies
- ANY /api/v2/service/companies/(:num)
- DELETE /api/v2/service/payments/(:num)
- DELETE /api/v2/service/pricing_plans/(:num)
- GET /api/v2/service/companies/(:num)/outlets
- GET /api/v2/service/payments
- GET /api/v2/service/settings/(:any)
- POST /api/v2/service/companies/(:num)/block
- POST /api/v2/service/companies/(:num)/unblock
- POST /api/v2/service/payments/manual
- POST /api/v2/service/pricing_plans
- POST /api/v2/service/settings/site
- PUT /api/v2/service/pricing_plans/(:num)
- PUT /api/v2/service/settings/(:any)

### Supplier payments

- ANY /api/v2/supplier_payments
- ANY /api/v2/supplier_payments/(:num)

### Suppliers

- ANY /api/v2/suppliers
- ANY /api/v2/suppliers/(:num)
- GET /api/v2/suppliers/due/(:num)

### Tables

- ANY /api/v2/tables
- ANY /api/v2/tables/(:num)

### Transfers

- ANY /api/v2/transfers
- ANY /api/v2/transfers/(:num)

### Units

- ANY /api/v2/units
- ANY /api/v2/units/(:num)

### Users

- ANY /api/v2/users
- ANY /api/v2/users/(:num)

### Wastes

- ANY /api/v2/wastes
- ANY /api/v2/wastes/(:num)

### Attendance

- DELETE /api/v2/attendance/(:num)
- GET /api/v2/attendance
- GET /api/v2/attendance/status
- POST /api/v2/attendance
- POST /api/v2/attendance/check_in
- POST /api/v2/attendance/check_out
- PUT /api/v2/attendance/(:num)

### Kitchen

- GET /api/v2/kitchen/orders/(:num)
- POST /api/v2/kitchen/update_status

### Orders

- GET /api/v2/orders/my_orders
- GET /api/v2/orders/profile_stats
- POST /api/v2/orders/place_order

### Profile

- GET /api/v2/profile
- POST /api/v2/profile/change_password
- POST /api/v2/profile/change_pin
- POST /api/v2/profile/security_question
- PUT /api/v2/profile

### Public

- GET /api/v2/public/categories/(:num)
- GET /api/v2/public/menu/(:num)
- GET /api/v2/public/outlets

### Settings

- GET /api/v2/settings/currency
- GET /api/v2/settings/tax
- PUT /api/v2/settings/tax

### Waiter

- GET /api/v2/waiter/new_orders
- GET /api/v2/waiter/notifications
- POST /api/v2/waiter/notifications/mark_as_viewed
- POST /api/v2/waiter/order_details


## API v3 Endpoints (Inferred)

> Note: there are currently no explicit api/v3 routes in application/config/routes.php. Endpoints below are inferred from REST method names in v3 controllers.

### Areas

- DELETE /api/v3/areas
- GET /api/v3/areas
- POST /api/v3/areas
- PUT /api/v3/areas

### Attendance

- DELETE /api/v3/attendance
- GET /api/v3/attendance
- GET /api/v3/attendance/status
- POST /api/v3/attendance
- POST /api/v3/attendance/check_in
- POST /api/v3/attendance/check_out
- PUT /api/v3/attendance

### Counters

- DELETE /api/v3/counters
- GET /api/v3/counters
- POST /api/v3/counters
- PUT /api/v3/counters

### Currencies

- DELETE /api/v3/currencies
- GET /api/v3/currencies
- POST /api/v3/currencies
- PUT /api/v3/currencies

### Customer due receives

- DELETE /api/v3/customer_due_receives
- GET /api/v3/customer_due_receives
- POST /api/v3/customer_due_receives
- PUT /api/v3/customer_due_receives

### Customers

- DELETE /api/v3/customers
- GET /api/v3/customers
- GET /api/v3/customers/get_due
- POST /api/v3/customers
- PUT /api/v3/customers

### Delivery partners

- DELETE /api/v3/delivery_partners
- GET /api/v3/delivery_partners
- POST /api/v3/delivery_partners
- PUT /api/v3/delivery_partners

### Denominations

- DELETE /api/v3/denominations
- GET /api/v3/denominations
- POST /api/v3/denominations
- PUT /api/v3/denominations

### Expense items

- DELETE /api/v3/expense_items
- GET /api/v3/expense_items
- POST /api/v3/expense_items
- PUT /api/v3/expense_items

### Expenses

- DELETE /api/v3/expenses
- GET /api/v3/expenses
- POST /api/v3/expenses
- PUT /api/v3/expenses

### Food menu categories

- DELETE /api/v3/food_menu_categories
- GET /api/v3/food_menu_categories
- POST /api/v3/food_menu_categories
- PUT /api/v3/food_menu_categories

### Food menus

- DELETE /api/v3/food_menus
- GET /api/v3/food_menus
- POST /api/v3/food_menus
- PUT /api/v3/food_menus

### Holds

- DELETE /api/v3/holds
- GET /api/v3/holds
- POST /api/v3/holds
- POST /api/v3/holds/finalize
- PUT /api/v3/holds

### Ingredient categories

- DELETE /api/v3/ingredient_categories
- GET /api/v3/ingredient_categories
- POST /api/v3/ingredient_categories
- PUT /api/v3/ingredient_categories

### Ingredients

- DELETE /api/v3/ingredients
- GET /api/v3/ingredients
- POST /api/v3/ingredients
- PUT /api/v3/ingredients

### Inventory adjustments

- DELETE /api/v3/inventory_adjustments
- GET /api/v3/inventory_adjustments
- POST /api/v3/inventory_adjustments
- PUT /api/v3/inventory_adjustments

### Kitchens

- DELETE /api/v3/kitchens
- GET /api/v3/kitchens
- GET /api/v3/kitchens/categories
- POST /api/v3/kitchens
- PUT /api/v3/kitchens

### Modifiers

- DELETE /api/v3/modifiers
- GET /api/v3/modifiers
- POST /api/v3/modifiers
- PUT /api/v3/modifiers

### Outlets

- DELETE /api/v3/outlets
- GET /api/v3/outlets
- POST /api/v3/outlets
- PUT /api/v3/outlets

### Payment methods

- DELETE /api/v3/payment_methods
- GET /api/v3/payment_methods
- POST /api/v3/payment_methods
- PUT /api/v3/payment_methods

### Premade foods

- DELETE /api/v3/premade_foods
- GET /api/v3/premade_foods
- POST /api/v3/premade_foods
- PUT /api/v3/premade_foods

### Printers

- DELETE /api/v3/printers
- GET /api/v3/printers
- POST /api/v3/printers
- PUT /api/v3/printers

### Productions

- DELETE /api/v3/productions
- GET /api/v3/productions
- POST /api/v3/productions
- PUT /api/v3/productions

### Promotions

- DELETE /api/v3/promotions
- GET /api/v3/promotions
- POST /api/v3/promotions
- POST /api/v3/promotions/check_conflict
- PUT /api/v3/promotions

### Purchases

- DELETE /api/v3/purchases
- GET /api/v3/purchases
- POST /api/v3/purchases
- PUT /api/v3/purchases

### Reservations

- DELETE /api/v3/reservations
- GET /api/v3/reservations
- POST /api/v3/reservations
- PUT /api/v3/reservations

### Roles

- DELETE /api/v3/roles
- GET /api/v3/roles
- GET /api/v3/roles/permissions
- POST /api/v3/roles
- PUT /api/v3/roles

### Sales

- DELETE /api/v3/sales
- GET /api/v3/sales
- GET /api/v3/sales/details
- GET /api/v3/sales/running_details
- POST /api/v3/sales
- POST /api/v3/sales/merge_orders
- POST /api/v3/sales/process_refund
- POST /api/v3/sales/split_sale
- PUT /api/v3/sales
- PUT /api/v3/sales/change_date
- PUT /api/v3/sales/change_delivery_status
- PUT /api/v3/sales/transfer_order

### Service

- DELETE /api/v3/service/companies
- DELETE /api/v3/service/payments
- DELETE /api/v3/service/pricing_plans
- GET /api/v3/service/companies
- GET /api/v3/service/company_outlets
- GET /api/v3/service/payments
- GET /api/v3/service/settings
- POST /api/v3/service/block_company
- POST /api/v3/service/companies
- POST /api/v3/service/manual_payment
- POST /api/v3/service/pricing_plans
- POST /api/v3/service/site_settings
- POST /api/v3/service/unblock_company
- PUT /api/v3/service/companies
- PUT /api/v3/service/pricing_plans
- PUT /api/v3/service/settings

### Supplier payments

- DELETE /api/v3/supplier_payments
- GET /api/v3/supplier_payments
- POST /api/v3/supplier_payments
- PUT /api/v3/supplier_payments

### Suppliers

- DELETE /api/v3/suppliers
- GET /api/v3/suppliers
- GET /api/v3/suppliers/get_due
- POST /api/v3/suppliers
- PUT /api/v3/suppliers

### Tables

- DELETE /api/v3/tables
- GET /api/v3/tables
- POST /api/v3/tables
- PUT /api/v3/tables

### Transfers

- DELETE /api/v3/transfers
- GET /api/v3/transfers
- POST /api/v3/transfers
- PUT /api/v3/transfers

### Units

- DELETE /api/v3/units
- GET /api/v3/units
- POST /api/v3/units
- PUT /api/v3/units

### Users

- DELETE /api/v3/users
- GET /api/v3/users
- POST /api/v3/users
- PUT /api/v3/users

### Wastes

- DELETE /api/v3/wastes
- GET /api/v3/wastes
- POST /api/v3/wastes
- PUT /api/v3/wastes

### Auth

- GET /api/v3/auth/pricing_plans
- POST /api/v3/auth/confirm_payment
- POST /api/v3/auth/customer_register
- POST /api/v3/auth/forgot_password_final
- POST /api/v3/auth/forgot_password_step1
- POST /api/v3/auth/forgot_password_step2
- POST /api/v3/auth/login
- POST /api/v3/auth/login_pin
- POST /api/v3/auth/regenerate_payment_link
- POST /api/v3/auth/register

### Kitchen

- GET /api/v3/kitchen/orders
- POST /api/v3/kitchen/update_status

### Orders

- GET /api/v3/orders/my_orders
- GET /api/v3/orders/profile_stats
- POST /api/v3/orders/place_order

### Profile

- GET /api/v3/profile
- POST /api/v3/profile/change_password
- POST /api/v3/profile/change_pin
- POST /api/v3/profile/security_question
- PUT /api/v3/profile

### Publicapi

- GET /api/v3/publicapi/categories
- GET /api/v3/publicapi/menu
- GET /api/v3/publicapi/outlets

### Register

- GET /api/v3/register/details
- POST /api/v3/register/close
- POST /api/v3/register/open

### Reports

- GET /api/v3/reports/attendance
- GET /api/v3/reports/audit_log
- GET /api/v3/reports/consumption
- GET /api/v3/reports/customer_due
- GET /api/v3/reports/customer_ledger
- GET /api/v3/reports/customer_report
- GET /api/v3/reports/daily_summary
- GET /api/v3/reports/dashboard
- GET /api/v3/reports/detailed_purchases
- GET /api/v3/reports/detailed_sales
- GET /api/v3/reports/expense
- GET /api/v3/reports/food_menu_sales
- GET /api/v3/reports/full_dashboard
- GET /api/v3/reports/inventory
- GET /api/v3/reports/kitchen_performance
- GET /api/v3/reports/low_stock
- GET /api/v3/reports/loyalty_points_available
- GET /api/v3/reports/loyalty_points_usage
- GET /api/v3/reports/product_analysis
- GET /api/v3/reports/production
- GET /api/v3/reports/profit_loss
- GET /api/v3/reports/purchases
- GET /api/v3/reports/purchases_by_ingredient
- GET /api/v3/reports/register
- GET /api/v3/reports/sales_by_waiter
- GET /api/v3/reports/sales_summary_by_date
- GET /api/v3/reports/sales_summary_by_month
- GET /api/v3/reports/supplier_due
- GET /api/v3/reports/supplier_ledger
- GET /api/v3/reports/tips
- GET /api/v3/reports/transfers
- GET /api/v3/reports/vat
- GET /api/v3/reports/waste
- GET /api/v3/reports/z_report

### Settings

- GET /api/v3/settings/currency
- GET /api/v3/settings/tax
- PUT /api/v3/settings/tax

### Waiter

- GET /api/v3/waiter/new_orders_ajax
- GET /api/v3/waiter/notifications
- POST /api/v3/waiter/mark_as_viewed
- POST /api/v3/waiter/order_details_ajax


## Notes

- ANY means the route does not enforce a specific HTTP verb at routes.php level.
- For v3, IDs and dynamic segments may be required by controller signatures even if not visible in inferred path list.
- To make v3 production-safe, add explicit api/v3 route definitions in application/config/routes.php.
