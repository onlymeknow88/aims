<?php declare(strict_types=1);

namespace App\Enums\MCU;

use BenSampo\Enum\Enum;

/**
 * @method static static Jantung()
 * @method static static Diabetes()
 * @method static static Kanker()
 * @method static static Asma()
 */
final class FamilyDiseaseHistory extends Enum
{
    const Tidak_Ada = 'Tidak Ada';
    const Jantung = 'Jantung';
    const Diabetes = 'Diabetes';
    const Kanker = 'Kanker';
    const Asma = 'Asma';
}
