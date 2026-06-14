<?php

namespace Modules\IbprAndBowtie\Database\Seeders;

use App\Models\IbprBowty\Bowtie;
use App\Models\IbprBowty\BowtieActivity;
use App\Models\IbprBowty\BowtieCca;
use App\Models\IbprBowty\BowtieEvent;
use App\Models\IbprBowty\BowtieEventCmf;
use App\Models\IbprBowty\BowtieEventCmfRepair;
use App\Models\IbprBowty\BowtieEventImm;
use App\Models\IbprBowty\BowtieEventImmRepair;
use App\Models\IbprBowty\BowtieEventReason;
use App\Models\IbprBowty\BowtieLossCalculation;
use App\Models\IbprBowty\BowtieLossCalculationDetail;
use App\Models\IbprBowty\BowtiePerformanceStandard;
use App\Models\IbprBowty\BowtieTeam;
use App\Models\IbprBowty\Iadl;
use App\Models\IbprBowty\IadlForm;
use App\Models\IbprBowty\IadlFormBowtie;
use App\Models\IbprBowty\IadlTeam;
use App\Models\IbprBowty\Ibpr;
use App\Models\IbprBowty\IbprForm;
use App\Models\IbprBowty\IbprFormBowtie;
use App\Models\IbprBowty\IbprMasterBahaya;
use App\Models\IbprBowty\IbprMasterHirarki;
use App\Models\IbprBowty\IbprTeam;
use App\Models\IbprBowty\Pica;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class IbprTruncateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Bowtie::truncate();
        BowtieActivity::truncate();
        BowtieCca::truncate();
        BowtieEvent::truncate();
        BowtieEventCmf::truncate();
        BowtieEventCmfRepair::truncate();
        BowtieEventImm::truncate();
        BowtieEventImmRepair::truncate();
        //BowtieEventReason::truncate();
        BowtieLossCalculation::truncate();
        BowtieLossCalculationDetail::truncate();
        BowtiePerformanceStandard::truncate();
        BowtieTeam::truncate();
        Iadl::truncate();
        IadlForm::truncate();
        IadlFormBowtie::truncate();
        IadlTeam::truncate();
        Ibpr::truncate();
        IbprForm::truncate();
        IbprFormBowtie::truncate();
        IbprMasterBahaya::truncate();
        IbprMasterHirarki::truncate();
        IbprTeam::truncate();
        Pica::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
