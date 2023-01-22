<div id="modal_reply" class="modal fade bd-example-modal-lg show" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="r_form_container modal-content">
      <div class="r_header modal-header">
        <h6 class="<?php if (!isset($_CONTEXT['auth_user']['id']) || $_CONTEXT['auth_user']['confirm'] != null)
            echo "text-danger";
            else echo "";
          ?> modal-title" id="myLargeModalLabel">
          <?php if (!isset($_CONTEXT['auth_user']['id']) || $_CONTEXT['auth_user']['confirm'] != null)
            echo "Error";
            else echo " Make Reply";
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
          <form action="" method="post" id="reply_form" name="reply_form">
              <div class="invisible ">
                  <input type="text" name="review_id">
              </div>
              <div class="form-group mb-2 was-validated">
                  <textarea class="form-control" name="reply_text" cols="30" rows="10" required></textarea>
              </div>
              <div class="form-group">
                  <button class="btn btn-primary">Leave Reply</button>
              </div>
          </form>
        <?php } ?>
      </div>
    </div>
  </div>
</div>