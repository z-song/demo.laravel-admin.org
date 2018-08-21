<?php

namespace App\Admin\Controllers\World;

use App\Models\World\City;

use App\Models\World\Country;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('City')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content->header('City')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('header')
            ->description('description')
            ->body($this->form());
    }

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
