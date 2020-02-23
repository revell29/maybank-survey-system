<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Connections
    |--------------------------------------------------------------------------
    |
    | This array stores the connections that are added to Adldap. You can add
    | as many connections as you like.
    |
    | The key is the name of the connection you wish to use and the value is
    | an array of configuration settings.
    |
    */

    'connections' => [

        'default' => [
            'auto_connect' => env('LDAP_AUTO_CONNECT', false),
            'connection' => Adldap\Connections\Ldap::class,
            'settings' => [
                // replace this line:
                'schema' => Adldap\Schemas\ActiveDirectory::class,
                'account_prefix' => env('LDAP_ACCOUNT_PREFIX', ''),
                'account_suffix' => env('LDAP_ACCOUNT_SUFFIX', '@star.dnroot.net'),
                'hosts' => explode(' ', env('LDAP_HOSTS', 'star.dnroot.net')),
                'port' => env('LDAP_PORT', 389),
                'timeout' => env('LDAP_TIMEOUT', 5),
                'base_dn' => env('LDAP_BASE_DN', 'dc=star,dc=dnroot,dc=net'),
                'username' => env('LDAP_ADMIN_USERNAME', ''),
                'password' => env('LDAP_ADMIN_PASSWORD', ''),
                'follow_referrals' => env('LDAP_FOLLOW_REFERRALS', false),
                'use_ssl' => env('LDAP_USE_SSL', false),
                'use_tls' => env('LDAP_USE_TLS', false),
            ],
        ],

    ],

];
