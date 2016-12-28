<?php
// iniciar request parameters si se llama desde la CLI
if (php_sapi_name() === 'cli') {
  parse_str(implode('&', array_slice($argv, 1)), $_REQUEST);
}
?>