<?php

namespace App\Admin\Controllers\World;

use App\Models\World\City;

use App\Models\World\Country;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

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

            $content->header('City');
            $content->description('description');

            $content->body($this->grid());
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

            $content->header('City');
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

            $grid->ID('ID')->sortable();
            $grid->Name()->editable();
            $grid->country()->Name('Country');
            $grid->District();
            $grid->Population();

            $grid->filter(function ($filter) {
                $filter->like('Name');
                $filter->like('country.Name');
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

            $form->display('ID', 'ID');

            $form->text('Name')->rules('required');

            $form->select('CountryCode', 'Country')->options(function ($code) {
                return Country::options($code);
            })->ajax('/demo/api/world/countries');

            $form->text('District');
            $form->text('Population');

        });
    }
}
