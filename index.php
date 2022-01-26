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

function mod($a, $b){ // manually created as % doesn't always work accurately
  return $a - $b * floor($a/$b);
}

function encode($input){
  global $a, $b, $m;
  $message_array = [];

  for ($i = 0; $i < strlen($input); $i++){
    // ord() converts ASCII character to a number
    $ex = (($a * (ord($input[$i])-32) + $b) % $m)+32;
    $message_array[] = chr($ex);
  }

  $scrambled_message = implode("",$message_array);
  return $scrambled_message;
}



function decode($input){
  global $b, $m, $a_inv;
  $message_array = [];

  for ($i = 0; $i < strlen($input); $i++){
    $dx = mod($a_inv*((ord($input[$i])-32) - $b), $m) + 32;
    $message_array[] = chr($dx);
  }
  $message = implode("",$message_array);
  return $message;
}

function introduction(){
  Echo "Hello and welcome to the Affine Cipher encryption service! Please select from one of the following options:\n\n";
  menu();
  }
  
function menu(){ // used when this ran in the terminal - leaving in here in case I want to refer back to it
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

?>

<!DOCTYPE html>
<html lang="en-GB">

<head>
  <title>Encryption Service</title>
  <link rel="stylesheet" href="normalize.css">
  <link rel="stylesheet" href="style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
  <link rel="shortcut icon" type="image/jpg" href="favicon.ico"/>
</head>

<body>
<header>

  <h1>Encryption Service</h1>
  <p>Hide your messages in plain site.</p>

</header>

<main>
  <section class="input-forms-section">
    <div class="input-forms-parent">
      <form method="post" action="#answer-section">
        <h2>Calculate required supplies</h2>
        <p>Instructions here</p>
        <div class="side-by-side-label-input">
          <label for="fence_length_input">Fence length (m):</label>
          <input type="number" id="fence_length_input" name="fence_length_input">
        </div>
        <input class="form-submit-button" type="submit" value="Calculate">
        <a href="index.php">Reset</a>
      </form>

      <form method="post" action="#answer-section">
        <h2>Calculate fence length</h2>
        <p>Instructions here</p>
        <div class="side-by-side-label-input">
          <label for="posts_available_input">Posts available:</label>
          <input type="number" id="posts_available_input" name="posts_available_input">
        </div>
        <div class="side-by-side-label-input">
          <label for="railings_available_input">Railings available:</label>
          <input type="number" id="railings_available_input" name="railings_available_input">
        </div>
        <input class="form-submit-button" type="submit" value="Calculate">
        <a href="index.php">Reset</a>
      </form>
    </div>
  </section>
  <section id="answer-section" class="answer-section">
    <p>
      <?php
      if (isset($_POST["fence_length_input"])) {
        echo "$_POST[fence_length_input]m of fence will require $posts_required posts and $railings_required railings.";
      }

      if (isset($_POST["posts_available_input"])) {
        echo "$_POST[posts_available_input] posts and $_POST[railings_available_input] railings can produce $returned_length"."m length of fencing.";
      }
      ?>
    </p>
  </section>
</main>

<footer>
  <div>
    <div class="footer-item">
      <a href="https://www.instagram.com/thehopefulhitchhikers/?hl=en" target="_blank">Instagram</a>
    </div>

    <div class="footer-item">
      <a href="https://www.linkedin.com/in/maxwellnewton/" target="_blank">LinkedIn</a>
    </div>

    <div class="footer-item">
      <a href="https://github.com/maxwell-01" target="_blank">GitHub</a>
    </div>
  </div>

</footer>

</body>

</html>
