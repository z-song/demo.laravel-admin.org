<?php

namespace App\Admin\Controllers;

use App\Models\Tag;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Tags')
            ->description('All tags')
            ->body($this->grid());
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Tags')
            ->description('Edit tags')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Tags')
            ->description('Create tags')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Tag());

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

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Tag());

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

        return $form;
    }
}
