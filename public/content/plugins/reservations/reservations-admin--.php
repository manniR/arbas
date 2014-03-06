<?php
require_once 'pagination.class.php';
global $wpdb;

$items = $wpdb->get_var('SELECT * FROM reservations');
//$items = mysql_num_rows(mysql_query("SELECT * FROM wp_table;")); // number of total rows in the database

if($items > 0) {
    $p = new pagination;
    $p->items($items);
    $p->limit(15); // Limit entries per page
    $p->target("admin.php?page=reservations");
    $p->currentPage($_GET[$p->paging]); // Gets and validates the current page
    $p->calculate(); // Calculates what to show
    $p->parameterName('paging');
    $p->adjacents(1); //No. of page away from the current page

    if(!isset($_GET['paging'])) {
        $p->page = 1;
    } else {
        $p->page = $_GET['paging'];
    }

    //Query for limit paging
    $limit = "LIMIT " . ($p->page - 1) * $p->limit  . ", " . $p->limit;

} else {
    echo "No Record Found";
}

/*
 * ACTIONS
 */

if (isset($_GET['action'])){
    switch ($_GET['action']){
        case 'delete':

            if(reservations_delete_entry($_GET['entry']) != 0) {
                $location = url_is();
                $wpdb->redirect($location);
            }
            break;
        case 'deleteSelected':
            if(isset($_GET['sel_entries'])){
                $entries = $_GET['sel_entries'];
//                  $entries_deleted = 0;
//                  $entries_count = count($entries);
                foreach($entries as $entry_id){
//                     if(reservations_delete_entry($entry_id)) $entries_deleted++;
                    reservations_delete_entry($entry_id);
                }
//                  if($entries_count == $entries_deleted){
//                        $location = url_is();
//                        echo 'redirect to ' .$location;
//                        wp_redirect($location);
//                  }
            }
            break;
        default:
    }
}
?>



    <div class="wrap">
        <div id="icon-edit" class="icon32"><br></div><h2>reservations <small><span class="count"><?= $items ?>Reservierungen</span></small></h2>

        <?php echo(ABSPATH); ?>
        <form id="reservations-actions" method="get" action="<?= url_is() ?>&noheader">




            <div class="tablenav">

                <div class="alignleft actions">

                    <select name="action">
                        <option selected="selected" value="-1">Bulk Actions</option>
                        <option value="deleteSelected">Delete Selected</option>
                    </select>
                    <input type="submit" class="button-secondary action" id="doaction" name="doaction" value="Apply">
                    <input type="hidden" name="page" value="reservations" >



                </div>

                <div class='tablenav-pages'>
                    <?php echo $p->show();  // Echo out the list of paging. ?>
                </div>
            </div>

            <table class="widefat">
                <thead>
                <tr>
                    <th style="" class="manage-column column-cb check-column" id="cb" scope="col"><input type="checkbox"></th>
                    <th class="manage-column" id="id" scope="row">ID</th>
                    <th class="manage-column" id="entry" scope="row">Entry</th>
                    <th class="manage-column" id="cat" scope="row">Cat</th>
                    <th class="manage-column" id="address" scope="row">Address</th>
                    <th class="manage-column" id="author" scope="row">Author</th>
                    <th class="manage-column" id="date" scope="row">Date</th>
                </tr>
                </thead>
                <tbody>
                <?php
                global $wpdb;
                $results = $wpdb->get_results("SELECT * FROM $wpdb->reservations ORDER BY id DESC $limit");
                //$sql = "SELECT *  FROM $wp_table ORDER BY id DESC $limit";
                //$result = mysql_query($sql) or die ('Error, query failed');

                if ($results) {
                    foreach ($results as $result) {
                        ?>
                        <tr valign="top" class="alternate author-self status-publish edit" id="<?= $result->id ?>">
                            <th class="check-column" scope="row"><input type="checkbox" value="<?= $result->id ?>" name="sel_entries[]"></th>
                            <td><?= $result->id; ?></td>
                            <td class="post-title column-title"><strong><?= $result->title; ?></strong>
                                <?php if($result->production_title != '') echo '<p>' . $result->production_title . '</p>'; ?>


                                <div class="row-actions">
                                    <!--  <span class="inline hide-if-no-js"><a title="Edit this post inline" class="editinline" href="#">Edit</a> | </span> -->
                                    <span class="trash"><a href="<?php echo url_is();?>&noheader&action=delete&result=<?= $result->id; ?>" title="Delete" class="submitdelete">Delete</a></span>
                                </div>

                            </td>

                            <td>Karten: <?php if($result->card_count != '') echo $result->card_count; ?></td>
                            <td><?php if($result->firstname != '') echo $result->firstname; ?> &nbsp; <?php if($result->lastname != '') echo  $result->lastname; ?> <br />
                                <?php if($result->phone != '') echo $result->phone .'<br />'; ?>
                                <?php if($result->email != '') echo  $result->email; ?>

                            </td>
                            <td><?= $result->created; ?></td>
                        </tr>

                    <?php }
                } else { ?>
                <tr>
                    <td>No Record Found!</td>
                <tr>
                    <?php } ?>
                </tbody>
            </table>
        </form>
    </div>






<?php

/*
 * DELETE
 */

function reservations_delete_entry($id){
    global $wpdb;
    $wpdb->query("DELETE FROM $wpdb->reservations WHERE id=$id");

    return $wpdb->rows_affected;

//   echo'<pre>';
//   print_r($wpdb);
//   echo'</pre>';

}



/*
 * UPDATE
 */





/*
 * return url for edit link
 */
function url_is($showlink = FALSE) {
    if ($_GET['page'])
        $query = 'page=' . $_GET['page'];
    else
        $query = '';
    if(isset($_GET['paging'])) {
        $query.= '&paging='.$p->page = $_GET['paging'];
    }
    $urlis = $_SERVER['PHP_SELF'] . '?' . $query;

    if($showlink == TRUE)
        return '<a href="' . $urlis . '">' . $urlis . '</a>';
    else
        return $urlis;
}

