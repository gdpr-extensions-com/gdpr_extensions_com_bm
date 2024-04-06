<?php
defined('TYPO3') || die();

(static function() {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'GdprExtensionsComBm',
        'Bannermanager',
        [
            \GdprExtensionsCom\GdprExtensionsComBm\Controller\LocalBannerController::class => 'index, getBanner, track'
        ],
        // non-cacheable actions
        [
            \GdprExtensionsCom\GdprExtensionsComBm\Controller\LocalBannerController::class => 'index, getBanner, track'
        ],
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );


    // Register Scheduler Task
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\GdprExtensionsCom\GdprExtensionsComBm\Commands\SyncBannersTask::class] = [
        'extension' => 'gdpr_extensions_com_bm',
        'title' => 'Fetch Banner Campaign ',
        'description' => 'Fetch banners from GDPR-extensions-come dashboard',
        'additionalFields' => \GdprExtensionsCom\GdprExtensionsComBm\Commands\SyncBannersTask::class,
    ];
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\GdprExtensionsCom\GdprExtensionsComBm\Commands\UploadBannerStatTask::class] = [
        'extension' => 'gdpr_extensions_com_bm',
        'title' => 'Update Banner Campaign Stats',
        'description' => 'Update banner campaign report #clicks and impressions',
        'additionalFields' => \GdprExtensionsCom\GdprExtensionsComBm\Commands\UploadBannerStatTask::class,
    ];

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.common {
                elements {
                    Bannermanager {
                        iconIdentifier = gdpr_extensions_com_bm-plugin-bannermanager
                        title = LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdpr_extensions_com_bm_bannerclient.name
                        description = LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdpr_extensions_com_bm_bannerclient.description
                        tt_content_defValues {
                            CType = gdprextensionscombm_bannermanager
                        }
                    }
                }
                show = *
            }
        }'
    );
})();
