<?php

namespace App\Admin\Controllers\Subway;

use App\Models\Subway\City;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CityController extends AdminController
{
    protected $title = 'Cities';

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->title('Cities')
            ->description('description')
            ->row(function($row) {
                $row->column(10, $this->grid());
                $row->column(2, view('admin.grid.subway'));
            });
    }

    protected function detail($id)
    {
        $show = new Show(City::findOrFail($id));

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

        return $show;
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new City());

        $grid->id('ID')->sortable();

        $grid->cn_name();
        $grid->en_name();

        $grid->created_at();
        $grid->updated_at();

        $grid->filter(function ($filter) {
            $filter->expand();
            $filter->like('cn_name', 'Name');
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
        $form = new Form(new City());

        $form->display('id', 'ID');

        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');

        return $form;
    }
}
