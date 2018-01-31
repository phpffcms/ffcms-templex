<?php

/** @var \Ffcms\Templex\Template $tpl */
/** @var \Ffcms\Templex\Engine\Renderer $this */

?>

<?php $tpl->section('javascript', \Ffcms\Templex\Template::SECTION_APPEND) ?>
<script>
    $(document).ready(function(){
        console.log('extend 2');
    });
</script>
<?php $tpl->stop() ?>
