<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?if(isset($title)):?>
        <title><?=$title?></title>
    <?endif;?>
    <?if(isset($metas)):?>
        <? foreach($metas as $meta) echo $meta?>
    <?endif;?>
    <?if(isset($styles)):?>
        <? foreach($styles as $style) echo $style?>
    <?endif;?>
    <?if(isset($scripts)):?>
        <? foreach($scripts as $script) echo $script?>
    <?endif;?>

   <link rel="stylesheet" href="/design/css/style.css" type="text/css" media="all" />
   <script type='text/javascript' src='/design/js/jQuery.js'></script>
   <script type='text/javascript' src='/design/js/scripts.js'></script>

</head>
<body>

<div id="wrapper">

	<div id="header">
            <div class="logo"><a class="logolink" href="/"><img src="/design/img/logo.png" /><a></div>
            <?=View::instance('user/userbar')?>
	</div>

	<div id="middle">

		<div id="container">

			<div id="content">
                             <?if(isset($content)) echo $content;?>
			</div>
		</div>

		<div class="sidebar" id="sideLeft">
                    <?if(isset($leftbar)) echo $leftbar;?>
		</div>

		<div class="sidebar" id="sideRight">
                    <div class="sideRight">
                        <?if(isset($rightbar)) echo $rightbar;?>
                    </div>
                </div>

	</div>

</div>

<div id="footer">
	<?if(isset($footer)) echo $footer;?>
</div>

</body>




</html>
