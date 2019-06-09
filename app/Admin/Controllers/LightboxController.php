<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Callout;

class LightboxController extends Controller
{
    public function lightbox(Content $content)
    {
        $grid = new Grid(new Image());
        $grid->id('ID');
        $grid->author()->name();
        $grid->caption()->limit(20);
        $grid->image()->lightbox(['zooming' => true]);
        $grid->created_at();

        return $content
            ->title($title = 'Lightbox')
            ->row($this->info('https://github.com/laravel-admin-extensions/grid-lightbox', $title))
            ->row($grid);
    }

    public function gallery(Content $content)
    {
        $grid = new Grid(new Image());
        $grid->id('ID');
        $grid->author()->name();
        $grid->caption()->limit(20);
        $grid->image()->gallery(['zooming' => true]);
        $grid->created_at();

        return $content
            ->title($title = 'Lightbox')
            ->row($this->info('https://github.com/laravel-admin-extensions/grid-lightbox', $title))
            ->row($grid);
    }

    protected function info($url, $title)
    {
        $content = "<a href=\"{$url}\" target='_blank'>{$url}</a>";

        return new Callout($content, $title, 'info');
    }
}