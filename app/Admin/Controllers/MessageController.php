<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Tools\Messagekind;
use App\Models\Message;

use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Request;

class MessageController extends AdminController
{
    protected $title = 'Messages';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Message);

        $kind = Request::get('kind', 'inbox');

        $grid->model()->{$kind}(Admin::user()->id)->orderBy('id', 'desc');

        $grid->id('ID')->sortable();

        $grid->title();

        if ($kind == 'inbox') {
            $grid->sender()->name('Sender');
        } else {
            $grid->recipient()->name('Recipient');
        }

        $grid->created_at();
        $grid->updated_at();

        $grid->tools(function ($tools) {
            $tools->append(new Messagekind());
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
        $form = new Form(new Message);

        $form->display('id', 'ID');

        $form->select('to')->options(Administrator::all()->pluck('name', 'id'));
        $form->text('title');
        $form->textarea('body');

        $form->hidden('from');

        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');

        $form->saving(function ($form) {
            $form->from = Admin::user()->id;
        });

        return $form;
    }
}
