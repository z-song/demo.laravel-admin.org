<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Tools\Messagekind;
use App\Models\Message;

use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\Request;

class MessageController extends Controller
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

            $content->header('Messages');

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

            $content->header('header');
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
        return Message::grid(function (Grid $grid) {

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
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Message::form(function (Form $form) {

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
        });
    }
}
