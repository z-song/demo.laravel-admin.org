<?php

namespace App\Admin\Controllers;

use App\Models\Painter;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class PainterController extends Controller
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
            $content->header('Painters');
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

            $content->header('Edit painters');

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

            $content->header('Create painters');

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
        return Admin::grid(Painter::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->username()->editable();
            //$grid->bio()->editable('textarea');

            $grid->paintings()->pluck('title')->map(function ($title) {
                return "<strong><i>《 $title 》</i></strong>";
            })->implode('<br />');

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
        return Admin::form(Painter::class, function (Form $form) {

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
        });
    }
}