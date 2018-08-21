<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Tools\GridView;
use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\User;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Support\Facades\Request;

class ImageController extends Controller
{
    use HasResourceActions;

    public function index(Content $content)
    {
        return $content
            ->header('Images')
            ->body($this->grid());
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Images')
            ->description(trans('admin::lang.create'))
            ->body($this->form());
    }

    public function edit($id, Content $content)
    {
        return $content
            ->header('Images')
            ->description('Edit')
            ->body($this->form()->edit($id));
    }

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

        $form->image('image')->flip('v')->rules('required');

        $form->display('created_at');
        $form->display('updated_at');

        return $form;
    }
}
