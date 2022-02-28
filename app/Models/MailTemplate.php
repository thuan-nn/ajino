<?php

namespace App\Models;

use App\Builders\MailTemplateBuilder;
use App\Supports\Traits\ClearsResponseCache;
use App\Supports\Traits\HasUuid;
use App\Supports\Traits\OverridesBuilder;
use App\Supports\Traits\UserStamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class MailTemplate extends Model
{
    use HasFactory, Notifiable, HasUuid, HasRoles, OverridesBuilder, UserStamps, ClearsResponseCache;

    protected $fillable = [
        'type',
        'title',
        'content',
        'language',
    ];

    public function provideCustomBuilder()
    {
        return MailTemplateBuilder::class;
    }
}
