<?php
function echoConK($teg, $content, $k)
{
  for ($i = 1; $i <= $k; $i++) {
    echo "<$teg>$content</$teg>" . "<br>";
  }
}
