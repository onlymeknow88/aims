<?php

namespace Modules\FieldLeadership\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Modules\FieldLeadership\Entities\FieldLeadership;
use Modules\FieldLeadership\Entities\FieldLeadershipRisk;
use Modules\FieldLeadership\Entities\FieldLeadershipMember;
use Modules\FieldLeadership\Entities\FieldLeadershipActivity;
use Modules\FieldLeadership\Entities\FieldLeadershipPositive;
use Modules\FieldLeadership\Entities\FieldLeadershipRiskFile;
use Modules\FieldLeadership\Entities\FieldLeadershipQuestionPto;
use Modules\FieldLeadership\Entities\FieldLeadershipActivityFile;

class TruncateDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        FieldLeadershipActivityFile::truncate();
        FieldLeadershipActivity::truncate();
        FieldLeadershipMember::truncate();
        FieldLeadershipPositive::truncate();
        FieldLeadershipQuestionPto::truncate();
        FieldLeadershipRiskFile::truncate();
        FieldLeadershipRisk::truncate();
        FieldLeadership::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
