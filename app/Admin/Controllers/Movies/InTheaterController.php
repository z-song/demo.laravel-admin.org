<?php

namespace App\Admin\Controllers\Movies;

use App\Http\Controllers\Controller;
use App\Models\Movie\InTheater;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class InTheaterController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('正在上映的电影');
            $content->description('上海');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('Orderable articles');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(InTheater::class, function (Grid $grid) {

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
        });
    }

    protected function form()
    {
        return Admin::form(InTheater::class, function (Form $form) {

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

        });
    }
}