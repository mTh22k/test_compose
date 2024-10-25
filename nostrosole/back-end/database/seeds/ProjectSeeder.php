<?php

use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->insert([
            'holder' => 'Exemplo 1',
            'group' => '0', // in:A,B
            'status' => 'em andamento',
            'statusDescription' => 'Exemplo 1', // nullable? // min?
            'projectistObservation' => 'Exemplo 1',
            'isInspectionRequested' => '0',
        ]);
        DB::table('projects')->insert([
            'holder' => 'Exemplo 1',
            'group' => '0', // in:A,B
            'status' => 'em andamento',
            'statusDescription' => 'Exemplo 1', // nullable? // min?
            'projectistObservation' => 'Exemplo 1',
            'isInspectionRequested' => '0',
        ]);
        DB::table('projects')->insert([
            'holder' => 'Exemplo 1',
            'group' => '0', // in:A,B
            'status' => 'em andamento',
            'statusDescription' => 'Exemplo 1', // nullable? // min?
            'projectistObservation' => 'Exemplo 1',
            'isInspectionRequested' => '0',
        ]);
        DB::table('projects')->insert([
            'holder' => 'Exemplo 1',
            'group' => '0', // in:A,B
            'status' => 'em andamento',
            'statusDescription' => 'Exemplo 1', // nullable? // min?
            'projectistObservation' => 'Exemplo 1',
            'isInspectionRequested' => '0',
        ]);
        DB::table('projects')->insert([
            'holder' => 'Exemplo 2',
            'group' => '1', // in:A,B
            'status' => 'finalizado',
            'statusDescription' => 'Exemplo 2', // nullable? // min?
            'projectistObservation' => 'Exemplo 2',
            'isInspectionRequested' => '1',
        ]);
        DB::table('projects')->insert([
            'holder' => 'Exemplo 2',
            'group' => '1', // in:A,B
            'status' => 'finalizado',
            'statusDescription' => 'Exemplo 2', // nullable? // min?
            'projectistObservation' => 'Exemplo 2',
            'isInspectionRequested' => '1',
        ]);
        DB::table('projects')->insert([
            'holder' => 'Exemplo 3',
            'group' => '0', // in:A,B
            'status' => 'cancelado',
            'statusDescription' => 'Exemplo 3', // nullable? // min?
            'projectistObservation' => 'Exemplo 3',
            'isInspectionRequested' => '1',
        ]);

    }
}
