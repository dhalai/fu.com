<div class="regTitle">Авторизация</div>
<form method="post" action="/useraction/auth" class="authForm">
    <div class="formIn">
        <div><label for="useremail">e-mail</label></div>
        <input type="text" id="useremail" name="email"/>
    </div>
    <div class="formIn">
        <div><label for="userpass">пароль</label></div>
        <input type="password" id="userpass" name="pass"/>
    </div>
    <div class="formIn">
        <input type="checkbox" id="memory" name="memory"/>
        <label for="memory">запомнить</label>
    </div>
    <div class="formSub">
        <input type="button" id="authBut" value="войти"/>
    </div>
</form>
<div class="validateReg">

</div>