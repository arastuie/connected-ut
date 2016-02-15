<?php

namespace App\Helpers\Transformers;


class TagTransformer extends Transformer
{

    /**
     * @var string $tagName : name of the field with tag's name
     */
    protected $tagsName = 'name';

    /**
     * @var string $tagName : name of the field with tag's id
     */
    protected $tagsId = 'id';


    /**
     * Transforms tags for json response
     *
     * @param $tag
     * @param string $name => name of the field with tag's name
     * @return mixed
     */
    public function transform($tag)
    {
        return [
            'id' => $tag['id'],
            'name' => $tag[$this->tagsName]
        ];
    }

    /**
     * @param string $name
     * @return $this
     */
    public function tagsName($name = '')
    {
        $this->tagsName = $name;

        return $this;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function tagsId($id = 'id')
    {
        $this->tagsId = $id;

        return $this;
    }
}