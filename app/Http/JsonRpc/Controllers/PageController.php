<?php


namespace App\Http\JsonRpc\Controllers;

use App\Exceptions\JsonRpcException;
use App\Exceptions\JsonRpcExceptions\InvalidParametersException;
use App\Models\Page;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * @param array $params
     * @return array
     * @throws \Throwable
     */
    public function addPage(array $params): array
    {
        $validator = Validator::make($params, [
            'name' => 'required|string',
            'author' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new InvalidParametersException();
        }

        $page = new Page();
        $page->name = $params['name'];
        $page->author = $params['author'];
        $page->page_uid = Str::uuid();
        $page->saveOrFail();

        return ['page_uid' => $page->page_uid];
    }

    /**
     * @param array $params
     * @return array
     * @throws InvalidParametersException
     * @throws JsonRpcException
     */
    public function getPageByUID(array $params): array
    {
        $validator = Validator::make($params, [
            'page_uid' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new InvalidParametersException();
        }

        $pageUID = $params['page_uid'];

        /** @var Page $page */
        $page = Page::where('page_uid', $pageUID)->first();
        if (!$page) {
            // @TODO продумать классификацию кодов ошибок для подобных случаев
            throw new JsonRpcException("Page [$pageUID] was not found.");
        }

        return $page->toArray();
    }
}
