<div class="box">
    <div class="box-header">

        <h3 class="box-title"></h3>

        <span style="position: absolute;left: 10px;top: 5px;">
            {!! $grid->renderHeaderTools() !!}
        </span>

        <div class="box-tools">
            {!! $grid->renderFilter() !!}
            {!! $grid->renderExportButton() !!}
            {!! $grid->renderCreateButton() !!}
        </div>

    </div>
    <!-- /.box-header -->
    <div class="box-footer">
        <ul class="mailbox-attachments clearfix">
            @foreach($grid->rows() as $row)
                <li>
                    <span class="mailbox-attachment-icon has-img">
                        {!! $row->column('image') !!}
                    </span>
                    <div class="mailbox-attachment-info">
                        <a href="#" class="mailbox-attachment-name">
                            {!! $row->column('caption') !!}
                        </a>
                        <br />
                        {!! $row->column('author.name') !!}
                        <br />
                        <span class="mailbox-attachment-size">
                              {!! $row->column('__row_selector__') !!}
                            <span class="pull-right">
                                {!! $row->column('__actions__') !!}
                            </span>
                        </span>
                    </div>
                </li>
            @endforeach
        </ul>

    </div>
    <div class="box-footer clearfix">
        {!! $grid->paginator() !!}
    </div>
    <!-- /.box-body -->
</div>