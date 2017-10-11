<?php

namespace App\Admin\Controllers;

use App\Models\Tag;
use App\Models\Video;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class VideoController extends Controller
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
            $content->header('header');
            $content->description('description');
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

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Video::class, function (Grid $grid) {

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
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Video::class, function (Form $form) {

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
        });
    }
}
