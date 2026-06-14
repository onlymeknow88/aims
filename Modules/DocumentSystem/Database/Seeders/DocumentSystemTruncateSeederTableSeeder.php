<?php

namespace Modules\DocumentSystem\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\DocumentSystem\Entities\Activity;
use Modules\DocumentSystem\Entities\ActivityAttachment;
use Modules\DocumentSystem\Entities\Attachment;
use Modules\DocumentSystem\Entities\Document;
use Modules\DocumentSystem\Entities\InvitedPeople;
use Modules\DocumentSystem\Entities\JsaDocument;
use Modules\DocumentSystem\Entities\JsaDocumentActivity;
use Modules\DocumentSystem\Entities\JsaDocumentAttachment;
use Modules\DocumentSystem\Entities\JsaDocumentPeople;
use Modules\DocumentSystem\Entities\PtwDocument;
use Modules\DocumentSystem\Entities\PtwDocumentActivity;
use Modules\DocumentSystem\Entities\PtwDocumentAttachment;
use Modules\DocumentSystem\Entities\PtwDocumentPeople;

class DocumentSystemTruncateSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Activity::truncate();
        ActivityAttachment::truncate();
        Attachment::truncate();
        Document::truncate();
        InvitedPeople::truncate();
        JsaDocument::truncate();
        JsaDocumentActivity::truncate();
        JsaDocumentAttachment::truncate();
        JsaDocumentPeople::truncate();
        PtwDocument::truncate();
        PtwDocumentActivity::truncate();
        PtwDocumentAttachment::truncate();
        PtwDocumentPeople::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
