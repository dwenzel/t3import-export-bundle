<?php
/*
 * TYPO3 system settings override from environment.
 */
$config = [
    'BE' => [
        'installToolPassword' => getenv('INSTALL_TOOL_PASSWORD'),
    ],
    'DB' => [
        'Connections' => [
            'Default' => [
                'host' => getenv('DB_SERVICE_HOST'),
                'dbname' => getenv('DB_SERVICE_DATABASE'),
                'password' => getenv('DB_SERVICE_PASSWORD'),
                'user' => getenv('DB_SERVICE_USER'),
                'port' => (int)getenv('DB_SERVICE_PORT'),
            ],
        ],
    ],
    'MAIL' => [
        'transport' => getenv('MAIL_TRANSPORT'),
        'transport_smtp_server' => getenv('MAIL_TRANSPORT_SERVER'),
    ],
    'SYS' => [
        'sitename' => getenv('TYPO3_SYS_sitename'),
        'trustedHostsPattern' => getenv('TYPO3_SYS_trustedHostsPattern'),
        'encryptionKey' => getenv('ENCRYPTION_KEY'),
        'locking' => [
            'redis' => [
                'database' => 9,
                'port' => (int)getenv('REDIS_PORT'),
                'hostname' => getenv('REDIS_HOST')
            ],
        ],
        'session' => [
            'BE' => [
                'backend' => \TYPO3\CMS\Core\Session\Backend\RedisSessionBackend::class,
                'options' => [
                    'database' => 10,
                    'defaultLifetime' => 86400,
                    'port' => (int)getenv('REDIS_PORT'),
                    'hostname' => getenv('REDIS_HOST')
                ]
            ],
            'FE' => [
                'backend' => \TYPO3\CMS\Core\Session\Backend\RedisSessionBackend::class,
                'options' => [
                    'database' => 11,
                    'defaultLifetime' => 86400,
                    'port' => (int)getenv('REDIS_PORT'),
                    'hostname' => getenv('REDIS_HOST')
                ]
            ],
        ],
        'caching' => [
            'cacheConfigurations' => [
                'hash' => [
                    'backend' => \TYPO3\CMS\Core\Cache\Backend\RedisBackend::class,
                    'options' => [
                        'database' => 3,
                        'defaultLifetime' => 86400,
                        'port' => (int)getenv('REDIS_PORT'),
                        'hostname' => getenv('REDIS_HOST')
                    ]
                ],
                'handlebars' => [
                    'frontend' => \TYPO3\CMS\Core\Cache\Frontend\VariableFrontend::class,
                    'backend' => \TYPO3\CMS\Core\Cache\Backend\RedisBackend::class,
                    'options' => [
                        'database' => 6,
                        'defaultLifetime' => 86400,
                        'port' => (int)getenv('REDIS_PORT'),
                        'hostname' => getenv('REDIS_HOST')
                    ],
                    'groups' => ['pages'],
                ],
                'imagesizes' => [
                    'backend' => \TYPO3\CMS\Core\Cache\Backend\RedisBackend::class,
                    'options' => [
                        'database' => 4,
                        'defaultLifetime' => 86400,
                        'port' => (int)getenv('REDIS_PORT'),
                        'hostname' => getenv('REDIS_HOST')
                    ]
                ],
                'pages' => [
                    'backend' => \TYPO3\CMS\Core\Cache\Backend\RedisBackend::class,
                    'options' => [
                        'database' => 5,
                        'defaultLifetime' => 86400,
                        'port' => (int)getenv('REDIS_PORT'),
                        'hostname' => getenv('REDIS_HOST')
                    ]
                ],
                'rootline' => [
                    'backend' => \TYPO3\CMS\Core\Cache\Backend\RedisBackend::class,
                    'options' => [
                        'database' => 7,
                        'defaultLifetime' => 86400,
                        'port' => (int)getenv('REDIS_PORT'),
                        'hostname' => getenv('REDIS_HOST')
                    ]
                ],
                'extbase' => [
                    'backend' => \TYPO3\CMS\Core\Cache\Backend\RedisBackend::class,
                    'options' => [
                        'database' => 8,
                        'defaultLifetime' => 86400,
                        'port' => (int)getenv('REDIS_PORT'),
                        'hostname' => getenv('REDIS_HOST')
                    ]
                ],
            ],
        ],
    ],
];

/*
 * Merge system settings
 */
$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive(
    $GLOBALS['TYPO3_CONF_VARS'],
    $config
);

/**
 *
 * TYPO3_CONTEXT Development
 */
if (TYPO3\CMS\Core\Core\Environment::getContext()->isDevelopment()) {
    // Completely disable error and exception handling
    $GLOBALS['TYPO3_CONF_VARS']['BE']['debug'] = true;
    $GLOBALS['TYPO3_CONF_VARS']['FE']['debug'] = false;
    $GLOBALS['TYPO3_CONF_VARS']['FE']['disableNoCacheParameter'] = false;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['sqlDebug'] = 1;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['displayErrors'] = 1;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask'] = '*';
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['errorHandler'] = \TYPO3\CMS\Core\Error\ErrorHandler::class;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['debugExceptionHandler'] = \TYPO3\CMS\Core\Error\DebugExceptionHandler::class;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['productionExceptionHandler'] = \TYPO3\CMS\Core\Error\ProductionExceptionHandler::class;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['belogErrorReporting'] = E_ALL & ~(E_NOTICE);
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['errorHandlerErrors'] = E_ALL & ~(E_NOTICE | E_COMPILE_WARNING | E_COMPILE_ERROR | E_CORE_WARNING | E_CORE_ERROR | E_PARSE | E_ERROR);
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['exceptionalErrors'] = E_ALL & ~(E_NOTICE | E_COMPILE_WARNING | E_COMPILE_ERROR | E_CORE_WARNING | E_CORE_ERROR | E_PARSE | E_ERROR | E_DEPRECATED | E_USER_DEPRECATED | E_WARNING | E_USER_ERROR | E_USER_NOTICE | E_USER_WARNING);
    ## Enabled to debug all errors and warnings
    #$GLOBALS['TYPO3_CONF_VARS']['SYS']['belogErrorReporting'] = 30719;
    #$GLOBALS['TYPO3_CONF_VARS']['SYS']['errorHandlerErrors'] = 30719;;
    #$GLOBALS['TYPO3_CONF_VARS']['SYS']['exceptionalErrors'] = 30719;
    $GLOBALS['TYPO3_CONF_VARS']['LOG']['TYPO3']['CMS']['deprecations']['writerConfiguration']['notice']['TYPO3\CMS\Core\Log\Writer\FileWriter']['disabled'] = false;
}

if (getenv('MIGRATION_ENABLED') === 'true') {
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'][getenv('MIGRATION_DB_CONNECTION_NAME')] = [
        'charset' => getenv('MIGRATION_DB_CHAR_SET'),
        'driver' => getenv('MIGRATION_DB_DRIVER'),
        'dbname' => getenv('MIGRATION_DB_DATABASE'),
        'host' => getenv('MIGRATION_DB_HOST'),
        'password' => getenv('MIGRATION_DB_PASSWORD'),
        'port' => (int)getenv('MIGRATION_DB_PORT'),
        'user' => getenv('MIGRATION_DB_USER'),
    ];
}
