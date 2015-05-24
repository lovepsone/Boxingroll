$(document).ready(function()
{
		//var texture = THREE.ImageUtils.loadTexture('images/crate.gif');
		//texture.anisotropy = renderer.getMaxAnisotropy();
		//material = new THREE.MeshBasicMaterial({map: texture});
		//$("#BoxingRoll").append(renderer.domElement);

	var camera, scene, renderer;
	var raycaster;
	var mouse;
	var debug = true;

	init();
	animate();

	function init()
	{
		camera = new THREE.PerspectiveCamera( 70, window.innerWidth / window.innerHeight, 1, 10000 );
		camera.position.y = 300;
		camera.position.z = 500;

		scene = new THREE.Scene();

		var geometry = new THREE.BoxGeometry(100, 100, 100);
		var texture = THREE.ImageUtils.loadTexture('images/crate.gif');
		var object = new THREE.Mesh(geometry, new THREE.MeshBasicMaterial({map: texture}));
		scene.add(object);
				
		raycaster = new THREE.Raycaster();
		mouse = new THREE.Vector2();

		renderer = new THREE.CanvasRenderer();
		renderer.setClearColor( 0xf0f0f0 );
		renderer.setPixelRatio( window.devicePixelRatio );
		renderer.setSize( window.innerWidth, window.innerHeight );
		$("#BoxingRoll").append(renderer.domElement);

		document.addEventListener('mousedown', onDocumentMouseDown, false );
		document.addEventListener('touchstart', onDocumentTouchStart, false );

		window.addEventListener('resize', onWindowResize, false );
	}

	function onWindowResize()
	{
		camera.aspect = window.innerWidth / window.innerHeight;
		camera.updateProjectionMatrix();
		renderer.setSize( window.innerWidth, window.innerHeight );
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
		var bcr = $("#BoxingRoll").get(0).getBoundingClientRect();
		var x_ = event.clientX - bcr.left;
		var y_ = event.clientY - bcr.top;
		event.clientY = event.clientY - 40;
		mouse.x = (x_ / renderer.domElement.width ) * 2 - 1;
		mouse.y = - (y_ / renderer.domElement.height ) * 2 + 1;
		if (debug) console.log('[onDocumentMouseDown]event.client['+x_+']['+y_+']mouse['+mouse.x+']['+mouse.y+']'+window.innerHeight);

		raycaster.setFromCamera( mouse, camera );

		var intersects = raycaster.intersectObjects( scene.children );

				if ( intersects.length > 0 ) {

					new TWEEN.Tween( intersects[ 0 ].object.position ).to( {
						x: Math.random() * 800 - 400,
						y: Math.random() * 800 - 400,
						z: Math.random() * 800 - 400 }, 2000 )
					.easing( TWEEN.Easing.Elastic.Out).start();

					new TWEEN.Tween( intersects[ 0 ].object.rotation ).to( {
						x: Math.random() * 2 * Math.PI,
						y: Math.random() * 2 * Math.PI,
						z: Math.random() * 2 * Math.PI }, 2000 )
					.easing( TWEEN.Easing.Elastic.Out).start();

				}
	}

	function animate()
	{
		requestAnimationFrame( animate );
		render();
	}

			var radius = 600;
			var theta = 0;

			function render() {

				TWEEN.update();

				theta += 0.1;

				/*camera.position.x = radius * Math.sin( THREE.Math.degToRad( theta ) );
				camera.position.y = radius * Math.sin( THREE.Math.degToRad( theta ) );
				camera.position.z = radius * Math.cos( THREE.Math.degToRad( theta ) );*/
				camera.lookAt( scene.position );

				renderer.render( scene, camera );

			}



});