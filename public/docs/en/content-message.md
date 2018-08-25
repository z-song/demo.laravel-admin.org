Content messages
=================

## Notifications

Call the following method on the page, which will call the [toastr](https://github.com/CodeSeven/toastr) component and add a floating notification in the top right corner of the page.
```php
admin_toastr('Message...', 'success');

admin_toastr('Message...', 'info');

admin_toastr('Message...', 'warning');

admin_toastr('Message...', 'error');
```

You can also pass the third parameter and add the options to toastr. For more parameters, refer to [toastr](https://github.com/CodeSeven/toastr)
```php
admin_toastr('Message...', 'success', ['timeOut' => 5000]);
```


## Alerts

> since v1.5.19

![wx20180822-200500](https://user-images.githubusercontent.com/1479100/44462262-a9b60500-a646-11e8-84d1-ee22b35106bd.png)

Modified and optimized the the Alert message on the page in the version `v1.5.19`.

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

Add several other types of messages

```php
$content->withWarning('Title', 'messages..');

$content->withInfo('Title', 'messages..');

$content->withSuccess('Title', 'messages..');
```

You can also use the following functions, the effect is the same

```php
admin_success($title, $message);

admin_warning($title, $message);

admin_error($title, $message);

admin_info($title, $message);
```

