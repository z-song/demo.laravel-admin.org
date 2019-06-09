<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Tools\GridView;
use App\Models\Image;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Illuminate\Support\Facades\Request;

class ImageController extends AdminController
{
    protected $title = 'Images';

    protected function grid()
    {
        $grid = new Grid(new Image);

        $grid->id('ID');
        $grid->author()->name();
        $grid->caption()->limit(20);

        $grid->image()->image();

        $grid->created_at();

        $grid->tools(function ($tools) {
            $tools->append(new GridView());
        });

        if (Request::get('view') !== 'table') {
            $grid->setView('admin.grid.card');
        }

        return $grid;
    }

    public function form()
    {
        $form = new Form(new Image());

        $form->display('id', 'ID');

        $form->text('caption');
        $form->select('uploader')->options(User::all()->pluck('name', 'id'));

        $form->image('image')/*->flip('v')*/->rules('required');

        $form->display('created_at');
        $form->display('updated_at');

        return $form;
    }
}
