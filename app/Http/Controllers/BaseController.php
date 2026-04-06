<?php


namespace App\Http\Controllers;


class BaseController extends Controller
{

    function responseJson($object = null, $massage = '', $response_status = 200, $pagination = null)
    {
        $response = [
            'status' => $response_status >= 200 && $response_status < 400,
            'message' => $massage,
            'data' => $object,
            'pagination' => $pagination,
        ];

        return response()->json($response, $response_status);
    }

    function getPaginates($collection)
    {
        return [
            'per_page' => $collection->perPage(),
            'path' => $collection->path(),
            'total' => $collection->total(),
            'current_page' => $collection->currentPage(),
            'next_page_url' => $collection->nextPageUrl(),
            'prev_page_url' => $collection->previousPageUrl(),
            'last_page' => $collection->lastPage(),
            'has_more_pages' => $collection->hasMorePages(),
            'from' => $collection->firstItem(),
            'to' => $collection->lastItem(),
        ];
    }

}
