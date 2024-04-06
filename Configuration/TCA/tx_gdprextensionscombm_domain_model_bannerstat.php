<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_bannerstat',
        'label' => 'impressions',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => '',
        'iconfile' => 'EXT:gdpr_extensions_com_bm/Resources/Public/Icons/tx_gdprextensionscombm_domain_model_bannerstat.gif'
    ],
    'types' => [
        '1' => ['showitem' => 'impressions, timestamp, local_banner, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, sys_language_uid, l10n_parent, l10n_diffsource, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_gdprextensionscombm_domain_model_bannerstat',
                'foreign_table_where' => 'AND {#tx_gdprextensionscombm_domain_model_bannerstat}.{#pid}=###CURRENT_PID### AND {#tx_gdprextensionscombm_domain_model_bannerstat}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],

        'impressions' => [
            'exclude' => true,
            'label' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_bannerstat.impressions',
            'description' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_bannerstat.impressions.description',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int',
                'default' => 0
            ]
        ],
        'timestamp' => [
            'exclude' => true,
            'label' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_bannerstat.timestamp',
            'description' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_bannerstat.timestamp.description',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int',
                'default' => 0
            ]
        ],
        'local_banner' => [
            'exclude' => true,
            'label' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_bannerstat.local_banner',
            'description' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_bannerstat.local_banner.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_gdprextensionscombm_domain_model_localbanner',
                'default' => 0,
                'minitems' => 0,
                'maxitems' => 1,
            ],
            
        ],
    
    ],
];
