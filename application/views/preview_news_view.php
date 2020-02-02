</div>
<div class="form">
    <h1>My post #<?php echo $data['news_id']; ?></h1>
    <div class="main_block">
        <div id="post" >
            <h1><?php echo $data['subj']; ?></h1><br>
            <form action="/moder/edit_subj" method="POST" name="sign_in">
                <input type="hidden" name="news_id" value="<?php echo $data['news_id']; ?>">
                <table>
                    <tr>
                        <th> <input type="text" class="form-control" name="new_subj" id="info"
                                    placeholder="Edit subject"></th>
                    </tr>
                    <tr>
                        <th>  <input id="bottom" type="submit" name="submit" value="OK"></th>
                    </tr>
                </table>
            </form>
            <h2><?php echo $data['info']; ?><br>
                <form action="/moder/edit_info" method="POST" name="sign_in">
                    <input type="hidden" name="news_id" value="<?php echo $data['news_id']; ?>">
                    <table>
                        <tr>
                            <th> <input type="text" class="form-control" name="new_info" id="new_info"
                                        placeholder="Edit info"></th>
                        </tr>
                        <tr>
                            <th>  <input id="bottom" type="submit" name="submit" value="OK"></th>
                        </tr>
                    </table>
                </form>
                <h2>Add tags</h2>
                <form action="/moder/edit_subj" method="POST" name="sign_in">
                    <input type="hidden" name="news_id" value="<?php echo $data['news_id']; ?>">
                    <table>
                        <tr>
                            <th> <input type="text" class="form-control" name="tag_name" id="tag_name"
                                        placeholder="Tag name"></th>
                        </tr>
                        <tr>
                            <th>  <input id="bottom" type="submit" name="submit" value="OK"></th>
                        </tr>
                    </table>
                </form>
                <?php echo $data['public_date']; ?></h2>
            <form action="/moder/delete_news" method="POST" name="sign_in">
                <input type="hidden" name="news_id" value="<?php echo $data['news_id']; ?>">
                <table>
                    <tr>
                        <th>  <input id="bottom" type="submit" name="submit" value="Delete"></th>
                    </tr>
                </table>
            </form>
        </div>

    </div>
</div>