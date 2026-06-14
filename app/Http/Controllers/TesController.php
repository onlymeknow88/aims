<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Support\Str;

use App\Models\COE\Event as CalenderOfEvent;
use DB;
use Carbon\Carbon;
use App\Access\ApiModules;
use App\Models\MainDashboard\RunningDate;
use Modules\Sap\Entities\SapDepartments;
use Modules\Sap\Entities\SapEmployees;

use App\Enums\FieldLeadership\FieldLeadershipType;
use Modules\FieldLeadership\Entities\FieldLeadership;
use App\Access\dateSetup;

class TesController extends Controller
{
    public function test(request $request)
    {

    }

    public function storageLink(request $request)
    {
        //$command_line =  $request->get('command_line');
        $auth =  $request->get('auth');
        if ($auth == 1001) {
            $run_command_line = " && php artisan storage:link"; //. $request->get('command_line');
            $process = Process::fromShellCommandline("cd " . base_path() . $run_command_line);
            $process->run();
            // executes after the command finishes
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            dd($process->getOutput());
        } else {
            abort(404);
        }
    }
}
