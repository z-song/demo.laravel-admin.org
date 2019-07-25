<?php

use App\Admin\Actions;
use App\Admin\Extensions\Column\OpenMap;
use App\Admin\Extensions\Column\FloatBar;
use App\Admin\Extensions\Column\UrlWrapper;
use App\Admin\Extensions\Nav;
use Encore\Admin\Form;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Grid\Column;

Form::forget(['map', 'editor']);

Form::extend('json', \Encore\JsEditor\Json::class);
Form::extend('jsonEditor', \Jxlwqq\JsonEditor\Editor::class);

Admin::css('/vendor/prism/prism.css');
Admin::js('/vendor/prism/prism.js');
Admin::js('/vendor/clipboard/dist/clipboard.min.js');

Column::extend('openMap', OpenMap::class);
Column::extend('floatBar', FloatBar::class);
Column::extend('urlWrapper', UrlWrapper::class);

Column::extend('prependIcon', function ($value, $icon) {
    return "<span style='color: #999;'><i class='fa fa-$icon'></i>  $value</span>";
});

Admin::navbar(function (\Encore\Admin\Widgets\Navbar $navbar) {
    $navbar->right(Nav\Link::make('Settings', 'forms/settings'));
    $navbar->right(Nav\Link::make('Register', 'forms/register', 'fa-user'));
    $navbar->right(new Nav\AutoRefresh())
        ->right(new Actions\ClearCache())
        ->right(new Actions\Feedback())
        ->right(new Actions\System());

    $navbar->left(view('admin.search-bar'));

    $navbar->left(Nav\Shortcut::make([
        'Posts' => 'posts/create',
        'Users' => 'users/create',
        'Images' => 'images/create',
        'Videos' => 'videos/create',
        'Articles' => 'articles/create',
        'Tags' => 'tags/create',
        'Categories' => 'categories/create',
    ], 'fa-plus')->title('Create'));

    $navbar->left(new Nav\Dropdown());
});


