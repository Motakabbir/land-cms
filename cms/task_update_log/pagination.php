<?php
 $limit = 100;
 $adjacent = 3;

function pagination($limit,$adjacents,$rows,$page){	
	$pagination='';
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$prev_='';
	$first='';
	$lastpage = ceil($rows/$limit);	
	$next_='';
	$last='';
	if($lastpage > 1)
	{	
		
		//previous button
		if ($page > 1) 
			$prev_.= "<li> <a href=\"javascript:void(0)\" onClick=\"sendData($prev)\" aria-label=\"Previous\"><i class=\"fa fa-angle-left\" aria-hidden=\"true\"></i></a></li>";
		else{
			//$pagination.= "<span class=\"disabled\">previous</span>";	
			}
		
		//pages	
		if ($lastpage < 5 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
		$first= "";
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li class='active'><a onClick=\"sendData($counter)\" href=\"javascript:void(0)\" >$counter</a></li>";
				else
					//$pagination.= "<a class='page-numbers' href=\"?page=$counter\">$counter</a>";
					$pagination.= "<li><a onClick=\"sendData($counter)\" href=\"javascript:void(0)\">$counter</a></li>";					
			}
			$last='';
		}
		elseif($lastpage > 3 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			$first.= "<li > <a href=\"javascript:void(0)\" onClick=\"sendData(1)\" aria-label=\"Previous\"><span aria-hidden=\"true\">&laquo;</span></a></li>";
			
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class='active'><a onClick=\"sendData($counter)\" href=\"javascript:void(0)\" >$counter</a></li>";
					else
						$pagination.= "<li><a onClick=\"sendData($counter)\" href=\"javascript:void(0)\">$counter</a></li>";					
				}
			$last.= "<li><a href=\"javascript:void(0)\" onClick=\"sendData($lastpage)\" aria-label=\"Next\"><span aria-hidden=\"true\">&raquo;</span></a></li>";			
			}
			
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
		     //  $first.= "<li> <a href=\"javascript:void(0)\" onClick=\"sendData(1)\" aria-label=\"Previous\"><span aria-hidden=\"true\">&laquo;</span></a></li>";	
			for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class='active'><a onClick=\"sendData($counter)\" href=\"javascript:void(0)\" >$counter</a></li>";
					else
						$pagination.= "<li><a onClick=\"sendData($counter)\" href=\"javascript:void(0)\">$counter</a></li>";					
				}
				$last.= "<li><a href=\"javascript:void(0)\" onClick=\"sendData($lastpage)\" aria-label=\"Next\"><span aria-hidden=\"true\">&raquo;</span></a></li>";				
			}
			//close to end; only hide early pages
			else
			{
			 //  $first.="<li> <a href=\"javascript:void(0)\" onClick=\"sendData(1)\" aria-label=\"Previous\"><span aria-hidden=\"true\">&laquo;</span></a></li>";	
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class='active'><a onClick=\"sendData($counter)\" href=\"javascript:void(0)\" >$counter</a></li>";
					else
						//$pagination.= "<a class='page-numbers' href=\"?page=$counter\">$counter</a>";
						$pagination.= "<li><a onClick=\"sendData($counter)\" href=\"javascript:void(0)\">$counter</a></li>";					
				}
				$last='';
			}
            
			}
		if ($page < $counter - 1) 
		
			$next_.= "<li><a href=\"javascript:void(0)\" onClick=\"sendData($next)\" aria-label=\"Next\"><i class=\"fa fa-angle-right\" aria-hidden=\"true\"></i></a></li>";	
		else{
			//$pagination.= "<span class=\"disabled\">next</span>";
			}
		$pagination = "<ul class=\"pagination\">".$first.$prev_.$pagination.$next_.$last;
		//next button
		
		$pagination.= "</ul>\n";		
	}

	echo $pagination;  
}
?>