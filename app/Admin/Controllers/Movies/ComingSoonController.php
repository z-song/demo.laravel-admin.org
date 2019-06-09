<?php

namespace App\Admin\Controllers\Movies;

use App\Http\Controllers\Controller;
use App\Models\Movie\ComingSoon;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class ComingSoonController extends Controller
{
    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        $content->title('即将上映');
        $content->description('上海');

        $content->body($this->grid());

        return $content;
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ComingSoon());

        $grid->title();
        $grid->images()->first()->image();
        $grid->year();
        $grid->rating()->display(function ($rating) {
            return $rating['average'];
        });
        $grid->directors()->pluck('name')->label('primary');

        $grid->casts()->pluck('name')->label();

        $grid->genres()->badge();

        $grid->disableActions();
        $grid->disableBatchDeletion();
        $grid->disableExport();
        $grid->disableCreateButton();
        $grid->disableFilter();

        return $grid;
    }
}