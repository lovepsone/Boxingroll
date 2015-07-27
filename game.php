<?php
	define("GAME_PAGE", true);
	require_once 'maincore.php';
	require_once THEMES.'header.php';
	HeadMenu();
	echo '<script>';
?>
	// начальные настройки и переменные
	var camera, scene, renderer, clock, raycaster;
	var SCREEN_WIDTH = window.innerWidth - 300, SCREEN_HEIGHT = 550;
	// переменные управления кликами мыши
	var mouse, mouseX, mouseY, MoseClick = true, MoseClickReturn = false, addRondValue = true;
	var meshKeyInput, meshKopeck;
	
	var InputKey = -1, RandValue = 0, UserGame;
	// переменные анимации
	var animCameraStart = false, animCameraReturn = false, animTimerCamera = 0.00;
	var animKeyStart = false, animKeyRotateInput = false, animOpenChest = false, animKopeckStart = false;
	// источник света
	var pointLight;
	
	var locLoadGame = '<span id="game-msg-loader" style="font-size:23px;position:absolute; left:' + (SCREEN_WIDTH/2) + 'px; top:' + (180 + SCREEN_HEIGHT/2) + 'px;">Loading...</span>';
	var style = 'position:relative;top:18px;height:64px;width:64px;background-size: 100% 100%;cursor:pointer;background-color:#0F3649; border:1px;border-radius:3px;'
	var panel = '<div style="height:100px;width:500px;background:url(game/panel-game.png);position:absolute;top:'+(80+SCREEN_HEIGHT)+'px;left:'+(SCREEN_WIDTH/2 - 250)+'px;">'
		+'<input type="submit" id="key1" name="key1" value="" style="'+style+'background-image: url(game/keys/i_keyNormal.png);right:24px;"/>'
		+'<input type="submit" id="key2" name="key2" value="" style="'+style+'background-image: url(game/keys/i_keyGold.png);right:8px;"/>'
		+'<input type="submit" id="key3" name="key3" value="" style="'+style+'background-image: url(game/keys/i_keyPlatinum.png);left:8px;"/>'
		+'<input type="submit" id="key4" name="key4" value="" style="'+style+'background-image: url(game/keys/i_keyPremium.png);left:24px;"/>'
		+'</div>';
		
	var locGameStart = '<span id="game-msg" style="position:absolute; left:' + (SCREEN_WIDTH/2 - 250) + 'px;top:'+(55+SCREEN_HEIGHT)+'px;"><?php echo $locale['GameStart']; ?></span>';
	
	function getCountKey()
	{
		$.ajax({type: "POST",url: "include/handle.Game.php",data: {'data': 'getCountKey:0'},success: function(DataUser){UserGame = JSON.parse(DataUser);}});
	}
<?php	
	echo '</script><script src="include/js/three.min.js"></script>';

	//echo '<script src="include/js/renderers/Projector.js"></script>';
	//echo '<script src="include/js/renderers/CanvasRenderer.js"></script>';

	echo '<script src="include/js/libs/tween.min.js"></script>';
	echo '<script src="include/js/fonts/helvetiker_regular.typeface.js"></script>';
	echo '<script src="include/js/ShaderParticles.min.js"></script>';

	echo '<script src="include/js/shaders/CopyShader.js"></script>';
	echo '<script src="include/js/shaders/FXAAShader.js"></script>';
	echo '<script src="include/js/postprocessing/EffectComposer.js"></script>';
	echo '<script src="include/js/postprocessing/RenderPass.js"></script>';
	echo '<script src="include/js/postprocessing/ShaderPass.js"></script>';
	echo '<script src="include/js/postprocessing/MaskPass.js"></script>';

	echo '<script src="game/LoaderScene.js"></script>';
	
	openbox();
	echo '<tr><td><div id="BoxingRollGame" align="center"></div><script>';
?>
	GameUpdateUser();
	init();
        setTimeout(animate, 0);
	
	$(window).load(function(){ LOADERSCENE.Initialize(); });

	var id2 = setInterval(function()
	{
		if (initStart)
		{
			LOADERSCENE.getProgress();
		}
		else if (InitEnd)
		{
			clearInterval(id2);
		}
	}, 1);

	function init()
	{
		renderer = new THREE.WebGLRenderer();
		renderer.setClearColor(0x010e16);
		renderer.setPixelRatio(window.devicePixelRatio);
		renderer.setSize(SCREEN_WIDTH, SCREEN_HEIGHT);
		renderer.shadowMapEnabled = true;
		$("#BoxingRollGame").append(renderer.domElement);

		camera = new THREE.PerspectiveCamera(50, renderer.domElement.offsetWidth / renderer.domElement.offsetHeight, 1, 70);
		camera.position.z = 36;//24
		camera.position.y = 22;//12

		scene = new THREE.Scene();
		//scene.fog = new THREE.Fog(0x838b83, 0.115, 900);
		raycaster = new THREE.Raycaster();
		mouse = new THREE.Vector2();
		clock = new THREE.Clock();

		initLight();

		document.addEventListener('mousedown', onDocumentMouseDown, false);
		document.addEventListener('mousemove', onDocumentMouseMove, false);
		document.addEventListener('touchstart', onDocumentTouchStart, false);
		window.addEventListener('resize', onWindowResize, false );
	}

	function initLight()
	{
		var ambient = new THREE.AmbientLight(0x101010);
		scene.add(ambient);

		pointLight = new THREE.PointLight(0x696969, 3, 700);
		scene.add(pointLight);
	}

	function getTypeKey(name_key)
	{
		var type_key = 0;
		switch (name_key)
		{
		  case "key1":
		    type_key = 0;
		    break;
		  case "key2":
		    type_key = 1;
		    break;
		  case "key3":
		    type_key = 2;
		    break;
		  case "key4":
		    type_key = 3;
		    break;
		}
		return type_key;
	}

	function getRoundValue()
	{
		$.ajax(
		{
			type: "POST",
			url: "include/handle.Game.php",
			data: {'data': 'RoundValueOpenChest:0'},
			success: function(Value)
			{
				RandValue = Value;
				DBH_AddRoundValue(InputKey + ',' + RandValue);
			}
		});
	}

	function onWindowResize()
	{
		SCREEN_WIDTH = renderer.domElement.offsetWidth;
		SCREEN_HEIGHT = renderer.domElement.offsetHeight;
		renderer.setSize(SCREEN_WIDTH, SCREEN_HEIGHT);

		camera.aspect = SCREEN_WIDTH / SCREEN_HEIGHT;
		camera.updateProjectionMatrix();
	}

	function onDocumentTouchStart(event)
	{
		event.preventDefault();
		event.clientX = event.touches[0].clientX;
		event.clientY = event.touches[0].clientY;
		onDocumentMouseDown(event);
	}

	function onDocumentMouseDown(event)
	{
		event.preventDefault();
		var bcr = $("#BoxingRollGame").get(0).getBoundingClientRect();
		mouseX = (event.clientX - bcr.left) / renderer.domElement.offsetWidth * 2 - 1;
		mouseY = 1 - (event.clientY - bcr.top) / renderer.domElement.offsetHeight * 2;
		if (MoseClick && (event.path[0].name == 'key1' || event.path[0].name == 'key2' || event.path[0].name == 'key3' || event.path[0].name == 'key4'))
		{
			InputKey = getTypeKey(event.path[0].name);
			if (UserGame[InputKey] <= 0) return;
			DBH_AddOpenChest();
			DBH_DeleteKey(InputKey);
			DBH_UpdateIncome(InputKey);
			meshKeyInput = objects.keys[InputKey];

			new TWEEN.Tween(meshKeyInput.rotation).to({x: 0, y: 0, z: 0}, 2000).easing(TWEEN.Easing.Elastic.Out).start();
			new TWEEN.Tween(meshKeyInput.position).to({x: 0, y: 5.9, z: 15}, 2000 ).easing(TWEEN.Easing.Elastic.Out).start();
			animCameraStart = true;
			MoseClick = false;
			animKeyStart = true;
			$("#game-msg").remove();
			getRoundValue();
		}
	}

	function onDocumentMouseMove(event)
	{
		event.preventDefault();
		// Определяем положение мыши относительно элемента
		var bcr = $("#BoxingRollGame").get(0).getBoundingClientRect();
		mouseX = (event.clientX - bcr.left) / renderer.domElement.offsetWidth * 2 - 1;
		mouseY = 1 - (event.clientY - bcr.top) / renderer.domElement.offsetHeight * 2;
	}

	function animate()
	{
		requestAnimationFrame(animate);
		TWEEN.update();
		camera.lookAt(scene.position);
		render(clock.getDelta());
	}
	
	var startTimeAnim = 0, countKopeck = 0, direction = 0;
        function render(dt)
	{
		// анимация камеры
		if (animCameraStart)
		{
			var animCamera = 0.1;
			camera.position.x -= animCamera;
			camera.position.y -= animCamera;
			camera.position.z -= animCamera;
			animTimerCamera += 0.01;
			if (animTimerCamera > 1)
			{
				animCameraStart = false;
				animTimerCamera = 0.00;
				animKeyStart = true;
			}
		}
		
		if (animCameraReturn)
		{
			var animCamera = 0.1;
			camera.position.x += animCamera;
			camera.position.y += animCamera;
			camera.position.z += animCamera;
			animTimerCamera += 0.01;
			if (animTimerCamera > 1)
			{
				animCameraReturn = false;
				animTimerCamera = 0.00;
				$("#BoxingRollGame").append(locGameStart);
				meshKopeck.position.set(0, 0, 0);
				new TWEEN.Tween(objects.chest.h.rotation).to({x: 0, y: 0, z: 0}, 2000).easing(TWEEN.Easing.Elastic.Out).start();
				new TWEEN.Tween(objects.chest.h.position).to({x: 0, y: 0, z: 0}, 10000).easing(TWEEN.Easing.Elastic.Out).start();
				MoseClick = true;
			}
		}
		
		// анимация ключа
		if (animKeyStart)
		{
			if (meshKeyInput.position.z > 4.5)
			{
				meshKeyInput.position.z -= 0.2;
			}	
			else if (animKeyRotateInput)
			{
				if (meshKeyInput.rotation.z > -1.64)
				{
					meshKeyInput.rotation.z  -= 0.1;
				}
				else
				{
					animOpenChest = true;
					animKeyStart = false;
				}
			}
			else
			{
				animKeyRotateInput = true;
			}
		}
		// анимация открытия сундука
		if (animOpenChest)
		{
			new TWEEN.Tween(objects.chest.h.rotation).to({x: 1, y: 1.2, z: 0.3}, 2000).easing(TWEEN.Easing.Elastic.Out).start();
			new TWEEN.Tween(objects.chest.h.position).to({x: 10, y: 10, z: -90}, 10000).easing(TWEEN.Easing.Elastic.Out).start();
			new TWEEN.Tween(meshKeyInput.rotation).to({x: 1, y: 1.2, z: 0.3}, 2000).easing(TWEEN.Easing.Elastic.Out).start();
			new TWEEN.Tween(meshKeyInput.position).to({x: 30, y: 0, z: 90}, 10000).easing(TWEEN.Easing.Elastic.Out).start();
			animOpenChest = false;
			// инициализация анимации копеек/метки
			meshKopeck = objects.kopeck[InputKey];
			direction = getRandomInt(0, 2);
			startTimeAnim = performance.now()/1000;
			animKopeckStart = true;
			console.log(RandValue);
		}
		
		if(animKopeckStart)
		{
			var x0 = 0, y0 = 0, u0 = 20, g = 9.8, a = 65, x = 0, y = 0;
			var a_ = a*Math.PI/180;
			var tMax = (2*u0*Math.sin(a_))/g;
			var t = performance.now()/1000 - startTimeAnim;
			
			if (t <= tMax)
			{
				x = u0*t*Math.cos(a_);
				y = u0*t*Math.sin(a_) - (g*t*t)/2;
				switch (direction)
				{
				  case 0:
				    meshKopeck.position.set(x, y, 0);
				    meshKopeck.rotation.x = Math.sin((Math.random()*800)*dt);
				    break;
				  case 1:
				    meshKopeck.position.set(-x, y, 0);
				    meshKopeck.rotation.x = Math.sin((Math.random()*200)*dt);
				    break;
				  case 2:
				    meshKopeck.position.set(0, y, x);
				    meshKopeck.rotation.x = Math.sin((Math.random()*800)*dt);
				    break;
				}
			}
			else
			{
				countKopeck++;
				if (countKopeck < RandValue)
				{
					direction = getRandomInt(0, 2);
					meshKopeck.position.set(0, 0, 0);
					startTimeAnim = performance.now()/1000;
				}
				else
				{
					animKopeckStart = false;
					animCameraReturn = true;
				}
			}
		}
            renderer.render(scene, camera);
        }

	function DBH_AddOpenChest()
	{
		$.ajax({ type: "POST", url: "include/handle.Game.php", data: {'data': 'DBH_AddOpenChest:0'} });
		GameUpdateUser();
	}

	function DBH_DeleteKey(typeKey)
	{
		$.ajax({ type: "POST", url: "include/handle.Game.php", data: {'data': 'DBH_DeleteKey:'+typeKey} });
		GameUpdateUser();
	}

	function DBH_AddRoundValue(str)
	{
		$.ajax({ type: "POST", url: "include/handle.Game.php", data: {'data': 'DBH_AddRoundValue:'+str} });
		GameUpdateUser();
	}

	function DBH_UpdateIncome(typeKey)
	{
		var str = '';
		switch (typeKey)
		{
		  case 0:
		    str = '1, 0, 0, 0';
		    break;
		  case 1:
		    str = '0, 1, 0, 0';
		    break;
		  case 2:
		    str = '0, 0, 1, 0';
		    break;
		  case 3:
		    str = '0, 0, 0, 1';
		    break;
		  default:
		    str = '0, 0, 0, 0';
		    break;
		}
		$.ajax({ type: "POST", url: "include/handle.Game.php", data: {'data': 'DBH_UpdateIncome:'+str}});
	}

	function GameUpdateUser()
	{
		$.ajax({type: "POST",url: "include/handle.Game.php",data: {'data': 'GameUpdateUser:0'},success: function(data){$("#GameUpdateUser").html(data);}});
	}
	
	function getRandomInt(min, max)
	{
		return Math.floor(Math.random() * (max - min + 1)) + min;
	}

<?php

	echo '</script></td></tr>';
	closebox();
	require_once THEMES.'footer.php';
?>