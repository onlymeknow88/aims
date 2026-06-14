<?php

namespace App\Console\Commands;

use App\Jobs\ActiveDocumentJob;
use App\Models\DocumentSystem\Document;
use App\Models\DocumentSystem\InvitedPeople;
use App\Models\User;
use App\Notifications\NewDocumentSystemNotification;
use App\Notifications\NewJsaDocumentNotification;
use App\Services\DocumentSystemService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Modules\DocumentSystem\Entities\JsaDocument;

class PlaygroundCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'play:new-document';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $document = JsaDocument::with('peoples')
            ->where('status', JsaDocument::ACTIVE)
            ->find('98d57546-b8fe-48cf-8925-9044dbb1c45c');
        $peoples = $document->peoples;
        $emails = collect($peoples)->pluck('email')->all();
        $users = User::whereIn('email', $emails)->get();
        Notification::sendNow($users, new NewJsaDocumentNotification($document));
        $this->info(json_encode($document));
    }
}
