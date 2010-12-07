<?if($files):?>
    <div class="blockTitle">Последние добавленные файлы:</div>
    <?foreach ($files as $file):?>
       <? $mod= new Model_User();
           $user = $mod->getUserById($file->user_id);
       ?>
      <div class="lastfile"><a href="/file?id=<?=$file->id?>"><?=$file->name?></a> | <a href="/user?id=<?=$file->user_id?>"><?=$user->email?></a></div>
    <?endforeach;?>
      <div class="viewAll"><a href="/file/all">Смотреть все файлы</a></div>
<?else:?>
<div class="blockTitle">Никто из пользователей пока ничего не добавлял</div>
<?endif;?>