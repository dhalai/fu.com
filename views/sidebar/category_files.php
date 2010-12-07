<?if($types):?>
<div class="blockTitle">Категории файлов</div>
    <?foreach($types as $type):?>
        <div class="categoryFile"><a href="/file/category?type=<?=Validate::clear_path($type->type)?>"><?=$type->type?></a></div>
    <?endforeach;?>
<?else:?>
<div class="blockTitle">Нет ни одного файла</div>
<?endif;?>

