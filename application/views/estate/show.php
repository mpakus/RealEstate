<h3><?=$object['title']?></h3>
<p>
    <em>
        <?=$object['rooms']?> <?= _plural($object['rooms'], lang('rooms'), lang('room'), lang('two_room'))?>, 
        <?=$object['stars']?> <?= _plural($object['stars'], lang('stars'), lang('star'), lang('two_stars'))?>
    </em>
</p>
<blockquote>
    <p><?=nl2br($object['description'])?></p>
    <small><?=$object['country']['country']?>, <?=$object['city']['city']?></small>
</blockquote>

<?
if( !empty($object['photos']) ){
    ?><div class="well" style="text-align:center;"><?
    foreach( $object['photos'] as $p ){
        ?>
        <a href="/photos/<?=$p['photo']?>" target="_blank" rel="group" class="fancybox"><img src="/photos/<?=$p['preview']?>" alt="<?=$object['title']?>" /></a>
        <?
    }
    ?></div><?
}
?>

<div class="row">
    
    <div class="span12">
        <h5>
        <?
        $types = array();
        if( !empty($object['bar']) )    $types[] = lang('bar');
        if( !empty($object['pool']) )   $types[] = lang('pool');
        if( !empty($object['bath']) )   $types[] = lang('bath');
        if( !empty($object['shower']) ) $types[] = lang('shower');
        
        
        if( !empty($object['cctv']) )     $types[] = lang('cctv');
        if( !empty($object['internet']) ) $types[] = lang('internet');
        if( !empty($object['tv']) )       $types[] = lang('tv');
        if( !empty($object['parking']) )  $types[] = lang('parking');
        
        echo implode( ', ', $types );
        ?>
        </h5>
    </div>
</div>