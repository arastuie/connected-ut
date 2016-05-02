<?php


namespace App\Http\Controllers;


use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{
    /**
     * @var statusCode
     */
    protected $statusCode = 200;

    /**
     * @return mixed
     */
    protected function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     * @return $this
     */
    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Returns a not found error
     *
     * @param string $message
     * @return mixed
     */
    protected function respondNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * @param $data
     * @param array $headers
     * @return mixed
     */
    protected function respond($data, $headers = [])
    {
        return response()->json($data, $this->statusCode, $headers);
    }


    /**
     * @param $message
     * @return mixed
     */
    protected function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode(),
            ]
        ]);
    }


    /**
     * Returns with pagination
     *
     * @param $result
     * @param $data
     * @param $inputs: all the get parameters for current url
     * @return mixed
     */
    protected function respondWithPagination($result, $inputs, $data)
    {
        $data = array_merge($data, [
            'paginator' => [
                'total_count' => $result->total(),
                'total_pages' => ceil($result->total() / $result->perPage()),
                'current_page' => $result->currentPage(),
                'limit' => $result->perPage(),
                'item_from' => ($result->currentPage() - 1) * $result->perPage() + 1,
                'item_to' => $result->currentPage() * $result->perPage(),
                'html_nav' => $result->appends($inputs)->render()
            ]
        ]);

        return $this->respond($data);
    }
}