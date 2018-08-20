<?php

namespace App\Admin\Controllers\Subway;

use App\Models\Subway\Line;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Show;

class LineController extends Controller
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

            $content->row(function($row) {
                $row->column(10, $this->grid());
                $row->column(2, view('admin.grid.subway'));
            });
        });
    }

    public function show($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('Lines');
            $content->description('线路详情');

            $content->body(Admin::show(Line::findOrFail($id), function (Show $show) {

                $show->name();
                $show->uid();
                $show->city()->cn_name();

                $show->stops('地铁线', function ($stop) {

                    $stop->resource('/demo/subway/stops');

                    $stop->id();
                    $stop->name();
                    $stop->uid();

                    $stop->column('position')->openMap(function () {
                        return [$this->lat/100000, $this->lng/100000];
                    }, 'Position');

                    $stop->created_at();
                    $stop->updated_at();

                });
            }));
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
        return Admin::grid(Line::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->name();

//            $grid->uid();
//            $grid->pair_uid();
//            $grid->stops()->display(function ($lines) {
//                return array_column($lines, 'name');
//            })->implode('</br>');

            $grid->city()->cn_name();

            $grid->created_at();
            $grid->updated_at();

            $grid->filter(function ($filter) {
                $filter->expand();
                $filter->like('name', 'Name');
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Line::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
