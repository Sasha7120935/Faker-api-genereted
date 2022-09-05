<?php require_once 'function.php'; ?>
<?php require_once 'form.html'; ?>
<?php

    if ( $data_type = $_POST['data_type'] === 'Select' ) {
        echo '<p>Select All Fields</p>';
    } else {
       get_file();
    }

