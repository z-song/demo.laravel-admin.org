<?php

namespace App\Admin\Extensions\Column;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Displayers\AbstractDisplayer;

class Qrcode extends AbstractDisplayer
{
    protected function script()
    {
        return <<<EOT

$('.grid-action-qrcode').popover({
    title: "Scan code to visit",
    html: true,
    trigger: 'focus'
});

EOT;

    }

    public function display()
    {
        Admin::script($this->script());

        $img = "<img src='https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={$this->value}' style='height: 150px;width: 150px;'/>";

        return "<a class='grid-action-qrcode btn btn-xs btn-info' data-content=\"$img\" data-toggle='popover' tabindex='0'><i class='fa fa-qrcode'></i></a>&nbsp;{$this->value}";
    }
}
