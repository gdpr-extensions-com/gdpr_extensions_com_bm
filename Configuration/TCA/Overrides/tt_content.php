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
        'business_locations_banner' => [
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'itemsProcFunc' => 'GdprExtensionsCom\GdprExtensionsComBm\Utility\ProcessMultiLocation->getLocationsforRoodPid',
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
         business_locations_banner; Business Location,
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

