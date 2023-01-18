<?php if(is_array($_CONTEXT['products']) && 
    isset($view_data['paginator']['lastpage']) &&
    $view_data['paginator']['lastpage'] > 1) { 
    $href_base = "?"
        . ( ( isset( $view_data[ 'order' ] ) ) 
                ? "order=" . $view_data[ 'order' ] . "&"
                : "" )
        . ( ( isset( $view_data[ 'filters' ][ 'minprice' ] ) ) 
                ? "minprice=" . $view_data[ 'filters' ][ 'minprice' ] . "&"
                : "" )
        . ( ( isset( $view_data[ 'filters' ][ 'maxprice' ] ) ) 
                ? "maxprice=" . $view_data[ 'filters' ][ 'maxprice' ] . "&"
                : "" ) 
        . ( ( isset( $view_data[ 'search' ] ) ) 
                ? "search=" . $view_data[ 'search' ] . "&"
                : "" );
?>
    <div class='paginator'>
        <?php if( $view_data['paginator']['page'] > 1 ) : ?>
            <a class="page_arrow" href="<?=$href_base?>page=<?= $view_data['paginator']['page'] - 1 ?>">
                <?php include "icon/ios-arrow-back.svg" ?>
            </a>
        <?php else : ?>
            <div class="page_arrow" >&nbsp;</div>
        <?php endif ?>
        <?php for( $i = 1; $i <= $view_data['paginator']['lastpage']; $i++ ) : 
            if( $i == $view_data['paginator']['page'] ) : ?>
                <b class="page"><?= $i ?></b>
            <?php else : ?>
                <a class="page" href="<?=$href_base?>page=<?= $i ?>"><?= $i ?></a> 
            <?php endif ?>
        <?php endfor ?>
            
        <?php if($view_data['paginator']['page'] < $view_data['paginator']['lastpage']) : ?>
            <a class="page_arrow" href="<?=$href_base?>page=<?= $view_data['paginator']['page'] + 1 ?>">
                <?php include "icon/ios-arrow-forward.svg" ?>
            </a>
        <?php else : ?>
            <div class="page_arrow" >&nbsp;</div>
        <?php endif ?>
    </div>
<?php } ?>