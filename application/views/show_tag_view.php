<div class="main_block">
    <div id="post" >
        <?php $page = $_GET['page'];?>

        <?php $last_news = $data['pages']['count_news'];?>
        <?php $news_in_page = $data['pages']['news_in_page'] ;?>
        <?php $start_news = ($page - 1) * $news_in_page;?>
        <?php if ($start_news == 0 ){
            $start_news = 0;}  ?>

        <?php for($i = $start_news, $n=0; $n != $news_in_page; $n++, $i++){?>
            <?php if ($i == $last_news) { break;} ?>
               <div class="news"><h1><?php echo $data[$i]['subj']; ?></h1><br>
            <h2><?php echo $data[$i]['info']; ?></h2><br>
            <h3> <?php for ($j = 0; $j < count($data[$i]['tag_name']); $j++){  ?>
            <?php echo "<a href='/main/show_tag/?tag=".$data[$i]['tag_name'][$j]['tag_id']."&page=0'>" ?>
                #<?php echo $data[$i]['tag_name'][$j]['tag_name'];}?></a></h3>
            <h4>Data created <?php echo $data[$i]['public_date'];} ?></h4>
               </div>
        <div class="pagin">
            <?php
            for ($i = 1; $i <= $data['pages']['count_page']; $i++)
            {
                if ($i == $data['pages']['start_page'])
                    echo "...";
                else
                    echo "<a href='/main/show_tag/?tag=".$data['tag_id']."&page=".$i."'>".$i."</a>";
            }
            ?>
        </div>
    </div>

</div>
