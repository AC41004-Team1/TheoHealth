<?php
include "head.php";
include "authPHP.php";
?>
<title>Session</title>

<link rel="stylesheet" href="./resources/styles/session.css">
<link rel="stylesheet" href="./resources/styles/range.css">
<link rel="stylesheet" href="./resources/styles/layout.css">
<script type="module" src="./resources/scripts/vis.js" defer></script>
<script type="module" src="./resources/scripts/session.js" defer></script>
</head>

<body>
    <?php
    // Check if the form is submitted
    if (isset($_POST['sessionIndexIn'])) {
        //retrieve the form data by using the element's name attributes value as key
        $sessionIndex = $_POST['sessionIndexIn'];
        $_SESSION["userSession"] = $sessionIndex;
    }
    try {

        $times = array();
        $readings = array();
        for ($i = 1; $i <= 4; $i++) {
            $connection = openCon();

            $queryString = "CALL getClientDataWithSensor(\"{$sessionIndex}\",{$i})";
            $result = $connection->query($queryString);
            //var_dump($result);
            //echo $queryString;
            if ($result->num_rows > 0) {
                $curTimes = array();
                $curReadings = array();
                while ($row = $result->fetch_object()) {
                    $curTimes[] = $row->TimeStamp;
                    $curReadings[] = $row->Reading;
                }
                array_push($times, $curTimes);
                array_push($readings, $curReadings);
            }
            closeCon($connection);
            unset($result);
        }
    } catch (PDOException $e) {

        die($e->getMessage());
    }

    ?>
    <script type="module" defer>
        const readings = <?php echo json_encode($readings); ?>;
        const times = <?php echo json_encode($times); ?>;
        console.log(readings);
        console.log(times);
        import initPlayer from "./resources/scripts/session.js"


        function createTime(timeString) {
            let timeInts = timeString.split(':').map((e) => {
                return parseInt(e)
            })
            let date = new Date(0)
            date.setHours(timeInts[0])
            date.setMinutes(timeInts[1])
            date.setSeconds(timeInts[2])
            return date
        }
        const sensorValues = {}
        const sensorNames = [
            "rightQuad",
            "leftQuad",
            "leftHamstring",
            "rightHamstring"
        ]
        times.forEach((timeArr, timeArrIndex) => {
            console.log(timeArrIndex);
            timeArr.forEach((time, timeIndex) => {
                if (!sensorValues[time]) {
                    sensorValues[time] = {
                        readings: [],
                        date: createTime(time)
                    }

                }
                sensorValues[time].readings.push({
                    sensorName: sensorNames[timeArrIndex],
                    value: readings[timeArrIndex][timeIndex]
                })
            })
        })
        console.log(sensorValues);
        initPlayer(sensorValues, times)
    </script>
    <?php
    include "header.php";
    ?>
    <div id="session-content">
        <div id="session-model">
            <div id="canvas-container">
                <canvas style="width:100%"></canvas>

            </div>
            <div id="controls">
                <div id="front">Front</div>
                <div id="back">Back</div>

            </div>

            <div class="slidecontainer">
                <label id="timeLabel" for="timeRange"></label>
                <div id="readings">
                    <div id="leftQuad">
                        <span>Left Quad</span>
                        <span class="value"> ? </span>
                    </div>
                    <div id="leftHamstring">
                        <span>Left Ham</span>
                        <span class="value"> ? </span>
                    </div>
                    <div id="rightQuad">
                        <span>Right Quad</span>
                        <span class="value"> ? </span>
                    </div>
                    <div id="rightHamstring">
                        <span>Right Ham</span>
                        <span class="value"> ? </span>
                    </div>
                </div>
                <input name="timeRange " type="range" min="0" max="100" value="0" class="slider" id="myRange">
                <button id="play">Play </button>
            </div>

        </div>
        <div id="model-interaction">
            <ul id="muscles">
                <li class="leftQuad rightQuad" style="display: none">
                    <span class="closeExercisePanel"></span>
                    <div>
                        <div>Quads</div>
                        <ul class="exerciseList">
                            <li class="exerciseExample"><span>Squat</span>
                                <span class="minimizeExercise"></span>
                                <div class="exerciseContent">
                                    <div class="exerciseImages">
                                        <img src="./resources/images/exercises/barbell-male-highbarsquat-back.gif" alt="Animation of Squat">
                                        <img src="./resources/images/exercises/barbell-male-highbarsquat-front.gif" alt="Animation of Squat">
                                    </div>
                                    <ol>
                                        <li> Stand with your feet shoulder-width apart. Maintain the natural arch in your back, squeezing your shoulder blades and raising your chest.</li>
                                        <li> Grip the bar across your shoulders and support it on your upper back. Unwrack the bar by straightening your legs, and take a step back.</li>
                                        <li>Bend your knees as you lower the weight without altering the form of your back until your hips are below your knees.</li>
                                        <li>Raise the bar back to starting position, lift with your legs and exhale at the top.</li>
                                    </ol>
                                </div>
                            </li>
                            <li class="exerciseExample"><span>Leg Press</span>
                                <span class="minimizeExercise"></span>
                                <div class="exerciseContent">
                                    <div class="exerciseImages">
                                        <img src="./resources/images/exercises/LegPress-Front-021316.gif" alt="Animation of Leg Press">
                                        <img src="./resources/images/exercises/LegPress-Side-021316.gif" alt="Animation of Leg Press">
                                    </div>
                                    <ol>
                                        <li> Place your legs on the platform with your feet at shoulder width.</li>
                                        <li> Release the weight and extend your legs fully, without locking your knees.</li>
                                        <li> Lower the weight until your legs are at a 90° angle (but DO NOT allow your butt and lower back to rise off of the pad. This will put your lower back in a rounded position, which is very dangerous.)</li>
                                        <li> Raise the weight back to starting position.</li>
                                    </ol>
                                </div>
                            </li>
                            <li class="exerciseExample"><span>Forward Lunge</span>
                                <span class="minimizeExercise"></span>
                                <div class="exerciseContent">
                                    <div class="exerciseImages">
                                        <img src="./resources/images/exercises/kettlebell-male-forwardlunge-front.gif" alt="Animation of Forward Lunge">
                                        <img src="./resources/images/exercises/kettlebell-male-forwardlunge-side.gif" alt="Animation of Forward Lunge">
                                    </div>
                                    <ol>
                                        <li>Stand straight with your feet slightly apart and hold a kettlebell in one hand.</li>
                                        <li>Bring the same leg as the arm holding the kettlebell in front of you, squat down until your thigh is parallel to the ground, keeping your back straight.</li>
                                        <li>Return to the starting position and repeat.</li>
                                    </ol>
                                </div>
                            </li>
                            <li class="exerciseExample"><span>Barbell Curtsy Lunge</span>
                                <span class="minimizeExercise"></span>
                                <div class="exerciseContent">
                                    <div class="exerciseImages">
                                        <img src="./resources/images/exercises/barbell-male-curtsylunge-front.gif" alt="Animation of Barbell Curtsy Lunge">
                                        <img src="./resources/images/exercises/barbell-male-curtsylunge-side.gif" alt="Animation of Barbell Curtsy Lunge">
                                    </div>
                                    <ol>
                                        <li>Place the barbell on your back</li>
                                        <li>Step your foot back and around while simultaneously bringing the weight down.</li>
                                        <li>Return to start and repeat on other leg.</li>
                                    </ol>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="leftHamstring rightHamstring" style="display: none">
                    <span class="closeExercisePanel"></span>
                    <div>
                        <div>Hamstrings</div>
                        <ul class="exerciseList">
                            <li class="exerciseExample"><span>Squat</span>
                                <span class="minimizeExercise"></span>
                                <div class="exerciseContent">
                                    <div class="exerciseImages">
                                        <img src="./resources/images/exercises/barbell-male-highbarsquat-back.gif" alt="Animation of Squat">
                                        <img src="./resources/images/exercises/barbell-male-highbarsquat-front.gif" alt="Animation of Squat">
                                    </div>
                                    <ol>
                                        <li> Stand with your feet shoulder-width apart. Maintain the natural arch in your back, squeezing your shoulder blades and raising your chest.</li>
                                        <li> Grip the bar across your shoulders and support it on your upper back. Unwrack the bar by straightening your legs, and take a step back.</li>
                                        <li>Bend your knees as you lower the weight without altering the form of your back until your hips are below your knees.</li>
                                        <li>Raise the bar back to starting position, lift with your legs and exhale at the top.</li>
                                    </ol>
                                </div>
                            </li>
                            <li class="exerciseExample"><span>Stiff Leg Deadlifts</span>
                                <span class="minimizeExercise"></span>
                                <div class="exerciseContent">
                                    <div class="exerciseImages">
                                        <img src="./resources/images/exercises/Male-Stiff-Leg-Deadlifts-front.gif" alt="Animation of Stiff Leg Deadlift">
                                        <img src="./resources/images/exercises/Male-Stiff-Leg-Deadlifts-side.gif" alt="Animation of Stiff Leg Deadlift">
                                    </div>
                                    <ol>
                                        <li>Stand with a barbell at your shins with your feet shoulder width apart.</li>
                                        <li>Bend forward at your hips and keep your knees as fully extended as possible.</li>
                                        <li>Grab the barbell and then extend your hips while maintaining a straight back.</li>
                                        <li>From the standing position, lower the weight in a controlled manner.</li>
                                        <li>You can either lower the weight to the floor or before you touch the floor, depending on your mobility.</li>
                                    </ol>
                                </div>
                            </li>
                            <li class="exerciseExample"><span>Hamstring Curl</span>
                                <span class="minimizeExercise"></span>
                                <div class="exerciseContent">
                                    <div class="exerciseImages">
                                        <img src="./resources/images/exercises/ProneLegCurl-Back-021316.gif" alt="Animation of Hamstring Curl">
                                        <img src="./resources/images/exercises/ProneLegCurl-Side-021316.gif" alt="Animation of Hamstring Curl">
                                    </div>
                                    <ol>
                                        <li>Lay down on the machine, placing your legs beneath the padded lever. Position your legs so that the padded lever is below your calve muscles.</li>
                                        <li>Support yourself by grabbing the side handles of the machine, and slowly raise the weight with your legs, toes pointed straight.</li>
                                        <li>Pause at the apex of the motion, then slowly return to starting position.</li>
                                    </ol>
                                </div>
                            </li>
                            <li class="exerciseExample"><span>Staggered Deadlift</span>
                                <span class="minimizeExercise"></span>
                                <div class="exerciseContent">
                                    <div class="exerciseImages">
                                        <img src="./resources/images/exercises/kettlebell-male-staggereddeadlift-front.gif" alt="Animation of Staggered Deadlift">
                                        <img src="./resources/images/exercises/kettlebell-male-staggereddeadlift-side.gif" alt="Animation of Staggered Deadlift">
                                    </div>
                                    <ol>
                                        <li>Stand with your feet shoulder width apart, shifting one foot behind you. Hold the kettlebell in both hands in front of your thighs.</li>
                                        <li>Bend forward at the hips bringing the kettlebell to the floor while you slightly bend your knees and keep your back straight.</li>
                                        <li>Return to the upright position and repeat.</li>
                                    </ol>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
    </div>
    <?php
    include "footer.php";
    ?>

</body>