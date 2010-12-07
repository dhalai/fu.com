<?if(!$user = Session::get_all()):?>
    <div class="enter"><a href="/enter">Войти</a> | <a href="/registrate">Регистрация</a></div>
<? else :?>
    <div class="user">
       <div><a href="/user?id=<?=$user['userid']?>"><?=$user['useremail']?></a></div>
       <div><a href="/useraction/logout">выйти</a></div>
    </div>
<? endif;?>