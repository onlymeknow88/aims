<?php

namespace Modules\KO\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Modules\KO\Entities\KoAttachment;
use Modules\KO\Entities\KoBrand;
use Modules\KO\Entities\KoCommissioning;
use Modules\KO\Entities\KoCommissioningItem;
use Modules\KO\Entities\KoIssueReport;
use Modules\KO\Entities\KoIssueReportAttachment;
use Modules\KO\Entities\KoProposal;
use Modules\KO\Entities\KoUnit;
use DB;

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

        $permissionNames = [
            'KO - Login',//
            'KO - Master Library',//

            'KO - Admin Revoke Unit Verification',//
            'KO - Coordinator Revoke Unit Verification',//

            'KO - Create Proposal',//

            'KO - Admin Proposal Verification',//
            'KO - Coordinator Proposal Verification',//

            'KO - Create Commissioning',//

            'KO - Admin Commissioning Verification',//
            'KO - Coordinator Commissioning Verification',//

            'KO - Request Temporary QR',//
            'KO - QR Request Verification',//
            'KO - Print Temporary QR',//

            'KO - Open PICA',//
            'KO - Admin PICA',//
            'KO - Coordinator PICA',//
            'KO - Solved PICA',//

            'KO - Print QR',//
        ];

        foreach ($permissionNames as $value) {
            Permission::findOrCreate($value, 'ko');
        }
    }
}
