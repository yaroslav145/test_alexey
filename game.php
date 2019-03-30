<?php
	$name = $_GET['name'];

	$global_session_id = 9;
	
	//$mysession = session_id();
	session_id($global_session_id);
	session_start();
	$temp_session = $_SESSION;
	session_write_close();

	//print_r($_GET);
		
	$step = 30;
	$yaw = 0;
		
	if(!isset($temp_session[$name]))
	{
		$temp_session[$name] = array(
			'yaw' => 0,
		
			0 => array(
				'x' => 30 * 7,
				'y' => 30 * 4,
			),
		);
		
		$temp_session['ball'] = array(
			'x' => 30 * 3,
			'y' => 30 * 2,
		);
	}
	
	$ball = $temp_session['ball'];
	$player = $temp_session[$name];
	
	
	if(isset($_GET['0']))
		$player['yaw'] = 0;
		
	if(isset($_GET['1']))
		$player['yaw'] = 1;
	
	if(isset($_GET['2']))
		$player['yaw'] = 2;
	
	if(isset($_GET['3']))
		$player['yaw'] = 3;
	
	//print_r($ball);
	//print_r($player);
	
	if(($ball['x'] == $player[0]['x']) && ($ball['y'] == $player[0]['y']))
	{
		$ball['x'] = rand(0, 1600/$step) * $step;
		$ball['y'] = rand(0, 700/$step) * $step;
		
		$temp['x'] = $player[0]['x'];
		$temp['y'] = $player[0]['y'];
		$player[] = $temp;
	}
	
	$prev = $player[0];
	
	if($player['yaw'] == 0)
		$player[0]['y'] -= $step;
		
	if($player['yaw'] == 1)
		$player[0]['x'] -= $step;
	
	if($player['yaw'] == 2)
		$player[0]['x'] += $step;
	
	if($player['yaw'] == 3)
		$player[0]['y'] += $step;
	
	foreach($player as $key => $val)
	{
		if(($key != 0) && ($key != 'yaw'))
		{
			$temp = $player[$key];
			$player[$key] = $prev;
			$prev = $temp;
		}
	}

	
	$temp_session['ball'] = $ball;
	$temp_session[$name] = $player;


	echo '<form name="w">
		<input type="hidden" name="0">
		<input type="hidden" name="name" value='.$name.'>
	</form>

	<form name="a">
		<input type="hidden" name="1">
		<input type="hidden" name="name" value='.$name.'>
	</form>

	<form name="d">
		<input type="hidden" name="2">
		<input type="hidden" name="name" value='.$name.'>
	</form>

	<form name="s">
		<input type="hidden" name="3">
		<input type="hidden" name="name" value='.$name.'>
	</form>';
	

	function drawRect($x, $y, $step, $color)
	{
		$w = $step;
		$h = $step;
		
		echo '<rect fill="rgb(255,'.$color.','.$color.')" width="'.$w.'" height="'.$h.'" x="'.($x - $w/2).'" y="'.($y - $h/2).'"/>';
	}
?>


<svg width="98vw" height="98vh" style="border:2px solid black; background-color: pink">
	<?php
		
		foreach($temp_session as $players_ex)
		{
			if($players_ex == 'ball')
				continue;
			
			$color = 0;
			$color_step = 255 / (count($players_ex) - 1);
			
			foreach($players_ex as $val)
				if(isset($val['y']))
				{
					$color += $color_step;
					drawRect($val['x'], $val['y'], $step, $color);
				}
		}
		
		echo '<circle r='.($step*0.35).'px cx="'.$ball['x'].'" cy="'.$ball['y'].'" fill="blue">';
	?>
</svg>


<script>
	document.onkeydown = function checkKeycode(event)
	{
		var keycode;
		keycode = event.which;
		
		//alert(keycode);
		
		if(keycode == 38)
			w.submit();
		
		if(keycode == 37)
			a.submit();
		
		if(keycode == 39)
			d.submit();
		
		if(keycode == 40)
			s.submit();
	}
</script>

<?php
	//session_id($mysession);
	//session_start();
	
	session_id($global_session_id);
	session_start();
	$_SESSION = $temp_session;

	header('Refresh: 0.1; url=game.php?name='.$name);
?>


