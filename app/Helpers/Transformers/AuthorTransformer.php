<?php

namespace App\Helpers\Transformers;


class AuthorTransformer extends Transformer
{

    /**
     * Transforms authors for json response
     *
     * @param $author
     * @return mixed
     */
    public function transform($author)
    {
        return [
            'id' => $author['id'] . '#^' . $author['full_name'],
            'authors_name' => $author['full_name']
        ];
    }
}