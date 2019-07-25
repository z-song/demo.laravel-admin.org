<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Document\CloneDocument;
use App\Admin\Actions\Document\CopyDocuments;
use App\Admin\Actions\Document\ImportDocument;
use App\Admin\Actions\Document\ModifyPrivilege;
use App\Admin\Actions\Document\ShareDocument;
use App\Admin\Actions\Document\ShareDocuments;
use App\Models\Document;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Storage;

class DocumentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '文档管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Document);

        $grid->quickSearch('title');

        $grid->sortable();

        $grid->quickCreate(function (Grid\Tools\QuickCreate $create) {
            $create->text('title');
            $create->email('desc');
        });

//        $grid->enableHotKeys();

        $grid->column('id', __('ID'))
            ->totalRow('统计')
            ->sortable();

        $grid->column('title', __('Title'))
            ->editable()
            ->filter('like')
            ->copyable();

        $grid->column('desc', __('Desc'))->hide();

        $grid->column('uploader.name', __('Uploader'));

        $grid->column('path', __('File path'))
            ->help('点击下载')
            ->downloadable()
            ->qrcode(function ($path) {
                return Storage::disk('admin')->url($path);
            })
        ;

        $grid->column('size', __('File Size'))->display(function () {
            $disk = Storage::disk('admin');

            if ($disk->exists($this->path)) {
                return $disk->size($this->path);
            }
        })->filesize();

        $grid->column('privilege', __('Privilege'))
            ->using(Document::$privileges)
            ->label([
                1 => 'default',
                2 => 'warning',
                3 => 'success',
                4 => 'info',
            ])
            ->filter(Document::$privileges);

        $grid->column('view_count', __('View count'))
            ->sortable()
            ->replace([0 => '-'])
            ->totalRow();

        $grid->column('download_count', __('价格'))
            ->sortable()
            ->replace([0 => '-'])
            ->totalRow()->filter('range');

        $grid->column('rate', __('Rate'))->replace([0 => '-'])->sortable();
        $grid->column('sort', __('Sort'))->hide();
        $grid->column('created_at', __('Created at'))->filter('range', 'datetime');
        $grid->column('updated_at', __('Updated at'))->hide();

        $grid->batchActions(function ($actions) {
            $actions->add(new ModifyPrivilege());
            $actions->add(new CopyDocuments());
            $actions->add(new ShareDocuments());
        });

        $grid->setActionClass(Grid\Displayers\DropdownActions::class);

        $grid->actions(function ($actions) {
            $actions->add(new CloneDocument());
            $actions->add(new ShareDocument());
        });

        $grid->tools(function (Grid\Tools $tools) {
            $tools->append(new ImportDocument());
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Document::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('title', __('Title'));
        $show->field('desc', __('Desc'));
//        $show->field('uploader.name', __('Uploader id'));

        $show->field('uploader', '作者')->as(function ($uploader) {
            return $uploader['name'];
        });

        $show->field('path', __('Path'))->file();
        $show->field('view_count', __('View count'));
        $show->field('download_count', __('Download count'));
        $show->field('rate', __('Rate'));
        $show->field('sort', __('Sort'));
        $show->field('privilege', __('Privilege'))->using(Document::$privileges)->label();
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Document);

        $form->text('title', __('Title'))->required();
        $form->textarea('desc', __('Desc'))->required();
        $form->select('uploader_id', __('Uploader'))
            ->options(User::all()->pluck('name', 'id'))
//            ->ajax('/demo/api/users')
            ->rules('required');
        $form->file('path', __('Path'))->required();
        $form->number('view_count', __('View count'))->default(0);
        $form->number('download_count', __('Download count'))->default(0);
        $form->number('rate', __('Rate'))->default(0);
        $form->radio('privilege', __('Privilege'))
            ->options(Document::$privileges)
            ->stacked()
            ->default(1);

        return $form;
    }
}
