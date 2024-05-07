<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $branches = [
            ["000","7", "Head Office"],
            ["001","7", "Accra"],
            ["002","7", "Abossey-Okai"],
            ["003","7", "Gicel"],
            ["004","7", "Tema Fishing"],
            ["005","7", "Madina "],
            ["007","7", "Makola"],
            ["008","2", "Kumasi"],
            ["009","7", "Ring Road Central"],
            ["010","7", "Spintex"],
            ["011","2", "Adum"],
            ["012","7", "Tema Comm. 1"],
            ["013","7", "Weija"],
            ["014","7", "Tesano"],
            ["015","7", "Zongo Junction"],
            ["016","15", "Takoradi Harbour"],
            ["017","7", "Odorkor"],
            ["018","2", "Afful-Nkwanta"],
            ["019","2", "Aboabo"],
            ["020","5", "Cape Coast"],
            ["021","7", "Abeka"],
            ["022","5", "UCC"],
            ["023","11", "Tamale"],
            ["024","7", "North Ind. Area"],
            ["025","2", "Atonsu"],
            ["026","7", "Adentan"],
            ["027","15", "Takoradi Market Circle"],
            ["028","2", "Suame Maakro"],
            ["029","7", "Nkrumah Circle"],
            ["030","7", "Mataheko"],
            ["031","7", "Okaishie"],
            ["032","3", "Techiman"],
            ["033","7", "East Legon"],
            ["034","7", "Bawaleshie"],
            ["035","7", "Nungua"],
            ["036","7", "Valley View"],
            ["037","2", "Santasi Rndabt"],
            ["038","7", "University Of Ghana"],
            ["039","7", "Taifa"],
            ["040","6", "Koforidua"],
            ["041","7", "Airport City"],
            ["042","7", "Cantonments"],
            ["043","7", "Haatso"],
            ["044","4", "Sunyani"]

        ];
        foreach ($branches as $data)
        {
            $branch = new Branch();
            $branch->branch_code = $data[0];
            $branch->branch_name = $data[2];
            $branch->save();
        }
    }
}
