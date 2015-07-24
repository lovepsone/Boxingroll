var cMeshProgress = 0, maxMeshKopeck = 4, cMeshLoad = 6 + maxMeshKopeck, group_m;
var initStart = false, InitEnd = false;
var meshChestH;

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
			
			this.mesh = new THREE.Mesh(geometry, material);
			this.mesh.scale.set(100, 100, 100);
			this.mesh.name = 'M_CHEST';
			this.mesh.castShadow = true;
			group_m.add(this.mesh);
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
			
			meshChestH = new THREE.Mesh(geometry, material);
			meshChestH.scale.set(100, 100, 100);
			meshChestH.name = 'H_CHEST';
			//this.mesh.castShadow = true;
			group_m.add(meshChestH);
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
			
			this.mesh = new THREE.Mesh(geometry, material);
			this.mesh.scale.set(100, 100, 100);
			this.mesh.position.set(0, 0, 100);
			this.mesh.name = 'keyNormal';
			//this.mesh.castShadow = true;
			group_m.add(this.mesh);
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
			
			this.mesh = new THREE.Mesh(geometry, material);
			this.mesh.scale.set(100, 100, 100);
			this.mesh.position.set(0, 0, 100);
			this.mesh.name = 'keyGold';
			//this.mesh.castShadow = true;
			group_m.add(this.mesh);
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
			
			this.mesh = new THREE.Mesh(geometry, material);
			this.mesh.scale.set(100, 100, 100);
			this.mesh.position.set(0, 0, 100);
			this.mesh.name = 'keyPlatinum';
			//this.mesh.castShadow = true;
			group_m.add(this.mesh);
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
			
			this.mesh = new THREE.Mesh(geometry, material);
			this.mesh.scale.set(100, 100, 100);
			this.mesh.position.set(0, 0, 100);
			this.mesh.name = 'keyPremium';
			//this.mesh.castShadow = true;
			group_m.add(this.mesh);
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
			
			this.mesh = new THREE.Mesh(geometry, material);
			this.mesh.name = 'kopeckNormal';
			//this.mesh.castShadow = true;
			group_m.add(this.mesh);
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
			
			this.mesh = new THREE.Mesh(geometry, material);
			this.mesh.name = 'kopeckGold';
			//this.mesh.castShadow = true;
			group_m.add(this.mesh);
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
			
			this.mesh = new THREE.Mesh(geometry, material);
			this.mesh.name = 'kopeckPlatinum';
			//this.mesh.castShadow = true;
			group_m.add(this.mesh);
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
			
			this.mesh = new THREE.Mesh(geometry, material);
			this.mesh.name = 'kopeckPremium';
			//this.mesh.castShadow = true;
			group_m.add(this.mesh);
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