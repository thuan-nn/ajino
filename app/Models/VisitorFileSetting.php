<?php

namespace App\Models;

use App\Builders\VisitorFileSettingBuilder;

class VisitorFileSetting extends BaseModel
{
    protected $table = 'visitor_file_setting';

    protected $fillable = [
        'type',
        'is_active',
    ];

    public function provideCustomBuilder()
    {
        return VisitorFileSettingBuilder::class;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function files()
    {
        return $this->morphToMany(File::class, 'model', 'model_has_files');
    }
}
