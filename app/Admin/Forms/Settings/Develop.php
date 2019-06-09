<?php

namespace App\Admin\Forms\Settings;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;

class Develop extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '开发';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        //dump($request->all());

        admin_success('Processed successfully.');

        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->radio('dev_mode', '开发模式')->options([0 => '关闭', 1 => '开启'])->stacked();
        $this->radio('show_trace', '显示页面Trace')->options([0 => '否', 1 => '是'])->stacked();
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return [
            'dev_mode'   => 1,
            'show_trace' => 1,
        ];
    }
}
