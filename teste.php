<?php

$negociacao = [
    'Data' => '15/06/2022',
    'Aplicação' => 'Ações',
    'Ativo' => 'PETR4',
    'Operação' => 'Venda',
    'Quantidade' => '200',
    'Preço' => '33.5',
    'Taxa' => '2.75'
];

// $negociacao2 = [
//     'Data' => '15/06/2022',
//     'Aplicação' => 'Ações',
//     'Ativo' => 'VIIA3',
//     'Operação' => 'Venda',
//     'Quantidade' => '600',
//     'Preço' => '11.5',
//     'Taxa' => '1.75'
// ];

$ativos = [
    'PETR4',
    'VIIA3'
];

$operacoes = [
    'Venda',
    'Venda'
];

$negociacao3 = [
    'Data' => '15/06/2022',
    'Aplicação' => 'Ações',
    'Ativos' => $ativos,
    'Operações' => $operacoes,
    'Quantidades' => [
        '200',
        '600'
    ],
    'Preços' => [
        '33.5',
        '11.5'
    ],
    'Taxas' => [
        '2.75',
        '1.75'
    ]
];

// // $negociacao3 = [
// //     'Data' => '15/06/2022',
// //     'Aplicação' => 'Ações',
// //     'Ativos' => [
// //         'PETR4',
// //         'VIIA3'
// //     ],
// //     'Operações' => [
// //         'Venda',
// //         'Venda'
// //     ],
// //     'Quantidades' => [
// //         '200',
// //         '600'
// //     ],
// //     'Preços' => [
// //         '33.5',
// //         '11.5'
// //     ],
// //     'Taxas' => [
// //         '2.75',
// //         '1.75'
// //     ]
// // ];

// $infos = [
//     'Ativos',
//     'Operações',
//     'Quantidades',
//     'Preços',
//     'Taxas'
// ];

// echo "{$negociacao3['Data']}\n";
// echo "{$negociacao3['Aplicação']}\n";
// foreach ($infos as $info) {
//     echo "{$negociacao3[$info][0]}\n";
// }