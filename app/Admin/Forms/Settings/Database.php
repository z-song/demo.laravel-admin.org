<?php

namespace App\Admin\Forms\Settings;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;

class Database extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '数据库';

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
        $this->text('path', '备份根路径')->rules('required')->help('路径必须以 / 结尾');
        $this->text('backup_size', '备份卷大小')->rules('required')->help('该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M');
        $this->radio('zip', '备份是否压缩')->options([1 => '是', 0 => '否'])->help('压缩备份文件需要PHP环境支持 gzopen, gzwrite函数');
        $this->radio('zip_level', '备份压缩级别')->options([1 => '最低', 2 => '一般', 3 => '最高'])->help('数据库备份文件的压缩级别，该配置在开启压缩时生效');
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return [
            'path'        => '../data/',
            'backup_size' => '20971520',
            'zip'         => 1,
            'zip_level'   => 2,
        ];
    }
}
