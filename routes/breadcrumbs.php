<?php

// Home

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('home', function ($trail) {
    $trail->push(__('translation.home'), route('home'));
});


/*********************
 * Users
 *********************/
// Home > About
Breadcrumbs::for('users', function ($trail) {
    $trail->parent('home');
    $trail->push(__('translation.users.management'), route('users.index'));
});

// Home > Blog > [Category]
Breadcrumbs::for('users.edit', function ($trail, $user) {
    $trail->parent('users');
    $trail->push($user->name, route('users.edit', $user->id));
});


Breadcrumbs::for('users.add', function ($trail) {
    $trail->parent('users');
    $trail->push(__('translation.add'), route('users.create'));
});
/*********************
 * End Users
 *********************/

/*********************
 *roles
 *********************/

// Home > About
Breadcrumbs::for('roles', function ($trail) {
    $trail->parent('home');
    $trail->push(__('translation.roles.management'), route('roles.index'));
});

Breadcrumbs::for('notification', function ($trail) {
    $trail->parent('home');
    $trail->push(__('translation.notification'), route('notification.index'));
});

// Home > Blog > [Category]
Breadcrumbs::for('roles.edit', function ($trail, $role) {
    $trail->parent('roles');
    $trail->push($role->name, route('roles.edit', $role->id));
});
Breadcrumbs::for('roles.add', function ($trail) {
    $trail->parent('roles');
    $trail->push(__('translation.add'), route('roles.create'));
});

Breadcrumbs::for('notification.add', function ($trail) {
    $trail->parent('notification');
    $trail->push(__('translation.add'), route('roles.create'));
});
/*********************
 * End roles
 *********************/

/*********************
 * Areas
 *********************/
// Home > About
Breadcrumbs::for('areas', function ($trail) {
    $trail->parent('home');
    $trail->push(__('translation.areas'), route('areas.index'));
});

/*********************
 * End Areas
 *********************/

/*********************
 * Sub Areas
 *********************/
Breadcrumbs::for('sub_areas', function ($trail, $area) {
    $trail->parent('areas');
    $trail->push($area->name, route('areas.index', $area->id));
});
/*********************
 * End Sub Areas
 *********************/

/*********************
 * Services
 *********************/
// Home > About
Breadcrumbs::for('services', function ($trail) {
    $trail->parent('home');
    $trail->push(__('translation.services'), route('services.index'));
});

/*********************
 * End Services
 *********************/
/*********************
 * Organization Profile
 *********************/
// Home > About
Breadcrumbs::for('organization.profile', function ($trail) {
    $trail->parent('home');
    $trail->push(__('translation.organization.profile'), route('organization.profile'));
});

/*********************
 * End Organization Profile
 *********************/
/*********************
 * User Profile
 *********************/
// Home > About
Breadcrumbs::for('user.profile', function ($trail) {
    $trail->parent('home');
    $trail->push(__('translation.edit profile'), route('user.profile'));
});

/*********************
 * End User Profile
 *********************/


/*********************
 * CLIENTS
 *********************/
// Home > About
Breadcrumbs::for('clients', function ($trail) {
    $trail->parent('home');
    $trail->push(__('translation.clients.management'), route('clients'));
});


Breadcrumbs::for('clients_approve', function ($trail) {
    $trail->parent('home');
    $trail->push(__('translation.clients_approve'), route('clients'));
});
Breadcrumbs::for('representatives_approve', function ($trail) {
    $trail->parent('home');
    $trail->push(__('translation.representatives_approve'), route('clients'));
});

/*********************
 * End CLIENTS
 *********************/
/*********************
 * REPRESENTATIVES
 *********************/
// Home > About
Breadcrumbs::for('representatives', function ($trail) {
    $trail->parent('home');
    $trail->push(__('translation.representatives'), route('representatives'));
});

/*********************
 * End REPRESENTATIVES
 *********************/
/*********************
 * REPRESENTATIVES ORDERS
 *********************/
// Home > About
Breadcrumbs::for('representatives-orders', function ($trail) {
    $trail->parent('home');
    $trail->push(__('translation.representatives.orders'), route('representatives.orders'));
});

/*********************
 * End REPRESENTATIVES ORDERS
 *********************/
/*********************
 * REPRESENTATIVES FEES COLLECTION
 *********************/
// Home > About
Breadcrumbs::for('representatives-fees-collection', function ($trail) {
    $trail->parent('home');
    $trail->push(__('translation.representatives.fees.collection'), route('representatives.fees.collection'));
});

/*********************
 * End REPRESENTATIVES FEES COLLECTION
 *********************/
/*********************
 * ORDERS
 *********************/
// Home > About
Breadcrumbs::for('orders', function ($trail) {
    $trail->parent('home');
    $trail->push(__('translation.orders.management'), route('orders'));
});



Breadcrumbs::for('cient_orders', function ($trail) {
    $trail->parent('orders');
    $trail->push(__('translation.cleint_account_details'), '#');
});


Breadcrumbs::for('add_order', function ($trail) {
    $trail->parent('orders');
    $trail->push(__('translation.add_order'), '#');
});


Breadcrumbs::for('represtative_order_search', function ($trail) {
    $trail->parent('orders');
    $trail->push(__('translation.represtative_order_search'), '#');
});


Breadcrumbs::for('sync_with_shipment_company', function ($trail) {
    $trail->parent('orders');
    $trail->push(__('translation.sync_with_shipping_company'), '#');
});



Breadcrumbs::for('wahts_accouts', function ($trail) {
    // $trail->parent('orders');
    $trail->parent('home');
    $trail->push(__('translation.settings'), '#');
    $trail->push(__('translation.wahts_accouts'), '#');
});


// Home > About
Breadcrumbs::for('order.invoice', function ($trail, $order) {
    $trail->parent('home');
    $trail->push(__('translation.orders.management'), route('orders'));
    $trail->push(__('translation.invoice'), route('print.invoice', $order->id));
});
Breadcrumbs::for('orders.importCSV', function ($trail) {
    $trail->parent('home');
    $trail->push(__('translation.orders.importCSV'), route('orders.importCSV'));
});

/*********************
 * End ORDERS
 *********************/
/*********************
 * TRANSACTIONS
 *********************/
// Home > About
Breadcrumbs::for('transactions', function ($trail) {
    $trail->parent('home');
    $trail->push(__('translation.transactions.management'), route('transactions'));
});

/*********************
 * End TRANSACTIONS
 *********************/
/*********************
 * REPORTS
 *********************/
// Home > About
Breadcrumbs::for('orders.month.reports', function ($trail) {
    $trail->parent('home');
    $trail->push(__('translation.orders.per.month.reports'), route('orders.per.month.reports'));
});
Breadcrumbs::for('orders.in.out.area.reports', function ($trail) {
    $trail->parent('home');
    $trail->push(__('translation.orders.in.out.area.reports'), route('orders.in.out.area.reports'));
});

/*********************
 * End REPORTS
 *********************/

Breadcrumbs::for('client.account.statement', function ($trail) {
    $trail->parent('home');
    $trail->push(__('translation.client.account.statement'), route('client.account.statement'));
});
Breadcrumbs::for('client.transaction', function ($trail) {
    $trail->parent('home');
    $trail->push(__('translation.client.transaction'), route('client.account.transactions'));
});
Breadcrumbs::for('privacy.policy', function ($trail) {
    $trail->parent('home');
    $trail->push(__('translation.privacy.policy'), route('client.account.transactions'));
});

Breadcrumbs::for('representative.account.statement', function ($trail) {
    $trail->parent('home');
    $trail->push(__('translation.representative.account.statement'), route('representative.account.statement'));
});

Breadcrumbs::for('orders.reports', function ($trail) {
    $trail->parent('home');
    $trail->push(__('translation.orders.reports'), route('orders.reports'));
});