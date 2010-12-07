<div class="upload">
    <form method="post" enctype="multipart/form-data">
        <div><input type="file" id="file" name="file"/></div>
        <div><input type="checkbox" id="iscomm" name="comm"/> <label for="iscomm">Разрешить комментирование?</label></div>
        <div><input type="submit" id="subUpload" value="загрузить"/></div>
    </form>
</div>
<div class="uploadError">
    <?if(isset($status)) echo $status;?>
</div>