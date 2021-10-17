import BodyVis from "./vis.js"

// reusbale function to turn a value into a colour string
function getHighlightColour(val) {
    if (val >= 400)
        return "red"
    if (val < 400 && val >= 200)
        return "orange"
    return "green"
}

//instance BodyVis to 'canvas' and attatch the click callback 
let bodyVis = new BodyVis('canvas', (callbackValue) => {
    let muscles = document.querySelector("#muscles").children
    Array.from(muscles).forEach((e) => {
        console.log(e);
        if (e.classList.contains(callbackValue)) {
            e.style = "display: block"

        } else {
            e.style = "display: none"
        }
    })
})

// use to map between ids in the 2D vis and the object values 
const sensorToIdMap = {
    leftHamstring: "HAMSTRINGS-LEFT",
    rightHamstring: "HAMSTRINGS-RIGHT",
    leftQuad: "QUADS-LEFT",
    rightQuad: "QUADS-RIGHT"
}

// for every 2d vis id
Object.values(sensorToIdMap).forEach((id, index) => {
    document.getElementById(id).onclick = () => {
        let muscles = document.querySelector("#muscles").children
        Array.from(muscles).forEach((e) => {
            console.log(e);
            if (e.classList.contains(Object.keys(sensorToIdMap)[index])) {
                e.style = "display: block"

            } else {
                e.style = "display: none"
            }
        })
    }
})


//set the fill of the svg element based on the sensor name and value 
function update2dSensor(sensorName, value) {
    document.getElementById(sensorToIdMap[sensorName]).setAttribute('fill', getHighlightColour(value))
}

//export this function to be used inside the php file 
export default function initPlayer(sensors) {

    function updateHeatMap(readings) {
        readings.readings.forEach((cur, i) => {
            //update models
            bodyVis.changeColourSensor(getHighlightColour(cur.value), cur.sensorName)
            update2dSensor(cur.sensorName, cur.value)

            //update dashboard 
            let valueBox = document.querySelector(`#readings #${cur.sensorName}`)
            valueBox.style = `border-color: ${getHighlightColour(cur.value)}`
            valueBox.querySelector(".value").innerText = cur.value;
        })
        //update label
        timeLabel.innerText = `${readings.date.getHours()} : ${readings.date.getMinutes()} : ${readings.date.getSeconds().toString().length == 1 ? "0" + readings.date.getSeconds().toString() : readings.date.getSeconds().toString()}`

    }

    // to be used by above function
    let timeLabel = document.getElementById('timeLabel')

    //update range to be correct length with step of 1 
    let rangeSlider = document.querySelector(".slidecontainer input")
    //play button functions 
    let playButton = document.getElementById("play")


    
    rangeSlider.min = 0;
    rangeSlider.max = Object.keys(sensors).length - 1
    rangeSlider.step = 1
    rangeSlider.onchange = (e) => {
        let index = e.target.value
        updateHeatMap(sensors[Object.keys(sensors)[index]])
    }
    rangeSlider.onclick = (e) => {
        if (playButton.getAttribute("playing") === "t") {
            var id = window.setTimeout(function () { }, 0);
            //loop through timeouts and destroy them all
            while (id--) {
                window.clearTimeout(id);
            }
            playButton.innerText = "Play"
            playButton.setAttribute("playing", "")

            //exit we've nothing else to do
        }
    }



    
    playButton.onclick = () => {
        //if playing we pause 
        if (playButton.getAttribute("playing") === "t") {
            var id = window.setTimeout(function () { }, 0);
            //loop through timeouts and destroy them all
            while (id--) {
                window.clearTimeout(id);
            }
            playButton.innerText = "Play"
            playButton.setAttribute("playing", "")

            //exit we've nothing else to do
            return
        }

        // starting to play
        playButton.setAttribute("playing", "t")
        playButton.innerText = "Pause"
        //get the initial time to be used later
        let initialTime = sensors[Object.keys(sensors)[0]].date
        for (let x = 0; x <= rangeSlider.max; x++) {

            let curTime = sensors[Object.keys(sensors)[x]].date
            setTimeout(() => {
                //update value 
                rangeSlider.value = x
                //updating value doesn't fire event so fire the event manually 
                updateHeatMap(sensors[Object.keys(sensors)[x]])

            }, curTime.getTime() - initialTime.getTime()); // timeout until the delta between initial time and this time 
        }
    }
}



document.querySelector('#back').onclick = () => {
    bodyVis.lookBack()
    bodyVis.start()
}

document.querySelector('#front').onclick = () => {
    bodyVis.lookFront()
    bodyVis.start()
}

//minimize exercise elements
let minimize = document.querySelectorAll('.minimizeExercise')
minimize.forEach((e) => {
    console.log(e);
    e.onclick = () => {
        let content = e.parentElement.querySelector('.exerciseContent')
        let display = content.style.display

        content.style.display = display == "none" ? "block" : "none"

        e.className = e.className == "minimizeExercise maximize" ? "minimizeExercise" : "minimizeExercise maximize"
    }
})

//close the exercise panel
let close = document.querySelectorAll('.closeExercisePanel')
close.forEach((e) => {
    e.onclick = () => {
        let parent = e.parentElement

        parent.style = "display: none;"

    }
})


//swap between 2d and 3d
let swap = document.getElementById('swapDimensions')

swap.onclick = () => {
    console.log(swap.children);
    Array.from(swap.children).forEach((child) => {
        child.style.display = child.style.display == "none" ? "block" : "none"
    })

    Array.from(document.querySelectorAll('#canvas-container > canvas , #canvas-container > svg')).forEach((child) => {
        child.style.display = child.style.display == "none" ? "block" : "none"
    })

    let controls = document.getElementById('controls')

    controls.style.display = controls.style.display == "none" ? "grid" : "none"

}