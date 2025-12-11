<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Available Currencies
    |--------------------------------------------------------------------------
    |
    | Liste des devises disponibles avec leurs informations
    | Format: code => [name, flag, symbol]
    |
    */
    'currencies' => [
        // Afrique
        'XOF' => ['name' => 'Franc CFA (BCEAO)', 'flag' => '🇧🇯', 'symbol' => 'FCFA', 'countries' => 'Bénin, Burkina Faso, Côte d\'Ivoire, Mali, Niger, Sénégal, Togo'],
        'XAF' => ['name' => 'Franc CFA (BEAC)', 'flag' => '🇨🇲', 'symbol' => 'FCFA', 'countries' => 'Cameroun, Gabon, Congo, RCA, Tchad, Guinée Équatoriale'],
        'NGN' => ['name' => 'Naira Nigérian', 'flag' => '🇳🇬', 'symbol' => '₦'],
        'GHS' => ['name' => 'Cedi Ghanéen', 'flag' => '🇬🇭', 'symbol' => '₵'],
        'ZAR' => ['name' => 'Rand Sud-Africain', 'flag' => '🇿🇦', 'symbol' => 'R'],
        'EGP' => ['name' => 'Livre Égyptienne', 'flag' => '🇪🇬', 'symbol' => 'E£'],
        'MAD' => ['name' => 'Dirham Marocain', 'flag' => '🇲🇦', 'symbol' => 'DH'],
        'TND' => ['name' => 'Dinar Tunisien', 'flag' => '🇹🇳', 'symbol' => 'DT'],
        'KES' => ['name' => 'Shilling Kenyan', 'flag' => '🇰🇪', 'symbol' => 'KSh'],
        
        // Europe
        'EUR' => ['name' => 'Euro', 'flag' => '🇪🇺', 'symbol' => '€'],
        'GBP' => ['name' => 'Livre Sterling', 'flag' => '🇬🇧', 'symbol' => '£'],
        'CHF' => ['name' => 'Franc Suisse', 'flag' => '🇨🇭', 'symbol' => 'CHF'],
        
        // Amériques
        'USD' => ['name' => 'Dollar Américain', 'flag' => '🇺🇸', 'symbol' => '$'],
        'CAD' => ['name' => 'Dollar Canadien', 'flag' => '🇨🇦', 'symbol' => 'C$'],
        'BRL' => ['name' => 'Réal Brésilien', 'flag' => '🇧🇷', 'symbol' => 'R$'],
        'MXN' => ['name' => 'Peso Mexicain', 'flag' => '🇲🇽', 'symbol' => 'MX$'],
        
        // Asie
        'CNY' => ['name' => 'Yuan Chinois', 'flag' => '🇨🇳', 'symbol' => '¥'],
        'JPY' => ['name' => 'Yen Japonais', 'flag' => '🇯🇵', 'symbol' => '¥'],
        'INR' => ['name' => 'Roupie Indienne', 'flag' => '🇮🇳', 'symbol' => '₹'],
        'SGD' => ['name' => 'Dollar Singapourien', 'flag' => '🇸🇬', 'symbol' => 'S$'],
        'AED' => ['name' => 'Dirham Émirati', 'flag' => '🇦🇪', 'symbol' => 'AED'],
        'SAR' => ['name' => 'Riyal Saoudien', 'flag' => '🇸🇦', 'symbol' => 'SR'],
        
        // Océanie
        'AUD' => ['name' => 'Dollar Australien', 'flag' => '🇦🇺', 'symbol' => 'A$'],
        'NZD' => ['name' => 'Dollar Néo-Zélandais', 'flag' => '🇳🇿', 'symbol' => 'NZ$'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Currency
    |--------------------------------------------------------------------------
    */
    'default' => env('DEFAULT_CURRENCY', 'XOF'),
];
