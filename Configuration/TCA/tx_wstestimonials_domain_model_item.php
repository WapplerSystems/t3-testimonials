<?php

return [
    'ctrl' => [
        'title' => 'LLL:EXT:ws_testimonials/Resources/Private/Language/locallang.xlf:tx_wstestimonials_domain_model_item',
        'label' => 'title',
        'label_alt' => 'author_name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'sortby' => 'sorting',
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'hideTable' => true,
        'searchFields' => 'title,content,author_name',
        'typeicon_classes' => [
            'default' => 'content-ws_testimonial'
        ],
        'security' => [
            'ignorePageTypeRestriction' => true,
        ]
    ],
    'interface' => [
    ],
    'types' => [
        '1' => [
            'showitem' => 'hidden, title, content, author_image, stars, sys_language_uid, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'
        ],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => ['type' => 'language']
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        '',
                        0
                    ]
                ],
                'foreign_table' => 'tx_wstestimonials_domain_model_item',
                'foreign_table_where' => 'AND tx_wstestimonials_domain_model_item.pid=###CURRENT_PID### AND tx_wstestimonials_domain_model_item.sys_language_uid IN (-1,0)',
                'default' => 0
            ]
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ]
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
            ]
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0
            ],
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly'
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
                ]
            ],
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly'
        ],
        'title' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'content' => [
            'l10n_mode' => 'prefixLangTitle',
            'l10n_cat' => 'text',
            'exclude' => 0,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.text',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 6,
                'enableRichtext' => true,
            ],
        ],
        'stars' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_testimonials/Resources/Private/Language/locallang.xlf:tx_wstestimonials_domain_model_item.stars',
            'config' => [
                'type' => 'number',
                'format' => 'decimal',
                'range' => [
                    'lower' => 0,
                    'upper' => 5
                ],
                'slider' => [
                    'step' => 0.5,
                    'width' => 300,
                ],
            ],
        ],
        'author_image' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_testimonials/Resources/Private/Language/locallang.xlf:tx_wstestimonials_domain_model_item.author_image',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-image-types',
                'minitems' => 0,
                'maxitems' => 1,
                'appearance' => [
                    'showAllLocalizationLink' => true,
                    'headerThumbnail' => [
                        'height' => '90c',
                        'width' => 90
                    ]
                ],
                'overrideChildTca' => [
                    'columns' => [
                        'crop' => [
                            'config' => [
                                'cropVariants' => [
                                    'default' => [
                                        'title' => 'LLL:EXT:core/Resources/Private/Language/locallang_wizards.xlf:imwizard.crop_variant.default',
                                        'allowedAspectRatios' => [
                                            'NaN' => [
                                                'title' => 'LLL:EXT:core/Resources/Private/Language/locallang_wizards.xlf:imwizard.ratio.free',
                                                'value' => 0
                                            ],
                                            '1:1' => [
                                                'title' => 'LLL:EXT:core/Resources/Private/Language/locallang_wizards.xlf:imwizard.ratio.1_1',
                                                'value' => 1 / 1
                                            ],
                                        ],
                                        'selectedRatio' => 'NaN',
                                        'cropArea' => [
                                            'x' => 0.0,
                                            'y' => 0.0,
                                            'width' => 1.0,
                                            'height' => 1.0,
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'author_name' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:ws_testimonials/Resources/Private/Language/locallang.xlf:tx_wstestimonials_domain_model_item.author_name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'content_uid' => [
            'label' => 'CC',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tt_content',
                //'foreign_table_where' => ...,
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
    ],
];

