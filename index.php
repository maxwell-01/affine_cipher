<?php
/*

Notes
$m
  Only 32 -> 126 ASCII codes are readable characters
  Therefore size of alphabet is 126-32 = 96

  See https://www.man7.org/linux/man-pages/man7/ascii.7.html

  Use 96 as size of alphabet and add 32 to bring it back into ASCII readable range.
  

Affine Cipher used
E(x) = (ax + b) mod m
D(x) = a^-1 * (x - b) mod m


To Do:
substitute $shift instead of 32.

user call_user_func in the menu but this global function doesnt seem to exist on codecademy...
*/

$a = 67;// must be coprime with $m
$b = 69; //arbitrary cipher key
$m = 96; //must be = to size of alphabet, see notes
$a_inv = 43; // calculate using gmp_invert($a, $m)
$shift = intval(32); // used to bring ASCII back in line - see notes

function mod($a, $b){ // manually created as % doesn't always work
  return $a - $b * floor($a/$b);
}

function encode($input){
  echo "Loading encoding cipher...\n";
  global $a, $b, $m;
  $message_array = [];
  // checks if function was provided with an input or not
  if (!$input){
    $input = readline("Enter message to be encoded: \n");
  }
  for ($i = 0; $i < strlen($input); $i++){
    // ord() converts ASCII character to a number
    $ex = (($a * (ord($input[$i])-32) + $b) % $m)+32;
    
    // line below used for testing
    #echo $input[$i]." is ASCII decimal ".ord($input[$i])." => encoded => $ex => which is => '".chr($ex)."'\n";
    array_push($message_array, chr($ex));
  }

  $scrambled_message = implode("",$message_array);
  echo "Encoded output:\n".$scrambled_message."\n";
  #return $scrambled_message;
  menu();
}



function decode($input){
  echo "Loading decoding cipher...\n";
    if (!$input){
    $input = readline("Enter message to be decoded: \n");
  }
  global $b, $m, $a_inv;
  $message_array = [];
  for ($i = 0; $i < strlen($input); $i++){
    $dx = mod($a_inv*((ord($input[$i])-32) - $b), $m) + 32;
    // line below used for testing
    #echo $input[$i]. " is ASCII decimal ".ord($input[$i])." => decoded => $dx => which is => ".chr($dx)."\n"; // for testing 
    array_push($message_array, chr($dx));
  }
  $message = implode("",$message_array);
  echo "Decoded output:\n".$message."\n";
  #return $message;
  menu();
}


#encode(""); // run empty "" and type or paste message into console
#decode(""); // run empty "" and type or paste message into console


function introduction(){
  Echo "Hello and welcome to the Affine Cipher encryption service! Please select from one of the following options:\n\n";
  menu();
  }
  
function menu(){
  $menu_options = [
    1 => ["Encode a message" => "encode"],
    2 => ["Decode a message" => "decode"],
    3 => ["Quit and exit this program" => "quit"]
    ];
  foreach( $menu_options as $key => $options ) {
      foreach( $options as $message => $function){
        echo "$key = $message\n";
      }
  }
  echo "\nEnter a number from above and press enter.\n\n";
  $choice = readline(">>");

  while (!(in_array($menu_options[$choice], $menu_options))){
    echo "Please only a number from the menu.\n\n";
    $choice = readline(">>");
  }
    if ($choice == 1) {
      echo "\e[H\e[J";
      encode("");
  } elseif ($choice == 2){
    echo "\e[H\e[J";
    decode("");
    }
  }
 
introduction();
?>
