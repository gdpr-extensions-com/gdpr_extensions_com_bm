<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_localbanner',
        'label' => 'banner_id',
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
        'searchFields' => 'banner_title,banner_html,banner_css,banner_js,root_pid,campaign_id',
        'iconfile' => 'EXT:gdpr_extensions_com_bm/Resources/Public/Icons/tx_gdprextensionscombm_domain_model_localbanner.gif'
    ],
    'types' => [
        '1' => ['showitem' => 'banner_id, banner_title, banner_html, banner_css, banner_js, valid_from, valid_to, root_pid, campaign_id, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, sys_language_uid, l10n_parent, l10n_diffsource, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime'],
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
                'foreign_table' => 'tx_gdprextensionscombm_domain_model_localbanner',
                'foreign_table_where' => 'AND {#tx_gdprextensionscombm_domain_model_localbanner}.{#pid}=###CURRENT_PID### AND {#tx_gdprextensionscombm_domain_model_localbanner}.{#sys_language_uid} IN (-1,0)',
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

        'banner_id' => [
            'exclude' => true,
            'label' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_localbanner.banner_id',
            'description' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_localbanner.banner_id.description',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int',
                'default' => 0
            ]
        ],
        'banner_title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_localbanner.banner_title',
            'description' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_localbanner.banner_title.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'banner_html' => [
            'exclude' => true,
            'label' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_localbanner.banner_html',
            'description' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_localbanner.banner_html.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'default' => ''
            ]
        ],
        'banner_css' => [
            'exclude' => true,
            'label' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_localbanner.banner_css',
            'description' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_localbanner.banner_css.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'banner_js' => [
            'exclude' => true,
            'label' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_localbanner.banner_js',
            'description' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_localbanner.banner_js.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'valid_from' => [
            'exclude' => true,
            'label' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_localbanner.valid_from',
            'description' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_localbanner.valid_from.description',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int',
                'default' => 0
            ]
        ],
        'valid_to' => [
            'exclude' => true,
            'label' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_localbanner.valid_to',
            'description' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_localbanner.valid_to.description',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int',
                'default' => 0
            ]
        ],
        'root_pid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_localbanner.root_pid',
            'description' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_localbanner.root_pid.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'campaign_id' => [
            'exclude' => true,
            'label' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_localbanner.campaign_id',
            'description' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_localbanner.campaign_id.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'is_archived' => [
            'exclude' => true,
            'label' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_localbanner.is_archived',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int',
                'default' => 0
            ]
        ],
        'campaign_is_disabled' => [
            'exclude' => true,
            'label' => 'LLL:EXT:gdpr_extensions_com_bm/Resources/Private/Language/locallang_db.xlf:tx_gdprextensionscombm_domain_model_localbanner.is_archived',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int',
                'default' => 0
            ]
        ],

        'dashboard_api_key' => [
            'exclude' => true,
            'label' => 'Dashboard API Key',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],

    ],
];
