<?if($files):?>
<div class="blockTitle">Последние загруженные мной файлы:</div>
    <?foreach($files as $file):?>
        <div class="lastfile">
            <a href="/file?id=<?=$file->id?>"><?=$file->name?></a>
        </div>
    <?endforeach;?>
<?endif;?>