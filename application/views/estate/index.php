<?php
?>
<fieldset id="search">
    <h3>Поиск</h3>
    <br class="cb" />
    <form id="search_form">
        <div class="well">
            <div class="clearfix">
                <div class="row show-grid">
                    <div class="span5"><?=form_dropdown( 'type', $types, 0, ' id="select_type" class="span4"' )?></div>
                    <div class="span5"><?=form_dropdown( 'country', $countries, 0, ' id="select_country" class="span4"' )?></div>
                    <div class="span4"><?=form_dropdown( 'city', array( 0=>lang('select_all') ), 0, ' id="select_city" class="span4"' )?></div>
                </div>
            </div>
            <div class="row">
                <div class="span5">
                    <label for="select_rooms"><?=lang('form_select_rooms')?> </label><?=form_dropdown( 'rooms', $rooms, 0, ' id="select_rooms" class="span2"' )?><br/>
                    <label for="select_stars"><?=lang('form_select_stars')?> </label><?=form_dropdown( 'stars', $stars, 0, ' id="select_stars" class="span2"' )?>
                </div>
                <div class="span10">
                    <div class="row">
                        <div class="span5">
                            <div class="clearfix">
                                <ul class="inputs-list">
                                    <li>
                                        <label for="checkbox_bar">
                                            <?=form_checkbox( 'bar', 1, FALSE, ' id="checkbox_bar"')?>
                                            <span><?=lang('form_checkbox_bar')?></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label for="checkbox_pool">
                                            <?=form_checkbox( 'pool', 1, FALSE, ' id="checkbox_pool"')?>
                                            <span><?=lang('form_checkbox_pool')?></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label for="checkbox_bath">
                                            <?=form_checkbox( 'bath', 1, FALSE, ' id="checkbox_bath"')?>
                                            <span><?=lang('form_checkbox_bath')?></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label for="checkbox_shower">
                                            <?=form_checkbox( 'shower', 1, FALSE, ' id="checkbox_shower"')?>
                                            <?=lang('form_checkbox_shower')?>
                                        </label>
                                    </li>
                                </ul>
                            </div>                           
                        </div>
                        <div class="span4">
                            <div class="clearfix">
                                <ul class="inputs-list">
                                    <li>
                                        <label for="checkbox_cctv">
                                            <?=form_checkbox( 'cctv', 1, FALSE, ' id="checkbox_cctv"')?>
                                            <span><?=lang('form_checkbox_cctv')?></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label for="checkbox_internet">
                                            <?=form_checkbox( 'internet', 1, FALSE, ' id="checkbox_internet"')?>
                                            <span><?=lang('form_checkbox_internet')?></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label for="checkbox_tv">
                                            <?=form_checkbox( 'tv', 1, FALSE, ' id="checkbox_tv"')?>
                                            <span><?=lang('form_checkbox_tv')?></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label for="checkbox_parking">
                                            <?=form_checkbox( 'parking', 1, FALSE, ' id="checkbox_parking"')?>
                                            <?=lang('form_checkbox_parking')?>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="text-align:center"><input type="submit" value="<?=lang('form_btn_search')?>" class="btn large primary" /></div>            
        </div> <!-- / well -->
    </form>
</fieldset>

<div id="search_results"></div>
<div id="waypoint" class="well">Load more...</div>