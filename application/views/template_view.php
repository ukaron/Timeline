<!DOCTYPE HTML PUBLIC «-//W3C//DTD HTML 4.01 Transitional//EN» «http://www.w3.org/TR/html4/loose.dtd»>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <title>Timeline</title>
    </head>
    <body>
        <div class="header">
            <?php
            if(isset($_SESSION['user'])){?>
            <p> <?php echo "Hello ".$_SESSION['user'];}?></p>
            <ul id="nav"  style="--items: 3;">
                <?php
                if(isset($_SESSION['status']))
                {
                    echo "<li><a href='/main/logout'>Logout</a></li>";
                    echo "<li><a href='/change_pass'>Change password</a></li>";
                }
                else
                        echo '<li><a href="/sign_in">Sign in</a></li>';?>
                <?php if($_SESSION['status'] == 'admin'){
                    echo '<li><a href="/moder">Moderation area</a></li>';
                    echo '<li><a href="/admin">Admin area</a></li>';}?>
                <?php if($_SESSION['status'] == 'moder')
                    echo '<li><a href="/moder">Moderation area</a></li>';?>
                <li><a href="/main">Start page</a></li>
            </ul>

        </div>
        <?php include 'application/views/'.$content_view; ?>

        </html>
    </body>
</html>
