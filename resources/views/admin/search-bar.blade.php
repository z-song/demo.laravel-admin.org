<style>

.search-form {
    width: 250px;
    margin: 10px 0 0 20px;
    border-radius: 3px;
    float: left;
}
.search-form input[type="text"] {
    color: #666;
    border: 0;
}

.search-form .btn {
    color: #999;
    background-color: #fff;
    border: 0;
}

</style>

<form action="{{ route('posts.index') }}" method="get" class="search-form" pjax-container>
    <div class="input-group input-group-sm ">
        <input type="text" name="title" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
          </span>
    </div>
</form>