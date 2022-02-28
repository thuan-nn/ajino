<?php

namespace App\Models;

use App\Builders\LocationBuilder;
use App\Enums\LanguageEnum;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'locations';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'name_en',
        'type',
        'code',
        'facebook_url',
        'address',
        'phone',
        'email',
        'additional',
        'content',
        'address_en'
    ];

    protected $casts = [
        'additional' => 'array',
        'content'    => 'array',
    ];

    protected $appends = ['display_name', 'display_address'];

    public function provideCustomBuilder()
    {
        return LocationBuilder::class;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobs()
    {
        return $this->hasMany(Job::class, 'location_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companyTours()
    {
        return $this->hasMany(CompanyTour::class, 'location_id', 'id');
    }

    public function getDisplayNameAttribute()
    {
        $locale =  request('locale') ?? request()->header('App-Locale');

        return $locale === LanguageEnum::VI ? $this->name : $this->name_en;
    }

    public function getDisplayAddressAttribute()
    {
        $locale =  request('locale') ?? request()->header('App-Locale');

        return $locale === LanguageEnum::VI ? $this->address : $this->address_en;
    }
}
