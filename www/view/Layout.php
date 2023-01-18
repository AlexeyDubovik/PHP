<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "Template/Title.php"?>
    <link rel="stylesheet" href="/lib/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/Layout.css">
    <link rel="stylesheet" href="/css/404.css">
</head>
<body class="bg-dark text-light">
    <header>
        <nav class="navbar navbar-expand-lg CU-gradient">
            <a class="brand" href="/index"><i>php</i></a>
            <button class="navbar-toggler navbar-dark" type="button" 
             data-toggle="collapse" data-target="#navbarToggleExternalContent" 
             aria-controls="navbarToggleExternalContent" aria-expanded="false" 
             aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/index">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/basic">Basic</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/fundamentials">Fundamential</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/formdata">Form Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/database">Data Base</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/shop">Shop</a>
                </li>
                <?php if (isset($_CONTEXT['auth_user']['rights']) && $_CONTEXT['auth_user']['rights'] === "admin" ){ ?>      
                    <li class="nav-item">
                        <a class="nav-link" href="/phpmyadmin">myAdmin</a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <?php global $Layout_nav_auth; if(isset( $Layout_nav_auth)){?>
                        <div class="nav-link">
                            <a class="text-decoration-none text-dark user_nav_profile" href="/profile/<?= $_CONTEXT['auth_user']['login']?>"> 
                                <?php 
                                    $class = "class='user_avatar'";
                                    echo "<img id='Avatar_Layout' src='/avatars/{$_CONTEXT['auth_user']['avatar']}' $class alt=''>";
                                    $class = "class='user_name'";
                                    echo "<span $class>" .  "$Layout_nav_auth" .  "</span>";
                                ?>
                            </a>
                            <label style="width:1.2em;">
                                <a class="logout" name="logout" href="?logout"> 
                                    <?= file_get_contents("icon/logout.svg"); ?> 
                                </a>
                            </label>
                        </div>
                    <?php } else { ?>
                        <a class="nav-link" href="/authorization">Log In</a>
                    <?php } ?>
                </li>
                <li class="nav-item">
                    <div class="nav-link" >
                        <div class="basket">
                            <div style="width:30px">
                                <?= file_get_contents("icon/basket.svg"); ?>
                            </div>
                        </div>
                    </div>
                </li>
              </ul>
            </div>
        </nav>
    </header>
    <div class="container">
        <!-- Components loads from router -->
        <?php include "Routes/General_Router.php"?>
    </div>
    <?php include "view/footer.php" ?>
    <script src="/lib/jquery/dist/jquery.min.js"></script>
    <script src="/lib/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/index.js"></script>
</body>
</html>