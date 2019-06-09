<?php

namespace App\Admin\Controllers\China;

use App\Models\ChinaArea;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class CityController extends AdminController
{
    protected $title = 'City';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ChinaArea());

        $grid->model()->city();

        $grid->name()->editable();

        $grid->children('District')->pluck('name')->label();

        $grid->filter(function ($filter) {
            $filter->like('name');
            $filter->equal('parent_id', 'Province')->select(ChinaArea::province()->pluck('name', 'id'));
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
