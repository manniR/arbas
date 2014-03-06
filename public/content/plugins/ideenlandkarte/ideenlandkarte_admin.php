<?php
require_once 'pagination.class.php';
global $wpdb;



$items = $wpdb->get_var('SELECT COUNT(*) FROM wp_ideenlandkarte ');
//$items = mysql_num_rows(mysql_query("SELECT * FROM wp_table;")); // number of total rows in the database

if($items > 0) {
		$p = new pagination;
		$p->items($items);
		$p->limit(15); // Limit entries per page
		$p->target("admin.php?page=Ideenlandkarte");
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
            
            if(ideenlandkarte_delete_entry($_GET['entry']) != 0) {
               $location = url_is();
               wp_redirect($location);     
            }
      break;
      case 'deleteSelected':
            if(isset($_GET['sel_entries'])){
                  $entries = $_GET['sel_entries'];
//                  $entries_deleted = 0;
//                  $entries_count = count($entries);
                  foreach($entries as $entry_id){
//                     if(ideenlandkarte_delete_entry($entry_id)) $entries_deleted++;
                     ideenlandkarte_delete_entry($entry_id);
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
   <div id="icon-edit" class="icon32"><br></div><h2>Ideenlandkarte <small><span class="count"><?= $items ?> Einträge</span></small></h2>
<form id="ideenlandkarte-actions" method="get" action="<?= url_is() ?>&noheader">

   
   

<div class="tablenav">

   <div class="alignleft actions">
      
<select name="action">
<option selected="selected" value="-1">Bulk Actions</option>
<option value="deleteSelected">Delete Selected</option>
</select>
<input type="submit" class="button-secondary action" id="doaction" name="doaction" value="Apply">
<input type="hidden" name="page" value="Ideenlandkarte" >



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
 $result = $wpdb->get_results("SELECT * FROM wp_ideenlandkarte ORDER BY id DESC $limit");
//$sql = "SELECT *  FROM $wp_table ORDER BY id DESC $limit";
//$result = mysql_query($sql) or die ('Error, query failed');

if ($result) {
	foreach ($result as $entry) {
?>
        <tr valign="top" class="alternate author-self status-publish iedit" id="<?= $entry->id ?>">
           <th class="check-column" scope="row"><input type="checkbox" value="<?= $entry->id ?>" name="sel_entries[]"></th>
            <td><?= $entry->id; ?></td>
            <td class="post-title column-title"><strong><?= $entry->title; ?></strong>
               <?php if($entry->comment != '') echo '<p>' . $entry->comment . '</p>'; ?>


               <div class="row-actions">
                <!--  <span class="inline hide-if-no-js"><a title="Edit this post inline" class="editinline" href="#">Edit</a> | </span> -->
                  <span class="trash"><a href="<?php echo url_is();?>&noheader&action=delete&entry=<?= $entry->id; ?>" title="Delete" class="submitdelete">Delete</a></span>
               </div>

            </td>
            <td><?= ($entry->cat == 0 ) ? 'Positiv' : 'Negativ'; ?></td>
            <td><?php if($entry->city != '') echo $entry->city; ?> &nbsp; <?php if($entry->address != '') echo  $entry->address; ?>          </td>
            <td><?php if($entry->firstname != '') echo $entry->firstname; ?> &nbsp; <?php if($entry->lastname != '') echo  $entry->lastname; ?> <br />
                <?php if($entry->phone != '') echo $entry->phone .'<br />'; ?>
                <?php if($entry->email != '') echo  $entry->email; ?>

            </td>
            <td><?= $entry->created; ?></td>
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

function ideenlandkarte_delete_entry($id){
   global $wpdb;
   $wpdb->query("DELETE FROM wp_ideenlandkarte WHERE id=$id");

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

?>