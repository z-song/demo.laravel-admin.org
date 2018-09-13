<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Callout;
use Encore\Admin\Widgets\Form;

class EditorsController extends Controller
{
    public function markdown(Content $content)
    {
        $form = new Form();
        $form->simplemde('content');

        return $content
            ->header($title = 'Markdown Editor')
            ->row($this->info('https://github.com/laravel-admin-extensions/simplemde', $title))
            ->row(new Box($title, $form));
    }

    public function wangEditor(Content $content)
    {
        $form = new Form();
        $form->editor('content');

        return $content
            ->header($title = 'Wang Editor')
            ->row($this->info('https://github.com/laravel-admin-extensions/wangEditor', $title))
            ->row(new Box($title, $form));
    }

    public function summernote(Content $content)
    {
        $form = new Form();
        $form->summernote('content');

        return $content
            ->header($title = 'Summernote Editor')
            ->row($this->info('https://github.com/laravel-admin-extensions/summernote', $title))
            ->row(new Box($title, $form));
    }

    public function json(Content $content)
    {
        $form = new Form();
        $form->jsonEditor('content');

        return $content
            ->header($title = 'Json Editor')
            ->row($this->info('https://github.com/laravel-admin-extensions/json-editor', $title))
            ->row(new Box($title, $form));
    }

    protected function info($url, $title)
    {
        $content = "<a href=\"{$url}\" target='_blank'>{$url}</a>";

        return new Callout($content, $title, 'info');
    }
}