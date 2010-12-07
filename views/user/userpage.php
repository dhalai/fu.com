<?if($files):?>
<div class="blockTitle">Файлы пользователя <?=$user->email?>:</div>
<table class="filesByType">
    <tr>
        <td>
            Id
        </td>
        <td>
            Имя файла
        </td>
        <td>
            Тип файла
        </td>
        <td>
           Дата создания
        </td>
    </tr>
<?foreach ($files as $file):?>
    <tr class="file">
        <td>
            <?=$file->id?>
        </td>
        <td>
            <a href="/file?id=<?=$file->id?>" ><?=$file->name?></a>
        </td>
        <td>
            <?=$file->type?>
        </td>
        <td>
           <?=$file->date_created?>
        </td>
    </tr>
    <?endforeach;?>
</table>

<?=$paging?>

<?else:?>
<div class="blockTitle">К сожалению, у пользователя <?=$user->email?> пока нет файлов</div>
<?endif;?>