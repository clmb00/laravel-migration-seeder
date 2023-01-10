<?php

namespace Database\Seeders;

use App\Models\Train;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Faker\Factory as FakerFactory;


class TrainTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $faker = FakerFactory::create('it_IT');
        for ($i=0; $i < 25; $i++) {
            $new_train = new Train();
            $new_train->azienda = $faker->randomElement(['Trenitalia', 'Trenord', 'Italo']);
            $new_train->stazione_di_partenza = $faker->city();
            $new_train->stazione_di_arrivo = $faker->city();
            $new_train->orario_di_partenza = $faker->time();
            $new_train->orario_di_arrivo = $faker->time();
            $new_train->tipo_treno = $faker->randomElement(['REG', 'RV', 'AV', 'SUB', 'IC']);
            $new_train->codice_treno = $faker->numerify('####');
            $new_train->numero_carrozze = $faker->numberBetween(1,14);
            $new_train->in_orario = $faker->biasedNumberBetween(0,1,'asin');
            $new_train->cancellato = $faker->biasedNumberBetween(0,1,'acos');
            $new_train->save();
        }
    }
}
