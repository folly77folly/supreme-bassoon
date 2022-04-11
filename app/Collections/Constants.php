<?php

namespace App\Collections;

class Constants
{
    //notification type
    const NOTIFICATION = [
        "LIKED" => 1,
        "SUBSCRIBED" => 2,
        "TIPPED" => 3,
        "MESSAGED" => 4,
        "FOLLOW" => 5,
        "BOOKMARK" => 6
    ];

    //pagination
    const PAGE_LIMIT = 10;
    const ADMIN_PAGE_LIMIT = 30;
    const MARKETPLACE_PAGE_LIMIT = 20;
    const HOME_PAGE_LIMIT = 24;


    //Currency
    const CURRENCY = 'ngn';

    //Stripe cents conversion
    const STRIPE_VALUE = 100;

    //Transaction Type
    const TRANSACTION = [
        "CREDIT" => 1,
        "DEBIT" => 2,
    ];

    //Earning Type
    const EARNING = [
        "CARD" => 1,
        "WALLET" => 2,
        "REFERRAL" => 3,
        "CRYPTO" => 4,
    ];

    // Job delay minute
    const JOB_DELAY_TIME = [
        "ONE" => 1,
        "TWO" => 2,
        "THREE" => 3,
    ];

    // subscription days
    const SUBSCRIPTION_EXPIRY_NOTIFICATION = [
        "ONE_MONTH" => 30,
        "HALF_MONTH" => 15,
        "DAYS" => 5,
    ];

    // user roles
    const ROLE = [
        "SUPER_ADMIN" => 1,
        "ADMIN" => 2,
        "ECOMMERCE_ADMIN" => 3,
        "MARKET_AGENT_ADMIN" => 4,
        "DELIVERY_ADMIN" => 5,
        "BUSINESS_ADMIN" => 6,
        "SALES_ADMIN" => 7,
        "PRODUCT_ADMIN" => 8,
        "USER" => 9,
        "MARKET_AGENT_SUB_ADMIN" => 10,
        "BUSINESS_SUB_ADMIN" => 11,
        "SALES_SUB_ADMIN" => 12,
        "PRODUCT_SUB_ADMIN" => 13,
        "DELIVERY_SUB_ADMIN" => 14,
        "BUSINESS_AGENT" => 15,
        "SERVICE_AGENT" => 16,
        "MARKET_AGENT" => 17,
        "SELLER" => 18
    ];

    // array of those that have priviledges in each hierarchy
    const ROLE_ARRAY = [
        "SUPER_ADMIN" => [self::ROLE['SUPER_ADMIN']],
        "ADMIN" => [self::ROLE['SUPER_ADMIN'], self::ROLE['ADMIN']],
        "MARKET_AGENT_ADMIN" => [self::ROLE['SUPER_ADMIN'], self::ROLE['ADMIN'], self::ROLE['MARKET_AGENT_ADMIN']],
        "MARKET_AGENT_SUB_ADMIN" => [self::ROLE['SUPER_ADMIN'], self::ROLE['ADMIN'], self::ROLE['MARKET_AGENT_ADMIN'], self::ROLE['MARKET_AGENT_ADMIN']],
        "DELIVERY_ADMIN" => [self::ROLE['SUPER_ADMIN'], self::ROLE['ADMIN'], self::ROLE['DELIVERY_ADMIN']],
        "DELIVERY_SUB_ADMIN" => [self::ROLE['SUPER_ADMIN'], self::ROLE['ADMIN'], self::ROLE['DELIVERY_ADMIN'], self::ROLE['DELIVERY_SUB_ADMIN']],
        "ECOMMERCE_ADMIN" => [self::ROLE['SUPER_ADMIN'], self::ROLE['ADMIN'], self::ROLE['ECOMMERCE_ADMIN']],
        "BUSINESS_ADMIN" => [self::ROLE['SUPER_ADMIN'], self::ROLE['ADMIN'], self::ROLE['ECOMMERCE_ADMIN'], self::ROLE['BUSINESS_ADMIN']],
        "BUSINESS_SUB_ADMIN" => [self::ROLE['SUPER_ADMIN'], self::ROLE['ADMIN'], self::ROLE['ECOMMERCE_ADMIN'], self::ROLE['BUSINESS_ADMIN'], self::ROLE['BUSINESS_SUB_ADMIN']],
        "SALES_ADMIN" => [self::ROLE['SUPER_ADMIN'], self::ROLE['ADMIN'], self::ROLE['ECOMMERCE_ADMIN'], self::ROLE['SALES_ADMIN']],
        "SALES_SUB_ADMIN" => [self::ROLE['SUPER_ADMIN'], self::ROLE['ADMIN'], self::ROLE['ECOMMERCE_ADMIN'], self::ROLE['BUSINESS_ADMIN'], self::ROLE['SALES_SUB_ADMIN']],
        "PRODUCT_ADMIN" => [self::ROLE['SUPER_ADMIN'], self::ROLE['ADMIN'], self::ROLE['ECOMMERCE_ADMIN'], self::ROLE['PRODUCT_ADMIN']],
        "PRODUCT_SUB_ADMIN" => [self::ROLE['SUPER_ADMIN'], self::ROLE['ADMIN'], self::ROLE['ECOMMERCE_ADMIN'], self::ROLE['BUSINESS_ADMIN'], self::ROLE['PRODUCT_SUB_ADMIN']],
    ];

    // message token charge
    const TOKEN = [
        "DEBIT" => 1,
    ];

    // check active status
    const ACTIVE = [
        "TRUE" => 1,
        "FALSE" => 0,
    ];

    //default subscription benefits
    const DEFAULT_BENEFITS = [
        "Full access to this user's content",
        "Direct message with this user",
        "Cancel your subscription at any time"
    ];

    const APPROVAL_STATUS = [
        "PENDING" => 1,
        "APPROVED" => 2,
        "REJECTED" => 3,
        "ONGOING" => 4,
    ];

    // OTP Expiry Time Frame
    const OTP_EXPIRY = 5;

    const SELLER_TYPE = [
        "OWNER_REPRESENTATIVE" => 1,
        "BUSINESS_AGENT" => 2
    ];

    const ESCROW_STATUS = [
        "ONGOING" => 1,
        "APPROVED" => 2,
        "CANCELLED" => 3,
        "COMPLETED" => 4,
        "OPEN" => 5,
        "REVIEW" => 6,
    ];

    const PAYMENT_STATUS = [
        "ONLINE" => 1,
        "TRANSFER" => 2,
        "WALLET" => 3,
        "IGNORE" => 4,
    ];


    const TRANSACTION_SOURCES = [
        "DELIVERY" => 1,
        "SALES" => 2,
        "EARNINGS" => 3,
        "REWARD" => 4,
        "CARD" => 5,
        "WALLET" => 6,
        "ESCROW" => 7,
        "WALLET_FUNDING" => 8,
        "COMMISSION_ON_SALES" => 9,
        "ESCROW_RELEASED" => 10,
        "MARKETPLACE_PURCHASE" => 11,
        "ESCROW_TRANSFER" => 12,
        "REFERRAL" => 13,
        "ADVERT" => 14,
    ];

    const LOCATION_TYPE = [
        "PICKUP" => 1,
        "DELIVERY" => 2
    ];
    
    const ORDER_REF_TABLE = [
        "CUSTOMER_PRODUCT" => 1,
        "SERVICE" => 2,
        "MARKET_PLACE" => 3,
    ];

    const FULFILLMENT_OPTION = [
        "PICKUP" => 1,
        "DELIVERY" => 2,
        "PICKUP_AND_DELIVERY" => 3,
        "ELECTRONICALLY" => 4,
        "CUSTOM" => 5,
    ];

    const ESCROW_REQUEST_OPTION = [
        "USER" => 1,
        "MARKETPLACE" => 2,
        "PRIVATE" => 3,
        "RESELLER" => 4,
    ];

    // product in cart status
    const PRODUCT_STATUS = [
        "PENDING" => 1,
        "BOUGHT" => 0,
    ];

    const BOOLEAN = [
        0 => "NO",
        1 => "YES",
        2 => "NO"
    ];

    const PURCHASE_TYPE = [
        'BUY_NOW' => 1,
        'CART' => 2,
    ];

    const NOTIFICATION_TYPE = [
        'PUBLIC' => 1,
        'PRIVATE' => 2
    ];

    const ORDER_TYPE = [
        "PRODUCT" => 1,
        "SERVICE" => 2
    ];
}
