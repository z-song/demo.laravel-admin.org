<?php

namespace App\Admin\Controllers;

use App\Models\Post;
use App\Models\PostComment;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;

class PostCommentController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content->header('Post comments')
            ->description('Post comments')
            ->body($this->grid());
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('header')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('header')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PostComment());

        if ($post = request('post_id')) {
            $grid->model()->ofPost($post);
        }

        $grid->id('ID')->sortable();
        $grid->post()->title('Post');
        $grid->content()->editable();
        $grid->created_at();
        $grid->updated_at();

        $grid->filter(function ($filter) {
            $filter->like('content');
        });

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new PostComment());

        $form->display('id', 'ID');

        $form->select('post_id')->options(Post::all()->pluck('title', 'id'))->value(request('post_id'));
        $form->textarea('content');

        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');

        return $form;
    }
}
