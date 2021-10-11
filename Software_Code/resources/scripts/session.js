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
let sensors = []
for (let x = 0; x < 4; x++) {
    sensors.push(Array.from({ length: 100 }, () => Math.floor(Math.random() * 601)))
}

function updateHeatMap(index) {
    const sensorNames = ["rightQuad",
        "leftQuad",
        "leftHamstring",
        "rightHamstring"
    ]
    sensors.forEach((cur, i) => {
        bodyVis.changeColourSensor(getHighlightColour(cur[index]), sensorNames[i])
    })
}
let rangeSlider = document.querySelector(".slidecontainer input")
let playButton = document.getElementById("play")
rangeSlider.onchange = (e) => {

    let index = e.target.value
    console.log(index);
    updateHeatMap(index)
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
    for (let x = rangeSlider.min; x <= rangeSlider.max; x++) {
        setTimeout(() => {
            rangeSlider.value = x
            updateHeatMap(x)
        }, (5000 / rangeSlider.max) * x);
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