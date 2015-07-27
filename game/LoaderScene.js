var cMeshProgress = 0, maxMeshKopeck = 4, cMeshLoad = 6 + maxMeshKopeck, group_m;
var initStart = false, InitEnd = false;

var objects = {
	chest: {},
	keys: {},
	kopeck: {}
};

var LOADERSCENE =
{
	loader: {},
	
	Initialize: function()
	{
		$("#BoxingRollGame").append(locLoadGame);
		$("#BoxingRollGame").append('<span id="game-msg-loader2" style=""> 0%</span>');
		initStart = true;
		var id = 0;
		this.loader = new THREE.JSONLoader();

		group_m = new THREE.Group();
		group_m.visible = false;

		this.InitializeChest();
		this.InitializeKeys();
		this.InitializeKopeck();
		scene.add(group_m);
		getCountKey();
		var id = setInterval(function()
		{
			if (LOADERSCENE.isLoad())
			{
				initStart = false;
				InitEnd = true;
				$("#game-msg-loader").remove();
				$("#BoxingRollGame").append(panel);
				$("#BoxingRollGame").append(locGameStart);
				group_m.visible = true;
				clearInterval(id);
			}
		}, 10);
	},
	
	InitializeChest: function()
	{
		this.loader.load('game/chest/m_chest.json', function(geometry)
		{
			this.material = new THREE.MeshPhongMaterial(
			{
				color: 0xdddddd,
				specular: 0x222222,
				shininess: 35,
				map: THREE.ImageUtils.loadTexture("game/chest/t_chest_diff.gif"),
				specularMap: THREE.ImageUtils.loadTexture("game/chest/t_chest_spec.gif"),
				normalMap: THREE.ImageUtils.loadTexture("game/chest/t_chest_normals.gif"),
				normalScale: new THREE.Vector2(0.8, 0.8),
				wrapRGB: new THREE.Vector3(0.575, 0.5, 0.5),
				wrapAround: true
			});
			
			objects.chest.m = new THREE.Mesh(geometry, material);
			objects.chest.m.scale.set(100, 100, 100);
			objects.chest.m.name = 'M_CHEST';
			objects.chest.m.castShadow = true;
			group_m.add(objects.chest.m);
		});
		
		this.loader.load('game/chest/h_chest.json', function(geometry)
		{
			this.material = new THREE.MeshPhongMaterial(
			{
				color: 0xffffff,
				specular: 0x222222,
				shininess: 35,
				//map: THREE.ImageUtils.loadTexture("game/chest/t_chest_diff.gif"),
				//specularMap: THREE.ImageUtils.loadTexture("game/chest/t_chest_spec.gif"),
				//normalMap: THREE.ImageUtils.loadTexture("game/chest/t_chest_normals.gif"),
				//normalScale: new THREE.Vector2(0.8, 0.8),
				//wrapRGB: new THREE.Vector3(0.575, 0.5, 0.5),
				wrapAround: true
			});
			
			objects.chest.h = new THREE.Mesh(geometry, material);
			objects.chest.h.scale.set(100, 100, 100);
			objects.chest.h.name = 'H_CHEST';
			//this.mesh.castShadow = true;
			group_m.add(objects.chest.h);
		});

		this.loader.onLoadComplete = function()
		{
			cMeshProgress += 1;
		};
	},
	
	InitializeKeys: function()
	{
		this.loader.load('game/keys/keyNormal.json', function(geometry)
		{
			this.material = new THREE.MeshPhongMaterial(
			{
				color: 0xffffff,
				specular: 0x222222,
				shininess: 35,
				map: THREE.ImageUtils.loadTexture("game/keys/keyNormal_diff.gif"),
				specularMap: THREE.ImageUtils.loadTexture("game/keys/keyNormal_spec.gif"),
				normalMap: THREE.ImageUtils.loadTexture("game/keys/keyNormal_normal.gif"),
				normalScale: new THREE.Vector2(0.8, 0.8),
				wrapRGB: new THREE.Vector3(0.575, 0.5, 0.5),
				wrapAround: true
			});
			
			objects.keys[0] = new THREE.Mesh(geometry, material);
			objects.keys[0].scale.set(100, 100, 100);
			objects.keys[0].position.set(0, 0, 100);
			objects.keys[0].name = 'keyNormal';
			//objects.keys[0].castShadow = true;
			group_m.add(objects.keys[0]);
		});

		this.loader.load('game/keys/keyGold.json', function(geometry)
		{
			this.material = new THREE.MeshPhongMaterial(
			{
				color: 0xffffff,
				specular: 0x222222,
				shininess: 35,
				map: THREE.ImageUtils.loadTexture("game/keys/keyGold_diff.gif"),
				specularMap: THREE.ImageUtils.loadTexture("game/keys/keyGold_spec.gif"),
				normalScale: new THREE.Vector2(0.8, 0.8),
				wrapRGB: new THREE.Vector3(0.575, 0.5, 0.5),
				wrapAround: true
			});
			
			objects.keys[1] = new THREE.Mesh(geometry, material);
			objects.keys[1].scale.set(100, 100, 100);
			objects.keys[1].position.set(0, 0, 100);
			objects.keys[1].name = 'keyGold';
			//this.mesh.castShadow = true;
			group_m.add(objects.keys[1]);
		});
		
		this.loader.load('game/keys/keyPlatinum.json', function(geometry)
		{
			this.material = new THREE.MeshPhongMaterial(
			{
				color: 0xffffff,
				specular: 0x222222,
				shininess: 35,
				map: THREE.ImageUtils.loadTexture("game/keys/keyPlatinum_diff.gif"),
				specularMap: THREE.ImageUtils.loadTexture("game/keys/keyPlatinum_spec.gif"),
				normalMap: THREE.ImageUtils.loadTexture("game/keys/keyPlatinum_normal.gif"),
				normalScale: new THREE.Vector2(0.8, 0.8),
				wrapRGB: new THREE.Vector3(0.575, 0.5, 0.5),
				wrapAround: true
			});
			
			objects.keys[2] = new THREE.Mesh(geometry, material);
			objects.keys[2].scale.set(100, 100, 100);
			objects.keys[2].position.set(0, 0, 100);
			objects.keys[2].name = 'keyPlatinum';
			//this.mesh.castShadow = true;
			group_m.add(objects.keys[2]);
		});
		
		this.loader.load('game/keys/keyPremium.json', function(geometry)
		{
			this.material = new THREE.MeshPhongMaterial(
			{
				color: 0xffffff,
				specular: 0x222222,
				shininess: 35,
				map: THREE.ImageUtils.loadTexture("game/keys/keyPremium_diff.gif"),
				specularMap: THREE.ImageUtils.loadTexture("game/keys/keyPremium_spec.gif"),
				normalMap: THREE.ImageUtils.loadTexture("game/keys/keyPremium_normal.gif"),
				normalScale: new THREE.Vector2(0.8, 0.8),
				wrapRGB: new THREE.Vector3(0.575, 0.5, 0.5),
				wrapAround: true
			});
			
			objects.keys[3] = new THREE.Mesh(geometry, material);
			objects.keys[3].scale.set(100, 100, 100);
			objects.keys[3].position.set(0, 0, 100);
			objects.keys[3].name = 'keyPremium';
			//this.mesh.castShadow = true;
			group_m.add(objects.keys[3]);
		});

		this.loader.onLoadComplete = function()
		{
			cMeshProgress += 1;
		};
	},
	
	InitializeKopeck: function()
	{
		this.loader.load('game/kopeck/kopeckNormal.json', function(geometry)
		{
			this.material = new THREE.MeshPhongMaterial(
			{
				color: 0xffffff,
				specular: 0x222222,
				shininess: 35,
				map: THREE.ImageUtils.loadTexture("game/kopeck/kopeckNormal.gif"),
				normalScale: new THREE.Vector2(0.8, 0.8),
				wrapRGB: new THREE.Vector3(0.575, 0.5, 0.5),
				wrapAround: true
			});
			
			objects.kopeck[0] = new THREE.Mesh(geometry, material);
			objects.kopeck[0].name = 'kopeckNormal';
			//this.mesh.castShadow = true;
			group_m.add(objects.kopeck[0]);
		});

		this.loader.load('game/kopeck/kopeckNormal.json', function(geometry)
		{
			this.material = new THREE.MeshPhongMaterial(
			{
				color: 0xffffff,
				specular: 0x222222,
				shininess: 35,
				map: THREE.ImageUtils.loadTexture("game/kopeck/kopeckGold.gif"),
				normalScale: new THREE.Vector2(0.8, 0.8),
				wrapRGB: new THREE.Vector3(0.575, 0.5, 0.5),
				wrapAround: true
			});
			
			objects.kopeck[1] = new THREE.Mesh(geometry, material);
			objects.kopeck[1].name = 'kopeckGold';
			//this.mesh.castShadow = true;
			group_m.add(objects.kopeck[1]);
		});

		this.loader.load('game/kopeck/kopeckNormal.json', function(geometry)
		{
			this.material = new THREE.MeshPhongMaterial(
			{
				color: 0xffffff,
				specular: 0x222222,
				shininess: 35,
				map: THREE.ImageUtils.loadTexture("game/kopeck/kopeckPlatinum.gif"),
				normalScale: new THREE.Vector2(0.8, 0.8),
				wrapRGB: new THREE.Vector3(0.575, 0.5, 0.5),
				wrapAround: true
			});
			
			objects.kopeck[2] = new THREE.Mesh(geometry, material);
			objects.kopeck[2].name = 'kopeckPlatinum';
			//this.mesh.castShadow = true;
			group_m.add(objects.kopeck[2]);
		});

		this.loader.load('game/kopeck/kopeckNormal.json', function(geometry)
		{
			this.material = new THREE.MeshPhongMaterial(
			{
				color: 0xffffff,
				specular: 0x222222,
				shininess: 35,
				map: THREE.ImageUtils.loadTexture("game/kopeck/kopeckPremium.gif"),
				normalScale: new THREE.Vector2(0.8, 0.8),
				wrapRGB: new THREE.Vector3(0.575, 0.5, 0.5),
				wrapAround: true
			});
			
			objects.kopeck[3] = new THREE.Mesh(geometry, material);
			objects.kopeck[3].name = 'kopeckPremium';
			//objects.kopeck[3].castShadow = true;
			group_m.add(objects.kopeck[3]);
		});
		this.loader.onLoadComplete = function()
		{
			cMeshProgress += 1;
		};	
	},
	
	isLoad: function()
	{
		if (cMeshProgress == cMeshLoad)
		{
			return true;
		}
		return false;
	},
	
	getProgress: function()
	{
		var c = cMeshProgress*100/cMeshLoad;
		var n = Math.round(c * 100) / 100;
		$("#game-msg-loader2").remove(); 
		$("#BoxingRollGame").append('<span id="game-msg-loader2" style=""> '+n+'%</span>');
	}
};