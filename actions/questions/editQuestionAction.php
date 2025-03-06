<?php

require('actions/database.php');

if (isset($_GET['id']) && !empty($_GET['id']))  {

}
else{
    $errorMsg = "Aucune question n'a été trouvé";
}