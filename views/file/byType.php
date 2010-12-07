<div class="blockTitle"> Файлы типа <?=$type?> :</div>
<?if($files):?>
<?if(Session::get('userid') == $user->id):?>
    <form method="post" action="/file/removeFiles">
<table class="filesByType">
    <tr>
        <td>
            Id
        </td>
        <td>
            Имя файла
        </td>
        <td>
           Дата создания
        </td>
        <td>
           <?if(Session::get('userid') == $files[0]->user_id):?> &nbsp;<? else:?>Автор<?endif;?>
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
           <?=$file->date_created?>
        </td>
        <td>
          <input type="checkbox" name="files[]" value="<?=$file->id?>"/>
        </td>
    </tr>
    <?endforeach;?>
</table>

    <div class="delByType"><input type="submit" value="Удалить"/></div>
    </form>

<?else:?>
<?$userM = new Model_User();?>
<table class="filesByType">
    <tr>
        <td>
            Id
        </td>
        <td>
            Имя файла
        </td>
        <td>
           Дата создания
        </td>
        <td>
           Автор
         </td>
    </tr>
<?foreach ($files as $file):?>
    <?$fuser = $userM->getUserById($file->user_id)?>
    <tr class="file">
        <td>
            <?=$file->id?>
        </td>
        <td>
            <a href="/file?id=<?=$file->id?>" ><?=$file->name?></a>
        </td>
        <td>
           <?=$file->date_created?>
        </td>
        <td>
          <a href="user?id=<?=$user->id?>"><?=$fuser->email?></a>
        </td>
    </tr>
 <?endforeach;?>
</table>

<?endif;?>
<?=$paging?>

<?else:?>
    У Вас нет файлов данного типа.
<?endif;?>
<div class="fileError">
    <?if(isset($status)) echo $status;?>
</div>

