<?php declare(strict_types=1);

namespace App\Enums\DocumentSystem;

use BenSampo\Enum\Enum;

/**
 * @method static static Document()
 * @method static static Record()
 */
final class UploadType extends Enum
{
    const Document  = 'DOCUMENT';
    const Record    = 'RECORD';
}
