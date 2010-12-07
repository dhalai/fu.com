<div class="blockTitle"><?=$file->name?> | <a href="/user?id=<?=$user->id?>"><?=$user->email?></a></div>
    <div class="file">
        <a href="/upload/<?=$file->user_id.'/'.Validate::clear_path($file->type).'/'.$file->hash?>">Скачать</a>
    </div>
    <?if (Session::get('userid') == $file->user_id):?>
     <a href="/file/remove?id=<?=$file->id?>">Удалить</a>
    <?endif;?>
<div class="fileError">
    <?if(isset($status)) echo $status;?>
</div>
     <?if($file->is_comm):?>
        <? Comments::form($file->id);?>
     <?endif;?>

