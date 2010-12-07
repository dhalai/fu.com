<?if($files):?>
<div class="blockTitle"><?if(Session::get('userid') == $files[0]->user_id):?> Мои файлы :<?else:?><?=$useremail?><?endif;?></div>
<?if(Session::get('userid') == $files[0]->user_id):?>
    <form method="post" action="/file/removeFiles" id="userFilesForm">
<?endif;?>
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
        <?if(Session::get('userid') == $files[0]->user_id):?>
        <td>
            Удалить?
        </td>
        <td>
           Комментировать?
        </td>
        <?endif;?>
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
        <?if(Session::get('userid') == $file->user_id):?>
        <td class="align-center">
              <input type="checkbox" name="files[]" value="<?=$file->id?>"/>
        </td>
        <td class="align-center">
              <input type="checkbox" name="filesComm[]" class="chceckIsComm" <?if($file->is_comm):?>checked<?endif;?> value="<?=$file->id?>"/>
              <input type="hidden" value="<?=$file->id?>"/>
        </td>
        <?endif;?>
    </tr>
    <?endforeach;?>
</table>

<?if(Session::get('userid') == $file->user_id):?>
    <div class="delByType"><input type="button" id="removeFiles" value="Удалить"/> <input type="button" value="Изменить комментирование" id="addComm"/></div>
    </form>
<?endif;?>

<?=$paging?>

<?else:?>
    <div class="blockTitle">У Вас нет ни одного файла. </div>
    <a href="/file/upload">Загрузить?</a>
<?endif;?>
<div class="fileError">
    <?if(isset($status)) echo $status;?>
</div>

