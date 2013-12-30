<select class="form-control social_select" id="rss_feeds_drop_down">
    <option value="-1">请选择一个Rss</option>
    <?php
    $hiddenString = ''; 
    foreach ($data as $key => $val) 
    {
        echo  '<option value="'.$val['id'].'">'.$val['name'].'</option>';
        $hiddenString .= '<input type="hidden" class="rss_master_id_'.$val['id'].'" value="'.$val['rss_master_id'].'">';
    }
    ?>
</select>
<?=$hiddenString?>