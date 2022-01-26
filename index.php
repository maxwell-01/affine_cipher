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
*/

$a = 67;// must be coprime with $m
$b = 69; //arbitrary cipher key
$m = 96; //must be = to size of alphabet, see notes
$a_inv = 43; // calculate using gmp_invert($a, $m)
$shift = intval(32); // used to bring ASCII back in line - see notes

function mod($a, $b){ // manually created as % doesn't always work accurately
  return $a - $b * floor($a/$b);
}

function encode(string $input){
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

function decode(string $input){
  global $b, $m, $a_inv;
  $message_array = [];

  for ($i = 0; $i < strlen($input); $i++){
    $dx = mod($a_inv*((ord($input[$i])-32) - $b), $m) + 32;
    $message_array[] = chr($dx);
  }
  $message = implode("",$message_array);
  return $message;
}

if (isset($_POST["encryption_input"])) {
    $encryptedMessage = encode($_POST["encryption_input"]);
}

if (isset($_POST["decryption_input"])) {
    $decrypted_message = decode($_POST["decryption_input"]);
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
  <p>Hide your messages in a plain site.</p>

</header>

<main>
  <section class="input-forms-section" id="input-forms-section">
    <form method="post" action="#answer-section">
        <h2>Encryption</h2>
        <label for="encryption_input">Message to be encrypted:</label>
        <textarea id="encryption_input" name="encryption_input"></textarea>
        <input class="form-submit-button" type="submit" value="Encrypt">
    </form>

    <form method="post" action="#answer-section">
        <h2>Decryption</h2>
        <label for="decryption_input">Message to be decrypted:</label>
        <textarea id="decryption_input" name="decryption_input"></textarea>
        <input class="form-submit-button" type="submit" value="Decrypt">
    </form>
  </section>
  <section id="answer-section" class="answer-section">
      <h2>Output</h2>
    <p><?php
      if (isset($_POST["encryption_input"])) {
          echo $encryptedMessage;
      }
      if (isset($_POST["decryption_input"])) {
        echo $decrypted_message;
      }
      ?></p>
      <form method="post" action="#answer-section">
      <input type="submit" name="reset" value="Reset" class="form-submit-button">
      </form>
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
