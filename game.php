<?php
	define("GAME_PAGE", true);
	require_once 'maincore.php';
	require_once THEMES.'header.php';
	HeadMenu();
	echo '<script src="include/js/three.min.js"></script>';
	echo '<script src="include/js/renderers/Projector.js"></script>';
	echo '<script src="include/js/renderers/CanvasRenderer.js"></script>';
	echo '<script src="include/js/libs/tween.min.js"></script>';
	echo '<script src="include/js/fonts/helvetiker_regular.typeface.js"></script>';
	echo '<script src="include/js/ShaderParticles.min.js"></script>';
	openbox();
	echo '<tr><td><div id="BoxingRollGame" align="center"></div><script>';
?>

	var camera, scene, renderer, clock;
	var raycaster;
	var mouse, MoseClick = true, MoseClickReturn = false, addRondValue = true;
	var mesh, texture, MeshRoundValue;
	var SCREEN_WIDTH = window.innerWidth - 600;
	var SCREEN_HEIGHT = 500;
	var GroupChest, GroupKey, GroupText, GroupPlane, GroupKopeck;
	var animDestruction = false, animDestructionReturn = false;
	var VisibleKey, RotateKeys = true, animKeyStart = false, animKeyRotateVisible = false;
	var animCameraStart = false, animCameraPositionStart = false, animCamera = 1.5, animTimerCamera = 0.00;
	var emitter, particleGroup, startAnimParticle = false;
	var TypeKey = '{ "Normal":0, "Gold":1, "Platinum":2, "Premium":3}';

	var LoaderLogic = true, LoaderChest = false, LoaderKeys = false, LoaderPlanes = false, LoaderKopecks = false, LoaderEnd = false;

	var txtGameStart = '<span id="game-msg" style="position:absolute; left:370px; top:220px;"><?php echo $locale['GameStart']; ?></span>';
	var txtGameLoad = '<span id="game-msg-loader" style="font-size:23px;position:absolute; left:' + (280 + SCREEN_WIDTH/2) + 'px; top:' + (180 + SCREEN_HEIGHT/2) + 'px;">Loading...</span>';
	var txtGameEnd = '<span id="game-msg" style="position:absolute; left:370px; top:220px;"><?php echo $locale['GameEnd']; ?> </span>';
	GameUpdateUser();
	init();
        initParticles();
        setTimeout(animate, 0);

	$(window).load(function(){if (LoaderLogic) $.getJSON('game/GameData.js', function(result){LoaderLogic = false; LoadScene(result);});});

	function init()
	{
		renderer = new THREE.WebGLRenderer();
		renderer.setClearColor(0x010e16); //010E16;
		renderer.setPixelRatio(window.devicePixelRatio);
		renderer.setSize(SCREEN_WIDTH, SCREEN_HEIGHT);
		$("#BoxingRollGame").append(renderer.domElement);
		$("#BoxingRollGame").append(txtGameLoad);
		camera = new THREE.PerspectiveCamera(100, renderer.domElement.offsetWidth / renderer.domElement.offsetHeight, 1, 600);
		camera.position.z = 500;

		scene = new THREE.Scene();
		raycaster = new THREE.Raycaster();
		mouse = new THREE.Vector2();
		clock = new THREE.Clock();
		GroupChest = new THREE.Group();
		GroupKey = new THREE.Group();
		GroupPlane = new THREE.Group();
		GroupKopeck = new THREE.Group();

		GroupChest.visible = false;
		GroupKey.visible = false;
		GroupPlane.visible = false;

		document.addEventListener('mousedown', onDocumentMouseDown, false);
		document.addEventListener('mousemove', onDocumentMouseMove, false);
		document.addEventListener('touchstart', onDocumentTouchStart, false);
		window.addEventListener('resize', onWindowResize, false );
	}

	function initParticles()
	{
		particleGroup = new SPE.Group({
			texture: THREE.ImageUtils.loadTexture('game/smokeparticle.png'),
			maxAge: 2
		});

		emitter = new SPE.Emitter({
			position: new THREE.Vector3(0, 0, 0),
			positionSpread: new THREE.Vector3(0, 0, 0),

        		acceleration: new THREE.Vector3(0, -30, 0),
        		accelerationSpread: new THREE.Vector3(200, 0, 200),

        		velocity: new THREE.Vector3(0, 250, 0),
        		velocitySpread: new THREE.Vector3(190, 280, 190),

        		colorStart: new THREE.Color('white'),
        		colorEnd: new THREE.Color('red'),

        		sizeStart: 10,
        		sizeEnd: 10,

        		particleCount: 4000
        	});

        	particleGroup.addEmitter(emitter);
        	scene.add(particleGroup.mesh);
        }

	function LoadScene(data)
	{
		var loader = new THREE.JSONLoader();

		for (var i = 0; i < data['chest'].length; i++)
		{
			if (i < data['chest'].length)
			{
				loader.load(data['chest'][i]['model'], function(geometry, materials)
				{
					var material = new THREE.MeshFaceMaterial(materials);
					mesh = new THREE.Mesh(geometry, material);
			        	GroupChest.add(mesh);
				});
			}
			if (i < data['keys'].length)
			{
				loader.load(data['keys'][i]['model'], function(geometry, materials)
				{
					var material = new THREE.MeshFaceMaterial(materials);
					mesh = new THREE.Mesh(geometry, material);
			        	GroupKey.add(mesh);
				});
			}
			if (i < data['plane'].length)
			{
				var geometry = new THREE.PlaneGeometry(data['plane'][i]['model'][0], data['plane'][i]['model'][1], data['plane'][i]['model'][2], data['plane'][i]['model'][3]);
				var materials = new THREE.ImageUtils.loadTexture('game/plane.png');
				var plane = new THREE.Mesh(geometry, new THREE.MeshBasicMaterial({map: materials, transparent: true}));
				plane.position.set(data['plane'][i]['position'][0], data['plane'][i]['position'][1], data['plane'][i]['position'][2]);
				plane.name = data['plane'][i]['name'];
				GroupPlane.add(plane);
			}
			if (i < data['kopeck'].length)
			{
				loader.load(data['kopeck'][i]['model'], function(geometry, materials)
				{
					var material = new THREE.MeshFaceMaterial(materials);
					mesh = new THREE.Mesh(geometry, material);
			        	GroupKopeck.add(mesh);
				});
			}
		}
		loader.onLoadComplete = function()
		{
			LoaderPlanes = true;
			if (GroupChest.children.length == data['chest'].length)
				StartConfigChest(data);
			if (GroupKey.children.length == data['keys'].length)
				StartConfigKeys(data);
			if (GroupKopeck.children.length == data['kopeck'].length)
			{
				for (var i = 0; i < GroupKopeck.children.length; i++)
				{
					GroupKopeck.children[i].name = data['kopeck'][i]['name'];
					GroupKopeck.children[i].scale.set(data['kopeck'][i]['scale'][0], data['kopeck'][i]['scale'][1], data['kopeck'][i]['scale'][2]);
					GroupKopeck.children[i].position.set(data['kopeck'][i]['position'][0], data['kopeck'][i]['position'][1], data['kopeck'][i]['position'][2]);
					GroupKopeck.children[i].rotation.set(1.57, 0, 0);
					GroupKopeck.children[i].visible = false;
				}
				LoaderKopecks = true;
			}
			if (GroupChest.children.length == data['chest'].length && GroupKey.children.length == data['keys'].length && GroupKopeck.children.length == data['kopeck'].length)
			{
				if (LoaderChest && LoaderKeys && LoaderPlanes && LoaderKopecks)
				{
					GroupChest.visible = true;
					GroupKey.visible = true;
					GroupPlane.visible = true;
					GroupText.visible = true;
					//GroupKopeck.visible = true;
					LoaderEnd = true;
					$("#game-msg-loader").remove();
					$("#BoxingRollGame").append(txtGameStart);
				}
			}
		};
		LoadStartText(data);
		scene.add(GroupChest);
		scene.add(GroupKey);
		scene.add(GroupPlane);
		scene.add(GroupKopeck);
	}

	function LoadStartText(data)
	{
		GroupText = new THREE.Group();
		if (!LoaderEnd) GroupText.visible = false;
		$.ajax(
		{
			type: "POST",
			url: "include/handle.Game.php",
			data: {'data': 'getCountKey:0'},
			success: function(DataUser)
			{
				for (var i = 0; i < data['text'].length; i++)
				{
					var tmp = JSON.parse(DataUser);
					var text3d = new THREE.TextGeometry("x " + tmp[i], {size: data['text'][i]['size'], height: data['text'][i]['height'], curveSegments: 2, font: "helvetiker"});
					text3d.computeBoundingBox();
					mesh = new THREE.Mesh(text3d, new THREE.MeshBasicMaterial({color: 0x0aadd2, overdraw: 0.5}));
					mesh.position.set(data['text'][i]['position'][0], data['text'][i]['position'][1], data['text'][i]['position'][2]);
					mesh.name = data['text'][i]['name'];
					GroupText.add(mesh);	
				}
				scene.add(GroupText);
			}
		});
	}

	function StartConfigChest(data)
	{
		for (var i = 0; i < GroupChest.children.length; i++)
		{
			GroupChest.children[i].name = data['chest'][i]['name'];
			GroupChest.children[i].scale.set(data['chest'][i]['scale'][0], data['chest'][i]['scale'][1], data['chest'][i]['scale'][2]);
		       	GroupChest.children[i].position.set(data['chest'][i]['position'][0], data['chest'][i]['position'][1], data['chest'][i]['position'][2]);
		}
		LoaderChest = true;
	}

	function StartConfigKeys(data)
	{
		for (var i = 0; i < GroupKey.children.length; i++)
		{
			GroupKey.children[i].name = data['keys'][i]['name'];
			GroupKey.children[i].scale.set(data['keys'][i]['scale'][0], data['keys'][i]['scale'][1], data['keys'][i]['scale'][2]);
		       	GroupKey.children[i].position.set(data['keys'][i]['position'][0], data['keys'][i]['position'][1], data['keys'][i]['position'][2]);
		}
		LoaderKeys = true;
		GroupKey.visible = true;
	}

	function LoadRoundValue()
	{
		if (addRondValue)
		{
			addRondValue = false;
			$.ajax(
			{
				type: "POST",
				url: "include/handle.Game.php",
				data: {'data': 'RoundValueOpenChest:0'},
				success: function(RandValue)
				{
					var text3d = new THREE.TextGeometry("x" + RandValue, {size: 100, height: 20, curveSegments: 2, font: "helvetiker"});
					text3d.computeBoundingBox();
					var textMaterial = new THREE.MeshBasicMaterial({color: 0x0aadd2, overdraw: 0.5});
					MeshRoundValue = new THREE.Mesh(text3d, textMaterial);
					MeshRoundValue.name = "RoundValue";
					MeshRoundValue.position.set(-30, 10, 40);
					scene.add(MeshRoundValue);
					DBH_AddRoundValue(VisibleKey + ',' + RandValue);
				}
			});
			GroupKopeck.children[VisibleKey].visible = true;
		}
	}
	function getTypeKey(name_key)
	{
		var type_key = 0;
		switch (name_key)
		{
		  case "Normal":
		    type_key = 0;
		    break;
		  case "Gold":
		    type_key = 1;
		    break;
		  case "Platinum":
		    type_key = 2;
		    break;
		  case "Premium":
		    type_key = 3;
		    break;
		}
		return type_key;
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
		if (!LoaderEnd) return;

		event.preventDefault();
		animDestructionReturn = false;
		if (MoseClick)
		{
			var bcr = $("#BoxingRollGame").get(0).getBoundingClientRect();
			mouseX = (event.clientX - bcr.left) / renderer.domElement.offsetWidth * 2 - 1;
			mouseY = 1 - (event.clientY - bcr.top) / renderer.domElement.offsetHeight * 2;

			var vector = new THREE.Vector3(mouseX, mouseY, 0).unproject(camera);
			raycaster.set(camera.position, vector.sub( camera.position ).normalize());
			var intersects = raycaster.intersectObject(scene, true);

			if (intersects.length > 0 && (intersects[0].object.name == "Normal" || intersects[0].object.name == "Gold" || intersects[0].object.name == "Platinum" || intersects[0].object.name == "Premium"))
			{
				VisibleKey = getTypeKey(intersects[0].object.name);
				DBH_AddOpenChest();
				DBH_DeleteKey(VisibleKey);
				new TWEEN.Tween(GroupKey.children[VisibleKey].position).to({x: 0, y: 90, z: 150}, 2000 ).easing(TWEEN.Easing.Elastic.Out).start();
				new TWEEN.Tween(GroupKey.children[VisibleKey].rotation).to({x: 1.64, y: 0, z: 0}, 2000).easing(TWEEN.Easing.Elastic.Out).start();
				animCameraStart = true;
				animKeyStart = true;
				MoseClick = false;
				RotateKeys = false;
				$("#game-msg").remove();
				scene.remove(GroupText);

				for (var i = 0; i < 4; i++)
				{
					if (i != VisibleKey) GroupKey.children[i].visible = false;
				}
			}
		}
		if (MoseClickReturn)
		{
			GroupKopeck.children[VisibleKey].visible = false;
			scene.remove(MeshRoundValue);
			$("#game-msg").remove();
			animCameraStart = false;
			animCameraPositionStart = false;
			startAnimParticle = false;
			particleGroup.mesh.visible = false;
			animDestructionReturn = true;
			RotateKeys = true;
			animKeyStart = false;
			animKeyRotateVisible = false;
			for (var i = 0; i < 4; i++)
			{
				GroupKey.children[i].visible = true;
				GroupKey.children[i].rotation.set(0, 1.2, 0);
			}
			$.getJSON('game/GameData.js', function(result){StartConfigKeys(result); LoadStartText(result);});
			MoseClickReturn = false;
			MoseClick = true;
			addRondValue = true;
			$("#BoxingRollGame").append(txtGameStart);
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

        function render(dt)
	{
		if (LoaderEnd)
		{
			animCameraGame();
			if (RotateKeys)
			{
				for (var i = 0; i < 4; i++)
					GroupKey.children[i].rotation.y += 0.05;
			}
			if (animKeyStart)
			{
				if (GroupKey.children[VisibleKey].position.z > 65) GroupKey.children[VisibleKey].position.z -= 1.9; else animKeyRotateVisible = true;
				if (animKeyRotateVisible)
				{
					if (GroupKey.children[VisibleKey].rotation.y > -1.64)
					{
						GroupKey.children[VisibleKey].rotation.y  -= 0.3;
					}
					else
					{
						startAnimParticle = true;
						animDestruction = true;
						animKeyStart = false;
					}
				}
			}
	            	if (startAnimParticle)
			{
				particleGroup.mesh.visible = true;
				particleGroup.tick(dt);
			}
	
			if (animDestruction)
			{
				LoadRoundValue();
				if (GroupChest.children[0].position.x < 2000)
				{
					var conf = 30;
					GroupChest.children[0].position.x += conf;
					GroupChest.children[1].position.x -= conf;
					GroupChest.children[2].position.y += conf;
					GroupChest.children[3].position.y -= conf;
					GroupChest.children[4].position.z -= conf;
					GroupKey.children[VisibleKey].position.z += conf;
					for (var i = 0; i < 5; i++)
					{
						GroupChest.children[i].rotation.set(Math.random() * 2 * Math.PI, Math.random() * 2 * Math.PI, Math.random() * 2 * Math.PI);
					}
					GroupKey.children[VisibleKey].rotation.set(Math.random() * 2 * Math.PI, Math.random() * 2 * Math.PI, Math.random() * 2 * Math.PI);
				}
				else
				{
					animCameraPositionStart = true;
					animDestruction = false;
				}
			}
			else if(animDestructionReturn)
			{
				if (GroupChest.children[0].position.x > 0)
				{
					var conf = 30;
					GroupChest.children[0].position.x -= conf;
					GroupChest.children[1].position.x += conf;
					GroupChest.children[2].position.y -= conf;
					GroupChest.children[3].position.y += conf;
					GroupChest.children[4].position.z += conf;
					for (var i = 0; i < 5; i++)
					{
						GroupChest.children[i].rotation.set(0, 0, 0);
					}
				}
			}
		}
            renderer.render(scene, camera);
        }

	// animation
	function animCameraGame()
	{
		if (animCameraStart)
		{
			camera.position.x -= animCamera;
			camera.position.y += animCamera;
			camera.position.z -= animCamera;
			animTimerCamera += 0.01;
			if (animTimerCamera > 1)
			{
				animCameraStart = false;
				animTimerCamera = 0.00;
			}
		}
		else if (animCameraPositionStart)
		{
			camera.position.x += animCamera;
			camera.position.y -= animCamera;
			camera.position.z += animCamera;
			animTimerCamera += 0.01;
			if (animTimerCamera > 1)
			{
				animCameraPositionStart = false;
				animTimerCamera = 0.00;
				$("#BoxingRollGame").append(txtGameEnd);
				MoseClickReturn = true;
			}
		}
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

	function GameUpdateUser()
	{
		$.ajax(
		{
			type: "POST",
			url: "include/handle.Game.php",
			data: {'data': 'GameUpdateUser:0'},
			success: function(data)
			{
				$("#GameUpdateUser").html(data);
			}
		});
	}
<?php

	echo '</script></td></tr>';
	closebox();
	require_once THEMES.'footer.php';
?>