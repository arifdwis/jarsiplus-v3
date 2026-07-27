<!-- chat footer -->
<div class="chatFooter">
    {!! Form::open(['route' => ["$prefix.pembahasan.store", [$parent->uuid, $data->uuid]], 'autocomplete' => 'off', 'id' => 'form-chat']) !!}
    {!! Form::hidden('id_histori', $data->histori ? $data->histori->id : null) !!}
    <a href="javascript:;" class="btn btn-icon btn-secondary" data-toggle="modal" data-target="#addActionSheet">
        <ion-icon name="add"></ion-icon>
    </a>
    <div class="form-group boxed">
        <div class="input-wrapper">
            <input type="text" name="komentar" id="input-chat" class="form-control" placeholder="Type a message...">
            <i class="clear-input">
                <ion-icon name="close-circle"></ion-icon>
            </i>
        </div>
    </div>
    <button type="submit" class="btn btn-icon btn-primary">
        <ion-icon name="send"></ion-icon>
    </button>

    {!! Form::close() !!}
</div>
<!-- * chat footer -->