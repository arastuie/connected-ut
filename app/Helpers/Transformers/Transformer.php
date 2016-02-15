<?php

namespace App\Helpers\Transformers;

 abstract class Transformer
{
     /**
      * Transform a collection of objects
      *
      * @param array $items
      * @return array
      */
     public function transformCollection(array $items)
     {
         return array_map([$this, 'transform'], $items);
     }

     /**
      * Transformation method
      *
      * @param $item
      * @return mixed
      */
     public abstract function transform($item);
}