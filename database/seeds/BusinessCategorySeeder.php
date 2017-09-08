<?php

use Illuminate\Database\Seeder;
use App\Models\BusinessCategory;
use App\Models\BusinessType;

class BusinessCategorySeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DB::table('business_types')->insert([
            'id' => BusinessType::TYPE_BUSINESS_RESTAURANT,
            'label' => 'Restaurant',
            'id_media' => 0,
        ]);

        self::insertBusinessCategory("Régionale", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Régionale", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("bistronomique", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Asiatique", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Africaine", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("burger", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Américaine", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Crêperie", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Moyen Orient", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Fromages / Fondues", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Océanie", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("fusionée", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("des Iles", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Gastronomique", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Moderne / Créative", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Pizzeria", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Poissons / Fruits de Mer", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("steak house", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Allemande", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Allemagne du Nord", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Badenoise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Hessienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Palatine", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Saxone", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Souabe", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Thuringeoise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Westphalienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Britannique", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Anglaise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Ecossaise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Galloise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Irlandaise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Balkanique", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Albanaise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Bosniaque", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Bulgare", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Croate", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Monténégrine", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Roumaine", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Serbe", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Autrichienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Heurigenoise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Belge", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Flamande", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Danoise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Smørrebrød", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Espagnole", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Andalouse", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Asturienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Basque", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Castillane", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Catalane", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Galice", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Flamenco", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Alsacienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Auvergnate", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Aveyronnaise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Basque", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Bourguignonne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Bressane", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Bretonne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Catalane", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Charentaise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Corse", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Flamande", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Franc Comtoise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Lorraine", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Lyonnaise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Normande", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Picarde", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Provençale", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Savoyarde", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("du Sud-Ouest", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Greque", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Hollandaise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Hongroise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Italienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Abruzzes", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Calabre", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Campanie", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Emilie-Romagne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Lazio", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Ligurie", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Lombarde", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Mantoue", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Marches", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Piémontaise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Romaine", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Sarde", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Sicilienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Toscane", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Méditerranéenne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Valtellinese", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Vénitienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Trattoria-Osteria", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Polonaise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Portugaise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Alentejano", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Fado", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Russe", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Scandinave", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Finlandaise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Norvégienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Suédoise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Suisse", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Tchèque", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Bohémienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Turque", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Bangladeshie", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Birmane", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Cambodgienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Chinoise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Cantonaise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Dim Sum", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Pékinoise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Szechuanaise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Coréenne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Indienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Sud-Indienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Bengalie", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Kashmiri", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Indienne Végétarienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Indonésienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Japonaise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Izakaya", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Okonomi-Yaki", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Ramen", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Soba", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Sushi", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Teppanyaki", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Malaisienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Mongolienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Népalaise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Pakistanaise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Philippine", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Singapourienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Sri Lankaise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Thaïlandaise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Tibétaine", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Vietnamienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Egyptienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Marocaine", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Tunisienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Ethiopienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Sud-Africaine", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Algérienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Argentine", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Brésilienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Des Caraïbes", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Chilienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Colombienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Cubaine", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Guatémaltèque", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Jamaicaine", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Mexicaine", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Nord-Américaine", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Américaine / Canadienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Californienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Bakery", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Barbecue", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Sud-Américaine", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Sud Ouest Américaine", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Cajun", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Texane", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Péruvienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Portoricaine", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Vénézuélienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Afghane", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Israëlienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Libanaise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Ouzbèque", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Arménienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Iranienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Australienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Neo-Zélandaise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Antillaise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Créole", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Océan Indien", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Malgache", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Mauricienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Seychelloise", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Océan Pacifique", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Hawaïenne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Polynésienne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Brasserie", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Européenne", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Tapas", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Tartes / Salades", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Traditionnelle / Classique", BusinessCategory::TYPE_COOKING_TYPE);
        self::insertBusinessCategory("Viandes / Grillades", BusinessCategory::TYPE_COOKING_TYPE);

        self::insertBusinessCategory("Business", BusinessCategory::TYPE_RESTAURANT_AMBIENCE);
        self::insertBusinessCategory("Traditionnel", BusinessCategory::TYPE_RESTAURANT_AMBIENCE);
        self::insertBusinessCategory("Terrasse", BusinessCategory::TYPE_RESTAURANT_AMBIENCE);
        self::insertBusinessCategory("Gastronomique", BusinessCategory::TYPE_RESTAURANT_AMBIENCE);
        self::insertBusinessCategory("Piscine", BusinessCategory::TYPE_RESTAURANT_AMBIENCE);
        self::insertBusinessCategory("Convivial", BusinessCategory::TYPE_RESTAURANT_AMBIENCE);
        self::insertBusinessCategory("Insolite", BusinessCategory::TYPE_RESTAURANT_AMBIENCE);
        self::insertBusinessCategory("Dansant", BusinessCategory::TYPE_RESTAURANT_AMBIENCE);
        self::insertBusinessCategory("Lounge", BusinessCategory::TYPE_RESTAURANT_AMBIENCE);
        self::insertBusinessCategory("Chic", BusinessCategory::TYPE_RESTAURANT_AMBIENCE);
        self::insertBusinessCategory("Au vert", BusinessCategory::TYPE_RESTAURANT_AMBIENCE);
        self::insertBusinessCategory("Sport / événement", BusinessCategory::TYPE_RESTAURANT_AMBIENCE);
        self::insertBusinessCategory("Brasserie / Bistrot", BusinessCategory::TYPE_RESTAURANT_AMBIENCE);
        self::insertBusinessCategory("Bar à vin", BusinessCategory::TYPE_RESTAURANT_AMBIENCE);
        self::insertBusinessCategory("Bord de mer", BusinessCategory::TYPE_RESTAURANT_AMBIENCE);
        self::insertBusinessCategory("Montagne", BusinessCategory::TYPE_RESTAURANT_AMBIENCE);

        self::insertBusinessCategory("Accès handicapé", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Accès internet WIFI", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Air conditionné", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Animaux admis", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Cave à vin", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Cave à cigare", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Ecran tv", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Non fumeur", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Service traiteur", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Organisation évènement | groupe", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Service voiturier", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Zone fumeur", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Tenue correcte exigée", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Salon privé", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Réservation en ligne", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Réservation exigée", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Cheminée", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Table d'hôte", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Terrasse", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Service continu", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Animation enfant", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Diner spectacle", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Menu enfant", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Menu déjeuner", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Menu diner", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Menu affaire", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Menu dégustation", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Petit déjeuner", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Menu Brunch", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Happy hours", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Salon de thé", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Bar à vin", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Bar à cocktail", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Pub", BusinessCategory::TYPE_SERVICES);
        self::insertBusinessCategory("Service traiteur", BusinessCategory::TYPE_SERVICES);
    }

    function insertBusinessCategory($name, $type) {
        $businessCategoryModel = BusinessCategory::where('name', '=', $name)
                        ->where('type', '=', $type)->first();
        if (!$businessCategoryModel) {
            $name = ucfirst($name);
            $idBusinessCategory = \App\Utilities\UuidTools::generateUuid();
            BusinessCategory::create([
                'id' => $idBusinessCategory,
                'name' => $name,
                'type' => $type, //const type de cuisinne
            ]);
        }
    }

}