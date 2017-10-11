<?php

namespace App\Admin\Extensions;

use Encore\Admin\Form\Field;

class Icon extends Field
{
    protected $view = 'admin.icon';

    protected static $css = [
        '/packages/fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css',
    ];

    protected static $js = [
        '/packages/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.min.js',
    ];

    public function render()
    {
        $this->script = <<<EOT

$('#{$this->id}').iconpicker();

EOT;
        return parent::render();
    }
}