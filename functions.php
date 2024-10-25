<?php 
     add_action( 'wp_enqueue_scripts', 'medline_baguio_enqueue_styles' );
     function medline_baguio_enqueue_styles() {
          wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' ); 
          } 

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}
add_filter( 'posts_where', 'devplus_wpquery_where' );
function devplus_wpquery_where( $where ){
    global $current_user;

    if( is_user_logged_in() ){
         // logged in user, but are we viewing the library?
         if( isset( $_POST['action'] ) && ( $_POST['action'] == 'query-attachments' ) ){
            // here you can add some extra logic if you'd want to.
            $where .= ' AND post_author='.$current_user->data->ID;
        }
    }

    return $where;
}

function show_my_files() { 
  
 if(have_rows('student_grades')):
?>
<ul class="the_grades">
<?php
while(have_rows('student_grades')): the_row();
///alternate of image
$grade_title = get_sub_field('subject_name');
$grade_score = get_sub_field('subject_grade');  
    
?>
    <li><a href="<?php echo $grade_score ?>" target="_blank" ><?php echo $grade_title ?></a></li>
<?php endwhile;
    else:
    ?>
    <p class="no_doc">No documents available.</p>
    <?php


 endif; 
    ?></ul>
    
    <?php
}

add_shortcode('myfiles', 'show_my_files');

add_action('acf/init', 'my_acfe_modules');
function my_acfe_modules(){

    // enable performance mode with ultra engine (default)
    acf_update_setting('acfe/modules/performance', true);
    
}
function upload_file_checker(  ) {

// Get the ACF file field value
$file = get_field('accomplished_registration_form_upload'); // Replace 'your_field_key' with the actual key of your ACF file field

// Check if a file is uploaded
if ($file) {
    $doc_url = "https://view.officeapps.live.com/op/view.aspx?src=";
    // Get the file URL
    $file_url = $file['url'];

    // Use wp_check_filetype() to get file information
    $file_info = wp_check_filetype($file_url);

    // Check the file extension
    if ($file_info['ext'] === 'pdf') {
        $result =$file_url;
    } elseif ($file_info['ext'] === 'jpg' || $file_info === 'jpeg') {
        $result = $file_url;
    } elseif ($file_info['ext']=== 'png') {
        $result = $file_url;
    } elseif ($file_info['ext'] === 'doc') {
        $result = $doc_url.$file_url;
    } else {
        $result = 'Unknown file type';
    }

    return $result;
}



}
add_shortcode( 'ufc', 'upload_file_checker' );



function show_my_grades2() { 

 if(have_rows('Grades')):
    while (have_rows('Grades')): the_row();

        if (get_row_layout() == 'school_year_c'):
            $sy = get_sub_field ( 'school_year');
?>
            <h3>School Year : <?php  echo $sy;  ?>  </h3> 
<?php
            

                if(have_rows('student_grades')):
                     while (have_rows('student_grades')): the_row();
                          if (get_row_layout() == 'semester_grades'):

                                $semestesr = get_sub_field('semester');
                                

                                
                                ?>
                                <h4>School Year : <?php  echo $semestesr['label'];  ?>  </h4> 
                                
                                <?php
                                $course_selected = get_sub_field('select_course');
                                ?> 
                                
                                
                                <h1 class="aligncenter" style="margin-bottom: 50px "><?php echo $course_selected['label']; 
                                ?></h1>
                                
                                
                                <?php
                                switch ($course_selected['value']) {
                                    case 'cg':
                                       
                                        if(have_rows('caregiving')):
                                           
                                ?>
                                             <table class="My grades" style="width:100%">
                                             <tr>
                                               <th>Subject</th>
                                              <!--   <th>Prelim Grade</th>
                                                <th>Midterm Grade</th> -->
                                                <th>Final Grade</th>
                                                <th>Status</th>
                                             </tr>
                                <?php
                                            while(have_rows('caregiving')): the_row();
                                            $cg_subject_title = get_sub_field('cg_subject');
                                            // $cg_grade = get_sub_field('cg_pg');
                                            // $cg_grade2 = get_sub_field('cg_mg');
                                            $cg_grade3 = get_sub_field('cg_fg');
                                            $stats = get_sub_field('status');
                                            ?>
                                        
                                             <tr>
                                               <td><?php echo $cg_subject_title['label']; ?></td>
                                            <!--   <td><?php echo $cg_grade; ?></td>
                                              <td><?php echo $cg_grade2; ?></td> -->
                                              <td><?php echo $cg_grade3; ?></td>
                                              <td><?php echo $stats['label']; ?></td>
                                             </tr>
                                          
                                
                                                <?php endwhile;
                                              else:
                                               ?>
                                
                                              <p class="no_doc">No grades available.</p>
                                              <?php
                                             endif; 
                                             ?>
                                 </table>   
                                             <?php
                                                 break;
                                    
                                            case 'hc':
                                                 if(have_rows('healthcare')):
                                           
                                ?>
                                             <table class="My grades" style="width:100%">
                                             <tr>
                                               <th>Subject</th>
                                               <!--  <th>Prelim Grade</th>
                                                <th>Midterm Grade</th> -->
                                                <th>Final Grade</th>
                                                <th>Status</th>
                                             </tr>
                                <?php
                                            while(have_rows('healthcare')): the_row();
                                                     $hc_subject_title = get_sub_field('hc_subject');
                                            // $hc_grade = get_sub_field('hc_subject_grade'); 
                                            // $hc_grade1 = get_sub_field('hc_midterm');
                                            $hc__grade2 = get_sub_field('hc_fg');
                                            $hc_stats = get_sub_field('hc_status');
                                            ?>
                                        
                                             <tr>
                                               <td><?php echo $hc_subject_title['label']; ?></td>
                                              <!-- <td><?php echo $hc_grade; ?></td>
                                              <td><?php echo $hc_grade1; ?></td> -->
                                              <td><?php echo $hc_grade2; ?></td>
                                              <td><?php echo $hc_stats['label']; ?></td>
                                             </tr>
                                          
                                
                                                <?php endwhile;
                                              else:
                                               ?>
                                
                                              <p class="no_doc">No grades available.</p>
                                              <?php
                                             endif; 
                                             ?>
                                 </table>   
                                             <?php
                                                 break;
                                               
                                            }
                                
                                

                          endif;

                    endwhile;
                endif;

        endif;

    endwhile;
endif;
     
}



add_shortcode('mygrades2', 'show_my_grades2');

/***
 * Grading System
 */




function dropdown_courses(){
    global $wpdb;
    $sql = "SELECT ID,label FROM wp_wlsm_classes";
    $results = $wpdb->get_results($sql) or die(mysql_error());

    echo "<select name='student' value=''>Student Name</option>"; // list box select command

    foreach ($results as $r){//Array or records stored in $row

    echo "<option value=$r->ID>$r->label</option>"; 

    /* Option values are added by looping through the array */ 

    }

    echo "</select>";// Closing of list box
}
add_shortcode('dropdown_list','dropdown_courses');


function student_grading(){
    global $wpdb;

    $sql = "SELECT wp_wlsm_classes.label, wp_wlsm_class_school.class_id, wp_wlsm_student_records.name
            FROM ((wp_wlsm_classes
            INNER JOIN wp_wlsm_class_school ON wp_wlsm_classes.ID = wp_wlsm_class_school.class_id)
            INNER JOIN wp_wlsm_student_records ON wp_wlsm_class_school.default_section_id = wp_wlsm_student_records.section_id)";
    
    $results = $wpdb->get_results($sql) or die(mysql_error());

    ?>
    <table class='table'>
        <tr>
            <td>Class ID</td>
            <td>Course</td>
            <td>Name</td>
        </tr>
    
    <?php
        foreach($results as $r)
        {
    ?>
        <tr>
            <td><?php echo $r->class_id; ?></td>
            <td><?php echo $r->label; ?></td>
            <td><?php echo $r->name; ?></td>
        </tr>
        
    <?php
    
        }
    ?>
    </table>
    <?php
}
add_shortcode('gs_student_list','student_grading');


 ?>
