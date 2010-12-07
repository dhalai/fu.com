$('document').ready(function() {

$('#email').val("");
$('#pass').val("");

    $('#email').blur(function(){
        ref = $(this);
        val = ref.val();

        if(val) {
            if($('.validateReg').length){
                $('.validateReg').append('<div class="load"><img src="/design/img/ajax.gif" /></div>');
            } else {
                $('.validateReg').html('<div class="load"><img src="/design/img/ajax.gif" /></div>');
            }
            
            $.post('/ajax/checkEmail',{email:val},function(data){

                if(data == 1)
                {
                   ref.css('border','2px solid green');
                   $('.errorEmail').remove();
                   $('.load').remove();
                } else {
                    ref.css('border','2px solid red');
                    $('.load').remove();

                    if(!$('.errorEmail').length)
                    {
                       $('.validateReg').append(data);
                    } else {
                        $('.errorEmail').replaceWith(data);
                    }
                }

            });
        } else {

            ref.css('border','2px solid red');
            if($('.errorEmail').length)
            {
                 $('.errorEmail').replaceWith('<div class="errorEmail">Пожалуйста, введите e-mail</div>');
            } else {

                $('.validateReg').append('<div class="errorEmail">Пожалуйста, введите e-mail</div>');

            }
            
        }
    });


    $('#pass').blur(function(){
        ref = $(this);
        val = ref.val();

        if(val) {
            if(val.length >= 8)
            {
                   ref.css('border','2px solid green');
                   $('.errorPass').remove();
            } else {
                    ref.css('border','2px solid red');
                    if(!$('.errorPass').length)
                    {
                       $('.validateReg').append('<div class="errorPass">Пароль должен быть не менее 8 символов</div>');
                    } else {
                       $('.errorPass').replaceWith('<div class="errorPass">Пароль должен быть не менее 8 символов</div>');
                    }
            }

        } else {

            ref.css('border','2px solid red');
            if($('.errorPass').length)
            {
                 $('.errorPass').replaceWith('<div class="errorPass">Пожалуйста, введите пароль</div>');
            } else {

                $('.validateReg').append('<div class="errorPass">Пожалуйста, введите пароль</div>');

            }

        }
    });

    $('#regBut').click(function(){
       if((!$('.errorPass').length && !$('.errorEmail').length) && $('#email').val() && $('#pass').val())
       {
           $('.regForm').submit();
       } else {

         if(!$('#email').val().lenght)
         {
            if(!$('.errorEmail').length)
            {
                $('.validateReg').append('<div class="errorEmail">Пожалуйста, введите e-mail</div>');
            } else {
                $('.errorEmail').replaceWith('<div class="errorEmail">Пожалуйста, введите e-mail</div>');
            }
         }

         if(!$('#pass').val().lenght)
         {
            if(!$('.errorPass').length)
            {
                $('.validateReg').append('<div class="errorPass">Пожалуйста, введите пароль</div>');
            } else {
                $('.errorPass').replaceWith('<div class="errorPass">Пожалуйста, введите пароль</div>');
            }
         }

       }
    });

    $('#authBut').click(function(){
       if(!$('#useremail').val() || !$('#userpass').val())
       {

         if(!$('#useremail').val())
         {
            if(!$('.errorEmail').length)
            {
                $('.validateReg').append('<div class="errorEmail">Пожалуйста, введите e-mail</div>');
            } else {
                $('.errorEmail').replaceWith('<div class="errorEmail">Пожалуйста, введите e-mail</div>');
            }
         } else {
             $('.errorEmail').remove();
         }

         if(!$('#userpass').val())
         {
            if(!$('.errorPass').length)
            {
                $('.validateReg').append('<div class="errorPass">Пожалуйста, введите пароль</div>');
            } else {
                $('.errorPass').replaceWith('<div class="errorPass">Пожалуйста, введите пароль</div>');
            }
         } else {
             $('.errorPass').remove();
         }

       } else {
           $('.authForm').submit();
       }

    });


    $('#addComm').click(function(){

       $('#userFilesForm').attr('action','/file/addComm');
       $('#userFilesForm').submit();

    });

    $('#addComm').click(function(){

       $('#userFilesForm').attr('action','/file/addComm');
       $('#userFilesForm').submit();

    });

    $('#removeFiles').click(function(){

       $('#userFilesForm').attr('action','/file/removeFiles');
       $('#userFilesForm').submit();

    });

    $('.chceckIsComm').click(function(){
        ref = $(this);
        id = ref.parent().prev().find('input').val();

        if(ref.attr('checked'))
        {
          ref.next().attr('name','Set[]');

        } else {
           ref.next().attr('name','Unset[]');
        }
    });

    $('.response').toggle(function(){

       $(this).next().show();

    }, function(){

       $(this).next().hide();
    });
});