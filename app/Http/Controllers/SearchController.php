<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Helpers\SearchHelper;
use App\Services\SearchService;
use App\Http\Controllers\Controller;
use App\Helpers\Transformers\BookTransformer;

class SearchController extends ApiController
{
    const DEF_PAGINATION_LIMIT = 10;
    const BOOKS_DETAILED_SEARCH_INPUTS = ['title', 'author_list', 'course_list', 'instructor_list', 'ISBN_13', 'ISBN_10'];
    const SEARCH_QUERY_INPUTS = ['keywords'];


    public function books(SearchService $search, Request $request, BookTransformer $bookTransformer)
    {
        // Check if there are keywords
        if(! $request->has('keywords') || trim($request->input('keywords')) == "")
            return redirect('/books');

        $searchInputs  = SearchHelper::getSearchInputs($request, Self::SEARCH_QUERY_INPUTS);
        $searchInputs['limit'] = SearchHelper::getPaginateLimit($request, Self::DEF_PAGINATION_LIMIT);

        $result = $search->on('books')->by($searchInputs['keywords'])->get()->paginate($searchInputs['limit']);

        $respond = $this->respondWithPagination($result, $searchInputs, [
            'data' => $bookTransformer->transformCollection($result->all()),
            'search' => $searchInputs,
            'query' => http_build_query(array_except($searchInputs, ['limit'])),
            'current_url' => $request->url()
        ]);

        return view('books.index', compact('respond'));
    }

    /**
     * @param SearchService $search
     * @param Request $request
     * @param BookTransformer $bookTransformer
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function booksDetailed(SearchService $search, Request $request, BookTransformer $bookTransformer)
    {
        if($request->exists('keywords'))
        {
            $request->merge(['title' => $request->input('keywords')]);
            flash('detailed_search_open');
        }

        $searchInputs = SearchHelper::getSearchInputs($request, Self::BOOKS_DETAILED_SEARCH_INPUTS);

        if(sizeof($searchInputs) == 0)
            return redirect('books');

        $searchInputs['limit'] = SearchHelper::getPaginateLimit($request, Self::DEF_PAGINATION_LIMIT);

        $result = $search->on('books')->filter($searchInputs)->get()->paginate($searchInputs['limit']);

        $respond = $this->respondWithPagination($result, $searchInputs, [
            'data' => $bookTransformer->transformCollection($result->all()),
            'search' => $searchInputs,
            'query' => http_build_query(array_except($searchInputs, ['limit'])),
            'current_url' => $request->url()
        ]);

        return view('books.index', compact('respond'));
    }
}
