

var scene = new THREE.Scene();
var camera = new THREE.PerspectiveCamera( 75, window.innerWidth/window.innerHeight, 0.1, 10000 );

var renderer = new THREE.WebGLRenderer();
renderer.setSize( window.innerWidth, window.innerHeight );
document.body.appendChild( renderer.domElement );

window.addEventListener('resize', function()
{
  renderer.setSize( window.innerWidth, window.innerHeight );
  camera.aspect = window.innerWidth / window.innerHeight;
  camera.updateProjectionMatrix();
});

controls = new THREE.OrbitControls(camera, renderer.domElement)

/*var geometry = new THREE.BoxGeometry(1,1,1);
var material = new THREE.MeshPhongMaterial( { color: 0xFF00FF, wireframe: false});*/

/*var cube = new THREE.Mesh(geometry, material);

scene.add(cube);*/

camera.position.z = 1250;

var ambiantLight = new THREE.AmbientLight(0xFFFFFF, 0.7);
scene.add(ambiantLight);

var planets = [];
var spheres = [];

var geometry = new THREE.SphereGeometry( 100, 32, 32 );
var material = new THREE.MeshPhongMaterial( { color: 0xFF00FF, wireframe: true});

spheres.push(new THREE.Mesh( geometry, material ));
planets.push(new Planet(0, 1000, 'test', '16/09/2018'));
scene.add(spheres[0]);

spheres.push(new THREE.Mesh( geometry, material ));
planets.push(new Planet(750, 300, 'test', '16/09/2018'));
scene.add(spheres[1]);


var update = function()
{
  for (var i = 0; i < planets.length; i++) {
    if(!planets[i].hit)
    {
      if(planets[i].r<=0)
        planets[i].hit = true;

      planets[i].r -= 0.5;

      planets[i].update();
      spheres[i].position.x = planets[i].getX();
      spheres[i].position.y = planets[i].getY();
    }
  }
};

var render = function()
{
  renderer.render(scene, camera);
};

var Loop = function()
{
  requestAnimationFrame(Loop);

  update();
  render();
};

Loop();