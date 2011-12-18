<?
if( !empty($results) ){
    ?>
    <table class="bordered-table zebra-striped">
        <thead>
            <tr>
                <th width="60">#</th>
                <th><?=lang('msg_tbl_title')?></th>
                <th><?=lang('msg_tbl_description')?></th>
                <th width="60"><?=lang('msg_tbl_rooms')?></th>
                <th width="60"><?=lang('msg_tbl_stars')?></th>
            </tr>
        </thead>
        <?
        foreach( $results as $r ){
            ?>
            <tr>
                <td><?=$r['id']?></td>
                <td><a href="<?=site_url('show/'.$r['id'] )?>"><?=$r['title']?></a></td>
                <td><?=$r['description']?></td>
                <td><?=$r['rooms']?></td>
                <td><?=$r['stars']?></td>
            </tr>
            <?
        }
        ?>
    </table>
    <?
}