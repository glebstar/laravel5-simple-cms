<?php

namespace GlebStarSimpleCms\Controllers;

use App\Http\Controllers\Controller as BaseController;
use Request;
use Illuminate\Http\Request as HRequest;
use GlebStarSimpleCms\Models\Cms;

class AdminController extends BaseController
{
    public function index()
    {
        return view('simplecms::admin.index', ['pages' => Cms::orderBy('path')->get()]);
    }

    public function add(HRequest $request)
    {
        if (Request::isMethod('post')) {
            $page = new Cms();
            $this->savePage ($request, $page);
            return redirect('/' . $page->path);
        } else {
            return view('simplecms::admin.add');
        }
    }

    public function edit($id, HRequest $request)
    {
        $page = Cms::where('id', $id)->first();
        if (! $page) {
            abort(404);
        }

        if (Request::isMethod('post')) {
            $this->savePage ($request, $page);
            return redirect('/' . $page->path);
        } else {
            return view('simplecms::admin.edit', ['page' => $page]);
        }
    }

    public function delete($id)
    {
        Cms::where('id', $id)->delete();

        return redirect(route('cms'));
    }

    protected function savePage($request, $page)
    {
        $this->validate($request, [
            'path'  => 'required|regex:/^[a-z0-9\/_]+$/',
            'title' => 'required|max:255',
            'body'  => 'required',
        ]);

        $page->path = $request->path;
        $page->title = $request->title;
        $page->description = Request::input('description', '');
        $page->keywords = Request::input('keywords', '');
        $page->body = base64_encode ($request->body);
        $page->save();
    }
}
