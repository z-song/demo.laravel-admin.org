<?php

namespace App\Admin\Controllers\Subway;

use App\Models\Subway\City;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Show;

class CityController extends Controller
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

            $content->header('Cities');
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

            $content->header('Cities');
            $content->description('城市详情');

            $content->body(Admin::show(City::findOrFail($id), function (Show $show) {

                $show->cn_name('中文名');
                $show->en_name('英文名');
                $show->code('城市编码');
                $show->field('pre');

                $show->lines('地铁线', function ($line) {

                    $line->resource('/demo/subway/lines');

                    $line->id();
                    $line->name();
                    $line->pair_uid();
                    $line->created_at();
                    $line->updated_at();

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
        return Admin::grid(City::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->cn_name();
            $grid->en_name();

//            $grid->lines()->display(function ($lines) {
//                return array_column($lines, 'name');
//            })->implode('</br>');

//            $grid->code();
//            $grid->pre();

            $grid->created_at();
            $grid->updated_at();

            $grid->filter(function ($filter) {
                $filter->expand();
                $filter->like('cn_name', 'Name');
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
        return Admin::form(City::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
