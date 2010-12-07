<?if($users):?>
    <div class="blockTitle">Последние пользователи:</div>
    <?foreach($users as $user):?>
        <div class="lastuser"><a href="/user?id=<?=$user->id?>"><?=$user->email?></a></div>
    <?endforeach;?>
<?else:?>
    <div class="blockTitle">В системе нет ни одного пользователя</div>
<?endif;?>