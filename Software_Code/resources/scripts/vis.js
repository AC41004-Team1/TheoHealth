import * as THREE from 'https://threejsfundamentals.org/threejs/resources/threejs/r132/build/three.module.js';
import {
    OrbitControls
} from 'https://threejsfundamentals.org/threejs/resources/threejs/r132/examples/jsm/controls/OrbitControls.js';
import {
    GLTFLoader
} from 'https://threejsfundamentals.org/threejs/resources/threejs/r132/examples/jsm/loaders/GLTFLoader.js';

export default class BodyVis {
    colours() {
        return {
            teal: 0x0297a2,
            orange: 0xf36d21,
            white: 0xFFFFFF,
            black: 0x000000,
        }
    }
    theme() {
        return {
            background: this.colours().teal,
            model: this.colours().white,

        }
    }
    constructor(element, callback) {
        if (typeof element == "string") {
            element = document.querySelector(element)
        }
        //TODO: add some checking here to ensure valid element 
        this.canvas = element;
        this.callback = callback
        this.setup()
        this.start()
    }

    setup() {
        this.renderer = new THREE.WebGLRenderer({
            canvas: this.canvas
        })

        this.camOpts = {
            fov: 45,
            aspect: 2,
            near: 0.1,
            far: 100,
        }

        this.camera = new THREE.PerspectiveCamera(
            this.camOpts.fov,
            this.camOpts.aspect,
            this.camOpts.near,
            this.camOpts.far)

        this.camera.position.set(0, 10, 20)

        this.controls = new OrbitControls(this.camera, this.canvas);
        this.controls.enablePan = false;
        this.controls.target.set(0, 0, 0);
        this.controls.update();


        this.scene = new THREE.Scene()
        this.scene.background = new THREE.Color(this.theme().background)

        this.scene.add(new THREE.HemisphereLight(this.colours().white, this.colours().white, 0.4))

        //scope inside {} to ensure vars are not reused
        {
            //adds a white light to the
            const color = 0xFFFFFF;
            const intensity = 1;
            const light = new THREE.DirectionalLight(color, intensity);
            light.position.set(5, 10, 2);
            this.scene.add(light);
            this.scene.add(light.target);
        }

        this.load()

    }
    frameCamera(dirVector = [0, 0, 1]) {
        if (this.gltf == undefined) {
            return
        }
        const direction = (new THREE.Vector3(dirVector[0], dirVector[1], dirVector[2]))
        const root = this.gltf.scene
        const box = new THREE.Box3().setFromObject(root);
        const boxSize = box.getSize(new THREE.Vector3()).length() * 2;
        const boxCenter = box.getCenter(new THREE.Vector3());
        const sizeToFitOnScreen = boxSize * 0.5
        const halfSizeToFitOnScreen = sizeToFitOnScreen * 0.5;
        const halfFovY = THREE.MathUtils.degToRad(this.camera.fov * .5);
        const distance = halfSizeToFitOnScreen / Math.tan(halfFovY);
        this.camera.position.copy(direction.multiplyScalar(distance).add(boxCenter));
        this.camera.near = boxSize / 100;
        this.camera.far = boxSize * 100;

        this.camera.updateProjectionMatrix();

        // point the camera to look at the center of the box
        this.camera.lookAt(boxCenter.x, boxCenter.y, boxCenter.z);
        this.controls.maxDistance = boxSize * 10;
        this.controls.target.copy(boxCenter);
        this.controls.update();

    }
    lookFront() {
        this.frameCamera()
    }
    lookBack() {
        this.frameCamera([0, 0, -1])
    }

    getMouseLocationWithEvent(event) {
        return {
            x: ((event.clientX - (this.renderer.domElement.getBoundingClientRect().left + this.renderer.domElement.scrollLeft)) / this.renderer.domElement.width) * 2 - 1,
            y: -((event.y - (this.renderer.domElement.getBoundingClientRect().top + this.renderer.domElement.scrollTop)) / this.renderer.domElement.height) * 2 + 1
        }
    }
    raycastMeshes() {
        this.raycaster = new THREE.Raycaster();
        this.mouse = new THREE.Vector2();
        this.canvas.addEventListener('click', (event) => {
            event.preventDefault();
            this.mouse = this.getMouseLocationWithEvent(event)


            this.raycaster.setFromCamera(this.mouse, this.camera);
            var intersects = this.raycaster.intersectObjects(this.scene.children, true);
            if (intersects.length > 0) {
                intersects[0].object.callback()
            } else {
                this.callback("reset")
            }

        })
        this.canvas.addEventListener('mousemove', (event) => {
            event.preventDefault();
            this.mouse = this.getMouseLocationWithEvent(event)
            this.raycaster.setFromCamera(this.mouse, this.camera);
            var intersects = this.raycaster.intersectObjects(this.scene.children, true);
            let intersectName = ""
            if (intersects.length > 0) {
                intersectName = intersects[0].object.name
            }
            Object.keys(this.sensorAreas).forEach((e) => {

                if (intersectName == this.sensorAreas[e].obj.name) {
                    this.sensorAreas[e].colReset = true
                    this.changeColour(this.sensorAreas[e].obj, "black")
                } else {
                    if (this.sensorAreas[e].colReset && this.sensorAreas[e].col) {
                        this.changeColour(this.sensorAreas[e].obj, this.sensorAreas[e].col)
                        this.colReset = false

                    }

                }
            })

        })


    }
    load() {
        const gltfLoader = new GLTFLoader();
        gltfLoader.load('./resources/object/person2.gltf', (gltf) => {
            this.gltf = gltf
            var material = new THREE.MeshStandardMaterial({});
            let human = gltf.scene;
            human.material = material
            human.material.color.setHex(this.colours().white);
            human.scale.set(0.5, 0.5, 0.5)

            gltf.parser.getDependencies('material').then((materials) => {

                this.sensorAreas = {
                    rightQuad: { obj: this.scene.getObjectByName("Left_A"), col: this.colours().white },
                    leftQuad: { obj: this.scene.getObjectByName("Right_A"), col: this.colours().white },
                    leftHamstring: { obj: this.scene.getObjectByName("Right_B"), col: this.colours().white },
                    rightHamstring: { obj: this.scene.getObjectByName("Left_B"), col: this.colours().white },
                }

                Object.keys(this.sensorAreas).forEach((e) => {
                    this.sensorAreas[e].obj.callback = () => {
                        console.log(e);
                        this.callback(e)
                    }
                })
                this.scene.getObjectByName("body_low_1").callback = () => {
                    console.log("reset");
                    this.callback("reset")
                }
                this.raycastMeshes()
            });

            human.traverse(function(child) {

                child.material = material;
                child.material.side = THREE.DoubleSide;

            });
            this.scene.add(gltf.scene);
            this.lookFront()
        })
    }

    start() {
        let camera = this.camera
        let scene = this.scene
        let renderer = this.renderer

        function resizeRendererToDisplaySize(renderer) {
            const canvas = renderer.domElement;
            const width = canvas.clientWidth;
            const height = canvas.clientHeight;
            const needResize = canvas.width !== width || canvas.height !== height;
            if (needResize) {
                renderer.setSize(width, height, false);
            }
            return needResize;
        }

        function render() {
            if (resizeRendererToDisplaySize(renderer)) {
                const canvas = renderer.domElement;
                camera.aspect = canvas.clientWidth / canvas.clientHeight;
                camera.updateProjectionMatrix();
            }

            renderer.render(scene, camera);

            requestAnimationFrame(render);
        }
        requestAnimationFrame(render);
    }
    changeColourSensor(color, bodyPart) {
        this.sensorAreas[bodyPart].col = color
        this.changeColour(this.sensorAreas[bodyPart].obj, color)
    }
    changeColour(bodyPart, value) {
        const colourMap = {
            green: 0x008000,
            orange: 0xffa500,
            red: 0xff0000,
            black: 0x000000
        }
        const material = new THREE.MeshStandardMaterial({
            color: colourMap[value] || value
        });

        bodyPart.material = material

    }


}