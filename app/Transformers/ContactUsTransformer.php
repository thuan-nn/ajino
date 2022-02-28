<?php

namespace App\Transformers;

use App\Models\Contact;
use App\Models\ContactUs;
use Flugg\Responder\Transformers\Transformer;

class ContactUsTransformer extends Transformer
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
     * @param \App\Models\Contact $contact
     * @return array
     */
    public function transform(Contact $contact)
    {
        return [
            'id'           => (string) $contact->id,
            'name'         => (string) $contact->name,
            'phone_number' => (string) $contact->phone_number,
            'email'        => (string) $contact->email,
            'address'      => (string) $contact->address,
            'reason'       => (string) $contact->reason,
            'content'      => (string) $contact->content,
            'is_open'      => (boolean) $contact->is_open,
            'images'       => thumbnail($contact->files()->pluck('id')),
            'created_at'   => (string) $contact->created_at,
            'updated_at'   => (string) $contact->updated_at,
        ];
    }
}
