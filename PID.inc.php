<?php
function getpidinfo($pid, $ps_opt="aux"){ 

   $ps=shell_exec("ps ".$ps_opt."p ".$pid); 
   $ps=explode("\n", $ps); 
   
   if(count($ps)<2){ 
      trigger_error("PID ".$pid." doesn't exists", E_USER_WARNING); 
      return false; 
   } 

   foreach($ps as $key=>$val){ 
      $ps[$key]=explode(" ", ereg_replace(" +", " ", trim($ps[$key]))); 
   } 

   foreach($ps[0] as $key=>$val){ 
      $pidinfo[$val] = $ps[1][$key]; 
      unset($ps[1][$key]); 
   } 
   
   if(is_array($ps[1])){ 
      $pidinfo[$val].=" ".implode(" ", $ps[1]); 
   } 
   return $pidinfo; 
} 

    function returnPids($command) {
        exec("ps -C $command -o pid=",$pids);
        foreach ($pids as $key=>$value) $pids[$key]=trim($value);
        return $pids;
    }    

    /*
    Returns an array of the pids for processes that are like me, i.e. my program running
    */
    function returnMyPids() {
        return returnPids(basename($_SERVER["SCRIPT_NAME"]));
    }

function multiexplode ($delimiters,$string) {
    
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}
?>