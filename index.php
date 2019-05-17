<?php
$myfile = fopen("stats.json", "r") or die("Unable to open file!");
$json = fread($myfile,filesize("stats.json"));

function stats($fileValue){
    
    $grouped_array = [];
    $new_array = [];

    //grouping array by websideId and by dates
    foreach (json_decode($fileValue,true) as $key => $val) {
        $grouped_array[$val['websiteId']][$val['date']] = $val;
    }
    //getting average missed chats and average chats per day of each website
    foreach($grouped_array as $key => $ids){
        $missedChats = 0;
        $chats = 0;

        //counting chats of each websites per day
        foreach($ids as $dateKey => $dates){
            $missedChats += $dates['missedChats'];
            $chats += $dates['chats'];
        }

        $averageChats = $chats / sizeof($ids); 
        //filtering websites with average chats that are greater that 50
        if($averageChats > 50){
            $new_array[$key]['id'] = $key;  
            $new_array[$key]['averageMissedChats'] = $missedChats / sizeof($ids) ;
            $new_array[$key]['averageChats'] = $chats / sizeof($ids);
        }
    }
    //sorting average missed chats to decending order
    usort( $new_array, function( $a, $b ) {
        if( $a['averageMissedChats'] === $b['averageMissedChats'] ) {
            return 0;	
        }    
        return ( $a['averageMissedChats'] < $b['averageMissedChats'] ) ? 1 : -1;	 				
    });
    return $new_array;
}


print_r(stats($json));