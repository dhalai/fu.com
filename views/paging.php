<? if($count_page>1):?>
<div class="paging">
    <?for($i=1; $i<=$count_page;$i++):?>
    <?if(preg_match('/page/',$_SERVER['REQUEST_URI'])):?>
        <?$url = preg_replace('/page=[0-9]*/','page='.$i,$_SERVER['REQUEST_URI']);?>
    <?elseif(!preg_match('/\?/',$_SERVER['REQUEST_URI'])):?>
        <?$url = $_SERVER['REQUEST_URI'].'?page='.$i;?>
    <?else:?>
        <?$url = $_SERVER['REQUEST_URI'].'&page='.$i;?>
    <?endif;?>
        <a <?if ($i == $page):?>class="activlink"<?endif?> href="<?=$url?>"><?=$i?></a>
    <?endfor;?>
</div>
<?endif;?>
