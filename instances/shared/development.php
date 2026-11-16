<?php

/**
 * Development settings shared by all TYPO3 instances of this bundle.
 *
 * Included from config/system/additional.php (TYPO3 >= 12) and
 * public/typo3conf/AdditionalConfiguration.php (TYPO3 11).
 */

defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive(
    $GLOBALS['TYPO3_CONF_VARS'],
    [
        'BE' => [
            'debug' => true,
        ],
        'FE' => [
            'debug' => true,
        ],
        'SYS' => [
            'devIPmask' => '*',
            'displayErrors' => 1,
            'trustedHostsPattern' => '.*',
            'exceptionalErrors' => E_ALL & ~(E_NOTICE | E_DEPRECATED | E_USER_DEPRECATED | E_WARNING | E_USER_WARNING),
        ],
        'GFX' => [
            'processor' => 'ImageMagick',
            'processor_path' => '/usr/bin/',
        ],
        'MAIL' => [
            'transport' => 'smtp',
            'transport_smtp_server' => 'localhost:1025',
        ],
    ]
);

// Database connection from the DDEV environment (see .ddev/config.zz-version.yaml)
$databaseName = getenv('TYPO3_INSTANCE_DB');
if (is_string($databaseName) && $databaseName !== '') {
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default'] = array_replace(
        $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default'] ?? [],
        [
            'driver' => 'mysqli',
            'host' => 'db',
            'port' => 3306,
            'dbname' => $databaseName,
            'user' => 'root',
            'password' => 'root',
            'charset' => 'utf8mb4',
        ]
    );
    // TYPO3 13 renamed 'tableoptions' to 'defaultTableOptions' and 'collate' to 'collation'
    if ((int)getenv('TYPO3_INSTANCE_VERSION') >= 13) {
        $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['defaultTableOptions'] = [
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ];
    } else {
        $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['tableoptions'] = [
            'charset' => 'utf8mb4',
            'collate' => 'utf8mb4_unicode_ci',
        ];
    }
}
