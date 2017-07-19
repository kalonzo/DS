<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    function insertCountries($iso2, $iso3, $label, $prefix) {

        $id = \App\Utilities\UuidTools::generateUuid();

        DB::table('countries')->insert([
            'id' => $id,
            'iso' => $iso2, //créer une constante pour le genre 
            'iso3' => $iso3,
            'label' => $label,
            'prefix' => $prefix,
            'id_currency' => 0
        ]);
    }

    public function run() {
        CountriesTableSeeder::insertCountries('AF', 'AFG', 'Afghanistan', 93);
        CountriesTableSeeder::insertCountries('ZA', 'ZAF', 'Afrique du Sud', 27);
        CountriesTableSeeder::insertCountries('AL', 'ALB', 'Albanie', 355);
        CountriesTableSeeder::insertCountries('DZ', 'DZA', 'Algérie', 213);
        CountriesTableSeeder::insertCountries('DE', 'DEU', 'Allemagne', 49);
        CountriesTableSeeder::insertCountries('AD', 'AND', 'Andorre', 376);
        CountriesTableSeeder::insertCountries('AO', 'AGO', 'Angola', 244);
        CountriesTableSeeder::insertCountries('AI', 'AIA', 'Anguilla', 1264);
        CountriesTableSeeder::insertCountries('AQ', 'ATA', 'Antarctique', 672);
        CountriesTableSeeder::insertCountries('SA', 'SAU', 'Arabie saoudite', 966);
        CountriesTableSeeder::insertCountries('AR', 'ARG', 'Argentine', 54);
        CountriesTableSeeder::insertCountries('AM', 'ARM', 'Arménie', 374);
        CountriesTableSeeder::insertCountries('AW', 'ABW', 'Aruba', 297);
        CountriesTableSeeder::insertCountries('AU', 'AUS', 'Australie', 61);
        CountriesTableSeeder::insertCountries('AT', 'AUT', 'Autriche', 43);
        CountriesTableSeeder::insertCountries('AZ', 'AZE', 'Azerbaïdjan', 994);
        CountriesTableSeeder::insertCountries('BS', 'BHS', 'Bahamas', 1);
        CountriesTableSeeder::insertCountries('BH', 'BHR', 'Bahreïn', 973);
        CountriesTableSeeder::insertCountries('BD', 'BGD', 'Bangladesh', 880);
        CountriesTableSeeder::insertCountries('BB', 'BRB', 'Barbade', 1);
        CountriesTableSeeder::insertCountries('BE', 'BEL', 'Belgique', 32);
        CountriesTableSeeder::insertCountries('BZ', 'BLZ', 'Belize', 501);
        CountriesTableSeeder::insertCountries('BJ', 'BEN', 'Benin', 229);
        CountriesTableSeeder::insertCountries('BM', 'BMU', 'Bermudes', 1);
        CountriesTableSeeder::insertCountries('BT', 'BTN', 'Bhoutan', 975);
        CountriesTableSeeder::insertCountries('BY', 'BLR', 'Biélorussie', 375);
        CountriesTableSeeder::insertCountries('BO', 'BOL', 'Bolivie', 591);
        CountriesTableSeeder::insertCountries('BA', 'BIH', 'Bosnie-Herzégovine', 387);
        CountriesTableSeeder::insertCountries('BW', 'BWA', 'Botswana', 267);
        CountriesTableSeeder::insertCountries('BR', 'BRA', 'Brésil', 55);
        CountriesTableSeeder::insertCountries('BN', 'BRN', 'Brunei', 673);
        CountriesTableSeeder::insertCountries('BG', 'BGR', 'Bulgarie', 359);
        CountriesTableSeeder::insertCountries('BF', 'BFA', 'Burkina Faso', 226);
        CountriesTableSeeder::insertCountries('BI', 'BDI', 'Burundi', 257);
        CountriesTableSeeder::insertCountries('KH', 'KHM', 'Cambodge', 855);
        CountriesTableSeeder::insertCountries('CM', 'CMR', 'Cameroun', 237);
        CountriesTableSeeder::insertCountries('CA', 'CAN', 'Canada', 1);
        CountriesTableSeeder::insertCountries('CV', 'CPV', 'Cap-Vert', 238);
        CountriesTableSeeder::insertCountries('CF', 'CAF', 'Centrafricaine, république', 236);
        CountriesTableSeeder::insertCountries('CL', 'CHL', 'Chili', 56);
        CountriesTableSeeder::insertCountries('CN', 'CHN', 'Chine', 86);
        CountriesTableSeeder::insertCountries('CY', 'CYP', 'Chypre', 357);
        CountriesTableSeeder::insertCountries('CO', 'COL', 'Colombie', 57);
        CountriesTableSeeder::insertCountries('KM', 'COM', 'Comores', 269);
        CountriesTableSeeder::insertCountries('KP', 'PRK', 'Corée du Nord', 850);
        CountriesTableSeeder::insertCountries('KR', 'KOR', 'Corée du Sud', 82);
        CountriesTableSeeder::insertCountries('CR', 'CRI', 'Costa Rica', 506);
        CountriesTableSeeder::insertCountries('CI', 'CIV', 'Côte d\'Ivoire', 225);
        CountriesTableSeeder::insertCountries('HR', 'HRV', 'Croatie', 385);
        CountriesTableSeeder::insertCountries('CU', 'CUB', 'Cuba', 53);
        CountriesTableSeeder::insertCountries('CW', 'CUW', 'Curaçao', 599);
        CountriesTableSeeder::insertCountries('DK', 'DNK', 'Danemark', 45);
        CountriesTableSeeder::insertCountries('DJ', 'DJI', 'Djibouti', 253);
        CountriesTableSeeder::insertCountries('DM', 'DMA', 'Dominique', 1);
        CountriesTableSeeder::insertCountries('EG', 'EGY', 'Égypte', 20);
        CountriesTableSeeder::insertCountries('SV', 'SLV', 'El Salvador', 503);
        CountriesTableSeeder::insertCountries('AE', 'ARE', 'Émirats Arabes Unis', 971);
        CountriesTableSeeder::insertCountries('EC', 'ECU', 'Équateur', 593);
        CountriesTableSeeder::insertCountries('ER', 'ERI', 'Érythrée', 291);
        CountriesTableSeeder::insertCountries('ES', 'ESP', 'Espagne', 34);
        CountriesTableSeeder::insertCountries('EE', 'EST', 'Estonie', 372);
        CountriesTableSeeder::insertCountries('US', 'USA', 'États-Unis', 1);
        CountriesTableSeeder::insertCountries('ET', 'ETH', 'Éthiopie', 251);
        CountriesTableSeeder::insertCountries('FJ', 'FJI', 'Fidji', 679);
        CountriesTableSeeder::insertCountries('FI', 'FIN', 'Finlande', 358);
        CountriesTableSeeder::insertCountries('FR', 'FRA', 'France', 33);
        CountriesTableSeeder::insertCountries('GA', 'GAB', 'Gabon', 241);
        CountriesTableSeeder::insertCountries('GM', 'GMB', 'Gambie', 220);
        CountriesTableSeeder::insertCountries('GE', 'GEO', 'Géorgie', 995);
        CountriesTableSeeder::insertCountries('GH', 'GHA', 'Ghana', 233);
        CountriesTableSeeder::insertCountries('GI', 'GIB', 'Gibraltar', 350);
        CountriesTableSeeder::insertCountries('GB', 'GBR', 'Grande-Bretagne', 44);
        CountriesTableSeeder::insertCountries('GR', 'GRC', 'Grèce', 30);
        CountriesTableSeeder::insertCountries('GL', 'GRL', 'Groenland', 299);
        CountriesTableSeeder::insertCountries('GP', 'GLP', 'Guadeloupe', 590);
        CountriesTableSeeder::insertCountries('GU', 'GUM', 'Guam', 1671);
        CountriesTableSeeder::insertCountries('GT', 'GTM', 'Guatemala', 502);
        CountriesTableSeeder::insertCountries('GN', 'GIN', 'Guinée', 224);
        CountriesTableSeeder::insertCountries('GQ', 'GNQ', 'Guinée équatoriale', 240);
        CountriesTableSeeder::insertCountries('GW', 'GNB', 'Guinée-Bissau', 245);
        CountriesTableSeeder::insertCountries('GY', 'GUY', 'Guyana', 592);
        CountriesTableSeeder::insertCountries('HT', 'HTI', 'Haïti', 509);
        CountriesTableSeeder::insertCountries('HN', 'HND', 'Honduras', 504);
        CountriesTableSeeder::insertCountries('HK', 'HKG', 'Hong Kong', 852);
        CountriesTableSeeder::insertCountries('HU', 'HUN', 'Hongrie', 36);
        CountriesTableSeeder::insertCountries('IM', 'IMN', 'Île de Man', 44);
        CountriesTableSeeder::insertCountries('MU', 'MUS', 'Île Maurice', 230);
        CountriesTableSeeder::insertCountries('NF', 'NFK', 'Île Norfolk', 672);
        CountriesTableSeeder::insertCountries('KY', 'CYM', 'Îles Caïmanes', -567949);
        CountriesTableSeeder::insertCountries('CK', 'COK', 'Îles Cook', 682);
        CountriesTableSeeder::insertCountries('FK', 'FLK', 'Îles Falkland', 500);
        CountriesTableSeeder::insertCountries('FO', 'FRO', 'Îles Féroé', 298);
        CountriesTableSeeder::insertCountries('MP', 'MNP', 'Îles Mariannes du Nord', 1670);
        CountriesTableSeeder::insertCountries('MH', 'MHL', 'Îles Marshall', 692);
        CountriesTableSeeder::insertCountries('PN', 'PCN', 'Îles Pitcairn', 870);
        CountriesTableSeeder::insertCountries('SB', 'SLB', 'Îles Salomon', 677);
        CountriesTableSeeder::insertCountries('VG', 'VGB', 'Îles Vierges', 1284);
        CountriesTableSeeder::insertCountries('IN', 'IND', 'Inde', 91);
        CountriesTableSeeder::insertCountries('ID', 'IDN', 'Indonésie', 62);
        CountriesTableSeeder::insertCountries('IQ', 'IRQ', 'Irak', 964);
        CountriesTableSeeder::insertCountries('IR', 'IRN', 'Iran', 98);
        CountriesTableSeeder::insertCountries('IE', 'IRL', 'Irlande', 353);
        CountriesTableSeeder::insertCountries('IS', 'ISL', 'Islande', 354);
        CountriesTableSeeder::insertCountries('IL', 'ISR', 'Israël', 972);
        CountriesTableSeeder::insertCountries('IT', 'ITA', 'Italie', 39);
        CountriesTableSeeder::insertCountries('JM', 'JAM', 'Jamaïque', 1);
        CountriesTableSeeder::insertCountries('JP', 'JPN', 'Japon', 81);
        CountriesTableSeeder::insertCountries('JO', 'JOR', 'Jordanie', 962);
        CountriesTableSeeder::insertCountries('KZ', 'KAZ', 'Kazakhstan', 7);
        CountriesTableSeeder::insertCountries('KE', 'KEN', 'Kenya', 254);
        CountriesTableSeeder::insertCountries('KG', 'KGZ', 'Kirghizistan', 996);
        CountriesTableSeeder::insertCountries('KI', 'KIR', 'Kiribati', 686);
        CountriesTableSeeder::insertCountries('XK', 'XKX', 'Kosovo', 381);
        CountriesTableSeeder::insertCountries('KW', 'KWT', 'Koweït', 965);
        CountriesTableSeeder::insertCountries('RE', 'REU', 'La Réunion', 262);
        CountriesTableSeeder::insertCountries('LA', 'LAO', 'Laos', 856);
        CountriesTableSeeder::insertCountries('LS', 'LSO', 'Lesotho', 266);
        CountriesTableSeeder::insertCountries('LV', 'LVA', 'Lettonie', 371);
        CountriesTableSeeder::insertCountries('LB', 'LBN', 'Liban', 961);
        CountriesTableSeeder::insertCountries('LR', 'LBR', 'Liberia', 231);
        CountriesTableSeeder::insertCountries('LY', 'LBY', 'Libye', 218);
        CountriesTableSeeder::insertCountries('LI', 'LIE', 'Liechtenstein', 423);
        CountriesTableSeeder::insertCountries('LT', 'LTU', 'Lituanie', 370);
        CountriesTableSeeder::insertCountries('LU', 'LUX', 'Luxembourg', 352);
        CountriesTableSeeder::insertCountries('MO', 'MAC', 'Macao', 853);
        CountriesTableSeeder::insertCountries('MK', 'MKD', 'Macédoine', 389);
        CountriesTableSeeder::insertCountries('MG', 'MDG', 'Madagascar', 261);
        CountriesTableSeeder::insertCountries('MY', 'MYS', 'Malaisie', 60);
        CountriesTableSeeder::insertCountries('MW', 'MWI', 'Malawi', 265);
        CountriesTableSeeder::insertCountries('MV', 'MDV', 'Maldives', 960);
        CountriesTableSeeder::insertCountries('ML', 'MLI', 'Mali', 223);
        CountriesTableSeeder::insertCountries('MT', 'MLT', 'Malte', 356);
        CountriesTableSeeder::insertCountries('MA', 'MAR', 'Maroc', 212);
        CountriesTableSeeder::insertCountries('MR', 'MRT', 'Mauritanie', 222);
        CountriesTableSeeder::insertCountries('MX', 'MEX', 'Mexique', 52);
        CountriesTableSeeder::insertCountries('FM', 'FSM', 'Micronésie', 691);
        CountriesTableSeeder::insertCountries('MD', 'MDA', 'Moldavie', 373);
        CountriesTableSeeder::insertCountries('MC', 'MCO', 'Monaco', 377);
        CountriesTableSeeder::insertCountries('MN', 'MNG', 'Mongolie', 976);
        CountriesTableSeeder::insertCountries('ME', 'MNE', 'Monténégro', 382);
        CountriesTableSeeder::insertCountries('MS', 'MSR', 'Montserrat', 1664);
        CountriesTableSeeder::insertCountries('MZ', 'MOZ', 'Mozambique', 258);
        CountriesTableSeeder::insertCountries('MM', 'MMR', 'Myanmar', 95);
        CountriesTableSeeder::insertCountries('NA', 'NAM', 'Namibie', 264);
        CountriesTableSeeder::insertCountries('NR', 'NRU', 'Nauru', 674);
        CountriesTableSeeder::insertCountries('NP', 'NPL', 'Népal', 977);
        CountriesTableSeeder::insertCountries('NI', 'NIC', 'Nicaragua', 505);
        CountriesTableSeeder::insertCountries('NE', 'NER', 'Niger', 227);
        CountriesTableSeeder::insertCountries('NG', 'NGA', 'Nigéria', 234);
        CountriesTableSeeder::insertCountries('NU', 'NIU', 'Nioué', 683);
        CountriesTableSeeder::insertCountries('NO', 'NOR', 'Norvège', 47);
        CountriesTableSeeder::insertCountries('NC', 'NCL', 'Nouvelle-Calédonie', 687);
        CountriesTableSeeder::insertCountries('NZ', 'NZL', 'Nouvelle-Zélande', 64);
        CountriesTableSeeder::insertCountries('OM', 'OMN', 'Oman', 968);
        CountriesTableSeeder::insertCountries('UG', 'UGA', 'Ouganda', 256);
        CountriesTableSeeder::insertCountries('UZ', 'UZB', 'Ouzbékistan', 998);
        CountriesTableSeeder::insertCountries('PK', 'PAK', 'Pakistan', 92);
        CountriesTableSeeder::insertCountries('PW', 'PLW', 'Palaos', 680);
        CountriesTableSeeder::insertCountries('PA', 'PAN', 'Panama', 507);
        CountriesTableSeeder::insertCountries('PG', 'PNG', 'Papouasie-Nouvelle-Guinée', 675);
        CountriesTableSeeder::insertCountries('PY', 'PRY', 'Paraguay', 595);
        CountriesTableSeeder::insertCountries('NL', 'NLD', 'Pays-Bas', 31);
        CountriesTableSeeder::insertCountries('PE', 'PER', 'Pérou', 51);
        CountriesTableSeeder::insertCountries('PH', 'PHL', 'Philippines', 63);
        CountriesTableSeeder::insertCountries('PL', 'POL', 'Pologne', 48);
        CountriesTableSeeder::insertCountries('PF', 'PYF', 'Polynésie Française', 689);
        CountriesTableSeeder::insertCountries('PR', 'PRI', 'Porto Rico', 1);
        CountriesTableSeeder::insertCountries('PT', 'PRT', 'Portugal', 351);
        CountriesTableSeeder::insertCountries('QA', 'QAT', 'Qatar', 974);
        CountriesTableSeeder::insertCountries('CD', 'COD', 'République démocratique du Congo', 243);
        CountriesTableSeeder::insertCountries('DO', 'DOM', 'République Dominicaine', 1);
        CountriesTableSeeder::insertCountries('CG', 'COG', 'République du Congo', 242);
        CountriesTableSeeder::insertCountries('CZ', 'CZE', 'République tchèque', 420);
        CountriesTableSeeder::insertCountries('RO', 'ROU', 'Roumanie', 40);
        CountriesTableSeeder::insertCountries('RU', 'RUS', 'Russie', 7);
        CountriesTableSeeder::insertCountries('RW', 'RWA', 'Rwanda', 250);
        CountriesTableSeeder::insertCountries('EH', 'ESH', 'Sahara Occidental', 212);
        CountriesTableSeeder::insertCountries('BL', 'BLM', 'Saint-Barthélemy', 590);
        CountriesTableSeeder::insertCountries('KN', 'KNA', 'Saint-Christophe-et-Niévès', 1);
        CountriesTableSeeder::insertCountries('SM', 'SMR', 'Saint-Marin', 378);
        CountriesTableSeeder::insertCountries('MF', 'MAF', 'Saint-Martin', 1599);
        CountriesTableSeeder::insertCountries('PM', 'SPM', 'Saint-Pierre et Miquelon', 508);
        CountriesTableSeeder::insertCountries('VC', 'VCT', 'Saint-Vincent-et-les Grenadines', 1);
        CountriesTableSeeder::insertCountries('SH', 'SHN', 'Sainte-Hélène', 290);
        CountriesTableSeeder::insertCountries('LC', 'LCA', 'Sainte-Lucie', 1);
        CountriesTableSeeder::insertCountries('WS', 'WSM', 'Samoa', 685);
        CountriesTableSeeder::insertCountries('AS', 'ASM', 'Samoa américaines', 1684);
        CountriesTableSeeder::insertCountries('ST', 'STP', 'Sao Tomé-et-Principe', 239);
        CountriesTableSeeder::insertCountries('SN', 'SEN', 'Sénégal', 221);
        CountriesTableSeeder::insertCountries('RS', 'SRB', 'Serbie', 381);
        CountriesTableSeeder::insertCountries('SC', 'SYC', 'Seychelles', 248);
        CountriesTableSeeder::insertCountries('SL', 'SLE', 'Sierra Leone', 232);
        CountriesTableSeeder::insertCountries('SG', 'SGP', 'Singapour', 65);
        CountriesTableSeeder::insertCountries('SK', 'SVK', 'Slovaquie', 421);
        CountriesTableSeeder::insertCountries('SI', 'SVN', 'Slovénie', 386);
        CountriesTableSeeder::insertCountries('SO', 'SOM', 'Somalie', 252);
        CountriesTableSeeder::insertCountries('SD', 'SDN', 'Soudan', 249);
        CountriesTableSeeder::insertCountries('SS', 'SSD', 'Soudan du Sud', 211);
        CountriesTableSeeder::insertCountries('LK', 'LKA', 'Sri Lanka', 94);
        CountriesTableSeeder::insertCountries('SE', 'SWE', 'Suède', 46);
        CountriesTableSeeder::insertCountries('CH', 'CHE', 'Suisse', 41);
        CountriesTableSeeder::insertCountries('SR', 'SUR', 'Suriname', 597);
        CountriesTableSeeder::insertCountries('SZ', 'SWZ', 'Swaziland', 268);
        CountriesTableSeeder::insertCountries('SY', 'SYR', 'Syrie', 963);
        CountriesTableSeeder::insertCountries('TJ', 'TJK', 'Tadjikistan', 992);
        CountriesTableSeeder::insertCountries('TW', 'TWN', 'Taiwan', 886);
        CountriesTableSeeder::insertCountries('TZ', 'TZA', 'Tanzanie', 255);
        CountriesTableSeeder::insertCountries('TH', 'THA', 'Thaïlande', 66);
        CountriesTableSeeder::insertCountries('TL', 'TLS', 'Timor Oriental', 670);
        CountriesTableSeeder::insertCountries('TG', 'TGO', 'Togo', 228);
        CountriesTableSeeder::insertCountries('TK', 'TKL', 'Tokelau', 690);
        CountriesTableSeeder::insertCountries('TT', 'TTO', 'Trinité-et-Tobago', 1);
        CountriesTableSeeder::insertCountries('TN', 'TUN', 'Tunisie', 216);
        CountriesTableSeeder::insertCountries('TM', 'TKM', 'Turkmenistan', 993);
        CountriesTableSeeder::insertCountries('TR', 'TUR', 'Turquie', 90);
        CountriesTableSeeder::insertCountries('TV', 'TUV', 'Tuvalu', 688);
        CountriesTableSeeder::insertCountries('UA', 'UKR', 'Ukraine', 380);
        CountriesTableSeeder::insertCountries('UY', 'URY', 'Uruguay', 598);
        CountriesTableSeeder::insertCountries('VU', 'VUT', 'Vanuatu', 678);
        CountriesTableSeeder::insertCountries('VA', 'VAT', 'Vatican', 39);
        CountriesTableSeeder::insertCountries('VE', 'VEN', 'Venezuela', 58);
        CountriesTableSeeder::insertCountries('VN', 'VNM', 'Viêt Nam', 84);
        CountriesTableSeeder::insertCountries('YE', 'YEM', 'Yémen', 967);
        CountriesTableSeeder::insertCountries('ZM', 'ZMB', 'Zambie', 260);
    }

}
