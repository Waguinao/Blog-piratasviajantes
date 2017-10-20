<?php
/*
Template Name: Parceiros
*/

$id = get_query_var("id");

if( empty($id) || !is_numeric($id) ){
    wp_redirect(home_url());
}

$flight = getFlight($id);

if( ( !$flight ) || isset($flight->status) && $flight->status != 200 ){
    wp_redirect(home_url());
}

$partner = getRandomPartner();
$partnerLink = get_field( ME_PARTNER_LINK, $partner->ID );
$partnerImage = get_field( ME_PARTNER_IMAGE, $partner->ID );

$seenPopup = $_COOKIE["popup"];
$enablePopupAfter = false;

if( $seenPopup != "seen" ){
    $enablePopupAfter = true;
}

setcookie("popup_check", "seen");
session_start();
$_SESSION['is_redirect'] = true;

get_header();

unset( $_SESSION['is_redirect'] );

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

?>

<?php if( $enablePopupAfter ): ?>

    <script type="text/javascript">
       cookie.set('popup_check','seen');
    </script>
    
<?php endif; ?>

<div id="main-content" style="width: 50%; margin: 0 auto; padding: 10px;">
    
    <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <div class="entry-content">
                
                <h2 id="titleRedirect"><?php _e("Redirecionando em 3,"); ?></h2>

                <br /><br />
                
                <?php if( $partner != -1 ): ?>

                    <span><?php _e("Recomendamos que você veja também:"); ?></span>
                    <br />
                    <a href="<?php echo $partnerLink; ?>" target="_blank">
                        <img src="<?php echo $partnerImage['url']; ?>" width="800" height="600" />
                    </a>
                    
                <?php endif; ?>
                    
            </div>

        </article>

    <?php endwhile; ?>

</div>

<script>
    
    window.setTimeout(function(){

        changeTitle(" 2,");

        window.setTimeout(function(){
            changeTitle(" 1...");            
        }, 1000);

    }, 1000);

    window.setTimeout(function(){
        window.location.href = "<?php echo $flight->link; ?>";
    }, 4000);

    var changeTitle = function( msg ){
        var title = document.getElementById("titleRedirect").innerHTML;
        document.getElementById("titleRedirect").innerHTML = title + msg;
    }
        
</script>

<?php // get_footer();

