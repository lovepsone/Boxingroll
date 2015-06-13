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
	var debug = true;
	var mesh, texture, MeshRoundValue;
	var SCREEN_WIDTH = window.innerWidth - 600;
	var SCREEN_HEIGHT = 500;
	var GroupChest, GroupKey, GroupText, GroupPlane;
	var animDestruction = false, animDestructionReturn = false;
	var pos_z_key = 180, pos_xy_key = 180, VisibleKey, RotateKeys = true, animKeyStart = false, animKeyRotateVisible = false;
	var animCameraStart = false, animCameraPositionStart = false, animCamera = 1.5, animTimerCamera = 0.00;
	var emitter, particleGroup, startAnimParticle = false;

	var LDC = 0;
	var data = {
	"chest": [
		{
		  "id": 0,
		  "name": "chest_b",
		  "patch": "",
		  "model": "game/chest/t_chest_b.json",
		  "texture": "game/chest/t_chest_b.gif",
		  "scale": [200, 200, 200],
		  "position": [0, 0, 0]
		},
		{
		  "id": 1,
		  "name": "chest_m",
		  "patch": "",
		  "model": "game/chest/t_chest_m.json",
		  "texture": "game/chest/t_chest_m.gif",
		  "scale": [200, 200, 200],
		  "position": [0, 0, 0]
		},
		{
		  "id": 2,
		  "name": "chest_c",
		  "patch": "",
		  "model": "game/chest/t_chest_c.json",
		  "texture": "game/chest/t_chest_c.gif",
		  "scale": [200, 200, 200],
		  "position": [0, 0, 0]
		},
		]
	};

	init();
	//animate();
        initParticles();

        setTimeout(animate, 0);
	function init()
	{
		renderer = new THREE.WebGLRenderer();
		renderer.setClearColor(0x010e16); //010E16;
		renderer.setPixelRatio(window.devicePixelRatio);
		renderer.setSize(SCREEN_WIDTH, SCREEN_HEIGHT);
		$("#BoxingRollGame").append(renderer.domElement);
		$("#BoxingRollGame").append('<span id="game-msg" style="position:absolute; left:370px; top:220px;"><?php echo $locale['GameStart']; ?> </span>');
		camera = new THREE.PerspectiveCamera(100, renderer.domElement.offsetWidth / renderer.domElement.offsetHeight, 1, 600);
		camera.position.z = 500;
		scene = new THREE.Scene();
		raycaster = new THREE.Raycaster();
		mouse = new THREE.Vector2();
		clock = new THREE.Clock();
		LoadScene();
		document.addEventListener('mousedown', onDocumentMouseDown, false);
		document.addEventListener('mousemove', onDocumentMouseMove, false);
		document.addEventListener('touchstart', onDocumentTouchStart, false);
		window.addEventListener('resize', onWindowResize, false );
	}

	function initParticles()
	{
		particleGroup = new SPE.Group({
			texture: THREE.ImageUtils.loadTexture('game/smokeparticle.png'),
			maxAge: 2,
			//blending: THREE.NormalBlending
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

	function LoadScene()
	{
		//load chest
		GroupChest = new THREE.Group();
		LoadChest(200, 0, 0, 0);
		scene.add(GroupChest);
		// load key
		var loader = new THREE.JSONLoader();
		GroupKey = new THREE.Group();
		GroupText = new THREE.Group();
		GroupPlane = new THREE.Group();
		loader.load("game/key.json", function(obj)
		{
			mesh = new THREE.Mesh(obj, new THREE.MeshBasicMaterial({map: THREE.ImageUtils.loadTexture("game/Normal.gif")}));
			mesh.scale.set(10, 10, 10);
			mesh.name = "key_Normal";
	        	mesh.position.set(-pos_xy_key, pos_xy_key, pos_z_key);
			mesh.rotation.set(0, 1.2, 0);
	        	GroupKey.add(mesh);
			addTextKey("Normal", -pos_xy_key, pos_xy_key, pos_z_key);
			LoadViziblePlane("Normal", -pos_xy_key, pos_xy_key, pos_z_key);
		});
		loader.load("game/key.json", function(obj)
		{
			mesh = new THREE.Mesh(obj, new THREE.MeshBasicMaterial({map: THREE.ImageUtils.loadTexture("game/Gold.gif")}));
			mesh.scale.set(10, 10, 10);
			mesh.name = "key_Gold";
	        	mesh.position.set(pos_xy_key, pos_xy_key, pos_z_key);
			mesh.rotation.set(0, 1.2, 0);
	        	GroupKey.add(mesh);
			addTextKey("Gold", pos_xy_key, pos_xy_key, pos_z_key);
			LoadViziblePlane("Gold", pos_xy_key, pos_xy_key, pos_z_key);
		});
		loader.load("game/key.json", function(obj)
		{
			mesh = new THREE.Mesh(obj, new THREE.MeshBasicMaterial({map: THREE.ImageUtils.loadTexture("game/Platinum.gif")}));
			mesh.scale.set(10, 10, 10);
			mesh.name = "key_Platinum";
	        	mesh.position.set(-pos_xy_key, -pos_xy_key, pos_z_key);
			mesh.rotation.set(0, 1.2, 0);
	        	GroupKey.add(mesh);
			addTextKey("Platinum", -pos_xy_key, -pos_xy_key, pos_z_key);
			LoadViziblePlane("Platinum", -pos_xy_key, -pos_xy_key, pos_z_key);
		});
		loader.load("game/key.json", function(obj)
		{
			mesh = new THREE.Mesh(obj, new THREE.MeshBasicMaterial({map: THREE.ImageUtils.loadTexture("game/Premium.gif")}));
			mesh.scale.set(10, 10, 10);
			mesh.name = "key_Premium";
	        	mesh.position.set(pos_xy_key, -pos_xy_key, pos_z_key);
			mesh.rotation.set(0, 1.2, 0);
	        	GroupKey.add(mesh);
			addTextKey("Premium", pos_xy_key, -pos_xy_key, pos_z_key);
			LoadViziblePlane("Premium", pos_xy_key, -pos_xy_key, pos_z_key);
		});

		scene.add(GroupKey);
		scene.add(GroupText);
		scene.add(GroupPlane);
	}

	function LoadChest(t_scale, pos_x, pos_y, pos_z)
	{
		var loader = new THREE.JSONLoader();

		loader.load("game/chest/t_chest_b.json", function(obj)
		{
			mesh = new THREE.Mesh(obj, new THREE.MeshBasicMaterial({map: THREE.ImageUtils.loadTexture(data['chest'][0]['texture'])}));
			mesh.scale.set(t_scale, t_scale, t_scale);
	        	mesh.position.set(pos_x, pos_y, pos_z);
			mesh.name = "chest_b";
	        	GroupChest.add(mesh);
		});
		loader.load("game/chest/t_chest_m.json", function(obj)
		{
			mesh = new THREE.Mesh(obj, new THREE.MeshBasicMaterial({map: THREE.ImageUtils.loadTexture("game/chest/t_chest_m.gif")}));
			mesh.scale.set(t_scale, t_scale, t_scale);
	        	mesh.position.set(pos_x, pos_y, pos_z);
			mesh.name = "chest_m";
	        	GroupChest.add(mesh);
		});
		loader.load("game/chest/t_chest_c.json", function(obj)
		{
			mesh = new THREE.Mesh(obj, new THREE.MeshBasicMaterial({map: THREE.ImageUtils.loadTexture("game/chest/t_chest_c.gif")}));
			mesh.scale.set(t_scale, t_scale, t_scale);
	        	mesh.position.set(pos_x, pos_y, pos_z);
			mesh.name = "chest_c";
	        	GroupChest.add(mesh);
		});
		loader.load("game/chest/t_chest_e.json", function(obj)
		{
			mesh = new THREE.Mesh(obj, new THREE.MeshBasicMaterial({map: THREE.ImageUtils.loadTexture("game/chest/t_chest_e.gif")}));
			mesh.scale.set(t_scale, t_scale, t_scale);
	        	mesh.position.set(pos_x, pos_y, pos_z);
			mesh.name = "chest_e";
	        	GroupChest.add(mesh);
		});
		loader.load("game/chest/t_chest_i.json", function(obj)
		{
			mesh = new THREE.Mesh(obj, new THREE.MeshBasicMaterial({color: 0xff9933}));
			mesh.scale.set(t_scale, t_scale, t_scale);
	        	mesh.position.set(pos_x, pos_y, pos_z);
			mesh.name = "chest_i";
	        	GroupChest.add(mesh);
		});
	}

	function LoadViziblePlane(p_name, pos_x, pos_y, pos_z)
	{
		var g_plane = new THREE.PlaneGeometry(130,70,1,1);
		var t_plane = THREE.ImageUtils.loadTexture('game/plane.png');
		t_plane.premultiplyAlpha = true;
		var plane = new THREE.Mesh(g_plane, new THREE.MeshBasicMaterial({map: t_plane, transparent: true}));
		plane.position.set(pos_x + 50, pos_y +30, pos_z + 5);
		plane.name = p_name;
		GroupPlane.add(plane);
	}

	function LoadRoundValue()
	{
		if (addRondValue)
		{
			addRondValue = false;
			var text3d = new THREE.TextGeometry(<?php echo RoundValueOpenChest(); ?>, {size: 110, height: 20, curveSegments: 2, font: "helvetiker"});
			text3d.computeBoundingBox();
			var textMaterial = new THREE.MeshBasicMaterial({color: 0x0aadd2, overdraw: 0.5});
			MeshRoundValue = new THREE.Mesh(text3d, textMaterial);
			MeshRoundValue.name = "RoundValue";
			MeshRoundValue.position.set(-30, 0, 40);
			scene.add(MeshRoundValue);
		}
	}

	function addTextKey(key_name, pos_x, pos_y, pos_z)
	{
		var tmp, text = "x ";
		text += getCountKey(key_name);
		var text3d = new THREE.TextGeometry(text, {size: 40, height: 5, curveSegments: 2, font: "helvetiker"});
		text3d.computeBoundingBox();
		var textMaterial = new THREE.MeshBasicMaterial({color: 0x0aadd2, overdraw: 0.5});
		text = new THREE.Mesh(text3d, textMaterial);
		text.position.set(pos_x + 30, pos_y + 10, pos_z);
		GroupText.add(text);
	}

	function getCountKey(key_name)
	{
		var tmp = '';
		switch (key_name)
		{
		  case 'Normal':
		    tmp = <?php echo getCountKey(1); ?>;
		    break;
		  case 'Gold':
		    tmp = <?php echo getCountKey(2); ?>;
		    break;
		  case 'Platinum':
		    tmp = <?php echo getCountKey(3); ?>;
		    break;
		  case 'Premium':
		    tmp = <?php echo getCountKey(4); ?>;
		    break;
		}
		return tmp;
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
		SCREEN_WIDTH = renderer.domElement.offsetWidth;//window.innerWidth;
		SCREEN_HEIGHT = renderer.domElement.offsetHeight;//window.innerHeight;
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
		animDestructionReturn = false;
		if (MoseClick)
		{
			var bcr = $("#BoxingRollGame").get(0).getBoundingClientRect();
			mouseX = (event.clientX - bcr.left) / renderer.domElement.offsetWidth * 2 - 1;
			mouseY = 1 - (event.clientY - bcr.top) / renderer.domElement.offsetHeight * 2;
			//raycaster.setFromCamera(mouse, camera);
			//var intersects = raycaster.intersectObjects(scene.children);
			var vector = new THREE.Vector3(mouseX, mouseY, 0).unproject(camera);
			raycaster.set(camera.position, vector.sub( camera.position ).normalize());
			var intersects = raycaster.intersectObject(scene, true);

			if (intersects.length > 0 && (intersects[0].object.name == "Normal" || intersects[0].object.name == "Gold" || intersects[0].object.name == "Platinum" || intersects[0].object.name == "Premium"))
			{
				VisibleKey = getTypeKey(intersects[0].object.name);
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
					if (i != VisibleKey)
						GroupKey.children[i].visible = false;
				}
			}
		}
		if (MoseClickReturn)
		{
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
			GroupText = new THREE.Group();
			GroupKey.children[0].position.set(-pos_xy_key, pos_xy_key, pos_z_key);
			addTextKey("Normal", -pos_xy_key, pos_xy_key, pos_z_key);
			GroupKey.children[1].position.set(pos_xy_key, pos_xy_key, pos_z_key);
			addTextKey("Gold", pos_xy_key, pos_xy_key, pos_z_key);
			GroupKey.children[2].position.set(-pos_xy_key, -pos_xy_key, pos_z_key);
			addTextKey("Platinum", -pos_xy_key, -pos_xy_key, pos_z_key);
			GroupKey.children[3].position.set(pos_xy_key, -pos_xy_key, pos_z_key);
			addTextKey("Premium", pos_xy_key, -pos_xy_key, pos_z_key);
			scene.add(GroupText);
			MoseClickReturn = false;
			MoseClick = true;
			addRondValue = true;
			$("#BoxingRollGame").append('<span id="game-msg" style="position:absolute; left:370px; top:220px;"><?php echo $locale['GameStart']; ?> </span>');
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
				$("#BoxingRollGame").append('<span id="game-msg" style="position:absolute; left:370px; top:220px;"><?php echo $locale['GameEnd']; ?> </span>');
				MoseClickReturn = true;
			}
		}
	}
<?php

	echo '</script></td></tr>';
	closebox();
	require_once THEMES.'footer.php';
?>