<?php

namespace App\Admin\Controllers\World;

use App\Models\World\City;

use App\Models\World\Country;
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
        $grid = new Grid(new City());

        $grid->ID('ID')->sortable();
        $grid->Name()->editable();
        $grid->country()->Name('Country');
        $grid->District();
        $grid->Population();

        $grid->filter(function ($filter) {
            $filter->like('Name');
            $filter->like('country.Name');
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

        $form->display('ID', 'ID');

        $form->text('Name')->rules('required');

        $form->select('CountryCode', 'Country')->options(function ($code) {
            return Country::options($code);
        })->ajax('/demo/api/world/countries');

        $form->text('District');
        $form->text('Population');

        return $form;
    }
}
