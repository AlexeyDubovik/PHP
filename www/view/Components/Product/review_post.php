<div class="review" id="<?= $review['review_id']; ?>">
    <div class="rev_header">
        <div class="review_author d-flex justify-content-between">
            <h6 class="
                <?php if ($review['rights'] === 'admin')
                        echo "author_admin";
                    else echo "author_user"; 
                ?>">
                <?= $review['user_name']; ?>
            </h6>
            <span><?= $review['date']; ?></span>
        </div>
    </div>
    <div class="rating mt-2 d-flex" data-rateValue="<?= $review['rating']; ?>">
        <?php for ($i = 1; $i <= 5; $i++) { ?>
            <label class="rate" data-rateNumber="<?=$i?>">
                <?php include "icon/Star.svg";?>
            </label>
        <?php }; ?>
        <div class="rating_info">
            <span class="text-info" style="margin:1px 5px;">(<?= $review['rating'] ?>)</span>
        </div>
    </div>
    <div class="rev_body">
        <div class="rev_text">
            <?= $review['text']; ?>
        </div>
        <?php if ($review['advantages'] != null) { ?>
            <div class="internals" >
                <b>Advantages:</b>
                <div><?= $review['advantages']; ?></div>
            </div>
        <?php }; if($review['disadvantages'] != null) {?>  
            <div class="internals">
                <b>Disadvantages:</b> 
                <div><?= $review['disadvantages']; ?></div>
            </div>
        <?php };?>  
    </div>
    <div class="rev_foot d-flex justify-content-between">
        <div class="rev_reply">
            <button class="d-flex bg-transparent border-0" onclick="replyForm(event)" 
            title="<?php if (!isset($_CONTEXT['auth_user']['id']))
                        echo "You are not authorized";
                    else if($_CONTEXT['auth_user']['confirm'] != null) 
                        echo " You are not confirm your email";
            ?>">
                <div>
                    <?php include "icon/reply.svg"?>
                </div>
                <div>Answer</div>
            </button>
        </div>
        <div class="estimate d-flex">
            <div class="d-flex frame">
                <div class="like d-flex"
                title="<?php if (!isset($_CONTEXT['auth_user']['id']))
                        echo "You are not authorized";
                    else if($_CONTEXT['auth_user']['confirm'] != null) 
                        echo " You are not confirm your email";
                ?>">
                    <?php include "icon/like.svg"?>
                    <span >
                        <?= $review['likes']; ?>
                    </span>
                </div>
                <div class="dislike d-flex"
                title="<?php if (!isset($_CONTEXT['auth_user']['id']))
                        echo "You are not authorized";
                    else if($_CONTEXT['auth_user']['confirm'] != null) 
                        echo " You are not confirm your email";
                ?>">
                    <?php include "icon/like.svg"?>
                    <span>
                        <?= $review['dislikes']; ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <?php //print_r($review); ?>
</div>
<?php if (is_array($review['replys']))
    foreach($review['replys'] as $reply){
        //print_r($reply);
        include "view/Components/Product/reply_review.php";
    }
?>
<?php 
    if(isset($_CONTEXT["reply"]) && $_CONTEXT["reply"]['review_id'] === $review['review_id']) {
        print_r($_CONTEXT["reply"]);
    }
    if(!is_bool($_CONTEXT['Errors'])) print_r($_CONTEXT['Errors']);
?>