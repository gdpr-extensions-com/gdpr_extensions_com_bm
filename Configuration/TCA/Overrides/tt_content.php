<?php
defined('TYPO3') || die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'GdprExtensionsComBm',
    'Bannermanager',
    'Sliding & Shuffling Ad Banners'
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'tt_content',
    [
        'enable_slider' => [
            'exclude' => true,
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [0 => 'Enabled', 1 => '']
                ],
            ],
        ],
    ]
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'tt_content',
    [
        'message' => [
            'displayCond' => 'USER:GdprExtensionsCom\GdprExtensionsComBm\Utility\ProcessMultiCamp->getAvailableCampCount:camp',
            'exclude' => true,
            'config' => [
                'type' => 'none',
                'size' => 200,
                'format' => 'user',
                'format.' => [
                    'userFunc' => 'GdprExtensionsCom\GdprExtensionsComBm\Utility\ProcessMultiCamp->getErrorMssg',

                ],

            ],
        ],
    ]
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'tt_content',
    [
        'business_locations_banner' => [
            'displayCond' => 'USER:GdprExtensionsCom\GdprExtensionsComBm\Utility\ProcessMultiCamp->getAvailableCampCount',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'itemsProcFunc' => 'GdprExtensionsCom\GdprExtensionsComBm\Utility\ProcessMultiCamp->getLocationsforRoodPid',
            ],
        ],
    ],
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    'enable_slider'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    'business_locations_banner'
);




$GLOBALS['TCA']['tt_content']['types']['gdprextensionscombm_bannermanager'] =[
    'showitem' => '
      --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
         --palette--;;general,
         enable_slider; Slider,
         business_locations_banner; Campaigns,
         message; Error Message,
         --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
         --palette--;;hidden,
         --palette--;;access,
      --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
         space_before_class,
         space_after_class,
      --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
      sys_language_uid,
    ',
];

