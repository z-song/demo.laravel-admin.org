<?php

namespace App\Admin\Controllers;

use App\Models\Painter;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class PainterController extends AdminController
{
    protected $title = 'Painters';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Painter());

        $grid->id('ID')->sortable();

        $grid->username()->editable();
        //$grid->bio()->editable('textarea');

        $grid->paintings()->pluck('title')->map(function ($title) {
            return "<strong><i>《 $title 》</i></strong>";
        })->implode('<br />');

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
        $form = new Form(new Painter());

        $form->display('id', 'ID');

        $form->text('username')->rules('required');
        $form->textarea('bio')->rules('required');

        $form->hasMany('paintings', '他的作品', function (Form\NestedForm $form) {
            $form->text('title');//->rules('required');
            $form->textarea('body');
            $form->datetime('completed_at');
        });

        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');

        return $form;
    }
}