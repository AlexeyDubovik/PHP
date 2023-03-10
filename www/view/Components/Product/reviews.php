<div class="product_review d-flex flex-column">
    <?php include "Template/Modal_Form_Reply.php" ?>
    <?php include "Template/Modal_Form_Review.php" ?>
    <div>
        <div class="pr_header">
            <button id="GiveFeedback" class="btn btn-info" data-toggle="tooltip" data-html="true" 
            title="<?php if (!isset($_CONTEXT['auth_user']['id']))
                        echo "You are not authorized";
                    else if($_CONTEXT['auth_user']['confirm'] != null) 
                        echo " You are not confirm your email";
            ?>">
                Give feedback
            </button>
        </div>
        <div class="pr_body">
        <?php if (isset($review_error)) {
            echo "<div class='text-danger'>" . $review_error . "</div>;";
            } else if (isset($_CONTEXT['reviews'])) {
                foreach($_CONTEXT['reviews'] as $review){
                    include "view/Components/Product/review_post.php";
                } 
            } else {
                echo "<div class='text-center text-info'> 
                    <div class='h1 m-5'>Empty Field</div>
                </div>";
            }
        ?>
        </div>
    </div>     
</div>