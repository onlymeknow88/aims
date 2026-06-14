<?php

namespace Modules\Coe\Entities;

use App\Enums\COE\COEStatus;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;
    use HasUuids;

    protected $table = 'coe_events';

    protected $guarded = [];

    protected $dates = ['start_date', 'end_date'];

    protected $casts = [
        'invited_emails' => 'array',
        'notification_sent' => 'boolean',
        'repeat' => 'boolean',
        'must_send_email' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function related_event()
    {
        return $this->belongsTo(Event::class, 'related_event_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function isDeletable(): Attribute
    {
        return new Attribute(
            get: fn () => in_array($this->status, [COEStatus::Draft, COEStatus::Pending])
        );
    }


    public function isParent(): Attribute
    {
        return new Attribute(
            get: fn () => is_null($this->related_event_id)
        );
    }
}
