# Model-show

> Since v1.5.16

`Encore\Admin\Show` is used to show the details of the data. Let's take an example. There is a `posts` table in the database:

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

The corresponding data model is `App\Models\Post`, and the following code can show the data details of the `posts` table:

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
            $content->description('Detail');

            $content->body(Admin::show(Post::findOrFail($id), function (Show $show) {
                
                $show->id('ID');
                $show->title('Title');
                $show->content();
                $show->rate();
                $show->created_at();
                $show->updated_at();
                $show->release_at();
                
            }));
        });
    }
}
```

If you want to show all the fields directly, you can use the following simple method:
```php
$content->body(Admin::show(Post::findOrFail($id)));
```

If you want to show the specified field directly:
```php
$content->body(Admin::show(Post::findOrFail($id), ['id', 'title', 'content']));
```

Or specify the label for each field:
```php
$content->body(Admin::show(Post::findOrFail($id), [
    'id'        => 'ID',
    'title'     => 'Title',
    'content'   => 'Contents'
]));
```

## Basic usage

### Modify the style and title of the panel
```php
$show->panel()
    ->style('danger')
    ->title('post detail...');
```
The value of `style` could be `primary`, `info`, `danger`, `warning`, `default`

### Panel tool settings

There are three buttons `Edit`, `Delete`, `List` in the upper right corner of the panel. You can turn them off in the following ways:
```php
$show->panel()
    ->tools(function ($tools) {
        $tools->disableEdit();
        $tools->disableList();
        $tools->disableDelete();
    });;
```

### Insert a divider

If you want to add a divider between the fields:
```php
$show->divider();
```

### Modify the display

Modify the display content as follows
```php
$show->title()->as(function ($title) {
    return "<{$title}>";
});

$show->contents()->as(function ($content) {
    return "<pre>{$content}</pre>";
});
```

Here are a few common display style methods implemented by the `as` method:

##### image

The content of the field `avatar` is the path or url of the image, which can be displayed as an image:

```php
$show->avatar()->image();
```
The parameters of the `image()` method are referenced to [Field::image()](https://github.com/z-song/laravel-admin/blob/master/src/Show/Field.php#L193)

##### file

The content of the field `document` is the path or url of the file, which can be displayed as an file:

```php
$show->avatar()->file();
```
The parameters of the `file()` method are referenced to [Field::file()](https://github.com/z-song/laravel-admin/blob/master/src/Show/Field.php#L216)

##### link

The content of the field `homepage` is a url link that can be displayed as an HTML link:
```php
$show->homepage()->link();
```
The parameters of the `link()` method are referenced to [Field::link()](https://github.com/z-song/laravel-admin/blob/master/src/Show/Field.php#L266)

##### label

Show the contents of the field `tag` as label:
```php
$show->tag()->label();
```
The parameters of the `label()` method are referenced to [Field::label()](https://github.com/z-song/laravel-admin/blob/master/src/Show/Field.php#L282)

##### badge

Show the contents of the field `rate` as badge:
```php
$show->rate()->badge();
```
The parameters of the `badge()` method are referenced to [Field::badge()](https://github.com/z-song/laravel-admin/blob/master/src/Show/Field.php#L302)

#### using

If the value of the field `gender` is `f`, `m`, it needs to be displayed with `Female` and `Male` respectively.

```php
$show->gender()->using(['f' => 'Female', 'm' => 'Male']);
```

## Show relationships

### One-to-one relationship

The `users` table and the above `posts` table are one-to-one associations, which are associated by the `posts.author_id` field. The `users` table structure is as follows:

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

The model is defined as:
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

Then you can show the details of the user to which `post` belongs in the following way:
```php
$show->author('Author information', function ($author) {

    $author->setResource('/admin/users');

    $author->id();
    $author->name();
    $author->email();
});
```
The `$author` object is also a `Show` instance. You can also use the various methods above.

> Note: In order to be able to use the tool in the upper right corner of this panel, you must set the url access path of the user resource with the `setResource()` method.

### One-to-many or many-to-many relationship

The associated data for a one-to-many or many-to-many relationship will be presented as `Model-grid`. Below is a simple example.

The `posts` table and the comment table `comments` are one-to-many relationships (a `post` has multiple `comments`), associated with the `comments.post_id` field.

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

The model is defined as:
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

Then the display of the comment is implemented by the following code:

```php
$show->comments('Comments', function ($comments) {

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

`$comments` is an instance of `Encore\Admin\Grid`. For detailed usage, please refer to [model-grid](/zh/model-grid.md)

> Note: In order to be able to use this data table function normally, you must use the `resource()` method to set the url access path of the `comments` resource.