<?php

namespace App\Admin\Controllers\Subway;

use App\Models\Subway\Line;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class LineController extends AdminController
{
    protected $title = 'Lines';

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->title($this->title)
            ->description('description')
            ->row(function($row) {
                $row->column(10, $this->grid());
                $row->column(2, view('admin.grid.subway'));
            });
    }

    protected function detail($id)
    {
        $show = new Show(Line::findOrFail($id));

        $show->name();
        $show->uid();
        $show->city()->cn_name();

        $show->stops('地铁线', function ($stop) {

            $stop->resource('/demo/subway/stops');

            $stop->id();
            $stop->name();
            $stop->uid();

            $stop->column('position')->openMap(function () {
                return [$this->lat / 100000, $this->lng / 100000];
            }, 'Position');

            $stop->created_at();
            $stop->updated_at();
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Line());

        $grid->id('ID')->sortable();

        $grid->name();

        $grid->city()->cn_name();

        $grid->created_at();
        $grid->updated_at();

        $grid->filter(function ($filter) {
            $filter->expand();
            $filter->like('name', 'Name');
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
        $form = new Form(new Line());

        $form->display('id', 'ID');

        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');

        return $form;
    }
}
