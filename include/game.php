<?php
	require_once 'maincore.php';
	require_once THEMES.'header.game.php';
	HeadMenu();
	//openbox();
	echo '<div id="BoxingRoll" align="center" style="background-color: #010E16;overflow: hidden; font-family: Monospace;"></div>';

?><div id = "game" align="center"></div><script>

	var scene, renderer, camera, raycaster;
	var mouseX = 0.0;
	var mouseY = 0.0;
	var c = 600, w = window.innerWidth - c, h = c;
	var div = document.getElementById("game");

	function L0G(info)
	{
		var debug = true;
		if (debug) console.log(info);
	}

	function print_r(arr, level)
	{
		var print_red_text = "";
		if(!level)
			level = 0;
		var level_padding = "";
		for(var j=0; j<level+1; j++)
			level_padding += "    ";
		if(typeof(arr) == 'object')
		{
			for(var item in arr)
			{
				var value = arr[item];
				if(typeof(value) == 'object')
				{
					print_red_text += level_padding + "'" + item + "' :\n";
					print_red_text += print_r(value,level+1);
				} 
				else 
					print_red_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
        		}
    		} 
    		else 
			print_red_text = "===>"+arr+"<===("+typeof(arr)+")";
		return print_red_text;
	}
	/*function init()
	{*/
	renderer = new THREE.WebGLRenderer();
	renderer.setSize(w, h); //window.innerWidth, window.innerHeight
	document.getElementById("game").appendChild(renderer.domElement);
	renderer.setClearColor(0xf0f0f0);
	renderer.setPixelRatio(window.devicePixelRatio);

	scene = new THREE.Scene();
	
	camera = new THREE.PerspectiveCamera(75, renderer.domElement.offsetWidth / renderer.domElement.offsetHeight, 0.1, 1000);
	//camera.position.set(0, 0, 5);
	camera.position.z = 400;
	camera.lookAt(new THREE.Vector3(0, -1, -1));

	raycaster = new THREE.Raycaster();

	renderer.domElement.addEventListener("click", function (event)
	{
		event.preventDefault();
		// Определяем положение мыши относительно элемента
		var bcr = this.getBoundingClientRect();
		mouseX = (event.clientX - bcr.left) / renderer.domElement.offsetWidth * 2 - 1;
		mouseY = 1 - (event.clientY - bcr.top) / renderer.domElement.offsetHeight * 2;
		L0G('mose(x/y)['+ mouseX.toFixed(2)+'/'+mouseY.toFixed(2)+']');

		var vector = new THREE.Vector3(mouseX, mouseY, 0).unproject(camera);
		raycaster.set(camera.position, vector.sub( camera.position ).normalize());
		var intersects = raycaster.intersectObject(scene, true);
		if (intersects.length > 0)
		{
			alert(intersects[0].object.name);
		}
	});
			
	renderer.domElement.addEventListener("mousemove", function (event)
	{
		event.preventDefault();
		// Определяем положение мыши относительно элемента
		var br = this.getBoundingClientRect();
		mouseX = (event.clientX - br.left) / renderer.domElement.offsetWidth * 2 - 1;
		mouseY = 1 - (event.clientY - br.top) / renderer.domElement.offsetHeight * 2;
		//L0G('mose(x/y)['+ mouseX.toFixed(2)+'/'+mouseY.toFixed(2)+']');
	});

			
	window.addEventListener("resize", function(event)
	{
		renderer.setSize(w, h);
		camera.aspect = w / h;
		camera.updateProjectionMatrix();
	});
			
	var boxGeometry = new THREE.BoxGeometry(200, 200, 200);
	var texture = THREE.ImageUtils.loadTexture('images/crate.gif');
	//texture.anisotropy = renderer.getMaxAnisotropy();
	var boxMaterial = new THREE.MeshBasicMaterial({ map:texture })	
	var boxMeshCenter = new THREE.Mesh(boxGeometry, boxMaterial);
	boxMeshCenter.name = "boxMeshCenter";
	scene.add(boxMeshCenter);
			

	function renderScene()
	{
				requestAnimationFrame(renderScene);
				boxMeshCenter.rotation.y += 0.01;
				renderer.render(scene, camera);
	}
			
	renderScene();
			
</script><?php

	require_once THEMES.'footer.php';
?>