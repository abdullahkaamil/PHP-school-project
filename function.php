<?php
function pagination($sql, $per_page = 10,$page = 1, $url = '?'){   
    $c = connect();
    $sql = "SELECT COUNT(*) as 'ono' FROM ogrenci  ";
    $row = mysqli_fetch_array(mysqli_query($c,$sql));
    $total = $row['ono'];
    $adjacents = "2"; 
    $page = ($page == 0 ? 1 : $page);  
    $start = ($page - 1) * $per_page;
    $prev = $page - 1;							
    $next = $page + 1;
    $lastpage = ceil($total/$per_page);
    $lpm1 = $lastpage - 1;
    $pagination = "";
$counter =1;
$first = ceil($per_page/$total);
   /* if($page != 1){
        // firstpage
        // previous
    }

    for($İ=(page-3), $i < page; $i++)
        // $i sayfa linki
    echo $page;
    for($İ=$page+1, $i < page+4; $i++)
        // $i sayfa linki

    if($page != $lastpage){
        // lastpage linki
        // next page linki
    }
*/
    if($lastpage > 1)
    {	  
        $pagination .= "<ul class='pagination'>";
      //  $pagination.= "<li><a class='dot' href='{$url}?page=$prev'> Preview </a></li>";
                $pagination .= "<li class='details' style='margin-top:2px'>Page $page of $lastpage</li>";
                if ($page > $counter){
                    $pagination.= "<li><a href='{$url}page=$first'>First</a></li>";
                    $pagination.= "<li><a href='{$url}page=$prev'>preview</a></li>";
                }else{
                    $pagination.= "<li><a class='current'>First</a></li>";
                    $pagination.= "<li><a class='current'>preview</a></li>";
                }
        if ($lastpage < $lastpage + ($adjacents * 2))
        {
            //for ($counter = 1; $counter <= $lastpage; $counter++)
            for ($counter = max($page -3,1); $counter <= min($lastpage,$page +3); $counter++)
            {
                if ($counter == $page)
                    $pagination.= "<li><a class='current'>$counter</a></li>";
                else
                    $pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";
            }
        }
        elseif($lastpage > 4 + ($adjacents * 2))
        {
            if($page < 1 + ($adjacents * 2))		
            {
                for ($counter = 1; $counter < 3 + ($adjacents * 2); $counter++)
                {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>$counter</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";
                }
                $pagination.= "<li class='dot'>...</li>";
                $pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
                $pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";
            }
            elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
            {
                $pagination.= "<li><a href='{$url}page=1'>1</a></li>";
                $pagination.= "<li><a href='{$url}page=2'>2</a></li>";
             $pagination.= "<li class='dot'>...</li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>$counter</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";
                }
                $pagination.= "<li class='dot'>..</li>";
                $pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
                $pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";
            }
            else
            {
                $pagination.= "<li><a href='{$url}page=1'>1</a></li>";
                $pagination.= "<li><a href='{$url}page=2'>2</a></li>";
                $pagination.= "<li class='dot'>..</li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>$counter</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";
                }
            }
        }
        if ($page < $counter - 1){
            $pagination.= "<li><a href='{$url}page=$next'>Next</a></li>";
            $pagination.= "<li><a href='{$url}page=$lastpage'>Last</a></li>";
        }else{
            $pagination.= "<li><a class='current'>Next</a></li>";
            $pagination.= "<li><a class='current'>Last</a></li>";
        }
        $pagination.= "</ul>\n";
    }
    return $pagination;
} 
?>