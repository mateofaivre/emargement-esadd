<?php
session_start();


if(isset($_SESSION['id']) && isset($_SESSION['user_name']))  {
    ?>
	
	<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="../../css/styles.css">
		<link rel="stylesheet" href="../../css/style-draw.css">
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
		<title>Signature | <?php echo $_SESSION['name'];?> </title>
		<style>
			.btn{
				width: 100px;
				color: #fff;
			}

			main{
				flex-direction: column;
			}

		</style>
	</head>
	
    <body>
	
	<main>
	
	<form  method="post" id="containerAll" action="draw-action.php" method=post>
			<h1>Bonjour, <?php echo $_SESSION['name'];?> <span>🦄</span></h1>
			<h2>C'est votre première connexion, nous avons besoin de votre signature :</h2>
		 		<canvas id="sig-canvas">
		 			Change de navigateur, vraiment, stp.
		 		</canvas>

				 <div id="containerBt">
					<button class="btn" id="sig-submitBtn" type='submit'>Valider</button>
					<button type="button" class="btn" id="sig-clearBtn">Effacer</button>
				</div>

				<div id="containerDatas">
					<textarea id="sig-dataUrl" name="sig-dataUrl">Url signature</textarea>
					<img id="sig-image" src="" alt="Your signature will go here!"/>
				</div>
		</form>
		<a href="logout-client.php">Se déconnecter</a>
	</main>
		
    <script src="../../js/draw.js"></script>
    </body>
	</html>
	
	<?php
}else{
    header("Location: ../../../index.php");
                exit();
}
?>