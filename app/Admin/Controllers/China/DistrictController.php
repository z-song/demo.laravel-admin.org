<?php

namespace App\Admin\Controllers\China;

use App\Models\ChinaArea;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class DistrictController extends AdminController
{
    protected $title = 'District';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ChinaArea());

        $grid->model()->district();

        $grid->name()->editable();

        $grid->parent()->name('City');

        $grid->filter(function ($filter) {
            $filter->like('name');
        });

        $grid->disableActions()
            ->disableCreateButton();

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
