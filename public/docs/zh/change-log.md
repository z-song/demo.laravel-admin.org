# Release Notes

## v1.5.19 (2018-08-22)

- 调整了生成控制器的代码结构，会根据表的字段生成对应的代码
- 调整了控制台命令，增加了三个命令, [参考](zh/commands.md)
- 增强了`admin:make`命令，将会根据表字段自动生成相应的代码
- 修复`v1.5.18`版本的bug

## v1.5.18 (2018-08-10)

- 重构了grid过滤器的样式，增加`scope`查询支持
- `Model-show`支持将字段显示为文件样式
- 修改在`Model-grid`中的`editable`空字段的显示样式
- 支持`Model-grid`中的二维数组字段显示为表格

## v1.5.16 (2018-08-3)

- 增加`Model-show`，支持显示数据详情

## v1.2.9、v1.3.3、v1.4.1

- 添加用户设置和修改头像功能
- model-form自定义工具[参考](zh/model-form.md?id=自定义工具)
- 内嵌表单支持[参考](zh/model-form-fields.md?id=embeds)
- 支持自定义导航条（右上角）[参考](https://github.com/z-song/laravel-admin/issues/392)
- 添加脚手架、数据库命令行工具、web artisan帮助工具[参考](zh/helpers.md)
- 支持自定义登陆页面和登陆逻辑[参考](zh/qa.md?id=自定义登陆页面和登陆逻辑)
- 表单支持设置宽度、设置action[参考](zh/model-form.md?id=其它方法)
- 优化表格过滤器
- 修复bug，优化代码和逻辑