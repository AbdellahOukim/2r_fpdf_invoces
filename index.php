<?php

use deuxrtmaroc\invoice\Invoice;

require 'vendor/autoload.php';

$data = [
    'header' => [
        "logo" => 'logo.png',
        "alingement" => 'L',
        "company_infos" => [
            "2R technologies",
            "Spesialized in web developement and solutions "
        ]
    ],
    'document_infos' => [
        "left" => [
            "N" => "DEV - 20120",
            "Client" => "Alhamd technologie",
            "ICE" => "777777777777777777844545",
        ],
        "right" => [
            "Adress" => "assaka tikioune agadir",
            "Compte" => "BMCE",
            "Téléphone" => "05285478485",
        ],
    ],
    'table' => [
        'thead' => [
            "Designation", "Quantité", "PU", "PHT", "TVA", "Total HT"
        ],
        'tbody' => [
            [
                "Designation" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
                "Quantité" => 100,
                "PU" => 1999,
                "PHT" => 400,
                "TVA" => 400,
                "Total HT" => 1599,
            ],
            [
                "Designation" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
                "Quantité" => 100,
                "PU" => 1999,
                "PHT" => 400,
                "TVA" => 400,
                "Total HT" => 1599,
            ],
            [
                "Designation" => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
                "Quantité" => 100,
                "PU" => 1999,
                "PHT" => 400,
                "TVA" => 400,
                "Total HT" => 1599,
            ],
            [
                "Designation" => "Lorem Ipsum is simply dummy text",
                "Quantité" => 100,
                "PU" => 1999,
                "PHT" => 400,
                "TVA" => 400,
                "Total HT" => 1599,
            ],

            [
                "Designation" => "Lorem Ipsum is simply dummy text",
                "Quantité" => 100,
                "PU" => 1999,
                "PHT" => 400,
                "TVA" => 400,
                "Total HT" => 1599,
            ],
            [
                "Designation" => "Lorem Ipsum is simply dummy text",
                "Quantité" => 100,
                "PU" => 1999,
                "PHT" => 400,
                "TVA" => 400,
                "Total HT" => 1599,
            ],
            [
                "Designation" => "Lorem Ipsum is simply dummy text",
                "Quantité" => 100,
                "PU" => 1999,
                "PHT" => 400,
                "TVA" => 400,
                "Total HT" => 1599,
            ],
            [
                "Designation" => "Lorem Ipsum is simply dummy text",
                "Quantité" => 100,
                "PU" => 1999,
                "PHT" => 400,
                "TVA" => 400,
                "Total HT" => 1599,
            ],
            [
                "Designation" => "Lorem Ipsum is simply dummy text",
                "Quantité" => 100,
                "PU" => 1999,
                "PHT" => 400,
                "TVA" => 400,
                "Total HT" => 1599,
            ],
            [
                "Designation" => "Lorem Ipsum is simply dummy text",
                "Quantité" => 100,
                "PU" => 1999,
                "PHT" => 400,
                "TVA" => 400,
                "Total HT" => 1599,
            ],
            [
                "Designation" => "Lorem Ipsum is simply dummy text",
                "Quantité" => 100,
                "PU" => 1999,
                "PHT" => 400,
                "TVA" => 400,
                "Total HT" => 1599,
            ],
            [
                "Designation" => "Lorem Ipsum is simply dummy text",
                "Quantité" => 100,
                "PU" => 1999,
                "PHT" => 400,
                "TVA" => 400,
                "Total HT" => 1599,
            ],
            [
                "Designation" => "Lorem Ipsum is simply dummy text",
                "Quantité" => 100,
                "PU" => 1999,
                "PHT" => 400,
                "TVA" => 400,
                "Total HT" => 1599,
            ],
            [
                "Designation" => "Lorem Ipsum is simply dummy text",
                "Quantité" => 100,
                "PU" => 1999,
                "PHT" => 400,
                "TVA" => 400,
                "Total HT" => 1599,
            ],
            [
                "Designation" => "Lorem Ipsum is simply dummy text",
                "Quantité" => 100,
                "PU" => 1999,
                "PHT" => 400,
                "TVA" => 400,
                "Total HT" => 1599,
            ],
            [
                "Designation" => "Lorem Ipsum is simply dummy text",
                "Quantité" => 100,
                "PU" => 1999,
                "PHT" => 400,
                "TVA" => 400,
                "Total HT" => 1599,
            ],
            [
                "Designation" => "Lorem Ipsum is simply dummy text",
                "Quantité" => 100,
                "PU" => 1999,
                "PHT" => 400,
                "TVA" => 400,
                "Total HT" => 1599,
            ],
            [
                "Designation" => "Lorem Ipsum is simply dummy text",
                "Quantité" => 100,
                "PU" => 1999,
                "PHT" => 400,
                "TVA" => 400,
                "Total HT" => 1599,
            ],
            [
                "Designation" => "Lorem Ipsum is simply dummy text",
                "Quantité" => 100,
                "PU" => 1999,
                "PHT" => 400,
                "TVA" => 400,
                "Total HT" => 1599,
            ],
            [
                "Designation" => "Lorem Ipsum is simply dummy text",
                "Quantité" => 100,
                "PU" => 1999,
                "PHT" => 400,
                "TVA" => 400,
                "Total HT" => 1599,
            ]
        ],
        "tfoot" => [
            "Total HT" => 3234,
            "TVA 20 " => 3000,
            "Total TTC" => 3234,
        ]
    ],
    'reglement_info' => [
        "conditions" => [
            [
                'nom' => "Virement",
                'date' => "12/10/2024",
                'montant' => 5000
            ],
            [
                'nom' => "LCN",
                'date' => "07/11/2024",
                'montant' => 2000
            ],
            [
                'nom' => "Chéque",
                'date' => "05/11/2024",
                'montant' => 1100
            ],




        ],
        'enlettre' => 'Arrêtter la presente  facture à la somme de : Deux milliards neuf cent quatre-vingt-dix-neuf millions neuf cent quatre-vingt-dix-neuf mille sept cent soixante-huit ',
        'validite' => 'Le document est  validé jusqu\'au : 12/2/2024',
    ],
    'footer' => [
        "2R technologies",
        "Spesialized in web developement and solutions ",
    ]
];


// print_r(count($data['reglement_info']['conditions']));



$options = [
    'print' => [
        'paddingY' => 2,
        'paddingX' => 5,
        'main_space' =>  8,
        'cols_gab' => 15,
    ],

    'document' => [
        'type' => 'I',
        'hasEnLettre' => true,
        'hasConditions' => true,
        'hasValidite' => true,
        'hasTotal' => true
    ],

    'style' => [
        'entete_hauteur' => 3 * 10,
        'pied_hauteur' => 3 * 10,
        'pied_hauteur' => 3 * 10,
    ]
];


$pdf = new Invoice();
$pdf->setOptions($options);
$pdf->prepareData($data);
$pdf->generateInvoice();
