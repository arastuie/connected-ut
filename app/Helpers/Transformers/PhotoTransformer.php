<?php

namespace App\Helpers\Transformers;


class PhotoTransformer extends Transformer
{

    /**
     * Transforms photos for json response
     *
     * @param $photo
     * @return mixed
     */
    public function transform($photo)
    {
        return [
            'id' => $photo['id'],
            'path' => $photo['path'],
            'thumbnail_path' => $photo['thumbnail_path'],
            'is_main' => $photo['is_main']
        ];
    }
}