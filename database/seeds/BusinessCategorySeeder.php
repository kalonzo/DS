<?php

use Illuminate\Database\Seeder;

class BusinessCategorySeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        
        DB::table('business_types')->insert([
            'id' => \App\Models\BusinessType::TYPE_BUSINESS_RESTAURANT,
            'label' => 'Restaurant',
            'id_media' => 0,
        ]);
        
        self::insertBusinessCategory("Régionale", 1);
        self::insertBusinessCategory("bistronomique", 1);
        self::insertBusinessCategory("Asiatique", 1);
        self::insertBusinessCategory("Africaine", 1);
        self::insertBusinessCategory("burger", 1);
        self::insertBusinessCategory("Américaine", 1);
        self::insertBusinessCategory("Crêperie", 1);
        self::insertBusinessCategory("Moyen Orient", 1);
        self::insertBusinessCategory("Fromages / Fondues", 1);
        self::insertBusinessCategory("Océanie", 1);
        self::insertBusinessCategory("fusionée", 1);
        self::insertBusinessCategory("des Iles", 1);
        self::insertBusinessCategory("Gastronomique", 1);
        self::insertBusinessCategory("Moderne / Créative", 1);
        self::insertBusinessCategory("Pizzeria", 1);
        self::insertBusinessCategory("Poissons / Fruits de Mer", 1);
        self::insertBusinessCategory("Pub", 1);
        self::insertBusinessCategory("steak house", 1);
        self::insertBusinessCategory("Allemande", 1);
        self::insertBusinessCategory("Allemagne du Nord", 1);
        self::insertBusinessCategory("Badenoise", 1);
        self::insertBusinessCategory("Bavaroise", 1);
        self::insertBusinessCategory("Franconienne", 1);
        self::insertBusinessCategory("Hessienne", 1);
        self::insertBusinessCategory("Palatine", 1);
        self::insertBusinessCategory("Saxone", 1);
        self::insertBusinessCategory("Souabe", 1);
        self::insertBusinessCategory("Thuringeoise", 1);
        self::insertBusinessCategory("Westphalienne", 1);
        self::insertBusinessCategory("Britannique", 1);
        self::insertBusinessCategory("Anglaise", 1);
        self::insertBusinessCategory("Ecossaise", 1);
        self::insertBusinessCategory("Galloise", 1);
        self::insertBusinessCategory("Irlandaise", 1);
        self::insertBusinessCategory("Balkanique", 1);
        self::insertBusinessCategory("Albanaise", 1);
        self::insertBusinessCategory("Bosniaque", 1);
        self::insertBusinessCategory("Bulgare", 1);
        self::insertBusinessCategory("Croate", 1);
        self::insertBusinessCategory("Monténégrine", 1);
        self::insertBusinessCategory("Roumaine", 1);
        self::insertBusinessCategory("Serbe", 1);
        self::insertBusinessCategory("Autrichienne", 1);
        self::insertBusinessCategory("Heurigenoise", 1);
        self::insertBusinessCategory("Belge", 1);
        self::insertBusinessCategory("Flamande", 1);
        self::insertBusinessCategory("Danoise", 1);
        self::insertBusinessCategory("Smørrebrød", 1);
        self::insertBusinessCategory("Espagnole", 1);
        self::insertBusinessCategory("Andalouse", 1);
        self::insertBusinessCategory("Asturienne", 1);
        self::insertBusinessCategory("Basque", 1);
        self::insertBusinessCategory("Castillane", 1);
        self::insertBusinessCategory("Catalane", 1);
        self::insertBusinessCategory("Galice", 1);
        self::insertBusinessCategory("Flamenco", 1);
        self::insertBusinessCategory("Alsacienne", 1);
        self::insertBusinessCategory("Auvergnate", 1);
        self::insertBusinessCategory("Aveyronnaise", 1);
        self::insertBusinessCategory("Basque", 1);
        self::insertBusinessCategory("Bourguignonne", 1);
        self::insertBusinessCategory("Bressane", 1);
        self::insertBusinessCategory("Bretonne", 1);
        self::insertBusinessCategory("Catalane", 1);
        self::insertBusinessCategory("Charentaise", 1);
        self::insertBusinessCategory("Corse", 1);
        self::insertBusinessCategory("Flamande", 1);
        self::insertBusinessCategory("Franc Comtoise", 1);
        self::insertBusinessCategory("Lorraine", 1);
        self::insertBusinessCategory("Lyonnaise", 1);
        self::insertBusinessCategory("Normande", 1);
        self::insertBusinessCategory("Picarde", 1);
        self::insertBusinessCategory("Provençale", 1);
        self::insertBusinessCategory("Savoyarde", 1);
        self::insertBusinessCategory("du Sud-Ouest", 1);
        self::insertBusinessCategory("Greque", 1);
        self::insertBusinessCategory("Hollandaise", 1);
        self::insertBusinessCategory("Hongroise", 1);
        self::insertBusinessCategory("Italienne", 1);
        self::insertBusinessCategory("Abruzzes", 1);
        self::insertBusinessCategory("Calabre", 1);
        self::insertBusinessCategory("Campanie", 1);
        self::insertBusinessCategory("Emilie-Romagne", 1);
        self::insertBusinessCategory("Lazio", 1);
        self::insertBusinessCategory("Ligurie", 1);
        self::insertBusinessCategory("Lombarde", 1);
        self::insertBusinessCategory("Mantoue", 1);
        self::insertBusinessCategory("Marches", 1);
        self::insertBusinessCategory("Piémontaise", 1);
        self::insertBusinessCategory("Romaine", 1);
        self::insertBusinessCategory("Sarde", 1);
        self::insertBusinessCategory("Sicilienne", 1);
        self::insertBusinessCategory("Toscane", 1);
        self::insertBusinessCategory("Méditerranéenne", 1);
        self::insertBusinessCategory("Valtellinese", 1);
        self::insertBusinessCategory("Vénitienne", 1);
        self::insertBusinessCategory("Trattoria-Osteria", 1);
        self::insertBusinessCategory("Polonaise", 1);
        self::insertBusinessCategory("Portugaise", 1);
        self::insertBusinessCategory("Alentejano", 1);
        self::insertBusinessCategory("Fado", 1);
        self::insertBusinessCategory("Russe", 1);
        self::insertBusinessCategory("Scandinave", 1);
        self::insertBusinessCategory("Finlandaise", 1);
        self::insertBusinessCategory("Norvégienne", 1);
        self::insertBusinessCategory("Suédoise", 1);
        self::insertBusinessCategory("Suisse", 1);
        self::insertBusinessCategory("Tchèque", 1);
        self::insertBusinessCategory("Bohémienne", 1);
        self::insertBusinessCategory("Turque", 1);
        self::insertBusinessCategory("Bangladeshie", 1);
        self::insertBusinessCategory("Birmane", 1);
        self::insertBusinessCategory("Cambodgienne", 1);
        self::insertBusinessCategory("Chinoise", 1);
        self::insertBusinessCategory("Cantonaise", 1);
        self::insertBusinessCategory("Dim Sum", 1);
        self::insertBusinessCategory("Pékinoise", 1);
        self::insertBusinessCategory("Szechuanaise", 1);
        self::insertBusinessCategory("Coréenne", 1);
        self::insertBusinessCategory("Indienne", 1);
        self::insertBusinessCategory("Sud-Indienne", 1);
        self::insertBusinessCategory("Bengalie", 1);
        self::insertBusinessCategory("Kashmiri", 1);
        self::insertBusinessCategory("Indienne Végétarienne", 1);
        self::insertBusinessCategory("Indonésienne", 1);
        self::insertBusinessCategory("Japonaise", 1);
        self::insertBusinessCategory("Izakaya", 1);
        self::insertBusinessCategory("Okonomi-Yaki", 1);
        self::insertBusinessCategory("Ramen", 1);
        self::insertBusinessCategory("Soba", 1);
        self::insertBusinessCategory("Sushi", 1);
        self::insertBusinessCategory("Teppanyaki", 1);
        self::insertBusinessCategory("Malaisienne", 1);
        self::insertBusinessCategory("Mongolienne", 1);
        self::insertBusinessCategory("Népalaise", 1);
        self::insertBusinessCategory("Pakistanaise", 1);
        self::insertBusinessCategory("Philippine", 1);
        self::insertBusinessCategory("Singapourienne", 1);
        self::insertBusinessCategory("Sri Lankaise", 1);
        self::insertBusinessCategory("Thaïlandaise", 1);
        self::insertBusinessCategory("Tibétaine", 1);
        self::insertBusinessCategory("Vietnamienne", 1);
        self::insertBusinessCategory("Egyptienne", 1);
        self::insertBusinessCategory("Marocaine", 1);
        self::insertBusinessCategory("Tunisienne", 1);
        self::insertBusinessCategory("Ethiopienne", 1);
        self::insertBusinessCategory("Sud-Africaine", 1);
        self::insertBusinessCategory("Algérienne", 1);
        self::insertBusinessCategory("Argentine", 1);
        self::insertBusinessCategory("Brésilienne", 1);
        self::insertBusinessCategory("Des Caraïbes", 1);
        self::insertBusinessCategory("Chilienne", 1);
        self::insertBusinessCategory("Colombienne", 1);
        self::insertBusinessCategory("Cubaine", 1);
        self::insertBusinessCategory("Guatémaltèque", 1);
        self::insertBusinessCategory("Jamaicaine", 1);
        self::insertBusinessCategory("Mexicaine", 1);
        self::insertBusinessCategory("Nord-Américaine", 1);
        self::insertBusinessCategory("Américaine / Canadienne", 1);
        self::insertBusinessCategory("Californienne", 1);
        self::insertBusinessCategory("Bakery", 1);
        self::insertBusinessCategory("Barbecue", 1);
        self::insertBusinessCategory("Sud-Américaine", 1);
        self::insertBusinessCategory("Sud Ouest Américaine", 1);
        self::insertBusinessCategory("Cajun", 1);
        self::insertBusinessCategory("Texane", 1);
        self::insertBusinessCategory("Péruvienne", 1);
        self::insertBusinessCategory("Portoricaine", 1);
        self::insertBusinessCategory("Vénézuélienne", 1);
        self::insertBusinessCategory("Afghane", 1);
        self::insertBusinessCategory("Israëlienne", 1);
        self::insertBusinessCategory("Libanaise", 1);
        self::insertBusinessCategory("Ouzbèque", 1);
        self::insertBusinessCategory("Arménienne", 1);
        self::insertBusinessCategory("Iranienne", 1);
        self::insertBusinessCategory("Australienne", 1);
        self::insertBusinessCategory("Neo-Zélandaise", 1);
        self::insertBusinessCategory("Antillaise", 1);
        self::insertBusinessCategory("Créole", 1);
        self::insertBusinessCategory("Océan Indien", 1);
        self::insertBusinessCategory("Malgache", 1);
        self::insertBusinessCategory("Mauricienne", 1);
        self::insertBusinessCategory("Seychelloise", 1);
        self::insertBusinessCategory("Océan Pacifique", 1);
        self::insertBusinessCategory("Hawaïenne", 1);
        self::insertBusinessCategory("Polynésienne", 1);
        self::insertBusinessCategory("Bistrot, Brasserie, Bar à vin", 1);
        self::insertBusinessCategory("Européenne", 1);
        self::insertBusinessCategory("Tapas", 1);
        self::insertBusinessCategory("Tartes / Salades", 1);
        self::insertBusinessCategory("Traditionnelle / Classique", 1);
        self::insertBusinessCategory("Viandes / Grillades", 1);

        self::insertBusinessCategory("Business", 3);
        self::insertBusinessCategory("Traditionnel", 3);
        self::insertBusinessCategory("Terrasse", 3);
        self::insertBusinessCategory("Gastronomique", 3);
        self::insertBusinessCategory("Piscine", 3);
        self::insertBusinessCategory("Convivial", 3);
        self::insertBusinessCategory("Insolite", 3);
        self::insertBusinessCategory("Dansant", 3);
        self::insertBusinessCategory("Lounge", 3);
        self::insertBusinessCategory("Chic", 3);
        self::insertBusinessCategory("Au vert", 3);
        self::insertBusinessCategory("Sport / événement", 3);
        self::insertBusinessCategory("Brasserie / Bistrot", 3);
        self::insertBusinessCategory("Bar à vin", 3);
        self::insertBusinessCategory("Bord de mer", 3);
        self::insertBusinessCategory("Montagne", 3);

        self::insertBusinessCategory("Accès handicapé", 4);
        self::insertBusinessCategory("Accès internet WIFI", 4);
        self::insertBusinessCategory("Air conditionné", 4);
        self::insertBusinessCategory("Animaux admis", 4);
        self::insertBusinessCategory("Cave à vin", 4);
        self::insertBusinessCategory("Cave à cigare", 4);
        self::insertBusinessCategory("Ecran tv", 4);
        self::insertBusinessCategory("Non fumeur", 4);
        self::insertBusinessCategory("Service traiteur", 4);
        self::insertBusinessCategory("Organisation évènement | groupe", 4);
        self::insertBusinessCategory("Service voiturier", 4);
        self::insertBusinessCategory("Zone fumeur", 4);
        self::insertBusinessCategory("Tenue correcte exigée", 4);
        self::insertBusinessCategory("Salon privé", 4);
        self::insertBusinessCategory("Réservation en ligne", 4);
        self::insertBusinessCategory("Réservation exigée", 4);
        self::insertBusinessCategory("Cheminée", 4);
        self::insertBusinessCategory("Table d'hôte", 4);
        self::insertBusinessCategory("Terrasse", 4);
        self::insertBusinessCategory("Service continu", 4);
        self::insertBusinessCategory("Animation enfant", 4);
        self::insertBusinessCategory("Diner spectacle", 4);
        self::insertBusinessCategory("Menu enfant", 4);
        self::insertBusinessCategory("Menu déjeuner", 4);
        self::insertBusinessCategory("Menu diner", 4);
        self::insertBusinessCategory("Menu affaire", 4);
        self::insertBusinessCategory("Menu dégustation", 4);
        self::insertBusinessCategory("Petit déjeuner", 4);
        self::insertBusinessCategory("Menu Brunch", 4);
        self::insertBusinessCategory("Happy hours", 4);
        self::insertBusinessCategory("Salon de thé", 4);
        self::insertBusinessCategory("Bar à vin", 4);
        self::insertBusinessCategory("Bar à cocktail", 4);
        self::insertBusinessCategory("Pub", 4);
        self::insertBusinessCategory("Service traiteur", 4);
    }

    function insertBusinessCategory($name, $type) {
        $name = ucfirst($name);

        $id_business_category = \App\Utilities\UuidTools::generateUuid();
        DB::table('business_categories')->insert([
            'id' => $id_business_category,
            'name' => $name,
            'type' => $type, //const type de cuisinne
        ]);
    }

}
