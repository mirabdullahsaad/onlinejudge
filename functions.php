<?php



    function redirect_to($new_location)
    {
        header("Location: " . $new_location);
        exit;
    }

    function mysql_prep($string)
    {
        global $connection;
        $escaped_string = mysqli_real_escape_string($connection, $string);
        return $escaped_string;
    }


    function confirm_query($result_set)
    {
        if (!$result_set) {
            die("Database query failed.");
        }
    }


    function form_errors($errors=array()) {
    	$output = "";
    	if (!empty($errors)) {
    	  $output .= "<div class=\"error\">";
    	  $output .= "Please fix the following errors:";
    	  $output .= "<ul>";
    	  foreach ($errors as $key => $error) {
    	    $output .= "<li>";
            $output .= htmlentities($error);
            $output .= "</li>";
    	  }
    	  $output .= "</ul>";
    	  $output .= "</div>";
    	}
    	return $output;
    }


    function find_all_news()
    {
        global $connection;
        $query  = "SELECT * ";
        $query .= "FROM takenews ";
        //$query .= "WHERE visible = 1 ";
        $query .= "ORDER BY position ASC";
        $news_set = mysqli_query($connection, $query);
        confirm_query($news_set);
        return $news_set;
    }

    function find_pages_for_subject($subject_id)
    {
        global $connection;
        $safe_subject_id = mysqli_real_escape_string($connection,$subject_id);
        $query  = "SELECT * ";
        $query .= "FROM page ";
        $query .= "WHERE visible = 1 ";
        $query .= "AND subject_id = {$safe_subject_id} ";
        $query .= "ORDER BY position ASC";
        $page_set = mysqli_query($connection, $query);
        confirm_query($page_set);
        return $page_set;
    }

    function find_subject_by_id($subject_id)
    {

        global $connection;
        $safe_subject_id = mysqli_real_escape_string($connection,$subject_id);
        $query  = "SELECT * ";
        $query .= "FROM subject ";
        $query .= "WHERE id = {$safe_subject_id} ";
        $query .= "LIMIT 1";
        $subject_set = mysqli_query($connection, $query);
        confirm_query($subject_set);
        if($subject = mysqli_fetch_assoc($subject_set))
        {
            return $subject;
        }else {
            return null;
        }

    }

    function find_page_by_id($page_id)
    {

        global $connection;
        $safe_subject_id = mysqli_real_escape_string($connection,$page_id);
        $query  = "SELECT * ";
        $query .= "FROM page ";
        $query .= "WHERE id = {$safe_subject_id} ";
        $query .= "LIMIT 1";
        $page_set = mysqli_query($connection, $query);
        confirm_query($page_set);
        if($page = mysqli_fetch_assoc($page_set))
        {
            return $page;
        }else {
            return null;
        }

    }


    function find_selected_page()
    {
        global $current_subject;
        global $current_page;
        if (isset($_GET["subject"])) {
            $current_subject = find_subject_by_id($_GET["subject"]);
            $current_page = null;
        }
        elseif (isset($_GET["page"])) {
            $current_page = find_page_by_id($_GET["page"]);
            $current_subject = null;
        }
        else {
            $current_subject = null;
            $current_page = null;
        }
    }
    //navigation takes 2 argument
    // current subject array or null
    // current  page array or null

    function navigation($subject_array,$page_array)
    {
        $output = "<ul class=\"subjects\">";
		$subject_set = find_all_subjects();
		while($subject = mysqli_fetch_assoc($subject_set)) {
		    $output .= "<li";
            if($subject_array && $subject["id"]==$subject_array["id"]){
                $output .= " class=\"selected\"";
            }
            $output .= ">";
            $output .= "<a href=\"manage_content.php?subject=";
            $output .= urlencode($subject["id"]);
            $output .= "\">";
            $output .= htmlentities($subject["menu_name"]);
            $output .= "</a>";

			$page_set=find_pages_for_subject($subject["id"]);
			$output .= "<ul class=\"pages\">";
			while($page = mysqli_fetch_assoc($page_set)) {
			    $output .= "<li";
                if($page_array && $page["id"]==$page_array["id"]){
                    $output .= " class=\"selected\"";
                }
                $output .= ">";
                $output .= "<a href=\"manage_content.php?page=";
                $output .= urlencode($page["id"]);
                $output .= "\">";
                $output .= htmlentities($page["menu_name"]);
                $output .= "</a></li>";
			}
            mysqli_free_result($page_set);
			$output .= "</ul></li>";
		}
        mysqli_free_result($subject_set);
		$output .= "</ul>";
        return $output;
    }

    function execute($command, $timeout) {
        $handle = proc_open($command, [['pipe', 'r'], ['pipe', 'w'], ['pipe', 'w']], $pipe);

        $startTime = microtime(true);
        /* Read the command output and kill it if the proccess surpassed the timeout */
        while(!feof($pipe[1])) {
            $read .= fread($pipe[1], 8192);
            if($startTime + $timeout < microtime(true)) 
            {
                $read = "TIME_OUT" . $read;
                break;
            }
        }

        kill(proc_get_status($handle)['pid']);
        proc_close($handle);

        return $read;
    }

    /* The proc_terminate() function doesn't end proccess properly on Windows */
    function kill($pid) {
        return strstr(PHP_OS, 'WIN') ? exec("taskkill /F /T /PID $pid") : exec("kill -9 $pid");
    }

    function exec_file_name($s){
        $o1 = strpos($s,".cpp");
        if ($o1 != false) {
            $o = explode(".cpp",$s);
            return $o[0];
        }
        $o2 = strpos($s,".c");
        if ($o2 != false) {
            $o = explode(".c",$s);
            return $o[0];
        }
        $o3 = strpos($s,".C");
        if ($o3 != false) {
            $o = explode(".C",$s);
            return $o[0];
        }
        $o4 = strpos($s,".CPP");
        if ($o4 != false) {
            $o = explode(".CPP",$s);
            return $o[0];
        }
    }

function cmp($a, $b) {
    if($a['accepted'] == $b['accepted']) {
        if ($a['submitted'] == $b['submitted']) {
            return 0;
        }
        else
        {
            return ($a['submitted'] < $b['submitted']) ? -1 : 1;
        }
    }
    return ($a['accepted'] > $b['accepted']) ? -1 : 1;
}


function chkcookie(){
    if (!isset($_SESSION['loggedin'])) {
       if ($_SESSION['loggedin'] != true) {
        if($_COOKIE['loggedin'] == true){
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $_COOKIE['username'];
            $_SESSION['userid'] = $_COOKIE['userid'];
            $_SESSION['privilage'] = $_COOKIE['privilage'];
            $_SESSION['timestamp'] = 0;
        }
    }
    }
}

 ?>

