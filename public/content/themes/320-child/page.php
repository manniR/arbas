<?php get_header(); ?>

  <div id="content" class="clearfix row">


    <div id="sidebar1" class="col-sm-3" role="complementary">
      <!--SIDE BAR-->

      <?php wp_nav_menu(array('theme_location' => 'hp_side_menu', 'walker' => new MR_Child_Only_Walker(), 'depth' => 2)) //hp_side_nav(); //get_sidebar(); // sidebar 1 ?>

      <?php //get_sidebar(); // sidebar 1 ?>

      <?php
      if ($post->post_parent)
        $children = wp_list_pages("title_li=&child_of=" . $post->post_parent . "&echo=0");
      else
        $children = wp_list_pages("title_li=&child_of=" . $post->ID . "&echo=0");
      if ($children) {
        ?>
        <!--responsive nav-->
        <div class="navbar">
          <ul class="nav nav-pills nav-stacked span2">
                        <?php echo $children; ?>
                    </ul>
        </div>
      <?php } ?>


    </div>
    <!--END SIDEBAR-->


    <div id="main" class="col-sm-9 clearfix" role="main">


      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope
                 itemtype="http://schema.org/BlogPosting">

          <header>

                        <!--							<div class="page-header"><h1 class="page-title" itemprop="headline">-->
                        <?php //the_title(); ?><!--</h1></div>-->

                    </header>
          <!-- end article header -->

          <section class="post_content clearfix" itemprop="articleBody">
            <?php the_content(); ?>

            <div class="galerie">
                            <?php

                            $rows = get_field('galeriebilder');

                            if ($rows) {
                                echo '<ul>';

                                foreach ($rows as $row) {

                                    echo '<pre>';
                                    var_dump($row['galeriebild']);
                                    echo '</pre>';

                                    $image = wp_get_attachment_image_src($row['galeriebild'], 'thumbnail');
                                    echo '<img src="' . $row['galeriebild']['sizes']['medium'] . '" />';
                                    //echo '<li>sub_field_1 = ' . '' .'</li>'; // . ', sub_field_2 = ' . $row['sub_field_2'] .', etc</li>';
                                }

                                echo '</ul>';
                            }?>

                        </div>


          </section>
          <!-- end article section -->


          <footer>

            <?php the_tags('<p class="tags"><span class="tags-title">' . __("Tags", "wpbootstrap") . ':</span> ', ', ', '</p>'); ?>

          </footer>
          <!-- end article footer -->

        </article> <!-- end article -->



      <?php endwhile; ?>

      <?php else : ?>

        <article id="post-not-found">
          <header>
            <h1><?php _e("Not Found", "wpbootstrap"); ?></h1>
          </header>
          <section class="post_content">
            <p><?php _e("Sorry, but the requested resource was not found on this site.", "wpbootstrap"); ?></p>
          </section>
          <footer>
          </footer>
        </article>

      <?php endif; ?>

    </div>
    <!-- end #main -->


  </div> <!-- end #content -->

<?php get_footer(); ?>