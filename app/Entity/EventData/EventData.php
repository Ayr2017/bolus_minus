<?php

namespace App\Entity\EventData;

use AllowDynamicProperties;
use App\Models\Event;
use App\Models\EventType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[AllowDynamicProperties] class EventData extends Event
{

    public array $storeRules = [];
    public array $data = [];
    public function getStoreKeys():array
    {
        return array_keys($this->storeRules);
    }

    public function getFields()
    {
        $slug = Str::upper(Str::slug(Str::kebab(class_basename($this)), '_'));
        return EventType
            ::with(['fields'])
            ->firstWhere('slug', $slug)->fields;
    }

}
