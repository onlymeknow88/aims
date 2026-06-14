<?php declare(strict_types=1);

namespace Modules\Audit\Enums;

use BenSampo\Enum\Enum;


final class AuditMethod extends Enum
{
    const INTERVIEW = 'Wawancara';
    const OBSERVATION = "Observasi";
    const DOCUMENT_REVIEW = "Tinjauan Dokumen dan Rekaman";
    const NOT_APPLICABLE = "N/A";
}
