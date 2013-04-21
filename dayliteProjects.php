<?php
/**
 * Author: Petr Havelka
 * Author URI: www.web-entity.cz
 * Version: 0.2b
 * License: MIT
 */


/************************************************
 * Config
*/

// table columns 'name' => array( 'column width', 'color (css)', 'text align (center|left|right)', 'Headline')
// comment or comment out for show/hide column
$columns = array(
  //'priority' => array('30','rgb(174, 183, 188)', '', 'Priority'),
  'projectName' => array('','rgb(252, 107, 0)', '', 'Project'),
  'stage' => array('','rgb(0, 159, 153)', '', 'Stage'),
  'dueDate' => array('','rgb(0, 108, 230)', '', 'Due'),
  //'category' => array('','', '', 'Category'),
  //'owner' => array('','', '', 'Owner'),
  //'currentStage' => array('','', '', ''),
  //'totalStages' => array('','', '', ''),
  'percentDoneString' => array('','', '', 'Status'),
  //'client' => array('','', '', 'Client'),
  //'company' => array('','', '', 'Company')
);

//set width unit - px or %
$widthUnit = 'px';

// category filter - what categories to show
define('FILTER_BY_CATEGORY', false);  //set it to true if you want to filter by categories
$categories = array(
  'category1',
  'category2'
);

// owner filter - show project with these owners
define('FILTER_BY_OWNER', false); //set it to true if you want to filter by owner
$owners = array(
  'owner1',
  'owner2'
);

// client filter - show project with these clients
define('FILTER_BY_CLIENT', false); //set it to true if you want to filter by client
$clients = array(
  'client1',
  'client2'
);

// exclude category - what categories to not show
define('EXCLUDE_CATEGORY', false);  //set it to true if you want to use it
$ex_categories = array(
  'category1',
  'category2'
);

// exclude owner - not show project with these owners
define('EXCLUDE_OWNER', false); //set it to true if you want to use it
$ex_owners = array(
  'owner1',
  'owner2'
);

// exclude client - not show project with these clients
define('EXCLUDE_CLIENT', false); //set it to true if you want to use it
$ex_clients = array(
  'client1',
  'client2'
);


// order by priority - default is by due date
define('ORDER_BY_PRIORITY', false); //set it to true if you want to use it

// min days to show as red
$redDays = 7;
$redColor = "red"; //css color

//load font awesome font icons - more at http://fortawesome.github.io/Font-Awesome/ - you can use it for nicknames (for example '<i class="icon-envelope-alt"></i>')
define('LOAD_AWESOME', false);

//owners nicknames
define('USE_OWNER_NICKNAMES', false); //set it to true if you want to use it
define('USE_OWNER_IMG', false); //set it to true, if you like to use images instead of text. USE_OWNER_NICKNAMES must be true. Add only path to image with image name (for example /images/mary.jpg).
$nicknames = array(
  'Mary Jennings' => 'Mary'
);

//client nicknames
define('USE_CLIENT_NICKNAMES', false); //set it to true if you want to use it
define('USE_CLIENT_IMG', false); //set it to true, if you like to use images instead of text. USE_CLIENT_NICKNAMES must be true. Add only path to image with image name (for example /images/mary.jpg).
$clientnicknames = array(
  'Chuck Darwin' => 'Chuck'
);

//category nicknames
define('USE_CAT_NICKNAMES', false); //set it to true if you want to use it
define('USE_CAT_IMG', false); //set it to true, if you like to use images instead of text. USE_CAT_NICKNAMES must be true. Add only path to image with image name (for example /images/mary.jpg).
$catnicknames = array(
  'Marketing' => '[M]'
);

//company nicknames
define('USE_COM_NICKNAMES', false); //set it to true if you want to use it
define('USE_COM_IMG', false); //set it to true, if you like to use images instead of text. USE_COM_NICKNAMES must be true. Add only path to image with image name (for example /images/mary.jpg).
$comnicknames = array(
  'Darwin Studios' => '(D)'
);

//show first row with headlines
define('SHOW_HEADLINE', false);
$headColor = ''; //headline text color

// show percent done in bars - you need to show percentDoneString in columns
define('SHOW_BARS', true); //set it to true if you want to use it

//Date format for dueDate - must be same as Daylites ouput - see http://php.net/manual/en/function.date.php
$dateFormat = "j. n. Y";

// shot for example 1 month, 2 days instead of 10.5.2013. You must have correct $dateFormat .
define('SHOW_TO_DATE', false); //set it to true if you want to use it

define('SHOW_WORK_DAYS', false); //set it to true if you want to show count of work days
$holidaysDateFormat = 'Y-m-d'; //date format for holidays - more at http://www.php.net/manual/en/datetime.formats.date.php
$holidays = array('2013-05-01');

/************************************************
 */


// load data from applescript and save to dayliteProjects.json
if(isset($_GET['load'])) {
  $handle = fopen('php://input','r');
  $jsonInput = fgets($handle);
  file_put_contents("dayliteProjects.json", $jsonInput , LOCK_EX);
} else {

  //or show table for status board
  table();

}


function table(){
  //load configs
  global $columns;
  global $categories;
  global $owners;
  global $clients;
  global $ex_categories;
  global $ex_owners;
  global $ex_clients;
  global $nicknames;
  global $clientnicknames;
  global $catnicknames;
  global $comnicknames;
  global $widthUnit;
  global $headColor;

	//load data from file
	$projects = json_decode( file_get_contents("dayliteProjects.json"), true );

	// order data by priority
	if(ORDER_BY_PRIORITY) {
  	if(!empty($projects)) {
  	  usort($projects, 'priority_sort');
    }
	}

	/*echo '<pre>';
	var_dump($projects);
  echo '</pre>';*/


  //load font awesome css font-face
  if(LOAD_AWESOME) {
    echo '<link href="//netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">';
  }

	?>
	<table id="projects">
		<?php

  	if(SHOW_HEADLINE) {
      echo '<tr style="background: none;">';

      if(!empty($headColor)) {
        $hcolor = 'color: '.$headColor.';';
      } else {
        $hcolor = '';
      }

      foreach ($columns as $name => $conf) {
        $width = $conf[0];

        if(SHOW_BARS && $name == "percentDoneString") {
          $name = "projectsBars";
        }

        if(!empty($width)) {
          $width = 'width: '.$conf[0].$widthUnit.';';
        }

        printf('<td class="%s" style="font-style: italic; background: none; text-transform: none; %s %s">%s</td>',$name , $width, $hcolor, $conf[3]);
      }

      echo '</tr>';
    }


		// test if data exist
		if( !empty($projects) ) {

  		//list all projects
  		foreach( $projects as $project => $data ) {

    		//filter by category
    		if(FILTER_BY_CATEGORY && !in_array($data['category'], $categories)) {
      		continue;
    		}

    		//filter by owner
    		if(FILTER_BY_OWNER && !in_array($data['owner'], $owners)) {
      		continue;
    		}

    		//filter by client
    		if(FILTER_BY_CLIENT && !in_array($data['client'], $clients)) {
      		continue;
    		}

    		//exclude category
    		if(EXCLUDE_CATEGORY && in_array($data['category'], $ex_categories)) {
      		continue;
    		}

    		//exclude owner
    		if(EXCLUDE_OWNER && in_array($data['owner'], $ex_owners)) {
      		continue;
    		}

    		//exclude client
    		if(EXCLUDE_CLIENT && in_array($data['client'], $ex_clients)) {
      		continue;
    		}

  		  //start row
  		  echo '<tr>';

  		  //show only selected properties
  		  foreach ($columns as $name => $conf) {

    		  //default values
    		  (!empty($data[$name])) ? $content = $data[$name] : $content = '';
  		    $width = $conf[0];
  		    $color = $conf[1];
  		    $align = $conf[2];

  		    //get proper output by type
    		  switch ($name) {
            case 'owner':
              if(USE_OWNER_NICKNAMES && array_key_exists($content, $nicknames)) {
                if(USE_OWNER_IMG) {
                  $content = '<img src="'.$nicknames[$content].'" />';
                } else {
                  $content = $nicknames[$content];
                }
              }
              break;
            case 'category':
              if(USE_CAT_NICKNAMES && array_key_exists($content, $catnicknames)) {
                if(USE_CAT_IMG) {
                  $content = '<img src="'.$catnicknames[$content].'" />';
                } else {
                  $content = $catnicknames[$content];
                }
              }
              break;
            case 'client':
              if(USE_CLIENT_NICKNAMES && array_key_exists($content, $clientnicknames)) {
                if(USE_CLIENT_IMG) {
                  $content = '<img src="'.$clientnicknames[$content].'" />';
                } else {
                  $content = $clientnicknames[$content];
                }
              }
              break;
            case 'company':
              if(USE_COM_NICKNAMES && array_key_exists($content, $comnicknames)) {
                if(USE_COM_IMG) {
                  $content = '<img src="'.$comnicknames[$content].'" />';
                } else {
                  $content = $comnicknames[$content];
                }
              }
              break;
            case 'percentDoneString':
              $content = round($content).'%';
              if(SHOW_BARS) {
                $name = "projectsBars";
                $percent = round($content);
                $content = "";

                for( $i = 1, $b = calc_bars($percent); $i <= $b; $i++ ) {
                  $content .= '<div class="barSegment value'.$i.'"></div>';
                }

              }
              break;
            case 'dueDate':
              if( !empty($data[$name]) && $due = get_date_content($data[$name]) ) {
                $content = $due[0];
                if( !empty($due[1]) ) { $color = $due[1]; }
              }
              break;
            default:

          }

          //color
          if(!empty($color)) {
            $color = 'color: '.$color.';';
          }

          //width
          if(!empty($width)) {
            $width = 'width: '.$width.$widthUnit.';';
          }

          //align
          if(!empty($align)) {
            $align = 'text-align: '.$align.';';
          }

          //print project column
          printf('<td class="%s" style="text-transform: none; %s %s %s">%s</td>',$name, $color, $align, $width ,$content);

  		  }

  		  //end row
  		  echo '</tr>';
  		}

		} else {
		?>
		  <tr><td>No projects.</td></tr>
		<?php } ?>
	</table>

	<?php
}

//date helper function
function get_date_content($date) {
  if(!empty($date)) {
    global $dateFormat;
    global $holidaysDateFormat;
    global $redDays;
    global $redColor;

    $due = DateTime::createFromFormat($dateFormat, $date);
    $curr = new DateTime();
    $diff = $due->diff($curr);

    $to = '';
    $years = $diff->format('%y');
    $months = $diff->format('%m');
    $days = $diff->format('%d');

    $color = "";
    if($years!=0){
      $to = $years.' year(s) '. $months.' month(s) '.$days.' day(s)';
    } else if($months != 0) {
      $to = $months.' month(s) '.$days.' day(s)';
    } else if($days != 0 ) {
      $to = $days.' day(s)';

      if(($redDays >= $days && $months == 0 && $years == 0 && $diff->invert) || !$diff->invert) {
        $color = $redColor;
      }

    } else {
      $to = 'today';
      $color = $redColor;
    }

    if(!$diff->invert && $days > 0) {
      $to .= ' ago';
    }

    if(SHOW_TO_DATE) {
      $output = $to;
    } else if(SHOW_WORK_DAYS) {
      $output = getWorkingDays($curr->format($holidaysDateFormat), $due->format($holidaysDateFormat));
    } else {
      $output = $date;
    }

    return array($output,$color);

  } else {
    return false;
  }
}

//helper function to sort by priority
function priority_sort($a, $b) {
  if(empty($a['priority'])) { $a['priority'] = 0; }
  if(empty($b['priority'])) { $b['priority'] = 0; }

  return ($b['priority'] > $a['priority']);
}

//helper function to get bars
function calc_bars($percent){
	$value = (int) str_replace('%', '', $percent) / 10;
	return round( ($value > 8 ? 8 : $value) * .8 );
}

//Source http://stackoverflow.com/questions/336127/calculate-business-days
//The function returns the no. of business days between two dates and it skips the holidays
function getWorkingDays($startDate,$endDate){
    global $holidays;
    // do strtotime calculations just once
    $endDate = strtotime($endDate);
    $startDate = strtotime($startDate);


    //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
    //We add one to inlude both dates in the interval.
    $days = ($endDate - $startDate) / 86400 + 1;

    $no_full_weeks = floor($days / 7);
    $no_remaining_days = fmod($days, 7);

    //It will return 1 if it's Monday,.. ,7 for Sunday
    $the_first_day_of_week = date("N", $startDate);
    $the_last_day_of_week = date("N", $endDate);

    //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
    //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
    if ($the_first_day_of_week <= $the_last_day_of_week) {
        if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
        if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
    }
    else {
        // (edit by Tokes to fix an edge case where the start day was a Sunday
        // and the end day was NOT a Saturday)

        // the day of the week for start is later than the day of the week for end
        if ($the_first_day_of_week == 7) {
            // if the start date is a Sunday, then we definitely subtract 1 day
            $no_remaining_days--;

            if ($the_last_day_of_week == 6) {
                // if the end date is a Saturday, then we subtract another day
                $no_remaining_days--;
            }
        }
        else {
            // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
            // so we skip an entire weekend and subtract 2 days
            $no_remaining_days -= 2;
        }
    }

    //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
   $workingDays = $no_full_weeks * 5;
    if ($no_remaining_days > 0 )
    {
      $workingDays += $no_remaining_days;
    }

    //We subtract the holidays
    foreach($holidays as $holiday){
        $time_stamp=strtotime($holiday);
        //If the holiday doesn't fall in weekend
        if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
            $workingDays--;
    }

    return $workingDays;
}

?>

