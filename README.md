# StatsProgram
Provides average stats for websites on their average missed chats and average chats per day by using php code, iteration and sorting algorithm

### Reading the file
```php
$myfile = fopen("stats.json", "r") or die("Unable to open file!");
$json = fread($myfile,filesize("stats.json"));
```
This code represents the reading of the file names `stats.json` and adding it to a variable `$json` for later consumption.

### Grouping
```php
    //grouping array by websideId and by dates
    foreach (json_decode($fileValue,true) as $key => $val) {
        $grouped_array[$val['websiteId']][$val['date']] = $val;
    }
```
In this function I consumed the `$json` variable that contained the data read from the file earlier and Grouped them by `websiteId` and
`date` with a simple iteration on the values given by the `$json` variable.

### Counting Iteration
```php
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
 ```
 After grouping every website with their respective dates and other values I then summed up every chat and missed chat per day of every website
 and get their average and put then on a new array for better presentation later on when the code is used
 
 ### Sorting
 ```
     //sorting average missed chats to decending order
    usort( $new_array, function( $a, $b ) {
        if( $a['averageMissedChats'] === $b['averageMissedChats'] ) {
            return 0;	
        }    
        return ( $a['averageMissedChats'] < $b['averageMissedChats'] ) ? 1 : -1;	 				
    });
    return $new_array;
```
Lastly I used a usort to sort the multidimentional array to be able to sort the array by value of key `averageMissedChats` and sort them
in a descending manner.
