<?php

namespace App\Transformers;

class OutfitTransformer
{

    public static function transformOne($outfit){
        return [
            'name' => $outfit->name,
            'id' => $outfit->id,
            'desc' => $outfit->description,
            'clothes' => $outfit->clothing
                ->mapWithKeys(function ($clothing) {

                    return [$clothing->pivot->category => [
                        'name' => $clothing->name,
                        'description' => $clothing->description,
                        'id' => $clothing->id, 
                        'size' => $clothing->size,
                        'color' => $clothing->color,
                        'wear_count' => $clothing->wear_count,
                        'category' => $clothing->category,
                    ]];
                })
                ->toArray(),
        ];
    }


    public static function transform($outfits)
    {
        return $outfits->map(function ($outfit) {
            return [
                'name' => $outfit->name,
                'id' => $outfit->id,
                'desc' => $outfit->description,
                'clothes' => $outfit->clothing
                    ->mapWithKeys(function ($clothing) {

                        return [$clothing->pivot->category => [
                            'name' => $clothing->name,
                            'description' => $clothing->description,
                            'id' => $clothing->id, 
                            'size' => $clothing->size,
                            'color' => $clothing->color,
                            'wear_count' => $clothing->wear_count,
                            'category' => $clothing->category,
                        ]];
                    })
                    ->toArray(),
            ];
        })
        ->toArray();
    }
}
