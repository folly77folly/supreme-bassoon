<?php
return [
    
    "PAGE_LIMIT" => [
        "user" => 10,
        "admin" => 10,
    ],
    "STOCK_LIMIT" => 4,

    "ROLES" => [
        "super-admin" => 1,
        "admin" => 2,
        "operations" => 3,
        "customer-care" => 4,
        "vendor" => 5,
        "user" => 6
    ],
    "DELIVERY_STATUS" => [
        'order_placed' => 1,
        'order_shipped' => 2,
        'order_delivered' => 3,
    ],
    "CHECKOUT_TYPE" => [
        'checkout' => 1,
        'buy-now' => 2,
    ],
    "ORDER_STATUS" => [
        'pending' => 1,
        'completed' => 2,
        'cancelled' => 3,
    ],
    "RECORDS_TAKE" => [
        'three' => 3,
        'five' => 5,
        'six' => 6,
        'ten' => 10,
        'fifteen' => 15,
        'twenty' => 20,
        'twentyFive' => 25,
    ],
    "PERMISSION" => [
        "super-admin" => array(1),
        "admins" => array(
            1,
            2,
            3,
        ),
        "customer-care" => array(
            4,
        ),
    ],
    "NUMBERS" => [
        'one' => 1,
        'two' => 2,
        'three' => 3,
        'five' => 5,
        'six' => 6,
        'ten' => 10,
        'fifteen' => 15,
        'twenty' => 20,
        'twentyFive' => 25,
    ],
];