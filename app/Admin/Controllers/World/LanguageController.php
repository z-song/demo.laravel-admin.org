<?php

namespace App\Admin\Controllers\World;

use App\Models\World\Language;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->title('Language')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Language());

        $grid->country()->Name('Country');
        $grid->Language();
        $grid->IsOfficial()->display(function ($isOfficial) {
            return $isOfficial == 'T' ? "<i class='fa fa-check' style='color:green'></i>" : "<i class='fa fa-close' style='color:red'></i>";
        });
        $grid->Percentage()->display(function ($percentage) {
            return "$percentage %";
        })->label();


        $grid->disableActions();
        $grid->disableCreateButton();

        $grid->filter(function ($filter) {
            $filter->like('Language');
            $filter->is('CountryCode');
            $filter->like('country.Name');
        });

        return $grid;
    }
}

