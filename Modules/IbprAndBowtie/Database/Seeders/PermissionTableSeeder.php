<?php

namespace Modules\IbprAndBowtie\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        $permissions = [
            'Ibpr And Bowtie - Login',//
            'Ibpr And Bowtie - Master Library',//
            'Ibpr And Bowtie - View IBPR',//
            'Ibpr And Bowtie - Create IBPR',//
            'Ibpr And Bowtie - Approve IBPR',//
            'Ibpr And Bowtie - View IADL',//
            'Ibpr And Bowtie - Create IADL',
            'Ibpr And Bowtie - Approve IADL',//
            'Ibpr And Bowtie - View BOWTIE',//
            'Ibpr And Bowtie - Create BOWTIE',//
            'Ibpr And Bowtie - Approve BOWTIE',//
            'Ibpr And Bowtie - Daftar Bowtie',//
            'Ibpr And Bowtie - Daftar Risiko',//
        ];

        foreach ($permissions as $value) {
            Permission::create([
                'name' => $value,
                'guard_name' => 'ibpr-and-bowtie'
            ]);
        }
    }
}
