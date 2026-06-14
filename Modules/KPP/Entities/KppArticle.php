<?php

namespace Modules\KPP\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KppArticle extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\KPP\Database\factories\KppArticleFactory::new();
    }

    public function rule()
    {
        return $this->belongsTo(KppRule::class, 'rule_id');
    }
}
