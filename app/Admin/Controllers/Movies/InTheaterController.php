<?php

namespace App\Admin\Controllers\Movies;

use App\Models\Movie\InTheater;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class InTheaterController extends AdminController
{
    protected $title = '正在上映的电影';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new InTheater());

        $grid->title();
        $grid->images()->first()->image();
        $grid->year();
        $grid->rating()->display(function ($rating) {
            return $rating['average'];
        });
        $grid->directors()->pluck('name')->label('primary');

        $grid->casts()->pluck('name')->label();

        $grid->genres()->badge();

        $grid->disableBatchDeletion();
        $grid->disableExport();
        $grid->disableCreateButton();
        $grid->disableFilter();

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new InTheater());

        $form->display('id', 'ID');

        $form->text('title')->rules('required');
        $form->text('original_title');
        $form->textarea('summary');
        $form->url('alt');
        $form->url('mobile_url');
        $form->url('share_url');
        $form->tags('countries');
        $form->tags('genres');
        $form->tags('aka');

        $form->year('year');

        return $form;
    }
}