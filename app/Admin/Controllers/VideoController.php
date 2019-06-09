<?php

namespace App\Admin\Controllers;

use App\Models\Tag;
use App\Models\Video;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class VideoController extends AdminController
{
    protected $title = 'Videos';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Video());

        $grid->id('ID')->sortable();

        $grid->title()->limit(30);

        $grid->status()->radio([
            0 => 'Sed ut perspiciatis unde omni',
            1 => 'voluptatem accusantium doloremque',
            2 => 'dicta sunt explicabo',
            3 => 'laudantium, totam rem aperiam',
        ]);

        $grid->tags()->pluck('name')->label();

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
        $form = new Form(new Video());

        $form->display('id', 'ID');

        $form->text('title')->rules('required');

        $form->radio('status')->options([
            0 => 'Sed ut perspiciatis unde omni',
            1 => 'voluptatem accusantium doloremque',
            2 => 'dicta sunt explicabo',
            3 => 'laudantium, totam rem aperiam',
        ])->stacked();

        $form->file('video');

        $form->datetime('release_at');

        $form->multipleSelect('tags')->options(Tag::all()->pluck('name', 'id'));

        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');

        return $form;
    }
}
