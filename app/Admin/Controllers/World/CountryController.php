<?php

namespace App\Admin\Controllers\World;

use App\Models\World\City;
use App\Models\World\Country;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class CountryController extends AdminController
{
    protected $title = 'Country';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Country());

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

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Country());

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

        return $form;
    }
}

