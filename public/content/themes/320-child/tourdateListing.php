<?php
/*
 Template Name: Tourdates Listing
*/
?>

<?php get_header(); ?>

<div id="content" class="clearfix row">

    <div id="sidebar1" class="col-sm-3" role="complementary">
        <!--SIDE BAR-->

        <?php wp_nav_menu(array('theme_location'=>'hp_side_menu', 'walker'=> new MR_Child_Only_Walker(), 'depth'=>2)) //hp_side_nav(); //get_sidebar(); // sidebar 1 ?>

        <?php //get_sidebar(); // sidebar 1 ?>

        <?php
        if($post->post_parent)
            $children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0");
        else
            $children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
        if ($children) { ?>
        <!--responsive nav-->
        <div class="navbar">
            <!--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="collapse navbar-collapse navbar-responsive-collapse">-->
            <div>
            <ul class="nav nav-pills nav-stacked span2">
                <?php echo $children; ?>
            </ul>
           </div>
        </div>
        <?php } ?>



    </div> <!--END SIDEBAR tourlisint-->

    <div id="main" class="col-sm-9 clearfix" role="main">


<?php

$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
//$today = date('d-m-Y');
$args= array(
        'post_type' => 'tourdate', // Tell WordPress which post type we want
        'orderby' => 'meta_value', // We want to organize the events by date
        'meta_key' => 'datum', // Grab the "date" field created via "More Fields" plugin (stored in YYYY-MM-DD format)
        'order' => 'ASC', // ASC is the other option
        'posts_per_page' => '-1', // Let's show them all.
        'meta_query' => array( // WordPress has all the results, now, return only the events after today's date
            array(
                'key' => 'datum', // Check the start date field
                'value' => date("y-m-d"), // Set today's date (note the similar format)
                'compare' => '>=', // Return the ones greater than today's date
                'type' => 'DATE' // Let WordPress know we're working with numbers
            )
        )
       /* 'tax_query' => array( // Return only concerts (event-types) and events where "songs-of-ascent" is performing
            array(
                'taxonomy' => 'event-types',
                'field' => 'slug',
                'terms' => 'concert',
            ),
            array(
                'taxonomy' => 'speakers',
                'field' => 'slug',
                'terms' => 'songs-of-ascent',
            )
    )

        )*/


);
$m=array("","");
$tourdates_query = new WP_Query($args);
/** @var $wpdb wpdb */

global $wpdb;
/*echo '<pre>';
var_dump($wpdb->get_caller());
echo '</pre>';*/


?>
<?php if($tourdates_query->have_posts()): ?>


<!--start accordion-->
<div class="panel-group" id="accordion">
<!-- the loop -->
<?php while( $tourdates_query->have_posts() ) : $tourdates_query->the_post(); ?>


<?php
//setlocale (LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge');
        setlocale(LC_TIME, 'de_DE');//  deutsch Monatsnamen

//        $date = new DateTime(get_field('datum',$post->ID));
        //    echo $month = $date->format('m');
//         $date->format('Y-m-d');

        $datum = strftime('%d. %B %Y',strtotime(get_field('datum',$post->ID))); // deutsche monatsnamen
        //$datum = strftime('%d. %B %Y',$date->getTimestamp());
        $m[0] = explode(' ',$datum)[1];

        if ($m[0] != $m[1]){
            //neues MONAT
            echo '<h3>' . $m[0]. ' ' . explode(' ',$datum)[2] . '</h3>';
            $m[1] = $m[0];
        }
        //echo explode(' ',$datum)[1] || "" ? explode(' ',$datum)[1] : "00";
        ?>

  <!--START PANELS-->
<div class="panel">
    <div class="">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#<?php the_ID() ?>">
        <h4 class="panel-title">
                <span><?php echo date('d-m-Y',strtotime(get_field('datum', $post->ID)))?></span>
                      <?php the_title() ?><span class="glyphicon glyphicon-plus pull-right"></span>
        </h4>
            </a>
    </div>
    <div id="<?php the_ID(); ?>" class="panel-collapse collapse">
        <div class="panel-body">

            <dl class="dl-horizontal">
                <dt>Ort: </dt>
                <dd><?php echo get_field('location', $post->ID)?></dd>
                <dt>Einlass: </dt>
                <dd><?php echo get_field('einlass', $post->ID)?></dd>
                <dt>Beginn: </dt>
                <dd><?php echo get_field('beginn', $post->ID)?></dd>
                <?php $href = get_field('ticket_link', $post->ID); ?>
             </dl>
                <?php if ($href): ?>
             <dl class="dl-horizontal">
                <dt>Tickets: </dt>
                <dd><a href="<?php echo $href ?>">
                        <?php echo _('Hier online reservieren') ?></a></dd>
              </dl>
                <?php endif  ?>

            <p><?php echo (get_field('ausverkauft')? 'AUSVERKAUFT' : '') ?></p>
        </div>
    </div>
</div>





<?php endwhile ?>

    </div><!--end accordion-->
<!-- end of the loop -->

<!-- pagination here -->

<?//php wp_reset_postdata(); ?>

<?php else: ?>
<p> <?php _e( 'Sorry, no tourdates where found'); ?></p>
<?php endif; ?>


    </div> <!-- end #main -->

</div> <!-- end #content -->



<?php get_footer(); ?>



