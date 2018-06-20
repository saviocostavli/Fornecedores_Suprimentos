<?php
    //if we got something through $_POST
    if (isset($_POST&#91;'search'&#93;)) {
        // here you would normally include some database connection
        include('db.php');
        $db = new db();
        // never trust what user wrote! We must ALWAYS sanitize user input
        $word = mysql_real_escape_string($_POST&#91;'search'&#93;);
        $word = htmlentities($word);
        // build your search query to the database
        $sql = "SELECT title, url FROM pages WHERE content LIKE '%" . $word . "%' ORDER BY title LIMIT 10";
        // get results
        $row = $db->select_list($sql);
        
        if(count($row)) {
            $end_result = '';
            foreach($row as $r) {
                $result = $r['title'];
                // we will use this to bold the search word in result
                $bold = '<span class="found">' . $word . '</span>';    
                $end_result.= '<li>' . str_ireplace($word, $bold, $result) . '</li>';            
            }
            echo $end_result;
        }
        else {
            echo '<li>No results found</li>';
        }
    }
?>