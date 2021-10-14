import BodyVis from "./vis.js"



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

function getHighlightColour(val) {
    if (val >= 400)
        return "red"
    if (val < 400 && val >= 200)
        return "orange"
    return "green"
}
export default function initPlayer(sensors) {
    function updateHeatMap(readings) {
        readings.readings.forEach((cur, i) => {
            bodyVis.changeColourSensor(getHighlightColour(cur.value), cur.sensorName)
            let valueBox = document.querySelector(`#readings #${cur.sensorName}`)
            valueBox.style = `border-color: ${getHighlightColour(cur.value)}`
            valueBox.querySelector(".value").innerText = cur.value;
        })
        console.log(readings.date);
        timeLabel.innerText = `${readings.date.getHours()} : ${readings.date.getMinutes()} : ${readings.date.getSeconds().toString().length == 1 ? "0" + readings.date.getSeconds().toString() : readings.date.getSeconds().toString()}`

    }
    let rangeSlider = document.querySelector(".slidecontainer input")
    rangeSlider.min = 0;
    rangeSlider.max = Object.keys(sensors).length - 1
    rangeSlider.step = 1
    let playButton = document.getElementById("play")

    let timeLabel = document.getElementById('timeLabel')
    rangeSlider.onchange = (e) => {
        let index = e.target.value
        updateHeatMap(sensors[Object.keys(sensors)[index]])
    }

    playButton.onclick = () => {
        console.log(rangeSlider);
        console.log(playButton);
        if (playButton.getAttribute("playing") === "t") {
            var id = window.setTimeout(function() {}, 0);
            while (id--) {
                window.clearTimeout(id);
            }
            playButton.innerText = "Play"
            playButton.setAttribute("playing", "")
            return
        }
        playButton.setAttribute("playing", "t")
        playButton.innerText = "Pause"
        let initialTime = sensors[Object.keys(sensors)[0]].date
        for (let x = 0; x <= rangeSlider.max; x++) {
            let curTime = sensors[Object.keys(sensors)[x]].date
            setTimeout(() => {
                rangeSlider.value = x
                updateHeatMap(sensors[Object.keys(sensors)[x]])
            }, curTime.getTime() - initialTime.getTime());
        }
    }
}
let sensors = []
    // for (let x = 0; x < 4; x++) {
    //     sensors.push(Array.from({ length: 100 }, () => Math.floor(Math.random() * 601)))
    // }


document.querySelector('#back').onclick = () => {
    bodyVis.lookBack()
    bodyVis.start()
}

document.querySelector('#front').onclick = () => {
    bodyVis.lookFront()
    bodyVis.start()
}


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

let close = document.querySelectorAll('.closeExercisePanel')
close.forEach((e) => {
    e.onclick = () => {
        let parent = e.parentElement

        parent.style = "display: none;"

    }
})