<?php

namespace App\Transformers;

class WardrobeTransformer
{
    public static function transform($wardrobe)
    {
        return $wardrobe->map(function ($c) {
            return [
                'name' => $c->name,
                'id' => $c->id,
                'desc' => $outfit->description,
                'clothes' => $c->clothing
                    ->mapWithKeys(function ($clothing) {
                        return [$clothing->pivot->category => [
                            'name' => $clothing->name,
                            'id' => $clothing->id, 
                        ]];
                    })
                    ->toArray(),
            ];
        })
        ->toArray();
    }
}
