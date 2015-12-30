<?php
if (array_key_exists('page', $_REQUEST)){
    $page = $_REQUEST['page'];
} else{
    $page = 1;
}
?>
<a href='?page=<?php echo ($page-1);?>'><button>Previous page</button></a>
<a href='?page=<?php echo ($page+1);?>'><button>Next page</button></a>
