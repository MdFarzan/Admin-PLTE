<?php 

/* 
    logout.php
    destroy session and removes auth token cookie
    
*/

require_once 'helpers/auth.php';

end_auth();
