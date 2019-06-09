<?php

namespace App\Admin\Controllers;

use App\Models\Tag;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class TagController extends AdminController
{
    protected $title = 'Tags';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Tag());

        $grid->id('ID')->sortable();

        $grid->name()->editable();

        $grid->options()->checkbox([
            1 => 'Sed ut perspiciatis unde omni',
            2 => 'voluptatem accusantium doloremque',
            3 => 'dicta sunt explicabo',
            4 => 'laudantium, totam rem aperiam',
        ]);

        $states = [
            'on' => ['text' => 'YES'],
            'off' => ['text' => 'NO'],
        ];

        $grid->column('switch_group')->switchGroup([
            'recommend' => '推荐', 'hot' => '热门', 'new' => '最新'
        ], $states);

        $grid->created_at();
        $grid->updated_at();

        $grid->filter(function ($filter) {
            $filter->between('updated_at')->datetime();
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
        $form = new Form(new Tag());

        $form->display('id', 'ID');

        $form->text('name')->rules('required');

        $form->checkbox('options')->options([
            1 => 'Sed ut perspiciatis unde omni',
            2 => 'voluptatem accusantium doloremque',
            3 => 'dicta sunt explicabo',
            4 => 'laudantium, totam rem aperiam',
        ])->stacked();

        $form->switch('recommend');
        $form->switch('hot');
        $form->switch('new');

        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');

        return $form;
    }
}
