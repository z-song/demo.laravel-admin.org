页面消息
=================

## Notifications

在页面调用下面的方法，它将会调用[toastr](https://github.com/CodeSeven/toastr)组件，在页面的右上角添加一条浮动的提示

```php
admin_toastr('Message...', 'success');

admin_toastr('Message...', 'info');

admin_toastr('Message...', 'warning');

admin_toastr('Message...', 'error');
```

也可以接收第三个参数，给toastr添加设置参数,更多参数参考[toastr](https://github.com/CodeSeven/toastr)
```php
admin_toastr('Message...', 'success', ['timeOut' => 5000]);
```


## Alerts

> since v1.5.19

![wx20180822-200500](https://user-images.githubusercontent.com/1479100/44462262-a9b60500-a646-11e8-84d1-ee22b35106bd.png)

在版本`v1.5.19`中调整并优化了在在页面添加Alert消息，

```php

<?php

namespace App\Admin\Controllers;

use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->withError('Title', 'messages..');
    }
}
```

添加其它几种类型的消息

```php
$content->withWarning('Title', 'messages..');

$content->withInfo('Title', 'messages..');

$content->withSuccess('Title', 'messages..');
```

也可以用下面的几个方法, 效果是一样的

```php
admin_success($title, $message);

admin_warning($title, $message);

admin_error($title, $message);

admin_info($title, $message);
```

