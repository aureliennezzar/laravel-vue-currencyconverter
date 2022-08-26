<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Currency;
use App\Models\Pair;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Currency::factory()
            ->times(4)
            ->create();

        $currencies = Currency::all()->toArray();
        $pairs = [];
        foreach ($currencies as $currency) {
            foreach ($currencies as $currency_to) {
                if ($currency['id'] == $currency_to['id']) continue;
                $duo = [$currency, $currency_to];
                usort($duo, function ($a, $b) {
                    return strcmp($a['name'], $b['name']);
                });
                if(in_array($duo[0]['id'].$duo[1]['id'], $pairs)) continue;
                $pairs[] = $duo[0]['id'].$duo[1]['id'];
                $pair = new Pair();
                $pair->rate = mt_rand() / mt_getrandmax();;
                $pair->primary_currency = $duo[0]['id'];
                $pair->secondary_currency = $duo[1]['id'];
                $pair->save();
            }
        }
    }
}
