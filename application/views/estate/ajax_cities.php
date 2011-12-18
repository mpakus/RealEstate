<?php
if( empty($cities) ) return;

foreach( $cities as $c ){
    ?>
    <option value="<?=$c['id']?>"><?=$c['city']?></option>
    <?
}