<?
if( !empty($results) ){
    ?>
    <table class="bordered-table zebra-striped" style="width:100%">
        <? if( $page == 1 ){ ?>
        <thead>
            <tr>
                <th>#</th>
                <th><?=lang('msg_tbl_title')?></th>
                <th><?=lang('msg_tbl_description')?></th>
                <th><?=lang('msg_tbl_rooms')?></th>
                <th><?=lang('msg_tbl_stars')?></th>
            </tr>
        </thead>
        <? } ?>
        <?
        foreach( $results as $r ){
            ?>
            <tr>
                <td width="60"><?=$r['id']?></td>
                <td width="200"><a href="<?=site_url('show/'.$r['id'] )?>" target="_blank"><?=$r['title']?></a></td>
                <td><?=$r['description']?></td>
                <td width="60"><?=$r['rooms']?></td>
                <td width="60"><?=$r['stars']?></td>
            </tr>
            <?
        }
        ?>
    </table>
    <?
}