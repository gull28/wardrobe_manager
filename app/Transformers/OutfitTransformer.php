<?php

namespace App\Transformers;

class OutfitTransformer
{
    public static function transform($outfits)
    {
        return $outfits->map(function ($outfit) {
            return [
                'name' => $outfit->name,
                'desc' => $outfit->description,
                'clothes' => $outfit->clothing
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
