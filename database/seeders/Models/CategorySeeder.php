<?php
namespace Database\Seeders\Models;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Command :
         * artisan seed:generate --model-mode --models=Category
         *
         * *
         */
        
        $newData0 = \App\Models\Category::create([
            'id' => 3,
            'category' => 'Categorie 1 (hoog risico]',
            'category_remark' => 'Verplaatsbare arbeidsmiddelen en warmtedragers',
            'example' => 'Elektrisch handgereedschap • Verlengsnoeren • Haspels • Waterkokers • Tosti apparatuur',
            'inspection_interval' => 1,
            'created_at' => '2025-03-11 21:34:59',
            'updated_at' => '2025-05-09 20:13:15',
        ]);
        $newData1 = \App\Models\Category::create([
            'id' => 4,
            'category' => 'Categorie 2 (gemiddeld risico]',
            'category_remark' => 'Niet verplaatsbare arbeidsmiddelen, alle klasse 1 middelen, middelen die op een veiligheidsaarding (randaarde] moeten worden aangesloten zoals metalen behuizingen/omhulsels',
            'example' => 'Magnetron • Koelkasten • Vaste verlengsnoeren onder het bureau of vast gemonteerd op het bureau',
            'inspection_interval' => 4,
            'created_at' => '2025-03-11 21:38:46',
            'updated_at' => '2025-03-11 21:38:46',
        ]);
        $newData2 = \App\Models\Category::create([
            'id' => 5,
            'category' => 'Categorie 3 (laag risico]',
            'category_remark' => 'Items van veiligheidsklasse 2 en 3',
            'example' => 'Klasse 2 zijn dubbel geïsoleerde middelen (dubbel vierkantje] • Klasse 3 zijn middelen met een zeer lage spanning en VZ keten',
            'inspection_interval' => 7,
            'created_at' => '2025-03-11 21:41:18',
            'updated_at' => '2025-05-10 22:43:45',
        ]);
        $newData3 = \App\Models\Category::create([
            'id' => 6,
            'category' => 'Categorie 4 (geen keuring]',
            'category_remark' => 'Het niet keuren van genoemde arbeidsmiddelen is toegestaan indien aan de volgende zaken is voldaan:
De arbeidsmiddelen moeten CE-gemarkeerd zijn, de gebruiker controleert voor gebruik het apparaat, de lader visueel op gebreken en de lader en klein apparatuur dienen klasse 2 apparatuur te zijn.(dubbel geïsoleerd]
Alleen de IV mag besluiten een afwijkende interval dan hierboven genoemde toe te staan, onder voorwaarde dat wordt voldaan aan bepalingen in bijlage k “Het bepalen van de tijd tussen twee opeenvolgende inspecties van elektrische arbeidsmiddelen” van de NEN3140.',
            'example' => 'De volgende arbeidsmiddelen behoeven niet gekeurd te worden, en behoeve ook niet voorzien te zijn van een keuringssticker: Laders van laptops • Laders van telefoons • Kleine apparatuur w.o. stekker adapter uitvoering en maximaal 15VA •  PC’s •  Monitoren • ICTS apparatuur',
            'inspection_interval' => 0,
            'created_at' => '2025-03-11 21:44:26',
            'updated_at' => '2025-05-09 20:32:35',
        ]);
    }
}