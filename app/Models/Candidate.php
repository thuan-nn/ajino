<?php

namespace App\Models;

class Candidate extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'candidates';

    protected $fillable = [
        'job_id',
        'name',
        'phone_number',
        'email',
        'address',
        'additional',
    ];

    protected $casts = [
        'addtional' => 'json',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function files()
    {
        return $this->morphToMany(File::class, 'model', 'model_has_files');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jobTranslation()
    {
        return $this->belongsTo(JobTranslation::class, 'job_translation_id', 'id');
    }
}
