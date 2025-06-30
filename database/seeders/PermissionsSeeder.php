<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $data = [

            'administrateur',
            'administrateur-liste',

            'administrateur-create',

            'administrateur-edit',
            'administrateur-delete',


            'employer',
            'employer-liste',

            'employer-create',

            'employer-edit',
            'employer-delete',

            'departement',
            'departement-liste',

            'departement-create',

            'departement-edit',

            'departement-delete',


            'role',
            'role-liste',

            'role-create',

            'role-edit',

            'role-delete',


            'permission',
            'permission-liste',

            'permission-create',

            'permission-edit',

            'permission-delete',

            'config',
            'config-liste',

            'config-create',

            'config-delete',


            'payment',
            'payment-lancer',




        ];

        // Looping and Inserting Array's Users into User Table
        foreach ($data as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
