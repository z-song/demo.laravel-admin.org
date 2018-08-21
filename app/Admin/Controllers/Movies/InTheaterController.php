<?php

namespace App\Admin\Controllers\Movies;

use App\Http\Controllers\Controller;
use App\Models\Movie\InTheater;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class InTheaterController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        $content->header('正在上映的电影');
        $content->description('上海');

        $content->body($this->grid());

        return $content;
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id, Content $content)
    {
        $content->header('Orderable articles');
        $content->description('description');

        $content->body($this->form()->edit($id));

        return $content;
    }

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
        $grid->disableCreation();
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