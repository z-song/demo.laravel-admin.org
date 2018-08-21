<?php

namespace App\Admin\Controllers\China;

use App\Models\ChinaArea;

use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;

class ProvinceController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        $content->header('Province');
        $content->description('description');
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
        $content->header('Province');
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
        $content->header('Country');
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
        $grid = new Grid(new ChinaArea());

        $grid->model()->province();

        $grid->name()->editable();

        $grid->children('City')->pluck('name')->label();

        $grid->filter(function ($filter) {
            $filter->like('name');
        });

        $grid->disableActions();
        $grid->disableCreation();

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ChinaArea());

        $form->display('id');
        $form->text('name');

        return $form;
    }
}
