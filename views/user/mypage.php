<div class="mypage">
    <?if($types):?>
    <div class="blockTitle">У Вас есть файлы следующих типов:</div>
        <?foreach($types as $type):?>
        <div class="categoryFile"><a href="/file/category?type=<?=Validate::clear_path($type->type)?>&id=<?=$userid?>"><?=$type->type?></a></div>
        <?endforeach;?>
    <?else:?>
    <div class="blockTitle">У Вас нет ни одного файла. </div>
    <a href="/file/upload">Загрузить?</a>
    <?endif;?>
</div>