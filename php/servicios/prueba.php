<?php
$clave = "123";
$clave = crypt($clave, '$2a$07$yMoJrJpwEPrmVnZx4KIyNuOAiOMQksjkV1EW0YRgVe33eYe/yT60y');
echo $clave;