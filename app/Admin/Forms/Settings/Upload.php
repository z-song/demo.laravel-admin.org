<?php

namespace App\Admin\Forms\Settings;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;

class Upload extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '上传';

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
        $this->number('file_size', '文件上传大小限制')->help('0为不限制大小，单位：kb')->rules('required');
        $this->tags('file_ext', '允许上传的文件后缀')->help('多个后缀用逗号隔开，不填写则不限制类型')->rules('required');
        $this->number('image_size', '图片上传大小限制')->help('0为不限制大小，单位：kb')->rules('required');
        $this->tags('image_ext', '允许上传的图片后缀')->help('多个后缀用逗号隔开，不填写则不限制类型')->rules('required');
        $this->number('thumbnail_size', '缩略图尺寸');
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return [
            'file_size'       => 100,
            'file_ext'      => ['doc', 'docx', 'xls', 'ppt', 'pptx', 'pdf', 'wps', 'txt', 'rar', 'zip', 'gz', 'bz2', '7z'],
            'image_size'       => 100,
            'image_ext'      => ['gif', 'bmp', 'jpeg', 'png'],
        ];
    }
}
