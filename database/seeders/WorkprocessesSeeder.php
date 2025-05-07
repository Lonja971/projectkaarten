<?php

namespace Database\Seeders;

use App\Models\Workprocess;
use Illuminate\Database\Seeder;

class WorkprocessesSeeder extends Seeder
{
    /**
     * Seed the workprocesses table.
     */
    public function run(): void
    {
         Workprocess::updateOrCreate(
            ['name' => 'B1K1W1'],
            [
               'name' => 'B1-K1-W1',
               'description' => 'Je overlegt met de opdrachtgever wat je moet ontwikkelen en wanneer dit klaar assende oplossing. '
            ]
        );
        Workprocess::updateOrCreate(
            ['name' => 'B1K1W2'],
            [
               'name' => 'B1-K1-W2',
               'description' => 'Op basis van de wensen en eisen van de opdrachtgever maak je mee'
            ]
        );

        Workprocess::updateOrCreate(
            ['name' => 'B1K1W3'],
            [
               'name' => 'B1-K1-W3',
               'description' => 'Je programmeert software. Tijdens het programmer'
            ]
        );

        Workprocess::updateOrCreate(
            ['name' => 'B1K1W4'],
            [
               'name' => 'B1-K1-W4',
               'description' => 'Je test de software die je geprogrammeerd h'
            ]
        );

        Workprocess::updateOrCreate(
            ['name' => 'B1K1W5'],
            [
               'name' => 'B1-K1-W5',
               'description' => 'Uit testresultaten, het overleg met '
            ]
        );

        Workprocess::updateOrCreate(
            ['name' => 'B1K2W1'],
            [
               'name' => 'B1-K2-W1',
               'description' => 'Je overlegt regelmatig met je pst.'
            ]
        );

        Workprocess::updateOrCreate(
            ['name' => 'B1K2W2'],
            [
               'name' => 'B1-K2-W2',
               'description' => 'Je presenteert je gemaakte werk aan delke oplossingen je bedacht hebt. Je geeft de mogelijkheid tot vragen stellen en beantwoord deze. Ook motiveer je de keuzes die je gemaakt hebt.'
            ]
        );

        Workprocess::updateOrCreate(
            ['name' => 'B1K2W3'],
            [
               'name' => 'B1-K2-W3',
               'description' => 'Je evalueert regelmatig je gemaakte werk. Hierbdig geef je feedback en feedforward aan je teamgenoten.'
            ]
        );
    }
}
