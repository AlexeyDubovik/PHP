<div class="reply" id="<?= $reply['reply_id']; ?>">
    <div class="reply_con">
        <div class="rep_header">
            <div class="reply_author d-flex justify-content-between">
                <h6 class="
                    <?php if ($reply['rights'] === 'admin')
                            echo "author_admin";
                        else echo "author_user"; 
                    ?>">
                    <?= $reply['user_name']; ?>
                </h6>
                <span><?= $reply['date']; ?></span>
            </div>
        </div>
        <div class="rep_body mt-2">
            <div class="rep_text">
                <?= $reply['text']; ?>
            </div>
        </div>
    </div>
</div>