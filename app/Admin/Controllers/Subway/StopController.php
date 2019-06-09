<?php

namespace App\Admin\Controllers\Subway;

use App\Models\Subway\Stop;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class StopController extends AdminController
{
    protected $title = 'Stops';

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->title($this->title)
            ->row(function($row) {
                $row->column(10, $this->grid());
                $row->column(2, view('admin.grid.subway'));
            });
    }

    protected function detail($id)
    {
        $show = new Show(Stop::findOrFail($id));

        $show->name();
        $show->uid();
        $show->lat();
        $show->lng();

        $show->line(function ($line) {
            $line->name();
            $line->uid();
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
        $grid = new Grid(new Stop());

        $grid->id('ID')->sortable();

        $grid->name();

        $grid->line()->name();

        $grid->column('position')->openMap(function () {
            return [$this->lat/100000, $this->lng/100000];
        }, 'Position');

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
        $form = new Form(new Stop());

        $form->display('id', 'ID');

        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');

        return $form;
    }
}
