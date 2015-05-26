<?php
	echo '<!DOCTYPE html><html>';
	echo '<head>';
	echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
	echo '<title>Booster Roll</title>';
	echo '<link rel="stylesheet" href="'.THEMES.'style.css">';
	echo '<script type="text/javascript" src="'.BASEDIR.'include/js/jquery.min.js"></script>';
	echo '<script type="text/javascript" src="'.BASEDIR.'include/js/jquery.textchange.min.js"></script>';
	echo '<script type="text/javascript" src="'.BASEDIR.'include/js/site.js"></script>';
	echo '<script type="text/javascript" src="'.BASEDIR.'include/js/tinymce/tinymce.min.js"></script>';
?>
<script>
tinymce.init({
    selector: "textarea#txt",
    theme: "modern",
    language : 'ru',
    width: 550,
    height: 200,
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
   ],
   content_css: "css/content.css",
   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons", 
   style_formats: [
        {title: 'Bold text', inline: 'b'},
        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
        {title: 'Example 1', inline: 'span', classes: 'example1'},
        {title: 'Example 2', inline: 'span', classes: 'example2'},
        {title: 'Table styles'},
        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
    ]
 }); 
</script>
<?php
	echo '</head><body>';

	define("ADMIN_PANEL", true);

	if (isset($_SESSION['gmlevel']) && $_SESSION['gmlevel'] < 3 && isset($_SESSION['user']) && isset($_SESSION['id']) && isset($_SESSION['p']))
		Redirect(BASEDIR.'index.php', true);

	require_once 'theme.php';
?>