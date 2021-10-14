<?php
include "head.php";
include "authPHP.php";
?>
<title>Invite</title>

<link rel="stylesheet" href="./resources/styles/invite.css">
<link rel="stylesheet" href="./resources/styles/layout.css">
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

</head>

<body>

    <?php
    include "header.php";
    ?>
    <div id="invite-content">
        <?php
        if (isset($_SESSION['inviteLink'])) {
            echo "Here is the link to send to the client: <br><a href=\"{$_SESSION['inviteLink']}\">{$_SESSION['inviteLink']}</a>";
            
        }
        ?>
        <div id="qrcode"></div>
        <script type="text/javascript">
            var qrcode = new QRCode(document.getElementById("qrcode"), {
                text: <?php echo "\"{$_SESSION['inviteLink']}\""?>,
                colorDark: "#0297a2",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
        </script>
    </div>
    <?php
    include "footer.php";
    ?>

</body>