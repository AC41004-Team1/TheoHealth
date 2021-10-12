<?php
include "head.php";
include "authPHP.php";
?>
<title>Session</title>

<link rel="stylesheet" href="./resources/styles/session.css">
<link rel="stylesheet" href="./resources/styles/range.css">
<link rel="stylesheet" href="./resources/styles/layout.css">
<link rel="manifest" href="manifest.webmanifest">
<script type="module" src="./resources/scripts/vis.js" defer></script>
<script type="module" src="./resources/scripts/session.js" defer></script>
</head>

<body>

    <?php
    include "header.php";
    ?>
    <div id="session-content">
        <div id="session-model">
            <div id="canvas-container">
                <canvas style="width :50vmin; height: 50vmin;"></canvas>

            </div>
            <div id="controls">
                <div id="front">Front</div>
                <div id="back">Back</div>

            </div>
            <button id="play">Play </button>
            <div class="slidecontainer">
                <input type="range" min="0" max="100" value="0" class="slider" id="myRange">
            </div>

        </div>
        <div id="model-interaction">
            <ul id="muscles">
                <li class="leftQuad rightQuad" style="display: none">
                    <div>
                        <div>Quads</div>
                        <ul class="exerciseList">
                            <li>Squat</li>
                            <li>Leg Press</li>
                            <li>Forward Press</li>
                            <li>Barbell Curtsy Lunge</li>
                        </ul>
                    </div>
                </li>
                <li class="leftHamstring rightHamstring" style="display: none">
                    <div>
                        <div>Hamstrings</div>
                        <ul class="exerciseList">
                            <li>Squat</li>
                            <li>Stiff Leg Deadlifts</li>
                            <li>Hamstring Curl</li>
                            <li>Staggered Deadlift</li>
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
