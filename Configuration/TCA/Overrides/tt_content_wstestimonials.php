<?php

/***************
 * Add Content Element
 */

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

if (!is_array($GLOBALS['TCA']['tt_content']['types']['ws_testimonials'] ?? null)) {
    $GLOBALS['TCA']['tt_content']['types']['ws_testimonials'] = [];
}

/***************
 * Add content element PageTSConfig
 */
ExtensionManagementUtility::registerPageTSConfigFile(
    'ws_testimonials',
    'Configuration/TsConfig/page.tsconfig',
    'Testimonials'
);

/***************
 * Add content element to selector list
 */
ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'LLL:EXT:ws_testimonials/Resources/Private/Language/locallang.xlf:CType.ws_testimonials',
        'ws_testimonials',
        'content-ws_testimonials'
    ],
);

/***************
 * Assign Icon
 */
$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['ws_testimonials'] = 'content-ws_testimonials';

/***************
 * Configure element type
 */
$GLOBALS['TCA']['tt_content']['types']['ws_testimonials'] = array_replace_recursive(
    $GLOBALS['TCA']['tt_content']['types']['ws_testimonials'],
    [
        'showitem' => '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                --palette--;;general,
                --palette--;;ws_testimonials,
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                --palette--;;frames,
                --palette--;;appearanceLinks,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                --palette--;;language,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                --palette--;;hidden,
                --palette--;;access,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
                categories,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
                rowDescription,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
        ',
    ]
);


$GLOBALS['TCA']['tt_content']['palettes'] = array_replace_recursive(
    $GLOBALS['TCA']['tt_content']['palettes'], [
        'ws_testimonials' => [
            'label' => 'LLL:EXT:ws_testimonials/Resources/Private/Language/locallang.xlf:palette.wstestimonials',
            'showitem' => '
                tx_wstestimonials_columns;LLL:EXT:ws_testimonials/Resources/Private/Language/locallang.xlf:tx_wstestimonials_domain_model_item.columns,
                --linebreak--,
                tx_wstestimonials_items;LLL:EXT:ws_testimonials/Resources/Private/Language/locallang.xlf:items
             ',
        ],
    ]
);


ExtensionManagementUtility::addTCAcolumns('tt_content', [
    'tx_wstestimonials_items' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:ws_testimonials/Resources/Private/Language/locallang.xlf:tx_wsslider_domain_model_flexslider.items',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_wstestimonials_domain_model_item',
            'foreign_field' => 'content_uid',
            'foreign_label' => 'title',
            'foreign_sortby' => 'sorting',
            'maxitems' => '100',
            'appearance' => [
                #'collapseAll' => 0, // Auskommentieren, da es sonst immer als true interpretiert wird
                'expandSingle' => true,
                'newRecordLinkAddTitle' => 1,
                'newRecordLinkPosition' => 'both',
                'showAllLocalizationLink' => true,
                'showPossibleLocalizationRecords' => true,
            ],
            'behaviour' => [
                'localizationMode' => 'select',
            ],
            'overrideChildTca' => [
                'types' => [
                    '1' => [
                        'showitem' => 'title, content, author_name, author_image, stars, sys_language_uid, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'
                    ],
                ]
            ]
        ]
    ],
    'tx_wstestimonials_columns' => [
        'label' => 'LLL:EXT:ws_testimonials/Resources/Private/Language/locallang.xlf:tx_wstestimonials_domain_model_item.columns',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'size' => 1,
            'items' => [
                [
                    'label' => 'LLL:EXT:ws_testimonials/Resources/Private/Language/locallang.xlf:tx_wstestimonials_domain_model_item.columns.options.1',
                    'value' => 1,
                ],
                [
                    'label' => 'LLL:EXT:ws_testimonials/Resources/Private/Language/locallang.xlf:tx_wstestimonials_domain_model_item.columns.options.2',
                    'value' => 2,
                ],
            ],
            'default' => 1,
        ],
    ],
]);

