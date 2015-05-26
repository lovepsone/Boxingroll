$(document).ready(function()
{
	var camera, scene, renderer;
	var raycaster;
	var mouse, stopmose = false;
	var object, animateStart = false, confrotation = 0.01, posCube;
	var objarrow;
	var group, text;
	var debug = true;
	var W = window.innerWidth, H = window.innerHeight; //window.innerWidth window.innerHeight

	init();
	animate();

	function dataUser()
	{
		$.ajax(
		{
			type: "POST",
			url: "include/handle.Game.php",
			data:{'data': ''},
			success: function(data)
			{
				var tmp = JSON.parse(data);
				UserSellBox = tmp['cSellBox'];
			}
		});
	}

	function init()
	{
		camera = new THREE.PerspectiveCamera(75, W / H, 1, 10000);
		camera.position.y = 300;
		camera.position.z = 500;

		scene = new THREE.Scene();
				
		raycaster = new THREE.Raycaster();
		mouse = new THREE.Vector2();

		draw();
		drawArrow();
		renderer = new THREE.CanvasRenderer();
		renderer.setClearColor(0x010e16); //010E16;
		renderer.setPixelRatio(window.devicePixelRatio);
		renderer.setSize(W, H);
		$("#BoxingRoll").append(renderer.domElement);

		document.addEventListener('mousedown', onDocumentMouseDown, false );
		document.addEventListener('touchstart', onDocumentTouchStart, false );

		window.addEventListener('resize', onWindowResize, false );
	}

	function draw()
	{
		var geometry = new THREE.BoxGeometry(70, 70, 70);
		var texture = THREE.ImageUtils.loadTexture('images/crate.gif');
		//texture.anisotropy = renderer.getMaxAnisotropy();
		object = new THREE.Mesh(geometry, new THREE.MeshBasicMaterial({map: texture}));
		posCube = new THREE.Vector3(Math.random() * 800 - 400, Math.random() * 800 - 400, 0);
		object.position.set(posCube.x, posCube.y, posCube.z);
		//if (debug) console.log('[onDocumentMouseDown]event.client['+x_+']['+y_+']mouse['+mouse.x+']['+mouse.y+']');
		object.name = 'cube';
		scene.add(object);
	}

	function drawArrow()
	{
		var geometry = new THREE.PlaneGeometry(140,70,1,1);
		var texture = THREE.ImageUtils.loadTexture('images/t_arrow.png');
		//texture.anisotropy = renderer.getMaxAnisotropy();
    		objarrow = new THREE.Mesh(geometry, new THREE.MeshBasicMaterial({map: texture}));
		objarrow.name = 'arrow';
		objarrow.position.set(posCube.x - 80, posCube.y + 83, 0);
		scene.add(objarrow);
		createText();
	}

	function createText()
	{
		var theText = "x ";
		$.ajax(
		{
			type: "POST",
			url: "include/handle.Game.php",
			data:{'cmd': 'SelectSellBox:0'},
			success: function(data)
			{
				theText += data;
				var hash = document.location.hash.substr(1);
				if (hash.length !== 0)
				{
					theText = hash;
				}
				var text3d = new THREE.TextGeometry(theText, {size: 60, height: 10, curveSegments: 2, font: "helvetiker"});
				text3d.computeBoundingBox();
		
				var textMaterial = new THREE.MeshBasicMaterial({color: 0x0aadd2, overdraw: 0.5});
				text = new THREE.Mesh(text3d, textMaterial);
				text.position.set(posCube.x + 50, posCube.y - 10, 0);
				group = new THREE.Group();
				group.add(text);
				scene.add(group);
			}
		});
	}

	function onWindowResize()
	{
		camera.aspect = W / W;
		camera.updateProjectionMatrix();
		renderer.setSize(W, H);
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
		if (!stopmose)
		{
			var bcr = $("#BoxingRoll").get(0).getBoundingClientRect();
			var x_ = event.clientX - bcr.left;
			var y_ = event.clientY - bcr.top;
			event.clientY = event.clientY - 40;
			mouse.x = (x_ / renderer.domElement.width ) * 2 - 1;
			mouse.y = - (y_ / renderer.domElement.height ) * 2 + 1;
			if (debug) console.log('[onDocumentMouseDown]event.client['+x_+']['+y_+']mouse['+mouse.x+']['+mouse.y+']');
	
			raycaster.setFromCamera(mouse, camera);
	
			var intersects = raycaster.intersectObjects(scene.children);
	
			if (intersects.length > 0 && intersects[0].object.name == 'cube')
			{
				stopmose = true;
				animateStart = true;
    				scene.remove(objarrow);
				scene.remove(group);
				intersects[0].object.scale.set(3, 3, 3);
				new TWEEN.Tween(intersects[0].object.position).to({x:0, y:0, z:0}, 2000 ).easing(TWEEN.Easing.Elastic.Out).start();
				new TWEEN.Tween(intersects[0].object.rotation).to({x: Math.random() * 2 * Math.PI, y: Math.random() * 2 * Math.PI, z: Math.random() * 2 * Math.PI }, 2000).easing(TWEEN.Easing.Elastic.Out).start();
			}
		}
	}

	function animate()
	{
		requestAnimationFrame(animate);
		TWEEN.update();
		camera.lookAt(scene.position);
		renderer.render(scene, camera);
		if (animateStart)
		{
			if (confrotation < 1) confrotation = confrotation + 0.01;
			else if (confrotation < 3) confrotation = confrotation + 0.03;
			else if (confrotation < 5) confrotation = confrotation + 0.07;
			else if (confrotation < 10) confrotation = confrotation + 0.35;
			else confrotation = confrotation + 0.5;

			object.rotation.x = confrotation;
		}
	}
});