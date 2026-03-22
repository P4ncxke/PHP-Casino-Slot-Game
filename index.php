<html>
<header>
	<title>Matt's Casino</title>
    <script>
        function changeHitOnHover() {
            const img = document.getElementById('buttonHit');
            img.src = '/matt/PHP-Casino-Slot-Game/images/button_hit_hovering.jpg';
        }
        function changeHitReset() {
            const img = document.getElementById('buttonHit');
            img.src = '/matt/PHP-Casino-Slot-Game/images/button_hit.jpg';
        }
        function changeCashoutOnHover() {
            const img = document.getElementById('buttonCashout');
            img.src = '/matt/PHP-Casino-Slot-Game/images/button_cashout_hovering.jpg';
        }
        function changeCashoutReset() {
            const img = document.getElementById('buttonCashout');
            img.src = '/matt/PHP-Casino-Slot-Game/images/button_cashout.jpg';
        }
        function changeHitOnClick() {
            const img = document.getElementById('buttonHit');
            img.src = '/matt/PHP-Casino-Slot-Game/images/button_hit_clicked.jpg';
			usleep(500000);
        }
        function changeCashoutOnClick() {
            const img = document.getElementById('buttonCashout');
            img.src = '/matt/PHP-Casino-Slot-Game/images/button_cashout_clicked.jpg';
			usleep(500000);
        }		
    </script>
</header>
<body>

<!-- Banner is always here, so it is a static HTML -->
<p align="center">
<img src="/matt/PHP-Casino-Slot-Game/images/banner.png" width="600" height="269">
</p>



<?php

#var_dump($_GET);

// Let's make a check if username is provided. If it is, then we display slots and buttons.
if (!array_key_exists('username', $_GET)) {
	
	// Username not provided, asking for username.
	
	echo <<<MARK
	<p align="center">Enter your name:</p>

	<div align="center">
	<form action="index.php" method="GET">
		<input type="text" name="username" maxlength="20">
		<input type="submit" value="Enter">
	</form>
	</div>
	
	<p align="center">
	<img src="/matt/PHP-Casino-Slot-Game/images/scoreboard.png" width=600 height=600/>
	</p>
MARK;
}
else {
	
	// Username provided, displaying slots game.
	
	$user = $_GET['username'];
	
	// Let's check if a button was pressed on the previous screen.
	if (!array_key_exists('button', $_GET)) {
		
		// Button not pressed, it is start of the game.
		
		echo('<h1 align="center">Welcome ' . $user . ', wanna play?</h1>');
		echo <<<MARK
		<p align="center">
		<!-- SLOTS AT START 777 --->
		<img src="/matt/PHP-Casino-Slot-Game/images/slots_seven.jpg" width=200 height=300/>
		<img src="/matt/PHP-Casino-Slot-Game/images/slots_seven.jpg" width=200 height=300/>
		<img src="/matt/PHP-Casino-Slot-Game/images/slots_seven.jpg" width=200 height=300/>
		</p>
		
		<div align=center>
		<!-- HIT BUTTON --->
		<form action="index.php" method="GET">
			<input type="hidden" name="button" value="hit">
			<input type="hidden" name="points" value="0">
MARK;
		
		echo('<input type="hidden" name="username" value="' . $user . '">');
			
		echo <<<MARK
			<input type="image" src="/matt/PHP-Casino-Slot-Game/images/button_hit.jpg" alt="HIT" width=300 height=150/>
		</form>
		</div>
MARK;
	}
	else {
		
		// Button was pressed, let proceed accoringly: hit or cashout
		
		$button = $_GET['button']; 
		
		// Get current points value
		
		$points = $_GET['points'];
		
		// Let's act accrdingly:
		
		// HIT BUTTON WAS PRESSED
		if ($button == 'hit') {
			
			$images = array(
				"/matt/PHP-Casino-Slot-Game/images/slots_bananas.jpg",		// 0
				"/matt/PHP-Casino-Slot-Game/images/slots_grapes.jpg",		// 1
				"/matt/PHP-Casino-Slot-Game/images/slots_coins.jpg",		// 2
				"/matt/PHP-Casino-Slot-Game/images/slots_horse.jpg",		// 3
				"/matt/PHP-Casino-Slot-Game/images/slots_lucky_charm.jpg",	// 4
				"/matt/PHP-Casino-Slot-Game/images/slots_bar.jpg",			// 5 
				"/matt/PHP-Casino-Slot-Game/images/slots_dice.jpg",			// 6
				"/matt/PHP-Casino-Slot-Game/images/slots_cards.jpg",		// 7
				"/matt/PHP-Casino-Slot-Game/images/slots_seven.jpg"			// 8
			);

		
			// Let's choose 3 random slots.
			$wheels = array(-1, -1, -1);
			for ($i = 0; $i < 3; $i++) {
				$wheels[$i] = rand(0, 8);
			}
			
			// Slot enforcer
			// $wheels[0] = 0;
			// $wheels[1] = 0;
			// $wheels[2] = 0;
			
			$win = false;
			$jackpot = false;
			$bomb = false;
			for ($i = 0; $i < 9; $i++) {
								
				// Checking if two the same
				$howmany = 0;
				for ($q = 0; $q < 3; $q++) {
					if ($wheels[$q] == $i) {
						++$howmany;
					}
				}
				if ($howmany == 2) {
					// Two the same
					$points += 2;
					$win = true;
				}
				if ($howmany == 3) {
					// Three the same
					$win = true;
					// $bomb = false;
					// $jackpot = false;
					if ($i == 0) {
						// BOMB!
						$points = 0;
						$bomb = true;
					}
					elseif ($i == 8) {
						// JACKPOT three 777!
						$points *= 2;
						$jackpot = true;
					}
					else {
						// All other same three
						$points +=10;
					}
				}
			}
			
			echo('<h1 align="center">' . $user . '</h1>');
			echo('<h2 align="center">' . $points . 'points</h2>');
			echo <<<MARK
			<p align="center">
			<!-- SLOT IMAGES --->
MARK;

			// Display final slots, after lottery
			for ($i = 0; $i < 3; $i++) {
				$q = $wheels[$i];
				echo '<img src="' . $images[$q] . '" width=200 height=300/>';
			}

			echo <<<MARK
			</p>
			
			<div align=center>
MARK;

			if ($win && ($jackpot || $bomb)) {
				if ($jackpot) {
					echo '<h2 color="red">JACKPOT - double points!</h2>';
				}
				elseif ($bomb) {
					echo '<h2 color="red">BANANA - zero points!</h2>';
				}
				else {
					echo '<h2>Hit +10 points</h2>';
				}
			}
			elseif ($win && (!$jackpot && !$bomb)) {
				echo "<h2>Hit +2 point up</h2>";
			}
			else {
					echo '<h2 color="gray">No win</h2>';
			}
				
				
			echo <<<MARK
			<!-- HIT BUTTON --->
			<form action="index.php" method="GET">
				<input type="hidden" name="button" value="hit">
MARK;
			
			echo('<input type="hidden" name="points" value="' . $points . '">');
			echo('<input type="hidden" name="username" value="' . $user . '">');
				
			echo <<<MARK
				<input type="image" src="/matt/PHP-Casino-Slot-Game/images/button_hit.jpg" alt="HIT" width=300 height=150
				id="buttonHit" onmouseover="changeHitOnHover()" onmouseleave="changeHitReset()" onmousedown="changeHitOnClick()">
			</form>
			<!-- CASHOUT BUTTON --->
			<form action="index.php" method="GET">
				<input type="hidden" name="button" value="cashout">
MARK;

			echo('<input type="hidden" name="username" value="' . $user . '">');
			
			echo <<<MARK
				<input type="image" src="/matt/PHP-Casino-Slot-Game/images/button_cashout.jpg" alt="CASHOUT" width=300 height=150
				id="buttonCashout" onmouseover="changeCashoutOnHover()" onmouseleave="changeCashoutReset()" onmousedown="changeCashoutOnClick()">
			</form>
			</div>
MARK;

		}
		
		// CASHOUT BUTTON WAS PRESSED
		elseif ($button == 'cashout') {
			
			echo('<h1 align="center">Congratulations ' . $user . '! You scored' . $points . ' points!</h1>');
			
			echo <<<MARK
			<p align="center">
			<img src="/matt/PHP-Casino-Slot-Game/images/Cashout.png" width=600 height=600/>
			</p>
MARK;		
		}
		
		
		// EMERGENCY CATCH
		else {
			echo('<h1 align="center">You nasty bukeroo. Police and Government have been notified! Prepare for long jail time soon, bukeroo!</h1>');
		}
		
		
	}

}

?>


</body>
</html>
