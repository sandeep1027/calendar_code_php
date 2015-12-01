<?php 
 
 class Ncal{
	 
	 //check for given year is leap year or not
	 function chckleap($year){
		$Leap=false;
		
		//if its divided by zero
		if ($year%4==0){
			
			// and not divided by 100 then its leap year
			if ($year%100!=0)
				$Leap=true;
		}else{
			
			//if its divided by 400 then its leap year
			if($year%400==0)
				$Leap=true;
		}	
		return $Leap; 
	 }
	 
	//calculate number of days in month by years
	 function DaysInMonth($m,$y)
	{
		switch ($m)
		{
			case 1:
			case 3:
			case 5:
			case 7:
			case 8:
			case 10:
			case 12: return 31;
			case 2: if ($this->chckleap($y))
						return 29;
					else
						return 28;
			default: return 30;
		}
	}
	
	//function will return number of days gap
	function FirstDayOfWeek($m,$y)
	{   
		$i;
		//January 1, 1583, was a Saturday, so we will start with 6. 
		
		$dow = 6;
		for($i=1583; $i<$y; $i++){
			$dow++;
			if ($this->chckleap($i))
				$dow++;
		}
		
		//Now all we do is advance dow to the first day of the current month by adding in the days in the months prior to the current month (m): 	
		for ($i=1; $i<$m; $i++)
			$dow += $this->DaysInMonth($i,$y);
		
		return $dow%7;
	}
	
	function getnamebymonth($m){
		switch ($m)
		{
			case 1:
			      return "January";
			     break;
			case 2:
			      return "February";
				break;	 
			case 3:
			      return "March";
				break;
			case 4:
			      return "April";
				break;	
			case 5:
			     return "May";
				break;
			case 6:
			     return "June";
				break;	
			case 7:
				 return "July";
				break;
			case 8:
			     return "August";
				break;
			case 9:
			     return "September";
				break;	
			case 10:
				return "October";
				break;
			case 11:
				return "November";
			   break;
			case 12:
				return "December";
			   break; 
		}
	}
}
//object of class
$db_cal=new Ncal();

//total numbers of calender to print
$total=4;

//Get given dates and months
if(isset($_GET['m']) && isset($_GET['y'])){
	$m=$db->real_escape($_GET['m']);
	$y=$db->real_escape($_GET['y']);
}else{
	$m=date("m");
	$y=date("y");
}

$m2=$m1=$m;
$y2=$y1=$y;

?>
<!-- Custom Theme files -->
<link  rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" href="css/clndr.css" type="text/css" />
<table>
   <tr>	
	<?php
              for($j=1;$j<=$total;$j++){
				  //start days with 1
					$fday=1;
			?>
		<td>	
		<div class="calnder">
		
			<div class="column_right_grid calender">
			
				<div class="cal1">
					<div class="clndr">
						<div class="clndr-controls">
							<div class="month"><?php echo $db_cal->getnamebymonth($m)." ".$y; ?> </div>
						</div>
						
						<table class="clndr-table">
							<thead>
								<tr class="header-days">
									<td class="header-day">MON</td>
									<td class="header-day">TUE</td>
									<td class="header-day">WED</td>
									<td class="header-day">THU</td>
									<td class="header-day">FRI</td>
									<td class="header-day">SAT</td>
									<td class="header-day">SUN</td>
								</tr>
							</thead>
							<tbody>
								<?php 
								 //get number of days 
									$no_days=$db_cal->DaysInMonth($m,$y);
									
								//find the first week gaps
								$start_day=$db_cal->FirstDayOfWeek($m,$y);
								
								?>
								<tr>
								<?php //main code loop no of days + first week gap ex. $no_days=30,start_day=5 30+5
								for($i=0;$i<=$no_days+$start_day;$i++){
									
                                   if($i<=$start_day){ ?>
									<td class="day past adjacent-month last-month"><div class="day-contents"></div></td>
							<?php	}else{
								  if($i%7==0){
										echo "</tr><tr>";
									}
								?> 
								<td class="day past event calendar-day-<?php echo $y."-".$m."-".$fday; ?>"><div class="day-contents"><?php echo $fday; ?></div></td>
							<?php 
								$fday++;
								} 
							}
							//if month is greater then 13 then rest the month n increase year 
							if($m%12==0){
								$m=1;
								$y++;
							}else{
								$m++;	
							}
						?>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			
			</div>
			 
		</div>
		</td>
		<?php 
		    if($j%2==0){
				echo "</tr><tr>";
			}
		?>
		 <?php }
			//for previous months
				for($i=0;$i<$total;$i++){
					$m2--;
					if($m2==0){
						$m2=12;
						 $y2--;
					}
				}	
			?>
		 </tr>
		 </table>
		 <center>
 <table>
    <tr align="center">
	  <td><img style="cursor:pointer" onclick="calender('<?php echo $m2; ?>','<?php echo $y2; ?>')" src="cal/prev.png" /></td>
	  <td><img style="cursor:pointer" onclick="calender('<?php echo $m; ?>','<?php echo $y; ?>')" src="cal/next.png" /></td>
	</tr>
	</table>
	</center>