<?php namespace App\Helpers;

use Illuminate\Http\Request;

class SearchHelper
{
    /**
     * Unset the null inputs and checks for htmlspacialchars
     *
     * @param Request $request
     * @param array $inputs: Allowed inputs
     * @return array
     */
    public static function getSearchInputs(Request $request, array $inputs)
    {
        $searchInputs = $request->only($inputs);
        foreach($searchInputs as $key => $val)
        {
            if(is_null($searchInputs[$key]) || $searchInputs[$key] == "")
                unset($searchInputs[$key]);
            else
            {
                if(is_array($searchInputs[$key]))
                {
                    foreach($searchInputs[$key] as $innerKey => $innerVal)
                        $searchInputs[$key][$innerKey] = htmlspecialchars($searchInputs[$key][$innerKey], ENT_QUOTES);
                }
                else
                    $searchInputs[$key] = htmlspecialchars($searchInputs[$key], ENT_QUOTES);
            }
        }

        return $searchInputs;
    }

    /**
     * Returns limit for pagination based on request
     *
     * @param Request $request
     * @param int $defaultLimit
     * @return int
     * @internal param int $limit
     */
    public static function getPaginateLimit(Request $request, $defaultLimit)
    {
        $limit = (int)($request->input('limit', $defaultLimit));

        if($limit > 50)
            $limit = 50;
        else if($limit < 5)
            $limit = 5;

        return $limit;
    }
}