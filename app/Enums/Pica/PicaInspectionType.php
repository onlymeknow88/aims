<?php

declare(strict_types=1);

namespace App\Enums\Pica;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PicaInspectionType extends Enum
{
    const Inspection                        = 'Inspeksi';
    const AuditInternal                     = 'Audit Internal';
    const AuditExternal                     = 'Audit External';
    const Investigation                     = 'Investigasi';
    const Monitoring                        = 'Monitoring';
    const EvaluationRegilationAndPermits    = 'Evaluasi Peraturan & Perijinan';
    const IbprAndBowtie                     = 'IBPR & Bowtie';
    const FieldLeadership                   = 'Field Leadership';
    const EvaluationTSP                     = 'Evaluasi Target, Sasaran, Program (TSP)';
}
