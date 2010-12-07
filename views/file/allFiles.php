
<?if($files):?>
<div class="blockTitle">Все файлы:</div>
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
        <td>
          Автор
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
        <td>
           <?
              $userM = new Model_User();
              $user = $userM->getUserById($file->user_id);
           ?>
           <a href="/user?id=<?=$user->id?>"><?=$user->email?></a>
        </td>
    </tr>
<?endforeach;?>
</table>
<?=$paging?>

<?else:?>
    <div class="blockTitle">Нет ни одного файла</div>
<?endif;?>

