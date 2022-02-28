<?php

namespace App\Transformers;

use App\Enums\LanguageEnum;
use App\Models\Location;
use Flugg\Responder\Transformers\Transformer;
use Illuminate\Support\Arr;

class LocationUiTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param \App\Models\Location $location
     * @return array
     */
    public function transform(Location $location)
    {
        return [
            'id'           => (string) $location->id,
            'type'         => (string) $location->type,
            'name'         => (string) $location->display_name,
            'code'         => (string) $location->code,
            'facebook_url' => (string) $location->facebook_url,
            'address'      => (string) $location->address,
            'phone'        => (string) $location->phone,
            'email'        => (string) $location->email,
            'additional'   => $location->additional,
            'content'      => $this->getContent($location->content),
            'created_at'   => (string) $location->created_at,
            'updated_at'   => (string) $location->updated_at,
        ];
    }

    private function getContent($content)
    {
        $local = request('locale') ?: LanguageEnum::VI;

        return Arr::get($content, $local);
    }
}
