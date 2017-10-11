<?php

namespace App\Admin\Controllers;

use App\Models\Tag;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class TagController extends Controller
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
            $content->header('Tags');
            $content->description('All tags');
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

            $content->header('Tags');
            $content->description('Edit tags');
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
            $content->header('Tags');
            $content->description('Create tags');
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
        return Admin::grid(Tag::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->name()->editable();

            $grid->options()->checkbox([
                1 => 'Sed ut perspiciatis unde omni',
                2 => 'voluptatem accusantium doloremque',
                3 => 'dicta sunt explicabo',
                4 => 'laudantium, totam rem aperiam',
            ]);

            $states = [
                'on' => ['text' => 'YES'],
                'off' => ['text' => 'NO'],
            ];

            $grid->column('switch_group')->switchGroup([
                'recommend' => '推荐', 'hot' => '热门', 'new' => '最新'
            ], $states);

            $grid->created_at();
            $grid->updated_at();

            $grid->filter(function ($filter) {
                $filter->between('updated_at')->datetime();
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
        return Admin::form(Tag::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('name')->rules('required');

            $form->checkbox('options')->options([
                1 => 'Sed ut perspiciatis unde omni',
                2 => 'voluptatem accusantium doloremque',
                3 => 'dicta sunt explicabo',
                4 => 'laudantium, totam rem aperiam',
            ])->stacked();

            $form->switch('recommend');
            $form->switch('hot');
            $form->switch('new');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
