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
        'LLL:EXT:ws_testimonials/Resources/Private/Language/locallang.xlf:CType.testimonials',
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
                tx_wstestimonials_items;LLL:EXT:ws_testimonials/Resources/Private/Language/locallang.xlf:items,
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
            'foreign_table' => 'tx_wsslider_domain_model_item',
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
                        'showitem' => 'title, sys_language_uid, foreground_media, description, text_position, style_class, link, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime, endtime'
                    ],
                ]
            ]
        ]
    ],
]);


$GLOBALS['TCA']['tt_content']['palettes'] = array_replace_recursive(
    $GLOBALS['TCA']['tt_content']['palettes'], [
        'tx_wsslider' => [
            'label' => 'LLL:EXT:ws_testimonials/Resources/Private/Language/locallang.xlf:palette.wsslider',
            'showitem' => '
                tx_wsslider_preset;LLL:EXT:ws_testimonials/Resources/Private/Language/locallang.xlf:preset,--linebreak--,
                tx_wsslider_renderer;LLL:EXT:ws_testimonials/Resources/Private/Language/locallang.xlf:renderer,
                tx_wsslider_layout;LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.layout,
                --linebreak--,
                tx_wsslider_items;LLL:EXT:ws_testimonials/Resources/Private/Language/locallang.xlf:items,
             ',
        ],
    ]
);
