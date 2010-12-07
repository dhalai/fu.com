 <div class="comment" style="padding-left:<?=$padding*20?>px">
        <div><?=$comm->date_created?> | <?if($comm->user_id):?><a href="/user?<?=$comm->user_id?>"><?=$comm->user_email?></a><? else:?>Гость<?endif;?></div>
        <div><?=$comm->comm?></div>
        <div>
            <span class="response">ответить</span>
            <div class="responseForm">
                <form method="post" action="/comm/add?parent=<?=$comm->id?>">
                <div class="commArea"><textarea name="comm"></textarea></div>
                <input type="hidden" name="fileid" value="<?=$fileid?>"/>
                <input type="submit" value="Комментировать"/>
                </form>
            </div>
        </div>
    </div>
