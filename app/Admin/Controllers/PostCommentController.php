<?php

namespace App\Admin\Controllers;

use App\Models\Post;
use App\Models\PostComment;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class PostCommentController extends AdminController
{
    protected $title = 'Post comments';

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
