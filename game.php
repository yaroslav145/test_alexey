<?php
	session_start();

	//print_r($_GET);
		
	$step = 10;
	$yaw = 0;
		
	if(!isset($_SESSION['player']))
	{
		$_SESSION['player'] = array(
			'yaw' => 0,
		
			0 => array(
				'x' => 100,
				'y' => 100,
			),
		);
		
		$_SESSION['ball'] = array(
			'x' => 200,
			'y' => 300,
		);
	}
	
	$ball = $_SESSION['ball'];
	$player = $_SESSION['player'];
	
	
	if(isset($_GET['0']))
		$player['yaw'] = 0;
		
	if(isset($_GET['1']))
		$player['yaw'] = 1;
	
	if(isset($_GET['2']))
		$player['yaw'] = 2;
	
	if(isset($_GET['3']))
		$player['yaw'] = 3;
	
	print_r($ball);
	print_r($player);
	
	if(($ball['x'] == $player[0]['x']) && ($ball['y'] == $player[0]['y']))
	{
		$ball['x'] = rand(1, 25) * $step;
		$ball['y'] = rand(1, 25) * $step;
		
		$temp['x'] = $player[0]['x'];
		$temp['y'] = $player[0]['y'];
		$player[] = $temp;
	}
	
	
	if($player['yaw'] == 0)
		$player[0]['y'] -= $step;
		
	if($player['yaw'] == 1)
		$player[0]['x'] -= $step;
	
	if($player['yaw'] == 2)
		$player[0]['x'] += $step;
	
	if($player['yaw'] == 3)
		$player[0]['y'] += $step;
?>


<form name="w">
	<input type="hidden" name="0">
</form>

<form name="a">
	<input type="hidden" name="1">
</form>

<form name="d">
	<input type="hidden" name="2">
</form>

<form name="s">
	<input type="hidden" name="3">
</form>

<?php
	function drawRect($x, $y)
	{
		$w = 25;
		$h = 25;
		
		echo '<rect fill="red" width="'.$w.'" height="'.$h.'" x="'.($x - $w/2).'" y="'.($y - $h/2).'"/>';
	}
?>


<svg width="98%" height="700px" style="border:2px solid black; background-color: pink">
	<?php
		foreach($player as $val)
			drawRect($val['x'], $val['y']);
			
		echo '<circle r=10px cx="'.$ball['x'].'" cy="'.$ball['y'].'" fill="blue">';
	?>
</svg>


<script>
	document.onkeydown = function checkKeycode(event)
	{
		var keycode;
		keycode = event.which;
		
		//alert(keycode);
		
		if(keycode == 38)
			w.submit()
		
		if(keycode == 37)
			a.submit()
		
		if(keycode == 39)
			d.submit()
		
		if(keycode == 40)
			s.submit()
	}
</script>

<?php
	$_SESSION['ball'] = $ball;
	$_SESSION['player'] = $player;

	header('Refresh: 0.1; url=game.php');
?>