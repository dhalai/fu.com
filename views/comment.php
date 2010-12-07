<div class="commentsBlock">
<?if($comments):?>
<? foreach($comments as $comm):?>
    <div class="comment">
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
    <?=Comments::getByParentId($comm->id)?>
<?endforeach;?>
<? endif;?>
</div>
<form method="post" action="/comm/add">
    <div class="commArea"><textarea name="comm"></textarea></div>
    <input type="hidden" name="fileid" value="<?=$fileid?>"/>
    <input type="submit" value="Комментировать"/>
</form>

