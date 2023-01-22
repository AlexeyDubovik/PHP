<div class="modal fade bd-example-modal-lg show" id="modal_review" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
  <div class="modal-dialog modal-lg">
    <div class="r_form_container modal-content">
      <div class="r_header modal-header">
        <h6 class="<?php if (!isset($_CONTEXT['auth_user']['id']) || $_CONTEXT['auth_user']['confirm'] != null)
            echo "text-danger";
            else echo "";
          ?> modal-title" id="myLargeModalLabel">
          <?php if (!isset($_CONTEXT['auth_user']['id']) || $_CONTEXT['auth_user']['confirm'] != null)
            echo "Error";
            else echo " Make Review";
          ?>
        </h6>
        <button type="button" class="close text-info bg-transparent border-0" data-dismiss="modal" aria-label="Close">
          <span class="h2" aria-hidden="true">×</span>
        </button>
      </div>
      <div class="r_content modal-body">
        <?php if (!isset($_CONTEXT['auth_user']['id'])) { 
            include "Template/Auth_message.php"; 
          } 
        else if($_CONTEXT['auth_user']['confirm'] != null){
          include "Template/Confirm_Email_message.php"; 
        }
        else { ?>
          <form action="" method="post" id="review_form" name="review_form">
            <div class="form_rating" data-rateValue="0">
                <?php for ($i = 1; $i <= 5; $i++) { ?>
                    <label class="width_35 rate" data-rateNumber="<?=$i?>">
                        <?php include "icon/Star.svg";?>
                    </label>
                <?php };?>
                <input class="rate_input" type="number" name="rating" readonly="readonly" value = "0">
            </div>
            <div class="form-group mt-2">
                <label class="" for="advantages">Advantages: </label>
                <input class="form-control" type="text" name="advantages" placeholder="Advantages">
            </div>
            <div class="form-group mb-4">
                <label class="" for="disadvantages">Disadvantages: </label>
                <input class="form-control" type="text" name="disadvantages" placeholder="Disadvantages">
            </div>
            <div class="form-group mb-2 was-validated">
                <textarea class="form-control" name="text" cols="30" rows="10" required></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary">Leave Review</button>
            </div>
          </form>
        <?php }?>
      </div>
    </div>
  </div>
</div>