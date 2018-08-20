# 数据模型详情

> v1.5.16版本及以上支持

`Encore\Admin\Show`用来显示数据详情，先来个例子，数据库中有`posts`表：

```sql
CREATE TABLE `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int(10) unsigned NOT NULL ,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rate` int(255) COLLATE utf8_unicode_ci NOT NULL,
  `release_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```

对应的数据模型为`App\Models\Post`，下面的代码可以显示`posts`表的数据详情：

```php
<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class PostController extends Controller
{
    public function show($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('Post');
            $content->description('详情');

            $content->body(Admin::show(Post::findOrFail($id), function (Show $show) {
                
                $show->id('ID');
                $show->title('标题');
                $show->content('内容');
                $show->rate();
                $show->created_at();
                $show->updated_at();
                $show->release_at();
                
            }));
        });
    }
}
```

如果要直接显示所有的字段，可以用下面的简单方式：
```php
$content->body(Admin::show(Post::findOrFail($id)));
```

如果要直接显示指定的字段：
```php
$content->body(Admin::show(Post::findOrFail($id), ['id', 'title', 'content']));
```

或者指定每一个字段的label:
```php
$content->body(Admin::show(Post::findOrFail($id), [
    'id'        => 'ID',
    'title'     => '标题',
    'content'   => '内容'
]));
```

## 基本使用方法

### 修改面板的样式和标题
```php
$show->panel()
    ->style('danger')
    ->title('post基本信息...');
```
`style`的取值可以是`primary`、`info`、`danger`、`warning`、`default`

### 面板工具设置

面板右上角默认有三个按钮`编辑`、`删除`、`列表`，可以分别用下面的方式关掉它们：
```php
$show->panel()
    ->tools(function ($tools) {
        $tools->disableEdit();
        $tools->disableList();
        $tools->disableDelete();
    });;
```

### 分隔线

如果要在字段之间添加一条分隔线：
```php
$show->divider();
```

### 修改显示内容

用下面的方法修改显示内容
```php
$show->title()->as(function ($title) {
    return "<{$title}>";
});

$show->contents()->as(function ($content) {
    return "<pre>{$content}</pre>";
});
```

下面是通过`as`方法内置实现的几个常用的显示样式.

##### image

字段`avatar`的内容是图片的路径或者url，可以将它显示为图片：

```php
$show->avatar()->image();
```
`image()`方法的参数参考[Field::image()](https://github.com/z-song/laravel-admin/blob/master/src/Show/Field.php#L193)

##### file

字段`document`的内容是文件的路径或者url，可以将它显示为文件：

```php
$show->avatar()->file();
```
`file()`方法的参数参考[Field::file()](https://github.com/z-song/laravel-admin/blob/master/src/Show/Field.php#L216)


##### link

字段`homepage`的内容是url链接，可以将它显示为HTML链接：
```php
$show->homepage()->link();
```
`link()`方法的参数参考[Field::link()](https://github.com/z-song/laravel-admin/blob/master/src/Show/Field.php#L266)

##### label

将字段`tag`的内容显示为label：
```php
$show->tag()->label();
```
`label()`方法的参数参考[Field::label()](https://github.com/z-song/laravel-admin/blob/master/src/Show/Field.php#L282)

##### badge

将字段`rate`的内容显示为badge：
```php
$show->rate()->badge();
```
`badge()`方法的参数参考[Field::badge()](https://github.com/z-song/laravel-admin/blob/master/src/Show/Field.php#L302)

#### using

如果字段`gender`的取值为`f`、`m`，分别需要用`女`、`男`来显示

```php
$show->gender()->using(['f' => '女', 'm' => '男']);
```

## 关联关系显示

### 一对一关系

`users`表和上面的`posts`表为一对一关联关系，通过`posts.author_id`字段关联，`users`表结构如下：

```sql
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
```

模型定义为：
```php
class User extends Model
{
}

class Post extends Model
{
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
```

那么可以用下面的方式显示`post`所属的用户的详细：
```php
$show->author('作者信息', function ($author) {

    $author->setResource('/admin/users');

    $author->id();
    $author->name();
    $author->email();
});
```
其中`$author`对象也是`Show`实例，同样可以使用上面的各种方法

> 注意：为了能够正常使用这个面板右上角的工具，必须用`setResource()`方法设置用户资源的url访问路径

### 一对多或多对多关系

一对多或多对多关系的关联数据会以`Model-grid`的方式呈现，下面是简单的例子

`posts`表和评论表`comments`为一对多关系(一条`post`有多条`comments`)，通过`comments.post_id`字段关联

```sql
CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(10) unsigned NOT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
```

模型定义为：
```php
class Post extends Model
{
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}

class Comment extends Model
{
}

```

那么评论的显示通过下面的代码实现：

```php
$show->comments('评论', function ($comments) {

    $comments->resource('/admin/comments');

    $comments->id();
    $comments->content()->limit(10);
    $comments->created_at();
    $comments->updated_at();

    $comments->filter(function ($filter) {
        $filter->like('content');
    });
});

```

`$comments`是一个`Encore\Admin\Grid`实例，详细的使用方法可以参考[model-grid](/zh/model-grid.md)

> 注意：为了能够正常使用这个数据表格的功能，必须用`resource()`方法设置`comments`资源的url访问路径