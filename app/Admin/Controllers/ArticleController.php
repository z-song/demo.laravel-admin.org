<?php

namespace App\Admin\Controllers;

use App\Models\Article;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class ArticleController extends AdminController
{
    protected $title = 'Orderable articles';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article());

        $grid->model()->ordered();

        $grid->id('ID')->sortable();

        $grid->title()->editable();
        $grid->content()->editable();
        $grid->picture()->image();

        $grid->order()->orderable();

        $grid->created_at();
        $grid->updated_at();

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Article());

        $form->display('id', 'ID');

        $form->text('title')->rules('required');
        $form->textarea('content')->rules('required');
        $form->image('picture');

        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');

        return $form;
    }
}
