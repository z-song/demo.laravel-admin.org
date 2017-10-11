<div class="box">

    <div class="box-body" style="display: block;">

        <form method="get" pjax-container action="/admin/redis">
            <div class="form-group">

                <div class="input-group">

                    <select class="form-control" name="c" id="connection" style="width: 100px;">
                        <option value="default">default</option>
                        <option value="users">users</option>
                        <option value="posts">posts</option>
                        <option value="books">books</option>
                    </select>

                    &nbsp;&nbsp;&nbsp;

                    <span class="input-group-btn" style="width: 300px;">
                        <input type="text" class="form-control" name="p" id="keys" placeholder="Keys" value="{{ request('p', '*') }}"/>
                    </span>

                    <span class="input-group-btn" style="width: 30px;">
                        <button type="submit" class="form-control btn btn-twitter"><span class="fa fa-search"></span></button>
                    </span>

                    &nbsp;&nbsp;&nbsp;

                    <span class="input-group-btn" style="width: 30px;">
                        <a class="form-control btn btn-success btn-sm" href="/admin/redis/create"><span class="fa fa-save"></span> new</a>
                    </span>
                </div>
            </div>

        </form>

    </div>
</div>

{!! $grid !!}