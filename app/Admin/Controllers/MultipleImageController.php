<?php

namespace App\Admin\Controllers;

use App\Models\MultipleImage;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class MultipleImageController extends AdminController
{
    protected $title = 'Multiple images upload';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new MultipleImage());

        $grid->id('ID')->sortable();

        $grid->title()->editable();

        $grid->pictures()->image();

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
        $form = new Form(new MultipleImage());

        $form->display('id', 'ID');

        $form->text('title')->rules('required');
        $form->multipleImage('pictures');

        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');

        return $form;
    }
}
