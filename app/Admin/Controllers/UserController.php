<?php

namespace App\Admin\Controllers;

use App\Admin\Resources\UserResource;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Layout\Content;

class UserController extends Controller
{
    use HasResourceActions;

    /**
     * @var UserResource
     */
    protected $resource;

    /**
     * @var string
     */
    protected $title = 'Users';

    /**
     * UserController constructor.
     *
     * @param UserResource $resource
     */
    public function __construct(UserResource $resource)
    {
        $this->resource = $resource;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Content
     */
    protected function index(Content $content)
    {
        return $content
            ->header($this->title)
            ->description('Index')
            ->body($this->resource->grid());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header($this->title)
            ->description('Detail')
            ->body($this->resource->detail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header($this->title)
            ->description('Edit')
            ->body($this->resource->form()->edit($id));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header($this->title)
            ->description('Create')
            ->body($this->resource->form());
    }
}
