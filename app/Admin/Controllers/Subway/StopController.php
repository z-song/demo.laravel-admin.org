<?php

namespace App\Admin\Controllers\Subway;

use App\Models\Subway\Stop;

use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Show;

class StopController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        $content->header('header');
        $content->description('description');

        $content->row(function($row) {
            $row->column(10, $this->grid());
            $row->column(2, view('admin.grid.subway'));
        });

        return $content;
    }

    public function show($id, Content $content)
    {
        $content->header('Lines');
        $content->description('线路详情');

        $content->body(Admin::show(Stop::findOrFail($id), function (Show $show) {

            $show->name();
            $show->uid();
            $show->lat();
            $show->lng();

            $show->line(function ($line) {
                $line->name();
                $line->uid();
            });
        }));

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
        $content->header('header');
        $content->description('description');

        $content->body($this->form()->edit($id));

        return $content;
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create(Content $content)
    {
        $content->header('header');
        $content->description('description');

        $content->body($this->form());

        return $content;
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
