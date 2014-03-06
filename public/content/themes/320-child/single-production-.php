<?php

function my_posts_where( $where )
{
    $where = str_replace("meta_key = 'images_%_type'", "meta_key LIKE 'images_%_type'", $where);

    return $where;
}

//add_filter('posts_where', 'my_posts_where');



// args
$args = array(
    'numberposts' => -1,
    'post_type' => 'production',
    'meta_query' => array(
        array(
            'key' => 'Event',
            'value' => strtotime("now"),
            'type'=> 'NUMBER',
            'compare' => '>'

        )
    )
);
// get results
$the_query = new WP_Query( $args );

$meta_query_args = array(
    'relation' => 'OR', // Optional, defaults to "AND"
    array(
        'key'     => 'event_%_date',
        'value'   => strtotime("now"),
        'compare' => '>'
    )
);
$meta_query = new WP_Meta_Query( $meta_query_args );



// get all rows from the postmeta table where the sub_field (type) equals 'type_3'
// - http://codex.wordpress.org/Class_Reference/wpdb#SELECT_Generic_Results
/*$rows = $wpdb->get_results($wpdb->prepare(
    "
    SELECT * FROM sapostmeta
    WHERE meta_key LIKE %s
        AND meta_value = %s
        AND post_id = %s
    ",
    'event_%_date', // meta_name: $ParentName_$RowNumber_$ChildName
    '1390262400',//strtotime("now") // meta_value: 'type_3' for example


));*/


$rows = $wpdb->get_results($wpdb->prepare(
    "
    SELECT * FROM saposts inner join sapostmeta ON saposts.ID = sapostmeta.post_id WHERE saposts.post_type = %s
    AND sapostmeta.meta_key LIKE %s

    ",
    'test', //posttype
    'event_%_date' // meta_name: $ParentName_$RowNumber_$ChildName
    //strtotime("now") // meta_value: 'type_3' for example


));


echo '<pre>';
var_dump($rows);
echo '</pre>';



// query all posts with post-type production
foreach ($rows as $row) {
    echo ('<h3>Title: '.$row->post_title.'</h3>');
    echo ('<h3>PostID: '.$row->ID.'</h3>');
    echo ('<h3>metaValue: '.$row->meta_value.'</h3>');


    echo ('<h3>metaValue: '.date('y-m-d H:i', $row->meta_value).'</h3>');
}





// The Loop
?>

<?php if( $the_query->have_posts() ): ?>
    <ul>

        <?php
        echo '<pre>';

        echo '</pre>';
        ?>



        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
            <li>

            <?php echo date("jS F, Y", strtotime("now")); ?>

            <?php while(has_sub_field('event')): ?>

                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

                <li>
                        <?php $id=get_the_ID(); ?>

                    <p>event date = <?php echo date('y-m-d',strtotime(get_sub_field('date'))); ?></p>
                    <p>Productions ID = <?php the_ID(); ?></p>


                </li>




            <?php endwhile; ?>






            </li>
        <?php endwhile; ?>
    </ul>
<?php endif; ?>

<?php wp_reset_query();  // Restore global post data stomped by the_post(). ?>