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

class CountryController extends Controller
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

            $content->header('Country');
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

            $content->header('Country');
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

            $content->header('Country');
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
        return Admin::grid(Country::class, function (Grid $grid) {

            $grid->Code('Code')->sortable();

            $grid->Name()->editable();
            $grid->Continent()->editable('select', array_combine(Country::$continents, Country::$continents));
            $grid->Region();
            $grid->SurfaceArea();
            $grid->IndepYear();
            $grid->Population();
            $grid->LifeExpectancy();
            $grid->city()->Name('Capital');

            $grid->column('language');

            $grid->rows(function (Grid\Row $row) {

                $row->column('language', "<a href='/demo/world/language?CountryCode={$row->Code}'>languages</a>");

            });

            $grid->filter(function ($filter) {
                $filter->like('Name');
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
        return Admin::form(Country::class, function (Form $form) {

            $form->display('Code', 'Code');

            $form->text('Name');
            $form->select('Continent')->options(array_combine(Country::$continents, Country::$continents));
            $form->text('Region');
            $form->decimal('SurfaceArea');
            $form->date('IndepYear')->format('YYYY');
            $form->text('Population');
            $form->decimal('LifeExpectancy');
            $form->text('GNP');
            $form->text('GNPOld');
            $form->text('LocalName');
            $form->textarea('GovernmentForm');
            $form->text('HeadOfState');

            $form->select('Capital')->options(function ($id) {

                return City::options($id);

            })->ajax('/demo/api/world/cities');

            $form->text('Code2');
        });
    }
}

