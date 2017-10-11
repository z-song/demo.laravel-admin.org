<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Tools\GridView;
use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Layout\Content;
use Illuminate\Support\Facades\Request;

class ImageController extends Controller
{
    use ModelForm;

    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('Images');

            $content->body($this->grid());
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
            $content->header('Images');
            $content->description(trans('admin::lang.create'));

            $content->body($this->form());
        });
    }

    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('Images');
            $content->description('Edit');

            $content->body($this->form()->edit($id));
        });
    }

    protected function grid()
    {
        return Admin::grid(Image::class, function (Grid $grid) {

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

        });
    }

    public function form()
    {
        return Admin::form(Image::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('caption');
            $form->select('uploader')->options(User::all()->pluck('name', 'id'));

            $form->image('image')->flip('v')->rules('required');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
