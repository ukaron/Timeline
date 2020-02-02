
<div class="main_block">
        <div id="post">
        <?php foreach ($data as $post) : ?>
            <div class="news"><h1><?php echo $post['subj']; ?></h1><br>
            <h2><?php echo $post['info']; ?></h2><br>
            <h3> <?php for ($i = 0; $i < count($post['tag_name']) ; $i++){ ?>
           <?php echo "<a href='/main/show_tag/?tag=".$post['tag_name'][$i]['tag_id']."&page=1'>" ?>
                #<?php echo $post['tag_name'][$i]['tag_name'];}?></a></h3>
            <h4>Data created <?php echo $post['public_date']; ?></h4></div>
            <?php endforeach;?>
        </div>
</div>
<script src="/js/show_news.js"></script>
