<?php

namespace App\Models;

use App\Builders\ContactUsBuilder;

class Contact extends BaseModel
{
    protected $table = 'contacts';

    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'address',
        'reason',
        'content',
        'is_open',
    ];

    public function provideCustomBuilder()
    {
        return ContactUsBuilder::class;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function files()
    {
        return $this->morphToMany(File::class, 'model', 'model_has_files');
    }
}
