<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DenominationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $denominations = [
            [
                'name' => 'Catholic',
                'description' => 'The largest Christian denomination, led by the Pope, emphasizing tradition and sacraments.',
            ],
            [
                'name' => 'Orthodox',
                'description' => 'An ancient Christian tradition with strong liturgical practices and emphasis on the early church.',
            ],
            [
                'name' => 'Lutheran',
                'description' => 'A Protestant branch founded by Martin Luther, focusing on justification by faith.',
            ],
            [
                'name' => 'Anglican',
                'description' => 'A tradition combining elements of Catholicism and Protestantism, originating from the Church of England.',
            ],
            [
                'name' => 'Methodist',
                'description' => 'Known for its focus on personal holiness and social justice, stemming from John Wesley’s teachings.',
            ],
            [
                'name' => 'Presbyterian',
                'description' => 'A Reformed Protestant denomination with a strong emphasis on governance by elders.',
            ],
            [
                'name' => 'Baptist',
                'description' => 'A Protestant group emphasizing believer’s baptism and the authority of Scripture.',
            ],
            [
                'name' => 'Pentecostal',
                'description' => 'A movement emphasizing the gifts of the Holy Spirit, such as speaking in tongues and healing.',
            ],
            [
                'name' => 'Seventh Day Adventist',
                'description' => 'A Protestant denomination observing Saturday as the Sabbath and emphasizing Christ’s return.',
            ],
            [
                'name' => 'Non-Denominational',
                'description' => 'Independent churches that emphasize a personal relationship with Jesus without formal affiliation.',
            ],
            [
                'name' => 'Assemblies of God',
                'description' => 'A Pentecostal denomination focused on evangelism and the baptism of the Holy Spirit.',
            ],
            [
                'name' => 'Salvation Army',
                'description' => 'A Christian organization combining worship with extensive charitable and social work.',
            ],
        ];

        foreach ($denominations as $denomination) {
            \App\Models\Denomination::create([
                'name' => $denomination['name'],
                'description' => $denomination['description'],
            ]);
        }
    }
}
