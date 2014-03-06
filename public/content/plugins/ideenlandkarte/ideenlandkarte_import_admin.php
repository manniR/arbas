<div id="icon-edit" class="icon32"><br></div><h2>Ideenlandkarte</h2>
<?php

   

   if($_GET){

     if($_GET['action']){

         switch ($_GET['action']) {
//               case 'edit': // edit entry
//                  echo 'edit';
//                  edit_ideenlandkarte_entry($_GET['entry']);
//               break;
               case 'delete': //delete entry
                     echo 'delete';
                     delete_ideenlandkarte_entry($_GET['entry']);
               break;
               default: // list all entries
                     echo 'list all';
                     get_ideenlandkarte_entries();
               break;

         }
      }

      get_ideenlandkarte_entries();
   }


   function get_ideenlandkarte_entries(){
         global $wpdb;
         $total = $wpdb->get_var('SELECT COUNT(*) FROM wp_ideenlandkarte ');

         echo 'total entries: ' . $total;


         $ideenlandkarte_entries = $wpdb->get_results("SELECT * FROM wp_ideenlandkarte");

         foreach ($ideenlandkarte_entries as $entry){

               $output = '<div class="ideenlandkarte-entry"><h3>' . $entry->title . ' </h3>';
               $output .= '<div class="details">';
               $output .= '<span class="city"> ORT:  '. $entry->city .'</span><span class="address">STRASSE: '. $entry->address .'</span>';
               $output .= '<span class="firstname"> VORNAME:  '. $entry->firstname .'</span><span class="lastname">NACHNAME: '. $entry->lastname .'</span>';
               $output .= '<span class="phone"> PHONE:  '. $entry->phone .'</span><span class="email">E-MAIL: '. $entry->lastname .'</span>';
               $output .= '</div>';
               $output .= '<p>'.$entry->comment.'<p>';
               $output .= '<div class="action">';
               $output .= '<a href="?page=Ideenlandkarte&&action=delete&entry='. $entry->id .'"<span class="delete">Delete</span></a>';
               $output .= '</div>';
               $output .= '</div>'; // end entry

               echo $output;
                }
   }

   function edit_ideenlandkarte_entry($entryID) {

   }

   function delete_ideenlandkarte_entry($entryID){

   }

?>
